@extends('admin.layouts.app')

@section('title', $univ['name'] . ' — Detail Universitas')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    {{-- Top Navigation & Action --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.univ.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 mb-2 transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar
            </a>
            <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
                <a href="{{ route('admin.univ.index') }}" class="hover:text-blue-600 transition">Universitas</a>
                <span class="text-slate-400">›</span>
                <span class="text-slate-900 font-semibold">{{ $univ['name'] }}</span>
            </div>
            <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">{{ $univ['name'] }}</h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.univ.edit', $univ['id']) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0b57d0] hover:bg-blue-700 text-white text-[13.5px] font-semibold shadow-sm transition">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Informasi Universitas
            </a>
        </div>
    </div>

    {{-- Details Cards Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 space-y-6">
            {{-- Overview Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0b57d0] font-bold text-lg shrink-0 overflow-hidden shadow-xs">
                        @if(!empty($univ['logo_url']))
                            <img src="{{ $univ['logo_url'] }}" alt="{{ $univ['name'] }}" class="w-full h-full object-cover">
                        @else
                            <span>{{ $univ['logo_text'] ?? 'UNIV' }}</span>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">{{ $univ['name'] }}</h2>
                        <div class="flex flex-wrap items-center gap-2 mt-1.5 text-xs text-slate-500">
                            <span class="font-semibold text-slate-700">NPSN: {{ $univ['npsn'] ?? '-' }}</span>
                            <span>•</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-[#0b57d0] font-semibold">{{ $univ['type'] }}</span>
                            <span>•</span>
                            <span>{{ $univ['location'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi & Profil</h3>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">
                        {{ $univ['description'] ?? 'Belum ada deskripsi profil untuk universitas ini.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            {{-- Quick Info Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Informasi Tambahan</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-500">Status</span>
                        <span class="font-semibold text-emerald-600">{{ $univ['status'] }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-500">Akreditasi</span>
                        <span class="font-medium text-slate-800">{{ $univ['accreditation'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-500">Email</span>
                        <span class="font-medium text-slate-800">{{ $univ['email'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-500">Telepon</span>
                        <span class="font-medium text-slate-800">{{ $univ['phone'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-500">Website</span>
                        @if(!empty($univ['website']))
                            <a href="{{ $univ['website'] }}" target="_blank" class="font-medium text-[#0b57d0] hover:underline">{{ $univ['website'] }}</a>
                        @else
                            <span class="font-medium text-slate-800">-</span>
                        @endif
                    </div>
                    <div class="py-1">
                        <span class="block text-slate-500 mb-1">Alamat</span>
                        <span class="font-medium text-slate-800 leading-relaxed block">{{ $univ['address'] ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
