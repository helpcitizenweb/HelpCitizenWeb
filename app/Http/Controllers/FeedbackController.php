<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Report;
use App\Notifications\ResidentRatedReportNotification;
use App\Notifications\AdminRepliedToFeedbackNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // ✅ FILE STORAGE line 55-56
      //  $photoPath = $request->file('photo')->store('feedback/photos', 'public');
      //  $videoPath = $request->file('video')->store('feedback/videos', 'public');
      // Handle Photo Upload (DigitalOcean Spaces)
if ($request->hasFile('photo')) {

    $path = $request->file('photo')->storePublicly(
        'reports',
        'spaces'
    );

    $photoUrl = Storage::disk('spaces')->url($path);

    $validated['photo'] = $photoUrl;
}
// Handle Video Upload (DigitalOcean Spaces)
if ($request->hasFile('video')) {

    $path = $request->file('video')->storePublicly(
        'reports/videos',
        'spaces'
    );

    $videoUrl = Storage::disk('spaces')->url($path);

    $validated['video'] = $videoUrl;
}


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

        // 🔔 Notify admins that a resident submitted feedback
$admins = \App\Models\User::where('role', 'admin')->get();

$residentEmail = $report->anonymous
    ? 'Anonymous'
    : Auth::user()->email;

foreach ($admins as $admin) {
    $admin->notify(
        new \App\Notifications\ResidentRatedReportNotification(
            $report,
            $residentEmail
        )
    );
}




        return redirect()
            ->route('report.history')
            ->with('success', 'Thank you! Your feedback has been submitted.');
    }


    ///next line
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

    // 🔔 Notify the resident who submitted the feedback
    $resident = $feedback->user;

    if ($resident) {
        $resident->notify(
            new AdminRepliedToFeedbackNotification($feedback)
        );
    }

    return back()->with('success', 'Admin response submitted successfully.');
}
public function feedbackReview(Report $report)
{
    // get the feedback related to this report
    $feedback = $report->feedback; // or Feedback::where('report_id', $report->id)->first();

   // return view('admin.reports.feedback_review', compact('report'));
    return view('admin.reports.partials.feedback_review', compact('report', 'feedback'));

}

}
