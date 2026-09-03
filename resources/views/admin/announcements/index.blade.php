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
    <div class="container mx-auto mt-8">
        <!-- Header -->
        <div class="mb-8">

            <!-- Top Row -->
            <div class="flex items-center justify-between">
                <h1 class="text-4xl font-bold text-gray-800 flex items-center gap-3">
                    📢 Emergency Announcements
                </h1>

                <a href="{{ route('admin.announcements.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-xl shadow transition">
                    ➕ Add New Announcement
                </a>
            </div>

            <!-- Description -->
            <p class="text-gray-500 mt-2">
                Manage emergency advisories, alerts, and mitigation information for residents.
            </p>

        </div>
        <!--header-->
        <!-- Dashboard Summary -->
        <div class="w-full mx-auto mb-4">
            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-4 gap-4 mb-8">
                <!-- Total -->

                <div
                    class="bg-indigo-600 border border-indigo-700 rounded-xl shadow-sm p-4 hover:bg-indigo-700 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Total Announcements
                            </p>
                            <h2 class="text-3xl font-bold text-white mt-2">
                                {{ $announcements->count() }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-2xl">
                            📢
                        </div>
                    </div>
                </div>
                <!-- Active -->
                <div
                    class="bg-blue-600 border border-blue-700 rounded-xl shadow-sm p-4 hover:bg-blue-700 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Active
                            </p>

                            <h2 class="text-3xl font-bold text-white mt-2">
                                {{ \App\Models\Announcement::where('status', 'active')->count() }}
                            </h2>
                        </div>

                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-2xl">
                            ⚙️
                        </div>
                    </div>
                </div>
                <!-- Resolved -->
                <div
                    class="bg-green-600 border border-green-700 rounded-xl shadow-sm p-4 hover:bg-green-700 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Resolved
                            </p>
                            <h2 class="text-3xl font-bold text-white mt-2">
                                {{ \App\Models\Announcement::where('status', 'resolved')->count() }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-2xl">
                            ✅
                        </div>
                    </div>
                </div>
                <!-- MOnitoring -->
                <div
                    class="bg-slate-800 border border-slate-900 rounded-xl shadow-sm p-4 hover:bg-slate-900 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Monitoring
                            </p>
                            <h2 class="text-3xl font-bold text-white mt-2">
                                {{ \App\Models\Announcement::where('alert_level', 'Monitoring')->count() }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-2xl">
                            💻
                        </div>
                    </div>
                </div>

            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-5xl mx-auto mb-8">

                <!-- Warning -->
                <!-- Warning -->
                <div
                    class="bg-yellow-500 border border-yellow-600 rounded-xl shadow-sm p-4 hover:bg-yellow-600 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Warning
                            </p>

                            <h2 class="text-3xl font-bold text-white mt-2">
                                {{ \App\Models\Announcement::where('alert_level', 'Warning')->count() }}
                            </h2>
                        </div>

                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-2xl">
                            ⚠️
                        </div>
                    </div>
                </div>
                <!-- Critical -->
                <!-- Critical -->
                <div
                    class="bg-red-600 border border-red-700 rounded-xl shadow-sm p-4 hover:bg-red-700 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Critical Alerts
                            </p>

                            <h2 class="text-3xl font-bold text-white mt-2">
                                {{ \App\Models\Announcement::where('alert_level', 'Critical')->count() }}
                            </h2>
                        </div>

                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-2xl">
                            ⛔
                        </div>
                    </div>
                </div>
                <!-- Evacuation -->
                <div
                    class="bg-green-500 border border-green-600 rounded-xl shadow-sm p-4 hover:bg-green-600 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Evacuation Required
                            </p>

                            <h2 class="text-3xl font-bold text-white mt-2">
                                {{ \App\Models\Announcement::where('alert_level', 'Evacuation Required')->count() }}
                            </h2>
                        </div>

                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-2xl">
                            🚨
                        </div>
                    </div>
                </div>

            </div>
            <!--dashboard--->


            <!--filters--->
            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 mb-6">

                <div class="flex items-center gap-4">

                    <!-- Search -->
                    <div class="flex-1 relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            🔍
                        </span>

                        <input type="text" id="searchAnnouncement" placeholder="Search announcements..."
                            class="w-full h-12 pl-11 pr-4 rounded-xl border border-gray-200 bg-white
                       text-gray-700 placeholder-gray-400
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       transition">
                    </div>

                    <!-- Disaster Type -->
                    <div class="w-48">
                        <select id="typeFilter"
                            class="w-full h-12 px-4 rounded-xl border border-gray-200 bg-white
                       text-gray-700 focus:ring-2 focus:ring-blue-500
                       focus:border-blue-500 transition">

                            <option value="">All Types</option>
                            <option value="Fire">Fire</option>
                            <option value="Flood">Flood</option>
                            <option value="Earthquake">Earthquake</option>
                            <option value="Typhoon">Typhoon</option>
                            <option value="Accident">Accident</option>
                            <option value="General Advisory">General Advisory</option>

                        </select>
                    </div>

                    <!-- Alert Level -->
                    <div class="w-48">
                        <select id="alertFilter"
                            class="w-full h-12 px-4 rounded-xl border border-gray-200 bg-white
                       text-gray-700 focus:ring-2 focus:ring-red-500
                       focus:border-red-500 transition">

                            <option value="">All Alert Levels</option>
                            <option value="Monitoring">Monitoring</option>
                            <option value="Warning">Warning</option>
                            <option value="Critical">Critical</option>
                            <option value="Evacuation Required">Evacuation Required</option>

                        </select>
                    </div>

                    <!-- Status -->
                    <div class="w-44">
                        <select id="statusFilter"
                            class="w-full h-12 px-4 rounded-xl border border-gray-200 bg-white
                       text-gray-700 focus:ring-2 focus:ring-green-500
                       focus:border-green-500 transition">

                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="resolved">Resolved</option>

                        </select>
                    </div>

                    <!-- Reset -->
                    <button id="resetFilters"
                        class="h-12 px-6 rounded-xl border border-gray-200 bg-white
                   hover:bg-gray-50 text-gray-700 font-medium
                   transition flex items-center gap-2">

                        ↻ Reset

                    </button>

                </div>

            </div>
            <!-- End Filters -->

            <!-- Announcements Cards -->
            @if ($announcements->isEmpty())
                <div class="bg-white rounded-xl shadow-lg p-10 text-center">
                    <div class="text-6xl mb-4">📢</div>
                    <h3 class="text-xl font-semibold text-gray-700">No Announcements Found</h3>
                    <p class="text-gray-500 mt-2">
                        There are currently no announcements available.
                    </p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($announcements as $announcement)
                        <div class="announcement-card
           bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 border border-gray-100"
                            data-title="{{ strtolower($announcement->title) }}"
                            data-description="{{ strtolower($announcement->content) }}"
                            data-type="{{ strtolower($announcement->disaster_type) }}"
                            data-alert="{{ strtolower($announcement->alert_level) }}"
                            data-status="{{ strtolower($announcement->status) }}">

<!--IMage needed to be shown-->
                            {{-- Announcement Image --}}
                            <!-- Announcement Image -->
@php
    $imageUrl = announcementMediaUrl($announcement->image);
@endphp

@if ($imageUrl)
    <img src="{{ $imageUrl }}"
         alt="{{ $announcement->title }}"
         class="w-full h-40 object-cover">
@else
    <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
        <span class="text-6xl">📢</span>
    </div>
@endif
<!--IMage needed to be shown-->
                            <div class="p-4">

                                {{-- Title --}}
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $announcement->title }}
                                </h3>

                                {{-- Badges --}}
                                <div class="flex flex-wrap gap-2 mt-3">

                                    @if ($announcement->disaster_type)
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                            {{ $announcement->disaster_type }}
                                        </span>
                                    @endif

                                    @if ($announcement->alert_level)
                                        @php
                                            $alertColor = match ($announcement->alert_level) {
                                                'Monitoring' => 'bg-cyan-100 text-cyan-700',
                                                'Warning' => 'bg-yellow-100 text-yellow-700',
                                                'Critical' => 'bg-red-100 text-red-700',
                                                'Evacuation Required' => 'bg-red-900 text-white',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp

                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $alertColor }}">
                                            {{ $announcement->alert_level }}
                                        </span>
                                    @endif

                                    @if ($announcement->status)
                                        @php
                                            $statusColor = match (strtolower($announcement->status)) {
                                                'active' => 'bg-green-100 text-green-700',
                                                'resolved' => 'bg-blue-100 text-blue-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp

                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ ucfirst($announcement->status) }}
                                        </span>
                                    @endif
                                </div>
                                {{-- Date --}}
                                <div class="mt-5 flex items-center text-sm text-gray-500">
                                    <span class="mr-2">📅</span>
                                    {{ $announcement->created_at->format('M d, Y') }}
                                </div>

                                {{-- Buttons --}}
                                <div class="flex gap-2 mt-5">

                                    <a href="{{ route('admin.announcements.view', $announcement->id) }}"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-1.5 text-sm rounded-lg transition">
                                        View
                                    </a>

                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-1.5 text-sm rounded-lg transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}"
                                        method="POST" class="flex-1 delete-announcement-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white py-1.5 text-sm rounded-lg transition delete-announcement-btn"
                                            data-title="{{ $announcement->title }}">
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>
            @endif
        </div>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('.delete-announcement-btn');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const form = this.closest('form');
                        const title = this.getAttribute('data-title');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: `Delete the announcement: "${title}"?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#e3342f',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
        <!-- Success Toast -->
        @if (session('success'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            </script>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const search = document.getElementById('searchAnnouncement');
                const type = document.getElementById('typeFilter');
                const alert = document.getElementById('alertFilter');
                const status = document.getElementById('statusFilter');
                const reset = document.getElementById('resetFilters');

                const cards = document.querySelectorAll('.announcement-card');

                function filterCards() {

                    const searchValue = search.value.toLowerCase();
                    const typeValue = type.value.toLowerCase();
                    const alertValue = alert.value.toLowerCase();
                    const statusValue = status.value.toLowerCase();

                    cards.forEach(card => {

                        const title = card.dataset.title;
                        const description = card.dataset.description;
                        const disasterType = card.dataset.type;
                        const alertLevel = card.dataset.alert;
                        const cardStatus = card.dataset.status;

                        const matchesSearch =
                            title.includes(searchValue) ||
                            description.includes(searchValue);

                        const matchesType =
                            typeValue === "" ||
                            disasterType === typeValue;

                        const matchesAlert =
                            alertValue === "" ||
                            alertLevel === alertValue;

                        const matchesStatus =
                            statusValue === "" ||
                            cardStatus === statusValue;

                        if (
                            matchesSearch &&
                            matchesType &&
                            matchesAlert &&
                            matchesStatus
                        ) {
                            card.style.display = "";
                        } else {
                            card.style.display = "none";
                        }

                    });

                }

                search.addEventListener('keyup', filterCards);
                type.addEventListener('change', filterCards);
                alert.addEventListener('change', filterCards);
                status.addEventListener('change', filterCards);

                reset.addEventListener('click', () => {

                    search.value = "";
                    type.value = "";
                    alert.value = "";
                    status.value = "";

                    filterCards();

                });

            });
        </script>
    @endsection
