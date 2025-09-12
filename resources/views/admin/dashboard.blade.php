@extends('layouts.admin')  

@section('content')
    <div class="container mx-auto mt-10 px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Main Dashboard Content -->
            <div class="col-span-3">
                <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-100">
                    <h3 class="text-3xl font-bold mb-4 text-primary">Welcome, Admin</h3>
                    <p class="text-gray-600 mb-6 text-lg">Oversee reports, users, announcements, and community updates.</p>

                    <!-- Stats Section -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-md transform hover:scale-[1.02] transition duration-300">
                            <div class="flex items-center">
                                <i class="fas fa-users text-3xl mr-4"></i>
                                <div>
                                    <h4 class="text-lg font-semibold">Users</h4>
                                    <p class="text-2xl">{{ $userCount }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-lg shadow-md transform hover:scale-[1.02] transition duration-300">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-3xl mr-4"></i>
                                <div>
                                    <h4 class="text-lg font-semibold">Reports</h4>
                                    <p class="text-2xl">{{ $reportCount }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 text-white p-6 rounded-lg shadow-md transform hover:scale-[1.02] transition duration-300">
                            <div class="flex items-center">
                                <i class="fas fa-bullhorn text-3xl mr-4"></i>
                                <div>
                                    <h4 class="text-lg font-semibold">Announcements</h4>
                                    <p class="text-2xl">{{ $announcementCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats Section -->
                    <div class="mt-10 bg-gray-50 p-6 rounded-lg shadow-sm border">
                        <h4 class="text-2xl font-semibold mb-5 text-gray-700">Quick Stats</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-white p-4 rounded-lg shadow border text-center">
                                <h5 class="font-semibold text-gray-700 mb-2">Total Active Users</h5>
                                <p class="text-2xl font-bold text-blue-600">{{ $activeUsers }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow border text-center">
                                <h5 class="font-semibold text-gray-700 mb-2">Pending Reports</h5>
                                <p class="text-2xl font-bold text-green-600">{{ $pendingReports }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow border text-center">
                                <h5 class="font-semibold text-gray-700 mb-2">Upcoming Announcements</h5>
                                <p class="text-2xl font-bold text-yellow-600">{{ $upcomingAnnouncements }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
