@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
        <i data-lucide="user-cog" class="w-7 h-7 text-blue-600"></i>
        Edit Profile
    </h2>

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ old('name', $user->name) }}" 
                required
            >
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ old('email', $user->email) }}" 
                required
            >
        </div>

        <!-- Password (Optional) -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-gray-400 text-sm">(Leave blank to keep current password)</span></label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                autocomplete="new-password"
            >
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                autocomplete="new-password"
            >
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition"
            >
                💾 Save Changes
            </button>
        </div>
    </form>
</div>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Successfully Updated',
        text: '{{ session("success") }}',
        confirmButtonColor: '#3085d6',
    });
</script>
@endif

<script>
    lucide.createIcons();
</script>

@endsection
