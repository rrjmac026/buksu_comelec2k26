<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    /**
     * List all feedback submissions with optional filtering.
     */
    public function index(Request $request)
    {
        $query = Feedback::with('user')->latest();

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->orWhere('feedback', 'like', "%{$search}%");
        }

        $feedbacks = $query->paginate(20)->withQueryString();

        $averageRating = Feedback::avg('rating');
        $ratingCounts  = Feedback::selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating');

        return view('admin.feedback.index', compact('feedbacks', 'averageRating', 'ratingCounts'));
    }

    /**
     * Show a single feedback entry.
     */
    public function show(Feedback $feedback)
    {
        $feedback->load('user');

        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Delete a feedback entry.
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully.');
    }

    // Admins view feedback only — creation/editing is handled by voters.
    public function create()   { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(Feedback $feedback)  { abort(403); }
    public function update(Request $request, Feedback $feedback) { abort(403); }
}