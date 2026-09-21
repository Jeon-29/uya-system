<?php

namespace App\Notifications;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProposalRevisionRequestedNotification extends Notification
{
    use Queueable;

    protected $proposal;
    protected $feedback;

    public function __construct(Proposal $proposal, string $feedback)
    {
        $this->proposal = $proposal;
        $this->feedback = $feedback;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type'        => 'proposal_revision_requested',
            'title'       => 'Proposal Revision Requested',
            'message'     => "An officer requested revisions for \"{$this->proposal->title}\": {$this->feedback}",
            'proposal_id' => $this->proposal->id,
            'url'         => route('proposals.show', $this->proposal->id),
        ];
    }
}
