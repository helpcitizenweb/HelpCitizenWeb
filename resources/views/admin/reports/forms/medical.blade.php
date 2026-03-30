<!-- 🩺 MEDICAL RESPONSE FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Medical'" x-cloak class="space-y-4">

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🩺 Responding Medical Authority</h4>

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

    <!-- Designated Hospitals -->
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

    <!-- First Aid Station -->
    <div x-data="{
        showOtherFirstAid:
            '{{ $response->first_aid_station }}' !== '' &&
            ![
                'Barangay 41 Barangay Hall',
                'Nearby Health Center',
                'On-Site Medical Tent',
                'Hospital Emergency Room',
                'NONE'
            ].includes('{{ $response->first_aid_station }}')
    }">

        <label class="block text-sm font-medium text-gray-700">First Aid Station</label>

        <select name="first_aid_station" class="w-full border rounded p-2"
                x-on:change="showOtherFirstAid = ($event.target.value === 'Other')">

            <option value="">-- Select Location --</option>

            @foreach ([
                'Barangay 41 Barangay Hall',
                'Nearby Health Center',
                'On-Site Medical Tent',
                'Hospital Emergency Room',
                'NONE'
            ] as $opt)
                <option value="{{ $opt }}" @selected($response->first_aid_station == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other"
                    @selected(!in_array($response->first_aid_station, [
                        'Barangay 41 Barangay Hall','Nearby Health Center',
                        'On-Site Medical Tent','Hospital Emergency Room','NONE'
                    ]) && $response->first_aid_station)>
                Other
            </option>

        </select>

        <input type="text" name="first_aid_station_other"
               x-show="showOtherFirstAid"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify station"
               value="{{ in_array($response->first_aid_station, [
                    'Barangay 41 Barangay Hall','Nearby Health Center','On-Site Medical Tent',
                    'Hospital Emergency Room','NONE'
               ]) ? '' : $response->first_aid_station }}">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Ambulance Units</label>
        <input type="number"
               name="ambulance_units"
               class="w-full border rounded p-2"
               value="{{ old('ambulance_units', $response->ambulance_units ?? '') }}">
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


     <!-- PNP Patrol Unitss -->
    <div>
        <label class="block text-sm font-medium text-gray-700">PNP Patrol Units</label>
        <input type="number" name="pnp_patrol_unit"
               value="{{ $response->pnp_patrol_unit }}"
               class="w-full border rounded p-2">
    </div>


</div>
