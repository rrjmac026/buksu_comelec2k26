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

        $topCandidates = Candidate::with(['position', 'partylist'])
            ->withCount('castedVotes')
            ->orderByDesc('casted_votes_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentVotes', 'topCandidates'));
    }
}