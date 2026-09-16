<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('author');

        $userRole = strtolower(auth()->user()->role ?? 'member');
        $isAdminArea = $request->routeIs('admin.*') || $request->is('admin*') || in_array($userRole, ['admin', 'officer']);

        if (!$isAdminArea) {
            if ($userRole === 'member') {
                $query->where('target_audience', 'all');
            } elseif ($userRole === 'officer') {
                $query->whereIn('target_audience', ['all', 'officers']);
            }
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $announcements = $query->orderBy('is_pinned', 'desc')
                               ->latest()
                               ->paginate(10)
                               ->withQueryString();

        $view = $isAdminArea ? 'admin.announcements' : 'announcements';

        return view($view, compact('announcements'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdminOrOfficer();

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'target_audience' => ['required', Rule::in(['all', 'officers', 'admin'])],
            'is_pinned'       => 'nullable|boolean',
        ]);

        $announcement = Announcement::create([
            'author_id'       => auth()->id(),
            'title'           => $validated['title'],
            'content'         => $validated['content'],
            'target_audience' => $validated['target_audience'],
            'is_pinned'       => $request->boolean('is_pinned'),
        ]);

        $userQuery = User::where('id', '!=', auth()->id());

        if ($validated['target_audience'] === 'officers') {
            $userQuery->whereIn(DB::raw('LOWER(role)'), ['officer', 'admin']);
        } elseif ($validated['target_audience'] === 'admin') {
            $userQuery->where(DB::raw('LOWER(role)'), 'admin');
        }

        $recipients = $userQuery->get();

        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new AnnouncementPublished($announcement));
        }

        ActivityLog::record('Published Announcement', "Posted announcement: \"{$announcement->title}\".");

        $redirect = ($request->routeIs('admin.*') || $request->is('admin*')) ? 'admin.announcements' : 'announcements';

        return redirect()->route($redirect)->with('success', 'Announcement posted and notifications sent.');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorizeAdminOrOfficer();

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'target_audience' => ['required', Rule::in(['all', 'officers', 'admin'])],
            'is_pinned'       => 'nullable|boolean',
        ]);

        $announcement->update([
            'title'           => $validated['title'],
            'content'         => $validated['content'],
            'target_audience' => $validated['target_audience'],
            'is_pinned'       => $request->boolean('is_pinned'),
        ]);

        ActivityLog::record('Updated Announcement', "Updated announcement #{$announcement->id}: \"{$announcement->title}\".");

        $redirect = ($request->routeIs('admin.*') || $request->is('admin*')) ? 'admin.announcements' : 'announcements';

        return redirect()->route($redirect)->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement, Request $request)
    {
        $this->authorizeAdminOrOfficer();

        $title = $announcement->title;
        $announcement->delete();

        ActivityLog::record('Deleted Announcement', "Deleted announcement: \"{$title}\".");

        $redirect = ($request->routeIs('admin.*') || $request->is('admin*')) ? 'admin.announcements' : 'announcements';

        return redirect()->route($redirect)->with('success', 'Announcement deleted successfully.');
    }

    private function authorizeAdminOrOfficer(): void
    {
        $role = strtolower(auth()->user()->role ?? 'member');
        if (!in_array($role, ['admin', 'officer'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}