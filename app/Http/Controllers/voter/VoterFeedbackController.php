<?php

namespace App\Http\Controllers\Voter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoterFeedbackController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // GET /voter/feedback
    // Show the feedback form — pre-fills if voter already submitted
    // ─────────────────────────────────────────────────────────────
    public function show()
    {
        // Retrieve this voter's existing feedback (if any) so the
        // form can be pre-filled for editing
        $myFeedback = auth()->user()
            ->feedback()
            ->latest()
            ->first();

        return view('voter.feedback', compact('myFeedback'));
    }

    // ─────────────────────────────────────────────────────────────
    // POST /voter/feedback
    // Save or update the voter's feedback (one record per voter)
    // ─────────────────────────────────────────────────────────────
    public function submit(Request $request)
    {
        $request->validate([
            'feedback' => ['required', 'string', 'min:10', 'max:1000'],
            'rating'   => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        // updateOrCreate so voters can revise their feedback
        auth()->user()->feedback()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'feedback' => $request->feedback,
                'rating'   => $request->rating,
            ]
        );

        return redirect()
            ->route('voter.feedback')
            ->with('success', 'Thank you! Your feedback has been saved.');
    }
}