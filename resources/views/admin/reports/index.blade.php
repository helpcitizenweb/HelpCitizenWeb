@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">

    <!-- Header Card -->
    <div class="bg-white shadow rounded-lg p-6 mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Community Reports</h2>
        <span class="text-gray-500">{{ $reports->count() }} reports</span>
    </div>
     <!-- Filter stfart -->
    <!-- Filters Card -->
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex flex-wrap gap-4 items-center">
        <select id="typeFilter" class="px-4 py-2 border w-1/6 border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            <option value="">Report Type</option>
            <option value="Emergencies">Emergencies</option>
            <option value="Accidents">Accidents</option>
            <option value="Complaints">Complaints</option>
            <option value="Suggestions">Suggestions</option>
            <option value="Others">Others</option>
        </select>

        <select id="subtypeFilter" class="px-4 py-2 w-1/6 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300 hidden">
            <option value="">Subtype</option>
        </select>

        <button id="openFilterModal" class="p-2 bg-gray-200 rounded-full hover:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-3.586L3.293 6.707A1 1 0 013 6V4z" />
            </svg>
        </button>

        <button id="resetFilters" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Reset</button>
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-xl font-semibold mb-4">Advanced Filters</h3>

            <input type="text" id="filterId" placeholder="Filter by ID" class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg">
            <input type="text" id="filterReporter" placeholder="Filter by Reporter" class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg">
            <input type="text" id="filterDescription" placeholder="Filter by Description" class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg">

            <select id="filterStatus" class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Select Status</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
                <option value="Action">Action</option>
                <option value="Cancel">Cancel</option>
            </select>

            <input type="date" id="filterDate" class="w-full mb-4 px-3 py-2 border border-gray-300 rounded-lg">

            <div class="flex justify-end space-x-2">
                <button id="closeFilterModal" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
                <button id="applyFilters" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Apply</button>
            </div>
        </div>
    </div>
    <!-- Filter end -->
    <!-- Reports Table -->
    <!-- Reports List (FIGMA DESIGN) -->
<div id="reportsList" class="space-y-4">
@foreach($reports as $report)
<div
    class="bg-white shadow rounded-lg p-4 flex gap-4 items-start report-item"
    data-id="{{ $report->id }}"
    data-reporter="{{ strtolower($report->user?->name ?? '') }}"
    data-type="{{ strtolower($report->type) }}"
    data-subtype="{{ strtolower($report->subtype) }}"
    data-status="{{ strtolower($report->status) }}"
    data-date="{{ $report->created_at->format('Y-m-d') }}"
>

    <!-- IMAGE (dominant like Figma) -->
    <div class="w-36 h-32 bg-gray-100 rounded overflow-hidden flex-shrink-0">
        @if($report->image)
            <img
                src="{{ asset('storage/' . $report->image) }}"
                class="w-full h-full object-cover cursor-pointer"
                onclick="openImageModal('{{ asset('storage/' . $report->image) }}')"
            >
        @else
            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">
                No image
            </div>
        @endif
    </div>

    <!-- META COLUMN -->
<div class="text-sm space-y-1 leading-snug min-w-[180px]">

    <p class="font-semibold text-base">
        Report #{{ $report->id }}
    </p>

    <p><span class="font-semibold">Date:</span> {{ $report->created_at->format('Y-m-d') }}</p>
    @if($report->anonymous)
    <p>
        <span class="font-semibold">Reporter:</span>
        <span class="italic text-gray-500">Anonymous</span>
    </p>
@else
    <p>
        <span class="font-semibold">Reporter:</span>
        {{ $report->user?->name ?? 'N/A' }}
    </p>
    <p>
        <span class="font-semibold">Email:</span>
        {{ $report->user?->email ?? 'N/A' }}
    </p>
@endif


    <!-- STATUS (CLEAR & PROMINENT) -->
    <p class="font-semibold">Status: <span
        class="inline-block mt-1 text-xs px-3 py-1 rounded-full text-white
        @if ($report->status === 'Pending') bg-yellow-500
        @elseif ($report->status === 'In Progress') bg-blue-600
        @elseif ($report->status === 'Action') bg-indigo-600
        @elseif ($report->status === 'Resolved') bg-green-600
        @elseif ($report->status === 'Cancel') bg-red-600
        @else bg-gray-700
        @endif">
        {{ $report->status }}
    </span></p>

</div>


    <!-- CONTENT COLUMN -->
    <div class="flex-1 text-sm space-y-0.5 leading-snug">
        <p><span class="font-semibold">Title: </span>{{ $report->title }}</p>
        <p><span class="font-semibold">Type:</span> {{ $report->type }}</p>
        <p><span class="font-semibold">Subtype:</span> {{ $report->subtype }}</p>
    </div>

   
<!-- ACTION (PRIMARY BIG BUTTON) -->
<div class="flex items-start justify-end self-start min-w-[160px]">
    <a href="{{ route('admin.reports.viewreport', $report->id) }}"
       class="flex items-center gap-2 px-5 py-3
              bg-green-600 text-white text-sm font-semibold
              rounded-xl shadow-md
              hover:bg-green-700 transition
              whitespace-nowrap">

        <!-- Eye icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-5 h-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5
                     c4.478 0 8.268 2.943 9.542 7
                     -1.274 4.057-5.064 7-9.542 7
                     -4.477 0-8.268-2.943-9.542-7z" />
        </svg>

        View Report
    </a>
</div>
 <!-- ACTION (PRIMARY CIRCULAR BUTTON) -->

</div>
@endforeach
</div>

</div>


<!-- modals,filters, and script -->

<!-- Description Modal -->
<div id="descModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <div id="descContent" class="text-gray-700"></div>
        <button onclick="document.getElementById('descModal').classList.add('hidden')" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg">Close</button>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-4 rounded-lg shadow-lg max-w-[90%] max-h-[90%]">
        <img id="modalImage" src="" class="max-w-full max-h-[80vh] rounded" />
        <button onclick="document.getElementById('imageModal').classList.add('hidden')" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg">Close</button>
    </div>
</div>

<script>
const allowedTypes = {
    "Emergencies": ["Fire", "Flood", "Earthquake", "Medical", "Others"],
    "Accidents": ["Traffic", "Workplace", "Home", "Others"],
    "Complaints": ["Noise", "Garbage", "Harassment", "Others"],
    "Suggestions": ["Public Safety", "Infrastructure", "Services", "Others"],
    "Others": ["Miscellaneous"]
};

const typeFilter = document.getElementById('typeFilter');
const subtypeFilter = document.getElementById('subtypeFilter');
const tableRows = document.querySelectorAll(".report-item");


// Filter modal elements
const filterId = document.getElementById('filterId');
const filterReporter = document.getElementById('filterReporter');
const filterStatus = document.getElementById('filterStatus');
const filterDate = document.getElementById('filterDate');
const modal = document.getElementById('filterModal');

// Update subtype
function updateSubtypeOptions() {
    const selectedType = typeFilter.value;
    if (selectedType) {
        subtypeFilter.innerHTML = `<option value="">Subtype</option>`;
        allowedTypes[selectedType].forEach(st => { subtypeFilter.innerHTML += `<option value="${st}">${st}</option>`; });
        subtypeFilter.classList.remove('hidden');
    } else {
        subtypeFilter.value = '';
        subtypeFilter.classList.add('hidden');
    }
    filterTypeAndSubtype();
}

// Real-time filter
function filterTypeAndSubtype() {
    const typeVal = typeFilter.value.toLowerCase();
    const subtypeVal = subtypeFilter.value.toLowerCase();

    tableRows.forEach(row => {
        const rowType = row.dataset.type;
        const rowSubtype = row.dataset.subtype;

        const matches =
            (!typeVal || rowType === typeVal) &&
            (!subtypeVal || rowSubtype === subtypeVal);

        row.style.display = matches ? '' : 'none';
    });
}


// Advanced filters
function applyAdvancedFilters() {
    const typeVal = typeFilter.value.toLowerCase();
    const subtypeVal = subtypeFilter.value.toLowerCase();
    const idVal = filterId.value.toLowerCase();
    const reporterVal = filterReporter.value.toLowerCase();
    const descriptionVal = filterDescription.value.toLowerCase();
    const statusVal = filterStatus.value.toLowerCase();
    const dateVal = filterDate.value;

    tableRows.forEach(row => {
        const matches =
            (!typeVal || row.dataset.type === typeVal) &&
            (!subtypeVal || row.dataset.subtype === subtypeVal) &&
            (!idVal || row.dataset.id.includes(idVal)) &&
            (!reporterVal || row.dataset.reporter.includes(reporterVal)) &&
            (!statusVal || row.dataset.status === statusVal) &&
            (!dateVal || row.dataset.date === dateVal);

        row.style.display = matches ? '' : 'none';
    });
}


// Listeners
typeFilter.addEventListener('change', updateSubtypeOptions);
subtypeFilter.addEventListener('change', filterTypeAndSubtype);

document.getElementById('openFilterModal').onclick = () => modal.classList.remove('hidden');
document.getElementById('closeFilterModal').onclick = () => modal.classList.add('hidden');
document.getElementById('applyFilters').addEventListener('click', () => { applyAdvancedFilters(); modal.classList.add('hidden'); });
document.getElementById('resetFilters').addEventListener('click', () => {
    typeFilter.value = '';
    subtypeFilter.value = '';
    subtypeFilter.classList.add('hidden');
    filterId.value = '';
    filterReporter.value = '';
    filterDescription.value = '';
    filterStatus.value = '';
    filterDate.value = '';
    tableRows.forEach(row => row.style.display = '');
});

// Description modal
function openDescModal(id) {
    const descModal = document.getElementById('descModal');
    const descContent = document.getElementById('descContent');
    const reports = @json($reports->keyBy('id'));
    descContent.textContent = reports[id]?.description ?? 'No description';
    descModal.classList.remove('hidden');
}

// Image modal seal
function openImageModal(url) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    img.src = url;
    modal.classList.remove('hidden');
}
</script>
@endsection
