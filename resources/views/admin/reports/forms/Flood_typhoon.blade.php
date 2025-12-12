<!-- 🌊 FLOOD & TYPHOON FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Flood_typhoon'" x-cloak class="space-y-4">

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🌊 Flood & Typhoon Response Details</h4>

    {{-- Evacuation Address --}}
    <div x-data="{ showOther: !['Barangay 41 Barangay Hall','Nearby School / Gym','Open Grounds','High Ground Area','Evacuation Center',''].includes('{{ $response->evacuation_address }}') }">
        <label class="block text-sm font-medium text-gray-700">Evacuation Address</label>

        <select name="evacuation_address" class="w-full border rounded p-2"
                x-on:change="showOther = ($event.target.value === 'Other')">

            <option value="">-- Select Location --</option>

            @foreach(['Barangay 41 Barangay Hall','Nearby School / Gym','Open Grounds','High Ground Area','Evacuation Center'] as $opt)
                <option value="{{ $opt }}" @selected($response->evacuation_address == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other" @selected(!in_array($response->evacuation_address, ['Barangay 41 Barangay Hall','Nearby School / Gym','Open Grounds','High Ground Area','Evacuation Center']))>
                Other
            </option>
        </select>

        <input type="text" name="evacuation_address_other" x-show="showOther"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify location"
               value="{{ !in_array($response->evacuation_address, ['Barangay 41 Barangay Hall','Nearby School / Gym','Open Grounds','High Ground Area','Evacuation Center']) ? $response->evacuation_address : '' }}">
    </div>

    {{-- Medical Response --}}
    <div x-data="{ showOther: !['Philippine Red Cross','Tondo Medical Center','Metropolitan Medical Center','Mary Johnston Hospital','Tondo Foreshore Health Center','Fugoso Health Center','NONE',''].includes('{{ $response->medical_response }}') }">
        <label class="block text-sm font-medium text-gray-700">Medical Response</label>

        <select name="medical_response" class="w-full border rounded p-2"
                x-on:change="showOther = ($event.target.value === 'Other')">

            <option value="">-- Select Medical Response --</option>

            @foreach(['Philippine Red Cross','Tondo Medical Center','Metropolitan Medical Center','Mary Johnston Hospital','Tondo Foreshore Health Center','Fugoso Health Center','NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->medical_response == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other" @selected(!in_array($response->medical_response, ['Philippine Red Cross','Tondo Medical Center','Metropolitan Medical Center','Mary Johnston Hospital','Tondo Foreshore Health Center','Fugoso Health Center','NONE']))>
                Other
            </option>
        </select>

        <input type="text" name="medical_response_other" x-show="showOther"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify medical response"
               value="{{ !in_array($response->medical_response, ['Philippine Red Cross','Tondo Medical Center','Metropolitan Medical Center','Mary Johnston Hospital','Tondo Foreshore Health Center','Fugoso Health Center','NONE']) ? $response->medical_response : '' }}">
    </div>

    <!-- 🩺 MEDICAL RESPONSE -->
<div x-data="{
    showOtherMed:
        '{{ $response->medical_response }}' &&
        ![
            'Philippine Red Cross',
            'Barangay Health Worker (BHW)',
            'Ambulance Team',
            'Medical Rescue Team'
        ].includes('{{ $response->medical_response }}')
}">

    <label class="block text-sm font-medium text-gray-700">Medical Response</label>

    <select name="medical_response"
            class="w-full border rounded p-2"
            x-on:change="showOtherMed = ($event.target.value === 'Other')">

        <option value="">-- Select Medical Response --</option>

        @foreach ([
            'Philippine Red Cross',
            'Barangay Health Worker (BHW)',
            'Ambulance Team',
            'Medical Rescue Team'
        ] as $opt)
            <option value="{{ $opt }}" @selected($response->medical_response == $opt)>
                {{ $opt }}
            </option>
        @endforeach

        <option value="Other"
                @selected(
                    $response->medical_response &&
                    !in_array($response->medical_response, [
                        'Philippine Red Cross',
                        'Barangay Health Worker (BHW)',
                        'Ambulance Team',
                        'Medical Rescue Team'
                    ])
                )>
            Other
        </option>

    </select>

    <input type="text"
           name="medical_response_other"
           x-show="showOtherMed"
           class="w-full border rounded p-2 mt-2"
           placeholder="Specify medical response"
           value="{{ in_array($response->medical_response, [
                'Philippine Red Cross',
                'Barangay Health Worker (BHW)',
                'Ambulance Team',
                'Medical Rescue Team'
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

    {{-- Hospital Address --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Hospital Address</label>
        <input type="text" name="hospital_address" class="w-full border rounded p-2"
               value="{{ $response->hospital_address }}">
    </div>

    {{-- Evacuation Transport --}}
    <div x-data="{ showOther: !['Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','Rescue Boat','Evacuation Truck','NONE',''].includes('{{ $response->evacuation_transport }}') }">
        <label class="block text-sm font-medium text-gray-700">Vehicle Transport</label>

        <select name="evacuation_transport" class="w-full border rounded p-2"
                x-on:change="showOther = ($event.target.value === 'Other')">

            <option value="">-- Select Transport --</option>

            @foreach(['Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','Rescue Boat','Evacuation Truck','NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->evacuation_transport == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other" @selected(!in_array($response->evacuation_transport, ['Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','Rescue Boat','Evacuation Truck','NONE']))>
                Other
            </option>

        </select>

        <input type="text" name="evacuation_transport_other" x-show="showOther"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify transport"
               value="{{ !in_array($response->evacuation_transport, ['Barangay Service Vehicle','Ambulance','Police Vehicle','Fire Truck','Rescue Boat','Evacuation Truck','NONE']) ? $response->evacuation_transport : '' }}">
    </div>

    {{-- Transport Units --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Transport Units</label>
        <input type="number" name="evacuation_transport_unit"
               class="w-full border rounded p-2"
               value="{{ $response->evacuation_transport_unit }}">
    </div>

    {{-- Water Rescue Response Unit --}}
    <div x-data="{ showOther: !['BFP Water Rescue','Philippine Coast Guard','Barangay Rescue Unit','MMDA Rescue','NONE',''].includes('{{ $response->water_rescue_response_unit }}') }">
        <label class="block text-sm font-medium text-gray-700">Water Rescue Response Unit</label>

        <select name="water_rescue_response_unit" class="w-full border rounded p-2"
                x-on:change="showOther = ($event.target.value === 'Other')">

            <option value="">-- Select Unit --</option>

            @foreach(['BFP Water Rescue','Philippine Coast Guard','Barangay Rescue Unit','MMDA Rescue','NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->water_rescue_response_unit == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other" @selected(!in_array($response->water_rescue_response_unit, ['BFP Water Rescue','Philippine Coast Guard','Barangay Rescue Unit','MMDA Rescue','NONE']))>
                Other
            </option>
        </select>

        <input type="text" name="water_rescue_response_unit_other" x-show="showOther"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify rescue unit"
               value="{{ !in_array($response->water_rescue_response_unit, ['BFP Water Rescue','Philippine Coast Guard','Barangay Rescue Unit','MMDA Rescue','NONE']) ? $response->water_rescue_response_unit : '' }}">
    </div>

    {{-- Rubber Boat Units --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Rubber Boat Units</label>
        <input type="number" name="rubber_boat_units" class="w-full border rounded p-2"
               value="{{ $response->rubber_boat_units }}">
    </div>

    {{-- Lifeguard Rescue Personnel --}}
    <div x-data="{ showOther: !['Barangay Lifeguard Team','MMDA Lifeguard Team','Volunteer Lifeguard Team','NONE',''].includes('{{ $response->lifeguard_rescue_personnel }}') }">
        <label class="block text-sm font-medium text-gray-700">Lifeguard Rescue Personnel</label>

        <select name="lifeguard_rescue_personnel" class="w-full border rounded p-2"
                x-on:change="showOther = ($event.target.value === 'Other')">

            <option value="">-- Select Personnel --</option>

            @foreach(['Barangay Lifeguard Team','MMDA Lifeguard Team','Volunteer Lifeguard Team','NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->lifeguard_rescue_personnel == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other" @selected(!in_array($response->lifeguard_rescue_personnel, ['Barangay Lifeguard Team','MMDA Lifeguard Team','Volunteer Lifeguard Team','NONE']))>
                Other
            </option>
        </select>

        <input type="text" name="lifeguard_rescue_personnel_other" x-show="showOther"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify personnel"
               value="{{ !in_array($response->lifeguard_rescue_personnel, ['Barangay Lifeguard Team','MMDA Lifeguard Team','Volunteer Lifeguard Team','NONE']) ? $response->lifeguard_rescue_personnel : '' }}">
    </div>

    {{-- Search & Rescue Team --}}
    <div x-data="{ showOther: !['BFP Rescue','Philippine Coast Guard Rescue','Barangay Search & Rescue','Volunteer Rescue Group','NONE',''].includes('{{ $response->search_rescue_team }}') }">
        <label class="block text-sm font-medium text-gray-700">Search & Rescue Team</label>

        <select name="search_rescue_team" class="w-full border rounded p-2"
                x-on:change="showOther = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach(['BFP Rescue','Philippine Coast Guard Rescue','Barangay Search & Rescue','Volunteer Rescue Group','NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->search_rescue_team == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other" @selected(!in_array($response->search_rescue_team, ['BFP Rescue','Philippine Coast Guard Rescue','Barangay Search & Rescue','Volunteer Rescue Group','NONE']))>
                Other
            </option>
        </select>

        <input type="text" name="search_rescue_team_other" x-show="showOther"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ !in_array($response->search_rescue_team, ['BFP Rescue','Philippine Coast Guard Rescue','Barangay Search & Rescue','Volunteer Rescue Group','NONE']) ? $response->search_rescue_team : '' }}">
    </div>

    {{-- Safety & Security --}}
    <div x-data="{ showOther: !['Barangay Tanod','PNP Patrol Unit','Barangay Safety Officer','NONE',''].includes('{{ $response->safety_and_security }}') }">
        <label class="block text-sm font-medium text-gray-700">Safety and Security Team</label>

        <select name="safety_and_security" class="w-full border rounded p-2"
                x-on:change="showOther = ($event.target.value === 'Other')">

            <option value="">-- Select Team --</option>

            @foreach(['Barangay Tanod','PNP Patrol Unit','Barangay Safety Officer','NONE'] as $opt)
                <option value="{{ $opt }}" @selected($response->safety_and_security == $opt)>{{ $opt }}</option>
            @endforeach

            <option value="Other" @selected(!in_array($response->safety_and_security, ['Barangay Tanod','PNP Patrol Unit','Barangay Safety Officer','NONE']))>
                Other
            </option>
        </select>

        <input type="text" name="safety_and_security_other" x-show="showOther"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ !in_array($response->safety_and_security, ['Barangay Tanod','PNP Patrol Unit','Barangay Safety Officer','NONE']) ? $response->safety_and_security : '' }}">
    </div>

    {{-- Relief Welfare (Checkboxes) --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Relief Welfare</label>

        @php
            $relief = collect(explode(',', $response->relief_welfare ?? ''));
        @endphp

        <div class="space-y-1">
            @foreach(['Food Packs','Drinks','Medicine','Hygiene Kits'] as $item)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="relief_welfare[]" value="{{ $item }}"
                           @checked($relief->contains($item))>
                    <span>{{ $item }}</span>
                </label>
            @endforeach
        </div>
    </div>

</div>
