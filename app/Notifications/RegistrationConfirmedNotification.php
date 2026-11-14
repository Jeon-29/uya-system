<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RegistrationConfirmedNotification extends Notification
{
    use Queueable;

    protected $activity;
    protected $action; // 'joined' or 'cancelled'

    public function __construct(Activity $activity, string $action = 'joined')
    {
        $this->activity = $activity;
        $this->action   = $action;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $isJoin = $this->action === 'joined';
    $targetUrl = route('activities.show', $this->activity->id);
    return [
        'type'        => 'registration_' . $this->action,
        'title'       => $isJoin ? 'Registration Confirmed' : 'Registration Cancelled',
        'message'     => $isJoin
            ? "You have successfully registered for \"{$this->activity->title}\"."
            : "Your registration for \"{$this->activity->title}\" has been cancelled.",
        'icon'        => $isJoin ? 'fa-regular fa-circle-check' : 'fa-regular fa-circle-xmark',
        'activity_id' => $this->activity->id,
        'url'         => $targetUrl,
        'action_url'  => $targetUrl,
        'action_text' => 'View Activity',
    ];
    }
}
