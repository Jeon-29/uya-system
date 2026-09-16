<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display attendance records and summary metrics.
     */
    public function index(Request $request)
    {
        $hasAttendanceTable = DB::getSchemaBuilder()->hasTable('attendances');

        if (!$hasAttendanceTable) {
            $records = collect();
            $stats = [
                'totalRecords'   => 0,
                'presentCount'   => 0,
                'lateCount'      => 0,
                'absentCount'    => 0,
                'attendanceRate' => 0,
            ];

            return view('admin.attendance', compact('records', 'stats'));
        }

        $query = DB::table('attendances')
            ->leftJoin('users', 'attendances.user_id', '=', 'users.id')
            ->leftJoin('activities', 'attendances.activity_id', '=', 'activities.id')
            ->select(
                'attendances.*',
                'users.name as member_name',
                'activities.title as activity_name'
            );

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('activities.title', 'like', "%{$search}%");
            });
        }

        $records = $query->orderBy('attendances.created_at', 'desc')->paginate(10);

        // Aggregate statistics calculation
        $totalRecords = DB::table('attendances')->count();
        $presentCount = DB::table('attendances')->where('status', 'present')->count();
        $lateCount    = DB::table('attendances')->whereIn('status', ['late', 'present but late'])->count();
        $absentCount  = DB::table('attendances')->where('status', 'absent')->count();

        $attendanceRate = $totalRecords > 0
            ? round((($presentCount + $lateCount) / $totalRecords) * 100)
            : 0;

        $stats = [
            'totalRecords'   => $totalRecords,
            'presentCount'   => $presentCount,
            'lateCount'      => $lateCount,
            'absentCount'    => $absentCount,
            'attendanceRate' => $attendanceRate,
        ];

        return view('admin.attendance', compact('records', 'stats'));
    }

    /**
     * Update an attendance record status.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:present,late,absent',
        ]);

        $hasAttendanceTable = DB::getSchemaBuilder()->hasTable('attendances');

        if ($hasAttendanceTable) {
            DB::table('attendances')->where('id', $id)->update([
                'status'     => $validated['status'],
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.attendance')->with('success', 'Attendance record updated successfully.');
    }
}
