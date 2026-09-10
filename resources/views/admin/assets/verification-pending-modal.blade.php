{{-- Verification Pending Modal --}}
<div id="verification-pending-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden animate-scale-in">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 mb-4">
                <svg class="w-8 h-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Pendaftaran Berhasil!</h2>
            <p class="text-sm text-slate-600 mt-2">Akun Anda sedang menunggu verifikasi</p>
        </div>

        {{-- Content --}}
        <div class="px-8 py-8 space-y-5">
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 space-y-2">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Apa selanjutnya?</p>
                        <p class="text-sm text-slate-700 mt-1">Super admin kami akan memeriksa dokumen dan data institusi Anda dalam 1-2 hari kerja.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex items-start gap-3">
                    <div class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold flex-shrink-0">1</div>
                    <div>
                        <p class="font-semibold text-slate-900">Dokumen Anda sedang diperiksa</p>
                        <p class="text-slate-600 mt-0.5">Kami memverifikasi semua dokumen yang Anda upload.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold flex-shrink-0">2</div>
                    <div>
                        <p class="font-semibold text-slate-900">Dapatkan notifikasi via email</p>
                        <p class="text-slate-600 mt-0.5">Kami akan mengirim email ke {{ auth()->user()->email }} saat verifikasi selesai.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold flex-shrink-0">3</div>
                    <div>
                        <p class="font-semibold text-slate-900">Mulai gunakan akun</p>
                        <p class="text-slate-600 mt-0.5">Setelah disetujui, Anda bisa login dan mulai menggunakan semua fitur.</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-800">
                <p><strong>Tip:</strong> Simpan email Anda tetap aktif untuk menerima notifikasi verifikasi kami.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-slate-50 px-8 py-4 flex items-center justify-between border-t border-slate-200">
            <button type="button" onclick="document.getElementById('verification-pending-modal').classList.add('hidden')" class="text-slate-600 hover:text-slate-900 font-medium text-sm">Tutup</button>
            <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition">
                Kembali ke Home
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
    // Show modal if session has the flag
    @if(session('show_verification_modal'))
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('verification-pending-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    @endif
</script>

<style>
    @keyframes scale-in {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-scale-in {
        animation: scale-in 0.3s ease-out;
    }
</style>
