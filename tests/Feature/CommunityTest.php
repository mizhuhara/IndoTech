<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_only_lists_active_communities(): void
    {
        Community::create([
            'name' => 'Active Community',
            'category' => 'Technology',
            'members' => 10,
            'status' => 'active',
        ]);

        Community::create([
            'name' => 'Inactive Community',
            'category' => 'Technology',
            'members' => 5,
            'status' => 'inactive',
        ]);

        $response = $this->get(route('community.index'));

        $response->assertOk();
        $response->assertSee('Active Community');
        $response->assertDontSee('Inactive Community');
    }

    public function test_admin_can_create_community(): void
    {
        $admin = User::factory()->create([
            'email' => User::ADMIN_EMAIL,
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.community.store'), [
            'name' => 'New Community',
            'category' => 'Technology',
            'description' => 'A new community.',
            'website' => 'https://example.com',
            'email' => 'hello@example.com',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('admin.community.index'));
        $this->assertDatabaseHas('communities', [
            'name' => 'New Community',
            'members' => 0,
            'status' => 'active',
        ]);
    }

    public function test_non_admin_cannot_access_community_management(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get(route('admin.community.index'))->assertForbidden();
    }
}
