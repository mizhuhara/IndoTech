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
                            @if ($community->type)
                                <span class="bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full border border-indigo-200/60 inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        @if($community->type === 'private')
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        @endif
                                    </svg>
                                    {{ $community->type === 'private' ? 'Privat' : 'Publik' }}
                                </span>
                            @endif
                            @if ($community->location)
                                <span class="bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-1 rounded-full inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $community->location }}
                                </span>
                            @endif
                            @if ($community->language)
                                <span class="bg-slate-100 text-slate-700 text-xs font-semibold px-3 py-1 rounded-full inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                    </svg>
                                    {{ $community->language }}
                                </span>
                            @endif
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

                    @if ($isOwnerOrAdmin)
                        <a href="{{ route('community.manage', $community) }}"
                           class="w-full sm:w-auto text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition inline-flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Kelola Komunitas
                        </a>
                    @endif

                    @if ($community->website)
                        <a href="{{ $community->website }}" target="_blank" rel="noopener noreferrer"
                           class="w-full sm:w-auto text-center border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-5 rounded-xl text-sm transition">
                            Kunjungi Website
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if ($community->rules)
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 text-slate-900 font-bold text-lg mb-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <h2>Aturan Komunitas</h2>
                </div>
                <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line bg-slate-50/70 p-4 rounded-2xl border border-slate-100">
                    {{ $community->rules }}
                </div>
            </div>
        @endif

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

        {{-- Postingan & Diskusi Komunitas --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Diskusi Komunitas</h2>
                    <p class="text-sm text-slate-500 mt-1">Wadah berbagi ilmu, tanya jawab, dan diskusi sesama anggota.</p>
                </div>
                @if ($isOwnerOrAdmin)
                    <a href="{{ route('community.manage', $community) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-200 transition">
                        Moderasi Postingan
                    </a>
                @endif
            </div>

            {{-- Form Kirim Postingan Baru (Jika Member / Owner) --}}
            @auth
                @if ($isMember || $isOwnerOrAdmin)
                    <form action="{{ route('community.posts.store', $community) }}" method="POST" class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 mb-8">
                        @csrf
                        <div class="space-y-3">
                            <input type="text" name="title" placeholder="Judul diskusi (opsional)" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-800 outline-none focus:border-blue-500">
                            <textarea name="content" rows="3" placeholder="Tuliskan pertanyaan, ide, atau topik diskusi di komunitas ini..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:border-blue-500" required></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs py-2 px-5 rounded-xl transition">
                                    Kirim Diskusi
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            @endauth

            {{-- Daftar Postingan --}}
            @if(isset($posts) && $posts->isNotEmpty())
                <div class="space-y-4">
                    @foreach($posts as $post)
                        <div class="p-4 sm:p-5 rounded-2xl border border-slate-100 bg-slate-50/50">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($post->user?->name ?: 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">{{ $post->user?->name ?: 'Anggota' }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $post->created_at?->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            @if($post->title)
                                <h3 class="text-sm font-bold text-slate-900 mt-1 mb-1">{{ $post->title }}</h3>
                            @endif
                            <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">{{ $post->content }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-500 italic py-2">Belum ada diskusi di komunitas ini. Mulailah percakapan pertama!</p>
            @endif
        </div>
    </div>
</div>
@endsection
