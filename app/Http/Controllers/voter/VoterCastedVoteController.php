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
    // GET /voter/vote
    // Show the ballot — one section per position with its candidates.
    // Redirects back to dashboard if the voter has already voted.
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
        ])->orderBy('name')->get();

        return view('voter.ballot', compact('positions'));
    }

    // ─────────────────────────────────────────────────────────────
    // POST /voter/vote
    // Store the ballot — one CastedVote row per position selected.
    // Expects: votes[position_id] = candidate_id
    // ─────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $voter = auth()->user();

        // Guard: already voted — prevents double-submit race conditions
        if ($voter->hasVoted()) {
            return redirect()
                ->route('voter.dashboard')
                ->with('error', 'You have already submitted your vote.');
        }

        // Basic shape validation — each value must be a real candidate_id
        $request->validate([
            'votes'   => ['required', 'array', 'min:1'],
            'votes.*' => ['required', 'integer', 'exists:candidates,candidate_id'],
        ]);

        $submittedVotes = $request->input('votes'); // [position_id => candidate_id]

        // ── Cross-validate: each candidate must actually belong to
        //    the position the voter claims they're voting for. ──────
        // Build a lookup of all valid (position_id → candidate_id) pairs
        // for the submitted candidate IDs in one query — avoids N+1.
        $candidateIds = array_values($submittedVotes);
        $validPairs   = Candidate::whereIn('candidate_id', $candidateIds)
            ->pluck('position_id', 'candidate_id'); // [candidate_id => position_id]

        $verifiedVotes = []; // [position_id => candidate_id] — only valid entries

        foreach ($submittedVotes as $positionId => $candidateId) {
            $positionId  = (int) $positionId;
            $candidateId = (int) $candidateId;

            // Reject if this candidate doesn't belong to the claimed position
            if (($validPairs[$candidateId] ?? null) !== $positionId) {
                // A legitimate voter should never hit this — it signals
                // a tampered request. Abort the entire submission.
                throw ValidationException::withMessages([
                    'votes' => "Invalid ballot: candidate #{$candidateId} does not belong to position #{$positionId}.",
                ]);
            }

            $verifiedVotes[$positionId] = $candidateId;
        }

        // Ensure at least one valid vote survived cross-validation
        if (empty($verifiedVotes)) {
            throw ValidationException::withMessages([
                'votes' => 'Your ballot contained no valid selections. Please try again.',
            ]);
        }

        // ── Persist inside a transaction so it's all-or-nothing ───
        $now       = now();
        $txn       = $this->generateTransactionNumber($voter->id);
        $ip        = $request->ip();
        $userAgent = $request->userAgent();

        DB::transaction(function () use ($voter, $verifiedVotes, $now, $txn, $ip, $userAgent) {
            foreach ($verifiedVotes as $positionId => $candidateId) {
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
            ->with('success', 'Your vote has been submitted! Transaction #: ' . $txn);
    }

    // ─────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────

    /**
     * Unique transaction number per ballot submission.
     * Format: TXN-{voter_id}-{YYYYMMDD}-{6 random hex chars}
     */
    private function generateTransactionNumber(int $voterId): string
    {
        return sprintf(
            'TXN-%d-%s-%s',
            $voterId,
            now()->format('Ymd'),
            strtoupper(substr(md5(uniqid('', true)), 0, 6))
        );
    }

    /**
     * Tamper-evident SHA-256 hash for one CastedVote row.
     * Ties together voter, position, candidate, timestamp, and app key.
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