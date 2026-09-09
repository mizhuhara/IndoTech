@extends('admin.layouts.app')

@section('title', 'Tambah Lowongan Internship Baru — IndoTech Admin')

@section('content')
<form method="POST" action="{{ route('admin.internships.store') }}" enctype="multipart/form-data" class="space-y-6 max-w-7xl mx-auto">
    @csrf

    {{-- Top Back Link & Breadcrumbs --}}
    <div>
        <a href="{{ route('admin.internships.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 mb-2 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Internship
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 text-rose-800 text-sm shadow-2xs space-y-1">
        <div class="font-bold flex items-center gap-2">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-rose-600 shrink-0">
                <circle cx="12" cy="12" r="9"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>Terdapat beberapa kesalahan pengisian form:</span>
        </div>
        <ul class="list-disc list-inside pl-5 text-[13px] text-rose-700 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Two Column Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- LEFT COLUMN (8 cols) --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Kartu 1: Informasi Utama Magang --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-5">
                <div class="flex items-center gap-2.5 text-slate-900 border-b border-slate-100 pb-4">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0b57d0] flex items-center justify-center shrink-0">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[16px] font-bold text-slate-900">Informasi Utama Posisi</h2>
                        <p class="text-[12px] text-slate-400 font-medium">Tentukan judul posisi, perusahaan, dan penanggung jawab magang.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Judul Magang --}}
                    <div class="sm:col-span-2">
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                            Judul Posisi Magang <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               value="{{ old('title') }}" 
                               required 
                               placeholder="Contoh: Frontend Developer Intern"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('title')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Perusahaan --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                            Nama Perusahaan / Organisasi <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="company" 
                               value="{{ old('company') }}" 
                               required 
                               placeholder="Contoh: PT IndoTech Solusi Nusantara"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('company')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- User Penanggung Jawab --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                            User Penanggung Jawab <span class="text-rose-500">*</span>
                        </label>
                        <select name="user_id" required class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium cursor-pointer">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', auth()->id()) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lokasi Penempatan --}}
                    <div class="sm:col-span-2">
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                            Lokasi Penempatan
                        </label>
                        <div class="relative">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="absolute left-3.5 top-3.5 text-slate-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                            </svg>
                            <input type="text" 
                                   name="location" 
                                   value="{{ old('location') }}" 
                                   placeholder="Contoh: Jakarta Selatan / Hybrid / Remote"
                                   class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl pl-10 pr-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        </div>
                        @error('location')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Kartu 2: Deskripsi Lengkap Magang --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-2.5 text-slate-900 border-b border-slate-100 pb-4">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0b57d0] flex items-center justify-center shrink-0">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[16px] font-bold text-slate-900">Deskripsi & Rincian Magang</h2>
                        <p class="text-[12px] text-slate-400 font-medium">Uraikan tugas, kualifikasi, atau keuntungan program magang ini.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Deskripsi Program Magang
                    </label>
                    <textarea name="description" 
                              rows="6" 
                              id="desc-field"
                              placeholder="Jelaskan mengenai program magang, tanggung jawab peserta, teknologi yang digunakan, serta kualifikasi yang diharapkan..."
                              class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl p-4 text-[14px] text-slate-800 leading-relaxed outline-none transition font-medium">{{ old('description') }}</textarea>
                    <div class="flex items-center justify-between text-[11.5px] text-slate-400 mt-1 font-medium">
                        <span>Format teks bebas atau daftar poin penjelasan.</span>
                        <span><span id="char-count">0</span> karakter</span>
                    </div>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Kartu 3: Periode Pelaksanaan Magang --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-2.5 text-slate-900 border-b border-slate-100 pb-4">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0b57d0] flex items-center justify-center shrink-0">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[16px] font-bold text-slate-900">Periode Pelaksanaan Magang</h2>
                        <p class="text-[12px] text-slate-400 font-medium">Tentukan jadwal tanggal mulai dan perkiraan selesai magang.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                            Tanggal Mulai
                        </label>
                        <input type="date" 
                               name="start_date" 
                               value="{{ old('start_date') }}"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('start_date')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                            Tanggal Selesai
                        </label>
                        <input type="date" 
                               name="end_date" 
                               value="{{ old('end_date') }}"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('end_date')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN (4 cols) --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Kartu Status Publikasi --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-2.5 text-slate-900 border-b border-slate-100 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0b57d0] flex items-center justify-center shrink-0">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-bold text-slate-900">Status Magang</h3>
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">
                        Status Keaktifan <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" required class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium cursor-pointer">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif (Tampil di Publik)</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Non-aktif / Draft</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    </select>
                </div>
            </div>

            {{-- Kartu Foto / Logo Profil --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-2.5 text-slate-900 border-b border-slate-100 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0b57d0] flex items-center justify-center shrink-0">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-bold text-slate-900">Logo Perusahaan</h3>
                    </div>
                </div>

                {{-- Preview Box --}}
                <div id="preview-box" class="w-full h-36 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 overflow-hidden flex flex-col items-center justify-center text-slate-400 p-2">
                    <img id="preview-img" src="" alt="Preview" class="hidden w-full h-full object-contain rounded-lg">
                    <div id="preview-placeholder" class="flex flex-col items-center justify-center text-center space-y-1.5">
                        <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="text-slate-300">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="m21 15-5-5L5 21"/>
                        </svg>
                        <span class="text-xs font-semibold text-slate-500">Belum ada foto yang dipilih</span>
                        <span class="text-[11px] text-slate-400">JPG, PNG, GIF, WebP (Maks. 2MB)</span>
                    </div>
                </div>

                {{-- Upload Button --}}
                <label class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#f0f4f9] hover:bg-[#e4ebf5] text-slate-800 font-semibold text-[13.5px] cursor-pointer transition">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
                    </svg>
                    <span>Pilih Foto Logo</span>
                    <input type="file" id="profile-picture-input" name="profile_picture" class="hidden" accept="image/*" onchange="previewImage(this)">
                </label>
                @error('profile_picture')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kartu Aksi Simpan --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-3">
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-[#0b57d0] hover:bg-blue-700 active:bg-blue-800 text-white font-bold text-[14px] shadow-sm transition cursor-pointer">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>Simpan & Publikasikan</span>
                </button>

                <a href="{{ route('admin.internships.index') }}" 
                   class="w-full py-3 px-4 rounded-xl border border-slate-200 text-slate-700 font-semibold text-[13.5px] hover:bg-slate-50 transition text-center block">
                    Batal
                </a>
            </div>

        </div>

    </div>
</form>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview-img');
        const placeholder = document.getElementById('preview-placeholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const desc = document.getElementById('desc-field');
        const count = document.getElementById('char-count');
        if (desc && count) {
            count.textContent = desc.value.length;
            desc.addEventListener('input', function() {
                count.textContent = this.value.length;
            });
        }
    });
</script>
@endpush
@endsection
