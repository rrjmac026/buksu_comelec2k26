<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CastedVote;
use App\Models\College;
use App\Models\Organization;
use App\Models\Partylist;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_voters'     => User::where('role', 'voter')->count(),
            'total_candidates' => Candidate::count(),
            'total_votes'      => CastedVote::distinct('voter_id')->count('voter_id'),
            'total_positions'  => Position::count(),
            'total_partylists' => Partylist::count(),
            'total_colleges'   => College::count(),
            'total_orgs'       => Organization::count(),
        ];

        $recentVotes = CastedVote::with(['voter', 'candidate', 'position'])
            ->latest('voted_at')
            ->take(10)
            ->get();

        // Fixed: was castedVotes() — correct relationship name is votes()
        $topCandidates = Candidate::with(['position', 'partylist'])
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentVotes', 'topCandidates'));
    }

    /**
     * Live polling endpoint — called every N seconds by the dashboard JS.
     * Route: GET /admin/dashboard/live  (name: admin.dashboard.live)
     */
    public function live(): JsonResponse
    {
        $stats = [
            'total_voters'     => User::where('role', 'voter')->count(),
            'total_candidates' => Candidate::count(),
            'total_votes'      => CastedVote::distinct('voter_id')->count('voter_id'),
            'total_positions'  => Position::count(),
            'total_partylists' => Partylist::count(),
            'total_colleges'   => College::count(),
            'total_orgs'       => Organization::count(),
        ];

        // Votes per position for bar chart
        $votesByPosition = Position::withCount('votes')
            ->orderBy('name')
            ->get()
            ->map(fn($p) => [
                'label' => $p->name,
                'count' => $p->votes_count,
            ]);

        // Top candidates
        $topCandidates = Candidate::with(['position', 'partylist'])
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->take(5)
            ->get()
            ->map(fn($c) => [
                'name'     => $c->first_name . ' ' . $c->last_name,
                'position' => $c->position?->name ?? '—',
                'partylist'=> $c->partylist?->name ?? '—',
                'votes'    => $c->votes_count,
            ]);

        // Recent votes
        $recentVotes = CastedVote::with(['voter', 'candidate', 'position'])
            ->latest('voted_at')
            ->take(8)
            ->get()
            ->map(fn($v) => [
                'voter'       => $v->voter?->name ?? 'Unknown',
                'candidate'   => $v->candidate ? ($v->candidate->first_name . ' ' . $v->candidate->last_name) : '—',
                'position'    => $v->position?->name ?? '—',
                'voted_at'    => $v->voted_at?->diffForHumans() ?? '—',
                'transaction' => $v->transaction_number ?? '—',
            ]);

        // Voter turnout: voted vs not voted
        $totalVoters  = User::where('role', 'voter')->count();
        $votedCount   = CastedVote::distinct('voter_id')->count('voter_id');
        $notVoted     = max(0, $totalVoters - $votedCount);

        return response()->json([
            'stats'            => $stats,
            'votesByPosition'  => $votesByPosition,
            'topCandidates'    => $topCandidates,
            'recentVotes'      => $recentVotes,
            'turnout'          => ['voted' => $votedCount, 'not_voted' => $notVoted],
            'timestamp'        => now()->format('H:i:s'),
        ]);
    }
}