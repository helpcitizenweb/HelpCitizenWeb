@php
    use Illuminate\Support\Str;

    if (!function_exists('announcementMediaUrl')) {
        function announcementMediaUrl($media)
        {
            if (!$media) {
                return null;
            }

            // DigitalOcean Spaces (full URL)
            if (Str::startsWith($media, 'http')) {
                return $media;
            }

            // Ignore old local storage paths in production
            return null;
        }
    }
@endphp
@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto mt-8 bg-white p-8 rounded-2xl shadow-md">


        <!-- Header -->
        <div class="border-b pb-4 mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                ✏️ Edit Emergency Advisory
            </h1>
            <p class="text-gray-500 mt-2">
                Update preparedness, mitigation, and emergency advisories for residents.
            </p>
        </div>

        <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST"
            enctype="multipart/form-data" class="space-y-8">

            @csrf
            @method('PUT')

            <!-- GENERAL INFORMATION -->
            <div class="bg-gray-50 rounded-xl border p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    General Information
                </h2>

                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Title
                        </label>

                        <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-4 py-3"
                            value="{{ old('title', $announcement->title) }}">
                    </div>


                    <!--IMAGE-->
                    <!-- IMAGE -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Announcement Image
    </label>

    @php
    $imageUrl = announcementMediaUrl($announcement->image);
@endphp

@if ($imageUrl)
    <div class="mb-4">
        <p class="text-sm text-gray-500 mb-2">
            Current Image
        </p>

        <img
            src="{{ $imageUrl }}"
            alt="Current Announcement Image"
            class="w-full max-w-md h-56 object-cover rounded-lg border shadow-sm">
    </div>
@endif

    <input
        type="file"
        id="image"
        name="image"
        accept="image/*"
        class="w-full border border-gray-300 rounded-lg px-4 py-3">

    <!-- New Image Preview -->
    <div id="imagePreviewContainer" class="hidden mt-4">

        <p class="text-sm text-gray-500 mb-2">
            New Image Preview
        </p>

        <img
            id="imagePreview"
            src="#"
            alt="Image Preview"
            class="hidden w-full max-w-md h-56 object-cover rounded-lg border shadow-sm">

        <!-- Remove Selected Image -->
        <button
            type="button"
            id="removeImageBtn"
            class="hidden mt-3 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            🗑 Remove Selected Image
        </button>

    </div>
</div>

                    <!--IMAGE-->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>

                        <textarea name="content" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-none">{{ old('content', $announcement->content) }}</textarea>
                    </div>

                </div>
            </div>

            <!-- EMERGENCY CLASSIFICATION -->
            <div class="bg-gray-50 rounded-xl border p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Emergency Classification
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Disaster Type
                        </label>

                        <select name="disaster_type" class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value=""
                                {{ old('disaster_type', $announcement->disaster_type) == '' ? 'selected' : '' }}>
                                Select Type
                            </option>

                            <option value="Fire"
                                {{ old('disaster_type', $announcement->disaster_type) == 'Fire' ? 'selected' : '' }}>
                                Fire
                            </option>

                            <option value="Flood"
                                {{ old('disaster_type', $announcement->disaster_type) == 'Flood' ? 'selected' : '' }}>
                                Flood
                            </option>

                            <option value="Earthquake"
                                {{ old('disaster_type', $announcement->disaster_type) == 'Earthquake' ? 'selected' : '' }}>
                                Earthquake
                            </option>

                            <option value="Typhoon"
                                {{ old('disaster_type', $announcement->disaster_type) == 'Typhoon' ? 'selected' : '' }}>
                                Typhoon
                            </option>

                            <option value="Gas Leak"
                                {{ old('disaster_type', $announcement->disaster_type) == 'Gas Leak' ? 'selected' : '' }}>
                                Gas Leak
                            </option>

                            <option value="Accident"
                                {{ old('disaster_type', $announcement->disaster_type) == 'Accident' ? 'selected' : '' }}>
                                Accident
                            </option>

                            <option value="General Advisory"
                                {{ old('disaster_type', $announcement->disaster_type) == 'General Advisory' ? 'selected' : '' }}>
                                General Advisory
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alert Level
                        </label>

                        <select name="alert_level" class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value=""
                                {{ old('alert_level', $announcement->alert_level) == '' ? 'selected' : '' }}>
                                Select Alert Level
                            </option>

                            <option value="Monitoring"
                                {{ old('alert_level', $announcement->alert_level) == 'Monitoring' ? 'selected' : '' }}>
                                Monitoring
                            </option>

                            <option value="Warning"
                                {{ old('alert_level', $announcement->alert_level) == 'Warning' ? 'selected' : '' }}>
                                Warning
                            </option>

                            <option value="Critical"
                                {{ old('alert_level', $announcement->alert_level) == 'Critical' ? 'selected' : '' }}>
                                Critical
                            </option>

                            <option value="Evacuation Required"
                                {{ old('alert_level', $announcement->alert_level) == 'Evacuation Required' ? 'selected' : '' }}>
                                Evacuation Required
                            </option>

                        </select>
                    </div>

                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Affected Area
                    </label>

                    <input type="text" name="affected_area" class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        value="{{ old('title', $announcement->affected_area) }}">
                </div>
            </div>

            <!-- MITIGATION INSTRUCTIONS -->
            <div class="bg-gray-50 rounded-xl border p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Mitigation Instructions
                </h2>

                <textarea name="instructions" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-none"
                    placeholder="Enter evacuation, preparedness, or safety instructions">{{ old('instructions', $announcement->instructions) }}</textarea>
            </div>

            <!-- COORDINATION INFORMATION -->
            <div class="bg-gray-50 rounded-xl border p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Coordination Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Evacuation Center
                        </label>

                    <select id="evacuation_center" name="evacuation_center"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3">

                        <option value="N/A"
                            {{ old('evacuation_center', $announcement->evacuation_center) == 'N/A' ? 'selected' : '' }}>
                            N/A
                        </option>

                        <option value="Barangay 41 Hall"
                            {{ old('evacuation_center', $announcement->evacuation_center) == 'Barangay 41 Hall' ? 'selected' : '' }}>
                            Barangay 41 Hall
                        </option>

                        <option value="Covered Court"
                            {{ old('evacuation_center', $announcement->evacuation_center) == 'Covered Court' ? 'selected' : '' }}>
                            Covered Court
                        </option>

                        <option value="Public School"
                            {{ old('evacuation_center', $announcement->evacuation_center) == 'Public School' ? 'selected' : '' }}>
                            Public School
                        </option>

                        <option value="City Designated Evacuation Center"
                            {{ old('evacuation_center', $announcement->evacuation_center) == 'City Designated Evacuation Center' ? 'selected' : '' }}>
                            City Designated Evacuation Center
                        </option>

                        <option value="Community Center"
                            {{ old('evacuation_center', $announcement->evacuation_center) == 'Community Center' ? 'selected' : '' }}>
                            Community Center
                        </option>

                        <option value="Church Facility"
                            {{ old('evacuation_center', $announcement->evacuation_center) == 'Church Facility' ? 'selected' : '' }}>
                            Church Facility
                        </option>

                        <option value="Other"
                            {{ old('evacuation_center', $announcement->evacuation_center) == 'Other' ? 'selected' : '' }}>
                            Other...
                        </option>

                    </select>
                    <input type="text"
        id="other_evacuation_center"
        class="hidden mt-3 w-full border border-gray-300 rounded-lg px-4 py-3"
        placeholder="Specify evacuation center">
</div>        



                    <!--start-->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Medical Facility
                        </label>

                        <select id="medical_facility_name" name="medical_facility_name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value="N/A"
                                {{ old('medical_facility_name', $announcement->medical_facility_name) == 'N/A' ? 'selected' : '' }}>
                                N/A
                            </option>

                            <option value="Tondo Medical Center"
                                {{ old('medical_facility_name', $announcement->medical_facility_name) == 'Tondo Medical Center' ? 'selected' : '' }}>
                                Tondo Medical Center
                            </option>

                            <option value="Metropolitan Medical Center"
                                {{ old('medical_facility_name', $announcement->medical_facility_name) == 'Metropolitan Medical Center' ? 'selected' : '' }}>
                                Metropolitan Medical Center
                            </option>

                            <option value="Mary Johnston Hospital"
                                {{ old('medical_facility_name', $announcement->medical_facility_name) == 'Mary Johnston Hospital' ? 'selected' : '' }}>
                                Mary Johnston Hospital
                            </option>

                            <option value="Tondo Foreshore Health Center"
                                {{ old('medical_facility_name', $announcement->medical_facility_name) == 'Tondo Foreshore Health Center' ? 'selected' : '' }}>
                                Tondo Foreshore Health Center
                            </option>

                            <option value="Fugoso Health Center"
                                {{ old('medical_facility_name', $announcement->medical_facility_name) == 'Fugoso Health Center' ? 'selected' : '' }}>
                                Fugoso Health Center
                            </option>

                            <option value="Philippine Red Cross"
                                {{ old('medical_facility_name', $announcement->medical_facility_name) == 'Philippine Red Cross' ? 'selected' : '' }}>
                                Philippine Red Cross
                            </option>

                            <option value="Other"
                                {{ old('medical_facility_name', $announcement->medical_facility_name) == 'Other' ? 'selected' : '' }}>
                                Other...
                            </option>

                        </select>

                        <input type="text" id="other_medical_facility"
                            class="hidden mt-3 w-full border border-gray-300 rounded-lg px-4 py-3"
                            placeholder="Specify medical facility">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Medical Contact
                        </label>

                        <select id="medical_facility_contact" name="medical_facility_contact"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value="N/A"
                                {{ old('medical_facility_contact', $announcement->medical_facility_contact) == 'N/A' ? 'selected' : '' }}>
                                N/A
                            </option>

                            <option value="(02) 8865 9000"
                                {{ old('medical_facility_contact', $announcement->medical_facility_contact) == '(02) 8865 9000' ? 'selected' : '' }}>
                                Tondo Medical Center - (02) 8865 9000
                            </option>

                            <option value="(02) 8863 2500"
                                {{ old('medical_facility_contact', $announcement->medical_facility_contact) == '(02) 8863 2500' ? 'selected' : '' }}>
                                Metropolitan Medical Center - (02) 8863 2500
                            </option>

                            <option value="(02) 5318 6600 / (02) 8245 4024"
                                {{ old('medical_facility_contact', $announcement->medical_facility_contact) == '(02) 5318 6600 / (02) 8245 4024' ? 'selected' : '' }}>
                                Mary Johnston Hospital - (02) 5318 6600
                            </option>

                            <option value="22545760"
                                {{ old('medical_facility_contact', $announcement->medical_facility_contact) == '22545760' ? 'selected' : '' }}>
                                Tondo Foreshore Health Center - 22545760
                            </option>

                            <option value="0928-673-1715"
                                {{ old('medical_facility_contact', $announcement->medical_facility_contact) == '0928-673-1715' ? 'selected' : '' }}>
                                Fugoso Health Center - 0928-673-1715
                            </option>

                            <option value="143"
                                {{ old('medical_facility_contact', $announcement->medical_facility_contact) == '143' ? 'selected' : '' }}>
                                Philippine Red Cross - 143
                            </option>

                            <option value="Other"
                                {{ old('medical_facility_contact', $announcement->medical_facility_contact) == 'Other' ? 'selected' : '' }}>
                                Other...
                            </option>

                        </select>

                        <input type="text" id="other_medical_contact"
                            class="hidden mt-3 w-full border border-gray-300 rounded-lg px-4 py-3"
                            placeholder="Specify contact number">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Issued By
                        </label>

                        <div>

<select id="issued_by"
        name="issued_by"
        class="w-full border border-gray-300 rounded-lg px-4 py-3">

    <option value="N/A"
        {{ old('issued_by', $announcement->issued_by) == 'N/A' ? 'selected' : '' }}>
        N/A
    </option>

    <option value="Barangay Captain"
        {{ old('issued_by', $announcement->issued_by) == 'Barangay Captain' ? 'selected' : '' }}>
        Barangay Captain
    </option>

    <option value="Barangay DRRM Committee"
        {{ old('issued_by', $announcement->issued_by) == 'Barangay DRRM Committee' ? 'selected' : '' }}>
        Barangay DRRM Committee
    </option>

    <option value="Barangay Emergency Response Team"
        {{ old('issued_by', $announcement->issued_by) == 'Barangay Emergency Response Team' ? 'selected' : '' }}>
        Barangay Emergency Response Team
    </option>

    <option value="Manila DRRM Office"
        {{ old('issued_by', $announcement->issued_by) == 'Manila DRRM Office' ? 'selected' : '' }}>
        Manila DRRM Office
    </option>

    <option value="Bureau of Fire Protection"
        {{ old('issued_by', $announcement->issued_by) == 'Bureau of Fire Protection' ? 'selected' : '' }}>
        Bureau of Fire Protection (BFP)
    </option>

    <option value="Philippine National Police"
        {{ old('issued_by', $announcement->issued_by) == 'Philippine National Police' ? 'selected' : '' }}>
        Philippine National Police (PNP)
    </option>

    <option value="Other"
        {{ old('issued_by', $announcement->issued_by) == 'Other' ? 'selected' : '' }}>
        Other...
    </option>

</select>

<input type="text"
       id="other_issued_by"
       class="hidden mt-3 w-full border border-gray-300 rounded-lg px-4 py-3"
       placeholder="Specify issuing authority">
</div>

                    </div>

                </div>
                <!--end-->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Security Coordination
                    </label>

                    <textarea name="security_coordination_note" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-none">{{ old('security_coordination_note', $announcement->security_coordination_note) }}</textarea>
                </div>
            </div>

            <!-- AUTHORITY & DURATION -->
            <div class="bg-gray-50 rounded-xl border p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Authority & Duration
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Reference Source
                        </label>

                        <select id="reference_source" name="reference_source"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value="N/A"
                                {{ old('reference_source', $announcement->reference_source) == 'N/A' ? 'selected' : '' }}>
                                N/A
                            </option>

                            <option value="PAGASA"
                                {{ old('reference_source', $announcement->reference_source) == 'PAGASA' ? 'selected' : '' }}>
                                PAGASA
                            </option>

                            <option value="PHIVOLCS"
                                {{ old('reference_source', $announcement->reference_source) == 'PHIVOLCS' ? 'selected' : '' }}>
                                PHIVOLCS
                            </option>

                            <option value="Manila DRRM Office"
                                {{ old('reference_source', $announcement->reference_source) == 'Manila DRRM Office' ? 'selected' : '' }}>
                                Manila DRRM Office
                            </option>

                            <option value="NDRRMC"
                                {{ old('reference_source', $announcement->reference_source) == 'NDRRMC' ? 'selected' : '' }}>
                                NDRRMC
                            </option>

                            <option value="Bureau of Fire Protection"
                                {{ old('reference_source', $announcement->reference_source) == 'Bureau of Fire Protection' ? 'selected' : '' }}>
                                Bureau of Fire Protection (BFP)
                            </option>

                            <option value="Philippine National Police"
                                {{ old('reference_source', $announcement->reference_source) == 'Philippine National Police' ? 'selected' : '' }}>
                                Philippine National Police (PNP)
                            </option>

                            <option value="Barangay Verification Team"
                                {{ old('reference_source', $announcement->reference_source) == 'Barangay Verification Team' ? 'selected' : '' }}>
                                Barangay Verification Team
                            </option>

                            <option value="Other"
                                {{ old('reference_source', $announcement->reference_source) == 'Other' ? 'selected' : '' }}>
                                Other...
                            </option>

                        </select>

                        <input type="text" id="other_reference_source"
                            class="hidden mt-3 w-full border border-gray-300 rounded-lg px-4 py-3"
                            placeholder="Specify reference source">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Status
                        </label>

                        <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value="" {{ old('status', $announcement->status) == '' ? 'selected' : '' }}>
                                Select Status
                            </option>

                            <option value="active"
                                {{ old('status', $announcement->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="resolved"
                                {{ old('status', $announcement->status) == 'resolved' ? 'selected' : '' }}>
                                Resolved
                            </option>

                            <option value="expired"
                                {{ old('status', $announcement->status) == 'expired' ? 'selected' : '' }}>
                                Expired
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Start Date & Time
                        </label>

                        <input type="datetime-local" name="start_datetime"
                            value="{{ old('start_datetime', $announcement->start_datetime ? \Carbon\Carbon::parse($announcement->start_datetime)->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            End Date & Time
                        </label>

                        <input type="datetime-local" name="end_datetime"
                            value="{{ old('end_datetime', $announcement->end_datetime ? \Carbon\Carbon::parse($announcement->end_datetime)->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="is_urgent" value="1"
                            {{ old('is_urgent', $announcement->is_urgent) ? 'checked' : '' }}>

                        <span class="text-sm font-medium text-gray-700">
                            Mark as Urgent
                        </span>
                    </label>
                </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition">
                    💾 Update Advisory
                </button>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Evacuation Center
            const evacuationSelect = document.getElementById('evacuation_center');
            const evacuationOther = document.getElementById('other_evacuation_center');

            evacuationSelect.addEventListener('change', function() {

                if (this.value === 'Other') {
                    evacuationOther.classList.remove('hidden');
                } else {
                    evacuationOther.classList.add('hidden');
                }

            });

            // Medical Facility
            const medicalSelect = document.getElementById('medical_facility_name');
            const medicalOther = document.getElementById('other_medical_facility');

            medicalSelect.addEventListener('change', function() {

                if (this.value === 'Other') {
                    medicalOther.classList.remove('hidden');
                } else {
                    medicalOther.classList.add('hidden');
                }

            });

            // Medical Contact
            const medicalContactSelect = document.getElementById('medical_facility_contact');
            const medicalContactOther = document.getElementById('other_medical_contact');

            medicalContactSelect.addEventListener('change', function() {

                if (this.value === 'Other') {
                    medicalContactOther.classList.remove('hidden');
                } else {
                    medicalContactOther.classList.add('hidden');
                }

            });

            // Reference Source
            const referenceSourceSelect = document.getElementById('reference_source');
            const referenceSourceOther = document.getElementById('other_reference_source');

            referenceSourceSelect.addEventListener('change', function() {

                if (this.value === 'Other') {
                    referenceSourceOther.classList.remove('hidden');
                } else {
                    referenceSourceOther.classList.add('hidden');
                }

            });

            // Issued By
const issuedBySelect = document.getElementById('issued_by');
const issuedByOther = document.getElementById('other_issued_by');

issuedBySelect.addEventListener('change', function() {

```
if (this.value === 'Other') {
    issuedByOther.classList.remove('hidden');
} else {
    issuedByOther.classList.add('hidden');
}
```

});


            // Image Preview
           const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('imagePreview');
const imagePreviewContainer = document.getElementById('imagePreviewContainer');
const removeImageBtn = document.getElementById('removeImageBtn');

imageInput.addEventListener('change', function () {

    const file = this.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (e) {

        imagePreview.src = e.target.result;

        imagePreview.classList.remove('hidden');
        imagePreviewContainer.classList.remove('hidden');
        removeImageBtn.classList.remove('hidden');

    };

    reader.readAsDataURL(file);

});

removeImageBtn.addEventListener('click', function () {

    imageInput.value = '';

    imagePreview.src = '#';

    imagePreview.classList.add('hidden');
    imagePreviewContainer.classList.add('hidden');
    removeImageBtn.classList.add('hidden');

});

        });
    </script>
@endsection
