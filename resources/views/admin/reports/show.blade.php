@extends('layouts.admin')

@section('content')
    <div x-data="{
        showModal: false,
        status: '{{ $report->status }}',
        showStatusDialog: false,
        showWarningDialog: false,
        showResolutionDialog: false,
        dispatchUnit: '{{ $report->dispatch_unit }}'
    }" class="max-w-4xl m-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">📄 Report Details</h2>
            <a href="{{ route('admin.reports') }}"
                class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                ← Back to Reports
            </a>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg space-y-6 mb-4">
            <!-- Title -->
            <div>
                <h3 class="text-2xl font-semibold text-gray-900">{{ $report->title }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Submitted on {{ $report->created_at->format('F j, Y g:i A') }}
                </p>
            </div>
            <!-- Uploaded Image -->
            @if ($report->image)
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-700 mb-2">📷 Uploaded Image</h4>

                    <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image"
                        class="w-48 h-48 object-cover rounded cursor-pointer border shadow" @click="showModal = true">
                </div>
            @endif
            <!-- Uploaded Video (NEW) -->
    @if ($report->video)
        <div class="mt-6">
            <h4 class="text-lg font-medium text-gray-700 mb-2">🎥 Uploaded Video</h4>

            <video controls class="w-64 rounded-lg border shadow">
                <source src="{{ asset('storage/' . $report->video) }}">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif

            <!-- Description -->
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-700 mb-2">📝 Description</h4>
                <p class="text-gray-800 leading-relaxed">{{ $report->description }}</p>
            </div>

            <!-- Type & Subtype -->
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-700 mb-2">📌 Report Classification</h4>

                <p><strong>Type:</strong> {{ $report->type }}</p>
                <p><strong>Subtype:</strong> {{ $report->subtype }}</p>
            </div>

            <!-- Location -->
            @if ($report->location)
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-700 mb-2">📍 Location</h4>
                    <p class="text-gray-800">{{ $report->location }}</p>
                </div>
            @endif

            <!-- Demographics (Emergencies & Accidents only) -->
            @if (in_array($report->type, ['Emergencies', 'Accidents']))
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-700 mb-2">🧑‍🤝‍🧑 Demographics</h4>

                    @if ($report->casualties)
                        <p><strong>Number of Casualties:</strong> {{ $report->casualties }}</p>
                    @endif

                    @if ($report->gender)
                        <p><strong>Gender:</strong> {{ $report->gender }}</p>
                    @endif
                </div>
            @endif

            <!-- Current Status -->
            <div>
                <h4 class="text-lg font-medium text-gray-700 mb-2">🚦 Current Status</h4>
                <span
                    class="inline-block px-3 py-1 rounded-full text-sm font-semibold 
                {{ $report->status == 'Pending'
                    ? 'bg-yellow-100 text-yellow-800'
                    : ($report->status == 'In Progress'
                        ? 'bg-blue-100 text-blue-800'
                        : 'bg-green-100 text-green-800') }}">
                    {{ $report->status }}
                </span>

                <!-- Edit Status Button -->
                <div class="mt-4">
                    <button type="button"
                        @click="
                            if (status === 'Resolved'|| status === 'Action') { 
                                showWarningDialog = true 
                            } else { 
                                showStatusDialog = true 
                            }"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                        Edit Status
                    </button>
                </div>
            </div>

            <!-- Current Resolution -->
            @if (in_array($report->status, ['Action', 'Resolved']))

            
                <div>
                    <h4 class="text-lg font-medium text-gray-700 mb-2">📝 Current Resolution</h4>

                    @if ($report->evacuation_site)
                        <p><strong>Evacuation Site:</strong> {{ $report->evacuation_site }}</p>
                    @endif

                    <p><strong>Dispatch Unit:</strong> {{ $report->dispatch_unit }}</p>
                    <p><strong>Contact Person:</strong> {{ $report->contact_person }}</p>
                    <p><strong>Overseer:</strong> {{ $report->overseer }}</p>
                    <p><strong>Contact Number:</strong> {{ $report->contact_number }}</p>

                    <!-- Natural Disasters -->
                    {{-- 🔥 FIRE RESPONSE --}}
                    @if ($report->dispatch_unit === 'Fire')
                        <h4 class="text-lg font-semibold mt-4 text-red-600">🔥 Fire Response Details</h4>

                        <p><strong>Evacuation Address:</strong> {{ $report->evacuation_address }}</p>
                        <p><strong>Medical Response:</strong> {{ $report->medical_response }}</p>

                        <p><strong>Designated Hospitals:</strong> {{ $report->designated_hospitals }}</p>
                        <p><strong>Hospital Address:</strong> {{ $report->hospital_address }}</p>
                        <p><strong>Vehicle Transport:</strong> {{ $report->evacuation_transport }}</p>
                        <p><strong>Transport Units:</strong> {{ $report->evacuation_transport_unit }}</p>
                        <p><strong>PNP Station:</strong> {{ $report->pnp_station }}</p>
                        <p><strong>PNP Team:</strong> {{ $report->pnp_team_unit }}</p>
                        <p><strong>PNP Patrol Units:</strong> {{ $report->pnp_patrol_unit }}</p>
                        <p><strong>Relief Goods Provider:</strong> {{ $report->relief_goods_provider }}</p>
                        <p><strong>Fire Department:</strong> {{ $report->fire_department }}</p>
                        <p><strong>Fire Team:</strong> {{ $report->fire_team }}</p>
                        <p><strong>Fire Truck Units:</strong> {{ $report->fire_truck_units }}</p>
                        <p><strong>Search & Rescue Team:</strong> {{ $report->search_rescue_team }}</p>
                    @endif


                    {{-- 🌊 FLOOD & TYPHOON RESPONSE --}}
                    @if ($report->dispatch_unit === 'Flood_typhoon')
                        <h4 class="text-lg font-semibold mt-4 text-blue-600">🌊 Flood & Typhoon Response Details</h4>

                        <p><strong>Evacuation Address:</strong> {{ $report->evacuation_address }}</p>
                        <p><strong>Medical Response:</strong> {{ $report->medical_response }}</p>

                        <p><strong>Designated Hospitals:</strong> {{ $report->designated_hospitals }}</p>
                        <p><strong>Hospital Address:</strong> {{ $report->hospital_address }}</p>
                        <p><strong>Vehicle Transport:</strong> {{ $report->evacuation_transport }}</p>
                        <p><strong>Transport Units:</strong> {{ $report->evacuation_transport_unit }}</p>
                        <p><strong>Water Rescue Unit:</strong> {{ $report->water_rescue_response_unit }}</p>
                        <p><strong>Rubber Boats:</strong> {{ $report->rubber_boat_units }}</p>
                        <p><strong>Lifeguard Team:</strong> {{ $report->lifeguard_rescue_personnel }}</p>
                        <p><strong>Search & Rescue Team:</strong> {{ $report->search_rescue_team }}</p>
                        <p><strong>Safety & Security:</strong> {{ $report->safety_and_security }}</p>
                        <p><strong>Relief Welfare:</strong> {{ $report->relief_welfare }}</p>
                    @endif


                    {{-- 🪨 EARTHQUAKE RESPONSE --}}
                    @if ($report->dispatch_unit === 'Earthquake')
                        <h4 class="text-lg font-semibold mt-4 text-yellow-600">🪨 Earthquake Response Details</h4>

                        <p><strong>Designated Hospitals:</strong> {{ $report->designated_hospitals }}</p>
                        <p><strong>Hospital Address:</strong> {{ $report->hospital_address }}</p>
                        <p><strong>Evacuation Address:</strong> {{ $report->evacuation_address }}</p>
                        <p><strong>Vehicle Transport:</strong> {{ $report->evacuation_transport }}</p>
                        <p><strong>Transport Units:</strong> {{ $report->evacuation_transport_unit }}</p>
                        <p><strong>PNP Station:</strong> {{ $report->pnp_station }}</p>
                        <p><strong>PNP Team:</strong> {{ $report->pnp_team_unit }}</p>
                        <p><strong>Fire Department:</strong> {{ $report->fire_department }}</p>
                        <p><strong>Fire Team:</strong> {{ $report->fire_team }}</p>
                        <p><strong>Fire Truck Units:</strong> {{ $report->fire_truck_units }}</p>
                        <p><strong>Search & Rescue Team:</strong> {{ $report->search_rescue_team }}</p>
                        <p><strong>Clearing Teams:</strong> {{ $report->clearing_teams }}</p>
                        <p><strong>Power Utility Agency:</strong> {{ $report->power_utility_agency }}</p>
                        <p><strong>Structural Assessment Teams:</strong> {{ $report->structural_assessment_teams }}</p>
                    @endif


                    {{-- 🩺 MEDICAL RESPONSE --}}
                    @if ($report->dispatch_unit === 'Medical')
                        <h4 class="text-lg font-semibold mt-4 text-green-600">🩺 Medical Response Details</h4>

                        <p><strong>Medical Response:</strong> {{ $report->medical_response }}</p>
                        <p><strong>Designated Hospitals:</strong> {{ $report->designated_hospitals }}</p>
                        <p><strong>Hospital Address:</strong> {{ $report->hospital_address }}</p>
                        <p><strong>First Aid Station:</strong> {{ $report->first_aid_station }}</p>
                        <p><strong>Vehicle Transport:</strong> {{ $report->evacuation_transport }}</p>
                        <p><strong>Ambulance Units:</strong> {{ $report->evacuation_transport_unit }}</p>
                    @endif

                    <!-- Accidents -->
                    {{-- 🚦 Traffic RESPONSE --}}
                    @if ($report->dispatch_unit === 'Traffic')
                        <h4 class="text-lg font-semibold mt-4 text-green-600">🚦 Traffic Response Details</h4>

                        <p><strong>Medical Response:</strong> {{ $report->medical_response }}</p>
                        <p><strong>Designated Hospitals:</strong> {{ $report->designated_hospitals }}</p>
                        <p><strong>Hospital Address:</strong> {{ $report->hospital_address }}</p>
                        <p><strong>Ambulance Units:</strong> {{ $report->ambulance_units }}</p>

                        <p><strong>Road Clearance team:</strong> {{ $report->road_clearance_team }}</p>
                        <p><strong>Traffic Diversion Sitest:</strong> {{ $report->traffic_diversion_sites }}</p>
                        <p><strong>PNP Station:</strong> {{ $report->pnp_station }}</p>
                        <p><strong>PNP Team:</strong> {{ $report->pnp_team_unit }}</p>
                        <p><strong>PNP Patrol Units:</strong> {{ $report->pnp_patrol_unit }}</p>
                    @endif

                    {{-- 🛠️🏠 Workplace / Home RESPONSE --}}
                    @if ($report->dispatch_unit === 'Workplace_Home')
                        <h4 class="text-lg font-semibold mt-4 text-green-600">🛠️🏠 Workplace / Home Response Details</h4>

                        <p><strong>Medical Response:</strong> {{ $report->medical_response }}</p>
                        <p><strong>Designated Hospitals:</strong> {{ $report->designated_hospitals }}</p>
                        <p><strong>Hospital Address:</strong> {{ $report->hospital_address }}</p>
                        <p><strong>Ambulance Units:</strong> {{ $report->ambulance_units }}</p>
                        <p><strong>First aid station:</strong> {{ $report->first_aid_station }}</p>
                        <p><strong>PNP Station:</strong> {{ $report->pnp_station }}</p>
                        <p><strong>PNP Team:</strong> {{ $report->pnp_team_unit }}</p>
                        <p><strong>PNP Patrol Units:</strong> {{ $report->pnp_patrol_unit }}</p>
                    @endif
                    <!-- Complaints -->
                    @if ($report->dispatch_unit === 'Harassment')
                        <h4 class="text-lg font-semibold mt-4 text-green-600">🛠️🏠 Workplace / Home Response Details</h4>

                        <p><strong>Responding Team:</strong> {{ $report->responding_team_complaints }}</p>
                        <p><strong>Actions:</strong> {{ $report->complaints_actions }}</p>
                        <p><strong>PNP Station:</strong> {{ $report->pnp_station }}</p>
                        <p><strong>PNP Team:</strong> {{ $report->pnp_team_unit }}</p>
                        <p><strong>PNP Patrol Units:</strong> {{ $report->pnp_patrol_unit }}</p>
                    @endif

                    @if ($report->dispatch_unit === 'Noise')
                        <h4 class="text-lg font-semibold mt-4 text-green-600">🛠️🏠 Workplace / Home Response Details</h4>

                        <p><strong>Responding Team:</strong> {{ $report->responding_team_complaints }}</p>
                        <p><strong>Recommended Actions:</strong> {{ $report->complaints_actions }}</p>
                    @endif

                    @if ($report->dispatch_unit === 'Garbage')
                        <h4 class="text-lg font-semibold mt-4 text-green-600">🛠️🏠 Workplace / Home Response Details</h4>

                        <p><strong>Responding Team:</strong> {{ $report->responding_team_complaints }}</p>
                        <p><strong>Recommended Actions:</strong> {{ $report->complaints_actions }}</p>
                    @endif

                    @if ($report->dispatch_unit === 'Services')
                        <h4 class="text-lg font-semibold mt-4 text-green-600">🛠️🏠 Workplace / Home Response Details</h4>

                        <p><strong>Responding Team:</strong> {{ $report->responding_team_complaints }}</p>
                        <p><strong>Inspection date:</strong> {{ $report->inspection_date }}</p>
                        <p><strong>Recommended Actions:</strong> {{ $report->recommended_action }}</p>
                    @endif
                    <!-- Suggestions -->
                    <!-- Edit Resolution Button -->
                    <div class="mt-4">
                        <button type="button" @click="showResolutionDialog = true"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                            Edit Resolution
                        </button>
                    </div>

                </div>
            @endif

        </div>

        <!-- Warning Dialog (if status is Resolved) -->
        <div x-show="showWarningDialog" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold mb-4">⚠️ Warning</h3>
                <p class="mb-4">Changing the status will delete the resolution details. Continue?</p>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showWarningDialog = false"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="button" @click="showWarningDialog = false; showStatusDialog = true; status='Pending';"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Yes, continue
                    </button>
                </div>
            </div>
        </div>

        <!-- Status Update Dialog -->
        <div x-show="showStatusDialog" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md"> <!-- width seal -->
                <div class="p-6 max-h-[80vh] overflow-y-auto"> <!-- height seal -->
                    <h3 class="text-lg font-semibold mb-4">Update Status</h3>
                    <form method="POST" action="{{ route('admin.reports.updateStatus', $report->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Hidden input ensures status is always sent -->
                        <input type="hidden" name="status" x-bind:value="status">

                        <template x-if="status !== 'Resolved'">
                            <select name="status_select" class="w-full border p-3 rounded-lg mb-4" x-model="status">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Action">Action</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Cancel">Cancel</option>

                            </select>
                        </template>

                        <div x-show="status === 'Resolved' || status === 'Action'">
                            @include('admin.reports.resolution')
                        </div>

                        <div class="flex justify-end gap-3 mt-4">
                            <button type="button" @click="showStatusDialog = false"
                                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Confirm
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- Resolution Edit Dialog -->
        <div x-show="showResolutionDialog" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md"> <!-- width seal -->
                <div class="p-6 max-h-[80vh] overflow-y-auto"> <!-- height seal -->

                    <h3 class="text-lg font-semibold mb-4">Edit Resolution</h3>
                    <form method="POST" action="{{ route('admin.reports.updateResolution', $report->id) }}">
                        @csrf
                        @method('PUT')

                        @include('admin.reports.resolution')

                        <div class="flex justify-end gap-3 mt-4">
                            <button type="button" @click="showResolutionDialog = false"
                                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for full image -->
        @if ($report->image)
            <div x-show="showModal" x-transition
                class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
                @click.self="showModal = false">
                <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl w-full relative">
                    <button @click="showModal = false"
                        class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">
                        ✕
                    </button>
                    <img src="{{ asset('storage/' . $report->image) }}" alt="Full Image"
                        class="w-full max-h-[80vh] object-contain rounded">
                </div>
            </div>
        @endif

    </div>
@endsection
