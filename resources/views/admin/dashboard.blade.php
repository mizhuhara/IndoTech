@extends('admin.layouts.app')

@section('title', 'Main Dashboard — IndoTech')

@section('content')
<div class="space-y-6">
    {{-- Breadcrumb & Title --}}
    <div>
        <div class="text-[13px] text-slate-500 mb-1">
            <span class="hover:text-blue-600 cursor-pointer">Home</span>
            <span class="mx-1.5">›</span>
            <span class="text-slate-900 font-medium">Main Dashboard</span>
        </div>
        <h1 class="text-[24px] font-bold text-slate-900">Main Dashboard</h1>
        <p class="text-[13.5px] text-slate-500 mt-0.5">Overview of platform data and verification requests.</p>
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
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-xl {{ $s['bg'] }} {{ $s['fg'] }} flex items-center justify-center">
                        @if ($s['icon'] === 'users')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="9" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20c1.2-3.2 3.7-4.8 6.5-4.8s5.3 1.6 6.5 4.8"/><path stroke-linecap="round" d="M16 5.5a3 3 0 0 1 0 5.8M18.5 15.6c1.2 1.1 2 2.4 2.6 4.4"/></svg>
                        @elseif ($s['icon'] === 'school')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5 2 9.5l10 5 10-5-10-5Zm0 7.5v6.5m6-4.5v3.5c0 1.5-2.69 3-6 3s-6-1.5-6-3V12"/></svg>
                        @elseif ($s['icon'] === 'university')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M4 9l8-5 8 5M5 12v6m4.5-6v6m5-6v6M19 12v6M3 21h18"/></svg>
                        @elseif ($s['icon'] === 'company')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/></svg>
                        @elseif ($s['icon'] === 'jobs')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="3" y="7" width="18" height="13" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 12h18"/></svg>
                        @endif
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-[12px] font-semibold {{ $s['up'] ? 'text-emerald-600' : 'text-red-500' }}">
                        {{ $s['delta'] }}
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="{{ $s['up'] ? '' : 'rotate-180' }}"><path d="M7 17 17 7m0 0H8m9 0v9"/></svg>
                    </span>
                </div>
                <div class="mt-3 text-[24px] font-extrabold text-slate-900 leading-none">{{ $s['value'] }}</div>
                <div class="mt-1 text-[12.5px] text-slate-500">{{ $s['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Line chart: New User Statistics --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-[16px] font-bold text-slate-900">New User Statistics</h2>
                    <p class="text-[12.5px] text-slate-500">Per month (Jan–Jun)</p>
                </div>
                <a href="#" class="text-[13px] font-semibold text-[#0b57d0] hover:underline">View All</a>
            </div>
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

        {{-- Bar chart: Distribution by Region (Daerah) --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-[16px] font-bold text-slate-900">Distribusi Berdasarkan Daerah</h2>
                    <p class="text-[12.5px] text-slate-500">Sebaran entitas terdaftar per wilayah</p>
                </div>
                <a href="#" class="text-[13px] font-semibold text-[#0b57d0] hover:underline">Lihat Semua</a>
            </div>
            <div class="flex items-end justify-around gap-3 h-40 pt-2">
                @php
                    $regions = [
                        ['label' => 'DKI Jakarta', 'short' => 'DKI Jakarta', 'val' => '38%', 'h' => '85%', 'color' => 'bg-blue-700'],
                        ['label' => 'Jawa Barat', 'short' => 'Jawa Barat', 'val' => '28%', 'h' => '68%', 'color' => 'bg-blue-600'],
                        ['label' => 'Jawa Timur', 'short' => 'Jawa Timur', 'val' => '18%', 'h' => '50%', 'color' => 'bg-blue-500'],
                        ['label' => 'Jawa Tengah', 'short' => 'Jateng & DIY', 'val' => '12%', 'h' => '38%', 'color' => 'bg-blue-400'],
                        ['label' => 'Luar Jawa', 'short' => 'Luar Jawa', 'val' => '4%', 'h' => '22%', 'color' => 'bg-blue-300'],
                    ];
                @endphp
                @foreach ($regions as $r)
                    <div class="flex flex-col items-center gap-1.5 flex-1 h-full justify-end group">
                        <span class="text-[11px] font-bold text-slate-500 opacity-0 group-hover:opacity-100 transition">{{ $r['val'] }}</span>
                        <div class="w-full max-w-[48px] rounded-t-lg {{ $r['color'] }} transition-all group-hover:brightness-110" style="height: {{ $r['h'] }}"></div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-around gap-2 text-[11px] font-semibold text-slate-500 mt-2.5 text-center">
                @foreach ($regions as $r)
                    <span class="flex-1 truncate" title="{{ $r['label'] }}">{{ $r['short'] }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recent Verification Requests --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="text-[16px] font-bold text-slate-900">Recent Verification Requests</h2>
                <p class="text-[12.5px] text-slate-500">Latest entity verification submissions</p>
            </div>
            <a href="{{ route('admin.schools.index') }}" class="text-[13px] font-semibold text-[#0b57d0] hover:underline">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[12px] uppercase tracking-wide text-slate-500">
                        <th class="px-6 py-3.5 font-semibold">Entity Name</th>
                        <th class="px-6 py-3.5 font-semibold">Type</th>
                        <th class="px-6 py-3.5 font-semibold">Registration Date</th>
                        <th class="px-6 py-3.5 font-semibold">Status</th>
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
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $r['name'] }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $r['type'] }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $r['date'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-[12px] font-semibold {{ $r['badge'] }}">{{ $r['status'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection