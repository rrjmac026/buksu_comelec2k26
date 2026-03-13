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

        // ✅ FIX — one row per voter ballot, not one row per position
        $recentVotes = CastedVote::query()
            ->selectRaw('
                MIN(casted_vote_id)  AS casted_vote_id,
                transaction_number,
                voter_id,
                MIN(voted_at)        AS voted_at,
                COUNT(*)             AS positions_count,
                SUM(CASE WHEN candidate_id IS NOT NULL THEN 1 ELSE 0 END) AS positions_voted
            ')
            ->groupBy('transaction_number', 'voter_id')
            ->orderByDesc('voted_at')
            ->take(10)
            ->get();

        // Eager-load voters manually (can't use ->with() on aggregate queries)
        $voterIds = $recentVotes->pluck('voter_id')->unique()->filter();
        $voters   = User::whereIn('id', $voterIds)->get()->keyBy('id');
        $recentVotes->each(fn($row) => $row->voter = $voters->get($row->voter_id));

        $topCandidates = Candidate::with(['position', 'partylist'])
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->take(5)
            ->get();

        $teamMembers = User::where('role', 'admin')
                       ->orderBy('first_name')
                       ->get();

        return view('admin.dashboard', compact('stats', 'recentVotes', 'topCandidates', 'teamMembers'));
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
                'name'      => $c->first_name . ' ' . $c->last_name,
                'position'  => $c->position?->name ?? '—',
                'partylist' => $c->partylist?->name ?? '—',
                'votes'     => $c->votes_count,
            ]);

        // ✅ FIX — one row per voter ballot, not one row per position
        $recentRaw = CastedVote::query()
            ->selectRaw('
                MIN(casted_vote_id)  AS casted_vote_id,
                transaction_number,
                voter_id,
                MIN(voted_at)        AS voted_at,
                COUNT(*)             AS positions_count,
                SUM(CASE WHEN candidate_id IS NOT NULL THEN 1 ELSE 0 END) AS positions_voted
            ')
            ->groupBy('transaction_number', 'voter_id')
            ->orderByDesc('voted_at')
            ->take(8)
            ->get();

        $voterIds2 = $recentRaw->pluck('voter_id')->unique()->filter();
        $voters2   = User::whereIn('id', $voterIds2)->get()->keyBy('id');

        $recentVotes = $recentRaw->map(function ($v) use ($voters2) {
            $voter = $voters2->get($v->voter_id);
            return [
                'voter'           => $voter ? ($voter->first_name . ' ' . $voter->last_name) : 'Unknown',
                'positions_voted' => (int) $v->positions_voted,
                'positions_count' => (int) $v->positions_count,
                'voted_at'        => $v->voted_at
                                        ? \Carbon\Carbon::parse($v->voted_at)->diffForHumans()
                                        : '—',
                'transaction'     => $v->transaction_number ?? '—',
            ];
        });

        // Monthly trend
        $monthlyTrend = collect(range(1, 12))->map(function ($month) {
            return [
                'month'  => date('M', mktime(0, 0, 0, $month, 1)),
                'voters' => User::where('role', 'voter')
                                ->whereMonth('created_at', $month)
                                ->whereYear('created_at', now()->year)
                                ->count(),
                'votes'  => CastedVote::whereMonth('voted_at', $month)
                                ->whereYear('voted_at', now()->year)
                                ->count(),
            ];
        });

        // Voter turnout
        $totalVoters = User::where('role', 'voter')->count();
        $votedCount  = CastedVote::distinct('voter_id')->count('voter_id');
        $notVoted    = max(0, $totalVoters - $votedCount);

        return response()->json([
            'stats'           => $stats,
            'votesByPosition' => $votesByPosition,
            'topCandidates'   => $topCandidates,
            'recentVotes'     => $recentVotes,
            'turnout'         => ['voted' => $votedCount, 'not_voted' => $notVoted],
            'monthlyTrend'    => $monthlyTrend,
            'timestamp'       => now()->format('H:i:s'),
        ]);
    }
}