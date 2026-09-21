<?php

namespace App\Notifications;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProposalSubmittedNotification extends Notification
{
    use Queueable;

    protected $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type'        => 'proposal_submitted',
            'title'       => 'New Proposal Submitted',
            'message'     => "{$this->proposal->user->name} submitted a new proposal: \"{$this->proposal->title}\".",
            'proposal_id' => $this->proposal->id,
            'url'         => route('admin.proposals.show', $this->proposal->id),
        ];
    }
}
