<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityQrController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CalendarController as AdminCalendarController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\ProposalController as AdminProposalController;
use App\Http\Controllers\Admin\CertificateTemplateController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

// Redirect guest root attempts to login page
Route::redirect('/', '/login');

// Public Privacy Policy Route
Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');

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

    // Member Dynamic Activity Routes
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities');
    Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');
    Route::post('/activities/{activity}/join', [ActivityController::class, 'join'])->name('activities.join');
    Route::post('/activities/{activity}/cancel', [ActivityController::class, 'cancel'])->name('activities.cancel');
    Route::post('/activities/{activity}/feedback', [ActivityController::class, 'storeFeedback'])->name('activities.feedback.store');
    Route::post('/activities/process-qr-scan', [ActivityQrController::class, 'processScan'])->name('activities.process-qr');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // Member Certificate Routes
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
    Route::patch('/certificates/{certificate}/archive', [CertificateController::class, 'archive'])->name('certificates.archive');
    Route::patch('/certificates/{id}/restore', [CertificateController::class, 'restore'])->name('certificates.restore');
    Route::delete('/certificates/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');

    // Member Proposals routes
    Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals');
    Route::post('/proposals', [ProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals/{id}', [ProposalController::class, 'show'])->name('proposals.show');
    Route::put('/proposals/{proposal}', [ProposalController::class, 'update'])->name('proposals.update');
    Route::patch('/proposals/{proposal}/archive', [ProposalController::class, 'archive'])->name('proposals.archive');
    Route::patch('/proposals/{proposal}/restore', [ProposalController::class, 'restore'])->name('proposals.restore');
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
    Route::put('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

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
        Route::get('/members/check-email', [MemberController::class, 'checkEmail'])->name('members.check-email');
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

        // Admin Profile Management
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');

        // Admin Activity Management
        Route::get('/activities', [AdminActivityController::class, 'index'])->name('activities.index');
        Route::post('/activities', [AdminActivityController::class, 'store'])->name('activities.store');
        Route::get('/activities/{id}', [AdminActivityController::class, 'show'])->name('activities.show');
        Route::put('/activities/{activity}', [AdminActivityController::class, 'update'])->name('activities.update');
        Route::patch('/activities/{activity}/complete', [AdminActivityController::class, 'complete'])->name('activities.complete');
        Route::patch('/activities/{activity}/toggle-registration', [AdminActivityController::class, 'toggleRegistration'])->name('activities.toggle-registration');
        Route::patch('/activities/{activity}/toggle-attendance', [AdminActivityController::class, 'toggleAttendance'])->name('activities.toggle-attendance');

        // Soft delete, Restore & Force delete
        Route::delete('/activities/{id}', [AdminActivityController::class, 'destroy'])->name('activities.destroy');
        Route::patch('/activities/{id}/restore', [AdminActivityController::class, 'restore'])->name('activities.restore');
        Route::delete('/activities/{id}/force-delete', [AdminActivityController::class, 'forceDelete'])->name('activities.force-delete');

        // Photo upload & photo deletion for documentation
        Route::post('/activities/{activity}/photos', [AdminActivityController::class, 'uploadPhotos'])->name('activities.photos.store');
        Route::delete('/activities/photos/{photoId}', [AdminActivityController::class, 'deletePhoto'])->name('activities.photos.destroy');

        Route::get('/activities/{activity}/qr-payload', [ActivityQrController::class, 'generatePayload'])->name('activities.qr-payload');

        // Admin Certificate Template Management
        Route::resource('certificates/templates', CertificateTemplateController::class, [
            'names' => [
                'index'   => 'certificates.templates.index',
                'create'  => 'certificates.templates.create',
                'store'   => 'certificates.templates.store',
                'edit'    => 'certificates.templates.edit',
                'update'  => 'certificates.templates.update',
                'destroy' => 'certificates.templates.destroy',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin-Only Protected Routes (Restricted from Officers)
        |--------------------------------------------------------------------------
        */
        Route::middleware(EnsureUserIsAdmin::class)->group(function () {
            // Admin Proposal Management
            Route::get('/proposals', [AdminProposalController::class, 'index'])->name('proposals.index');
            Route::get('/proposals/{id}', [AdminProposalController::class, 'show'])->name('proposals.show');
            Route::post('/proposals/schedule', [AdminProposalController::class, 'updateSchedule'])->name('proposals.updateSchedule');
            Route::patch('/proposals/{proposal}/toggle-document', [AdminProposalController::class, 'toggleDocumentValidation'])->name('proposals.toggleDocument');
            Route::post('/proposals/{proposal}/request-revision', [AdminProposalController::class, 'requestRevision'])->name('proposals.requestRevision');
            Route::patch('/proposals/{proposal}/approve-voting', [AdminProposalController::class, 'approveForVoting'])->name('proposals.approveVoting');
            Route::patch('/proposals/{proposal}/reject', [AdminProposalController::class, 'reject'])->name('proposals.reject');
            Route::patch('/proposals/{proposal}/archive', [AdminProposalController::class, 'archive'])->name('proposals.archive');
            Route::patch('/proposals/{proposal}/restore', [AdminProposalController::class, 'restore'])->name('proposals.restore');
            Route::post('/proposals/{proposal}/convert', [AdminProposalController::class, 'convertToActivity'])->name('proposals.convert');
            Route::delete('/proposals/{proposal}', [AdminProposalController::class, 'destroy'])->name('proposals.destroy');

            // Reports
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
        });
    });
});
