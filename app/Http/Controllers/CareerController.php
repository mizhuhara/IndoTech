<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\JobApplication;
use App\Models\JobListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('type', 'jobs');

        // If internship tab is selected, fetch from Internship model
        if ($tab === 'internship') {
            $jobs = $this->getInternships($request);
        } else {
            // Otherwise fetch from JobListing model
            $query = JobListing::query()
                ->where('is_active', true)
                ->where('status', '!=', 'Draft');

            if ($tab !== 'all' && $tab !== 'jobs') {
                $query->where('category', $tab);
            }

            if ($request->filled('job_type')) {
                $query->whereIn('type', (array) $request->query('job_type'));
            }

            if ($request->filled('experience')) {
                $query->whereIn('experience', (array) $request->query('experience'));
            }

            if ($request->filled('salary')) {
                $query->whereIn('salary_range', (array) $request->query('salary'));
            }

            if ($request->filled('q')) {
                $keyword = trim($request->query('q'));
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                        ->orWhere('company', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhere('location', 'like', "%{$keyword}%");
                });
            }

            if ($request->filled('skills')) {
                $skillFilters = (array) $request->query('skills');
                foreach ($skillFilters as $skill) {
                    $query->whereJsonContains('skills', $skill);
                }
            }

            $jobs = $query->orderByDesc('id')->get();
        }

        return view('career.index', [
            'jobs' => $jobs,
            'tab' => $tab,
            'tabs' => [
                'jobs' => 'Jobs',
                'internship' => 'Internship',
                'freelance' => 'Freelance',
                'remote' => 'Remote Work',
                'graduate' => 'Graduate Job',
            ],
            'jobTypes' => ['Full-time', 'Part-time', 'Contract', 'Internship'],
            'experienceLevels' => ['Entry', 'Mid', 'Senior'],
            'salaryRanges' => ['< 8jt', '8–15jt', '15–25jt', '25jt+'],
            'allSkills' => [
                'Laravel', 'PHP', 'React', 'Vue', 'JavaScript', 'TypeScript',
                'Python', 'Node.js', 'Go', 'Java', 'Spring Boot', 'UI/UX',
                'Figma', 'Tailwind', 'MySQL', 'PostgreSQL', 'Redis', 'Docker',
                'Kubernetes', 'AWS', 'GraphQL', 'REST API', 'Git', 'Flutter',
            ],
        ]);
    }

    private function getInternships(Request $request)
    {
        $query = Internship::where('status', 'active');

        if ($request->filled('q')) {
            $keyword = trim($request->query('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('company', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('location', 'like', "%{$keyword}%");
            });
        }

        return $query->orderByDesc('id')->get();
    }

    public function apply(string $type, int $id): View
    {
        $job = $this->resolveJob($type, $id);

        if ($job instanceof JobListing) {
            $job->increment('total_views');
        }

        return view('career.apply', [
            'job' => $job,
            'applyType' => $type,
        ]);
    }

    public function storeApplication(Request $request, string $type, int $id): RedirectResponse
    {
        $job = $this->resolveJob($type, $id);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'linkedin' => ['nullable', 'url', 'max:200'],
            'portfolio' => ['nullable', 'url', 'max:200'],
            'cover_letter' => ['required', 'string', 'min:50', 'max:3000'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'local');
        $userId = $request->user()?->id;

        try {
            DB::transaction(function () use ($job, $validated, $resumePath, $userId) {
                $application = JobApplication::create([
                    'job_listing_id' => $job instanceof JobListing ? $job->id : null,
                    'internship_id' => $job instanceof Internship ? $job->id : null,
                    'user_id' => $userId,
                    'full_name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'linkedin' => $validated['linkedin'] ?? null,
                    'portfolio' => $validated['portfolio'] ?? null,
                    'cover_letter' => $validated['cover_letter'],
                    'resume_path' => $resumePath,
                ]);

                $application->statusHistories()->create([
                    'status' => 'pending',
                    'note' => 'Lamaran dikirim.',
                ]);

                if ($job instanceof JobListing) {
                    $job->increment('applicants_count');
                }
            });
        } catch (\Throwable $exception) {
            Storage::disk('local')->delete($resumePath);

            throw $exception;
        }

        return redirect()
            ->route('career.index', ['type' => $job->category])
            ->with('apply_success', "Lamaran kamu untuk \"{$job->title}\" di {$job->company} berhasil dikirim!");
    }

    private function resolveJob(string $type, int $id): Internship|JobListing
    {
        if ($type === 'internship') {
            return Internship::where('status', 'active')->findOrFail($id);
        }

        if ($type === 'job') {
            return JobListing::where('is_active', true)
                ->where('status', '!=', 'Draft')
                ->findOrFail($id);
        }

        abort(404);
    }
}
