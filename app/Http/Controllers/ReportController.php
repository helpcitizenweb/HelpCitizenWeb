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
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'Pending';

        $report = Report::create($validated);

        $user = $report->user ?? User::find($report->user_id);
        if ($user) {
            $user->notify(new ReportStatusNotification(
                $report,
                "Your report ID {$report->id} for {$report->type} - {$report->subtype} has been received."
            ));
        }

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ReportStatusNotification(
                $report,
                "A new report (ID {$report->id}) has been submitted by {$user->name}."
            ));
        }

        return redirect()
            ->route('reports.index')
            ->with('success', "Report {$report->id} created successfully.");
    }

    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }
}                                                             