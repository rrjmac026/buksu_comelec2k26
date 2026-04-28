<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CastedVote;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VoterCastedVoteController extends Controller
{
    // ── Request-level cache to avoid repeated DB calls ────────────────────
    private ?Collection $cachedPositions = null;

    private function getVoterPositions(): Collection
    {
        if ($this->cachedPositions !== null) {
            return $this->cachedPositions;
        }

        $voter     = auth()->user();
        $voterYear = (int) $voter->year_level;

        $universalPositions = ['President', 'Vice President', 'Senator'];

        $collegePositions = [
            'Governor', 'Vice Governor', 'Secretary',
            'Associate Secretary', 'Treasurer', 'Associate Treasurer',
            'Auditor', 'Public Relation Officer',
        ];

        $repNames = [
            1 => 'Second Year Representative',
            2 => 'Third Year Representative',
            3 => 'Fourth Year Representative',
        ];

        $allowedNames = array_merge($universalPositions, $collegePositions);

        if (isset($repNames[$voterYear])) {
            $allowedNames[] = $repNames[$voterYear];
        }

        $universalPositionIds = Position::whereIn('name', $universalPositions)->pluck('id');

        $this->cachedPositions = Position::with([
            'candidates' => fn($q) => $q
                ->with(['partylist', 'college'])
                ->where(function ($q) use ($voter, $universalPositionIds) {
                    $q->whereIn('position_id', $universalPositionIds)
                      ->orWhere('college_id', $voter->college_id);
                })
                ->orderBy('last_name'),
        ])
        ->whereIn('name', $allowedNames)
        ->orderBy('sort_order')
        ->get();

        return $this->cachedPositions;
    }

    public function intro()
    {
        $totalPositions = $this->getVoterPositions()->count();

        if (auth()->user()->hasVoted()) {
            return view('voter.ballot.intro', compact('totalPositions'));
        }

        session()->forget('ballot');
        session()->forget(['current_step', 'highest_reached_step']);

        return view('voter.ballot.intro', compact('totalPositions'));
    }

    public function step(int $step)
    {
        if (auth()->user()->hasVoted()) {
            return redirect()->route('voter.dashboard')
                ->with('info', 'You have already submitted your vote.');
        }

        $positions = $this->getVoterPositions();
        $totalSteps = $positions->count();

        if ($step < 1 || $step > $totalSteps) {
            return redirect()->route('voter.vote.intro');
        }

        $highestReachedStep = (int) session('highest_reached_step', 1);
        $highestReachedStep = max(1, min($highestReachedStep, $totalSteps));

        if ($step > $highestReachedStep) {
            return redirect()->route('voter.vote.step', $highestReachedStep);
        }

        session([
            'current_step' => $step,
            'highest_reached_step' => max($highestReachedStep, $step),
        ]);
        $highestReachedStep = (int) session('highest_reached_step', 1);

        $position    = $positions->get($step - 1);
        $ballot      = session('ballot', []);
        $rawSelected = $ballot[$position->id] ?? null;

        if ($position->max_votes > 1) {
            $selectedId = is_array($rawSelected) ? $rawSelected : [];
        } else {
            $selectedId = ($rawSelected && $rawSelected !== 'skip') ? $rawSelected : null;
        }

        $steps = $positions->map(function ($pos, $idx) use ($ballot, $step, $highestReachedStep) {
            $stepNumber = $idx + 1;
            $status = 'pending';

            if ($stepNumber === $step) {
                $status = 'current';
            } elseif ($stepNumber <= $highestReachedStep) {
                if (!isset($ballot[$pos->id])) {
                    $status = 'past';
                } else {
                    $val = $ballot[$pos->id];
                    if ($val === 'skip') {
                    $status = 'skipped';
                    } elseif (is_array($val) && count($val) > 0) {
                    $status = 'selected';
                    } elseif (is_numeric($val)) {
                    $status = 'selected';
                    } else {
                    $status = 'past';
                    }
                }
            }

            return [
                'step'        => $stepNumber,
                'name'        => $pos->name,
                'status'      => $status,
                'position_id' => $pos->id,
            ];
        });

        $allSelectedIds = collect($ballot)
            ->flatten()
            ->filter(fn($v) => is_numeric($v))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values()
            ->all();

        $ballotCandidates = !empty($allSelectedIds)
            ? Candidate::with(['partylist'])
                ->whereIn('candidate_id', $allSelectedIds)
                ->get()
                ->keyBy('candidate_id')
            : collect();

        return view('voter.ballot.step', compact(
            'position',
            'step',
            'totalSteps',
            'steps',
            'selectedId',
            'ballotCandidates',
            'highestReachedStep',
        ));
    }

    public function saveStep(Request $request, int $step)
    {
        if (auth()->user()->hasVoted()) {
            return redirect()->route('voter.dashboard')
                ->with('info', 'You have already submitted your vote.');
        }

        $positions  = $this->getVoterPositions();
        $totalSteps = $positions->count();

        if ($step < 1 || $step > $totalSteps) {
            return redirect()->route('voter.vote.intro');
        }

        $position = $positions->get($step - 1);
        $ballot   = session('ballot', []);
        $action   = $request->input('action');
        $highestReachedStep = (int) session('highest_reached_step', 1);
        $highestReachedStep = max($highestReachedStep, $step);

        if ($action === 'back') {
            $targetStep = max(1, $step - 1);
            session([
                'current_step' => $targetStep,
                'highest_reached_step' => $highestReachedStep,
            ]);

            return $step > 1
                ? redirect()->route('voter.vote.step', $targetStep)
                : redirect()->route('voter.vote.intro');
        }

        if ($action === 'skip') {
            $ballot[$position->id] = 'skip';

        } elseif ($action === 'select') {

            $maxVotes = $position->max_votes ?? 1;

            if ($maxVotes > 1) {
                // ── Multi-vote (Senator) ──────────────────────────────
                $candidateIds = array_filter(
                    (array) $request->input('candidate_ids', []),
                    fn($v) => is_numeric($v)
                );
                $candidateIds = array_map('intval', array_values($candidateIds));

                if (!empty($candidateIds)) {
                    if (count($candidateIds) > $maxVotes) {
                        return back()->withErrors([
                            'candidate_id' => "You can only select up to {$maxVotes} candidates.",
                        ]);
                    }

                    $validCount = Candidate::whereIn('candidate_id', $candidateIds)
                        ->where('position_id', $position->id)
                        ->count();

                    if ($validCount !== count($candidateIds)) {
                        return back()->withErrors(['candidate_id' => 'Invalid candidate selection.']);
                    }
                }

                $ballot[$position->id] = !empty($candidateIds) ? $candidateIds : 'skip';

            } else {
                // ── Single-vote ───────────────────────────────────────
                $candidateId = (int) $request->input('candidate_id');

                $valid = Candidate::where('candidate_id', $candidateId)
                    ->where('position_id', $position->id)
                    ->exists();

                if (! $valid) {
                    return back()->withErrors(['candidate_id' => 'Invalid candidate selection.']);
                }

                $ballot[$position->id] = $candidateId;
            }

        } else {
            return back()->withErrors(['candidate_id' => 'Please select a candidate or skip.']);
        }

        session(['ballot' => $ballot]);

        // ── Remove in production ──────────────────────────────────────────
        \Log::info('saveStep debug', [
            'step'          => $step,
            'position_id'   => $position->id,
            'position_name' => $position->name,
            'action'        => $action,
            'ballot_value'  => $ballot[$position->id],
        ]);

        if ($step === $totalSteps) {
            session([
                'current_step' => $step,
                'highest_reached_step' => max($highestReachedStep, $step),
            ]);
            return redirect()->route('voter.vote.review');
        }

        $nextStep = $step + 1;
        session([
            'current_step' => $nextStep,
            'highest_reached_step' => max($highestReachedStep, $nextStep),
        ]);

        return redirect()->route('voter.vote.step', $nextStep);
    }

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

        $positions = $this->getVoterPositions();

        $reviewRows = $positions->map(function ($position) use ($ballot) {
            $value    = $ballot[$position->id] ?? null;
            $maxVotes = $position->max_votes ?? 1;

            if ($maxVotes > 1) {
                if (!$value || $value === 'skip' || (is_array($value) && empty($value))) {
                    return [
                        'position'   => $position,
                        'candidates' => [],
                        'skipped'    => true,
                        'is_multi'   => true,
                    ];
                }
                $candidateIds = is_array($value) ? $value : [$value];
                $candidates   = $position->candidates->whereIn('candidate_id', $candidateIds)->values();

                return [
                    'position'   => $position,
                    'candidates' => $candidates,
                    'skipped'    => false,
                    'is_multi'   => true,
                ];
            }

            if (!$value || $value === 'skip') {
                return [
                    'position'  => $position,
                    'candidate' => null,
                    'skipped'   => true,
                    'is_multi'  => false,
                ];
            }

            return [
                'position'  => $position,
                'candidate' => $position->candidates->firstWhere('candidate_id', $value),
                'skipped'   => false,
                'is_multi'  => false,
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

    public function store(Request $request)
    {
        $voter = auth()->user();

        $ballot = session('ballot', []);

        if (empty($ballot)) {
            return redirect()->route('voter.vote.intro')
                ->with('error', 'Your ballot was empty. Please start again.');
        }

        // Build flat vote pairs for cross-validation
        $votePairs = collect();
        foreach ($ballot as $positionId => $value) {
            if (!$value || $value === 'skip') continue;
            if (is_array($value)) {
                foreach ($value as $cid) {
                    $votePairs->push(['position_id' => (int) $positionId, 'candidate_id' => (int) $cid]);
                }
            } else {
                $votePairs->push(['position_id' => (int) $positionId, 'candidate_id' => (int) $value]);
            }
        }

        $now            = now();
        $txn            = $this->generateTransactionNumber($voter->id);
        $ip             = $request->ip();
        $userAgent      = $request->userAgent();
        $positions      = $this->getVoterPositions();
        $allPositionIds = $positions->pluck('id');

        try {
            DB::transaction(function () use (
                $voter, $ballot, $votePairs, $positions, $allPositionIds, $now, $txn, $ip, $userAgent
            ) {
                // ── FIX 1: hasVoted re-check INSIDE transaction with row lock ──
                // Prevents race condition from double-submit / simultaneous requests
                if (CastedVote::where('voter_id', $voter->id)->lockForUpdate()->exists()) {
                    throw new \Exception('You have already submitted your vote.');
                }

                // ── FIX 2: Cross-validation INSIDE transaction ─────────────────
                // Ensures candidate-position integrity at the moment of insert
                if ($votePairs->isNotEmpty()) {
                    $candidateIds = $votePairs->pluck('candidate_id')->toArray();
                    $validPairs   = Candidate::whereIn('candidate_id', $candidateIds)
                        ->pluck('position_id', 'candidate_id');

                    foreach ($votePairs as $pair) {
                        if (($validPairs[$pair['candidate_id']] ?? null) !== $pair['position_id']) {
                            throw new \Exception('Invalid ballot detected. Please start over.');
                        }
                    }
                }

                // ── FIX 3: Re-validate senator max_votes inside store() ────────
                // Prevents a tampered session from smuggling in extra senator votes
                foreach ($positions as $position) {
                    $ballotVal = $ballot[$position->id] ?? null;
                    if (is_array($ballotVal) && !empty($ballotVal)) {
                        $maxVotes = $position->max_votes ?? 1;
                        if (count($ballotVal) > $maxVotes) {
                            throw new \Exception(
                                "Exceeded maximum allowed votes for {$position->name}."
                            );
                        }
                    }
                }

                // ── Insert all ballot rows ─────────────────────────────────────
                foreach ($allPositionIds as $positionId) {
                    $ballotVal = $ballot[$positionId] ?? null;

                    if (is_array($ballotVal) && !empty($ballotVal)) {
                        // Multi-vote: one DB row per selected candidate
                        foreach ($ballotVal as $candidateId) {
                            CastedVote::create([
                                'transaction_number' => $txn,
                                'voter_id'           => $voter->id,
                                'position_id'        => $positionId,
                                'candidate_id'       => (int) $candidateId,
                                'vote_hash'          => $this->generateVoteHash($voter->id, $positionId, (int) $candidateId),
                                'voted_at'           => $now,
                                'ip_address'         => $ip,
                                'user_agent'         => $userAgent,
                            ]);
                        }
                    } else {
                        // Single-vote or skipped (abstain)
                        $candidateId = ($ballotVal && $ballotVal !== 'skip' && is_numeric($ballotVal))
                            ? (int) $ballotVal
                            : null;

                        CastedVote::create([
                            'transaction_number' => $txn,
                            'voter_id'           => $voter->id,
                            'position_id'        => $positionId,
                            'candidate_id'       => $candidateId,
                            'vote_hash'          => $this->generateVoteHash($voter->id, $positionId, $candidateId ?? 0),
                            'voted_at'           => $now,
                            'ip_address'         => $ip,
                            'user_agent'         => $userAgent,
                        ]);
                    }
                }
            });

        } catch (\Exception $e) {
            // ── FIX 4: Always clear ballot session on any failure ─────────
            session()->forget('ballot');

            return redirect()->route('voter.vote.intro')
                ->with('error', $e->getMessage());
        }

        session()->forget('ballot');

        return redirect()->route('voter.vote.success')
            ->with('txn', $txn)
            ->with('voted_count', $votePairs->count());
    }

    public function success()
    {
        if (! session()->has('txn')) {
            return redirect()->route('voter.dashboard');
        }

        return view('voter.ballot.success', [
            'txn'        => session('txn'),
            'votedCount' => session('voted_count'),
        ]);
    }

    public function details()
    {
        $voter = auth()->user();

        if (! $voter->hasVoted()) {
            return redirect()->route('voter.vote.intro');
        }

        $allPositions = $this->getVoterPositions();

        $myVotes = $voter->votes()
            ->with(['candidate.partylist', 'candidate.college', 'position'])
            ->get();

        $votesByPosition = $myVotes->groupBy('position_id');

        $txn     = $myVotes->first()?->transaction_number ?? '—';
        $votedAt = $myVotes->first()?->voted_at ?? now();

        $totalVoted   = $myVotes->whereNotNull('candidate_id')->count();
        $totalSkipped = $allPositions->count() - $myVotes->pluck('position_id')->unique()->count();

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