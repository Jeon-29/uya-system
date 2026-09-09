<?php

namespace Database\Factories;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Proposal>
 */
class ProposalFactory extends Factory
{
    protected $model = Proposal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'location' => fake()->city(),
            'duration' => fake()->randomElement(['2 hours', 'Half day', 'Full day']),
            'proposed_date' => fake()->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d'),
            'voting_deadline' => fake()->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d'),
            'estimated_budget' => (string) fake()->numberBetween(500, 5000),
            'status' => 'draft',
        ];
    }
}
