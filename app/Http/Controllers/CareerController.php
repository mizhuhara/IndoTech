<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $filteredJobs = collect($this->jobs());

        $tab = $request->query('type', 'jobs');
        if ($tab !== 'all') {
            $filteredJobs = $filteredJobs->where('category', $tab);
        }

        if ($request->filled('job_type')) {
            $filteredJobs = $filteredJobs->whereIn('job_type', (array) $request->query('job_type'));
        }

        if ($request->filled('experience')) {
            $filteredJobs = $filteredJobs->whereIn('experience', (array) $request->query('experience'));
        }

        if ($request->filled('salary')) {
            $filteredJobs = $filteredJobs->whereIn('salary_range', (array) $request->query('salary'));
        }

        if ($request->filled('skills')) {
            $skillFilters = (array) $request->query('skills');
            $filteredJobs = $filteredJobs->filter(function ($job) use ($skillFilters) {
                return count(array_intersect($job['skills'], $skillFilters)) > 0;
            });
        }

        if ($request->filled('q')) {
            $keyword = strtolower($request->query('q'));
            $filteredJobs = $filteredJobs->filter(function ($job) use ($keyword) {
                return str_contains(strtolower($job['title']), $keyword)
                    || str_contains(strtolower($job['company']), $keyword)
                    || str_contains(strtolower($job['description']), $keyword)
                    || str_contains(strtolower($job['location']), $keyword);
            });
        }

        return view('career.index', [
            'jobs' => $filteredJobs->values()->all(),
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

    private function jobs(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Senior Backend Developer (Laravel)',
                'company' => 'Bukalapak',
                'category' => 'jobs',
                'job_type' => 'Full-time',
                'experience' => 'Senior',
                'salary_range' => '25jt+',
                'location' => 'Jakarta (Hybrid)',
                'skills' => ['Laravel', 'PHP', 'MySQL', 'Redis', 'Docker', 'AWS'],
                'description' => 'Senior Backend Developer untuk core platform. Desain API scalable, optimasi query, mentor junior. Stack: Laravel, PostgreSQL, Redis, Kafka, Kubernetes di AWS. Sistem high-traffic jutaan user per hari.',
                'deadline' => '15 Jan 2025',
                'status' => 'Open',
                'logo_color' => '#e60012',
                'logo_text' => 'BL',
                'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=400&h=200&fit=crop',
            ],
            [
                'id' => 2,
                'title' => 'Frontend Developer (React + TypeScript)',
                'company' => 'Traveloka',
                'category' => 'jobs',
                'job_type' => 'Full-time',
                'experience' => 'Mid',
                'salary_range' => '15–25jt',
                'location' => 'Jakarta (On-site)',
                'skills' => ['React', 'TypeScript', 'Tailwind', 'GraphQL', 'Git'],
                'description' => 'Bangun pengalaman booking travel next-gen. React, TypeScript, GraphQL. Fokus performa, aksesibilitas, DX. Kolaborasi designer, PM, dan backend di squad lintas fungsi.',
                'deadline' => '20 Jan 2025',
                'status' => 'Open',
                'logo_color' => '#ff6b35',
                'logo_text' => 'TK',
                'image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=400&h=200&fit=crop',
            ],
            [
                'id' => 3,
                'title' => 'Full Stack Developer Intern',
                'company' => 'Gojek',
                'category' => 'internship',
                'job_type' => 'Internship',
                'experience' => 'Entry',
                'salary_range' => '< 8jt',
                'location' => 'Jakarta (Hybrid)',
                'skills' => ['Go', 'React', 'PostgreSQL', 'Kubernetes', 'Git'],
                'description' => 'Magang 6 bulan berbayar. Rotasi backend (Go, Kubernetes) dan frontend (React). Mentorship engineer senior. Proyek nyata dari hari pertama. Peluang konversi full-time. Terbuka untuk mahasiswa tingkat akhir atau fresh graduate.',
                'deadline' => '1 Feb 2025',
                'status' => 'Open',
                'logo_color' => '#00aa13',
                'logo_text' => 'GJ',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=200&fit=crop',
            ],
            [
                'id' => 4,
                'title' => 'Data Science Internship',
                'company' => 'Tokopedia',
                'category' => 'internship',
                'job_type' => 'Internship',
                'experience' => 'Entry',
                'salary_range' => '< 8jt',
                'location' => 'Jakarta (Remote)',
                'skills' => ['Python', 'PostgreSQL', 'Git'],
                'description' => 'Kerjakan recommendation system, demand forecasting, dan analisis perilaku user. Python, SQL, cloud ML. Kolaborasi data engineer dan product. Lingkungan belajar dengan tech talk dan hackathon mingguan.',
                'deadline' => '10 Feb 2025',
                'status' => 'Open',
                'logo_color' => '#007bff',
                'logo_text' => 'TP',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=200&fit=crop',
            ],
            [
                'id' => 5,
                'title' => 'Freelance Laravel Developer',
                'company' => 'Kredivo',
                'category' => 'freelance',
                'job_type' => 'Contract',
                'experience' => 'Mid',
                'salary_range' => '15–25jt',
                'location' => 'Remote (Indonesia)',
                'skills' => ['Laravel', 'PHP', 'MySQL', 'REST API', 'Docker', 'Git'],
                'description' => 'Kontrak 3 bulan: merchant dashboard baru. Laravel, Blade, Tailwind. Clean architecture, TDD. Jam fleksibel, sync mingguan. Rate 15–25jt/bulan. Minimal 3 tahun Laravel + portfolio.',
                'deadline' => '31 Jan 2025',
                'status' => 'Open',
                'logo_color' => '#7c3aed',
                'logo_text' => 'KD',
                'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=400&h=200&fit=crop',
            ],
            [
                'id' => 6,
                'title' => 'UI/UX Designer (Freelance)',
                'company' => 'Ruangguru',
                'category' => 'freelance',
                'job_type' => 'Contract',
                'experience' => 'Mid',
                'salary_range' => '8–15jt',
                'location' => 'Remote (Indonesia)',
                'skills' => ['Figma', 'UI/UX'],
                'description' => 'Desain fitur mobile app ed-tech. Wireframe, mockup high-fidelity, prototype interaktif. Usability testing. Kerja dengan PM dan engineer. Proyek 2 bulan, bisa diperpanjang. Portfolio wajib.',
                'deadline' => '15 Feb 2025',
                'status' => 'Open',
                'logo_color' => '#f97316',
                'logo_text' => 'RG',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=200&fit=crop',
            ],
            [
                'id' => 7,
                'title' => 'Remote Full Stack Engineer',
                'company' => 'Xendit',
                'category' => 'remote',
                'job_type' => 'Full-time',
                'experience' => 'Senior',
                'salary_range' => '25jt+',
                'location' => 'Fully Remote (Indonesia)',
                'skills' => ['Node.js', 'React', 'TypeScript', 'PostgreSQL', 'AWS', 'Kubernetes', 'GraphQL'],
                'description' => 'Posisi fully remote. Bangun payment infrastructure API se-SEA. Node.js, TypeScript, React, PostgreSQL, Kubernetes di AWS. Fokus kualitas kode, observability, security. Gaji kompetitif + equity. Budget home office.',
                'deadline' => '25 Jan 2025',
                'status' => 'Open',
                'logo_color' => '#06b6d4',
                'logo_text' => 'XD',
                'image' => 'https://images.unsplash.com/photo-1518432031352-d6fc5c10da5a?w=400&h=200&fit=crop',
            ],
            [
                'id' => 8,
                'title' => 'Remote DevOps Engineer',
                'company' => 'Midtrans',
                'category' => 'remote',
                'job_type' => 'Full-time',
                'experience' => 'Mid',
                'salary_range' => '15–25jt',
                'location' => 'Fully Remote (Indonesia)',
                'skills' => ['Docker', 'Kubernetes', 'AWS', 'Git'],
                'description' => 'Kelola cloud infrastructure payment gateway jutaan transaksi. IaC Terraform, CI/CD, monitoring Prometheus/Grafana. On-call rotation. Linux dan networking kuat. Sertifikasi AWS/CKAD plus.',
                'deadline' => '5 Feb 2025',
                'status' => 'Open',
                'logo_color' => '#10b981',
                'logo_text' => 'MT',
                'image' => 'https://images.unsplash.com/photo-1667372393119-4d4a4b5e8b0e?w=400&h=200&fit=crop',
            ],
            [
                'id' => 9,
                'title' => 'Graduate Software Engineer Program',
                'company' => 'Bank BCA',
                'category' => 'graduate',
                'job_type' => 'Full-time',
                'experience' => 'Entry',
                'salary_range' => '8–15jt',
                'location' => 'Jakarta (On-site)',
                'skills' => ['Java', 'Spring Boot', 'React', 'PostgreSQL', 'Docker'],
                'description' => 'Program graduate 18 bulan. Rotasi digital banking, core banking, data platform. Mentorship tech lead. Training teknis, leadership, proyek inovasi. Paket kompetitif. Terbuka untuk lulusan 2024/2025 CS atau terkait.',
                'deadline' => '1 Mar 2025',
                'status' => 'Open',
                'logo_color' => '#1e3a8a',
                'logo_text' => 'BCA',
                'image' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=400&h=200&fit=crop',
            ],
            [
                'id' => 10,
                'title' => 'Graduate Data Analyst',
                'company' => 'Shopee',
                'category' => 'graduate',
                'job_type' => 'Full-time',
                'experience' => 'Entry',
                'salary_range' => '8–15jt',
                'location' => 'Jakarta (Hybrid)',
                'skills' => ['Python', 'PostgreSQL', 'Git'],
                'description' => 'Graduate Data Program. Analitik e-commerce: akuisisi, retensi, GMV. Python, SQL, BigQuery. Rotasi marketplace, logistik, fintech. Kurikulum terstruktur. Performa tinggi bisa fast-track Data Scientist.',
                'deadline' => '15 Mar 2025',
                'status' => 'Open',
                'logo_color' => '#ee4d2d',
                'logo_text' => 'SP',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=200&fit=crop',
            ],
            [
                'id' => 11,
                'title' => 'Mobile Developer (Flutter) — Contract',
                'company' => 'DANA',
                'category' => 'freelance',
                'job_type' => 'Contract',
                'experience' => 'Mid',
                'salary_range' => '15–25jt',
                'location' => 'Remote (Indonesia)',
                'skills' => ['Flutter', 'REST API', 'Git'],
                'description' => 'Kontrak 6 bulan fitur super-app DANA. Flutter, Clean Architecture, BLoC. Testing unit/widget/integrasi. Code review. Jadwal fleksibel, deliverable bulanan. Wajib punya app di Play Store/App Store.',
                'deadline' => '20 Feb 2025',
                'status' => 'Open',
                'logo_color' => '#00bfa5',
                'logo_text' => 'DN',
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=400&h=200&fit=crop',
            ],
            [
                'id' => 12,
                'title' => 'QA Engineer Intern',
                'company' => 'JD.ID',
                'category' => 'internship',
                'job_type' => 'Internship',
                'experience' => 'Entry',
                'salary_range' => '< 8jt',
                'location' => 'Jakarta (Hybrid)',
                'skills' => ['Git', 'REST API'],
                'description' => 'Belajar test automation web dan mobile. Tulis test case, automasi regresi, API dan load testing. Kerja di tim Scrum. Magang 4–6 bulan. Sertifikat. Potensi full-time QA Engineer.',
                'deadline' => '28 Feb 2025',
                'status' => 'Open',
                'logo_color' => '#ff0055',
                'logo_text' => 'JD',
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&h=200&fit=crop',
            ],
        ];
    }
}
