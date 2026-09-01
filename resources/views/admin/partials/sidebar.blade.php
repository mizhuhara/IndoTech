<aside class="w-64 shrink-0 bg-white border-r border-slate-200 flex flex-col justify-between h-screen sticky top-0">
    <div>
        {{-- Logo --}}
        <div class="px-6 pt-6 pb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-[22px] font-extrabold text-slate-900 tracking-tight block">
                IndoTech
            </a>
        </div>

        {{-- New Record Button --}}
        <div class="px-4 pt-2 pb-4">
            <a href="{{ route('admin.schools.create') }}" class="w-full flex items-center justify-center gap-2 h-11 rounded-full bg-[#0b57d0] text-white text-[13.5px] font-semibold hover:bg-blue-700 shadow-sm transition">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                New Record
            </a>
        </div>

        {{-- Nav --}}
        <nav class="px-3 py-2 space-y-1 overflow-y-auto max-h-[calc(100vh-210px)]">
            @php
                $isUserAndVerification = request()->routeIs('admin.users.*') || request()->routeIs('admin.verification.*');
                $menu = [
                    [
                        'label' => 'Dashboard',
                        'icon' => 'grid',
                        'active' => request()->routeIs('admin.dashboard'),
                        'href' => route('admin.dashboard')
                    ],
                    [
                        'label' => 'Users and Verification',
                        'icon' => 'users',
                        'active' => $isUserAndVerification,
                        'href' => route('admin.users.index'),
                        'arrow' => true,
                        'is_group' => true
                    ],
                    [
                        'label' => 'School',
                        'icon' => 'school',
                        'active' => request()->routeIs('admin.schools.*'),
                        'href' => route('admin.schools.index')
                    ],
                    [
                        'label' => 'Universities',
                        'icon' => 'university',
                        'active' => request()->routeIs('admin.univ.*'),
                        'href' => route('admin.univ.index')
                    ],
                    [
                        'label' => 'Company',
                        'icon' => 'company',
                        'active' => false,
                        'href' => '#'
                    ],
                    [
                        'label' => 'Jobs',
                        'icon' => 'jobs',
                        'active' => request()->routeIs('admin.jobs.*'),
                        'href' => route('admin.jobs.index')
                    ],
                    [
                        'label' => 'Internships',
                        'icon' => 'internship',
                        'active' => request()->routeIs('admin.internships.*'),
                        'href' => route('admin.internships.index')
                    ],
                    [
                        'label' => 'Event',
                        'icon' => 'events',
                        'active' => request()->routeIs('admin.events.*'),
                        'href' => route('admin.events.index')
                    ],
                    [
                        'label' => 'Articles',
                        'icon' => 'articles',
                        'active' => request()->routeIs('admin.articles.*'),
                        'href' => route('admin.articles.index')
                    ],
                    [
                        'label' => 'Community',
                        'icon' => 'community',
                        'active' => false,
                        'href' => '#'
                    ],
                    [
                        'label' => 'Reports',
                        'icon' => 'reports',
                        'active' => request()->routeIs('admin.reports.*'),
                        'href' => route('admin.reports.index')
                    ],
                ];
            @endphp

            @foreach ($menu as $item)
                @if (!empty($item['is_group']))
                    <div class="space-y-1">
                        <button type="button" 
                                onclick="toggleSubmenu('user-verification-submenu', 'user-verification-arrow')"
                                class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13.5px] font-medium transition cursor-pointer select-none relative group
                                       {{ $item['active'] ? 'bg-blue-50 text-[#0b57d0] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            @if ($item['active'])
                                <span class="absolute right-0 top-1.5 bottom-1.5 w-1 bg-[#0b57d0] rounded-l"></span>
                            @endif
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20c1.2-3.2 3.7-4.8 6.5-4.8s5.3 1.6 6.5 4.8"/><path stroke-linecap="round" d="M16 5.5a3 3 0 0 1 0 5.8M18.5 15.6c1.2 1.1 2 2.4 2.6 4.4"/></svg>
                            <span class="flex-1 text-left">{{ $item['label'] }}</span>
                            <svg id="user-verification-arrow" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                 class="transition-transform duration-200 {{ $item['active'] ? 'rotate-180 text-[#0b57d0]' : 'text-slate-400' }}">
                                <path d="m8 10 4 4 4-4"/>
                            </svg>
                        </button>
                        {{-- Submenu Items --}}
                        <div id="user-verification-submenu" class="pl-8 pr-2 space-y-1 {{ $item['active'] ? '' : 'hidden' }} transition-all duration-200">
                            <a href="{{ route('admin.users.index') }}" 
                               class="flex items-center px-3 py-2 rounded-lg text-[13px] font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-[#0b57d0] text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                Manage Users
                            </a>
                            <a href="{{ route('admin.verification.index') }}" 
                               class="flex items-center px-3 py-2 rounded-lg text-[13px] font-medium transition {{ request()->routeIs('admin.verification.*') ? 'bg-[#0b57d0] text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                Verification
                            </a>
                        </div>
                    </div>
                @else
                    <a href="{{ $item['href'] }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13.5px] font-medium transition relative group
                              {{ $item['active']
                                  ? 'bg-blue-50 text-[#0b57d0] font-semibold'
                                  : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        
                        {{-- Active blue right edge bar indicator --}}
                        @if ($item['active'])
                            <span class="absolute right-0 top-1.5 bottom-1.5 w-1 bg-[#0b57d0] rounded-l"></span>
                        @endif

                        @if ($item['icon'] === 'grid')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                        @elseif ($item['icon'] === 'users')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20c1.2-3.2 3.7-4.8 6.5-4.8s5.3 1.6 6.5 4.8"/><path stroke-linecap="round" d="M16 5.5a3 3 0 0 1 0 5.8M18.5 15.6c1.2 1.1 2 2.4 2.6 4.4"/></svg>
                        @elseif ($item['icon'] === 'school')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5 2 9.5l10 5 10-5-10-5Zm0 7.5v6.5m6-4.5v3.5c0 1.5-2.69 3-6 3s-6-1.5-6-3V12"/></svg>
                        @elseif ($item['icon'] === 'university')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M4 9l8-5 8 5M5 12v6m4.5-6v6m5-6v6M19 12v6M3 21h18"/></svg>
                        @elseif ($item['icon'] === 'company')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/></svg>
                        @elseif ($item['icon'] === 'jobs')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="7" width="18" height="13" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 12h18"/></svg>
                        @elseif ($item['icon'] === 'internship')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/><path stroke-linecap="round" d="M19 8v6m3-3h-6"/></svg>
                        @elseif ($item['icon'] === 'events')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3m8-3v3M4 8h16M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/></svg>
                        @elseif ($item['icon'] === 'articles')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h6"/></svg>
                        @elseif ($item['icon'] === 'community')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 0 0-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 0 1 5.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 0 1 9.288 0M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm6 3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM7 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>
                        @elseif ($item['icon'] === 'reports')
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2zm0 0V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v10m-6 0a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2m0 0V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2z"/></svg>
                        @endif

                        <span class="flex-1">{{ $item['label'] }}</span>

                        @if (! empty($item['arrow']))
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="text-slate-400"><path d="m8 10 4 4 4-4"/></svg>
                        @endif
                    </a>
                @endif
            @endforeach
        </nav>
    </div>

    {{-- Sidebar footer / Logout --}}
    <div class="p-4 border-t border-slate-100">
        <a href="{{ url('/') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[13.5px] font-medium text-slate-600 hover:text-red-600 hover:bg-red-50 transition">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Logout
        </a>
    </div>
</aside>

<script>
    if (typeof window.toggleSubmenu === 'undefined') {
        window.toggleSubmenu = function(submenuId, arrowId) {
            const submenu = document.getElementById(submenuId);
            const arrow = document.getElementById(arrowId);
            if (submenu) {
                submenu.classList.toggle('hidden');
            }
            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        };
    }
</script>
