@extends('admin.layouts.app')

@section('title', 'Job Management — Admin IndoTech')

@section('content')
<div class="space-y-6">
    {{-- Search Bar in Content / Header Area --}}
    <div class="bg-white rounded-xl border border-slate-200/80 px-4 py-2.5 shadow-2xs flex items-center gap-3">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
        </svg>
        <form action="{{ route('admin.jobs.index') }}" method="GET" class="flex-1">
            <input type="text" 
                   name="search"
                   value="{{ $search ?? '' }}" 
                   placeholder="Search jobs, companies, or IDs..." 
                   class="w-full bg-transparent text-[13.5px] text-slate-800 placeholder-slate-400 focus:outline-none"
                   onchange="this.form.submit()">
        </form>
    </div>

    {{-- Title & Action Button --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-[26px] font-extrabold text-slate-900 tracking-tight">Job Management</h1>
            <p class="text-[13.5px] text-slate-500 mt-0.5">Manage and track all job postings across the platform.</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#0b57d0] hover:bg-blue-700 text-white font-semibold text-[13.5px] px-5 py-2.5 rounded-lg shadow-xs transition">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.8"><path d="M12 5v14M5 12h14"/></svg>
            <span>POST NEW JOB</span>
        </a>
    </div>

    {{-- Stats Cards (3 Columns) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Total Postings --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
            <div class="text-[11.5px] font-bold text-slate-400 uppercase tracking-wider">TOTAL POSTINGS</div>
            <div class="text-[32px] font-extrabold text-slate-900 tracking-tight leading-tight mt-2.5">{{ $totalPostings }}</div>
            <div class="mt-2.5 flex items-center gap-1.5 text-[12.5px] font-semibold text-emerald-600">
                <span class="font-bold">+12%</span>
                <span class="text-slate-400 font-normal">from last month</span>
            </div>
        </div>

        {{-- Active Jobs --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
            <div class="text-[11.5px] font-bold text-slate-400 uppercase tracking-wider">ACTIVE JOBS</div>
            <div class="text-[32px] font-extrabold text-slate-900 tracking-tight leading-tight mt-2.5">{{ $activeJobs }}</div>
            <div class="mt-2.5 flex items-center gap-1.5 text-[12.5px] font-semibold text-emerald-600">
                <span class="font-bold">+5%</span>
                <span class="text-slate-400 font-normal">from last month</span>
            </div>
        </div>

        {{-- Applications --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs">
            <div class="text-[11.5px] font-bold text-slate-400 uppercase tracking-wider">APPLICATIONS</div>
            <div class="text-[32px] font-extrabold text-slate-900 tracking-tight leading-tight mt-2.5">{{ $applicationsCount }}</div>
            <div class="mt-2.5 flex items-center gap-1.5 text-[12.5px] font-semibold text-emerald-600">
                <span class="font-bold">+24%</span>
                <span class="text-slate-400 font-normal">from last month</span>
            </div>
        </div>
    </div>

    {{-- Main Table Container --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        {{-- Filter Tabs and Actions Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between px-6 border-b border-slate-200/80 gap-4 pt-2">
            {{-- Nav Tabs --}}
            <div class="flex items-center gap-6 text-[13px] font-bold">
                <a href="{{ route('admin.jobs.index', ['tab' => 'all']) }}" 
                   class="py-3.5 border-b-2 transition relative {{ $currentTab === 'all' ? 'border-[#0b57d0] text-[#0b57d0]' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    ALL JOBS
                </a>
                <a href="{{ route('admin.jobs.index', ['tab' => 'active']) }}" 
                   class="py-3.5 border-b-2 transition relative {{ $currentTab === 'active' ? 'border-[#0b57d0] text-[#0b57d0]' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    ACTIVE
                </a>
                <a href="{{ route('admin.jobs.index', ['tab' => 'drafts']) }}" 
                   class="py-3.5 border-b-2 transition relative {{ $currentTab === 'drafts' ? 'border-[#0b57d0] text-[#0b57d0]' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    DRAFTS
                </a>
                <a href="{{ route('admin.jobs.index', ['tab' => 'closed']) }}" 
                   class="py-3.5 border-b-2 transition relative {{ $currentTab === 'closed' ? 'border-[#0b57d0] text-[#0b57d0]' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    CLOSED
                </a>
            </div>

            {{-- Right Actions (Filter & Export) --}}
            <div class="flex items-center gap-4 py-3 text-[12.5px] font-bold text-slate-500">
                <button type="button" class="flex items-center gap-1.5 hover:text-slate-800 transition">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18m-15 5h12m-9 5h6m-3 5h0"/></svg>
                    <span>FILTER</span>
                </button>
                <button type="button" class="flex items-center gap-1.5 hover:text-slate-800 transition">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 12 12 16.5m0 0 4.5-4.5M12 16.5v-13.5"/></svg>
                    <span>EXPORT</span>
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50/50">
                        <th class="py-4 pl-6 pr-3 w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="py-4 px-4 font-bold">JOB TITLE</th>
                        <th class="py-4 px-4 font-bold">COMPANY / PROVIDER</th>
                        <th class="py-4 px-4 font-bold">TYPE</th>
                        <th class="py-4 px-4 font-bold">DATE POSTED</th>
                        <th class="py-4 px-4 font-bold">STATUS</th>
                        <th class="py-4 pr-6 pl-4 font-bold text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @forelse ($jobs as $job)
                        <tr class="hover:bg-slate-50/80 transition group">
                            <td class="py-4 pl-6 pr-3">
                                <input type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('admin.jobs.show', $job['id']) }}" class="font-bold text-slate-900 hover:text-[#0b57d0] transition block leading-tight">
                                    {{ $job['title'] }}
                                </a>
                                <span class="text-[11.5px] text-slate-400 font-medium block mt-0.5">
                                    ID: {{ $job['code'] }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-700">
                                {{ $job['company'] }}
                            </td>
                            <td class="py-4 px-4 text-slate-600 font-medium">
                                {{ $job['type'] }}
                            </td>
                            <td class="py-4 px-4 text-slate-500 font-medium">
                                {{ $job['date_posted'] }}
                            </td>
                            <td class="py-4 px-4">
                                @if ($job['status'] === 'Active')
                                    <span class="font-bold text-emerald-600 text-[13px]">Active</span>
                                @elseif ($job['status'] === 'Paused')
                                    <span class="font-bold text-amber-500 text-[13px]">Paused</span>
                                @elseif ($job['status'] === 'Draft')
                                    <span class="font-bold text-slate-400 text-[13px]">Draft</span>
                                @else
                                    <span class="font-bold text-red-500 text-[13px]">Closed</span>
                                @endif
                            </td>
                            <td class="py-4 pr-6 pl-4 text-right">
                                <div class="flex items-center justify-end gap-3 text-slate-400">
                                    {{-- View Icon --}}
                                    <a href="{{ route('admin.jobs.show', $job['id']) }}" class="hover:text-slate-700 transition" title="View Job">
                                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.573 16.49 16.638 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    {{-- Edit Icon --}}
                                    <a href="{{ route('admin.jobs.edit', $job['id']) }}" class="hover:text-blue-600 transition" title="Edit Job">
                                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                        </svg>
                                    </a>
                                    {{-- Delete Icon --}}
                                    <form action="{{ route('admin.jobs.destroy', $job['id']) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus job listing ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-red-600 transition" title="Delete Job">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-[13.5px]">
                                Tidak ada data job posting yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Pagination --}}
        <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-[13px] text-slate-500">
            <div>
                Showing <span class="font-semibold text-slate-800">1</span> to <span class="font-semibold text-slate-800">10</span> of <span class="font-semibold text-slate-800">4,285</span> jobs
            </div>
            <div class="flex items-center gap-1.5 font-semibold">
                <a href="#" class="px-2.5 py-1 text-slate-400 hover:text-slate-700 transition">&lt; Prev</a>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#0b57d0] text-white shadow-2xs font-bold">1</a>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-600 transition">2</a>
                <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-600 transition">3</a>
                <span class="px-1 text-slate-400">...</span>
                <a href="#" class="px-2.5 py-1 text-slate-600 hover:text-slate-900 transition">Next &gt;</a>
            </div>
        </div>
    </div>
</div>
@endsection
