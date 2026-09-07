@extends('admin.layouts.app')

@section('title', 'Edit User — IndoTech Admin')

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6 max-w-7xl mx-auto">
    @csrf
    @method('PUT')

    {{-- Header --}}
    <div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 mb-2 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
            <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 transition">User Management</a>
            <span class="text-slate-400">›</span>
            <span class="text-slate-900 font-semibold">Edit User</span>
        </div>

        <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">Edit User: {{ $user->name }}</h1>
    </div>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN (8 cols) --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Card 1: User Profile --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-5">
                <div class="flex items-center gap-2.5 mb-2 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Informasi Profil User</h2>
                </div>

                {{-- Fields Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Name --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required
                               placeholder="Nama user"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required
                               placeholder="Alamat email"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Optional --}}
                    <div class="sm:col-span-2">
                        <label class="block text-[13px] font-semibold text-slate-700 mb-1">Ganti Password (Opsional)</label>
                        <p class="text-[12px] text-slate-400 mb-2">Biarkan kosong jika tidak ingin mengubah password user.</p>
                        <input type="password" 
                               name="password" 
                               placeholder="Masukkan password baru jika ingin mengubah"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Card 2: Organization Info --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-5">
                <div class="flex items-center gap-2.5 mb-2 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5v3"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Informasi Organisasi / Instansi</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Org Contact --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Kontak Penanggung Jawab</label>
                        <input type="text" 
                               name="org_contact" 
                               value="{{ old('org_contact', $user->org_contact) }}" 
                               placeholder="Nama PIC"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('org_contact')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Org Phone --}}
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Nomor Telepon Organisasi</label>
                        <input type="text" 
                               name="org_phone" 
                               value="{{ old('org_phone', $user->org_phone) }}" 
                               placeholder="Nomor telepon"
                               class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">
                        @error('org_phone')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Org Address --}}
                    <div class="sm:col-span-2">
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Alamat Instansi / Perusahaan</label>
                        <textarea name="org_address" 
                                  rows="3" 
                                  placeholder="Alamat organisasi"
                                  class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition font-medium">{{ old('org_address', $user->org_address) }}</textarea>
                        @error('org_address')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN (4 cols) --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Status & Role Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-5">
                <h3 class="text-[15px] font-bold text-slate-900 border-b border-slate-100 pb-3">Peran & Status</h3>

                {{-- Role Selection --}}
                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Role Pengguna <span class="text-red-500">*</span></label>
                    <select name="role" required class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition cursor-pointer font-medium">
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User (Siswa / umum)</option>
                        <option value="school_admin" {{ old('role', $user->role) == 'school_admin' ? 'selected' : '' }}>School Admin</option>
                        <option value="university_rep" {{ old('role', $user->role) == 'university_rep' ? 'selected' : '' }}>University Representative</option>
                        <option value="company_hr" {{ old('role', $user->role) == 'company_hr' ? 'selected' : '' }}>Company HR</option>
                        <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Selection --}}
                <div>
                    <label class="block text-[13px] font-semibold text-slate-700 mb-2">Status Akun <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-[#f0f4f9]/80 hover:bg-[#e9eef6] focus:bg-white border border-transparent focus:border-blue-500 rounded-xl px-4 py-3 text-[14px] text-slate-800 outline-none transition cursor-pointer font-medium">
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Submit Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-3">
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-3 rounded-xl text-[14px] shadow-sm transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" 
                   class="block w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-3 rounded-xl text-[14px] transition">
                    Batal
                </a>
            </div>

        </div>

    </div>
</form>
@endsection
