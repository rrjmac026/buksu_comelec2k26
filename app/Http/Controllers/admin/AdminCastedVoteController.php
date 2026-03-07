<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CastedVote;
use App\Models\Position;
use Illuminate\Http\Request;

class AdminCastedVoteController extends Controller
{
    public function index(Request $request)
    {
        $query = CastedVote::with(['voter', 'candidate', 'position']);

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('voter', fn($q) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"))
                  ->orWhere('transaction_number', 'like', "%{$search}%");
            });
        }

        $votes     = $query->latest('voted_at')->paginate(20)->withQueryString();
        $positions = Position::orderBy('name')->get();

        return view('admin.votes.index', compact('votes', 'positions'));
    }

    public function results()
    {
        // Candidate::votes() is the hasMany to CastedVote
        $results = Position::with([
            'candidates' => fn($q) => $q->withCount('votes')->orderByDesc('votes_count'),
        ])->get();

        $totalVotersTurnout = CastedVote::distinct('voter_id')->count('voter_id');

        return view('admin.votes.results', compact('results', 'totalVotersTurnout'));
    }

    public function show(CastedVote $castedVote)
    {
        $castedVote->load(['voter', 'candidate.partylist', 'candidate.college', 'position']);

        return view('admin.votes.show', compact('castedVote'));
    }

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

    public function destroy(CastedVote $castedVote)
    {
        $castedVote->delete();

        return redirect()->route('admin.votes.index')
            ->with('success', 'Vote record deleted successfully.');
    }
}