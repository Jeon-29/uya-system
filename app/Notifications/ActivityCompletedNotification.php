<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivityCompletedNotification extends Notification
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
            'type'        => 'activity_completed',
            'title'       => 'Activity Completed',
            'message'     => "The activity \"{$this->activity->title}\" has ended. Leave feedback or access your certificate!",
            'activity_id' => $this->activity->id,
            'url'         => route('activities.show', $this->activity->id),
        ];
    }
}
