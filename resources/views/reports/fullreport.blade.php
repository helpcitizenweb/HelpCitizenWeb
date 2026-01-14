@extends('layouts.app')

@section('content')

@php
    $step = match($report->status) {
        'Pending' => 1,
        'In Progress' => 2,
        'Action' => 3,
        'Resolved' => 4,
        default => 1
    };

    $response = $report->response;   // 🔥 MAIN FIX: Shortcut for readability
@endphp

<style>
    .progress-line { transition: width 0.8s ease-in-out; }
    .fade-in { animation: fadeIn 0.6s ease-in-out forwards; opacity: 0; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px);} to { opacity: 1; transform: translateY(0);} }
    .pulse { animation: pulse 1.6s infinite ease-in-out; }
    @keyframes pulse { 0%{transform:scale(1);} 50%{transform:scale(1.15);} 100%{transform:scale(1);} }
</style>


<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    <!-- Progress Bar -->
    <div class="max-w-2xl mx-auto my-8 fade-in">
        <div class="relative pt-4">

            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-300 rounded"></div>

            <div class="absolute top-1/2 left-0 h-1 bg-green-500 rounded progress-line"
                 style="width: {{ ($step - 1) * 33.33 }}%">
            </div>

            <div class="flex justify-between relative z-10">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                    {{ $step >= 1 ? 'bg-green-600 text-white pulse' : 'bg-gray-300 text-gray-600' }}">1</div>
                    <p class="text-xs mt-2">Pending</p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                    {{ $step >= 2 ? 'bg-green-600 text-white pulse' : 'bg-gray-300 text-gray-600' }}">2</div>
                    <p class="text-xs mt-2">In Progress</p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                    {{ $step >= 3 ? 'bg-green-600 text-white pulse' : 'bg-gray-300 text-gray-600' }}">3</div>
                    <p class="text-xs mt-2">Action</p>
                </div>

                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                    {{ $step >= 4 ? 'bg-green-600 text-white pulse' : 'bg-gray-300 text-gray-600' }}">4</div>
                    <p class="text-xs mt-2">Resolved</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Main Info -->
    <h2 class="text-2xl font-bold mb-4">Full Report Details</h2>

    <p><strong>Title:</strong> {{ $report->title }}</p>
    <p><strong>Status:</strong> {{ $report->status }}</p>
    <p><strong>Submitted On:</strong> {{ $report->created_at->format('F j, Y g:i A') }}</p>
    <p><strong>Description:</strong> {{ $report->description }}</p>

    



    <hr class="my-4">

    <!-- Response Section -->
    <h3 class="text-xl font-semibold mb-3">📄 Response Details</h3>

    @if (!$response)
        <p class="text-gray-600">Response details will appear once the admin submits a response.</p>
    @else

        <p><strong>Dispatch Unit:</strong> {{ $response->dispatch_unit }}</p>
        <p><strong>Contact Person:</strong> {{ $response->contact_person }}</p>
        <p><strong>Overseer:</strong> {{ $response->overseer }}</p>
        <p><strong>Contact Number:</strong> {{ $response->contact_number }}</p>

        <hr class="my-4">

        {{-- 🔥 FIRE --}}
        @if ($response->dispatch_unit === 'Fire')
            <h4 class="text-lg font-semibold text-red-600">🔥 Fire Response</h4>
            <p><strong>Evacuation Address:</strong> {{ $response->evacuation_address }}</p>
            <p><strong>Medical Response:</strong> {{ $response->medical_response }}</p>
            <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals }}</p>
            <p><strong>Hospital Address:</strong> {{ $response->hospital_address }}</p>
            <p><strong>Vehicle Transport:</strong> {{ $response->evacuation_transport }}</p>
            <p><strong>Transport Units:</strong> {{ $response->evacuation_transport_unit }}</p>
            <p><strong>PNP Station:</strong> {{ $response->pnp_station }}</p>
            <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit }}</p>
            <p><strong>PNP Patrol Units:</strong> {{ $response->pnp_patrol_unit }}</p>
            <p><strong>Relief Goods Provider:</strong> {{ $response->relief_goods_provider }}</p>
            <p><strong>Fire Department:</strong> {{ $response->fire_department }}</p>
            <p><strong>Fire Team:</strong> {{ $response->fire_team }}</p>
            <p><strong>Fire Truck Units:</strong> {{ $response->fire_truck_units }}</p>
            <p><strong>Search & Rescue Team:</strong> {{ $response->search_rescue_team }}</p>
        @endif

        {{-- 🌊 FLOOD --}}
        @if ($response->dispatch_unit === 'Flood_typhoon')
            <h4 class="text-lg font-semibold text-blue-600">🌊 Flood Response</h4>
            <p><strong>Evacuation Address:</strong> {{ $response->evacuation_address }}</p>
            <p><strong>Medical Response:</strong> {{ $response->medical_response }}</p>
            <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals }}</p>
            <p><strong>Hospital Address:</strong> {{ $response->hospital_address }}</p>
            <p><strong>Transport:</strong> {{ $response->evacuation_transport }}</p>
            <p><strong>Transport Units:</strong> {{ $response->evacuation_transport_unit }}</p>
            <p><strong>Water Rescue Unit:</strong> {{ $response->water_rescue_response_unit }}</p>
            <p><strong>Rubber Boats:</strong> {{ $response->rubber_boat_units }}</p>
            <p><strong>Lifeguards:</strong> {{ $response->lifeguard_rescue_personnel }}</p>
            <p><strong>Search & Rescue:</strong> {{ $response->search_rescue_team }}</p>
            <p><strong>Safety & Security:</strong> {{ $response->safety_and_security }}</p>
            <p><strong>Relief Welfare:</strong> {{ $response->relief_welfare }}</p>
        @endif

        {{-- EARTHQUAKE --}}
        @if ($response->dispatch_unit === 'Earthquake')
            <h4 class="text-lg font-semibold text-yellow-600">🪨 Earthquake Response</h4>
            <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals }}</p>
            <p><strong>Hospital Address:</strong> {{ $response->hospital_address }}</p>
            <p><strong>Evacuation Address:</strong> {{ $response->evacuation_address }}</p>
            <p><strong>Vehicle Transport:</strong> {{ $response->evacuation_transport }}</p>
            <p><strong>Transport Units:</strong> {{ $response->evacuation_transport_unit }}</p>
            <p><strong>PNP Station:</strong> {{ $response->pnp_station }}</p>
            <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit }}</p>
            <p><strong>Fire Department:</strong> {{ $response->fire_department }}</p>
            <p><strong>Fire Team:</strong> {{ $response->fire_team }}</p>
            <p><strong>Clearing Teams:</strong> {{ $response->clearing_teams }}</p>
            <p><strong>Power Utility Agency:</strong> {{ $response->power_utility_agency }}</p>
            <p><strong>Structural Assessment:</strong> {{ $response->structural_assessment_teams }}</p>
        @endif

        {{-- MEDICAL --}}
        @if ($response->dispatch_unit === 'Medical')
            <h4 class="text-lg font-semibold text-green-600">🩺 Medical Response</h4>
            <p><strong>Medical Response:</strong> {{ $response->medical_response }}</p>
            <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals }}</p>
            <p><strong>Hospital Address:</strong> {{ $response->hospital_address }}</p>
            <p><strong>First Aid Station:</strong> {{ $response->first_aid_station }}</p>
            <p><strong>Ambulance Units:</strong> {{ $response->ambulance_units }}</p>
        @endif

        {{-- TRAFFIC --}}
        @if ($response->dispatch_unit === 'Traffic')
            <h4 class="text-lg font-semibold text-orange-600">🚦 Traffic Response</h4>
            <p><strong>Medical Response:</strong> {{ $response->medical_response }}</p>
            <p><strong>Hospitals:</strong> {{ $response->designated_hospitals }}</p>
            <p><strong>Hospital Address:</strong> {{ $response->hospital_address }}</p>
            <p><strong>Ambulance Units:</strong> {{ $response->ambulance_units }}</p>
            <p><strong>Road Clearance Team:</strong> {{ $response->road_clearance_team }}</p>
            <p><strong>Traffic Diversion Sites:</strong> {{ $response->traffic_diversion_sites }}</p>
            <p><strong>PNP Station:</strong> {{ $response->pnp_station }}</p>
            <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit }}</p>
            <p><strong>PNP Patrol Units:</strong> {{ $response->pnp_patrol_unit }}</p>
        @endif

        {{-- WORKPLACE/HOME --}}
        @if ($response->dispatch_unit === 'Workplace_Home')
            <h4 class="text-lg font-semibold text-blue-700">🏠 Workplace/Home Response</h4>
            <p><strong>Medical Response:</strong> {{ $response->medical_response }}</p>
            <p><strong>Hospitals:</strong> {{ $response->designated_hospitals }}</p>
            <p><strong>Hospital Address:</strong> {{ $response->hospital_address }}</p>
            <p><strong>Ambulance Units:</strong> {{ $response->ambulance_units }}</p>
            <p><strong>First Aid:</strong> {{ $response->first_aid_station }}</p>
            <p><strong>PNP Station:</strong> {{ $response->pnp_station }}</p>
            <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit }}</p>
            <p><strong>PNP Patrol Units:</strong> {{ $response->pnp_patrol_unit }}</p>
        @endif

        {{-- COMPLAINTS --}}
        @if (in_array($response->dispatch_unit, ['Harassment','Noise','Garbage']))
            <h4 class="text-lg font-semibold mt-4 text-purple-600">🗣 Complaint Details</h4>

            <p><strong>Responding Team:</strong> {{ $response->responding_team_complaints }}</p>
            <p><strong>Actions:</strong> {{ $response->complaints_actions }}</p>

            @if ($response->pnp_station)
                <p><strong>PNP Station:</strong> {{ $response->pnp_station }}</p>
            @endif

            @if ($response->pnp_team_unit)
                <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit }}</p>
            @endif
        @endif

        {{-- SERVICES --}}
        @if ($response->dispatch_unit === 'Services')
            <h4 class="text-lg font-semibold text-green-600">🛠 Service Request</h4>
            <p><strong>Inspection Date:</strong> {{ $response->inspection_date }}</p>
            <p><strong>Recommended Action:</strong> {{ $response->recommended_action }}</p>
        @endif

    @endif

    {{-- Resident Resolution Confirmation --}}
@if ($report->status === 'Action')
    <div class="mt-6 p-4 border rounded bg-gray-50">

        <h3 class="text-lg font-semibold mb-2">📌 Case Resolution</h3>

        <p class="text-gray-600 mb-3">
            Our team has already taken action.  
            If everything is resolved on your end, please confirm below.
        </p>

        <form method="POST" action="{{ route('reports.updateStatus', $report->id) }}">
            @csrf

            <label class="inline-flex items-center space-x-2">
                <input type="checkbox"
       name="status"
       value="Resolved"
       onchange="
           if(confirm('Are you sure this issue has been fully resolved?')) {
               this.form.submit();
           } else {
               this.checked = false;
           }
       ">

                <span class="font-medium text-gray-700">Yes, this issue has been resolved.</span>
            </label>
        </form>

    </div>
@endif
{{-- Resident Feedback Button --}}
@if ($report->status === 'Resolved')
    <div class="mt-6 p-4 border rounded bg-green-50 text-center">

        <h3 class="text-lg font-semibold text-green-700 mb-2">
            ⭐ Case Resolved
        </h3>

        <p class="text-gray-600 mb-4">
            Your report has been successfully resolved.  
            We’d appreciate your feedback to help us improve our services.
        </p>

        <a href="{{ route('feedback.create', $report->id) }}"
           class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm transition">
            Rate This Service
        </a>

    </div>
@endif

</div>

@endsection
