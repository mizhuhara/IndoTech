<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\CommunityMessage;
use App\Models\CommunityMessageAttachment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommunityChatTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_guest_is_redirected_to_login_when_accessing_chat(): void
    {
        $community = Community::create([
            'name' => 'Laravel Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);

        $response = $this->get(route('community.chat', $community));

        $response->assertRedirect(route('login'));
    }

    public function test_member_can_view_public_community_chat(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Tech Enthusiasts',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $response = $this->actingAs($user)->get(route('community.chat', $community));

        $response->assertOk();
        $response->assertSee('Tech Enthusiasts');
        $response->assertSee('Kirim File');
        $response->assertSee('Kirim Foto / Video');
        $response->assertSee('Kirim Folder');
    }

    public function test_non_member_cannot_access_private_community_chat(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Private Group',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'private',
        ]);

        $response = $this->actingAs($user)->get(route('community.chat', $community));

        $response->assertForbidden();
    }

    public function test_banned_member_cannot_access_chat(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Public Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => true]);

        $response = $this->actingAs($user)->get(route('community.chat', $community));

        $response->assertForbidden();
    }

    public function test_member_can_send_text_and_emoji(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Emoji Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $response = $this->actingAs($user)->postJson(route('community.chat.send', $community), [
            'message' => 'Halo semuanya! Selamat pagi! 😊🚀🔥',
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('message.message', 'Halo semuanya! Selamat pagi! 😊🚀🔥');

        $this->assertDatabaseHas('community_messages', [
            'community_id' => $community->id,
            'user_id' => $user->id,
            'message' => 'Halo semuanya! Selamat pagi! 😊🚀🔥',
            'type' => 'text',
        ]);
    }

    public function test_member_can_send_images_and_videos(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Media Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $photo = UploadedFile::fake()->image('screenshot.png', 800, 600);
        $video = UploadedFile::fake()->create('demo.mp4', 2048, 'video/mp4');

        $response = $this->actingAs($user)->postJson(route('community.chat.send', $community), [
            'message' => 'Cek foto dan video berikut!',
            'files' => [$photo, $video],
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $this->assertDatabaseHas('community_messages', [
            'community_id' => $community->id,
            'user_id' => $user->id,
            'message' => 'Cek foto dan video berikut!',
        ]);

        $this->assertDatabaseHas('community_message_attachments', [
            'file_name' => 'screenshot.png',
            'file_type' => 'image',
        ]);

        $this->assertDatabaseHas('community_message_attachments', [
            'file_name' => 'demo.mp4',
            'file_type' => 'video',
        ]);
    }

    public function test_member_can_send_documents(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Doc Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $pdf = UploadedFile::fake()->create('panduan.pdf', 1024, 'application/pdf');
        $docx = UploadedFile::fake()->create('laporan.docx', 512, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $response = $this->actingAs($user)->postJson(route('community.chat.send', $community), [
            'message' => 'Ini dokumen panduannya',
            'files' => [$pdf, $docx],
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $this->assertDatabaseHas('community_message_attachments', [
            'file_name' => 'panduan.pdf',
            'file_type' => 'document',
        ]);

        $this->assertDatabaseHas('community_message_attachments', [
            'file_name' => 'laporan.docx',
            'file_type' => 'document',
        ]);
    }

    public function test_member_can_send_folder_with_subfolders(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Dev Project',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $file1 = UploadedFile::fake()->create('index.html', 100, 'text/html');
        $file2 = UploadedFile::fake()->create('style.css', 200, 'text/css');
        $file3 = UploadedFile::fake()->create('app.js', 150, 'application/javascript');

        $response = $this->actingAs($user)->postJson(route('community.chat.send', $community), [
            'message' => 'Ini source code folder proyek',
            'folder_name' => 'ProyekWeb',
            'relative_paths' => [
                'ProyekWeb/index.html',
                'ProyekWeb/css/style.css',
                'ProyekWeb/js/app.js',
            ],
            'files' => [$file1, $file2, $file3],
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $this->assertDatabaseHas('community_messages', [
            'community_id' => $community->id,
            'type' => 'folder',
        ]);

        $this->assertDatabaseHas('community_message_attachments', [
            'folder_name' => 'ProyekWeb',
            'file_name' => 'index.html',
            'relative_path' => 'ProyekWeb/index.html',
        ]);

        $this->assertDatabaseHas('community_message_attachments', [
            'folder_name' => 'ProyekWeb',
            'file_name' => 'style.css',
            'relative_path' => 'ProyekWeb/css/style.css',
        ]);
    }

    public function test_dangerous_files_are_rejected(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Security Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $dangerPhp = UploadedFile::fake()->create('malicious.php', 100, 'text/x-php');

        $response = $this->actingAs($user)->postJson(route('community.chat.send', $community), [
            'message' => 'Coba upload ini',
            'files' => [$dangerPhp],
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $this->assertDatabaseCount('community_messages', 0);
    }

    public function test_member_can_preview_and_download_attachment(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Preview Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $file = UploadedFile::fake()->image('banner.jpg');
        $storedPath = $file->store('community_chat/'.$community->id, 'local');

        $message = CommunityMessage::create([
            'community_id' => $community->id,
            'user_id' => $user->id,
            'message' => 'Banner preview test',
            'type' => 'media',
        ]);

        $attachment = CommunityMessageAttachment::create([
            'message_id' => $message->id,
            'community_id' => $community->id,
            'user_id' => $user->id,
            'file_name' => 'banner.jpg',
            'storage_path' => $storedPath,
            'mime_type' => 'image/jpeg',
            'file_size' => 1024,
            'file_type' => 'image',
        ]);

        // Preview
        $previewRes = $this->actingAs($user)->get(route('community.chat.preview', [$community, $attachment]));
        $previewRes->assertOk();
        $previewRes->assertHeader('X-Content-Type-Options', 'nosniff');

        // Download
        $downloadRes = $this->actingAs($user)->get(route('community.chat.download', [$community, $attachment]));
        $downloadRes->assertOk();
    }

    public function test_member_can_download_folder_as_zip(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Zip Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $file1 = UploadedFile::fake()->create('readme.txt', 100);
        $stored1 = $file1->store('community_chat/'.$community->id, 'local');

        $message = CommunityMessage::create([
            'community_id' => $community->id,
            'user_id' => $user->id,
            'message' => 'Folder pesan',
            'type' => 'folder',
        ]);

        CommunityMessageAttachment::create([
            'message_id' => $message->id,
            'community_id' => $community->id,
            'user_id' => $user->id,
            'file_name' => 'readme.txt',
            'storage_path' => $stored1,
            'mime_type' => 'text/plain',
            'file_size' => 100,
            'file_type' => 'document',
            'folder_name' => 'PaketFolder',
            'relative_path' => 'PaketFolder/readme.txt',
        ]);

        $zipResponse = $this->actingAs($user)->get(route('community.chat.download_folder', [$community, $message]));
        $zipResponse->assertOk();
        $zipResponse->assertHeader('Content-Type', 'application/zip');
    }

    public function test_messages_polling_endpoint_returns_json(): void
    {
        $user = User::factory()->create();
        $community = Community::create([
            'name' => 'Polling Community',
            'category' => 'Technology',
            'status' => 'active',
            'type' => 'public',
        ]);
        $community->members()->attach($user->id, ['role' => 'member', 'is_banned' => false]);

        $msg = CommunityMessage::create([
            'community_id' => $community->id,
            'user_id' => $user->id,
            'message' => 'Pesan real-time 1',
            'type' => 'text',
        ]);

        $response = $this->actingAs($user)->getJson(route('community.chat.messages', $community));

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonCount(1, 'messages');
        $response->assertJsonPath('messages.0.message', 'Pesan real-time 1');
    }
}
