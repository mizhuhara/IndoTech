@extends('admin.layouts.app')

@section('title', ($event['title'] ?? 'Event Detail') . ' — Detail Event')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Top Back Bar --}}
    <div>
        <a href="{{ route('admin.events.index') }}" 
           class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-blue-600 transition mb-3">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Daftar Event</span>
        </a>
    </div>

    {{-- Main Detail Card --}}
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        
        {{-- Card Header --}}
        <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        {{ $event['type'] ?? 'General' }}
                    </span>
                    @if(($event['status'] ?? 'Pending') === 'Pending')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                            • Pending
                        </span>
                    @elseif(($event['status'] ?? '') === 'Approved')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            • Approved
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                            • Rejected
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight pt-1">
                    {{ $event['title'] ?? 'Event Title' }}
                </h1>
                <p class="text-xs font-semibold text-slate-500">
                    Kategori: {{ $event['category'] ?? 'General Event' }}
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2.5">
                <form action="{{ route('admin.events.approve', $event['id']) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs inline-flex items-center gap-1.5 transition">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        <span>Approve Event</span>
                    </button>
                </form>

                <form action="{{ route('admin.events.reject', $event['id']) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs inline-flex items-center gap-1.5 transition">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                        <span>Reject Event</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="p-6 sm:p-8 space-y-8 text-xs text-slate-700">
            
            {{-- Quick Info Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/80 p-5 rounded-2xl border border-slate-100">
                <div>
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block mb-1">Penyelenggara / Organizer</span>
                    <div class="font-extrabold text-slate-900 text-base">{{ $event['organizer'] ?? '-' }}</div>
                    <div class="text-slate-500 font-semibold mt-0.5">{{ $event['type'] ?? 'Partner' }} Partner</div>
                </div>

                <div>
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block mb-1">Tanggal Pelaksanaan</span>
                    <div class="font-extrabold text-slate-900 text-base">{{ $event['proposed_date'] ?? '-' }}</div>
                </div>

                <div>
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block mb-1">Lokasi Event</span>
                    <div class="font-bold text-slate-900 text-sm">{{ $event['location'] ?? 'Lokasi belum ditentukan' }}</div>
                </div>

                <div>
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block mb-1">Target Quota Peserta</span>
                    <div class="font-bold text-slate-900 text-sm">{{ $event['quota'] ?? 'Tanpa Batasan' }}</div>
                </div>

                <div class="md:col-span-2 border-t border-slate-200/60 pt-4 flex flex-wrap gap-6 text-xs text-slate-600">
                    <div>
                        <span class="font-extrabold text-slate-800">Email Kontak:</span> {{ $event['contact_email'] ?? '-' }}
                    </div>
                    <div>
                        <span class="font-extrabold text-slate-800">No. Telepon:</span> {{ $event['contact_phone'] ?? '-' }}
                    </div>
                </div>
            </div>

            {{-- Description & Proposal --}}
            <div class="space-y-2">
                <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">
                    Deskripsi & Proposal Event
                </h3>
                <div class="text-slate-600 text-sm leading-relaxed bg-white p-5 rounded-2xl border border-slate-200/90 shadow-2xs">
                    {{ $event['description'] ?? 'Belum ada deskripsi lengkap yang dilampirkan untuk event ini.' }}
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
