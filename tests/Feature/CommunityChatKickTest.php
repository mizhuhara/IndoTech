<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\CommunityMessage;
use App\Models\CommunityMessageAttachment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommunityChatKickTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_owner_can_kick_admin_moderator_and_member(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create();
        $moderator = User::factory()->create();
        $member = User::factory()->create();

        $community = Community::create([
            'user_id' => $owner->id,
            'name' => 'Tech Leaders',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
            'members' => 4,
        ]);

        $community->members()->attach([
            $owner->id => ['role' => 'admin', 'is_banned' => false],
            $admin->id => ['role' => 'admin', 'is_banned' => false],
            $moderator->id => ['role' => 'moderator', 'is_banned' => false],
            $member->id => ['role' => 'member', 'is_banned' => false],
        ]);

        // Owner kicks member via JSON
        $response = $this->actingAs($owner)->deleteJson(route('community.manage.kick', [$community, $member]));
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'members_count' => 3,
            ]);
        $this->assertFalse($community->members()->whereKey($member->id)->exists());

        // Owner kicks moderator
        $response = $this->actingAs($owner)->deleteJson(route('community.manage.kick', [$community, $moderator]));
        $response->assertOk()->assertJson(['success' => true]);
        $this->assertFalse($community->members()->whereKey($moderator->id)->exists());

        // Owner kicks another admin
        $response = $this->actingAs($owner)->deleteJson(route('community.manage.kick', [$community, $admin]));
        $response->assertOk()->assertJson(['success' => true]);
        $this->assertFalse($community->members()->whereKey($admin->id)->exists());

        $this->assertSame(1, $community->fresh()->members);
    }

    public function test_admin_can_kick_moderator_and_member_but_not_owner_or_themselves(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create();
        $moderator = User::factory()->create();
        $member = User::factory()->create();

        $community = Community::create([
            'user_id' => $owner->id,
            'name' => 'Dev Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
            'members' => 4,
        ]);

        $community->members()->attach([
            $owner->id => ['role' => 'admin', 'is_banned' => false],
            $admin->id => ['role' => 'admin', 'is_banned' => false],
            $moderator->id => ['role' => 'moderator', 'is_banned' => false],
            $member->id => ['role' => 'member', 'is_banned' => false],
        ]);

        // Admin kicks member
        $this->actingAs($admin)->deleteJson(route('community.manage.kick', [$community, $member]))
            ->assertOk()
            ->assertJson(['success' => true]);
        $this->assertFalse($community->members()->whereKey($member->id)->exists());

        // Admin kicks moderator
        $this->actingAs($admin)->deleteJson(route('community.manage.kick', [$community, $moderator]))
            ->assertOk()
            ->assertJson(['success' => true]);
        $this->assertFalse($community->members()->whereKey($moderator->id)->exists());

        // Admin tries to kick owner -> 403 Forbidden
        $this->actingAs($admin)->deleteJson(route('community.manage.kick', [$community, $owner]))
            ->assertForbidden();
        $this->assertTrue($community->members()->whereKey($owner->id)->exists());

        // Admin tries to kick themselves -> 403 Forbidden
        $this->actingAs($admin)->deleteJson(route('community.manage.kick', [$community, $admin]))
            ->assertForbidden();
        $this->assertTrue($community->members()->whereKey($admin->id)->exists());
    }

    public function test_moderator_can_only_kick_regular_member(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create();
        $moderatorA = User::factory()->create();
        $moderatorB = User::factory()->create();
        $member = User::factory()->create();

        $community = Community::create([
            'user_id' => $owner->id,
            'name' => 'Moderator Test',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
            'members' => 5,
        ]);

        $community->members()->attach([
            $owner->id => ['role' => 'admin', 'is_banned' => false],
            $admin->id => ['role' => 'admin', 'is_banned' => false],
            $moderatorA->id => ['role' => 'moderator', 'is_banned' => false],
            $moderatorB->id => ['role' => 'moderator', 'is_banned' => false],
            $member->id => ['role' => 'member', 'is_banned' => false],
        ]);

        // Moderator kicks regular member -> Allowed
        $this->actingAs($moderatorA)->deleteJson(route('community.manage.kick', [$community, $member]))
            ->assertOk()
            ->assertJson(['success' => true]);
        $this->assertFalse($community->members()->whereKey($member->id)->exists());

        // Moderator tries to kick another moderator -> 403 Forbidden
        $this->actingAs($moderatorA)->deleteJson(route('community.manage.kick', [$community, $moderatorB]))
            ->assertForbidden();
        $this->assertTrue($community->members()->whereKey($moderatorB->id)->exists());

        // Moderator tries to kick admin -> 403 Forbidden
        $this->actingAs($moderatorA)->deleteJson(route('community.manage.kick', [$community, $admin]))
            ->assertForbidden();
        $this->assertTrue($community->members()->whereKey($admin->id)->exists());

        // Moderator tries to kick owner -> 403 Forbidden
        $this->actingAs($moderatorA)->deleteJson(route('community.manage.kick', [$community, $owner]))
            ->assertForbidden();
        $this->assertTrue($community->members()->whereKey($owner->id)->exists());

        // Moderator tries to kick self -> 403 Forbidden
        $this->actingAs($moderatorA)->deleteJson(route('community.manage.kick', [$community, $moderatorA]))
            ->assertForbidden();
        $this->assertTrue($community->members()->whereKey($moderatorA->id)->exists());
    }

    public function test_regular_member_cannot_kick_anyone(): void
    {
        $owner = User::factory()->create();
        $memberA = User::factory()->create();
        $memberB = User::factory()->create();

        $community = Community::create([
            'user_id' => $owner->id,
            'name' => 'Member Test',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
            'members' => 3,
        ]);

        $community->members()->attach([
            $owner->id => ['role' => 'admin', 'is_banned' => false],
            $memberA->id => ['role' => 'member', 'is_banned' => false],
            $memberB->id => ['role' => 'member', 'is_banned' => false],
        ]);

        $this->actingAs($memberA)->deleteJson(route('community.manage.kick', [$community, $memberB]))
            ->assertForbidden();

        $this->assertTrue($community->members()->whereKey($memberB->id)->exists());
    }

    public function test_kicked_member_loses_access_to_private_chat_and_private_files(): void
    {
        $owner = User::factory()->create();
        $member = User::factory()->create();

        $privateComm = Community::create([
            'user_id' => $owner->id,
            'name' => 'Secret Society',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'private',
            'members' => 2,
        ]);

        $privateComm->members()->attach([
            $owner->id => ['role' => 'admin', 'is_banned' => false],
            $member->id => ['role' => 'member', 'is_banned' => false],
        ]);

        // Create an attachment in private community
        Storage::disk('local')->put('community_attachments/'.$privateComm->id.'/secret.pdf', 'Confidential');
        $msg = CommunityMessage::create([
            'community_id' => $privateComm->id,
            'user_id' => $owner->id,
            'message' => 'Confidential doc',
        ]);
        $attachment = CommunityMessageAttachment::create([
            'message_id' => $msg->id,
            'community_id' => $privateComm->id,
            'user_id' => $owner->id,
            'file_name' => 'secret.pdf',
            'file_type' => 'document',
            'mime_type' => 'application/pdf',
            'file_size' => 12,
            'storage_path' => 'community_attachments/'.$privateComm->id.'/secret.pdf',
        ]);

        // Before kick, member can view chat and preview file
        $this->actingAs($member)->get(route('community.chat', $privateComm))->assertOk();
        $this->actingAs($member)->get(route('community.chat.preview', [$privateComm, $attachment]))->assertOk();

        // Owner kicks member
        $this->actingAs($owner)->deleteJson(route('community.manage.kick', [$privateComm, $member]))
            ->assertOk();

        // After kick, member cannot view chat or preview/download file
        $this->actingAs($member)->get(route('community.chat', $privateComm))->assertForbidden();
        $this->actingAs($member)->getJson(route('community.chat.messages', $privateComm))->assertForbidden();
        $this->actingAs($member)->get(route('community.chat.preview', [$privateComm, $attachment]))->assertForbidden();
        $this->actingAs($member)->get(route('community.chat.download', [$privateComm, $attachment]))->assertForbidden();

        // Member cannot send message
        $this->actingAs($member)->postJson(route('community.chat.send', $privateComm), ['message' => 'Hello'])
            ->assertForbidden();
    }

    public function test_members_list_json_endpoint_returns_accurate_permissions(): void
    {
        $owner = User::factory()->create(['name' => 'Owner Alice']);
        $moderator = User::factory()->create(['name' => 'Mod Bob']);
        $member = User::factory()->create(['name' => 'Member Charlie']);

        $community = Community::create([
            'user_id' => $owner->id,
            'name' => 'Design Club',
            'category' => 'Design',
            'status' => 'active',
            'type' => 'public',
            'members' => 3,
        ]);

        $community->members()->attach([
            $owner->id => ['role' => 'admin', 'is_banned' => false],
            $moderator->id => ['role' => 'moderator', 'is_banned' => false],
            $member->id => ['role' => 'member', 'is_banned' => false],
        ]);

        // As Moderator: can kick member Charlie, but cannot kick Owner Alice
        $response = $this->actingAs($moderator)->getJson(route('community.chat.members', $community));
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'total' => 3,
                'can_moderate' => true,
            ]);

        $members = collect($response->json('members'));
        $ownerItem = $members->firstWhere('id', $owner->id);
        $memberItem = $members->firstWhere('id', $member->id);
        $modItem = $members->firstWhere('id', $moderator->id);

        $this->assertFalse($ownerItem['can_be_kicked']);
        $this->assertFalse($modItem['can_be_kicked']); // cannot kick self
        $this->assertTrue($memberItem['can_be_kicked']); // mod can kick member

        // As regular member: can_moderate is false, cannot kick anyone
        $resMember = $this->actingAs($member)->getJson(route('community.chat.members', $community));
        $resMember->assertOk()->assertJson(['can_moderate' => false]);
        $memberItems = collect($resMember->json('members'));
        $this->assertTrue($memberItems->every(fn ($m) => $m['can_be_kicked'] === false));
    }

    public function test_chat_page_renders_members_toggle_button_and_initial_members(): void
    {
        $owner = User::factory()->create(['name' => 'Boss']);
        $community = Community::create([
            'user_id' => $owner->id,
            'name' => 'Chat View Test',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
            'members' => 1,
        ]);
        $community->members()->attach($owner->id, ['role' => 'admin', 'is_banned' => false]);

        $response = $this->actingAs($owner)->get(route('community.chat', $community));
        $response->assertOk();
        $response->assertSee('id="btn-toggle-members"', false);
        $response->assertSee('modal-community-members', false);
        $response->assertSee('modal-confirm-kick', false);
        $response->assertSee('chat-toast', false);
    }
}
