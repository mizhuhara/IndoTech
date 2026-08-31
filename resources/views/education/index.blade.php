@extends('layouts.app')

@section('title', 'Vocational High School (SMK) Directory - IndoTech')

@section('content')

{{-- Hero Section --}}
<section class="py-12 sm:py-16 px-4 text-center max-w-4xl mx-auto">
    <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
        Vocational High School (SMK) Directory
    </h1>
    <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto">
        Discover and connect with top IT vocational schools (SMK Jurusan IT) across Indonesia, specializing in Software Engineering, Network Infrastructure, Cybersecurity, and Creative Technologies.
    </p>
</section>

{{-- Main Container --}}
<div class="max-w-7xl mx-auto px-4 pb-28 sm:pb-36">

    {{-- Filter Bar Toolbar --}}
    <div class="bg-white border border-slate-200 rounded-xl p-3 sm:p-4 mb-10 shadow-xs">
        <form id="educationFilterForm" onsubmit="event.preventDefault(); applyEduFilter();" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-center">
            
            {{-- Location / Region Filter --}}
            <div class="relative flex items-center">
                <svg class="absolute left-3.5 w-4 h-4 text-slate-400 pointer-events-none stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <select id="eduLocationSelect" class="w-full h-11 pl-10 pr-8 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-hidden focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition cursor-pointer appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center]" onchange="applyEduFilter()">
                    <option value="">All Locations (Seluruh Indonesia)</option>
                    <option value="Jakarta">DKI Jakarta</option>
                    <option value="West Java">Jawa Barat (Bandung)</option>
                    <option value="Central Java">Jawa Tengah (Kudus)</option>
                    <option value="East Java">Jawa Timur (Surabaya/Malang)</option>
                    <option value="Yogyakarta">DI Yogyakarta</option>
                    <option value="Bali">Bali (Denpasar)</option>
                    <option value="Sumatra">Sumatera (Medan)</option>
                    <option value="Sulawesi">Sulawesi (Makassar)</option>
                    <option value="Kalimantan">Kalimantan (Banjarbaru)</option>
                    <option value="Papua">Papua (Jayapura)</option>
                </select>
            </div>

            {{-- Skill Competencies Filter --}}
            <div>
                <select id="eduSkillSelect" class="w-full h-11 px-3.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-hidden focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition cursor-pointer appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center]" onchange="applyEduFilter()">
                    <option value="">Skill Competencies (Jurusan IT)</option>
                    <option value="RPL">Software Engineering (RPL)</option>
                    <option value="TKJ">Computer Network (TKJ)</option>
                    <option value="SIJA">SIJA (Cloud & Network)</option>
                    <option value="Multimedia">Multimedia & Design</option>
                    <option value="3D Animation">3D Animation</option>
                </select>
            </div>

            {{-- Featured Programs Filter --}}
            <div>
                <select id="eduProgramSelect" class="w-full h-11 px-3.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-hidden focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition cursor-pointer appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center]" onchange="applyEduFilter()">
                    <option value="">Featured Programs</option>
                    <option value="Teaching Factory">Teaching Factory</option>
                    <option value="Center of Excellence">Center of Excellence</option>
                    <option value="Enrollment Open">Enrollment Open</option>
                </select>
            </div>

            {{-- Teaching Factory Filter --}}
            <div>
                <select id="eduTeFaSelect" class="w-full h-11 px-3.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-hidden focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition cursor-pointer appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center]" onchange="applyEduFilter()">
                    <option value="">Teaching Factory</option>
                    <option value="Active">Active TeFa Partner</option>
                    <option value="Lab">Modern Lab Certified</option>
                </select>
            </div>

            {{-- More Filter Button (Dropdown) --}}
            <div class="relative group/dropdown">
                <button type="button" class="w-full h-11 px-4 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-semibold rounded-lg flex items-center justify-center gap-2 transition cursor-pointer">
                    <svg class="w-4 h-4 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <line x1="4" y1="6" x2="20" y2="6"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                        <line x1="10" y1="18" x2="14" y2="18"/>
                    </svg>
                    <span>More</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover/dropdown:rotate-180 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                {{-- Dropdown Menu --}}
                <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-lg opacity-0 invisible group-hover/dropdown:opacity-100 group-hover/dropdown:visible transition-all duration-200 z-50 py-1">
                    <a href="{{ route('campus.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        Kampus
                    </a>
                    <a href="{{ route('education.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        SMK
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- School Cards Grid (3 Columns) --}}
    <div id="schoolGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($schools as $school)
            <div class="school-card bg-white border border-slate-200 rounded-2xl overflow-hidden flex flex-col justify-between hover:shadow-xl hover:border-slate-300 transition-all duration-200 group"
                 data-location="{{ $school['location'] }}"
                 data-province="{{ $school['province'] ?? '' }}"
                 data-tags="{{ implode(',', $school['tags']) }}"
                 data-status="{{ $school['status_badge'] }}">

                <div>
                    {{-- Header Banner & Floating Logo --}}
                    <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                        <img src="{{ $school['image'] }}" alt="{{ $school['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        
                        {{-- Logo Box --}}
                        <div class="absolute bottom-3 left-4 w-12 h-12 rounded-xl bg-white border border-slate-200/80 shadow-md p-1.5 flex items-center justify-center">
                            <div class="w-full h-full rounded-lg flex items-center justify-center text-white text-xs font-bold text-center leading-none {{ $school['logo_bg_class'] ?? 'bg-blue-600' }}">
                                {{ $school['logo_text'] }}
                            </div>
                        </div>
                    </div>

                    {{-- Card Body Content --}}
                    <div class="p-5">
                        {{-- Title Row with Verified Badge --}}
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <h3 class="font-bold text-lg text-slate-900 leading-snug group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('education.show', $school['id']) }}">
                                    {{ $school['name'] }}
                                </a>
                            </h3>
                            @if($school['verified'])
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200/60 shrink-0">
                                    <svg class="w-3 h-3 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Verified
                                </span>
                            @endif
                        </div>

                        {{-- Location --}}
                        <div class="flex items-center gap-1 text-xs text-slate-500 mb-4">
                            <svg class="w-3.5 h-3.5 text-slate-400 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $school['location'] }}</span>
                        </div>

                        {{-- Competencies Tags --}}
                        <div class="flex flex-wrap gap-1.5 mb-5">
                            @foreach($school['tags'] as $tag)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-slate-100 text-slate-600">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Bottom Row --}}
                <div class="px-5 pb-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        @if($school['status_badge_type'] == 'green')
                            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                                {{ $school['status_badge'] }}
                            </span>
                        @elseif($school['status_badge_type'] == 'purple')
                            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-100">
                                {{ $school['status_badge'] }}
                            </span>
                        @else
                            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200/60">
                                {{ $school['status_badge'] }}
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('education.show', $school['id']) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline transition">
                        View Profile
                    </a>
                </div>
            </div>
        @endforeach
    </div>

        {{-- Empty state --}}
        <div id="emptyState" class="hidden text-center py-12 px-6 bg-white border border-dashed border-slate-300 rounded-xl col-span-full">
            <svg class="w-12 h-12 text-slate-400 mx-auto mb-3 stroke-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <h4 class="text-base font-bold text-slate-800 mb-1">Tidak Ada Sekolah Ditemukan</h4>
            <p class="text-sm text-slate-500">Coba sesuaikan filter lokasi atau jurusan IT Anda.</p>
        </div>
    </div>

    {{-- Pagination Navigation Bar (Matching Industry Design) --}}
    <div id="paginationBar" class="flex items-center justify-center gap-2 mt-14 mb-6">
        <button type="button" id="prevPageBtn" onclick="changePage(currentPage - 1)" class="w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 text-sm font-semibold flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition cursor-pointer" aria-label="Previous">
            <svg class="w-4 h-4 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <button type="button" class="page-num w-9 h-9 rounded-lg border border-blue-700 bg-blue-700 text-white text-sm font-semibold flex items-center justify-center transition cursor-pointer" onclick="changePage(1)">1</button>
        <button type="button" class="page-num w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 text-sm font-semibold flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition cursor-pointer" onclick="changePage(2)">2</button>
        <button type="button" class="page-num w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 text-sm font-semibold flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition cursor-pointer" onclick="changePage(3)">3</button>

        <button type="button" id="nextPageBtn" onclick="changePage(currentPage + 1)" class="w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 text-sm font-semibold flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition cursor-pointer" aria-label="Next">
            <svg class="w-4 h-4 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>
</div>

<script>
    let currentPage = 1;
    const itemsPerPage = 6;
    let filteredItems = [];

    document.addEventListener("DOMContentLoaded", function() {
        applyEduFilter();
    });

    function applyEduFilter() {
        const loc = document.getElementById('eduLocationSelect').value.toLowerCase();
        const skill = document.getElementById('eduSkillSelect').value.toLowerCase();
        const program = document.getElementById('eduProgramSelect').value.toLowerCase();

        const allCards = Array.from(document.querySelectorAll('.school-card'));

        filteredItems = allCards.filter(card => {
            const cardLoc = card.getAttribute('data-location').toLowerCase();
            const cardProv = (card.getAttribute('data-province') || '').toLowerCase();
            const cardTags = card.getAttribute('data-tags').toLowerCase();
            const cardStatus = card.getAttribute('data-status').toLowerCase();

            const matchLoc = !loc || cardLoc.includes(loc) || cardProv.includes(loc);
            const matchSkill = !skill || cardTags.includes(skill);
            const matchProg = !program || cardStatus.includes(program);

            return matchLoc && matchSkill && matchProg;
        });

        currentPage = 1;
        renderPage();
    }

    function renderPage() {
        const allCards = document.querySelectorAll('.school-card');
        const emptyState = document.getElementById('emptyState');
        const paginationBar = document.getElementById('paginationBar');

        allCards.forEach(card => card.classList.add('hidden'));

        if (filteredItems.length === 0) {
            if (emptyState) emptyState.classList.remove('hidden');
            if (paginationBar) paginationBar.classList.add('hidden');
            return;
        } else {
            if (emptyState) emptyState.classList.add('hidden');
            if (paginationBar) {
                paginationBar.classList.remove('hidden');
                paginationBar.classList.add('flex');
            }
        }

        const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        const pageItems = filteredItems.slice(startIndex, endIndex);
        pageItems.forEach(card => card.classList.remove('hidden'));

        // Update pagination buttons
        const pageBtns = document.querySelectorAll('.page-num');
        pageBtns.forEach((btn, index) => {
            const pageNum = index + 1;
            if (pageNum <= totalPages) {
                btn.classList.remove('hidden');
                if (pageNum === currentPage) {
                    btn.className = 'page-num w-9 h-9 rounded-lg border border-blue-700 bg-blue-700 text-white text-sm font-semibold flex items-center justify-center transition cursor-pointer';
                } else {
                    btn.className = 'page-num w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 text-sm font-semibold flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition cursor-pointer';
                }
            } else {
                btn.classList.add('hidden');
            }
        });

        // Prev & Next Buttons state
        const prevBtn = document.getElementById('prevPageBtn');
        const nextBtn = document.getElementById('nextPageBtn');

        if (currentPage === 1) {
            prevBtn.classList.add('opacity-40', 'cursor-not-allowed');
        } else {
            prevBtn.classList.remove('opacity-40', 'cursor-not-allowed');
        }

        if (currentPage === totalPages || totalPages === 0) {
            nextBtn.classList.add('opacity-40', 'cursor-not-allowed');
        } else {
            nextBtn.classList.remove('opacity-40', 'cursor-not-allowed');
        }
    }

    function changePage(page) {
        const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderPage();

        window.scrollTo({
            top: document.getElementById('educationFilterForm').offsetTop - 80,
            behavior: 'smooth'
        });
    }
</script>

@endsection
