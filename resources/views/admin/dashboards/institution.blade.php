@extends('admin.layouts.app')

@section('title', $title.' — IndoTech')
@section('header_title', $title)
@section('header_subtitle', $subtitle)

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach ($cards as $card)
        <a href="{{ $card['url'] }}" class="card hover:shadow-md hover:border-blue-400 transition block group">
            <div class="text-[12px] font-bold tracking-wider text-slate-400 uppercase">{{ $card['label'] }}</div>
            <div class="text-[20px] font-extrabold text-slate-900 leading-tight mt-2 line-clamp-2">{{ $card['value'] }}</div>
            @if (!empty($card['sub']))
            <div class="text-[12px] text-slate-500 mt-1">{{ $card['sub'] }}</div>
            @endif
            <div class="mt-4">
                @if (($card['cta_style'] ?? 'secondary') === 'primary')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-blue-600 text-white text-[13px] font-semibold group-hover:bg-blue-700 transition">
                        {{ $card['action'] }}
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-[13px] text-blue-600 font-semibold group-hover:text-blue-800 transition">
                        {{ $card['action'] }}
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
