@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl sm:text-2xl font-semibold mb-6">Announcements</h2>

    <!-- Add New Announcement Button -->
    <div class="mb-6 text-right">
        <a href="{{ route('admin.announcements.create') }}"
           class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mb-4 sm:mb-0">
            + Add New
        </a>
    </div>

    <!-- Announcements Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($announcements as $announcement)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $announcement->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 truncate">{{ Str::limit($announcement->content, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $announcement->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm rounded-md hover:bg-yellow-600 transition shadow">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}"
                                      method="POST"
                                      class="inline-block delete-announcement-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition shadow delete-announcement-btn"
                                            data-title="{{ $announcement->title }}">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-announcement-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                const title = this.getAttribute('data-title');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Delete the announcement: "${title}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<!-- Success Toast -->
@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
</script>
@endif



@endsection
