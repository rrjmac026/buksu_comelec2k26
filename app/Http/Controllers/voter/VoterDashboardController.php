<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CastedVote;
use App\Models\Position;
use App\Models\User;

class VoterDashboardController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // GET /voter/dashboard
    // ─────────────────────────────────────────────────────────────
    public function index()
    {
        $voter = auth()->user()->load('college');

        // Election-wide stats
        $totalCandidates = Candidate::count();
        $totalPositions  = Position::count();
        $totalVoters     = User::where('role', 'voter')->count();
        $totalVotesCast  = CastedVote::distinct('voter_id')->count('voter_id');
        $turnoutPct      = $totalVoters > 0
            ? round(($totalVotesCast / $totalVoters) * 100, 1)
            : 0;

        // This voter's own data
        $hasVoted     = $voter->hasVoted();
        $myVotesCount = $voter->votes()->count();

        $myVotes = $voter->votes()
            ->with(['candidate.position', 'candidate.partylist', 'position'])
            ->latest('voted_at')
            ->get();

        // Top candidates leaderboard
        $topCandidates = Candidate::withCount('votes')
            ->with(['position', 'partylist'])
            ->orderByDesc('votes_count')
            ->limit(6)
            ->get();

        // All positions with ranked candidates
        $positions = Position::with([
            'candidates' => function ($q) {
                $q->withCount('votes')->orderByDesc('votes_count');
            },
        ])->get();

        // Election end time
        $electionEnd = \Carbon\Carbon::parse(
            config('election.end_date', now()->endOfDay())
        );

        return view('voter.dashboard', compact(
            'voter',
            'totalCandidates',
            'totalPositions',
            'totalVoters',
            'totalVotesCast',
            'turnoutPct',
            'hasVoted',
            'myVotesCount',
            'myVotes',
            'topCandidates',
            'positions',
            'electionEnd',
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // GET /voter/results
    // ─────────────────────────────────────────────────────────────
    public function results()
    {
        $positions = Position::with([
            'candidates' => function ($q) {
                $q->withCount('votes')
                  ->with(['partylist', 'college'])
                  ->orderByDesc('votes_count');
            },
        ])->get();

        $totalVoters    = User::where('role', 'voter')->count();
        $totalVotesCast = CastedVote::distinct('voter_id')->count('voter_id');
        $turnoutPct     = $totalVoters > 0
            ? round(($totalVotesCast / $totalVoters) * 100, 1)
            : 0;

        return view('voter.results', compact(
            'positions',
            'totalVoters',
            'totalVotesCast',
            'turnoutPct',
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // GET /voter/results/live  (AJAX — for real-time polling)
    // ─────────────────────────────────────────────────────────────
    public function liveResults()
    {
        $totalVoters    = User::where('role', 'voter')->count();
        $totalVotesCast = CastedVote::distinct('voter_id')->count('voter_id');
        $turnoutPct     = $totalVoters > 0
            ? round(($totalVotesCast / $totalVoters) * 100, 1)
            : 0;

        $votesByPosition = Position::withCount('votes')
            ->get()
            ->map(fn($p) => [
                'label' => $p->name,
                'count' => $p->votes_count,
            ]);

        $topCandidates = Candidate::withCount('votes')
            ->with(['position', 'partylist'])
            ->orderByDesc('votes_count')
            ->limit(10)
            ->get()
            ->map(fn($c) => [
                'name'      => $c->full_name,
                'votes'     => $c->votes_count,
                'position'  => $c->position?->name ?? '—',
                'partylist' => $c->partylist?->name ?? '—',
            ]);

        return response()->json([
            'turnout' => [
                'voted'     => $totalVotesCast,
                'not_voted' => max(0, $totalVoters - $totalVotesCast),
                'pct'       => $turnoutPct,
            ],
            'votesByPosition' => $votesByPosition,
            'topCandidates'   => $topCandidates,
            'totalVoters'     => $totalVoters,
            'totalVotesCast'  => $totalVotesCast,
            'timestamp'       => now()->format('h:i:s A'),
        ]);
    }
}