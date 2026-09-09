@extends('admin.layouts.app')

@section('title', 'Edit Job Posting — Admin IndoTech')

@section('content')
<form action="{{ route('admin.jobs.update', $job['id']) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-[13.5px]">
            <p class="font-semibold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('admin.jobs.show', $job['id']) }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Kembali
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.jobs.show', $job['id']) }}" class="inline-flex items-center justify-center bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold px-5 py-2.5 rounded-lg text-[13.5px] transition">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#0b57d0] hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg text-[13.5px] shadow-2xs transition">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/></svg>
                <span>Simpan Perubahan</span>
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
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-[#0b57d0] flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/></svg>
                    </div>
                    <span>Basic Information</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    {{-- Job Title --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $job['title']) }}" required
                               class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    {{-- Department --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Department <span class="text-red-500">*</span></label>
                        <select name="department" class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @foreach (['Engineering', 'Product', 'Design', 'Data', 'Marketing', 'Operations', 'Finance', 'Human Resources'] as $dept)
                                <option value="{{ $dept }}" {{ old('department', $job['department'] ?? '') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Employment Type --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Employment Type <span class="text-red-500">*</span></label>
                        <select name="type" class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @foreach (['Full-time', 'Part-time', 'Contract', 'Internship'] as $tp)
                                <option value="{{ $tp }}" {{ strtolower(old('type', $job['type'])) === strtolower($tp) ? 'selected' : '' }}>{{ $tp }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Salary Range --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Salary Range (IDR)</label>
                        <input type="text" name="salary_range" value="{{ old('salary_range', $job['salary_range'] ?? '') }}"
                               class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    {{-- Career Category --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Career Category</label>
                        <select name="category" class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="jobs" {{ old('category', $job['category'] ?? '') === 'jobs' ? 'selected' : '' }}>Jobs (Reguler)</option>
                            <option value="internship" {{ old('category', $job['category'] ?? '') === 'internship' ? 'selected' : '' }}>Internship (Magang)</option>
                            <option value="freelance" {{ old('category', $job['category'] ?? '') === 'freelance' ? 'selected' : '' }}>Freelance / Kontrak</option>
                            <option value="remote" {{ old('category', $job['category'] ?? '') === 'remote' ? 'selected' : '' }}>Remote Work</option>
                            <option value="graduate" {{ old('category', $job['category'] ?? '') === 'graduate' ? 'selected' : '' }}>Graduate Job</option>
                        </select>
                    </div>

                    {{-- Experience Level --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Experience Level</label>
                        <select name="experience" class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="Entry" {{ old('experience', $job['experience'] ?? '') === 'Entry' ? 'selected' : '' }}>Entry Level</option>
                            <option value="Mid" {{ old('experience', $job['experience'] ?? '') === 'Mid' ? 'selected' : '' }}>Mid Level</option>
                            <option value="Senior" {{ old('experience', $job['experience'] ?? '') === 'Senior' ? 'selected' : '' }}>Senior Level</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Job Description Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-[#0b57d0] flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                    </div>
                    <span>Job Description <span class="text-red-500">*</span></span>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Detailed Description</label>
                    <textarea name="description" rows="6" required id="desc-field"
                              class="w-full bg-slate-100/70 border border-slate-200 rounded-xl p-4 text-[13.5px] text-slate-900 leading-relaxed focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">{{ old('description', $job['description']) }}</textarea>
                    <div class="text-right text-[11.5px] text-slate-400 mt-1 font-medium">
                        <span id="char-count">350</span> / 2000 characters
                    </div>
                </div>
            </div>

            {{-- Requirements Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-[#0b57d0] flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm0 5.25h.007v.008H3.75V12Zm0 5.25h.007v.008H3.75v-.008Z"/></svg>
                    </div>
                    <span>Requirements</span>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Key Qualifications</label>
                    <textarea name="requirements" rows="6"
                              class="w-full bg-slate-100/70 border border-slate-200 rounded-xl p-4 text-[13.5px] text-slate-900 leading-relaxed focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">{{ old('requirements', $job['requirements']) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Right Column (1/3 width) --}}
        <div class="space-y-6">
            {{-- Company Details Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-[#0b57d0] flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/></svg>
                    </div>
                    <span>Company Details</span>
                </div>

                {{-- Featured / Company Image --}}
                <div class="space-y-2 pt-1">
                    <label class="block text-[13px] font-semibold text-slate-700">Foto / Banner Lowongan</label>
                    
                    {{-- Selector URL vs Upload --}}
                    <div class="flex items-center space-x-4 mb-2">
                        <label class="inline-flex items-center text-[13px] text-slate-700 font-medium cursor-pointer">
                            <input type="radio" name="image_source" value="url" checked class="mr-1.5 accent-blue-600">
                            URL Link
                        </label>
                        <label class="inline-flex items-center text-[13px] text-slate-700 font-medium cursor-pointer">
                            <input type="radio" name="image_source" value="upload" class="mr-1.5 accent-blue-600">
                            Upload File
                        </label>
                    </div>

                    {{-- Image Preview Container --}}
                    @php
                        $currentJobImage = old('image', $job['image'] ?? $job['logo_url'] ?? '');
                    @endphp
                    <div id="image-preview-container" class="w-full h-36 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center relative mb-2 shadow-inner">
                        <img id="image-preview" src="{{ $currentJobImage }}" alt="Preview" class="w-full h-full object-cover {{ !empty($currentJobImage) ? '' : 'hidden' }}" onerror="handleImageError(this)">
                        <div id="image-placeholder" class="flex flex-col items-center justify-center text-slate-400 {{ !empty($currentJobImage) ? 'hidden' : '' }}">
                            <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                            <span class="text-[11.5px] mt-1">Preview Foto</span>
                        </div>
                    </div>

                    {{-- URL Field --}}
                    <div id="image-url-field">
                        <input id="image" name="image" type="text" value="{{ old('image', $job['image'] ?? $job['logo_url'] ?? '') }}"
                               placeholder="https://... atau /storage/..."
                               oninput="updateUrlPreview(this.value)"
                               class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2 text-[13px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <p class="text-[11.5px] text-slate-400 mt-1">Tempelkan link gambar publik atau path gambar untuk banner lowongan.</p>
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
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Company Name <span class="text-red-500">*</span></label>
                    <input type="text" name="company" value="{{ old('company', $job['company'] ?? 'TechCorp Indonesia') }}" required
                           class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                {{-- Location --}}
                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Location <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="absolute left-3.5 top-3 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        <input type="text" name="location" value="{{ old('location', $job['location_full'] ?? $job['location']) }}" required
                               class="w-full bg-slate-100/70 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                </div>

                {{-- Company Size --}}
                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Company Size <span class="text-red-500">*</span></label>
                    <select name="company_size" class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="1-50 Employees" {{ old('company_size', $job['company_size'] ?? '') === '1-50 Employees' ? 'selected' : '' }}>1-50 Employees</option>
                        <option value="51-200 Employees" {{ old('company_size', $job['company_size'] ?? '') === '51-200 Employees' ? 'selected' : '' }}>51-200 Employees</option>
                        <option value="201-500 Employees" {{ old('company_size', $job['company_size'] ?? '') === '201-500 Employees' ? 'selected' : '' }}>201-500 Employees</option>
                        <option value="500+ Employees" {{ old('company_size', $job['company_size'] ?? '') === '500+ Employees' ? 'selected' : '' }}>500+ Employees</option>
                    </select>
                </div>
            </div>

            {{-- Posting Status Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-[#0b57d0] flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/></svg>
                    </div>
                    <span>Posting Status</span>
                </div>

                {{-- Active Green Light Toggle Box --}}
                <div class="bg-emerald-50/90 border border-emerald-200/90 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <div class="text-[13.5px] font-bold text-emerald-900">Active Posting</div>
                        <div class="text-[11.5px] font-medium text-emerald-700">Currently visible to candidates</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $job['is_active'] ?? false) || $job['status'] === 'Active' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    const initialJobImage = @json($currentJobImage);

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
                    } else if (initialJobImage) {
                        const preview = document.getElementById('image-preview');
                        const placeholder = document.getElementById('image-placeholder');
                        preview.src = initialJobImage;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
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
        } else if (initialJobImage) {
            preview.src = initialJobImage;
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
        } else if (initialJobImage) {
            preview.src = initialJobImage;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
    }

    function handleImageError(img) {
        img.classList.add('hidden');
        const placeholder = document.getElementById('image-placeholder');
        if (placeholder) {
            placeholder.classList.remove('hidden');
        }
    }
</script>
@endpush
@endsection
