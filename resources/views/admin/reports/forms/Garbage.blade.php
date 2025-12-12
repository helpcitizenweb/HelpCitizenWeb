<!-- 🗑 Garbage RESPONSE FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Garbage'" x-cloak>

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🗑 Garbage Response Details</h4>

    <!-- ⭐ RESPONDING TEAM -->
    <div x-data="{
        showOtherGarbageTeam: '{{ $response->responding_team_complaints }}' !== '' &&
            ![
                'Barangay Solid Waste Unit',
                'Barangay Tanod',
                'Barangay Kagawad',
                'City Waste Management Office',
                'MMDA Waste Management',
                'NONE'
            ].includes('{{ $response->responding_team_complaints }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Responding Team</label>

        <select name="responding_team_complaints" class="w-full border rounded p-2"
            x-on:change="showOtherGarbageTeam = ($event.target.value === 'Other')">

            <option value="">-- Select Responding Team --</option>

            <option value="Barangay Solid Waste Unit" @selected($response->responding_team_complaints == 'Barangay Solid Waste Unit')>
                Barangay Solid Waste Unit
            </option>

            <option value="Barangay Tanod" @selected($response->responding_team_complaints == 'Barangay Tanod')}>
                Barangay Tanod
            </option>

            <option value="Barangay Kagawad" @selected($response->responding_team_complaints == 'Barangay Kagawad')}>
                Barangay Kagawad
            </option>

            <option value="City Waste Management Office" @selected($response->responding_team_complaints == 'City Waste Management Office')}>
                City Waste Management Office
            </option>

            <option value="MMDA Waste Management" @selected($response->responding_team_complaints == 'MMDA Waste Management')}>
                MMDA Waste Management
            </option>

            <option value="NONE" @selected($response->responding_team_complaints == 'NONE')}>
                N/A
            </option>

            <!-- OTHER -->
            <option value="Other"
                @selected($response->responding_team_complaints !== null &&
                    !in_array($response->responding_team_complaints, [
                        'Barangay Solid Waste Unit',
                        'Barangay Tanod',
                        'Barangay Kagawad',
                        'City Waste Management Office',
                        'MMDA Waste Management',
                        'NONE',
                    ]))>
                Other
            </option>

        </select>

        <!-- OTHER TEXT FIELD -->
        <input type="text" name="responding_team_complaints_other"
            x-show="showOtherGarbageTeam"
            class="w-full border rounded p-2 mt-2"
            placeholder="Specify team"
            value="{{ in_array($response->responding_team_complaints, [
                'Barangay Solid Waste Unit',
                'Barangay Tanod',
                'Barangay Kagawad',
                'City Waste Management Office',
                'MMDA Waste Management',
                'NONE',
            ])
                ? ''
                : $response->responding_team_complaints }}">
    </div>



    <!-- ⭐ ACTIONS TAKEN -->
    <div x-data="{
        showOtherGarbageActions: '{{ $response->complaints_actions }}' !== '' &&
            ![
                'Garbage Collected',
                'Issued Warning to Resident',
                'Scheduled Pickup',
                'Referred to City Waste Office',
                'NONE'
            ].includes('{{ $response->complaints_actions }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Actions Taken</label>

        <select name="complaints_actions" class="w-full border rounded p-2"
            x-on:change="showOtherGarbageActions = ($event.target.value === 'Other')">

            <option value="">-- Select Action --</option>

            <option value="Garbage Collected" @selected($response->complaints_actions == 'Garbage Collected')}>
                Garbage Collected
            </option>

            <option value="Issued Warning to Resident" @selected($response->complaints_actions == 'Issued Warning to Resident')}>
                Issued Warning to Resident
            </option>

            <option value="Scheduled Pickup" @selected($response->complaints_actions == 'Scheduled Pickup')}>
                Scheduled Pickup
            </option>

            <option value="Referred to City Waste Office" @selected($response->complaints_actions == 'Referred to City Waste Office')}>
                Referred to City Waste Office
            </option>

            <option value="NONE" @selected($response->complaints_actions == 'NONE')}>
                N/A
            </option>

            <!-- OTHER -->
            <option value="Other"
                @selected($response->complaints_actions !== null &&
                    !in_array($response->complaints_actions, [
                        'Garbage Collected',
                        'Issued Warning to Resident',
                        'Scheduled Pickup',
                        'Referred to City Waste Office',
                        'NONE',
                    ]))>
                Other
            </option>

        </select>

        <!-- OTHER TEXT FIELD -->
        <input type="text" name="complaints_actions_other"
            x-show="showOtherGarbageActions"
            class="w-full border rounded p-2 mt-2"
            placeholder="Specify action"
            value="{{ in_array($response->complaints_actions, [
                'Garbage Collected',
                'Issued Warning to Resident',
                'Scheduled Pickup',
                'Referred to City Waste Office',
                'NONE',
            ])
                ? ''
                : $response->complaints_actions }}">
    </div>

</div>
