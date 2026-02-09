<!-- 🔥 FIRE RESPONSE FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Fire'" x-cloak class="space-y-4">

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🔥 Fire Response Details</h4>


    <!-- 🚨 EVACUATION ADDRESS -->

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

    <!-- 🧭 HOSPITAL ADDRESS -->
    <!-- Hospital Address -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Hospital Address</label>
        <input type="text" name="hospital_address"
               value="{{ $response->hospital_address }}"
               class="w-full border rounded p-2">
    </div>


    <!-- 🚐 EVACUATION TRANSPORT -->
    <div x-data="{
        showOtherTrans:
            '{{ $response->evacuation_transport }}' !== '' &&
            ![
                'Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','NONE'
            ].includes('{{ $response->evacuation_transport }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Vehicle Transport</label>

        <select name="evacuation_transport"
                class="w-full border rounded p-2"
                x-on:change='showOtherTrans = ($event.target.value === "Other")'>

            <option value="">-- Select Transport --</option>

            @foreach (['Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->evacuation_transport == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected($response->evacuation_transport && !in_array($response->evacuation_transport, ['Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','NONE']))>
                Other
            </option>

        </select>

        <input type="text"
               name="evacuation_transport_other"
               x-show="showOtherTrans"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify transport"
               value="{{ in_array($response->evacuation_transport, ['Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','NONE']) ? '' : $response->evacuation_transport }}">
    </div>



    <!-- 🚐 TRANSPORT UNITS -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Transport Units</label>
        <input type="number"
               name="evacuation_transport_unit"
               value="{{ $response->evacuation_transport_unit }}"
               class="w-full border rounded p-2">
    </div>



    <!-- 🚓 PNP STATION -->
    <div x-data="{
        showOtherPNPStation:
            '{{ $response->pnp_station }}' !== '' &&
            '{{ $response->pnp_station }}' !== 'Moriones Tondo Police Station'
    }">

        <label class="block text-sm font-medium text-gray-700">PNP Station</label>

        <select name="pnp_station"
                class="w-full border rounded p-2"
                x-on:change='showOtherPNPStation = ($event.target.value === "Other")'>

            <option value="">-- Select Station --</option>
            <option value="Moriones Tondo Police Station"
                @selected($response->pnp_station == 'Moriones Tondo Police Station')}>
                Moriones Tondo Police Station
            </option>

            <option value="Other"
                @selected($response->pnp_station && $response->pnp_station !== 'Moriones Tondo Police Station')}>
                Other
            </option>

        </select>

        <input type="text"
               name="pnp_station_other"
               x-show="showOtherPNPStation"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify station"
               value="{{ $response->pnp_station == 'Moriones Tondo Police Station' ? '' : $response->pnp_station }}">
    </div>



    <!-- 🚓 PNP TEAM -->
    <div x-data="{
        showOtherPNPTeam:
            '{{ $response->pnp_team_unit }}' !== '' &&
            !['Rapid Response Team','Barangay Patrol'].includes('{{ $response->pnp_team_unit }}')
    }">

        <label class="block text-sm font-medium text-gray-700">PNP Team</label>

        <select name="pnp_team_unit"
                class="w-full border rounded p-2"
                x-on:change='showOtherPNPTeam = ($event.target.value === "Other")'>

            <option value="">-- Select Team --</option>

            @foreach (['Rapid Response Team','Barangay Patrol'] as $opt)
                <option value="{{ $opt }}" @selected($response->pnp_team_unit == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->pnp_team_unit &&
                    !in_array($response->pnp_team_unit, ['Rapid Response Team','Barangay Patrol'])
                )>Other</option>

        </select>

        <input type="text"
               name="pnp_team_unit_other"
               x-show="showOtherPNPTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->pnp_team_unit, ['Rapid Response Team','Barangay Patrol']) ? '' : $response->pnp_team_unit }}">
    </div>



    <!-- 🧺 RELIEF GOODS PROVIDER -->
    <div x-data="{
        showOtherRelief:
            '{{ $response->relief_goods_provider }}' !== '' &&
            !['DSWD','Barangay 41','City Social Welfare Office'].includes('{{ $response->relief_goods_provider }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Relief Goods Provider</label>

        <select name="relief_goods_provider"
                class="w-full border rounded p-2"
                x-on:change='showOtherRelief = ($event.target.value === "Other")'>

            <option value="">-- Select Provider --</option>

            @foreach (['DSWD','Barangay 41','City Social Welfare Office'] as $opt)
                <option value="{{ $opt }}" @selected($response->relief_goods_provider == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->relief_goods_provider &&
                    !in_array($response->relief_goods_provider, ['DSWD','Barangay 41','City Social Welfare Office'])
                )>Other</option>

        </select>

        <input type="text"
               name="relief_goods_provider_other"
               x-show="showOtherRelief"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify provider"
               value="{{ in_array($response->relief_goods_provider, ['DSWD','Barangay 41','City Social Welfare Office']) ? '' : $response->relief_goods_provider }}">
    </div>



    <!-- 🚒 FIRE DEPARTMENT -->
    <div x-data="{
        showOtherFireDep:
            '{{ $response->fire_department }}' !== '' &&
            !['BFP','COMMEL MANILA','Special Rescue Force'].includes('{{ $response->fire_department }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Fire Department</label>

        <select name="fire_department"
                class="w-full border rounded p-2"
                x-on:change='showOtherFireDep = ($event.target.value === "Other")'>

            <option value="">-- Select Fire Department --</option>

            @foreach (['BFP','COMMEL MANILA','Special Rescue Force'] as $opt)
                <option value="{{ $opt }}" @selected($response->fire_department == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected($response->fire_department && !in_array($response->fire_department, ['BFP','COMMEL MANILA','Special Rescue Force']))>
                Other
            </option>

        </select>

        <input type="text"
               name="fire_department_other"
               x-show="showOtherFireDep"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify department"
               value="{{ in_array($response->fire_department, ['BFP','COMMEL MANILA','Special Rescue Force']) ? '' : $response->fire_department }}">
    </div>



    <!-- 🔥 FIRE TEAM -->
    <div x-data="{
        showOtherFireTeam:
            '{{ $response->fire_team }}' !== '' &&
            !['Engine Crew','Rescue Team','Support Crew','Ladder Team','HazMat Team'].includes('{{ $response->fire_team }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Fire Team</label>

        <select name="fire_team"
                class="w-full border rounded p-2"
                x-on:change='showOtherFireTeam = ($event.target.value === "Other")'>

            <option value="">-- Select Fire Team --</option>

            @foreach (['Engine Crew','Rescue Team','Support Crew','Ladder Team','HazMat Team'] as $opt)
                <option value="{{ $opt }}" @selected($response->fire_team == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->fire_team &&
                    !in_array($response->fire_team, ['Engine Crew','Rescue Team','Support Crew','Ladder Team','HazMat Team'])
                )>
                Other
            </option>

        </select>

        <input type="text"
               name="fire_team_other"
               x-show="showOtherFireTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->fire_team, ['Engine Crew','Rescue Team','Support Crew','Ladder Team','HazMat Team']) ? '' : $response->fire_team }}">
    </div>



    <!-- 🚒 FIRE TRUCK UNITS -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Fire Truck Units</label>
        <input type="number"
               name="fire_truck_units"
               value="{{ $response->fire_truck_units }}"
               class="w-full border rounded p-2">
    </div>



    <!-- 🔍 SEARCH & RESCUE TEAM -->
    <div x-data="{
        showOtherSearch:
            '{{ $response->search_rescue_team }}' !== '' &&
            !['Special Rescue Force','BFP Rescue','Barangay Tanod Response'].includes('{{ $response->search_rescue_team }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Search & Rescue Team</label>

        <select name="search_rescue_team"
                class="w-full border rounded p-2"
                x-on:change='showOtherSearch = ($event.target.value === "Other")'>

            <option value="">-- Select Team --</option>

            @foreach (['Special Rescue Force','BFP Rescue','Barangay Tanod Response'] as $opt)
                <option value="{{ $opt }}" @selected($response->search_rescue_team == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->search_rescue_team &&
                    !in_array($response->search_rescue_team, ['Special Rescue Force','BFP Rescue','Barangay Tanod Response'])
                )>
                Other
            </option>

        </select>

        <input type="text"
               name="search_rescue_team_other"
               x-show="showOtherSearch"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->search_rescue_team, ['Special Rescue Force','BFP Rescue','Barangay Tanod Response']) ? '' : $response->search_rescue_team }}">
    </div>

</div>
