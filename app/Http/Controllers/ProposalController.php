<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display the proposals list page (index).
     * Data is currently hardcoded; replace with DB queries once a
     * Proposal model + migration exist.
     */
    public function index()
    {
        $allProposals = collect([
            (object) [
                'id' => 1,
                'title' => 'Community Garden Project',
                'description' => 'Start a community garden where members can grow vegetables and flowers together.',
                'proposer' => (object) ['name' => 'Dahyun'],
                'location' => 'Carmona',
                'duration' => 'Ongoing',
                'date' => Carbon::parse('2026-08-15'),
                'status' => 'voting',
                'open' => true,
                'outcome' => null,
                'yes_votes' => 5,
                'no_votes' => 1,
            ],
            (object) [
                'id' => 2,
                'title' => 'Peer Tutoring Circle',
                'description' => 'A small study-support circle where members help other youth with basic school subjects.',
                'proposer' => (object) ['name' => 'Sana'],
                'location' => 'UYA Hall',
                'duration' => '2 hours',
                'date' => Carbon::parse('2026-08-18'),
                'status' => 'closed',
                'open' => false,
                'outcome' => 'approved',
                'yes_votes' => 31,
                'no_votes' => 2,
            ],
            (object) [
                'id' => 3,
                'title' => 'Open Mic Night',
                'description' => 'A casual talent-sharing night showcasing local youth music and performances.',
                'proposer' => (object) ['name' => 'Chaeyoung'],
                'location' => 'Baras',
                'duration' => '3 hours',
                'date' => Carbon::parse('2026-08-22'),
                'status' => 'closed',
                'open' => false,
                'outcome' => 'rejected',
                'yes_votes' => 14,
                'no_votes' => 18,
            ],
            (object) [
                'id' => 4,
                'title' => 'Coding for Kids Workshop',
                'description' => 'Introduce basic programming concepts to elementary students using interactive blocks.',
                'proposer' => (object) ['name' => 'Mina'],
                'location' => 'CvSU Lab',
                'duration' => 'Half day',
                'date' => Carbon::parse('2026-08-25'),
                'status' => 'voting',
                'open' => true,
                'outcome' => null,
                'yes_votes' => 10,
                'no_votes' => 2,
            ],
            (object) [
                'id' => 5,
                'title' => 'Youth Leadership Summit',
                'description' => 'A full-day conference featuring guest speakers on community leadership and teamwork.',
                'proposer' => (object) ['name' => 'Jihyo'],
                'location' => 'Auditorium',
                'duration' => 'Full day',
                'date' => Carbon::parse('2026-08-28'),
                'status' => 'voting',
                'open' => true,
                'outcome' => null,
                'yes_votes' => 18,
                'no_votes' => 2,
            ],
            (object) [
                'id' => 6,
                'title' => 'Charity Basketball League',
                'description' => 'A weekend sports tournament to raise funds for local community outreach programs.',
                'proposer' => (object) ['name' => 'Nayeon'],
                'location' => 'City Gym',
                'duration' => 'Full day',
                'date' => Carbon::parse('2026-08-30'),
                'status' => 'closed',
                'open' => false,
                'outcome' => 'approved',
                'yes_votes' => 35,
                'no_votes' => 5,
            ],
        ]);

        $myProposals = collect([
            (object) [
                'id' => 7,
                'title' => 'CleanUp Drive in Carmona',
                'description' => 'Organize a community cleanup drive around local parks.',
                'proposer' => (object) ['name' => 'Momo'],
                'location' => 'Carmona',
                'duration' => '3 hours',
                'date' => Carbon::parse('2026-08-12'),
                'status' => 'submission',
                'open' => true,
                'outcome' => null,
                'yes_votes' => 0,
                'no_votes' => 0,
            ],
            (object) [
                'id' => 8,
                'title' => 'Youth Digital Literacy Bootcamp',
                'description' => 'A beginner-friendly training program that helps youth members learn basic computer safety.',
                'proposer' => (object) ['name' => 'Momo'],
                'location' => 'GMA Hall',
                'duration' => '1 day',
                'date' => Carbon::parse('2026-08-20'),
                'status' => 'closed',
                'open' => false,
                'outcome' => 'approved',
                'yes_votes' => 28,
                'no_votes' => 7,
            ],
            (object) [
                'id' => 9,
                'title' => 'Weekend Movie Night Fundraiser',
                'description' => 'A small fundraising activity proposal that did not meet the required approval threshold.',
                'proposer' => (object) ['name' => 'Momo'],
                'location' => 'UYA Ctr',
                'duration' => '3 hours',
                'date' => Carbon::parse('2026-08-24'),
                'status' => 'closed',
                'open' => false,
                'outcome' => 'rejected',
                'yes_votes' => 20,
                'no_votes' => 15,
            ],
        ]);

        // Workflow status — derives the current phase from the latest proposal state.
        // Replace with a real Phase enum or DB lookup once the model exists.
        $currentPhase = 'Submission';

        return view('proposals', [
            'allProposals' => $allProposals,
            'myProposals' => $myProposals,
            'currentPhase' => $currentPhase,
        ]);
    }

    /**
     * Store a newly submitted proposal.
     * Currently returns a success flash and redirects back.
     * Wire to DB once the Proposal model exists.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'duration'    => 'required|string|max:100',
            'proposed_date' => 'required|date',
            'description' => 'required|string|max:2000',
            'budget'      => 'nullable|string|max:100',
        ]);

        // TODO: Proposal::create([...$validated + ['proposer_id' => auth()->id(), 'status' => 'submission']]);
        // For now, just confirm success.

        return redirect()
            ->route('proposals')
            ->with('success', 'Your proposal has been submitted successfully!');
    }

    /**
     * Cast a vote (YES / NO) on a proposal, with optional feedback.
     * Returns a flash success and redirects back.
     */
    public function vote(Request $request, $id)
    {
        $validated = $request->validate([
            'vote'     => 'required|in:yes,no',
            'feedback' => 'nullable|string|max:1000',
        ]);

        // TODO: Vote::create([...]) or Proposal::find($id)->castVote(...)
        // For now, just confirm success.

        return redirect()
            ->route('proposals')
            ->with('success', 'Your vote has been recorded. Thank you!');
    }

    /**
     * Update an existing proposal (edit flow).
     * Returns a flash success and redirects back.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'duration'    => 'required|string|max:100',
            'proposed_date' => 'required|date',
            'description' => 'required|string|max:2000',
            'budget'      => 'nullable|string|max:100',
        ]);

        // TODO: Proposal::findOrFail($id)->update([...]);

        return redirect()
            ->route('proposals')
            ->with('success', 'Proposal updated successfully!');
    }

    /**
     * Save a proposal as draft.
     */
    public function draft(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'duration'    => 'required|string|max:100',
            'proposed_date' => 'required|date',
            'description' => 'required|string|max:2000',
            'budget'      => 'nullable|string|max:100',
        ]);

        // TODO: Proposal::create([...$validated + ['proposer_id' => auth()->id(), 'status' => 'draft']]);

        return redirect()
            ->route('proposals')
            ->with('success', 'Proposal saved as draft.');
    }
}
