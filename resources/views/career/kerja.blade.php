@extends('layouts.app')

@section('title', 'Siap Kerja — IndoTech')

@section('content')
<style>
    /* ── page shell ── */
    .sk-page {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ── tabs (shared with career/index) ── */
    .cr-tabs {
        position: sticky;
        top: 62px;
        z-index: 20;
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
    }
    .cr-tabs-inner {
        display: flex;
        gap: 4px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .cr-tabs-inner::-webkit-scrollbar { display: none; }
    .cr-tabs a {
        flex-shrink: 0;
        padding: 14px 16px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-bottom: 2.5px solid transparent;
        margin-bottom: -1px;
        white-space: nowrap;
        transition: color 0.15s, border-color 0.15s;
    }
    .cr-tabs a:hover { color: #2563eb; }
    .cr-tabs a.on { color: #2563eb; border-bottom-color: #2563eb; }

    /* ── hero bar ── */
    .sk-hero {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);
        border-radius: 20px;
        padding: 36px 40px;
        margin-top: 28px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }
    .sk-hero-text h1 { font-size: 22px; font-weight: 800; margin: 0 0 6px; }
    .sk-hero-text p  { font-size: 14px; color: #bfdbfe; margin: 0; }
    .sk-hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: #2563eb;
        font-weight: 700;
        font-size: 14px;
        padding: 11px 22px;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        transition: transform 0.15s, box-shadow 0.15s;
        cursor: pointer;
        border: none;
        font-family: inherit;
        flex-shrink: 0;
    }
    .sk-hero-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        color: #1d4ed8;
        text-decoration: none;
    }

    /* ── toolbar ── */
    .sk-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 24px 0 16px;
        flex-wrap: wrap;
    }
    .sk-count { font-size: 14px; color: #64748b; margin: 0; }
    .sk-count strong { color: #0f172a; }
    .sk-search {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0 12px;
        min-width: 240px;
        flex: 1;
        max-width: 360px;
    }
    .sk-search svg { color: #94a3b8; flex-shrink: 0; }
    .sk-search input {
        border: none;
        outline: none;
        font-size: 13.5px;
        padding: 9px 10px;
        width: 100%;
        font-family: inherit;
        background: transparent;
        color: #334155;
    }

    /* ── grid ── */
    .sk-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        padding-bottom: 48px;
    }
    @media (max-width: 1080px) { .sk-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 620px)  { .sk-grid { grid-template-columns: 1fr; } }

    /* ── seeker card ── */
    .sk-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
        transition: box-shadow 0.2s, transform 0.2s;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .sk-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.07); transform: translateY(-2px); }
    .sk-card-header { display: flex; align-items: center; gap: 12px; }
    .sk-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        color: #fff;
        flex-shrink: 0;
    }
    .sk-card-name { font-size: 14.5px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.2; }
    .sk-card-title { font-size: 12.5px; color: #2563eb; font-weight: 600; margin: 2px 0 0; }
    .sk-avail-badge {
        margin-left: auto;
        font-size: 10.5px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 20px;
        flex-shrink: 0;
    }
    .avail-segera    { background: #dcfce7; color: #15803d; }
    .avail-bulan     { background: #fef3c7; color: #b45309; }
    .avail-lebih     { background: #f1f5f9; color: #64748b; }

    .sk-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 4px 10px;
    }
    .sk-meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11.5px;
        color: #64748b;
    }
    .sk-meta-item svg { width: 12px; height: 12px; color: #94a3b8; flex-shrink: 0; }

    .sk-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }
    .sk-skill-chip {
        font-size: 10.5px;
        font-weight: 600;
        color: #334155;
        background: #f1f5f9;
        border-radius: 4px;
        padding: 2px 7px;
    }

    .sk-about {
        font-size: 12px;
        color: #475569;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0;
    }

    .sk-card-footer {
        margin-top: auto;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .sk-exp-badge {
        font-size: 10.5px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
        background: #eff6ff;
        color: #2563eb;
    }
    .sk-view-btn {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        font-size: 11.5px;
        font-weight: 600;
        color: #fff;
        background: #2563eb;
        border-radius: 6px;
        text-decoration: none;
        box-shadow: 0 1px 3px rgba(37,99,235,0.2);
        transition: background 0.15s;
    }
    .sk-view-btn:hover {
        background: #1d4ed8;
        color: #fff;
        text-decoration: none;
    }

    /* ── empty ── */
    .sk-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px 24px;
        background: #fff;
        border: 1px dashed #cbd5e1;
        border-radius: 14px;
    }
    .sk-empty h3 { font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px; }
    .sk-empty p  { font-size: 14px; color: #64748b; margin: 0; }
</style>

{{-- Shared tabs nav --}}
<div style="margin-left: calc(50% - 50vw); margin-right: calc(50% - 50vw);">
    <nav class="cr-tabs" aria-label="Kategori Karir">
        <div class="cr-tabs-inner">
            @foreach($tabs as $key => $label)
                <a href="{{ route('career.index', ['type' => $key]) }}"
                   class="{{ $tab === $key ? 'on' : '' }}"
                   id="tab-{{ $key }}">{{ $label }}</a>
            @endforeach
        </div>
    </nav>
</div>

<div class="sk-page">
    {{-- Success banner --}}
    @if(session('seeker_success'))
        <div id="sk-success" style="display:flex;align-items:center;gap:12px;background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:1px solid #6ee7b7;border-radius:12px;padding:14px 20px;margin-top:16px;font-size:14px;font-weight:600;color:#065f46;">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:#059669"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            {{ session('seeker_success') }}
            <button onclick="document.getElementById('sk-success').remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:#059669;font-size:18px;line-height:1;">&times;</button>
        </div>
    @endif

    {{-- Hero banner --}}
    <div class="sk-hero">
        <div class="sk-hero-text">
            <h1>Direktori Pencari Kerja</h1>
            <p>Temukan kandidat berbakat atau daftarkan dirimu agar perusahaan bisa menemukanmu lebih mudah.</p>
        </div>
        <a href="{{ route('career.seeker.create') }}" class="sk-hero-btn">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Daftarkan Dirimu
        </a>
    </div>

    {{-- Toolbar --}}
    <div class="sk-toolbar">
        <p class="sk-count"><strong>{{ $seekers->total() }}</strong> pencari kerja aktif terdaftar</p>
        <form class="sk-search" method="GET" action="{{ route('career.index') }}">
            <input type="hidden" name="type" value="kerja">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama, posisi, lokasi...">
        </form>
    </div>

    {{-- Grid --}}
    <div class="sk-grid">
        @forelse($seekers as $seeker)
            @php
                $initials = collect(explode(' ', $seeker->name))->take(2)->map(fn($w) => strtoupper(substr($w,0,1)))->implode('');
                $colors = ['#2563eb','#7c3aed','#db2777','#059669','#d97706','#0891b2','#dc2626','#65a30d'];
                $avatarColor = $colors[$seeker->id % count($colors)];
                $availClass = match($seeker->availability) {
                    'Segera' => 'avail-segera',
                    'Bulan Depan' => 'avail-bulan',
                    default => 'avail-lebih',
                };
            @endphp
            <div class="sk-card" id="seeker-card-{{ $seeker->id }}">
                {{-- Header --}}
                <div class="sk-card-header">
                    <div class="sk-avatar" style="background: {{ $avatarColor }}">{{ $initials }}</div>
                    <div style="min-width:0;flex:1;">
                        <p class="sk-card-name">{{ $seeker->name }}</p>
                        <p class="sk-card-title">{{ $seeker->job_title }}</p>
                    </div>
                    <span class="sk-avail-badge {{ $availClass }}">{{ $seeker->availability }}</span>
                </div>

                {{-- Meta --}}
                <div class="sk-meta">
                    @if($seeker->location)
                    <span class="sk-meta-item">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                        {{ $seeker->location }}
                    </span>
                    @endif
                    @if($seeker->expected_salary)
                    <span class="sk-meta-item">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        {{ $seeker->expected_salary }}
                    </span>
                    @endif
                </div>

                {{-- Skills --}}
                @if(!empty($seeker->skills))
                    <div class="sk-skills">
                        @foreach(array_slice($seeker->skills, 0, 5) as $skill)
                            <span class="sk-skill-chip">{{ $skill }}</span>
                        @endforeach
                        @if(count($seeker->skills) > 5)
                            <span class="sk-skill-chip" style="background:#e2e8f0;color:#64748b;">+{{ count($seeker->skills) - 5 }}</span>
                        @endif
                    </div>
                @endif

                {{-- About --}}
                @if($seeker->about)
                    <p class="sk-about">{{ $seeker->about }}</p>
                @endif

                {{-- Footer --}}
                <div class="sk-card-footer">
                    <span class="sk-exp-badge">{{ $seeker->experience_level }}</span>
                    <a href="{{ route('career.seeker.show', $seeker->id) }}" class="sk-view-btn" id="view-seeker-{{ $seeker->id }}">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" style="margin-right:4px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="sk-empty">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="#cbd5e1" stroke-width="1.5" style="margin:0 auto 12px;display:block;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
                <h3>Belum ada pencari kerja terdaftar</h3>
                <p>Jadilah yang pertama mendaftarkan dirimu!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination (Centered) --}}
    @if($seekers->hasPages())
        <div class="sk-pagination mt-10 mb-4 flex justify-center w-full">
            {{ $seekers->withQueryString()->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
@endsection
