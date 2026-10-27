@extends('admin.layouts.app')

@section('title', 'Reports — IndoTech Admin')

@section('content')
<div class="space-y-6">
    {{-- Report Management --}}
    <section class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
        <div class="flex items-start justify-between gap-4 mb-5">
            <div>
                <h2 class="text-[16px] font-bold text-slate-900">Report Generation</h2>
                <p class="text-[12.5px] text-slate-500">Filter dan buat laporan analitik platform dari data terbaru</p>
            </div>
            <button id="generate-report" type="button" class="inline-flex items-center gap-2 h-9 px-4 rounded-xl bg-brand-600 text-white text-[13px] font-semibold hover:bg-blue-700 shadow-xs transition">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Generate Report
            </button>
        </div>

        <form id="report-filter-form" method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label for="report-type" class="block text-[12px] font-medium text-slate-600 mb-1">Type</label>
                <select id="report-type" name="type" class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
                    <option value="">All types</option>
                    @foreach ($reports as $report)
                        <option value="{{ $report['slug'] }}" @selected($activeType === $report['slug'])>{{ $report['type'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="report-from" class="block text-[12px] font-medium text-slate-600 mb-1">From</label>
                <input id="report-from" name="from" type="date" value="{{ $from }}" class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
            </div>
            <div>
                <label for="report-to" class="block text-[12px] font-medium text-slate-600 mb-1">To</label>
                <input id="report-to" name="to" type="date" value="{{ $to }}" class="w-full h-9 rounded-lg border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-700 outline-none focus:border-blue-500 focus:bg-white">
            </div>
        </form>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mt-5">
            @foreach ($totals as $label => $value)
                <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3">
                    <div class="text-[20px] font-extrabold text-slate-800 leading-none">{{ number_format($value) }}</div>
                    <div class="text-[12px] text-slate-500 mt-1">Total {{ $label }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Recent Reports --}}
    <section class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">Recent Reports</h2>
                <p class="text-[12px] text-slate-500">Laporan terbaru yang siap diunduh</p>
            </div>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach ($recent as $r)
                <a href="{{ route('admin.reports.show', ['type' => $r['slug'], 'from' => $from, 'to' => $to]) }}" class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50/70 transition">
                    <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M4 20V10m5 10V4m5 16v-7m5 7V8"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13.5px] font-semibold text-slate-900 truncate">{{ $r['title'] }}</div>
                        <div class="text-[12px] text-slate-500">{{ $r['id'] }} · {{ number_format($r['records']) }} records · {{ $r['period'] }}</div>
                    </div>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold bg-emerald-50 text-emerald-600">Ready</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Export History --}}
    <section class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">Export History</h2>
                <p class="text-[12px] text-slate-500">Arsip laporan yang sudah diunduh admin</p>
            </div>
            <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold bg-slate-100 text-slate-600">{{ number_format($exports->total()) }} total</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[12px] uppercase tracking-wide text-slate-500">
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
                                'pdf' => 'bg-rose-50 text-rose-600',
                                'xlsx' => 'bg-emerald-50 text-emerald-600',
                                default => 'bg-blue-50 text-blue-600',
                            };
                            $exportQuery = array_filter([
                                'type' => $export->type,
                                'from' => $export->period_from?->toDateString(),
                                'to' => $export->period_to?->toDateString(),
                            ]);
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-3.5 text-slate-500 whitespace-nowrap">{{ $export->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-3.5">
                                <div class="font-semibold text-slate-900">{{ $definition['title'] ?? strtoupper($export->type) }}</div>
                                <div class="text-[12px] text-slate-400">{{ $export->file_name }}</div>
                            </td>
                            <td class="px-6 py-3.5 text-slate-500 whitespace-nowrap">
                                {{ $export->period_from?->format('d M Y') ?? 'Beginning' }} - {{ $export->period_to?->format('d M Y') ?? 'Now' }}
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold uppercase {{ $formatClass }}">{{ $export->format }}</span>
                            </td>
                            <td class="px-6 py-3.5 text-slate-600">{{ number_format($export->rows_count) }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $export->user?->name ?? 'System' }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('admin.reports.show', $exportQuery) }}" class="text-[13px] font-semibold text-brand-600 hover:underline">Buka</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-500">Belum ada riwayat export.</td>
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
    </section>

    {{-- View Reports --}}
    <section class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="text-[15px] font-bold text-slate-900">All Reports</h2>
                <p class="text-[12px] text-slate-500">Daftar laporan yang tersedia</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[12px] uppercase tracking-wide text-slate-500">
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
                            <td class="px-6 py-3.5 font-medium text-slate-500">{{ $r['id'] }}</td>
                            <td class="px-6 py-3.5 font-semibold text-slate-900">{{ $r['title'] }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ $r['type'] }}</td>
                            <td class="px-6 py-3.5 text-slate-500">{{ $r['period'] }}</td>
                            <td class="px-6 py-3.5 text-slate-600">{{ number_format($r['records']) }}</td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[12px] font-semibold bg-emerald-50 text-emerald-600">Ready</span>
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('admin.reports.show', ['type' => $r['slug'], 'from' => $from, 'to' => $to]) }}" class="text-[13px] font-semibold text-brand-600 hover:underline">View Detail →</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('generate-report')?.addEventListener('click', function () {
        const type = document.getElementById('report-type').value;
        const from = document.getElementById('report-from').value;
        const to = document.getElementById('report-to').value;
        const params = new URLSearchParams();

        if (from) params.set('from', from);
        if (to) params.set('to', to);

        if (type) {
            const query = params.toString();
            window.location.href = `{{ url('/admin/reports') }}/${type}${query ? '?' + query : ''}`;
            return;
        }

        document.getElementById('report-filter-form').submit();
    });
</script>
@endpush
