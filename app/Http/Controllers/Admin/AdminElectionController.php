<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElectionSetting;
use Illuminate\Http\Request;

class AdminElectionController extends Controller
{
    /**
     * GET /admin/election
     * Show the election control panel.
     */
    public function index()
    {
        $status       = ElectionSetting::status();
        $electionName = ElectionSetting::get('election_name', 'Student Council Election');

        return view('admin.election.index', compact('status', 'electionName'));
    }

    /**
     * POST /admin/election/status
     * Update the election status.
     * Body: { status: 'upcoming' | 'ongoing' | 'ended' }
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => ['required', 'in:upcoming,ongoing,ended'],
        ]);

        ElectionSetting::set('status', $request->status);

        $labels = [
            'upcoming' => 'Election set to Upcoming.',
            'ongoing'  => 'Election is now LIVE!',
            'ended'    => 'Election has been marked as Ended.',
        ];

        return back()->with('success', $labels[$request->status]);
    }

    /**
     * POST /admin/election/name
     * Update the election name shown publicly.
     */
    public function updateName(Request $request)
    {
        $request->validate([
            'election_name' => ['required', 'string', 'max:100'],
        ]);

        ElectionSetting::set('election_name', $request->election_name);

        return back()->with('success', 'Election name updated.');
    }
}