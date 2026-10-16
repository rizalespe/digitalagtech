<?php

namespace Tests\Feature;

use App\Enums\EventType;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function makeEvent(array $attributes = []): Event
    {
        return Event::create([
            'title' => 'Workshop Malang',
            'slug' => 'workshop-malang',
            'type' => EventType::Workshop,
            'starts_at' => now()->addWeek(),
            'published_at' => now()->subDay(),
            ...$attributes,
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $event = $this->makeEvent();

        $this->post(route('events.registration.store', $event))->assertRedirect(route('login'));
    }

    public function test_user_can_register_and_cancel(): void
    {
        $user = User::factory()->create();
        $event = $this->makeEvent();

        $this->actingAs($user)->post(route('events.registration.store', $event))->assertSessionHas('status');
        $this->assertDatabaseHas('event_registrations', ['event_id' => $event->id, 'user_id' => $user->id, 'status' => 'registered']);

        $this->actingAs($user)->delete(route('events.registration.destroy', $event));
        $this->assertDatabaseHas('event_registrations', ['event_id' => $event->id, 'user_id' => $user->id, 'status' => 'cancelled']);

        // Re-registering reuses the same row.
        $this->actingAs($user)->post(route('events.registration.store', $event));
        $this->assertDatabaseCount('event_registrations', 1);
        $this->assertDatabaseHas('event_registrations', ['status' => 'registered']);
    }

    public function test_registration_is_rejected_when_quota_is_full(): void
    {
        $event = $this->makeEvent(['quota' => 1]);
        $event->registrations()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs(User::factory()->create())
            ->post(route('events.registration.store', $event))
            ->assertSessionHas('error');

        $this->assertDatabaseCount('event_registrations', 1);
    }

    public function test_past_events_do_not_accept_registrations(): void
    {
        $event = $this->makeEvent(['starts_at' => now()->subDay()]);

        $this->actingAs(User::factory()->create())
            ->post(route('events.registration.store', $event))
            ->assertSessionHas('error');
    }
}
