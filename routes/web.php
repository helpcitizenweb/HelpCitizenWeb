<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminAnnouncementsController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\ResidentServiceController;
use App\Http\Controllers\ResidentAnnouncementController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('home'); 
})->name('home');

// Public routes
Route::get('/services', [ResidentServiceController::class, 'index'])->name('resident.services');
Route::get('/about', function () {
    return view('resident.about');
})->name('resident.about');
Route::get('/resident/announcements', [ResidentAnnouncementController::class, 'index'])->name('resident.announcements');
Route::get('/resident/announcements/{id}', [ResidentAnnouncementController::class, 'show'])->name('resident.announcements.show');

// Reports (public submission)
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// Authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');

    // Shared Profile (Fallback route if needed)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 🔒 Admin Profile
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

        Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Users
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

        // Reports
        Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports');
        Route::get('/admin/reports/{report}', [AdminReportController::class, 'show'])->name('admin.reports.show');
        Route::put('/admin/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('admin.reports.updateStatus');
        Route::put('/admin/reports/{report}/resolution', [AdminReportController::class, 'updateResolution'])->name('admin.reports.updateResolution');

        // Announcements
        Route::get('/admin/announcements', [AdminAnnouncementsController::class, 'index'])->name('admin.announcements.index');
        Route::get('/admin/announcements/create', [AdminAnnouncementsController::class, 'create'])->name('admin.announcements.create');
        Route::post('/admin/announcements', [AdminAnnouncementsController::class, 'store'])->name('admin.announcements.store');
        Route::get('/admin/announcements/{announcement}/edit', [AdminAnnouncementsController::class, 'edit'])->name('admin.announcements.edit');
        Route::put('/admin/announcements/{announcement}', [AdminAnnouncementsController::class, 'update'])->name('admin.announcements.update');
        Route::delete('/admin/announcements/{announcement}', [AdminAnnouncementsController::class, 'destroy'])->name('admin.announcements.destroy');

        // Services
        Route::get('/admin/services', [AdminServiceController::class, 'index'])->name('admin.services.index');
        Route::get('/admin/services/create', [AdminServiceController::class, 'create'])->name('admin.services.create');
        Route::post('/admin/services/store', [AdminServiceController::class, 'store'])->name('admin.services.store');
        Route::get('/admin/services/{service}/edit', [AdminServiceController::class, 'edit'])->name('admin.services.edit');
        Route::put('/admin/services/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/admin/services/{service}', [AdminServiceController::class, 'destroy'])->name('admin.services.destroy');
    });

    // 🔒 Barangay Officials
    Route::middleware(['role:barangay_official'])->group(function () {
        Route::get('/officials-dashboard', function () {
            return view('officials.dashboard');
        })->name('officials.dashboard');
    });

    // 🔒 Resident Profile
    Route::middleware(['role:resident'])->group(function () {
        Route::get('/resident/profile/edit', [ProfileController::class, 'residentEdit'])->name('profile.useredit');
        Route::patch('/resident/profile/update', [ProfileController::class, 'residentUpdate'])->name('profile.userupdate');
    });
});

// Role testing (optional)
Route::get('/test-role', function () {
    return 'Access Granted!';
})->middleware(['auth', 'role:admin']);

require __DIR__.'/auth.php';
