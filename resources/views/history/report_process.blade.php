@extends('layouts.app')
@push('scripts')
    <script src="https://unpkg.com/alpinejs" defer></script>
@endpush

@php
                                    use Illuminate\Support\Str;

                                    function reportImageUrl($image)
                                    {
                                        if (!$image) {
                                            return null;
                                        }

                                        // If already a full URL (DigitalOcean Spaces)
                                        if (Str::startsWith($image, 'http')) {
                                            return $image;
                                        }

                                        // Otherwise assume local storage path
                                        return asset('storage/' . $image);
                                    }
                                @endphp

@section('content')
    <div class="max-w-screen-xl mx-auto p-5">

        <h2 class="text-2xl font-bold mb-6 text-center">
            ⚙️ Report Processing
        </h2>

        <!-- GRID -->
        @php
            $count = $reports->count();
        @endphp

        @if ($count === 1)
            <!-- If ONLY ONE CARD → center it, keep normal size -->
            <div class="flex justify-center px-6">
                <div class="max-w-md w-full">

                    @foreach ($reports as $report)
                        <div class="rounded-lg overflow-hidden shadow-md bg-white border border-gray-200">

                            <!-- IMAGE + MODAL -->
                            <div x-data="{ showImage: false }">
                                <!-- CLICKABLE IMAGE -->
                                {{-- LINE 33–36 FIX --}}
                                @if (reportImageUrl($report->image))
                                    <img src="{{ reportImageUrl($report->image) }}" alt="Report Image"
                                        class="w-full h-48 object-cover rounded-t">
                                @endif

                                <!-- FULL IMAGE MODAL -->
                                <div x-show="showImage" x-cloak
                                    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
                                    <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl max-h-[80vh] overflow-hidden">

                                        <!-- Close Button -->
                                        <div class="flex justify-end">
                                            <button @click="showImage = false"
                                                class="text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
                                        </div>

                                        <!-- IMAGE PREVIEW 50-51 -->
                                        {{-- LINE 50–51 FIX --}}
                                        @if (reportImageUrl($report->image))
                                            <img src="{{ reportImageUrl($report->image) }}" class="preview-image">
                                        @endif

                                    </div>
                                </div>

                            </div>


                            <!-- Text Content -->
                            <div class="px-6 py-4 space-y-1">

                                <div class="font-bold text-lg">
                                    {{ $report->title }}
                                </div>

                                <p class="text-gray-700 text-sm">
                                    <strong>Reference ID:</strong> {{ $report->ref_id }} <br>
                                    <strong>Type:</strong> {{ $report->type }} <br>
                                    <strong>Subtype:</strong> {{ $report->subtype }} <br>
                                    <strong>Date:</strong> {{ $report->created_at->format('M d, Y') }} <br>
                                    <strong>Location:</strong> {{ $report->location }} <br>
                                </p>

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

                            </div>

                            <!-- Footer Buttons -->
                            <div class="px-6 py-3 flex justify-between items-center bg-gray-50">


                                <span
                                    class="px-3 py-1 text-xs font-semibold text-white rounded-full
    @if ($report->status === 'Pending') bg-yellow-500
    @elseif ($report->status === 'In Progress') bg-blue-600
    @elseif ($report->status === 'Action') bg-indigo-600
    @elseif ($report->status === 'Resolved') bg-green-600
    @elseif ($report->status === 'Cancel') bg-red-600
    @else bg-gray-600 @endif">
                                    {{ $report->status }}
                                </span>

                                <div class="flex gap-2 shrink-0">

                                    <a href="{{ route('reports.full', $report->id) }}"
                                        class="px-3 py-1 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                                        See progress
                                    </a>



                                    @if (!in_array($report->status, ['Action', 'Resolved', 'Cancel']))
                                        <form action="{{ route('report.process.destroy', $report->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                class="delete-report-btn px-3 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded-md"
                                                data-title="{{ $report->title }}" data-status="{{ $report->status }}">
                                                Cancel
                                            </button>
                                        </form>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs bg-gray-300 text-gray-500 rounded-md cursor-not-allowed"
                                            title="This report can no longer be canceled">
                                            Cancel 149
                                        </span>
                                    @endif


                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>
            </div>
        @else
            <!-- If 2 or more → normal grid -->
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 px-6">

                @foreach ($reports as $report)
                    <div class="rounded-lg overflow-hidden shadow-md bg-white border border-gray-200">

                        <!-- remove -->
                        <p class="text-xs text-red-500">{{ $report->image }}</p>
                        <!-- IMAGE + MODAL -->
                        <div x-data="{ showImage: false }">

                            <!-- CLICKABLE IMAGE -->
                            {{-- LINE 184–187 FIX --}}
@if(reportImageUrl($report->image))
    <a href="{{ reportImageUrl($report->image) }}" target="_blank">
        <img
            src="{{ reportImageUrl($report->image) }}"
            class="w-full rounded"
        >
    </a>
@endif

                            <!-- FULL IMAGE MODAL -->
                            <div x-show="showImage" x-cloak
                                class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
                                <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl max-h-[80vh] overflow-hidden">

                                    <!-- Close Button -->
                                    <div class="flex justify-end">
                                        <button @click="showImage = false"
                                            class="text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
                                    </div>

                                    <!-- IMAGE PREVIEW -->
                                    {{-- LINE 201–202 FIX --}}
@if(reportImageUrl($report->image))
    <img
        src="{{ reportImageUrl($report->image) }}"
        class="w-full rounded"
    >
@endif
                                </div>
                            </div>

                        </div>

                        <!-- Text Content -->
                        <div class="px-6 py-4 space-y-1">

                            <div class="font-bold text-lg">
                                {{ $report->title }}
                            </div>

                            <p class="text-gray-700 text-sm">
                                <strong>Reference ID:</strong> {{ $report->ref_id }} <br>
                                <strong>Type:</strong> {{ $report->type }} <br>
                                <strong>Subtype:</strong> {{ $report->subtype }} <br>
                                <strong>Date:</strong> {{ $report->created_at->format('M d, Y') }} <br>

                            </p>
                            <!-- Location Modal -->
                            <div x-data="{ openLocation: false }">
                                <p class="text-gray-700 text-sm cursor-pointer hover:text-indigo-600"
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

                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-3 flex justify-between items-center bg-gray-50">

                            <span
                                class="px-3 py-1 text-xs font-semibold text-white rounded-full
    @if ($report->status === 'Pending') bg-yellow-500
    @elseif ($report->status === 'In Progress') bg-blue-600
    @elseif ($report->status === 'Action') bg-indigo-600
    @elseif ($report->status === 'Resolved') bg-green-600
    @elseif ($report->status === 'Cancel') bg-red-600
    @else bg-gray-600 @endif">
                                {{ $report->status }}
                            </span>

                            <div class="flex gap-2">
                                <a href="{{ route('reports.full', $report->id) }}"
                                    class="px-3 py-1 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                                    Track progress
                                </a>



                                @if (!in_array($report->status, ['Action', 'Resolved', 'Cancel']))
                                    <form action="{{ route('report.process.destroy', $report->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            class="delete-report-btn px-3 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded-md"
                                            data-title="{{ $report->title }}" data-status="{{ $report->status }}">
                                            Cancel
                                        </button>
                                    </form>
                                @else
                                    <span
                                        class="px-3 py-1 text-xs bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                                        Cancel
                                    </span>
                                @endif


                                </form>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>
        @endif




    </div>

    <!-- SweetAlert + Delete Logic (inline like index.blade.php) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-report-btn').forEach(button => {
                button.addEventListener('click', function() {

                    const form = button.closest('form');
                    const status = button.dataset.status;

                    // 🚫 HARD BLOCK for Action
                    if (status === 'Action') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Action in Progress',
                            text: 'This report can no longer be canceled because action has already started.'
                        });
                        return;
                    }

                    const title = button.dataset.title ?? 'this report';

                    Swal.fire({
                        title: `Cancel report "${title}"?`,
                        text: 'This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'No'
                    }).then(result => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
