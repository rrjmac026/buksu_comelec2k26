<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CastedVote;
use App\Models\Position;
use Illuminate\Http\Request;

class CastedVoteController extends Controller
{
    /**
     * Display all casted votes with filtering options.
     */
    public function index(Request $request)
    {
        $query = CastedVote::with(['voter', 'candidate', 'position']);

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('voter', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
                ->orWhere('transaction_number', 'like', "%{$search}%");
        }

        $votes     = $query->latest('voted_at')->paginate(20)->withQueryString();
        $positions = Position::orderBy('name')->get();

        return view('admin.votes.index', compact('votes', 'positions'));
    }

    /**
     * Display vote tallies grouped by position and candidate.
     */
    public function results()
    {
        $results = Position::with([
            'candidates' => fn($q) => $q->withCount('castedVotes')->orderByDesc('casted_votes_count'),
        ])->get();

        $totalVotersTurnout = CastedVote::distinct('voter_id')->count('voter_id');

        return view('admin.votes.results', compact('results', 'totalVotersTurnout'));
    }

    /**
     * Show a single vote's details.
     */
    public function show(CastedVote $castedVote)
    {
        $castedVote->load(['voter', 'candidate.partylist', 'candidate.college', 'position']);

        return view('admin.votes.show', compact('castedVote'));
    }

    /**
     * Admins cannot create votes manually — votes are cast by voters only.
     * This method is intentionally disabled.
     */
    public function create()
    {
        abort(403, 'Votes can only be cast by registered voters.');
    }

    public function store(Request $request)
    {
        abort(403, 'Votes can only be cast by registered voters.');
    }

    public function edit(CastedVote $castedVote)
    {
        abort(403, 'Votes cannot be edited to preserve election integrity.');
    }

    public function update(Request $request, CastedVote $castedVote)
    {
        abort(403, 'Votes cannot be edited to preserve election integrity.');
    }

    /**
     * Delete a specific vote (e.g. to handle duplicate/fraud cases).
     */
    public function destroy(CastedVote $castedVote)
    {
        $castedVote->delete();

        return redirect()->route('admin.votes.index')
            ->with('success', 'Vote record deleted successfully.');
    }
}