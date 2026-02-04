<div x-data="{ showImageModal: false, showVideoModal: false }"
     class="bg-white p-6 rounded-xl shadow space-y-6">

    

    <!-- ================= TITLE ================= -->
    <div>
        <h3 class="text-2xl font-semibold text-gray-900">{{ $report->title }}</h3>
        <p class="mt-1 text-sm text-gray-500">Reference ID: {{ $report->id }}</p>
        <p class="mt-1 text-sm text-gray-500">Reference ID: {{ $report->ref_id }}</p>
        <p class="mt-1 text-sm text-gray-500">
            Submitted on {{ $report->created_at->format('F j, Y g:i A') }}
        </p>
    </div>

    <!-- ================= MEDIA ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @if ($report->image)
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                <h4 class="text-lg font-medium text-gray-700 mb-2">📷 Uploaded Image</h4>
                <img src="{{ asset('storage/' . $report->image) }}"
                     alt="Report Image"
                     @click="showImageModal = true"
                     class="w-full h-48 object-cover rounded border shadow cursor-pointer hover:scale-105 transition">
            </div>
        @endif

        @if ($report->video)
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                <h4 class="text-lg font-medium text-gray-700 mb-2">🎥 Uploaded Video</h4>
                <video @click="showVideoModal = true"
                       class="w-full h-48 rounded-lg border shadow cursor-pointer hover:scale-105 transition">
                    <source src="{{ asset('storage/' . $report->video) }}">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
    </div>

    <!-- ================= DESCRIPTION ================= -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <h4 class="text-lg font-medium text-gray-700 mb-2">📝 Description</h4>
        <p class="text-gray-800 leading-relaxed">{{ $report->description }}</p>
    </div>

    <!-- ================= CLASSIFICATION ================= -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <h4 class="text-lg font-medium text-gray-700 mb-2">📌 Report Classification</h4>
        <p><strong>Type:</strong> {{ $report->type }}</p>
        <p><strong>Subtype:</strong> {{ $report->subtype }}</p>
    </div>

    <!-- ================= LOCATION ================= -->
    @if ($report->location)
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h4 class="text-lg font-medium text-gray-700 mb-2">📍 Location</h4>
            <p class="text-gray-800">{{ $report->location }}</p>
        </div>
    @endif

    <!-- ================= DEMOGRAPHICS ================= -->
    @if (in_array($report->type, ['Emergencies', 'Accidents']))
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h4 class="text-lg font-medium text-gray-700 mb-2">🧑‍🤝‍🧑 Demographics</h4>
            @if ($report->casualties)
                <p><strong>Number of Casualties:</strong> {{ $report->casualties }}</p>
            @endif
            @if ($report->gender)
                <p><strong>Gender:</strong> {{ $report->gender }}</p>
            @endif
        </div>
    @endif

    <!-- ================= IMAGE MODAL ================= -->
    @if ($report->image)
        <div x-show="showImageModal"
             x-transition
             class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
             @click.self="showImageModal = false">
            <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl w-full relative">
                <button @click="showImageModal = false"
                        class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">✕</button>
                <img src="{{ asset('storage/' . $report->image) }}"
                     class="w-full max-h-[80vh] object-contain rounded">
            </div>
        </div>
    @endif

    <!-- ================= VIDEO MODAL ================= -->
    @if ($report->video)
        <div x-show="showVideoModal"
             x-transition
             class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
             @click.self="showVideoModal = false">
            <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl w-full relative">
                <button @click="showVideoModal = false"
                        class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">✕</button>
                <video controls class="w-full max-h-[80vh] rounded">
                    <source src="{{ asset('storage/' . $report->video) }}">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    @endif
    <!-- ================= STATUS SECTION ================= -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">📄 Status</h4>

        <!-- Status Badge -->
        <p class="mb-3">
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                {{ $report->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                   ($report->status == 'In Progress' ? 'bg-blue-100 text-blue-800' :
                   ($report->status == 'Action' ? 'bg-purple-100 text-purple-800' :
                   ($report->status == 'Cancel' ? 'bg-red-100 text-red-800' :
                   'bg-green-100 text-green-800'))) }}">
                {{ $report->status }}
            </span>
        </p>

        <!-- Update Status Form -->
        @if ($report->status !== 'Resolved')
            <form action="{{ route('admin.reports.updateStatus', $report->id) }}"
                  method="POST"
                  class="flex flex-wrap items-center gap-3">
                @csrf
                @method('PUT')

                <select name="status"
                        class="border border-gray-300 rounded px-3 py-1">
                    <option value="Pending" {{ $report->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ $report->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Action" {{ $report->status === 'Action' ? 'selected' : '' }}>Action</option>
                    <option value="Cancel" {{ $report->status === 'Cancel' ? 'selected' : '' }}>Cancel</option>
                </select>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 transition">
                    Update
                </button>
            </form>
        @else
            <div class="p-3 bg-green-50 border border-green-200 rounded">
                <p class="text-green-700 font-medium">
                    ✅ This report has been resolved and can no longer be updated.
                </p>
            </div>
        @endif
    </div>

</div>
