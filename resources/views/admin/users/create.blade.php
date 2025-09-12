@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-3xl font-bold text-blue-600 mb-8">👤 Create New User</h2>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Enter full name"
                    required
                >
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Enter email address"
                    required
                >
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">User Role</label>
                <select 
                    name="role" 
                    id="role" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                >
                    <option value="" disabled selected>Select a role</option>
                    <option value="admin">Admin</option>
                    <option value="barangay_official">Barangay Official</option>
                    <option value="resident">Resident</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition"
                >
                    ➕ Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
