<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CalendarController as AdminCalendarController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use Illuminate\Support\Facades\Route;

// Redirect guest root attempts to login page
Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Guest-only: login / register / forgot password
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('/api/check-email-availability', [AuthController::class, 'checkEmailAvailability'])->name('api.check-email');

    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register/verify-otp', [AuthController::class, 'verifyRegistrationOtp'])->name('register.verify');
    Route::post('/register/resend-otp', [AuthController::class, 'resendRegistrationOtp'])->name('register.resend');

    Route::post('/forgot-password', [AuthController::class, 'sendPasswordOtp'])->name('password.email');
    Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyPasswordOtp'])->name('password.verify');
    Route::post('/forgot-password/resend-otp', [AuthController::class, 'resendPasswordOtp'])->name('password.resend');
    Route::post('/forgot-password/reset', [AuthController::class, 'updatePassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated App Pages (Member & Shared Views)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/activities', function () {
        return view('activities');
    })->name('activities');

    Route::get('/activities/{id}', function ($id) {
        return view('activity-details', ['id' => $id]);
    })->name('activities.show');

    Route::get('/activities/{id}/finished', function ($id) {
        return view('activities.finished-show', ['id' => $id]);
    })->name('activities.finished.show');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    Route::get('/certificates', function () {
        return view('certificates');
    })->name('certificates');

    // Member Proposals routes
    Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals');
    Route::post('/proposals', [ProposalController::class, 'store'])->name('proposals.store');

    // Legacy view-detail route (no ID) - kept for backward compatibility.
    Route::get('/proposals/view-details', function () {
        return view('view');
    })->name('view-detail');

    Route::get('/proposals/{proposal}', [ProposalController::class, 'show'])->name('proposals.show');
    Route::put('/proposals/{proposal}', [ProposalController::class, 'update'])->name('proposals.update');
    Route::delete('/proposals/{proposal}', [ProposalController::class, 'destroy'])->name('proposals.destroy');
    Route::post('/proposals/{proposal}/vote', [ProposalController::class, 'vote'])->name('proposals.vote');

    // Shared Announcements routes
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // Member Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Member Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    /*
    |--------------------------------------------------------------------------
    | Admin & Officer Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin Member Management
        Route::get('/members', [MemberController::class, 'index'])->name('members');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
        Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
        Route::patch('/members/{member}/toggle-status', [MemberController::class, 'toggleStatus'])->name('members.toggle-status');
        Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');

        // Admin Calendar
        Route::get('/calendar', [AdminCalendarController::class, 'index'])->name('calendar');

        // Admin Announcements
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

        // Admin Attendance Management
        Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('attendance');
        Route::put('/attendance/{id}', [AdminAttendanceController::class, 'update'])->name('attendance.update');

        // Admin Notification Management
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

        // Admin Certificates Management
        Route::get('/certificates', function () {
            return view('admin.certificates');
        })->name('certificates');

        // Admin Profile & Activity Log Management
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');
    });
});
