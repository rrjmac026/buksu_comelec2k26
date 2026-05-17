<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CastedVote;
use App\Models\Position;
use App\Services\Reports\ReportDataService;
use Illuminate\Http\Request;

class AdminCastedVoteController extends Controller
{
    /**
     * GET /admin/votes
     *
     * Show one row per ballot (transaction_number), not one row per position.
     * Uses a subquery to grab the representative row per transaction, then
     * paginates the result as an Eloquent collection.
     */
    public function index(Request $request)
    {
        // ── Build the base query ──────────────────────────────────────────
        // We want one row per transaction_number (i.e. one row per voter
        // ballot). We use selectRaw to pick the earliest casted_vote_id for
        // each transaction so we can still load the voter relationship, and
        // count how many positions were recorded in that ballot.
        $query = CastedVote::query()
            ->selectRaw('
                MIN(casted_vote_id)    AS casted_vote_id,
                transaction_number,
                voter_id,
                MIN(voted_at)          AS voted_at,
                COUNT(*)               AS positions_count,
                SUM(CASE WHEN candidate_id IS NOT NULL THEN 1 ELSE 0 END) AS positions_voted
            ')
            ->groupBy('transaction_number', 'voter_id');

        // ── Search filter ─────────────────────────────────────────────────
        if ($request->filled('search')) {
            $search = $request->search;

            // We need to match against voter name/email (via a subquery)
            // OR against the transaction_number column.
            $voterIds = \App\Models\User::where('role', 'voter')
                ->where(fn($q) =>
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                      ->orWhere('email', 'like', "%{$search}%")
                )
                ->pluck('id');

            $query->where(fn($q) =>
                $q->whereIn('voter_id', $voterIds)
                  ->orWhere('transaction_number', 'like', "%{$search}%")
            );
        }

        // ── Paginate, then hydrate voter relationship ─────────────────────
        // paginate() works on aggregate queries; we just can't use ->with()
        // directly, so we eager-load after pagination.
        $transactions = $query
            ->orderByDesc('voted_at')
            ->paginate(20)
            ->withQueryString();

        // Hydrate voter relationship manually (avoids N+1)
        $voterIds = $transactions->pluck('voter_id')->unique()->filter();
        $voters   = \App\Models\User::whereIn('id', $voterIds)->get()->keyBy('id');

        $transactions->each(function ($row) use ($voters) {
            $row->voter = $voters->get($row->voter_id);
        });

        return view('admin.votes.index', compact('transactions'));
    }

    /**
     * GET /admin/votes/results
     */
    public function results(ReportDataService $reportData)
    {
        $results = Position::with([
            'candidates' => fn($q) => $q
                ->selectRaw('candidates.*, (
                    SELECT COUNT(*) FROM casted_votes cv
                    WHERE cv.candidate_id = candidates.candidate_id
                    AND cv.position_id = candidates.position_id
                ) AS vote_count')
                ->with(['partylist', 'college'])
                ->orderByDesc('vote_count'),
        ])->orderBy('sort_order')->get();

        // SSC position IDs (President, VP, Senator) — all voters can vote
        $sscPositionIds = \App\Models\Position::whereIn('name', ['President', 'Vice President', 'Senator'])
            ->pluck('id')->toArray();

        // Overall turnout (denominator for SSC positions)
        $overallVoted = CastedVote::distinct('voter_id')->count('voter_id');

        // Cache college turnout so we don't query repeatedly
        $collegeTurnoutCache = [];

        foreach ($results as $position) {
            $isYearRep     = array_key_exists($position->name, $reportData->yrLevelMap);
            $isSscPosition = in_array($position->id, $sscPositionIds);

            if ($isYearRep) {
                // Year-rep: denominator = voters of that year level in that college
                $yearLevel = $reportData->yrLevelMap[$position->name];

                foreach ($position->candidates->groupBy('college_id') as $collegeId => $candidates) {
                    [, $yrVoted] = $reportData->yrLevelTurnout($collegeId, $yearLevel);

                    $yrVoterIds = \App\Models\User::where('role', 'voter')
                        ->whereRaw('LOWER(status) = ?', ['active'])
                        ->where('college_id', $collegeId)
                        ->where('year_level', $yearLevel)
                        ->pluck('id');

                    foreach ($candidates as $candidate) {
                        $candidate->yr_vote_count  = \App\Models\CastedVote::where('candidate_id', $candidate->candidate_id)
                            ->whereIn('voter_id', $yrVoterIds)
                            ->count();
                        $candidate->yr_denominator = $yrVoted;
                    }
                }
            } elseif ($isSscPosition) {
                // SSC: denominator = total voters who voted overall
                foreach ($position->candidates as $candidate) {
                    $candidate->sbo_denominator = $overallVoted;
                }
            } else {
                // SBO (Governor, Secretary, etc.): denominator = college voters who voted
                foreach ($position->candidates as $candidate) {
                    $collegeId = $candidate->college_id;

                    if (!isset($collegeTurnoutCache[$collegeId])) {
                        [, $collegeTurnoutCache[$collegeId]] = $reportData->collegeTurnout($collegeId);
                    }

                    $candidate->sbo_denominator = $collegeTurnoutCache[$collegeId];
                }
            }
        }

        $totalVotersTurnout = $overallVoted;

        return view('admin.votes.results', compact('results', 'totalVotersTurnout'));
    }

    /**
     * GET /admin/votes/{castedVote}
     * Show a single vote record (the "show" page is per-row, which is fine
     * for the detail drill-down — we keep it as-is).
     */
    public function show(CastedVote $castedVote)
    {
        $castedVote->load(['voter', 'candidate.partylist', 'candidate.college', 'position']);

        return view('admin.votes.show', compact('castedVote'));
    }

    /**
     * DELETE /admin/votes/transaction/{transaction}
     *
     * Deletes ALL casted_vote rows that share the same transaction_number.
     * This effectively deletes the voter's entire ballot at once.
     */
    public function destroyTransaction(string $transaction)
    {
        CastedVote::where('transaction_number', $transaction)->delete();

        return redirect()->route('admin.votes.index')
            ->with('success', 'Ballot deleted successfully.');
    }

    /**
     * DELETE /admin/votes/{castedVote}
     * Keep individual row deletion for the show page.
     */
    public function destroy(CastedVote $castedVote)
    {
        $castedVote->delete();

        return redirect()->route('admin.votes.index')
            ->with('success', 'Vote record deleted successfully.');
    }

    // ── Blocked actions ───────────────────────────────────────────────────

    public function create()  { abort(403, 'Votes can only be cast by registered voters.'); }
    public function store(Request $request) { abort(403, 'Votes can only be cast by registered voters.'); }
    public function edit(CastedVote $castedVote) { abort(403, 'Votes cannot be edited to preserve election integrity.'); }
    public function update(Request $request, CastedVote $castedVote) { abort(403, 'Votes cannot be edited to preserve election integrity.'); }
}