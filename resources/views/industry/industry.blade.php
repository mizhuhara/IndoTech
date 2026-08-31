@extends('layouts.app')

@section('title', 'Ekosistem IT di Bali - IndoTech')

@section('content')

{{-- Hero Header Section --}}
<section class="py-12 sm:py-16 px-4 text-center max-w-4xl mx-auto">
    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-3">
        Ekosistem IT di Bali
    </h1>
    <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto">
        Jelajahi lanskap teknologi yang sedang berkembang di Bali. Temukan perusahaan inovatif, agensi kreatif, dan startup yang membangun masa depan digital dari Pulau Dewata.
    </p>
</section>

{{-- Main Content Container --}}
<div class="max-w-6xl mx-auto px-4 pb-28 sm:pb-36">

    {{-- Filter Bar Toolbar --}}
    <div class="bg-white border border-slate-200 rounded-xl p-3 sm:p-4 mb-8 shadow-xs">
        <form id="filterForm" onsubmit="event.preventDefault(); applyFilter();" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 items-center">
            
            {{-- Search Bar --}}
            <div class="relative flex items-center">
                <svg class="absolute left-3.5 w-4 h-4 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput" class="w-full h-11 pl-10 pr-3 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition" placeholder="Cari perusahaan..." onkeyup="applyFilter()">
            </div>

            {{-- Location Filter --}}
            <div>
                <select id="locationSelect" class="w-full h-11 px-3.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-hidden focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition cursor-pointer appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center]" onchange="applyFilter()">
                    <option value="">Semua Lokasi</option>
                    <option value="Denpasar">Denpasar</option>
                    <option value="Badung">Badung</option>
                    <option value="Ubud">Ubud</option>
                    <option value="Canggu">Canggu</option>
                    <option value="Sanur">Sanur</option>
                    <option value="Kuta">Kuta</option>
                    <option value="Seminyak">Seminyak</option>
                    <option value="Jimbaran">Jimbaran</option>
                    <option value="Benoa">Benoa</option>
                    <option value="Tabanan">Tabanan</option>
                    <option value="Singaraja">Singaraja</option>
                    <option value="Uluwatu">Uluwatu</option>
                </select>
            </div>

            {{-- Category Filter --}}
            <div>
                <select id="categorySelect" class="w-full h-11 px-3.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-hidden focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition cursor-pointer appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[right_12px_center]" onchange="applyFilter()">
                    <option value="">Kategori</option>
                    <option value="Software Development">Software Development</option>
                    <option value="Creative Agency">Creative Agency</option>
                    <option value="Startup">Startup</option>
                </select>
            </div>

            {{-- Filter Submit Button --}}
            <div>
                <button type="button" onclick="applyFilter()" class="w-full h-11 px-5 bg-blue-700 hover:bg-blue-800 active:scale-[0.99] text-white text-sm font-semibold rounded-lg flex items-center justify-center gap-2 transition cursor-pointer shadow-xs">
                    <svg class="w-4 h-4 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <line x1="4" y1="6" x2="20" y2="6"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                        <line x1="10" y1="18" x2="14" y2="18"/>
                    </svg>
                    <span>Terapkan Filter</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Company Cards Grid --}}
    <div id="companyGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($companies as $company)
            <div class="company-item bg-white border border-slate-200 rounded-xl p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 hover:-translate-y-0.5 transition-all duration-200"
                 data-name="{{ strtolower($company['name']) }}"
                 data-category="{{ $company['category'] }}"
                 data-location="{{ $company['location'] }}"
                 data-id="{{ $company['id'] }}">

                <div>
                    <div class="flex items-start gap-3.5 mb-4">
                        {{-- Logo Box --}}
                        @if($company['badge_class'] == 'software')
                            <div class="w-12 h-12 rounded-lg border border-blue-100 bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        @elseif($company['badge_class'] == 'creative')
                            <div class="w-12 h-12 rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-lg border border-rose-100 bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        @endif
                            @if($company['icon_type'] == 'code' || $company['icon_type'] == 'cpu' || $company['icon_type'] == 'cloud' || $company['icon_type'] == 'terminal')
                                {{-- Code / Software Icon --}}
                                <svg class="w-6 h-6 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="16 18 22 12 16 6"></polyline>
                                    <polyline points="8 6 2 12 8 18"></polyline>
                                </svg>
                            @elseif($company['icon_type'] == 'palette' || $company['icon_type'] == 'magic' || $company['icon_type'] == 'layers' || $company['icon_type'] == 'camera')
                                {{-- Creative / Palette Icon --}}
                                <svg class="w-6 h-6 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            @elseif($company['icon_type'] == 'building')
                                {{-- Building / Office Icon --}}
                                <svg class="w-6 h-6 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
                                    <line x1="9" y1="6" x2="9" y2="6.01"></line>
                                    <line x1="15" y1="6" x2="15" y2="6.01"></line>
                                </svg>
                            @elseif($company['icon_type'] == 'credit-card')
                                {{-- Credit Card / Fintech Icon --}}
                                <svg class="w-6 h-6 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                            @elseif($company['icon_type'] == 'sparkles')
                                {{-- Sparkles AI Icon --}}
                                <svg class="w-6 h-6 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"></path>
                                </svg>
                            @else
                                {{-- Rocket / Startup Icon --}}
                                <svg class="w-6 h-6 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.71.79-1.81.79-1.81l-1.98-1.98s-1.1.08-1.81.79z"></path>
                                    <path d="M15 9l-6 6"></path>
                                    <path d="M16.5 4.5c1.5-1.26 5-2 5-2s-.5 3.74-2 5c-.71.71-1.81.79-1.81.79l-1.98-1.98s.08-1.1.79-1.81z"></path>
                                </svg>
                            @endif
                        </div>

                        {{-- Company Title & Badge --}}
                        <div class="min-w-0 flex-1">
                            <h3 class="font-bold text-base text-slate-900 leading-snug truncate mb-1">
                                {{ $company['name'] }}
                            </h3>
                            @if($company['badge_class'] == 'software')
                                <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700">
                                    {{ $company['category'] }}
                                </span>
                            @elseif($company['badge_class'] == 'creative')
                                <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-700">
                                    {{ $company['category'] }}
                                </span>
                            @else
                                <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-600">
                                    {{ $company['category'] }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Description --}}
                    <p class="text-slate-600 text-sm leading-relaxed mb-6 grow">
                        {{ $company['description'] }}
                    </p>
                </div>

                {{-- Action Button ("Lihat Profil") --}}
                <button type="button" data-company='@json($company)' onclick="showCompanyModal(this)" class="w-full py-2.5 text-center text-sm font-semibold text-blue-600 hover:text-white bg-white hover:bg-blue-600 border border-blue-600 rounded-lg transition-colors duration-150 cursor-pointer">
                    Lihat Profil
                </button>
            </div>
        @endforeach

        {{-- Empty state --}}
        <div id="emptyState" class="hidden text-center py-12 px-6 bg-white border border-dashed border-slate-300 rounded-xl col-span-full">
            <svg class="w-12 h-12 text-slate-400 mx-auto mb-3 stroke-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <h4 class="text-base font-bold text-slate-800 mb-1">Tidak Ada Perusahaan Ditemukan</h4>
            <p class="text-sm text-slate-500">Coba sesuaikan kata kunci pencarian atau filter lokasi dan kategori Anda.</p>
        </div>
    </div>

    {{-- Pagination Navigation --}}
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

{{-- Detail Modal --}}
<div id="companyModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-200" onclick="if(event.target === this) closeCompanyModal()">
    <div class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl p-6 sm:p-7 relative translate-y-3 transition-transform duration-200">
        <button onclick="closeCompanyModal()" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 flex items-center justify-center transition cursor-pointer">
            <svg class="w-4.5 h-4.5 stroke-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="flex items-center gap-4 mb-5">
            <div id="modalLogoBox" class="w-14 h-14 rounded-xl border border-slate-200 flex items-center justify-center shrink-0">
                {{-- Dynamic SVG Icon --}}
            </div>
            <div>
                <h2 id="modalCompanyName" class="text-xl font-extrabold text-slate-900 mb-1"></h2>
                <div class="flex items-center gap-2">
                    <span id="modalBadge" class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full"></span>
                    <span class="text-xs text-slate-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 stroke-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span id="modalLocText"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Tentang Perusahaan</h4>
            <p id="modalDescription" class="text-sm leading-relaxed text-slate-700"></p>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-5 bg-slate-50 p-3.5 rounded-xl border border-slate-100">
            <div>
                <span class="text-xs text-slate-500 block mb-0.5">Jumlah Karyawan</span>
                <strong id="modalEmployees" class="text-sm text-slate-900"></strong>
            </div>
            <div>
                <span class="text-xs text-slate-500 block mb-0.5">Tahun Berdiri</span>
                <strong id="modalFounded" class="text-sm text-slate-900"></strong>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2.5">Teknologi & Stack</h4>
            <div id="modalTechStack" class="flex flex-wrap gap-1.5">
                {{-- Dynamic pills --}}
            </div>
        </div>

        <div class="flex gap-3 pt-5 border-t border-slate-200">
            <a id="modalWebsiteLink" href="#" target="_blank" class="flex-1 py-2.5 px-4 text-center text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-xs">
                Kunjungi Website
            </a>
            <a id="modalEmailLink" href="#" class="flex-1 py-2.5 px-4 text-center text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg transition">
                Hubungi Email
            </a>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;
    const itemsPerPage = 6;
    let filteredItems = [];

    document.addEventListener("DOMContentLoaded", function() {
        applyFilter();
    });

    function applyFilter() {
        const query = document.getElementById("searchInput").value.toLowerCase().trim();
        const selectedLoc = document.getElementById("locationSelect").value;
        const selectedCat = document.getElementById("categorySelect").value;

        const allCards = Array.from(document.querySelectorAll(".company-item"));

        filteredItems = allCards.filter(card => {
            const name = card.getAttribute("data-name") || "";
            const cat = card.getAttribute("data-category") || "";
            const loc = card.getAttribute("data-location") || "";

            const matchQuery = !query || name.includes(query);
            const matchLoc = !selectedLoc || loc === selectedLoc;
            const matchCat = !selectedCat || cat === selectedCat;

            return matchQuery && matchLoc && matchCat;
        });

        currentPage = 1;
        renderPage();
    }

    function renderPage() {
        const allCards = document.querySelectorAll(".company-item");
        const emptyState = document.getElementById("emptyState");
        const paginationBar = document.getElementById("paginationBar");

        allCards.forEach(card => card.classList.add("hidden"));

        if (filteredItems.length === 0) {
            emptyState.classList.remove("hidden");
            paginationBar.classList.add("hidden");
            return;
        } else {
            emptyState.classList.add("hidden");
            paginationBar.classList.remove("hidden");
            paginationBar.classList.add("flex");
        }

        const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        const pageItems = filteredItems.slice(startIndex, endIndex);
        pageItems.forEach(card => card.classList.remove("hidden"));

        // Update pagination buttons
        const pageBtns = document.querySelectorAll(".page-num");
        pageBtns.forEach((btn, index) => {
            const pageNum = index + 1;
            if (pageNum <= totalPages) {
                btn.classList.remove("hidden");
                if (pageNum === currentPage) {
                    btn.className = "page-num w-9 h-9 rounded-lg border border-blue-700 bg-blue-700 text-white text-sm font-semibold flex items-center justify-center transition cursor-pointer";
                } else {
                    btn.className = "page-num w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 text-sm font-semibold flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition cursor-pointer";
                }
            } else {
                btn.classList.add("hidden");
            }
        });

        // Prev & Next Buttons state
        const prevBtn = document.getElementById("prevPageBtn");
        const nextBtn = document.getElementById("nextPageBtn");

        if (currentPage === 1) {
            prevBtn.classList.add("opacity-40", "cursor-not-allowed");
        } else {
            prevBtn.classList.remove("opacity-40", "cursor-not-allowed");
        }

        if (currentPage === totalPages || totalPages === 0) {
            nextBtn.classList.add("opacity-40", "cursor-not-allowed");
        } else {
            nextBtn.classList.remove("opacity-40", "cursor-not-allowed");
        }
    }

    function changePage(page) {
        const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderPage();

        window.scrollTo({
            top: document.getElementById('filterForm').offsetTop - 80,
            behavior: 'smooth'
        });
    }

    function showCompanyModal(target) {
        let company = target;
        if (target instanceof HTMLElement) {
            company = JSON.parse(target.getAttribute('data-company'));
        }

        document.getElementById("modalCompanyName").innerText = company.name;
        document.getElementById("modalLocText").innerText = company.location + ", Bali";

        const modalBadge = document.getElementById("modalBadge");
        modalBadge.innerText = company.category;
        
        if (company.badge_class === 'software') {
            modalBadge.className = "inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700";
        } else if (company.badge_class === 'creative') {
            modalBadge.className = "inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-700";
        } else {
            modalBadge.className = "inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-600";
        }

        document.getElementById("modalDescription").innerText = company.full_description || company.description;
        document.getElementById("modalEmployees").innerText = company.employees || "20-50 Karyawan";
        document.getElementById("modalFounded").innerText = company.founded || "2020";

        // Stack
        const stackContainer = document.getElementById("modalTechStack");
        stackContainer.innerHTML = "";
        if (company.tech_stack) {
            company.tech_stack.forEach(tech => {
                const pill = document.createElement("span");
                pill.className = "text-xs font-semibold bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md border border-slate-200/60";
                pill.innerText = tech;
                stackContainer.appendChild(pill);
            });
        }

        // Links
        document.getElementById("modalWebsiteLink").href = company.website || "#";
        document.getElementById("modalEmailLink").href = "mailto:" + (company.email || "info@example.com");

        // Logo SVG Box
        const logoBox = document.getElementById("modalLogoBox");
        if (company.badge_class === 'software') {
            logoBox.className = "w-14 h-14 rounded-xl border border-blue-100 bg-blue-50 text-blue-600 flex items-center justify-center shrink-0";
        } else if (company.badge_class === 'creative') {
            logoBox.className = "w-14 h-14 rounded-xl border border-emerald-100 bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0";
        } else {
            logoBox.className = "w-14 h-14 rounded-xl border border-rose-100 bg-rose-50 text-rose-600 flex items-center justify-center shrink-0";
        }
        logoBox.innerHTML = getIconSvg(company.icon_type);

        const modal = document.getElementById("companyModal");
        modal.classList.remove("opacity-0", "pointer-events-none");
    }

    function closeCompanyModal() {
        const modal = document.getElementById("companyModal");
        modal.classList.add("opacity-0", "pointer-events-none");
    }

    function getIconSvg(type) {
        if (type === 'code' || type === 'cpu' || type === 'cloud' || type === 'terminal') {
            return `<svg class="w-7 h-7 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>`;
        } else if (type === 'palette' || type === 'magic' || type === 'layers' || type === 'camera') {
            return `<svg class="w-7 h-7 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>`;
        } else if (type === 'building') {
            return `<svg class="w-7 h-7 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="9" y1="6" x2="9" y2="6.01"></line><line x1="15" y1="6" x2="15" y2="6.01"></line></svg>`;
        } else if (type === 'credit-card') {
            return `<svg class="w-7 h-7 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>`;
        } else if (type === 'sparkles') {
            return `<svg class="w-7 h-7 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"></path></svg>`;
        } else {
            return `<svg class="w-7 h-7 stroke-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.71.79-1.81.79-1.81l-1.98-1.98s-1.1.08-1.81.79z"></path><path d="M15 9l-6 6"></path><path d="M16.5 4.5c1.5-1.26 5-2 5-2s-.5 3.74-2 5c-.71.71-1.81.79-1.81.79l-1.98-1.98s.08-1.1.79-1.81z"></path></svg>`;
        }
    }
</script>
@endsection
