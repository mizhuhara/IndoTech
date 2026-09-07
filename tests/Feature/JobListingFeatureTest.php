<?php

namespace Tests\Feature;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class JobListingFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function createAdminUser(): User
    {
        return User::factory()->create([
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }

    private function createSampleJob(array $attributes = []): JobListing
    {
        return JobListing::create(array_merge([
            'title' => 'Software Engineer',
            'department' => 'Engineering',
            'type' => 'Full-time',
            'category' => 'jobs',
            'experience' => 'Mid',
            'salary_range' => '15.000.000 - 20.000.000',
            'description' => 'Test job description.',
            'company' => 'IndoTech Corp',
            'location' => 'Jakarta, Indonesia',
            'company_size' => '51-200 Employees',
            'is_active' => true,
            'status' => 'Active',
            'tab_status' => 'active',
        ], $attributes));
    }

    public function test_admin_jobs_index_page_can_be_rendered(): void
    {
        $admin = $this->createAdminUser();
        $this->createSampleJob();

        $response = $this->actingAs($admin)->get(route('admin.jobs.index'));

        $response->assertStatus(200);
        $response->assertSee('Job Management');
        $response->assertSee('ALL JOBS');
    }

    public function test_admin_can_create_a_job_posting(): void
    {
        $admin = $this->createAdminUser();

        $payload = [
            'title' => 'Software Architect Feature Test',
            'department' => 'Engineering',
            'type' => 'Full-time',
            'category' => 'jobs',
            'experience' => 'Senior',
            'salary_range' => '30.000.000 - 45.000.000',
            'description' => 'Architecting high-scale enterprise systems.',
            'requirements' => '10+ years in software engineering.',
            'company' => 'IndoTech Test Labs',
            'location' => 'Jakarta, Indonesia',
            'company_size' => '201-500 Employees',
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('admin.jobs.store'), $payload);

        $response->assertRedirect(route('admin.jobs.index'));
        $this->assertDatabaseHas('job_listings', [
            'title' => 'Software Architect Feature Test',
            'company' => 'IndoTech Test Labs',
        ]);
    }

    public function test_admin_can_update_a_job_posting(): void
    {
        $admin = $this->createAdminUser();
        $job = $this->createSampleJob();

        $response = $this->actingAs($admin)->put(route('admin.jobs.update', $job->id), [
            'title' => 'Lead Software Architect Updated',
            'department' => 'Engineering',
            'type' => 'Full-time',
            'category' => 'jobs',
            'experience' => 'Senior',
            'salary_range' => '35.000.000 - 50.000.000',
            'description' => 'Updated description.',
            'company' => 'IndoTech Test Labs',
            'location' => 'Jakarta, Indonesia',
            'company_size' => '201-500 Employees',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.jobs.index'));
        $this->assertDatabaseHas('job_listings', [
            'id' => $job->id,
            'title' => 'Lead Software Architect Updated',
        ]);
    }

    public function test_admin_can_view_job_detail(): void
    {
        $admin = $this->createAdminUser();
        $job = $this->createSampleJob(['title' => 'Product Designer Specialist']);

        $response = $this->actingAs($admin)->get(route('admin.jobs.show', $job->id));

        $response->assertStatus(200);
        $response->assertSee('Product Designer Specialist');
    }

    public function test_career_index_page_displays_jobs(): void
    {
        $this->createSampleJob(['title' => 'Career Showcase Engineer']);

        $response = $this->get(route('career.index'));

        $response->assertStatus(200);
        $response->assertSee('Career Showcase Engineer');
    }

    public function test_career_apply_increments_applicants_count(): void
    {
        $job = $this->createSampleJob();
        $initialApplicants = $job->applicants_count;

        $response = $this->post(route('career.apply.store', $job->id), [
            'full_name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'phone' => '081234567890',
            'cover_letter' => 'Saya sangat tertarik untuk melamar posisi ini karena memiliki pengalaman relevan yang kuat selama lebih dari lima tahun.',
            'resume' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect();
        $this->assertEquals($initialApplicants + 1, $job->fresh()->applicants_count);
    }

    public function test_admin_can_delete_a_job_posting(): void
    {
        $admin = $this->createAdminUser();
        $job = $this->createSampleJob();
        $id = $job->id;

        $response = $this->actingAs($admin)->delete(route('admin.jobs.destroy', $id));

        $response->assertRedirect(route('admin.jobs.index'));
        $this->assertDatabaseMissing('job_listings', ['id' => $id]);
    }
}
