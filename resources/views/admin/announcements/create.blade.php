@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📢 Create Announcement</h1>

    <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Enter announcement title" 
                required
            >
        </div>

        <!-- Description -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea 
                id="content" 
                name="content" 
                rows="5" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"
                placeholder="Enter announcement description" 
                required
            ></textarea>
        </div>

        <!-- Date -->
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input 
                type="date" 
                id="date" 
                name="date" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                required
            >
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition"
            >
                💾 Save Announcement
            </button>
        </div>
    </form>
</div>
@endsection

