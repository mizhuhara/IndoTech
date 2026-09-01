@extends('admin.layouts.app')

@section('title', 'Post New Job — Admin IndoTech')

@section('content')
<form action="{{ route('admin.jobs.store') }}" method="POST" class="space-y-6">
    @csrf

    {{-- Top Breadcrumbs --}}
    <div class="text-[13px] text-slate-500 flex items-center gap-2">
        <a href="{{ route('admin.jobs.index') }}" class="hover:text-blue-600 font-medium transition">Jobs</a>
        <span>›</span>
        <span class="text-slate-900 font-semibold">Post New Job</span>
    </div>

    {{-- Title Bar & Top Action Buttons --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.jobs.index') }}" class="p-2 rounded-lg text-slate-600 hover:bg-slate-200/60 transition" title="Kembali">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <h1 class="text-[24px] font-bold text-slate-900 tracking-tight">Post New Job</h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center justify-center bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold px-5 py-2.5 rounded-lg text-[13.5px] transition">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#0b57d0] hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg text-[13.5px] shadow-2xs transition">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.8"><path d="M12 5v14M5 12h14"/></svg>
                <span>Publikasikan Job</span>
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
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Job Title</label>
                        <input type="text" name="title" placeholder="mis. Senior Frontend Engineer" required
                               class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    {{-- Department --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Department</label>
                        <select name="department" class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="Engineering">Engineering</option>
                            <option value="Product">Product</option>
                            <option value="Design">Design</option>
                            <option value="Data">Data</option>
                            <option value="Marketing">Marketing</option>
                        </select>
                    </div>

                    {{-- Employment Type --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Employment Type</label>
                        <select name="type" class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                            <option value="Internship">Internship</option>
                        </select>
                    </div>

                    {{-- Salary Range --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Salary Range (IDR)</label>
                        <input type="text" name="salary_range" placeholder="mis. 15.000.000 - 25.000.000"
                               class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                </div>
            </div>

            {{-- Job Description Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-2xs space-y-4">
                <div class="flex items-center gap-3 text-slate-900 font-bold text-[16px]">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-[#0b57d0] flex items-center justify-center">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                    </div>
                    <span>Job Description</span>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Detailed Description</label>
                    <textarea name="description" rows="6" required id="desc-field" placeholder="Tuliskan deskripsi lengkap pekerjaan..."
                              class="w-full bg-slate-100/70 border border-slate-200 rounded-xl p-4 text-[13.5px] text-slate-900 leading-relaxed focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"></textarea>
                    <div class="text-right text-[11.5px] text-slate-400 mt-1 font-medium">
                        <span id="char-count">0</span> / 2000 characters
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
                    <textarea name="requirements" rows="6" placeholder="- Minimal 3 tahun pengalaman di bidang terkait...&#10;- Menguasai React, TypeScript, dan Git..."
                              class="w-full bg-slate-100/70 border border-slate-200 rounded-xl p-4 text-[13.5px] text-slate-900 leading-relaxed focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"></textarea>
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

                {{-- Company Image Box --}}
                <div class="w-full h-28 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center">
                    <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="text-slate-300">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="m21 15-5-5L5 21"/>
                    </svg>
                </div>

                {{-- Company Name --}}
                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Company Name</label>
                    <input type="text" name="company" placeholder="mis. TechFlow Systems" required
                           class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                {{-- Location --}}
                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Location</label>
                    <div class="relative">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="absolute left-3.5 top-3 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        <input type="text" name="location" placeholder="mis. Jakarta Selatan, DKI Jakarta" required
                               class="w-full bg-slate-100/70 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                </div>

                {{-- Company Size --}}
                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-1.5">Company Size</label>
                    <select name="company_size" class="w-full bg-slate-100/70 border border-slate-200 rounded-xl px-4 py-2.5 text-[13.5px] text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="1-50 Employees">1-50 Employees</option>
                        <option value="51-200 Employees" selected>51-200 Employees</option>
                        <option value="201-500 Employees">201-500 Employees</option>
                        <option value="500+ Employees">500+ Employees</option>
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

                <div class="bg-emerald-50/90 border border-emerald-200/90 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <div class="text-[13.5px] font-bold text-emerald-900">Active Posting</div>
                        <div class="text-[11.5px] font-medium text-emerald-700">Currently visible to candidates</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
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
    });
</script>
@endpush
@endsection
