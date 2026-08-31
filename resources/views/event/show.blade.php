@extends('layouts.app')

@section('title', $event['title'] . ' — IndoTech Events')

@section('content')
<div class="bg-slate-50 min-h-screen py-8" x-data="{ registered: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Back Navigation --}}
        <div>
            <a href="{{ route('event.index') }}" 
               class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-blue-600 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to All Events
            </a>
        </div>

        {{-- Hero Banner Image --}}
        <div class="w-full h-64 sm:h-80 md:h-96 rounded-2xl overflow-hidden shadow-sm bg-slate-200 relative">
            <img src="{{ $event['image'] }}" 
                 alt="{{ $event['title'] }}" 
                 class="w-full h-full object-cover">
        </div>

        {{-- Main 2-Column Content Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-2 items-start">
            
            {{-- Left Main Column --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Event Header (Tags, Title, Host) --}}
                <div class="space-y-4">
                    {{-- Badges --}}
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $event['category'] }}
                        </span>
                        @if(!empty($event['is_verified']))
                            <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full inline-flex items-center gap-1.5 border border-emerald-200/50">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Verified
                            </span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                        {{ $event['title'] }}
                    </h1>

                    {{-- Host Info --}}
                    <div class="flex items-center gap-2.5 pt-1">
                        <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs overflow-hidden shrink-0">
                            @if(!empty($event['organizer_logo']))
                                <img src="{{ $event['organizer_logo'] }}" alt="{{ $event['organizer'] }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($event['organizer'], 0, 2) }}
                            @endif
                        </div>
                        <span class="text-xs sm:text-sm font-medium text-slate-600">
                            Hosted by <strong class="text-slate-900 font-semibold">{{ $event['organizer'] }}</strong>
                        </span>
                    </div>
                </div>

                <hr class="border-slate-200">

                {{-- About This Event --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-slate-900">About This Workshop</h2>
                    
                    <div class="text-sm text-slate-600 leading-relaxed space-y-3">
                        {!! nl2br(e($event['description'])) !!}
                    </div>

                    {{-- What You'll Learn --}}
                    @if(!empty($event['what_you_will_learn']))
                        <div class="pt-4 space-y-3">
                            <h3 class="text-sm font-bold text-slate-900">What You'll Learn:</h3>
                            <ul class="space-y-2 text-sm text-slate-600">
                                @foreach($event['what_you_will_learn'] as $item)
                                    <li class="flex items-start gap-2.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-2 shrink-0"></span>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{-- Speakers Section --}}
                @if(!empty($event['speakers']))
                    <div class="space-y-4 pt-2">
                        <h2 class="text-lg font-bold text-slate-900">Speakers</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($event['speakers'] as $speaker)
                                <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-3.5 shadow-sm hover:border-slate-300 transition">
                                    <img src="{{ $speaker['avatar'] }}" 
                                         alt="{{ $speaker['name'] }}" 
                                         class="w-13 h-13 rounded-full object-cover shrink-0">
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900">{{ $speaker['name'] }}</h4>
                                        <p class="text-xs text-slate-500 font-medium leading-normal mt-0.5">{{ $speaker['role'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Certificate of Completion Box --}}
                <div class="bg-indigo-50/70 border border-indigo-100 rounded-2xl p-5 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-slate-900">Certificate of Completion</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            All participants who complete the workshop and final project will receive an industry-recognized certificate from TechLink.id.
                        </p>
                    </div>
                </div>

            </div>

            {{-- Right Sticky Sidebar (Enrollment Card) --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
                    
                    {{-- Header --}}
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-extrabold text-slate-900">Enrollment Open</h3>
                        <span class="bg-emerald-500 text-white text-xs font-semibold px-2.5 py-0.5 rounded-md">
                            Active
                        </span>
                    </div>

                    {{-- Event Meta Items --}}
                    <div class="space-y-4 text-xs text-slate-600 border-t border-b border-slate-100 py-4">
                        {{-- Date --}}
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <div>
                                <span class="font-bold text-slate-900 block">Date</span>
                                <span>{{ $event['full_date'] ?? $event['date'] }}</span>
                            </div>
                        </div>

                        {{-- Time --}}
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <div>
                                <span class="font-bold text-slate-900 block">Time</span>
                                <span>{{ $event['time'] ?? '09:00 - 16:00 (WIB)' }}</span>
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <span class="font-bold text-slate-900 block">Location</span>
                                <span>{{ $event['location'] }}</span>
                                <a href="https://maps.google.com/?q={{ urlencode($event['location']) }}" target="_blank" class="block text-blue-600 hover:underline font-semibold mt-0.5">
                                    View on Map
                                </a>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 12h10m-7 5h7"/>
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                            </svg>
                            <div>
                                <span class="font-bold text-slate-900 block">Price</span>
                                <span class="font-bold text-slate-900">{{ $event['price'] }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Registration Quota Progress Bar --}}
                    @php
                        $quota = $event['quota'] ?? 50;
                        $total = $event['total_quota'] ?? 100;
                        $percent = min(100, max(0, round(($quota / $total) * 100)));
                    @endphp
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-900">Registration Quota</span>
                            <span class="text-slate-700">{{ $quota }} / {{ $total }} Spots</span>
                        </div>

                        {{-- Progress bar container --}}
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-blue-600 h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>

                        <p class="text-[11px] text-slate-500 font-medium text-center pt-0.5">
                            Hurry, spots are almost full!
                        </p>
                    </div>

                    {{-- Action Button --}}
                    <div>
                        <button type="button" 
                                onclick="alert('Successfully registered for {{ addslashes($event['title']) }}! We have sent a confirmation email with event details.')"
                                class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-bold py-3 px-4 rounded-xl text-sm transition shadow-sm">
                            Register for Event
                        </button>
                    </div>

                    {{-- Footnote --}}
                    <p class="text-[11px] text-slate-400 text-center">
                        Requires a TechLink.id account to register.
                    </p>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
