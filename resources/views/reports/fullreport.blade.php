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
        <p><strong>Status:</strong> {{ $report->status }}</p>
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
                <p><strong>Contact Person:</strong> {{ $response->contact_person }}</p>
                <p><strong>Overseer:</strong> {{ $response->overseer }}</p>
                <p><strong>Contact Number:</strong> {{ $response->contact_number }}</p>
                <p><strong>Response Submitted: </strong>{{ optional($response->response_datetime)->format('F d, Y • h:i A') ?? '—' }}</p>
            </div>

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

            {{-- 🪨 EARTHQUAKE --}}
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

            {{-- 🩺 MEDICAL --}}
            @if ($response->dispatch_unit === 'Medical')
                <h4 class="text-lg font-semibold text-green-600">🩺 Medical Response</h4>
                <p><strong>Medical Response:</strong> {{ $response->medical_response }}</p>
                <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals }}</p>
                <p><strong>Hospital Address:</strong> {{ $response->hospital_address }}</p>
                <p><strong>First Aid Station:</strong> {{ $response->first_aid_station }}</p>
                <p><strong>Ambulance Units:</strong> {{ $response->ambulance_units }}</p>
            @endif

            {{-- 🚦 TRAFFIC --}}
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

            {{-- 🏠 WORKPLACE / HOME --}}
            @if ($response->dispatch_unit === 'Workplace_Home')
                <h4 class="text-lg font-semibold text-blue-700">🏠 Workplace / Home Response</h4>
                <p><strong>Medical Response:</strong> {{ $response->medical_response }}</p>
                <p><strong>Hospitals:</strong> {{ $response->designated_hospitals }}</p>
                <p><strong>Hospital Address:</strong> {{ $response->hospital_address }}</p>
                <p><strong>Ambulance Units:</strong> {{ $response->ambulance_units }}</p>
                <p><strong>First Aid:</strong> {{ $response->first_aid_station }}</p>
                <p><strong>PNP Station:</strong> {{ $response->pnp_station }}</p>
                <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit }}</p>
                <p><strong>PNP Patrol Units:</strong> {{ $response->pnp_patrol_unit }}</p>
            @endif

            {{-- 🗣 COMPLAINTS --}}
            @if (in_array($response->dispatch_unit, ['Harassment','Noise','Garbage']))
                <h4 class="text-lg font-semibold text-purple-600">🗣 Complaint Details</h4>
                <p><strong>Responding Team:</strong> {{ $response->responding_team_complaints }}</p>
                <p><strong>Actions:</strong> {{ $response->complaints_actions }}</p>
            @endif

            {{-- 🛠 SERVICES --}}
            @if ($response->dispatch_unit === 'Services')
                <h4 class="text-lg font-semibold text-green-700">🛠 Service Request</h4>
                <p><strong>Inspection Date:</strong> {{ $response->inspection_date }}</p>
                <p><strong>Recommended Action:</strong> {{ $response->recommended_action }}</p>
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
