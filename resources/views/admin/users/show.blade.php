@extends('admin.layouts.app')

@section('title', 'Detail User — IndoTech Admin')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    @php
        $roleMap = [
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'school_admin' => 'School Admin',
            'university_rep' => 'University Representative',
            'company_hr' => 'Company HR',
            'user' => 'User',
        ];
        $roleName = $roleMap[strtolower($user->role ?? '')] ?? ucfirst($user->role ?? 'User');

        $statusColorMap = [
            'active' => 'bg-emerald-100 text-emerald-700',
            'pending' => 'bg-amber-100 text-amber-700',
            'inactive' => 'bg-red-100 text-red-700',
        ];
        $statusColor = $statusColorMap[strtolower($user->status ?? '')] ?? 'bg-slate-100 text-slate-700';

        $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
    @endphp

    {{-- Top Navigation --}}
    <div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 mb-2 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar User
        </a>

        <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
            <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 transition">User Management</a>
            <span class="text-slate-400">›</span>
            <span class="text-slate-900 font-semibold">Detail User</span>
        </div>

        <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">Detail Pengguna</h1>
    </div>

    {{-- Main Profile Card --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-8 shadow-xs space-y-8">
        
        {{-- Profile Header Banner --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-700 font-bold text-xl flex items-center justify-center border-2 border-blue-200 shadow-xs">
                    {{ $initials }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500 font-medium">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="bg-slate-100 text-slate-800 font-semibold px-2.5 py-0.5 rounded-lg text-xs">
                            {{ $roleName }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColor }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            <span>{{ ucfirst($user->status ?? 'Active') }}</span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-4 py-2.5 rounded-xl text-xs shadow-xs transition">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/></svg>
                    <span>Edit User</span>
                </a>

                <button type="button" 
                        onclick="openUserDeleteModal('{{ route('admin.users.destroy', $user) }}', '{{ addslashes($user->name) }}')"
                        class="inline-flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-4 py-2.5 rounded-xl text-xs transition border border-red-200">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                    <span>Hapus User</span>
                </button>
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- General Info Card --}}
            <div class="space-y-4 bg-slate-50/70 p-5 rounded-xl border border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    <span>Informasi Akun</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block">ID Pengguna</span>
                        <span class="font-bold text-slate-800">#{{ $user->id }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Nama Lengkap</span>
                        <span class="font-semibold text-slate-800">{{ $user->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Email</span>
                        <span class="font-semibold text-slate-800">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Tanggal Bergabung</span>
                        <span class="font-semibold text-slate-800">{{ $user->created_at ? $user->created_at->format('d F Y (H:i)') : '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Organization Info Card --}}
            <div class="space-y-4 bg-slate-50/70 p-5 rounded-xl border border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5v3"/></svg>
                    <span>Informasi Organisasi / Instansi</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block">Kontak Penanggung Jawab</span>
                        <span class="font-semibold text-slate-800">{{ $user->org_contact ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Telepon Organisasi</span>
                        <span class="font-semibold text-slate-800">{{ $user->org_phone ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Alamat Organisasi</span>
                        <span class="font-semibold text-slate-800">{{ $user->org_address ?: '-' }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

{{-- MODAL POPUP KONFIRMASI HAPUS USER --}}
<div id="modal-delete-user" class="fixed inset-0 z-50 hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-7 max-w-md w-full shadow-2xl border border-slate-100 relative space-y-6">
        
        <button type="button" onclick="closeUserDeleteModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 transition p-1 rounded-full hover:bg-slate-100">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div class="flex flex-col items-center text-center space-y-3 pt-2">
            <div class="w-16 h-16 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center ring-8 ring-red-50/60 shadow-xs">
                <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Hapus User Ini?</h3>
                <p class="text-xs text-slate-500 mt-1.5 max-w-xs mx-auto leading-relaxed">
                    Apakah Anda yakin ingin menghapus user <span id="delete-user-name" class="font-bold text-slate-800"></span>? Tindakan ini permanen dan tidak dapat dibatalkan.
                </p>
            </div>
        </div>

        <form id="form-delete-user" method="POST" action="" class="flex items-center gap-3 pt-2">
            @csrf
            @method('DELETE')
            
            <button type="button" 
                    onclick="closeUserDeleteModal()" 
                    class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-3 rounded-2xl text-xs transition">
                Batal
            </button>

            <button type="submit" 
                    class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold px-4 py-3 rounded-2xl text-xs shadow-lg shadow-red-600/25 transition">
                Ya, Hapus User
            </button>
        </form>
    </div>
</div>

<script>
    function openUserDeleteModal(actionUrl, userName) {
        const modal = document.getElementById('modal-delete-user');
        const form = document.getElementById('form-delete-user');
        const nameSpan = document.getElementById('delete-user-name');

        if (modal && form && nameSpan) {
            form.action = actionUrl;
            nameSpan.textContent = '"' + userName + '"';
            modal.classList.remove('hidden');
        }
    }

    function closeUserDeleteModal() {
        const modal = document.getElementById('modal-delete-user');
        if (modal) modal.classList.add('hidden');
    }
</script>
@endsection
