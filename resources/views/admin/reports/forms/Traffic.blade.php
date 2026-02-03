<!-- 🚦 Traffic RESPONSE FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Traffic'" x-cloak>

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🚦 Traffic Response Details</h4>

    <!-- Medical Response -->
    <div x-data="{
        showOtherMedResponse:
            '{{ $response->medical_response }}' !== '' &&
            ![
                'Philippine Red Cross',
                'Tondo Medical Center',
                'Metropolitan Medical Center',
                'Mary Johnston Hospital',
                'Tondo Foreshore Health Center',
                'Fugoso Health Center'
            ].includes('{{ $response->medical_response }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Responding Medical Authority</label>

        <select name="medical_response" class="w-full border rounded p-2"
                x-on:change="showOtherMedResponse = ($event.target.value === 'Other')">

            <option value="">-- Select Responding Medical team --</option>

            @foreach ([
                'Philippine Red Cross',
                'Tondo Medical Center',
                'Metropolitan Medical Center',
                'Mary Johnston Hospital',
                'Tondo Foreshore Health Center',
                'Fugoso Health Center'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->medical_response == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other"
                    @selected(!in_array($response->medical_response, [
                        'Philippine Red Cross',
                        'Tondo Medical Center',
                        'Metropolitan Medical Center',
                        'Mary Johnston Hospital',
                        'Tondo Foreshore Health Center',
                        'Fugoso Health Center'
                    ]) && $response->medical_response)>
                Other
            </option>

        </select>

        <input type="text" name="medical_response_other"
               x-show="showOtherMedResponse"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify response team"
               value="{{ in_array($response->medical_response, [
                    'Philippine Red Cross','Tondo Medical Center','Metropolitan Medical Center',
                    'Mary Johnston Hospital','Tondo Foreshore Health Center','Fugoso Health Center'
               ]) ? '' : $response->medical_response }}">
    </div>

    <!-- 🚫 AMBULANCE UNITS REMOVED -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Ambulance Units</label>
        <input type="number"
               name="ambulance_units"
               class="w-full border rounded p-2"
               value="{{ old('ambulance_units', $response->ambulance_units ?? '') }}">
    </div>

    <!-- Designated Hospitals -->
    <div x-data="{
        showOtherMedHosp:
            '{{ $response->designated_hospitals }}' !== '' &&
            ![
                'Tondo Medical Center',
                'Metropolitan Medical Center',
                'Mary Johnston Hospital',
                'NONE'
            ].includes('{{ $response->designated_hospitals }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Designated Hospital</label>

        <select name="designated_hospitals" class="w-full border rounded p-2"
                x-on:change="showOtherMedHosp = ($event.target.value === 'Other')">

            <option value="">-- Select Hospital --</option>

            @foreach ([
                'Tondo Medical Center',
                'Metropolitan Medical Center',
                'Mary Johnston Hospital',
                'NONE'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->designated_hospitals == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other"
                    @selected(!in_array($response->designated_hospitals, [
                        'Tondo Medical Center','Metropolitan Medical Center','Mary Johnston Hospital','NONE'
                    ]) && $response->designated_hospitals)>
                Other
            </option>

        </select>

        <input type="text" name="designated_hospitals_other"
               x-show="showOtherMedHosp"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify hospital"
               value="{{ in_array($response->designated_hospitals, [
                    'Tondo Medical Center','Metropolitan Medical Center','Mary Johnston Hospital','NONE'
               ]) ? '' : $response->designated_hospitals }}">
    </div>

    <!-- 🚑 Ambulance Units -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Ambulance Units</label>
        <input type="number"
               name="ambulance_units"
               class="w-full border rounded p-2"
               value="{{ old('ambulance_units', $response->ambulance_units ?? '') }}">
    </div>



    <!-- 📍 Hospital Address -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Hospital Address</label>
        <input type="text"
               name="hospital_address"
               value="{{ old('hospital_address', $response->hospital_address ?? '') }}"
               class="w-full border rounded p-2">
    </div>


    <!-- 🚧 Road Clearance Team -->
    <div x-data="{
        showOtherRoadClear:
            '{{ $response->road_clearance_team }}' !== '' &&
            ![
                'Barangay Clearing Crew',
                'City Engineering Road Team',
                'MMDA Road Clearing',
                'DPWH Emergency Crew',
                'NONE'
            ].includes('{{ $response->road_clearance_team }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Road Clearance Team</label>

        <select name="road_clearance_team"
                class="w-full border rounded p-2"
                x-on:change="showOtherRoadClear = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach ([
                'Barangay Clearing Crew',
                'City Engineering Road Team',
                'MMDA Road Clearing',
                'DPWH Emergency Crew',
                'NONE'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->road_clearance_team == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->road_clearance_team &&
                    !in_array(
                        $response->road_clearance_team,
                        ['Barangay Clearing Crew','City Engineering Road Team','MMDA Road Clearing','DPWH Emergency Crew','NONE']
                    )
                )>Other</option>
        </select>

        <input type="text" name="road_clearance_team_other"
               x-show="showOtherRoadClear"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify clearing team"
               value="{{ in_array($response->road_clearance_team, [
                    'Barangay Clearing Crew',
                    'City Engineering Road Team',
                    'MMDA Road Clearing',
                    'DPWH Emergency Crew',
                    'NONE'
               ]) ? '' : $response->road_clearance_team }}">
    </div>


    <!-- 🔀 Traffic Diversion Sites -->
    <div x-data="{
        showOtherTrafficDivert:
            '{{ $response->traffic_diversion_sites }}' !== '' &&
            ![
                'Alternate Street Route',
                'Barangay Detour Area',
                'Main Road Redirection',
                'Temporary Road Closure',
                'NONE'
            ].includes('{{ $response->traffic_diversion_sites }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Traffic Diversion Sites</label>

        <select name="traffic_diversion_sites"
                class="w-full border rounded p-2"
                x-on:change="showOtherTrafficDivert = ($event.target.value === 'Other')">

            <option value="">-- Select Site --</option>

            @foreach ([
                'Alternate Street Route',
                'Barangay Detour Area',
                'Main Road Redirection',
                'Temporary Road Closure',
                'NONE'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->traffic_diversion_sites == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->traffic_diversion_sites &&
                    !in_array(
                        $response->traffic_diversion_sites,
                        ['Alternate Street Route','Barangay Detour Area','Main Road Redirection','Temporary Road Closure','NONE']
                    )
                )>Other</option>
        </select>

        <input type="text" name="traffic_diversion_sites_other"
               x-show="showOtherTrafficDivert"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify diversion site"
               value="{{ in_array($response->traffic_diversion_sites, [
                    'Alternate Street Route',
                    'Barangay Detour Area',
                    'Main Road Redirection',
                    'Temporary Road Closure',
                    'NONE'
               ]) ? '' : $response->traffic_diversion_sites }}">
    </div>


    <!-- 🚓 PNP Station -->
    <div x-data="{
        showOtherTrafficPNP:
            '{{ $response->pnp_station }}' !== '' &&
            ![
                'Moriones Tondo Police Station',
                'NONE'
            ].includes('{{ $response->pnp_station }}')
    }">

        <label class="block text-sm font-medium text-gray-700">PNP Station</label>

        <select name="pnp_station"
                class="w-full border rounded p-2"
                x-on:change="showOtherTrafficPNP = ($event.target.value === 'Other')">

            <option value="">-- Select PNP Station --</option>

            <option value="Moriones Tondo Police Station"
                @selected($response->pnp_station == 'Moriones Tondo Police Station')}>
                Moriones Tondo Police Station
            </option>

            <option value="NONE" @selected($response->pnp_station == 'NONE')>N/A</option>

            <option value="Other"
                @selected(
                    $response->pnp_station &&
                    !in_array($response->pnp_station, ['Moriones Tondo Police Station','NONE'])
                )>Other</option>
        </select>

        <input type="text" name="pnp_station_other"
               x-show="showOtherTrafficPNP"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify station"
               value="{{ in_array($response->pnp_station, ['Moriones Tondo Police Station','NONE']) ? '' : $response->pnp_station }}">
    </div>


    <!-- 🚓 PNP Team -->
    <div x-data="{
        showOtherTrafficPNPTeam:
            '{{ $response->pnp_team_unit }}' !== '' &&
            ![
                'Rapid Response Team',
                'Traffic Control Unit',
                'Barangay Patrol',
                'NONE'
            ].includes('{{ $response->pnp_team_unit }}')
    }">

        <label class="block text-sm font-medium text-gray-700">PNP Team</label>

        <select name="pnp_team_unit"
                class="w-full border rounded p-2"
                x-on:change="showOtherTrafficPNPTeam = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach (['Rapid Response Team','Traffic Control Unit','Barangay Patrol','NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->pnp_team_unit == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->pnp_team_unit &&
                    !in_array(
                        $response->pnp_team_unit,
                        ['Rapid Response Team','Traffic Control Unit','Barangay Patrol','NONE']
                    )
                )>Other</option>
        </select>

        <input type="text" name="pnp_team_unit_other"
               x-show="showOtherTrafficPNPTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->pnp_team_unit, [
                    'Rapid Response Team',
                    'Traffic Control Unit',
                    'Barangay Patrol',
                    'NONE'
               ]) ? '' : $response->pnp_team_unit }}">
    </div>


    <!-- 🚓 PNP PATROL UNITS -->
    <div>
        <label class="block text-sm font-medium text-gray-700">PNP Patrol Units</label>
        <input type="number"
               name="pnp_patrol_unit"
               value="{{ old('pnp_patrol_unit', $response->pnp_patrol_unit ?? '') }}"
               class="w-full border rounded p-2">
    </div>

</div>
