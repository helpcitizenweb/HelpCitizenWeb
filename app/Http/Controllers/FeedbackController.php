<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Show feedback form
     * Resident is ALLOWED to open this page even if already rated
     */
    public function create(Report $report)
    
    {
         $existingFeedback = Feedback::where('report_id', $report->id)
        ->where('user_id', Auth::id())
        ->first();

        //return view('feedback.feedback_resident', compact('report'));
        return view('feedback.feedback_resident', compact('report', 'existingFeedback'));
    }

    /**
     * Store feedback
     * Resident is BLOCKED from submitting more than once
     */
    public function store(Request $request, Report $report)
    {
        // 🚫 BLOCK duplicate submission (submit button logic)
        $alreadyRated = Feedback::where('report_id', $report->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyRated) {
            return redirect()
                ->route('report.history')
                ->with('error', 'You have already submitted feedback for this report.');
        }

        // ✅ VALIDATION (based on your model & requirements)
        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'feedback' => 'required|string',
            'photo'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'video'    => 'required|mimes:mp4,mov,avi|max:10240',
        ]);

        // ✅ FILE STORAGE
        $photoPath = $request->file('photo')->store('feedback/photos', 'public');
        $videoPath = $request->file('video')->store('feedback/videos', 'public');

        // ✅ CREATE FEEDBACK (hasOne via report_id unique)
        Feedback::create([
            'report_id'     => $report->id,
            'user_id'       => Auth::id(),

            // Ratings
            'rating'        => $validated['rating'],

            // Feedback content
            'feedback'      => $validated['feedback'],

            // Media
            'photo'         => $photoPath,
            'video'         => $videoPath,

            // Time tracking
            'feedback_date' => now()->toDateString(),
            'feedback_time' => now()->toTimeString(),
        ]);

        return redirect()
            ->route('report.history')
            ->with('success', 'Thank you! Your feedback has been submitted.');
    }
    public function adminRespond(Request $request, Feedback $feedback)
{
    // Prevent double response
    if ($feedback->admin_response) {
        return back()->with('error', 'You already responded to this feedback.');
    }

    $request->validate([
        'admin_response' => 'required|string|max:1000',
    ]);

    $feedback->update([
        'admin_response' => $request->admin_response,
        'admin_id' => Auth::id(),
        'admin_responded_at' => now(),
    ]);

    return back()->with('success', 'Admin response submitted successfully.');
}
public function feedbackReview(Report $report)
{
    return view('admin.reports.feedback_review', compact('report'));
}

}
