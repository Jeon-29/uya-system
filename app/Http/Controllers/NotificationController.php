<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display member notifications page feed.
     *
     * Only unread notifications are shown here — once a notification is
     * marked as read it should disappear from this list rather than
     * linger with its "Unread" tag removed.
     */
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications()->paginate(15);
        return view('notifications', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}
