<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// authenticated users on to the dashboard via the 'guest' middleware.
Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Guest-only: login / register / forgot password
|--------------------------------------------------------------------------
| All three flows live on one page (auth.login) and are toggled client
| side, so they share a single GET route. Redirect signed-in users
| straight to the dashboard. para mas madali potaena kapagod type ng route uyy
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

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
| Authenticated app pages
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/activities', function () {
        return view('activities');
    })->name('activities');

    Route::get('/activities/{id}', function ($id) {
        return view('activity-details', ['id' => $id]);
    })->name('activities.show');

    Route::get('/activities/{id}/finished', function ($id) {
        return view('activities.finished-show', ['id' => $id]);
    })->name('activities.finished.show');

    Route::view('/calendar', 'calendar')->name('calendar');

    Route::get('/certificates', function () {
        return view('certificates');
    })->name('certificates');

    Route::get('/proposals', function () {
        return view('proposals');
    })->name('proposals');

    Route::get('/proposals/details', function () {
        return view('proposals-details');
    })->name('details');

    Route::put('/proposals/update', function () {
        return back()->with('success', 'Proposal updated successfully!');
    });

    Route::get('/proposals/view-details', function () {
        return view('view');
    })->name('view-detail');

    Route::get('/announcements', function () {
        return view('announcements');
    })->name('announcements');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});
