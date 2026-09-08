<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // My Activities: count of activities the user has joined
        $myActivitiesCount = $user->activities()->count();

        // Upcoming: count of upcoming activities (status upcoming and date >= today)
        $upcomingCount = Activity::upcoming()->count();

        // Notifications: count of all announcements (assuming all are active)
        $notificationsCount = Announcement::count();

        // Attendance Rate: percentage of attended activities out of joined activities
        $attendanceRate = 0;
        if ($myActivitiesCount > 0) {
            $attendedCount = $user->activities()
                ->wherePivot('activity_participants.attended', 1)
                ->count();
            $attendanceRate = round(($attendedCount / $myActivitiesCount) * 100);
        }

        $stats = [
            'myActivities' => $myActivitiesCount,
            'upcoming' => $upcomingCount,
            'notifications' => $notificationsCount,
            'attendanceRate' => $attendanceRate,
        ];

        // Recent Announcements: latest 5 announcements with author
        $announcements = Announcement::with('author')
            ->latest()
            ->take(5)
            ->get();

        // Upcoming Activities: latest 5 upcoming activities (ordered by date)
        $upcomingActivities = Activity::upcoming()
            ->orderBy('date')
            ->take(5)
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'announcements' => $announcements,
            'upcomingActivities' => $upcomingActivities,
        ]);
    }
}
