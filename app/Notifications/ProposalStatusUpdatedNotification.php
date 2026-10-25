<?php

namespace App\Notifications;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProposalStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $proposal;
    protected $statusMessage;

    public function __construct(Proposal $proposal, string $statusMessage)
    {
        $this->proposal      = $proposal;
        $this->statusMessage = $statusMessage;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $targetUrl = route('proposals.show', $this->proposal->id);
    return [
        'type'        => 'proposal_status_updated',
        'title'       => 'Proposal Status Update',
        'message'     => "Your proposal \"{$this->proposal->title}\" status updated: {$this->statusMessage}",
        'icon'        => 'fa-regular fa-bell',
        'proposal_id' => $this->proposal->id,
        'url'         => $targetUrl,
        'action_url'  => $targetUrl,
        'action_text' => 'View Proposal',
    ];
    }
}
