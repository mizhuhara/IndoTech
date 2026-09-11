<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\JobListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function apply(int $id): View
    {
        // Try to find in Internship model first
        $job = Internship::find($id);

        // If not found, try JobListing model
        if (! $job) {
            $job = JobListing::findOrFail($id);
        }

        // Only increment views if JobListing (Internship doesn't track views)
        if ($job instanceof JobListing) {
            $job->increment('total_views');
        }

        return view('career.apply', compact('job'));
    }

    public function storeApplication(Request $request, int $id): RedirectResponse
    {
        // Try to find in Internship model first
        $job = Internship::find($id);

        // If not found, try JobListing model
        if (! $job) {
            $job = JobListing::findOrFail($id);
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'linkedin' => ['nullable', 'url', 'max:200'],
            'portfolio' => ['nullable', 'url', 'max:200'],
            'cover_letter' => ['required', 'string', 'min:50', 'max:3000'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        // Only increment applicants if JobListing
        if ($job instanceof JobListing) {
            $job->increment('applicants_count');
        }

        return redirect()
            ->route('career.index', ['type' => $job->category])
            ->with('apply_success', "Lamaran kamu untuk \"{$job->title}\" di {$job->company} berhasil dikirim!");
    }
}
