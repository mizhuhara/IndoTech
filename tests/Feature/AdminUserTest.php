<?php

namespace Tests\Feature;

use App\Models\Company;
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

    public function test_admin_can_toggle_hide_user(): void
    {
        $user = User::factory()->create([
            'name' => 'PT Member Expired',
            'role' => 'company',
            'status' => 'active',
        ]);

        Company::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'status' => 'Active',
        ]);

        // 1. Hide user
        $response = $this->actingAs($this->admin)->post(route('admin.users.toggle-hide', $user->id), [
            '_token' => Session::token(),
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'hidden',
        ]);
        $this->assertDatabaseHas('companies', [
            'user_id' => $user->id,
            'status' => 'Inactive',
        ]);

        // 2. Unhide user
        $responseUnhide = $this->actingAs($this->admin)->post(route('admin.users.toggle-hide', $user->id), [
            '_token' => Session::token(),
        ]);

        $responseUnhide->assertRedirect(route('admin.users.index'));
        $responseUnhide->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('companies', [
            'user_id' => $user->id,
            'status' => 'Active',
        ]);
    }

    public function test_admin_cannot_hide_self_or_super_admin(): void
    {
        // Cannot hide self
        $responseSelf = $this->actingAs($this->admin)->post(route('admin.users.toggle-hide', $this->admin->id), [
            '_token' => Session::token(),
        ]);

        $responseSelf->assertRedirect(route('admin.users.index'));
        $responseSelf->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'status' => 'active',
        ]);
    }

    public function test_admin_can_filter_users_by_role(): void
    {
        $regularUser = User::factory()->create([
            'name' => 'John Regular User',
            'email' => 'john.regular@example.com',
            'role' => 'user',
        ]);

        $schoolUser = User::factory()->create([
            'name' => 'SMK IT Developer',
            'email' => 'smkit@example.com',
            'role' => 'school',
        ]);

        $companyUser = User::factory()->create([
            'name' => 'PT Teknologi Unggul',
            'email' => 'company@example.com',
            'role' => 'company',
        ]);

        // Filter user biasa
        $resUser = $this->actingAs($this->admin)->get(route('admin.users.index', ['role' => 'user']));
        $resUser->assertOk();
        $resUser->assertSee($regularUser->name);
        $resUser->assertDontSee($schoolUser->name);
        $resUser->assertDontSee($companyUser->name);

        // Filter sekolah
        $resSchool = $this->actingAs($this->admin)->get(route('admin.users.index', ['role' => 'school']));
        $resSchool->assertOk();
        $resSchool->assertSee($schoolUser->name);
        $resSchool->assertDontSee($regularUser->name);
        $resSchool->assertDontSee($companyUser->name);

        // Filter company
        $resCompany = $this->actingAs($this->admin)->get(route('admin.users.index', ['role' => 'company']));
        $resCompany->assertOk();
        $resCompany->assertSee($companyUser->name);
        $resCompany->assertDontSee($regularUser->name);
        $resCompany->assertDontSee($schoolUser->name);
    }

    public function test_admin_can_sort_users(): void
    {
        $userA = User::factory()->create([
            'name' => 'Abby Anderson',
            'email' => 'abby@example.com',
            'role' => 'user',
        ]);

        $userZ = User::factory()->create([
            'name' => 'Zack Snyder',
            'email' => 'zack@example.com',
            'role' => 'user',
        ]);

        // Sort name A-Z
        $resAsc = $this->actingAs($this->admin)->get(route('admin.users.index', ['sort' => 'name_asc']));
        $resAsc->assertOk();
        $usersAsc = $resAsc->viewData('users');
        $this->assertSame($userA->name, $usersAsc->first()->name);

        // Sort name Z-A
        $resDesc = $this->actingAs($this->admin)->get(route('admin.users.index', ['sort' => 'name_desc']));
        $resDesc->assertOk();
        $usersDesc = $resDesc->viewData('users');
        $this->assertSame($userZ->name, $usersDesc->first()->name);
    }
}
