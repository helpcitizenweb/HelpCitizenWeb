<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminAnnouncementsController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\ResidentServiceController;
use App\Http\Controllers\ResidentAnnouncementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportHistoryController; // we added this
use App\Http\Controllers\ReportProcessController;// we added this
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\FeedbackController; // this is new

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
//we added this 
Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
Route::get('/reports/{report}/full', [ReportController::class, 'fullReport'])->name('reports.full');

Route::post('/reports/{report}/update-status',
    [App\Http\Controllers\ReportController::class, 'updateStatus']
)->name('reports.updateStatus')->middleware('auth');

Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');

// Notification
Route::post('/notifications/mark-all-read', function () {
    if (Auth::check()) {
        Auth::user()->unreadNotifications->markAsRead();
    }
    return back();
})->name('notifications.markAllRead');

// Authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');

    // Shared Profile (Fallback route if needed)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // 📌 Report History & Processing Available to ALL logged-in users
    Route::get('/report-history', [ReportHistoryController::class, 'index'])->name('report.history');

    // ✅ Feedback (Resident Rating)
Route::get(
    '/reports/{report}/feedback',
    [FeedbackController::class, 'create']
)->name('feedback.create');
   // this is where we store the feedback
Route::post(
    '/reports/{report}/feedback',
    [FeedbackController::class, 'store']
)->name('feedback.store');
// Admin submits response to feedback

Route::get(
    '/admin/reports/{report}/feedback',
    [FeedbackController::class, 'feedbackReview']
)->name('admin.reports.feedback');

// Admin responds to resident feedback
Route::post(
    '/admin/feedback/{feedback}/respond',
    [FeedbackController::class, 'adminRespond']
)->name('admin.feedback.respond');


/////////////////////////////////////////////////////////////

      Route::get('/report-process', [ReportProcessController::class, 'index'])
    ->name('report.process');

Route::delete('/report-process/{report}', [ReportProcessController::class, 'destroy'])
    ->name('report.process.destroy');


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
       Route::get('/admin/reports/{report}/viewreport',
    [ResponseController::class, 'showViewReport']
)->name('admin.reports.viewreport');

Route::get('/admin/reports/{report}/response',
    [ResponseController::class, 'createResponseForm']
)->name('admin.reports.response');

Route::post('/admin/reports/{report}/response/save',
    [ResponseController::class, 'storeResponse']
)->name('admin.reports.storeResponse');

Route::put('/admin/reports/{report}/update-status',
    [App\Http\Controllers\ResponseController::class, 'updateStatus'])
    ->name('admin.reports.updateStatus');



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
