@extends('layouts.app')

@section('title', 'Profil Saya — IndoTech')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Profil Saya</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola data akun dan password Anda.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('applications.index') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white hover:bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 transition">
                    Lamaran Saya
                </a>
                <a href="{{ route('career.index') }}"
                   class="inline-flex items-center justify-center rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition">
                    Cari Lowongan
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center text-xl font-extrabold shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <h2 class="text-lg font-bold text-slate-900 truncate">{{ $user->name }}</h2>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200">
                            {{ ucfirst($user->status) }}
                        </span>
                        <span class="text-xs text-slate-500">
                            Bergabung {{ $user->created_at?->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm">
                <h2 class="text-base font-bold text-slate-900">Data Akun</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui nama tampilan Anda.</p>

                <form method="POST" action="{{ route('profile.update') }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required maxlength="100"
                               class="w-full rounded-xl border px-3.5 py-2.5 text-sm focus:outline-none {{ $errors->has('name') ? 'border-red-300 focus:border-red-400' : 'border-slate-200 focus:border-blue-500' }}">
                        @error('name')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                        <input type="email" id="email" value="{{ $user->email }}" readonly
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-500">
                        <p class="text-xs text-slate-500 mt-1.5">Email dipakai untuk login dan verifikasi akun.</p>
                    </div>

                    <button type="submit"
                            class="rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition">
                        Simpan Profil
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-sm">
                <h2 class="text-base font-bold text-slate-900">Ganti Password</h2>
                <p class="text-sm text-slate-500 mt-1">Gunakan minimal 8 karakter.</p>

                <form method="POST" action="{{ route('profile.password') }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" required autocomplete="current-password"
                               class="w-full rounded-xl border px-3.5 py-2.5 text-sm focus:outline-none {{ $errors->has('current_password') ? 'border-red-300 focus:border-red-400' : 'border-slate-200 focus:border-blue-500' }}">
                        @error('current_password')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password Baru</label>
                        <input type="password" name="password" id="password" required autocomplete="new-password"
                               class="w-full rounded-xl border px-3.5 py-2.5 text-sm focus:outline-none {{ $errors->has('password') ? 'border-red-300 focus:border-red-400' : 'border-slate-200 focus:border-blue-500' }}">
                        @error('password')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Ulangi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                               class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>

                    <button type="submit"
                            class="rounded-xl bg-slate-900 hover:bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition">
                        Perbarui Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
