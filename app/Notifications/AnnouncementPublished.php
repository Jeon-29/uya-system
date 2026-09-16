<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnnouncementPublished extends Notification
{
    use Queueable;

    public $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title'       => 'New Announcement Posted',
            'message'     => $this->announcement->title,
            'icon'        => 'fa-solid fa-bullhorn',
            'action_url'  => route('announcements'),
            'action_text' => 'View Announcement',
        ];
    }
}
