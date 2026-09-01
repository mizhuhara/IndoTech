<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class AdminInternshipController extends Controller
{
    /**
     * Data store for internship postings.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getInternshipsData(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'INT-4021',
                'title' => 'Full Stack Developer Intern',
                'company' => 'Gojek Tech',
                'company_industry' => 'Super App / Tech',
                'type' => 'Internship',
                'category' => 'Engineering',
                'department' => 'Engineering',
                'salary_range' => '4.000.000 - 6.000.000',
                'date_posted' => 'Oct 28, 2024',
                'status' => 'Active',
                'tab_status' => 'active',
                'location' => 'Jakarta (Hybrid)',
                'location_full' => 'Jakarta Selatan, DKI Jakarta',
                'company_size' => '1000+',
                'company_size_label' => '1000+ Employees',
                'tags' => ['Engineering', 'Go', 'React', 'Internship'],
                'description' => "Magang 6 bulan berbayar di Gojek Tech. Rotasi backend (Go, Kubernetes) dan frontend (React). Mentorship engineer senior, proyek nyata dari hari pertama, serta peluang konversi menjadi karyawan full-time.\n\nTerbuka untuk mahasiswa tingkat akhir atau fresh graduate dari jurusan Teknik Informatika, Ilmu Komputer, atau bidang terkait.",
                'requirements' => "- Mahasiswa aktif semester akhir atau fresh graduate S1 Computer Science / IT.\n- Menguasai dasar-dasar algoritma, React.js, dan Go / Python / Node.js.\n- Memahami Git version control dan RESTful API architecture.\n- Memiliki komitmen magang full-time minimal 6 bulan.",
                'total_views' => 124,
                'applicants_count' => 38,
                'logo_url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=200&h=200&fit=crop',
            ],
            [
                'id' => 2,
                'code' => 'INT-4020',
                'title' => 'Data Science Internship',
                'company' => 'Tokopedia Data Labs',
                'company_industry' => 'E-Commerce / Data',
                'type' => 'Internship',
                'category' => 'Data',
                'department' => 'Data',
                'salary_range' => '4.500.000 - 6.500.000',
                'date_posted' => 'Oct 26, 2024',
                'status' => 'Active',
                'tab_status' => 'active',
                'location' => 'Jakarta (Remote)',
                'location_full' => 'Jakarta Barat, DKI Jakarta',
                'company_size' => '1000+',
                'company_size_label' => '1000+ Employees',
                'tags' => ['Data Science', 'Python', 'SQL'],
                'description' => "Kerjakan recommendation system, demand forecasting, dan analisis perilaku user di Tokopedia Data Labs. Menggunakan Python, SQL, dan cloud ML platform.",
                'requirements' => "- Kuat di SQL, Python (Pandas, Scikit-Learn), dan statistik dasar.\n- Pengalaman dengan Machine Learning project atau Kaggle competition nilai plus.",
                'total_views' => 98,
                'applicants_count' => 29,
                'logo_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=200&h=200&fit=crop',
            ],
            [
                'id' => 3,
                'code' => 'INT-4015',
                'title' => 'UI/UX Design Intern',
                'company' => 'Ruangguru Studio',
                'company_industry' => 'EdTech',
                'type' => 'Internship',
                'category' => 'Design',
                'department' => 'Design',
                'salary_range' => '3.500.000 - 5.000.000',
                'date_posted' => 'Oct 22, 2024',
                'status' => 'Paused',
                'tab_status' => 'active',
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'location_full' => 'Jakarta Selatan, DKI Jakarta',
                'company_size' => '500-1000',
                'company_size_label' => '500-1000 Employees',
                'tags' => ['Design', 'Figma', 'UI/UX'],
                'description' => "Bantu tim produk Ruangguru mendesain antarmuka aplikasi mobile & web ed-tech generasi terbaru. Wireframing, prototyping, dan usability testing.",
                'requirements' => "- Mahasiswa/Fresh graduate Desain Komunikasi Visual atau sejenis.\n- Mahir Figma, wireframing, dan membuat interactive prototype.\n- Wajib melampirkan portofolio UX case study.",
                'total_views' => 86,
                'applicants_count' => 24,
                'logo_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=200&h=200&fit=crop',
            ],
            [
                'id' => 4,
                'code' => 'INT-4010',
                'title' => 'QA Engineer Intern',
                'company' => 'Traveloka Tech',
                'company_industry' => 'Travel & Fintech',
                'type' => 'Internship',
                'category' => 'Engineering',
                'department' => 'Engineering',
                'salary_range' => '4.000.000 - 5.500.000',
                'date_posted' => 'Oct 18, 2024',
                'status' => 'Active',
                'tab_status' => 'active',
                'location' => 'Jakarta Pusat, DKI Jakarta',
                'location_full' => 'Jakarta Pusat, DKI Jakarta',
                'company_size' => '500-1000',
                'company_size_label' => '500-1000 Employees',
                'tags' => ['QA', 'Testing', 'Automation'],
                'description' => "Magang Quality Assurance untuk pengujian otomatisasi web & mobile app Traveloka. Menulis test case, regresi otomatis, serta API testing.",
                'requirements' => "- Paham konsep Software Quality Assurance, SDLC, dan STLC.\n- Dasar pemrograman Cypress / Selenium / Postman nilai plus.",
                'total_views' => 74,
                'applicants_count' => 20,
                'logo_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=200&h=200&fit=crop',
            ],
            [
                'id' => 5,
                'code' => 'INT-4005',
                'title' => 'Content Marketing Intern',
                'company' => 'IndoTech Media',
                'company_industry' => 'Media / Community',
                'type' => 'Internship',
                'category' => 'Marketing',
                'department' => 'Marketing',
                'salary_range' => '3.000.000 - 4.500.000',
                'date_posted' => 'Oct 15, 2024',
                'status' => 'Draft',
                'tab_status' => 'drafts',
                'location' => 'Jakarta Selatan, DKI Jakarta',
                'location_full' => 'Jakarta Selatan, DKI Jakarta',
                'company_size' => '50-100',
                'company_size_label' => '50-100 Employees',
                'tags' => ['Marketing', 'Copywriting', 'Social Media'],
                'description' => "Draft program magang Content Marketing IndoTech Media. Mengelola konten sosial media, artikel blog, dan newsletter.",
                'requirements' => "- Tertarik di bidang media digital dan ed-tech.\n- Kemampuan riset dan copywriting yang baik.",
                'total_views' => 0,
                'applicants_count' => 0,
                'logo_url' => 'https://images.unsplash.com/photo-1557838923-2985c318be48?w=200&h=200&fit=crop',
            ],
            [
                'id' => 6,
                'code' => 'INT-4001',
                'title' => 'Cybersecurity Intern',
                'company' => 'Bank BCA Tech',
                'company_industry' => 'Banking / IT',
                'type' => 'Internship',
                'category' => 'Engineering',
                'department' => 'Engineering',
                'salary_range' => '5.000.000 - 7.000.000',
                'date_posted' => 'Oct 10, 2024',
                'status' => 'Closed',
                'tab_status' => 'closed',
                'location' => 'Jakarta Pusat, DKI Jakarta',
                'location_full' => 'Jakarta Pusat, DKI Jakarta',
                'company_size' => '1000+',
                'company_size_label' => '1000+ Employees',
                'tags' => ['Cybersecurity', 'Security', 'Closed'],
                'description' => "Closed listing magang Cybersecurity di Bank BCA Tech. Analisis kerentanan, vulnerability assessment, dan monitoring log keamanan.",
                'requirements' => "- Pemahaman dasar jaringan komputer, Linux security, dan OWASP Top 10.",
                'total_views' => 140,
                'applicants_count' => 45,
                'logo_url' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=200&h=200&fit=crop',
            ],
        ];
    }

    /**
     * Display a listing of internships.
     */
    public function index(Request $request): View
    {
        $allInternships = collect($this->getInternshipsData());

        $tab = $request->query('tab', 'all');
        $internships = $allInternships;

        if ($tab === 'active') {
            $internships = $internships->where('tab_status', 'active');
        } elseif ($tab === 'drafts') {
            $internships = $internships->where('tab_status', 'drafts');
        } elseif ($tab === 'closed') {
            $internships = $internships->where('tab_status', 'closed');
        }

        if ($request->filled('search')) {
            $search = strtolower($request->query('search'));
            $internships = $internships->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['title']), $search)
                    || str_contains(strtolower($item['company']), $search)
                    || str_contains(strtolower($item['code']), $search)
                    || str_contains(strtolower($item['type']), $search);
            });
        }

        $perPage = 10;
        $page = (int) $request->input('page', 1);
        $total = $internships->count();
        $offset = ($page - 1) * $perPage;
        $items = $internships->slice($offset, $perPage)->values();

        $paginatedInternships = new LengthAwarePaginator(
            $items,
            $total > 0 ? $total : 1850,
            $perPage,
            $page,
            ['path' => route('admin.internships.index'), 'query' => $request->query()]
        );

        $totalPostings = '1,850';
        $activeInternships = '1,240';
        $applicationsCount = '7,890';

        return view('admin.internship.index', [
            'internships' => $paginatedInternships,
            'currentTab' => $tab,
            'totalPostings' => $totalPostings,
            'activeInternships' => $activeInternships,
            'applicationsCount' => $applicationsCount,
            'search' => $request->query('search', ''),
        ]);
    }

    /**
     * Show form for creating an internship posting.
     */
    public function create(): View
    {
        return view('admin.internship.create');
    }

    /**
     * Store new internship posting (stub).
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

        return redirect()->route('admin.internships.index')
            ->with('success', "Internship posting \"{$request->input('title')}\" berhasil dipublikasikan!");
    }

    /**
     * Show detail of an internship posting.
     */
    public function show(int $id): View
    {
        $internship = collect($this->getInternshipsData())->firstWhere('id', $id);

        if (! $internship) {
            $internship = $this->getInternshipsData()[0];
        }

        return view('admin.internship.show', compact('internship'));
    }

    /**
     * Show edit form for internship posting.
     */
    public function edit(int $id): View
    {
        $internship = collect($this->getInternshipsData())->firstWhere('id', $id);

        if (! $internship) {
            $internship = $this->getInternshipsData()[0];
        }

        return view('admin.internship.edit', compact('internship'));
    }

    /**
     * Update internship posting (stub).
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

        return redirect()->route('admin.internships.index')
            ->with('success', "Internship posting \"{$request->input('title')}\" berhasil diperbarui.");
    }

    /**
     * Remove internship posting (stub).
     */
    public function destroy(int $id): RedirectResponse
    {
        $internship = collect($this->getInternshipsData())->firstWhere('id', $id);
        $title = $internship ? $internship['title'] : 'Internship Posting';

        return redirect()->route('admin.internships.index')
            ->with('success', "Internship listing \"{$title}\" berhasil dihapus.");
    }
}
