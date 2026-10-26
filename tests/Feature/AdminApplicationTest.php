<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminApplicationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => User::ADMIN_EMAIL,
            'role' => 'super_admin',
            'status' => 'active',
        ]);
    }

    public function test_admin_can_search_and_filter_applications(): void
    {
        $job = $this->job();
        $this->application($job, [
            'full_name' => 'Ayu Pending',
            'email' => 'ayu@example.com',
            'status' => 'pending',
        ]);
        $this->application($job, [
            'full_name' => 'Budi Shortlisted',
            'email' => 'budi@example.com',
            'status' => 'shortlisted',
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.applications.index', ['q' => 'Ayu']))
            ->assertOk()
            ->assertSee('Ayu Pending')
            ->assertDontSee('Budi Shortlisted');

        $this->actingAs($this->admin)
            ->get(route('admin.applications.index', ['status' => 'shortlisted']))
            ->assertOk()
            ->assertSee('Budi Shortlisted')
            ->assertDontSee('Ayu Pending');
    }

    public function test_admin_can_download_application_resume(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('resumes/test.pdf', 'resume content');

        $application = $this->application($this->job());

        $response = $this->actingAs($this->admin)
            ->get(route('admin.applications.resume', $application));

        $response->assertOk()->assertDownload('test.pdf');
        $this->assertSame('resume content', $response->streamedContent());
    }

    public function test_missing_resume_returns_not_found(): void
    {
        Storage::fake('local');

        $application = $this->application($this->job(), [
            'resume_path' => 'resumes/missing.pdf',
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.applications.resume', $application))
            ->assertNotFound();
    }

    public function test_admin_can_delete_application_and_resume(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('resumes/test.pdf', 'resume content');

        $application = $this->application($this->job());
        $application->statusHistories()->create([
            'status' => 'pending',
            'note' => 'Lamaran dikirim.',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.applications.destroy', $application))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('job_applications', ['id' => $application->id]);
        $this->assertDatabaseMissing('job_application_status_histories', [
            'job_application_id' => $application->id,
        ]);
        Storage::disk('local')->assertMissing('resumes/test.pdf');
    }

    public function test_non_admin_cannot_access_application_management(): void
    {
        $user = User::factory()->create(['role' => 'user', 'status' => 'active']);

        $this->actingAs($user)
            ->get(route('admin.applications.index'))
            ->assertForbidden();
    }

    private function job(array $attributes = []): JobListing
    {
        return JobListing::create(array_merge([
            'title' => 'Software Engineer',
            'department' => 'Engineering',
            'type' => 'Full-time',
            'category' => 'jobs',
            'experience' => 'Mid',
            'description' => 'Test job description.',
            'company' => 'IndoTech Corp',
            'location' => 'Jakarta, Indonesia',
            'company_size' => '51-200 Employees',
            'is_active' => true,
            'status' => 'Active',
            'tab_status' => 'active',
        ], $attributes));
    }

    private function application(JobListing $job, array $attributes = []): JobApplication
    {
        return JobApplication::create(array_merge([
            'job_listing_id' => $job->id,
            'full_name' => 'Applicant',
            'email' => 'applicant@example.com',
            'phone' => '081234567890',
            'cover_letter' => 'Saya tertarik dengan posisi ini.',
            'resume_path' => 'resumes/test.pdf',
            'status' => 'pending',
        ], $attributes));
    }
}
