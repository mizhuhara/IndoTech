<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
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

    public function test_admin_dashboard_renders_with_navbar_breadcrumbs_and_title(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Home');
        $response->assertSee('Main Dashboard');
        $response->assertSee('Overview of platform data and verification requests.');
        $response->assertViewHasAll(['stats', 'lineChartMonths', 'lineChartPoints', 'regions', 'recentRequests']);
    }

    public function test_admin_dashboard_displays_real_database_records(): void
    {
        $candidateUser = User::factory()->create([
            'name' => 'PT Karya Digital Indonesia',
            'role' => 'company',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('PT Karya Digital Indonesia');
        $response->assertSee('Company');
        $response->assertSee('Pending');
        $response->assertSee('New User Statistics');
        $response->assertSee('Distribusi Berdasarkan Daerah');
    }
}
