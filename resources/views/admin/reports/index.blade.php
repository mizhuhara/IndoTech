<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports — IndoTech Admin</title>

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

@php
    $reports = [
        ['id' => 'RPT-1042', 'title' => 'Monthly User Growth', 'type' => 'Users', 'period' => 'Oct 2024', 'generated' => 'Oct 28, 2024', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600'],
        ['id' => 'RPT-1041', 'title' => 'Verification Summary', 'type' => 'Verification', 'period' => 'Oct 2024', 'generated' => 'Oct 27, 2024', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600'],
        ['id' => 'RPT-1038', 'title' => 'Job Posting Analytics', 'type' => 'Jobs', 'period' => 'Sep 2024', 'generated' => 'Oct 26, 2024', 'status' => 'Processing', 'badge' => 'bg-amber-50 text-amber-600'],
        ['id' => 'RPT-1035', 'title' => 'School Registration', 'type' => 'School', 'period' => 'Q3 2024', 'generated' => 'Oct 20, 2024', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600'],
        ['id' => 'RPT-1031', 'title' => 'Company Activity', 'type' => 'Company', 'period' => 'Q3 2024', 'generated' => 'Oct 18, 2024', 'status' => 'Failed', 'badge' => 'bg-red-50 text-red-600'],
        ['id' => 'RPT-1028', 'title' => 'Internship Placement', 'type' => 'Internship', 'period' => 'Sep 2024', 'generated' => 'Oct 12, 2024', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600'],
    ];
    $recent = array_slice($reports, 0, 4);
@endphp

<div class="flex min-h-screen">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center gap-4">
            <div class="text-[13px] text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Home</a>
                <span class="mx-1.5">›</span>
                <span class="text-slate-900 font-medium">Reports</span>
            </div>

            <div class="flex-1"></div>

            <div class="hidden md:flex items-center gap-2 bg-slate-100 rounded-lg px-3 h-9 w-64">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
                <input id="reports-search" type="text" placeholder="Search reports..." class="bg-transparent outline-none text-[13px] text-slate-700 placeholder-slate-400 flex-1 min-w-0">
            </div>

            <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-[13px] font-bold">AD</div>
                <div class="hidden sm:block">
                    <div class="text-[13px] font-semibold text-slate-900 leading-none">Admin</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Super Admin</div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 space-y-6">

            <div>
                <h1 class="text-[22px] font-bold text-slate-900">Reports</h1>
                <p class="text-[13px] text-slate-500 mt-0.5">Generate, review, and open platform reports.</p>
            </div>

            {{-- Report Management --}}
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h2 class="text-[15px] font-bold text-slate-900">Report Management</h2>
                        <p class="text-[12px] text-slate-500">Filter and generate a new report</p>
                    </div>
                    <button id="generate-report" type="button" class="inline-flex items-center gap-2 h-9 px-3.5 rounded-lg bg-blue-600 text-white text-[13px] font-semibold hover:bg-blue-700 transition">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                        Generate Report
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label for="report-type" class="block text-[12px] font-medium text-slate-600 mb-1">Type</label>
                        <select id="report-type" class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
                            <option>All types</option>
                            <option>Users</option>
                            <option>Verification</option>
                            <option>Jobs</option>
                            <option>School</option>
                            <option>Company</option>
                        </select>
                    </div>
                    <div>
                        <label for="report-status" class="block text-[12px] font-medium text-slate-600 mb-1">Status</label>
                        <select id="report-status" class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
                            <option>All status</option>
                            <option>Ready</option>
                            <option>Processing</option>
                            <option>Failed</option>
                        </select>
                    </div>
                    <div>
                        <label for="report-from" class="block text-[12px] font-medium text-slate-600 mb-1">From</label>
                        <input id="report-from" type="date" class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
                    </div>
                    <div>
                        <label for="report-to" class="block text-[12px] font-medium text-slate-600 mb-1">To</label>
                        <input id="report-to" type="date" class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mt-5">
                    @php
                        $mgmt = [
                            ['label' => 'Total Reports', 'value' => '128', 'bg' => 'bg-blue-50', 'fg' => 'text-blue-600'],
                            ['label' => 'Ready', 'value' => '112', 'bg' => 'bg-emerald-50', 'fg' => 'text-emerald-600'],
                            ['label' => 'Processing', 'value' => '9', 'bg' => 'bg-amber-50', 'fg' => 'text-amber-600'],
                            ['label' => 'Failed', 'value' => '7', 'bg' => 'bg-red-50', 'fg' => 'text-red-600'],
                        ];
                    @endphp
                    @foreach ($mgmt as $m)
                        <div class="rounded-lg border border-slate-100 {{ $m['bg'] }} px-4 py-3">
                            <div class="text-[20px] font-extrabold {{ $m['fg'] }} leading-none">{{ $m['value'] }}</div>
                            <div class="text-[12px] text-slate-500 mt-1">{{ $m['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Recent Reports --}}
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-[15px] font-bold text-slate-900">Recent Reports</h2>
                        <p class="text-[12px] text-slate-500">Latest generated files</p>
                    </div>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach ($recent as $r)
                        <a href="{{ route('admin.reports.show', $r['id']) }}" class="flex items-center gap-4 px-5 py-3.5 hover:bg-slate-50/70 transition">
                            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M4 20V10m5 10V4m5 16v-7m5 7V8"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[13.5px] font-semibold text-slate-900 truncate">{{ $r['title'] }}</div>
                                <div class="text-[12px] text-slate-500">{{ $r['id'] }} · {{ $r['generated'] }}</div>
                            </div>
                            <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold {{ $r['badge'] }}">{{ $r['status'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- View Reports --}}
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-[15px] font-bold text-slate-900">View Reports</h2>
                        <p class="text-[12px] text-slate-500">Open report information</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-[12px] uppercase tracking-wide text-slate-500">
                                <th class="px-5 py-3 font-semibold">ID</th>
                                <th class="px-5 py-3 font-semibold">Title</th>
                                <th class="px-5 py-3 font-semibold">Type</th>
                                <th class="px-5 py-3 font-semibold">Period</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                                <th class="px-5 py-3 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-[13.5px]">
                            @foreach ($reports as $r)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-5 py-3.5 font-medium text-slate-500">{{ $r['id'] }}</td>
                                    <td class="px-5 py-3.5 font-medium text-slate-900">{{ $r['title'] }}</td>
                                    <td class="px-5 py-3.5 text-slate-600">{{ $r['type'] }}</td>
                                    <td class="px-5 py-3.5 text-slate-500">{{ $r['period'] }}</td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold {{ $r['badge'] }}">{{ $r['status'] }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a id="view-report-{{ $r['id'] }}" href="{{ route('admin.reports.show', $r['id']) }}" class="text-[12.5px] font-semibold text-blue-600 hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>
</div>

</body>
</html>
