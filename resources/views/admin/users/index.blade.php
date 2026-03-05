@php
    use Illuminate\Support\Str;

    function reportMediaUrl($media)
    {
        if (!$media) {
            return null;
        }

        if (Str::startsWith($media, 'http')) {
            return $media;
        }

        return null;
    }
@endphp
@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-screen-lg px-4 py-8 sm:px-8">

        <!-- Header -->
        <div class="flex items-center justify-between pb-6">
            <div>
                <h2 class="font-semibold text-gray-700 text-lg">User Accounts</h2>
                <span class="text-xs text-gray-500">View accounts of registered users</span>
            </div>

            <div>
                <a href="{{ route('admin.users.create') }}"
                    class="flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Create User
                </a>
            </div>
        </div>

        <div class="mb-6 flex flex-wrap items-center gap-3">
            <!--filter-->
            <div class="relative">
                <select id="filterType"
                    class="appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:ring focus:ring-blue-200">
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                    <option value="role">Role</option>
                </select>

                <!-- Better aligned arrow -->
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <input type="text" id="filterInput" placeholder="Search..."
                class="rounded-md border border-gray-300 px-4 py-2 text-sm focus:ring focus:ring-blue-200 w-64">

            <button id="resetFilter"
                class="rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 transition">
                Reset
            </button>

        </div>

        <!-- Table Wrapper -->
        <div class="overflow-hidden rounded-lg border shadow-sm">
            <div class="overflow-x-auto">

                <table class="w-full">

                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-blue-600 text-left text-xs font-semibold uppercase tracking-widest text-white">
                            <th class="px-5 py-3">ID</th>
                            <th class="px-5 py-3">Full Name</th>
                            <th class="px-5 py-3">Gender</th>
                            <th class="px-5 py-3">User Role</th>
                            <th class="px-5 py-3">Created At</th>
                            <th class="px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="text-gray-600 text-sm">

                        @foreach ($users as $user)
                            @php
                                $profilePicture =
                                    reportMediaUrl(optional($user->profile)->profile_picture) ??
                                    'https://ui-avatars.com/api/?name=' . urlencode($user->name);
                            @endphp

                            <tr class="border-b hover:bg-gray-50 transition">

                                <!-- ID -->
                                <td class="px-5 py-4">
                                    {{ $user->id }}
                                </td>

                                <!-- Name + Profile Pic -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-7 w-7 flex-shrink-0 overflow-hidden rounded-full border border-gray-200">
                                            <img src="{{ $profilePicture }}" alt="Profile"
                                                class="h-full w-full object-cover">
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-800">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Gender -->
                                <td class="px-5 py-4">
                                    {{ optional($user->profile)->gender ?? 'N/A' }}
                                </td>

                                <!-- Role -->
                                <td class="px-5 py-4">
                                    {{ ucfirst($user->role) }}
                                </td>

                                <!-- Created -->
                                <td class="px-5 py-4">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 text-center">
                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('admin.reports.viewuser', $user->id) }}"
                                            class="px-3 py-1 text-xs font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 transition">
                                            View
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            class="delete-user-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                class="px-3 py-1 text-xs font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 transition delete-user-btn"
                                                data-name="{{ $user->name }}">
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

            <!-- Pagination Footer -->
            <div class="flex items-center justify-between border-t bg-white px-5 py-4 text-sm text-gray-600">
                <span>
                    Showing {{ $users->firstItem() ?? 0 }}
                    to {{ $users->lastItem() ?? 0 }}
                    of {{ $users->total() ?? count($users) }} entries
                </span>

                <div>
                    {{ $users->links() }}
                </div>
            </div>

        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-user-btn').forEach(button => {

                button.addEventListener('click', function() {

                    const userName = this.getAttribute('data-name');
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Delete user: " + userName + "?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });

                });

            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const filterInput = document.getElementById('filterInput');
            const filterType = document.getElementById('filterType');
            const resetBtn = document.getElementById('resetFilter');
            const rows = document.querySelectorAll('tbody tr');

            function filterRows() {

                const searchValue = filterInput.value.toLowerCase();
                const type = filterType.value;

                rows.forEach(row => {

                    const name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
                    const email = row.querySelector('td:nth-child(2) p.text-xs')?.innerText.toLowerCase();
                    const role = row.querySelector('td:nth-child(4)').innerText.toLowerCase();

                    let match = false;

                    if (type === 'name') {
                        match = name.includes(searchValue);
                    } else if (type === 'email') {
                        match = email?.includes(searchValue);
                    } else if (type === 'role') {
                        match = role.includes(searchValue);
                    }

                    row.style.display = match ? '' : 'none';
                });
            }

            filterInput.addEventListener('keyup', filterRows);
            filterType.addEventListener('change', filterRows);

            // RESET BUTTON
            resetBtn.addEventListener('click', function() {
                filterInput.value = '';
                filterType.value = 'name';

                rows.forEach(row => {
                    row.style.display = '';
                });
            });

        });
    </script>
@endsection
