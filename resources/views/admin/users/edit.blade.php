@extends('layouts.admin')

@section('content')
<div class="flex min-h-screen">
    <div class="flex-1 p-8 bg-gray-50">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-xl space-y-8">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold text-blue-600 flex items-center gap-3">
                    <i data-lucide="user-check" class="w-6 h-6 text-blue-600"></i>
                    Edit User
                </h2>
                <a href="{{ route('admin.users') }}"
                   class="inline-flex items-center bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back to Users
                </a>
            </div>

            <!-- Update Form -->
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ $user->name }}" required
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <i data-lucide="user" class="absolute left-3 top-3.5 w-5 h-5 text-gray-400"></i>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ $user->email }}" required
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <i data-lucide="mail" class="absolute left-3 top-3.5 w-5 h-5 text-gray-400"></i>
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <div class="relative">
                        <select name="role" id="role" required
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="admin" @selected($user->role == 'admin')>Admin</option>
                            <option value="barangay_official" @selected($user->role == 'barangay_official')>Barangay Official</option>
                            <option value="resident" @selected($user->role == 'resident')>Resident</option>
                        </select>
                        <i data-lucide="shield" class="absolute left-3 top-3.5 w-5 h-5 text-gray-400"></i>
                    </div>
                </div>

                <!-- Update Button Only -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md transition">
                        <i data-lucide="save" class="w-5 h-5"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
