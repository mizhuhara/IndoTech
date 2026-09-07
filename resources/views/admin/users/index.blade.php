@extends('admin.layouts.app')

@section('title', 'User Management — IndoTech Admin')

@section('content')
<div class="space-y-6">

    {{-- SUCCESS POPUP NOTIFICATION --}}
    @if(session('success'))
        <div id="toast-success-notification" 
             class="fixed top-6 right-6 z-50 max-w-md w-full bg-white/95 backdrop-blur-md border border-emerald-200/80 rounded-2xl shadow-2xl shadow-emerald-500/10 p-4 transition-all duration-300 overflow-hidden">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-500/30">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-[14px] font-bold text-slate-900">Berhasil!</h4>
                        <span class="text-[10px] font-semibold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Sukses</span>
                    </div>
                    <p class="text-[13px] font-medium text-slate-600 mt-0.5 leading-snug">{{ session('success') }}</p>
                </div>
                <button type="button" 
                        onclick="closeSuccessToast()" 
                        class="text-slate-400 hover:text-slate-600 transition p-1 rounded-lg hover:bg-slate-100 shrink-0">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-100">
                <div class="h-full bg-emerald-500 transition-all duration-4500 ease-linear w-full" id="toast-progress"></div>
            </div>
        </div>
    @endif

    {{-- ERROR POPUP NOTIFICATION --}}
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm shadow-sm">
            <div class="flex items-center gap-2.5">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-red-600"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 font-bold">&times;</button>
        </div>
    @endif

    {{-- Top Header Section --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                <span class="text-slate-400">›</span>
                <span class="text-slate-900 font-semibold">User Management</span>
            </div>
            <h1 class="text-[24px] font-bold text-slate-900 tracking-tight">User Management</h1>
            <p class="text-[13px] text-slate-500 mt-0.5">Kelola pengguna sistem, peran (role), dan status keaktifan user dalam database.</p>
        </div>

        {{-- Add User Button --}}
        <div>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs shadow-sm transition">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>Tambah User Baru</span>
            </a>
        </div>
    </div>

    {{-- Main Table Card Container --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
        
        {{-- Table Top Bar: Search & Filter Actions --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
            <h2 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                <span>Daftar Pengguna Sistem</span>
                <span class="bg-slate-100 text-slate-600 font-semibold px-2.5 py-0.5 rounded-full text-xs">
                    {{ $users->total() }} Total
                </span>
            </h2>

            {{-- Right Controls: Search, Filter, Reset --}}
            <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
                {{-- Search Form --}}
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex-1 md:w-64 flex items-center gap-2 bg-slate-100/80 focus-within:bg-white border border-transparent focus-within:border-blue-500 rounded-xl px-3 h-9 transition">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400">
                        <circle cx="11" cy="11" r="7"/>
                        <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." class="bg-transparent outline-none text-[13px] text-slate-700 placeholder-slate-400 flex-1 min-w-0">
                    @if(request()->hasAny(['q', 'status', 'role']))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                </form>

                {{-- Filter Modal Trigger --}}
                <button type="button" 
                        onclick="toggleModal('modal-filter')" 
                        class="inline-flex items-center justify-center gap-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-3.5 py-2 rounded-xl text-xs shadow-2xs transition">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L4.35 21l3.39-.62A8.94 8.94 0 0012 21c4.97 0 9-4.03 9-9s-4.03-9-9-9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h3m-4.5 4h6m-3 4h3"/></svg>
                    <span>Filter</span>
                    @if((request('status') && request('status') !== 'all') || (request('role') && request('role') !== 'all'))
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    @endif
                </button>

                @if(request()->hasAny(['q', 'status', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-red-600 hover:text-red-700 font-semibold px-2 py-1">
                        Reset Filter
                    </a>
                @endif
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-50/50 border-y border-slate-100 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                        <th class="py-3.5 px-4 rounded-l-lg">User Name</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Role</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[13px] text-slate-700">
                    @forelse($users as $user)
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
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs shrink-0 border border-blue-200/60">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.users.show', $user) }}" class="font-bold text-slate-900 text-xs sm:text-sm hover:text-blue-600 transition">
                                            {{ $user->name }}
                                        </a>
                                        <div class="text-[11px] text-slate-400 mt-0.5">Joined: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">{{ $user->email }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                <span class="bg-slate-100 text-slate-700 border border-slate-200/80 px-2.5 py-1 rounded-lg text-xs font-medium">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusColor }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    <span>{{ ucfirst($user->status ?? 'Active') }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center justify-center gap-3">
                                    {{-- View Detail --}}
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-slate-400 hover:text-blue-600 transition" title="Lihat Detail">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 123c2.7 5.422 8.5 9 15.014 9 6.514 0 12.315-3.578 15.014-9C29.315 6.578 23.514 3 17.000000000000004 3c-6.514 0-12.314 3.578-15.014 9z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-slate-400 hover:text-amber-600 transition" title="Edit User">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/></svg>
                                    </a>
                                    {{-- Delete Button with Custom Modal Popup --}}
                                    <button type="button" 
                                            onclick="openUserDeleteModal('{{ route('admin.users.destroy', $user) }}', '{{ addslashes($user->name) }}')" 
                                            class="text-slate-400 hover:text-red-600 transition" 
                                            title="Hapus User">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="text-slate-300"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>Tidak ada user yang ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer Pagination --}}
        <div class="mt-6 pt-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>

    </div>

</div>

{{-- MODAL FILTER --}}
<div id="modal-filter" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Filter User</h3>
            <button type="button" onclick="toggleModal('modal-filter')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>
        <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4 text-xs font-medium">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif
            <div>
                <label class="block text-slate-700 mb-1.5 font-semibold">Status Pengguna</label>
                <select name="status" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 outline-none focus:border-blue-600 bg-slate-50 text-slate-800">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block text-slate-700 mb-1.5 font-semibold">Role Pengguna</label>
                <select name="role" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 outline-none focus:border-blue-600 bg-slate-50 text-slate-800">
                    <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>Semua Role</option>
                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="school_admin" {{ request('role') == 'school_admin' ? 'selected' : '' }}>School Admin</option>
                    <option value="university_rep" {{ request('role') == 'university_rep' ? 'selected' : '' }}>University Representative</option>
                    <option value="company_hr" {{ request('role') == 'company_hr' ? 'selected' : '' }}>Company HR</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="toggleModal('modal-filter')" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold shadow-xs hover:bg-blue-700">Terapkan Filter</button>
            </div>
        </form>
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
    function toggleModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.toggle('hidden');
    }

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

    function closeSuccessToast() {
        const toast = document.getElementById('toast-success-notification');
        if (toast) {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-15px)';
            setTimeout(() => toast.remove(), 300);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast-success-notification');
        if (toast) {
            const progress = document.getElementById('toast-progress');
            if (progress) {
                setTimeout(() => progress.style.width = '0%', 50);
            }
            setTimeout(() => closeSuccessToast(), 4500);
        }
    });
</script>
@endsection
