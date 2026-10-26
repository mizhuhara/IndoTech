@extends('layouts.app')

@section('title', $community->name . ' — Komunitas IndoTech')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div>
            <a href="{{ route('community.index') }}"
               class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-blue-600 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Komunitas
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            @if ($community->cover_url)
                <div class="h-40 sm:h-56 bg-slate-100 overflow-hidden">
                    <img src="{{ $community->cover_url }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start gap-5">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-2xl font-extrabold overflow-hidden shrink-0">
                        @if ($community->logo_url)
                            <img src="{{ $community->logo_url }}" alt="{{ $community->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($community->name, 0, 2)) }}
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $community->category }}
                            </span>
                            <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full border border-emerald-200/60">
                                Aktif
                            </span>
                            @if ($isMember)
                                <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full border border-blue-200/60">
                                    Anda anggota
                                </span>
                            @endif
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-3">
                            {{ $community->name }}
                        </h1>

                        <p class="text-sm text-slate-600 leading-relaxed mt-3">
                            {{ $community->description ?: 'Belum ada deskripsi komunitas.' }}
                        </p>

                        @if (! empty($community->tags))
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach ($community->tags as $tag)
                                    <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg">#{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-8 pt-6 border-t border-slate-100">
                    <div>
                        <p class="text-lg font-extrabold text-slate-900">{{ number_format($community->members) }}</p>
                        <p class="text-xs text-slate-500">Anggota</p>
                    </div>
                    <div>
                        <p class="text-lg font-extrabold text-slate-900">{{ $memberUsers->count() }}</p>
                        <p class="text-xs text-slate-500">Anggota platform terbaru</p>
                    </div>
                    <div>
                        <p class="text-lg font-extrabold text-slate-900">{{ $community->created_at?->format('Y') }}</p>
                        <p class="text-xs text-slate-500">Bergabung sejak</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 mt-8">
                    @auth
                        @if ($isMember)
                            <form action="{{ route('community.leave', $community) }}" method="POST"
                                  onsubmit="return confirm('Keluar dari komunitas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full sm:w-auto border border-red-200 bg-white text-red-600 hover:bg-red-50 font-semibold py-2.5 px-5 rounded-xl text-sm transition">
                                    Keluar dari Komunitas
                                </button>
                            </form>
                        @else
                            <form action="{{ route('community.join', $community) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition">
                                    Gabung Komunitas
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full sm:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition">
                            Masuk untuk Bergabung
                        </a>
                    @endauth

                    @if ($community->website)
                        <a href="{{ $community->website }}" target="_blank" rel="noopener noreferrer"
                           class="w-full sm:w-auto text-center border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-5 rounded-xl text-sm transition">
                            Kunjungi Website
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">Anggota Platform</h2>
            <p class="text-sm text-slate-500 mt-1">Talenta IndoTech yang sudah bergabung di komunitas ini.</p>

            @if ($memberUsers->isEmpty())
                <p class="text-sm text-slate-500 mt-6">Belum ada anggota platform. Jadilah yang pertama bergabung.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mt-6">
                    @foreach ($memberUsers as $member)
                        <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/60 px-3 py-2.5">
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                {{ strtoupper(substr($member->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">
                                    {{ $member->name }}
                                    @if (auth()->id() === $member->id)
                                        <span class="text-xs font-normal text-blue-600">(Anda)</span>
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500 truncate">{{ ucfirst($member->role) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
