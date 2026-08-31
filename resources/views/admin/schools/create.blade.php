@extends('admin.layouts.app')

@section('title', 'Add New School — IndoTech')

@section('content')
<form method="POST" action="{{ route('admin.schools.store') }}" class="space-y-6 max-w-7xl mx-auto">
    @csrf

    {{-- Top Back Link & Breadcrumb --}}
    <div>
        <a href="{{ route('admin.schools.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 mb-2 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
            <a href="{{ route('admin.schools.index') }}" class="hover:text-blue-600 transition">Schools</a>
            <span class="text-slate-400">›</span>
            <span class="text-slate-900 font-semibold">Add New School</span>
        </div>

        <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">Add New School</h1>
    </div>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN (8 cols) --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Card 1: Basic Information --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                {{-- Card Header with Blue Icon --}}
                <div class="flex items-center gap-2.5 mb-6 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <rect x="3" y="4" width="18" height="16" rx="3"/>
                        <path stroke-linecap="round" d="M7 8h10M7 12h4m-4 4h7"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Basic Information</h2>
                </div>

                {{-- Fields Grid (2 cols) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- School Name --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">School Name</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               placeholder="Contoh: SMK Telkom Jakarta"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NPSN --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">NPSN</label>
                        <input type="text" 
                               name="npsn" 
                               value="{{ old('npsn') }}" 
                               required
                               placeholder="Contoh: 20109988"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('npsn')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Institution Type --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Institution Type</label>
                        <div class="relative">
                            <select name="institution_type" 
                                    class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition appearance-none cursor-pointer font-medium pr-10">
                                <option value="SMK IT" {{ old('institution_type') == 'SMK IT' ? 'selected' : '' }}>SMK IT</option>
                                <option value="SMK Non-IT" {{ old('institution_type') == 'SMK Non-IT' ? 'selected' : '' }}>SMK Non-IT</option>
                                <option value="SMA" {{ old('institution_type') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="Universitas" {{ old('institution_type') == 'Universitas' ? 'selected' : '' }}>Universitas</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Location</label>
                        <input type="text" 
                               name="location" 
                               value="{{ old('location') }}" 
                               required
                               placeholder="Contoh: Jakarta Barat, DKI Jakarta"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('location')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Card 2: School Description --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                {{-- Card Header with Blue Icon --}}
                <div class="flex items-center gap-2.5 mb-5 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">School Description</h2>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Profile & Curriculum Details</label>
                    <textarea name="description" 
                              id="schoolDescription"
                              rows="5"
                              maxlength="1000"
                              oninput="document.getElementById('charCount').textContent = this.value.length + ' / 1000 characters'"
                              placeholder="Tuliskan deskripsi profil dan keunggulan kurikulum sekolah..."
                              class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl p-4 text-[14px] text-slate-800 outline-none transition font-medium leading-relaxed resize-none">{{ old('description') }}</textarea>
                    
                    <div class="flex justify-end mt-2">
                        <span id="charCount" class="text-[12.5px] font-medium text-slate-500">
                            0 / 1000 characters
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card 3: Campus Gallery --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                {{-- Card Header with Action --}}
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2.5 text-slate-900">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21"/>
                        </svg>
                        <h2 class="text-[17px] font-bold text-slate-900">Campus Gallery</h2>
                    </div>

                    <button type="button" 
                            class="inline-flex items-center gap-1.5 text-[13.5px] font-bold text-[#0b57d0] hover:text-blue-700 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/>
                        </svg>
                        Add Photo
                    </button>
                </div>

                {{-- 4 Image Placeholders Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="aspect-square rounded-2xl bg-[#f0f4f9] hover:bg-[#e4ebf5] border border-slate-200/60 flex items-center justify-center text-slate-400 cursor-pointer transition group">
                            <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="group-hover:scale-110 transition">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21"/>
                            </svg>
                        </div>
                    @endfor
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN (4 cols) --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Card 1: Logo & Branding --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs flex flex-col items-center text-center">
                <h2 class="text-[17px] font-bold text-slate-900 self-start mb-5">Logo & Branding</h2>

                {{-- Logo Preview Box --}}
                <div class="w-full aspect-[4/3] rounded-2xl bg-[#f0f4f9] border border-slate-200/70 flex items-center justify-center p-6 mb-4 relative overflow-hidden">
                    <div class="bg-white p-4 rounded-xl shadow-xs border border-slate-200/80 flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-[#0b57d0] font-extrabold text-sm mb-1">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                                <path d="M2 12h20"/>
                            </svg>
                        </div>
                        <div class="text-[11px] font-bold text-slate-800">School Logo</div>
                        <div class="text-[9px] text-slate-400">IndoTech System</div>
                    </div>
                </div>

                <div class="font-bold text-slate-900 text-[14px]">
                    Belum ada file terpilih
                </div>
                <p class="text-[12.5px] text-slate-500 mt-0.5 mb-5">
                    JPG, PNG or SVG. Max size of 2MB.
                </p>

                {{-- Upload New Logo Button --}}
                <label class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#f0f4f9] hover:bg-[#e4ebf5] text-slate-800 font-semibold text-[13.5px] cursor-pointer transition">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
                    </svg>
                    Upload Logo
                    <input type="file" name="logo" class="hidden" accept="image/*">
                </label>
            </div>

            {{-- Card 2: Map Location --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <h2 class="text-[17px] font-bold text-slate-900 mb-4">Map Location</h2>

                <div class="mb-4">
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" 
                              rows="3"
                              placeholder="Masukkan alamat lengkap sekolah..."
                              class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl p-3 text-[13.5px] text-slate-800 outline-none transition font-medium">{{ old('address') }}</textarea>
                </div>
            </div>

        </div>

    </div>

    {{-- Bottom Action Bar --}}
    <div class="pt-6 border-t border-slate-200/80 flex items-center justify-end gap-4">
        <a href="{{ route('admin.schools.index') }}" 
           class="px-6 py-2.5 text-[14px] font-semibold text-slate-600 hover:text-slate-900 transition">
            Cancel
        </a>

        <button type="submit" 
                class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#0b57d0] hover:bg-blue-700 text-white font-semibold text-[14px] shadow-sm transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Simpan Sekolah
        </button>
    </div>

</form>
@endsection
