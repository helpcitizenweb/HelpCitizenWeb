<div class="p-6">


    <hr class="my-4">

    <!-- Response Section -->
    <h3 class="text-xl font-semibold mb-3">📄 Response Details</h3>

   @if (!$response)
    <div class="text-gray-600 italic">
        No response yet.
    </div>
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

        {{-- 🏠 WORKPLACE/HOME --}}
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

        {{-- 🗣 COMPLAINTS --}}
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

        {{-- 🛠 SERVICES --}}
        @if ($response->dispatch_unit === 'Services')
            <h4 class="text-lg font-semibold text-green-600">🛠 Service Request</h4>

            <p><strong>Inspection Date:</strong> {{ $response->inspection_date }}</p>
            <p><strong>Recommended Action:</strong> {{ $response->recommended_action }}</p>
        @endif

    @endif

</div>
