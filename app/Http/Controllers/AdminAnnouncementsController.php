<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Support\Facades\Storage;

class AdminAnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(6); 
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
    'title' => 'required|string|max:255',
    'content' => 'required|string',

    'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

    'disaster_type' => 'nullable|string|max:255',
    'alert_level' => 'nullable|string|max:255',
    'affected_area' => 'nullable|string|max:255',

    'instructions' => 'nullable|string',

    'evacuation_center' => 'nullable|string|max:255',

    'medical_facility_name' => 'nullable|string|max:255',
    'medical_facility_contact' => 'nullable|string|max:255',

    'security_coordination_note' => 'nullable|string',

    'start_datetime' => 'nullable|date',
    'end_datetime' => 'nullable|date',

    'status' => 'nullable|string|max:255',

    'is_urgent' => 'nullable',

    'issued_by' => 'nullable|string|max:255',

    'reference_source' => 'nullable|string|max:255',
]);

$imagePath = null;

if ($request->hasFile('image')) {

    $path = $request->file('image')->storePublicly(
        'announcements',
        'spaces'
    );

    $imagePath = Storage::disk('spaces')->url($path);
}

        // Store the announcement
      $announcement = Announcement::create([
    'title' => $request->title,
    'content' => $request->content,

    'image' => $imagePath,

    'disaster_type' => $request->disaster_type,
    'alert_level' => $request->alert_level,
    'affected_area' => $request->affected_area,

    'instructions' => $request->instructions,

    'evacuation_center' => $request->evacuation_center,

    'medical_facility_name' => $request->medical_facility_name,
    'medical_facility_contact' => $request->medical_facility_contact,

    'security_coordination_note' => $request->security_coordination_note,

    'start_datetime' => $request->start_datetime,
    'end_datetime' => $request->end_datetime,

    'status' => $request->status,

    'is_urgent' => $request->has('is_urgent'),

    'issued_by' => $request->issued_by,

    'reference_source' => $request->reference_source,
]);
$message =
    "📢 New Emergency Announcement\n" .
    "A new {$announcement->disaster_type} advisory has been issued.\n" .
    "Alert Level: {$announcement->alert_level}\n\n" .
    "Please review the announcement for important safety information and recommended actions.";

$residents = User::where('role', 'resident')->get();

foreach ($residents as $resident) {
    $resident->notify(
        new AnnouncementNotification($announcement, $message)
    );
}

        // Redirect to the announcements index with a success message
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created successfully.');
    }


    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
       $request->validate([
'title' => 'required|string|max:255',
'content' => 'required|string',

    'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

    'disaster_type' => 'nullable|string|max:255',
    'alert_level' => 'nullable|string|max:255',
    'affected_area' => 'nullable|string|max:255',

    'instructions' => 'nullable|string',

    'evacuation_center' => 'nullable|string|max:255',

    'medical_facility_name' => 'nullable|string|max:255',
    'medical_facility_contact' => 'nullable|string|max:255',

    'security_coordination_note' => 'nullable|string',

    'start_datetime' => 'nullable|date',
    'end_datetime' => 'nullable|date',

    'status' => 'nullable|string|max:255',

    'is_urgent' => 'nullable',

    'issued_by' => 'nullable|string|max:255',

    'reference_source' => 'nullable|string|max:255',
]);

$imagePath = $announcement->image; if ($request->hasFile('image')) { $imagePath = $request->file('image')->store( 'announcements', 'public' ); }

        $announcement->update([ 'title' => $request->title, 'content' => $request->content, 'image' => $imagePath, 'disaster_type' => $request->disaster_type, 'alert_level' => $request->alert_level, 'affected_area' => $request->affected_area, 'instructions' => $request->instructions, 'evacuation_center' => $request->evacuation_center, 'medical_facility_name' => $request->medical_facility_name, 'medical_facility_contact' => $request->medical_facility_contact, 'security_coordination_note' => $request->security_coordination_note, 'start_datetime' => $request->start_datetime, 'end_datetime' => $request->end_datetime, 'status' => $request->status, 'is_urgent' => $request->has('is_urgent'), 'issued_by' => $request->issued_by, 'reference_source' => $request->reference_source, ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }

public function view($id)
{
    $announcement = Announcement::findOrFail($id);

    return view('admin.announcements.viewannouncement', compact('announcement'));
}


}
