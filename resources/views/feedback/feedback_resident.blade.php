@extends('layouts.app')

@section('content')
@php
    $alreadyRated = \App\Models\Feedback::where('report_id', $report->id)
        ->where('user_id', auth()->id())
        ->exists();

    $existingFeedback = null;

    if ($alreadyRated) {
        $existingFeedback = \App\Models\Feedback::where('report_id', $report->id)
            ->where('user_id', auth()->id())
            ->first();
    }
@endphp

<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">

    <!-- PAGE TITLE -->
    <h2 class="text-2xl font-bold mb-2 text-center">
        ⭐ Give Feedback
    </h2>

    <p class="text-sm text-gray-600 text-center mb-6">
        Please rate the service related to your report and share your feedback.
    </p>

    <!-- REPORT CONTEXT -->
    <div class="mb-6 p-4 bg-gray-50 rounded border">
        <p class="text-sm">
            <span class="font-semibold">Report ID:</span>
            {{ $report->id ?? 'N/A' }}
        </p>
        <p class="text-sm">
            <span class="font-semibold">Reference ID:</span>
            {{ $report->ref_id ?? 'N/A' }}
        </p>
        <p class="text-sm">
            <span class="font-semibold">Report Title:</span>
            {{ $report->title ?? 'N/A' }}
        </p>
        <p class="text-sm">
            <span class="font-semibold">Report Type:</span>
            {{ $report->type ?? 'N/A' }}
        </p>
        <p class="text-sm">
            <span class="font-semibold">Date Submitted:</span>
            {{ optional($report->created_at)->format('M d, Y') }}
        </p>
    </div>

    <!-- VALIDATION ERRORS -->
    @if ($errors->any())
        <div class="mb-5 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FEEDBACK FORM -->
    <form method="POST" action="{{ route('feedback.store', $report->id) }}" enctype="multipart/form-data">
        @csrf

        <!-- RATING -->
        <div class="mb-5">
            <label class="block text-sm font-medium mb-1">
                Rating <span class="text-red-500">*</span>
            </label>
            <select name="rating" required
                @if ($alreadyRated) disabled @endif
                class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                <option value="">Select rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}"
                        @if (old('rating', $existingFeedback->rating ?? '') == $i) selected @endif>
                        {{ $i }} ⭐ - {{ ['', 'Very Poor', 'Poor', 'Fair', 'Good', 'Excellent'][$i] }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- FEEDBACK -->
        <div class="mb-5">
            <label class="block text-sm font-medium mb-1">
                Feedback <span class="text-red-500">*</span>
            </label>
            <textarea name="feedback"
                rows="4"
                required
                @if ($alreadyRated) readonly @endif
                class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                placeholder="Share your experience or feedback...">{{ old('feedback', $existingFeedback->feedback ?? '') }}</textarea>
        </div>

       <!-- PHOTO -->
<div class="mb-5">
    <label class="block text-sm font-medium mb-1">
        Upload Photo <span class="text-red-500">*</span>
    </label>

    @if (!$alreadyRated)
        <input type="file"
            name="photo"
            id="photoInput"
            required
            accept="image/*"
            onchange="previewPhoto(event)"
            class="block w-full text-sm text-gray-600">

        <div id="photoContainer" class="mt-3 hidden">
            <img id="photoPreview" class="max-h-60 rounded border mb-2">

            <button type="button"
                onclick="removePhoto()"
                class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                ❌ Remove Photo
            </button>
        </div>
    @else
        <div class="mt-3">
            <img src="{{ asset('storage/' . $existingFeedback->photo) }}"
                class="max-h-60 rounded border">
        </div>
    @endif
</div>


        <!-- VIDEO -->
<div class="mb-6">
    <label class="block text-sm font-medium mb-1">
        Upload Video <span class="text-red-500">*</span>
    </label>

    @if (!$alreadyRated)
        <input type="file"
            name="video"
            id="videoInput"
            required
            accept="video/*"
            onchange="previewVideo(event)"
            class="block w-full text-sm text-gray-600">

        <div id="videoContainer" class="mt-3 hidden">
            <video id="videoPreview"
                class="w-full max-h-64 rounded border mb-2"
                controls>
            </video>

            <button type="button"
                onclick="removeVideo()"
                class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                ❌ Remove Video
            </button>
        </div>
    @else
        <div class="mt-3">
            <video controls class="w-full max-h-64 rounded border">
                <source src="{{ asset('storage/' . $existingFeedback->video) }}">
            </video>
        </div>
    @endif
</div>


        <!-- SUBMIT -->
        <div class="flex justify-end">
            @if ($alreadyRated)
                <button type="button" disabled
                    class="px-6 py-2 bg-gray-400 text-white rounded-md cursor-not-allowed">
                    Already Submitted
                </button>
            @else
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Submit Feedback
                </button>
            @endif
        </div>
    </form>

    {{-- ================= ADMIN RESPONSE (RESIDENT VIEW) ================= --}}
    @if ($alreadyRated && $existingFeedback)

        <hr class="my-6">

        <h3 class="text-lg font-bold text-gray-800">
            🛡️ Admin Response
        </h3>

        @if ($existingFeedback->admin_response)
            <div class="mt-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-gray-800">
                    {{ $existingFeedback->admin_response }}
                </p>

                @if ($existingFeedback->admin_responded_at)
                    <p class="text-xs text-gray-500 mt-2">
                        Responded on
                        {{ $existingFeedback->admin_responded_at->format('F j, Y g:i A') }}
                    </p>
                @endif
            </div>
        @else
            <div class="mt-3 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <p class="text-gray-600 italic">
                    Please wait for response.
                </p>
            </div>
        @endif

    @endif

</div>

<script>
function previewPhoto(event) {
    const input = document.getElementById('photoInput');
    const preview = document.getElementById('photoPreview');
    const container = document.getElementById('photoContainer');

    if (!input.files.length) return;

    const reader = new FileReader();
    reader.onload = e => {
        preview.src = e.target.result;
        container.classList.remove('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}

function removePhoto() {
    const input = document.getElementById('photoInput');
    const preview = document.getElementById('photoPreview');
    const container = document.getElementById('photoContainer');

    input.value = '';
    preview.src = '';
    container.classList.add('hidden');
}

function previewVideo(event) {
    const input = document.getElementById('videoInput');
    const preview = document.getElementById('videoPreview');
    const container = document.getElementById('videoContainer');

    if (!input.files.length) return;

    preview.src = URL.createObjectURL(input.files[0]);
    container.classList.remove('hidden');
}

function removeVideo() {
    const input = document.getElementById('videoInput');
    const preview = document.getElementById('videoPreview');
    const container = document.getElementById('videoContainer');

    preview.pause();
    preview.src = '';
    input.value = '';
    container.classList.add('hidden');
}
</script>

@endsection
