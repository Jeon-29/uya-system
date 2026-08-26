<?php

use Illuminate\Support\Facades\Route;

// Default welcome page
Route::get('/', function () {
    return view('welcome');
});

// Mock route to display our new login UI
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Dashboard View Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Activities View Route
Route::get('/activities', function () {
    return view('activities');
})->name('activities');

// Regular activity details (for active / upcoming / ongoing activities)
Route::get('/activities/{id}', function ($id) {
    return view('activity-details', ['id' => $id]);
})->name('activities.show');

// Finished activity details (for completed activities with feedback & documentation)
Route::get('/activities/{id}/finished', function ($id) {
    return view('activities.finished-show', ['id' => $id]);
})->name('activities.finished.show');

Route::view('/calendar', 'calendar')->name('calendar');

// Certificates page route
Route::get('/certificates', function () {
    return view('certificates');
})->name('certificates');

Route::get('/proposals', function () {
    return view('proposals');
})->name('proposals');

// Add this route to your web.php file using your exact view file name: proposals-details

Route::get('/proposals/details', function () {
    return view('proposals-details');
})->name('details');

// Route for handling proposal updates/edits
Route::put('/proposals/update', function () {
    // Handle update logic here
    return back()->with('success', 'Proposal updated successfully!');
});

// Route for view details page using view.blade
Route::get('/proposals/view-details', function () {
    return view('view');
})->name('view-detail');

Route::get('/announcements', function () {
    return view('announcements');
})->name('announcements');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Mock route to handle the form submission (preventing page crash)
Route::post('/login', function () {
    return "Login form submitted! (Backend logic coming later)";
});

// Mock routes for the links on the login page
Route::get('/register', function () {
    return "Register UI will go here!";
})->name('register');

Route::get('/forgot-password', function () {
    return "Forgot Password UI will go here!";
})->name('password.request');
