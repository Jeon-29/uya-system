<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityParticipant;
use App\Models\ActivityFeedback;
use App\Models\User;
use App\Notifications\ActivityFeedbackSubmittedNotification;
use App\Notifications\RegistrationConfirmedNotification;
use App\Notifications\MemberRegisteredNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ActivityController extends Controller
{
    /**
     * Display member activity feed filtered by active, registered, or completed.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'active');
        $search = $request->query('search');
        $user = auth()->user();

        // Count queries for tab badges
        $activeCount = Activity::whereIn('status', ['upcoming', 'ongoing'])->count();

        // Only count non-completed activities for "My Activities"
        $myCount = Activity::where('status', '!=', 'completed')
            ->whereHas('participants', function ($q) use ($user) {
                $q->where('user_id', $user->id)->whereIn('status', ['registered', 'attended', 'late']);
            })->count();

        $finishedCount = Activity::where('status', 'completed')->count();

        $query = Activity::with(['creator', 'participants', 'photos']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('organizer_name', 'like', "%{$search}%");
            });
        }

        if ($tab === 'my-activities') {
            // Show registered activities ONLY if they are NOT completed yet
            $query->where('status', '!=', 'completed')
                ->whereHas('participants', function ($q) use ($user) {
                    $q->where('user_id', $user->id)->whereIn('status', ['registered', 'attended', 'late']);
                });
        } elseif ($tab === 'finished') {
            // Show all completed activities
            $query->where('status', 'completed');
        } else {
            // Default: Active activities
            $query->whereIn('status', ['upcoming', 'ongoing']);
        }

        $activities = $query->orderBy('date', 'asc')->paginate(8)->withQueryString();

        return view('activities', compact('activities', 'tab', 'search', 'activeCount', 'myCount', 'finishedCount'));
    }

    /**
     * Display unified activity details page for active and completed activities.
     */
    public function show($id)
    {
        $activity = Activity::with(['creator', 'photos', 'feedback.user', 'participants'])->findOrFail($id);
        $user = auth()->user();

        $userParticipant = ActivityParticipant::where('activity_id', $activity->id)
            ->where('user_id', $user->id)
            ->first();

        $isRegistered = $userParticipant && in_array($userParticipant->status, ['registered', 'attended', 'late']);
        $hasAttended = $userParticipant && in_array($userParticipant->status, ['attended', 'late']);

        $registeredCount = $activity->participants()->whereIn('status', ['registered', 'attended', 'late'])->count();
        $presentCount = $activity->participants()->whereIn('status', ['attended', 'late'])->count();
        $waitingCount = $activity->participants()->where('status', 'registered')->count();

        $userFeedback = ActivityFeedback::where('activity_id', $activity->id)
            ->where('user_id', $user->id)
            ->first();

        return view('activity-details', compact(
            'activity',
            'isRegistered',
            'hasAttended',
            'userParticipant',
            'userFeedback',
            'registeredCount',
            'presentCount',
            'waitingCount'
        ));
    }

    /**
     * Join / Register for an activity.
     */
    public function join(Activity $activity)
    {
        if (!$activity->is_registration_open || $activity->status === 'completed') {
            return back()->with('error', 'Registration for this activity is currently closed.');
        }

        if (!$activity->hasAvailableSlots()) {
            return back()->with('error', 'Sorry, this activity has reached its maximum capacity.');
        }

        $user = auth()->user();

        ActivityParticipant::updateOrCreate(
            [
                'activity_id' => $activity->id,
                'user_id'     => $user->id,
            ],
            [
                'status' => 'registered',
            ]
        );

        // 1. Send confirmation notification to member
        $user->notify(new RegistrationConfirmedNotification($activity, 'joined'));

        // 2. Alert admins and officers of new member registration
        $admins = User::whereIn('role', ['admin', 'officer'])->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new MemberRegisteredNotification($activity, $user));
        }

        return back()->with('success', 'You have successfully registered for ' . $activity->title . '!');
    }

    /**
     * Cancel activity registration.
     */
    public function cancel(Activity $activity)
    {
        $user = auth()->user();
        $participant = ActivityParticipant::where('activity_id', $activity->id)
            ->where('user_id', $user->id)
            ->first();

        if ($participant && $participant->status === 'registered') {
            $participant->update(['status' => 'cancelled']);

            // Send cancellation notification to member
            $user->notify(new RegistrationConfirmedNotification($activity, 'cancelled'));

            return back()->with('success', 'Your registration has been cancelled.');
        }

        return back()->with('error', 'Unable to cancel registration.');
    }

    /**
     * Store text-only feedback for completed activity.
     */
    public function storeFeedback(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'comments' => 'required|string|max:1000',
        ]);

        ActivityFeedback::updateOrCreate(
            [
                'activity_id' => $activity->id,
                'user_id'     => auth()->id(),
            ],
            [
                'comment' => $validated['comments'],
            ]
        );

        // Notify officers and admins when new feedback is posted
        $admins = User::whereIn('role', ['admin', 'officer'])->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new ActivityFeedbackSubmittedNotification($activity, auth()->user(), $validated['comments']));
        }

        return back()->with('success', 'Thank you! Your feedback has been submitted.');
    }
}
