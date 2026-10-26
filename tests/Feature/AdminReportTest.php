<?php

namespace Tests\Feature;

use App\Models\ReportExport;
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

        $response = $this->actingAs($admin)->get(route('admin.reports.export', [
            'type' => 'users',
            'from' => '2026-01-01',
            'to' => '2026-12-31',
        ]));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Name,Email,Role,Status,Registered', $response->streamedContent());
        $this->assertStringContainsString('"CSV User",csv@example.com', $response->streamedContent());

        $this->assertDatabaseHas('report_exports', [
            'user_id' => $admin->id,
            'type' => 'users',
            'format' => 'csv',
            'period_from' => '2026-01-01',
            'period_to' => '2026-12-31',
            'rows_count' => 2,
        ]);
    }

    public function test_admin_can_view_export_history(): void
    {
        $admin = $this->admin();
        ReportExport::create([
            'user_id' => $admin->id,
            'type' => 'users',
            'format' => 'pdf',
            'rows_count' => 12,
            'file_name' => 'user-growth-20261026-120000.pdf',
        ]);

        $this->actingAs($admin)->get(route('admin.reports.index'))
            ->assertOk()
            ->assertSee('Export History')
            ->assertSee('user-growth-20261026-120000.pdf')
            ->assertSee($admin->name);
    }

    public function test_admin_can_export_report_as_pdf(): void
    {
        $admin = $this->admin();
        User::factory()->create(['name' => 'PDF User']);

        $response = $this->actingAs($admin)->get(route('admin.reports.export.pdf', 'users'));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
        $this->assertDatabaseHas('report_exports', [
            'user_id' => $admin->id,
            'type' => 'users',
            'format' => 'pdf',
            'rows_count' => 2,
        ]);
    }

    public function test_admin_can_export_report_as_xlsx(): void
    {
        $admin = $this->admin();
        User::factory()->create(['name' => 'XLSX User']);

        $response = $this->actingAs($admin)->get(route('admin.reports.export.xlsx', 'users'));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->assertStringContainsString('.xlsx', $response->headers->get('content-disposition'));
        $this->assertStringStartsWith('PK', $response->streamedContent());
        $this->assertDatabaseHas('report_exports', [
            'user_id' => $admin->id,
            'type' => 'users',
            'format' => 'xlsx',
            'rows_count' => 2,
        ]);
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
