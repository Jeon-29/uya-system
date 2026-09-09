<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalVote;
use App\Models\ProposalAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProposalController extends Controller
{
    /**
     * Display a listing of proposals.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'all'); // which pane is active by default ('all' or 'my')
        $search = $request->query('search', '');
        $status = $request->query('status', '');
        $sort = $request->query('sort', 'latest'); // latest, oldest, deadline, votes

        $applyFilters = function ($query) use ($search, $status, $sort) {
            if ($status) {
                $query->where('status', $status);
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            switch ($sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'deadline':
                    $query->orderBy('voting_deadline', 'asc');
                    break;
                case 'votes':
                    $query->orderByDesc('votes_count');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            return $query;
        };

        // "Other Proposals" tab: everyone else's proposals (available to vote on).
        $otherProposals = $applyFilters(
            Proposal::withCount('votes')
                ->with(['proposer', 'votes'])
                ->where('user_id', '!=', $user->id)
        )->paginate(10, ['*'], 'other_page')->appends($request->query());

        // "My Proposals" tab: only the current user's own proposals.
        $myProposals = $applyFilters(
            Proposal::withCount('votes')
                ->with(['proposer', 'votes'])
                ->where('user_id', $user->id)
        )->paginate(10, ['*'], 'my_page')->appends($request->query());

        $allCount = Proposal::where('user_id', '!=', $user->id)->count();
        $myCount = $user->proposals()->count();

        return view('proposals', [
            'proposals' => $otherProposals, // kept for backward compatibility
            'otherProposals' => $otherProposals,
            'myProposals' => $myProposals,
            'tab' => $tab,
            'search' => $search,
            'status' => $status,
            'sort' => $sort,
            'allCount' => $allCount,
            'myCount' => $myCount,
        ]);
    }

    /**
     * Display the specified proposal.
     *
     * @param  Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        $proposal->load(['proposer', 'votes.user', 'attachments']);

        $userVoted = null;
        $userFeedback = '';
        if (Auth::check()) {
            $vote = $proposal->votes()->where('user_id', Auth::id())->first();
            if ($vote) {
                $userVoted = $vote->vote;
                $userFeedback = $vote->feedback;
            }
        }

        return view('proposals-details', [
            'proposal' => $proposal,
            'userVoted' => $userVoted,
            'userFeedback' => $userFeedback,
        ]);
    }

    /**
     * Show the form for creating a new proposal.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('proposals');
    }

    /**
     * Store a newly created proposal in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user is an officer or admin
        $isOfficer = in_array($user->role ?? 'member', ['admin', 'officer']);

        $rules = [
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'duration' => 'required|string',
            'proposed_date' => 'required|date|after_or_equal:today',
            'estimated_budget' => 'nullable|string|max:100',
            'description' => 'required|string',
            'attachments.*' => 'file|mimes:pdf,doc,docx|max:10240', // 10MB
        ];

        // Only validate the voting deadline if an officer/admin is submitting it
        if ($isOfficer) {
            $rules['voting_deadline'] = 'required|date|before_or_equal:proposed_date|after_or_equal:today';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Calculate a default voting deadline for standard members automatically
        if (!$isOfficer) {
            $proposed = \Carbon\Carbon::parse($data['proposed_date']);
            $deadline = $proposed->copy()->subDays(7); // Default to 7 days before event

            // If 7 days prior is already in the past, set the deadline to today
            if ($deadline->isPast()) {
                $deadline = now();
            }
            $data['voting_deadline'] = $deadline->format('Y-m-d');
        }

        $data['status'] = 'submitted';
        $data['user_id'] = $user->id;

        $proposal = Proposal::create($data);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('proposal_attachments', 'public');
                ProposalAttachment::create([
                    'proposal_id' => $proposal->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('proposals.show', $proposal)
            ->with('success', 'Proposal created successfully.');
    }

    /**
     * Show the form for editing the specified proposal.
     *
     * @param  Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        if ($proposal->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        return view('proposals', [
            'proposal' => $proposal,
        ]);
    }

    /**
     * Update the specified proposal in storage.
     *
     * @param  Request  $request
     * @param  Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal)
    {
        $user = Auth::user();

        if ($proposal->user_id !== $user->id && !in_array($user->role ?? 'member', ['admin', 'officer'])) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $isOfficer = in_array($user->role ?? 'member', ['admin', 'officer']);

        $rules = [
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'duration' => 'required|string',
            'proposed_date' => 'required|date|after_or_equal:today',
            'estimated_budget' => 'nullable|string|max:100',
            'description' => 'required|string',
            'attachments.*' => 'file|mimes:pdf,doc,docx|max:10240', // 10MB
        ];

        // Only allow updating/validating voting deadline if user is officer/admin
        if ($isOfficer) {
            $rules['voting_deadline'] = 'required|date|before_or_equal:proposed_date|after_or_equal:today';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        unset($data['attachments']);

        // Editing a proposal that was sent back for revision resubmits it.
        if ($proposal->status === 'revision_requested') {
            $data['status'] = 'submitted';
        }

        $proposal->update($data);

        // Handle new attachments if any
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('proposal_attachments', 'public');
                ProposalAttachment::create([
                    'proposal_id' => $proposal->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('proposals.show', $proposal)
            ->with('success', 'Proposal updated successfully.');
    }

    /**
    * Remove the specified proposal from storage.
    *
    * @param  Proposal  $proposal
    * @return \Illuminate\Http\Response
    */
    public function destroy(Proposal $proposal)
    {
        // Authorization
        if ($proposal->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        // Delete attachments files and records
        foreach ($proposal->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }

        // Delete votes
        $proposal->votes()->delete();

        // Delete proposal
        $proposal->delete();

        return redirect()->route('proposals')
            ->with('success', 'Proposal deleted successfully.');
    }

    /**
     * Store a vote for the proposal.
     *
     * @param  Request  $request
     * @param  Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function vote(Request $request, Proposal $proposal)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($proposal->user_id === $user->id) {
            return redirect()->back()->with('error', 'You cannot vote on your own proposal.');
        }

        // Check if user already voted
        if ($proposal->votes()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You have already voted on this proposal.');
        }

        $validator = Validator::make($request->all(), [
            'vote' => ['required', Rule::in(['yes', 'no'])],
            'feedback' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['user_id'] = $user->id;
        $data['proposal_id'] = $proposal->id;

        ProposalVote::create($data);

        return redirect()->route('proposals.show', $proposal)
            ->with('success', 'Your vote has been recorded.');
    }
}
