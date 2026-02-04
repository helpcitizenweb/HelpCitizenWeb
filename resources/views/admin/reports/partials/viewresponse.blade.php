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
            <p><strong>Responder/Contact Person:</strong> {{ $response->contact_person ?? '—' }}</p>
            <p><strong>Overseer:</strong> {{ $response->overseer ?? '—' }}</p>
            <p><strong>Contact Number: </strong> {{ $response->contact_number ?? '—' }}</p>
             <p>
        <strong>Response Submitted:</strong>
        {{ optional($response->response_datetime)->format('F d, Y • h:i A') ?? '—' }}
    </p>
        </div>

        <!--Fire Response -->
        @if ($response->dispatch_unit === 'Fire')
            <div class="p-4 bg-red-50 rounded-lg shadow-sm space-y-2">
                <h4 class="text-lg font-semibold text-red-600 mb-2">🔥 Fire Response</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><strong>Evacuation Address:</strong> {{ $response->evacuation_address ?? '—' }}</p>
                    <p><strong>Responding Medical Authority:</strong> {{ $response->medical_response ?? '—' }}</p>
                    <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals ?? '—' }}</p>
                    <p><strong>Hospital Address:</strong> {{ $response->hospital_address ?? '—' }}</p>
                    <p><strong>Vehicle Transport:</strong> {{ $response->evacuation_transport ?? '—' }}</p>
                    <p><strong>Transport Units:</strong> {{ $response->evacuation_transport_unit ?? '—' }}</p>
                    <p><strong>PNP Station:</strong> {{ $response->pnp_station ?? '—' }}</p>
                    <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit ?? '—' }}</p>
                    <p><strong>PNP Patrol Units:</strong> {{ $response->pnp_patrol_unit ?? '—' }}</p>
                    <p><strong>Relief Goods Provider:</strong> {{ $response->relief_goods_provider ?? '—' }}</p>
                    <p><strong>Fire Department:</strong> {{ $response->fire_department ?? '—' }}</p>
                    <p><strong>Fire Team:</strong> {{ $response->fire_team ?? '—' }}</p>
                    <p><strong>Fire Truck Units:</strong> {{ $response->fire_truck_units ?? '—' }}</p>
                    <p><strong>Search & Rescue Team:</strong> {{ $response->search_rescue_team ?? '—' }}</p>
                </div>
            </div>
        @endif

        <!--Flood/Typhoon Response -->
        @if ($response->dispatch_unit === 'Flood_typhoon')
            <div class="p-4 bg-blue-50 rounded-lg shadow-sm space-y-2">
                <h4 class="text-lg font-semibold text-blue-600 mb-2">🌊 Flood Response</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><strong>Evacuation Address:</strong> {{ $response->evacuation_address ?? '—' }}</p>
                    <p><strong>Responding Medical Authority:</strong> {{ $response->medical_response ?? '—' }}</p>
                    <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals ?? '—' }}</p>
                    <p><strong>Hospital Address:</strong> {{ $response->hospital_address ?? '—' }}</p>
                    <p><strong>Transport:</strong> {{ $response->evacuation_transport ?? '—' }}</p>
                    <p><strong>Transport Units:</strong> {{ $response->evacuation_transport_unit ?? '—' }}</p>
                    <p><strong>Water Rescue Unit:</strong> {{ $response->water_rescue_response_unit ?? '—' }}</p>
                    <p><strong>Rubber Boats:</strong> {{ $response->rubber_boat_units ?? '—' }}</p>
                    <p><strong>Lifeguards:</strong> {{ $response->lifeguard_rescue_personnel ?? '—' }}</p>
                    <p><strong>Search & Rescue:</strong> {{ $response->search_rescue_team ?? '—' }}</p>
                    <p><strong>Safety & Security:</strong> {{ $response->safety_and_security ?? '—' }}</p>
                    <p><strong>Relief Welfare:</strong> {{ $response->relief_welfare ?? '—' }}</p>
                </div>
            </div>
        @endif

        <!--Earthquake Response -->
        @if ($response->dispatch_unit === 'Earthquake')
            <div class="p-4 bg-yellow-50 rounded-lg shadow-sm space-y-2">
                <h4 class="text-lg font-semibold text-yellow-600 mb-2">🪨 Earthquake Response</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals ?? '—' }}</p>
                    <p><strong>Hospital Address:</strong> {{ $response->hospital_address ?? '—' }}</p>
                    <p><strong>Evacuation Address:</strong> {{ $response->evacuation_address ?? '—' }}</p>
                    <p><strong>Vehicle Transport:</strong> {{ $response->evacuation_transport ?? '—' }}</p>
                    <p><strong>Transport Units:</strong> {{ $response->evacuation_transport_unit ?? '—' }}</p>
                    <p><strong>PNP Station:</strong> {{ $response->pnp_station ?? '—' }}</p>
                    <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit ?? '—' }}</p>
                    <p><strong>Fire Department:</strong> {{ $response->fire_department ?? '—' }}</p>
                    <p><strong>Fire Team:</strong> {{ $response->fire_team ?? '—' }}</p>
                    <p><strong>Clearing Teams:</strong> {{ $response->clearing_teams ?? '—' }}</p>
                    <p><strong>Power Utility Agency:</strong> {{ $response->power_utility_agency ?? '—' }}</p>
                    <p><strong>Structural Assessment:</strong> {{ $response->structural_assessment_teams ?? '—' }}</p>
                </div>
            </div>
        @endif

        <!--Medical Response -->
        @if ($response->dispatch_unit === 'Medical')
            <div class="p-4 bg-green-50 rounded-lg shadow-sm space-y-2">
                <h4 class="text-lg font-semibold text-green-600 mb-2">🩺 Responding Medical Authority</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><strong>Responding Medical Authority:</strong> {{ $response->medical_response ?? '—' }}</p>
                    <p><strong>Designated Hospitals:</strong> {{ $response->designated_hospitals ?? '—' }}</p>
                    <p><strong>Hospital Address:</strong> {{ $response->hospital_address ?? '—' }}</p>
                    <p><strong>First Aid Station:</strong> {{ $response->first_aid_station ?? '—' }}</p>
                    <p><strong>Ambulance Units:</strong> {{ $response->ambulance_units ?? '—' }}</p>
                </div>
            </div>
        @endif

        <!--Traffic Response -->
        @if ($response->dispatch_unit === 'Traffic')
            <div class="p-4 bg-orange-50 rounded-lg shadow-sm space-y-2">
                <h4 class="text-lg font-semibold text-orange-600 mb-2">🚦 Traffic Response</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><strong> Responding Medical Authority:</strong> {{ $response->medical_response ?? '—' }}</p>
                    <p><strong>Hospitals:</strong> {{ $response->designated_hospitals ?? '—' }}</p>
                    <p><strong>Hospital Address:</strong> {{ $response->hospital_address ?? '—' }}</p>
                    <p><strong>Ambulance Units:</strong> {{ $response->ambulance_units ?? '—' }}</p>
                    <p><strong>Road Clearance Team:</strong> {{ $response->road_clearance_team ?? '—' }}</p>
                    <p><strong>Traffic Diversion Sites:</strong> {{ $response->traffic_diversion_sites ?? '—' }}</p>
                    <p><strong>PNP Station:</strong> {{ $response->pnp_station ?? '—' }}</p>
                    <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit ?? '—' }}</p>
                    <p><strong>PNP Patrol Units:</strong> {{ $response->pnp_patrol_unit ?? '—' }}</p>
                </div>
            </div>
        @endif

        <!--Workplace/Home -->
        @if ($response->dispatch_unit === 'Workplace_Home')
            <div class="p-4 bg-blue-50 rounded-lg shadow-sm space-y-2">
                <h4 class="text-lg font-semibold text-blue-700 mb-2">🏠 Workplace/Home Response</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><strong>Responding Medical Authority:</strong> {{ $response->medical_response ?? '—' }}</p>
                    <p><strong>Hospitals:</strong> {{ $response->designated_hospitals ?? '—' }}</p>
                    <p><strong>Hospital Address:</strong> {{ $response->hospital_address ?? '—' }}</p>
                    <p><strong>Ambulance Units:</strong> {{ $response->ambulance_units ?? '—' }}</p>
                    <p><strong>First Aid:</strong> {{ $response->first_aid_station ?? '—' }}</p>
                    <p><strong>PNP Station:</strong> {{ $response->pnp_station ?? '—' }}</p>
                    <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit ?? '—' }}</p>
                    <p><strong>PNP Patrol Units:</strong> {{ $response->pnp_patrol_unit ?? '—' }}</p>
                </div>
            </div>
        @endif

        <!--Complaints -->
        @if (in_array($response->dispatch_unit, ['Harassment','Noise','Garbage']))
            <div class="p-4 bg-purple-50 rounded-lg shadow-sm space-y-2">
                <h4 class="text-lg font-semibold text-purple-600 mb-2">🗣 Complaint Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><strong>Responding Team:</strong> {{ $response->responding_team_complaints ?? '—' }}</p>
                    <p><strong>Actions:</strong> {{ $response->complaints_actions ?? '—' }}</p>
                    <p><strong>PNP Station:</strong> {{ $response->pnp_station ?? '—' }}</p>
                    <p><strong>PNP Team:</strong> {{ $response->pnp_team_unit ?? '—' }}</p>
                </div>
            </div>
        @endif

        <!-- Services -->
        @if ($response->dispatch_unit === 'Services')
            <div class="p-4 bg-green-50 rounded-lg shadow-sm space-y-2">
                <h4 class="text-lg font-semibold text-green-600 mb-2">🛠 Service Request</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <p><strong>Inspection Date:</strong> {{ $response->inspection_date ?? '—' }}</p>
                    <p><strong>Recommended Action:</strong> {{ $response->recommended_action ?? '—' }}</p>
                </div>
            </div>
        @endif

    @endif

</div>
