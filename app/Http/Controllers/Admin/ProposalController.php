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
     * Display proposal detailed view for Officers/Admins.
     */
    public function show($id)
    {
        $proposal = Proposal::with(['user', 'votes.user', 'revisions.officer', 'campaign'])->findOrFail($id);
        $activeCampaign = ProposalCampaign::where('is_active', true)->first();

        $yesFeedback = $proposal->votes()->where('vote_type', 'yes')->whereNotNull('feedback')->get();
        $noFeedback  = $proposal->votes()->where('vote_type', 'no')->whereNotNull('feedback')->get();

        return view('admin.proposals.show', compact('proposal', 'activeCampaign', 'yesFeedback', 'noFeedback'));
    }

    /**
     * Toggle supporting document validation status.
     */
    public function toggleDocumentValidation($id)
    {
        $proposal = Proposal::findOrFail($id);

        $newStatus = !$proposal->is_document_validated;
        $proposal->update([
            'is_document_validated' => $newStatus,
        ]);

        $statusText = $newStatus ? 'validated' : 'unvalidated';
        ActivityLog::record('Updated Document Validation', "Marked supporting document for proposal '{$proposal->title}' as {$statusText}.");

        return back()->with('success', "Supporting document marked as {$statusText}.");
    }

    /**
     * Update active campaign schedule settings, manual overrides, and voting deadline.
     */
    public function updateSchedule(Request $request)
    {
        $validated = $request->validate([
            'current_phase'          => 'required|in:submission,review,voting,closed',
            'submission_deadline'   => 'required|date',
            'voting_deadline'       => 'nullable|date',
            'proposed_date_start'    => 'required|date',
            'proposed_date_end'      => 'required|date|after_or_equal:proposed_date_start',
            'is_submission_override' => 'nullable|in:auto,force_open,force_close',
            'required_approval_rate' => 'required|numeric|min:1|max:100',
        ]);

        $overrideValue = match ($request->input('is_submission_override')) {
            'force_open'  => true,
            'force_close' => false,
            default       => null,
        };

        // current_phase is included in the defaults so the first save on a fresh
        // database (no campaign row yet) doesn't fail with "no default value".
        try {
            $campaign = ProposalCampaign::firstOrCreate(['is_active' => true], [
                'title'                  => 'Current Campaign',
                'current_phase'          => 'submission',
                'submission_deadline'    => now()->addDays(7),
                'proposed_date_start'    => now()->addDays(10),
                'proposed_date_end'      => now()->addDays(30),
                'required_approval_rate' => 60.00,
            ]);

            $campaign->update([
                'current_phase'          => $validated['current_phase'],
                'submission_deadline'    => $validated['submission_deadline'],
                'voting_deadline'        => $validated['voting_deadline'] ?? null,
                'proposed_date_start'    => $validated['proposed_date_start'],
                'proposed_date_end'      => $validated['proposed_date_end'],
                'is_submission_override' => $overrideValue,
                'required_approval_rate' => $validated['required_approval_rate'],
            ]);

            ActivityLog::record('Updated Campaign Settings', "Updated campaign phase to {$campaign->current_phase} and schedule settings.");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Schedule save failed: ' . $e->getMessage());

            // TEMPORARY DIAGNOSTIC: shows the real error on screen. Remove this line once fixed.
            return response('Schedule save failed: ' . $e->getMessage(), 500);
        }

        return back()->with('success', 'Proposal schedule settings and campaign deadlines updated successfully!');
    }

    /**
     * Request revision for a submitted proposal.
     */
    public function requestRevision(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        $proposal = Proposal::findOrFail($id);

        $proposal->revisions()->create([
            'officer_id' => auth()->id(),
            'feedback'   => $request->feedback,
        ]);

        $proposal->update([
            'status' => 'needs_revision',
        ]);

        if ($proposal->user) {
            $proposal->user->notify(new ProposalRevisionRequestedNotification($proposal, $request->feedback));
        }

        ActivityLog::record('Requested Proposal Revision', "Requested revisions for proposal '{$proposal->title}'.");

        return back()->with('success', 'Revision request and feedback submitted successfully.');
    }

    /**
     * Approve proposal for voting or execution.
     */
    public function approve($id)
    {
        return $this->approveForVoting($id);
    }

    /**
     * Approve proposal for voting.
     */
    public function approveForVoting($id)
    {
        $proposal = Proposal::findOrFail($id);

        $proposal->update([
            'status'                 => 'active',
            'is_document_validated' => true,
        ]);

        if ($proposal->user) {
            $proposal->user->notify(new ProposalStatusUpdatedNotification($proposal, 'active'));
        }

        ActivityLog::record('Approved Proposal', "Approved proposal '{$proposal->title}' for voting.");

        return back()->with('success', 'Proposal approved and released for voting!');
    }

    /**
     * Reject a proposal.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        $proposal = Proposal::findOrFail($id);

        $proposal->update([
            'status' => 'rejected',
        ]);

        if ($request->filled('reason')) {
            $proposal->revisions()->create([
                'officer_id' => auth()->id(),
                'feedback'   => 'Rejection Reason: ' . $request->reason,
            ]);
        }

        if ($proposal->user) {
            $proposal->user->notify(new ProposalStatusUpdatedNotification($proposal, 'rejected'));
        }

        ActivityLog::record('Rejected Proposal', "Rejected proposal '{$proposal->title}'.");

        return back()->with('success', 'Proposal rejected successfully.');
    }

    /**
     * Convert an approved proposal directly into an official Activity.
     */
    public function convertToActivity($id)
    {
        $proposal = Proposal::with('user')->findOrFail($id);

        $activity = Activity::create([
            'title'          => $proposal->title,
            'description'    => $proposal->description,
            'date'           => $proposal->proposed_date,
            'location'       => $proposal->location,
            'duration'       => $proposal->duration,
            'budget'         => $proposal->estimated_budget,
            'organizer_name' => $proposal->user->name ?? 'UYA Connect',
            'status'         => 'upcoming',
            'created_by'     => auth()->id(),
        ]);

        $proposal->update([
            'status' => 'approved_for_execution',
        ]);

        // Notify active members about the newly scheduled activity
        $members = User::where('role', 'member')->get();
        Notification::send($members, new ActivityCreatedNotification($activity));

        ActivityLog::record('Converted Proposal to Activity', "Converted proposal '{$proposal->title}' into Activity #{$activity->id}.");

        return redirect()->route('admin.activities.index')->with('success', 'Proposal successfully converted into an official Activity!');
    }

    /**
     * Alias route method for convertToActivity.
     */
    public function convert($id)
    {
        return $this->convertToActivity($id);
    }

    /**
     * Archive a proposal.
     */
    public function archive($id)
    {
        $proposal = Proposal::findOrFail($id);

        $proposal->update([
            'status' => 'archived',
        ]);

        ActivityLog::record('Archived Proposal', "Archived proposal '{$proposal->title}'.");

        return back()->with('success', 'Proposal archived successfully.');
    }

    /**
     * Restore an archived proposal to pending state.
     */
    public function restore($id)
    {
        $proposal = Proposal::findOrFail($id);

        $proposal->update([
            'status' => 'pending',
        ]);

        ActivityLog::record('Restored Proposal', "Restored proposal '{$proposal->title}'.");

        return back()->with('success', 'Proposal restored successfully.');
    }

    /**
     * Permanently delete a proposal and its supporting document.
     */
    public function destroy($id)
    {
        $proposal = Proposal::findOrFail($id);

        if ($proposal->supporting_document_path) {
            Storage::disk('public')->delete($proposal->supporting_document_path);
        }

        $proposal->delete();

        ActivityLog::record('Deleted Proposal', "Permanently deleted proposal '{$proposal->title}'.");

        return back()->with('success', 'Proposal deleted permanently.');
    }
}
