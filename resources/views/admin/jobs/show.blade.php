@extends('admin.layouts.app')

@section('title', $job['title'] . ' — Detail Lowongan Admin')

@section('content')
<div class="space-y-6">
    {{-- Back to Jobs Link --}}
    <div>
        <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center gap-2 text-[13px] font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5m7 7-7-7 7-7"/>
            </svg>
            <span>Kembali ke Daftar Lowongan</span>
        </a>
    </div>

    {{-- Title Header & Actions --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h1 class="text-[30px] font-extrabold text-slate-900 tracking-tight leading-tight">
                {{ $job['title'] }}
            </h1>
            {{-- Category / Location / Type Badges --}}
            <div class="flex flex-wrap items-center gap-2.5 mt-3">
                <span class="inline-block bg-[#d9e6ff] text-brand-700 text-[12px] font-bold px-3.5 py-1 rounded-full">
                    {{ $job['category'] ?? 'Engineering' }}
                </span>
                <span class="inline-block bg-slate-200/80 text-slate-700 text-[12px] font-bold px-3.5 py-1 rounded-full">
                    {{ str_contains(strtolower($job['location']), 'remote') ? 'Remote' : 'Hybrid / Remote' }}
                </span>
                <span class="inline-block bg-slate-200/80 text-slate-700 text-[12px] font-bold px-3.5 py-1 rounded-full">
                    {{ $job['type'] }}
                </span>
            </div>
        </div>

        {{-- Top Right Buttons --}}
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.jobs.edit', $job['id']) }}" class="inline-flex items-center justify-center bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 font-bold px-5 py-2.5 rounded-lg text-[13.5px] shadow-2xs transition">
                Edit Lowongan
            </a>
            <form action="{{ route('admin.jobs.destroy', $job['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan pekerjaan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-lg text-[13.5px] shadow-2xs transition">
                    Hapus Lowongan
                </button>
            </form>
        </div>
    </div>

    {{-- Content Grid (Left Main 2/3, Right Details 1/3) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Job Banner / Image Card --}}
            @if (!empty($job['image']) || !empty($job['logo_url']))
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-2xs">
                    <img src="{{ $job['image'] ?? $job['logo_url'] }}" alt="{{ $job['title'] }}" class="w-full h-56 sm:h-72 object-cover">
                </div>
            @endif

            {{-- Job Description Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-2xs">
                <h2 class="text-[18px] font-extrabold text-slate-900 pb-4 border-b border-slate-100">
                    Deskripsi Pekerjaan
                </h2>
                <div class="mt-5 text-[14px] leading-relaxed text-slate-600 whitespace-pre-line space-y-4">
                    {{ $job['description'] }}
                </div>
            </div>

            {{-- Kualifikasi & Persyaratan Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-2xs">
                <h2 class="text-[18px] font-extrabold text-slate-900 pb-4 border-b border-slate-100 flex items-center gap-2">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <span>Kualifikasi &amp; Persyaratan</span>
                </h2>
                <div class="mt-5 text-[14px] leading-relaxed text-slate-600">
                    @php
                        $reqList = [];
                        if (!empty($job['requirements'])) {
                            if (is_array($job['requirements'])) {
                                $reqList = $job['requirements'];
                            } else {
                                foreach (explode("\n", (string) $job['requirements']) as $line) {
                                    $clean = trim(ltrim($line, "-* "));
                                    if ($clean) $reqList[] = $clean;
                                }
                            }
                        }
                    @endphp

                    @if (!empty($reqList))
                        <ul class="space-y-2.5 list-none pl-0">
                            @foreach ($reqList as $item)
                                <li class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 mt-2 shrink-0"></span>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-slate-400">Tidak ada persyaratan khusus yang dicantumkan.</p>
                    @endif
                </div>
            </div>

            {{-- Tanggung Jawab Pekerjaan Card --}}
            @if (!empty($job['responsibilities']) && is_array($job['responsibilities']))
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-2xs">
                    <h2 class="text-[18px] font-extrabold text-slate-900 pb-4 border-b border-slate-100 flex items-center gap-2">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 20.015A9.753 9.753 0 0 1 12 21.75c-5.385 0-9.75-4.365-9.75-9.75s4.365-9.75 9.75-9.75 9.75 4.365 9.75 9.75c0 1.956-.575 3.776-1.564 5.305m-3.436-1.84c.75-.75 1.72-1.28 2.804-1.51M9 10.5a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0Zm-6 9c0-3.314 3.134-6 7-6 1.834 0 3.497.607 4.743 1.589"/></svg>
                        <span>Tanggung Jawab Pekerjaan</span>
                    </h2>
                    <div class="mt-5 text-[14px] leading-relaxed text-slate-600">
                        <ul class="space-y-2.5 list-none pl-0">
                            @foreach ($job['responsibilities'] as $resp)
                                <li class="flex items-start gap-3">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 mt-2 shrink-0"></span>
                                    <span>{{ $resp }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Skills / Tags Card --}}
            @if (!empty($job['skills']) && is_array($job['skills']))
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-2xs">
                    <h2 class="text-[18px] font-extrabold text-slate-900 pb-4 border-b border-slate-100 flex items-center gap-2">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/></svg>
                        <span>Skills &amp; Keahlian</span>
                    </h2>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($job['skills'] as $skill)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12.5px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Company Details Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
                <div class="flex items-center gap-4 pb-5 border-b border-slate-100">
                    <div class="w-14 h-14 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center shrink-0">
                        @if (!empty($job['image']) || !empty($job['logo_url']))
                            <img src="{{ $job['image'] ?? $job['logo_url'] }}" alt="{{ $job['company'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center font-bold text-white text-[18px]" style="background: {{ $job['logo_color'] ?? '#2563eb' }}">
                                {{ $job['logo_text'] ?? strtoupper(substr($job['company'], 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-[16px] font-bold text-slate-900 leading-snug">
                            {{ $job['company'] }}
                        </h3>
                        <p class="text-[12.5px] text-slate-500 font-medium">
                            {{ $job['company_industry'] ?? 'Enterprise Software' }}
                        </p>
                    </div>
                </div>

                <div class="mt-4 divide-y divide-slate-100 text-[13.5px]">
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Lokasi</span>
                        <span class="font-bold text-slate-900 text-right">{{ $job['location'] }}</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Ukuran Perusahaan</span>
                        <span class="font-bold text-slate-900 text-right">{{ $job['company_size'] }}</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Tanggal Tayang</span>
                        <span class="font-bold text-slate-900 text-right">{{ $job['date_posted'] }}</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Batas Waktu Lamaran</span>
                        <span class="font-bold text-red-600 text-right flex items-center gap-1.5">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                            {{ $job['deadline'] ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Application Summary Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <h3 class="text-[16px] font-bold text-slate-900">
                    Ringkasan Lamaran
                </h3>

                {{-- Views Stat --}}
                <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
                    <span class="text-[11px] uppercase tracking-wider font-extrabold text-brand-600">
                        TOTAL DILIHAT
                    </span>
                    <span class="text-[28px] font-extrabold text-brand-700 leading-none">
                        {{ $job['total_views'] ?? 42 }}
                    </span>
                </div>

                {{-- Applicants Stat --}}
                <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
                    <span class="text-[11px] uppercase tracking-wider font-extrabold text-brand-600">
                        TOTAL PELAMAR
                    </span>
                    <span class="text-[28px] font-extrabold text-brand-700 leading-none">
                        {{ $job['applicants_count'] ?? 12 }}
                    </span>
                </div>

                {{-- View Applicants Button --}}
                <a href="#" class="inline-flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[13.5px] py-3 rounded-xl shadow-2xs transition">
                    Lihat Daftar Pelamar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
