@extends('admin.layouts.app')

@section('title', 'Buat Lowongan Baru — Admin IndoTech')

@section('content')
<form action="{{ route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data" data-async data-async-reset class="space-y-6">
    @csrf

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-[13.5px]">
            <p class="font-semibold mb-1">Mohon perbaiki kesalahan berikut:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Kembali
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center justify-center bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold px-5 py-2.5 rounded-lg text-[13.5px] transition">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg text-[13.5px] shadow-2xs transition">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.8"><path d="M12 5v14M5 12h14"/></svg>
                <span>Publikasikan Lowongan</span>
            </button>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        {{-- Left Column (2/3 width) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Information Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-5">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-brand-600 flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/></svg>
                    </div>
                    <span>Informasi Dasar Lowongan</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    {{-- Job Title --}}
                    <div>
                        <label class="form-label-sm">Judul Posisi / Pekerjaan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="mis. Senior Frontend Engineer" required
                               class="field">
                    </div>

                    {{-- Department --}}
                    <div>
                        <label class="form-label-sm">Departemen <span class="text-red-500">*</span></label>
                        <select name="department" class="field">
                            @foreach (['Engineering', 'Product', 'Design', 'Data', 'Marketing', 'Operations', 'Finance', 'Human Resources'] as $dept)
                                <option value="{{ $dept }}" {{ old('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Employment Type --}}
                    <div>
                        <label class="form-label-sm">Tipe Pekerjaan <span class="text-red-500">*</span></label>
                        <select name="type" class="field">
                            @foreach (['Full-time', 'Part-time', 'Contract', 'Internship (Magang / PKL)', 'Freelance'] as $tp)
                                <option value="{{ $tp }}" {{ old('type') === $tp ? 'selected' : '' }}>{{ $tp }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Salary Range --}}
                    <div>
                        <label class="form-label-sm">Rentang Gaji / Uang Saku (IDR)</label>
                        <input type="text" name="salary_range" value="{{ old('salary_range') }}" placeholder="mis. 15.000.000 - 25.000.000 atau Rp 2.000.000 / bulan"
                               class="field">
                    </div>

                    {{-- Career Category --}}
                    <div>
                        <label class="form-label-sm">Kategori Karir</label>
                        <select name="category" class="field">
                            <option value="jobs" {{ old('category') === 'jobs' ? 'selected' : '' }}>Lowongan Kerja (Reguler)</option>
                            <option value="internship" {{ old('category') === 'internship' ? 'selected' : '' }}>Lowongan Magang / PKL (Internship)</option>
                            <option value="freelance" {{ old('category') === 'freelance' ? 'selected' : '' }}>Freelance / Kontrak</option>
                            <option value="remote" {{ old('category') === 'remote' ? 'selected' : '' }}>Remote Work</option>
                            <option value="graduate" {{ old('category') === 'graduate' ? 'selected' : '' }}>Fresh Graduate</option>
                        </select>
                    </div>

                    {{-- Experience Level --}}
                    <div>
                        <label class="form-label-sm">Tingkat Pengalaman</label>
                        <select name="experience" class="field">
                            <option value="Entry" {{ old('experience') === 'Entry' ? 'selected' : '' }}>Entry Level (Pemula)</option>
                            <option value="Mid" {{ old('experience', 'Mid') === 'Mid' ? 'selected' : '' }}>Mid Level (Menengah)</option>
                            <option value="Senior" {{ old('experience') === 'Senior' ? 'selected' : '' }}>Senior Level (Berpengalaman)</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Job Description Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-brand-600 flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                    </div>
                    <span>Deskripsi Pekerjaan <span class="text-red-500">*</span></span>
                </div>

                <div>
                    <label class="form-label-sm">Deskripsi Lengkap Posisi</label>
                    <textarea name="description" rows="6" required id="desc-field" placeholder="Tuliskan deskripsi lengkap pekerjaan..."
                              class="field p-4 leading-relaxed">{{ old('description') }}</textarea>
                    <div class="text-right text-[11.5px] text-slate-400 mt-1 font-medium">
                        <span id="char-count">0</span> / 2000 karakter
                    </div>
                </div>
            </div>

            {{-- Kualifikasi & Persyaratan Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <span>Kualifikasi &amp; Persyaratan</span>
                </div>

                <div>
                    <label class="form-label-sm">Tambah persyaratan (tekan Enter atau klik Tambah)</label>
                    <div class="flex gap-2 mt-1">
                        <input type="text" id="req-input" placeholder="mis. Menguasai Laravel, Minimal S1 Teknik..."
                               class="field flex-1" onkeydown="handleTagKey(event,'req-input','req-list','requirements')">
                        <button type="button" onclick="addTag('req-input','req-list','requirements')"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[13px] font-semibold rounded-lg transition">Tambah</button>
                    </div>
                    <div id="req-list" class="flex flex-wrap gap-2 mt-3">
                        @foreach (old('requirements', []) as $req)
                            <span class="tag-badge-green">
                                {{ $req }}
                                <button type="button" onclick="removeTag(this)" class="ml-1 text-green-800 hover:text-red-600 font-bold leading-none">&times;</button>
                                <input type="hidden" name="requirements[]" value="{{ $req }}">
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tanggung Jawab Pekerjaan Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 20.015A9.753 9.753 0 0 1 12 21.75c-5.385 0-9.75-4.365-9.75-9.75s4.365-9.75 9.75-9.75 9.75 4.365 9.75 9.75c0 1.956-.575 3.776-1.564 5.305m-3.436-1.84c.75-.75 1.72-1.28 2.804-1.51M9 10.5a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0Zm-6 9c0-3.314 3.134-6 7-6 1.834 0 3.497.607 4.743 1.589"/></svg>
                    </div>
                    <span>Tanggung Jawab Pekerjaan</span>
                </div>

                <div>
                    <label class="form-label-sm">Tambah tanggung jawab (tekan Enter atau klik Tambah)</label>
                    <div class="flex gap-2 mt-1">
                        <input type="text" id="resp-input" placeholder="mis. Mengembangkan fitur backend, Melakukan code review..."
                               class="field flex-1" onkeydown="handleTagKey(event,'resp-input','resp-list','responsibilities')">
                        <button type="button" onclick="addTag('resp-input','resp-list','responsibilities')"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[13px] font-semibold rounded-lg transition">Tambah</button>
                    </div>
                    <div id="resp-list" class="flex flex-wrap gap-2 mt-3">
                        @foreach (old('responsibilities', []) as $resp)
                            <span class="tag-badge-indigo">
                                {{ $resp }}
                                <button type="button" onclick="removeTag(this)" class="ml-1 text-indigo-800 hover:text-red-600 font-bold leading-none">&times;</button>
                                <input type="hidden" name="responsibilities[]" value="{{ $resp }}">
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Skills / Tags Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-brand-600 flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/></svg>
                    </div>
                    <span>Skills / Tags</span>
                </div>

                <div>
                    <label class="form-label-sm">Tambah skill atau tag (tekan Enter atau klik Tambah)</label>
                    <div class="flex gap-2 mt-1">
                        <input type="text" id="skill-input" placeholder="mis. Laravel, React, Python..."
                               class="field flex-1" onkeydown="handleTagKey(event,'skill-input','skill-list','skills')">
                        <button type="button" onclick="addTag('skill-input','skill-list','skills')"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[13px] font-semibold rounded-lg transition">Tambah</button>
                    </div>
                    <div id="skill-list" class="flex flex-wrap gap-2 mt-3">
                        @foreach (old('skills', []) as $skill)
                            <span class="tag-badge-blue">
                                {{ $skill }}
                                <button type="button" onclick="removeTag(this)" class="ml-1 text-blue-800 hover:text-red-600 font-bold leading-none">&times;</button>
                                <input type="hidden" name="skills[]" value="{{ $skill }}">
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column (1/3 width) --}}
        <div class="space-y-6">
            {{-- Detail Perusahaan Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-brand-600 flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/></svg>
                    </div>
                    <span>Detail Perusahaan</span>
                </div>

                {{-- Featured / Company Image --}}
                <div class="space-y-2 pt-1">
                    <label class="block text-[13px] font-semibold text-slate-700">Foto / Banner Lowongan</label>
                    
                    {{-- Selector URL vs Upload --}}
                    <div class="flex items-center space-x-4 mb-2">
                        <label class="inline-flex items-center text-[13px] text-slate-700 font-medium cursor-pointer">
                            <input type="radio" name="image_source" value="url" checked class="mr-1.5 accent-blue-600">
                            Tautan URL
                        </label>
                        <label class="inline-flex items-center text-[13px] text-slate-700 font-medium cursor-pointer">
                            <input type="radio" name="image_source" value="upload" class="mr-1.5 accent-blue-600">
                            Unggah Berkas
                        </label>
                    </div>

                    {{-- Image Preview Container --}}
                    <div id="image-preview-container" class="w-full h-36 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center relative mb-2 shadow-inner">
                        <img id="image-preview" src="{{ old('image') }}" alt="Preview" class="w-full h-full object-cover {{ old('image') ? '' : 'hidden' }}" onerror="handleImageError(this)">
                        <div id="image-placeholder" class="flex flex-col items-center justify-center text-slate-400 {{ old('image') ? 'hidden' : '' }}">
                            <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                            <span class="text-[11.5px] mt-1">Pratinjau Foto</span>
                        </div>
                    </div>

                    {{-- URL Field --}}
                    <div id="image-url-field">
                        <input id="image" name="image" type="text" value="{{ old('image') }}"
                               placeholder="https://... atau /storage/..."
                               oninput="updateUrlPreview(this.value)"
                               class="field py-2 text-[13px]">
                        <p class="text-[11.5px] text-slate-400 mt-1">Tempelkan tautan gambar publik atau path gambar untuk banner lowongan.</p>
                    </div>

                    {{-- Upload Field --}}
                    <div id="image-upload-field" class="hidden">
                        <input id="image_file" name="image_file" type="file" accept="image/*"
                               onchange="previewUploadedFile(this)"
                               class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-3 py-2 text-[12.5px] text-slate-900 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[12px] file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                        <p class="text-[11.5px] text-slate-400 mt-1">Unggah berkas foto (JPG, PNG, WebP maks 2MB).</p>
                    </div>
                </div>

                {{-- Company Name --}}
                <div>
                    <label class="form-label-sm">Nama Perusahaan <span class="text-red-500">*</span></label>
                    @if (!empty($isCompany) && $company)
                        <input type="text" name="company" value="{{ old('company', $company->name) }}" readonly
                               class="field bg-slate-100 text-slate-700 cursor-not-allowed font-medium">
                        <p class="text-[11.5px] text-slate-400 mt-1">Diterbitkan atas nama perusahaan Anda.</p>
                    @else
                        <input type="text" name="company" value="{{ old('company') }}" placeholder="mis. TechFlow Systems" required
                               class="field">
                    @endif
                </div>

                {{-- Location --}}
                <div>
                    <label class="form-label-sm">Lokasi Perusahaan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="absolute left-3.5 top-3 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        <input type="text" name="location" value="{{ old('location', !empty($isCompany) && $company ? ($company->location ?: $company->city) : '') }}" placeholder="mis. Jakarta Selatan, DKI Jakarta" required
                               class="field pl-10 pr-4">
                    </div>
                </div>

                {{-- Company Size --}}
                <div>
                    <label class="form-label-sm">Ukuran Perusahaan <span class="text-red-500">*</span></label>
                    @php
                        $defaultSize = old('company_size', !empty($isCompany) && $company && $company->size ? $company->size : '51-200 Employees');
                    @endphp
                    <select name="company_size" class="field">
                        <option value="1-50 Employees" {{ $defaultSize === '1-50 Employees' || $defaultSize === '1-50 Karyawan' ? 'selected' : '' }}>1-50 Karyawan</option>
                        <option value="51-200 Employees" {{ $defaultSize === '51-200 Employees' || $defaultSize === '51-200 Karyawan' ? 'selected' : '' }}>51-200 Karyawan</option>
                        <option value="201-500 Employees" {{ $defaultSize === '201-500 Employees' || $defaultSize === '201-500 Karyawan' ? 'selected' : '' }}>201-500 Karyawan</option>
                        <option value="500+ Employees" {{ $defaultSize === '500+ Employees' || $defaultSize === '500+ Karyawan' ? 'selected' : '' }}>500+ Karyawan</option>
                    </select>
                </div>
            </div>

            {{-- Posting Status Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-brand-600 flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/></svg>
                    </div>
                    <span>Status Publikasi</span>
                </div>

                {{-- Deadline --}}
                <div>
                    <label class="form-label-sm">Deadline Lamaran</label>
                    <div class="relative">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="absolute left-3.5 top-3 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        <input type="text" name="deadline" value="{{ old('deadline') }}"
                               placeholder="mis. 30 Nov 2026"
                               class="field pl-10">
                    </div>
                    <p class="text-[11.5px] text-slate-400 mt-1">Format bebas, mis: 30 Nov 2026 atau 2026-11-30</p>
                </div>

                <div class="bg-emerald-50/90 border border-emerald-200/90 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <div class="text-[13.5px] font-bold text-emerald-900">Lowongan Aktif</div>
                        <div class="text-[11.5px] font-medium text-emerald-700">Dapat dilihat oleh para pelamar kerja</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', '1') ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<style>
.tag-badge-green { display:inline-flex; align-items:center; gap:4px; background:#dcfce7; color:#166534; border:1px solid #bbf7d0; font-size:12.5px; font-weight:600; padding:4px 10px; border-radius:999px; }
.tag-badge-indigo { display:inline-flex; align-items:center; gap:4px; background:#e0e7ff; color:#3730a3; border:1px solid #c7d2fe; font-size:12.5px; font-weight:600; padding:4px 10px; border-radius:999px; }
.tag-badge-blue { display:inline-flex; align-items:center; gap:4px; background:#dbeafe; color:#1e40af; border:1px solid #bfdbfe; font-size:12.5px; font-weight:600; padding:4px 10px; border-radius:999px; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const desc = document.getElementById('desc-field');
        const count = document.getElementById('char-count');
        if (desc && count) {
            count.textContent = desc.value.length;
            desc.addEventListener('input', function() {
                count.textContent = this.value.length;
            });
        }

        // Toggle URL vs Upload
        document.querySelectorAll('input[name="image_source"]').forEach(function(el) {
            el.addEventListener('change', function() {
                if (this.value === 'url') {
                    document.getElementById('image-url-field').classList.remove('hidden');
                    document.getElementById('image-upload-field').classList.add('hidden');
                    const urlVal = document.getElementById('image').value;
                    updateUrlPreview(urlVal);
                } else {
                    document.getElementById('image-url-field').classList.add('hidden');
                    document.getElementById('image-upload-field').classList.remove('hidden');
                    const fileInput = document.getElementById('image_file');
                    if (fileInput && fileInput.files && fileInput.files[0]) {
                        previewUploadedFile(fileInput);
                    }
                }
            });
        });
    });

    function updateUrlPreview(val) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');
        if (val && val.trim() !== '') {
            preview.src = val;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }

    function previewUploadedFile(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');
        if (input && input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function handleImageError(img) {
        img.classList.add('hidden');
        const placeholder = document.getElementById('image-placeholder');
        if (placeholder) {
            placeholder.classList.remove('hidden');
        }
    }

    // ── Tag input helpers ──────────────────────────────────────────
    function addTag(inputId, listId, fieldName) {
        const input = document.getElementById(inputId);
        const val = input.value.trim();
        if (!val) { return; }
        const list = document.getElementById(listId);
        const colorMap = {
            'requirements': 'tag-badge-green',
            'responsibilities': 'tag-badge-indigo',
            'skills': 'tag-badge-blue',
        };
        const cls = colorMap[fieldName] || 'tag-badge-blue';
        const span = document.createElement('span');
        span.className = cls;
        span.innerHTML = `${val} <button type="button" onclick="removeTag(this)" class="ml-1 hover:text-red-600 font-bold leading-none">&times;</button><input type="hidden" name="${fieldName}[]" value="${val.replace(/"/g,'&quot;')}">`;
        list.appendChild(span);
        input.value = '';
        input.focus();
    }

    function handleTagKey(event, inputId, listId, fieldName) {
        if (event.key === 'Enter') {
            event.preventDefault();
            addTag(inputId, listId, fieldName);
        }
    }

    function removeTag(btn) {
        btn.closest('span').remove();
    }
</script>
@endpush
@endsection
