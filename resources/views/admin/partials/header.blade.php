<header class="bg-white border-b border-slate-200/80 px-8 py-3.5 flex items-center justify-end gap-4 sticky top-0 z-30">
    {{-- Right Icons & Profile --}}
    <div class="flex items-center gap-4">
        {{-- Help / Info --}}
        <button type="button" class="p-2 rounded-full text-slate-500 hover:bg-slate-100 transition" aria-label="Help">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="9"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 9a2.5 2.5 0 0 1 4.9.8c0 1.7-2.4 2.2-2.4 3.7m0 3h.01"/>
            </svg>
        </button>

        {{-- Notifications --}}
        <button type="button" class="relative p-2 rounded-full text-slate-500 hover:bg-slate-100 transition" aria-label="Notifications">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.5-1.5V11a5.5 5.5 0 0 0-4-5.3V5a1.5 1.5 0 0 0-3 0v.7a5.5 5.5 0 0 0-4 5.3v4.5L6 17h5m4 0v1a3 3 0 0 1-6 0v-1"/>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>

        <div class="h-7 w-[1px] bg-slate-200 mx-1"></div>

        {{-- Admin Profile Badge --}}
        <div class="flex items-center gap-3 pl-1">
            <div class="text-right hidden sm:block">
                <div class="text-[13px] font-bold text-slate-900 leading-tight">ADMIN USER</div>
                <div class="text-[11px] text-slate-500">Super Admin</div>
            </div>
            <div class="w-9 h-9 rounded-full bg-[#0b57d0] text-white flex items-center justify-center shadow-sm">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20c0-4 4-6 8-6s8 2 8 6"/>
                </svg>
            </div>
        </div>
    </div>
</header>
