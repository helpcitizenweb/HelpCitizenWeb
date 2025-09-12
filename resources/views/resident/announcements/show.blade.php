@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <!-- Banner Image or Icon -->
        @if($announcement->image_path)
            <img src="{{ asset('storage/' . $announcement->image_path) }}" 
                 alt="{{ $announcement->title }}" 
                 class="w-full h-60 object-cover">
        @else
            <div class="bg-blue-100 flex items-center justify-center h-60">
                <i data-lucide="megaphone" class="w-16 h-16 text-blue-500"></i>
            </div>
        @endif

        <!-- Announcement Content -->
        <div class="p-6 space-y-4">
            <h1 class="text-2xl font-bold text-gray-800">{{ $announcement->title }}</h1>
            <p class="text-sm text-gray-500">Posted on {{ $announcement->created_at->format('F d, Y') }}</p>
            <div class="text-gray-700 leading-relaxed">
                {!! nl2br(e($announcement->content)) !!}
            </div>
        </div>

        <!-- Back Button -->
        <div class="px-6 pb-6">
            <a href="{{ route('resident.announcements') }}"
               class="inline-block mt-4 px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition">
                ← Back to Announcements
            </a>
        </div>
    </div>
</div>

<!-- Lucide Icons -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>
@endsection
