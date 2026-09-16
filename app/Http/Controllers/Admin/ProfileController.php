<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the admin profile page with activity history.
     */
    public function index()
    {
        $user = auth()->user();
        $activityLogs = $user->activityLogs()->take(10)->get();

        return view('admin.profile', compact('activityLogs'));
    }

    /**
     * Update profile information (name & email).
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        ActivityLog::record('Updated Profile Info', 'Updated name/email preferences.');

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::record('Changed Password', 'Updated security credentials.');

        return back()->with('success', 'Password updated successfully.');
    }
}