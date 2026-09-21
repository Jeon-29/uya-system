<?php

namespace App\Notifications;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProposalVotedNotification extends Notification
{
    use Queueable;

    protected $proposal;
    protected $voter;

    public function __construct(Proposal $proposal, User $voter)
    {
        $this->proposal = $proposal;
        $this->voter    = $voter;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type'        => 'proposal_voted',
            'title'       => 'New Vote Cast',
            'message'     => "Someone voted on your proposal \"{$this->proposal->title}\". Check private feedback!",
            'proposal_id' => $this->proposal->id,
            'url'         => route('proposals.show', $this->proposal->id),
        ];
    }
}
