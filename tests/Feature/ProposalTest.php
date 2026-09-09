<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Proposal;
use App\Models\ProposalAttachment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProposalTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_view_proposals_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/proposals');

        $response->assertStatus(200);
        $response->assertViewIs('proposals');
        $response->assertViewHas('proposals');
    }

    public function test_user_can_create_a_proposal()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');

        $response = $this->post('/proposals', [
            'title' => 'Test Proposal',
            'location' => 'Test Location',
            'duration' => '2 hours',
            'proposed_date' => '2026-09-15',
            'voting_deadline' => '2026-09-20',
            'estimated_budget' => '1000',
            'description' => 'A test proposal',
            'status' => 'draft',
            'attachments' => [
                UploadedFile::fake()->image('proposal.jpg')
            ]
        ]);

        $response->assertRedirect('/proposals/' . Proposal::first()->id);
        $this->assertDatabaseHas('proposals', [
            'title' => 'Test Proposal',
            'user_id' => $user->id,
            'status' => 'draft',
        ]);
        $attachment = ProposalAttachment::first();
        $this->assertNotNull($attachment);
        Storage::disk('public')->assertExists($attachment->file_path);
    }

    public function test_user_can_view_proposal_details()
    {
        $user = User::factory()->create();
        $proposal = Proposal::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Proposal',
            'status' => 'voting',
        ]);
        $this->actingAs($user);

        $response = $this->get('/proposals/' . $proposal->id);

        $response->assertStatus(200);
        $response->assertViewIs('proposals-details');
        $response->assertViewHas('proposal');
        $this->assertEquals($proposal->id, $response->original('proposal')->id);
    }

    public function test_user_can_vote_on_a_proposal()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $proposal = Proposal::factory()->create([
            'user_id' => $user->id,
            'status' => 'voting',
        ]);
        $this->actingAs($anotherUser);

        $response = $this->post('/proposals/' . $proposal->id . '/vote', [
            'vote' => 'yes',
            'feedback' => 'Great idea!',
        ]);

        $response->assertRedirect('/proposals/' . $proposal->id);
        $this->assertDatabaseHas('proposal_votes', [
            'proposal_id' => $proposal->id,
            'user_id' => $anotherUser->id,
            'vote' => 'yes',
            'feedback' => 'Great idea!',
        ]);
        $proposal->refresh();
        $this->assertEquals(1, $proposal->votes()->count());
        $this->assertEquals(1, $proposal->yes_count);
        $this->assertEquals(0, $proposal->no_count);
        $this->assertEquals(100, $proposal->approval_percentage);
    }
}
