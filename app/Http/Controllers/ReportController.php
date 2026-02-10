<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Notifications\ReportStatusNotification;
use App\Notifications\ResolvedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function index()
    {
        $reports = Auth::check()
            ? Report::where('user_id', Auth::id())->latest()->get()
            : collect();

        return view('reports.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|string',
            'subtype'     => 'required|string',

            'location'    => 'nullable|string',
            'casualties'  => 'nullable|integer|min:0',
            'gender'      => 'nullable|string',
            'image'       => 'nullable|image|max:2048|required_without:video',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:20480|required_without:image',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'Pending';
        $validated['anonymous'] = $request->boolean('anonymous');


        // Handle Image Upload
   //if ($request->hasFile('image')) {
     //   $validated['image'] = $request->file('image')->store('reports', 'public');
    //}

   // Handle Image Upload (DigitalOcean Spaces)
if ($request->hasFile('image')) {

    $path = $request->file('image')->storePublicly(
        'reports',
        'spaces'
    );

    $imageUrl = Storage::disk('spaces')->url($path);// do not mind the url problem

    $validated['image'] = $imageUrl;
}



    // Handle Video Upload (DigitalOcean Spaces)
if ($request->hasFile('video')) {

    $path = $request->file('video')->storePublicly(
        'reports/videos',
        'spaces'
    );

    // Save FULL public URL
    $videoUrl = Storage::disk('spaces')->url($path);

    $validated['video'] = $videoUrl;
}


        // Save report
        $report = Report::create($validated);
         // Notify user
      //  $user = $report->user ?? User::find($report->user_id);
        //if ($user) {
          //  $user->notify(new ReportStatusNotification(
            //    $report,
              //  "Your report ID {$report->id} for {$report->type} - {$report->subtype} has been received."
           // ));
        //}
        // // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $reporterIdentity = $report->anonymous
    ? 'Anonymous'
    : ($user->email ?? 'Unknown User');

$admin->notify(new ReportStatusNotification(
    $report,
    "A new report (ID {$report->id}) has been submitted by {$reporterIdentity}."
));

        }

        return redirect()
            //->route('reports.index')
            ->route('report.process')
            ->with('success', "Report {$report->id} created successfully.");
    } 
    
    // end on this line

    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }


    public function fullReport(Report $report)
{
    return view('reports.fullreport', [
        'report' => $report
    ]);
}


// Recently added here
public function destroy(Report $report)
{
    // Ensure the logged-in user owns the report
    if ($report->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $report->delete();

    return redirect()
        ->route('reports.index')
        ->with('success', 'Report deleted successfully.');
}




public function updateStatus(Request $request, Report $report) 
{
    // Only allow the report owner to update
    if ($report->user_id !== Auth::id()) {
        abort(403, 'You are not allowed to update this report.');
    }

    $request->validate([
        'status' => 'required|string'
    ]);

    // Prevent duplicate notifications
    $oldStatus = $report->status;

    $report->status = $request->status;
    $report->save();

    // 🔔 Notify admins ONLY when resolved
    if ($oldStatus !== 'Resolved' && $request->status === 'Resolved') {

    $admins = User::where('role', 'admin')->get();

    $residentEmail = $report->anonymous
        ? 'Anonymous'
        : Auth::user()->email;

    foreach ($admins as $admin) {
        $admin->notify(
            new ResolvedNotification(
                $report,
                $residentEmail
            )
        );
    }
}


    return back()->with('success', 'Report status updated successfully.');
}




}                                                             