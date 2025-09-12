<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    // List all reports
    public function index(Request $request)
    {
        $query = Report::with('user');

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->get();

        return view('admin.reports.index', compact('reports'));
    }

    // Show single report
    public function show(Report $report)
    {
        return view('admin.reports.show', compact('report'));
    }

    // Update report status
    public function updateStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $newStatus = $request->input('status');

        if ($report->status === 'Resolved' && $newStatus !== 'Resolved') {
            // Clear resolution fields if changing from Resolved
            $report->evacuation_site = null;
            $report->dispatch_unit = null;
            $report->contact_person = null;
            $report->contact_number = null;
        }

        if ($newStatus === 'Resolved') {
            $report->evacuation_site = $request->input('evacuation_site');
            $report->dispatch_unit = $request->input('dispatch_unit');
            $report->contact_person = $request->input('contact_person');
            $report->contact_number = $request->input('contact_number');
        }

        $report->status = $newStatus;
        $report->save();

        return redirect()->back()->with('success', 'Report status updated successfully.');
    }

    // Update resolution fields only (status stays the same)
    public function updateResolution(Request $request, Report $report)
    {
        // Only update resolution fields
        $report->update($request->only([
            'evacuation_site',
            'dispatch_unit',
            'contact_person',
            'contact_number',
        ]));

        return redirect()->back()->with('success', 'Resolution updated successfully.');
    }
}
