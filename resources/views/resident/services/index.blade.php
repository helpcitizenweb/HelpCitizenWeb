@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-6">Barangay Services</h2>

    @if($services->isEmpty())
        <p class="text-gray-600">No services available at the moment.</p>
    @else
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($services as $service)
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-blue-700">{{ $service->name }}</h3>
                    <p class="mt-2 text-gray-600">{{ $service->description }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
