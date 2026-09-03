@extends('layouts.app')

@section('title', 'IndoTech — Connect With Indonesia\'s IT Ecosystem')

@section('content')
    {{-- ===== HERO (100svh, includes category shortcuts) ===== --}}
    <section class="relative overflow-hidden bg-white text-slate-900 h-svh flex flex-col justify-center">

        {{-- === BLOB BACKGROUND === --}}
        {{-- Single large round blob — centered at top --}}
        <div class="pointer-events-none absolute left-1/2 -translate-x-1/2 -top-[280px]"
             style="width:1100px; height:1100px; border-radius:9999px;
                    background: radial-gradient(circle, rgba(147,185,255,0.75) 0%, rgba(180,200,255,0.55) 35%, rgba(210,220,255,0.25) 65%, transparent 100%);
                    filter: blur(50px);">
        </div>

        {{-- Content --}}
        <div class="relative mx-auto w-full max-w-5xl px-6 text-center">
            <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-5xl md:text-6xl">
                Connect With Indonesia's IT Ecosystem
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-slate-500 sm:text-lg">
                Your premier platform for discovering top education, leading tech companies,
                vibrant communities, and career opportunities in Indonesia's digital landscape.
            </p>

            {{-- Search Bar --}}
            <form action="/search" method="GET" class="mx-auto mt-8 flex max-w-xl overflow-hidden rounded-full border border-slate-200 bg-white p-1.5 shadow-md">
                <div class="flex flex-1 items-center pl-4">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="q" placeholder="Search campuses, schools, companies, jobs, internships, events..."
                           class="w-full border-none bg-transparent px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none">
                </div>
                <button type="submit" class="shrink-0 rounded-full bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-blue-700">
                    Search
                </button>
            </form>

            {{-- Category Shortcuts --}}
            @php
                $cats = [
                    ['Campus',      '/campus',        'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5'],
                    ['Vocational',  '/vocational',    'M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25'],
                    ['Company',     '/company',       'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21'],
                    ['Jobs',        '/jobs',          'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0'],
                    ['Internship',  '/internship',    'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z'],
                    ['Scholarship', '/scholarship',   'M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                    ['Events',      '/events',        'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5'],
                    ['Knowledge',   '/knowledge-hub', 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25'],
                ];
            @endphp

            <div class="mt-10 grid grid-cols-4 gap-3 sm:grid-cols-8">
                @foreach ($cats as [$label, $url, $path])
                    <a href="{{ $url }}" class="group flex flex-col items-center gap-2.5 rounded-2xl border border-slate-200/80 bg-white/70 backdrop-blur-sm p-3.5 transition-all hover:-translate-y-1 hover:border-blue-300 hover:shadow-lg hover:bg-white">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-500 transition-colors group-hover:border-blue-200 group-hover:bg-blue-50 group-hover:text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
                            </svg>
                        </span>
                        <span class="text-center text-[12px] font-semibold text-slate-700 group-hover:text-blue-600 leading-snug">{{ $label }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ===== FEATURED OPPORTUNITIES ===== --}}
    <section class="mx-auto max-w-6xl px-6 pb-16">
        <div class="mb-8 flex items-end justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Featured Opportunities</h2>
                <p class="mt-1 text-sm text-slate-500">Discover curated opportunities to advance your tech career.</p>
            </div>
            <a href="/opportunities" class="shrink-0 text-sm font-semibold text-blue-600 transition-colors hover:text-blue-700">
                View All &rarr;
            </a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $cards = [
                    [
                        'logo' => 'GT', 'bg' => '#16a34a', 'tag' => 'Jobs',    'tagColor' => 'bg-blue-100 text-blue-700',
                        'title' => 'Senior Frontend Developer', 'company' => 'GoTech Indonesia',
                        'loc' => 'Jakarta, Indonesia (Hybrid)', 'type' => 'Full-Time', 'close' => 'Closes: Oct 30, 2024',
                    ],
                    [
                        'logo' => 'DF', 'bg' => '#2563eb', 'tag' => 'Internship',  'tagColor' => 'bg-amber-100 text-amber-700',
                        'title' => 'Data Science Internship', 'company' => 'DataFlow Analytics',
                        'loc' => 'Bandung, Indonesia (Remote)', 'type' => '3 Months', 'close' => 'Closes: Nov 15, 2024',
                    ],
                    [
                        'logo' => 'MC', 'bg' => '#7c3aed', 'tag' => 'Scholarship', 'tagColor' => 'bg-violet-100 text-violet-700',
                        'title' => 'Future Tech Leaders Scholarship', 'company' => 'Ministry of Communication and IT',
                        'loc' => 'National (Indonesia)', 'type' => "Bachelor's Degree", 'close' => 'Closes: Dec 01, 2024',
                    ],
                ];
            @endphp

            @foreach ($cards as $c)
                <article class="flex flex-col rounded-2xl border border-slate-200 bg-white p-6 transition-all hover:-translate-y-1 hover:shadow-xl">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl text-sm font-bold text-white" style="background:{{ $c['bg'] }}">{{ $c['logo'] }}</span>
                        <span class="rounded-md px-2.5 py-1 text-xs font-semibold {{ $c['tagColor'] }}">{{ $c['tag'] }}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">{{ $c['title'] }}</h3>
                    <p class="text-sm text-slate-500">{{ $c['company'] }}</p>
                    <div class="mt-4 flex flex-col gap-2 text-[13px] text-slate-500">
                        @foreach (['loc' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z', 'type' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'close' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5'] as $k => $d)
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}"/></svg>
                                <span>{{ $c[$k] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                        <span class="flex items-center gap-1.5 text-[13px] font-semibold text-emerald-600">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Open
                        </span>
                        <a href="#" class="text-sm font-semibold text-blue-600 transition-colors hover:text-blue-700">Apply Now &rarr;</a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="mx-auto max-w-6xl px-6 pb-16">
        <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 px-8 py-14 text-center text-white sm:px-14">
            <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Build Your Future in Technology</h2>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-300">
                Join Indonesia's rapidly growing IT ecosystem. Connect with peers, find mentors,
                and discover opportunities that match your skills.
            </p>
            <div class="mt-8 flex flex-col justify-center gap-4 sm:flex-row">
                <a href="/register" class="rounded-lg bg-blue-600 px-8 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/40 transition-colors hover:bg-blue-500">
                    Create Your Profile
                </a>
                <a href="/opportunities" class="rounded-lg border-2 border-white/20 px-8 py-3.5 text-sm font-semibold text-white transition-colors hover:border-white/40 hover:bg-white/10">
                    Explore Opportunities
                </a>
            </div>
        </div>
    </section>
@endsection
