<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Report; 
use App\Models\Announcement; 
use App\Models\Service; 

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get the count of users, reports, announcements, and services
        $userCount = User::count();
        $reportCount = Report::count();
        $announcementCount = Announcement::count();
        $serviceCount = Service::count(); // Count services

        // Additional stats for active users, pending reports, and upcoming announcements
        $activeUsers = User::where('status', 'active')->count();
        $pendingReports = Report::where('status', 'pending')->count();
        $upcomingAnnouncements = Announcement::where('created_at', '>=', now())->count();

        // Return the view and pass the variables
        return view('admin.dashboard', compact('userCount', 'reportCount', 'announcementCount', 'serviceCount', 'activeUsers', 'pendingReports', 'upcomingAnnouncements'));
    }
}
