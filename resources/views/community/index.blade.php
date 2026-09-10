@extends('layouts.app')

@section('title', 'Community — Komunitas Tech Indonesia')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<div class="cmty-hero">
    <div class="cmty-hero-inner">
        <div class="cmty-hero-badge">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
            Joining Pengembang &amp; Desainer Indonesia
        </div>
        <h1 class="cmty-hero-title">Komunitas Tech Indonesia</h1>
        <p class="cmty-hero-sub">
            Terhubung, berbagi ilmu, dan berkolaborasi bersama ribuan talenta teknologi di seluruh Nusantara. Temukan ruang yang tumbuh yang relevan dengan kariermu.
        </p>

        {{-- Search --}}
        <form action="{{ route('community.index') }}" method="GET" class="cmty-hero-search-form" id="cmty-search-form">
            <input type="hidden" name="category" value="{{ $activeCategory }}">
            <div class="cmty-hero-search">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="q" id="cmty-search-input"
                       placeholder="Cari komunitas, topik diskusi, atau anggota..."
                       value="{{ request('q') }}" autocomplete="off">
                <button type="submit">Cari</button>
            </div>
        </form>

        {{-- Category Pills --}}
        <div class="cmty-cat-bar">
            <a href="{{ route('community.index', array_merge(request()->except('category','page'), ['category' => 'all'])) }}"
               class="cmty-cat-pill {{ $activeCategory === 'all' ? 'active' : '' }}">
                Semua
            </a>
            @php
                $categories = ['Technology', 'Design', 'Business', 'Education', 'Science'];
            @endphp
            @foreach($categories as $cat)
                @php $slug = strtolower(str_replace([' ', '&'], '-', $cat)); @endphp
                <a href="{{ route('community.index', array_merge(request()->except('category','page'), ['category' => $slug])) }}"
                   class="cmty-cat-pill {{ $activeCategory === $slug ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ===== MAIN LAYOUT ===== --}}
<div class="cmty-page-wrap">
    <div class="cmty-layout">

        {{-- ========== MAIN COLUMN (FULL WIDTH) ========== --}}
        <div class="cmty-main-col">

            {{-- Komunitas Populer & Unggulan --}}
            <div class="cmty-section">
                <div class="cmty-section-header">
                    <div>
                        <h2 class="cmty-section-title">Komunitas Populer &amp; Unggulan</h2>
                        <p class="cmty-section-sub">Bergabunglah dengan grup aktif yang diverifikasi oleh tim IndoTech.</p>
                    </div>
                    <button type="button" class="cmty-add-community-btn" id="cmty-add-community-btn" aria-label="Tambah Komunitas">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Komunitas
                    </button>
                </div>

                @if($communities->count() > 0)
                    <div class="cmty-cards-grid">
                        @foreach($communities as $community)
                            @php
                                $gradients = [
                                    'from-blue-500 to-indigo-600',
                                    'from-pink-500 to-rose-500',
                                    'from-emerald-500 to-teal-500',
                                    'from-amber-500 to-orange-500',
                                    'from-violet-500 to-purple-600',
                                    'from-cyan-500 to-blue-500',
                                    'from-fuchsia-500 to-pink-500',
                                    'from-lime-500 to-green-500',
                                ];
                                $gradientColors = [
                                    ['#3b82f6','#6366f1'],
                                    ['#ec4899','#f43f5e'],
                                    ['#10b981','#14b8a6'],
                                    ['#f59e0b','#f97316'],
                                    ['#8b5cf6','#a855f7'],
                                    ['#06b6d4','#3b82f6'],
                                    ['#d946ef','#ec4899'],
                                    ['#84cc16','#22c55e'],
                                ];
                                $gc = $gradientColors[($community['id'] - 1) % count($gradientColors)];
                                $initials = collect(explode(' ', $community['name']))->take(2)->map(fn($w) => strtoupper($w[0]))->join('');

                                $categoryBadgeColors = [
                                    'Technology' => 'cmty-badge-tech',
                                    'Design'     => 'cmty-badge-design',
                                    'Business'   => 'cmty-badge-biz',
                                    'Education'  => 'cmty-badge-edu',
                                    'Science'    => 'cmty-badge-sci',
                                ];
                                $badgeClass = $categoryBadgeColors[$community['category']] ?? 'cmty-badge-tech';

                                // Simulate member avatars
                                $avatarColors = ['#3b82f6','#10b981','#f59e0b','#8b5cf6','#ec4899'];
                                $avatarInitials = ['RH','DS','FA','MK','NP'];
                            @endphp
                            <div class="cmty-card" id="cmty-card-{{ $community['id'] }}">
                                {{-- Top: Logo + Status badge --}}
                                <div class="cmty-card-top">
                                    <div class="cmty-card-logo-wrap">
                                        @if(!empty($community['logo_url']))
                                            <img src="{{ $community['logo_url'] }}" alt="{{ $community['name'] }}" class="cmty-card-logo">
                                        @else
                                            <div class="cmty-card-logo-init"
                                                 style="background: linear-gradient(135deg, {{ $gc[0] }}, {{ $gc[1] }})">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="cmty-card-badges">
                                        <span class="cmty-badge-aktif">
                                            <span class="cmty-pulse-dot"></span>
                                            Sangat Aktif
                                        </span>
                                        <span class="cmty-badge {{ $badgeClass }}">{{ $community['category'] }}</span>
                                    </div>
                                </div>

                                {{-- Name + Member count --}}
                                <div class="cmty-card-middle">
                                    <h3 class="cmty-card-name">{{ $community['name'] }}</h3>
                                    <p class="cmty-card-member-count">
                                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ number_format($community['members'] / 1000, 1) }}k anggota
                                    </p>
                                    <p class="cmty-card-desc">{{ $community['description'] }}</p>

                                    {{-- Tags --}}
                                    @if(!empty($community['tags']))
                                        <div class="cmty-card-tags">
                                            @foreach(array_slice($community['tags'], 0, 3) as $tag)
                                                <span class="cmty-tag">#{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- Bottom: Avatars + Join --}}
                                <div class="cmty-card-footer">
                                    <div class="cmty-avatars">
                                        @for($i = 0; $i < 4; $i++)
                                            <div class="cmty-avatar" style="background:{{ $avatarColors[$i % count($avatarColors)] }}; z-index: {{ 4 - $i }};">
                                                {{ $avatarInitials[$i] }}
                                            </div>
                                        @endfor
                                        <span class="cmty-avatar-more">{{ number_format($community['members'] / 1000, 0) }}k anggota</span>
                                    </div>
                                    <a href="{{ $community['website'] }}" target="_blank" rel="noopener noreferrer" class="cmty-join-btn">
                                        Gabung
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="cmty-empty">
                        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p>Tidak ada komunitas ditemukan.</p>
                        <a href="{{ route('community.index') }}">Reset Filter</a>
                    </div>
                @endif

                {{-- Pagination --}}
                @if($communities->hasPages())
                    <div class="cmty-pagination">
                        {{ $communities->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>

            {{-- Diskusi Terhangat --}}
            <div class="cmty-section cmty-discuss-section">
                <div class="cmty-section-header">
                    <div>
                        <h2 class="cmty-section-title">Diskusi Terhangat</h2>
                        <p class="cmty-section-sub">Pertanyaan, inspirasi, tips, jawab-kepo, dan diskusi produk industri terkini.</p>
                    </div>
                    <div class="cmty-discuss-tabs">
                        <button class="cmty-tab active" onclick="switchTab(this, 'trending')">Trending</button>
                        <button class="cmty-tab" onclick="switchTab(this, 'terbaru')">Terbaru</button>
                        <button class="cmty-tab" onclick="switchTab(this, 'belum')">Belum Terjawab</button>
                    </div>
                </div>

                <div class="cmty-discuss-list" id="discuss-list">
                    @php
                        $discussions = [
                            [
                                'id' => 1,
                                'author' => 'Bambang Wicaksono',
                                'role' => 'Lead Backend Engineer at PT Indo Vision',
                                'avatar_color' => '#2563eb',
                                'initials' => 'BW',
                                'tag' => '#Arsitektur',
                                'title' => 'Pengalaman migrasi monolitik ke event-driven architecture di tech startup lokal: Tantangan operasional & audit log',
                                'excerpt' => 'Setelah 5 tahun menjalankan codebase PHP dengan arsitektur monolith dan library event BPS Nasii saat kamu tahu ketika ada masalah dari konsistensi data.',
                                'upvotes' => 156,
                                'comments' => 48,
                                'time' => '1 hr Dilihat',
                            ],
                            [
                                'id' => 2,
                                'author' => 'Annisa Nurai',
                                'role' => 'Satu yang lagi baru',
                                'avatar_color' => '#ec4899',
                                'initials' => 'AN',
                                'tag' => '#KarierTech',
                                'title' => 'Roadmap belajar Data Science untuk fresh graduate tahun 2025: Portofolio nyata vs Sertifikasi mana yang lebih dianggap?',
                                'excerpt' => 'Banyak saran online yang saling bertentangan. Sertifikasi global expert AWS ML Specialty atau OCP Professional Data Engineer lebih dari Github project open-source dan to-do web.',
                                'upvotes' => 243,
                                'comments' => 91,
                                'time' => '3 hr Dilihat',
                            ],
                            [
                                'id' => 3,
                                'author' => 'Ilham Hartun',
                                'role' => 'Product Future Designer',
                                'avatar_color' => '#10b981',
                                'initials' => 'IH',
                                'tag' => '#DesignSystem',
                                'title' => 'Menjaga sinkronisasi token warna di Figma & Tailwind v4 untuk tim multidisiplin',
                                'excerpt' => 'Siapa ada yang cara bagus itu mengelola desain token dalam konteks pembuatan token desain tanpa automasi export ke style-dictionary.',
                                'upvotes' => 89,
                                'comments' => 31,
                                'time' => '1.5 hr Dilihat',
                            ],
                        ];
                    @endphp

                    @foreach($discussions as $disc)
                        <div class="cmty-discuss-item">
                            <div class="cmty-discuss-left">
                                <div class="cmty-discuss-vote">
                                    <button class="cmty-vote-btn" aria-label="Upvote">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    </button>
                                    <span class="cmty-vote-count">{{ $disc['upvotes'] }}</span>
                                </div>
                            </div>
                            <div class="cmty-discuss-body">
                                <div class="cmty-discuss-meta">
                                    <div class="cmty-discuss-avatar" style="background:{{ $disc['avatar_color'] }}">{{ $disc['initials'] }}</div>
                                    <span class="cmty-discuss-author">{{ $disc['author'] }}</span>
                                    <span class="cmty-discuss-role">• {{ $disc['role'] }}</span>
                                    <span class="cmty-discuss-tag">{{ $disc['tag'] }}</span>
                                </div>
                                <h4 class="cmty-discuss-title">{{ $disc['title'] }}</h4>
                                <p class="cmty-discuss-excerpt">{{ $disc['excerpt'] }}</p>
                                <div class="cmty-discuss-footer">
                                    <span class="cmty-discuss-stat">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $disc['comments'] }} Komentar
                                    </span>
                                    <span class="cmty-discuss-stat">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        {{ $disc['time'] }}
                                    </span>
                                    <button class="cmty-discuss-bookmark" aria-label="Bookmark">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cmty-load-more-wrap">
                    <button class="cmty-load-more-btn" id="load-more-btn">
                        Muat Lebih Banyak Diskusi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STATS SECTION ===== --}}
<div class="cmty-stats-section">
    <div class="cmty-stats-inner">
        <div class="cmty-stats-grid">
            <div class="cmty-stats-item">
                <span class="cmty-stats-num">180+</span>
                <span class="cmty-stats-label">Komunitas Aktif Terdaftar</span>
            </div>
            <div class="cmty-stats-item">
                <span class="cmty-stats-num">95,000+</span>
                <span class="cmty-stats-label">Pengembang &amp; Desainer</span>
            </div>
            <div class="cmty-stats-item">
                <span class="cmty-stats-num">34</span>
                <span class="cmty-stats-label">Provinsi Terjangkau</span>
            </div>
            <div class="cmty-stats-item">
                <span class="cmty-stats-num">500+</span>
                <span class="cmty-stats-label">Meetup &amp; Webinar Tahunan</span>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================
   COMMUNITY PAGE STYLES
   ============================================ */

/* ----- HERO ----- */
.cmty-hero {
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    padding: 48px 24px 0;
    text-align: center;
}
.cmty-hero-inner {
    max-width: 760px;
    margin: 0 auto;
}
.cmty-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #2563eb;
    font-size: 12.5px;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 999px;
    margin-bottom: 20px;
}
.cmty-hero-title {
    font-size: 38px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
    letter-spacing: -0.5px;
    margin: 0 0 12px;
}
@media (min-width: 640px) { .cmty-hero-title { font-size: 46px; } }
.cmty-hero-sub {
    font-size: 15px;
    color: #64748b;
    line-height: 1.7;
    margin: 0 auto 28px;
    max-width: 580px;
}

/* Hero Search */
.cmty-hero-search-form { max-width: 580px; margin: 0 auto 28px; }
.cmty-hero-search {
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 50px;
    padding: 6px 6px 6px 18px;
    gap: 10px;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.cmty-hero-search:focus-within {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
.cmty-hero-search svg { color: #94a3b8; flex-shrink: 0; }
.cmty-hero-search input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 14px;
    color: #334155;
    background: transparent;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.cmty-hero-search input::placeholder { color: #94a3b8; }
.cmty-hero-search button {
    background: #2563eb;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 9px 24px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    flex-shrink: 0;
}
.cmty-hero-search button:hover { background: #1d4ed8; }

/* Category Pills */
.cmty-cat-bar {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    justify-content: center;
    padding-bottom: 0;
    margin-bottom: -1px;
}
.cmty-cat-pill {
    display: inline-flex;
    align-items: center;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    background: transparent;
    border: none;
    border-bottom: 2.5px solid transparent;
    text-decoration: none;
    transition: color 0.15s, border-color 0.15s;
    white-space: nowrap;
    cursor: pointer;
}
.cmty-cat-pill:hover { color: #2563eb; }
.cmty-cat-pill.active {
    color: #2563eb;
    border-bottom-color: #2563eb;
}

/* ----- PAGE LAYOUT ----- */
.cmty-page-wrap {
    background: #f8fafc;
    padding: 40px 24px;
}
.cmty-layout {
    max-width: 1200px;
    margin: 0 auto;
}

/* ----- SECTION WRAPPER ----- */
.cmty-section {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 28px;
    margin-bottom: 24px;
}
.cmty-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 24px;
}
.cmty-section-title {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px;
}
.cmty-section-sub {
    font-size: 13px;
    color: #94a3b8;
    margin: 0;
}
.cmty-section-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 600;
    color: #2563eb;
    text-decoration: none;
    white-space: nowrap;
    transition: color 0.15s;
    flex-shrink: 0;
}
.cmty-section-link:hover { color: #1d4ed8; }

/* Add Community Button */
.cmty-add-community-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 700;
    color: #2563eb;
    background: #eff6ff;
    border: 1.5px solid #bfdbfe;
    border-radius: 10px;
    padding: 8px 16px;
    cursor: pointer;
    transition: all 0.15s ease;
    flex-shrink: 0;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.cmty-add-community-btn:hover {
    background: #dbeafe;
    border-color: #93c5fd;
    color: #1d4ed8;
    transform: translateY(-1px);
}
.cmty-add-community-btn:active {
    transform: translateY(0);
}
.cmty-add-community-btn svg { flex-shrink: 0; }

/* ----- COMMUNITY CARDS GRID ----- */
.cmty-cards-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}
@media (max-width: 640px) {
    .cmty-cards-grid { grid-template-columns: 1fr; }
}

/* ----- COMMUNITY CARD ----- */
.cmty-card {
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: #ffffff;
    transition: box-shadow 0.2s, border-color 0.2s, transform 0.2s;
}
.cmty-card:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,0.08);
    border-color: #bfdbfe;
    transform: translateY(-2px);
}

.cmty-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
}
.cmty-card-logo-wrap { flex-shrink: 0; }
.cmty-card-logo {
    width: 48px; height: 48px;
    border-radius: 12px;
    object-fit: cover;
    border: 1.5px solid #e2e8f0;
}
.cmty-card-logo-init {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 800;
    color: #fff;
}
.cmty-card-badges {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
}
.cmty-badge-aktif {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    color: #16a34a;
    background: #dcfce7;
    padding: 3px 9px;
    border-radius: 999px;
}
.cmty-pulse-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #16a34a;
    animation: cmty-pulse 2s infinite;
}
@keyframes cmty-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
}
.cmty-badge {
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 5px;
}
.cmty-badge-tech     { background: #dbeafe; color: #1d4ed8; }
.cmty-badge-design   { background: #fce7f3; color: #be185d; }
.cmty-badge-biz      { background: #d1fae5; color: #065f46; }
.cmty-badge-edu      { background: #fef3c7; color: #92400e; }
.cmty-badge-sci      { background: #ede9fe; color: #5b21b6; }

.cmty-card-middle { flex: 1; display: flex; flex-direction: column; gap: 8px; }
.cmty-card-name {
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    line-height: 1.3;
}
.cmty-card-member-count {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
    margin: 0;
}
.cmty-card-member-count svg { color: #94a3b8; }
.cmty-card-desc {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cmty-card-tags { display: flex; flex-wrap: wrap; gap: 5px; }
.cmty-tag {
    font-size: 11px;
    font-weight: 600;
    color: #475569;
    background: #f1f5f9;
    padding: 2px 8px;
    border-radius: 5px;
    border: 1px solid #e2e8f0;
}

.cmty-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}
.cmty-avatars {
    display: flex;
    align-items: center;
}
.cmty-avatar {
    width: 26px; height: 26px;
    border-radius: 50%;
    border: 2px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
    color: #fff;
    margin-left: -6px;
    position: relative;
}
.cmty-avatar:first-child { margin-left: 0; }
.cmty-avatar-more {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
    margin-left: 8px;
    white-space: nowrap;
}
.cmty-join-btn {
    display: inline-flex;
    align-items: center;
    background: #2563eb;
    color: #fff;
    font-size: 12.5px;
    font-weight: 700;
    padding: 7px 18px;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.15s;
    flex-shrink: 0;
}
.cmty-join-btn:hover { background: #1d4ed8; }

/* ----- EMPTY STATE ----- */
.cmty-empty {
    text-align: center;
    padding: 48px 24px;
    color: #94a3b8;
}
.cmty-empty svg { margin: 0 auto 12px; display: block; }
.cmty-empty p { font-size: 14px; margin: 0 0 16px; }
.cmty-empty a {
    display: inline-flex;
    padding: 9px 20px;
    background: #2563eb;
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

/* ----- DISKUSI SECTION ----- */
.cmty-discuss-section {}
.cmty-discuss-tabs {
    display: flex;
    gap: 4px;
    background: #f1f5f9;
    border-radius: 10px;
    padding: 3px;
    flex-shrink: 0;
}
.cmty-tab {
    padding: 6px 14px;
    font-size: 12.5px;
    font-weight: 600;
    color: #64748b;
    background: transparent;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.cmty-tab.active {
    background: #ffffff;
    color: #2563eb;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}
.cmty-tab:hover:not(.active) { color: #334155; }

.cmty-discuss-list { display: flex; flex-direction: column; gap: 0; }
.cmty-discuss-item {
    display: flex;
    gap: 14px;
    padding: 18px 0;
    border-bottom: 1px solid #f1f5f9;
}
.cmty-discuss-item:last-child { border-bottom: none; }

.cmty-discuss-left { flex-shrink: 0; }
.cmty-discuss-vote {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    min-width: 36px;
}
.cmty-vote-btn {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    width: 30px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.15s;
}
.cmty-vote-btn:hover { background: #eff6ff; border-color: #bfdbfe; color: #2563eb; }
.cmty-vote-count {
    font-size: 12px;
    font-weight: 700;
    color: #475569;
}

.cmty-discuss-body { flex: 1; min-width: 0; }
.cmty-discuss-meta {
    display: flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 8px;
    flex-wrap: wrap;
}
.cmty-discuss-avatar {
    width: 24px; height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}
.cmty-discuss-author {
    font-size: 12.5px;
    font-weight: 700;
    color: #0f172a;
}
.cmty-discuss-role {
    font-size: 12px;
    color: #94a3b8;
}
.cmty-discuss-tag {
    font-size: 11px;
    font-weight: 700;
    color: #2563eb;
    background: #eff6ff;
    padding: 2px 8px;
    border-radius: 5px;
    margin-left: auto;
}

.cmty-discuss-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 6px;
    line-height: 1.45;
    cursor: pointer;
    transition: color 0.15s;
}
.cmty-discuss-title:hover { color: #2563eb; }
.cmty-discuss-excerpt {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.6;
    margin: 0 0 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cmty-discuss-footer {
    display: flex;
    align-items: center;
    gap: 14px;
}
.cmty-discuss-stat {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
}
.cmty-discuss-stat svg { color: #cbd5e1; }
.cmty-discuss-bookmark {
    margin-left: auto;
    background: none;
    border: none;
    cursor: pointer;
    color: #cbd5e1;
    padding: 3px;
    transition: color 0.15s;
}
.cmty-discuss-bookmark:hover { color: #2563eb; }

/* Load More */
.cmty-load-more-wrap { text-align: center; margin-top: 20px; }
.cmty-load-more-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 28px;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 999px;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: all 0.15s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.cmty-load-more-btn:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
    color: #2563eb;
}

/* ----- PAGINATION ----- */
.cmty-pagination {
    display: flex;
    justify-content: center;
    padding: 32px 0 12px;
}
.cmty-pagination :where(nav, .flex) {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
    justify-content: center;
}
.cmty-pagination a.inline-flex,
.cmty-pagination span.inline-flex {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    padding: 0 10px;
    text-decoration: none;
    transition: all 0.15s ease;
}
.cmty-pagination [aria-current="page"] {
    color: #ffffff;
    background: linear-gradient(135deg, #2563eb, #6366f1);
    border-color: #2563eb;
    box-shadow: 0 2px 8px rgba(37, 99, 235, .25);
}
.cmty-pagination a.inline-flex:hover {
    border-color: #bfdbfe;
    color: #2563eb;
}
.cmty-pagination span[aria-disabled="true"] span,
.cmty-pagination span.cursor-not-allowed {
    color: #94a3b8;
    background: #f8fafc;
    cursor: default;
}
.cmty-pagination p.text-sm {
    font-size: 12.5px;
    color: #94a3b8;
}
.cmty-pagination p.text-sm span.font-medium {
    color: #0f172a;
}

/* ----- SIDEBAR ----- */
.cmty-sidebar { display: flex; flex-direction: column; gap: 20px; }
.cmty-sidebar-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 22px;
}
.cmty-sidebar-box-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}
.cmty-sidebar-title {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}
.cmty-sidebar-link {
    font-size: 12.5px;
    font-weight: 600;
    color: #2563eb;
    text-decoration: none;
}
.cmty-sidebar-link:hover { color: #1d4ed8; }

/* Meetup Items */
.cmty-meetup-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.cmty-meetup-item:last-child { margin-bottom: 0; }
.cmty-meetup-featured {
    border-color: #bfdbfe;
    background: #fafcff;
}
.cmty-meetup-date-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 46px;
    min-width: 46px;
    height: 46px;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.cmty-meetup-day { font-size: 18px; font-weight: 800; line-height: 1; }
.cmty-meetup-month { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.cmty-meetup-info { flex: 1; min-width: 0; }
.cmty-meetup-time { font-size: 11px; font-weight: 700; display: block; margin-bottom: 3px; }
.cmty-meetup-title {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cmty-meetup-location {
    font-size: 11.5px;
    color: #94a3b8;
    margin: 0 0 6px;
}
.cmty-meetup-attendees {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
}
.cmty-meetup-attendees svg { color: #94a3b8; }
.cmty-meetup-cta { width: 100%; padding-top: 10px; }
.cmty-meetup-register-btn {
    display: block;
    text-align: center;
    background: #2563eb;
    color: #fff;
    font-size: 12.5px;
    font-weight: 700;
    padding: 9px;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.15s;
}
.cmty-meetup-register-btn:hover { background: #1d4ed8; }

/* Dark CTA Box */
.cmty-cta-dark-box {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-color: transparent;
}
.cmty-cta-dark-icon {
    width: 48px; height: 48px;
    background: rgba(59,130,246,0.15);
    border: 1px solid rgba(59,130,246,0.3);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #60a5fa;
    margin-bottom: 14px;
}
.cmty-cta-dark-title {
    font-size: 16px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 8px;
}
.cmty-cta-dark-desc {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.6;
    margin: 0 0 16px;
}
.cmty-cta-dark-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 700;
    color: #60a5fa;
    text-decoration: none;
    transition: color 0.15s;
}
.cmty-cta-dark-link:hover { color: #93c5fd; }

/* Contributors */
.cmty-contributor-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
}
.cmty-contributor-item:last-of-type { border-bottom: none; }
.cmty-contrib-rank {
    font-size: 16px;
    font-weight: 800;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
}
.cmty-contrib-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}
.cmty-contrib-info {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
}
.cmty-contrib-name {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cmty-contrib-sub {
    font-size: 11px;
    color: #94a3b8;
}
.cmty-contrib-pts {
    font-size: 12px;
    font-weight: 700;
    color: #2563eb;
    flex-shrink: 0;
}
.cmty-contrib-note {
    font-size: 11px;
    color: #cbd5e1;
    margin: 10px 0 0;
    text-align: center;
}

/* ----- STATS SECTION ----- */
.cmty-stats-section {
    background: #0f172a;
    padding: 56px 24px;
}
.cmty-stats-inner { max-width: 1000px; margin: 0 auto; }
.cmty-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 32px;
    text-align: center;
}
@media (max-width: 768px) {
    .cmty-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
}
@media (max-width: 400px) {
    .cmty-stats-grid { grid-template-columns: 1fr 1fr; }
}
.cmty-stats-item { display: flex; flex-direction: column; gap: 6px; }
.cmty-stats-num {
    font-size: 36px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.5px;
}
.cmty-stats-label {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
    line-height: 1.4;
}
</style>

<script>
function switchTab(el, tab) {
    document.querySelectorAll('.cmty-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    // In a real app this would filter discussions via AJAX
}

document.getElementById('load-more-btn')?.addEventListener('click', function () {
    this.textContent = 'Memuat...';
    setTimeout(() => { this.textContent = 'Muat Lebih Banyak Diskusi'; }, 1200);
});

// Add Community button — static placeholder for now
document.getElementById('cmty-add-community-btn')?.addEventListener('click', function () {
    alert('Fitur Tambah Komunitas sedang dalam pengembangan. Silakan hubungi tim IndoTech.');
});
</script>

@endsection
