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
            <div class="hidden md:flex items-center">
                <a href="{{ route('home') }}" class="p-2 text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Home</a>
                <a href="{{ route('reports.index') }}" class="p-2 text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Reports</a>
                <a href="{{ route('report.history') }}" class="p-2 text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Report Logs</a>

                <a href="{{ route('resident.announcements') }}" class="p-2 text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Announcements</a>
                <a href="{{ route('resident.services') }}" class="p-2 text-base font-semibold text-gray-800 hover:text-indigo-600 transition">Services</a>
                <a href="{{ route('resident.about') }}" class="p-2 text-base font-semibold text-gray-800 hover:text-indigo-600 transition">About</a>

               <!-- Notification Bell -->
                <div x-data="{ open: false }" class="p-2 relative">
                    <button @click="open = !open" class="relative text-gray-600 hover:text-indigo-600 focus:outline-none">
                        <!-- Bell icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 
                                    6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 
                                    6.165 6 8.388 6 11v3.159c0 .538-.214 
                                    1.055-.595 1.436L4 17h5m6 0v1a3 3 
                                    0 11-6 0v-1m6 0H9" />
                        </svg>

                        <!-- Unread count badge -->
                        @php
                            $unreadCount = Auth::check() ? Auth::user()->unreadNotifications()->count() : 0;
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full px-1.5">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 min-w-[20rem] bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-h-80 overflow-y-auto">

                        @if(Auth::check() && Auth::user()->notifications->count())
                            <div class="flex justify-between items-center px-4 py-2">
                                <span class="text-sm font-semibold">Notifications</span>
                            </div>

                            @foreach(Auth::user()->notifications as $notification)
                                <a href="{{ $notification->data['url'] ?? route('reports.index') }}"
                                    class="block px-4 py-2 text-sm border-b hover:bg-gray-50 
                                    {{ $notification->read_at ? 'text-gray-600' : 'font-bold text-gray-800' }}">
                                    {{ $notification->data['message'] ?? 'New Notification' }}
                                </a>
                            @endforeach
                        @else
                            <div class="px-4 py-2 text-sm text-gray-500">No notifications</div>
                        @endif
                    </div>
                </div>

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
            <a href="{{ route('report.history') }}" 
   class="block py-2 text-gray-700 hover:text-indigo-600">
   Report Logs
</a>

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
