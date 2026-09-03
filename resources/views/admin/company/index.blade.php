@extends('admin.layouts.app')

@section('title', 'Company Management — IndoTech')

@section('content')
<div class="space-y-6">

    {{-- Top Bar: Breadcrumb, Title & Action Buttons --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Home</a>
                <span class="text-slate-400">›</span>
                <span class="text-slate-900 font-semibold">Company Management</span>
            </div>
            <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">Company Management</h1>
        </div>

        <div class="flex items-center gap-3">
            {{-- Filter Button --}}
            <div class="relative" x-data="{ open: false }">
                <button type="button" 
                        onclick="document.getElementById('filterModal').classList.toggle('hidden')"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200/90 bg-white text-slate-700 hover:bg-slate-50 text-[13.5px] font-semibold shadow-xs transition">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
            </div>

            {{-- Add New Company Button --}}
            <a href="{{ route('admin.company.create') }}" 
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0b57d0] hover:bg-blue-700 text-white text-[13.5px] font-semibold shadow-sm transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Add New Company
            </a>
        </div>
    </div>

    {{-- Filter Modal / Drawer (Collapsible) --}}
    <div id="filterModal" class="hidden bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm transition">
        <form method="GET" action="{{ route('admin.company.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Status</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm text-slate-700 outline-none focus:border-blue-500">
                    <option value="all">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Type</label>
                <select name="type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm text-slate-700 outline-none focus:border-blue-500">
                    <option value="all">Semua Tipe</option>
                    <option value="BUMN" {{ request('type') === 'BUMN' ? 'selected' : '' }}>BUMN</option>
                    <option value="Swasta" {{ request('type') === 'Swasta' ? 'selected' : '' }}>Swasta</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-[#0b57d0] text-white py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">Terapkan Filter</button>
                <a href="{{ route('admin.company.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-medium hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </div>

    {{-- 3 Top Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Card 1: COMPANIES --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs relative overflow-hidden flex flex-col justify-between">
            <div class="text-[12px] font-bold tracking-wider text-slate-400 uppercase">COMPANIES</div>
            <div class="text-[34px] font-extrabold text-slate-900 leading-tight mt-2">{{ $totalCompanies }}</div>
        </div>

        {{-- Card 2: ACTIVE PARTNERS --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs relative overflow-hidden flex flex-col justify-between">
            <div class="text-[12px] font-bold tracking-wider text-slate-400 uppercase">ACTIVE PARTNERS</div>
            <div class="text-[34px] font-extrabold text-slate-900 leading-tight mt-2">{{ $activePartners }}</div>
        </div>

        {{-- Card 3: NEW SUBMISSIONS --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs relative overflow-hidden flex flex-col justify-between">
            <div class="text-[12px] font-bold tracking-wider text-slate-400 uppercase">NEW SUBMISSIONS</div>
            <div class="text-[34px] font-extrabold text-slate-900 leading-tight mt-2">{{ $newSubmissions }}</div>
        </div>
    </div>

    {{-- Main Table Container Card --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        {{-- Table Toolbar: Search & Sort --}}
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.company.index') }}" class="relative flex-1 max-w-md">
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200/80 rounded-xl px-3.5 h-10 w-full focus-within:border-blue-500 focus-within:bg-white transition">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400">
                        <circle cx="11" cy="11" r="7"/>
                        <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search Company..." 
                           class="bg-transparent outline-none text-[13.5px] text-slate-800 placeholder-slate-400 flex-1 min-w-0">
                    @if(request('search'))
                        <a href="{{ route('admin.company.index') }}" class="text-xs text-slate-400 hover:text-slate-600 font-bold">&times;</a>
                    @endif
                </div>
            </form>

            {{-- Sort Dropdown --}}
            <div class="flex items-center gap-2 text-[13.5px] text-slate-600 self-end sm:self-auto">
                <form method="GET" action="{{ route('admin.company.index') }}" id="sortForm" class="flex items-center gap-2">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                    @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                    
                    <span class="text-slate-500 font-medium">Sort by:</span>
                    <select name="sort" 
                            onchange="document.getElementById('sortForm').submit()"
                            class="bg-transparent font-semibold text-slate-900 outline-none cursor-pointer pr-4 hover:text-blue-600 transition">
                        <option value="recently_added" {{ request('sort') === 'recently_added' ? 'selected' : '' }}>Recently Added ▾</option>
                        <option value="region_asc" {{ request('sort') === 'region_asc' ? 'selected' : '' }}>Daerah (A-Z) ▾</option>
                        <option value="region_desc" {{ request('sort') === 'region_desc' ? 'selected' : '' }}>Daerah (Z-A) ▾</option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name (A-Z) ▾</option>
                        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name (Z-A) ▾</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest ▾</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Companies Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 text-[11.5px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                        <th class="px-6 py-4">COMPANY NAME</th>
                        <th class="px-6 py-4">TYPE</th>
                        <th class="px-6 py-4">INDUSTRY</th>
                        <th class="px-6 py-4">LOCATION</th>
                        <th class="px-6 py-4">STATUS</th>
                        <th class="px-6 py-4 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @forelse ($companies as $company)
                        <tr class="hover:bg-slate-50/70 transition group">
                            {{-- Company Name & NPSN & Logo --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    {{-- Logo Avatar --}}
                                    <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0b57d0] font-bold text-xs shrink-0 overflow-hidden shadow-2xs">
                                        @if(!empty($company['logo_url']))
                                            <img src="{{ $company['logo_url'] }}" alt="{{ $company['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="font-extrabold">{{ $company['logo_text'] ?? 'CMP' }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.company.show', $company['id']) }}" class="font-bold text-slate-900 hover:text-blue-600 transition block leading-snug">
                                            {{ $company['name'] }}
                                        </a>
                                        <div class="text-[12px] text-slate-400 mt-0.5">
                                            Code: {{ $company['npsn'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Type Badge --}}
                            <td class="px-6 py-4">
                                @if($company['type'] === 'BUMN')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-medium bg-red-50 text-red-700">{{ $company['type'] }}</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-medium bg-green-50 text-green-700">{{ $company['type'] }}</span>
                                @endif
                            </td>

                            {{-- Industry --}}
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800 leading-tight">
                                    {{ $company['industry'] }}
                                </div>
                            </td>

                            {{-- Location --}}
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800 leading-tight">
                                    {{ $company['city'] }}
                                </div>
                                <div class="text-[12px] text-slate-400 mt-0.5">
                                    {{ $company['province'] }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if(strtolower($company['status']) === 'active')
                                    <span class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-slate-800">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-slate-800">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 text-slate-400">
                                    {{-- Edit Link --}}
                                    <a href="{{ route('admin.company.edit', $company['id']) }}" 
                                       class="p-1.5 rounded-lg hover:text-blue-600 hover:bg-blue-50 transition" 
                                       title="Edit Data Perusahaan">
                                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>

                                    {{-- Delete Button with Form --}}
                                    <form method="POST" action="{{ route('admin.company.destroy', $company['id']) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perusahaan {{ $company['name'] }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg hover:text-red-600 hover:bg-red-50 transition" title="Hapus Perusahaan">
                                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                <line x1="10" y1="11" x2="10" y2="17"/>
                                                <line x1="14" y1="11" x2="14" y2="17"/>
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- More Actions Dropdown/Menu --}}
                                    <a href="{{ route('admin.company.show', $company['id']) }}" class="p-1.5 rounded-lg hover:text-slate-800 hover:bg-slate-100 transition" title="Detail Perusahaan">
                                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="1"/>
                                            <circle cx="12" cy="5" r="1"/>
                                            <circle cx="12" cy="19" r="1"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></svg>
                                    </div>
                                    <div class="font-bold text-slate-800">Tidak ada data perusahaan ditemukan</div>
                                    <p class="text-xs text-slate-400">Coba ubah kata kunci pencarian atau filter status Anda.</p>
                                    <a href="{{ route('admin.company.index') }}" class="inline-block text-xs font-semibold text-blue-600 hover:underline">Reset Pencarian</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer / Pagination --}}
        <div class="p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-[13px] text-slate-500">
                Showing <span class="font-semibold text-slate-800">{{ $companies->firstItem() ?? 0 }}-{{ $companies->lastItem() ?? 0 }}</span> of <span class="font-semibold text-slate-800">{{ $companies->total() }}</span> companies
            </div>

            {{-- Pagination Navigation --}}
            <div class="flex items-center gap-1.5 text-[13.5px]">
                {{-- Previous Link --}}
                @if ($companies->onFirstPage())
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-100 text-slate-300 cursor-not-allowed select-none">‹</span>
                @else
                    <a href="{{ $companies->previousPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">‹</a>
                @endif

                {{-- Page Number Links --}}
                @for ($page = 1; $page <= max(1, $companies->lastPage()); $page++)
                    @if ($page == $companies->currentPage())
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#0b57d0] text-white font-bold shadow-xs select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $companies->url($page) }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Next Link --}}
                @if ($companies->hasMorePages())
                    <a href="{{ $companies->nextPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">›</a>
                @else
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-100 text-slate-300 cursor-not-allowed select-none">›</span>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
