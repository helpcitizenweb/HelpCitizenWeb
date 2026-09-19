@extends('layouts.app')

@section('content')

@php
    $step = match($report->status) {
        'Pending' => 1,
        'In Progress' => 2,
        'Cancel' => 2.5,
        'Action' => 3,
        'Resolved' => 4,
        default => 1
    };

    $response = $report->response;
@endphp

<style>
    .progress-line { transition: width 0.8s ease-in-out; }
    .fade-in { animation: fadeIn 0.6s ease-in-out forwards; opacity: 0; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="max-w-4xl mx-auto fade-in space-y-6">

    {{-- ================= REPORT DETAILS ================= --}}
    <div class="bg-gray-50 p-6 rounded-lg shadow">

        {{-- PROGRESS BAR --}}
        <div class="mb-8">
            <div class="relative flex items-center justify-between">
                <div class="absolute left-0 right-0 top-1/2 h-1.5 bg-gray-300 rounded"></div>

                <div class="absolute left-0 top-1/2 h-1.5 bg-green-500 rounded progress-line"
                     style="width: {{ ($step - 1) * 33.33 }}%"></div>

                @foreach ([1 => 'Pending', 2 => 'In Progress', 3 => 'Action', 4 => 'Resolved'] as $num => $label)
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full
                            {{ $step >= $num ? 'bg-green-600 text-white ring-4 ring-white' : 'bg-gray-300 text-gray-600' }}">
                            {{ $num }}
                        </div>
                        <span class="text-xs mt-2">{{ $label }}</span>
                    </div>
                @endforeach

                @if ($report->status === 'Cancel')
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full
                            bg-red-600 text-white ring-4 ring-white">✖</div>
                        <span class="text-xs mt-2 text-red-600">Canceled</span>
                    </div>
                @endif
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4">📋 Full Report Details</h2>
        <p><strong>Title:</strong> {{ $report->title }}</p>
        <p><strong>Report ID:</strong> {{ $report->id }}</p>
        <p><strong>Reference ID:</strong> {{ $report->ref_id }}</p>
        <p><strong>Submitted On:</strong> {{ $report->created_at->format('F j, Y g:i A') }}</p>
        <p><strong>Description:</strong> {{ $report->description }}</p>
        <p><strong>Location:</strong> {{ $report->location }}</p>
    </div>

    {{-- ================= RESPONSE DETAILS ================= --}}
    <div class="bg-white p-6 rounded-lg shadow border-l-4
        {{ $response?->dispatch_unit === 'Fire' ? 'border-red-500' : '' }}
        {{ $response?->dispatch_unit === 'Flood_typhoon' ? 'border-blue-500' : '' }}
        {{ $response?->dispatch_unit === 'Earthquake' ? 'border-yellow-500' : '' }}
        {{ $response?->dispatch_unit === 'Medical' ? 'border-green-500' : '' }}
        {{ $response?->dispatch_unit === 'Traffic' ? 'border-orange-500' : '' }}
        {{ $response?->dispatch_unit === 'Workplace_Home' ? 'border-blue-700' : '' }}
    ">

        <h3 class="text-xl font-semibold mb-3">📄 Response Details</h3>

        @if (!$response)
            <p class="text-gray-600">
                Response details will appear once the admin submits a response.
            </p>
        @else
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                
                <p><strong>Response category:</strong> {{ $response->dispatch_unit }}</p>
               <!-- <p><strong>Contact Person:</strong> {{ $response->contact_person }}</p>-->
                <p><strong>Assigened Coordinator:</strong> {{ $response->overseer }}</p>
                <!-- <p><strong>Contact Number:</strong> {{ $response->contact_number }}</p> -->
                <p><strong>Response Submitted: </strong>{{ optional($response->response_datetime)->format('F d, Y • h:i A') ?? '—' }}</p>
            </div>

            <hr class="my-4">

            {{-- 🔥 FIRE --}}
            {{-- 🔥 FIRE --}}
@if ($response->dispatch_unit === 'Fire')
    <div class="p-4 bg-red-50 rounded-lg shadow-sm space-y-2">

        <h4 class="text-base font-semibold text-red-600 mb-1">
            🔥 Recorded Fire Coordination
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Evacuation Site</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->evacuation_address ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Transport Assistance</p>
                <p class="text-sm text-gray-700">
                    {{ $response->evacuation_transport ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Transport Units</p>
                <p class="text-sm text-gray-700">
                    {{ $response->evacuation_transport_unit ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->designated_hospitals ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Hospital Address</p>
                <p class="text-sm text-gray-700">
                    {{ $response->hospital_address ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Medical Assistance</p>
                <p class="text-sm font-semibold text-gray-800">
                    {{ $response->medical_response ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">PNP Station</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->pnp_station ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">PNP Team</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ $response->pnp_team_unit ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Patrol Support</p>
                <p class="text-sm text-gray-700">
                    {{ $response->pnp_patrol_unit ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Fire Department</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->fire_department ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Fire Team</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ $response->fire_team ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Fire Truck Units</p>
                <p class="text-sm text-gray-700">
                    {{ $response->fire_truck_units ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Search & Rescue Support</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->search_rescue_team ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm md:col-span-2">
                <p class="text-base font-bold text-gray-700">Relief Assistance</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->relief_goods_provider ?? '—' }}
                </p>
            </div>

        </div>
    </div>
@endif

            {{-- 🌊 FLOOD --}}
            {{-- 🌊 FLOOD / TYPHOON --}}
@if ($response->dispatch_unit === 'Flood_typhoon')
    <div class="p-4 bg-blue-50 rounded-lg shadow-sm space-y-2">

        <h4 class="text-base font-semibold text-blue-600 mb-1">
            🌊 Recorded Flood/Typhoon Coordination
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Evacuation Site</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->evacuation_address ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Transport Assistance</p>
                <p class="text-sm text-gray-700">
                    {{ $response->evacuation_transport ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Transport Units</p>
                <p class="text-sm text-gray-700">
                    {{ $response->evacuation_transport_unit ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->designated_hospitals ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Hospital Address</p>
                <p class="text-sm text-gray-700">
                    {{ $response->hospital_address ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Medical Assistance</p>
                <p class="text-sm font-semibold text-gray-800">
                    {{ $response->medical_response ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">PNP Station</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->pnp_station ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">PNP Team</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ $response->pnp_team_unit ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Patrol Support</p>
                <p class="text-sm text-gray-700">
                    {{ $response->pnp_patrol_unit ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Water Rescue Unit</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->water_rescue_response_unit ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Lifeguard Support</p>
                <p class="text-sm text-gray-700">
                    {{ $response->lifeguard_rescue_personnel ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Search & Rescue</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->search_rescue_team ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Safety & Security</p>
                <p class="text-sm text-gray-700">
                    {{ $response->safety_and_security ?? '—' }}
                </p>
            </div>

        </div>
    </div>
@endif

            {{-- 🪨 EARTHQUAKE --}}
           {{-- 🪨 EARTHQUAKE --}}
@if ($response->dispatch_unit === 'Earthquake')
    <div class="p-4 bg-yellow-50 rounded-lg shadow-sm space-y-2">

        <h4 class="text-base font-semibold text-yellow-600 mb-1">
            🪨 Recorded Earthquake Coordination
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->designated_hospitals ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Hospital Address</p>
                <p class="text-sm text-gray-700">
                    {{ $response->hospital_address ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Medical Assistance</p>
                <p class="text-sm font-semibold text-gray-800">
                    {{ $response->medical_response ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Evacuation Site</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->evacuation_address ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Transport Assistance</p>
                <p class="text-sm text-gray-700">
                    {{ $response->evacuation_transport ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Transport Units</p>
                <p class="text-sm text-gray-700">
                    {{ $response->evacuation_transport_unit ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">PNP Station</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->pnp_station ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">PNP Team</p>
                <p class="text-sm font-medium text-gray-800">
                    {{ $response->pnp_team_unit ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Patrol Support</p>
                <p class="text-sm text-gray-700">
                    {{ $response->pnp_patrol_unit ?? '—' }}
                </p>
            </div>

            <div class="bg-white rounded-lg p-3 shadow-sm">
                <p class="text-base font-bold text-gray-700">Fire Department</p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->fire_department ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Fire Team</p>
                <p class="text-sm text-gray-800">
                    {{ $response->fire_team ?? '—' }}
                </p>

                <hr class="border-gray-100 my-2">

                <p class="text-base font-bold text-gray-700">Clearing Teams</p>
                <p class="text-sm text-gray-700">
                    {{ $response->clearing_teams ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Power Utility Agency</p>
                <p class="text-sm text-gray-700">
                    {{ $response->power_utility_agency ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700 mt-2">Structural Assessment</p>
                <p class="text-sm text-gray-700">
                    {{ $response->structural_assessment_teams ?? '—' }}
                </p>
            </div>

        </div>
    </div>
@endif

            {{-- 🩺 MEDICAL --}}
@if ($response->dispatch_unit === 'Medical')

    <div class="bg-green-50 rounded-lg p-4 shadow-sm">

        <!-- Header -->
        <h4 class="text-base font-semibold text-green-600 mb-1">
            🩺 Recorded Medical Coordination
        </h4>
        <p class="text-xs text-gray-500 mb-3">
            Encoded medical and support information based on the reported situation.
        </p>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <!-- Medical / Hospital -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    Medical Authority
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->medical_response ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    Designated Hospital
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->designated_hospitals ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700">
                    Hospital Address
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->hospital_address ?? '—' }}
                </p>

            </div>

            <!-- First Aid / Ambulance -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    First Aid Station
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->first_aid_station ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    Ambulance Units (reported)
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->ambulance_units ?? '—' }}
                </p>

            </div>

            <!-- Security -->
            <div class="bg-white rounded-lg p-3 shadow-sm md:col-span-2 space-y-2">

                <p class="text-base font-bold text-gray-700">
                    PNP Station
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->pnp_station ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    PNP Team (notified)
                </p>
                <p class="text-sm font-medium text-gray-800">
                    {{ $response->pnp_team_unit ?? '—' }}
                </p>

                {{-- Patrol Units intentionally omitted from the resident display --}}
                <!--
                <p class="text-base font-bold text-gray-700">
                    PNP Patrol Units
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->pnp_patrol_unit ?? '—' }}
                </p>
                -->

            </div>

        </div>

    </div>

@endif

            {{-- 🚦 TRAFFIC --}}
@if ($response->dispatch_unit === 'Traffic')

    <div class="bg-orange-50 rounded-lg p-4 shadow-sm">

        <!-- Header -->
        <h4 class="text-base font-semibold text-orange-600 mb-1">
            🚦 Recorded Traffic Coordination
        </h4>
        <p class="text-xs text-gray-500 mb-3">
            Encoded traffic, medical, and support information based on the reported situation.
        </p>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <!-- Medical / Hospital -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    Medical Authority
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->medical_response ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    Designated Hospital
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->designated_hospitals ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700">
                    Hospital Address
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->hospital_address ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700">
                    Ambulance Units (reported)
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->ambulance_units ?? '—' }}
                </p>

            </div>

            <!-- Road / Traffic -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    Road Clearance Team
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->road_clearance_team ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    Traffic Diversion Sites
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->traffic_diversion_sites ?? '—' }}
                </p>

            </div>

            <!-- Security -->
            <div class="bg-white rounded-lg p-3 shadow-sm md:col-span-2 space-y-2">

                <p class="text-base font-bold text-gray-700">
                    PNP Station
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->pnp_station ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    PNP Team (notified)
                </p>
                <p class="text-sm font-medium text-gray-800">
                    {{ $response->pnp_team_unit ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700">
                    PNP Patrol Units (reported)
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->pnp_patrol_unit ?? '—' }}
                </p>

            </div>

        </div>

    </div>

@endif

            {{-- 🏠 WORKPLACE / HOME --}}
@if ($response->dispatch_unit === 'Workplace_Home')

    <div class="bg-blue-50 rounded-lg p-4 shadow-sm">

        <!-- Header -->
        <h4 class="text-base font-semibold text-blue-700 mb-1">
            🏠 Recorded Workplace / Home Coordination
        </h4>
        <p class="text-xs text-gray-500 mb-3">
            Encoded medical and support information based on the reported situation.
        </p>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <!-- Medical / Hospital -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    Medical Authority
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->medical_response ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    Designated Hospital
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->designated_hospitals ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700">
                    Hospital Address
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->hospital_address ?? '—' }}
                </p>

            </div>

            <!-- First Aid / Ambulance -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    First Aid Station
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->first_aid_station ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    Ambulance Units (reported)
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->ambulance_units ?? '—' }}
                </p>

            </div>

            <!-- Security -->
            <div class="bg-white rounded-lg p-3 shadow-sm md:col-span-2 space-y-2">

                <p class="text-base font-bold text-gray-700">
                    PNP Station
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->pnp_station ?? '—' }}
                </p>

                <hr class="border-gray-100">

                <p class="text-base font-bold text-gray-700">
                    PNP Team (notified)
                </p>
                <p class="text-sm font-medium text-gray-800">
                    {{ $response->pnp_team_unit ?? '—' }}
                </p>

                <p class="text-base font-bold text-gray-700">
                    PNP Patrol Units (reported)
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->pnp_patrol_unit ?? '—' }}
                </p>

            </div>

        </div>

    </div>

@endif

            {{-- 🗣 COMPLAINTS --}}
@if (in_array($response->dispatch_unit, ['Harassment', 'Noise', 'Garbage']))

    <div class="bg-purple-50 rounded-lg p-4 shadow-sm">

        <!-- Header -->
        <h4 class="text-base font-semibold text-purple-600 mb-1">
            🗣 Recorded Complaint Coordination
        </h4>
        <p class="text-xs text-gray-500 mb-3">
            Encoded administrative response based on the submitted complaint.
        </p>

        <!-- Complaint Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <!-- Responding Team -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    Responding Team
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->responding_team_complaints ?? '—' }}
                </p>

            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    Administrative Actions
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->complaints_actions ?? '—' }}
                </p>

            </div>

        </div>

    </div>

@endif

            {{-- 🛠 SERVICES --}}
@if ($response->dispatch_unit === 'Services')

    <div class="bg-green-50 rounded-lg p-4 shadow-sm">

        <!-- Header -->
        <h4 class="text-base font-semibold text-green-700 mb-1">
            🛠 Recorded Service Request Details
        </h4>
        <p class="text-xs text-gray-500 mb-3">
            Encoded service-related action based on the submitted request.
        </p>

        <!-- Service Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <!-- Inspection -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    Inspection Date
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $response->inspection_date ?? '—' }}
                </p>

            </div>

            <!-- Recommended Action -->
            <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">

                <p class="text-base font-bold text-gray-700">
                    Recommended Action
                </p>
                <p class="text-sm text-gray-700">
                    {{ $response->recommended_action ?? '—' }}
                </p>

            </div>

        </div>

    </div>

@endif
        @endif
    </div>

    {{-- ================= ACTION CONFIRM ================= --}}
    @if ($report->status === 'Action')
        <div class="bg-gray-50 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">📌 Case Resolution</h3>
            <p class="text-gray-600 mb-3">
                Our team has already taken action. If everything is resolved on your end,
                please confirm below.
            </p>

            <form method="POST" action="{{ route('reports.updateStatus', $report->id) }}">
                @csrf
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" id="resolveCheckbox" name="status" value="Resolved">
                    <span class="font-medium text-gray-700">
                        Yes, this issue has been resolved.
                    </span>
                </label>
            </form>
        </div>
    @endif

    {{-- ================= RESOLVED ================= --}}
    @if ($report->status === 'Resolved')
        <div class="bg-green-50 p-6 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-green-700 mb-2">⭐ Case Resolved</h3>
            <p class="text-gray-600 mb-4">
                We’d appreciate your feedback to help us improve our services.
            </p>
            <a href="{{ route('feedback.create', $report->id) }}"
               class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700
                      text-white rounded-md text-sm transition">
                Rate This Service
            </a>
        </div>
    @endif

    {{-- ================= CANCELED ================= --}}
    @if ($report->status === 'Cancel')
        <div class="bg-red-50 p-6 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-red-700 mb-2">❌ Report Canceled</h3>
            <p class="text-gray-700">
                Your report has been canceled due to insufficient details or review findings.
            </p>
        </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('resolveCheckbox');
    if (!checkbox) return;

    checkbox.addEventListener('change', function () {
        if (!this.checked) return;

        Swal.fire({
            title: 'Confirm Resolution',
            html: `
                <p class="text-gray-600 text-sm">
                    Are you sure this issue has been fully resolved?
                </p>
                <p class="text-xs text-green-600 mt-2">
                    This will mark the report as <strong>Resolved</strong>.
                </p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, resolve it',
            cancelButtonText: 'Not yet',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-2xl p-6',
                title: 'text-lg font-semibold',
                confirmButton:
                    'px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700',
                cancelButton:
                    'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 ml-3'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                checkbox.closest('form').submit();
            } else {
                checkbox.checked = false;
            }
        });
    });
});
</script>

@endsection
