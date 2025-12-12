{{-- resolution.blade.php --}}
<div x-data="{ dispatchUnit: '{{ $report->dispatch_unit }}' }" class="space-y-4">


    <!-- Dispatch Unit -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Response category</label>

        <select name="dispatch_unit" class="w-full border rounded p-2" x-model="dispatchUnit">

            <option value="">Select dispatch unit</option>

            <!-- Natural Disasters -->
            <option value="Fire">Fire Response</option>
            <option value="Flood_typhoon">Flood & Typhoon</option>
            <option value="Earthquake">Earthquake</option>
            <option value="Medical">Medical Response</option>

            <!-- Accidents -->
            <option value="Traffic">Traffic Response</option>
            <option value="Workplace_Home">Workplace & Home</option>

            <!-- Complaints -->
            <option value="Noise">Noise</option>
            <option value="Harassment">Harassment</option>
            <option value="Garbage">Garbage</option>
            <!-- Suggestions -->
            <option value="Services">Services</option>
        </select>
    </div>

    <!-- Overseer -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Overseer</label>

        <select name="overseer" class="w-full border rounded p-2">
            <option value="">-- Select Overseer --</option>
            <option value="Barangay Chairman Erwin Lapaz">Barangay Chairman Erwin Lapaz</option>
            <option value="Barangay Kapitan">Barangay Kapitan</option>
            <option value="Barangay Kagawad">Barangay Kagawad</option>
            <option value="Barangay Tanod">Barangay Tanod</option>
            <option value="Barangay Secretary">Barangay Secretary</option>
            <option value="Barangay Treasurer">Barangay Treasurer</option>
            <option value="Barangay Administrator">Barangay Administrator</option>
            <option value="Barangay Health Worker (BHW)">Barangay Health Worker (BHW)</option>
            <option value="Barangay Rescue Team Leader">Barangay Rescue Team Leader</option>
            <option value="BDRRM Officer">BDRRM Officer</option>
            <option value="PNP Officer">PNP Officer</option>
            <option value="Fire Officer">Fire Officer</option>
        </select>
    </div>

    <!-- Contact Person -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Contact Person</label>
        <input type="text" name="contact_person" value="{{ $report->contact_person }}"
            class="w-full border rounded p-2">
    </div>

    <!-- Contact Number -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
        <input type="text" name="contact_number" value="{{ $report->contact_number }}" maxlength="11"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full border rounded p-2">
    </div>

    <!-- 🌟 LOAD SPECIFIC FORM BASED ON SELECTION -->

    <!-- 🌟 Emergencies SELECTION -->
    <template x-if="dispatchUnit === 'Fire'">
        @include('admin.reports.forms.fire')
    </template>

    <template x-if="dispatchUnit === 'Flood_typhoon'">
        @include('admin.reports.forms.flood_typhoon')
    </template>

    <template x-if="dispatchUnit === 'Earthquake'">
        @include('admin.reports.forms.earthquake')
    </template>
    <template x-if="dispatchUnit === 'Medical'">
        @include('admin.reports.forms.medical')
    </template>


    <!-- 🌟 Accidents SELECTION Workplace_Home -->

    <template x-if="dispatchUnit === 'Traffic'">
        @include('admin.reports.forms.traffic')
    </template>

    <template x-if="dispatchUnit === 'Workplace_Home'">
        @include('admin.reports.forms.workplace_home')
    </template>

    <!-- 🌟 Complaints SELECTION -->
    <template x-if="dispatchUnit === 'Harassment'">
        @include('admin.reports.forms.harassment')
    </template>


    <template x-if="dispatchUnit === 'Noise'">
        @include('admin.reports.forms.noise')
    </template>

    <template x-if="dispatchUnit === 'Garbage'">
        @include('admin.reports.forms.garbage')
    </template>

    <!-- 🌟 Services SELECTION -->
    <template x-if="dispatchUnit === 'Services'">
        @include('admin.reports.forms.services')
    </template>
</div>
