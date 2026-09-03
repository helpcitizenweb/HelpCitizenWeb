@php
    use Illuminate\Support\Str;

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
@endphp
@extends('layouts.admin')
@section('content')
    <div class="max-w-5xl mx-auto mt-8 bg-white p-8 rounded-2xl shadow-md">


        <!-- Headeer -->
        <div class="border-b pb-4 mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                🚨 Create Emergency Advisory
            </h1>
            <p class="text-gray-500 mt-2">
                Create preparedness, mitigation, and emergency advisories for residents.
            </p>
        </div>

        <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">

            @csrf

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
                            placeholder="Enter advisory title">
                    </div>

                    <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Announcement Image
    </label>

    <input type="file"
           id="image"
           name="image"
           accept="image/*"
           class="w-full border border-gray-300 rounded-lg px-4 py-3">

    <!-- Image Preview -->
    <div id="imagePreviewContainer" class="hidden mt-4">

        <img id="imagePreview"
             src="#"
             alt="Image Preview"
             class="w-full max-w-md h-56 object-cover rounded-lg border shadow-sm">

        <!-- Remove Button -->
        <button type="button"
                id="removeImageBtn"
                class="mt-3 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            🗑 Remove Image
        </button>

    </div>
</div> <!-- image end  -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>

                        <textarea name="content" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-none"
                            placeholder="Enter advisory description"></textarea>
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

                            <option value="">Select Type</option>
                            <option value="Fire">Fire</option>
                            <option value="Flood">Flood</option>
                            <option value="Earthquake">Earthquake</option>
                            <option value="Typhoon">Typhoon</option>
                            <option value="Accident">Accident</option>
                            <option value="General Advisory">General Advisory</option>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alert Level
                        </label>

                        <select name="alert_level" class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value="">Select Alert Level</option>
                            <option value="Monitoring">Monitoring</option>
                            <option value="Warning">Warning</option>
                            <option value="Critical">Critical</option>
                            <option value="Evacuation Required">Evacuation Required</option>

                        </select>
                    </div>

                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Affected Area
                    </label>

                    <input type="text" name="affected_area" class="w-full border border-gray-300 rounded-lg px-4 py-3"
                        placeholder="Enter affected area, zone, street, or location">
                </div>
            </div>

            <!-- MITIGATION INSTRUCTIONS -->
            <div class="bg-gray-50 rounded-xl border p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Mitigation Instructions
                </h2>

                <textarea name="instructions" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-none"
                    placeholder="Enter evacuation, preparedness, or safety instructions"></textarea>
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

                            <option value="N/A">N/A</option>

                            <option value="Barangay 41 Hall">
                                Barangay 41 Hall
                            </option>

                            <option value="Covered Court">
                                Covered Court
                            </option>

                            <option value="Public School">
                                Public School
                            </option>

                            <option value="City Designated Evacuation Center">
                                City Designated Evacuation Center
                            </option>

                            <option value="Community Center">
                                Community Center
                            </option>

                            <option value="Church Facility">
                                Church Facility
                            </option>

                            <option value="Other">
                                Other...
                            </option>

                        </select>

                        <input type="text" id="other_evacuation_center"
                            class="hidden mt-3 w-full border border-gray-300 rounded-lg px-4 py-3"
                            placeholder="Specify evacuation center">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Medical Facility
                        </label>

                        <select id="medical_facility_name" name="medical_facility_name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value="N/A">N/A</option>

                            <option value="Tondo Medical Center">
                                Tondo Medical Center
                            </option>

                            <option value="Metropolitan Medical Center">
                                Metropolitan Medical Center
                            </option>

                            <option value="Mary Johnston Hospital">
                                Mary Johnston Hospital
                            </option>

                            <option value="Tondo Foreshore Health Center">
                                Tondo Foreshore Health Center
                            </option>

                            <option value="Fugoso Health Center">
                                Fugoso Health Center
                            </option>

                            <option value="Philippine Red Cross">
                                Philippine Red Cross
                            </option>

                            <option value="Other">
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

                            <option value="N/A">N/A</option>

                            <option value="(02) 8865 9000">
                                Tondo Medical Center - (02) 8865 9000
                            </option>

                            <option value="(02) 8863 2500">
                                Metropolitan Medical Center - (02) 8863 2500
                            </option>

                            <option value="(02) 5318 6600 / (02) 8245 4024">
                                Mary Johnston Hospital - (02) 5318 6600
                            </option>

                            <option value="22545760">
                                Tondo Foreshore Health Center - 22545760
                            </option>

                            <option value="0928-673-1715">
                                Fugoso Health Center - 0928-673-1715
                            </option>

                            <option value="143">
                                Philippine Red Cross - 143
                            </option>

                            <option value="Other">
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

                        <select id="issued_by" name="issued_by"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value="N/A">N/A</option>

                            <option value="Barangay Captain">
                                Barangay Captain
                            </option>

                            <option value="Barangay DRRM Committee">
                                Barangay DRRM Committee
                            </option>

                            <option value="Barangay Emergency Response Team">
                                Barangay Emergency Response Team
                            </option>

                            <option value="Manila DRRM Office">
                                Manila DRRM Office
                            </option>

                            <option value="Bureau of Fire Protection">
                                Bureau of Fire Protection (BFP)
                            </option>

                            <option value="Philippine National Police">
                                Philippine National Police (PNP)
                            </option>

                            <option value="Other">
                                Other...
                            </option>

                        </select>

                        <input type="text" id="other_issued_by"
                            class="hidden mt-3 w-full border border-gray-300 rounded-lg px-4 py-3"
                            placeholder="Specify issuing authority">
                    </div>

                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Security Coordination
                    </label>

                    <textarea name="security_coordination_note" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-none"
                        placeholder="Barangay Tanod deployment, PNP assistance, traffic control, etc."></textarea>
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

                            <option value="N/A">N/A</option>

                            <option value="PAGASA">
                                PAGASA
                            </option>

                            <option value="PHIVOLCS">
                                PHIVOLCS
                            </option>

                            <option value="Manila DRRM Office">
                                Manila DRRM Office
                            </option>

                            <option value="NDRRMC">
                                NDRRMC
                            </option>

                            <option value="Bureau of Fire Protection">
                                Bureau of Fire Protection (BFP)
                            </option>

                            <option value="Philippine National Police">
                                Philippine National Police (PNP)
                            </option>

                            <option value="Barangay Verification Team">
                                Barangay Verification Team
                            </option>

                            <option value="Other">
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

                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="resolved">Resolved</option>
                            <option value="expired">Expired</option>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Start Date & Time
                        </label>

                        <input type="datetime-local" name="start_datetime"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            End Date & Time
                        </label>

                        <input type="datetime-local" name="end_datetime"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>

                </div>

                <div class="mt-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="is_urgent" value="1" class="h-4 w-4">

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
                    💾 Save Advisory
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

                ``
                `
if (this.value === 'Other') {
    issuedByOther.classList.remove('hidden');
} else {
    issuedByOther.classList.add('hidden');
}
`
                ``

            });


            // Image Preview
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const removeImageBtn = document.getElementById('removeImageBtn');

            imageInput.addEventListener('change', function() {

                const file = this.files[0];

                if (file) {

                    const reader = new FileReader();

                    reader.onload = function(e) {

                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        imagePreviewContainer.classList.remove('hidden');
                        removeImageBtn.classList.remove('hidden');

                    };

                    reader.readAsDataURL(file);

                }

            });

            removeImageBtn.addEventListener('click', function() {

                imageInput.value = '';

                imagePreview.src = '#';

                imagePreview.classList.add('hidden');
                imagePreviewContainer.classList.add('hidden');
                removeImageBtn.classList.add('hidden');

            });

        });
    </script>
@endsection
