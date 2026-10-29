<header class="bg-white border-b border-slate-200/80 px-6 sm:px-8 py-3.5 flex items-center justify-between gap-4 sticky top-0 z-30 min-h-[66px]">
    @php
        $headerUserRole = auth()->user()?->role ?? 'user';
        $homeRoute = match($headerUserRole) {
            'school' => route('dashboard.school'),
            'university' => route('dashboard.university'),
            'company' => route('dashboard.company'),
            'super_admin', 'admin' => route('admin.dashboard'),
            default => route('dashboard'),
        };
    @endphp

    {{-- Left: Breadcrumb & Title Info --}}
    <div class="flex-1 min-w-0 pr-4">
        @if(View::hasSection('header_title'))
            <div class="flex flex-col">
                <nav class="flex items-center gap-1.5 text-[12px] text-slate-400 font-medium leading-none mb-1">
                    <a href="{{ $homeRoute }}" class="hover:text-blue-600 transition">Home</a>
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
                    <a href="{{ $homeRoute }}" class="hover:text-blue-600 transition">Home</a>
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

        {{-- Admin Profile Badge & Dropdown --}}
        <div class="relative" id="admin-user-nav">
            <button type="button" id="admin-user-btn" aria-haspopup="true" aria-expanded="false" class="flex items-center gap-3 pl-1 group text-left cursor-pointer focus:outline-none">
                <div class="text-right hidden sm:block">
                    <div class="text-[13px] font-bold text-slate-900 leading-tight group-hover:text-brand-600 transition-colors">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-slate-500 capitalize">
                        @php
                            $adminRoleLabels = [
                                'super_admin' => 'Super Admin',
                                'admin' => 'Admin',
                                'school' => 'Sekolah',
                                'school_admin' => 'Admin Sekolah',
                                'university' => 'Universitas',
                                'company' => 'Perusahaan',
                                'user' => 'Pengguna',
                            ];
                        @endphp
                        {{ $adminRoleLabels[Auth::user()->role] ?? ucfirst(str_replace(['-', '_'], ' ', Auth::user()->role)) }}
                    </div>
                </div>
                @if(Auth::user()->avatar_url)
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-full object-cover shadow-sm ring-2 ring-slate-100 group-hover:ring-brand-200 transition-all">
                @else
                    <div class="w-9 h-9 rounded-full bg-brand-600 text-white flex items-center justify-center shadow-sm group-hover:bg-brand-700 transition-colors">
                        <span class="text-[13px] font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                @endif
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-slate-600 transition-transform duration-150"><path d="m6 9 6 6 6-6"/></svg>
            </button>

            {{-- Dropdown Menu --}}
            <div id="admin-user-menu" class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-200/90 py-1.5 z-50 animate-fade-in" style="display:none;">
                <div class="px-3.5 py-2 border-b border-slate-100 mb-1">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                </div>

                {{-- Dashboard link --}}
                <a href="{{ $homeRoute }}" class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                    <span>Dashboard</span>
                </a>

                {{-- Only show "Profil Saya" if NOT role school --}}
                @if(Auth::user()->role !== 'school')
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21a8 8 0 0 1 16 0"/></svg>
                        <span>Profil Saya</span>
                    </a>
                @endif

                {{-- Lihat Website --}}
                <a href="/" target="_blank" class="flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a14.5 14.5 0 0 0 0 20M12 2a14.5 14.5 0 0 1 0 20M2 12h20"/></svg>
                    <span>Lihat Website</span>
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="ml-auto text-slate-400"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                </a>

                <div class="my-1 border-t border-slate-100"></div>

                {{-- Logout --}}
                <form method="POST" data-async data-async-follow action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-[13px] font-medium text-rose-600 hover:bg-rose-50 transition-colors text-left cursor-pointer">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 21H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3m7 14 5-5-5-5m5 5H9"/></svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    (function() {
        var btn = document.getElementById('admin-user-btn');
        var menu = document.getElementById('admin-user-menu');
        if (btn && menu) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                var isHidden = menu.style.display === 'none';
                menu.style.display = isHidden ? 'block' : 'none';
                btn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            });
            document.addEventListener('click', function(e) {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.style.display = 'none';
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    menu.style.display = 'none';
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        }
    })();
</script>
