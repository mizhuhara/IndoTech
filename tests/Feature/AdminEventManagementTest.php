<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEventManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => User::ADMIN_EMAIL,
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }

    public function test_admin_can_filter_and_search_events(): void
    {
        $this->event([
            'title' => 'Alpha Pending Event',
            'organizer' => 'Alpha Corp',
            'status' => 'Pending',
        ]);
        $this->event([
            'title' => 'Beta Approved Event',
            'organizer' => 'Beta Corp',
            'status' => 'Approved',
            'is_verified' => true,
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.events.index', ['status' => 'pending']))
            ->assertOk()
            ->assertSee('Alpha Pending Event')
            ->assertDontSee('Beta Approved Event');

        $this->actingAs($this->admin)
            ->get(route('admin.events.index', ['q' => 'Beta']))
            ->assertOk()
            ->assertSee('Beta Approved Event')
            ->assertDontSee('Alpha Pending Event');
    }

    public function test_admin_can_view_event_detail_with_registrations(): void
    {
        $event = $this->event(['title' => 'Detail Event']);
        $registration = $event->registrations()->create([
            'name' => 'Peserta Satu',
            'email' => 'peserta@example.com',
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.events.show', $event->id))
            ->assertOk()
            ->assertSee('Detail Event')
            ->assertSee('Peserta Satu')
            ->assertSee($registration->ticket_code);
    }

    public function test_admin_can_approve_and_reject_event(): void
    {
        $event = $this->event(['status' => 'Pending']);

        $this->actingAs($this->admin)
            ->post(route('admin.events.approve', $event->id))
            ->assertSessionHas('success');

        $event->refresh();
        $this->assertSame('Approved', $event->status);
        $this->assertTrue($event->is_verified);

        $this->actingAs($this->admin)
            ->post(route('admin.events.reject', $event->id))
            ->assertSessionHas('success');

        $event->refresh();
        $this->assertSame('Rejected', $event->status);
        $this->assertFalse($event->is_verified);
    }

    public function test_admin_can_delete_event_and_registrations(): void
    {
        $event = $this->event();
        $registration = $event->registrations()->create([
            'name' => 'Peserta Hapus',
            'email' => 'hapus@example.com',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.events.destroy', $event->id))
            ->assertRedirect(route('admin.events.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
        $this->assertDatabaseMissing('event_registrations', ['id' => $registration->id]);
    }

    public function test_missing_event_detail_redirects_with_error(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.events.show', 999))
            ->assertRedirect(route('admin.events.index'))
            ->assertSessionHas('error');
    }

    private function event(array $attributes = []): Event
    {
        return Event::create(array_merge([
            'title' => 'Technology Event',
            'organizer' => 'IndoTech',
            'organizer_type' => 'Company',
            'category' => 'Technology',
            'mode' => 'Online',
            'price' => 'Free',
            'date' => '2026-11-01',
            'location' => 'Online',
            'total_quota' => 100,
            'status' => 'Pending',
            'is_verified' => false,
        ], $attributes));
    }
}
