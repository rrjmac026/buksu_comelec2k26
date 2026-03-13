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

        // Pre-compute turnout for initial doughnut render (no flash of empty chart)
        $totalVoters = $stats['total_voters'];
        $votedCount  = $stats['total_votes'];
        $notVoted    = max(0, $totalVoters - $votedCount);
        $turnoutPct  = $totalVoters > 0
            ? round(($votedCount / $totalVoters) * 100, 1)
            : 0;

        return view('admin.dashboard', compact(
            'stats', 'recentVotes', 'topCandidates', 'teamMembers',
            'votedCount', 'notVoted', 'turnoutPct',
        ));
    }

    /**
     * Live polling endpoint — GET /admin/dashboard/live
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

        $votesByPosition = Position::withCount('votes')
            ->orderBy('name')
            ->get()
            ->map(fn($p) => [
                'label' => $p->name,
                'count' => $p->votes_count,
            ]);

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

        // ── Hourly vote activity for today ──────────────────────────────
        // Returns 24 buckets (hour 0–23) counting distinct voters per hour
        $hourlyRaw = CastedVote::query()
            ->selectRaw('HOUR(voted_at) AS hour, COUNT(DISTINCT voter_id) AS count')
            ->whereDate('voted_at', now()->toDateString())
            ->groupByRaw('HOUR(voted_at)')
            ->pluck('count', 'hour');

        $hourlyData = collect(range(0, 23))->map(fn($h) => (int) ($hourlyRaw[$h] ?? 0));

        // Rolling 12-hour window: last 12 completed hours up to current hour
        $currentHour = (int) now()->format('G');
        $windowStart = max(0, $currentHour - 11);
        $windowLabels = collect(range($windowStart, $currentHour))->map(function ($h) {
            $suffix = $h < 12 ? 'AM' : 'PM';
            $display = $h % 12 ?: 12;
            return $display . $suffix;
        });
        $windowData = collect(range($windowStart, $currentHour))->map(fn($h) => $hourlyData[$h]);

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
            'hourly'          => [
                'labels' => $windowLabels->values(),
                'data'   => $windowData->values(),
            ],
            'timestamp'       => now()->format('H:i:s'),
        ]);
    }
}