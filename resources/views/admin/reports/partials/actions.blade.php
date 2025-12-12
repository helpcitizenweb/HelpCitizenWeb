<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-3">⚙️ Actions Taken</h2>

    @if (!$response)
        <p class="text-gray-600">No response has been submitted yet.</p>
        @return
    @endif

    <p><strong>Dispatch Unit:</strong> {{ $response->dispatch_unit }}</p>
    <p><strong>Contact Person:</strong> {{ $response->contact_person }}</p>
    <p><strong>Overseer:</strong> {{ $response->overseer }}</p>
    <p><strong>Contact Number:</strong> {{ $response->contact_number }}</p>

    <hr class="my-4">

    @if ($response->dispatch_unit === 'Fire')
        @include('admin.reports.partials.response-fire')
    @endif

    @if ($response->dispatch_unit === 'Flood_typhoon')
        @include('admin.reports.partials.response-flood')
    @endif

    @if ($response->dispatch_unit === 'Earthquake')
        @include('admin.reports.partials.response-earthquake')
    @endif

    @if ($response->dispatch_unit === 'Medical')
        @include('admin.reports.partials.response-medical')
    @endif

</div>
