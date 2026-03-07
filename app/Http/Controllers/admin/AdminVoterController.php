<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminVoterController extends Controller
{
    /**
     * List all voter accounts.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'voter')->with('college');

        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) =>
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%")
            );
        }

        $voters   = $query->latest()->paginate(20)->withQueryString();
        $colleges = College::orderBy('name')->get();

        return view('admin.voters.index', compact('voters', 'colleges'));
    }

    /**
     * Show form to manually create a voter account.
     */
    public function create()
    {
        $colleges = College::orderBy('name')->get();

        return view('admin.voters.create', compact('colleges'));
    }

    /**
     * Store a new voter account.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'       => ['required', Password::defaults(), 'confirmed'],
            'student_number' => ['required', 'string', 'max:50', 'unique:users,student_number'],
            'sex'            => ['required', 'in:male,female,other'],
            'college_id'     => ['required', 'exists:colleges,college_id'],
            'course'         => ['required', 'string', 'max:100'],
            'year_level'     => ['required', 'integer', 'min:1', 'max:6'],
            'status'         => ['required', 'in:active,inactive'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role']     = 'voter';

        User::create($validated);

        return redirect()->route('admin.voters.index')
            ->with('success', 'Voter account created successfully.');
    }

    /**
     * Show a voter's full profile and vote history.
     */
    public function show(User $voter)
    {
        abort_if($voter->role !== 'voter', 404);

        $voter->load(['college', 'votes.candidate', 'votes.position']);

        return view('admin.voters.show', compact('voter'));
    }

    /**
     * Show edit form for a voter.
     */
    public function edit(User $voter)
    {
        abort_if($voter->role !== 'voter', 404);

        $colleges = College::orderBy('name')->get();

        return view('admin.voters.edit', compact('voter', 'colleges'));
    }

    /**
     * Update a voter's profile.
     */
    public function update(Request $request, User $voter)
    {
        abort_if($voter->role !== 'voter', 404);

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($voter->id)],
            'student_number' => ['required', 'string', 'max:50', Rule::unique('users', 'student_number')->ignore($voter->id)],
            'sex'            => ['required', 'in:male,female,other'],
            'college_id'     => ['required', 'exists:colleges,college_id'],
            'course'         => ['required', 'string', 'max:100'],
            'year_level'     => ['required', 'integer', 'min:1', 'max:6'],
            'status'         => ['required', 'in:active,inactive'],
        ]);

        $voter->update($validated);

        return redirect()->route('admin.voters.index')
            ->with('success', 'Voter updated successfully.');
    }

    /**
     * Delete a voter account.
     */
    public function destroy(User $voter)
    {
        abort_if($voter->role !== 'voter', 404);

        $voter->delete();

        return redirect()->route('admin.voters.index')
            ->with('success', 'Voter account deleted successfully.');
    }

    /**
     * Toggle a voter's active/inactive status.
     */
    public function toggleStatus(User $voter)
    {
        abort_if($voter->role !== 'voter', 404);

        $voter->status = $voter->status === 'active' ? 'inactive' : 'active';
        $voter->save();

        return back()->with('success', "Voter status set to {$voter->status}.");
    }
}