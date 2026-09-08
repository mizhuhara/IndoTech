@extends('admin.layouts.app')

@section('title', 'Company Management — IndoTech Admin')

@section('content')
<div class="space-y-6">

    {{-- Success Toast Banner --}}
    

    {{-- Error Banner --}}
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm shadow-sm flex items-start gap-3 animate-fade-in">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-red-500 shrink-0 mt-0.5">
                <circle cx="12" cy="12" r="9"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div class="flex-1">
                <div class="font-bold">Terdapat beberapa kesalahan:</div>
                <ul class="list-disc list-inside mt-1 text-xs space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
        </div>
    @endif

    {{-- Top Bar: Breadcrumb, Title & Action Buttons --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Home</a>
                <span class="text-slate-400">›</span>
                <span class="text-slate-900 font-semibold">Company Management</span>
            </div>
            <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">Company Management</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola data mitra perusahaan, lokasi maps, galeri, dan profil lengkap.</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Filter Button --}}
            <button type="button" 
                    onclick="openFilterModal()" 
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-[13.5px] font-semibold shadow-xs transition">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>Filter</span>
                @if(request('status') || request('type'))
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                @endif
            </button>

            {{-- Add New Company Button --}}
            @if (!empty($canManage))
            <a href="{{ route('admin.company.create') }}" 
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-[13.5px] font-semibold shadow-md shadow-blue-500/20 transition transform active:scale-95">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                <span>Tambah Perusahaan</span>
            </a>
            @endif
        </div>
    </div>

    {{-- 3 Top Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11.5px] font-bold tracking-wider text-slate-400 uppercase">TOTAL PERUSAHAAN</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalCompanies) }}</div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11.5px] font-bold tracking-wider text-slate-400 uppercase">MITRA AKTIF</div>
                <div class="text-3xl font-extrabold text-emerald-600 mt-1">{{ number_format($activePartners) }}</div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11.5px] font-bold tracking-wider text-slate-400 uppercase">PENGAJUAN BARU</div>
                <div class="text-3xl font-extrabold text-amber-600 mt-1">{{ number_format($newSubmissions) }}</div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- Main Table Container Card --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        {{-- Table Toolbar: Search & Sort --}}
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.company.index') }}" class="relative flex-1 max-w-md">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif

                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200/80 rounded-xl px-3.5 h-10 w-full focus-within:border-blue-500 focus-within:bg-white transition">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400">
                        <circle cx="11" cy="11" r="7"/>
                        <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama perusahaan, industri, atau lokasi..." 
                           class="bg-transparent outline-none text-[13.5px] text-slate-800 placeholder-slate-400 flex-1 min-w-0">
                    @if(request('search'))
                        <a href="{{ route('admin.company.index') }}" class="text-xs text-slate-400 hover:text-slate-600 font-bold">&times;</a>
                    @endif
                </div>
            </form>

            <div class="flex items-center gap-2 text-[13.5px] text-slate-600 self-end sm:self-auto">
                <form method="GET" action="{{ route('admin.company.index') }}" id="sortForm" class="flex items-center gap-2">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                    @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                    
                    <span class="text-slate-500 font-medium">Urutkan:</span>
                    <select name="sort" 
                            onchange="document.getElementById('sortForm').submit()"
                            class="bg-transparent font-semibold text-slate-900 outline-none cursor-pointer pr-4 hover:text-blue-600 transition">
                        <option value="recently_added" {{ request('sort') === 'recently_added' ? 'selected' : '' }}>Terbaru ▾</option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama (A-Z) ▾</option>
                        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama (Z-A) ▾</option>
                        <option value="region_asc" {{ request('sort') === 'region_asc' ? 'selected' : '' }}>Kota (A-Z) ▾</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama ▾</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Companies Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 text-[11.5px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                        <th class="px-6 py-4">NAMA PERUSAHAAN</th>
                        <th class="px-6 py-4">TIPE</th>
                        <th class="px-6 py-4">INDUSTRI</th>
                        <th class="px-6 py-4">LOKASI & MAPS</th>
                        <th class="px-6 py-4">STATUS</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @forelse ($companies as $company)
                        <tr class="hover:bg-slate-50/70 transition group">
                            {{-- Company Name & Logo --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-slate-800 to-slate-900 text-white font-extrabold flex items-center justify-center text-xs shrink-0 overflow-hidden shadow-sm">
                                        @if(!empty($company->logo_url))
                                            <img src="{{ asset($company->logo_url) }}" alt="{{ $company->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span>{{ strtoupper(substr($company->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.company.show', $company->id) }}" class="font-bold text-slate-900 hover:text-blue-600 transition block leading-snug truncate">
                                            {{ $company->name }}
                                        </a>
                                        <div class="text-[12px] text-slate-400 mt-0.5 truncate">
                                            Kode: {{ $company->npsn ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Type Badge --}}
                            <td class="px-6 py-4">
                                @if(strtoupper($company->type) === 'BUMN')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">{{ $company->type }}</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">{{ $company->type }}</span>
                                @endif
                            </td>

                            {{-- Industry --}}
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $company->industry }}
                            </td>

                            {{-- Location & Maps Icon --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 font-semibold text-slate-800 leading-tight">
                                    <span>{{ $company->location }}</span>
                                    @if($company->map_link)
                                        <a href="{{ $company->map_link }}" target="_blank" class="text-blue-600 hover:text-blue-700 shrink-0" title="Lihat Lokasi di Google Maps">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </a>
                                    @endif
                                </div>
                                @if(!empty($company->gallery) && count($company->gallery) > 0)
                                    <div class="text-[11px] text-blue-600 font-bold mt-0.5 flex items-center gap-1">
                                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        <span>{{ count($company->gallery) }} Foto Galeri</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if(strtolower($company->status) === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.company.edit', $company->id) }}" 
                                       class="p-2 rounded-xl text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition" 
                                       title="Edit Perusahaan">
                                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    {{-- Delete Button (Modal Pop-Up, admin only) --}}
                                    @if (!empty($canManage))
                                    <button type="button" 
                                            onclick="openDeleteModal({{ $company->id }}, '{{ addslashes($company->name) }}')"
                                            class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition" 
                                            title="Hapus Perusahaan">
                                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                    @endif
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
                Showing <span class="font-semibold text-slate-800">{{ $companies->firstItem() ?? 0 }}-{{ $companies->lastItem() ?? 0 }}</span> of <span class="font-semibold text-slate-800">{{ $companies->total() }}</span> items
            </div>

            <div class="flex items-center gap-1.5 text-[13.5px]">
                @if ($companies->onFirstPage())
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-100 text-slate-300 cursor-not-allowed select-none">‹</span>
                @else
                    <a href="{{ $companies->previousPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">‹</a>
                @endif

                @for ($page = 1; $page <= max(1, $companies->lastPage()); $page++)
                    @if ($page == $companies->currentPage())
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-600 text-white font-bold shadow-xs select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $companies->url($page) }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">{{ $page }}</a>
                    @endif
                @endfor

                @if ($companies->hasMorePages())
                    <a href="{{ $companies->nextPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">›</a>
                @else
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-100 text-slate-300 cursor-not-allowed select-none">›</span>
                @endif
            </div>
        </div>

    </div>

</div>

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 1: KONFIRMASI HAPUS PERUSAHAAN --}}
{{-- ========================================================================= --}}
<div id="modal-delete-company" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all p-6 space-y-4 text-center">
        <div class="w-14 h-14 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto shadow-xs">
            <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus Perusahaan</h3>
            <p class="text-xs text-slate-500 mt-1">
                Apakah Anda yakin ingin menghapus <strong id="delete_company_name" class="text-slate-900"></strong>?
            </p>
            <p class="text-[11px] text-red-500 mt-2 font-medium bg-red-50 p-2.5 rounded-xl border border-red-100">
                Peringatan: Tindakan ini permanen dan data perusahaan serta galeri foto akan dihapus.
            </p>
        </div>

        <form id="form-delete-company" method="POST" class="pt-2 flex items-center justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition text-xs sm:text-sm">Batal</button>
            <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold shadow-md shadow-red-500/20 transition text-xs sm:text-sm">Ya, Hapus</button>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 2: FILTER PERUSAHAAN --}}
{{-- ========================================================================= --}}
<div id="modal-filter-company" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl space-y-4 border border-slate-100">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <h3 class="text-sm font-bold text-slate-900">Filter Data Perusahaan</h3>
            </div>
            <button type="button" onclick="closeFilterModal()" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.company.index') }}" method="GET" class="space-y-4 text-xs font-medium">
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif

            <div>
                <label class="block text-slate-700 mb-1.5 font-bold">Status Mitra</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-blue-600">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active (Aktif)</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive (Non-aktif)</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1.5 font-bold">Tipe Perusahaan</label>
                <select name="type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-blue-600">
                    <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>Semua Tipe</option>
                    <option value="Swasta" {{ request('type') === 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    <option value="BUMN" {{ request('type') === 'BUMN' ? 'selected' : '' }}>BUMN</option>
                    <option value="Multinasional" {{ request('type') === 'Multinasional' ? 'selected' : '' }}>Multinasional</option>
                    <option value="Startup" {{ request('type') === 'Startup' ? 'selected' : '' }}>Startup</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.company.index') }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition">Reset</a>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm transition">Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(id, name) {
        const form = document.getElementById('form-delete-company');
        form.action = `{{ url('/admin/company') }}/${id}`;
        document.getElementById('delete_company_name').textContent = name;
        document.getElementById('modal-delete-company').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        document.getElementById('modal-delete-company').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openFilterModal() {
        document.getElementById('modal-filter-company').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeFilterModal() {
        document.getElementById('modal-filter-company').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endpush
@endsection
