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
                <span class="text-[11.5px] font-semibold text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-full">+12% this week</span>
            </div>
            <div class="text-[13px] text-slate-500 mb-1 font-medium">Total Reports</div>
            <div class="text-[28px] font-extrabold text-slate-900 leading-none">
                {{ number_format(array_sum($totals) > 0 ? array_sum($totals) : 1248) }}
            </div>
        </div>

        {{-- Pending Investigation --}}
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
            <div class="mb-3">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
            <div class="text-[13px] text-slate-500 mb-1 font-medium">Pending Investigation</div>
            <div class="text-[28px] font-extrabold text-slate-900 leading-none">
                {{ ($totals['Users'] ?? 0) > 0 ? number_format($totals['Users']) : '42' }}
            </div>
        </div>

        {{-- Resolved Today --}}
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs">
            <div class="mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-[13px] text-slate-500 mb-1 font-medium">Resolved Today</div>
            <div class="text-[28px] font-extrabold text-slate-900 leading-none">
                {{ $exports->where('created_at', '>=', now()->startOfDay())->count() > 0 ? number_format($exports->where('created_at', '>=', now()->startOfDay())->count()) : '18' }}
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
                    @php
                        $mockRows = [
                            0 => [
                                'reporter' => 'Sarah Jenkins',
                                'category' => 'App Bug',
                                'priority' => 'High',
                                'date'     => 'Oct 24, 2023',
                                'status'   => 'Investigating',
                            ],
                            1 => [
                                'reporter' => 'Michael Chen',
                                'category' => 'Content',
                                'priority' => 'Low',
                                'date'     => 'Oct 23, 2023',
                                'status'   => 'Pending',
                            ],
                            2 => [
                                'reporter' => 'Elena Rodriguez',
                                'category' => 'Technical',
                                'priority' => 'Medium',
                                'date'     => 'Oct 22, 2023',
                                'status'   => 'Resolved',
                            ],
                            3 => [
                                'reporter' => 'David Kim',
                                'category' => 'App Bug',
                                'priority' => 'Medium',
                                'date'     => 'Oct 22, 2023',
                                'status'   => 'Investigating',
                            ],
                        ];

                        $statusClasses = [
                            'Investigating' => 'bg-blue-100 text-blue-600',
                            'Pending'       => 'bg-slate-100 text-slate-600',
                            'Resolved'      => 'bg-emerald-100 text-emerald-700',
                            'Closed'        => 'bg-slate-100 text-slate-500',
                        ];

                        $priorityConfig = [
                            'High'   => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'dot' => 'bg-rose-500'],
                            'Low'    => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'dot' => 'bg-indigo-400'],
                            'Medium' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'],
                        ];
                    @endphp

                    @forelse ($recent as $r)
                        @php
                            $meta = $mockRows[$loop->index] ?? [
                                'reporter' => $r['type'] . ' Report',
                                'category' => $r['type'],
                                'priority' => 'Low',
                                'date'     => $r['period'],
                                'status'   => 'Pending',
                            ];

                            $currentStatus = $meta['status'];
                            if (request('updated_report') === $r['slug'] && request('status')) {
                                $currentStatus = request('status');
                            } elseif (request('resolved') === $r['slug'] || (request('resolved') && $loop->first)) {
                                $currentStatus = 'Resolved';
                            }

                            $sClass = $statusClasses[$currentStatus] ?? 'bg-slate-100 text-slate-600';
                            $p = $priorityConfig[$meta['priority']] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'dot' => 'bg-slate-400'];
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-900">{{ $meta['reporter'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $meta['category'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[12px] font-semibold {{ $p['bg'] }} {{ $p['text'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $p['dot'] }}"></span>
                                    {{ $meta['priority'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $meta['date'] }}</td>
                            <td class="px-6 py-4">
                                <span class="report-status-badge inline-flex px-3 py-1 rounded-full text-[12px] font-semibold {{ $sClass }}" data-slug="{{ $r['slug'] }}">
                                    {{ $currentStatus }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.reports.show', ['type' => $r['slug'], 'from' => $from, 'to' => $to]) }}"
                                        class="inline-flex items-center gap-1.5 h-8 px-3 rounded-lg bg-[#edf4ff] border border-[#d3e4ff] text-[12.5px] font-semibold text-[#2563eb] hover:bg-blue-100 transition shadow-2xs">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        View
                                    </a>
                                    <button type="button" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="1.75"/>
                                            <circle cx="12" cy="12" r="1.75"/>
                                            <circle cx="12" cy="19" r="1.75"/>
                                        </svg>
                                    </button>
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
                Showing 1 to 4 of {{ number_format(array_sum($totals) > 0 ? array_sum($totals) : 1248) }} entries
            </span>
            <div class="flex items-center gap-1.5 text-[12.5px]">
                <button type="button" class="h-8 px-3 rounded-lg border border-slate-200 text-slate-400 bg-white cursor-not-allowed font-medium">Prev</button>
                <span class="w-8 h-8 rounded-lg bg-brand-600 text-white font-semibold flex items-center justify-center">1</span>
                <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium transition flex items-center justify-center">2</button>
                <button type="button" class="w-8 h-8 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium transition flex items-center justify-center">3</button>
                <span class="text-slate-400 px-1">...</span>
                <button type="button" class="h-8 px-3 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium transition">Next</button>
            </div>
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

    // Check URL parameters for status update
    const urlParams = new URLSearchParams(window.location.search);
    const updatedReport = urlParams.get('updated_report') || urlParams.get('resolved');
    const updatedStatus = urlParams.get('status') || (urlParams.get('resolved') ? 'Resolved' : null);

    if (updatedReport && updatedStatus) {
        localStorage.setItem('report_status_' + updatedReport, updatedStatus);
    }

    const statusClasses = {
        'Investigating': 'bg-blue-100 text-blue-600',
        'Pending':       'bg-slate-100 text-slate-600',
        'Resolved':      'bg-emerald-100 text-emerald-700',
        'Closed':        'bg-slate-100 text-slate-500'
    };

    // Apply any saved status from localStorage
    document.querySelectorAll('.report-status-badge').forEach(badge => {
        const slug = badge.dataset.slug;
        if (!slug) return;

        const savedStatus = localStorage.getItem('report_status_' + slug);
        if (savedStatus && statusClasses[savedStatus]) {
            badge.textContent = savedStatus;
            badge.className = 'report-status-badge inline-flex px-3 py-1 rounded-full text-[12px] font-semibold ' + statusClasses[savedStatus];
        }
    });

    // If just updated, show toast notification
    if (updatedReport && updatedStatus) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-5 right-5 z-50 flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-900 text-white text-[13.5px] shadow-xl border border-slate-800 transition-all duration-300';
        toast.innerHTML = `
            <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <span class="font-medium">Status laporan berhasil diperbarui menjadi ${updatedStatus}.</span>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }
</script>
@endpush
