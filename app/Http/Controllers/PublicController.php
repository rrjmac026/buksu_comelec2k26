<?php

namespace App\Http\Controllers;

use App\Models\CastedVote;
use App\Models\ElectionSetting;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class PublicController extends Controller
{
    /**
     * GET /public/stats  (unauthenticated, called by welcome page JS)
     * Returns live votes cast count + election status.
     */
    public function stats(): JsonResponse
    {
        $votesCast = CastedVote::distinct('voter_id')->count('voter_id');
        $totalVoters = User::where('role', 'voter')->count();
        $status    = ElectionSetting::status();

        $electionStart = ElectionSetting::get('election_start', '');

        return response()->json([
            'votes_cast'     => $votesCast,
            'total_voters'   => $totalVoters,
            'status'         => $status,
            'status_label'   => ElectionSetting::statusLabel(),
            'election_name'  => ElectionSetting::get('election_name', 'Student Government Election'),
            'election_start' => $electionStart ? date('c', strtotime($electionStart)) : null,
        ]);
    }
}