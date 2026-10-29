@extends('admin.layouts.app')

@section('title', 'User Management — IndoTech Admin')

@section('content')
<div class="space-y-6">

    {{-- Error Banner --}}
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm shadow-sm flex items-start gap-3 animate-fade-in">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-red-500 shrink-0 mt-0.5">
                <circle cx="12" cy="12" r="9"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div class="flex-1">
                <div class="font-bold">Terdapat beberapa kesalahan:</div>
                <ul class="list-disc list-inside mt-1 text-xs space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
        </div>
    @endif

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3">
            {{-- Filter Modal Button --}}
            <button type="button" 
                    onclick="openFilterModal()" 
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-[13.5px] font-semibold shadow-xs transition">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span>Filter</span>
                @if(request('status') || (request('role') && request('role') !== 'all') || (request('sort') && request('sort') !== 'latest'))
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                @endif
            </button>

            {{-- Tambah User Button --}}
            <button type="button" 
                    onclick="openAddModal()" 
                    class="flex items-center gap-2 px-4.5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-[13.5px] font-semibold shadow-xs transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                <span>Tambah User</span>
            </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11.5px] font-bold tracking-wider text-slate-400 uppercase">TOTAL USERS</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalUsersCount) }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-500 flex items-center justify-center font-bold">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11.5px] font-bold tracking-wider text-slate-400 uppercase">USER AKTIF</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($activeUsersCount) }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-500 flex items-center justify-center font-bold">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11.5px] font-bold tracking-wider text-slate-400 uppercase">PENDING VERIFIKASI</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($pendingUsersCount) }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-500 flex items-center justify-center font-bold">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-[11.5px] font-bold tracking-wider text-slate-400 uppercase">USER HIDDEN</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($hiddenUsersCount ?? 0) }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-500 flex items-center justify-center font-bold">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
            </div>
        </div>
    </div>
    @php
        $currentRole = strtolower(request('role', 'all'));
    @endphp

    {{-- Main Container Card --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">

        {{-- Table Toolbar: Search, Role Selector, Sorting & Reset --}}
        <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3.5">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 flex-1 max-w-4xl">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif

                {{-- Search Input --}}
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3.5 h-10 w-full sm:w-72 focus-within:border-blue-500 focus-within:bg-white transition">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400">
                        <circle cx="11" cy="11" r="7"/>
                        <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}" 
                           placeholder="Cari nama, email..." 
                           class="bg-transparent outline-none text-[13px] text-slate-800 placeholder-slate-400 flex-1 min-w-0">
                    @if(request('q'))
                        <a href="{{ request()->fullUrlWithQuery(['q' => null, 'page' => 1]) }}" class="text-xs text-slate-400 hover:text-slate-600 font-bold">&times;</a>
                    @endif
                </div>

                {{-- Role Selector Dropdown --}}
                <div class="relative min-w-[155px]">
                    <select name="role" 
                            onchange="this.form.submit()" 
                            class="w-full h-10 pl-3 pr-8 bg-slate-50 border border-slate-200 rounded-xl text-[13px] text-slate-700 font-medium outline-none focus:border-blue-500 focus:bg-white transition cursor-pointer appearance-none">
                        <option value="all" {{ (request('role') === 'all' || !request('role')) ? 'selected' : '' }}>Semua Role</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="school" {{ request('role') === 'school' ? 'selected' : '' }}>Sekolah (School)</option>
                        <option value="company" {{ request('role') === 'company' ? 'selected' : '' }}>Company (Perusahaan)</option>
                        <option value="university" {{ request('role') === 'university' ? 'selected' : '' }}>Universitas (University)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Sorting Selector Dropdown --}}
                <div class="relative min-w-[160px]">
                    <select name="sort" 
                            onchange="this.form.submit()" 
                            class="w-full h-10 pl-3 pr-8 bg-slate-50 border border-slate-200 rounded-xl text-[13px] text-slate-700 font-medium outline-none focus:border-blue-500 focus:bg-white transition cursor-pointer appearance-none">
                        <option value="latest" {{ (request('sort') === 'latest' || !request('sort')) ? 'selected' : '' }}>Urutkan: Terbaru</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Urutkan: Terlama</option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama: A → Z</option>
                        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama: Z → A</option>
                        <option value="role_asc" {{ request('sort') === 'role_asc' ? 'selected' : '' }}>Role: A → Z</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                    </div>
                </div>

                {{-- Submit button for keyboard/enter --}}
                <button type="submit" class="hidden sm:inline-flex items-center justify-center px-3 h-10 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-[12.5px] font-semibold transition cursor-pointer shrink-0">
                    Terapkan
                </button>

                @if(request('q') || (request('role') && request('role') !== 'all') || (request('sort') && request('sort') !== 'latest') || (request('status') && request('status') !== 'all'))
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-3 h-10 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-[12.5px] font-semibold transition shrink-0">
                        Reset Filter
                    </a>
                @endif
            </form>

            <div class="text-xs text-slate-500 font-medium shrink-0 self-end lg:self-auto">
                Total: <span class="font-bold text-slate-800">{{ number_format($users->total()) }}</span> User Ditemukan
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 text-[11.5px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                        <th class="cell">USER & EMAIL</th>
                        <th class="cell">ROLE</th>
                        <th class="cell">STATUS</th>
                        <th class="cell">TERDAFTAR</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13.5px]">
                    @forelse($users as $user)
                        @php
                            $roleLower = strtolower($user->role ?? 'user');
                            $statusLower = strtolower($user->status ?? 'active');

                            $roleBadgeClasses = match($roleLower) {
                                'super_admin', 'superadmin', 'admin' => 'bg-slate-100 text-slate-800 border-slate-300 font-semibold',
                                'school', 'school_admin', 'school admin' => 'bg-slate-50 text-slate-700 border-slate-200/90 font-medium',
                                'company', 'company_hr', 'company hr' => 'bg-slate-50 text-slate-700 border-slate-200/90 font-medium',
                                'university', 'univ_rep', 'university representative' => 'bg-slate-50 text-slate-700 border-slate-200/90 font-medium',
                                default => 'bg-slate-50 text-slate-600 border-slate-200/90 font-medium',
                            };

                            $roleDisplayName = match($roleLower) {
                                'super_admin', 'superadmin' => 'Super Admin',
                                'admin' => 'Admin',
                                'school', 'school_admin', 'school admin' => 'Sekolah',
                                'company', 'company_hr', 'company hr' => 'Company',
                                'univ_rep', 'university representative', 'university' => 'Universitas',
                                'user' => 'User Biasa',
                                default => ucwords($user->role ?? 'User'),
                            };

                            $initials = strtoupper(substr($user->name, 0, 2));
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition group">
                            {{-- User & Email --}}
                            <td class="cell">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 truncate leading-snug">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5 truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td class="cell">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs border {{ $roleBadgeClasses }}">
                                    {{ $roleDisplayName }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="cell">
                                @if($statusLower === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @elseif($statusLower === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Pending
                                    </span>
                                @elseif($statusLower === 'hidden')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-600 border border-slate-200/80">
                                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                        </svg>
                                        Hidden
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Terdaftar --}}
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- Edit Button --}}
                                    <button type="button" 
                                            onclick="openEditModal({{ json_encode($user) }})" 
                                            class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" 
                                            title="Edit User">
                                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/>
                                        </svg>
                                    </button>

                                    {{-- Hide / Unhide Button --}}
                                    @if($statusLower === 'hidden')
                                        <button type="button" 
                                                onclick="openToggleHideModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', true)" 
                                                class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" 
                                                title="Tampilkan / Unhide User">
                                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    @else
                                        <button type="button" 
                                                onclick="openToggleHideModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', false)" 
                                                class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" 
                                                title="Hide / Sembunyikan User (Membership)">
                                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                            </svg>
                                        </button>
                                    @endif

                                    {{-- Delete Button --}}
                                    <button type="button" 
                                            onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" 
                                            class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" 
                                            title="Hapus User">
                                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="max-w-sm mx-auto space-y-2">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.35-4.35"/></svg>
                                    </div>
                                    <div class="font-bold text-slate-800 text-sm">Tidak ada user ditemukan</div>
                                    <p class="text-xs text-slate-400">Coba ubah kata kunci pencarian atau reset filter status Anda.</p>
                                    <a href="{{ route('admin.users.index') }}" class="inline-block text-xs font-semibold text-blue-600 hover:underline">Reset Filter & Search</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer & Pagination --}}
        <div class="p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-[13px] text-slate-500">
                Showing <span class="font-semibold text-slate-800">{{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }}</span> of <span class="font-semibold text-slate-800">{{ $users->total() }}</span> users
            </div>

            <div class="flex items-center gap-1.5 text-[13.5px]">
                @if ($users->onFirstPage())
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-100 text-slate-300 cursor-not-allowed select-none">‹</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">‹</a>
                @endif

                @for ($page = 1; $page <= max(1, $users->lastPage()); $page++)
                    @if ($page == $users->currentPage())
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-600 text-white font-bold shadow-xs select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $users->url($page) }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">{{ $page }}</a>
                    @endif
                @endfor

                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition">›</a>
                @else
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-100 text-slate-300 cursor-not-allowed select-none">›</span>
                @endif
            </div>
        </div>

    </div>

</div>

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 1: TAMBAH USER BARU --}}
{{-- ========================================================================= --}}
<div id="modal-add-user" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4 overflow-y-auto transition-all duration-200">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        {{-- Modal Header --}}
        <div class="px-6 py-4.5 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-brand-600 border border-blue-100 flex items-center justify-center">
                    <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div>
                    <h3 class="text-[15px] font-bold text-slate-900">Tambah User Baru</h3>
                    <p class="text-[12px] text-slate-500">Lengkapi formulir untuk menambahkan pengguna baru.</p>
                </div>
            </div>
            <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Modal Body Form --}}
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4 text-xs sm:text-sm font-medium text-slate-700">
            @csrf
            <div>
                <label class="form-label-strong">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Ahmad Rizky" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
            </div>

            <div>
                <label class="form-label-strong">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required placeholder="user@indotech.id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
            </div>

            <div>
                <label class="form-label-strong">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label-strong">Role / Peranan <span class="text-red-500">*</span></label>
                    <select name="role" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
                        <option value="user">User / Alumni</option>
                        <option value="school">Sekolah (School)</option>
                        <option value="university">Universitas (University)</option>
                        <option value="company">Perusahaan (Company)</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>

                <div>
                    <label class="form-label-strong">Status Akun <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
                        <option value="active">Active (Aktif)</option>
                        <option value="pending">Pending (Verifikasi)</option>
                        <option value="hidden">Hidden (Disembunyikan / Membership)</option>
                        <option value="inactive">Inactive (Non-aktif)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-[13px] transition cursor-pointer">Batal</button>
                <button type="submit" style="background-color: #2563eb !important; color: #ffffff !important;" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[13px] shadow-sm transition cursor-pointer">Simpan User</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 2: EDIT DATA USER --}}
{{-- ========================================================================= --}}
<div id="modal-edit-user" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4 overflow-y-auto transition-all duration-200">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        {{-- Modal Header --}}
        <div class="px-6 py-4.5 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-brand-600 border border-blue-100 flex items-center justify-center">
                    <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h3 class="text-[15px] font-bold text-slate-900">Edit Data User</h3>
                    <p class="text-[12px] text-slate-500">Perbarui informasi pengguna berikut.</p>
                </div>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Modal Body Form --}}
        <form id="form-edit-user" method="POST" class="p-6 space-y-4 text-xs sm:text-sm font-medium text-slate-700">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label-strong">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="edit_name" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
            </div>

            <div>
                <label class="form-label-strong">Email <span class="text-red-500">*</span></label>
                <input type="email" id="edit_email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
            </div>

            <div>
                <label class="form-label-strong">Password Baru <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <input type="password" id="edit_password" name="password" minlength="6" placeholder="Biarkan kosong jika tidak ingin mengubah password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label-strong">Role / Peranan <span class="text-red-500">*</span></label>
                    <select id="edit_role" name="role" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
                        <option value="user">User / Alumni</option>
                        <option value="school">Sekolah (School)</option>
                        <option value="university">Universitas (University)</option>
                        <option value="company">Perusahaan (Company)</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>

                <div>
                    <label class="form-label-strong">Status Akun <span class="text-red-500">*</span></label>
                    <select id="edit_status" name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 outline-none focus:border-blue-600 focus:bg-white transition text-[13px]">
                        <option value="active">Active (Aktif)</option>
                        <option value="pending">Pending (Verifikasi)</option>
                        <option value="hidden">Hidden (Disembunyikan / Membership)</option>
                        <option value="inactive">Inactive (Non-aktif)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-[13px] transition cursor-pointer">Batal</button>
                <button type="submit" style="background-color: #2563eb !important; color: #ffffff !important;" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[13px] shadow-sm transition cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 3: FILTER USER --}}
{{-- ========================================================================= --}}
<div id="modal-filter" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl space-y-4 border border-slate-100">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <h3 class="text-sm font-bold text-slate-900">Filter Data User</h3>
            </div>
            <button type="button" onclick="closeFilterModal()" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4 text-xs font-medium">
            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

            <div>
                <label class="block text-slate-700 mb-1.5 font-bold">Status Akun</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-blue-600">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active (Aktif)</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (Verifikasi)</option>
                    <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>Hidden (Disembunyikan)</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive (Non-aktif)</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1.5 font-bold">Role / Peranan</label>
                <select name="role" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-blue-600 text-[13px]">
                    <option value="all" {{ (request('role') === 'all' || !request('role')) ? 'selected' : '' }}>Semua Role</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User Biasa</option>
                    <option value="school" {{ request('role') === 'school' ? 'selected' : '' }}>Sekolah (School)</option>
                    <option value="company" {{ request('role') === 'company' ? 'selected' : '' }}>Company (Perusahaan)</option>
                    <option value="university" {{ request('role') === 'university' ? 'selected' : '' }}>Universitas (University)</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1.5 font-bold">Urutkan Data</label>
                <select name="sort" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 outline-none focus:border-blue-600 text-[13px]">
                    <option value="latest" {{ (request('sort') === 'latest' || !request('sort')) ? 'selected' : '' }}>Terbaru (Default)</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama: A → Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama: Z → A</option>
                    <option value="role_asc" {{ request('sort') === 'role_asc' ? 'selected' : '' }}>Role: A → Z</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition">Reset</a>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm transition">Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL POP-UP 4: KONFIRMASI HIDE / UNHIDE USER (MEMBERSHIP) --}}
{{-- ========================================================================= --}}
<div id="modal-toggle-hide-user" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4 transition-all duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all p-6 space-y-4 text-left">
        <div class="flex items-start gap-3.5">
            <div id="hide_user_icon_box" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 border border-slate-200 mt-0.5">
                <svg id="hide_user_icon_slash" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                </svg>
                <svg id="hide_user_icon_eye" class="hidden" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 id="hide_user_modal_title" class="text-[15px] font-bold text-slate-900 tracking-tight">Konfirmasi Sembunyikan Akun</h3>
                <p class="text-[13px] text-slate-500 leading-relaxed mt-1">
                    <span id="hide_user_modal_desc">Sembunyikan akun untuk</span> <strong id="hide_user_name" class="text-slate-800 font-semibold"></strong> (<span id="hide_user_email" class="text-slate-600"></span>)?
                </p>
            </div>
            <button type="button" onclick="closeToggleHideModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div id="hide_user_warning_box" class="text-[12px] text-slate-600 bg-slate-50 border border-slate-200 px-3.5 py-2.5 rounded-xl flex items-start gap-2">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="shrink-0 text-slate-400 mt-0.5"><circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span id="hide_user_warning_text">Akun yang disembunyikan (belum perpanjang membership) tidak akan tampil di direktori publik dan dinonaktifkan sementara.</span>
        </div>

        <form id="form-toggle-hide-user" method="POST" class="pt-1 flex items-center justify-end gap-2.5">
            @csrf
            <button type="button" onclick="closeToggleHideModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 text-[13px] transition cursor-pointer">Batal</button>
            <button type="submit" id="hide_user_submit_btn" class="px-4.5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-[13px] shadow-xs transition cursor-pointer">Sembunyikan User</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openToggleHideModal(id, name, email, isHidden) {
        const form = document.getElementById('form-toggle-hide-user');
        form.action = `{{ url('/admin/users') }}/${id}/toggle-hide`;

        document.getElementById('hide_user_name').textContent = name;
        document.getElementById('hide_user_email').textContent = email;

        const titleEl = document.getElementById('hide_user_modal_title');
        const descEl = document.getElementById('hide_user_modal_desc');
        const submitBtn = document.getElementById('hide_user_submit_btn');
        const iconSlash = document.getElementById('hide_user_icon_slash');
        const iconEye = document.getElementById('hide_user_icon_eye');
        const warnText = document.getElementById('hide_user_warning_text');

        if (isHidden) {
            titleEl.textContent = 'Konfirmasi Tampilkan Akun (Unhide)';
            descEl.textContent = 'Tampilkan kembali akun untuk';
            submitBtn.textContent = 'Tampilkan User';
            submitBtn.className = 'px-4.5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[13px] shadow-xs transition cursor-pointer';
            iconSlash.classList.add('hidden');
            iconEye.classList.remove('hidden');
            warnText.textContent = 'Akun akan diaktifkan kembali dan data institusinya akan muncul di direktori publik.';
        } else {
            titleEl.textContent = 'Konfirmasi Sembunyikan Akun (Hide)';
            descEl.textContent = 'Sembunyikan akun untuk';
            submitBtn.textContent = 'Sembunyikan User';
            submitBtn.className = 'px-4.5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-[13px] shadow-xs transition cursor-pointer';
            iconSlash.classList.remove('hidden');
            iconEye.classList.add('hidden');
            warnText.textContent = 'Akun yang disembunyikan (belum perpanjang membership) tidak akan tampil di direktori publik dan dinonaktifkan sementara.';
        }

        document.getElementById('modal-toggle-hide-user').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeToggleHideModal() {
        document.getElementById('modal-toggle-hide-user').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    function openAddModal() {
        document.getElementById('modal-add-user').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAddModal() {
        document.getElementById('modal-add-user').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openEditModal(user) {
        const form = document.getElementById('form-edit-user');
        form.action = `{{ url('/admin/users') }}/${user.id}`;
        
        document.getElementById('edit_name').value = user.name || '';
        document.getElementById('edit_email').value = user.email || '';
        document.getElementById('edit_password').value = '';
        
        let roleVal = (user.role || 'user').toLowerCase();
        document.getElementById('edit_role').value = roleVal;

        let statusVal = (user.status || 'active').toLowerCase();
        document.getElementById('edit_status').value = statusVal;

        document.getElementById('modal-edit-user').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditModal() {
        document.getElementById('modal-edit-user').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openDeleteModal(id, name, email) {
        window.confirmDelete(`{{ url('/admin/users') }}/${id}`, `${name} (${email})`, {
            title: 'Konfirmasi Hapus User',
            warning: 'Peringatan: Tindakan ini permanen dan data user tidak dapat dikembalikan.'
        });
    }

    function closeDeleteModal() {
        window.closeGlobalDeleteModal();
    }

    function openFilterModal() {
        document.getElementById('modal-filter').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeFilterModal() {
        document.getElementById('modal-filter').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endpush
@endsection
