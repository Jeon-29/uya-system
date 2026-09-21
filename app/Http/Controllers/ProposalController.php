<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalCampaign;
use App\Models\ProposalVote;
use App\Models\User;
use App\Notifications\ProposalSubmittedNotification;
use App\Notifications\ProposalVotedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    /**
     * Display member proposals feed with tabs (Proposals vs My Proposals).
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'proposals');
        $search = $request->query('search');
        $user = auth()->user();

        $activeCampaign = ProposalCampaign::where('is_active', true)->first();

        // Counts for tab badges (Excludes archived proposals from public count)
        $proposalsCount = Proposal::whereIn('status', ['active', 'approved_for_execution', 'rejected', 'completed'])->count();
        $myProposalsCount = Proposal::where('user_id', $user->id)->count();

        $query = Proposal::with(['user', 'votes', 'campaign']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($tab === 'my-proposals') {
            $query->where('user_id', $user->id);
        } else {
            // Public feed: show active, approved, rejected, or completed proposals
            $query->whereIn('status', ['active', 'approved_for_execution', 'rejected', 'completed']);
        }

        $proposals = $query->orderBy('created_at', 'desc')->paginate(6)->withQueryString();

        return view('proposals.index', compact(
            'proposals',
            'tab',
            'search',
            'activeCampaign',
            'proposalsCount',
            'myProposalsCount'
        ));
    }

    /**
     * Display single proposal details.
     */
    public function show($id)
    {
        $proposal = Proposal::with(['user', 'revisions.officer', 'votes.user', 'campaign'])->findOrFail($id);
        $user = auth()->user();

        $isOwner = (int)$proposal->user_id === (int)$user->id;
        $userVote = ProposalVote::where('proposal_id', $proposal->id)->where('user_id', $user->id)->first();

        // Private feedback loaded exclusively for the proposer/owner
        $yesFeedback = $isOwner ? $proposal->votes()->where('vote_type', 'yes')->whereNotNull('feedback')->with('user')->get() : collect();
        $noFeedback  = $isOwner ? $proposal->votes()->where('vote_type', 'no')->whereNotNull('feedback')->with('user')->get() : collect();

        return view('proposals.show', compact('proposal', 'isOwner', 'userVote', 'yesFeedback', 'noFeedback'));
    }

    /**
     * Store new member proposal.
     */
    public function store(Request $request)
    {
        $activeCampaign = ProposalCampaign::where('is_active', true)->first();

        // Safeguard: Check if campaign allows submission
        if (!$activeCampaign || !$activeCampaign->isSubmissionAllowed()) {
            return back()->with('error', 'Proposal submissions are currently closed.');
        }

        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'location'             => 'required|string|max:255',
            'duration'             => 'required|string|max:100',
            'proposed_date'        => 'required|date',
            'estimated_budget'     => 'nullable|numeric|min:0',
            'description'          => 'required|string|max:2000',
            'supporting_document'  => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('supporting_document')) {
            $filePath = $request->file('supporting_document')->store('proposal_docs', 'public');
        }

        $proposal = Proposal::create([
            'campaign_id'              => $activeCampaign?->id,
            'user_id'                  => auth()->id(),
            'title'                    => $validated['title'],
            'location'                 => $validated['location'],
            'duration'                 => $validated['duration'],
            'proposed_date'            => $validated['proposed_date'],
            'estimated_budget'         => $validated['estimated_budget'] ?? 0.00,
            'description'              => $validated['description'],
            'supporting_document_path' => $filePath,
            'status'                   => 'pending',
        ]);

        // Notify admins and officers
        $admins = User::whereIn('role', ['admin', 'officer'])->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new ProposalSubmittedNotification($proposal));
        }

        return back()->with('success', 'Your proposal has been submitted successfully for officer review!');
    }

    /**
     * Update proposal.
     */
    public function update(Request $request, Proposal $proposal)
    {
        if ((int)$proposal->user_id !== (int)auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $activeCampaign = ProposalCampaign::where('is_active', true)->first();

        // Safeguard: Block edits if in Voting or Closed phase
        if (!$activeCampaign || !$activeCampaign->isOwnerModificationAllowed()) {
            return back()->with('error', 'Proposals cannot be edited once voting has started or when the campaign is closed.');
        }

        if (!in_array($proposal->status, ['pending', 'needs_revision'])) {
            return back()->with('error', 'You can only edit proposals that are pending or requiring revisions.');
        }

        $validated = $request->validate([
            'title'                => 'required|string|max:255',
            'location'             => 'required|string|max:255',
            'duration'             => 'required|string|max:100',
            'proposed_date'        => 'required|date',
            'estimated_budget'     => 'nullable|numeric|min:0',
            'description'          => 'required|string|max:2000',
            'supporting_document'  => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('supporting_document')) {
            $validated['supporting_document_path'] = $request->file('supporting_document')->store('proposal_docs', 'public');
            $validated['is_document_validated'] = false;
        }

        $validated['status'] = 'pending';

        $proposal->update($validated);

        $admins = User::whereIn('role', ['admin', 'officer'])->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new ProposalSubmittedNotification($proposal));
        }

        return back()->with('success', 'Proposal updated and resubmitted for review!');
    }

    /**
     * Archive own proposal (Owner side).
     */
    public function archive(Proposal $proposal)
    {
        if ((int)$proposal->user_id !== (int)auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $activeCampaign = ProposalCampaign::where('is_active', true)->first();

        // Safeguard: Block archiving during voting or closed phases
        if (!$activeCampaign || !$activeCampaign->isOwnerModificationAllowed()) {
            return back()->with('error', 'Proposals cannot be archived once voting has started or when the campaign is closed.');
        }

        $proposal->update(['status' => 'archived']);

        return back()->with('success', 'Your proposal has been archived.');
    }

    /**
     * Restore own archived proposal (Owner side).
     */
    public function restore(Proposal $proposal)
    {
        if ((int)$proposal->user_id !== (int)auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($proposal->status !== 'archived') {
            return back()->with('error', 'Only archived proposals can be restored.');
        }

        $proposal->update(['status' => 'pending']);

        return redirect()->route('proposals', ['tab' => 'my-proposals'])
            ->with('success', 'Your proposal has been restored to Pending Review.');
    }

    /**
     * Delete own proposal.
     */
    public function destroy(Proposal $proposal)
    {
        if ((int)$proposal->user_id !== (int)auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $activeCampaign = ProposalCampaign::where('is_active', true)->first();

        // Safeguard: Block deletion during voting or closed phases
        if (!$activeCampaign || !$activeCampaign->isOwnerModificationAllowed()) {
            return back()->with('error', 'Proposals cannot be deleted once voting has started or when the campaign is closed.');
        }

        if (!in_array($proposal->status, ['pending', 'needs_revision', 'rejected', 'archived'])) {
            return back()->with('error', 'You cannot delete active or completed proposals.');
        }

        if ($proposal->supporting_document_path) {
            Storage::disk('public')->delete($proposal->supporting_document_path);
        }

        $proposal->delete();

        return redirect()->route('proposals', ['tab' => 'my-proposals'])->with('success', 'Your proposal was deleted successfully.');
    }

    /**
     * Vote Yes/No on active proposal.
     */
    public function vote(Request $request, Proposal $proposal)
    {
        $user = auth()->user();

        if ((int)$proposal->user_id === (int)$user->id) {
            return back()->with('error', 'Self-voting is not allowed on your own proposal.');
        }

        $activeCampaign = ProposalCampaign::where('is_active', true)->first();

        // Safeguard: Voting only allowed during Voting Phase
        if (!$activeCampaign || !$activeCampaign->isVotingPhase()) {
            return back()->with('error', 'Community voting is currently closed.');
        }

        if ($proposal->status !== 'active') {
            return back()->with('error', 'Voting is currently closed for this proposal.');
        }

        $validated = $request->validate([
            'vote_type' => 'required|in:yes,no',
            'feedback'  => 'nullable|string|max:1000',
        ]);

        ProposalVote::updateOrCreate(
            [
                'proposal_id' => $proposal->id,
                'user_id'     => $user->id,
            ],
            [
                'vote_type' => $validated['vote_type'],
                'feedback'  => $validated['feedback'] ?? null,
            ]
        );

        $proposal->user->notify(new ProposalVotedNotification($proposal, $user));

        return back()->with('success', 'Your vote has been recorded!');
    }
}
