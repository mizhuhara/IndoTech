<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_profile_page(): void
    {
        $this->get(route('profile.edit'))->assertRedirect(route('login'));
    }

    public function test_user_can_view_profile_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('profile.edit'))
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee($user->email);
    }

    public function test_user_can_update_name(): void
    {
        $user = User::factory()->create(['name' => 'Nama Lama']);

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Nama Baru',
        ])->assertSessionHas('success');

        $this->assertSame('Nama Baru', $user->refresh()->name);
    }

    public function test_name_is_required(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => '',
        ])->assertSessionHasErrors('name');
    }

    public function test_user_can_change_password_with_correct_current_password(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $this->actingAs($user)->put(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ])->assertSessionHas('success');

        $this->assertTrue(Hash::check('password-baru-123', $user->refresh()->password));
    }

    public function test_wrong_current_password_is_rejected(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $this->actingAs($user)->put(route('profile.password'), [
            'current_password' => 'password-salah',
            'password' => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ])->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('password', $user->refresh()->password));
    }

    public function test_user_can_update_portfolio_and_social_links(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'portfolio_url' => 'https://myportfolio.dev',
            'instagram_url' => 'https://instagram.com/myusername',
            'linkedin_url' => 'https://linkedin.com/in/myusername',
        ])->assertSessionHas('success');

        $updated = $user->refresh();
        $this->assertSame('https://myportfolio.dev', $updated->portfolio_url);
        $this->assertSame('https://instagram.com/myusername', $updated->instagram_url);
        $this->assertSame('https://linkedin.com/in/myusername', $updated->linkedin_url);
    }

    public function test_user_can_upload_profile_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $photo = UploadedFile::fake()->image('my-avatar.jpg', 200, 200);

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'avatar' => $photo,
        ])->assertSessionHas('success');

        $updated = $user->refresh();
        $this->assertNotNull($updated->avatar);
        Storage::disk('public')->assertExists($updated->avatar);
    }

    public function test_user_can_remove_profile_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'avatar' => 'avatars/sample.jpg',
        ]);
        Storage::disk('public')->put('avatars/sample.jpg', 'fake-image-content');

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'remove_avatar' => '1',
        ])->assertSessionHas('success');

        $updated = $user->refresh();
        $this->assertNull($updated->avatar);
        Storage::disk('public')->assertMissing('avatars/sample.jpg');
    }

    public function test_user_can_upload_cv_pdf(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $cv = UploadedFile::fake()->create('my_cv.pdf', 1200, 'application/pdf');

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'cv' => $cv,
        ])->assertSessionHas('success');

        $updated = $user->refresh();
        $this->assertNotNull($updated->cv_path);
        Storage::disk('public')->assertExists($updated->cv_path);
    }

    public function test_cv_must_be_pdf(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $doc = UploadedFile::fake()->create('my_cv.docx', 500, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'cv' => $doc,
        ])->assertSessionHasErrors('cv');
    }

    public function test_cv_must_not_exceed_2mb(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $largePdf = UploadedFile::fake()->create('huge_cv.pdf', 2500, 'application/pdf');

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'cv' => $largePdf,
        ])->assertSessionHasErrors('cv');
    }

    public function test_user_can_remove_cv(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'cv_path' => 'cvs/old_cv.pdf',
        ]);
        Storage::disk('public')->put('cvs/old_cv.pdf', 'fake-pdf-content');

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'remove_cv' => '1',
        ])->assertSessionHas('success');

        $updated = $user->refresh();
        $this->assertNull($updated->cv_path);
        Storage::disk('public')->assertMissing('cvs/old_cv.pdf');
    }
}
