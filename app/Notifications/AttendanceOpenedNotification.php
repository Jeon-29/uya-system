<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AttendanceOpenedNotification extends Notification
{
    use Queueable;

    protected $activity;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type'        => 'attendance_opened',
            'title'       => 'Attendance Check-In Open',
            'message'     => "Attendance check-in for \"{$this->activity->title}\" is now open. Scan your QR code to verify presence.",
            'icon'        => 'fa-solid fa-qrcode',
            'activity_id' => $this->activity->id,
            'url'         => route('activities.show', $this->activity->id),
            'action_url'  => route('activities.show', $this->activity->id),
            'action_text' => 'Check In Now',
        ];
    }
}
