<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('author')->latest()->get();
        return view('announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Restrict creation strictly to admin or officer
        if (!in_array($user->role ?? 'member', ['admin', 'officer'])) {
            return redirect()->route('announcements')->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'author_id' => $user->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('announcements')->with('success', 'Announcement posted successfully.');
    }
}
