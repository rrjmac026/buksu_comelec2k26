<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\College;
use App\Models\Organization;
use App\Models\Partylist;
use App\Models\Position;
use Illuminate\Http\Request;

class AdminCandidateController extends Controller
{
    public function index()
    {
        $query = Candidate::with(['partylist', 'organization', 'position', 'college']);

        // Apply search filter
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%")
                  ->orWhereHas('position', fn($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        // Apply college filter
        if ($college_id = request('college_id')) {
            $query->where('college_id', $college_id);
        }

        // Apply partylist filter
        if ($partylist_id = request('partylist_id')) {
            $query->where('partylist_id', $partylist_id);
        }

        // Compute stats from the filtered query
        $stats = [
            'total' => $query->count(),
            'partylists' => $query->distinct('partylist_id')->count('partylist_id'),
            'colleges' => $query->distinct('college_id')->count('college_id'),
            'votes' => \App\Models\CastedVote::count(),
        ];

        $candidates = $query->latest()->paginate(15);

        return view('admin.candidates.index', compact('candidates', 'stats'));
    }

    public function create()
    {
        $partylists    = Partylist::orderBy('name')->get();
        $organizations = Organization::with('college')->orderBy('name')->get();
        $positions     = Position::orderBy('sort_order')->get();
        $colleges      = College::orderBy('name')->get();

        return view('admin.candidates.create', compact('partylists', 'organizations', 'positions', 'colleges'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'first_name'      => ['required', 'string', 'max:100'],
            'last_name'       => ['required', 'string', 'max:100'],
            'middle_name'     => ['nullable', 'string', 'max:100'],
            'partylist_id'    => ['required', 'exists:partylists,id'],       // PK is id ✅
            'organization_id' => ['required', 'exists:organizations,id'],    // PK is id ✅
            'position_id'     => ['required', 'exists:positions,id'],        // PK is id ✅
            'college_id'      => ['required', 'exists:colleges,id'],         // PK is id ✅
            'course'          => ['required', 'string', 'max:100'],
            'platform'        => ['nullable', 'string'],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        if ($request->hasFile('photo')) {
            $file     = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/candidates'), $filename);
            $validated['photo'] = $filename;
        }

        Candidate::create($validated);

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate created successfully.');
    }

    public function show(Candidate $candidate)
    {
        $candidate->load(['partylist', 'organization', 'position', 'college', 'votes']);

        return view('admin.candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        $partylists    = Partylist::orderBy('name')->get();
        $organizations = Organization::with('college')->orderBy('name')->get();
        $positions     = Position::orderBy('sort_order')->get();
        $colleges      = College::orderBy('name')->get();

        return view('admin.candidates.edit', compact('candidate', 'partylists', 'organizations', 'positions', 'colleges'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'first_name'      => ['required', 'string', 'max:100'],
            'last_name'       => ['required', 'string', 'max:100'],
            'middle_name'     => ['nullable', 'string', 'max:100'],
            'partylist_id'    => ['required', 'exists:partylists,id'],       // PK is id ✅
            'organization_id' => ['required', 'exists:organizations,id'],    // PK is id ✅
            'position_id'     => ['required', 'exists:positions,id'],        // PK is id ✅
            'college_id'      => ['required', 'exists:colleges,id'],         // PK is id ✅
            'course'          => ['required', 'string', 'max:100'],
            'platform'        => ['nullable', 'string'],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        if ($request->hasFile('photo')) {
            if ($candidate->photo) {
                $oldPath = public_path('images/candidates/' . $candidate->photo);
                if (file_exists($oldPath)) unlink($oldPath);
            }

            $file     = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/candidates'), $filename);
            $validated['photo'] = $filename;
        }

        $candidate->update($validated);

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate updated successfully.');
    }

    public function destroy(Candidate $candidate)
    {
        if ($candidate->photo) {
            $path = public_path('images/candidates/' . $candidate->photo);
            if (file_exists($path)) unlink($path);
        }

        $candidate->delete();

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate deleted successfully.');
    }

    public function searchStudent(Request $request)
    {
        $query = trim($request->query('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = \App\Models\User::with('college')
            ->where('role', 'voter')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('middle_name', 'like', "%{$query}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(last_name, ', ', first_name) like ?", ["%{$query}%"]);
            })
            ->limit(10)
            ->get()
            ->map(fn($u) => [
                'id'          => $u->id,
                'first_name'  => $u->first_name,
                'middle_name' => $u->middle_name ?? '',
                'last_name'   => $u->last_name,
                'college_id'  => $u->college_id,
                'college'     => $u->college?->name ?? '',
                'course'      => $u->course,
                'display'     => $u->last_name . ', ' . $u->first_name . ($u->middle_name ? ' ' . $u->middle_name[0] . '.' : '') . ' — ' . $u->course,
            ]);

        return response()->json($users);
    }
}