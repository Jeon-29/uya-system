<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivityCreatedNotification extends Notification
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
            'type'        => 'activity_created',
            'title'       => 'New Activity Available',
            'message'     => "A new activity \"{$this->activity->title}\" has been published.",
            'icon'        => 'fa-regular fa-calendar-check',
            'activity_id' => $this->activity->id,
            'url'         => route('activities.show', $this->activity->id),
            'action_url'  => route('activities.show', $this->activity->id),
            'action_text' => 'View Activity',
        ];
    }
}
