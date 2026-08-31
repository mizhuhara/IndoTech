<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verification — IndoTech Admin</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script>
        if (window.tailwind) {
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    },
                },
            };
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-slate-800 antialiased">

<div class="flex min-h-screen">

    {{-- ===== SIDEBAR PARTIAL ===== --}}
    @include('admin.partials.sidebar')

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Header Bar (Matching Verification Design) --}}
        <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center justify-between gap-4 sticky top-0 z-10">
            
            {{-- Search Bar --}}
            <form action="{{ route('admin.verification.index') }}" method="GET" class="w-full max-w-md">
                <div class="relative flex items-center">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search entities, users..." 
                           class="w-full bg-slate-100/70 hover:bg-slate-100 focus:bg-white border border-slate-200 focus:border-blue-500 rounded-full pl-10 pr-4 py-2 text-xs font-medium text-slate-700 placeholder-slate-400 outline-none transition">
                </div>
            </form>

            {{-- Right Header Actions --}}
            <div class="flex items-center gap-3.5 shrink-0">
                {{-- Bell Icon --}}
                <button type="button" class="relative p-2 rounded-full text-slate-500 hover:bg-slate-100 transition" aria-label="Notifications">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500"></span>
                </button>

                {{-- Help Icon --}}
                <button type="button" class="p-2 rounded-full text-slate-500 hover:bg-slate-100 transition" aria-label="Help">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 9a2.5 2.5 0 0 1 4.9.8c0 1.7-2.4 2.2-2.4 3.7m0 3h.01"/>
                    </svg>
                </button>

                {{-- Profile Pill (Matching Verification Header) --}}
                <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&h=100&fit=crop" 
                         alt="Admin Profile" 
                         class="w-8 h-8 rounded-full object-cover border border-slate-200">
                    <div class="hidden sm:block text-left">
                        <div class="text-xs font-extrabold text-slate-900 leading-none">Admin User</div>
                        <div class="text-[11px] text-slate-400 mt-0.5 font-medium">Superadmin</div>
                    </div>
                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
        </header>

        {{-- Content Body --}}
        <main class="flex-1 p-6 sm:p-8 space-y-6">

            {{-- Title Header --}}
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Verification
                </h1>
                <p class="text-xs font-semibold text-slate-500 mt-1">
                    Review and approve pending registration requests.
                </p>
            </div>

            {{-- Main Table Card Container (Matching Verification Design Image) --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">

                {{-- Filter Bar: Left Type Pills + Right Search Input --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    
                    {{-- Left Category Type Pills --}}
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 w-full sm:w-auto">
                        {{-- All Types --}}
                        <div class="relative">
                            <a href="{{ route('admin.verification.index', ['type' => 'all']) }}" 
                               class="inline-flex items-center gap-1.5 border border-blue-200 bg-blue-50 text-blue-700 font-bold px-4 py-1.5 rounded-full text-xs shadow-sm transition">
                                <span>All Types</span>
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </a>
                        </div>

                        {{-- School --}}
                        <a href="{{ route('admin.verification.index', ['type' => 'school']) }}" 
                           class="border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-1.5 rounded-full text-xs transition">
                            School
                        </a>

                        {{-- University --}}
                        <a href="{{ route('admin.verification.index', ['type' => 'university']) }}" 
                           class="border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-1.5 rounded-full text-xs transition">
                            University
                        </a>

                        {{-- Company --}}
                        <a href="{{ route('admin.verification.index', ['type' => 'company']) }}" 
                           class="border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-1.5 rounded-full text-xs transition">
                            Company
                        </a>
                    </div>

                    {{-- Right Search Filter Input --}}
                    <form action="{{ route('admin.verification.index') }}" method="GET" class="w-full sm:w-auto">
                        <div class="relative flex items-center">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L4.35 21l3.39-.62A8.94 8.94 0 0012 21c4.97 0 9-4.03 9-9s-4.03-9-9-9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h3m-4.5 4h6m-3 4h3" />
                            </svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Filter by name or ID..." 
                                   class="w-full sm:w-60 bg-slate-50/70 border border-slate-200 rounded-full pl-9 pr-4 py-1.5 text-xs text-slate-700 placeholder-slate-400 outline-none focus:border-blue-500 transition">
                        </div>
                    </form>

                </div>

                {{-- Table Component --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-50/40 border-y border-slate-100 text-slate-500 text-[11px] font-extrabold uppercase tracking-wider">
                                <th class="py-3 px-4 w-10">
                                    <input type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="py-3 px-4">ENTITY NAME</th>
                                <th class="py-3 px-4">TYPE</th>
                                <th class="py-3 px-4">REGISTRATION DATE</th>
                                <th class="py-3 px-4">STATUS</th>
                                <th class="py-3 px-4 text-right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                            @forelse($requests as $req)
                                <tr class="hover:bg-slate-50/60 transition">
                                    {{-- Checkbox --}}
                                    <td class="py-4 px-4">
                                        <input type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    </td>

                                    {{-- Entity Name & Icon & REQ ID --}}
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                                                @if($req['icon_type'] === 'school')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147L12 14.6l7.74-4.453M12 4.5L2.25 10.125 12 15.75l9.75-5.625L12 4.5z" />
                                                    </svg>
                                                @elseif($req['icon_type'] === 'university')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5" />
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6h1.5m-1.5 3h1.5m-1.5 3h1.5" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">
                                                    {{ $req['name'] }}
                                                </h4>
                                                <p class="text-[11px] text-slate-400 font-semibold mt-0.5 uppercase tracking-wider">
                                                    {{ $req['req_id'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Type --}}
                                    <td class="py-4 px-4 font-semibold text-slate-600">
                                        {{ $req['type'] }}
                                    </td>

                                    {{-- Registration Date --}}
                                    <td class="py-4 px-4">
                                        <div class="font-semibold text-slate-800">{{ $req['date'] }}</div>
                                        <div class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $req['time'] }}</div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                                            <span>{{ $req['status'] }}</span>
                                        </span>
                                    </td>

                                    {{-- Action Buttons (Reject Circle Slash & Verify Blue Button) --}}
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            {{-- Reject Icon Button --}}
                                            <button type="button" 
                                                    onclick="if(confirm('Reject request from {{ $req['name'] }}?')) alert('Rejected.');" 
                                                    class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition" 
                                                    title="Reject Request">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                            </button>

                                            {{-- Verify Button --}}
                                            <button type="button" 
                                                    onclick="alert('Entity {{ $req['name'] }} has been verified!')" 
                                                    class="bg-blue-900 hover:bg-blue-950 text-white font-bold text-xs px-3.5 py-1.5 rounded-lg shadow-sm inline-flex items-center gap-1.5 transition">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Verify</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">
                                        No pending verification requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer (Matching Design Image) --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100 text-xs font-semibold text-slate-400">
                    <div>
                        Showing 1-3 of {{ $totalPendingCount }} pending requests
                    </div>

                    {{-- Round Circle Pagination --}}
                    <div class="flex items-center gap-1.5">
                        <button disabled class="w-8 h-8 rounded-full border border-slate-200 text-slate-300 flex items-center justify-center opacity-50 text-xs">
                            &lsaquo;
                        </button>
                        <button class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold text-xs shadow-sm flex items-center justify-center">
                            1
                        </button>
                        <a href="?page=2" class="w-8 h-8 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center font-bold text-xs transition">
                            2
                        </a>
                        <a href="?page=3" class="w-8 h-8 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center font-bold text-xs transition">
                            3
                        </a>
                        <span class="px-1 text-slate-400">...</span>
                        <a href="?page=2" class="w-8 h-8 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center text-xs transition">
                            &rsaquo;
                        </a>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

</body>
</html>
