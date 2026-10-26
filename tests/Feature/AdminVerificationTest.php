<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => User::ADMIN_EMAIL,
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }

    public function test_admin_can_view_verification_requests_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.verification.index'));

        $response->assertStatus(200);
        $response->assertSee('Verification Request');
    }

    public function test_admin_can_approve_verification_request(): void
    {
        $user = User::factory()->create([
            'name' => 'SMK IT Nusantara',
            'role' => 'school',
            'status' => 'pending',
            'org_contact' => 'Drs. Supriyadi',
            'org_phone' => '081234567890',
        ]);

        School::create([
            'user_id' => $user->id,
            'npsn' => 'BF-TEST-1',
            'name' => $user->name,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.verification.approve', $user->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('schools', [
            'user_id' => $user->id,
            'status' => 'Active',
        ]);
    }

    public function test_admin_can_reject_verification_request(): void
    {
        $user = User::factory()->create([
            'name' => 'PT Fake Corp',
            'role' => 'company',
            'status' => 'pending',
            'org_contact' => 'Budi Sudarsono',
        ]);

        Company::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.verification.reject', $user->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'rejected',
        ]);
        $this->assertDatabaseHas('companies', [
            'user_id' => $user->id,
            'status' => 'Inactive',
        ]);
    }

    public function test_admin_can_delete_verification_request(): void
    {
        $user = User::factory()->create([
            'name' => 'Universitas Indonesia Sub',
            'role' => 'university',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.verification.destroy', $user->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
