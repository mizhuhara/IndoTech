<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AdminUserTest extends TestCase
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

    public function test_admin_can_view_users_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('User Management');
    }

    public function test_admin_can_create_new_user(): void
    {
        $userData = [
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'school',
            'status' => 'active',
            '_token' => Session::token(),
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), $userData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'email' => 'budi.santoso@example.com',
            'role' => 'school',
        ]);
    }

    public function test_admin_can_update_existing_user(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old.email@example.com',
            'role' => 'user',
            'status' => 'pending',
        ]);

        $updateData = [
            'name' => 'New Name',
            'email' => 'new.email@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'role' => 'company',
            'status' => 'active',
            '_token' => Session::token(),
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $user->id), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new.email@example.com',
            'role' => 'company',
            'status' => 'active',
        ]);
    }

    public function test_admin_can_delete_user(): void
    {
        $user = User::factory()->create([
            'name' => 'User To Delete',
            'email' => 'delete.me@example.com',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $user->id), [
            '_token' => Session::token(),
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_regular_admin_cannot_create_super_admin(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Escalated User',
            'email' => 'escalated@example.com',
            'password' => 'secret123',
            'role' => 'super_admin',
            'status' => 'active',
            '_token' => Session::token(),
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseMissing('users', [
            'email' => 'escalated@example.com',
        ]);
    }

    public function test_regular_admin_cannot_update_super_admin(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $target = User::factory()->create([
            'name' => 'Protected Admin',
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $target->id), [
            'name' => 'Hacked',
            'email' => $target->email,
            'role' => 'super_admin',
            'status' => 'active',
            '_token' => Session::token(),
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'name' => 'Protected Admin',
        ]);
    }
}
