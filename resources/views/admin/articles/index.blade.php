@extends('admin.layouts.app')

@section('title', 'Article Management — Admin')

@section('content')
{{-- Breadcrumb --}}
<nav class="text-[13px] text-slate-500 mb-4">
    <span class="hover:text-blue-600 cursor-pointer">Home</span>
    <span class="mx-1.5">›</span>
    <span class="text-slate-900 font-medium">Articles</span>
</nav>

{{-- Header + Create button --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-[24px] font-bold text-slate-900">Article Management</h1>
        <p class="text-[13.5px] text-slate-500 mt-0.5">Manage all articles on the platform</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-[#0b57d0] text-white text-[13.5px] font-semibold hover:bg-blue-700 shadow-sm transition">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Create New Article
    </a>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
        $stats = [
            ['label' => 'Total Articles', 'value' => '1,284', 'delta' => '+12%', 'up' => true,  'icon' => 'articles', 'bg' => 'bg-blue-50',   'fg' => 'text-blue-600'],
            ['label' => 'Published',      'value' => '942',   'delta' => '+5%',  'up' => true,  'icon' => 'check',    'bg' => 'bg-emerald-50','fg' => 'text-emerald-600'],
            ['label' => 'Drafts',         'value' => '215',   'delta' => '0%',   'up' => null,  'icon' => 'draft',    'bg' => 'bg-orange-50', 'fg' => 'text-orange-500'],
            ['label' => 'Total Views',    'value' => '1.2M',  'delta' => '+24%', 'up' => true,  'icon' => 'views',    'bg' => 'bg-violet-50', 'fg' => 'text-violet-600'],
        ];
    @endphp
    @foreach ($stats as $s)
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="w-10 h-10 rounded-lg {{ $s['bg'] }} {{ $s['fg'] }} flex items-center justify-center">
                    @if ($s['icon'] === 'articles')
                        <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h6"/></svg>
                    @elseif ($s['icon'] === 'check')
                        <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/></svg>
                    @elseif ($s['icon'] === 'draft')
                        <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4a1 1 0 0 0 1 1h4M6 21h12a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2zm4-6h4"/></svg>
                    @elseif ($s['icon'] === 'views')
                        <svg width="19" height="19" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                    @endif
                </div>
                <span class="inline-flex items-center gap-0.5 text-[12.5px] font-semibold {{ $s['up'] === true ? 'text-emerald-600' : ($s['up'] === false ? 'text-red-500' : 'text-slate-400') }}">
                    {{ $s['delta'] }}
                    @if ($s['up'] !== null)
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="{{ $s['up'] ? '' : 'rotate-180' }}"><path d="M7 17 17 7m0 0H8m9 0v9"/></svg>
                    @endif
                </span>
            </div>
            <div class="mt-3 text-[24px] font-extrabold text-slate-900 leading-none">{{ $s['value'] }}</div>
            <div class="mt-1.5 text-[13px] text-slate-500">{{ $s['label'] }}</div>
        </div>
    @endforeach
</div>

{{-- Table: Recent Articles --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <div>
            <h2 class="text-[16px] font-bold text-slate-900">Recent Articles</h2>
            <p class="text-[12.5px] text-slate-500">Latest published and drafted content</p>
        </div>
        <select class="h-9 px-3 rounded-lg border border-slate-200 bg-white text-[13px] text-slate-600 focus:outline-none focus:border-blue-500">
            <option>All Categories</option>
            <option>Technology</option>
            <option>Education</option>
            <option>Career</option>
            <option>News</option>
            <option>Press Release</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-[11.5px] uppercase tracking-wider text-slate-500">
                    <th class="px-5 py-3 font-semibold">Title</th>
                    <th class="px-5 py-3 font-semibold">Category</th>
                    <th class="px-5 py-3 font-semibold">Author</th>
                    <th class="px-5 py-3 font-semibold">Publish Date</th>
                    <th class="px-5 py-3 font-semibold">Status</th>
                    <th class="px-5 py-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-[13.5px]">
                @php
                    $rows = [
                        ['title' => 'The Future of EdTech in Indonesia', 'cat' => 'Technology',   'author' => 'Budi Santoso',  'init' => 'BS', 'color' => 'bg-blue-100 text-blue-700',  'date' => 'Oct 24, 2024', 'status' => 'Published', 'st' => 'bg-emerald-50 text-emerald-600 before:bg-emerald-500'],
                        ['title' => 'Navigating the New Curriculum',    'cat' => 'Education',    'author' => 'Dewi Lestari',  'init' => 'DL', 'color' => 'bg-violet-100 text-violet-700', 'date' => 'Oct 22, 2024', 'status' => 'Published', 'st' => 'bg-emerald-50 text-emerald-600 before:bg-emerald-500'],
                        ['title' => 'Top 10 Vocational Skills for 2024', 'cat' => 'Career',       'author' => 'Andi Rahman',   'init' => 'AR', 'color' => 'bg-orange-100 text-orange-700','date' => '—',           'status' => 'Draft',    'st' => 'bg-orange-50 text-orange-600 before:bg-orange-500'],
                        ['title' => 'Quarterly Education Report Release','cat' => 'News',        'author' => 'Budi Santoso',  'init' => 'BS', 'color' => 'bg-blue-100 text-blue-700',  'date' => 'Oct 15, 2024', 'status' => 'Archived', 'st' => 'bg-slate-100 text-slate-600 before:bg-slate-400'],
                        ['title' => 'Partnership: IndoTech & Telkom',    'cat' => 'Press Release','author' => 'Siti Aminah',  'init' => 'SA', 'color' => 'bg-emerald-100 text-emerald-700','date' => 'Oct 12, 2024','status' => 'Published', 'st' => 'bg-emerald-50 text-emerald-600 before:bg-emerald-500'],
                    ];
                @endphp
                @foreach ($rows as $r)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-5 py-4 font-medium text-slate-900 max-w-[280px] truncate">{{ $r['title'] }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $r['cat'] }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-2">
                                <span class="w-7 h-7 rounded-full {{ $r['color'] }} flex items-center justify-center text-[11px] font-bold">{{ $r['init'] }}</span>
                                <span class="text-slate-700">{{ $r['author'] }}</span>
                            </span>
                        </td>
                        <td class="px-5 py-4 text-slate-500">{{ $r['date'] }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[12px] font-semibold {{ $r['st'] }} before:content-[''] before:w-1.5 before:h-1.5 before:rounded-full">{{ $r['status'] }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.articles.edit', 1) }}" class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition" aria-label="Edit">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                </a>
                                <a href="#" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" aria-label="Delete">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14zM10 11v6m4-6v6"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 py-4 border-t border-slate-100">
        <span class="text-[12.5px] text-slate-500">Showing 1 to 5 of 1,284 entries</span>
        <div class="flex items-center gap-1">
            <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 flex items-center justify-center transition" aria-label="Previous">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m15 6-6 6 6 6"/></svg>
            </button>
            <button class="w-8 h-8 rounded-lg bg-[#0b57d0] text-white text-[13px] font-semibold flex items-center justify-center">1</button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-[13px] flex items-center justify-center transition">2</button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-[13px] flex items-center justify-center transition">3</button>
            <span class="px-1 text-slate-400 text-[13px]">…</span>
            <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-[13px] flex items-center justify-center transition">257</button>
            <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 flex items-center justify-center transition" aria-label="Next">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 6 6 6-6 6"/></svg>
            </button>
        </div>
    </div>
</div>
@endsection
