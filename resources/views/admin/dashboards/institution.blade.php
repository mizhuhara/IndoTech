@extends('admin.layouts.app')

@section('title', $title.' — IndoTech')

@section('content')
<div class="space-y-6">
    <div>
        <div class="text-[13px] text-slate-500 mb-1">
            <span class="hover:text-blue-600 cursor-pointer">Home</span>
            <span class="mx-1.5">›</span>
            <span class="text-slate-900 font-medium">{{ $title }}</span>
        </div>
        <h1 class="text-[24px] font-bold text-slate-900">{{ $title }}</h1>
        <p class="text-[13.5px] text-slate-500 mt-0.5">{{ $subtitle }}</p>
    </div>

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