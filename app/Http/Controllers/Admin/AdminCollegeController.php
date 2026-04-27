<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCollegeController extends Controller
{
    public function index()
    {
        $colleges = College::withCount(['voters', 'candidates'])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.colleges.index', compact('colleges'));
    }

    public function create()
    {
        return view('admin.colleges.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255', 'unique:colleges,name'],
            'acronym' => ['required', 'string', 'max:20', 'unique:colleges,acronym'],
        ]);

        College::create($validated);

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College created successfully.');
    }

    public function show(College $college)
    {
        $college->load(['voters', 'candidates.position', 'candidates.partylist']);

        return view('admin.colleges.show', compact('college'));
    }

    public function edit(College $college)
    {
        return view('admin.colleges.edit', compact('college'));
    }

    public function update(Request $request, College $college)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255', Rule::unique('colleges', 'name')->ignore($college->id)],   // PK is id ✅
            'acronym' => ['required', 'string', 'max:20',  Rule::unique('colleges', 'acronym')->ignore($college->id)], // PK is id ✅
        ]);

        $college->update($validated);

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College updated successfully.');
    }

    public function destroy(College $college)
    {
        if ($college->candidates()->exists() || $college->voters()->exists()) {
            return redirect()->route('admin.colleges.index')
                ->with('error', 'Cannot delete college — it has associated candidates or voters.');
        }

        $college->delete();

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College deleted successfully.');
    }
}