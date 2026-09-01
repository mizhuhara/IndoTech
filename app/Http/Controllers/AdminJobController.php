<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class AdminJobController extends Controller
{
    /**
     * Data store for job postings.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getJobsData(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'JOB-8921',
                'title' => 'Senior Frontend Engineer',
                'company' => 'TechFlow Systems',
                'company_industry' => 'Enterprise Software',
                'type' => 'Full-Time',
                'category' => 'Engineering',
                'department' => 'Engineering',
                'salary_range' => '15.000.000 - 25.000.000',
                'date_posted' => 'Oct 28, 2024',
                'status' => 'Active',
                'tab_status' => 'active',
                'location' => 'Jakarta, Indonesia',
                'location_full' => 'Jakarta Selatan, DKI Jakarta',
                'company_size' => '201-500',
                'company_size_label' => '201-500 Employees',
                'tags' => ['Engineering', 'Remote', 'Full-time'],
                'description' => "TechFlow Systems is seeking a highly skilled Senior Frontend Engineer to lead the development of our next-generation enterprise SaaS platform. In this role, you will be instrumental in architectural decisions, guiding a talented team of developers, and ensuring the delivery of performant, accessible, and scalable user interfaces.\n\nYou will collaborate closely with product managers, designers, and backend engineering teams to translate complex business requirements into intuitive and robust frontend solutions. Our stack relies heavily on modern React, TypeScript, and state-of-the-art build tools.",
                'requirements' => "- Minimum 5+ years of professional experience in frontend development, with a strong focus on single-page applications.\n- Expert proficiency in React, TypeScript, and modern JavaScript (ES6+).\n- Deep understanding of web performance optimization techniques and browser rendering critical paths.\n- Experience with state management libraries (e.g., Redux, Zustand) and complex data fetching patterns.\n- Strong communication skills in English and ability to mentor junior engineers.",
                'total_views' => 42,
                'applicants_count' => 12,
                'logo_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=200&h=200&fit=crop',
            ],
            [
                'id' => 2,
                'code' => 'JOB-8920',
                'title' => 'Backend Developer (Node.js)',
                'company' => 'Nexus Global',
                'company_industry' => 'Cloud Infrastructure',
                'type' => 'Contract',
                'category' => 'Engineering',
                'department' => 'Engineering',
                'salary_range' => '18.000.000 - 28.000.000',
                'date_posted' => 'Oct 27, 2024',
                'status' => 'Active',
                'tab_status' => 'active',
                'location' => 'Bandung, Jawa Barat',
                'location_full' => 'Bandung, Jawa Barat',
                'company_size' => '51-200',
                'company_size_label' => '51-200 Employees',
                'tags' => ['Node.js', 'TypeScript', 'Contract'],
                'description' => "Nexus Global is looking for a Backend Developer (Node.js) to build high-performance microservices, REST APIs, and event-driven architecture.",
                'requirements' => "- 3+ years experience with Node.js, Express/NestJS.\n- Strong knowledge of PostgreSQL and Redis caching.\n- Hands-on experience with Docker & Kubernetes.",
                'total_views' => 68,
                'applicants_count' => 19,
                'logo_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=200&h=200&fit=crop',
            ],
            [
                'id' => 3,
                'code' => 'JOB-8915',
                'title' => 'Data Analyst Internship',
                'company' => 'IndoTech Internals',
                'company_industry' => 'EdTech / Media',
                'type' => 'Internship',
                'category' => 'Data',
                'department' => 'Data',
                'salary_range' => '4.000.000 - 6.000.000',
                'date_posted' => 'Oct 25, 2024',
                'status' => 'Paused',
                'tab_status' => 'active',
                'location' => 'Jakarta Pusat, DKI Jakarta',
                'location_full' => 'Jakarta Pusat, DKI Jakarta',
                'company_size' => '50-100',
                'company_size_label' => '50-100 Employees',
                'tags' => ['Data', 'Python', 'Internship'],
                'description' => "Join the IndoTech internal analytics team as a Data Analyst Intern. Perform exploratory data analysis, dashboard creation, and user metrics tracking.",
                'requirements' => "- Final year student or recent graduate in CS, Math, or Statistics.\n- Proficient in SQL, Python (Pandas), and Tableau or Power BI.\n- Strong analytical mindset.",
                'total_views' => 112,
                'applicants_count' => 34,
                'logo_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=200&h=200&fit=crop',
            ],
            [
                'id' => 4,
                'code' => 'JOB-8910',
                'title' => 'Product Manager',
                'company' => 'Tokopedia',
                'company_industry' => 'E-Commerce',
                'type' => 'Full-Time',
                'category' => 'Product',
                'department' => 'Product',
                'salary_range' => '20.000.000 - 35.000.000',
                'date_posted' => 'Oct 20, 2024',
                'status' => 'Active',
                'tab_status' => 'active',
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'location_full' => 'Jakarta Selatan, DKI Jakarta',
                'company_size' => '1000+',
                'company_size_label' => '1000+ Employees',
                'tags' => ['Product', 'Strategy', 'Full-time'],
                'description' => "Lead product strategy and roadmap execution for buyer experience at Tokopedia. Define feature specifications, measure KPI impact, and collaborate with engineering leads.",
                'requirements' => "- 4+ years in product management at a tech startup or enterprise.\n- Proven track record of launching successful consumer products.\n- Data-driven decision maker.",
                'total_views' => 155,
                'applicants_count' => 48,
                'logo_url' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=200&h=200&fit=crop',
            ],
            [
                'id' => 5,
                'code' => 'JOB-8902',
                'title' => 'UI/UX Designer',
                'company' => 'Bukalapak Design Studio',
                'company_industry' => 'Digital Tech',
                'type' => 'Full-Time',
                'category' => 'Design',
                'department' => 'Design',
                'salary_range' => '12.000.000 - 20.000.000',
                'date_posted' => 'Oct 15, 2024',
                'status' => 'Draft',
                'tab_status' => 'drafts',
                'location' => 'Jakarta Barat, DKI Jakarta',
                'location_full' => 'Jakarta Barat, DKI Jakarta',
                'company_size' => '500-1000',
                'company_size_label' => '500-1000 Employees',
                'tags' => ['Design', 'Figma', 'Draft'],
                'description' => "Draft posting for Senior UI/UX Designer role. Create interactive prototypes and design systems.",
                'requirements' => "- 3+ years experience with Figma, design tokens, and user testing.\n- Strong portfolio.",
                'total_views' => 0,
                'applicants_count' => 0,
                'logo_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=200&h=200&fit=crop',
            ],
            [
                'id' => 6,
                'code' => 'JOB-8890',
                'title' => 'DevOps Specialist',
                'company' => 'Midtrans Cloud',
                'company_industry' => 'Fintech',
                'type' => 'Full-Time',
                'category' => 'Engineering',
                'department' => 'Engineering',
                'salary_range' => '22.000.000 - 32.000.000',
                'date_posted' => 'Oct 10, 2024',
                'status' => 'Closed',
                'tab_status' => 'closed',
                'location' => 'Remote, Indonesia',
                'location_full' => 'Remote, Indonesia',
                'company_size' => '201-500',
                'company_size_label' => '201-500 Employees',
                'tags' => ['DevOps', 'AWS', 'Closed'],
                'description' => "Closed listing for DevOps Specialist to oversee CI/CD infrastructure and AWS deployment pipelines.",
                'requirements' => "- Terraform, Ansible, AWS Certified Solutions Architect.",
                'total_views' => 210,
                'applicants_count' => 64,
                'logo_url' => 'https://images.unsplash.com/photo-1518432031352-d6fc5c10da5a?w=200&h=200&fit=crop',
            ],
        ];
    }

    /**
     * Display a listing of jobs.
     */
    public function index(Request $request): View
    {
        $allJobs = collect($this->getJobsData());

        // Tab filter (all, active, drafts, closed)
        $tab = $request->query('tab', 'all');
        $jobs = $allJobs;

        if ($tab === 'active') {
            $jobs = $jobs->where('tab_status', 'active');
        } elseif ($tab === 'drafts') {
            $jobs = $jobs->where('tab_status', 'drafts');
        } elseif ($tab === 'closed') {
            $jobs = $jobs->where('tab_status', 'closed');
        }

        // Search query filter
        if ($request->filled('search')) {
            $search = strtolower($request->query('search'));
            $jobs = $jobs->filter(function ($j) use ($search) {
                return str_contains(strtolower($j['title']), $search)
                    || str_contains(strtolower($j['company']), $search)
                    || str_contains(strtolower($j['code']), $search)
                    || str_contains(strtolower($j['type']), $search);
            });
        }

        $perPage = 10;
        $page = (int) $request->input('page', 1);
        $total = $jobs->count();
        $offset = ($page - 1) * $perPage;
        $items = $jobs->slice($offset, $perPage)->values();

        $paginatedJobs = new LengthAwarePaginator(
            $items,
            $total > 0 ? $total : 4285,
            $perPage,
            $page,
            ['path' => route('admin.jobs.index'), 'query' => $request->query()]
        );

        $totalPostings = '4,285';
        $activeJobs = '3,102';
        $applicationsCount = '18,492';

        return view('admin.jobs.index', [
            'jobs' => $paginatedJobs,
            'currentTab' => $tab,
            'totalPostings' => $totalPostings,
            'activeJobs' => $activeJobs,
            'applicationsCount' => $applicationsCount,
            'search' => $request->query('search', ''),
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
     * Store new job posting (stub).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string'],
            'type' => ['required', 'string'],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string'],
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', "Job posting \"{$request->input('title')}\" berhasil dipublikasikan!");
    }

    /**
     * Show detail of a job posting.
     */
    public function show(int $id): View
    {
        $job = collect($this->getJobsData())->firstWhere('id', $id);

        if (! $job) {
            $job = $this->getJobsData()[0];
        }

        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Show edit form for job posting.
     */
    public function edit(int $id): View
    {
        $job = collect($this->getJobsData())->firstWhere('id', $id);

        if (! $job) {
            $job = $this->getJobsData()[0];
        }

        return view('admin.jobs.edit', compact('job'));
    }

    /**
     * Update job posting (stub).
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string'],
            'type' => ['required', 'string'],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'company_size' => ['required', 'string'],
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', "Job posting \"{$request->input('title')}\" berhasil diperbarui.");
    }

    /**
     * Remove job posting (stub).
     */
    public function destroy(int $id): RedirectResponse
    {
        $job = collect($this->getJobsData())->firstWhere('id', $id);
        $title = $job ? $job['title'] : 'Job Posting';

        return redirect()->route('admin.jobs.index')
            ->with('success', "Job listing \"{$title}\" berhasil dihapus.");
    }
}
