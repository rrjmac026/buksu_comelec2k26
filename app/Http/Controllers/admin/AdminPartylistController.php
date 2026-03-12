<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partylist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPartylistController extends Controller
{
    public function index()
    {
        $partylists = Partylist::withCount('candidates')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.partylists.index', compact('partylists'));
    }

    public function create()
    {
        return view('admin.partylists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:partylists,name'],
            'description' => ['nullable', 'string'],
        ]);

        Partylist::create($validated);

        return redirect()->route('admin.partylists.index')
            ->with('success', 'Partylist created successfully.');
    }

    public function show(Partylist $partylist)
    {
        $partylist->load(['candidates.position', 'candidates.college']);

        return view('admin.partylists.show', compact('partylist'));
    }

    public function edit(Partylist $partylist)
    {
        return view('admin.partylists.edit', compact('partylist'));
    }

    public function update(Request $request, Partylist $partylist)
    {
        $validated = $request->validate([
            // PK is id ✅ — was wrongly using partylist_id
            'name'        => ['required', 'string', 'max:255', Rule::unique('partylists', 'name')->ignore($partylist->id)],
            'description' => ['nullable', 'string'],
        ]);

        $partylist->update($validated);

        return redirect()->route('admin.partylists.index')
            ->with('success', 'Partylist updated successfully.');
    }

    public function destroy(Partylist $partylist)
    {
        if ($partylist->candidates()->exists()) {
            return redirect()->route('admin.partylists.index')
                ->with('error', 'Cannot delete partylist — it has associated candidates.');
        }

        $partylist->delete();

        return redirect()->route('admin.partylists.index')
            ->with('success', 'Partylist deleted successfully.');
    }
}