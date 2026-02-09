{{-- resources/views/admin/reports/forms/harassment.blade.php --}}
@php
    $response = $response ?? new \App\Models\Response();
@endphp
<div x-show="dispatchUnit === 'Harassment'" x-cloak class="space-y-4">


    <h4 class="text-lg font-semibold text-gray-700 mb-3">
        👊😡 Harassment Response Details
    </h4>

    {{-- ========================= --}}
    {{-- RESPONDING TEAM           --}}
    {{-- ========================= --}}
    <div x-data="{
        showOtherHarassTeam: '{{ $response->responding_team_complaints }}' !== '' &&
            ![
                'Barangay Tanod',
                'Barangay Kagawad',
                'Barangay Peace & Order Council',
                'Violence Against Women Desk',
                'PNP Officer',
                'NONE'
            ].includes('{{ $response->responding_team_complaints }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Responding Team</label>

        <select name="responding_team_complaints" class="w-full border rounded p-2"
                x-on:change="showOtherHarassTeam = ($event.target.value === 'Other')">

            <option value="">-- Select Responding Team --</option>

            <option value="Barangay Tanod" @selected($response->responding_team_complaints == 'Barangay Tanod')>
                Barangay Tanod
            </option>

            <option value="Barangay Kagawad" @selected($response->responding_team_complaints == 'Barangay Kagawad')}>
                Barangay Kagawad
            </option>

            <option value="Barangay Peace & Order Council" @selected($response->responding_team_complaints == 'Barangay Peace & Order Council')}>
                Barangay Peace & Order Council
            </option>

            <option value="Violence Against Women Desk" @selected($response->responding_team_complaints == 'Violence Against Women Desk')}>
                Violence Against Women Desk
            </option>

            <option value="PNP Officer" @selected($response->responding_team_complaints == 'PNP Officer')}>
                PNP Officer
            </option>

            <option value="NONE" @selected($response->responding_team_complaints == 'NONE')}>
                N/A
            </option>

            {{-- OTHER --}}
            <option value="Other"
                @selected($response->responding_team_complaints !== null &&
                    !in_array($response->responding_team_complaints, [
                        'Barangay Tanod',
                        'Barangay Kagawad',
                        'Barangay Peace & Order Council',
                        'Violence Against Women Desk',
                        'PNP Officer',
                        'NONE'
                    ])
                )>
                Other
            </option>
        </select>

        {{-- OTHER INPUT --}}
        <input type="text"
               name="responding_team_complaints_other"
               x-show="showOtherHarassTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->responding_team_complaints, [
                   'Barangay Tanod',
                   'Barangay Kagawad',
                   'Barangay Peace & Order Council',
                   'Violence Against Women Desk',
                   'PNP Officer',
                   'NONE',
               ]) ? '' : $response->responding_team_complaints }}">
    </div>


    {{-- ========================= --}}
    {{-- ACTIONS TAKEN             --}}
    {{-- ========================= --}}
    <div x-data="{
        showOtherHarassActions: '{{ $response->complaints_actions }}' !== '' &&
            ![
                'Counseling / Mediation',
                'Issued Warning',
                'Elevated to Barangay Hearing',
                'Referred to VAW Desk',
                'Reported to PNP',
                'NONE'
            ].includes('{{ $response->complaints_actions }}')
    }">

        <label class="block text-sm font-medium text-gray-700">Actions Taken</label>

        <select name="complaints_actions" class="w-full border rounded p-2"
                x-on:change="showOtherHarassActions = ($event.target.value === 'Other')">

            <option value="">-- Select Action --</option>

            <option value="Counseling / Mediation" @selected($response->complaints_actions == 'Counseling / Mediation')}>
                Counseling / Mediation
            </option>

            <option value="Issued Warning" @selected($response->complaints_actions == 'Issued Warning')}>
                Issued Warning
            </option>

            <option value="Elevated to Barangay Hearing" @selected($response->complaints_actions == 'Elevated to Barangay Hearing')}>
                Elevated to Barangay Hearing
            </option>

            <option value="Referred to VAW Desk" @selected($response->complaints_actions == 'Referred to VAW Desk')}>
                Referred to VAW Desk
            </option>

            <option value="Reported to PNP" @selected($response->complaints_actions == 'Reported to PNP')}>
                Reported to PNP
            </option>

            <option value="NONE" @selected($response->complaints_actions == 'NONE')}>
                N/A
            </option>

            {{-- OTHER --}}
            <option value="Other"
                @selected($response->complaints_actions !== null &&
                    !in_array($response->complaints_actions, [
                        'Counseling / Mediation',
                        'Issued Warning',
                        'Elevated to Barangay Hearing',
                        'Referred to VAW Desk',
                        'Reported to PNP',
                        'NONE'
                    ])
                )>
                Other
            </option>
        </select>

        {{-- OTHER INPUT --}}
        <input type="text"
               name="complaints_actions_other"
               x-show="showOtherHarassActions"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify action"
               value="{{ in_array($response->complaints_actions, [
                   'Counseling / Mediation',
                   'Issued Warning',
                   'Elevated to Barangay Hearing',
                   'Referred to VAW Desk',
                   'Reported to PNP',
                   'NONE',
               ]) ? '' : $response->complaints_actions }}">
    </div>


    {{-- ========================= --}}
    {{-- PNP STATION               --}}
    {{-- ========================= --}}
    <div x-data="{
        showOtherStation: '{{ $response->pnp_station }}' !== '' &&
            ![
                'Moriones Tondo Police Station (PS1)',
                'Raxabago Police Substation',
                'Tondo Foreshore Substation',
                'Manila Police District – Station 1',
                'Baseco Police Substation',
                'NONE'
            ].includes('{{ $response->pnp_station }}')
    }">

        <label class="block text-sm font-medium text-gray-700">PNP Station</label>

        <select name="pnp_station" class="w-full border rounded p-2"
                x-on:change="showOtherStation = ($event.target.value === 'Other')">

            <option value="">-- Select Police Station --</option>

            <option value="Moriones Tondo Police Station (PS1)"
                @selected($response->pnp_station == 'Moriones Tondo Police Station (PS1)')}>
                Moriones Tondo Police Station (PS1)
            </option>

            <option value="Raxabago Police Substation"
                @selected($response->pnp_station == 'Raxabago Police Substation')}>
                Raxabago Police Substation
            </option>

            <option value="Tondo Foreshore Substation"
                @selected($response->pnp_station == 'Tondo Foreshore Substation')}>
                Tondo Foreshore Substation
            </option>

            <option value="Manila Police District – Station 1"
                @selected($response->pnp_station == 'Manila Police District – Station 1')}>
                Manila Police District – Station 1
            </option>

            <option value="Baseco Police Substation"
                @selected($response->pnp_station == 'Baseco Police Substation')}>
                Baseco Police Substation
            </option>

            <option value="NONE" @selected($response->pnp_station == 'NONE')}>
                N/A
            </option>

            <option value="Other"
                @selected($response->pnp_station !== null &&
                    !in_array($response->pnp_station, [
                        'Moriones Tondo Police Station (PS1)',
                        'Raxabago Police Substation',
                        'Tondo Foreshore Substation',
                        'Manila Police District – Station 1',
                        'Baseco Police Substation',
                        'NONE'
                ]))>
                Other
            </option>
        </select>

        <input type="text"
               name="pnp_station_other"
               x-show="showOtherStation"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify station"
               value="{{ in_array($response->pnp_station, [
                   'Moriones Tondo Police Station (PS1)',
                   'Raxabago Police Substation',
                   'Tondo Foreshore Substation',
                   'Manila Police District – Station 1',
                   'Baseco Police Substation',
                   'NONE'
               ]) ? '' : $response->pnp_station }}">
    </div>


    {{-- ========================= --}}
    {{-- PNP TEAM UNIT             --}}
    {{-- ========================= --}}
    <div x-data="{
        showOtherPNPTeam: '{{ $response->pnp_team_unit }}' !== '' &&
            ![
                'Beat Patrol',
                'Mobile Patrol Unit',
                'Barangay Patrol',
                'Women & Children Protection Desk (WCPD)',
                'Quick Response Team',
                'Special Operations Unit',
                'SWAT',
                'NONE'
            ].includes('{{ $response->pnp_team_unit }}')
    }">

        <label class="block text-sm font-medium text-gray-700">PNP Team</label>

        <select name="pnp_team_unit" class="w-full border rounded p-2"
                x-on:change="showOtherPNPTeam = ($event.target.value === 'Other')">

            <option value="">-- Select PNP Team --</option>

            <option value="Beat Patrol" @selected($response->pnp_team_unit == 'Beat Patrol')}>
                Beat Patrol
            </option>

            <option value="Mobile Patrol Unit" @selected($response->pnp_team_unit == 'Mobile Patrol Unit')}>
                Mobile Patrol Unit
            </option>

            <option value="Barangay Patrol" @selected($response->pnp_team_unit == 'Barangay Patrol')}>
                Barangay Patrol
            </option>

            <option value="Women & Children Protection Desk (WCPD)"
                @selected($response->pnp_team_unit == 'Women & Children Protection Desk (WCPD)')}>
                Women & Children Protection Desk (WCPD)
            </option>

            <option value="Quick Response Team" @selected($response->pnp_team_unit == 'Quick Response Team')}>
                Quick Response Team
            </option>

            <option value="Special Operations Unit" @selected($response->pnp_team_unit == 'Special Operations Unit')}>
                Special Operations Unit
            </option>

            <option value="SWAT" @selected($response->pnp_team_unit == 'SWAT')}>
                SWAT
            </option>

            <option value="NONE" @selected($response->pnp_team_unit == 'NONE')}>
                N/A
            </option>

            <option value="Other"
                @selected($response->pnp_team_unit !== null &&
                    !in_array($response->pnp_team_unit, [
                        'Beat Patrol',
                        'Mobile Patrol Unit',
                        'Barangay Patrol',
                        'Women & Children Protection Desk (WCPD)',
                        'Quick Response Team',
                        'Special Operations Unit',
                        'SWAT',
                        'NONE'
                ]))>
                Other
            </option>
        </select>

        <input type="text"
               name="pnp_team_unit_other"
               x-show="showOtherPNPTeam"
               class="w-full border rounded p-2 mt-2"
               placeholder="Specify team"
               value="{{ in_array($response->pnp_team_unit, [
                   'Beat Patrol',
                   'Mobile Patrol Unit',
                   'Barangay Patrol',
                   'Women & Children Protection Desk (WCPD)',
                   'Quick Response Team',
                   'Special Operations Unit',
                   'SWAT',
                   'NONE'
               ]) ? '' : $response->pnp_team_unit }}">
    </div>


    {{-- ========================= --}}
    {{-- PNP PATROL UNITS          --}}
    {{-- ========================= --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">PNP Patrol Units</label>
        <input type="number" name="pnp_patrol_unit"
               class="w-full border rounded p-2"
               value="{{ old('pnp_patrol_unit', $response->pnp_patrol_unit ?? '') }}">
    </div>

</div>
