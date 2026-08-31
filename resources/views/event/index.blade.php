@extends('layouts.app')

@section('title', 'Events — IndoTech')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                Discover Tech Events
            </h1>
            <p class="text-slate-600 text-base max-w-2xl leading-relaxed">
                Connect, learn, and grow with Indonesia's tech community. Discover seminars, workshops, and hackathons tailored for your career advancement.
            </p>
        </div>

        {{-- Category Pills Row --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 no-scrollbar [&::-webkit-scrollbar]:hidden" style="scrollbar-width: none; -ms-overflow-style: none;">
            @foreach($categories as $cat)
                @php
                    $isActive = strtolower($activeCategory) === strtolower($cat);
                @endphp
                <a href="{{ route('event.index', ['category' => strtolower($cat)]) }}" 
                   class="px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap transition-all duration-150 {{ $isActive ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- Main Layout (Filters Sidebar + Events Grid) --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            
            {{-- Left Sidebar Filters --}}
            <form action="{{ route('event.index') }}" method="GET" class="space-y-6">
                <input type="hidden" name="category" value="{{ $activeCategory }}">

                {{-- Date Filter --}}
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Date
                    </h3>
                    <div class="space-y-2">
                        @foreach(['This week', 'Next week', 'This month'] as $dateOpt)
                            <label class="flex items-center gap-2 text-xs font-medium text-slate-600 cursor-pointer hover:text-slate-900">
                                <input type="checkbox" name="date[]" value="{{ $dateOpt }}" 
                                       onchange="this.form.submit()"
                                       {{ in_array($dateOpt, (array) request('date')) ? 'checked' : '' }}
                                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                {{ $dateOpt }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Location Filter --}}
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Location
                    </h3>
                    <div class="space-y-2">
                        @foreach(['Jakarta', 'Bandung', 'Remote'] as $locOpt)
                            <label class="flex items-center gap-2 text-xs font-medium text-slate-600 cursor-pointer hover:text-slate-900">
                                <input type="checkbox" name="location[]" value="{{ $locOpt }}"
                                       onchange="this.form.submit()"
                                       {{ in_array($locOpt, (array) request('location')) ? 'checked' : '' }}
                                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                {{ $locOpt }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Price Filter --}}
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 12h10m-7 5h7"/>
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                        </svg>
                        Price
                    </h3>
                    <div class="space-y-2">
                        @foreach(['Free', 'Paid'] as $priceOpt)
                            <label class="flex items-center gap-2 text-xs font-medium text-slate-600 cursor-pointer hover:text-slate-900">
                                <input type="checkbox" name="price[]" value="{{ $priceOpt }}"
                                       onchange="this.form.submit()"
                                       {{ in_array($priceOpt, (array) request('price')) ? 'checked' : '' }}
                                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                {{ $priceOpt }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Organizer Type Filter --}}
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0v-5a2 2 0 012-2h2a2 2 0 012 2v5m-6 0h6"/>
                        </svg>
                        Organizer Type
                    </h3>
                    <div class="space-y-2">
                        @foreach(['University', 'Tech Company', 'Community'] as $orgOpt)
                            <label class="flex items-center gap-2 text-xs font-medium text-slate-600 cursor-pointer hover:text-slate-900">
                                <input type="checkbox" name="organizer_type[]" value="{{ $orgOpt }}"
                                       onchange="this.form.submit()"
                                       {{ in_array($orgOpt, (array) request('organizer_type')) ? 'checked' : '' }}
                                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                {{ $orgOpt }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Clear Filters Button --}}
                <div>
                    <a href="{{ route('event.index') }}" 
                       class="block w-full text-center py-2.5 px-4 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                        Clear Filters
                    </a>
                </div>
            </form>

            {{-- Right Main Content (Event Cards Grid + Pagination) --}}
            <div class="lg:col-span-3 space-y-8">
                
                @if(count($events) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($events as $event)
                            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                                <div>
                                    {{-- Image & Mode Badge --}}
                                    <div class="relative h-44 w-full bg-slate-100 overflow-hidden">
                                        <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        
                                        {{-- Mode Pill Badge (Top Left) --}}
                                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full flex items-center gap-1.5 shadow-sm">
                                            <span class="w-2 h-2 rounded-full {{ $event['mode_color'] }}"></span>
                                            <span class="text-[11px] font-semibold text-slate-800">{{ $event['mode'] }}</span>
                                        </div>
                                    </div>

                                    {{-- Card Content --}}
                                    <div class="p-4 space-y-3">
                                        {{-- Category Tag & Price Badge --}}
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="text-[11px] font-extrabold tracking-wider text-blue-600 uppercase">
                                                {{ $event['category_tag'] }}
                                            </span>
                                            <span class="bg-slate-100 text-slate-700 text-[11px] font-semibold px-2.5 py-0.5 rounded-md">
                                                {{ $event['price'] }}
                                            </span>
                                        </div>

                                        {{-- Title --}}
                                        <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-blue-600 transition">
                                            <a href="{{ route('event.show', $event['id']) }}">
                                                {{ $event['title'] }}
                                            </a>
                                        </h3>

                                        {{-- Organizer --}}
                                        <p class="text-xs text-slate-500 font-medium">
                                            {{ $event['organizer'] }}
                                        </p>

                                        {{-- Meta Information (Date & Location) --}}
                                        <div class="pt-2 space-y-1.5 border-t border-slate-100 text-xs text-slate-500">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                                </svg>
                                                <span>{{ $event['date'] }}</span>
                                            </div>

                                            @if(!empty($event['location']))
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    <span class="truncate">{{ $event['location'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Card Action Button --}}
                                <div class="p-4 pt-0">
                                    <a href="{{ route('event.show', $event['id']) }}" 
                                       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl text-xs shadow-sm transition">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-base font-bold text-slate-800">No Events Found</h3>
                        <p class="text-xs text-slate-500 mt-1">Try adjusting your filters or search keywords.</p>
                        <a href="{{ route('event.index') }}" class="inline-block mt-4 text-xs font-semibold text-blue-600 hover:underline">
                            Reset Filters
                        </a>
                    </div>
                @endif

                {{-- Pagination Component --}}
                @php
                    $curr = $currentPage ?? 1;
                    $maxP = $totalPages ?? 3;
                    $queryParams = request()->query();
                @endphp
                <div class="flex items-center justify-center gap-1.5 pt-4">
                    {{-- Prev --}}
                    @if($curr > 1)
                        <a href="{{ route('event.index', array_merge($queryParams, ['page' => $curr - 1])) }}" 
                           class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center text-xs font-semibold transition">
                            &lsaquo;
                        </a>
                    @else
                        <span class="w-8 h-8 rounded-lg border border-slate-200 text-slate-300 flex items-center justify-center text-xs opacity-50 cursor-not-allowed">
                            &lsaquo;
                        </span>
                    @endif

                    {{-- Page 1 --}}
                    <a href="{{ route('event.index', array_merge($queryParams, ['page' => 1])) }}" 
                       class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs transition {{ $curr === 1 ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                        1
                    </a>

                    {{-- Page 2 --}}
                    <a href="{{ route('event.index', array_merge($queryParams, ['page' => 2])) }}" 
                       class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs transition {{ $curr === 2 ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                        2
                    </a>

                    {{-- Page 3 --}}
                    <a href="{{ route('event.index', array_merge($queryParams, ['page' => 3])) }}" 
                       class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs transition {{ $curr === 3 ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                        3
                    </a>

                    @if($maxP > 3)
                        <span class="px-1 text-slate-400 text-xs">...</span>
                        <a href="{{ route('event.index', array_merge($queryParams, ['page' => $maxP])) }}" 
                           class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs transition {{ $curr === $maxP ? 'bg-blue-600 text-white shadow-sm' : 'border border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                            {{ $maxP }}
                        </a>
                    @endif

                    {{-- Next --}}
                    @if($curr < $maxP)
                        <a href="{{ route('event.index', array_merge($queryParams, ['page' => $curr + 1])) }}" 
                           class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center text-xs font-semibold transition">
                            &rsaquo;
                        </a>
                    @else
                        <span class="w-8 h-8 rounded-lg border border-slate-200 text-slate-300 flex items-center justify-center text-xs opacity-50 cursor-not-allowed">
                            &rsaquo;
                        </span>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
