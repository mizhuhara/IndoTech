@extends('admin.layouts.app')

@section('title', $report['title'].' — IndoTech Admin')

@section('content')
<div class="space-y-6 max-w-6xl">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.reports.index', ['from' => $from, 'to' => $to]) }}" class="h-9 px-4 inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white text-[13px] font-semibold text-slate-700 hover:bg-slate-50 transition shadow-2xs">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Laporan
        </a>

        <a href="{{ route('admin.reports.export', ['type' => $report['slug'], 'from' => $from, 'to' => $to]) }}"
           class="h-9 px-4 inline-flex items-center gap-2 rounded-xl bg-[#0b57d0] text-white text-[13px] font-semibold hover:bg-blue-700 transition shadow-xs">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M4 21h16"/></svg>
            Export CSV
        </a>
    </div>

    <section class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[12px] font-bold">{{ $report['id'] }}</span>
                <span class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[12px] font-bold">{{ $report['type'] }}</span>
                <span class="text-[12px] text-slate-500">{{ $report['period'] }}</span>
            </div>
            <h2 class="mt-3 text-[18px] font-bold text-slate-900">{{ $report['title'] }}</h2>
            <p class="mt-1.5 text-[14px] text-slate-600 leading-relaxed">{{ $report['summary'] }}</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 p-6">
            @foreach ($report['stats'] as $label => $value)
                <div class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3">
                    <div class="text-[22px] font-extrabold text-slate-800 leading-none">{{ number_format((int) $value) }}</div>
                    <div class="text-[12px] text-slate-500 mt-1">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h3 class="text-[14px] font-bold text-slate-900">Report Data</h3>
                <p class="text-[12px] text-slate-500">
                    {{ number_format($report['totalRows']) }} records
                    @if (count($report['rows']) > count($rows))
                        · menampilkan {{ count($rows) }} terbaru
                    @endif
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[12px] uppercase tracking-wide text-slate-500">
                        @foreach ($report['columns'] as $label)
                            <th class="px-6 py-3.5 font-semibold">{{ $label }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @forelse ($rows as $row)
                        <tr class="hover:bg-slate-50/70 transition">
                            @foreach (array_keys($report['columns']) as $column)
                                <td class="px-6 py-3.5 text-slate-600">{{ $row[$column] ?? '-' }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($report['columns']) }}" class="px-6 py-10 text-center text-slate-500">
                                Belum ada data untuk filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
