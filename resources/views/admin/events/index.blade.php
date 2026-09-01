@extends('admin.layouts.app')

@section('title', 'Event Verification — IndoTech Admin')

@section('content')
<div class="space-y-6">

    {{-- Page Header: Title & Subtitle --}}
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            Event Verification
        </h1>
        <p class="text-sm font-medium text-slate-500 mt-1">
            Review and approve pending event requests from partners.
        </p>
    </div>

    {{-- Main Container Card --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 sm:p-7 shadow-xs space-y-6">

        {{-- Filter Toolbar: Segmented Pills + Search --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            {{-- Left: Filter By Pills --}}
            <div class="flex items-center gap-3 overflow-x-auto pb-1 md:pb-0">
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider shrink-0 select-none">
                    FILTER BY:
                </span>

                <div class="inline-flex items-center p-1 bg-slate-100/90 rounded-xl gap-1 shrink-0">
                    {{-- All Types --}}
                    <a href="{{ route('admin.events.index', array_filter(['type' => 'all', 'q' => request('q')])) }}" 
                       class="px-4 py-1.5 rounded-lg text-xs font-bold transition {{ $activeType === 'all' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        All Types
                    </a>

                    {{-- School --}}
                    <a href="{{ route('admin.events.index', array_filter(['type' => 'school', 'q' => request('q')])) }}" 
                       class="px-4 py-1.5 rounded-lg text-xs font-bold transition {{ $activeType === 'school' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        School
                    </a>

                    {{-- University --}}
                    <a href="{{ route('admin.events.index', array_filter(['type' => 'university', 'q' => request('q')])) }}" 
                       class="px-4 py-1.5 rounded-lg text-xs font-bold transition {{ $activeType === 'university' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        University
                    </a>

                    {{-- Company --}}
                    <a href="{{ route('admin.events.index', array_filter(['type' => 'company', 'q' => request('q')])) }}" 
                       class="px-4 py-1.5 rounded-lg text-xs font-bold transition {{ $activeType === 'company' ? 'bg-white text-blue-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                        Company
                    </a>
                </div>
            </div>

            {{-- Right: Search Input --}}
            <form method="GET" action="{{ route('admin.events.index') }}" class="w-full md:w-auto shrink-0">
                @if(request()->has('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <div class="relative flex items-center">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" 
                           name="q" 
                           value="{{ $searchQuery }}" 
                           placeholder="Search events..." 
                           class="w-full md:w-64 bg-slate-50/70 border border-slate-200/90 rounded-xl pl-9 pr-4 py-2 text-xs font-medium text-slate-700 placeholder-slate-400 outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
            </form>

        </div>

        {{-- Table Component --}}
        <div class="overflow-x-auto border-t border-slate-100 pt-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-[11px] font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-3.5 pr-4 font-extrabold">EVENT NAME</th>
                        <th class="pb-3.5 px-4 font-extrabold">ORGANIZER</th>
                        <th class="pb-3.5 px-4 font-extrabold">TYPE</th>
                        <th class="pb-3.5 px-4 font-extrabold">PROPOSED DATE</th>
                        <th class="pb-3.5 px-4 font-extrabold">STATUS</th>
                        <th class="pb-3.5 pl-4 text-right font-extrabold">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($events as $event)
                        <tr class="hover:bg-slate-50/60 transition">
                            {{-- Event Name --}}
                            <td class="py-4 pr-4">
                                <span class="font-extrabold text-slate-900 text-[13.5px] block">
                                    {{ $event['title'] }}
                                </span>
                            </td>

                            {{-- Organizer --}}
                            <td class="py-4 px-4">
                                <span class="text-slate-600 font-medium text-[13px]">
                                    {{ $event['organizer'] }}
                                </span>
                            </td>

                            {{-- Type Badge --}}
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11.5px] font-semibold bg-indigo-50/80 text-indigo-700 border border-indigo-100/90">
                                    {{ $event['type'] }}
                                </span>
                            </td>

                            {{-- Proposed Date --}}
                            <td class="py-4 px-4">
                                <span class="text-slate-600 font-medium text-[13px]">
                                    {{ $event['proposed_date'] }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="py-4 px-4">
                                @if($event['status'] === 'Pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11.5px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Pending
                                    </span>
                                @elseif($event['status'] === 'Approved')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11.5px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11.5px] font-bold bg-rose-50 text-rose-700 border border-rose-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Rejected
                                    </span>
                                @endif
                            </td>

                            {{-- Action Buttons (Eye Detail Icon Link + Approve + Reject) --}}
                            <td class="py-4 pl-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Eye Detail Link Button --}}
                                    <a href="{{ route('admin.events.show', $event['id']) }}" 
                                       title="Lihat Detail Event"
                                       class="bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 font-bold text-xs p-2 rounded-lg inline-flex items-center justify-center transition shadow-2xs">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>

                                    {{-- Approve Form --}}
                                    <form action="{{ route('admin.events.approve', $event['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/90 font-bold text-xs px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition shadow-2xs">
                                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 6L9 17l-5-5"/>
                                            </svg>
                                            <span>Approve</span>
                                        </button>
                                    </form>

                                    {{-- Reject Form --}}
                                    <form action="{{ route('admin.events.reject', $event['id']) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/90 font-bold text-xs px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition shadow-2xs">
                                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18 6L6 18M6 6l12 12"/>
                                            </svg>
                                            <span>Reject</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400 font-medium">
                                No event requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer / Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100 text-xs font-semibold text-slate-500">
            <div>
                Showing 1 to {{ count($events) }} of {{ $totalEntries }} entries
            </div>

            {{-- Pagination Controls --}}
            <div class="flex items-center gap-1.5">
                <button disabled class="px-3 py-1.5 border border-slate-200 rounded-lg text-slate-400 opacity-60 text-xs font-semibold cursor-not-allowed">
                    Prev
                </button>
                <button class="px-3.5 py-1.5 bg-[#0b57d0] text-white rounded-lg text-xs font-bold shadow-2xs">
                    1
                </button>
                <button disabled class="px-3 py-1.5 border border-slate-200 rounded-lg text-slate-400 opacity-60 text-xs font-semibold cursor-not-allowed">
                    Next
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
