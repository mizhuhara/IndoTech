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
<body class="bg-gray-50 min-h-screen">

@php
    $catalog = [
        'RPT-1042' => ['title' => 'Monthly User Growth', 'type' => 'Users', 'period' => 'Oct 2024', 'generated' => 'Oct 28, 2024 09:14', 'by' => 'Admin', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600', 'format' => 'PDF', 'size' => '1.4 MB', 'summary' => 'New user registrations, active accounts, and month-over-month growth across SMK, university, and company roles.', 'metrics' => [['label' => 'New users', 'value' => '2,418'], ['label' => 'Active', 'value' => '18,902'], ['label' => 'Growth', 'value' => '+12%']]],
        'RPT-1041' => ['title' => 'Verification Summary', 'type' => 'Verification', 'period' => 'Oct 2024', 'generated' => 'Oct 27, 2024 16:02', 'by' => 'Admin', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600', 'format' => 'XLSX', 'size' => '820 KB', 'summary' => 'Entity verification submissions by type, approval rate, and pending queue age.', 'metrics' => [['label' => 'Submitted', 'value' => '186'], ['label' => 'Approved', 'value' => '141'], ['label' => 'Pending', 'value' => '28']]],
        'RPT-1038' => ['title' => 'Job Posting Analytics', 'type' => 'Jobs', 'period' => 'Sep 2024', 'generated' => 'Oct 26, 2024 11:40', 'by' => 'Admin', 'status' => 'Processing', 'badge' => 'bg-amber-50 text-amber-600', 'format' => 'PDF', 'size' => '—', 'summary' => 'Job posts, applications, and fill rate by industry and location. File still generating.', 'metrics' => [['label' => 'Jobs', 'value' => '4,521'], ['label' => 'Applications', 'value' => '31,204'], ['label' => 'Fill rate', 'value' => '38%']]],
        'RPT-1035' => ['title' => 'School Registration', 'type' => 'School', 'period' => 'Q3 2024', 'generated' => 'Oct 20, 2024 08:22', 'by' => 'Admin', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600', 'format' => 'CSV', 'size' => '640 KB', 'summary' => 'SMK registrations, verified schools, and regional distribution for Q3.', 'metrics' => [['label' => 'Schools', 'value' => '1,204'], ['label' => 'Verified', 'value' => '986'], ['label' => 'New', 'value' => '74']]],
        'RPT-1031' => ['title' => 'Company Activity', 'type' => 'Company', 'period' => 'Q3 2024', 'generated' => 'Oct 18, 2024 14:55', 'by' => 'Admin', 'status' => 'Failed', 'badge' => 'bg-red-50 text-red-600', 'format' => 'PDF', 'size' => '—', 'summary' => 'Export failed while aggregating company job and internship activity. Regenerate from Report Management.', 'metrics' => [['label' => 'Companies', 'value' => '890'], ['label' => 'Active jobs', 'value' => '2,104'], ['label' => 'Error', 'value' => 'Timeout']]],
        'RPT-1028' => ['title' => 'Internship Placement', 'type' => 'Internship', 'period' => 'Sep 2024', 'generated' => 'Oct 12, 2024 10:08', 'by' => 'Admin', 'status' => 'Ready', 'badge' => 'bg-emerald-50 text-emerald-600', 'format' => 'PDF', 'size' => '980 KB', 'summary' => 'Internship openings, applicants, and placement rate by campus and company.', 'metrics' => [['label' => 'Openings', 'value' => '612'], ['label' => 'Applicants', 'value' => '4,880'], ['label' => 'Placed', 'value' => '401']]],
    ];
    $report = $catalog[$id] ?? null;
@endphp

<div class="flex min-h-screen">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center gap-4">
            <div class="text-[13px] text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Home</a>
                <span class="mx-1.5">›</span>
                <a href="{{ route('admin.reports.index') }}" class="hover:text-blue-600">Reports</a>
                <span class="mx-1.5">›</span>
                <span class="text-slate-900 font-medium">Report Information</span>
            </div>
            <div class="flex-1"></div>
            <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-[13px] font-bold">AD</div>
                <div class="hidden sm:block">
                    <div class="text-[13px] font-semibold text-slate-900 leading-none">Admin</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Super Admin</div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 space-y-6">

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
                <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-[15px] font-bold text-slate-900">{{ $report['title'] }}</h2>
                            <p class="text-[12px] text-slate-500">{{ $report['summary'] }}</p>
                        </div>
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold {{ $report['badge'] }}">{{ $report['status'] }}</span>
                    </div>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-0 divide-y sm:divide-y-0">
                        @php
                            $fields = [
                                'Report ID' => $id,
                                'Type' => $report['type'],
                                'Period' => $report['period'],
                                'Generated at' => $report['generated'],
                                'Generated by' => $report['by'],
                                'Format' => $report['format'].' · '.$report['size'],
                            ];
                        @endphp
                        @foreach ($fields as $label => $value)
                            <div class="px-5 py-4 border-b border-slate-100">
                                <dt class="text-[12px] text-slate-500">{{ $label }}</dt>
                                <dd class="mt-0.5 text-[14px] font-semibold text-slate-900">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </section>

                <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($report['metrics'] as $metric)
                        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                            <div class="text-[22px] font-extrabold text-slate-900 leading-none">{{ $metric['value'] }}</div>
                            <div class="mt-1 text-[12.5px] text-slate-500">{{ $metric['label'] }}</div>
                        </div>
                    @endforeach
                </section>
            @endif

        </main>
    </div>
</div>

</body>
</html>
