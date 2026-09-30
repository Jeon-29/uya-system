<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display reports dashboard for Evaluation and Attendance.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'evaluation');
        $search = $request->query('search');
        $activityFilter = $request->query('activity_id');

        $activitiesList = Activity::orderBy('title', 'asc')->get(['id', 'title']);

        if ($tab === 'attendance') {
            return $this->attendanceReport($request, $search, $activityFilter, $activitiesList);
        }

        return $this->evaluationReport($request, $search, $activityFilter, $activitiesList);
    }

    /**
     * Export active report tab data as CSV.
     */
    public function export(Request $request)
    {
        $tab = $request->query('tab', 'evaluation');
        $search = $request->query('search');
        $activityFilter = $request->query('activity_id');

        $fileName = 'uya_' . $tab . '_report_' . date('Y-m-d_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($tab, $search, $activityFilter) {
            $file = fopen('php://output', 'w');

            if ($tab === 'attendance') {
                fputcsv($file, ['Activity Title', 'Event Date', 'Registered', 'Attended', 'Late', 'Absent', 'Turnout Rate (%)']);

                $query = Activity::withCount([
                    'participants as total_registered',
                    'participants as total_attended' => function ($q) {
                        $q->where('activity_participants.status', 'attended');
                    },
                    'participants as total_late' => function ($q) {
                        $q->where('activity_participants.status', 'late');
                    },
                    'participants as total_absent' => function ($q) {
                        $q->where('activity_participants.status', 'registered');
                    },
                ]);

                if ($search) {
                    $query->where('title', 'like', "%{$search}%");
                }

                if ($activityFilter) {
                    $query->where('id', $activityFilter);
                }

                $records = $query->orderBy('date', 'desc')->get();

                foreach ($records as $row) {
                    $reg = $row->total_registered ?? 0;
                    $att = $row->total_attended ?? 0;
                    $late = $row->total_late ?? 0;
                    $abs = $row->total_absent ?? 0;
                    $rate = $reg > 0 ? round((($att + $late) / $reg) * 100) : 0;

                    fputcsv($file, [
                        $row->title,
                        $row->date ? $row->date->format('Y-m-d H:i') : 'N/A',
                        $reg,
                        $att,
                        $late,
                        $abs,
                        $rate . '%'
                    ]);
                }
            } else {
                fputcsv($file, ['Member Name', 'Member Email', 'Activity Title', 'Feedback / Comment', 'Date Submitted']);

                $query = DB::table('activity_feedback')
                    ->join('users', 'activity_feedback.user_id', '=', 'users.id')
                    ->join('activities', 'activity_feedback.activity_id', '=', 'activities.id')
                    ->select(
                        'activity_feedback.comment as comments',
                        'activity_feedback.created_at',
                        'users.name as member_name',
                        'users.email as member_email',
                        'activities.title as activity_title'
                    );

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                          ->orWhere('activities.title', 'like', "%{$search}%")
                          ->orWhere('activity_feedback.comment', 'like', "%{$search}%");
                    });
                }

                if ($activityFilter) {
                    $query->where('activity_feedback.activity_id', $activityFilter);
                }

                $records = $query->orderBy('activity_feedback.created_at', 'desc')->get();

                foreach ($records as $row) {
                    fputcsv($file, [
                        $row->member_name,
                        $row->member_email,
                        $row->activity_title,
                        $row->comments,
                        $row->created_at
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Handle Evaluation Reports (Qualitative Feedback).
     */
    private function evaluationReport(Request $request, $search, $activityFilter, $activitiesList)
    {
        $query = DB::table('activity_feedback')
            ->join('users', 'activity_feedback.user_id', '=', 'users.id')
            ->join('activities', 'activity_feedback.activity_id', '=', 'activities.id')
            ->select(
                'activity_feedback.id',
                'activity_feedback.comment as comments',
                'activity_feedback.created_at',
                'users.name as member_name',
                'users.email as member_email',
                'activities.title as activity_title',
                'activities.id as activity_id'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('activities.title', 'like', "%{$search}%")
                  ->orWhere('activity_feedback.comment', 'like', "%{$search}%");
            });
        }

        if ($activityFilter) {
            $query->where('activity_feedback.activity_id', $activityFilter);
        }

        $feedbacks = $query->orderBy('activity_feedback.created_at', 'desc')->paginate(10)->withQueryString();

        $totalResponses = DB::table('activity_feedback')->count();
        $evaluatedActivitiesCount = DB::table('activity_feedback')->distinct('activity_id')->count('activity_id');

        $mostEvaluated = DB::table('activity_feedback')
            ->select('activity_id', DB::raw('count(*) as count'))
            ->groupBy('activity_id')
            ->orderByDesc('count')
            ->first();

        $mostEvaluatedTitle = 'N/A';
        if ($mostEvaluated) {
            $act = Activity::find($mostEvaluated->activity_id);
            if ($act) {
                $mostEvaluatedTitle = $act->title;
            }
        }

        $stats = [
            'totalResponses'            => $totalResponses,
            'evaluatedActivitiesCount' => $evaluatedActivitiesCount,
            'mostEvaluatedTitle'        => $mostEvaluatedTitle,
        ];

        return view('admin.reports', [
            'tab'            => 'evaluation',
            'feedbacks'      => $feedbacks,
            'stats'          => $stats,
            'activitiesList' => $activitiesList,
            'search'         => $search,
            'activityFilter' => $activityFilter,
        ]);
    }

    /**
     * Handle Attendance Summary & Log Reports.
     */
    private function attendanceReport(Request $request, $search, $activityFilter, $activitiesList)
    {
        $query = Activity::withCount([
            'participants as total_registered',
            'participants as total_attended' => function ($q) {
                $q->where('activity_participants.status', 'attended');
            },
            'participants as total_late' => function ($q) {
                $q->where('activity_participants.status', 'late');
            },
            'participants as total_absent' => function ($q) {
                $q->where('activity_participants.status', 'registered');
            },
        ]);

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($activityFilter) {
            $query->where('id', $activityFilter);
        }

        $attendanceSummary = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();

        $totalRegistrations = DB::table('activity_participants')->count();
        $totalPresent = DB::table('activity_participants')->where('status', 'attended')->count();
        $totalLate = DB::table('activity_participants')->where('status', 'late')->count();
        $totalAbsent = DB::table('activity_participants')->where('status', 'registered')->count();

        $overallRate = $totalRegistrations > 0
            ? round((($totalPresent + $totalLate) / $totalRegistrations) * 100)
            : 0;

        $stats = [
            'totalRegistrations' => $totalRegistrations,
            'totalPresent'       => $totalPresent,
            'totalLate'          => $totalLate,
            'totalAbsent'        => $totalAbsent,
            'overallRate'        => $overallRate,
        ];

        return view('admin.reports', [
            'tab'               => 'attendance',
            'attendanceSummary' => $attendanceSummary,
            'stats'             => $stats,
            'activitiesList'    => $activitiesList,
            'search'            => $search,
            'activityFilter'    => $activityFilter,
        ]);
    }
}
