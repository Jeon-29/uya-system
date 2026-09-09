<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $currentDate = Carbon::createFromDate($year, $month, 1);

        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        $startOfCalendar = $currentDate->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = $currentDate->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        // Fetch events grouped by Y-m-d
        $activities = Activity::whereBetween('date', [
            $startOfCalendar->format('Y-m-d'),
            $endOfCalendar->format('Y-m-d')
        ])->get()->groupBy(function($event) {
            return Carbon::parse($event->date)->format('Y-m-d');
        });

        $upcomingActivities = Activity::where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->take(5)
            ->get();

        return view('calendar', [
            'currentMonth' => $currentDate,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
            'startOfCalendar' => $startOfCalendar,
            'endOfCalendar' => $endOfCalendar,
            'activities' => $activities,
            'upcomingActivities' => $upcomingActivities,
        ]);
    }
}
