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
                    <a href="{{ route('report.process') }}" class="bg-white text-gray-700 px-6 py-3 rounded-md border hover:bg-gray-100 transition">
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

    <!-- Directory Section -->
    <section class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10">Emergency Directory</h2>

            <div class="space-y-6">
                @php
                    $directory = [
                        '1. Local Police Station' => "Moriones Tondo Police Station<br>
                            Contact Numbers: (+632) 245-4551, (+632) 772-5973, (+63917) 847-5757, (02) 722-0650, (02) 8722-0650<br>
                            Emergency: 911 or (02) 925-9111",

                        '2. Fire Department' => "Landline: (8245-3403), Mobile: 0946-727-0166<br>
                            Special Rescue Force: (8523-2850), Mobile: 0920-527-3346<br>
                            COMMEL MANILA: (5336-5138 / 5336-5139), Mobile: 0969-398-9700",

                        '3. Ambulance / Health Center' => "Philippine Red Cross: Dial 143<br><br>
                            <b>Hospitals Near Tondo:</b><br>
                            - Tondo Medical Center: (02) 8865 9000, dpo-foi@tmrc.doh.gov.ph<br>
                            - Metropolitan Medical Center: (02) 8863 2500<br>
                            - Mary Johnston Hospital: (02) 5318 6600 / (02) 8245 4024<br><br>
                            <b>Health Centers:</b><br>
                            - Tondo Foreshore Health Center: (22545760)<br>
                            - Fugoso Health Center: 0928-673-1715, bofugosohealthcenter@gmail.com",

                        '4. City / Municipal DRRMC Hotline' => "Dial 911 or (02) 8568-6909<br>
                            Manila DRRM Office: 0950-700-3710 / 0932-662-2322, officialmaniladrrmo@gmail.com<br>
                            MMDA: Dial 136 (Traffic)<br>
                            NDRRMC: (02) 8911-5061 to 65 local 100, (02) 8911-1406, (02) 8912-2665",

                        '5. DSWD / CSWD' => '<a href="http://dswd.gov.ph" target="_blank" class="text-blue-600 underline">http://dswd.gov.ph</a>',

                        '6. Barangay Officials' => "Chairman: Erwin Lapaz<br>
                            Kagawad: Richard Flores, Edilberto De Jesus, Shiela Halili, Jomar Bonifacio, Francisco Vibar Jr., Daryl Garcia, Aselmo Pablo<br>
                            Secretary: Rosemary Lupango<br>
                            Treasurer: Arjhun Padasas<br>
                            EX-O: Ronald Peres<br>
                            Tanod: Arnold Lapaz, Joey Baldisimo, Benegno Baldisimo, Dennise Cunanan, Darwin Cunanan, Debbie De Jesus, Nelson Salvatiera, Rony Pollarcio, Caesar Isip, Armicko Diego, Manny Santos, Arman Cacho, Rodolfo Catapang, Roberto Geronemo, Lorenzo Meneses, Ammy Peres, Jasmyn Maryn, Arlyn Quirante<br>
                            SK Chairman: Joshua Tolentino",

                        '7. Barangay Hall Contact' => "Email: barangay41zone3@gmail.com",

                        '8. Utilities' => "Water: Maynilad Water Services, Inc — Dial 1626<br>
                            Electricity: Meralco — (0920-9716211 / 0917-5516211) or Hotline: (02) 16211",
                    ];
                @endphp

                @foreach($directory as $title => $content)
                    <div x-data="{ open: false }" class="border rounded-lg shadow-md">
                        <!-- Header -->
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-t-lg">
                            <span class="font-semibold text-lg">{{ $title }}</span>
                            <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        </button>

                        <!-- Content -->
                        <div x-show="open" x-collapse class="px-4 py-3 text-gray-700">
                            {!! $content !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
