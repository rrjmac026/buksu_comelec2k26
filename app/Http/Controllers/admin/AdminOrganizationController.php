<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminOrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::with('college')
            ->withCount('candidates')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        $colleges = College::orderBy('name')->get();

        return view('admin.organizations.create', compact('colleges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:organizations,name'],
            'description' => ['nullable', 'string'],
            'acronym'     => ['nullable', 'string', 'max:20'],
            'college_id'  => ['required', 'exists:colleges,id'],
        ]);

        Organization::create($validated);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    public function show(Organization $organization)
    {
        $organization->load(['college', 'candidates.position', 'candidates.partylist']);

        return view('admin.organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        $colleges = College::orderBy('name')->get();

        return view('admin.organizations.edit', compact('organization', 'colleges'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', Rule::unique('organizations', 'name')->ignore($organization->id)],
            'description' => ['nullable', 'string'],
            'acronym'     => ['nullable', 'string', 'max:20'],
            'college_id'  => ['required', 'exists:colleges,id'],
        ]);

        $organization->update($validated);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        if ($organization->candidates()->exists()) {
            return redirect()->route('admin.organizations.index')
                ->with('error', 'Cannot delete organization — it still has associated candidates.');
        }

        $organization->delete();

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }
}