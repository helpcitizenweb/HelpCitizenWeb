<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">BDRRM Response Form</h2>

    <form action="{{ route('admin.reports.storeResponse', $report->id) }}" method="POST">
        @csrf

        <!-- Alpine wrapper -->
        <div x-data="{ dispatchUnit: '' }" class="space-y-6">

            <!-- Response Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Response Category</label>

                <select name="dispatch_unit"
                        x-model="dispatchUnit"
                        @change="$store.resp.unit = dispatchUnit"
                        class="w-full border rounded p-2">
                    
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
                    <option value="Harassment">Harassment</option>
                    <option value="Noise">Noise</option>
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
                <input type="text" name="contact_person" class="w-full border rounded p-2">
            </div>

            <!-- Contact Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" name="contact_number" maxlength="11"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       class="w-full border rounded p-2">
            </div>

            <!-- Dynamic forms -->
            <template x-if="dispatchUnit === 'Fire'">
               @include('admin.reports.forms.fire', ['response' => $response])

            </template>

            <template x-if="dispatchUnit === 'Flood_typhoon'">
                @include('admin.reports.forms.flood_typhoon', ['response' => $response])
            </template>

            <template x-if="dispatchUnit === 'Earthquake'">
                @include('admin.reports.forms.earthquake', ['response' => $response])
            </template>

            <template x-if="dispatchUnit === 'Medical'">
                @include('admin.reports.forms.medical', ['response' => $response])
            </template>

            <!-- Accidents -->
            <template x-if="dispatchUnit === 'Traffic'">
                @include('admin.reports.forms.traffic', ['response' => $response])
            </template>

            <template x-if="dispatchUnit === 'Workplace_Home'">
                @include('admin.reports.forms.workplace_home', ['response' => $response])
            </template>

            <!-- Complaints -->
            <template x-if="dispatchUnit === 'Harassment'">
                @include('admin.reports.forms.harassment', ['response' => $response])
            </template>

            <template x-if="dispatchUnit === 'Noise'">
                @include('admin.reports.forms.noise', ['response' => $response])
            </template>

            <template x-if="dispatchUnit === 'Garbage'">
                @include('admin.reports.forms.garbage', ['response' => $response])
            </template>

            <!-- Services -->
            <template x-if="dispatchUnit === 'Services'">
                @include('admin.reports.forms.services', ['response' => $response])
            </template>

        </div>

        <!-- Submit -->
        <button type="submit"
                class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Response
        </button>

    </form>
</div>

<!-- LEAFLET (NO API KEY NEEDED) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener("alpine:init", () => {

    Alpine.store('resp', { unit: '' });

    Alpine.effect(() => {
        if (Alpine.store('resp').unit !== 'Fire') return;

        setTimeout(() => initLeafletMaps(), 150);
    });
});

function initLeafletMaps() {

    const evacDiv = document.getElementById('evacuation-map');
    const hospDiv = document.getElementById('hospital-map');

    if (!evacDiv || !hospDiv) return;

    // Initialize maps
    const evacMap = L.map(evacDiv).setView([14.5995, 120.9842], 13);
    const hospMap = L.map(hospDiv).setView([14.5995, 120.9842], 13);

    // FREE OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(evacMap);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(hospMap);

    // Draggable markers
    const evacMarker = L.marker([14.5995, 120.9842], { draggable: true }).addTo(evacMap);
    const hospMarker = L.marker([14.5995, 120.9842], { draggable: true }).addTo(hospMap);

    // Update hidden fields on drag
    evacMarker.on("dragend", () => {
        const pos = evacMarker.getLatLng();
        document.getElementById('evacuation-lat').value = pos.lat;
        document.getElementById('evacuation-lng').value = pos.lng;
    });

    hospMarker.on("dragend", () => {
        const pos = hospMarker.getLatLng();
        document.getElementById('hospital-lat').value = pos.lat;
        document.getElementById('hospital-lng').value = pos.lng;
    });


    // --------------------------
    //  ADDRESS SEARCH FUNCTION
    // --------------------------
    function searchAndMove(inputField, map, marker, latField, lngField) {
        inputField.addEventListener("change", () => {
            const query = inputField.value;
            if (!query) return;

            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        alert("Location not found.");
                        return;
                    }

                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);

                    // Move map
                    map.setView([lat, lng], 16);

                    // Move marker
                    marker.setLatLng([lat, lng]);

                    // Save coordinates
                    latField.value = lat;
                    lngField.value = lng;
                })
                .catch(err => console.error(err));
        });
    }

    // Bind evacuation search
    searchAndMove(
        document.getElementById('evacuation-address-input'),
        evacMap,
        evacMarker,
        document.getElementById('evacuation-lat'),
        document.getElementById('evacuation-lng')
    );

    // Bind hospital search
    searchAndMove(
        document.getElementById('hospital-address-input'),
        hospMap,
        hospMarker,
        document.getElementById('hospital-lat'),
        document.getElementById('hospital-lng')
    );
}
</script>


