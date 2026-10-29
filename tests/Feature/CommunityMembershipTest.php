<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityMembershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_joining(): void
    {
        $community = $this->createCommunity();

        $this->post(route('community.join', $community))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_join_community(): void
    {
        $user = User::factory()->create();
        $community = $this->createCommunity(['members' => 10]);

        $this->actingAs($user)->post(route('community.join', $community))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('community_user', [
            'community_id' => $community->id,
            'user_id' => $user->id,
        ]);
        $this->assertSame(11, $community->refresh()->members);
    }

    public function test_user_cannot_join_same_community_twice(): void
    {
        $user = User::factory()->create();
        $community = $this->createCommunity(['members' => 10]);

        $this->actingAs($user)->post(route('community.join', $community));
        $this->actingAs($user)->post(route('community.join', $community))
            ->assertSessionHas('error');

        $this->assertSame(11, $community->refresh()->members);
    }

    public function test_member_can_leave_community(): void
    {
        $user = User::factory()->create();
        $community = $this->createCommunity(['members' => 10]);

        $this->actingAs($user)->post(route('community.join', $community));
        $this->actingAs($user)->delete(route('community.leave', $community))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('community_user', [
            'community_id' => $community->id,
            'user_id' => $user->id,
        ]);
        $this->assertSame(10, $community->refresh()->members);
    }

    public function test_non_member_cannot_leave_community(): void
    {
        $user = User::factory()->create();
        $community = $this->createCommunity(['members' => 10]);

        $this->actingAs($user)->delete(route('community.leave', $community))
            ->assertSessionHas('error');

        $this->assertSame(10, $community->refresh()->members);
    }

    public function test_community_detail_shows_membership_state(): void
    {
        $user = User::factory()->create();
        $community = $this->createCommunity();

        $this->actingAs($user)->get(route('community.show', $community))
            ->assertOk()
            ->assertSee('Gabung Komunitas');

        $this->actingAs($user)->post(route('community.join', $community));

        $this->actingAs($user)->get(route('community.show', $community))
            ->assertOk()
            ->assertSee('Keluar dari Komunitas')
            ->assertSee('Chat Komunitas')
            ->assertSee('Ruang Chat Komunitas')
            ->assertSee('Buka Chat Komunitas')
            ->assertSee('Live Chat &amp; Berbagi Berkas', false)
            ->assertSee($user->name);
    }

    public function test_creator_sees_manage_icon_button(): void
    {
        $creator = User::factory()->create();
        $community = $this->createCommunity(['user_id' => $creator->id]);
        $community->members()->attach($creator->id, ['role' => 'admin', 'is_banned' => false]);

        $this->actingAs($creator)->get(route('community.show', $community))
            ->assertOk()
            ->assertSee('Kelola Komunitas')
            ->assertSee('Chat Komunitas')
            ->assertSee('Keluar dari Komunitas');
    }

    public function test_inactive_community_is_not_publicly_visible(): void
    {
        $community = $this->createCommunity(['status' => 'inactive']);

        $this->get(route('community.show', $community))->assertNotFound();
    }

    private function createCommunity(array $attributes = []): Community
    {
        return Community::create(array_merge([
            'name' => 'Komunitas Laravel Indonesia',
            'category' => 'Technology',
            'members' => 0,
            'status' => 'active',
            'description' => 'Tempat belajar Laravel bersama.',
            'website' => 'https://example.com',
            'tags' => ['laravel', 'php'],
        ], $attributes));
    }
}
