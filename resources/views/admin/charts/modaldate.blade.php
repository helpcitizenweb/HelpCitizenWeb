<div id="dateModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 relative">

        <!-- CLOSE -->
        <button onclick="closeDateModal()" class="absolute top-2 right-3 text-gray-500 text-xl">
            &times;
        </button>

        <!-- TITLE -->
        <h2 class="text-xl font-semibold mb-4">Date Filter</h2>

        <!-- OPTIONS -->
        <div class="space-y-3">

            <!-- ✅ NEW -->
    <button onclick="selectDateFilter('all')" 
        class="w-full p-2 border rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">
        All Time
    </button>
    <br>

            <button onclick="selectDateFilter('today')" 
                class="w-full p-2 border rounded-lg hover:bg-gray-100">
                Today
            </button>
            <br>

            <button onclick="selectDateFilter('week')" 
                class="w-full p-2 border rounded-lg hover:bg-gray-100">
                This Week
            </button>
            <br>
            <button onclick="selectDateFilter('month')" 
                class="w-full p-2 border rounded-lg hover:bg-gray-100">
                This Month
            </button>
            <br>
            <button onclick="showCustomRange()" 
                class="w-full p-2 border rounded-lg hover:bg-gray-100">
                Custom Range
            </button>
            <br>
        </div>


        <!-- CUSTOM RANGE -->
        <p>Start date:</p>
        <div id="modalCustomRange" class="hidden mt-4">
            <input type="date" id="modalStartDate" class="w-full p-2 border rounded-lg mb-2">
            <input type="date" id="modalEndDate" class="w-full p-2 border rounded-lg">
        <br>
        <p>End date:</p>
            <button onclick="applyCustomRange()" 
                class="w-full mt-3 bg-blue-600 text-white py-2 rounded-lg">
                Apply Filter
            </button>
        </div>
        <br>

    </div>
</div>
<script>

function selectDateFilter(type) {

    // ✅ Handle "ALL"
    if (type === 'all') {
        window.selectedDateFilter = '';
        window.selectedStartDate = '';
        window.selectedEndDate = '';
    } else {
        window.selectedDateFilter = type;
        window.selectedStartDate = '';
        window.selectedEndDate = '';
    }

    closeDateModal();
    loadChart(currentChartType);
}

function showCustomRange() {
    document.getElementById('modalCustomRange').classList.remove('hidden');
}

function applyCustomRange() {
    const start = document.getElementById("modalStartDate").value;
    const end = document.getElementById("modalEndDate").value;

    if (!start || !end) {
        alert("Please select both dates");
        return;
    }

    if (new Date(start) > new Date(end)) {
        alert("Start date cannot be after end date");
        return;
    }

    window.selectedDateFilter = 'custom';
    window.selectedStartDate = start;
    window.selectedEndDate = end;

    closeDateModal();
    loadChart(currentChartType);
}
</Script>