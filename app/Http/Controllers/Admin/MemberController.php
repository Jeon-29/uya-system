<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('id', 'asc')
                         ->paginate(8)
                         ->withQueryString();

        return view('admin.members', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'string', Rule::in(['admin', 'officer', 'member'])],
        ]);

        $newMember = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => $validated['role'],
            'email_verified_at' => now(),
        ]);

        ActivityLog::record('Added Member', "Created user account for {$newMember->name} ({$newMember->email}) with role {$newMember->role}.");

        return redirect()->route('admin.members')->with('success', 'Member added successfully.');
    }

    public function update(Request $request, User $member)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($member->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role'     => ['required', 'string', Rule::in(['admin', 'officer', 'member'])],
        ]);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $member->update($data);

        ActivityLog::record('Updated Member', "Updated details for member #{$member->id} ({$member->name}).");

        return redirect()->route('admin.members')->with('success', 'Member updated successfully.');
    }

    public function toggleStatus(User $member)
    {
        if (auth()->id() === $member->id) {
            return redirect()->route('admin.members')->with('error', 'You cannot change your own account status.');
        }

        $member->email_verified_at = $member->email_verified_at ? null : now();
        $member->save();

        $status = $member->email_verified_at ? 'activated' : 'deactivated';

        ActivityLog::record('Toggled Member Status', "Status of member #{$member->id} ({$member->name}) set to {$status}.");

        return redirect()->route('admin.members')->with('success', "Member {$status} successfully.");
    }

    public function destroy(User $member)
    {
        if (auth()->id() === $member->id) {
            return redirect()->route('admin.members')->with('error', 'You cannot delete your own account.');
        }

        $memberName = $member->name;
        $memberId   = $member->id;

        $member->delete();

        ActivityLog::record('Deleted Member', "Deleted member account #{$memberId} ({$memberName}).");

        return redirect()->route('admin.members')->with('success', 'Member deleted successfully.');
    }
}