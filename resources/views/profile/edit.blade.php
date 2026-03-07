<style>
    .readonly-field {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }
</style>
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
    <div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-md">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="user-cog" class="w-7 h-7 text-blue-600"></i>
                Profile
            </h2>

            <button type="button" id="editToggleBtn"
                class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm shadow transition">
                ✏️ Edit
            </button>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Profile Picture Preview -->
            @php
                $photoUrl = reportMediaUrl(optional($user->profile)->profile_picture);
            @endphp

            @if ($photoUrl)
                <div class="flex justify-center">
                    <img src="{{ $photoUrl }}" class="w-32 h-32 rounded-full object-cover shadow-md">
                </div>
            @endif

            <!-- Profile Picture Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Profile Picture <span class="text-gray-400 text-sm">(Optional)</span>
                </label>
                <input type="file" name="profile_picture" class="form-control w-full">
            </div>

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    New Password <span class="text-gray-400 text-sm">(Leave blank to keep current password)</span>
                </label>

                <div class="relative">
                    <input id="password" type="password" name="password" autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-10 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <button type="button" onclick="togglePassword('password', 'eye-open-password', 'eye-closed-password')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                        <svg id="eye-open-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                           c4.478 0 8.268 2.943 9.542 7
                           -1.274 4.057-5.064 7-9.542 7
                           -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg id="eye-closed-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm New Password
                </label>

                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-10 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <button type="button"
                        onclick="togglePassword('password_confirmation', 'eye-open-confirm', 'eye-closed-confirm')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                        <svg id="eye-open-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                           c4.478 0 8.268 2.943 9.542 7
                           -1.274 4.057-5.064 7-9.542 7
                           -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg id="eye-closed-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Gender -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Gender <span class="text-gray-400 text-sm">(Optional)</span>
                </label>
                <select name="gender"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Select gender</option>
                    <option value="Male"
                        {{ old('gender', optional($user->profile)->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female"
                        {{ old('gender', optional($user->profile)->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other"
                        {{ old('gender', optional($user->profile)->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Date of Birth -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Date of Birth <span class="text-gray-400 text-sm">(Optional)</span>
                </label>
                <input type="date" name="date_of_birth"
                    value="{{ old('date_of_birth', optional($user->profile)->date_of_birth ? \Carbon\Carbon::parse($user->profile->date_of_birth)->format('Y-m-d') : '') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Mobile -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Mobile Number <span class="text-gray-400 text-sm">(Optional)</span>
                </label>
                <input type="text" name="mobile_number"
                    value="{{ old('mobile_number', optional($user->profile)->mobile_number) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Address <span class="text-gray-400 text-sm">(Optional)</span>
                </label>
                <input type="text" name="address" value="{{ old('address', optional($user->profile)->address) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Bio -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Bio <span class="text-gray-400 text-sm">(Optional)</span>
                </label>
                <textarea name="bio" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('bio', optional($user->profile)->bio) }}</textarea>
            </div>

            <!-- Save + Cancel -->
            <div class="flex justify-end gap-3 hidden" id="saveButtonWrapper">
                <button type="button" id="cancelEditBtn"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium px-6 py-3 rounded-lg shadow transition">
                    Cancel
                </button>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg shadow transition">
                    💾 Save Changes
                </button>
            </div>

        </form>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Successfully Updated',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const editBtn = document.getElementById('editToggleBtn');
            const cancelBtn = document.getElementById('cancelEditBtn');
            const saveWrapper = document.getElementById('saveButtonWrapper');

            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, textarea');
            const selects = form.querySelectorAll('select');

            function enableEditMode() {
                inputs.forEach(input => {
                    if (input.type !== 'hidden' && input.type !== 'submit' && input.type !== 'button') {
                        input.removeAttribute('readonly');
                        input.classList.remove('readonly-field');
                    }
                });

                selects.forEach(select => {
                    select.removeAttribute('disabled');
                    select.classList.remove('readonly-field');
                });

                saveWrapper.classList.remove('hidden');
                editBtn.classList.add('hidden');
            }

            function disableEditMode() {
                inputs.forEach(input => {
                    if (input.type !== 'hidden' && input.type !== 'submit' && input.type !== 'button') {
                        input.setAttribute('readonly', true);
                        input.classList.add('readonly-field');
                    }
                });

                selects.forEach(select => {
                    select.setAttribute('disabled', true);
                    select.classList.add('readonly-field');
                });

                saveWrapper.classList.add('hidden');
                editBtn.classList.remove('hidden');
            }

            // Start in view mode
            disableEditMode();

            editBtn.addEventListener('click', enableEditMode);
            cancelBtn.addEventListener('click', disableEditMode);

        });
    </script>
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
