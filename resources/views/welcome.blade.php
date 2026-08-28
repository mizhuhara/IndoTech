@extends('layouts.app')

@section('title', 'IndoTech — Platform Magang & Beasiswa')

@section('content')
    {{-- HERO --}}
    <section id="beranda" class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600"></div>
        <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute -bottom-32 right-0 h-80 w-80 rounded-full bg-cyan-300/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-6xl px-4 py-20 text-center text-white md:py-28">
            <span class="inline-block rounded-full bg-white/15 px-4 py-1.5 text-xs font-semibold tracking-wide backdrop-blur">
                Platform Magang, Beasiswa & Volunteer Indonesia
            </span>
            <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-extrabold leading-tight md:text-6xl">
                Temukan Program Magang & Beasiswa Impianmu
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-slate-100">
                Ribuan peluang dari perusahaan, kampus, dan organisasi terpercaya tersedia untuk membantu kamu mengembangkan karier.
            </p>

            {{-- Search --}}
            <form class="mx-auto mt-10 flex max-w-2xl flex-col gap-3 rounded-2xl bg-white p-2 text-left shadow-xl sm:flex-row sm:items-center">
                <input type="text" placeholder="Cari program, perusahaan, atau kata kunci..."
                    class="flex-1 rounded-xl border-0 bg-transparent px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400">
                <select class="rounded-xl border-0 bg-slate-100 px-4 py-3 text-sm font-medium text-slate-700 outline-none">
                    <option>Semua Kategori</option>
                    <option>Teknologi</option>
                    <option>Bisnis</option>
                    <option>Desain</option>
                    <option>Pendidikan</option>
                </select>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white hover:bg-emerald-700">
                    Cari
                </button>
            </form>

            <div class="mt-12 grid grid-cols-2 gap-6 sm:grid-cols-4">
                <div>
                    <p class="text-3xl font-extrabold">2.500+</p>
                    <p class="mt-1 text-sm text-slate-200">Program Tersedia</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold">1.200+</p>
                    <p class="mt-1 text-sm text-slate-200">Perusahaan Partner</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold">89.000+</p>
                    <p class="mt-1 text-sm text-slate-200">Mahasiswa Terdaftar</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold">4.9/5</p>
                    <p class="mt-1 text-sm text-slate-200">Rating Pengguna</p>
                </div>
            </div>
        </div>
    </section>

    {{-- KATEGORI --}}
    <section id="kategori" class="mx-auto max-w-6xl px-4 py-16">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-slate-900">Jelajahi Berdasarkan Kategori</h2>
            <p class="mt-3 text-slate-500">Pilih bidang yang paling sesuai dengan minat dan keahlianmu</p>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-4 md:grid-cols-4">
            @php
                $kategori = [
                    ['💻', 'Teknologi', '1.200 Program'],
                    ['💼', 'Bisnis & Finance', '850 Program'],
                    ['🎨', 'Desain & Kreatif', '640 Program'],
                    ['📚', 'Pendidikan', '520 Program'],
                    ['⚕️', 'Kesehatan', '310 Program'],
                    ['🔬', 'Sains & Riset', '280 Program'],
                    ['🎭', 'Seni & Media', '240 Program'],
                    ['⚖️', 'Hukum & Politik', '190 Program'],
                ];
            @endphp
            @foreach ($kategori as [$ikon, $nama, $jumlah])
                <a href="#" class="group rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-3xl transition group-hover:bg-emerald-600/10">
                        {{ $ikon }}
                    </div>
                    <h3 class="mt-4 font-bold text-slate-900">{{ $nama }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $jumlah }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- PROGRAM UNGGULAN --}}
    <section id="program" class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900">Program Populer Saat Ini</h2>
                    <p class="mt-3 text-slate-500">Peluang terbaik yang sedang dibuka, jangan sampai terlewat</p>
                </div>
                <a href="#" class="font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua &rarr;</a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @php
                    $program = [
                        [
                            'PT Aplikasi Nusantara', 'Magang Software Engineer',
                            'Jakarta (Hybrid)', '3 bulan', 'Teknologi', 'Dibuka',
                            ['React', 'Laravel', 'SQL'],
                        ],
                        [
                            'Universitas Indonesia', 'Beasiswa S1/ S2 Penuh',
                            'Depok, Jawa Barat', 'Fleksibel', 'Pendidikan', 'Tutup 7 hari lagi',
                            ['S1', 'S2', 'GPA 3.5+'],
                        ],
                        [
                            'BRI Ventures', 'Young Talent Program',
                            'Jakarta (Onsite)', '3 bulan', 'Bisnis', 'Dibuka',
                            ['Analisis', 'Finance', 'Excel'],
                        ],
                    ];
                @endphp
                @foreach ($program as [$penyedia, $judul, $lokasi, $durasi, $kategoriProgram, $status, $tag])
                    <article class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative flex h-36 items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-600 text-5xl font-extrabold text-white">
                            {{ strtoupper(substr($penyedia, 0, 1)) }}
                            <span class="absolute right-3 top-3 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur">{{ $status }}</span>
                        </div>
                        <div class="p-5">
                            <p class="text-sm font-semibold text-emerald-600">{{ $penyedia }}</p>
                            <h3 class="mt-1 text-lg font-bold text-slate-900">{{ $judul }}</h3>
                            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                @foreach ($tag as $t)
                                    <span class="rounded-full bg-slate-100 px-3 py-1 font-medium text-slate-600">{{ $t }}</span>
                                @endforeach
                            </div>
                            <div class="mt-4 flex items-center justify-between border-t border-dashed border-slate-200 pt-4 text-sm text-slate-500">
                                <span>📍 {{ $lokasi }}</span>
                                <span>⏱ {{ $durasi }}</span>
                            </div>
                            <button class="mt-4 w-full rounded-xl bg-slate-900 py-2.5 text-sm font-bold text-white hover:bg-emerald-600 transition">
                                Daftar Sekarang
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-auto max-w-6xl px-4 py-16">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-14 text-center text-white md:px-16">
            <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-cyan-300/20 blur-2xl"></div>
            <h2 class="relative text-3xl font-extrabold md:text-4xl">Siap Memulai Karier Impianmu?</h2>
            <p class="relative mx-auto mt-4 max-w-xl text-emerald-50">
                Daftar gratis sekarang dan mulai melamar program pertama kamu hari ini.
            </p>
            <a href="#" class="relative mt-8 inline-block rounded-xl bg-white px-8 py-3.5 font-bold text-emerald-700 shadow-lg hover:bg-slate-50">
                Buat Akun Gratis
            </a>
        </div>
    </section>
@endsection