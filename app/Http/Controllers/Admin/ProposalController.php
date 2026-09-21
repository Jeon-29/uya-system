<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Proposal;
use App\Models\ProposalCampaign;
use App\Models\ProposalRevision;
use App\Models\ActivityLog;
use App\Notifications\ProposalRevisionRequestedNotification;
use App\Notifications\ProposalStatusUpdatedNotification;
use App\Notifications\ActivityCreatedNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    /**
     * Admin proposals dashboard filtered by status tabs.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');
        $search = $request->query('search');

        $activeCampaign = ProposalCampaign::where('is_active', true)->first();

        // Calculate dynamic hybrid voting targets
        $totalActiveMembers = User::where('role', 'member')->count();
        if ($activeCampaign) {
            $rate = ($activeCampaign->required_approval_rate ?? 60.00) / 100;
            $activeCampaign->total_voters_target = $totalActiveMembers;
            $activeCampaign->required_yes_votes = (int) ceil($totalActiveMembers * $rate);
        }

        // Admin Badge Counters
        $pendingCount   = Proposal::where('status', 'pending')->count();
        $revisionCount  = Proposal::where('status', 'needs_revision')->count();
        $approvedCount  = Proposal::whereIn('status', ['active', 'approved_for_execution', 'completed'])->count();
        $rejectedCount  = Proposal::where('status', 'rejected')->count();
        $archivedCount  = Proposal::where('status', 'archived')->count();

        $query = Proposal::with(['user', 'votes', 'revisions', 'campaign']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($tab === 'needs-revision') {
            $query->where('status', 'needs_revision');
        } elseif ($tab === 'approved') {
            $query->whereIn('status', ['active', 'approved_for_execution', 'completed']);
        } elseif ($tab === 'rejected') {
            $query->where('status', 'rejected');
        } elseif ($tab === 'archived') {
            $query->where('status', 'archived');
        } else {
            $query->where('status', 'pending');
        }

        $proposals = $query->orderBy('created_at', 'desc')->paginate(9)->withQueryString();

        return view('admin.proposals.index', compact(
            'proposals',
            'tab',
            'search',
            'activeCampaign',
            'pendingCount',
            'revisionCount',
            'approvedCount',
            'rejectedCount',
            'archivedCount'
        ));
    }

    /**
     * Admin view details of a proposal.
     */
    public function show($id)
    {
        $proposal = Proposal::with(['user', 'revisions.officer', 'votes.user', 'campaign'])->findOrFail($id);

        $yesFeedback = $proposal->votes()->where('vote_type', 'yes')->whereNotNull('feedback')->get();
        $noFeedback  = $proposal->votes()->where('vote_type', 'no')->whereNotNull('feedback')->get();

        return view('admin.proposals.show', compact('proposal', 'yesFeedback', 'noFeedback'));
    }

    /**
     * Update active campaign schedule settings, manual overrides, and approval threshold.
     */
    public function updateSchedule(Request $request)
    {
        $validated = $request->validate([
            'current_phase'          => 'required|in:submission,review,voting,closed',
            'submission_deadline'   => 'required|date',
            'proposed_date_start'    => 'required|date',
            'proposed_date_end'      => 'required|date|after_or_equal:proposed_date_start',
            'is_submission_override' => 'nullable|in:auto,force_open,force_close',
            'required_approval_rate' => 'required|numeric|min:1|max:100',
        ]);

        $overrideValue = match ($request->input('is_submission_override')) {
            'force_open'  => true,
            'force_close' => false,
            default       => null, // 'auto'
        };

        $campaign = ProposalCampaign::firstOrCreate(['is_active' => true], [
            'title'                   => 'Current Campaign',
            'submission_deadline'    => now()->addDays(7),
            'proposed_date_start'    => now()->addDays(10),
            'proposed_date_end'      => now()->addDays(30),
            'required_approval_rate' => 60.00,
        ]);

        $campaign->update([
            'current_phase'          => $validated['current_phase'],
            'submission_deadline'    => $validated['submission_deadline'],
            'proposed_date_start'    => $validated['proposed_date_start'],
            'proposed_date_end'      => $validated['proposed_date_end'],
            'is_submission_override' => $overrideValue,
            'required_approval_rate' => $validated['required_approval_rate'],
        ]);

        ActivityLog::record('Updated Campaign Settings', "Updated campaign phase to {$campaign->current_phase} and approval rate threshold to {$campaign->required_approval_rate}%.");

        return back()->with('success', 'Proposal schedule settings and voting targets updated successfully!');
    }

    /**
     * Validate or invalidate supporting PDF document.
     */
    public function toggleDocumentValidation(Proposal $proposal)
    {
        $proposal->update([
            'is_document_validated' => !$proposal->is_document_validated,
        ]);

        $statusText = $proposal->is_document_validated ? 'validated' : 'unvalidated';
        ActivityLog::record('Toggled Document Validation', "Marked supporting document for \"{$proposal->title}\" as {$statusText}.");

        return back()->with('success', "Supporting document marked as {$statusText}.");
    }

    /**
     * Request revisions from author.
     */
    public function requestRevision(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        $proposal->update(['status' => 'needs_revision']);

        ProposalRevision::create([
            'proposal_id' => $proposal->id,
            'officer_id'  => auth()->id(),
            'feedback'    => $validated['feedback'],
        ]);

        ActivityLog::record('Requested Proposal Revision', "Requested revision for: \"{$proposal->title}\".");

        $proposal->user->notify(new ProposalRevisionRequestedNotification($proposal, $validated['feedback']));

        return back()->with('success', 'Revision request sent to the author.');
    }

    /**
     * Approve proposal for community voting.
     */
    public function approveForVoting(Proposal $proposal)
    {
        $proposal->update(['status' => 'active']);

        ActivityLog::record('Approved Proposal for Voting', "Approved proposal for community vote: \"{$proposal->title}\".");

        $proposal->user->notify(new ProposalStatusUpdatedNotification($proposal, 'Approved for community voting!'));

        return back()->with('success', 'Proposal is now active for community voting.');
    }

    /**
     * Reject proposal.
     */
    public function reject(Proposal $proposal)
    {
        $proposal->update(['status' => 'rejected']);

        ActivityLog::record('Rejected Proposal', "Rejected proposal: \"{$proposal->title}\".");

        $proposal->user->notify(new ProposalStatusUpdatedNotification($proposal, 'Declined during review.'));

        return back()->with('success', 'Proposal marked as rejected.');
    }

    /**
     * Archive proposal (Admin side).
     */
    public function archive(Proposal $proposal)
    {
        $proposal->update(['status' => 'archived']);

        ActivityLog::record('Archived Proposal', "Archived proposal: \"{$proposal->title}\".");

        return back()->with('success', 'Proposal has been moved to Archives.');
    }

    /**
     * Restore an archived proposal (Admin side).
     */
    public function restore(Proposal $proposal)
    {
        if ($proposal->status !== 'archived') {
            return back()->with('error', 'Only archived proposals can be restored.');
        }

        $newStatus = $proposal->activity_id ? 'completed' : 'pending';
        $proposal->update(['status' => $newStatus]);

        ActivityLog::record('Restored Archived Proposal', "Restored archived proposal: \"{$proposal->title}\" back to {$newStatus}.");

        return redirect()->route('admin.proposals.index', ['tab' => 'pending'])
            ->with('success', "Proposal \"{$proposal->title}\" has been restored successfully.");
    }

    /**
     * Admin delete a proposal.
     */
    public function destroy(Proposal $proposal)
    {
        if (!in_array($proposal->status, ['rejected', 'archived'])) {
            return back()->with('error', 'Only rejected or archived proposals can be deleted by administrators.');
        }

        if ($proposal->supporting_document_path) {
            Storage::disk('public')->delete($proposal->supporting_document_path);
        }

        $title = $proposal->title;
        $proposal->delete();

        ActivityLog::record('Deleted Proposal', "Permanently deleted proposal: \"{$title}\".");

        return redirect()->route('admin.proposals.index', ['tab' => $proposal->status === 'archived' ? 'archived' : 'rejected'])
            ->with('success', 'Proposal has been permanently deleted.');
    }

    /**
     * One-click conversion of an approved proposal into an official activity.
     */
    public function convertToActivity(Proposal $proposal)
    {
        if (!in_array($proposal->status, ['active', 'approved_for_execution'])) {
            return back()->with('error', 'Only active or winning proposals can be converted into activities.');
        }

        $activity = Activity::create([
            'title'                => $proposal->title,
            'organizer_name'       => $proposal->user->name,
            'date'                 => $proposal->proposed_date->format('Y-m-d') . ' 09:00:00',
            'location'             => $proposal->location,
            'budget'               => $proposal->estimated_budget ?? 0.00,
            'duration'             => $proposal->duration,
            'status'               => 'upcoming',
            'description'          => $proposal->description . "\n\n*Origin: Winning Community Proposal by " . $proposal->user->name . "*",
            'is_registration_open' => true,
            'is_attendance_open'   => false,
            'created_by'           => auth()->id(),
        ]);

        $proposal->update([
            'activity_id' => $activity->id,
            'status'      => 'completed',
        ]);

        ActivityLog::record('Converted Proposal to Activity', "Converted proposal \"{$proposal->title}\" into official Activity #{$activity->id}.");

        $members = User::where('role', 'member')->get();
        if ($members->count() > 0) {
            Notification::send($members, new ActivityCreatedNotification($activity));
        }

        return redirect()->route('admin.activities.show', $activity->id)
            ->with('success', 'Proposal successfully converted into an official Activity!');
    }
}
