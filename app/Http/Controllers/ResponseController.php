<?php

namespace App\Http\Controllers;

use App\Notifications\AdminRespondedNotification;
use App\Notifications\ReportStatusUpdatedNotification;

use App\Models\Report;
use App\Models\Response;
use App\Models\Feedback;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function showViewReport(Report $report)
    {
         $response = $report->response; // this part has been added
       // $feedback = Feedback::where('report_id', $report->id)->first();
        $feedback = $report->feedback;
       // return view('admin.reports.viewreport', compact('report'));
        return view('admin.reports.viewreport', compact('report', 'response','feedback'));
    }

    public function createResponseForm(Report $report)
{
    $response = $report->response ?? new Response();

    return view('admin.reports.response', compact('report', 'response'));
}





public function updateStatus(Request $request, Report $report)
{
    $validated = $request->validate([
        'status' => 'required|in:Pending,In Progress,Action,Cancel'
    ]);

    $report->status = $validated['status'];
    $report->save();
     // 🔔 Notify ONLY the report owner
    $resident = $report->user;

    if ($resident) {
        $resident->notify(
            new ReportStatusUpdatedNotification($report, $validated['status'])
        );
    }

    return redirect()->back()->with('success', 'Status updated successfully.');
}



    public function storeResponse(Request $request, Report $report)
{
    // -------------------------------------------
    // VALIDATION
    // -------------------------------------------
    $validated = $request->validate([
        'dispatch_unit'   => 'required|string',
        'overseer'        => 'nullable|string|max:255',
        'contact_person'  => 'nullable|string|max:255',
        'contact_number'  => 'nullable|string|max:20',
    ]);

    // -------------------------------------------
    // GET OR CREATE RESPONSE
    // -------------------------------------------
    $response = $report->response ?? new Response();
    $response->report_id = $report->id;

    // -------------------------------------------
    // HELPER FUNCTIONS (same as updateResolution)
    // -------------------------------------------
    $pick = function ($field) use ($request) {
        $value = $request->input($field);
        return $value === 'Other'
            ? ($request->input($field . '_other') ?: null)
            : $value;
    };

    $pickNum = function ($field) use ($request) {
        return ($request->input($field) !== null && $request->input($field) !== '')
            ? intval($request->input($field))
            : null;
    };

    $pickCheckbox = function ($field) use ($request) {
        if ($request->has($field)) {
            $values = array_filter($request->input($field));
            return empty($values) ? null : json_encode($values);
        }
        return null;
    };

    // -------------------------------------------
    // DISPATCH-UNIT SPECIFIC FIELDS
    // -------------------------------------------
    $fields = [

        // 🔥 FIRE RESPONSE --------------------------------------
        'Fire' => [
            'medical_response'          => $pick('medical_response'),
            'ambulance_units'           => $pickNum('ambulance_units'),
            'designated_hospitals'      => $pick('designated_hospitals'),

            'hospital_address'          => $request->hospital_address,
            'hospital_latitude'         => $request->hospital_latitude,
            'hospital_longitude'        => $request->hospital_longitude,

            'evacuation_address'        => $request->evacuation_address,
            'evacuation_latitude'       => $request->evacuation_latitude,
            'evacuation_longitude'      => $request->evacuation_longitude,

            'evacuation_transport'      => $pick('evacuation_transport'),
            'evacuation_transport_unit' => $pickNum('evacuation_transport_unit'),

            'relief_goods_provider'     => $pick('relief_goods_provider'),
            'pnp_station'               => $pick('pnp_station'),
            'pnp_team_unit'             => $pick('pnp_team_unit'),
            'pnp_patrol_unit'           => $pickNum('pnp_patrol_unit'),

            'fire_department'           => $pick('fire_department'),
            'fire_team'                 => $pick('fire_team'),
            'fire_truck_units'          => $pickNum('fire_truck_units'),

            'search_rescue_team'        => $pick('search_rescue_team'),

            'relief_welfare'            => $pickCheckbox('relief_welfare'),
        ],

        // 🌊 FLOOD & TYPHOON RESPONSE ---------------------------
        'Flood_typhoon' => [
            'medical_response'          => $pick('medical_response'),
            'ambulance_units'           => $pickNum('ambulance_units'),
            'designated_hospitals'      => $pick('designated_hospitals'),
            'hospital_address' => $request->hospital_address,
            //'hospital_latitude'         => $request->hospital_latitude,
            //'hospital_longitude'        => $request->hospital_longitude,
            'evacuation_address' => $pick('evacuation_address'),
            //'evacuation_latitude'       => $request->evacuation_latitude,
            //'evacuation_longitude'      => $request->evacuation_longitude,
            'evacuation_transport'      => $pick('evacuation_transport'),
            'evacuation_transport_unit' => $pickNum('evacuation_transport_unit'),
            'water_rescue_response_unit' => $pick('water_rescue_response_unit'),
            //'rubber_boat_units'          => $pickNum('rubber_boat_units'),
            'lifeguard_rescue_personnel' => $pick('lifeguard_rescue_personnel'),
            'search_rescue_team'        => $pick('search_rescue_team'),
            'safety_and_security'       => $pick('safety_and_security'),
            'relief_welfare'            => $pickCheckbox('relief_welfare'),
        ],

        // 🌎 EARTHQUAKE ------------------------------------------
        'Earthquake' => [
                'medical_response' => $pick('medical_response'),             
                'designated_hospitals' => $pick('designated_hospitals'),               
                'hospital_address' => $request->hospital_address,

                'evacuation_address' => $pick('evacuation_address'),
                'evacuation_transport' => $pick('evacuation_transport'),
                'evacuation_transport_unit' => $pickNum('evacuation_transport_unit'),
                'pnp_station' => $pick('pnp_station'),
                'pnp_team_unit' => $pick('pnp_team_unit'),
                'pnp_patrol_unit' => $pickNum('pnp_patrol_unit'),
                'relief_goods_provider' => $pick('relief_goods_provider'),
                'fire_department' => $pick('fire_department'),
                'fire_team' => $pick('fire_team'),
                'fire_truck_units' => $pickNum('fire_truck_units'),
                'search_rescue_team' => $pick('search_rescue_team'),
                'clearing_teams' => $pick('clearing_teams'),
                'power_utility_agency' => $pick('power_utility_agency'),
                'structural_assessment_teams' => $pick('structural_assessment_teams'),
                'relief_welfare' => $pickCheckbox('relief_welfare')
        ],
        // 🚑 MEDICAL ---------------------------------------------
        'Medical' => [
                'medical_response' => $pick('medical_response'),
                'designated_hospitals' => $pick('designated_hospitals'),
                'hospital_address' => $request->hospital_address,
                'first_aid_station' => $pick('first_aid_station'),
                'ambulance_units' => $pickNum('ambulance_units'),
        ],
        // 🚓 TRAFFIC ---------------------------------------------
        'Traffic' => [
                'medical_response' => $pick('medical_response'),
                'ambulance_units' => $pickNum('ambulance_units'),
                'designated_hospitals' => $pick('designated_hospitals'),
                'hospital_address' => $request->hospital_address,
                'road_clearance_team' => $pick('road_clearance_team'),
                'traffic_diversion_sites' => $pick('traffic_diversion_sites'),
                'pnp_station' => $pick('pnp_station'),
                'pnp_team_unit' => $pick('pnp_team_unit'),
                'pnp_patrol_unit' => $pickNum('pnp_patrol_unit'),
        ],
        // 🏠 WORKPLACE -------------------------------------------
        'Workplace_Home' => [
            'medical_response' => $pick('medical_response'),
                'ambulance_units' => $pickNum('ambulance_units'),
                'designated_hospitals' => $pick('designated_hospitals'),
                'hospital_address' => $request->hospital_address,
                'first_aid_station' => $pick('first_aid_station'),
                'pnp_station' => $pick('pnp_station'),
                'pnp_team_unit' => $pick('pnp_team_unit'),
                'pnp_patrol_unit' => $pickNum('pnp_patrol_unit'),
        ],
        // 🚨 COMPLAINTS (Noise, Harassment, etc.) ---------------
        'Noise' => [
            'responding_team_complaints' => $pick('responding_team_complaints'),
                'complaints_actions' => $pick('complaints_actions'),
                'pnp_station' => $pick('pnp_station'),
                'pnp_team_unit' => $pick('pnp_team_unit'),
                'pnp_patrol_unit' => $pickNum('pnp_patrol_unit'),

        ],
        'Harassment' => [
                'responding_team_complaints' => $pick('responding_team_complaints'),
                'complaints_actions' => $pick('complaints_actions'),              
                // ADD THESE
                'pnp_station' => $pick('pnp_station'),
                'pnp_team_unit' => $pick('pnp_team_unit'),
                 'pnp_patrol_unit' => $pickNum('pnp_patrol_unit'),
        ],
        'Garbage' => [
                'responding_team_complaints' => $pick('responding_team_complaints'),
                'complaints_actions' => $pick('complaints_actions'),
                'pnp_station' => $pick('pnp_station'),
                'pnp_team_unit' => $pick('pnp_team_unit'),
                'pnp_patrol_unit' => $pickNum('pnp_patrol_unit'),

        ],
        'Services' => [
                'responding_team_suggestion' => $pick('responding_team_suggestion'),
                'inspection_date' => $request->inspection_date,
                'recommended_action' => $pick('recommended_action'),

        ],
    ];

    // -------------------------------------------
    // SAVE GLOBAL RESPONSE FIELDS
    // -------------------------------------------
    $response->dispatch_unit  = $validated['dispatch_unit'];
    $response->overseer       = $validated['overseer'];
    $response->contact_person = $validated['contact_person'];
    $response->contact_number = $validated['contact_number'];

    // -------------------------------------------
    // APPLY DISPATCH-SPECIFIC FIELDS
    // -------------------------------------------
    if (isset($fields[$response->dispatch_unit])) {
        foreach ($fields[$response->dispatch_unit] as $column => $value) {
            $response->$column = $value;
        }
    }

    // Save response
    $response->response_datetime = now();

    if (!$response->reference_ID) {
        $response->reference_ID = 'REF-' . strtoupper(uniqid());
    }

    $response->save();

    $resident = $report->user;

if ($resident) {
    $resident->notify(new AdminRespondedNotification($report));
}

    // Update report status
    $report->status = 'Action';
    $report->save();

    return redirect()
        ->route('admin.reports.viewreport', $report->id)
        ->with('success', value: 'Response saved successfully.');
}

}
