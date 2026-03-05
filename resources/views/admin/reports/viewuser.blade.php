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
<div class="max-w-md mx-auto mt-16">

    <div class="bg-white p-6 rounded-2xl shadow-md border text-center">

        {{-- Profile Picture --}}
       @php
    $profilePicture = reportMediaUrl(optional($user->profile)->profile_picture)
        ?? 'https://loremflickr.com/320/320/person';
@endphp

        <div class="flex justify-center">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-200 shadow">
                <img
                    src="{{ $profilePicture }}"
                    alt="Profile Picture"
                    class="w-full h-full object-cover"
                >
            </div>
        </div>

        {{-- Name --}}
        <h2 class="mt-4 text-lg font-semibold text-gray-800">
            {{ $user->name }}
        </h2>

        {{-- Gender --}}
        <p class="text-sm text-gray-500">
            {{ optional($user->profile)->gender ?? 'Resident' }}
        </p>


        {{-- Extra Info --}}
        <div class="mt-4 text-sm text-gray-600 space-y-1">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Mobile:</strong> {{ optional($user->profile)->mobile_number ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ optional($user->profile)->address ?? 'N/A' }}</p>
            <p>
                <strong>Date of Birth:</strong>
                {{ optional($user->profile)->date_of_birth 
                    ? \Carbon\Carbon::parse($user->profile->date_of_birth)->format('F d, Y')
                    : 'N/A' }}
            </p>
        </div>

       {{-- Bio --}}
<div class="mt-4 text-center">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Bio
    </label>

    <div class="border rounded-lg p-3 bg-gray-50 text-sm text-gray-700 
                max-h-32 overflow-y-auto text-center">
        {{ optional($user->profile)->bio ?? 'No bio provided.' }}
    </div>
</div>

        {{-- Back Button --}}
        <div class="mt-6">
            <a href="{{ url()->previous() }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Back
            </a>
        </div>

    </div>

</div>
@endsection