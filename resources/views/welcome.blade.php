<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpCitizen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white">

    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to HelpCitizen</h1>
            <p class="text-lg mb-8">Empowering your Barangay through smart community engagement.</p>

            @auth
                <p class="mb-4">Hello, {{ Auth::user()->name }}!</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                        Logout
                    </button>
                </form>
            @else
            <p>You are not logged in.</p>
            @endauth
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>

</body>
</html>
