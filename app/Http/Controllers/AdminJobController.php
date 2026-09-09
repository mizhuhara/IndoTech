<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminJobController extends Controller
{
    /**
     * Display a listing of jobs.
     */
    public function index(Request $request): View
    {
        $query = JobListing::query();

        // Tab filter (all, active, drafts, closed)
        $tab = $request->query('tab', 'all');
        if ($tab === 'active') {
            $query->where('tab_status', 'active');
        } elseif ($tab === 'drafts') {
            $query->where('tab_status', 'drafts');
        } elseif ($tab === 'closed') {
            $query->where('tab_status', 'closed');
        }

        // Status filter
        if ($request->filled('status') && $request->query('status') !== 'all') {
            $query->where('status', $request->query('status'));
        }

        // Job Type filter
        if ($request->filled('type') && $request->query('type') !== 'all') {
            $query->where('type', 'like', "%{$request->query('type')}%");
        }

        // Department filter
        if ($request->filled('department') && $request->query('department') !== 'all') {
            $query->where('department', 'like', "%{$request->query('department')}%");
        }

        // Search query filter
        if ($request->filled('search')) {
            $search = trim($request->query('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $paginatedJobs = $query->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $totalPostings = number_format(JobListing::count());
        $activeJobs = number_format(JobListing::where('tab_status', 'active')->count());
        $applicationsCount = number_format(JobListing::sum('applicants_count'));

        $hasActiveFilter = ($request->filled('status') && $request->query('status') !== 'all') ||
                           ($request->filled('type') && $request->query('type') !== 'all') ||
                           ($request->filled('department') && $request->query('department') !== 'all');

        return view('admin.jobs.index', [
            'jobs' => $paginatedJobs,
            'currentTab' => $tab,
            'totalPostings' => $totalPostings,
            'activeJobs' => $activeJobs,
            'applicationsCount' => $applicationsCount,
            'search' => $request->query('search', ''),
            'status' => $request->query('status', 'all'),
            'type' => $request->query('type', 'all'),
            'department' => $request->query('department', 'all'),
            'hasActiveFilter' => $hasActiveFilter,
        ]);
    }

    /**
     * Export job listings to Excel-compatible CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = JobListing::query();

        $tab = $request->query('tab', 'all');
        if ($tab === 'active') {
            $query->where('tab_status', 'active');
        } elseif ($tab === 'drafts') {
            $query->where('tab_status', 'drafts');
        } elseif ($tab === 'closed') {
            $query->where('tab_status', 'closed');
        }

        if ($request->filled('status') && $request->query('status') !== 'all') {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('type') && $request->query('type') !== 'all') {
            $query->where('type', 'like', "%{$request->query('type')}%");
        }

        if ($request->filled('department') && $request->query('department') !== 'all') {
            $query->where('department', 'like', "%{$request->query('department')}%");
        }

        if ($request->filled('search')) {
            $search = trim($request->query('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->orderByDesc('id')->get();
        $filename = 'jobs_export_'.date('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($jobs) {
            $output = fopen('php://output', 'w');

            // UTF-8 BOM for Microsoft Excel compatibility
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($output, [
                'ID / Kode',
                'Judul Pekerjaan',
                'Perusahaan',
                'Departemen',
                'Tipe Pekerjaan',
                'Pengalaman',
                'Rentang Gaji',
                'Lokasi',
                'Status',
                'Jumlah Pelamar',
                'Total Dilihat',
                'Tanggal Diposting',
                'Tanggal Dibuat',
            ]);

            foreach ($jobs as $job) {
                fputcsv($output, [
                    $job->code ?? ('JOB-'.$job->id),
                    $job->title,
                    $job->company,
                    $job->department,
                    $job->type,
                    $job->experience ?? '-',
                    $job->salary_range ?? '-',
                    $job->location,
                    $job->status,
                    $job->applicants_count ?? 0,
                    $job->total_views ?? 0,
                    $job->date_posted,
                    $job->created_at ? $job->created_at->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    /**
     * Show form for creating a job posting.
     */
    public function create(): View
    {
        return view('admin.jobs.create');
    }

    /**
     * Store new job posting in MySQL.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'experience' => ['nullable', 'string', 'max:100'],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable'],
            'image' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'logo_url' => ['nullable', 'string', 'max:500'],
            'logo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $isActive = $request->boolean('is_active', true);
        $status = $isActive ? 'Active' : 'Draft';
        $tabStatus = $isActive ? 'active' : 'drafts';

        // Process image and logo
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('jobs', 'public');
            $imageUrl = Storage::url($path);
        } else {
            $imageUrl = $validated['image'] ?? null;
        }

        if ($request->hasFile('logo_file')) {
            $logoPath = $request->file('logo_file')->store('jobs/logos', 'public');
            $logoUrl = Storage::url($logoPath);
        } else {
            $logoUrl = $validated['logo_url'] ?? $imageUrl;
        }

        if (empty($imageUrl) && ! empty($logoUrl)) {
            $imageUrl = $logoUrl;
        }

        if (empty($logoUrl) && ! empty($imageUrl)) {
            $logoUrl = $imageUrl;
        }

        $job = JobListing::create([
            'title' => $validated['title'],
            'department' => $validated['department'],
            'type' => $validated['type'],
            'category' => $validated['category'] ?? null,
            'experience' => $validated['experience'] ?? 'Mid',
            'salary_range' => $validated['salary_range'] ?? null,
            'description' => $validated['description'],
            'requirements' => $validated['requirements'] ?? null,
            'company' => $validated['company'],
            'location' => $validated['location'],
            'location_full' => $validated['location'],
            'company_size' => $validated['company_size'],
            'image' => $imageUrl,
            'logo_url' => $logoUrl,
            'status' => $status,
            'tab_status' => $tabStatus,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', "Job posting \"{$job->title}\" berhasil dipublikasikan ke database!");
    }

    /**
     * Show detail of a job posting.
     */
    public function show(int $id): View
    {
        $job = JobListing::findOrFail($id);

        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Show edit form for job posting.
     */
    public function edit(int $id): View
    {
        $job = JobListing::findOrFail($id);

        return view('admin.jobs.edit', compact('job'));
    }

    /**
     * Update job posting in MySQL.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $job = JobListing::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'experience' => ['nullable', 'string', 'max:100'],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable'],
            'image' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'logo_url' => ['nullable', 'string', 'max:500'],
            'logo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $isActive = $request->boolean('is_active', false);
        $status = $isActive ? 'Active' : 'Draft';
        $tabStatus = $isActive ? 'active' : 'drafts';

        // Process image
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('jobs', 'public');
            $imageUrl = Storage::url($path);
            $logoUrl = $imageUrl;
        } elseif ($request->filled('image')) {
            $imageUrl = $validated['image'];
            $logoUrl = $imageUrl;
        } else {
            $imageUrl = $job->image;
            $logoUrl = $job->logo_url ?? $imageUrl;
        }

        // Process logo if explicitly uploaded
        if ($request->hasFile('logo_file')) {
            $logoPath = $request->file('logo_file')->store('jobs/logos', 'public');
            $logoUrl = Storage::url($logoPath);
        } elseif ($request->filled('logo_url')) {
            $logoUrl = $validated['logo_url'];
        }

        if (empty($imageUrl) && ! empty($logoUrl)) {
            $imageUrl = $logoUrl;
        }

        if (empty($logoUrl) && ! empty($imageUrl)) {
            $logoUrl = $imageUrl;
        }

        $job->update([
            'title' => $validated['title'],
            'department' => $validated['department'],
            'type' => $validated['type'],
            'category' => ! empty($validated['category']) ? $validated['category'] : $job->category,
            'experience' => ! empty($validated['experience']) ? $validated['experience'] : $job->experience,
            'salary_range' => $validated['salary_range'] ?? null,
            'description' => $validated['description'],
            'requirements' => $validated['requirements'] ?? null,
            'company' => $validated['company'],
            'location' => $validated['location'],
            'location_full' => $validated['location'],
            'company_size' => $validated['company_size'],
            'image' => $imageUrl,
            'logo_url' => $logoUrl,
            'status' => $status,
            'tab_status' => $tabStatus,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', "Job posting \"{$job->title}\" berhasil diperbarui di database.");
    }

    /**
     * Remove job posting from MySQL.
     */
    public function destroy(int $id): RedirectResponse
    {
        $job = JobListing::findOrFail($id);
        $title = $job->title;
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', "Job listing \"{$title}\" berhasil dihapus dari database.");
    }
}
