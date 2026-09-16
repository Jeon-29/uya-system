<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a list of announcements sorted by pinned status and date.
     */
    public function index(Request $request)
    {
        $query = Announcement::with('author');

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Always prioritize pinned announcements at the top, followed by the latest posts
        $announcements = $query->orderBy('is_pinned', 'desc')
                               ->latest()
                               ->paginate(6)
                               ->withQueryString();

        // Render admin template for administrative roles, member template for regular users
        $view = in_array(auth()->user()->role ?? 'member', ['admin', 'officer'])
            ? 'admin.announcements'
            : 'announcements';

        return view($view, compact('announcements'));
    }

    /**
     * Store a newly created announcement in database.
     */
    public function store(Request $request)
    {
        $this->authorizeAdminOrOfficer();

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'is_pinned' => 'nullable|boolean',
        ]);

        Announcement::create([
            'author_id' => auth()->id(),
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('announcements')->with('success', 'Announcement published successfully.');
    }

    /**
     * Update the specified announcement in database.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $this->authorizeAdminOrOfficer();

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'is_pinned' => 'nullable|boolean',
        ]);

        $announcement->update([
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('announcements')->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement from database.
     */
    public function destroy(Announcement $announcement)
    {
        $this->authorizeAdminOrOfficer();

        $announcement->delete();

        return redirect()->route('announcements')->with('success', 'Announcement deleted successfully.');
    }

    /**
     * Helper check to enforce Admin / Officer privileges.
     */
    private function authorizeAdminOrOfficer(): void
    {
        if (!in_array(auth()->user()->role ?? 'member', ['admin', 'officer'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
