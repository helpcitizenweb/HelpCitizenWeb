@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss-cdn@3.4.1/tailwindcss.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <h2 class="text-2xl font-bold text-center mb-6 flex items-center justify-center gap-2">
        📜 Report History
    </h2>

    <!-- FILTER BaAR -->
    <div class="max-w-screen-xl mx-auto mt-4 mb-6 flex flex-wrap gap-4 items-center justify-center text-center">


        <!-- TYPE FILTER -->
        <select id="typeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:border-indigo-500">
            <option value="">Type</option>
            <option value="Emergencies">Emergencies</option>
            <option value="Accidents">Accidents</option>
            <option value="Complaints">Complaints</option>
            <option value="Suggestions">Suggestions</option>
            <option value="Others">Others</option>
        </select>

        <!-- SUBTYPE FILTER -->
        <select id="subtypeFilter"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:border-indigo-500 hidden">
            <option value="">Subtype</option>
        </select>

        <!-- STATUS FILTER -->
        <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:border-indigo-500">
            <option value="">Status</option>
            <option value="Pending">Pending</option>
            <option value="Action">Action</option>
            <option value="In Progress">In Progress</option>
            <option value="Resolved">Resolved</option>
        </select>

        <!-- DATE FILTER -->
        <input type="date" id="dateFilter"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:border-indigo-500">

        <!-- RESET BUTTON -->
        <button id="resetFilters" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Reset
        </button>
    </div>


    <!-- SCROLL / DRAG / SNAP CAROUSEL -->
    <div x-data x-init="let isDown = false;
    let startX;
    let scrollLeft;
    const slider = $el.querySelector('.inner-slider');
    
    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => isDown = false);
    slider.addEventListener('mouseup', () => isDown = false);
    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 1;
        slider.scrollLeft = scrollLeft - walk;
    });" class="overflow-x-scroll scrollbar-hide px-2 mb-10" style="overflow-y: hidden;">

        <div class="inner-slider flex snap-x snap-mandatory gap-6 w-max py-4 mx-auto justify-center">


            @foreach ($reports as $report)
                <!-- CARD WRAPPER (with filter data attributes) -->
                <div class="flex-none w-96 snap-center report-card" data-type="{{ strtolower($report->type) }}"
                    data-subtype="{{ strtolower($report->subtype) }}" data-status="{{ strtolower($report->status) }}"
                    data-date="{{ $report->created_at->format('Y-m-d') }}">

                    <div
                        class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">

                        <!-- IMAGE -->
                        <img src="{{ $report->image ? asset('storage/' . $report->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                            class="w-full h-48 object-cover">

                        <!-- CARD BODY -->
                        <div class="p-4">
                            <!-- TITLE -->
                            <h3 class="text-lg font-bold text-gray-900 capitalize">
                                {{ Str::limit($report->title, 20) }}
                            </h3>
                            <p class="text-gray-600 mt-2 text-sm">
                            <strong>Reference ID:</strong> {{ $report->ref_id }}
                            </p>
                            <!-- TYPE -->
                            <p class="text-gray-600 mt-2 text-sm">
                                <strong>Type:</strong> {{ $report->type }}
                            </p>

                            <!-- SUBTYPE -->
                            <p class="text-gray-600 mt-1 text-sm">
                                <strong>SubType:</strong> {{ $report->subtype }}
                            </p>
                            

                            <!-- DATE -->
                            <p class="text-gray-600 mt-1 text-sm"></p>
                            <strong>Date:</strong>{{ $report->created_at->format('M d, Y') }}
                            </p>

                        <!-- location -->
                            <!-- Location Modal -->
<div x-data="{ openLocation: false }">
    <p class="text-gray-600 mt-1 text-sm cursor-pointer hover:text-indigo-600"
        @click="openLocation = true">
        <strong>Location:</strong>
        {{ Str::limit($report->location, 50) }}
        <span class="text-indigo-500 underline text-xs">view</span>
    </p>

    <div x-show="openLocation" x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm 
            flex items-center justify-center z-50">

        <div class="bg-white w-[900px] max-h-[60vh] rounded-lg shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h3 class="text-xl font-semibold">Full Location</h3>
                <button @click="openLocation = false"
                    class="text-gray-600 hover:text-gray-900 text-2xl leading-none">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4 overflow-y-auto max-h-[50vh]">
                <label class="font-semibold text-gray-700">Location:</label>

                <textarea
                    class="w-full h-40 p-3 border border-gray-300 rounded-md text-sm resize-none 
                        bg-gray-50 text-gray-800 leading-relaxed"
                    readonly>{{ $report->location }}</textarea>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t flex justify-end">
                <button @click="openLocation = false"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


                            <!-- Description Modal -->
                            <div x-data="{ openDesc: false }">
                                <p class="text-sm text-gray-700 cursor-pointer hover:text-indigo-600"
                                    @click="openDesc = true">
                                    <strong>Description:</strong>
                                    {{ Str::limit($report->description, 50) }}
                                    <span class="text-indigo-500 underline text-xs">read more</span>
                                </p>

                                <div x-show="openDesc" x-cloak
                                    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm 
                                        flex items-center justify-center z-50">

                                    <div class="bg-white w-[900px] max-h-[60vh] rounded-lg shadow-xl overflow-hidden">

                                        <div class="flex justify-between items-center px-6 py-4 border-b">
                                            <h3 class="text-xl font-semibold">Full Description</h3>
                                            <button @click="openDesc = false"
                                                class="text-gray-600 hover:text-gray-900 text-2xl leading-none">&times;</button>
                                        </div>

                                        <div class="p-6 space-y-4 overflow-y-auto max-h-[50vh]">
                                            <label class="font-semibold text-gray-700">Description:</label>

                                            <textarea
                                                class="w-full h-40 p-3 border border-gray-300 rounded-md text-sm resize-none bg-gray-50 text-gray-800 leading-relaxed"
                                                readonly>{{ $report->description }}</textarea>
                                        </div>

                                        <div class="px-6 py-4 border-t flex justify-end">
                                            <button @click="openDesc = false"
                                                class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                                                Close
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-4">

                                <!-- Status -->
                                <span
    class="text-xs px-3 py-1 rounded-full text-white
    @if ($report->status === 'Pending') bg-yellow-500
    @elseif ($report->status === 'In Progress') bg-blue-600
    @elseif ($report->status === 'Action') bg-indigo-600
    @elseif ($report->status === 'Resolved') bg-green-600
    @elseif ($report->status === 'Cancel') bg-red-600
    @else bg-gray-700
    @endif">
    {{ $report->status }}
</span>


                                <!-- Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('reports.full', $report->id) }}"
                                        class="px-4 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-xs">
                                        View Full report
                                    </a>

                                    

    @if ($report->status === 'Resolved')
    <a href="{{ route('feedback.create', $report->id) }}"
       class="px-4 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs">
        Rate
    </a>
@else
    <span
        class="px-4 py-1 bg-gray-300 text-gray-500 rounded-md text-xs cursor-not-allowed"
        title="You can rate this report once it is resolved">
        Rate
    </span>
@endif

                                </div>

                            </div>


                        </div>
                    </div>

                </div>
            @endforeach

        </div>

    </div>


    <!-- FILTER SCRIPT -->
    <script>
        const allowedTypes = {
            "Emergencies": ["Fire", "Flood", "Earthquake", "Medical", "Others"],
            "Accidents": ["Traffic", "Workplace", "Home", "Others"],
            "Complaints": ["Noise", "Garbage", "Harassment", "Others"],
            "Suggestions": ["Public Safety", "Infrastructure", "Services", "Others"],
            "Others": ["Miscellaneous"]
        };

        const typeFilter = document.getElementById("typeFilter");
        const subtypeFilter = document.getElementById("subtypeFilter");
        const statusFilter = document.getElementById("statusFilter");
        const dateFilter = document.getElementById("dateFilter");
        const resetBtn = document.getElementById("resetFilters");
        const cards = document.querySelectorAll(".report-card");


        // TYPE CHANGES → UPDATE SUBTYPES
        typeFilter.addEventListener("change", () => {
            subtypeFilter.innerHTML = `<option value="">Subtype</option>`;

            if (typeFilter.value) {
                allowedTypes[typeFilter.value].forEach(st => {
                    subtypeFilter.innerHTML += `<option value="${st}">${st}</option>`;
                });
                subtypeFilter.classList.remove("hidden");
            } else {
                subtypeFilter.classList.add("hidden");
            }

            applyFilters();
        });

        // Apply filters when subtype/status/date changes
        [subtypeFilter, statusFilter, dateFilter].forEach(el => {
            el.addEventListener("change", applyFilters);
        });

        // MAIN FILTER FUNCTION
        function applyFilters() {
            const t = typeFilter.value.toLowerCase();
            const st = subtypeFilter.value.toLowerCase();
            const s = statusFilter.value.toLowerCase();
            const d = dateFilter.value;

            cards.forEach(card => {
                const cardType = card.dataset.type;
                const cardSubtype = card.dataset.subtype;
                const cardStatus = card.dataset.status;
                const cardDate = card.dataset.date;

                const show =
                    (!t || cardType === t) &&
                    (!st || cardSubtype === st) &&
                    (!s || cardStatus === s) &&
                    (!d || cardDate === d);

                card.style.display = show ? "block" : "none";
            });
        }

        // RESET BUTTON
        resetBtn.addEventListener("click", () => {
            typeFilter.value = "";
            subtypeFilter.value = "";
            subtypeFilter.classList.add("hidden");

            statusFilter.value = "";
            dateFilter.value = "";

            cards.forEach(c => c.style.display = "block");
        });
    </script>
@endsection
