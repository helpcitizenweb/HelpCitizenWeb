<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - HelpCitizen</title>

    <!-- Segoe UI Font -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>

    <!-- Tailwind & App CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>

<body class="bg-gray-100">

    @include('layouts.navigation')

    <div class="flex min-h-screen space-x-4 px-6 pt-6">
        @include('admin.admin-sidebar')

        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Lucide Icons (if needed) -->
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>

    @stack('scripts')
</body>

</html>
