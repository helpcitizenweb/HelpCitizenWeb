<div class="space-y-6">

    <hr class="my-4">

    <!-- Response Section -->
    <h3 class="text-2xl font-bold mb-4 text-gray-800">📄 Response Details</h3>

    @if (!$response)
        <div class="text-gray-500 italic">No response yet.</div>
    @else
        <!-- General Info Card -->
        <div class="p-4 bg-gray-50 rounded-lg shadow-sm space-y-2">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">👤 General Information</h4>
            <p><strong>Dispatch Unit:</strong> {{ $response->dispatch_unit ?? '—' }}</p>
            <!--<p><strong>Responder/Contact Person:</strong> {{ $response->contact_person ?? '—' }}</p>-->
            <p><strong>Assigned Coordinator:</strong> {{ $response->overseer ?? '—' }}</p>
            <!-- <p><strong>Contact Number: </strong> {{ $response->contact_number ?? '—' }}</p>-->
            <p>
                <strong>Response Submitted:</strong>
                {{ optional($response->response_datetime)->format('F d, Y • h:i A') ?? '—' }}
            </p>
        </div>

        <!--Fire Response -->
        @if ($response->dispatch_unit === 'Fire')
            <div class="bg-red-50 border border-red-100 rounded-xl p-4">

                <!-- Header -->
                <h4 class="text-base font-semibold text-red-600 mb-1">
                    🔥 Recorded Fire Coordination Details
                </h4>
                <p class="text-xs text-gray-500 mb-3">
                    Encoded coordination details based on the reported situation.
                </p>

                <!-- Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <!-- Evacuation -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Evacuation Site</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->evacuation_address ?? '—' }}
                        </p>
                        <hr class="border-gray-100">
                        <p class="text-base font-bold text-gray-700">Transport Support</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->evacuation_transport ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Transport Units (reported)</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->evacuation_transport_unit ?? '—' }}
                        </p>
                    </div>

                    <!-- Medical -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->designated_hospitals ?? '—' }}
                        </p>
                        <p class="text-base font-bold text-gray-700">Hospital Address</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->hospital_address ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">Medical Team (as recorded)</p>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $response->medical_response ?? '—' }}
                        </p>
                    </div>

                    <!-- Security -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">PNP Station</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->pnp_station ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">PNP Team (notified)</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $response->pnp_team_unit ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Patrol Support (if any)</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->pnp_patrol_unit ?? '—' }}
                        </p>
                    </div>

                    <!-- Fire Coordination -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Fire Department</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->fire_department ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">Fire Team (as recorded)</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $response->fire_team ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Fire Trucks (reported)</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $response->fire_truck_units ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Rescue Team</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->search_rescue_team ?? '—' }}
                        </p>
                    </div>

                    <!-- Support -->
                    <div class="bg-white rounded-lg p-3 shadow-sm md:col-span-2 space-y-1">
                        <p class="text-base font-bold text-gray-700">Relief Goods Provider</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->relief_goods_provider ?? '—' }}
                        </p>
                    </div>

                </div>
            </div>
        @endif

        <!--Flood/Typhoon Response -->
        @if ($response->dispatch_unit === 'Flood_typhoon')
            <div class="bg-blue-50 border border-red-100 rounded-xl p-4">
                <!-- Header -->
                <h4 class="text-base font-semibold text-blue-600 mb-1">
                    🌊 Recorded Flood/Typhoon Coordination Details
                </h4>
                <p class="text-xs text-gray-500 mb-3">
                    Encoded coordination details based on the reported situation.
                </p>

                <!-- Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <!-- Evacuation -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Evacuation Site</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->evacuation_address ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">Transport Support</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->evacuation_transport ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Transport Units (reported)</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->evacuation_transport_unit ?? '—' }}
                        </p>
                    </div>

                    <!-- Medical -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->designated_hospitals ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Hospital Address</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->hospital_address ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">Medical Team (as recorded)</p>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $response->medical_response ?? '—' }}
                        </p>
                    </div>

                    <!-- Security -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">PNP Station</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->pnp_station ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">PNP Team (notified)</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $response->pnp_team_unit ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Patrol Support (if any)</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->pnp_patrol_unit ?? '—' }}
                        </p>
                    </div>

                    <!-- Water & Rescue -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Water Rescue Unit (reported)</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->water_rescue_response_unit ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">Lifeguard Support</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->lifeguard_rescue_personnel ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Search & Rescue Team</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->search_rescue_team ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Safety & Security</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->safety_and_security ?? '—' }}
                        </p>
                    </div>

                </div>

            </div>
        @endif

        <!--Earthquake Response -->
        @if ($response->dispatch_unit === 'Earthquake')
            <!-- Container with yellow background -->
            <div class="p-4 bg-yellow-50 rounded-lg">

                <!-- Header -->
                <h4 class="text-base font-semibold text-yellow-600 mb-1">
                    🪨 Recorded Earthquake Coordination Details
                </h4>
                <p class="text-xs text-gray-500 mb-3">
                    Encoded coordination details based on the reported situation.
                </p>

                <!-- Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <!-- Medical -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->designated_hospitals ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Hospital Address</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->hospital_address ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">Medical Team (as recorded)</p>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $response->medical_response ?? '—' }}
                        </p>
                    </div>

                    <!-- Evacuation -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Evacuation Site</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->evacuation_address ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">Transport Support</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->evacuation_transport ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Transport Units (reported)</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->evacuation_transport_unit ?? '—' }}
                        </p>
                    </div>

                    <!-- Security -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">PNP Station</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->pnp_station ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">PNP Team (notified)</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $response->pnp_team_unit ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Patrol Support (if any)</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->pnp_patrol_unit ?? '—' }}
                        </p>
                    </div>

                    <!-- Fire & Clearing -->
                    <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
                        <p class="text-base font-bold text-gray-700">Fire Department (coordinated)</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->fire_department ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Fire Team (as recorded)</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $response->fire_team ?? '—' }}
                        </p>

                        <hr class="border-gray-100">

                        <p class="text-base font-bold text-gray-700">Clearing Teams</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->clearing_teams ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Power Utility Agency</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->power_utility_agency ?? '—' }}
                        </p>

                        <p class="text-base font-bold text-gray-700">Structural Assessment Teams</p>
                        <p class="text-sm text-gray-700">
                            {{ $response->structural_assessment_teams ?? '—' }}
                        </p>
                    </div>

                    <!-- Support -->
                    <div class="bg-white rounded-lg p-3 shadow-sm md:col-span-2 space-y-1">
                        <p class="text-base font-bold text-gray-700">Relief Goods Provider</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $response->relief_goods_provider ?? '—' }}
                        </p>
                    </div>

                </div>
            </div>
        @endif

        <!--Medical Response -->
       @if ($response->dispatch_unit === 'Medical')

<!-- Container with green background -->
<div class="p-4 bg-green-50 rounded-lg">

    <!-- Header -->
    <h4 class="text-base font-semibold text-green-600 mb-1">
        🩺 Recorded Medical Coordination Details
    </h4>
    <p class="text-xs text-gray-500 mb-3">
        Encoded coordination details based on the reported situation.
    </p>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <!-- Hospital & Medical -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->designated_hospitals ?? '—' }}
            </p>

            <p class="text-base font-bold text-gray-700">Hospital Address</p>
            <p class="text-sm text-gray-700">
                {{ $response->hospital_address ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Medical Team (as recorded)</p>
            <p class="text-sm font-semibold text-gray-800">
                {{ $response->medical_response ?? '—' }}
            </p>
        </div>

        <!-- Emergency Support -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">First Aid Station</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->first_aid_station ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Ambulance Units (reported)</p>
            <p class="text-sm text-gray-700">
                {{ $response->ambulance_units ?? '—' }}
            </p>
        </div>

        <!-- Security -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">PNP Station</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->pnp_station ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Police Team (notified)</p>
            <p class="text-sm font-medium text-gray-800">
                {{ $response->pnp_team_unit ?? '—' }}
            </p>
        </div>

    </div>
</div>

@endif

        <!--Traffic Response -->
       @if ($response->dispatch_unit === 'Traffic')

<!-- Container with orange background -->
<div class="p-4 bg-orange-50 rounded-lg">

    <!-- Header -->
    <h4 class="text-base font-semibold text-orange-600 mb-1">
        🚦 Recorded Traffic Coordination Details
    </h4>
    <p class="text-xs text-gray-500 mb-3">
        Encoded coordination details based on the reported situation.
    </p>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <!-- Medical -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->designated_hospitals ?? '—' }}
            </p>

            <p class="text-base font-bold text-gray-700">Hospital Address</p>
            <p class="text-sm text-gray-700">
                {{ $response->hospital_address ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Medical Team (as recorded)</p>
            <p class="text-sm font-semibold text-gray-800">
                {{ $response->medical_response ?? '—' }}
            </p>

            <p class="text-base font-bold text-gray-700">Ambulance Units (reported)</p>
            <p class="text-sm text-gray-700">
                {{ $response->ambulance_units ?? '—' }}
            </p>
        </div>

        <!-- Traffic Control -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">Road Management Status</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->road_clearance_team ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Traffic Diversion (if any)</p>
            <p class="text-sm text-gray-700">
                {{ $response->traffic_diversion_sites ?? '—' }}
            </p>
        </div>

        <!-- Security -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">PNP Station</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->pnp_station ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Police Team (notified)</p>
            <p class="text-sm font-medium text-gray-800">
                {{ $response->pnp_team_unit ?? '—' }}
            </p>

            <p class="text-base font-bold text-gray-700">Patrol Support (if any)</p>
            <p class="text-sm text-gray-700">
                {{ $response->pnp_patrol_unit ?? '—' }}
            </p>
        </div>

    </div>
</div>
@endif

        <!--Workplace/Home -->
       @if ($response->dispatch_unit === 'Workplace_Home')

<!-- Container with blue background -->
<div class="p-4 bg-blue-50 rounded-lg">

    <!-- Header -->
    <h4 class="text-base font-semibold text-blue-700 mb-1">
        🏠 Recorded Workplace/Home Coordination Details
    </h4>
    <p class="text-xs text-gray-500 mb-3">
        Encoded coordination details based on the reported situation.
    </p>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <!-- Medical -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">Receiving Hospital</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->designated_hospitals ?? '—' }}
            </p>

            <p class="text-base font-bold text-gray-700">Hospital Address</p>
            <p class="text-sm text-gray-700">
                {{ $response->hospital_address ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Medical Team (as recorded)</p>
            <p class="text-sm font-semibold text-gray-800">
                {{ $response->medical_response ?? '—' }}
            </p>
        </div>

        <!-- Emergency Support -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">First Aid Station</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->first_aid_station ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Ambulance Units (reported)</p>
            <p class="text-sm text-gray-700">
                {{ $response->ambulance_units ?? '—' }}
            </p>
        </div>

        <!-- Security -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">PNP Station</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->pnp_station ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Police Team (notified)</p>
            <p class="text-sm font-medium text-gray-800">
                {{ $response->pnp_team_unit ?? '—' }}
            </p>

            <p class="text-base font-bold text-gray-700">Patrol Support (if any)</p>
            <p class="text-sm text-gray-700">
                {{ $response->pnp_patrol_unit ?? '—' }}
            </p>
        </div>

    </div>
</div>

@endif

        <!--Complaints -->
       @if (in_array($response->dispatch_unit, ['Harassment', 'Noise', 'Garbage']))

<!-- Container with purple background -->
<div class="p-4 bg-purple-50 rounded-lg">

    <!-- Header -->
    <h4 class="text-base font-semibold text-purple-600 mb-1">
        🗣 Recorded Complaint Coordination Details
    </h4>
    <p class="text-xs text-gray-500 mb-3">
        Encoded administrative response based on the submitted complaint.
    </p>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <!-- Complaint Handling -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">Responding Team</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->responding_team_complaints ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Actions Taken (as recorded)</p>
            <p class="text-sm text-gray-800">
                {{ $response->complaints_actions ?? '—' }}
            </p>
        </div>

        <!-- Security Coordination -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">PNP Station</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->pnp_station ?? '—' }}
            </p>

            <hr class="border-gray-100">

            <p class="text-base font-bold text-gray-700">Police Team (notified)</p>
            <p class="text-sm font-medium text-gray-800">
                {{ $response->pnp_team_unit ?? '—' }}
            </p>
        </div>

    </div>
</div>

@endif

        <!-- Services -->
        @if ($response->dispatch_unit === 'Services')

<!-- Container with green background -->
<div class="p-4 bg-green-50 rounded-lg">

    <!-- Header -->
    <h4 class="text-base font-semibold text-green-600 mb-1">
        🛠 Recorded Service Request Details
    </h4>
    <p class="text-xs text-gray-500 mb-3">
        Encoded service-related action based on the submitted request.
    </p>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <!-- Inspection -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">Inspection Date</p>
            <p class="text-sm font-semibold text-gray-900">
                {{ $response->inspection_date ?? '—' }}
            </p>
        </div>

        <!-- Action -->
        <div class="bg-white rounded-lg p-3 shadow-sm space-y-2">
            <p class="text-base font-bold text-gray-700">Recommended Action</p>
            <p class="text-sm text-gray-800">
                {{ $response->recommended_action ?? '—' }}
            </p>
        </div>

    </div>
</div>

@endif

    @endif

</div>
