<nav x-data="{ open: false }" class="fixed top-0 left-0 w-full z-50 bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-logo class="block h-20 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex items-center space-x-8 sm:ml-10">

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
        class="inline-flex items-center px-1 pt-3 pb-2 border-b-2 text-sm font-medium leading-5
               {{ request()->routeIs('admin.dashboard') ? 'border-indigo-500 text-gray-900'
                                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Dashboard
    </a>

    {{-- Manage Users --}}
    <a href="{{ route('admin.users') }}"
        class="inline-flex items-center px-1 pt-3 pb-2 border-b-2 text-sm font-medium leading-5
               {{ request()->routeIs('admin.users') ? 'border-indigo-500 text-gray-900'
                                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Manage Users
    </a>

    {{-- Manage Reports --}}
    <a href="{{ route('admin.reports') }}"
        class="inline-flex items-center px-1 pt-3 pb-2 border-b-2 text-sm font-medium leading-5
               {{ request()->routeIs('admin.reports') ? 'border-indigo-500 text-gray-900'
                                                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Manage Reports
    </a>

    {{-- Announcements --}}
    <a href="{{ route('admin.announcements.index') }}"
        class="inline-flex items-center px-1 pt-3 pb-2 border-b-2 text-sm font-medium leading-5
               {{ request()->routeIs('admin.announcements.index') ? 'border-indigo-500 text-gray-900'
                                                                   : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Announcements
    </a>

    {{-- Services --}}
    <a href="{{ route('admin.services.index') }}"
        class="inline-flex items-center px-1 pt-3 pb-2 border-b-2 text-sm font-medium leading-5
               {{ request()->routeIs('admin.services.index') ? 'border-indigo-500 text-gray-900'
                                                             : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Services
    </a>

</div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                <!-- Notifications -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="mt-2 text-gray-600 hover:text-indigo-600 focus:outline-none relative">
                        <!-- Bell Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                                6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67
                                6.165 6 8.388 6 11v3.159c0 .538-.214
                                1.055-.595 1.436L4 17h5m6 0v1a3 3
                                0 11-6 0v-1m6 0H9" />
                        </svg>
                        <!-- Badge -->
                        @php
                            $unreadCount = Auth::check() ? Auth::user()->unreadNotifications()->count() : 0;
                        @endphp
                        @if ($unreadCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full px-1.5">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg z-50 w-80 max-h-80 overflow-y-auto">

                        @if (Auth::check() && Auth::user()->notifications->count())
                            <div class="flex justify-between items-center px-4 py-2 border-b">
                                <span class="text-sm font-semibold">Notifications</span>
                            </div>

                            @foreach (Auth::user()->notifications as $notification)
                                @php
                                   $url = $notification->data['url'] ?? '#';
                                @endphp
                                <a href="{{ $url }}"
                                    class="block px-4 py-2 text-sm border-b hover:bg-gray-50 transition 
                                {{ $notification->read_at ? 'text-gray-600' : 'font-bold text-gray-800' }}">
                                    {{ $notification->data['message'] ?? 'New Notification' }}
                                </a>
                            @endforeach
                        @else
                            <div class="px-4 py-2 text-sm text-gray-500">No notifications</div>
                        @endif
                    </div>
                </div>

                <x-dropdown width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = true"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <!-- Mobile Sidebar (Admin) -->
<div x-show="open" class="fixed inset-0 z-50 sm:hidden">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"
         x-transition.opacity
         @click="open = false"></div>

    <!-- Sidebar -->
    <div x-show="open"
         x-transition:enter="transform transition ease-in-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="absolute right-0 top-0 h-full w-72 bg-white shadow-lg p-6 overflow-y-auto">

        <!-- Close Button -->
        <div class="flex justify-between items-center mb-4">
            <span class="font-bold text-lg">Menu</span>
            <button @click="open = false" class="text-gray-500">✖</button>
        </div>

         <!-- NOTIFICATIONS -->
        <div x-data="{ notifOpen: false }">

            <button @click="notifOpen = !notifOpen"
                class="flex justify-between w-full py-2 font-semibold">

                <span>🔔 Notifications</span>
                <span x-text="notifOpen ? '▲' : '▼'"></span>
            </button>

            <div x-show="notifOpen" class="mt-2">

                @php
                    $unreadCount = Auth::check() ? Auth::user()->unreadNotifications()->count() : 0;
                @endphp

                @if(Auth::check() && Auth::user()->notifications->count())
                    @foreach(Auth::user()->notifications as $notification)
                        <a href="{{ $notification->data['url'] ?? '#' }}"
                           @click="open=false"
                           class="block py-2 text-sm border-b
                           {{ $notification->read_at ? 'text-gray-600' : 'font-bold text-gray-800' }}">
                            {{ $notification->data['message'] ?? 'New Notification' }}
                        </a>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500">No notifications</p>
                @endif

            </div>
        </div>

        <hr class="my-4">

        <!-- NAV LINKS -->
        <a @click="open=false" href="{{ route('admin.dashboard') }}" class="block py-2 font-semibold">Dashboard</a>
        <a @click="open=false" href="{{ route('admin.users') }}" class="block py-2 font-semibold">Manage Users</a>
        <a @click="open=false" href="{{ route('admin.reports') }}" class="block py-2 font-semibold">Manage Reports</a>
        <a @click="open=false" href="{{ route('admin.announcements.index') }}" class="block py-2 font-semibold">Announcements</a>
        <a @click="open=false" href="{{ route('admin.services.index') }}" class="block py-2 font-semibold">Services</a>
        <hr class="my-4">
        <!-- PROFILE -->
        <div class="text-gray-600 mb-2">
            {{ Auth::user()->name }}
        </div>

        <a @click="open=false" href="{{ route('profile.edit') }}" class="block py-2">
            Profile
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left py-2 text-red-600">
                Log Out
            </button>
        </form>

    </div>
</div>
</nav>
