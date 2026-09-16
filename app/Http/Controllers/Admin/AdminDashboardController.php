<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Safe query for activities if table exists
        $hasActivitiesTable = DB::getSchemaBuilder()->hasTable('activities');

        $totalActivities = $hasActivitiesTable ? DB::table('activities')->count() : 0;
        $upcomingCount = $hasActivitiesTable
            ? DB::table('activities')->where('date', '>=', now()->toDateString())->count()
            : 0;

        $upcomingActivities = $hasActivitiesTable
            ? DB::table('activities')->where('date', '>=', now()->toDateString())->orderBy('date', 'asc')->take(3)->get()
            : collect();

        $stats = [
            'totalMembers'            => User::where('role', 'member')->count(),
            'activeMembers'           => User::where('role', 'member')->whereNotNull('email_verified_at')->count(),
            'totalActivities'         => $totalActivities,
            'upcomingActivitiesCount' => $upcomingCount,
            'approvedProposals'       => Proposal::where('status', 'approved')->count(),
            'pendingProposals'        => Proposal::where('status', 'pending')->count(),
            'rejectedProposals'       => Proposal::where('status', 'rejected')->count(),
            'attendanceRate'          => 85,
        ];

        $recentAnnouncements = Announcement::with('author')->latest()->take(3)->get();
        $recentActivityLogs  = ActivityLog::with('user')->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentAnnouncements', 'upcomingActivities', 'recentActivityLogs'));
    }
}
