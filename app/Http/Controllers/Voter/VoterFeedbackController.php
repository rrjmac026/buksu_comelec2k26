<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoterFeedbackController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // GET /voter/feedback
    // Show the feedback form — pre-fills if voter already submitted.
    // Append ?edit=1 to force the edit form even after submission.
    // ─────────────────────────────────────────────────────────────
    public function show(Request $request)
    {
        $myFeedback = auth()->user()
            ->feedback()
            ->latest()
            ->first();

        return view('voter.feedback.feedback', compact('myFeedback'));
    }

    // ─────────────────────────────────────────────────────────────
    // POST /voter/feedback
    // Save or update the voter's feedback (one record per voter).
    // ─────────────────────────────────────────────────────────────
    public function submit(Request $request)
    {
        $request->validate([
            'feedback' => ['required', 'string', 'min:10', 'max:1000'],
            'rating'   => ['required', 'integer', 'min:1', 'max:5'],
        ], [
            'feedback.required' => 'Please write a comment before submitting.',
            'feedback.min'      => 'Your comment must be at least 10 characters.',
            'feedback.max'      => 'Your comment must not exceed 1000 characters.',
            'rating.required'   => 'Please select a star rating.',
            'rating.min'        => 'Rating must be at least 1 star.',
            'rating.max'        => 'Rating cannot exceed 5 stars.',
        ]);

        // updateOrCreate so voters can revise their feedback at any time
        auth()->user()->feedback()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'feedback' => $request->feedback,
                'rating'   => $request->rating,
            ]
        );

        return redirect()
            ->route('voter.feedback')
            ->with('success', 'Thank you! Your feedback has been saved successfully.');
    }
}