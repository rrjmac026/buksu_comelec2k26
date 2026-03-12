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
    // Intro / welcome screen — clears any previous ballot session
    // ─────────────────────────────────────────────────────────────
    public function intro()
    {
        if (auth()->user()->hasVoted()) {
            return redirect()->route('voter.dashboard')
                ->with('info', 'You have already submitted your vote.');
        }

        // Fresh start — wipe any leftover in-progress ballot
        session()->forget('ballot');

        $totalPositions = Position::count();

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

        $positions = Position::with([
            'candidates' => fn($q) => $q->with(['partylist', 'college'])->orderBy('last_name'),
        ])->orderBy('sort_order')->get();

        // Guard: step out of range → redirect to intro
        if ($step < 1 || $step > $positions->count()) {
            return redirect()->route('voter.vote.intro');
        }

        // 0-indexed position for the collection
        $position     = $positions->get($step - 1);
        $totalSteps   = $positions->count();
        $ballot       = session('ballot', []); // [position_id => candidate_id]
        $selectedId   = $ballot[$position->id] ?? null;

        // Build a small steps map for the progress dots
        // Each item: ['position' => name, 'status' => 'pending|selected|skipped']
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
                'step'     => $idx + 1,
                'name'     => $pos->name,
                'status'   => $status,
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

        $positions  = Position::orderBy('name')->get();
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

        if (empty($ballot)) {
            return redirect()->route('voter.vote.intro');
        }

        $positions = Position::with([
            'candidates' => fn($q) => $q->with(['partylist', 'college'])->orderBy('last_name'),
        ])->orderBy('sort_order')->get();

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

        // Filter out skips — only real selections
        $votes = collect($ballot)
            ->filter(fn($v) => $v !== 'skip' && is_numeric($v))
            ->map(fn($v) => (int) $v);

        if ($votes->isEmpty()) {
            return redirect()->route('voter.vote.review')
                ->with('error', 'You skipped all positions. Please select at least one candidate.');
        }

        // Cross-validate: each candidate must belong to the claimed position
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

        $now       = now();
        $txn       = $this->generateTransactionNumber($voter->id);
        $ip        = $request->ip();
        $userAgent = $request->userAgent();

        DB::transaction(function () use ($voter, $votes, $now, $txn, $ip, $userAgent) {
            foreach ($votes as $positionId => $candidateId) {
                CastedVote::create([
                    'transaction_number' => $txn,
                    'voter_id'           => $voter->id,
                    'position_id'        => $positionId,
                    'candidate_id'       => $candidateId,
                    'vote_hash'          => $this->generateVoteHash($voter->id, $positionId, $candidateId),
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
    // Confirmation page shown after successful submission
    // ─────────────────────────────────────────────────────────────
    public function success()
    {
        // Must come from a flash — otherwise redirect away
        if (! session()->has('txn')) {
            return redirect()->route('voter.dashboard');
        }

        $txn        = session('txn');
        $votedCount = session('voted_count');

        return view('voter.ballot.success', compact('txn', 'votedCount'));
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