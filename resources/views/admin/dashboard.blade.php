<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard — IndoTech</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script>
        if (window.tailwind) {
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    },
                },
            };
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="flex min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 shrink-0 bg-slate-100 border-r border-slate-200 flex flex-col">
        {{-- Logo --}}
        <div class="px-6 pt-6 pb-4 border-b border-slate-200">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-extrabold text-sm">IT</div>
                <div>
                    <div class="text-[15px] font-extrabold text-slate-900 leading-none">IndoTech</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Admin System</div>
                </div>
            </div>
        </div>

        {{-- New Record --}}
        <div class="px-4 pt-4">
            <button class="w-full flex items-center justify-center gap-2 h-10 rounded-lg bg-blue-600 text-white text-[13px] font-semibold hover:bg-blue-700 transition">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                New Record
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            @php
                $menu = [
                    ['label' => 'Dashboard', 'icon' => 'grid', 'active' => true, 'href' => '#'],
                    ['label' => 'User and Verification', 'icon' => 'users', 'active' => false, 'href' => '#', 'arrow' => true],
                    ['label' => 'School', 'icon' => 'school', 'active' => false, 'href' => '#'],
                    ['label' => 'University', 'icon' => 'university', 'active' => false, 'href' => '#'],
                    ['label' => 'Company', 'icon' => 'company', 'active' => false, 'href' => '#'],
                    ['label' => 'Jobs', 'icon' => 'jobs', 'active' => false, 'href' => '#'],
                    ['label' => 'Internship', 'icon' => 'internship', 'active' => false, 'href' => '#'],
                    ['label' => 'Events', 'icon' => 'events', 'active' => false, 'href' => '#'],
                    ['label' => 'Articles', 'icon' => 'articles', 'active' => false, 'href' => '#'],
                    ['label' => 'Community', 'icon' => 'community', 'active' => false, 'href' => '#'],
                    ['label' => 'Reports', 'icon' => 'reports', 'active' => false, 'href' => '#'],
                ];
            @endphp

            @foreach ($menu as $item)
                <a href="{{ $item['href'] }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13.5px] font-medium transition
                          {{ $item['active']
                              ? 'bg-blue-600 text-white shadow-sm'
                              : 'text-slate-700 hover:bg-slate-200/70 hover:text-slate-900' }}">
                    @if ($item['icon'] === 'grid')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                    @elseif ($item['icon'] === 'users')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="9" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20c1.2-3.2 3.7-4.8 6.5-4.8s5.3 1.6 6.5 4.8"/><path stroke-linecap="round" d="M16 5.5a3 3 0 0 1 0 5.8M18.5 15.6c1.2 1.1 2 2.4 2.6 4.4"/></svg>
                    @elseif ($item['icon'] === 'school')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6"/></svg>
                    @elseif ($item['icon'] === 'university')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M4 9l8-5 8 5M5 12v6m4.5-6v6m5-6v6M19 12v6M3 21h18"/></svg>
                    @elseif ($item['icon'] === 'company')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/></svg>
                    @elseif ($item['icon'] === 'jobs')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="3" y="7" width="18" height="13" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 12h18"/></svg>
                    @elseif ($item['icon'] === 'internship')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="3" y="5" width="18" height="16" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M8 3v4m8-4v4"/></svg>
                    @elseif ($item['icon'] === 'events')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M5 4h14a2 2 0 0 1 2 2v14H3V6a2 2 0 0 1 2-2zm3 8h8m-8 4h5"/></svg>
                    @elseif ($item['icon'] === 'articles')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12a1 1 0 0 1 1 1v17l-4-2.5L11 21l-6-3V4a1 1 0 0 1 1-1z"/><path stroke-linecap="round" d="M9 8h6m-6 4h6"/></svg>
                    @elseif ($item['icon'] === 'community')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="8" cy="9" r="3"/><circle cx="16" cy="10" r="2.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 19c1-2.5 3-3.8 5.5-3.8s4.5 1.3 5.5 3.8M14.5 15.4c2.6-.2 4.7 1 5.7 3.6"/></svg>
                    @elseif ($item['icon'] === 'reports')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M4 20V10m5 10V4m5 16v-7m5 7V8"/></svg>
                    @endif
                    <span class="flex-1">{{ $item['label'] }}</span>
                    @if (! empty($item['arrow']))
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="opacity-60"><path d="m8 10 4 4 4-4"/></svg>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- Sidebar footer --}}
        <div class="px-4 py-4 border-t border-slate-200">
            <div class="flex items-center gap-2 text-[12px] text-slate-500">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
                v1.0.0
            </div>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Header --}}
        <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center gap-4">
            {{-- Breadcrumb --}}
            <div class="text-[13px] text-slate-500">
                <span class="hover:text-blue-600 cursor-pointer">Home</span>
                <span class="mx-1.5">›</span>
                <span class="text-slate-900 font-medium">Main Dashboard</span>
            </div>

            <div class="flex-1"></div>

            {{-- Search --}}
            <div class="hidden md:flex items-center gap-2 bg-slate-100 rounded-lg px-3 h-9 w-64">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
                <input type="text" placeholder="Search data..." class="bg-transparent outline-none text-[13px] text-slate-700 placeholder-slate-400 flex-1 min-w-0">
            </div>

            {{-- Icons --}}
            <button class="relative p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition" aria-label="Notifications">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.5-1.5V11a5.5 5.5 0 0 0-4-5.3V5a1.5 1.5 0 0 0-3 0v.7a5.5 5.5 0 0 0-4 5.3v4.5L6 17h5m4 0v1a3 3 0 0 1-6 0v-1"/></svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500"></span>
            </button>
            <button class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition" aria-label="Help">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 9a2.5 2.5 0 0 1 4.9.8c0 1.7-2.4 2.2-2.4 3.7m0 3h.01"/></svg>
            </button>
            <button class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition" aria-label="Settings">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 12a7 7 0 0 0-.1-1.2l2-1.6-2-3.4-2.4 1a7 7 0 0 0-2-1.2L14 3h-4l-.5 2.6a7 7 0 0 0-2 1.2l-2.4-1-2 3.4 2 1.6A7 7 0 0 0 5 12c0 .4 0 .8.1 1.2l-2 1.6 2 3.4 2.4-1a7 7 0 0 0 2 1.2L10 21h4l.5-2.6a7 7 0 0 0 2-1.2l2.4 1 2-3.4-2-1.6c.1-.4.1-.8.1-1.2z"/></svg>
            </button>

            {{-- Profile --}}
            <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-[13px] font-bold">AD</div>
                <div class="hidden sm:block">
                    <div class="text-[13px] font-semibold text-slate-900 leading-none">Admin</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Super Admin</div>
                </div>
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="text-slate-400"><path d="m8 10 4 4 4-4"/></svg>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 p-6 space-y-6">

            {{-- Page title --}}
            <div>
                <h1 class="text-[22px] font-bold text-slate-900">Main Dashboard</h1>
                <p class="text-[13px] text-slate-500 mt-0.5">Overview of platform data and verification requests.</p>
            </div>

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @php
                    $stats = [
                        ['label' => 'Total Users',  'value' => '24,592', 'delta' => '+12%', 'up' => true,  'icon' => 'users',     'bg' => 'bg-blue-50',  'fg' => 'text-blue-600'],
                        ['label' => 'Schools (SMK)', 'value' => '1,204',  'delta' => '+15%', 'up' => true,  'icon' => 'school',    'bg' => 'bg-sky-50',   'fg' => 'text-sky-600'],
                        ['label' => 'University',    'value' => '342',    'delta' => '+2%',  'up' => true,  'icon' => 'university','bg' => 'bg-rose-50',  'fg' => 'text-rose-500'],
                        ['label' => 'Company',       'value' => '890',    'delta' => '+18%', 'up' => true,  'icon' => 'company',   'bg' => 'bg-violet-50','fg' => 'text-violet-600'],
                        ['label' => 'Active Jobs',   'value' => '4,521',  'delta' => '-3%',  'up' => false, 'icon' => 'jobs',      'bg' => 'bg-amber-50', 'fg' => 'text-amber-600'],
                    ];
                @endphp

                @foreach ($stats as $s)
                    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div class="w-9 h-9 rounded-lg {{ $s['bg'] }} {{ $s['fg'] }} flex items-center justify-center">
                                @if ($s['icon'] === 'users')
                                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="9" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20c1.2-3.2 3.7-4.8 6.5-4.8s5.3 1.6 6.5 4.8"/><path stroke-linecap="round" d="M16 5.5a3 3 0 0 1 0 5.8M18.5 15.6c1.2 1.1 2 2.4 2.6 4.4"/></svg>
                                @elseif ($s['icon'] === 'school')
                                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6"/></svg>
                                @elseif ($s['icon'] === 'university')
                                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M4 9l8-5 8 5M5 12v6m4.5-6v6m5-6v6M19 12v6M3 21h18"/></svg>
                                @elseif ($s['icon'] === 'company')
                                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/></svg>
                                @elseif ($s['icon'] === 'jobs')
                                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="3" y="7" width="18" height="13" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 12h18"/></svg>
                                @endif
                            </div>
                            <span class="inline-flex items-center gap-0.5 text-[12px] font-semibold {{ $s['up'] ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $s['delta'] }}
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="{{ $s['up'] ? '' : 'rotate-180' }}"><path d="M7 17 17 7m0 0H8m9 0v9"/></svg>
                            </span>
                        </div>
                        <div class="mt-3 text-[22px] font-extrabold text-slate-900 leading-none">{{ $s['value'] }}</div>
                        <div class="mt-1 text-[12.5px] text-slate-500">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Line chart: New User Statistics --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-[15px] font-bold text-slate-900">New User Statistics</h2>
                            <p class="text-[12px] text-slate-500">Per month (Jan–Jun)</p>
                        </div>
                        <a href="#" class="text-[12.5px] font-semibold text-blue-600 hover:text-blue-700">View All</a>
                    </div>
                    {{-- Line chart via SVG --}}
                    <svg viewBox="0 0 400 160" class="w-full h-auto" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="lineFill" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#2563eb" stop-opacity="0.22"/>
                                <stop offset="100%" stop-color="#2563eb" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <line x1="0" y1="130" x2="400" y2="130" stroke="#e2e8f0" stroke-width="1"/>
                        <line x1="0" y1="93" x2="400" y2="93" stroke="#f1f5f9" stroke-width="1"/>
                        <line x1="0" y1="56" x2="400" y2="56" stroke="#f1f5f9" stroke-width="1"/>
                        <line x1="0" y1="19" x2="400" y2="19" stroke="#f1f5f9" stroke-width="1"/>
                        <path d="M0 122 C 30 118, 45 105, 70 100 S 130 92, 160 82 S 220 68, 250 58 S 320 38, 350 26 S 385 12, 400 8 L 400 130 L 0 130 Z" fill="url(#lineFill)"/>
                        <path d="M0 122 C 30 118, 45 105, 70 100 S 130 92, 160 82 S 220 68, 250 58 S 320 38, 350 26 S 385 12, 400 8" fill="none" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="160" cy="82" r="3.5" fill="#2563eb" stroke="#fff" stroke-width="1.5"/>
                        <circle cx="250" cy="58" r="3.5" fill="#2563eb" stroke="#fff" stroke-width="1.5"/>
                        <circle cx="350" cy="26" r="3.5" fill="#2563eb" stroke="#fff" stroke-width="1.5"/>
                        <circle cx="400" cy="8" r="3.5" fill="#2563eb" stroke="#fff" stroke-width="1.5"/>
                    </svg>
                    <div class="flex justify-between text-[11px] text-slate-400 mt-1 px-1">
                        <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
                    </div>
                </div>

                {{-- Bar chart: Verification by Category --}}
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-[15px] font-bold text-slate-900">Verification by Category</h2>
                            <p class="text-[12px] text-slate-500">Distribution</p>
                        </div>
                        <a href="#" class="text-[12.5px] font-semibold text-blue-600 hover:text-blue-700">View All</a>
                    </div>
                    <div class="flex items-end justify-around gap-4 h-40 pt-2">
                        @php
                            $bars = [
                                ['label' => 'Vocational School', 'h' => '55%', 'color' => 'bg-blue-600'],
                                ['label' => 'University', 'h' => '85%', 'color' => 'bg-blue-700'],
                                ['label' => 'Company', 'h' => '68%', 'color' => 'bg-blue-500'],
                                ['label' => 'More', 'h' => '38%', 'color' => 'bg-blue-300'],
                            ];
                        @endphp
                        @foreach ($bars as $b)
                            <div class="flex flex-col items-center gap-2 flex-1">
                                <div class="w-full max-w-[64px] rounded-t-md {{ $b['color'] }}" style="height: {{ $b['h'] }}"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-around gap-4 text-[11px] text-slate-500 mt-2">
                        <span class="text-center">Vocational<br>School</span>
                        <span>University</span>
                        <span>Company</span>
                        <span>More</span>
                    </div>
                </div>
            </div>

            {{-- Recent Verification Requests --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-[15px] font-bold text-slate-900">Recent Verification Requests</h2>
                        <p class="text-[12px] text-slate-500">Latest entity verification submissions</p>
                    </div>
                    <a href="#" class="text-[12.5px] font-semibold text-blue-600 hover:text-blue-700">View All →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-[12px] uppercase tracking-wide text-slate-500">
                                <th class="px-5 py-3 font-semibold">Entity Name</th>
                                <th class="px-5 py-3 font-semibold">Type</th>
                                <th class="px-5 py-3 font-semibold">Registration Date</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-[13.5px]">
                            @php
                                $reqs = [
                                    ['name' => 'SMK Telkom Jakarta', 'type' => 'Vocational School', 'date' => 'Oct 12, 2024', 'status' => 'Pending',  'badge' => 'bg-slate-100 text-slate-600'],
                                    ['name' => 'PT Gojek Tokopedia Tbk', 'type' => 'Company', 'date' => 'Oct 11, 2024', 'status' => 'Approved', 'badge' => 'bg-emerald-50 text-emerald-600'],
                                    ['name' => 'Universitas Indonesia', 'type' => 'Campus', 'date' => 'Oct 10, 2024', 'status' => 'Rejected', 'badge' => 'bg-red-50 text-red-600'],
                                    ['name' => 'SMKN 2 Surabaya', 'type' => 'Vocational School', 'date' => 'Oct 09, 2024', 'status' => 'Pending',  'badge' => 'bg-slate-100 text-slate-600'],
                                ];
                            @endphp
                            @foreach ($reqs as $r)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-5 py-3.5 font-medium text-slate-900">{{ $r['name'] }}</td>
                                    <td class="px-5 py-3.5 text-slate-600">{{ $r['type'] }}</td>
                                    <td class="px-5 py-3.5 text-slate-500">{{ $r['date'] }}</td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold {{ $r['badge'] }}">{{ $r['status'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>