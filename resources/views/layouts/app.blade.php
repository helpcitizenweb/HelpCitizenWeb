<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpCitizen - Community Response System</title>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-poppins bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700 transition">
                HelpCitizen
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Home</a>
                <a href="{{ route('reports.index') }}" class="text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Reports</a>
                <a href="{{ route('resident.announcements') }}" class="text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Announcements</a>
                <a href="{{ route('resident.services') }}" class="text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Services</a>
                <a href="{{ route('resident.about') }}" class="text-base font-semibold text-gray-800 hover:text-indigo-600 transition">About</a>

                @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="inline-flex items-center gap-2 border border-gray-300 text-sm text-gray-700 px-3 py-1 rounded-md bg-white shadow-sm hover:bg-gray-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15.75c2.175 0 4.212.517 6.038 1.426M15 11.25a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Hi, <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                        <a href="{{ route('profile.useredit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            ⚙️ Edit Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 px-5 py-2.5 rounded-full shadow-md transition duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H6.75A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h6.75a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Login
                    </a>
                @endauth

            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-data="{ open: false }" x-show="open" class="md:hidden px-4 pb-4">
            <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-indigo-600">Home</a>
            <a href="{{ route('reports.index') }}" class="block py-2 text-gray-700 hover:text-indigo-600">Reports</a>
            <a href="{{ route('resident.services') }}" class="block py-2 text-gray-700 hover:text-indigo-600">Services</a>
            <a href="{{ route('resident.about') }}" class="block py-2 text-gray-700 hover:text-indigo-600">About</a>

            @auth
                <div class="py-2 text-gray-600">Hi, {{ Auth::user()->name }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left bg-red-500 text-white py-2 px-4 mt-2 rounded-md hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block w-full bg-green-600 text-white py-2 px-4 mt-2 rounded-md text-center hover:bg-green-700 transition">
                    Login
                </a>
            @endauth
        </div>
    </nav>


    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>

</body>
</html>
