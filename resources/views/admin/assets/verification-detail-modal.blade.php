{{-- ========================================================================= --}}
{{-- ASSET: VERIFICATION DETAIL MODAL TEMPLATE --}}
{{-- Clean, modern modal for reviewing institutional & user verification data --}}
{{-- ========================================================================= --}}

<div id="modal-detail-verification" 
     class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-[2px] flex items-center justify-center p-4 transition-all duration-200"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="detail_name">

    <div class="bg-white rounded-2xl max-w-xl w-full shadow-2xl border border-slate-100/90 overflow-hidden flex flex-col max-h-[90vh] transform transition-all">
        
        {{-- Modal Header --}}
        <div class="px-6 py-4.5 bg-slate-50/70 border-b border-slate-100 flex items-start justify-between gap-3 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0b57d0] border border-blue-100/80 flex items-center justify-center shrink-0">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-[16px] font-bold text-slate-900 tracking-tight leading-snug" id="detail_name">
                        Detail Pengajuan
                    </h3>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span id="detail_role_badge" class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 capitalize">
                            -
                        </span>
                        <span class="text-slate-300">•</span>
                        <span id="detail_created_at" class="text-[12px] text-slate-400 font-medium">-</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <div id="detail_status_badge"></div>
                <button type="button" 
                        onclick="closeDetailModal()" 
                        class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition cursor-pointer"
                        aria-label="Tutup">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Scrollable Content Body --}}
        <div class="p-6 overflow-y-auto space-y-5 custom-sidebar-nav flex-1">
            
            {{-- Account & Contact Details Grid --}}
            <div class="space-y-2">
                <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Informasi Pendaftar</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100/90">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Email Akun</span>
                        <span class="text-[13px] font-bold text-slate-800 break-all mt-0.5 block" id="detail_email">-</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100/90">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Penanggung Jawab</span>
                        <span class="text-[13px] font-bold text-slate-800 mt-0.5 block" id="detail_contact">-</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100/90">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">No. Telepon / WhatsApp</span>
                        <span class="text-[13px] font-bold text-slate-800 mt-0.5 block" id="detail_phone">-</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100/90">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Tipe Pendaftaran</span>
                        <span class="text-[13px] font-bold text-slate-800 capitalize mt-0.5 block" id="detail_role">-</span>
                    </div>
                </div>
            </div>

            {{-- Address Box --}}
            <div class="space-y-2">
                <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Alamat Lengkap</h4>
                <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100/90 flex items-start gap-2.5">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400 shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-[13px] text-slate-700 leading-relaxed font-medium" id="detail_address">-</p>
                </div>
            </div>

            {{-- Legal Document File Preview Card --}}
            <div class="space-y-2 pt-1 border-t border-slate-100">
                <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dokumen Verifikasi (Legalitas / SK)</h4>
                
                {{-- If Document Exists --}}
                <div id="detail_doc_container" class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-xl flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-[#0b57d0] border border-blue-100 flex items-center justify-center shrink-0">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-[13px] font-bold text-slate-800 truncate block" id="detail_doc_name">Dokumen_Legalitas.pdf</span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Dokumen resmi pengajuan verifikasi</span>
                        </div>
                    </div>
                    <a id="detail_doc_link" href="#" target="_blank" class="px-3.5 py-2 bg-white hover:bg-blue-50 text-[#0b57d0] border border-blue-200/80 rounded-xl text-[12.5px] font-bold shadow-2xs transition inline-flex items-center gap-1.5 shrink-0 cursor-pointer">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Buka File</span>
                    </a>
                </div>

                {{-- If No Document --}}
                <div id="detail_no_doc" class="hidden p-3.5 bg-slate-50 border border-slate-100 rounded-xl text-[12.5px] text-slate-500 flex items-center gap-2 font-medium">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400 shrink-0"><circle cx="12" cy="12" r="9"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>Tidak ada lampiran dokumen file untuk akun ini.</span>
                </div>
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="px-6 py-3.5 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between gap-3 shrink-0">
            <button type="button" 
                    onclick="closeDetailModal()" 
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-[13px] transition cursor-pointer">
                Tutup
            </button>

            <div id="detail_actions_container" class="flex items-center gap-2">
                <button type="button" 
                        onclick="triggerDetailReject()" 
                        class="px-4 py-2.5 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200/80 font-semibold text-[13px] transition cursor-pointer flex items-center gap-1.5">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>Tolak</span>
                </button>

                <button type="button" 
                        onclick="triggerDetailApprove()" 
                        class="px-4.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-[13px] shadow-xs shadow-emerald-600/20 transition cursor-pointer flex items-center gap-1.5">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                    <span>Setujui Akun</span>
                </button>
            </div>
        </div>

    </div>
</div>
