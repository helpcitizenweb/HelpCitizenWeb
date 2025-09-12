@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
        <i data-lucide="settings" class="w-7 h-7 text-blue-600"></i>
        Edit Service
    </h2>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Service Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ old('name', $service->name) }}" 
                required
            >
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea 
                name="description" 
                id="description" 
                rows="5" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"
                required
            >{{ old('description', $service->description) }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition"
            >
                🔄 Update Service
            </button>
        </div>
    </form>
</div>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Successfully Updated',
        text: '{{ session("success") }}',
        confirmButtonColor: '#3085d6',
    });
</script>
@endif

<script>
    lucide.createIcons();
</script>
@endsection
