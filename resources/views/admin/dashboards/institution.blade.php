@extends('admin.layouts.app')

@section('title', $title.' — IndoTech')
@section('header_title', $title)
@section('header_subtitle', $subtitle)

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach ($cards as $card)
        <a href="{{ $card['url'] }}" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs hover:shadow-md hover:border-blue-400 transition block">
            <div class="text-[12px] font-bold tracking-wider text-slate-400 uppercase">{{ $card['label'] }}</div>
            <div class="text-[22px] font-extrabold text-slate-900 leading-tight mt-2">{{ $card['value'] }}</div>
            @if (!empty($card['sub']))
            <div class="text-[12px] text-slate-500 mt-1">{{ $card['sub'] }}</div>
            @endif
            <div class="text-[13px] text-blue-600 font-semibold mt-3">{{ $card['action'] }} →</div>
        </a>
        @endforeach
    </div>
</div>
@endsection