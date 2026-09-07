<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProposalController;
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
        $upcomingActivities = collect([
            (object) [
                'id' => 2,
                'title' => 'Tech Workshop: Web Development',
                'date' => \Carbon\Carbon::parse('2026-09-12'),
                'location' => 'SM Aura Conference',
                'organizer' => (object) ['name' => 'Jihyo'],
                'description' => 'Learn the basics of modern web development with React and TypeScript.',
                'status' => 'open',
                'category' => 'education',
                'capacity' => 20,
                'registered_count' => 14,
            ],
            (object) [
                'id' => 3,
                'title' => 'Leadership Training',
                'date' => \Carbon\Carbon::parse('2026-09-22'),
                'location' => 'Conference Room A',
                'organizer' => (object) ['name' => 'Jihyo'],
                'description' => 'Develop leadership skills through interactive workshops and team activities.',
                'status' => 'open',
                'category' => 'leadership',
                'capacity' => 25,
                'registered_count' => 8,
            ],
        ]);

        $announcements = collect([
            (object) [
                'title' => 'Welcome to UYA Connect 2026!',
                'content' => 'We are excited to announce our new platform for managing activities and connecting with the community.',
                'author' => (object) ['name' => 'Nayeon'],
                'created_at' => \Carbon\Carbon::parse('2026-09-01'),
            ],
            (object) [
                'title' => 'New Activity: Tech Workshop',
                'content' => 'Join us for an exciting web development workshop. Seats are limited!',
                'author' => (object) ['name' => 'Jihyo'],
                'created_at' => \Carbon\Carbon::parse('2026-09-02'),
            ],
        ]);

        return view('dashboard', [
            'stats' => [
                'myActivities' => 2,
                'upcoming' => $upcomingActivities->count(),
                'notifications' => $announcements->count(),
                'attendanceRate' => 85,
            ],
            'announcements' => $announcements,
            'upcomingActivities' => $upcomingActivities,
        ]);
    })->name('dashboard');

    Route::get('/activities', function () {
        // All activities the user can see in the system
        $allActivities = collect([
            (object) [
                'id' => 1,
                'title' => 'Community Service Day',
                'date' => \Carbon\Carbon::parse('2026-09-08'),
                'location' => 'Carmona City Park',
                'organizer' => (object) ['name' => 'Nayeon'],
                'description' => 'Join us for a day of community service cleaning up the local park. Volunteers will work together to beautify the area, plant trees, and raise environmental awareness among residents.',
                'status' => 'closed',
                'category' => 'community',
                'capacity' => 30,
                'registered_count' => 30,
            ],
            (object) [
                'id' => 2,
                'title' => 'Tech Workshop: Web Development',
                'date' => \Carbon\Carbon::parse('2026-09-12'),
                'location' => 'SM Aura Conference',
                'organizer' => (object) ['name' => 'Jihyo'],
                'description' => 'Learn the basics of modern web development with React and TypeScript.',
                'status' => 'ongoing',
                'category' => 'education',
                'capacity' => 20,
                'registered_count' => 18,
            ],
            (object) [
                'id' => 3,
                'title' => 'Leadership Training',
                'date' => \Carbon\Carbon::parse('2026-09-22'),
                'location' => 'Conference Room A',
                'organizer' => (object) ['name' => 'Jihyo'],
                'description' => 'Develop leadership skills through interactive workshops and team activities.',
                'status' => 'registered',
                'category' => 'leadership',
                'capacity' => 25,
                'registered_count' => 9,
            ],
            (object) [
                'id' => 4,
                'title' => 'Annual Sports Festival',
                'date' => \Carbon\Carbon::parse('2026-10-05'),
                'location' => 'CvSU Main Campus',
                'organizer' => (object) ['name' => 'Jeongyeon'],
                'description' => 'Annual sports competition featuring various team sports and activities.',
                'status' => 'open',
                'category' => 'sports',
                'capacity' => 50,
                'registered_count' => 12,
            ],
            (object) [
                'id' => 5,
                'title' => 'Environmental Campaign',
                'date' => \Carbon\Carbon::parse('2026-09-29'),
                'location' => 'CvSU Carmona',
                'organizer' => (object) ['name' => 'Nayeon'],
                'description' => 'Raise awareness about environmental issues in our community.',
                'status' => 'open',
                'category' => 'environment',
                'capacity' => 30,
                'registered_count' => 6,
            ],
            (object) [
                'id' => 6,
                'title' => 'Cultural Night',
                'date' => \Carbon\Carbon::parse('2026-08-18'),
                'location' => 'CvSU Role Hall',
                'organizer' => (object) ['name' => 'Nayeon'],
                'description' => 'Celebrate diversity with cultural performances and international cuisine.',
                'status' => 'finished',
                'category' => 'community',
                'capacity' => 40,
                'registered_count' => 38,
            ],
        ]);

        // IDs the current user has registered for
        // (when backend is wired, this becomes: $user->registeredActivityIds())
        $userRegisteredIds = [2, 3];

        // Partition into the three tabs
        $openActivities = $allActivities->filter(function ($a) use ($userRegisteredIds) {
            return in_array($a->status, ['open', 'closed'], true)
                && !in_array($a->id, $userRegisteredIds, true);
        })->values();

        $myActivities = $allActivities->filter(function ($a) use ($userRegisteredIds) {
            return in_array($a->id, $userRegisteredIds, true);
        })->values();

        $finishedActivities = $allActivities->filter(function ($a) {
            return $a->status === 'finished' && !in_array($a->id, [1, 2, 3], true);
        })->values();

        return view('activities', [
            'openActivities' => $openActivities,
            'myActivities' => $myActivities,
            'finishedActivities' => $finishedActivities,
        ]);
    })->name('activities');

    Route::get('/activities/{id}', function ($id) {
        $activity = (object) [
            'id' => 1,
            'title' => 'Community Service Day',
            'date' => \Carbon\Carbon::parse('2026-09-08'),
            'location' => 'Carmona City Park',
            'organizer' => (object) ['name' => 'Nayeon'],
            'description' => 'Join us for a day of community service cleaning up the local park. Volunteers will work together to beautify the area, plant trees, and raise environmental awareness among residents.',
            'status' => 'closed',
            'category' => 'community',
            'capacity' => 30,
            'registered_count' => 22,
            'duration' => '8:00 AM - 12:00 PM',
            'feedback_count' => 3,
            'photo_count' => 5,
        ];
        $feedbacks = collect([
            (object) [
                'author' => (object) ['name' => 'Mina'],
                'type' => 'General Experience',
                'comment' => 'Wonderful event! I enjoyed meeting new people and contributing to our community park.',
                'created_at' => \Carbon\Carbon::parse('2026-09-09'),
            ],
            (object) [
                'author' => (object) ['name' => 'Chaeyoung'],
                'type' => 'Suggestion for Improvement',
                'comment' => 'Loved it! More water stations next time would be great, especially during summer.',
                'created_at' => \Carbon\Carbon::parse('2026-09-10'),
            ],
            (object) [
                'author' => (object) ['name' => 'Dahyun'],
                'type' => 'Praise / Appreciation',
                'comment' => 'Amazing coordination by the organizers. Looking forward to the next one!',
                'created_at' => \Carbon\Carbon::parse('2026-09-11'),
            ],
        ]);
        return view('activity-details', [
            'activity' => $activity,
            'feedbacks' => $feedbacks,
            'id' => $id,
        ]);
    })->name('activities.show');

    Route::get('/activities/{id}/finished', function ($id) {
        $activity = (object) [
            'id' => 5,
            'title' => 'Annual Sports Festival',
            'date' => \Carbon\Carbon::parse('2026-08-15'),
            'location' => 'CvSU Main Campus',
            'organizer' => (object) ['name' => 'Jeongyeon'],
            'description' => 'Annual sports competition featuring various team sports and activities.',
            'status' => 'finished',
            'category' => 'sports',
            'capacity' => 50,
            'registered_count' => 42,
            'attendance_present' => 38,
        ];
        return view('activities.finished-show', ['activity' => $activity, 'id' => $id]);
    })->name('activities.finished.show');

    Route::get('/calendar', function () {
        $allActivities = collect([
            (object) [
                'id' => 1,
                'title' => 'Community Service Day',
                'date' => \Carbon\Carbon::parse('2026-09-08'),
                'location' => 'Carmona City Park',
                'organizer' => (object) ['name' => 'Nayeon'],
                'description' => 'Join us for a day of community service cleaning up the local park.',
                'status' => 'closed',
                'category' => 'community',
            ],
            (object) [
                'id' => 2,
                'title' => 'Tech Workshop: Web Development',
                'date' => \Carbon\Carbon::parse('2026-09-12'),
                'location' => 'SM Aura Conference',
                'organizer' => (object) ['name' => 'Jihyo'],
                'description' => 'Learn the basics of modern web development with React and TypeScript.',
                'status' => 'open',
                'category' => 'education',
            ],
            (object) [
                'id' => 3,
                'title' => 'Leadership Training',
                'date' => \Carbon\Carbon::parse('2026-09-22'),
                'location' => 'Conference Room A',
                'organizer' => (object) ['name' => 'Jihyo'],
                'description' => 'Develop leadership skills through interactive workshops.',
                'status' => 'open',
                'category' => 'leadership',
            ],
            (object) [
                'id' => 4,
                'title' => 'Annual Sports Festival',
                'date' => \Carbon\Carbon::parse('2026-10-05'),
                'location' => 'CvSU Main Campus',
                'organizer' => (object) ['name' => 'Jeongyeon'],
                'description' => 'Annual sports competition featuring various team sports.',
                'status' => 'open',
                'category' => 'sports',
            ],
            (object) [
                'id' => 5,
                'title' => 'Environmental Campaign',
                'date' => \Carbon\Carbon::parse('2026-09-29'),
                'location' => 'CvSU Carmona',
                'organizer' => (object) ['name' => 'Nayeon'],
                'description' => 'Raise awareness about environmental issues in our community.',
                'status' => 'open',
                'category' => 'environment',
            ],
        ]);

        return view('calendar', ['activities' => $allActivities]);
    })->name('calendar');

    Route::get('/certificates', function () {
        return view('certificates');
    })->name('certificates');

    Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals');

    // Proposal actions (form submissions).
    // Currently no Proposal model exists; controllers accept input, validate, and flash success.
    Route::post('/proposals', [ProposalController::class, 'store'])->name('proposals.store');
    Route::post('/proposals/{id}/vote', [ProposalController::class, 'vote'])->name('proposals.vote');
    Route::put('/proposals/{id}', [ProposalController::class, 'update'])->name('proposals.update');
    Route::post('/proposals/draft', [ProposalController::class, 'draft'])->name('proposals.draft');

    Route::get('/proposals/details', function () {
        return view('proposals-details');
    })->name('details');

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
