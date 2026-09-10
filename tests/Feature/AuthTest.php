<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout_and_is_redirected_to_welcome_page(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('welcome'));
    }

    public function test_admin_can_logout_and_is_redirected_to_welcome_page(): void
    {
        $admin = User::factory()->create([
            'email' => User::ADMIN_EMAIL,
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('welcome'));
    }

    public function test_normal_user_login_redirects_to_user_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
            'status' => 'active',
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard/user');
    }

    public function test_normal_user_accessing_dashboard_redirects_to_user_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('dashboard.user'));
    }

    public function test_school_login_redirects_to_school_dashboard(): void
    {
        $school = User::factory()->create([
            'email' => 'school@example.com',
            'password' => bcrypt('password123'),
            'role' => 'school',
            'status' => 'active',
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'school@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($school);
        $response->assertRedirect('/dashboard/school');
    }

    public function test_university_login_redirects_to_university_dashboard(): void
    {
        $university = User::factory()->create([
            'email' => 'univ@example.com',
            'password' => bcrypt('password123'),
            'role' => 'university',
            'status' => 'active',
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'univ@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($university);
        $response->assertRedirect('/dashboard/university');
    }

    public function test_company_login_redirects_to_company_dashboard(): void
    {
        $company = User::factory()->create([
            'email' => 'company@example.com',
            'password' => bcrypt('password123'),
            'role' => 'company',
            'status' => 'active',
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'company@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($company);
        $response->assertRedirect('/dashboard/company');
    }

    public function test_pending_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'pending@example.com',
            'password' => bcrypt('password123'),
            'role' => 'school',
            'status' => 'pending',
        ]);

        $response = $this->post(route('login.submit'), [
            'email' => 'pending@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }
}
