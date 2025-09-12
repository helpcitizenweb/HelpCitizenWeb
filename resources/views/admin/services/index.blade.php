@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-semibold mb-6">Manage Services</h2>

    <!-- Add New Service Button -->
    <div class="mb-6 text-right">
        <a href="{{ route('admin.services.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition">
            + Add New
        </a>
    </div>

    <!-- Services Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($services as $service)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $service->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $service->description }}</td>
                    <td class="px-6 py-4 text-center text-sm">
                        <div class="flex items-center justify-center space-x-2">
                            <!-- Yellow Edit Button -->
                            <a href="{{ route('admin.services.edit', $service->id) }}"
                               class="inline-block px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500 transition text-sm font-medium shadow">
                                Edit
                            </a>
                            <!-- Red Delete Button -->
                            <form action="{{ route('admin.services.destroy', $service->id) }}"
                                  method="POST"
                                  class="inline-block delete-service-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition text-sm font-medium shadow delete-service-btn"
                                        data-name="{{ $service->name }}">
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-service-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = button.closest('form');
                const serviceName = button.getAttribute('data-name');

                Swal.fire({
                    title: `Delete "${serviceName}"?`,
                    text: "This action cannot be undone.",
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
