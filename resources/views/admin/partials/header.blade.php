<header class="bg-white border-b border-slate-200/80 px-6 sm:px-8 py-3.5 flex items-center justify-between gap-4 sticky top-0 z-30 min-h-[66px]">
    {{-- Left: Breadcrumb & Title Info --}}
    <div class="flex-1 min-w-0 pr-4">
        @if(View::hasSection('header_title'))
            <div class="flex flex-col">
                <nav class="flex items-center gap-1.5 text-[12px] text-slate-400 font-medium leading-none mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Home</a>
                    <span class="text-slate-300">›</span>
                    <span class="text-slate-700 font-bold truncate">@yield('header_breadcrumb', View::yieldContent('header_title'))</span>
                </nav>
                <div class="flex items-center gap-3 min-w-0">
                    <h1 class="text-[19px] sm:text-[21px] font-extrabold text-slate-900 tracking-tight leading-tight truncate">
                        @yield('header_title')
                    </h1>
                    @if(View::hasSection('header_subtitle'))
                        <span class="hidden xl:inline-block text-slate-300">|</span>
                        <p class="hidden xl:inline-block text-[13px] text-slate-500 font-medium truncate leading-none">
                            @yield('header_subtitle')
                        </p>
                    @endif
                </div>
            </div>
        @else
            @php
                $title = 'Main Dashboard';
                $breadcrumb = 'Main Dashboard';
                $subtitle = 'Overview of platform data and verification requests.';
                $parentRoute = null;
                $parentName = null;

                if (request()->routeIs('admin.dashboard')) {
                    $title = 'Main Dashboard';
                    $breadcrumb = 'Main Dashboard';
                    $subtitle = 'Overview of platform data and verification requests.';
                } elseif (request()->routeIs('admin.verification.*')) {
                    $title = 'Verification Management';
                    $breadcrumb = 'Verification Request';
                    $subtitle = 'Tinjau, lihat rincian, setujui, atau tolak pendaftaran akun pengguna & institusi.';
                } elseif (request()->routeIs('admin.users.*')) {
                    $title = 'User Management';
                    $breadcrumb = 'User Management';
                    $subtitle = 'Kelola semua akun pengguna dan hak akses terdaftar di platform.';
                } elseif (request()->routeIs('admin.schools.*')) {
                    $parentRoute = route('admin.schools.index');
                    $parentName = 'SMK IT';
                    if (request()->routeIs('admin.schools.create')) {
                        $title = 'Tambah SMK IT Baru';
                        $breadcrumb = 'Tambah Baru';
                        $subtitle = 'Daftarkan data sekolah vokasi baru ke dalam platform.';
                    } elseif (request()->routeIs('admin.schools.edit')) {
                        $title = 'Edit SMK IT';
                        $breadcrumb = 'Edit Sekolah';
                        $subtitle = 'Perbarui profil dan informasi verifikasi sekolah vokasi.';
                    } else {
                        $title = 'SMK IT Management';
                        $breadcrumb = 'School Management';
                        $subtitle = 'Kelola direktori sekolah kejuruan IT dan verifikasi.';
                        $parentName = null;
                    }
                } elseif (request()->routeIs('admin.univ.*')) {
                    $parentRoute = route('admin.univ.index');
                    $parentName = 'Universitas';
                    if (request()->routeIs('admin.univ.create')) {
                        $title = 'Tambah Universitas Baru';
                        $breadcrumb = 'Tambah Baru';
                        $subtitle = 'Daftarkan institusi universitas mitra baru.';
                    } elseif (request()->routeIs('admin.univ.edit')) {
                        $title = 'Edit Universitas';
                        $breadcrumb = 'Edit Universitas';
                        $subtitle = 'Perbarui data perguruan tinggi mitra.';
                    } else {
                        $title = 'Universitas Management';
                        $breadcrumb = 'Universitas Management';
                        $subtitle = 'Kelola direktori kampus mitra dan status kerjasama.';
                        $parentName = null;
                    }
                } elseif (request()->routeIs('admin.company.*')) {
                    $parentRoute = route('admin.company.index');
                    $parentName = 'Company';
                    if (request()->routeIs('admin.company.create')) {
                        $title = 'Tambah Company Baru';
                        $breadcrumb = 'Tambah Baru';
                        $subtitle = 'Daftarkan mitra perusahaan industri baru.';
                    } elseif (request()->routeIs('admin.company.edit')) {
                        $title = 'Edit Company';
                        $breadcrumb = 'Edit Company';
                        $subtitle = 'Perbarui informasi legalitas perusahaan mitra.';
                    } else {
                        $title = 'Company Management';
                        $breadcrumb = 'Company Management';
                        $subtitle = 'Kelola direktori mitra industri dan status legalitas.';
                        $parentName = null;
                    }
                } elseif (request()->routeIs('admin.jobs.*')) {
                    $parentRoute = route('admin.jobs.index');
                    $parentName = 'Jobs';
                    if (request()->routeIs('admin.jobs.create')) {
                        $title = 'Tambah Lowongan Pekerjaan';
                        $breadcrumb = 'Tambah Lowongan';
                        $subtitle = 'Publikasikan lowongan kerja baru ke seluruh talenta IndoTech.';
                    } elseif (request()->routeIs('admin.jobs.edit')) {
                        $title = 'Edit Lowongan Pekerjaan';
                        $breadcrumb = 'Edit Lowongan';
                        $subtitle = 'Perbarui deskripsi dan kualifikasi lowongan kerja.';
                    } else {
                        $title = 'Job Management';
                        $breadcrumb = 'Job Management';
                        $subtitle = 'Kelola dan pantau seluruh lowongan karir di platform.';
                        $parentName = null;
                    }
                } elseif (request()->routeIs('admin.internships.*') || request()->routeIs('admin.internship.*')) {
                    $parentRoute = route('admin.internships.index');
                    $parentName = 'Internships';
                    if (request()->routeIs('admin.internships.create')) {
                        $title = 'Tambah Lowongan Internship Baru';
                        $breadcrumb = 'Tambah Internship';
                        $subtitle = 'Lengkapi formulir untuk mempublikasikan program magang baru.';
                    } else {
                        $title = 'Internship Management';
                        $breadcrumb = 'Internship Management';
                        $subtitle = 'Kelola kesempatan magang industri untuk siswa dan mahasiswa.';
                        $parentName = null;
                    }
                } elseif (request()->routeIs('admin.events.*')) {
                    $title = 'Event Management';
                    $breadcrumb = 'Event Management';
                    $subtitle = 'Kelola agenda webinar, workshop, dan pameran teknologi.';
                } elseif (request()->routeIs('admin.community.*')) {
                    $title = 'Community Management';
                    $breadcrumb = 'Community Management';
                    $subtitle = 'Kelola ruang diskusi publik dan forum interaksi pengguna.';
                } elseif (request()->routeIs('admin.articles.*')) {
                    $parentRoute = route('admin.articles.index');
                    $parentName = 'Articles';
                    if (request()->routeIs('admin.articles.create')) {
                        $title = 'Tulis Artikel Baru';
                        $breadcrumb = 'Tulis Baru';
                        $subtitle = 'Publikasikan wawasan, panduan, dan berita teknologi.';
                    } elseif (request()->routeIs('admin.articles.edit')) {
                        $title = 'Edit Artikel';
                        $breadcrumb = 'Edit Artikel';
                        $subtitle = 'Perbarui konten artikel dan pengaturan publikasi.';
                    } else {
                        $title = 'Article Management';
                        $breadcrumb = 'Article Management';
                        $subtitle = 'Kelola publikasi berita edukasi dan wawasan teknologi.';
                        $parentName = null;
                    }
                } elseif (request()->routeIs('admin.reports.*')) {
                    $title = 'Report Management';
                    $breadcrumb = 'Reports';
                    $subtitle = 'Laporan statistik dan analitik menyeluruh.';
                }
            @endphp
            <div class="flex flex-col">
                <nav class="flex items-center gap-1.5 text-[12px] text-slate-400 font-medium leading-none mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Home</a>
                    @if($parentName && $parentRoute)
                        <span class="text-slate-300">›</span>
                        <a href="{{ $parentRoute }}" class="hover:text-blue-600 transition">{{ $parentName }}</a>
                    @endif
                    <span class="text-slate-300">›</span>
                    <span class="text-slate-700 font-bold truncate">{{ $breadcrumb }}</span>
                </nav>
                <div class="flex items-center gap-3 min-w-0">
                    <h1 class="text-[19px] sm:text-[21px] font-extrabold text-slate-900 tracking-tight leading-tight truncate">
                        {{ $title }}
                    </h1>
                    @if(!empty($subtitle))
                        <span class="hidden xl:inline-block text-slate-300">|</span>
                        <p class="hidden xl:inline-block text-[13px] text-slate-500 font-medium truncate leading-none">
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- Right Icons & Profile --}}
    <div class="flex items-center gap-3 sm:gap-4 shrink-0">
        {{-- Help / Info --}}
        <button type="button" class="p-2 rounded-full text-slate-500 hover:bg-slate-100 transition" aria-label="Help">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="9"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 9a2.5 2.5 0 0 1 4.9.8c0 1.7-2.4 2.2-2.4 3.7m0 3h.01"/>
            </svg>
        </button>

        {{-- Notifications --}}
        <button type="button" class="relative p-2 rounded-full text-slate-500 hover:bg-slate-100 transition" aria-label="Notifications">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.5-1.5V11a5.5 5.5 0 0 0-4-5.3V5a1.5 1.5 0 0 0-3 0v.7a5.5 5.5 0 0 0-4 5.3v4.5L6 17h5m4 0v1a3 3 0 0 1-6 0v-1"/>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>

        <div class="h-7 w-[1px] bg-slate-200 mx-1"></div>

        {{-- Admin Profile Badge --}}
        <div class="flex items-center gap-3 pl-1">
            <div class="text-right hidden sm:block">
                <div class="text-[13px] font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</div>
                <div class="text-[11px] text-slate-500 capitalize">{{ str_replace('-', ' ', Auth::user()->role) }}</div>
            </div>
            <div class="w-9 h-9 rounded-full bg-[#0b57d0] text-white flex items-center justify-center shadow-sm">
                <span class="text-[13px] font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
        </div>
    </div>
</header>
