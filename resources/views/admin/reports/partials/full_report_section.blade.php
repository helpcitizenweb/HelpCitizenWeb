<div class="bg-white p-6 rounded-xl shadow space-y-6">
    <!-- Status Section -->
<div class="mt-4">
    <h4 class="text-lg font-medium text-gray-700 mb-2">📄 Status</h4>

    <!-- Display Current Status -->
    <p class="text-gray-800 mb-3">
        <strong>{{ $report->status }}</strong>
    </p>

    <!-- Update Status Form -->
    <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST" class="flex items-center space-x-3">
    @csrf
    @method('PUT')

    <select name="status" class="border border-gray-300 rounded px-3 py-1">
        <option value="Pending"      {{ $report->status === 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="In Progress"  {{ $report->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
        <option value="Action"       {{ $report->status === 'Action' ? 'selected' : '' }}>Action</option>
        <option value="Cancel"       {{ $report->status === 'Cancel' ? 'selected' : '' }}>Cancel</option>
    </select>

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 transition">
        Update
    </button>
</form>

</div>


    <!-- Title -->
    <div>
        <h3 class="text-2xl font-semibold text-gray-900">{{ $report->title }}</h3>
        <p class="mt-1 text-sm text-gray-500">
            Submitted on {{ $report->created_at->format('F j, Y g:i A') }}
        </p>
    </div>

    <!-- Uploaded Image -->
    @if ($report->image)
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">📷 Uploaded Image</h4>

            <img src="{{ asset('storage/' . $report->image) }}" 
                 alt="Report Image"
                 class="w-48 h-48 object-cover rounded border shadow">
        </div>
    @endif

    <!-- Uploaded Video -->
    @if ($report->video)
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">🎥 Uploaded Video</h4>

            <video controls class="w-64 rounded-lg border shadow">
                <source src="{{ asset('storage/' . $report->video) }}">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif

    <!-- Description -->
    <div>
        <h4 class="text-lg font-medium text-gray-700 mb-2">📝 Description</h4>
        <p class="text-gray-800 leading-relaxed">{{ $report->description }}</p>
    </div>

    <!-- Type & Subtype -->
    <div>
        <h4 class="text-lg font-medium text-gray-700 mb-2">📌 Report Classification</h4>
        <p><strong>Type:</strong> {{ $report->type }}</p>
        <p><strong>Subtype:</strong> {{ $report->subtype }}</p>
    </div>

    <!-- Location -->
    @if ($report->location)
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">📍 Location</h4>
            <p class="text-gray-800">{{ $report->location }}</p>
        </div>
    @endif

    <!-- Demographics -->
    @if (in_array($report->type, ['Emergencies', 'Accidents']))
        <div>
            <h4 class="text-lg font-medium text-gray-700 mb-2">🧑‍🤝‍🧑 Demographics</h4>

            @if ($report->casualties)
                <p><strong>Number of Casualties:</strong> {{ $report->casualties }}</p>
            @endif

            @if ($report->gender)
                <p><strong>Gender:</strong> {{ $report->gender }}</p>
            @endif
        </div>
    @endif

</div>
