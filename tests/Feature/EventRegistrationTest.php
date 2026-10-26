<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $event = $this->createEvent();

        $this->post(route('event.register', $event), [
            'name' => 'Guest',
            'email' => 'guest@example.com',
        ])->assertRedirect(route('login'));
    }

    public function test_event_page_shows_registration_form_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $event = $this->createEvent();

        $this->actingAs($user)->get(route('event.show', $event->id))
            ->assertOk()
            ->assertSee('Register for Event');
    }

    public function test_authenticated_user_can_register_for_event(): void
    {
        $user = User::factory()->create();
        $event = $this->createEvent();

        $this->actingAs($user)->post(route('event.register', $event), [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '081234567890',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('event_registrations', [
            'event_id' => $event->id,
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function test_user_cannot_register_twice_for_same_event(): void
    {
        $user = User::factory()->create();
        $event = $this->createEvent();

        $data = ['name' => $user->name, 'email' => $user->email];

        $this->actingAs($user)->post(route('event.register', $event), $data);
        $this->actingAs($user)->post(route('event.register', $event), $data)
            ->assertSessionHas('error');

        $this->assertDatabaseCount('event_registrations', 1);
    }

    public function test_user_cannot_register_when_quota_is_full(): void
    {
        $existingUser = User::factory()->create();
        $user = User::factory()->create();
        $event = $this->createEvent(['total_quota' => 1]);

        $event->registrations()->create([
            'user_id' => $existingUser->id,
            'name' => $existingUser->name,
            'email' => $existingUser->email,
        ]);

        $this->actingAs($user)->post(route('event.register', $event), [
            'name' => $user->name,
            'email' => $user->email,
        ])->assertSessionHas('error');

        $this->assertDatabaseCount('event_registrations', 1);
    }

    public function test_registration_creates_ticket_code_and_shows_it_on_event_page(): void
    {
        $user = User::factory()->create();
        $event = $this->createEvent();

        $this->actingAs($user)->post(route('event.register', $event), [
            'name' => $user->name,
            'email' => $user->email,
        ])->assertSessionHas('success');

        $registration = $event->registrations()->firstOrFail();

        $this->assertStringStartsWith('EVT-', $registration->ticket_code);

        $this->actingAs($user)->get(route('event.show', $event->id))
            ->assertOk()
            ->assertSee($registration->ticket_code);
    }

    public function test_admin_can_toggle_participant_attendance(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin', 'status' => 'active']);
        $user = User::factory()->create();
        $event = $this->createEvent();
        $registration = $event->registrations()->create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.events.registrations.check-in', [$event, $registration]))
            ->assertSessionHas('success');

        $this->assertNotNull($registration->refresh()->checked_in_at);

        $this->actingAs($admin)
            ->post(route('admin.events.registrations.check-in', [$event, $registration]))
            ->assertSessionHas('success');

        $this->assertNull($registration->refresh()->checked_in_at);
    }

    public function test_admin_cannot_check_in_registration_from_another_event(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin', 'status' => 'active']);
        $user = User::factory()->create();
        $event = $this->createEvent();
        $otherEvent = $this->createEvent(['title' => 'Other Event']);
        $registration = $otherEvent->registrations()->create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.events.registrations.check-in', [$event, $registration]))
            ->assertNotFound();

        $this->assertNull($registration->refresh()->checked_in_at);
    }

    public function test_user_can_cancel_event_registration(): void
    {
        $user = User::factory()->create();
        $event = $this->createEvent();

        $event->registrations()->create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $this->actingAs($user)->delete(route('event.unregister', $event))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('event_registrations', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_cancel_another_user_registration(): void
    {
        $registeredUser = User::factory()->create();
        $otherUser = User::factory()->create();
        $event = $this->createEvent();

        $event->registrations()->create([
            'user_id' => $registeredUser->id,
            'name' => $registeredUser->name,
            'email' => $registeredUser->email,
        ]);

        $this->actingAs($otherUser)->delete(route('event.unregister', $event))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('event_registrations', [
            'event_id' => $event->id,
            'user_id' => $registeredUser->id,
        ]);
    }

    public function test_unapproved_event_cannot_be_registered(): void
    {
        $user = User::factory()->create();
        $event = $this->createEvent(['status' => 'Pending', 'is_verified' => false]);

        $this->actingAs($user)->post(route('event.register', $event), [
            'name' => $user->name,
            'email' => $user->email,
        ])->assertNotFound();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createEvent(array $attributes = []): Event
    {
        return Event::create(array_merge([
            'title' => 'Test Event',
            'organizer' => 'IndoTech',
            'category' => 'Seminar',
            'mode' => 'Online',
            'price' => 'Free',
            'date' => 'Oct 15, 2026',
            'location' => 'Online',
            'total_quota' => 10,
            'status' => 'Approved',
            'is_verified' => true,
        ], $attributes));
    }
}
