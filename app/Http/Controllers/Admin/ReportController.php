<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display reports dashboard for Activity Report and Attendance Report.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'activities');
        $search = $request->query('search');
        $activityFilter = $request->query('activity_id');
        $period = $request->query('period', 'all');

        if ($tab === 'evaluation') {
            $tab = 'activities';
        }

        $activitiesList = Activity::when($tab === 'activities', fn($q) => $q->where('status', 'completed'))
            ->orderBy('title', 'asc')
            ->get(['id', 'title']);

        if ($tab === 'attendance') {
            return $this->attendanceReport($request, $search, $activityFilter, $period, $activitiesList);
        }

        return $this->activityReport($request, $search, $activityFilter, $period, $activitiesList);
    }

    /**
     * Export active report tab data as CSV.
     */
    public function export(Request $request)
    {
        $tab = $request->query('tab', 'activities');
        if ($tab === 'evaluation') {
            $tab = 'activities';
        }

        $search = $request->query('search');
        $activityFilter = $request->query('activity_id');
        $period = $request->query('period', 'all');

        $fileName = 'uya_' . $tab . '_report_' . date('Y-m-d_His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($tab, $search, $activityFilter, $period) {
            $file = fopen('php://output', 'w');

            if ($tab === 'attendance') {
                fputcsv($file, [
                    'Activity Title',
                    'Event Date',
                    'Registered',
                    'On-Time',
                    'Late',
                    'Absent',
                    'Male (Attended)',
                    'Female (Attended)',
                    'Other/Unspecified (Attended)',
                    'Turnout Rate (%)'
                ]);

                $query = $this->buildActivityMetricsQuery($search, $activityFilter, $period, false);
                $records = $query->orderBy('date', 'desc')->get();

                foreach ($records as $row) {
                    $reg = $row->total_registered ?? 0;
                    $att = $row->total_attended ?? 0;
                    $late = $row->total_late ?? 0;
                    $abs = $row->total_absent ?? 0;
                    $male = $row->male_count ?? 0;
                    $female = $row->female_count ?? 0;
                    $other = $row->other_gender_count ?? 0;
                    $rate = $reg > 0 ? round((($att + $late) / $reg) * 100) : 0;

                    fputcsv($file, [
                        $row->title,
                        $row->date ? $row->date->format('Y-m-d H:i') : 'N/A',
                        $reg,
                        $att,
                        $late,
                        $abs,
                        $male,
                        $female,
                        $other,
                        $rate . '%'
                    ]);
                }
            } else {
                // Completed Activities Compilation Export
                fputcsv($file, [
                    'Activity Title',
                    'Description',
                    'Date',
                    'Venue',
                    'Status',
                    'Number of Participants',
                    'Male Participants',
                    'Female Participants',
                    'Other/Unspecified'
                ]);

                $query = $this->buildActivityMetricsQuery($search, $activityFilter, $period, true);
                $records = $query->orderBy('date', 'desc')->get();

                foreach ($records as $row) {
                    $participantsCount = ($row->total_attended ?? 0) + ($row->total_late ?? 0);
                    $male = $row->male_count ?? 0;
                    $female = $row->female_count ?? 0;
                    $other = $row->other_gender_count ?? 0;

                    fputcsv($file, [
                        $row->title,
                        $row->description ?? 'N/A',
                        $row->date ? $row->date->format('Y-m-d H:i') : 'N/A',
                        $row->location ?? 'N/A',
                        ucfirst($row->status ?? 'Completed'),
                        $participantsCount,
                        $male,
                        $female,
                        $other
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Handle Activity Report (Compilation of completed activities, events, and programs).
     */
    private function activityReport(Request $request, $search, $activityFilter, $period, $activitiesList)
    {
        $query = $this->buildActivityMetricsQuery($search, $activityFilter, $period, true);

        // Chronological dataset for Line Graph (up to 12 completed activities)
        $chartActivities = (clone $query)
            ->orderBy('date', 'asc')
            ->limit(12)
            ->get();

        // All matching completed activities for KPI aggregation
        $allFilteredActivities = (clone $query)->get();

        $totalCompletedActivities = $allFilteredActivities->count();
        $totalParticipants = $allFilteredActivities->sum(fn($a) => ($a->total_attended ?? 0) + ($a->total_late ?? 0));
        $maleCount = $allFilteredActivities->sum('male_count');
        $femaleCount = $allFilteredActivities->sum('female_count');
        $otherCount = $allFilteredActivities->sum('other_gender_count');
        $avgParticipants = $totalCompletedActivities > 0
            ? round($totalParticipants / $totalCompletedActivities)
            : 0;

        $activityReports = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();

        $chartData = [
            'labels'       => $chartActivities->map(fn($a) => \Illuminate\Support\Str::limit($a->title, 18))->values(),
            'participants' => $chartActivities->map(fn($a) => ($a->total_attended ?? 0) + ($a->total_late ?? 0))->values(),
            'gender'       => [
                'male'   => $maleCount,
                'female' => $femaleCount,
                'other'  => $otherCount,
            ],
        ];

        $stats = [
            'totalCompletedActivities' => $totalCompletedActivities,
            'totalParticipants'        => $totalParticipants,
            'avgParticipants'          => $avgParticipants,
            'maleCount'                => $maleCount,
            'femaleCount'              => $femaleCount,
            'otherCount'               => $otherCount,
        ];

        return view('admin.reports', [
            'tab'             => 'activities',
            'activityReports' => $activityReports,
            'stats'           => $stats,
            'chartData'       => $chartData,
            'activitiesList'  => $activitiesList,
            'search'          => $search,
            'activityFilter'  => $activityFilter,
            'period'          => $period,
            'periodLabel'     => $this->getPeriodLabel($period),
        ]);
    }

    /**
     * Handle Attendance Report (Summary of registered, on-time, late, absent, and turnout rate).
     */
    private function attendanceReport(Request $request, $search, $activityFilter, $period, $activitiesList)
    {
        $query = $this->buildActivityMetricsQuery($search, $activityFilter, $period, false);

        $chartActivities = (clone $query)
            ->orderBy('date', 'asc')
            ->limit(12)
            ->get();

        $allFilteredActivities = (clone $query)->get();

        $totalRegistrations = $allFilteredActivities->sum('total_registered');
        $totalOnTime = $allFilteredActivities->sum('total_attended');
        $totalLate = $allFilteredActivities->sum('total_late');
        $totalAbsent = $allFilteredActivities->sum('total_absent');
        $maleCount = $allFilteredActivities->sum('male_count');
        $femaleCount = $allFilteredActivities->sum('female_count');
        $otherCount = $allFilteredActivities->sum('other_gender_count');

        $overallRate = $totalRegistrations > 0
            ? round((($totalOnTime + $totalLate) / $totalRegistrations) * 100)
            : 0;

        $attendanceSummary = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();

        $chartData = [
            'labels'     => $chartActivities->map(fn($a) => \Illuminate\Support\Str::limit($a->title, 18))->values(),
            'registered' => $chartActivities->pluck('total_registered')->values(),
            'attended'   => $chartActivities->map(fn($a) => ($a->total_attended ?? 0) + ($a->total_late ?? 0))->values(),
            'gender'     => [
                'male'   => $maleCount,
                'female' => $femaleCount,
                'other'  => $otherCount,
            ],
        ];

        $stats = [
            'totalRegistrations' => $totalRegistrations,
            'totalOnTime'        => $totalOnTime,
            'totalLate'          => $totalLate,
            'totalAbsent'        => $totalAbsent,
            'overallRate'        => $overallRate,
            'maleCount'          => $maleCount,
            'femaleCount'        => $femaleCount,
            'otherCount'         => $otherCount,
        ];

        return view('admin.reports', [
            'tab'               => 'attendance',
            'attendanceSummary' => $attendanceSummary,
            'stats'             => $stats,
            'chartData'         => $chartData,
            'activitiesList'    => $activitiesList,
            'search'            => $search,
            'activityFilter'    => $activityFilter,
            'period'            => $period,
            'periodLabel'       => $this->getPeriodLabel($period),
        ]);
    }

    /**
     * Build shared Activity query with participant counts, gender counts, and filters.
     */
    private function buildActivityMetricsQuery($search, $activityFilter, $period, bool $onlyCompleted = false)
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
            'participants as male_count' => function ($q) {
                $q->join('users', 'activity_participants.user_id', '=', 'users.id')
                  ->whereIn('activity_participants.status', ['attended', 'late'])
                  ->whereRaw('LOWER(users.gender) = ?', ['male']);
            },
            'participants as female_count' => function ($q) {
                $q->join('users', 'activity_participants.user_id', '=', 'users.id')
                  ->whereIn('activity_participants.status', ['attended', 'late'])
                  ->whereRaw('LOWER(users.gender) = ?', ['female']);
            },
            'participants as other_gender_count' => function ($q) {
                $q->join('users', 'activity_participants.user_id', '=', 'users.id')
                  ->whereIn('activity_participants.status', ['attended', 'late'])
                  ->where(function ($sub) {
                      $sub->whereNull('users.gender')
                          ->orWhereNotIn(DB::raw('LOWER(users.gender)'), ['male', 'female']);
                  });
            },
        ]);

        if ($onlyCompleted) {
            $query->where('status', 'completed');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($activityFilter) {
            $query->where('id', $activityFilter);
        }

        if ($period === 'past_30_days') {
            $query->whereBetween('date', [Carbon::now()->subDays(30)->startOfDay(), Carbon::now()->endOfDay()]);
        } elseif ($period === 'this_month') {
            $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        } elseif ($period === 'last_month') {
            $query->whereBetween('date', [Carbon::now()->subMonthNoOverflow()->startOfMonth(), Carbon::now()->subMonthNoOverflow()->endOfMonth()]);
        } elseif ($period === 'past_3_months') {
            $query->whereBetween('date', [Carbon::now()->subMonths(3)->startOfDay(), Carbon::now()->endOfDay()]);
        }

        return $query;
    }

    /**
     * Human-readable label for the selected date period.
     */
    private function getPeriodLabel(string $period): string
    {
        return match ($period) {
            'past_30_days'  => 'Past 30 Days',
            'this_month'    => 'This Month (' . Carbon::now()->format('F Y') . ')',
            'last_month'    => 'Last Month (' . Carbon::now()->subMonthNoOverflow()->format('F Y') . ')',
            'past_3_months' => 'Past 3 Months',
            default         => 'All Time',
        };
    }
}
