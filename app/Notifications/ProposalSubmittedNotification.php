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
        $targetUrl = route('admin.proposals.show', $this->proposal->id);
    return [
        'type'        => 'proposal_submitted',
        'title'       => 'New Proposal Submitted',
        'message'     => "{$this->proposal->user->name} submitted a new proposal: \"{$this->proposal->title}\".",
        'icon'        => 'fa-regular fa-file-lines',
        'proposal_id' => $this->proposal->id,
        'url'         => $targetUrl,
        'action_url'  => $targetUrl,
        'action_text' => 'Review Proposal',
    ];
    }
}
