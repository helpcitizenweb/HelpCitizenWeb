<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Notifications\ReportStatusNotification;
use Illuminate\Http\Request;
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
            'urgency'     => 'nullable|string',
            'casualties'  => 'nullable|integer|min:0',
            'gender'      => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:20480',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'Pending';

        // Handle Image Upload
   if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('reports', 'public');
    }
    // ✅ Handle Video Upload (THIS IS WHAT YOU NEED)
    if ($request->hasFile('video')) {
        $validated['video'] = $request->file('video')->store('reports/videos', 'public');
    }

        // Save report
        $report = Report::create($validated);
         // Notify user
        $user = $report->user ?? User::find($report->user_id);
        if ($user) {
            $user->notify(new ReportStatusNotification(
                $report,
                "Your report ID {$report->id} for {$report->type} - {$report->subtype} has been received."
            ));
        }
        // // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ReportStatusNotification(
                $report,
                "A new report (ID {$report->id}) has been submitted by {$user->name}."
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

    $report->status = $request->status;
    $report->save();

    return back()->with('success', 'Report status updated successfully.');
}



}                                                             