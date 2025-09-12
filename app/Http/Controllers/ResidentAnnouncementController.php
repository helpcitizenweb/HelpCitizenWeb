<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class ResidentAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(6);
        return view('resident.announcements.index', compact('announcements'));
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('resident.announcements.show', compact('announcement'));
    }

}
