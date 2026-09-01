@extends('admin.layouts.app')

@section('title', $internship['title'] . ' — Internship Details Admin')

@section('content')
<div class="space-y-6">
    {{-- Back to Internships Link --}}
    <div>
        <a href="{{ route('admin.internships.index') }}" class="inline-flex items-center gap-2 text-[13px] font-semibold text-slate-600 hover:text-slate-900 transition">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5m7 7-7-7 7-7"/>
            </svg>
            <span>Back to Internships</span>
        </a>
    </div>

    {{-- Title Header & Actions --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h1 class="text-[30px] font-extrabold text-slate-900 tracking-tight leading-tight">
                {{ $internship['title'] }}
            </h1>
            {{-- Category / Location / Type Badges --}}
            <div class="flex flex-wrap items-center gap-2.5 mt-3">
                <span class="inline-block bg-[#d9e6ff] text-[#0842a0] text-[12px] font-bold px-3.5 py-1 rounded-full">
                    {{ $internship['category'] ?? 'Engineering' }}
                </span>
                <span class="inline-block bg-slate-200/80 text-slate-700 text-[12px] font-bold px-3.5 py-1 rounded-full">
                    {{ str_contains(strtolower($internship['location']), 'remote') ? 'Remote' : 'Hybrid / Remote' }}
                </span>
                <span class="inline-block bg-slate-200/80 text-slate-700 text-[12px] font-bold px-3.5 py-1 rounded-full">
                    {{ $internship['type'] }}
                </span>
            </div>
        </div>

        {{-- Top Right Buttons --}}
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.internships.edit', $internship['id']) }}" class="inline-flex items-center justify-center bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 font-bold px-5 py-2.5 rounded-lg text-[13.5px] shadow-2xs transition">
                Edit Posting
            </a>
            <form action="{{ route('admin.internships.destroy', $internship['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus internship posting ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center bg-[#c5221f] hover:bg-red-800 text-white font-bold px-5 py-2.5 rounded-lg text-[13.5px] shadow-2xs transition">
                    Delete Listing
                </button>
            </form>
        </div>
    </div>

    {{-- Content Grid (Left Main 2/3, Right Details 1/3) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Internship Description Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-2xs">
                <h2 class="text-[18px] font-extrabold text-slate-900 pb-4 border-b border-slate-100">
                    Internship Description
                </h2>
                <div class="mt-5 text-[14px] leading-relaxed text-slate-600 whitespace-pre-line space-y-4">
                    {{ $internship['description'] }}
                </div>
            </div>

            {{-- Requirements Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-2xs">
                <h2 class="text-[18px] font-extrabold text-slate-900 pb-4 border-b border-slate-100">
                    Requirements
                </h2>
                <div class="mt-5 text-[14px] leading-relaxed text-slate-600">
                    @if (!empty($internship['requirements']))
                        <ul class="space-y-3 list-none pl-0">
                            @foreach (explode("\n", $internship['requirements']) as $line)
                                @php $cleanLine = ltrim($line, "-* "); @endphp
                                @if (trim($cleanLine))
                                    <li class="flex items-start gap-3">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#0b57d0] mt-2 shrink-0"></span>
                                        <span>{{ $cleanLine }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-slate-400">Tidak ada kualifikasi khusus yang dicantumkan.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Company Details Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
                <div class="flex items-center gap-4 pb-5 border-b border-slate-100">
                    <div class="w-14 h-14 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center shrink-0">
                        @if (!empty($internship['logo_url']))
                            <img src="{{ $internship['logo_url'] }}" alt="{{ $internship['company'] }}" class="w-full h-full object-cover">
                        @else
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="text-slate-400">
                                <rect x="4" y="3" width="16" height="18" rx="2"/>
                                <path d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-[16px] font-bold text-slate-900 leading-snug">
                            {{ $internship['company'] }}
                        </h3>
                        <p class="text-[12.5px] text-slate-500 font-medium">
                            {{ $internship['company_industry'] ?? 'Tech Enterprise' }}
                        </p>
                    </div>
                </div>

                <div class="mt-4 divide-y divide-slate-100 text-[13.5px]">
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Location</span>
                        <span class="font-bold text-slate-900 text-right">{{ $internship['location'] }}</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Company Size</span>
                        <span class="font-bold text-slate-900 text-right">{{ $internship['company_size'] }}</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Posted Date</span>
                        <span class="font-bold text-slate-900 text-right">{{ $internship['date_posted'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Application Summary Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <h3 class="text-[16px] font-bold text-slate-900">
                    Application Summary
                </h3>

                {{-- Views Stat --}}
                <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
                    <span class="text-[11px] uppercase tracking-wider font-extrabold text-[#0b57d0]">
                        TOTAL VIEWS
                    </span>
                    <span class="text-[28px] font-extrabold text-[#0842a0] leading-none">
                        {{ $internship['total_views'] ?? 124 }}
                    </span>
                </div>

                {{-- Applicants Stat --}}
                <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-4 flex items-center justify-between">
                    <span class="text-[11px] uppercase tracking-wider font-extrabold text-[#0b57d0]">
                        APPLICANTS
                    </span>
                    <span class="text-[28px] font-extrabold text-[#0842a0] leading-none">
                        {{ $internship['applicants_count'] ?? 38 }}
                    </span>
                </div>

                {{-- View Applicants Button --}}
                <a href="#" class="inline-flex items-center justify-center w-full bg-[#0b57d0] hover:bg-blue-700 text-white font-semibold text-[13.5px] py-3 rounded-xl shadow-2xs transition">
                    View Applicants
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
