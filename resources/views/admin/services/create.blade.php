@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md mt-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🛠️ Create Service</h1>

    <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Service Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Enter service name" 
                required
            >
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea 
                id="description" 
                name="description" 
                rows="5" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"
                placeholder="Enter service description" 
                required
            ></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition"
            >
                💾 Save Service
            </button>
        </div>
    </form>
</div>
@endsection
