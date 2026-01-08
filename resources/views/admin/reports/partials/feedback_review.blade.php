<div class="bg-white p-6 rounded-xl shadow space-y-6">

    <h2 class="text-xl font-bold">⭐ Resident Feedback</h2>

    {{-- ================= NO FEEDBACK YET ================= --}}
    @if (!$feedback)
        <p class="text-gray-600">
            No feedback has been submitted yet.
        </p>
    @else

        {{-- ================= RATING ================= --}}
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-1">⭐ Rating</h4>
            <p class="text-gray-800 font-semibold">
                {{ $feedback->rating }} / 5
            </p>
        </div>

        {{-- ================= FEEDBACK MESSAGE ================= --}}
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-1">📝 Message</h4>
            <p class="text-gray-800 leading-relaxed">
                {{ $feedback->feedback }}
            </p>
        </div>

        {{-- ================= DATE & TIME ================= --}}
        <div class="text-sm text-gray-500">
            Submitted on {{ $feedback->created_at->format('F j, Y g:i A') }}
        </div>

        {{-- ================= PHOTO ================= --}}
        @if ($feedback->photo)
            <div>
                <h4 class="text-lg font-medium text-gray-700 mb-2">📷 Photo</h4>
                <img
                    src="{{ asset('storage/' . $feedback->photo) }}"
                    class="w-48 h-48 object-cover rounded border shadow"
                >
            </div>
        @endif

        {{-- ================= VIDEO ================= --}}
        @if ($feedback->video)
            <div>
                <h4 class="text-lg font-medium text-gray-700 mb-2">🎥 Video</h4>
                <video controls class="w-64 rounded-lg border shadow">
                    <source src="{{ asset('storage/' . $feedback->video) }}">
                </video>
            </div>
        @endif

    @endif

    {{-- ================= ADMIN RESPONSE ================= --}}
@if ($feedback)

    <hr class="my-6">

    <h3 class="text-lg font-bold text-gray-800">🛡️ Admin Response</h3>

    @if ($feedback->admin_response)

        {{-- ✅ Already responded --}}
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-3">
            <p class="text-gray-800 leading-relaxed">
                {{ $feedback->admin_response }}
            </p>

            <p class="text-xs text-gray-500 mt-2">
                Responded on {{ $feedback->admin_responded_at->format('F j, Y g:i A') }}
            </p>
        </div>

    @else

        {{-- ❌ Not yet responded --}}
        <form
    action="{{ route('admin.feedback.respond', $feedback) }}"
    method="POST"
    class="mt-4 space-y-4"
>
    @csrf

    <textarea
        name="admin_response"
        rows="4"
        class="w-full border rounded-lg p-3"
        required
    ></textarea>

    <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg"
    >
        Submit Response
    </button>
</form>


    @endif

@endif

</div>
