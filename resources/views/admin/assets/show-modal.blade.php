{{-- ========================================================================= --}}
{{-- ASSET: UNIVERSAL SHOW / DETAIL MODAL TEMPLATE --}}
{{-- Clean, modern modal for viewing detailed record without full page reload --}}
{{-- ========================================================================= --}}

<div id="global-show-modal" 
     class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4 transition-all duration-200"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="global-show-title">

    <div class="bg-white rounded-2xl max-w-xl w-full shadow-2xl border border-slate-100/90 overflow-hidden flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div class="px-6 py-4.5 border-b border-slate-100 flex items-start justify-between gap-3 shrink-0 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div id="global-show-icon-container" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 font-bold text-sm">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 id="global-show-title" class="text-[16px] font-bold text-slate-900 tracking-tight leading-snug">
                            Detail Data
                        </h3>
                        <span id="global-show-badge" class="hidden px-2 py-0.5 rounded-md text-[11px] font-semibold"></span>
                    </div>
                    <p id="global-show-subtitle" class="text-[12.5px] text-slate-500 mt-0.5">Informasi lengkap terkait entitas</p>
                </div>
            </div>
            <button type="button" 
                    onclick="closeGlobalShowModal()" 
                    class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-200/60 transition" 
                    aria-label="Tutup">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Scrollable Content Body --}}
        <div id="global-show-body" class="p-6 overflow-y-auto space-y-5 custom-sidebar-nav flex-1">
            {{-- Image / Media Preview Area (optional) --}}
            <div id="global-show-image-wrap" class="hidden flex items-center gap-4 p-3 rounded-xl bg-slate-50 border border-slate-100">
                <img id="global-show-image" src="" alt="Thumbnail" class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                <div class="flex-1 min-w-0">
                    <span class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">Preview Media</span>
                    <p id="global-show-image-caption" class="text-xs text-slate-600 truncate mt-0.5"></p>
                </div>
            </div>

            {{-- Dynamic Fields Grid --}}
            <div id="global-show-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Injected dynamically --}}
            </div>

            {{-- Description Box (optional) --}}
            <div id="global-show-desc-wrap" class="hidden space-y-1.5 pt-1 border-t border-slate-100">
                <span class="text-[11px] font-bold uppercase text-slate-400 tracking-wider block">Deskripsi / Catatan</span>
                <div id="global-show-description" class="p-3.5 rounded-xl bg-slate-50 text-[13px] text-slate-700 leading-relaxed border border-slate-100"></div>
            </div>

            {{-- Extra Custom HTML --}}
            <div id="global-show-custom-wrap" class="hidden"></div>
        </div>

        {{-- Footer Actions --}}
        <div class="px-6 py-3.5 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0 bg-slate-50/50">
            <button type="button" 
                    onclick="closeGlobalShowModal()" 
                    class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-100 text-[13px] transition cursor-pointer">
                Tutup
            </button>
            <a id="global-show-edit-btn" 
               href="#" 
               class="hidden px-4.5 py-2 rounded-xl bg-[#0b57d0] hover:bg-blue-700 text-white font-semibold text-[13px] shadow-xs shadow-blue-700/20 transition flex items-center gap-1.5 cursor-pointer">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Data</span>
            </a>
        </div>
    </div>
</div>

<script>
    /**
     * Open Global Show / Detail Modal
     * @param {Object} options
     *   title: string
     *   subtitle: string
     *   badge: { text, color: 'blue'|'emerald'|'amber'|'slate' }
     *   fields: Array<{ label, value }>
     *   description: string
     *   image: { url, caption }
     *   editUrl: string
     *   customHtml: string
     */
    window.openShowModal = function(options = {}) {
        const modal = document.getElementById('global-show-modal');
        if (!modal) return;

        // Title & Subtitle
        document.getElementById('global-show-title').textContent = options.title || 'Detail Data';
        document.getElementById('global-show-subtitle').textContent = options.subtitle || '';

        // Badge
        const badgeEl = document.getElementById('global-show-badge');
        if (options.badge && options.badge.text) {
            badgeEl.textContent = options.badge.text;
            badgeEl.className = 'px-2 py-0.5 rounded-md text-[11px] font-semibold';
            const color = options.badge.color || 'blue';
            if (color === 'emerald') badgeEl.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-200');
            else if (color === 'amber') badgeEl.classList.add('bg-amber-50', 'text-amber-700', 'border', 'border-amber-200');
            else if (color === 'rose') badgeEl.classList.add('bg-rose-50', 'text-rose-700', 'border', 'border-rose-200');
            else badgeEl.classList.add('bg-blue-50', 'text-blue-700', 'border', 'border-blue-200');
            badgeEl.classList.remove('hidden');
        } else {
            badgeEl.classList.add('hidden');
        }

        // Image
        const imgWrap = document.getElementById('global-show-image-wrap');
        const imgEl = document.getElementById('global-show-image');
        const imgCaption = document.getElementById('global-show-image-caption');
        if (options.image && options.image.url) {
            imgEl.src = options.image.url;
            imgCaption.textContent = options.image.caption || '';
            imgWrap.classList.remove('hidden');
        } else {
            imgWrap.classList.add('hidden');
        }

        // Fields Grid
        const gridEl = document.getElementById('global-show-grid');
        gridEl.innerHTML = '';
        if (Array.isArray(options.fields) && options.fields.length > 0) {
            options.fields.forEach(f => {
                const item = document.createElement('div');
                item.className = 'p-3 rounded-xl bg-slate-50/70 border border-slate-100 flex flex-col justify-between';
                item.innerHTML = `
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">${f.label}</span>
                    <span class="text-[13.5px] font-semibold text-slate-800 mt-1 break-words">${f.value || '-'}</span>
                `;
                gridEl.appendChild(item);
            });
            gridEl.classList.remove('hidden');
        } else {
            gridEl.classList.add('hidden');
        }

        // Description
        const descWrap = document.getElementById('global-show-desc-wrap');
        const descEl = document.getElementById('global-show-description');
        if (options.description) {
            descEl.innerHTML = options.description;
            descWrap.classList.remove('hidden');
        } else {
            descWrap.classList.add('hidden');
        }

        // Custom HTML
        const customWrap = document.getElementById('global-show-custom-wrap');
        if (options.customHtml) {
            customWrap.innerHTML = options.customHtml;
            customWrap.classList.remove('hidden');
        } else {
            customWrap.innerHTML = '';
            customWrap.classList.add('hidden');
        }

        // Edit Button
        const editBtn = document.getElementById('global-show-edit-btn');
        if (options.editUrl) {
            editBtn.href = options.editUrl;
            editBtn.classList.remove('hidden');
        } else {
            editBtn.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    window.closeGlobalShowModal = function() {
        const modal = document.getElementById('global-show-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    };

    // Close on backdrop click
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('global-show-modal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeGlobalShowModal();
            });
        }
    });
</script>
