<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // GET /admin/feedback
    // List all feedback with search/rating filters + stats
    // ─────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Feedback::with(['user.college'])
            ->latest('updated_at');

        // Search by voter name, email, or feedback text
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('feedback', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by exact rating
        if ($rating = $request->input('rating')) {
            $query->where('rating', (int) $rating);
        }

        $feedbacks     = $query->paginate(10)->withQueryString();
        $averageRating = Feedback::avg('rating') ?? 0;
        $ratingCounts  = Feedback::selectRaw('rating, count(*) as count')
                                 ->groupBy('rating')
                                 ->pluck('count', 'rating');

        return view('admin.feedback.index', compact(
            'feedbacks',
            'averageRating',
            'ratingCounts',
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // GET /admin/feedback/{feedback}
    // Show a single feedback submission in full
    // ─────────────────────────────────────────────────────────────
    public function show(Feedback $feedback)
    {
        $feedback->load('user.college');

        return view('admin.feedback.show', compact('feedback'));
    }

    // ─────────────────────────────────────────────────────────────
    // DELETE /admin/feedback/{feedback}
    // Hard-delete a feedback record
    // ─────────────────────────────────────────────────────────────
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()
            ->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully.');
    }
}