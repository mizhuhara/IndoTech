<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\User;
use App\Notifications\ApplicationStatusUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplicationTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_submission_links_application_to_user_and_creates_history(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $job = $this->createJob();

        $this->actingAs($user)->post(route('career.apply.store', ['type' => 'job', 'id' => $job->id]), [
            'full_name' => $user->name,
            'email' => $user->email,
            'phone' => '081234567890',
            'cover_letter' => 'Saya tertarik dengan posisi ini dan memiliki pengalaman yang relevan untuk tim Anda.',
            'resume' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
        ])->assertSessionHas('apply_success');

        $application = JobApplication::firstOrFail();

        $this->assertSame($user->id, $application->user_id);
        $this->assertDatabaseHas('job_application_status_histories', [
            'job_application_id' => $application->id,
            'status' => 'pending',
            'note' => 'Lamaran dikirim.',
        ]);
    }

    public function test_guest_is_redirected_from_application_tracking_page(): void
    {
        $this->get(route('applications.index'))->assertRedirect(route('login'));
    }

    public function test_user_only_sees_own_applications(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $visibleJob = $this->createJob(['title' => 'Visible Backend Role']);
        $hiddenJob = $this->createJob(['title' => 'Hidden Frontend Role']);

        $visible = $this->makeApplication($user, $visibleJob);
        $visible->statusHistories()->create([
            'status' => 'reviewed',
            'note' => 'Catatan tracking terlihat.',
        ]);
        $this->makeApplication($otherUser, $hiddenJob);

        $this->actingAs($user)->get(route('applications.index'))
            ->assertOk()
            ->assertSee('Visible Backend Role')
            ->assertSee('Catatan tracking terlihat.')
            ->assertDontSee('Hidden Frontend Role');
    }

    public function test_admin_status_update_creates_history_and_notifies_user(): void
    {
        Notification::fake();
        $admin = User::factory()->create(['role' => 'super_admin', 'status' => 'active']);
        $user = User::factory()->create();
        $application = $this->makeApplication($user, $this->createJob());

        $this->actingAs($admin)->patch(route('admin.applications.update', $application), [
            'status' => 'shortlisted',
            'note' => 'Silakan siapkan jadwal wawancara.',
        ])->assertSessionHas('success');

        $this->assertSame('shortlisted', $application->refresh()->status);
        $this->assertDatabaseHas('job_application_status_histories', [
            'job_application_id' => $application->id,
            'status' => 'shortlisted',
            'note' => 'Silakan siapkan jadwal wawancara.',
            'changed_by' => $admin->id,
        ]);
        Notification::assertSentTo($user, ApplicationStatusUpdated::class);
    }

    public function test_admin_note_without_status_change_is_recorded(): void
    {
        Notification::fake();
        $admin = User::factory()->create(['role' => 'super_admin', 'status' => 'active']);
        $user = User::factory()->create();
        $application = $this->makeApplication($user, $this->createJob());

        $this->actingAs($admin)->patch(route('admin.applications.update', $application), [
            'status' => 'pending',
            'note' => 'Dokumen tambahan diminta.',
        ]);

        $this->assertDatabaseHas('job_application_status_histories', [
            'job_application_id' => $application->id,
            'status' => 'pending',
            'note' => 'Dokumen tambahan diminta.',
        ]);
        Notification::assertSentTo($user, ApplicationStatusUpdated::class);
    }

    public function test_admin_update_without_changes_creates_no_history_or_notification(): void
    {
        Notification::fake();
        $admin = User::factory()->create(['role' => 'super_admin', 'status' => 'active']);
        $user = User::factory()->create();
        $application = $this->makeApplication($user, $this->createJob());

        $this->actingAs($admin)->patch(route('admin.applications.update', $application), [
            'status' => 'pending',
            'note' => '',
        ]);

        $this->assertDatabaseCount('job_application_status_histories', 0);
        Notification::assertNothingSent();
    }

    private function createJob(array $attributes = []): JobListing
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

    private function makeApplication(User $user, JobListing $job, array $attributes = []): JobApplication
    {
        return JobApplication::create(array_merge([
            'job_listing_id' => $job->id,
            'user_id' => $user->id,
            'full_name' => $user->name,
            'email' => $user->email,
            'phone' => '081234567890',
            'cover_letter' => 'Saya tertarik dengan posisi ini.',
            'resume_path' => 'resumes/test.pdf',
            'status' => 'pending',
        ], $attributes));
    }
}
