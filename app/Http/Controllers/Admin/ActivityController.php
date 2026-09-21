<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityPhoto;
use App\Models\ActivityLog;
use App\Models\CertificateTemplate;
use App\Models\User;
use App\Notifications\ActivityCreatedNotification;
use App\Notifications\AttendanceOpenedNotification;
use App\Notifications\ActivityCompletedNotification;
use App\Services\CertificateGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'active');
        $search = $request->query('search');

        $activeCount = Activity::whereIn('status', ['upcoming', 'ongoing'])->count();
        $finishedCount = Activity::where('status', 'completed')->count();
        $archivedCount = Activity::onlyTrashed()->count();

        // Fetch certificate templates for dropdown options in modals
        $certificateTemplates = CertificateTemplate::orderBy('title', 'asc')->get();

        if ($tab === 'archived') {
            $query = Activity::onlyTrashed();
        } else {
            $query = Activity::query();
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('organizer_name', 'like', "%{$search}%");
            });
        }

        if ($tab === 'finished') {
            $query->where('status', 'completed');
        } elseif ($tab === 'archived') {
            // Filtered to archived
        } else {
            $query->whereIn('status', ['upcoming', 'ongoing']);
        }

        $activities = $query->with('certificateTemplate')->orderBy('date', 'desc')->paginate(9)->withQueryString();

        return view('admin.activities.index', compact(
            'activities',
            'tab',
            'search',
            'activeCount',
            'finishedCount',
            'archivedCount',
            'certificateTemplates'
        ));
    }

    public function show($id)
    {
        $activity = Activity::withTrashed()
            ->with(['creator', 'photos', 'feedback.user', 'participants.user', 'certificateTemplate', 'certificates.user'])
            ->findOrFail($id);

        $registeredCount = $activity->participants()->whereIn('status', ['registered', 'attended', 'late'])->count();
        $presentCount = $activity->participants()->whereIn('status', ['attended', 'late'])->count();
        $waitingCount = $activity->participants()->where('status', 'registered')->count();

        // Group photos by batch_id if available, fallback to individual photo id grouping
        $groupedPhotos = $activity->photos->groupBy(function ($photo) {
            return $photo->batch_id ?? ('single_' . $photo->id);
        });

        return view('admin.activities.show', compact('activity', 'groupedPhotos', 'registeredCount', 'presentCount', 'waitingCount'));
    }

    /**
     * Upload event documentation photos grouped by unique batch ID.
     */
    public function uploadPhotos(Request $request, Activity $activity)
    {
        $request->validate([
            'photos'        => 'required|array',
            'photos.*'      => 'image|mimes:jpeg,png,jpg,webp|max:51200',
            'caption_type'  => 'nullable|string|in:single,individual',
            'single_caption'=> 'nullable|string|max:500',
            'captions'      => 'nullable|array',
        ]);

        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
            $captionType = $request->input('caption_type', 'single');
            $singleCaption = $request->input('single_caption');
            $captions = $request->input('captions', []);
            $batchId = (string) Str::uuid();

            foreach ($photos as $index => $file) {
                $path = $file->store('activity_photos', 'public');

                $finalCaption = ($captionType === 'single')
                    ? $singleCaption
                    : ($captions[$index] ?? null);

                ActivityPhoto::create([
                    'activity_id' => $activity->id,
                    'photo_path'  => $path,
                    'caption'     => $finalCaption,
                    'batch_id'    => $batchId,
                ]);
            }
        }

        ActivityLog::record('Uploaded Activity Photos', "Uploaded documentation photos for: \"{$activity->title}\".");

        return back()->with('success', 'Event documentation photos uploaded successfully.');
    }

    public function deletePhoto($photoId)
    {
        $photo = ActivityPhoto::findOrFail($photoId);
        $photo->delete();

        ActivityLog::record('Deleted Activity Photo', "Deleted photo from event gallery.");

        return back()->with('success', 'Photo removed from gallery.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                     => 'required|string|max:255',
            'organizer_name'            => 'required|string|max:255',
            'event_date'                => 'required|date',
            'event_time'                => 'required',
            'location'                  => 'nullable|string|max:255',
            'budget'                    => 'nullable|numeric|min:0',
            'duration'                  => 'nullable|string|max:100',
            'status'                    => 'required|in:upcoming,ongoing,completed',
            'certificate_template_id'   => 'nullable|exists:certificate_templates,id',
            'certificate_issuance_rule' => 'nullable|in:attendance,all_registered,manual',
            'description'               => 'nullable|string',
        ]);

        $eventDateTime = $validated['event_date'] . ' ' . $validated['event_time'];

        $activity = Activity::create([
            'title'                     => $validated['title'],
            'organizer_name'            => $validated['organizer_name'],
            'date'                      => $eventDateTime,
            'location'                  => $validated['location'],
            'budget'                    => $validated['budget'] ?? 0.00,
            'duration'                  => $validated['duration'],
            'status'                    => $validated['status'],
            'certificate_template_id'   => $validated['certificate_template_id'] ?? null,
            'certificate_issuance_rule' => $validated['certificate_issuance_rule'] ?? 'attendance',
            'description'               => $validated['description'],
            'is_registration_open'      => true,
            'is_attendance_open'        => false,
            'created_by'                => auth()->id(),
        ]);

        ActivityLog::record('Created Activity', "Created activity: \"{$activity->title}\".");

        // Notify all active members about the new activity
        $members = User::where('role', 'member')->get();
        if ($members->count() > 0) {
            Notification::send($members, new ActivityCreatedNotification($activity));
        }

        return back()->with('success', 'Activity created successfully.');
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title'                     => 'required|string|max:255',
            'organizer_name'            => 'required|string|max:255',
            'event_date'                => 'required|date',
            'event_time'                => 'required',
            'location'                  => 'nullable|string|max:255',
            'budget'                    => 'nullable|numeric|min:0',
            'duration'                  => 'nullable|string|max:100',
            'status'                    => 'required|in:upcoming,ongoing,completed',
            'certificate_template_id'   => 'nullable|exists:certificate_templates,id',
            'certificate_issuance_rule' => 'nullable|in:attendance,all_registered,manual',
            'description'               => 'nullable|string',
        ]);

        $eventDateTime = $validated['event_date'] . ' ' . $validated['event_time'];

        $activity->update([
            'title'                     => $validated['title'],
            'organizer_name'            => $validated['organizer_name'],
            'date'                      => $eventDateTime,
            'location'                  => $validated['location'],
            'budget'                    => $validated['budget'] ?? 0.00,
            'duration'                  => $validated['duration'],
            'status'                    => $validated['status'],
            'certificate_template_id'   => $validated['certificate_template_id'] ?? null,
            'certificate_issuance_rule' => $validated['certificate_issuance_rule'] ?? 'attendance',
            'description'               => $validated['description'],
        ]);

        ActivityLog::record('Updated Activity', "Updated details for: \"{$activity->title}\".");

        return back()->with('success', 'Activity updated successfully.');
    }

    /**
     * Mark an activity as completed and trigger automated certificate generation.
     */
    public function complete(Activity $activity, CertificateGeneratorService $certService)
    {
        $activity->update([
            'status'               => 'completed',
            'is_registration_open' => false,
            'is_attendance_open'   => false,
        ]);

        ActivityLog::record('Completed Activity', "Marked activity as completed: \"{$activity->title}\".");

        // Batch generate certificates if template is configured
        $generatedCount = 0;
        if ($activity->certificate_template_id) {
            $generatedCount = $certService->batchGenerateForActivity($activity);
        }

        // Notify all registered/attended participants that the activity is completed
        $registeredUserIds = $activity->participants()
            ->whereIn('status', ['registered', 'attended', 'late'])
            ->pluck('user_id');

        $participants = User::whereIn('id', $registeredUserIds)->get();
        if ($participants->count() > 0) {
            Notification::send($participants, new ActivityCompletedNotification($activity));
        }

        $msg = "Activity has been marked as completed.";
        if ($generatedCount > 0) {
            $msg .= " Generated {$generatedCount} certificate(s) for eligible participants.";
        }

        return back()->with('success', $msg);
    }

    public function toggleRegistration(Activity $activity)
    {
        if ($activity->status === 'completed') {
            return back()->with('error', 'Cannot change registration status for completed activities.');
        }

        $activity->update([
            'is_registration_open' => !$activity->is_registration_open,
        ]);

        $statusText = $activity->is_registration_open ? 'opened' : 'closed';
        ActivityLog::record('Toggled Registration', "Registration {$statusText} for: \"{$activity->title}\".");

        return back()->with('success', "Registration has been {$statusText}.");
    }

    public function toggleAttendance(Activity $activity)
    {
        if ($activity->status === 'completed') {
            return back()->with('error', 'Cannot change attendance status for completed activities.');
        }

        $newAttendanceState = !$activity->is_attendance_open;
        $updates = ['is_attendance_open' => $newAttendanceState];

        if ($newAttendanceState && $activity->status === 'upcoming') {
            $updates['status'] = 'ongoing';
        }

        $activity->update($updates);

        $statusText = $newAttendanceState ? 'opened' : 'closed';
        ActivityLog::record('Toggled Attendance', "Attendance check-in {$statusText} for: \"{$activity->title}\".");

        // Send notification to registered participants when attendance check-in opens
        if ($newAttendanceState) {
            $registeredUserIds = $activity->participants()
                ->whereIn('status', ['registered', 'attended', 'late'])
                ->pluck('user_id');

            $participants = User::whereIn('id', $registeredUserIds)->get();
            if ($participants->count() > 0) {
                Notification::send($participants, new AttendanceOpenedNotification($activity));
            }
        }

        return back()->with('success', "Attendance check-in has been {$statusText}.");
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        ActivityLog::record('Archived Activity', "Moved activity to archive: \"{$activity->title}\".");

        return redirect()->route('admin.activities.index', ['tab' => 'active'])
            ->with('success', 'Activity moved to archive.');
    }

    public function restore($id)
    {
        $activity = Activity::onlyTrashed()->findOrFail($id);
        $activity->restore();

        ActivityLog::record('Restored Activity', "Restored activity from archive: \"{$activity->title}\".");

        return back()->with('success', 'Activity restored successfully.');
    }

    public function forceDelete($id)
    {
        $activity = Activity::onlyTrashed()->findOrFail($id);
        $title = $activity->title;
        $activity->forceDelete();

        ActivityLog::record('Deleted Activity Permanently', "Permanently wiped activity: \"{$title}\".");

        return back()->with('success', 'Activity permanently deleted.');
    }
}
