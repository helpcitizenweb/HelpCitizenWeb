@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-semibold mb-6">Community Reports</h2>

    <!-- Filters -->
    <div class="mb-4 flex space-x-4 items-center">
        <!-- Type Filter -->
        <select id="typeFilter" class="px-4 py-2 border w-1/6 border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
            <option value="">Report Type</option>
            <option value="Emergencies">Emergencies</option>
            <option value="Accidents">Accidents</option>
            <option value="Complaints">Complaints</option>
            <option value="Suggestions">Suggestions</option>
            <option value="Others">Others</option>
        </select>

        <!-- Subtype Filter (hidden by default) -->
        <select id="subtypeFilter" class="px-4 py-2 w-1/6 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300 hidden">
            <option value="">Subtype</option>
        </select>

        <!-- Filter Icon -->
        <button id="openFilterModal" class="p-2 bg-gray-200 rounded-full hover:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-3.586L3.293 6.707A1 1 0 013 6V4z" />
            </svg>
        </button>

        <!-- Reset Button -->
        <button id="resetFilters" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Reset
        </button>
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-xl font-semibold mb-4">Advanced Filters</h3>

            <input type="text" id="filterId" placeholder="Filter by ID"
                class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg">

            <input type="text" id="filterReporter" placeholder="Filter by Reporter"
                class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg">


            <input type="text" id="filterDescription" placeholder="Filter by Description"
                class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg">

            <select id="filterStatus" class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Select Status</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
            </select>

            <input type="date" id="filterDate" class="w-full mb-4 px-3 py-2 border border-gray-300 rounded-lg">

            <div class="flex justify-end space-x-2">
                <button id="closeFilterModal" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
                <button id="applyFilters" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Apply</button>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full table-auto" id="reportsTable">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reporter</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtype</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Submitted</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($reports as $report)
                <tr>
                    <td class="px-6 py-4">{{ $report->id }}</td>
                    <td class="px-6 py-4">{{ $report->user->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $report->type }}</td>
                    <td class="px-6 py-4">{{ $report->subtype }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $report->description }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 text-white rounded 
                            @if($report->status == 'Pending') bg-yellow-500 
                            @elseif($report->status == 'In Progress') bg-blue-500 
                            @elseif($report->status == 'Resolved') bg-green-500 
                            @endif">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $report->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
const tableRows = document.querySelectorAll("#reportsTable tbody tr");

// Modal filters
const filterId = document.getElementById('filterId');
const filterReporter = document.getElementById('filterReporter');
const filterDescription = document.getElementById('filterDescription');
const filterStatus = document.getElementById('filterStatus');
const filterDate = document.getElementById('filterDate');
const modal = document.getElementById('filterModal');

// Update subtype options based on type
function updateSubtypeOptions() {
    const selectedType = typeFilter.value;
    if (selectedType) {
        subtypeFilter.innerHTML = `<option value="">Subtype</option>`;
        allowedTypes[selectedType].forEach(st => {
            subtypeFilter.innerHTML += `<option value="${st}">${st}</option>`;
        });
        subtypeFilter.classList.remove('hidden');
    } else {
        subtypeFilter.value = '';
        subtypeFilter.classList.add('hidden');
    }
    filterTypeAndSubtype(); // filter immediately on type/subtype change
}

// Real-time filter for type/subtype only
function filterTypeAndSubtype() {
    const typeVal = typeFilter.value.toLowerCase();
    const subtypeVal = subtypeFilter.value.toLowerCase();

    tableRows.forEach(row => {
        const rowType = row.cells[2].textContent.toLowerCase();
        const rowSubtype = row.cells[3].textContent.toLowerCase();
        const matches = (!typeVal || rowType === typeVal) &&
                        (!subtypeVal || rowSubtype === subtypeVal);
        row.style.display = matches ? '' : 'none';
    });
}

// Advanced filter (applied only when "Apply" button is clicked)
function applyAdvancedFilters() {
    const typeVal = typeFilter.value.toLowerCase();
    const subtypeVal = subtypeFilter.value.toLowerCase();
    const idVal = filterId.value.toLowerCase();
    const reporterVal = filterReporter.value.toLowerCase();
    const descriptionVal = filterDescription.value.toLowerCase();
    const statusVal = filterStatus.value.toLowerCase();
    const dateVal = filterDate.value;

    tableRows.forEach(row => {
        const rowId = row.cells[0].textContent.toLowerCase();
        const rowReporter = row.cells[1].textContent.toLowerCase();
        const rowType = row.cells[2].textContent.toLowerCase();
        const rowSubtype = row.cells[3].textContent.toLowerCase();
        const rowDescription = row.cells[4].textContent.toLowerCase();
        const rowStatus = row.cells[5].textContent.trim().toLowerCase();
        const rowDate = row.cells[6].textContent.trim();

        const matches = (!typeVal || rowType === typeVal) &&
                        (!subtypeVal || rowSubtype === subtypeVal) &&
                        (!idVal || rowId.includes(idVal)) &&
                        (!reporterVal || rowReporter.includes(reporterVal)) &&
                        (!descriptionVal || rowDescription.includes(descriptionVal)) &&
                        (!statusVal || rowStatus === statusVal) &&
                        (!dateVal || rowDate === dateVal);

        row.style.display = matches ? '' : 'none';
    });
}

// Real-time listeners for type/subtype
typeFilter.addEventListener('change', updateSubtypeOptions);
subtypeFilter.addEventListener('change', filterTypeAndSubtype);

// Modal open/close
document.getElementById('openFilterModal').onclick = () => modal.classList.remove('hidden');
document.getElementById('closeFilterModal').onclick = () => modal.classList.add('hidden');

// Apply advanced filters
document.getElementById('applyFilters').addEventListener('click', () => {
    applyAdvancedFilters();
    modal.classList.add('hidden');
});

// Reset filters
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
</script>
@endsection