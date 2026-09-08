@extends('admin.layouts.app')

@section('title', 'Tambah Perusahaan Baru — IndoTech Admin')

@section('content')
<form method="POST" action="{{ route('admin.company.store') }}" enctype="multipart/form-data" class="space-y-6 max-w-7xl mx-auto">
    @csrf

    {{-- Top Back Link & Breadcrumb --}}
    <div>
        <a href="{{ route('admin.company.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 mb-2 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
            <a href="{{ route('admin.company.index') }}" class="hover:text-blue-600 transition">Companies</a>
            <span class="text-slate-400">›</span>
            <span class="text-slate-900 font-semibold">Add New Company</span>
        </div>

        <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">Add New Company</h1>
    </div>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN (8 cols) --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Card 1: Basic Information --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-6 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Informasi Dasar Perusahaan</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Company Name --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Nama Perusahaan <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               placeholder="Contoh: PT. Telekomunikasi Indonesia Tbk"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Company Code --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Kode / NPSN Perusahaan</label>
                        <input type="text" 
                               name="npsn" 
                               value="{{ old('npsn') }}" 
                               placeholder="Contoh: CMP001"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                    </div>

                    {{-- Company Type --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Tipe Perusahaan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="type" 
                                    required
                                    class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition appearance-none cursor-pointer font-medium pr-10">
                                <option value="Swasta" {{ old('type') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                <option value="BUMN" {{ old('type') == 'BUMN' ? 'selected' : '' }}>BUMN</option>
                                <option value="Multinasional" {{ old('type') == 'Multinasional' ? 'selected' : '' }}>Multinasional</option>
                                <option value="Startup" {{ old('type') == 'Startup' ? 'selected' : '' }}>Startup</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Industry --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Bidang Industri <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="industry" 
                               value="{{ old('industry') }}" 
                               required
                               placeholder="Contoh: Teknologi & Informasi"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('industry')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Kota / Kabupaten</label>
                        <input type="text" 
                               name="city" 
                               value="{{ old('city') }}" 
                               placeholder="Contoh: Bandung"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                    </div>

                    {{-- Province --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Provinsi</label>
                        <input type="text" 
                               name="province" 
                               value="{{ old('province') }}" 
                               placeholder="Contoh: Jawa Barat"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                    </div>

                    {{-- Location --}}
                    <div class="sm:col-span-2">
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Ringkasan Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="location" 
                               value="{{ old('location') }}" 
                               required
                               placeholder="Contoh: Bandung, Jawa Barat"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('location')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Card 2: Company Description --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-5 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Deskripsi & Profil Perusahaan</h2>
                </div>

                <div>
                    <textarea name="description" 
                              rows="5"
                              placeholder="Tuliskan deskripsi profil dan bisnis perusahaan..."
                              class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl p-4 text-[14px] text-slate-800 outline-none transition font-medium leading-relaxed resize-none">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Card 3: Company Gallery Upload --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5 text-slate-900">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21"/>
                        </svg>
                        <div>
                            <h2 class="text-[17px] font-bold text-slate-900">Galeri Foto Perusahaan</h2>
                            <p class="text-xs text-slate-500">Unggah beberapa foto suasana kantor, fasilitas, atau kegiatan perusahaan.</p>
                        </div>
                    </div>

                    <label class="cursor-pointer inline-flex items-center gap-1.5 text-[13.5px] font-bold text-[#0b57d0] hover:text-blue-700 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        <span>Pilih Foto</span>
                        <input type="file" name="gallery[]" id="galleryInput" multiple accept="image/*" class="hidden" onchange="previewGalleryImages(event)">
                    </label>
                </div>

                {{-- Gallery Preview Container --}}
                <div id="galleryPreviewContainer" class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
                    <div class="aspect-square rounded-2xl bg-[#f0f4f9] border border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400 p-4 text-center cursor-pointer hover:bg-blue-50/50 transition" onclick="document.getElementById('galleryInput').click()">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                        <span class="text-[11px] font-semibold mt-1">Tambah Foto</span>
                    </div>
                </div>
            </div>

            {{-- Card 4: Address & Google Maps Integration --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <div class="flex items-center gap-2.5 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                    <div>
                        <h2 class="text-[17px] font-bold text-slate-900">Alamat Lengkap & Integrasi Google Maps</h2>
                        <p class="text-xs text-slate-500">Masukkan tautan Google Maps untuk menampilkan visualisasi peta interaktif.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Alamat Lengkap Kantor</label>
                    <textarea name="address" 
                              rows="3"
                              placeholder="Masukkan alamat lengkap gedung/kantor perusahaan..."
                              class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl p-3.5 text-[13.5px] text-slate-800 outline-none transition font-medium">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Link / Embed Google Maps</label>
                    <input type="text" 
                           name="map_link" 
                           id="mapLinkInput"
                           value="{{ old('map_link') }}" 
                           placeholder="Contoh: https://maps.google.com/maps?q=Bandung&output=embed"
                           oninput="updateMapPreview(this.value)"
                           class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[13.5px] text-slate-800 outline-none transition font-medium">
                </div>

                {{-- Interactive Map Preview Container --}}
                <div class="mt-3">
                    <div class="text-[12px] font-bold text-slate-500 uppercase mb-2">Pratinjau Peta (Maps Preview)</div>
                    <div id="mapPreviewBox" class="w-full h-64 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center text-slate-400">
                        <div class="text-center p-4">
                            <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            <span class="text-xs font-semibold text-slate-500">Tempelkan link Google Maps di atas untuk melihat gambaran peta lokasi</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN (4 cols) --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Card 1: Logo & Branding --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs flex flex-col items-center text-center">
                <h2 class="text-[17px] font-bold text-slate-900 self-start mb-5">Logo Perusahaan</h2>

                <div class="w-full aspect-[4/3] rounded-2xl bg-[#f0f4f9] border border-slate-200/70 flex items-center justify-center p-4 mb-4 relative overflow-hidden">
                    <div id="logoPreviewWrapper" class="w-20 h-20 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0b57d0] font-extrabold text-xl overflow-hidden shadow-sm">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/>
                        </svg>
                    </div>
                </div>

                <div id="logoStatusText" class="font-bold text-slate-900 text-[14px]">
                    Pilih File Logo
                </div>
                <p class="text-[12.5px] text-slate-500 mt-0.5 mb-5">
                    JPG, PNG, atau WEBP. Maksimal 5MB.
                </p>

                <label class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#f0f4f9] hover:bg-[#e4ebf5] text-slate-800 font-semibold text-[13.5px] cursor-pointer transition">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
                    </svg>
                    Upload Logo
                    <input type="file" name="logo" class="hidden" accept="image/*" onchange="previewLogoImage(event)">
                </label>
            </div>

            {{-- Card 2: Status & Operational Info --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <h2 class="text-[17px] font-bold text-slate-900 mb-2">Status Kemitraan</h2>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Status Kemitraan <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-[#f0f4f9]/80 border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none font-medium">
                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active (Aktif)</option>
                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive (Non-aktif)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Jumlah Karyawan</label>
                    <input type="number" 
                           name="total_employees" 
                           value="{{ old('total_employees') }}" 
                           placeholder="Contoh: 500"
                           class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Tahun Berdiri</label>
                    <input type="number" 
                           name="founded" 
                           value="{{ old('founded') }}" 
                           placeholder="Contoh: 2010"
                           class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                </div>
            </div>

            {{-- Card 3: Contact Info --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <h2 class="text-[17px] font-bold text-slate-900 mb-2">Kontak Perusahaan</h2>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Email Perusahaan</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="corporate@perusahaan.com"
                           class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Website Resmi</label>
                    <input type="url" 
                           name="website" 
                           value="{{ old('website') }}" 
                           placeholder="https://www.perusahaan.com"
                           class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Telepon / No. HP</label>
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           placeholder="021-1234567"
                           class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                </div>
            </div>

        </div>

    </div>

    {{-- Bottom Action Bar --}}
    <div class="pt-6 border-t border-slate-200/80 flex items-center justify-end gap-4">
        <a href="{{ route('admin.company.index') }}" 
           class="px-6 py-2.5 text-[14px] font-semibold text-slate-600 hover:text-slate-900 transition">
            Batal
        </a>

        <button type="submit" 
                class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold text-[14px] shadow-md shadow-blue-500/20 transition transform active:scale-95">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Simpan Perusahaan
        </button>
    </div>

</form>

@push('scripts')
<script>
    function previewLogoImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreviewWrapper').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                document.getElementById('logoStatusText').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    }

    function previewGalleryImages(event) {
        const files = event.target.files;
        const container = document.getElementById('galleryPreviewContainer');
        if (files.length > 0) {
            container.innerHTML = '';
            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.className = 'aspect-square rounded-2xl overflow-hidden border border-slate-200 shadow-xs relative group';
                    imgDiv.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    container.appendChild(imgDiv);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function updateMapPreview(url) {
        const previewBox = document.getElementById('mapPreviewBox');
        if (!url) {
            previewBox.innerHTML = `
                <div class="text-center p-4">
                    <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    <span class="text-xs font-semibold text-slate-500">Tempelkan link Google Maps di atas untuk melihat gambaran peta lokasi</span>
                </div>`;
            return;
        }

        let embedUrl = url;
        if (url.includes('<iframe')) {
            const match = url.match(/src="([^"]+)"/);
            if (match && match[1]) embedUrl = match[1];
        } else if ((url.includes('maps.google.com') || url.includes('google.com/maps')) && !url.includes('output=embed') && !url.includes('/embed')) {
            embedUrl = url.includes('?') ? url + '&output=embed' : url + '?output=embed';
        }

        previewBox.innerHTML = `<iframe src="${embedUrl}" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>`;
    }

    // Initialize map preview if old value exists
    document.addEventListener('DOMContentLoaded', function() {
        const val = document.getElementById('mapLinkInput').value;
        if (val) updateMapPreview(val);
    });
</script>
@endpush
@endsection
