<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration_is_auto_verified_without_verification_email(): void
    {
        Notification::fake();

        $response = $this->post(route('register.submit'), [
            'name' => 'Email User',
            'email' => 'email@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $user = User::where('email', 'email@example.com')->firstOrFail();

        $response->assertRedirect(route('welcome'));
        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->email_verified_at);
        Notification::assertNotSentTo($user, VerifyEmailNotification::class);
    }

    public function test_verification_notice_page_renders_for_unverified_institution(): void
    {
        $user = User::factory()->unverified()->create(['role' => 'school', 'status' => 'active']);

        $this->actingAs($user)->get(route('verification.notice'))
            ->assertOk()
            ->assertSee($user->email);
    }

    public function test_notice_page_redirects_and_verifies_user_role(): void
    {
        $user = User::factory()->unverified()->create(['role' => 'user', 'status' => 'active']);

        $this->actingAs($user)->get(route('verification.notice'))
            ->assertRedirect(route('welcome'));

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_unverified_user_login_auto_verifies_and_logs_in(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'unverified@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
            'status' => 'active',
        ]);

        $this->post(route('login.submit'), [
            'email' => 'unverified@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('welcome'));

        $this->assertAuthenticatedAs($user);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_unverified_institution_login_redirects_to_verification_notice(): void
    {
        $institution = User::factory()->unverified()->create([
            'email' => 'school@example.com',
            'password' => bcrypt('password123'),
            'role' => 'school',
            'status' => 'active',
        ]);

        $this->post(route('login.submit'), [
            'email' => 'school@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('verification.notice'));

        $this->assertAuthenticatedAs($institution);
    }

    public function test_signed_verification_link_marks_email_as_verified(): void
    {
        $user = User::factory()->unverified()->create(['role' => 'user', 'status' => 'active']);

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]);

        $this->actingAs($user)->get($url)
            ->assertRedirect(route('dashboard'));

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_unverified_user_can_request_a_new_verification_email(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create(['role' => 'user', 'status' => 'active']);

        $this->actingAs($user)->post(route('verification.send'))
            ->assertSessionHas('status');

        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    public function test_approved_institution_receives_verification_email(): void
    {
        Notification::fake();

        $admin = User::factory()->create([
            'email' => User::ADMIN_EMAIL,
            'role' => 'super_admin',
            'status' => 'active',
        ]);
        $institution = User::factory()->unverified()->create([
            'role' => 'school',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.verification.approve', $institution->id))
            ->assertSessionHas('success');

        Notification::assertSentTo($institution, VerifyEmailNotification::class);
    }
}
