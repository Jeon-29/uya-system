<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Staff accounts belong on the admin dashboard, not the member one
        if (in_array($user->role, ['admin', 'officer'], true)) {
            return redirect()->route('admin.dashboard');
        }

        // My Activities: count of activities the user has joined (excluding cancelled)
        $myActivitiesCount = $user->activities()
            ->wherePivotIn('status', ['registered', 'attended'])
            ->count();

        // Upcoming: count of upcoming activities (status upcoming and date >= today)
        $upcomingCount = Activity::whereIn('status', ['upcoming', 'ongoing'])
            ->where('date', '>=', now())
            ->count();

        // Notifications: count of all announcements
        $notificationsCount = Announcement::count();

        // Attendance Rate: percentage of attended activities out of joined activities
        $attendanceRate = 0;
        if ($myActivitiesCount > 0) {
            $attendedCount = DB::table('activity_participants')
                ->where('user_id', $user->id)
                ->where('status', 'attended')
                ->count();
            $attendanceRate = round(($attendedCount / $myActivitiesCount) * 100);
        }

        $stats = [
            'myActivities'  => $myActivitiesCount,
            'upcoming'      => $upcomingCount,
            'notifications' => $notificationsCount,
            'attendanceRate'=> $attendanceRate,
        ];

        // Recent Announcements: latest 3 announcements with author
        $announcements = Announcement::with('author')
            ->latest()
            ->take(3)
            ->get();

        // Upcoming Activities: next 3 upcoming activities (ordered by date)
        $upcomingActivities = Activity::whereIn('status', ['upcoming', 'ongoing'])
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();

        return view('dashboard', [
            'stats'              => $stats,
            'announcements'      => $announcements,
            'upcomingActivities' => $upcomingActivities,
        ]);
    }
}
