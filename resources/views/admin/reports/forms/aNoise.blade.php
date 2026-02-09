<!-- 🗣 Noise RESPONSE FORM -->
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Noise'" x-cloak>

    <h4 class="text-lg font-semibold text-gray-700 mb-3">🗣 Noise Response Details</h4>

    <!-- Responding Team -->
    <div x-data="{
        showOtherNoiseTeam:
            '{{ $response->responding_team_complaints }}' !== '' &&
            ![
                'Barangay Tanod',
                'Barangay Kagawad',
                'Barangay Peace & Order Council',
                'PNP Officer',
                'NONE'
            ].includes('{{ $response->responding_team_complaints }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Responding Team</label>

        <select name="responding_team_complaints"
                class="w-full border rounded p-2"
                x-on:change="showOtherNoiseTeam = ($event.target.value === 'Other')">

            <option value="">-- Select Responding Team --</option>

            <option value="Barangay Tanod"
                @selected($response->responding_team_complaints == 'Barangay Tanod')>
                Barangay Tanod
            </option>

            <option value="Barangay Kagawad"
                @selected($response->responding_team_complaints == 'Barangay Kagawad')>
                Barangay Kagawad
            </option>

            <option value="Barangay Peace & Order Council"
                @selected($response->responding_team_complaints == 'Barangay Peace & Order Council')>
                Peace & Order Council
            </option>

            <option value="PNP Officer"
                @selected($response->responding_team_complaints == 'PNP Officer')>
                PNP Officer
            </option>

            <option value="NONE"
                @selected($response->responding_team_complaints == 'NONE')>
                N/A
            </option>

            <!-- Other -->
            <option value="Other"
                @selected(
                    $response->responding_team_complaints &&
                    !in_array(
                        $response->responding_team_complaints,
                        ['Barangay Tanod','Barangay Kagawad','Barangay Peace & Order Council','PNP Officer','NONE']
                    )
                )>
                Other
            </option>

        </select>

        <!-- Other textbox -->
        <input type="text"
               name="responding_team_complaints_other"
               x-show="showOtherNoiseTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->responding_team_complaints, [
                    'Barangay Tanod',
                    'Barangay Kagawad',
                    'Barangay Peace & Order Council',
                    'PNP Officer',
                    'NONE',
               ]) ? '' : $response->responding_team_complaints }}">
    </div>


    <!-- Actions Taken -->
    <div x-data="{
        showOtherNoiseActions:
            '{{ $response->complaints_actions }}' !== '' &&
            ![
                'Verbal Warning',
                'Settlement / Mediation',
                'Issued Citation',
                'Reported to PNP',
                'Advised to Lower Noise',
                'NONE'
            ].includes('{{ $response->complaints_actions }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Actions Taken</label>

        <select name="complaints_actions"
                class="w-full border rounded p-2"
                x-on:change="showOtherNoiseActions = ($event.target.value === 'Other')">

            <option value="">-- Select Action --</option>

            <option value="Verbal Warning"
                @selected($response->complaints_actions == 'Verbal Warning')>
                Verbal Warning
            </option>

            <option value="Settlement / Mediation"
                @selected($response->complaints_actions == 'Settlement / Mediation')>
                Settlement / Mediation
            </option>

            <option value="Issued Citation"
                @selected($response->complaints_actions == 'Issued Citation')>
                Issued Citation
            </option>

            <option value="Reported to PNP"
                @selected($response->complaints_actions == 'Reported to PNP')>
                Reported to PNP
            </option>

            <option value="Advised to Lower Noise"
                @selected($response->complaints_actions == 'Advised to Lower Noise')>
                Advised to Lower Noise
            </option>

            <option value="NONE"
                @selected($response->complaints_actions == 'NONE')>
                N/A
            </option>

            <!-- Other -->
            <option value="Other"
                @selected(
                    $response->complaints_actions &&
                    !in_array(
                        $response->complaints_actions,
                        ['Verbal Warning','Settlement / Mediation','Issued Citation','Reported to PNP','Advised to Lower Noise','NONE']
                    )
                )>
                Other
            </option>

        </select>

        <!-- Other textbox -->
        <input type="text"
               name="complaints_actions_other"
               x-show="showOtherNoiseActions"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify action"
               value="{{ in_array($response->complaints_actions, [
                    'Verbal Warning',
                    'Settlement / Mediation',
                    'Issued Citation',
                    'Reported to PNP',
                    'Advised to Lower Noise',
                    'NONE',
               ]) ? '' : $response->complaints_actions }}">
    </div>

</div>
