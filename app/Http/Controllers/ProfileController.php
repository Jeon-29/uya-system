<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the member profile page with statistics.
     */
    public function show()
    {
        $user = auth()->user();

        // Calculate member attendance stats dynamically
        $attendanceQuery = $user->activities();
        $total = $attendanceQuery->count();
        $present = (clone $attendanceQuery)->wherePivot('attended', true)->count();
        $absent = $total - $present;
        $late = 0; // Configurable based on pivot schema if tracking timestamps
        $rate = $total > 0 ? round(($present / $total) * 100) . '%' : '0%';

        $attendanceStats = [
            'total'   => $total,
            'present' => $present,
            'late'    => $late,
            'absent'  => $absent,
            'rate'    => $rate,
        ];

        $attendanceRecords = $user->activities()->latest('activity_participants.created_at')->get();

        return view('profile', compact('user', 'attendanceStats', 'attendanceRecords'));
    }

    /**
     * Update the user's personal information.
     */
    public function updateInfo(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'age'            => ['required', 'integer', 'min:1', 'max:120'],
            'email'          => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'gender'         => ['required', 'string', Rule::in(['Female', 'Male', 'Other'])],
            'contact_number' => ['required', 'string', 'max:20'],
            'address'        => ['required', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Personal information updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
