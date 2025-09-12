<?php

namespace App\Http\Controllers;

use App\Models\Report;
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
        $anonymous = $request->input('anonymous', 0);

        $allowedTypes = [
            'Emergencies' => ['Fire', 'Flood', 'Earthquake', 'Medical', 'Others'],
            'Accidents' => ['Traffic', 'Workplace', 'Home', 'Others'],
            'Complaints' => ['Noise', 'Garbage', 'Harassment', 'Others'],
            'Suggestions' => ['Public Safety', 'Infrastructure', 'Services', 'Others'],
            'Others' => ['Miscellaneous']
        ];

        $prefixMap = [
            'Emergencies' => [
                'Fire' => 'E-FR', 
                'Flood' => 'E-FL', 
                'Earthquake' => 'E-EQ', 
                'Medical' => 'E-MD', 
                'Others' => 'E-OE'
            ],
            'Accidents' => [
                'Traffic' => 'A-TR', 
                'Workplace' => 'A-WP', 
                'Home' => 'A-HH', 
                'Others' => 'A-OA'
            ],
            'Complaints' => [
                'Noise' => 'C-NS', 
                'Garbage' => 'C-GB', 
                'Harassment' => 'C-HR', 
                'Others' => 'C-OC'
            ],
            'Suggestions' => [
                'Public Safety' => 'S-PS', 
                'Infrastructure' => 'S-IF', 
                'Services' => 'S-SS', 
                'Others' => 'S-OS'
            ],
            'Others' => [
                'Miscellaneous' => 'O-MS'
                ]
        ];

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'type' => 'required|string|in:' . implode(',', array_keys($allowedTypes)),
            'subtype' => [
                'required',
                'string',
                function ($attribute, $value) use ($request, $allowedTypes) {
                    $type = $request->input('type');
                    if (!isset($allowedTypes[$type]) || !in_array($value, $allowedTypes[$type])) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            $attribute => "Invalid subtype for the selected type."
                        ]);
                    }
                }
            ],
            'location' => 'nullable|string|max:255',
            'urgency' => 'required|string',
            'casualties' => 'nullable|integer|min:0',
            'gender' => 'nullable|string|in:Male,Female,Both'
        ];

        if (!Auth::check()) {
            if ($anonymous != 1) {
                $rules['name'] = 'required|string|max:255';
                $rules['email'] = 'required|email|max:255';
            } else {
                $request->merge(['name' => 'Anonymous', 'email' => 'anonymous@example.com']);
            }
            $rules['phone'] = 'nullable|string|max:20';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('reports', 'public');
        }

        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        $validated['status'] = 'Pending';
        $type = $validated['type'];
        $subtype = $validated['subtype'];
        $prefix = $prefixMap[$type][$subtype] ?? 'GEN';

        $lastReport = Report::where('id', 'like', $prefix . '-%')
                            ->orderBy('id', 'desc')
                            ->first();

        $nextNumber = $lastReport
            ? intval(substr($lastReport->id, strlen($prefix) + 1)) + 1
            : 1;

        $validated['id'] = $prefix . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        $report = Report::create($validated);

        if ($type === 'Emergencies') {
            $message = "Your report ID {$report->id} for {$type} - {$subtype} has been received. Please move to a safe location and follow any known safety procedures. Barangay responders are being alerted and will contact you if needed.";
        } else {
            $message = "Your report ID {$report->id} for {$type} - {$subtype} has been received. Barangay staff will review your concern and take the necessary action. Please keep your contact line open for updates.";
        }

        return redirect()->route('reports.index')->with('success', $message);
    }
}
