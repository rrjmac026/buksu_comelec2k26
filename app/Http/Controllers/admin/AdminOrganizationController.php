<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::with('college')
            ->withCount('positions')
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
            'college_id'  => ['required', 'exists:colleges,college_id'],
        ]);

        Organization::create($validated);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    public function show(Organization $organization)
    {
        $organization->load(['college', 'positions.candidates']);

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
            'name'        => ['required', 'string', 'max:255', Rule::unique('organizations', 'name')->ignore($organization->organization_id, 'organization_id')],
            'description' => ['nullable', 'string'],
            'college_id'  => ['required', 'exists:colleges,college_id'],
        ]);

        $organization->update($validated);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        if ($organization->positions()->exists()) {
            return redirect()->route('organizations.index')
                ->with('error', 'Cannot delete organization — it has associated positions.');
        }

        $organization->delete();

        return redirect()->route('organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }
}