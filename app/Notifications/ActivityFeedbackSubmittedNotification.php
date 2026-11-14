<?php

namespace App\Notifications;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivityFeedbackSubmittedNotification extends Notification
{
    use Queueable;

    protected $activity;
    protected $member;
    protected $comment;

    public function __construct(Activity $activity, User $member, string $comment)
    {
        $this->activity = $activity;
        $this->member   = $member;
        $this->comment   = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type'        => 'feedback_submitted',
            'title'       => 'New Feedback Submitted',
            'message'     => "{$this->member->name} submitted feedback for \"{$this->activity->title}\".",
            'icon'        => 'fa-regular fa-comment-dots',
            'comment'     => $this->comment,
            'activity_id' => $this->activity->id,
            'url'         => route('admin.activities.show', $this->activity->id),
            'action_url'  => route('admin.activities.show', $this->activity->id),
            'action_text' => 'View Feedback',
        ];
    }
}
