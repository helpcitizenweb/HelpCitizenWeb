<!-- 🪨 EARTHQUAKE RESPONSE FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Earthquake'" x-cloak class="space-y-4">

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🪨 Earthquake Response Details</h4>

    <!-- Evacuation Address -->
    <div x-data="{ showOtherEqEvac: '{{ $response->evacuation_address }}' !== '' &&
        !['Barangay 41 Barangay Hall','Nearby School / Gym','Open Grounds','High Ground Area','Evacuation Center']
        .includes('{{ $response->evacuation_address }}') }">

        <label class="block text-sm font-medium text-gray-700">Evacuation Address</label>

        <select name="evacuation_address" class="w-full border rounded p-2"
                x-on:change="showOtherEqEvac = ($event.target.value === 'Other')">

            <option value="">-- Select Location --</option>

            @foreach ([
                'Barangay 41 Barangay Hall',
                'Nearby School / Gym',
                'Open Grounds',
                'High Ground Area',
                'Evacuation Center'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->evacuation_address == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->evacuation_address, [
                'Barangay 41 Barangay Hall','Nearby School / Gym','Open Grounds','High Ground Area','Evacuation Center'
            ]) && $response->evacuation_address)>
                Other
            </option>
        </select>

        <input type="text" name="evacuation_address_other" x-show="showOtherEqEvac"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify location"
               value="{{ in_array($response->evacuation_address, [
                    'Barangay 41 Barangay Hall','Nearby School / Gym','Open Grounds','High Ground Area','Evacuation Center'
               ]) ? '' : $response->evacuation_address }}">
    </div>

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



<!-- 🏥 DESIGNATED HOSPITALS -->
<div x-data="{
    showOtherHosp:
        '{{ $response->designated_hospitals }}' &&
        ![
            'Tondo Medical Center',
            'Mary Johnston Hospital',
            'Metropolitan Medical Center',
            'Seaman’s Hospital Manila',
            'Justice Jose Abad Santos General Hospital',
            'San Lazaro Hospital',
            'Chinese General Hospital',
            'Jose Reyes Memorial Medical Center',
            'NONE'
        ].includes('{{ $response->designated_hospitals }}')
}">

    <label class="block text-sm font-medium text-gray-700">Designated Hospital</label>

    <select name="designated_hospitals"
            class="w-full border rounded p-2"
            x-on:change="showOtherHosp = ($event.target.value === 'Other')">

        <option value="">-- Select Hospital --</option>

        @foreach ([
            'Tondo Medical Center',
            'Mary Johnston Hospital',
            'Metropolitan Medical Center',
            'Seaman’s Hospital Manila',
            'Justice Jose Abad Santos General Hospital',
            'San Lazaro Hospital',
            'Chinese General Hospital',
            'Jose Reyes Memorial Medical Center',
            'NONE'
        ] as $opt)
            <option value="{{ $opt }}" @selected($response->designated_hospitals == $opt)>
                {{ $opt }}
            </option>
        @endforeach

        <option value="Other"
                @selected(
                    $response->designated_hospitals &&
                    !in_array($response->designated_hospitals, [
                        'Tondo Medical Center',
                        'Mary Johnston Hospital',
                        'Metropolitan Medical Center',
                        'Seaman’s Hospital Manila',
                        'Justice Jose Abad Santos General Hospital',
                        'San Lazaro Hospital',
                        'Chinese General Hospital',
                        'Jose Reyes Memorial Medical Center',
                        'NONE'
                    ])
                )>
            Other
        </option>

    </select>

    <input type="text"
           name="designated_hospitals_other"
           x-show="showOtherHosp"
           class="w-full border rounded p-2 mt-2"
           placeholder="Specify hospital"
           value="{{ in_array($response->designated_hospitals, [
                'Tondo Medical Center',
                'Mary Johnston Hospital',
                'Metropolitan Medical Center',
                'Seaman’s Hospital Manila',
                'Justice Jose Abad Santos General Hospital',
                'San Lazaro Hospital',
                'Chinese General Hospital',
                'Jose Reyes Memorial Medical Center',
                'NONE'
           ]) ? '' : $response->designated_hospitals }}">
</div>


    <!-- Hospital Address -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Hospital Address</label>
        <input type="text" name="hospital_address"
               value="{{ $response->hospital_address }}"
               class="w-full border rounded p-2">
    </div>

    <!-- Evacuation Transport -->
    <div x-data="{ showOtherEqTrans: '{{ $response->evacuation_transport }}' !== '' &&
        !['Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck',
          'Rescue Vehicle','Evacuation Truck','NONE']
        .includes('{{ $response->evacuation_transport }}') }">

        <label class="block text-sm font-medium text-gray-700">Vehicle Transport</label>

        <select name="evacuation_transport" class="w-full border rounded p-2"
                x-on:change="showOtherEqTrans = ($event.target.value === 'Other')">

            <option value="">-- Select Transport --</option>

            @foreach ([
                'NONE',
                'Barangay Service Vehicle',
                'Ambulance',
                'Police Vehicle',
                'Fire Truck',
                'Rescue Vehicle',
                'Evacuation Truck'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->evacuation_transport == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->evacuation_transport, [
                'NONE','Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','Rescue Vehicle','Evacuation Truck'
            ]) && $response->evacuation_transport)>
                Other
            </option>
        </select>

        <input type="text" name="evacuation_transport_other" x-show="showOtherEqTrans"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify transport"
               value="{{ in_array($response->evacuation_transport, [
                    'NONE','Barangay Service Vehicle','Ambulance','Police Vehicle',
                    'Fire Truck','Rescue Vehicle','Evacuation Truck'
               ]) ? '' : $response->evacuation_transport }}">
    </div>

    <!-- Transport Units -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Transport Units</label>
        <input type="number" name="evacuation_transport_unit"
               value="{{ $response->evacuation_transport_unit }}"
               class="w-full border rounded p-2">
    </div>

    <!-- PNP Station -->
    <div x-data="{ showOtherEqPNP: '{{ $response->pnp_station }}' !== '' &&
        !['Moriones Tondo Police Station','NONE'].includes('{{ $response->pnp_station }}') }">

        <label class="block text-sm font-medium text-gray-700">PNP Station</label>

        <select name="pnp_station" class="w-full border rounded p-2"
                x-on:change="showOtherEqPNP = ($event.target.value === 'Other')">

            <option value="">-- Select Station --</option>

            <option value="Moriones Tondo Police Station" @selected($response->pnp_station == 'Moriones Tondo Police Station')>
                Moriones Tondo Police Station
            </option>

            <option value="NONE" @selected($response->pnp_station == 'NONE')>N/A</option>

            <option value="Other" @selected(!in_array($response->pnp_station, [
                'Moriones Tondo Police Station','NONE'
            ]) && $response->pnp_station)>
                Other
            </option>
        </select>

        <input type="text" name="pnp_station_other" x-show="showOtherEqPNP"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify station"
               value="{{ in_array($response->pnp_station, [
                    'Moriones Tondo Police Station','NONE'
               ]) ? '' : $response->pnp_station }}">
    </div>

    <!-- PNP Patrol Units -->
    <div>
        <label class="block text-sm font-medium text-gray-700">PNP Patrol Units</label>
        <input type="number" name="pnp_patrol_unit"
               value="{{ $response->pnp_patrol_unit }}"
               class="w-full border rounded p-2">
    </div>

    <!-- PNP Team -->
    <div x-data="{ showOtherEqPNPTeam: '{{ $response->pnp_team_unit }}' !== '' &&
        !['Rapid Response Team','Barangay Patrol','NONE']
        .includes('{{ $response->pnp_team_unit }}') }">

        <label class="block text-sm font-medium text-gray-700">PNP Team</label>

        <select name="pnp_team_unit" class="w-full border rounded p-2"
                x-on:change="showOtherEqPNPTeam = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach ([
                'Rapid Response Team',
                'Barangay Patrol',
                'NONE'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->pnp_team_unit == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->pnp_team_unit, [
                'Rapid Response Team','Barangay Patrol','NONE'
            ]) && $response->pnp_team_unit)>
                Other
            </option>
        </select>

        <input type="text" name="pnp_team_unit_other" x-show="showOtherEqPNPTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->pnp_team_unit, [
                    'Rapid Response Team','Barangay Patrol','NONE'
               ]) ? '' : $response->pnp_team_unit }}">
    </div>

    <!-- Relief Goods Provider -->
    <div x-data="{ showOtherEqRelief: '{{ $response->relief_goods_provider }}' !== '' &&
        !['DSWD','Barangay 41','City Social Welfare Office']
        .includes('{{ $response->relief_goods_provider }}') }">

        <label class="block text-sm font-medium text-gray-700">Relief Goods Provider</label>

        <select name="relief_goods_provider" class="w-full border rounded p-2"
                x-on:change="showOtherEqRelief = ($event.target.value === 'Other')">

            <option value="">-- Select Provider --</option>

            @foreach ([
                'DSWD',
                'Barangay 41',
                'City Social Welfare Office'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->relief_goods_provider == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->relief_goods_provider, [
                'DSWD','Barangay 41','City Social Welfare Office'
            ]) && $response->relief_goods_provider)>
                Other
            </option>
        </select>

        <input type="text" name="relief_goods_provider_other" x-show="showOtherEqRelief"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify provider"
               value="{{ in_array($response->relief_goods_provider, [
                    'DSWD','Barangay 41','City Social Welfare Office'
               ]) ? '' : $response->relief_goods_provider }}">
    </div>

    <!-- Fire Department -->
    <div x-data="{ showOtherEqFireDep: '{{ $response->fire_department }}' !== '' &&
        !['BFP','COMMEL MANILA','Special Rescue Force']
        .includes('{{ $response->fire_department }}') }">

        <label class="block text-sm font-medium text-gray-700">Fire Department</label>

        <select name="fire_department" class="w-full border rounded p-2"
                x-on:change="showOtherEqFireDep = ($event.target.value === 'Other')">

            <option value="">-- Select Fire Department --</option>

            @foreach ([
                'BFP',
                'COMMEL MANILA',
                'Special Rescue Force'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->fire_department == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->fire_department, [
                'BFP','COMMEL MANILA','Special Rescue Force'
            ]) && $response->fire_department)>
                Other
            </option>
        </select>

        <input type="text" name="fire_department_other" x-show="showOtherEqFireDep"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify department"
               value="{{ in_array($response->fire_department, [
                    'BFP','COMMEL MANILA','Special Rescue Force'
               ]) ? '' : $response->fire_department }}">
    </div>

    <!-- Fire Team -->
    <div x-data="{ showOtherEqFireTeam: '{{ $response->fire_team }}' !== '' &&
        !['Engine Crew','Rescue Team']
        .includes('{{ $response->fire_team }}') }">

        <label class="block text-sm font-medium text-gray-700">Fire Team</label>

        <select name="fire_team" class="w-full border rounded p-2"
                x-on:change="showOtherEqFireTeam = ($event.target.value === 'Other')">

            <option value="">-- Select Fire Team --</option>

            @foreach ([
                'Engine Crew',
                'Rescue Team'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->fire_team == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->fire_team, [
                'Engine Crew','Rescue Team'
            ]) && $response->fire_team)>
                Other
            </option>
        </select>

        <input type="text" name="fire_team_other" x-show="showOtherEqFireTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->fire_team, [
                    'Engine Crew','Rescue Team'
               ]) ? '' : $response->fire_team }}">
    </div>

    <!-- Fire Truck Units -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Fire Truck Units</label>
        <input type="number" name="fire_truck_units"
               value="{{ $response->fire_truck_units }}"
               class="w-full border rounded p-2">
    </div>

    <!-- Search Rescue Team -->
    <div x-data="{ showOtherEqSearch: '{{ $response->search_rescue_team }}' !== '' &&
        !['Special Rescue Force','BFP Rescue','Barangay Search & Rescue','Volunteer Rescue Group']
        .includes('{{ $response->search_rescue_team }}') }">

        <label class="block text-sm font-medium text-gray-700">Search Rescue Team</label>

        <select name="search_rescue_team" class="w-full border rounded p-2"
                x-on:change="showOtherEqSearch = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach ([
                'Special Rescue Force',
                'BFP Rescue',
                'Barangay Search & Rescue',
                'Volunteer Rescue Group'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->search_rescue_team == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->search_rescue_team, [
                'Special Rescue Force','BFP Rescue','Barangay Search & Rescue','Volunteer Rescue Group'
            ]) && $response->search_rescue_team)>
                Other
            </option>
        </select>

        <input type="text" name="search_rescue_team_other" x-show="showOtherEqSearch"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->search_rescue_team, [
                    'Special Rescue Force','BFP Rescue','Barangay Search & Rescue','Volunteer Rescue Group'
               ]) ? '' : $response->search_rescue_team }}">
    </div>

    <!-- Clearing Team -->
    <div x-data="{ showOtherEqClear: '{{ $response->clearing_teams }}' !== '' &&
        !['Barangay Clearing Crew','City Engineering Office','DPWH Clearing Team','Volunteer Clearing Team']
        .includes('{{ $response->clearing_teams }}') }">

        <label class="block text-sm font-medium text-gray-700">Clearing Team</label>

        <select name="clearing_teams" class="w-full border rounded p-2"
                x-on:change="showOtherEqClear = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach ([
                'Barangay Clearing Crew',
                'City Engineering Office',
                'DPWH Clearing Team',
                'Volunteer Clearing Team'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->clearing_teams == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->clearing_teams, [
                'Barangay Clearing Crew','City Engineering Office','DPWH Clearing Team','Volunteer Clearing Team'
            ]) && $response->clearing_teams)>
                Other
            </option>
        </select>

        <input type="text" name="clearing_teams_other" x-show="showOtherEqClear"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify clearing team"
               value="{{ in_array($response->clearing_teams, [
                    'Barangay Clearing Crew','City Engineering Office','DPWH Clearing Team','Volunteer Clearing Team'
               ]) ? '' : $response->clearing_teams }}">
    </div>

    <!-- Power Utility Agency -->
    <div x-data="{ showOtherEqPower: '{{ $response->power_utility_agency }}' !== '' &&
        !['Meralco','Electric Cooperative','Barangay Electrical Team']
        .includes('{{ $response->power_utility_agency }}') }">

        <label class="block text-sm font-medium text-gray-700">Power Utility Agency</label>

        <select name="power_utility_agency" class="w-full border rounded p-2"
                x-on:change="showOtherEqPower = ($event.target.value === 'Other')">

            <option value="">-- Select Agency --</option>

            @foreach ([
                'Meralco',
                'Electric Cooperative',
                'Barangay Electrical Team'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->power_utility_agency == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->power_utility_agency, [
                'Meralco','Electric Cooperative','Barangay Electrical Team'
            ]) && $response->power_utility_agency)>
                Other
            </option>
        </select>

        <input type="text" name="power_utility_agency_other" x-show="showOtherEqPower"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify utility agency"
               value="{{ in_array($response->power_utility_agency, [
                    'Meralco','Electric Cooperative','Barangay Electrical Team'
               ]) ? '' : $response->power_utility_agency }}">
    </div>

    <!-- Structural Assessment Teams -->
    <div x-data="{ showOtherEqStructural: '{{ $response->structural_assessment_teams }}' !== '' &&
        !['City Engineering Office','DPWH Structural Team','Volunteer Structural Assessors']
        .includes('{{ $response->structural_assessment_teams }}') }">

        <label class="block text-sm font-medium text-gray-700">Structural Assessment Teams</label>

        <select name="structural_assessment_teams" class="w-full border rounded p-2"
                x-on:change="showOtherEqStructural = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach ([
                'City Engineering Office',
                'DPWH Structural Team',
                'Volunteer Structural Assessors'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->structural_assessment_teams == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other" @selected(!in_array($response->structural_assessment_teams, [
                'City Engineering Office','DPWH Structural Team','Volunteer Structural Assessors'
            ]) && $response->structural_assessment_teams)>
                Other
            </option>
        </select>

        <input type="text" name="structural_assessment_teams_other" x-show="showOtherEqStructural"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify assessment team"
               value="{{ in_array($response->structural_assessment_teams, [
                    'City Engineering Office','DPWH Structural Team','Volunteer Structural Assessors'
               ]) ? '' : $response->structural_assessment_teams }}">
    </div>

</div>
