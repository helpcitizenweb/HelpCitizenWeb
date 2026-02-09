<!-- 🛠️ SERVICES RESPONSE FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Services'" x-cloak>

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🛠️ Services Response Details</h4>

    <!-- ⭐ RESPONDING TEAM -->
    <div x-data="{
        showOtherServTeam:
            '{{ $response->responding_team_suggestion }}' !== '' &&
            ![
                'Barangay Maintenance Crew',
                'Barangay Construction Team',
                'Barangay Infrastructure Committee',
                'City Engineering Office',
                'City Public Works',
                'NONE'
            ].includes('{{ $response->responding_team_suggestion }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Responding Team</label>

        <select name="responding_team_suggestion" class="w-full border rounded p-2"
                x-on:change="showOtherServTeam = ($event.target.value === 'Other')">

            <option value="">-- Select Responding Team --</option>

            <option value="Barangay Maintenance Crew"
                @selected($response->responding_team_suggestion == 'Barangay Maintenance Crew')}>
                Barangay Maintenance Crew
            </option>

            <option value="Barangay Construction Team"
                @selected($response->responding_team_suggestion == 'Barangay Construction Team')}>
                Barangay Construction Team
            </option>

            <option value="Barangay Infrastructure Committee"
                @selected($response->responding_team_suggestion == 'Barangay Infrastructure Committee')}>
                Infrastructure Committee
            </option>

            <option value="City Engineering Office"
                @selected($response->responding_team_suggestion == 'City Engineering Office')}>
                City Engineering Office
            </option>

            <option value="City Public Works"
                @selected($response->responding_team_suggestion == 'City Public Works')}>
                City Public Works
            </option>

            <option value="NONE" @selected($response->responding_team_suggestion == 'NONE')}>
                N/A
            </option>

            <!-- OTHER -->
            <option value="Other"
                @selected(
                    $response->responding_team_suggestion !== null &&
                    !in_array($response->responding_team_suggestion, [
                        'Barangay Maintenance Crew',
                        'Barangay Construction Team',
                        'Barangay Infrastructure Committee',
                        'City Engineering Office',
                        'City Public Works',
                        'NONE'
                    ])
                )>
                Other
            </option>
        </select>

        <!-- Other textbox -->
        <input type="text" name="responding_team_suggestion_other"
               x-show="showOtherServTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify responding team"
               value="{{ in_array($response->responding_team_suggestion, [
                   'Barangay Maintenance Crew',
                   'Barangay Construction Team',
                   'Barangay Infrastructure Committee',
                   'City Engineering Office',
                   'City Public Works',
                   'NONE'
               ])
                   ? ''
                   : $response->responding_team_suggestion }}">
    </div>



    <!-- ⭐ INSPECTION DATE -->
    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Inspection Date</label>
        <input type="date" name="inspection_date"
               value="{{ old('inspection_date', $response->inspection_date ?? '') }}"
               class="w-full border rounded p-2">
    </div>



    <!-- ⭐ RECOMMENDED ACTION -->
    <div class="mt-4"
        x-data="{
            showOtherServAction:
                '{{ $response->recommended_action }}' !== '' &&
                ![
                    'Repair Required',
                    'Maintenance Scheduled',
                    'Inspection Only',
                    'Follow-up Required',
                    'Referred to City Engineering',
                    'NONE'
                ].includes('{{ $response->recommended_action }}')
        }">

        <label class="block text-sm font-medium text-gray-700">Recommended Action</label>

        <select name="recommended_action" class="w-full border rounded p-2"
                x-on:change="showOtherServAction = ($event.target.value === 'Other')">

            <option value="">-- Select Action --</option>

            <option value="Repair Required"
                @selected($response->recommended_action == 'Repair Required')}>
                Repair Required
            </option>

            <option value="Maintenance Scheduled"
                @selected($response->recommended_action == 'Maintenance Scheduled')}>
                Maintenance Scheduled
            </option>

            <option value="Inspection Only"
                @selected($response->recommended_action == 'Inspection Only')}>
                Inspection Only
            </option>

            <option value="Follow-up Required"
                @selected($response->recommended_action == 'Follow-up Required')}>
                Follow-up Required
            </option>

            <option value="Referred to City Engineering"
                @selected($response->recommended_action == 'Referred to City Engineering')}>
                Referred to City Engineering
            </option>

            <option value="NONE" @selected($response->recommended_action == 'NONE')}>
                N/A
            </option>

            <!-- OTHER -->
            <option value="Other"
                @selected(
                    $response->recommended_action !== null &&
                    !in_array($response->recommended_action, [
                        'Repair Required',
                        'Maintenance Scheduled',
                        'Inspection Only',
                        'Follow-up Required',
                        'Referred to City Engineering',
                        'NONE'
                    ])
                )>
                Other
            </option>

        </select>

        <!-- OTHER FIELD -->
        <input type="text" name="recommended_action_other"
               x-show="showOtherServAction"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify action"
               value="{{ in_array($response->recommended_action, [
                   'Repair Required',
                   'Maintenance Scheduled',
                   'Inspection Only',
                   'Follow-up Required',
                   'Referred to City Engineering',
                   'NONE'
               ])
                   ? ''
                   : $response->recommended_action }}">
    </div>

</div>
