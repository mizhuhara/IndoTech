<aside class="w-64 shrink-0 bg-slate-100 border-r border-slate-200 flex flex-col">
    {{-- Logo --}}
    <div class="px-6 pt-6 pb-4 border-b border-slate-200">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-extrabold text-sm">IT</div>
            <div>
                <div class="text-[15px] font-extrabold text-slate-900 leading-none">IndoTech</div>
                <div class="text-[11px] text-slate-500 mt-0.5">Admin System</div>
            </div>
        </div>
    </div>

    {{-- New Record --}}
    <div class="px-4 pt-4">
        <button class="w-full flex items-center justify-center gap-2 h-10 rounded-lg bg-blue-600 text-white text-[13px] font-semibold hover:bg-blue-700 transition">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
            New Record
        </button>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        @php
            $isUserAndVerification = request()->routeIs('admin.users.*') || request()->routeIs('admin.verification.*');
            $menu = [
                ['label' => 'Dashboard', 'icon' => 'grid', 'active' => request()->routeIs('admin.dashboard'), 'href' => route('admin.dashboard')],
                ['label' => 'User and Verification', 'icon' => 'users', 'active' => $isUserAndVerification, 'href' => route('admin.users.index'), 'arrow' => true, 'is_group' => true],
                ['label' => 'School', 'icon' => 'school', 'active' => false, 'href' => '#'],
                ['label' => 'University', 'icon' => 'university', 'active' => false, 'href' => '#'],
                ['label' => 'Company', 'icon' => 'company', 'active' => false, 'href' => '#'],
                ['label' => 'Jobs', 'icon' => 'jobs', 'active' => false, 'href' => '#'],
                ['label' => 'Internship', 'icon' => 'internship', 'active' => false, 'href' => '#'],
                ['label' => 'Events', 'icon' => 'events', 'active' => false, 'href' => '#'],
                ['label' => 'Articles', 'icon' => 'articles', 'active' => false, 'href' => '#'],
                ['label' => 'Community', 'icon' => 'community', 'active' => false, 'href' => '#'],
                ['label' => 'Reports', 'icon' => 'reports', 'active' => false, 'href' => '#'],
            ];
        @endphp

        @foreach ($menu as $item)
            @if (!empty($item['is_group']))
                <div class="space-y-1">
                    <button type="button" 
                            onclick="toggleSubmenu('user-verification-submenu', 'user-verification-arrow')"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13.5px] font-medium transition cursor-pointer select-none
                                   {{ $item['active'] ? 'text-blue-600 font-bold bg-blue-50/50' : 'text-slate-700 hover:bg-slate-200/70 hover:text-slate-900' }}">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="9" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 20c1.2-3.2 3.7-4.8 6.5-4.8s5.3 1.6 6.5 4.8"/><path stroke-linecap="round" d="M16 5.5a3 3 0 0 1 0 5.8M18.5 15.6c1.2 1.1 2 2.4 2.6 4.4"/></svg>
                        <span class="flex-1 text-left">{{ $item['label'] }}</span>
                        <svg id="user-verification-arrow" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                             class="transition-transform duration-200 {{ $item['active'] ? 'rotate-180 text-blue-600 opacity-100' : 'opacity-60' }}">
                            <path d="m8 10 4 4 4-4"/>
                        </svg>
                    </button>
                    {{-- Submenu Items --}}
                    <div id="user-verification-submenu" class="pl-8 space-y-1 {{ $item['active'] ? '' : 'hidden' }} transition-all duration-200">
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-[13px] font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-sm font-bold' : 'text-slate-600 hover:bg-slate-200/70 hover:text-slate-900' }}">
                            Manage Users
                        </a>
                        <a href="{{ route('admin.verification.index') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-[13px] font-semibold transition {{ request()->routeIs('admin.verification.*') ? 'bg-blue-600 text-white shadow-sm font-bold' : 'text-slate-600 hover:bg-slate-200/70 hover:text-slate-900' }}">
                            Verification
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ $item['href'] }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13.5px] font-medium transition
                          {{ $item['active']
                              ? 'bg-blue-600 text-white shadow-sm'
                              : 'text-slate-700 hover:bg-slate-200/70 hover:text-slate-900' }}">
                    @if ($item['icon'] === 'grid')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                    @elseif ($item['icon'] === 'school')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6"/></svg>
                    @elseif ($item['icon'] === 'university')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M4 9l8-5 8 5M5 12v6m4.5-6v6m5-6v6M19 12v6M3 21h18"/></svg>
                    @elseif ($item['icon'] === 'company')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-linecap="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/></svg>
                    @elseif ($item['icon'] === 'jobs')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="3" y="7" width="18" height="13" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 12h18"/></svg>
                    @elseif ($item['icon'] === 'internship')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><rect x="3" y="5" width="18" height="16" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M8 3v4m8-4v4"/></svg>
                    @elseif ($item['icon'] === 'events')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M5 4h14a2 2 0 0 1 2 2v14H3V6a2 2 0 0 1 2-2zm3 8h8m-8 4h5"/></svg>
                    @elseif ($item['icon'] === 'articles')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12a1 1 0 0 1 1 1v17l-4-2.5L11 21l-6-3V4a1 1 0 0 1 1-1z"/><path stroke-linecap="round" d="M9 8h6m-6 4h6"/></svg>
                    @elseif ($item['icon'] === 'community')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="8" cy="9" r="3"/><circle cx="16" cy="10" r="2.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.5 19c1-2.5 3-3.8 5.5-3.8s4.5 1.3 5.5 3.8M14.5 15.4c2.6-.2 4.7 1 5.7 3.6"/></svg>
                    @elseif ($item['icon'] === 'reports')
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M4 20V10m5 10V4m5 16v-7m5 7V8"/></svg>
                    @endif
                    <span class="flex-1">{{ $item['label'] }}</span>
                    @if (! empty($item['arrow']))
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="opacity-60"><path d="m8 10 4 4 4-4"/></svg>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>

    {{-- Sidebar footer --}}
    <div class="px-4 py-4 border-t border-slate-200">
        <div class="flex items-center gap-2 text-[12px] text-slate-500">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
            v1.0.0
        </div>
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

