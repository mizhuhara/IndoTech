@extends('admin.layouts.app')

@section('title', ($community['name'] ?? 'Community Details') . ' — IndoTech')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    
    {{-- Top Back Link & Breadcrumb --}}
    <div>
        <a href="{{ route('admin.community.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-700 hover:text-blue-600 mb-2 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <div class="text-[13px] text-slate-500 mb-1 flex items-center gap-1.5 font-medium">
            <a href="{{ route('admin.community.index') }}" class="hover:text-blue-600 transition">Community</a>
            <span class="text-slate-400">›</span>
            <span class="text-slate-900 font-semibold">{{ $community['name'] ?? 'Detail' }}</span>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-2">
            <h1 class="text-[26px] font-bold text-slate-900 tracking-tight">{{ $community['name'] ?? 'Community Details' }}</h1>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.community.edit', $community['id']) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-[13.5px] font-semibold transition">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit
                </a>
                
                <form method="POST" action="{{ route('admin.community.destroy', $community['id']) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komunitas ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 text-[13.5px] font-semibold transition">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            <line x1="10" y1="11" x2="10" y2="17"/>
                            <line x1="14" y1="11" x2="14" y2="17"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN (8 cols) --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Card 1: Basic Information --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-6 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-5">
                    <div>
                        <div class="text-[13px] font-semibold text-slate-500 mb-1">Category</div>
                        <div class="text-[15px] font-bold text-slate-900">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-bold bg-blue-50 text-[#0b57d0]">
                                {{ $community['category'] ?? '-' }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-[13px] font-semibold text-slate-500 mb-1">Total Members</div>
                        <div class="text-[15px] font-bold text-slate-900">
                            {{ number_format($community['members'] ?? 0, 0, ',', '.') }} Members
                        </div>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <div class="text-[13px] font-semibold text-slate-500 mb-1">Status</div>
                        <div>
                            @if(($community['status'] ?? 'active') === 'active')
                                <span class="inline-flex items-center gap-1.5 text-[14px] font-bold text-slate-800">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                    Active Community
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[14px] font-bold text-slate-800">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Community Description --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-5 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Description</h2>
                </div>
                
                <div class="text-[14px] text-slate-700 leading-relaxed bg-[#f0f4f9]/50 rounded-xl p-5">
                    {{ $community['description'] ?? 'Belum ada deskripsi.' }}
                </div>
            </div>

            {{-- Card 3: Gallery --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-5 text-slate-900">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#0b57d0" stroke-width="2" class="shrink-0">
                        <rect x="3" y="3" width="18" height="18" rx="3"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21"/>
                    </svg>
                    <h2 class="text-[17px] font-bold text-slate-900">Community Gallery</h2>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="aspect-square rounded-2xl bg-[#f0f4f9] border border-slate-200/60 flex items-center justify-center text-slate-300">
                            <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21"/>
                            </svg>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN (4 cols) --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Card 1: Logo Preview --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs flex flex-col items-center text-center">
                <h2 class="text-[17px] font-bold text-slate-900 self-start mb-5">Community Logo</h2>
                
                <div class="w-full aspect-[4/3] rounded-2xl bg-[#f0f4f9] border border-slate-200/70 flex items-center justify-center p-6 mb-4 relative overflow-hidden">
                    <div class="w-24 h-24 rounded-full bg-blue-50 flex items-center justify-center shadow-sm border border-white text-[#0b57d0] font-extrabold text-3xl overflow-hidden">
                        @if(!empty($community['logo_url']))
                            <img src="{{ $community['logo_url'] }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            {{ substr($community['name'] ?? 'C', 0, 1) }}
                        @endif
                    </div>
                </div>
            </div>

            {{-- Card 2: Contact Info --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <h2 class="text-[17px] font-bold text-slate-900 mb-5">Contact Information</h2>

                <div class="space-y-5">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-slate-400">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[13px] font-semibold text-slate-500 mb-0.5">Email</div>
                            <div class="text-[14px] font-bold text-slate-900">{{ $community['email'] ?? '-' }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-slate-400">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-[13px] font-semibold text-slate-500 mb-0.5">Website</div>
                            @if(!empty($community['website']))
                                <a href="{{ $community['website'] }}" target="_blank" class="text-[14px] font-bold text-blue-600 hover:underline">{{ $community['website'] }}</a>
                            @else
                                <div class="text-[14px] font-bold text-slate-900">-</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Meta Information --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                <h2 class="text-[17px] font-bold text-slate-900 mb-4">Metadata</h2>
                <div class="space-y-4">
                    <div>
                        <div class="text-[13px] font-semibold text-slate-500 mb-0.5">Registered Date</div>
                        <div class="text-[14px] font-bold text-slate-800">{{ $community['created_at'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-[13px] font-semibold text-slate-500 mb-0.5">Last Updated</div>
                        <div class="text-[14px] font-bold text-slate-800">{{ $community['updated_at'] ?? '-' }}</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
