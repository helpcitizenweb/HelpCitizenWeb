@php
    use Illuminate\Support\Str;

    function reportMediaUrl($media)
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
@endphp

<div x-data="{ showImage: false, showVideo: false }" class="bg-white p-6 rounded-xl shadow space-y-8">

    <!-- HEADER -->
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
        ⭐ Resident Feedback Review
    </h2>

    {{-- ================= NO FEEDBACK ================= --}}
    @if (!$feedback)
        <div class="text-gray-500 italic bg-gray-50 p-4 rounded-lg">
            No feedback has been submitted yet.
        </div>
    @else
        {{-- ================= FEEDBACK SUMMARY ================= --}}
        <div class="bg-gray-50 border rounded-lg p-5 space-y-4">
            <h3 class="text-lg font-semibold text-gray-700">🧾 Feedback Summary</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <p>
                    <strong>⭐ Rating:</strong>
                    <span class="font-semibold text-gray-800">
                        {{ $feedback->rating }} / 5
                    </span>
                </p>

                <p class="text-gray-500">
                    <strong>Submitted:</strong>
                    {{ $feedback->created_at->format('F j, Y g:i A') }}
                </p>
            </div>
        </div>

        {{-- ================= MESSAGE ================= --}}
        <div class="bg-white border rounded-lg p-5 space-y-2">
            <h4 class="text-lg font-semibold text-gray-700">📝 Resident Message</h4>

            <p class="text-gray-800 leading-relaxed whitespace-pre-line">
                {{ $feedback->feedback }}
            </p>
        </div>

        {{-- ================= ATTACHMENTS ================= --}}
        @if ($feedback->photo || $feedback->video)
            <div class="bg-gray-50 border rounded-lg p-5 space-y-4">
                <h4 class="text-lg font-semibold text-gray-700">📎 Attachments</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- PHOTO --}}
                    @if ($feedback->photo)
                        <div class="bg-white p-3 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-medium text-gray-700 mb-2">
                                📷 Photo
                            </h4>
                            {{-- img starts at  line 60-66 --}}
                            @php
                                $photoUrl = reportMediaUrl($feedback->photo);
                            @endphp

                            @if ($photoUrl)
                                <img src="{{ $photoUrl }}"
                                    class="w-full h-48 object-cover rounded border shadow cursor-pointer hover:scale-105 transition"
                                    @click="showImage = true" alt="Feedback Photo">
                            @endif

                        </div>
                    @endif

                    {{-- VIDEO --}}
                    @if ($feedback->video)
                        <div class="bg-white p-3 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-medium text-gray-700 mb-2">
                                🎥 Video
                            </h4>
                            {{-- video starts at line 74-81 --}}
                            @php
                                $videoUrl = reportMediaUrl($feedback->video);
                            @endphp

                            @if ($videoUrl)
                                <video @click="showVideo = true"
                                    class="w-full h-48 rounded-lg border shadow cursor-pointer hover:scale-105 transition">
                                    <source src="{{ $videoUrl }}">
                                    Your browser does not support the video tag.
                                </video>
                            @endif

                        </div>
                    @endif

                </div>
            </div>
        @endif


        {{-- ================= ADMIN RESPONSE ================= --}}
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                🛡️ Admin Response
            </h3>

            @if ($feedback->admin_response)
                {{-- ✅ RESPONDED --}}
                <div class="bg-green-50 border border-green-200 rounded-lg p-5 space-y-2">
                    <p class="text-gray-800 leading-relaxed whitespace-pre-line">
                        {{ $feedback->admin_response }}
                    </p>

                    <p class="text-xs text-gray-500">
                        Responded on {{ $feedback->admin_responded_at->format('F j, Y g:i A') }}
                    </p>
                </div>
            @else
                {{-- ❌ NOT RESPONDED --}}
                <form action="{{ route('admin.feedback.respond', $feedback) }}" method="POST"
                    class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 space-y-4">
                    @csrf

                    <p class="text-sm text-gray-600">
                        No admin response yet. You may submit one below.
                    </p>

                    <textarea name="admin_response" rows="4" class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200"
                        required placeholder="Write your response to the resident..."></textarea>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition">
                            Submit Response
                        </button>
                    </div>
                </form>
            @endif
        </div>

    @endif

    {{-- ================= IMAGE MODAL ================= --}}
    @if ($feedback && $feedback->photo)
        <div x-show="showImage" x-transition class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center"
            @click.self="showImage = false">
            <div class="bg-white rounded-xl p-4 max-w-3xl w-full relative">
                <button class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl"
                    @click="showImage = false">&times;</button>

                <img src="{{ asset('storage/' . $feedback->photo) }}"
                    class="w-full max-h-[80vh] object-contain rounded-lg">
            </div>
        </div>
    @endif


    {{-- ================= VIDEO MODAL ================= --}}
    @if ($feedback && $feedback->video)
        <div x-show="showVideo" x-transition class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center"
            @click.self="showVideo = false">
            <div class="bg-white rounded-xl p-4 max-w-4xl w-full relative">
                <button class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl"
                    @click="showVideo = false">&times;</button>

                <video controls autoplay class="w-full max-h-[80vh] rounded-lg">
                    <source src="{{ asset('storage/' . $feedback->video) }}">
                </video>
            </div>
        </div>
    @endif


</div>
