<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportHistoryController extends Controller
{
     public function index()
    {
        // Fetch only the authenticated user's reports
        $reports = Report::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('history.report_history', compact('reports'));
    }

    
}
