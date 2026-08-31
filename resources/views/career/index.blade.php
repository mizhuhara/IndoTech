@extends('layouts.app')

@section('title', 'Career — IndoTech')

@section('content')
<style>
    .cr-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .cr-tabs {
        display: flex;
        gap: 4px;
        border-bottom: 1px solid #e2e8f0;
        overflow-x: auto;
        background: #fff;
        position: sticky;
        top: 62px;
        z-index: 20;
        margin: 0 -24px;
        padding: 0 24px;
    }
    .cr-tabs a {
        flex-shrink: 0;
        padding: 14px 16px;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-bottom: 2.5px solid transparent;
        margin-bottom: -1px;
        white-space: nowrap;
        transition: color 0.15s, border-color 0.15s;
    }
    .cr-tabs a:hover { color: #2563eb; }
    .cr-tabs a.on {
        color: #2563eb;
        border-bottom-color: #2563eb;
    }
    .cr-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
        padding-top: 20px;
        padding-bottom: 40px;
    }
    .cr-sidebar {
        position: sticky;
        top: 115px;
        max-height: calc(100vh - 140px);
        overflow-y: auto;
        padding-right: 8px;
        padding-bottom: 24px;
    }
    .cr-main {
        padding-right: 4px;
        padding-bottom: 24px;
    }
    .cr-sidebar::-webkit-scrollbar { width: 6px; }
    .cr-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 99px;
    }
    .cr-card-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 16px;
        background: #f1f5f9;
    }
    .cr-filter-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .cr-filter-head h2 {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .cr-clear {
        font-size: 12px;
        font-weight: 600;
        color: #2563eb;
        text-decoration: none;
    }
    .cr-clear:hover { text-decoration: underline; }
    .cr-filter-group {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 12px;
    }
    .cr-filter-group h3 {
        font-size: 12px;
        font-weight: 700;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin: 0 0 10px;
    }
    .cr-check {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #334155;
        padding: 5px 0;
        cursor: pointer;
    }
    .cr-check input { accent-color: #2563eb; }
    .cr-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .cr-skill {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 99px;
        padding: 4px 10px;
        cursor: pointer;
        transition: all 0.12s;
    }
    .cr-skill input { display: none; }
    .cr-skill:hover { border-color: #93c5fd; color: #2563eb; }
    .cr-skill.on {
        background: #eff6ff;
        border-color: #2563eb;
        color: #2563eb;
    }
    .cr-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .cr-count {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }
    .cr-count strong { color: #0f172a; }
    .cr-search {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0 12px;
        min-width: 240px;
        flex: 1;
        max-width: 360px;
    }
    .cr-search svg { color: #94a3b8; flex-shrink: 0; }
    .cr-search input {
        border: none;
        outline: none;
        font-size: 13.5px;
        padding: 9px 10px;
        width: 100%;
        font-family: inherit;
        background: transparent;
        color: #334155;
    }
    .cr-list { display: flex; flex-direction: column; gap: 16px; }
    .cr-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .cr-card:hover {
        box-shadow: 0 6px 24px rgba(0,0,0,0.08);
        transform: translateY(-1px);
    }
    .cr-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .cr-logo {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        color: #fff;
    }
    .cr-tag {
        font-size: 11.5px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 5px;
    }
    .cr-tag.jobs { background: #dbeafe; color: #2563eb; }
    .cr-tag.internship { background: #fef3c7; color: #d97706; }
    .cr-tag.freelance { background: #fce7f3; color: #db2777; }
    .cr-tag.remote { background: #d1fae5; color: #059669; }
    .cr-tag.graduate { background: #ede9fe; color: #7c3aed; }
    .cr-card-title {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 2px;
    }
    .cr-card-company {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
    }
    .cr-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px 18px;
        margin-top: 12px;
    }
    .cr-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        color: #64748b;
    }
    .cr-meta-item svg { color: #94a3b8; flex-shrink: 0; }
    .cr-skill-row {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 12px;
    }
    .cr-chip {
        font-size: 11.5px;
        font-weight: 600;
        color: #334155;
        background: #f1f5f9;
        border-radius: 6px;
        padding: 3px 8px;
    }
    .cr-desc {
        font-size: 13.5px;
        color: #475569;
        line-height: 1.65;
        margin: 14px 0 0;
    }
    .cr-card-bottom {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cr-apply {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        background: #2563eb;
        border-radius: 8px;
        text-decoration: none;
        box-shadow: 0 1px 4px rgba(37,99,235,0.25);
        transition: background 0.15s;
    }
    .cr-apply:hover { background: #1d4ed8; }
    .cr-empty {
        text-align: center;
        padding: 64px 24px;
        background: #fff;
        border: 1px dashed #cbd5e1;
        border-radius: 14px;
    }
    .cr-empty h3 {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 6px;
    }
    .cr-empty p { font-size: 14px; color: #64748b; margin: 0; }
    .cr-filter-toggle {
        display: none;
        width: 100%;
        margin-bottom: 12px;
        padding: 10px 14px;
        font-size: 13.5px;
        font-weight: 600;
        color: #2563eb;
        background: #eff6ff;
        border: 1.5px solid #bfdbfe;
        border-radius: 10px;
        cursor: pointer;
        font-family: inherit;
    }
    @media (max-width: 860px) {
        .cr-layout {
            grid-template-columns: 1fr;
            height: auto;
            min-height: 0;
        }
        .cr-sidebar {
            display: none;
            max-height: 60vh;
            overflow-y: auto;
            margin-bottom: 8px;
        }
        .cr-sidebar.open { display: block; }
        .cr-main { overflow: visible; }
        .cr-filter-toggle { display: block; }
        .cr-tabs { top: 62px; }
    }
</style>

<div class="cr-page">
    <nav class="cr-tabs" aria-label="Career categories">
        @foreach($tabs as $key => $label)
            <a href="{{ route('career.index', array_merge(request()->except('type'), ['type' => $key])) }}"
               class="{{ $tab === $key ? 'on' : '' }}"
               id="tab-{{ $key }}">{{ $label }}</a>
        @endforeach
    </nav>

    <div class="cr-layout">
        @include('career._filters')

        <div class="cr-main">
            <button type="button" class="cr-filter-toggle" id="cr-filter-toggle">Show filters</button>

            <div class="cr-toolbar">
                <p class="cr-count"><strong>{{ count($jobs) }}</strong> {{ Str::plural('opening', count($jobs)) }}</p>
                <form class="cr-search" method="GET" action="{{ route('career.index') }}">
                    <input type="hidden" name="type" value="{{ $tab }}">
                    @foreach((array) request('job_type', []) as $v)
                        <input type="hidden" name="job_type[]" value="{{ $v }}">
                    @endforeach
                    @foreach((array) request('experience', []) as $v)
                        <input type="hidden" name="experience[]" value="{{ $v }}">
                    @endforeach
                    @foreach((array) request('salary', []) as $v)
                        <input type="hidden" name="salary[]" value="{{ $v }}">
                    @endforeach
                    @foreach((array) request('skills', []) as $v)
                        <input type="hidden" name="skills[]" value="{{ $v }}">
                    @endforeach
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search title, company, location..." id="career-search">
                </form>
            </div>

            @if(count($jobs) === 0)
                <div class="cr-empty">
                    <h3>No openings match</h3>
                    <p>Clear filters or try another category.</p>
                </div>
            @else
                <div class="cr-list">
                    @foreach($jobs as $job)
                        @include('career._job-card', ['job' => $job, 'tabs' => $tabs])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    (function () {
        var btn = document.getElementById('cr-filter-toggle');
        var side = document.getElementById('cr-sidebar');
        if (btn && side) {
            btn.addEventListener('click', function () {
                side.classList.toggle('open');
                btn.textContent = side.classList.contains('open') ? 'Hide filters' : 'Show filters';
            });
        }
    })();
</script>
@endsection
