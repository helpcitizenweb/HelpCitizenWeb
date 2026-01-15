<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportProcessController
 extends Controller
{
     public function index()
    {
        $reports = Report::where('user_id', Auth::id())
                     ->whereIn('status', ['Pending', 'In Progress', 'Action'])
                     ->orderBy('created_at', 'desc')
                     ->get();

    return view('history.report_process', compact('reports'));
    }
   public function destroy(Report $report)
{
    // Ownership check
    if (!$report || $report->user_id !== Auth::id()) {
        return redirect()->route('report.process')
            ->with('error', 'You cannot delete this report.');
    }

    // 🚫 BLOCK cancel if Action already started
    if ($report->status === 'Action') {
        return redirect()->route('report.process')
            ->with('error', 'This report can no longer be canceled because action has already started.');
    }

    // Optional: also block Resolved / Cancel
    if (in_array($report->status, ['Resolved', 'Cancel'])) {
        return redirect()->route('report.process')
            ->with('error', 'This report can no longer be canceled.');
    }

    $report->delete();

    return redirect()
        ->route('report.process')
        ->with('success', 'Report canceled successfully.');
}




    
}
