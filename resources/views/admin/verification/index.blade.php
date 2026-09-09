@extends('admin.layouts.app')

@section('title', 'Verification Management — IndoTech Admin')

@section('content')
<div class="space-y-6">

    {{-- Status Quick Filter Tabs --}}
    <div class="flex items-center justify-start flex-wrap gap-4">
        <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-2xl border border-slate-200 text-xs font-bold overflow-x-auto">
            <a href="{{ route('admin.verification.index', ['status' => 'pending', 'type' => request('type'), 'q' => request('q')]) }}" 
               class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status', 'pending') === 'pending' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span>Pending</span>
                <span class="bg-amber-100 text-amber-800 text-[10px] px-1.5 py-0.5 rounded-full font-extrabold">{{ $pendingCount }}</span>
            </a>

            <a href="{{ route('admin.verification.index', ['status' => 'active', 'type' => request('type'), 'q' => request('q')]) }}" 
               class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status') === 'active' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Disetujui</span>
                <span class="bg-emerald-100 text-emerald-800 text-[10px] px-1.5 py-0.5 rounded-full font-extrabold">{{ $approvedCount }}</span>
            </a>

            <a href="{{ route('admin.verification.index', ['status' => 'rejected', 'type' => request('type'), 'q' => request('q')]) }}" 
               class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status') === 'rejected' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                <span>Ditolak</span>
                <span class="bg-red-100 text-red-800 text-[10px] px-1.5 py-0.5 rounded-full font-extrabold">{{ $rejectedCount }}</span>
            </a>

            <a href="{{ route('admin.verification.index', ['status' => 'all', 'type' => request('type'), 'q' => request('q')]) }}" 
               class="px-3.5 py-2 rounded-xl transition {{ request('status') === 'all' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                <span>Semua</span>
            </a>
        </div>
    </div>

    {{-- Stats Cards Summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">PENDING VERIFIKASI</div>
                <div class="text-2xl font-extrabold text-amber-600 mt-0.5">{{ number_format($pendingCount) }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">INSTITUSI DISETUJUI</div>
                <div class="text-2xl font-extrabold text-emerald-600 mt-0.5">{{ number_format($approvedCount) }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">DITOLAK</div>
                <div class="text-2xl font-extrabold text-red-600 mt-0.5">{{ number_format($rejectedCount) }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11px] font-bold tracking-wider text-slate-400 uppercase">TOTAL DATA</div>
                <div class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ number_format($totalCount) }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-bold">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>
    </div>

    {{-- Table Container Card --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">

        {{-- Filter Bar --}}
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            
            {{-- Category Pills --}}
            <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto">
                <a href="{{ route('admin.verification.index', ['type' => 'all', 'status' => request('status'), 'q' => request('q')]) }}" 
                   class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('type', 'all') === 'all' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Tipe
                </a>
                <a href="{{ route('admin.verification.index', ['type' => 'user', 'status' => request('status'), 'q' => request('q')]) }}" 
                   class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('type') === 'user' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    User / Alumni
                </a>
                <a href="{{ route('admin.verification.index', ['type' => 'school', 'status' => request('status'), 'q' => request('q')]) }}" 
                   class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('type') === 'school' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    School (Sekolah)
                </a>
                <a href="{{ route('admin.verification.index', ['type' => 'university', 'status' => request('status'), 'q' => request('q')]) }}" 
                   class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('type') === 'university' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    University (Kampus)
                </a>
                <a href="{{ route('admin.verification.index', ['type' => 'company', 'status' => request('status'), 'q' => request('q')]) }}" 
                   class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('type') === 'company' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Company (Perusahaan)
                </a>
            </div>

            {{-- Search Bar --}}
            <form action="{{ route('admin.verification.index') }}" method="GET" class="w-full sm:w-72">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif

                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3.5 h-10 w-full focus-within:border-blue-500 focus-within:bg-white transition">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400">
                        <circle cx="11" cy="11" r="7"/>
                        <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}" 
                           placeholder="Cari nama, email, kontak..." 
                           class="bg-transparent outline-none text-[13.5px] text-slate-800 placeholder-slate-400 flex-1 min-w-0">
                    @if(request('q'))
                        <a href="{{ route('admin.verification.index', ['status' => request('status'), 'type' => request('type')]) }}" class="text-xs text-slate-400 hover:text-slate-600 font-bold">&times;</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Verification Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 text-[11.5px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                        <th class="px-6 py-4">NAMA & EMAIL</th>
                        <th class="px-6 py-4">ROLE / TIPE</th>
                        <th class="px-6 py-4">PENANGGUNG JAWAB & NO. HP</th>
                        <th class="px-6 py-4">STATUS</th>
                        <th class="px-6 py-4 text-center">AKSI / DETAIL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @forelse($requests as $req)
                        @php
                            $roleLower = strtolower($req->role ?? 'user');
                            $statusLower = strtolower($req->status ?? 'pending');

                            $roleBadge = match($roleLower) {
                                'school', 'school_admin' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'university', 'univ_rep' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                'company', 'company_hr' => 'bg-teal-50 text-teal-700 border-teal-200',
                                'user' => 'bg-slate-100 text-slate-700 border-slate-200',
                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                            };

                            $roleDisplayName = match($roleLower) {
                                'school', 'school_admin' => 'School',
                                'university', 'univ_rep' => 'University',
                                'company', 'company_hr' => 'Company',
                                'user' => 'User / Alumni',
                                default => ucwords($req->role ?? 'User'),
                            };

                            $initials = strtoupper(substr($req->name, 0, 2));
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition group">
                            {{-- Entity Name & Email --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-slate-800 to-slate-900 text-white font-extrabold flex items-center justify-center text-xs shrink-0 shadow-sm">
                                        @if(in_array($roleLower, ['school', 'school_admin']))
                                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                        @elseif(in_array($roleLower, ['university', 'univ_rep']))
                                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        @elseif(in_array($roleLower, ['company', 'company_hr']))
                                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        @else
                                            <span>{{ $initials }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 truncate leading-snug">{{ $req->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5 truncate">{{ $req->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipe / Role --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border capitalize {{ $roleBadge }}">
                                    {{ $roleDisplayName }}
                                </span>
                            </td>

                            {{-- Penanggung Jawab & HP --}}
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800 leading-tight">
                                    {{ $req->org_contact ?? 'Pengguna Individu' }}
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">
                                    {{ $req->org_phone ?? '-' }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($statusLower === 'active' || $statusLower === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Disetujui (Active)
                                    </span>
                                @elseif($statusLower === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Pending Verifikasi
                                    </span>
                                @endif
                            </td>

                            {{-- Actions / Detail --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- Lihat Detail Button --}}
                                    <button type="button" 
                                            onclick="openDetailModal({{ json_encode($req) }})" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Lihat Detail</span>
                                    </button>

                                    {{-- Quick Reject Button --}}
                                    @if($statusLower !== 'rejected')
                                        <button type="button" 
                                                onclick="openRejectModal({{ $req->id }}, '{{ addslashes($req->name) }}', '{{ addslashes($req->email) }}')"
                                                class="p-2 rounded-xl text-red-500 hover:bg-red-50 transition" 
                                                title="Tolak Pendaftaran">
                                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    @endif

                                    {{-- Quick Approve Button --}}
                                    @if($statusLower !== 'active')
                                        <button type="button" 
                                                onclick="openApproveModal({{ $req->id }}, '{{ addslashes($req->name) }}', '{{ addslashes($req->email) }}')"
                                                class="p-2 rounded-xl text-emerald-600 hover:bg-emerald-50 transition" 
                                                title="Setujui Pendaftaran">
                                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endif

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admin.verification.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Hapus data verifikasi {{ addslashes($req->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus Data">
                                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="max-w-sm mx-auto space-y-2">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="font-bold text-slate-800 text-sm">Tidak ada pengajuan verifikasi ditemukan</div>
                                    <p class="text-xs text-slate-400">Belum ada akun pengguna dengan status pencarian/filter ini.</p>
                                    <a href="{{ route('admin.verification.index') }}" class="inline-block text-xs font-semibold text-blue-600 hover:underline">Reset Filter</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer & Pagination --}}
        <div class="p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-[13px] text-slate-500">
                Showing <span class="font-semibold text-slate-800">{{ $requests->firstItem() ?? 0 }}-{{ $requests->lastItem() ?? 0 }}</span> of <span class="font-semibold text-slate-800">{{ $requests->total() }}</span> items
            </div>

            <div class="flex items-center gap-1.5 text-[13.5px]">
                @if ($requests->onFirstPage())
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-100 text-slate-300 cursor-not-allowed select-none">‹</span>
                @else
                    <a href="{{ $requests->previousPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">‹</a>
                @endif

                @for ($page = 1; $page <= max(1, $requests->lastPage()); $page++)
                    @if ($page == $requests->currentPage())
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-600 text-white font-bold shadow-xs select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $requests->url($page) }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">{{ $page }}</a>
                    @endif
                @endfor

                @if ($requests->hasMorePages())
                    <a href="{{ $requests->nextPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">›</a>
                @else
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-100 text-slate-300 cursor-not-allowed select-none">›</span>
                @endif
            </div>
        </div>

    </div>

</div>

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 1: DETAIL VERIFIKASI INSTITUSI / USER --}}
{{-- ========================================================================= --}}
@include('admin.assets.verification-detail-modal')

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 2: KONFIRMASI SETUJUI (APPROVE) --}}
{{-- ========================================================================= --}}
<div id="modal-approve-verification" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4 transition-all duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all p-6 space-y-4 text-left">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100 mt-0.5">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-[15px] font-bold text-slate-900 tracking-tight">Konfirmasi Setujui Akun</h3>
                <p class="text-[13px] text-slate-500 leading-relaxed mt-1">
                    Setujui verifikasi untuk <strong id="approve_user_name" class="text-slate-800 font-semibold"></strong> (<span id="approve_user_email" class="text-slate-600"></span>)?
                </p>
            </div>
            <button type="button" onclick="closeApproveModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="text-[12px] text-emerald-800 bg-emerald-50/80 border border-emerald-100 px-3.5 py-2.5 rounded-xl flex items-center gap-2">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="shrink-0 text-emerald-600"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg>
            <span>Akun ini akan langsung diaktifkan dan dapat digunakan login ke sistem.</span>
        </div>

        <form id="form-approve-verification" method="POST" class="pt-1 flex items-center justify-end gap-2.5">
            @csrf
            <button type="button" onclick="closeApproveModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 text-[13px] transition cursor-pointer">Batal</button>
            <button type="submit" class="px-4.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[13px] shadow-xs shadow-emerald-600/20 transition cursor-pointer">Setujui Akun</button>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 3: KONFIRMASI TOLAK (REJECT) --}}
{{-- ========================================================================= --}}
<div id="modal-reject-verification" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4 transition-all duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all p-6 space-y-4 text-left">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100 mt-0.5">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-[15px] font-bold text-slate-900 tracking-tight">Konfirmasi Tolak Verifikasi</h3>
                <p class="text-[13px] text-slate-500 leading-relaxed mt-1">
                    Tolak pendaftaran verifikasi untuk <strong id="reject_user_name" class="text-slate-800 font-semibold"></strong> (<span id="reject_user_email" class="text-slate-600"></span>)?
                </p>
            </div>
            <button type="button" onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="text-[12px] text-rose-700 bg-rose-50/70 border border-rose-100/80 px-3.5 py-2.5 rounded-xl flex items-center gap-2">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="shrink-0 text-rose-500"><circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Status akun akan diubah menjadi Ditolak (Rejected).</span>
        </div>

        <form id="form-reject-verification" method="POST" class="pt-1 flex items-center justify-end gap-2.5">
            @csrf
            <button type="button" onclick="closeRejectModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 text-[13px] transition cursor-pointer">Batal</button>
            <button type="submit" class="px-4.5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-[13px] shadow-xs shadow-rose-600/20 transition cursor-pointer">Tolak Verifikasi</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let currentDetailReq = null;

    function openDetailModal(req) {
        currentDetailReq = req;
        document.getElementById('detail_name').textContent = req.name || 'Detail Akun';
        document.getElementById('detail_role').textContent = req.role ? req.role.replace('_', ' ') : 'User';
        
        const roleBadge = document.getElementById('detail_role_badge');
        if (roleBadge) {
            roleBadge.textContent = req.role ? req.role.replace('_', ' ') : 'User';
        }

        document.getElementById('detail_email').textContent = req.email || '-';
        document.getElementById('detail_created_at').textContent = req.created_at ? new Date(req.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';

        document.getElementById('detail_contact').textContent = req.org_contact || 'Pengguna Perorangan';
        document.getElementById('detail_phone').textContent = req.org_phone || '-';
        document.getElementById('detail_address').textContent = req.org_address || 'Tidak ada alamat khusus dilampirkan.';

        // Set status badge
        const statusVal = (req.status || 'pending').toLowerCase();
        let badgeHtml = '';
        if (statusVal === 'active' || statusVal === 'approved') {
            badgeHtml = '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11.5px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Active</span>';
        } else if (statusVal === 'rejected') {
            badgeHtml = '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11.5px] font-semibold bg-rose-50 text-rose-700 border border-rose-200"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Rejected</span>';
        } else {
            badgeHtml = '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11.5px] font-semibold bg-amber-50 text-amber-700 border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Pending</span>';
        }
        document.getElementById('detail_status_badge').innerHTML = badgeHtml;

        // Set document link
        const docContainer = document.getElementById('detail_doc_container');
        const noDocContainer = document.getElementById('detail_no_doc');
        if (req.org_doc) {
            if (docContainer) docContainer.classList.remove('hidden');
            if (noDocContainer) noDocContainer.classList.add('hidden');
            const docNameEl = document.getElementById('detail_doc_name');
            if (docNameEl) docNameEl.textContent = req.org_doc.split('/').pop();
            const docLinkEl = document.getElementById('detail_doc_link');
            if (docLinkEl) docLinkEl.href = `{{ asset('storage') }}/${req.org_doc}`;
        } else {
            if (docContainer) docContainer.classList.add('hidden');
            if (noDocContainer) noDocContainer.classList.remove('hidden');
        }

        // Action buttons inside modal
        const actionsContainer = document.getElementById('detail_actions_container');
        if (actionsContainer) {
            if (statusVal === 'active' || statusVal === 'approved') {
                actionsContainer.innerHTML = '<span class="text-xs text-emerald-600 font-semibold flex items-center gap-1"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> Akun Telah Aktif</span>';
            } else if (statusVal === 'rejected') {
                actionsContainer.innerHTML = `
                    <button type="button" onclick="triggerDetailApprove()" class="px-4.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[13px] shadow-xs shadow-emerald-600/20 transition cursor-pointer flex items-center gap-1.5">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        <span>Pulihkan & Setujui</span>
                    </button>
                `;
            } else {
                actionsContainer.innerHTML = `
                    <button type="button" onclick="triggerDetailReject()" class="px-4 py-2.5 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/80 font-semibold text-[13px] transition cursor-pointer flex items-center gap-1.5">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Tolak</span>
                    </button>
                    <button type="button" onclick="triggerDetailApprove()" class="px-4.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[13px] shadow-xs shadow-emerald-600/20 transition cursor-pointer flex items-center gap-1.5">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        <span>Setujui Akun</span>
                    </button>
                `;
            }
        }

        document.getElementById('modal-detail-verification').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDetailModal() {
        document.getElementById('modal-detail-verification').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function triggerDetailApprove() {
        if (currentDetailReq) {
            openApproveModal(currentDetailReq.id, currentDetailReq.name, currentDetailReq.email);
        }
    }

    function triggerDetailReject() {
        if (currentDetailReq) {
            openRejectModal(currentDetailReq.id, currentDetailReq.name, currentDetailReq.email);
        }
    }

    function openApproveModal(id, name, email) {
        closeDetailModal();
        const form = document.getElementById('form-approve-verification');
        form.action = `{{ url('/admin/verification') }}/${id}/approve`;
        document.getElementById('approve_user_name').textContent = name;
        document.getElementById('approve_user_email').textContent = email;

        document.getElementById('modal-approve-verification').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeApproveModal() {
        document.getElementById('modal-approve-verification').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openRejectModal(id, name, email) {
        closeDetailModal();
        const form = document.getElementById('form-reject-verification');
        form.action = `{{ url('/admin/verification') }}/${id}/reject`;
        document.getElementById('reject_user_name').textContent = name;
        document.getElementById('reject_user_email').textContent = email;

        document.getElementById('modal-reject-verification').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeRejectModal() {
        document.getElementById('modal-reject-verification').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endpush
@endsection
