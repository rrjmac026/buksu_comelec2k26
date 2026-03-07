<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::withCount('candidates')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:positions,name'],
        ]);

        Position::create($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position created successfully.');
    }

    public function show(Position $position)
    {
        $position->load(['candidates.partylist', 'candidates.college']);

        return view('admin.positions.show', compact('position'));
    }

    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('positions', 'name')->ignore($position->position_id, 'position_id')],
        ]);

        $position->update($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position updated successfully.');
    }

    public function destroy(Position $position)
    {
        if ($position->candidates()->exists()) {
            return redirect()->route('positions.index')
                ->with('error', 'Cannot delete position — it has associated candidates.');
        }

        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Position deleted successfully.');
    }
}