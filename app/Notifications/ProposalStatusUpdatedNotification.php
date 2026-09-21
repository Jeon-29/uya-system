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
        return [
            'type'        => 'proposal_status_updated',
            'title'       => 'Proposal Status Update',
            'message'     => "Your proposal \"{$this->proposal->title}\" status updated: {$this->statusMessage}",
            'proposal_id' => $this->proposal->id,
            'url'         => route('proposals.show', $this->proposal->id),
        ];
    }
}
