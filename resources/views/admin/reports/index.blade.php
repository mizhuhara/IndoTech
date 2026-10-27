@extends('admin.layouts.app')

@section('title', 'Report Management — IndoTech Admin')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
        <div>
            <h1 class="text-[22px] font-extrabold text-slate-900 tracking-tight leading-tight">Report Management</h1>
            <p class="text-[13.5px] text-slate-500 mt-0.5">Monitor and resolve system, content, and user reports.</p>
        </div>
        <div class="flex items-center gap-2.5 shrink-0">
            {{-- Filter Button --}}
            <button type="button" id="toggle-filter"
                class="inline-flex items-center gap-2 h-9 px-4 rounded-xl border border-slate-200 bg-white text-[13px] font-semibold text-slate-700 hover:bg-slate-50 shadow-xs transition">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>
            {{-- Export Data Button --}}
            <button type="button" id="generate-report"
                class="inline-flex items-center gap-2 h-9 px-4 rounded-xl bg-brand-600 text-white text-[13px] font-semibold hover:bg-blue-700 shadow-xs transition">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M4 21h16" />
                </svg>
                Export Data
            </button>
        </div>
    </div>

    {{-- Filter Drawer --}}
    <div id="filter-drawer" class="hidden">
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5">
            <form id="report-filter-form" method="GET" action="{{ route('admin.reports.index') }}"
                class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="report-type" class="form-label">Report Type</label>
                    <select id="report-type" name="type"
                        class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
                        <option value="">All types</option>
                        @foreach ($reports as $report)
                            <option value="{{ $report['slug'] }}" @selected($activeType === $report['slug'])>
                                {{ $report['type'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="report-from" class="form-label">From</label>
                    <input id="report-from" name="from" type="date" value="{{ $from }}"
                        class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
                </div>
                <div>
                    <label for="report-to" class="form-label">To</label>
                    <input id="report-to" name="to" type="date" value="{{ $to }}"
                        class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
                </div>
                <div class="sm:col-span-3 flex justify-end gap-2">
                    <a href="{{ route('admin.reports.index') }}"
                        class="h-9 px-4 inline-flex items-center rounded-lg border border-slate-200 bg-white text-[13px] font-semibold text-slate-700 hover:bg-slate-50 transition">Reset</a>
                    <button type="submit"
                        class="h-9 px-4 inline-flex items-center rounded-lg bg-brand-600 text-white text-[13px] font-semibold hover:bg-blue-700 transition">Apply</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Total Reports --}}
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-brand-600">
                    <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-[12px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+12% this week</span>
            </div>
            <div class="text-[13px] text-slate-500 mb-1">Total Reports</div>
            <div class="text-[28px] font-extrabold text-slate-900 leading-none">
                {{ number_format(array_sum($totals)) }}
            </div>
        </div>

        {{-- Pending Investigation --}}
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-[13px] text-slate-500 mb-1">Pending Investigation</div>
            <div class="text-[28px] font-extrabold text-slate-900 leading-none">
                {{ number_format($totals['Users'] ?? 0) }}
            </div>
        </div>

        {{-- Resolved Today --}}
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-[13px] text-slate-500 mb-1">Resolved Today</div>
            <div class="text-[28px] font-extrabold text-slate-900 leading-none">
                {{ number_format($exports->where('created_at', '>=', now()->startOfDay())->count()) }}
            </div>
        </div>
    </div>

    {{-- Recent Reports Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-[15px] font-bold text-slate-900">Recent Reports</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-100 text-[11.5px] uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-3.5 font-semibold">Reporter Name</th>
                        <th class="px-6 py-3.5 font-semibold">Category</th>
                        <th class="px-6 py-3.5 font-semibold">Priority</th>
                        <th class="px-6 py-3.5 font-semibold">Date Submitted</th>
                        <th class="px-6 py-3.5 font-semibold">Status</th>
                        <th class="px-6 py-3.5 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @forelse ($recent as $r)
                        @php
                            $priorityColors = [
                                0 => ['label' => 'High',   'dot' => 'bg-rose-500',   'text' => 'text-rose-600'],
                                1 => ['label' => 'Low',    'dot' => 'bg-blue-500',   'text' => 'text-blue-600'],
                                2 => ['label' => 'Medium', 'dot' => 'bg-amber-500',  'text' => 'text-amber-600'],
                                3 => ['label' => 'Medium', 'dot' => 'bg-amber-500',  'text' => 'text-amber-600'],
                            ];
                            $priorities = [
                                'users'        => ['label' => 'High',   'dot' => 'bg-rose-500',  'text' => 'text-rose-600'],
                                'verification' => ['label' => 'Medium', 'dot' => 'bg-amber-500', 'text' => 'text-amber-600'],
                                'jobs'         => ['label' => 'Low',    'dot' => 'bg-blue-500',  'text' => 'text-blue-600'],
                                'schools'      => ['label' => 'Medium', 'dot' => 'bg-amber-500', 'text' => 'text-amber-600'],
                                'companies'    => ['label' => 'Low',    'dot' => 'bg-blue-500',  'text' => 'text-blue-600'],
                                'internships'  => ['label' => 'Low',    'dot' => 'bg-blue-500',  'text' => 'text-blue-600'],
                            ];
                            $priority = $priorities[$r['slug']] ?? ['label' => 'Low', 'dot' => 'bg-blue-500', 'text' => 'text-blue-600'];
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-900">{{ $r['type'] }} Report</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $r['type'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 {{ $priority['text'] }} font-semibold text-[12.5px]">
                                    <span class="w-2 h-2 rounded-full {{ $priority['dot'] }} inline-block"></span>
                                    {{ $priority['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $r['period'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold bg-blue-50 text-blue-600">Investigating</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.reports.show', ['type' => $r['slug'], 'from' => $from, 'to' => $to]) }}"
                                        class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg border border-slate-200 text-[12.5px] font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-600 transition">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center text-slate-400">
                                <svg class="mx-auto mb-3 text-slate-300" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-[13.5px] font-medium">No reports yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination / Showing info --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 py-4 border-t border-slate-100">
            <span class="text-[12.5px] text-slate-500">
                Showing 1 to {{ count($recent) }} of {{ count($reports) }} entries
            </span>
            <div class="flex items-center gap-1">
                <span class="w-8 h-8 rounded-lg border border-slate-200 text-slate-300 flex items-center justify-center cursor-not-allowed text-[13px]">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m15 6-6 6 6 6"/></svg>
                </span>
                <span class="w-8 h-8 rounded-lg bg-brand-600 text-white text-[13px] font-semibold flex items-center justify-center">1</span>
                @if(count($reports) > 4)
                    <a href="{{ route('admin.reports.index') }}"
                        class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-[13px] flex items-center justify-center transition">2</a>
                    <a href="{{ route('admin.reports.index') }}"
                        class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-[13px] flex items-center justify-center transition">3</a>
                    <span class="text-slate-400 text-[13px] px-1">...</span>
                @endif
                @if(count($reports) > 4)
                    <a href="{{ route('admin.reports.index') }}"
                        class="w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 flex items-center justify-center transition">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 6 6 6-6 6"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- All Available Reports --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">All Reports</h2>
                <p class="text-[12px] text-slate-500">Available report types you can generate and export.</p>
            </div>
            <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold bg-slate-100 text-slate-600">{{ count($reports) }} reports</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[11.5px] uppercase tracking-wider text-slate-400">
                        <th class="table-head">ID</th>
                        <th class="table-head">Title</th>
                        <th class="table-head">Type</th>
                        <th class="table-head">Period</th>
                        <th class="table-head">Records</th>
                        <th class="table-head">Status</th>
                        <th class="px-6 py-3.5 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @foreach ($reports as $r)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 font-mono text-[12px] text-slate-400">{{ $r['id'] }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $r['title'] }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $r['type'] }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $r['period'] }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ number_format($r['records']) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold bg-emerald-50 text-emerald-600">Ready</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.reports.show', ['type' => $r['slug'], 'from' => $from, 'to' => $to]) }}"
                                    class="text-[13px] font-semibold text-brand-600 hover:underline">
                                    View Detail →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Export History --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">Export History</h2>
                <p class="text-[12px] text-slate-500">Archive of previously exported reports.</p>
            </div>
            <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold bg-slate-100 text-slate-600">{{ number_format($exports->total()) }} total</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[11.5px] uppercase tracking-wider text-slate-400">
                        <th class="table-head">Waktu</th>
                        <th class="table-head">Laporan</th>
                        <th class="table-head">Periode</th>
                        <th class="table-head">Format</th>
                        <th class="table-head">Baris</th>
                        <th class="table-head">Oleh</th>
                        <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @forelse ($exports as $export)
                        @php
                            $definition = collect($reports)->firstWhere('slug', $export->type);
                            $formatClass = match ($export->format) {
                                'pdf'   => 'bg-rose-50 text-rose-600',
                                'xlsx'  => 'bg-emerald-50 text-emerald-600',
                                default => 'bg-blue-50 text-blue-600',
                            };
                            $exportQuery = array_filter([
                                'type' => $export->type,
                                'from' => $export->period_from?->toDateString(),
                                'to'   => $export->period_to?->toDateString(),
                            ]);
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">{{ $export->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900">{{ $definition['title'] ?? strtoupper($export->type) }}</div>
                                <div class="text-[12px] text-slate-400">{{ $export->file_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                {{ $export->period_from?->format('d M Y') ?? 'Beginning' }} - {{ $export->period_to?->format('d M Y') ?? 'Now' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold uppercase {{ $formatClass }}">{{ $export->format }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ number_format($export->rows_count) }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $export->user?->name ?? 'System' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.reports.show', $exportQuery) }}"
                                    class="text-[13px] font-semibold text-brand-600 hover:underline">Buka</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-[13.5px]">Belum ada riwayat export.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($exports->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $exports->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Toggle filter drawer
    document.getElementById('toggle-filter')?.addEventListener('click', function () {
        const drawer = document.getElementById('filter-drawer');
        drawer.classList.toggle('hidden');
    });

    // Generate / Export Data button
    document.getElementById('generate-report')?.addEventListener('click', function () {
        const type = document.getElementById('report-type')?.value;
        const from = document.getElementById('report-from')?.value;
        const to   = document.getElementById('report-to')?.value;

        const params = new URLSearchParams();
        if (from) params.set('from', from);
        if (to)   params.set('to', to);

        if (type) {
            const query = params.toString();
            window.location.href = `{{ url('/admin/reports') }}/${type}${query ? '?' + query : ''}`;
            return;
        }

        document.getElementById('report-filter-form')?.submit();
    });
</script>
@endpush
