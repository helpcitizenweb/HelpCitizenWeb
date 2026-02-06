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

            <!-- Password -->
<div>
    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
        Password
    </label>

    <div class="relative">
        <input
            type="password"
            name="password"
            id="password"
            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-10 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
            placeholder="Enter password"
            required
        >

        <button
            type="button"
            onclick="togglePassword('password', 'eye-open-password', 'eye-closed-password')"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500"
        >
            <!-- Eye -->
            <svg id="eye-open-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.478 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.064 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z"/>
            </svg>

            <!-- Eye Slash -->
            <svg id="eye-closed-password" xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 hidden" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3l18 18"/>
            </svg>
        </button>
    </div>
</div>
<!-- Confirm Password -->
<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
        Confirm Password
    </label>

    <div class="relative">
        <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-10 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
            placeholder="Re-enter password"
            required
        >

        <button
            type="button"
            onclick="togglePassword('password_confirmation', 'eye-open-confirm', 'eye-closed-confirm')"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500"
        >
            <!-- Eye -->
            <svg id="eye-open-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.478 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.064 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z"/>
            </svg>

            <!-- Eye Slash -->
            <svg id="eye-closed-confirm" xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 hidden" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3l18 18"/>
            </svg>
        </button>
    </div>
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

            <!-- Submit Button f-->
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
<script>
function togglePassword(inputId, eyeOpenId, eyeClosedId) {
    const input = document.getElementById(inputId);
    const eyeOpen = document.getElementById(eyeOpenId);
    const eyeClosed = document.getElementById(eyeClosedId);

    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
}
</script>

@endsection
