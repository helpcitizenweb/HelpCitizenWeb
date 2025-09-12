@extends('layouts.admin')

@section('content')
<div 
    x-data="{ 
        showModal: false, 
        status: '{{ $report->status }}', 
        showStatusDialog: false, 
        showWarningDialog: false, 
        showResolutionDialog: false
    }"  
    class="max-w-4xl m-auto"
>
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">📄 Report Details</h2>
        <a href="{{ route('admin.reports') }}" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            ← Back to Reports
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg space-y-6 mb-4">
        <!-- Title -->
        <div>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $report->title }}</h3>
            <p class="mt-1 text-sm text-gray-500">Submitted on {{ $report->created_at->format('F j, Y g:i A') }}</p>
        </div>

        <!-- Description -->
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">📝 Description</h4>
            <p class="text-gray-800 leading-relaxed">{{ $report->description }}</p>
        </div>

        <!-- Demographics -->
        @if($report->casualties || $report->gender)
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">🧑‍🤝‍🧑 Demographics</h4>
            @if($report->casualties)
                <p><strong>Number of Casualties:</strong> {{ $report->casualties }}</p>
            @endif
            @if($report->gender)
                <p><strong>Gender:</strong> {{ $report->gender }}</p>
            @endif
        </div>
        @endif

        <!-- Uploaded Image -->
        @if($report->image)
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">📷 Uploaded Image</h4>
            <img 
                src="{{ asset('storage/' . $report->image) }}" 
                alt="Report Image" 
                class="w-32 h-32 object-cover rounded cursor-pointer border shadow"
                @click="showModal = true"
            >
        </div>
        @endif

        <!-- Current Status -->
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">🚦 Current Status</h4>
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold 
                {{ $report->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                ($report->status == 'In Progress' ? 'bg-blue-100 text-blue-800' : 
                'bg-green-100 text-green-800') }}">
                {{ $report->status }}
            </span>

            <!-- Edit Status Button -->
            <div class="mt-4">
                <button type="button"
                        @click="
                            if (status === 'Resolved') { 
                                showWarningDialog = true 
                            } else { 
                                showStatusDialog = true 
                            }"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                    Edit Status
                </button>
            </div>
        </div>

        <!-- Current Resolution -->
        @if($report->status === 'Resolved')
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">📝 Current Resolution</h4>
            @if($report->evacuation_site)
                <p><strong>Evacuation Site:</strong> {{ $report->evacuation_site }}</p>
            @endif
            <p><strong>Dispatch Unit:</strong> {{ $report->dispatch_unit }}</p>
            <p><strong>Contact Person:</strong> {{ $report->contact_person }}</p>
            <p><strong>Contact Number:</strong> {{ $report->contact_number }}</p>

            <!-- Edit Resolution Button -->
            <div class="mt-4">
                <button type="button"
                        @click="showResolutionDialog = true"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                    Edit Resolution
                </button>
            </div>
        </div>
        @endif
    </div>

    <!-- Warning Dialog (if status is Resolved) -->
    <div x-show="showWarningDialog" x-transition
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">⚠️ Warning</h3>
            <p class="mb-4">Changing the status will delete the resolution details. Continue?</p>
            <div class="flex justify-end gap-3">
                <button type="button" @click="showWarningDialog = false"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
                <button type="button" 
                        @click="showWarningDialog = false; showStatusDialog = true; status='Pending';"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Yes, continue
                </button>
            </div>
        </div>
    </div>

    <!-- Status Update Dialog -->
    <div x-show="showStatusDialog" x-transition
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Update Status</h3>
            <form method="POST" action="{{ route('admin.reports.updateStatus', $report->id) }}">
                @csrf
                @method('PUT')

                <!-- Hidden input ensures status is always sent -->
                <input type="hidden" name="status" x-bind:value="status">

                <template x-if="status !== 'Resolved'">
                    <select name="status_select" class="w-full border p-3 rounded-lg mb-4" x-model="status">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </template>

                <template x-if="status === 'Resolved'">
                    @include('admin.reports.resolution')
                </template>

                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" @click="showStatusDialog = false"
                            class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resolution Edit Dialog -->
    <div x-show="showResolutionDialog" x-transition
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Edit Resolution</h3>
            <form method="POST" action="{{ route('admin.reports.updateResolution', $report->id) }}">
                @csrf
                @method('PUT')

                @include('admin.reports.resolution')

                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" @click="showResolutionDialog = false"
                            class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for full image -->
    @if($report->image)
    <div 
        x-show="showModal"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
        @click.self="showModal = false"
    >
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl w-full relative">
            <button 
                @click="showModal = false"
                class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl"
            >
                ✕
            </button>
            <img 
                src="{{ asset('storage/' . $report->image) }}" 
                alt="Full Image"
                class="w-full max-h-[80vh] object-contain rounded"
            >
        </div>
    </div>
    @endif

</div>
@endsection
