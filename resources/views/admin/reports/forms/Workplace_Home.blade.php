<!-- 🛠️🏠 Workplace / Home RESPONSE FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Workplace_Home'" x-cloak>

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🛠️🏠 Workplace / Home Response Details</h4>

    <!-- 🩺 MEDICAL RESPONSE -->
    <div x-data="{
        showOtherWHMedical:
            '{{ $response->medical_response }}' !== '' &&
            ![
                'Philippine Red Cross',
                'Tondo Medical Center',
                'Metropolitan Medical Center',
                'Mary Johnston Hospital',
                'Tondo Foreshore Health Center',
                'Fugoso Health Center',
                'NONE'
            ].includes('{{ $response->medical_response }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Medical Response</label>

        <select name="medical_response"
                class="w-full border rounded p-2"
                x-on:change="showOtherWHMedical = ($event.target.value === 'Other')">

            <option value="">-- Select Medical Response --</option>

            @foreach ([
                'Philippine Red Cross',
                'Tondo Medical Center',
                'Metropolitan Medical Center',
                'Mary Johnston Hospital',
                'Tondo Foreshore Health Center',
                'Fugoso Health Center',
                'NONE'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->medical_response == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->medical_response &&
                    !in_array(
                        $response->medical_response,
                        ['Philippine Red Cross','Tondo Medical Center','Metropolitan Medical Center','Mary Johnston Hospital','Tondo Foreshore Health Center','Fugoso Health Center','NONE']
                    )
                )>
                Other
            </option>
        </select>

        <input type="text" name="medical_response_other"
               x-show="showOtherWHMedical"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify medical response"
               value="{{ in_array($response->medical_response, [
                    'Philippine Red Cross',
                    'Tondo Medical Center',
                    'Metropolitan Medical Center',
                    'Mary Johnston Hospital',
                    'Tondo Foreshore Health Center',
                    'Fugoso Health Center',
                    'NONE'
               ]) ? '' : $response->medical_response }}">
    </div>


    <!-- 🚑 AMBULANCE UNITS -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Ambulance Units</label>
        <input type="number" name="ambulance_units"
               value="{{ old('ambulance_units', $response->ambulance_units ?? '') }}"
               class="w-full border rounded p-2">
    </div>


    <!-- 🏥 DESIGNATED HOSPITALS -->
    <div x-data="{
        showOtherWHHosp:
            '{{ $response->designated_hospitals }}' !== '' &&
            ![
                'Tondo Medical Center',
                'Metropolitan Medical Center',
                'Mary Johnston Hospital',
                'NONE'
            ].includes('{{ $response->designated_hospitals }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Designated Hospitals</label>

        <select name="designated_hospitals"
                class="w-full border rounded p-2"
                x-on:change="showOtherWHHosp = ($event.target.value === 'Other')">

            <option value="">-- Select Hospital --</option>

            @foreach (['Tondo Medical Center', 'Metropolitan Medical Center', 'Mary Johnston Hospital', 'NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->designated_hospitals == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->designated_hospitals &&
                    !in_array(
                        $response->designated_hospitals,
                        ['Tondo Medical Center','Metropolitan Medical Center','Mary Johnston Hospital','NONE']
                    )
                )>
                Other
            </option>
        </select>

        <input type="text" name="designated_hospitals_other"
               x-show="showOtherWHHosp"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify hospital"
               value="{{ in_array($response->designated_hospitals, [
                    'Tondo Medical Center',
                    'Metropolitan Medical Center',
                    'Mary Johnston Hospital',
                    'NONE'
               ]) ? '' : $response->designated_hospitals }}">
    </div>


    <!-- 📍 HOSPITAL ADDRESS -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Hospital Address</label>
        <input type="text" name="hospital_address"
               value="{{ old('hospital_address', $response->hospital_address ?? '') }}"
               class="w-full border rounded p-2">
    </div>


    <!-- ⛑ FIRST AID STATION -->
    <div x-data="{
        showOtherWHFirstAid:
            '{{ $response->first_aid_station }}' !== '' &&
            ![
                'Barangay First Aid Station',
                'On-site Workplace First Aid',
                'Clinic First Aid Area',
                'NONE'
            ].includes('{{ $response->first_aid_station }}')
    }">

        <label class="block text-sm font-medium text-gray-700">First Aid Station</label>

        <select name="first_aid_station"
                class="w-full border rounded p-2"
                x-on:change="showOtherWHFirstAid = ($event.target.value === 'Other')">

            <option value="">-- Select Station --</option>

            @foreach ([
                'Barangay First Aid Station',
                'On-site Workplace First Aid',
                'Clinic First Aid Area',
                'NONE'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->first_aid_station == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->first_aid_station &&
                    !in_array(
                        $response->first_aid_station,
                        ['Barangay First Aid Station','On-site Workplace First Aid','Clinic First Aid Area','NONE']
                    )
                )>
                Other
            </option>
        </select>

        <input type="text" name="first_aid_station_other"
               x-show="showOtherWHFirstAid"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify station"
               value="{{ in_array($response->first_aid_station, [
                    'Barangay First Aid Station',
                    'On-site Workplace First Aid',
                    'Clinic First Aid Area',
                    'NONE'
               ]) ? '' : $response->first_aid_station }}">
    </div>


    <!-- 🚓 PNP STATION -->
    <div x-data="{
        showOtherWHPNP:
            '{{ $response->pnp_station }}' !== '' &&
            ![
                'Moriones Tondo Police Station',
                'NONE'
            ].includes('{{ $response->pnp_station }}')
    }">

        <label class="block text-sm font-medium text-gray-700">PNP Station</label>

        <select name="pnp_station"
                class="w-full border rounded p-2"
                x-on:change="showOtherWHPNP = ($event.target.value === 'Other')">

            <option value="">-- Select Station --</option>

            <option value="Moriones Tondo Police Station"
                @selected($response->pnp_station == 'Moriones Tondo Police Station')}>
                Moriones Tondo Police Station
            </option>

            <option value="NONE"
                @selected($response->pnp_station == 'NONE')}>
                N/A
            </option>

            <option value="Other"
                @selected(
                    $response->pnp_station &&
                    !in_array($response->pnp_station, ['Moriones Tondo Police Station','NONE'])
                )>Other</option>
        </select>

        <input type="text" name="pnp_station_other"
               x-show="showOtherWHPNP"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify station"
               value="{{ in_array($response->pnp_station, ['Moriones Tondo Police Station','NONE']) ? '' : $response->pnp_station }}">
    </div>


    <!-- 🚨 PNP TEAM -->
    <div x-data="{
        showOtherWHPNPTeam:
            '{{ $response->pnp_team_unit }}' !== '' &&
            ![
                'Rapid Response Team',
                'Barangay Patrol',
                'Police Assistance Desk',
                'NONE'
            ].includes('{{ $response->pnp_team_unit }}')
    }">

        <label class="block text-sm font-medium text-gray-700">PNP Team</label>

        <select name="pnp_team_unit"
                class="w-full border rounded p-2"
                x-on:change="showOtherWHPNPTeam = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach ([
                'Rapid Response Team',
                'Barangay Patrol',
                'Police Assistance Desk',
                'NONE'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->pnp_team_unit == $opt)>
                    {{ $opt }}
                </option>
            @endforeach

            <option value="Other"
                @selected(
                    $response->pnp_team_unit &&
                    !in_array(
                        $response->pnp_team_unit,
                        ['Rapid Response Team','Barangay Patrol','Police Assistance Desk','NONE']
                    )
                )>
                Other
            </option>
        </select>

        <input type="text" name="pnp_team_unit_other"
               x-show="showOtherWHPNPTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->pnp_team_unit, [
                    'Rapid Response Team',
                    'Barangay Patrol',
                    'Police Assistance Desk',
                    'NONE'
               ]) ? '' : $response->pnp_team_unit }}">
    </div>


    <!-- 🚓 PNP PATROL UNITS -->
    <div>
        <label class="block text-sm font-medium text-gray-700">PNP Patrol Units</label>
        <input type="number" name="pnp_patrol_unit"
               value="{{ old('pnp_patrol_unit', $response->pnp_patrol_unit ?? '') }}"
               class="w-full border rounded p-2">
    </div>

</div>
