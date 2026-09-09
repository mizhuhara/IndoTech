{{-- ========================================================================= --}}
{{-- ASSET: UNIVERSAL UPDATE / EDIT MODAL TEMPLATE --}}
{{-- Clean, modern modal for quick data editing without leaving the page --}}
{{-- ========================================================================= --}}

<div id="global-update-modal" 
     class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4 transition-all duration-200"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="global-update-title">

    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100/90 overflow-hidden flex flex-col max-h-[90vh]">
        {{-- Header --}}
        <div class="px-6 py-4.5 border-b border-slate-100 flex items-start justify-between gap-3 shrink-0 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0b57d0] flex items-center justify-center shrink-0 border border-blue-100 font-bold text-sm">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 id="global-update-title" class="text-[16px] font-bold text-slate-900 tracking-tight leading-snug">
                        Edit Data
                    </h3>
                    <p id="global-update-subtitle" class="text-[12.5px] text-slate-500 mt-0.5">Perbarui informasi entitas berikut</p>
                </div>
            </div>
            <button type="button" 
                    onclick="closeGlobalUpdateModal()" 
                    class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-200/60 transition" 
                    aria-label="Tutup">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Form Body --}}
        <form id="global-update-form" method="POST" class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" name="_method" id="global-update-method" value="PUT">

            <div id="global-update-body" class="p-6 overflow-y-auto space-y-4 custom-sidebar-nav flex-1">
                {{-- Dynamic Inputs will be appended here --}}
            </div>

            {{-- Footer Actions --}}
            <div class="px-6 py-3.5 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0 bg-slate-50/50">
                <button type="button" 
                        onclick="closeGlobalUpdateModal()" 
                        class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-100 text-[13px] transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" 
                        id="global-update-submit-btn" 
                        class="px-4.5 py-2 rounded-xl bg-[#0b57d0] hover:bg-blue-700 text-white font-semibold text-[13px] shadow-xs shadow-blue-700/20 transition cursor-pointer flex items-center gap-1.5">
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    /**
     * Open Global Update / Edit Modal
     * @param {Object} options
     *   title: string
     *   subtitle: string
     *   actionUrl: string
     *   method: 'PUT'|'PATCH'|'POST'
     *   fields: Array<{ name, label, type: 'text'|'number'|'email'|'select'|'textarea', value, placeholder, options: Array<{value, label}>, required: boolean }>
     *   customHtml: string
     *   submitText: string
     */
    window.openUpdateModal = function(options = {}) {
        const modal = document.getElementById('global-update-modal');
        const form = document.getElementById('global-update-form');
        const methodInput = document.getElementById('global-update-method');
        const bodyEl = document.getElementById('global-update-body');
        const submitBtn = document.getElementById('global-update-submit-btn');

        if (!modal || !form) return;

        document.getElementById('global-update-title').textContent = options.title || 'Edit Data';
        document.getElementById('global-update-subtitle').textContent = options.subtitle || 'Perbarui informasi entitas berikut';

        form.action = options.actionUrl || '';
        methodInput.value = options.method || 'PUT';

        if (options.submitText) {
            submitBtn.querySelector('span').textContent = options.submitText;
        } else {
            submitBtn.querySelector('span').textContent = 'Simpan Perubahan';
        }

        bodyEl.innerHTML = '';

        if (options.customHtml) {
            bodyEl.innerHTML = options.customHtml;
        } else if (Array.isArray(options.fields)) {
            options.fields.forEach(field => {
                const group = document.createElement('div');
                group.className = 'space-y-1.5';

                const label = document.createElement('label');
                label.className = 'block text-[12.5px] font-bold text-slate-700';
                label.textContent = field.label || field.name;
                group.appendChild(label);

                if (field.type === 'textarea') {
                    const textarea = document.createElement('textarea');
                    textarea.name = field.name;
                    textarea.rows = field.rows || 3;
                    textarea.value = field.value || '';
                    textarea.placeholder = field.placeholder || '';
                    if (field.required) textarea.required = true;
                    textarea.className = 'w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-[13px] text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition';
                    group.appendChild(textarea);
                } else if (field.type === 'select') {
                    const select = document.createElement('select');
                    select.name = field.name;
                    if (field.required) select.required = true;
                    select.className = 'w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-[13px] text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition';
                    if (Array.isArray(field.options)) {
                        field.options.forEach(opt => {
                            const optEl = document.createElement('option');
                            optEl.value = opt.value;
                            optEl.textContent = opt.label;
                            if (String(opt.value) === String(field.value)) optEl.selected = true;
                            select.appendChild(optEl);
                        });
                    }
                    group.appendChild(select);
                } else {
                    const input = document.createElement('input');
                    input.type = field.type || 'text';
                    input.name = field.name;
                    input.value = field.value || '';
                    input.placeholder = field.placeholder || '';
                    if (field.required) input.required = true;
                    input.className = 'w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-[13px] text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 outline-none transition';
                    group.appendChild(input);
                }

                bodyEl.appendChild(group);
            });
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    window.closeGlobalUpdateModal = function() {
        const modal = document.getElementById('global-update-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    };

    // Close on backdrop click
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('global-update-modal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeGlobalUpdateModal();
            });
        }
    });
</script>
