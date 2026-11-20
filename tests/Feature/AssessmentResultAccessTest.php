<?php

namespace Tests\Feature;

use App\Models\AssessmentAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssessmentResultAccessTest extends TestCase
{
    use RefreshDatabase;

    private function makeAttempt(?User $owner): AssessmentAttempt
    {
        return AssessmentAttempt::create([
            'user_id' => $owner?->id,
            'startup_name' => 'Tani Maju',
            'founder_name' => 'Budi',
            'sector' => 'Precision Agriculture',
            'total_score' => 55,
            'stage' => 'Build',
            'completed_at' => now(),
        ]);
    }

    public function test_owner_can_view_own_result(): void
    {
        $owner = User::factory()->create();
        $attempt = $this->makeAttempt($owner);

        $this->actingAs($owner)
            ->get(route('assessment.result', $attempt))
            ->assertOk()
            ->assertSee('Tani Maju');
    }

    public function test_other_user_cannot_view_result(): void
    {
        $attempt = $this->makeAttempt(User::factory()->create());

        $this->actingAs(User::factory()->create())
            ->get(route('assessment.result', $attempt))
            ->assertNotFound();
    }

    public function test_attempt_without_owner_is_not_viewable(): void
    {
        $attempt = $this->makeAttempt(null);

        $this->actingAs(User::factory()->create())
            ->get(route('assessment.result', $attempt))
            ->assertNotFound();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $attempt = $this->makeAttempt(User::factory()->create());

        $this->get(route('assessment.result', $attempt))
            ->assertRedirect(route('login'));
    }
}
