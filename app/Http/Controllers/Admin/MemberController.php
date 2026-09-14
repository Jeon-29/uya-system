<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * Display a paginated list of members with search filtering.
     */
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

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'string', Rule::in(['admin', 'officer', 'member'])],
        ]);

        User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => $validated['role'],
            'email_verified_at' => now(), // Admin-created accounts are active by default
        ]);

        return redirect()->route('admin.members')->with('success', 'Member added successfully.');
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, User $member)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($member->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role'     => ['required', 'string', Rule::in(['admin', 'officer', 'member'])],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $member->update($data);

        return redirect()->route('admin.members')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(User $member)
    {
        // Prevent an admin from accidentally deleting their own active account
        if (auth()->id() === $member->id) {
            return redirect()->route('admin.members')->with('error', 'You cannot delete your own account.');
        }

        $member->delete();

        return redirect()->route('admin.members')->with('success', 'Member deleted successfully.');
    }
}
