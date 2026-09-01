<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Information — IndoTech Admin</title>

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
<body class="bg-[#f8fafd] min-h-screen">

@php
    $catalog = [
        'RPT-1042' => ['title' => 'Monthly User Growth', 'type' => 'Users', 'period' => 'Oct 2024', 'generated' => 'Oct 28, 2024 09:14', 'by' => 'Admin', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600', 'format' => 'PDF', 'size' => '1.4 MB', 'summary' => 'New user registrations, active accounts, and month-over-month growth across SMK, university, and company roles.'],
        'RPT-1041' => ['title' => 'Verification Summary', 'type' => 'Verification', 'period' => 'Oct 2024', 'generated' => 'Oct 27, 2024 16:02', 'by' => 'Admin', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600', 'format' => 'XLSX', 'size' => '820 KB', 'summary' => 'Entity verification submissions by type, approval rate, and pending queue age.'],
        'RPT-1038' => ['title' => 'Job Posting Analytics', 'type' => 'Jobs', 'period' => 'Sep 2024', 'generated' => 'Oct 26, 2024 11:40', 'by' => 'Admin', 'status' => 'Processing', 'badge' => 'bg-amber-50 text-amber-600', 'format' => 'PDF', 'size' => '—', 'summary' => 'Job posts, applications, and fill rate by industry and location. File still generating.'],
        'RPT-1035' => ['title' => 'School Registration', 'type' => 'School', 'period' => 'Q3 2024', 'generated' => 'Oct 20, 2024 08:22', 'by' => 'Admin', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600', 'format' => 'CSV', 'size' => '640 KB', 'summary' => 'SMK registrations, verified schools, and regional distribution for Q3.'],
        'RPT-1031' => ['title' => 'Company Activity', 'type' => 'Company', 'period' => 'Q3 2024', 'generated' => 'Oct 18, 2024 14:55', 'by' => 'Admin', 'status' => 'Failed', 'badge' => 'bg-red-50 text-red-600', 'format' => 'PDF', 'size' => '—', 'summary' => 'Export failed while aggregating company job and internship activity. Regenerate from Report Management.'],
        'RPT-1028' => ['title' => 'Internship Placement', 'type' => 'Internship', 'period' => 'Sep 2024', 'generated' => 'Oct 12, 2024 10:08', 'by' => 'Admin', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600', 'format' => 'PDF', 'size' => '980 KB', 'summary' => 'Internship openings, applicants, and placement rate by campus and company.'],
    ];
    $report = $catalog[$id] ?? null;

    $priority = 'High';
    $status   = 'Investigasi';
    $photos   = [1, 2, 3];
    $profile  = [
        'name'  => 'Budi Santoso',
        'phone' => '0812-3456-7890',
        'email' => 'budi.santoso@mail.com',
        'role'  => 'Mahasiswa — Universitas Nusantara',
    ];
    $timeline = [
        ['label' => 'Laporan diterima',   'meta' => 'Diajukan oleh Budi Santoso', 'time' => '2 jam lalu'],
        ['label' => 'Status diperbarui',  'meta' => 'Ditandai sebagai Investigasi', 'time' => '1 jam lalu'],
        ['label' => 'Menunggu tindakan',  'meta' => 'Ditugaskan ke Admin Regional', 'time' => '30 menit lalu'],
    ];
@endphp

<div class="flex min-h-screen">
    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">
        @include('admin.partials.header')

        <main class="flex-1 p-6 space-y-6 max-w-6xl mx-auto w-full">

            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-[22px] font-bold text-slate-900">Report Information</h1>
                    <p class="text-[13px] text-slate-500 mt-0.5">{{ $id }}</p>
                </div>
                <a href="{{ route('admin.reports.index') }}" class="h-9 px-3.5 inline-flex items-center rounded-lg border border-slate-200 bg-white text-[13px] font-semibold text-slate-700 hover:bg-slate-50">Back to reports</a>
            </div>

            @if (! $report)
                <div class="bg-white rounded-xl border border-slate-200 p-8 text-center text-[14px] text-slate-500">
                    Report not found.
                </div>
            @else
                {{-- Priority banner --}}
                <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-5 py-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-600 text-[12px] font-bold">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 12.414a1 1 0 101.414 1.414L10 12.828l1.879 1.88a1 1 0 101.414-1.415l-2.293-2.292V7z" clip-rule="evenodd"/></svg>
                                {{ $priority }} Priority
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-[12px] font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                {{ $status }}
                            </span>
                        </div>
                        <div class="sm:ml-auto text-[12px] text-slate-500">{{ $report['generated'] }}</div>
                    </div>

                    <div class="px-5 py-5">
                        <h2 class="text-[17px] font-bold text-slate-900">{{ $report['title'] }}</h2>
                        <p class="mt-1.5 text-[14px] text-slate-600 leading-relaxed">{{ $report['summary'] }}</p>
                    </div>
                </section>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Left: Profile + photos --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- Reporter profile --}}
                        <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-slate-100">
                                <h3 class="text-[14px] font-bold text-slate-900">Profile Pelapor</h3>
                            </div>
                            <div class="p-5 flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-bold shrink-0">
                                    {{ collect(explode(' ', $profile['name']))->map(fn($w) => strtoupper($w[0]))->take(2)->join('') }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-[15px] font-bold text-slate-900">{{ $profile['name'] }}</div>
                                    <div class="text-[12.5px] text-slate-500">{{ $profile['role'] }}</div>
                                    <div class="mt-1.5 flex flex-wrap items-center gap-x-4 gap-y-1 text-[12.5px] text-slate-600">
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2a1 1 0 011 1v2a1 1 0 01-1 1h-2v2a7 7 0 0014 0V9h-2a1 1 0 01-1-1V4a1 1 0 011-1h2a2 2 0 012 2v2a9 9 0 01-18 0V5z"/></svg>
                                            {{ $profile['phone'] }}
                                        </span>
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            {{ $profile['email'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        {{-- Photos --}}
                        <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-slate-100">
                                <h3 class="text-[14px] font-bold text-slate-900">Foto Laporan</h3>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach ($photos as $i)
                                    <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-50 aspect-[4/3]">
                                        <img src="https://picsum.photos/seed/report-{{ $id }}-{{ $i }}/600/450" alt="Foto laporan {{ $i }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" loading="lazy">
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>

                    {{-- Right: Admin action + timeline --}}
                    <div class="space-y-6">
                        <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-slate-100">
                                <h3 class="text-[14px] font-bold text-slate-900">Admin Action</h3>
                            </div>
                            <div class="p-5 space-y-5">
                                <div>
                                    <label class="text-[12.5px] font-semibold text-slate-700">Status laporan</label>
                                    <div class="mt-2 grid grid-cols-2 gap-2">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="status" value="investigasi" checked class="accent-blue-600">
                                            <span class="text-[13px] text-slate-700 font-medium">Investigasi</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="status" value="diproses" class="accent-blue-600">
                                            <span class="text-[13px] text-slate-700 font-medium">Diproses</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="status" value="selesai" class="accent-blue-600">
                                            <span class="text-[13px] text-slate-700 font-medium">Selesai</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="status" value="ditutup" class="accent-blue-600">
                                            <span class="text-[13px] text-slate-700 font-medium">Ditutup</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label for="note" class="text-[12.5px] font-semibold text-slate-700">Catatan tindakan</label>
                                    <textarea id="note" rows="3" class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-[13px] text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500" placeholder="Tulis catatan untuk laporan ini..."></textarea>
                                </div>

                                <div class="flex gap-2">
                                    <button class="flex-1 h-9 inline-flex items-center justify-center rounded-lg bg-blue-600 text-white text-[13px] font-semibold hover:bg-blue-700">Simpan</button>
                                    <button class="h-9 px-3 inline-flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 text-[13px] font-semibold hover:bg-slate-50">Batal</button>
                                </div>
                            </div>
                        </section>

                        <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-slate-100">
                                <h3 class="text-[14px] font-bold text-slate-900">Activity Timeline</h3>
                            </div>
                            <div class="p-5">
                                <ol class="relative border-l border-slate-200 ml-2 space-y-6">
                                    @foreach ($timeline as $event)
                                        <li class="ml-4">
                                            <span class="absolute -left-[9px] mt-1 w-3 h-3 rounded-full border-2 border-white {{ $loop->first ? 'bg-blue-500' : 'bg-slate-300' }}"></span>
                                            <div class="text-[13px] font-semibold text-slate-800">{{ $event['label'] }}</div>
                                            <div class="text-[12px] text-slate-500">{{ $event['meta'] }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">{{ $event['time'] }}</div>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </section>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>

</body>
</html>
