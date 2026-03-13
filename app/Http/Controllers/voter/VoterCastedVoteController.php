<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CastedVote;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VoterCastedVoteController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // PRIVATE HELPER — returns only the positions this voter
    // is allowed to vote on, based on their year level.
    //
    // Algorithm:
    //   Global positions (IDs 1–3)   → ALL voters
    //   College officers (IDs 4–11)  → ALL voters
    //   Representative (IDs 12–14)   → year-dependent:
    //       1st year → votes for 2nd Year Rep (ID 12)
    //       2nd year → votes for 3rd Year Rep (ID 13)
    //       3rd year → votes for 4th Year Rep (ID 14)
    //       4th year → NO representative ballot
    // ─────────────────────────────────────────────────────────────
    private function getVoterPositions(): \Illuminate\Support\Collection
    {
        $voter     = auth()->user();
        $voterYear = (int) $voter->year_level;

        $globalIds         = [1, 2, 3];
        $collegeOfficerIds = [4, 5, 6, 7, 8, 9, 10, 11];

        // Formula: voterYear + 11 maps to the correct rep position ID
        // 1st → 12 (2nd Year Rep), 2nd → 13 (3rd Year Rep), 3rd → 14 (4th Year Rep)
        // 4th year is excluded (>= 4 check)
        $repId = ($voterYear < 4) ? ($voterYear + 11) : null;

        $allowedIds = array_merge($globalIds, $collegeOfficerIds);
        if ($repId) {
            $allowedIds[] = $repId;
        }

        return Position::with([
            'candidates' => fn($q) => $q->with(['partylist', 'college'])->orderBy('last_name'),
        ])
        ->whereIn('id', $allowedIds)
        ->orderBy('sort_order')
        ->get();
    }

    // ─────────────────────────────────────────────────────────────
    // GET /voter/vote
    // Intro / welcome screen — clears any previous ballot session
    // ─────────────────────────────────────────────────────────────
    public function intro()
    {
        // Use filtered count so the intro shows the correct number
        $totalPositions = $this->getVoterPositions()->count();

        // If already voted, just show the "already voted" screen — no redirect
        if (auth()->user()->hasVoted()) {
            return view('voter.ballot.intro', compact('totalPositions'));
        }

        // Fresh start — wipe any leftover in-progress ballot
        session()->forget('ballot');

        return view('voter.ballot.intro', compact('totalPositions'));
    }

    // ─────────────────────────────────────────────────────────────
    // GET /voter/vote/step/{step}
    // One position per page. Step is 1-indexed.
    // ─────────────────────────────────────────────────────────────
    public function step(int $step)
    {
        if (auth()->user()->hasVoted()) {
            return redirect()->route('voter.dashboard')
                ->with('info', 'You have already submitted your vote.');
        }

        // ✅ Use filtered positions — voter only sees their allowed positions
        $positions = $this->getVoterPositions();

        // Guard: step out of range → redirect to intro
        if ($step < 1 || $step > $positions->count()) {
            return redirect()->route('voter.vote.intro');
        }

        // 0-indexed position for the collection
        $position     = $positions->get($step - 1);
        $totalSteps   = $positions->count();
        $ballot       = session('ballot', []); // [position_id => candidate_id]
        $selectedId   = $ballot[$position->id] ?? null;
        // Don't pass the 'skip' sentinel to the view
        if ($selectedId === 'skip') {
            $selectedId = null;
        }

        // Build a small steps map for the progress dots
        // Each item: ['step', 'name', 'status', 'position_id']
        $steps = $positions->map(function ($pos, $idx) use ($ballot, $step) {
            $status = 'pending';
            if (isset($ballot[$pos->id])) {
                $status = $ballot[$pos->id] === 'skip' ? 'skipped' : 'selected';
            } elseif ($idx + 1 < $step) {
                $status = 'skipped'; // passed without selecting
            } elseif ($idx + 1 === $step) {
                $status = 'current';
            }
            return [
                'step'        => $idx + 1,
                'name'        => $pos->name,
                'status'      => $status,
                'position_id' => $pos->id,
            ];
        });

        return view('voter.ballot.step', compact(
            'position',
            'step',
            'totalSteps',
            'steps',
            'selectedId',
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // POST /voter/vote/step/{step}
    // Save this step's selection (or skip) to session, advance.
    // ─────────────────────────────────────────────────────────────
    public function saveStep(Request $request, int $step)
    {
        if (auth()->user()->hasVoted()) {
            return redirect()->route('voter.dashboard')
                ->with('info', 'You have already submitted your vote.');
        }

        // ✅ Use filtered positions — must match step() ordering
        $positions  = $this->getVoterPositions();
        $totalSteps = $positions->count();

        if ($step < 1 || $step > $totalSteps) {
            return redirect()->route('voter.vote.intro');
        }

        $position = $positions->get($step - 1);
        $ballot   = session('ballot', []);

        $action = $request->input('action'); // 'select', 'skip', 'back'

        if ($action === 'back') {
            return $step > 1
                ? redirect()->route('voter.vote.step', $step - 1)
                : redirect()->route('voter.vote.intro');
        }

        if ($action === 'skip') {
            $ballot[$position->id] = 'skip';
        } elseif ($action === 'select') {
            $candidateId = (int) $request->input('candidate_id');

            // Validate: candidate must exist and belong to this position
            $valid = Candidate::where('candidate_id', $candidateId)
                ->where('position_id', $position->id)
                ->exists();

            if (! $valid) {
                return back()->withErrors(['candidate_id' => 'Invalid candidate selection.']);
            }

            $ballot[$position->id] = $candidateId;
        } else {
            // No action provided (shouldn't happen with proper form)
            return back()->withErrors(['candidate_id' => 'Please select a candidate or skip.']);
        }

        session(['ballot' => $ballot]);

        // Last step → go to review
        if ($step === $totalSteps) {
            return redirect()->route('voter.vote.review');
        }

        return redirect()->route('voter.vote.step', $step + 1);
    }

    // ─────────────────────────────────────────────────────────────
    // GET /voter/vote/review
    // Show full ballot summary before final submit
    // ─────────────────────────────────────────────────────────────
    public function review()
    {
        if (auth()->user()->hasVoted()) {
            return redirect()->route('voter.dashboard')
                ->with('info', 'You have already submitted your vote.');
        }

        $ballot = session('ballot', []);

        // Redirect to intro only if the voter hasn't touched the ballot at all
        if (empty($ballot)) {
            return redirect()->route('voter.vote.intro');
        }

        // ✅ Use filtered positions — review only shows voter's allowed positions
        $positions = $this->getVoterPositions();

        // Build review rows
        $reviewRows = $positions->map(function ($position) use ($ballot) {
            $value = $ballot[$position->id] ?? null;

            if (! $value || $value === 'skip') {
                return [
                    'position'  => $position,
                    'candidate' => null,
                    'skipped'   => true,
                ];
            }

            $candidate = $position->candidates->firstWhere('candidate_id', $value);

            return [
                'position'  => $position,
                'candidate' => $candidate,
                'skipped'   => false,
            ];
        });

        $totalSelected = $reviewRows->where('skipped', false)->count();
        $totalSkipped  = $reviewRows->where('skipped', true)->count();

        return view('voter.ballot.review', compact(
            'reviewRows',
            'totalSelected',
            'totalSkipped',
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // POST /voter/vote
    // Final submission — reads from session, persists to DB
    // ─────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $voter = auth()->user();

        if ($voter->hasVoted()) {
            return redirect()->route('voter.dashboard')
                ->with('error', 'You have already submitted your vote.');
        }

        $ballot = session('ballot', []);

        if (empty($ballot)) {
            return redirect()->route('voter.vote.intro')
                ->with('error', 'Your ballot was empty. Please start again.');
        }

        // Separate real votes from skips
        $votes = collect($ballot)
            ->filter(fn($v) => $v !== 'skip' && is_numeric($v))
            ->map(fn($v) => (int) $v);

        // Cross-validate real votes: each candidate must belong to the claimed position
        if ($votes->isNotEmpty()) {
            $candidateIds = $votes->values()->toArray();
            $validPairs   = Candidate::whereIn('candidate_id', $candidateIds)
                ->pluck('position_id', 'candidate_id');

            foreach ($votes as $positionId => $candidateId) {
                if (($validPairs[$candidateId] ?? null) !== (int) $positionId) {
                    session()->forget('ballot');
                    throw ValidationException::withMessages([
                        'votes' => "Invalid ballot detected. Please start over.",
                    ]);
                }
            }
        }

        $now       = now();
        $txn       = $this->generateTransactionNumber($voter->id);
        $ip        = $request->ip();
        $userAgent = $request->userAgent();

        // ✅ Only write rows for THIS voter's allowed positions (not all 14).
        // A 4th year voter will NOT get a representative row at all.
        $allPositionIds = $this->getVoterPositions()->pluck('id');

        DB::transaction(function () use ($voter, $votes, $ballot, $allPositionIds, $now, $txn, $ip, $userAgent) {
            foreach ($allPositionIds as $positionId) {
                $ballotVal   = $ballot[$positionId] ?? null;
                $candidateId = ($ballotVal && $ballotVal !== 'skip' && is_numeric($ballotVal))
                    ? (int) $ballotVal
                    : null;

                CastedVote::create([
                    'transaction_number' => $txn,
                    'voter_id'           => $voter->id,
                    'position_id'        => $positionId,
                    'candidate_id'       => $candidateId,           // null = skipped
                    'vote_hash'          => $this->generateVoteHash($voter->id, $positionId, $candidateId ?? 0),
                    'voted_at'           => $now,
                    'ip_address'         => $ip,
                    'user_agent'         => $userAgent,
                ]);
            }
        });

        // Clear ballot from session after successful submission
        session()->forget('ballot');

        return redirect()->route('voter.vote.success')
            ->with('txn', $txn)
            ->with('voted_count', $votes->count());
    }

    // ─────────────────────────────────────────────────────────────
    // GET /voter/vote/success
    // ─────────────────────────────────────────────────────────────
    public function success()
    {
        if (! session()->has('txn')) {
            return redirect()->route('voter.dashboard');
        }

        $txn        = session('txn');
        $votedCount = session('voted_count');

        return view('voter.ballot.success', compact('txn', 'votedCount'));
    }

    // ─────────────────────────────────────────────────────────────
    // GET /voter/vote/details
    // ─────────────────────────────────────────────────────────────
    public function details()
    {
        $voter = auth()->user();

        if (! $voter->hasVoted()) {
            return redirect()->route('voter.vote.intro');
        }

        // ✅ Use filtered positions so the receipt only shows
        // positions relevant to this voter's year level
        $allPositions = $this->getVoterPositions();

        $myVotes = $voter->votes()
            ->with(['candidate.partylist', 'candidate.college', 'position'])
            ->get();

        $votesByPosition = $myVotes->keyBy('position_id');

        $txn     = $myVotes->first()?->transaction_number ?? '—';
        $votedAt = $myVotes->first()?->voted_at ?? now();

        $totalVoted   = $myVotes->whereNotNull('candidate_id')->count();
        $totalSkipped = $allPositions->count() - $totalVoted;

        return view('voter.ballot.details', compact(
            'voter',
            'allPositions',
            'votesByPosition',
            'txn',
            'votedAt',
            'totalVoted',
            'totalSkipped',
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────

    private function generateTransactionNumber(int $voterId): string
    {
        return sprintf(
            'TXN-%d-%s-%s',
            $voterId,
            now()->format('Ymd'),
            strtoupper(substr(md5(uniqid('', true)), 0, 6))
        );
    }

    private function generateVoteHash(int $voterId, int $positionId, int $candidateId): string
    {
        return hash('sha256', implode('|', [
            $voterId,
            $positionId,
            $candidateId,
            now()->timestamp,
            config('app.key'),
        ]));
    }
}