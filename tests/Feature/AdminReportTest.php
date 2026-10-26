<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_reports_index(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.reports.index'))
            ->assertOk()
            ->assertSee('User Growth')
            ->assertSee('Job Posting Analytics');
    }

    public function test_admin_can_view_report_detail(): void
    {
        $admin = $this->admin();
        $user = User::factory()->create(['name' => 'Reported User']);

        $this->actingAs($admin)->get(route('admin.reports.show', 'users'))
            ->assertOk()
            ->assertSee('Reported User')
            ->assertSee('Total Users')
            ->assertSee($user->email);
    }

    public function test_admin_can_export_report_as_csv(): void
    {
        $admin = $this->admin();
        User::factory()->create(['name' => 'CSV User', 'email' => 'csv@example.com']);

        $response = $this->actingAs($admin)->get(route('admin.reports.export', 'users'));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Name,Email,Role,Status,Registered', $response->streamedContent());
        $this->assertStringContainsString('"CSV User",csv@example.com', $response->streamedContent());
    }

    public function test_unknown_report_type_returns_not_found(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.reports.show', 'unknown'))
            ->assertNotFound();
    }

    public function test_non_admin_cannot_access_reports(): void
    {
        $user = User::factory()->create(['role' => 'user', 'status' => 'active']);

        $this->actingAs($user)->get(route('admin.reports.index'))->assertForbidden();
    }

    private function admin(): User
    {
        return User::factory()->create([
            'email' => User::ADMIN_EMAIL,
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }
}
