@extends('layouts.admin')

@section('content')
    @php

        $alertColor = match ($announcement->alert_level) {
            'Monitoring' => 'bg-yellow-100 text-yellow-700',
            'Warning' => 'bg-orange-100 text-orange-700',
            'Critical' => 'bg-red-100 text-red-700',
            'Evacuation Required' => 'bg-red-600 text-white',
            default => 'bg-gray-100 text-gray-700',
        };

        $statusColor = match ($announcement->status) {
            'active' => 'bg-green-100 text-green-700',
            'resolved' => 'bg-blue-100 text-blue-700',
            'expired' => 'bg-gray-100 text-gray-700',
            default => 'bg-gray-100 text-gray-700',
        };

        $disasterColor = match ($announcement->disaster_type) {
            'Fire' => 'bg-red-100 text-red-700',
            'Flood' => 'bg-blue-100 text-blue-700',
            'Earthquake' => 'bg-yellow-100 text-yellow-700',
            'Typhoon' => 'bg-purple-100 text-purple-700',
            'Gas Leak' => 'bg-orange-100 text-orange-700',
            default => 'bg-gray-100 text-gray-700',
        };
        $alertCardClass = match ($announcement->alert_level) {
            'Monitoring' => 'bg-blue-50 border-blue-200 text-blue-700',
            'Warning' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
            'Critical' => 'bg-red-50 border-red-200 text-red-700',
            'Evacuation Required' => 'bg-red-100 border-red-400 text-red-800',
            default => 'bg-gray-50 border-gray-200 text-gray-700',
        };

    @endphp

    @php

        $alertCardClass = 'bg-yellow-50 border-yellow-200 text-yellow-700';
        $alertIcon = '🟡';

        if ($announcement->alert_level == 'Warning') {
            $alertCardClass = 'bg-orange-50 border-orange-200 text-orange-700';
            $alertIcon = '🟠';
        }

        if ($announcement->alert_level == 'Critical') {
            $alertCardClass = 'bg-red-50 border-red-200 text-red-700';
            $alertIcon = '🔴';
        }

        if ($announcement->alert_level == 'Evacuation Required') {
            $alertCardClass = 'bg-red-100 border-red-300 text-red-800';
            $alertIcon = '🚨';
        }

        $statusCardClass = 'bg-green-50 border-green-200 text-green-700';
        $statusIcon = '🟢';

        if ($announcement->status == 'resolved') {
            $statusCardClass = 'bg-blue-50 border-blue-200 text-blue-700';
            $statusIcon = '🔵';
        }

        if ($announcement->status == 'expired') {
            $statusCardClass = 'bg-gray-50 border-gray-200 text-gray-700';
            $statusIcon = '⚪';
        }

    @endphp

    <div x-data="{ imageModal: false }" class="w-full max-w-5xl mx-auto px-4 mt-6 mb-6">

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

          <!-- IMAGE + MODAL -->
<div x-data="{ showImage: false }">

    <!-- HERO IMAGE -->
    @if ($announcement->image)

        <img
            src="{{ asset('storage/' . $announcement->image) }}"
            alt="{{ $announcement->title }}"
            @click="showImage = true"
            class="w-full h-48 object-cover cursor-pointer hover:brightness-95 transition">

    @else

        <div class="h-48 bg-blue-100 flex items-center justify-center">
            <span class="text-6xl">📢</span>
        </div>

    @endif

    <!-- IMAGE MODAL -->
    @if ($announcement->image)

        <div
            x-show="showImage"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
            @click.self="showImage = false">

            <div class="bg-white rounded-xl shadow-2xl p-4 max-w-3xl w-full mx-4">

                <!-- Close -->
                <div class="flex justify-between items-center mb-4">

                    <h2 class="text-lg font-semibold">
                        📷 Announcement Image
                    </h2>

                    <button
                        @click="showImage = false"
                        class="text-2xl font-bold text-gray-500 hover:text-red-600">
                        &times;
                    </button>

                </div>

                <!-- Preview -->
                <div class="flex justify-center">

                    <img
                        src="{{ asset('storage/' . $announcement->image) }}"
                        alt="{{ $announcement->title }}"
                        class="max-w-full max-h-[70vh] object-contain rounded-lg border">

                </div>

            </div>

        </div>

    @endif

</div>
            <div class="p-6">

                

                <!--start--><!--end-->



                <div class="bg-white rounded-xl border p-6 mb-6">

                    <p class="text-sm uppercase tracking-widest text-gray-500">
                        Emergency Advisory
                    </p>

                    <h1 class="text-3xl font-bold text-gray-900 mb-6">
                        {{ $announcement->title }}
                    </h1>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-gray-500 text-sm">
                                👤 Issued By
                            </p>

                            <p class="font-semibold text-lg">
                                {{ $announcement->issued_by ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">
                                📅 Posted
                            </p>

                            <p class="font-semibold text-lg">
                                {{ $announcement->created_at->format('F d, Y h:i A') }}
                            </p>
                        </div>

                    </div>
                    <br>
                    <br>

                    <!-- Status Summary -->
                    <div class="flex flex-col md:flex-row gap-4 mb-6">

                        <div class="flex-1 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-xs uppercase text-gray-500">
                                Emergency Type
                            </p>

                            <p class="font-bold text-blue-700 text-lg mt-1">
                                {{ $announcement->disaster_type ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="flex-1 rounded-lg border p-4 {{ $alertCardClass }}">
                            <p class="text-xs uppercase text-gray-500">
                                Alert Level
                            </p>

                            <p class="font-bold text-lg mt-1">
                                {{ $announcement->alert_level ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="flex-1 bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-xs uppercase text-gray-500">
                                Status
                            </p>

                            <p class="font-bold text-green-700 text-lg mt-1">
                                {{ ucfirst($announcement->status ?? 'N/A') }}
                            </p>
                        </div>

                    </div>



                </div>
                <!-- Main Grid -->
                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Description -->
                    <div class="bg-blue-50 border rounded-xl p-6">
                        <h2 class="text-xl font-semibold mb-3">
                            📄 Description
                        </h2>

                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($announcement->content)) !!}
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-yellow-50 border rounded-xl p-6">
                        <h2 class="text-xl font-semibold mb-3">
                            🛡️ Mitigation Instructions
                        </h2>

                        <div class="text-gray-700">
                            {!! nl2br(e($announcement->instructions ?? 'No instructions provided.')) !!}
                        </div>
                    </div>

                    <!-- Affected Area -->
                    <div class="bg-red-50 border rounded-xl p-6">
                        <h2 class="text-xl font-semibold mb-3">
                            📍 Affected Area
                        </h2>
                        <p>
                            {{ $announcement->affected_area ?? 'N/A' }}
                        </p>
                    </div>



                    <!-- Evacuation -->
                    <div class="bg-orange-50 border rounded-xl p-6">
                        <h2 class="text-xl font-semibold mb-3">
                            🏃 Evacuation Information
                        </h2>

                        <p>
                            {{ $announcement->evacuation_center ?? 'N/A' }}
                        </p>
                    </div>

                    <!-- Medical -->
                    <div class="bg-green-50 border rounded-xl p-6">
                        <h2 class="text-xl font-semibold mb-3">
                            ➕ Medical Assistance
                        </h2>

                        <p class="mb-2">
                            <strong>Facility:</strong>
                            {{ $announcement->medical_facility_name ?? 'N/A' }}
                        </p>

                        <p>
                            <strong>Contact:</strong>
                            {{ $announcement->medical_facility_contact ?? 'N/A' }}
                        </p>
                    </div>

                    <!-- Security -->
                    <div class="bg-purple-50 border rounded-xl p-6">
                        <h2 class="text-xl font-semibold mb-3">
                            👮 Security Coordination
                        </h2>

                        <div class="text-gray-700">
                            {!! nl2br(e($announcement->security_coordination_note ?? 'No information provided.')) !!}
                        </div>
                    </div>

                    <!-- Reference -->
                    <div class="bg-blue-50 border rounded-xl p-6">

                        <h2 class="text-xl font-semibold mb-3">
                            📚 Reference Source
                        </h2>

                        <p>
                            {{ $announcement->reference_source ?? 'N/A' }}
                        </p>
                    </div>

                    <!-- Effective Period -->
                    <div class="bg-gray-50 border rounded-xl p-6">
                        <h2 class="text-xl font-semibold mb-4">
                            🕒 Effective Period
                        </h2>

                        <div class="grid grid-cols-2 gap-6">

                            <div>
                                <p class="text-gray-500 text-sm">
                                    Start
                                </p>

                                <p class="font-semibold">
                                    {{ $announcement->start_datetime
                                        ? \Carbon\Carbon::parse($announcement->start_datetime)->format('F d, Y h:i A')
                                        : 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500 text-sm">
                                    End
                                </p>

                                <p class="font-semibold">
                                    {{ $announcement->end_datetime
                                        ? \Carbon\Carbon::parse($announcement->end_datetime)->format('F d, Y h:i A')
                                        : 'N/A' }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>



                <!-- Back Button -->
                <div class="mt-8">

                    <a href="{{ route('admin.announcements.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                        ← Back to Announcements
                    </a>

                </div>

            </div>

        </div>

    </div>


    
@endsection

