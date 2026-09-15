<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $currentMonth = Carbon::createFromDate($year, $month, 1);
        $prevMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();

        $startOfCalendar = $currentMonth->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $hasActivitiesTable = DB::getSchemaBuilder()->hasTable('activities');

        $activities = collect();
        $upcomingActivities = collect();

        if ($hasActivitiesTable) {
            $rawActivities = DB::table('activities')
                ->whereBetween('date', [$startOfCalendar->format('Y-m-d'), $endOfCalendar->format('Y-m-d')])
                ->get()
                ->groupBy(function($item) {
                    return Carbon::parse($item->date)->format('Y-m-d');
                });
            $activities = $rawActivities;

            $upcomingActivities = DB::table('activities')
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date', 'asc')
                ->take(5)
                ->get();
        }

        return view('admin.calendar', compact(
            'currentMonth',
            'prevMonth',
            'nextMonth',
            'startOfCalendar',
            'endOfCalendar',
            'activities',
            'upcomingActivities'
        ));
    }
}
