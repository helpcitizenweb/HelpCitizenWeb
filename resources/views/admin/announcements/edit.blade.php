@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">✏️ Edit Announcement</h2>

    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ old('title', $announcement->title) }}" 
                required
            >
        </div>

        <!-- Content -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
            <textarea 
                name="content" 
                id="content" 
                rows="5" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"
                required
            >{{ old('content', $announcement->content) }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition"
            >
                🔄 Update Announcement
            </button>
        </div>
    </form>
</div>
@if(session('success'))
<script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        confirmButtonColor: '#3085d6',
    });
</script>
@endif

<script>
    lucide.createIcons();
</script>
@endsection
