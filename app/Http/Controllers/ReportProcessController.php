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
                     ->whereIn('status', ['Pending', 'In Progress'])
                     ->orderBy('created_at', 'desc')
                     ->get();

    return view('history.report_process', compact('reports'));
    }
   public function destroy(Report $report)
{
    if (!$report || $report->user_id !== Auth::id()) {
        return redirect()->route('report.process')
            ->with('error', 'You cannot delete this report.');
    }

    $report->delete();

    return redirect()
        ->route('report.process')
        ->with('success', 'Report deleted successfully.');
}



    
}
