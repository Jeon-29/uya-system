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
        $targetUrl = route('proposals.show', $this->proposal->id);
    return [
        'type'        => 'proposal_voted',
        'title'       => 'New Vote Cast',
        'message'     => "Someone voted on your proposal \"{$this->proposal->title}\". Check private feedback!",
        'icon'        => 'fa-regular fa-thumbs-up',
        'proposal_id' => $this->proposal->id,
        'url'         => $targetUrl,
        'action_url'  => $targetUrl,
        'action_text' => 'View Feedback',
    ];
    }
}
