@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-10">Latest Announcements</h2>

    @if($announcements->isEmpty())
        <p class="text-gray-600 text-center">No announcements available at the moment.</p>
    @else
        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach($announcements as $announcement)
                <a href="{{ route('resident.announcements.show', $announcement->id) }}"
                   class="block bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transform hover:scale-[1.02] transition duration-300">

                    <!-- Subtle Fallback Banner -->
                    @if($announcement->image_path)
                        <img src="{{ asset('storage/' . $announcement->image_path) }}"
                             alt="{{ $announcement->title }}"
                             class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                            <i data-lucide="megaphone" class="w-10 h-10 text-gray-400"></i>
                        </div>
                    @endif

                    <!-- Card Content -->
                    <div class="p-5 space-y-2">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $announcement->title }}</h3>
                        <p class="text-sm text-gray-600">{{ Str::limit($announcement->content, 100) }}</p>
                        <span class="text-xs text-gray-400 block">{{ $announcement->created_at->format('M d, Y') }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $announcements->links() }}
        </div>
    @endif
</div>

<!-- Lucide Icons -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>
@endsection
