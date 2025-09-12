@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-slate-800 bg-primary text-white py-12 px-4 md:px-8 shadow-lg rounded-2xl mb-12">
        <div x-data="{ openModal: false }" class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-10">
            <div class="md:w-1/2 space-y-6 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-bold">Barangay 41 Community Response System</h1>
                <p class="text-lg">A platform dedicated to addressing community concerns efficiently and transparently. Report issues, track progress, and help improve our barangay.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <!-- Submit a Report -->
                    <a href="{{ route('reports.index') }}" class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition">
                        Submit a Report
                    </a>

                    <!-- Track Report Status -->
                    @auth
                    <a href="{{ route('reports.index') }}" class="bg-white text-gray-700 px-6 py-3 rounded-md border hover:bg-gray-100 transition">
                        Track Report Status
                    </a>
                    @else
                    <button @click="openModal = true" class="bg-white text-gray-700 px-6 py-3 rounded-md border hover:bg-gray-100 transition">
                        Track Report Status
                    </button>
                    @endauth
                </div>
            </div>

            <div class="md:w-1/2">
                <img src="{{ asset('community-paper-art.png') }}" alt="community-paper-cutout" class="rounded-lg shadow-lg w-full max-h-[400px] object-cover">
            </div>

            <!-- Modal -->
            <div x-show="openModal" x-transition class="fixed inset-0 bg-black bg-opacity-50 z-40" @click="openModal = false"></div>

            <div x-show="openModal" x-transition
                 class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-lg w-11/12 max-w-md z-50 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Please Log In</h2>
                <p class="text-gray-600 mb-4">You need to be signed in to track your report.</p>
                <div class="flex justify-end gap-4">
                    <button @click="openModal = false" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Log In
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Report Categories Section -->
    <section class="bg-gray-50 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10">Report Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md text-center space-y-2">
                    <div class="text-3xl text-primary"><i class="fas fa-road"></i></div>
                    <h5 class="text-xl font-semibold">Infrastructure</h5>
                    <p class="text-sm text-gray-600">Report road damages, broken streetlights, and other infrastructure issues.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center space-y-2">
                    <div class="text-3xl text-primary"><i class="fas fa-shield-alt"></i></div>
                    <h5 class="text-xl font-semibold">Security</h5>
                    <p class="text-sm text-gray-600">Report suspicious activities, safety concerns, and security issues.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center space-y-2">
                    <div class="text-3xl text-primary"><i class="fas fa-trash-alt"></i></div>
                    <h5 class="text-xl font-semibold">Sanitation</h5>
                    <p class="text-sm text-gray-600">Report garbage disposal issues, drainage problems, and cleanliness.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center space-y-2">
                    <div class="text-3xl text-primary"><i class="fas fa-medkit"></i></div>
                    <h5 class="text-xl font-semibold">Health</h5>
                    <p class="text-sm text-gray-600">Report health hazards, disease outbreaks, and medical emergencies.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
