<div class="w-72 p-4">
    <div class="bg-gradient-to-br from-white to-gray-100 shadow-xl rounded-xl p-6 border border-gray-200 h-full">
        <h2 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2">
            <i class="fas fa-cogs"></i> Admin Panel
        </h2>
        <hr class="mb-4 border-blue-300">

        <ul class="space-y-2 text-sm font-medium">
            <li>
                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-2 py-2 px-4 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">
                    <i class="fas fa-user-cog text-blue-600"></i> Manage Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports') }}"
                   class="flex items-center gap-2 py-2 px-4 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">
                    <i class="fas fa-file-alt text-green-600"></i> Manage Reports
                </a>
            </li>
            <li>
                <a href="{{ route('admin.announcements.index') }}"
                   class="flex items-center gap-2 py-2 px-4 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">
                    <i class="fas fa-bullhorn text-yellow-500"></i> Announcements
                </a>
            </li>
            <li>
                <a href="{{ route('admin.services.index') }}"
                   class="flex items-center gap-2 py-2 px-4 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">
                    <i class="fas fa-tools text-purple-600"></i> Services
                </a>
            </li>
            
        </ul>
    </div>
</div>
