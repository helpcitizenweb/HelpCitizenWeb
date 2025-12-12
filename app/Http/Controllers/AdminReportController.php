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

    // -------------------------------------------------------------------
    // UPDATED updateStatus() — saves BASIC + FULL resolution datag
    // -------------------------------------------------------------------
    public function updateStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $newStatus = $request->input('status');

        // If leaving Resolved, clear only the quick fields
        if (in_array($report->status, ['Resolved', 'Action']) 
        && $newStatus !== $report->status) {
            $report->evacuation_site = null;
            $report->dispatch_unit = null;
            $report->contact_person = null;
            $report->overseer = null;
            $report->contact_number = null;
        }

        // If switching to Resolved, save quick + full BDRRM fields
         if (in_array($newStatus, ['Resolved', 'Action'])) {

            // Quick fields (always saved)
            $report->evacuation_site = $request->input('evacuation_site');
            $report->dispatch_unit = $request->input('dispatch_unit');
            $report->contact_person = $request->input('contact_person');
            $report->overseer = $request->input('overseer');
            $report->contact_number = $request->input('contact_number');

            // Save ALL dispatch form fields
            $this->updateResolution($request, $report);
        }

        $report->status = $newStatus;
        $report->save();

        return redirect()->back()->with('success', 'Report status updated successfully.');
    }

    // -------------------------------------------------------------------
    // UPDATED updateResolution() — all BDRRM fields saved here
    // -------------------------------------------------------------------
    public function updateResolution(Request $request, Report $report)
    {
       // dd($request->all());
        // Helper: dropdown with OTHER
        $pick = function ($field) use ($request) {
            $value = $request->input($field);

            if ($value === 'Other') {
                return $request->input($field . '_other') ?: null;
            }

            return $value; // includes NONE/N/A
        };

        // Helper: numbers
        $pickNum = function ($field) use ($request) {
            return ($request->input($field) !== null && $request->input($field) !== '')
                ? intval($request->input($field))
                : null;
        };

        // Helper: checkbox arrays
        $pickCheckbox = function ($field) use ($request) {
            if ($request->has($field)) {
                $values = array_filter($request->input($field));
                return empty($values) ? null : json_encode($values);
            }
            return null;
        };

        // DISPATCH-UNIT SPECIFIC FIELDS
        $fields = [

            'Fire' => [
                'medical_response' => $pick('medical_response'),
                'ambulance_units' => $pickNum('ambulance_units'),
                'designated_hospitals' => $pick('designated_hospitals'),
                'hospital_address' => $request->hospital_address,
                'evacuation_address' => $pick('evacuation_address'),
                'evacuation_transport' => $pick('evacuation_transport'),
                'evacuation_transport_unit' => $pickNum('evacuation_transport_unit'),
                'relief_goods_provider' => $pick('relief_goods_provider'),
                'pnp_station' => $pick('pnp_station'),
                'pnp_team_unit' => $pick('pnp_team_unit'),
                'pnp_patrol_unit' => $pickNum('pnp_patrol_unit'),
                'fire_department' => $pick('fire_department'),
                'fire_team' => $pick('fire_team'),
                'fire_truck_units' => $pickNum('fire_truck_units'),
                'search_rescue_team' => $pick('search_rescue_team'),
                'relief_welfare' => $pickCheckbox('relief_welfare')
            ],

            'Flood_typhoon' => [
                'medical_response' => $pick('medical_response'),
                'ambulance_units' => $pickNum('ambulance_units'),
                'designated_hospitals' => $pick('designated_hospitals'),
                'hospital_address' => $request->hospital_address,
                'evacuation_address' => $pick('evacuation_address'),
                'evacuation_transport' => $pick('evacuation_transport'),
                'evacuation_transport_unit' => $pickNum('evacuation_transport_unit'),
                'water_rescue_response_unit' => $pick('water_rescue_response_unit'),
                'rubber_boat_units' => $pickNum('rubber_boat_units'),
                'lifeguard_rescue_personnel' => $pick('lifeguard_rescue_personnel'),
                'search_rescue_team' => $pick('search_rescue_team'),
                'safety_and_security' => $pick('safety_and_security'),
                'relief_welfare' => $pickCheckbox('relief_welfare')
            ],

            'Earthquake' => [
                'medical_response' => $pick('medical_response'),
                'ambulance_units' => $pickNum('ambulance_units'),
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

            'Medical' => [
                'medical_response' => $pick('medical_response'),
                'ambulance_units' => $pickNum('ambulance_units'),
                'designated_hospitals' => $pick('designated_hospitals'),
                'hospital_address' => $request->hospital_address,
                'first_aid_station' => $pick('first_aid_station'),
                
            ],

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

        // GLOBAL FIELDS
        $report->evacuation_site = $request->evacuation_site;
        $report->dispatch_unit = $request->dispatch_unit;
        $report->contact_person = $request->contact_person;
        $report->overseer = $request->overseer;
        $report->contact_number = $request->contact_number;

        // DISPATCH-SPECIFIC SAVE
        if (isset($fields[$report->dispatch_unit])) {
            foreach ($fields[$report->dispatch_unit] as $column => $value) {
                $report->$column = $value;
            }
        }

        $report->save();

        return redirect()->back()->with('success', 'Resolution updated successfully.');
    }
}