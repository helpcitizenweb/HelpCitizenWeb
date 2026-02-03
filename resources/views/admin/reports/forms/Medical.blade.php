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
</div>
