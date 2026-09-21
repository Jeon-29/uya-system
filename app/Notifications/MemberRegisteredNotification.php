<?php

namespace App\Notifications;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MemberRegisteredNotification extends Notification
{
    use Queueable;

    protected $activity;
    protected $member;

    public function __construct(Activity $activity, User $member)
    {
        $this->activity = $activity;
        $this->member   = $member;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type'        => 'member_registered',
            'title'       => 'New Registration',
            'message'     => "{$this->member->name} registered for \"{$this->activity->title}\".",
            'activity_id' => $this->activity->id,
            'url'         => route('admin.activities.show', $this->activity->id),
        ];
    }
}
