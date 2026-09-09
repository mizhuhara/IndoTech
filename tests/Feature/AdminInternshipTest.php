<?php

namespace Tests\Feature;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminInternshipTest extends TestCase
{
    use RefreshDatabase;

    private function createAdminUser(): User
    {
        return User::factory()->create([
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }

    public function test_admin_can_view_internships_index_page(): void
    {
        $admin = $this->createAdminUser();
        Internship::create([
            'user_id' => $admin->id,
            'title' => 'Software Engineer Intern',
            'company' => 'IndoTech Corp',
            'location' => 'Jakarta',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.internships.index'));

        $response->assertStatus(200);
        $response->assertSee('Internship Management');
        $response->assertSee('Software Engineer Intern');
        $response->assertSee(route('admin.internships.create'));
    }

    public function test_admin_can_view_internship_create_page(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get(route('admin.internships.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Lowongan Internship Baru');
        $response->assertSee('Simpan & Publikasikan', false);
    }

    public function test_admin_can_store_a_new_internship(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->post(route('admin.internships.store'), [
            'user_id' => $admin->id,
            'title' => 'Mobile Developer Intern',
            'company' => 'PT IndoTech Kreatif',
            'description' => 'Membangun aplikasi mobile Flutter.',
            'location' => 'Bandung, Jawa Barat',
            'status' => 'active',
            'start_date' => '2026-10-01',
            'end_date' => '2027-01-01',
        ]);

        $response->assertRedirect(route('admin.internships.index'));
        $this->assertDatabaseHas('internships', [
            'title' => 'Mobile Developer Intern',
            'company' => 'PT IndoTech Kreatif',
            'location' => 'Bandung, Jawa Barat',
            'status' => 'active',
        ]);
    }
}
