<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Report; 
use App\Models\Announcement; 
use App\Models\Service; 
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get the count of users, reports, announcements, and services hello there
        $userCount = User::count();
        $reportCount = Report::count();
        $announcementCount = Announcement::count();
        $serviceCount = Service::count(); // Count services

        // Additional stats for active users, pending reports, and upcoming announcements
        $activeUsers = User::where('status', 'active')->count();
        $pendingReports = Report::where('status', 'pending')->count();
        $upcomingAnnouncements = Announcement::where('created_at', '>=', now())->count();

        //for charts
        $reportData = Report::select('type', DB::raw('count(*) as total'))
    ->groupBy('type')
    ->pluck('total', 'type');

        // BAR CHART (subcategories)
$subtypeData = Report::select('subtype', DB::raw('count(*) as total'))
    ->groupBy('subtype')
    ->pluck('total', 'subtype');

// Convert to arrays for JS
$barLabels = $subtypeData->keys();
$barData = $subtypeData->values();

// LINE CHART (reports per day)
$lineDataRaw = Report::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('count(*) as total')
    )
    ->groupBy('date')
    ->orderBy('date')
    ->get();

$lineLabels = $lineDataRaw->pluck('date');
$lineData = $lineDataRaw->pluck('total');

        // Define fixed categories (important for consistent order)
        $categories = ['Emergencies', 'Accidents', 'Complaints', 'Suggestions'];
        $data = []; 
        foreach ($categories as $cat) {
        $data[] = $reportData[$cat] ?? 0;
        }
        // Return the view and pass the variabless
        return view('admin.dashboard', compact(
            'userCount',
             'reportCount', 
             'announcementCount', 
             'serviceCount', 
             'activeUsers', 
             'pendingReports', 
             'upcomingAnnouncements',
             'data',
             'barLabels',
    'barData',
    'lineLabels',
    'lineData'));
    }

    public function getChart($type)
{
    $query = Report::query();

    // FILTERS
    // FILTERS (FIXED)
if (request('category') && request('category') !== 'All') {
    $query->where('type', request('category'));
}

if (request('subtype') && request('subtype') !== 'All') {
    $query->where('subtype', request('subtype'));
}

if (request('status') && request('status') !== 'All') {
    $query->where('status', request('status'));
}

 // RATING FILTER
if (request('rating')) {
    $query->whereHas('feedback', function ($q) {
        $q->where('rating', request('rating'));
    });
}

    // DATE FILTER
    if (request('date') === 'today') {
        $query->whereDate('created_at', now());
    }

    if (request('date') === 'week') {
        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    if (request('date') === 'month') {
        $query->whereMonth('created_at', now()->month);
    }
    
    

    // =====================
    // CHART LOGIC
    // =====================

    if ($type === 'pie') {
    $data = $query->select('type', DB::raw('count(*) as total'))
        ->groupBy('type')
        ->get();

    return response()->json($data);
}

    if ($type === 'bar') {
    $data = $query->select('subtype', DB::raw('count(*) as total'))
        ->groupBy('subtype')
        ->get();

    return response()->json($data);
}
    if ($type === 'line') {
        $data = $query->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($data);
    }

    return response()->json([]);
}
    
}
