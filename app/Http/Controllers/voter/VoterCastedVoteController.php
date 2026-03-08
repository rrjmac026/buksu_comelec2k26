<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CastedVote;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoterCastedVoteController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // GET /voter/vote
    // Show the ballot — one section per position with its candidates
    // Redirects back to dashboard if voter already voted
    // ─────────────────────────────────────────────────────────────
    public function create()
    {
        $voter = auth()->user();

        if ($voter->hasVoted()) {
            return redirect()
                ->route('voter.dashboard')
                ->with('info', 'You have already submitted your vote.');
        }

        $positions = Position::with([
            'candidates' => function ($q) {
                $q->with(['partylist', 'college', 'organization'])
                  ->orderBy('last_name');
            },
        ])->get();

        return view('voter.ballot', compact('positions'));
    }

    // ─────────────────────────────────────────────────────────────
    // POST /voter/vote
    // Store the ballot — one CastedVote row per position selected
    // Expects: votes[position_id] = candidate_id
    // ─────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $voter = auth()->user();

        // Guard: already voted
        if ($voter->hasVoted()) {
            return redirect()
                ->route('voter.dashboard')
                ->with('error', 'You have already submitted your vote.');
        }

        // Validate — each value must be a real candidate_id
        $request->validate([
            'votes'   => ['required', 'array', 'min:1'],
            'votes.*' => ['required', 'integer', 'exists:candidates,candidate_id'],
        ]);

        $votes     = $request->input('votes'); // [position_id => candidate_id]
        $now       = now();
        $txn       = $this->generateTransactionNumber($voter->id);
        $ip        = $request->ip();
        $userAgent = $request->userAgent();

        DB::transaction(function () use ($voter, $votes, $now, $txn, $ip, $userAgent) {
            foreach ($votes as $positionId => $candidateId) {
                // Confirm the candidate actually belongs to that position
                $valid = Candidate::where('candidate_id', $candidateId)
                    ->where('position_id', $positionId)
                    ->exists();

                if (!$valid) {
                    continue; // skip mismatched entries silently
                }

                CastedVote::create([
                    'transaction_number' => $txn,
                    'voter_id'           => $voter->id,
                    'position_id'        => $positionId,
                    'candidate_id'       => $candidateId,
                    'vote_hash'          => $this->generateVoteHash(
                                               $voter->id, $positionId, $candidateId
                                           ),
                    'voted_at'           => $now,
                    'ip_address'         => $ip,
                    'user_agent'         => $userAgent,
                ]);
            }
        });

        return redirect()
            ->route('voter.dashboard')
            ->with('success', 'Your vote has been submitted! Transaction # ' . $txn);
    }

    // ─────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────

    /**
     * Unique transaction number per ballot submission.
     * Format: TXN-{voter_id}-{YYYYMMDD}-{6 random chars}
     */
    private function generateTransactionNumber(int $voterId): string
    {
        return sprintf(
            'TXN-%d-%s-%s',
            $voterId,
            now()->format('Ymd'),
            strtoupper(substr(md5(uniqid()), 0, 6))
        );
    }

    /**
     * Tamper-evident SHA-256 hash for one CastedVote row.
     */
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