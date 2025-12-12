@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8 px-4 flex justify-center">
    <div class="w-full max-w-5xl">

        <h2 class="text-3xl font-semibold mb-6 text-center">Manage Users</h2>

        <!-- Create User Button -->
        <div class="mb-6 text-left">
            <a href="{{ route('admin.users.create') }}"
               class="bg-blue-600 text-white py-2 px-6 rounded-md shadow-md hover:bg-blue-700 transition duration-300 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Create User
            </a>
        </div>

        <!-- Users Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full table-auto" style="width: 100%; table-layout: fixed;">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-3 text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-3 text-sm text-gray-500">{{ ucfirst($user->role) }}</td>
                        <td class="px-4 py-2 text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-2">

                                <!-- Edit -->
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="inline-block px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500 transition text-sm font-medium shadow">
                                    Edit
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST"
                                      class="inline-block delete-user-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition text-sm font-medium shadow delete-user-btn"
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

    </div>
</div>

<!-- JS + Toasts stay the same -->
@endsection
