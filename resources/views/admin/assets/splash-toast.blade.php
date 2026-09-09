{{-- ========================================================================= --}}
{{-- ASSET: SPLASH / TOAST NOTIFICATION POPUP --}}
{{-- Clean, modern floating popup for session messages and dynamic JS alerts --}}
{{-- ========================================================================= --}}

<div id="admin-toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-2.5 max-w-sm w-full pointer-events-none">
    {{-- Initial Session Success --}}
    @if(session('success'))
        <div class="admin-toast pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-lg shadow-slate-900/10 border border-emerald-100 flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100">
            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100 mt-0.5">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-[13px] font-bold text-slate-900 leading-tight">Berhasil</h4>
                <p class="text-[12.5px] text-slate-600 mt-0.5 leading-snug">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="this.closest('.admin-toast').remove()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Initial Session Status --}}
    @if(session('status') && !session('success'))
        <div class="admin-toast pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-lg shadow-slate-900/10 border border-blue-100 flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100">
            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 mt-0.5">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-[13px] font-bold text-slate-900 leading-tight">Informasi</h4>
                <p class="text-[12.5px] text-slate-600 mt-0.5 leading-snug">{{ session('status') }}</p>
            </div>
            <button type="button" onclick="this.closest('.admin-toast').remove()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Initial Session Error --}}
    @if(session('error') || $errors->any())
        <div class="admin-toast pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-lg shadow-slate-900/10 border border-rose-100 flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100">
            <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100 mt-0.5">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-[13px] font-bold text-slate-900 leading-tight">Terjadi Kesalahan</h4>
                <p class="text-[12.5px] text-slate-600 mt-0.5 leading-snug">
                    {{ session('error') ?? $errors->first() }}
                </p>
            </div>
            <button type="button" onclick="this.closest('.admin-toast').remove()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif
</div>

<script>
    /**
     * Universal Toast / Splash Notification API
     * @param {Object} options { type: 'success'|'error'|'info'|'warning', title: string, message: string, duration: number }
     */
    window.showSplashToast = function({ type = 'success', title = '', message = '', duration = 4000 }) {
        const container = document.getElementById('admin-toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'admin-toast pointer-events-auto bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-lg shadow-slate-900/10 border flex items-start gap-3 transition-all duration-300 transform translate-y-[-10px] opacity-0';

        let borderClass = 'border-slate-200';
        let iconBg = 'bg-blue-50 text-blue-600 border-blue-100';
        let defaultTitle = 'Informasi';
        let iconSvg = `<circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>`;

        if (type === 'success') {
            borderClass = 'border-emerald-100';
            iconBg = 'bg-emerald-50 text-emerald-600 border-emerald-100';
            defaultTitle = 'Berhasil';
            iconSvg = `<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>`;
        } else if (type === 'error') {
            borderClass = 'border-rose-100';
            iconBg = 'bg-rose-50 text-rose-600 border-rose-100';
            defaultTitle = 'Gagal';
            iconSvg = `<circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>`;
        } else if (type === 'warning') {
            borderClass = 'border-amber-100';
            iconBg = 'bg-amber-50 text-amber-600 border-amber-100';
            defaultTitle = 'Peringatan';
            iconSvg = `<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>`;
        }

        toast.classList.add(borderClass);
        toast.innerHTML = `
            <div class="w-8 h-8 rounded-xl ${iconBg} flex items-center justify-center shrink-0 border mt-0.5">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">${iconSvg}</svg>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-[13px] font-bold text-slate-900 leading-tight">${title || defaultTitle}</h4>
                <p class="text-[12.5px] text-slate-600 mt-0.5 leading-snug">${message}</p>
            </div>
            <button type="button" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;

        const closeBtn = toast.querySelector('button');
        closeBtn.addEventListener('click', () => {
            removeToast(toast);
        });

        container.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-[-10px]', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
        });

        // Auto dismiss
        if (duration > 0) {
            setTimeout(() => {
                removeToast(toast);
            }, duration);
        }

        function removeToast(el) {
            el.classList.add('opacity-0', 'translate-y-[-10px]');
            setTimeout(() => {
                el.remove();
            }, 300);
        }
    };

    window.showToast = window.showSplashToast;

    // Auto-dismiss server-rendered toasts after 4.5 seconds
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#admin-toast-container .admin-toast').forEach(toast => {
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-[-10px]');
                setTimeout(() => toast.remove(), 300);
            }, 4500);
        });
    });
</script>
