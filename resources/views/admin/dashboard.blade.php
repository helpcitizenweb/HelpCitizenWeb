@extends('layouts.admin')

@section('content')
    <div class="container mx-auto mt-10 px-4 flex justify-center">
        <div class="w-full max-w-5xl">
            <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-100">
                <h3 class="text-3xl font-bold mb-4 text-primary">Welcome, Admin</h3>
                <p class="text-gray-600 mb-6 text-lg">Oversee reports, users, announcements, and community updates.</p>

                <!-- Stats Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-md transform hover:scale-[1.02] transition duration-300">
                        <div class="flex items-center">
                            <i class="fas fa-users text-3xl mr-4"></i>
                            <div>
                                <h4 class="text-lg font-semibold">Users</h4>
                                <p class="text-2xl">{{ $userCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-lg shadow-md transform hover:scale-[1.02] transition duration-300">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt text-3xl mr-4"></i>
                            <div>
                                <h4 class="text-lg font-semibold">Reports</h4>
                                <p class="text-2xl">{{ $reportCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-yellow-400 to-yellow-500 text-white p-6 rounded-lg shadow-md transform hover:scale-[1.02] transition duration-300">
                        <div class="flex items-center">
                            <i class="fas fa-bullhorn text-3xl mr-4"></i>
                            <div>
                                <h4 class="text-lg font-semibold">Announcements</h4>
                                <p class="text-2xl">{{ $announcementCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Section -->
                <div class="mt-10 bg-gray-50 p-6 rounded-lg shadow-sm border">
                    <h4 class="text-2xl font-semibold mb-5 text-gray-700">Quick Stats</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow border text-center">
                            <h5 class="font-semibold text-gray-700 mb-2">Total Active Users</h5>
                            <p class="text-2xl font-bold text-blue-600">{{ $activeUsers }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow border text-center">
                            <h5 class="font-semibold text-gray-700 mb-2">Pending Reports</h5>
                            <p class="text-2xl font-bold text-green-600">{{ $pendingReports }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow border text-center">
                            <h5 class="font-semibold text-gray-700 mb-2">Upcoming Announcements</h5>
                            <p class="text-2xl font-bold text-yellow-600">{{ $upcomingAnnouncements }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--this is where will start at line 65 to add the charts got it--->
    <!--this is where will start at line 65 to add the charts got it--->
    <div class="container mx-auto mt-10 px-4 flex justify-center">
        <div class="w-full max-w-5xl">
            <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-100">

                <!-- TITLE -->
                <h3 class="text-3xl font-bold mb-6 text-primary">Analytics Dashboard</h3>

                

                <!-- FILTERS -->
                <div class="flex flex-col md:flex-row gap-4 mb-6">

                     <!-- DATE -->
                    <button onclick="openDateModal()" class="flex-1 p-2 border rounded-lg">
                        Filter Date
                    </button>

                    <!-- CATEGORY -->
                    <select id="categoryFilter" class="flex-1 p-2 border rounded-lg">
                        <option value="">Category: All</option>
                        <option value="Emergencies">Emergencies</option>
                        <option value="Accidents">Accidents</option>
                        <option value="Complaints">Complaints</option>
                        <option value="Suggestions">Suggestions</option>
                    </select>

                    <!-- SUBTYPE -->
                    <select id="subtypeFilter" class="flex-1 p-2 border rounded-lg" disabled>
                        <option value="">Subtype: Select Category First</option>
                    </select>

                    <!-- STATUS -->
                    <select id="statusFilter" class="flex-1 p-2 border rounded-lg">
                        <option value="All">Status: All</option>
                        <option value="Pending">Pending</option>
                        <option value="Action">Action</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                   
                  <!-- Rating -->
                    <select id="ratingFilter" class="flex-1 p-2 border rounded-lg">
    <option value="">All Ratings</option>
    <option value="5">★★★★★ (5)</option>
    <option value="4">★★★★☆ (4)</option>
    <option value="3">★★★☆☆ (3)</option>
    <option value="2">★★☆☆☆ (2)</option>
    <option value="1">★☆☆☆☆ (1)</option>
</select>
                    

                </div>

                <!-- LEVEL 2: CHART TYPES -->
                <div class="flex space-x-4 mb-6">
                    <button id="pieTab" class="px-4 py-2 rounded-lg bg-green-500 text-white font-semibold">
                        Reports
                    </button>
                    <button id="barTab" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold">
                        Subtypes of reports
                    </button>
                    <button id="lineTab" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold">
                        Timeline
                    </button>
                </div>

                <!-- ✅ ADD HERE -->
                <div id="chartContainer" class="mt-4">
                    Loading chart...
                </div>

                <!-- CHART DISPLAY AREA -->
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>

    <script>
        let currentChartType = 'pie';
        let chartInstance = null; // ✅ ADD THIS HERE
        document.addEventListener("DOMContentLoaded", function() {

            // =========================
            // SUBTYPE LOGIC
            // =========================
            const subtypes = {
                "Emergencies": ["Fire", "Flood", "Typhoon", "Earthquake", "Medical", "Others"],
                "Accidents": ["Traffic", "Workplace", "Home", "Others"],
                "Complaints": ["Noise", "Garbage", "Harassment", "Others"],
                "Suggestions": ["Public Safety", "Infrastructure", "Services", "Others"]
            };

            const category = document.getElementById("categoryFilter");
            const subtype = document.getElementById("subtypeFilter");

            if (category && subtype) {
                category.addEventListener("change", function() {
                    const selected = this.value;

                    subtype.innerHTML = "";

                    if (!selected) {
                        subtype.disabled = true;
                        subtype.innerHTML = '<option value="">Subtype: Select Category First</option>';
                        return;
                    }

                    subtype.disabled = false;

                    let defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.textContent = "Subtype: All";
                    subtype.appendChild(defaultOption);

                    subtypes[selected].forEach(function(item) {
                        let option = document.createElement("option");
                        option.value = item;
                        option.textContent = item;
                        subtype.appendChild(option);
                    });
                });
            }

            // =========================
            // ✅ DATE LOGIC (OUTSIDE)
            // =========================
            const dateFilter = document.getElementById("dateFilter");
            const customRange = document.getElementById("customDateRange");
            const startDate = document.getElementById("startDate");
            const endDate = document.getElementById("endDate");

            if (dateFilter && customRange && startDate && endDate) {

                dateFilter.addEventListener("change", function() {

                    if (this.value === "custom") {
                        customRange.classList.remove("hidden");

                        // ✅ clear old values
                        startDate.value = "";
                        endDate.value = "";

                        return;
                    } else {
                        customRange.classList.add("hidden");
                        loadChart(currentChartType);
                    }
                });

                function tryCustomDateFilter() {

                    // Must be custom mode
                    if (dateFilter.value !== "custom") return;

                    // Must have both dates
                    if (!startDate.value || !endDate.value) return;

                    // ✅ PUT VALIDATION HERE
                    if (new Date(startDate.value) > new Date(endDate.value)) {
                        alert("Start date cannot be after end date");
                        return;
                    }

                    // ✅ ONLY RUN IF VALID
                    loadChart(currentChartType);
                }

                startDate.addEventListener("change", tryCustomDateFilter);
                endDate.addEventListener("change", tryCustomDateFilter);
            }

            // =========================
            // CHART LOADING
            // =========================
            function loadChart(type) {

                const category = document.getElementById("categoryFilter")?.value || '';
                const subtype = document.getElementById("subtypeFilter")?.value || '';
                const status = document.getElementById("statusFilter")?.value || '';
                const date = window.selectedDateFilter || '';
                const startDate = window.selectedStartDate || '';
                const endDate = window.selectedEndDate || '';
                const rating = document.getElementById("ratingFilter")?.value || '';
                // STEP 1: load HTML (canvas)
                fetch(`/admin/chart-view/${type}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById("chartContainer").innerHTML = html;

                        // ⏳ WAIT for DOM update
                        setTimeout(() => {
                            fetch(`/admin/chart/${type}?category=${category}&subtype=${subtype}&status=${status}&date=${date}&start_date=${startDate}&end_date=${endDate}&rating=${rating}`)

                                .then(res => res.json())
                                .then(data => {
                                    console.log("DATA:", data);

                                    if (type === 'pie') renderPieChart(data);
                                    if (type === 'bar') renderBarChart(data);
                                    if (type === 'line') renderLineChart(data);
                                });
                        }, 50);
                    })
            }

            // Default load
            loadChart('pie');

            // =========================
            // TAB BUTTONS
            // =========================
            const pieTab = document.getElementById("pieTab");
            const barTab = document.getElementById("barTab");
            const lineTab = document.getElementById("lineTab");

            if (pieTab && barTab && lineTab) {

                pieTab.addEventListener("click", function() {
                    currentChartType = 'pie';
                    loadChart('pie');
                });

                barTab.addEventListener("click", function() {
                    currentChartType = 'bar';
                    setActive(this);
                    loadChart('bar');
                });

                lineTab.addEventListener("click", function() {
                    currentChartType = 'line';
                    setActive(this);
                    loadChart('line');
                });
            }

            // =========================
            // ACTIVE BUTTON STYLE
            // =========================
            function setActive(activeBtn) {
                document.querySelectorAll("#pieTab, #barTab, #lineTab").forEach(btn => {
                    btn.classList.remove("bg-green-500", "text-white");
                    btn.classList.add("bg-gray-200", "text-gray-700");
                });

                activeBtn.classList.remove("bg-gray-200", "text-gray-700");
                activeBtn.classList.add("bg-green-500", "text-white");
            }

            // ✅ ADD THIS RIGHT HERE (INSIDE DOMContentLoaded)
            document.querySelectorAll("select").forEach(select => {
                select.addEventListener("change", () => {
                    loadChart(currentChartType);
                });
            });

        });
        //pie chart/////////////////////////////////////////////////////////////////////////////
        function renderPieChart(data) {
            const canvas = document.getElementById('pieChartCanvas');

            if (!canvas) {
                console.error("Canvas NOT FOUND");
                return;
            }

            const ctx = canvas.getContext('2d');

            if (chartInstance) chartInstance.destroy();

            chartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.map(d => d.type),
                    datasets: [{
                        data: data.map(d => d.total),
                    }]
                }
            });
        }
        //bar chart/////////////////////////////////////////////////////////////////////////////
        function renderBarChart(data) {
            const canvas = document.getElementById('barChartCanvas');

            if (!canvas) {
                console.error("Bar canvas NOT FOUND");
                return;
            }

            const ctx = canvas.getContext('2d');

            if (chartInstance) chartInstance.destroy();

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(d => d.subtype), // ✅ FIXED
                    datasets: [{
                        label: 'Reports by Subtype',
                        data: data.map(d => d.total), // ✅ FIXED
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        //line chart/////////////////////////////////////////////////////////////////////////////
        function renderLineChart(data) {
            const ctx = document.getElementById('lineChartCanvas');

            if (chartInstance) chartInstance.destroy();

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => d.date),
                    datasets: [{
                        label: 'Reports Over Time', // ✅ ADD THIS
                        data: data.map(d => d.total),
                        borderWidth: 2,
                        fill: false,
                        tension: 0.3
                    }]
                }
            });
        }

        function openDateModal() {
            document.getElementById('dateModal').classList.remove('hidden');
        }

        function closeDateModal() {
            document.getElementById('dateModal').classList.add('hidden');
        }
    </script>

    @include('admin.charts.modaldate')
@endsection
