@extends('admin.layouts.app')

@section('title', 'Edit Community — IndoTech')

@section('content')
<form method="POST" action="{{ route('admin.community.update', $community['id']) }}" class="space-y-6 max-w-7xl mx-auto">
    @csrf
    @method('PUT')

    {{-- Top Back Link & Breadcrumb --}}
    <div>
        <a href="{{ route('admin.community.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 mb-2 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
            <a href="{{ route('admin.community.index') }}" class="hover:text-blue-600 transition">Community</a>
            <span class="text-slate-400">›</span>
            <span class="text-slate-900 font-semibold">Edit {{ $community['name'] ?? 'Community' }}</span>
        </div>

        <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">Edit Community</h1>
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
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Basic Information</h2>
                </div>

                {{-- Fields Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Community Name --}}
                    <div class="sm:col-span-2">
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Community Name <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $community['name'] ?? '') }}" 
                               required
                               placeholder="Contoh: Web Developer Indonesia"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Category <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="category" 
                                    class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition appearance-none cursor-pointer font-medium pr-10">
                                <option value="Technology" {{ old('category', $community['category'] ?? '') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Design" {{ old('category', $community['category'] ?? '') == 'Design' ? 'selected' : '' }}>Design</option>
                                <option value="Business" {{ old('category', $community['category'] ?? '') == 'Business' ? 'selected' : '' }}>Business</option>
                                <option value="Other" {{ old('category', $community['category'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-6 h-12">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="status" value="active" {{ old('status', $community['status'] ?? 'active') === 'active' ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#0b57d0] border-gray-300 focus:ring-[#0b57d0]">
                                <span class="ml-2 text-[14px] font-medium text-slate-800">Active</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="status" value="inactive" {{ old('status', $community['status'] ?? '') === 'inactive' ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#0b57d0] border-gray-300 focus:ring-[#0b57d0]">
                                <span class="ml-2 text-[14px] font-medium text-slate-800">Inactive</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Card 2: Description --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-5 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Description</h2>
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Community Profile</label>
                    <textarea name="description" 
                              id="communityDescription"
                              rows="5"
                              maxlength="1000"
                              oninput="document.getElementById('charCount').textContent = this.value.length + ' / 1000 characters'"
                              placeholder="Tuliskan deskripsi singkat komunitas..."
                              class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl p-4 text-[14px] text-slate-800 outline-none transition font-medium leading-relaxed resize-none">{{ old('description', $community['description'] ?? '') }}</textarea>
                    
                    <div class="flex justify-end mt-2">
                        <span id="charCount" class="text-[12.5px] font-medium text-slate-500">
                            {{ strlen(old('description', $community['description'] ?? '')) }} / 1000 characters
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card 3: Gallery --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                {{-- Card Header with Action --}}
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2.5 text-slate-900">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21"/>
                        </svg>
                        <h2 class="text-[17px] font-bold text-slate-900">Community Gallery</h2>
                    </div>

                    <button type="button" class="inline-flex items-center gap-1.5 text-[13.5px] font-bold text-[#0b57d0] hover:text-blue-700 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/>
                        </svg>
                        Add Photo
                    </button>
                </div>

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

            {{-- Card 1: Logo / Avatar --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs flex flex-col items-center text-center">
                <h2 class="text-[17px] font-bold text-slate-900 self-start mb-5">Community Logo</h2>

                {{-- Logo Preview Box --}}
                <div class="w-full aspect-[4/3] rounded-2xl bg-[#f0f4f9] border border-slate-200/70 flex items-center justify-center p-6 mb-4 relative overflow-hidden">
                    <div class="w-24 h-24 rounded-full bg-blue-50 flex items-center justify-center text-[#0b57d0] font-extrabold text-2xl shadow-sm border border-white overflow-hidden">
                        @if(!empty($community['logo_url']))
                            <img src="{{ $community['logo_url'] }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            {{ substr($community['name'] ?? 'C', 0, 1) }}
                        @endif
                    </div>
                </div>

                <div class="font-bold text-slate-900 text-[14px]">
                    Change Logo
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

            {{-- Card 2: Contact Info --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <h2 class="text-[17px] font-bold text-slate-900 mb-4">Contact & Socials</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $community['email'] ?? '') }}" 
                               placeholder="hello@community.org"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                    </div>

                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Website</label>
                        <input type="url" 
                               name="website" 
                               value="{{ old('website', $community['website'] ?? '') }}" 
                               placeholder="https://www.community.org"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- Bottom Action Bar --}}
    <div class="pt-6 border-t border-slate-200/80 flex items-center justify-end gap-4">
        <a href="{{ route('admin.community.index') }}" 
           class="px-6 py-2.5 text-[14px] font-semibold text-slate-600 hover:text-slate-900 transition">
            Cancel
        </a>

        <button type="submit" 
                class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#0b57d0] hover:bg-blue-700 text-white font-semibold text-[14px] shadow-sm transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Update Komunitas
        </button>
    </div>

</form>
@endsection
