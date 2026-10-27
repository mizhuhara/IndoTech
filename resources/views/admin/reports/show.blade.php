@extends('admin.layouts.app')

@section('title', ($report['title'] ?? 'Report #' . ($report['id'] ?? '1248')) . ' — IndoTech Admin')

@section('content')
<div class="max-w-6xl space-y-5">

    {{-- Toast Notification Container --}}
    <div id="toast-notification" class="fixed top-5 right-5 z-50 flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-900 text-white text-[13.5px] shadow-xl border border-slate-800 transition-all duration-300 opacity-0 translate-y-[-10px] pointer-events-none">
        <div id="toast-icon" class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>
        <span id="toast-message" class="font-medium">Report marked as Resolved.</span>
    </div>

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-[13px] text-slate-500">
        <a href="{{ route('admin.reports.index', ['from' => $from, 'to' => $to]) }}"
            class="hover:text-brand-600 transition font-medium">Reports</a>
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" class="text-slate-400"><path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6"/></svg>
        <span class="font-bold text-slate-800">{{ $report['id'] ?? 'Report #1248' }}</span>
    </nav>

    {{-- Main Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ===== LEFT COLUMN ===== --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Report Detail Card --}}
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
                {{-- Header: Title + Badges --}}
                <div class="flex flex-wrap items-start justify-between gap-3 mb-1">
                    <h1 class="text-[20px] font-bold text-slate-900 leading-snug">
                        {{ $report['title'] ?? 'App Bug: Grade Submission Portal' }}
                    </h1>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold bg-rose-50 text-rose-600 border border-rose-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            High Priority
                        </span>
                        <span id="header-status-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold bg-blue-50 text-brand-600 border border-blue-100 transition-colors duration-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                            <span id="header-status-text">Investigating</span>
                        </span>
                    </div>
                </div>
                <p class="text-[13px] text-slate-500 mb-5">
                    Reported 2 hours ago by {{ auth()->user()->name ?? 'Sarah Jenkins' }}
                </p>

                {{-- Description --}}
                <div class="pt-4 border-t border-slate-100">
                    <h2 class="text-[14px] font-bold text-slate-900 mb-2.5">Description</h2>
                    <div class="rounded-xl border border-slate-200/90 bg-white px-4 py-3.5 text-[13.5px] text-slate-600 leading-relaxed shadow-2xs">
                        {{ $report['summary'] ?? "The grade submission portal has been returning a 502 Bad Gateway error since 8:00 AM this morning. I've tried clearing my cache, using different browsers (Chrome, Firefox), and having other faculty members test it, but no one can access it. This is a critical issue as final grades are due by 5:00 PM today." }}
                    </div>
                </div>

                {{-- Attachments --}}
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <h2 class="text-[14px] font-bold text-slate-900 mb-3">Attachments</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        {{-- Image Attachment Thumbnail --}}
                        <div class="relative rounded-xl border border-slate-200 bg-slate-50 p-2 h-28 flex items-center justify-center overflow-hidden group hover:border-slate-300 transition cursor-pointer">
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200/80 flex items-center justify-center">
                                <div class="w-10 h-10 rounded-lg bg-white/90 shadow-xs flex items-center justify-center text-slate-500 group-hover:scale-105 transition">
                                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- File Attachment --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4 h-28 flex flex-col items-center justify-center text-center hover:border-slate-300 transition cursor-pointer group">
                            <div class="w-10 h-10 rounded-lg bg-white shadow-xs flex items-center justify-center text-slate-500 mb-2 group-hover:scale-105 transition">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="text-[12.5px] font-semibold text-slate-700">console_logs.txt</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity Timeline --}}
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
                <h2 class="text-[15px] font-bold text-slate-900 border-b border-slate-100 pb-3 mb-5">Activity Timeline</h2>
                <div id="timeline-container" class="space-y-4">
                    {{-- Item 1 --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3.5 h-3.5 rounded-full bg-brand-600 mt-0.5 shrink-0 ring-4 ring-blue-50"></div>
                            <div class="w-px flex-1 bg-slate-200 mt-1"></div>
                        </div>
                        <div class="pb-4">
                            <div class="text-[12px] text-slate-400 font-medium mb-0.5">Today, 10:15 AM</div>
                            <div class="text-[13.5px] font-bold text-slate-800">Status changed to Investigating by Admin (System)</div>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3.5 h-3.5 rounded-full bg-blue-200 mt-0.5 shrink-0"></div>
                            <div class="w-px flex-1 bg-slate-200 mt-1"></div>
                        </div>
                        <div class="pb-4">
                            <div class="text-[12px] text-slate-400 font-medium mb-0.5">Today, 8:45 AM</div>
                            <div class="text-[13.5px] font-bold text-slate-800">Assigned to Tech Support Queue</div>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3.5 h-3.5 rounded-full bg-blue-200 mt-0.5 shrink-0"></div>
                        </div>
                        <div>
                            <div class="text-[12px] text-slate-400 font-medium mb-0.5">Today, 8:30 AM</div>
                            <div class="text-[13.5px] font-bold text-slate-800">Report Submitted via Faculty Portal</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end left column --}}

        {{-- ===== RIGHT COLUMN ===== --}}
        <div class="space-y-5">

            {{-- Reporter Information --}}
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
                <h2 class="text-[15px] font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Reporter Information</h2>

                <div class="flex items-center gap-3.5 mb-5">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80" 
                        alt="Sarah Jenkins"
                        class="w-12 h-12 rounded-full object-cover shadow-2xs border border-slate-100 shrink-0" 
                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center text-[16px] font-bold shrink-0\'>SJ</div>'">
                    <div>
                        <div class="text-[15px] font-bold text-slate-900 leading-snug">Sarah Jenkins</div>
                        <div class="text-[12.5px] text-slate-500 font-medium">University Admin</div>
                    </div>
                </div>

                <div class="space-y-3 text-[13px] text-slate-600">
                    <div class="flex items-center gap-3">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="text-slate-400 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">s.jenkins@university.edu</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="text-slate-400 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>+1 (555) 019-2834</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="text-slate-400 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Faculty Office, Building A</span>
                    </div>
                </div>
            </div>

            {{-- Admin Actions --}}
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6">
                <h2 class="text-[15px] font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Admin Actions</h2>

                <div class="space-y-3.5">
                    <div>
                        <label for="status-select" class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Update Status</label>
                        <div class="relative">
                            <select id="status-select" class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3.5 pr-9 text-[13.5px] text-slate-700 outline-none focus:border-brand-600 appearance-none transition shadow-2xs cursor-pointer">
                                <option value="Investigating" selected>Investigating</option>
                                <option value="Pending">Pending</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Closed">Closed</option>
                            </select>
                            <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m8 10 4 4 4-4"/></svg>
                        </div>
                    </div>

                    <button type="button" id="btn-mark-resolved"
                        class="w-full h-10 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 text-white text-[13.5px] font-semibold hover:bg-blue-700 active:scale-[0.99] transition shadow-xs cursor-pointer">
                        <svg id="resolve-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="resolve-text">Mark as Resolved</span>
                    </button>

                    <button type="button" id="btn-send-message"
                        class="w-full h-10 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-100 text-blue-700 text-[13.5px] font-semibold hover:bg-blue-200 active:scale-[0.99] transition cursor-pointer">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>Send Message</span>
                    </button>
                </div>
            </div>

        </div>{{-- end right column --}}

    </div>

</div>

{{-- Message Modal --}}
<div id="message-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs hidden transition-all duration-200">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="text-[15px] font-bold text-slate-900">Send Message to Reporter</h3>
            <button type="button" id="close-modal-btn" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div>
            <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Recipient</label>
            <input type="text" readonly value="Sarah Jenkins (s.jenkins@university.edu)" class="w-full h-9 rounded-xl border border-slate-200 bg-slate-50 px-3 text-[13px] text-slate-600 outline-none">
        </div>
        <div>
            <label for="message-content" class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Message</label>
            <textarea id="message-content" rows="4" placeholder="Write your message or update to the reporter..." class="w-full rounded-xl border border-slate-200 bg-white p-3 text-[13px] text-slate-800 outline-none focus:border-brand-600 transition resize-none"></textarea>
        </div>
        <div class="flex items-center justify-end gap-2.5 pt-2">
            <button type="button" id="cancel-modal-btn" class="h-9 px-4 rounded-xl border border-slate-200 text-[13px] font-semibold text-slate-600 hover:bg-slate-50 transition">Cancel</button>
            <button type="button" id="submit-message-btn" class="h-9 px-4 rounded-xl bg-brand-600 text-white text-[13px] font-semibold hover:bg-blue-700 transition">Send</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status-select');
    const btnMarkResolved = document.getElementById('btn-mark-resolved');
    const resolveText = document.getElementById('resolve-text');
    const headerStatusBadge = document.getElementById('header-status-badge');
    const headerStatusText = document.getElementById('header-status-text');
    const timelineContainer = document.getElementById('timeline-container');

    const toast = document.getElementById('toast-notification');
    const toastMessage = document.getElementById('toast-message');

    function showToast(message) {
        if (!toast) return;
        toastMessage.textContent = message;
        toast.classList.remove('opacity-0', 'translate-y-[-10px]', 'pointer-events-none');
        toast.classList.add('opacity-100', 'translate-y-0');

        setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-[-10px]', 'pointer-events-none');
        }, 3500);
    }

    function updateBadge(status) {
        headerStatusText.textContent = status;
        headerStatusBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-semibold border transition-colors duration-200';
        
        let dotColor = 'bg-brand-600';
        if (status === 'Resolved') {
            headerStatusBadge.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-100');
            dotColor = 'bg-emerald-500';
        } else if (status === 'Pending') {
            headerStatusBadge.classList.add('bg-amber-50', 'text-amber-600', 'border-amber-100');
            dotColor = 'bg-amber-500';
        } else if (status === 'Closed') {
            headerStatusBadge.classList.add('bg-slate-100', 'text-slate-600', 'border-slate-200');
            dotColor = 'bg-slate-400';
        } else {
            // Investigating
            headerStatusBadge.classList.add('bg-blue-50', 'text-brand-600', 'border-blue-100');
            dotColor = 'bg-brand-600';
        }

        const dot = headerStatusBadge.querySelector('span');
        if (dot) {
            dot.className = `w-1.5 h-1.5 rounded-full ${dotColor}`;
        }
    }

    function addTimelineItem(title, text, isGreen = false) {
        if (!timelineContainer) return;

        const dotClass = isGreen ? 'bg-emerald-500 ring-4 ring-emerald-50' : 'bg-brand-600 ring-4 ring-blue-50';

        const newItem = document.createElement('div');
        newItem.className = 'flex gap-4 animate-fade-in';
        newItem.innerHTML = `
            <div class="flex flex-col items-center">
                <div class="w-3.5 h-3.5 rounded-full ${dotClass} mt-0.5 shrink-0"></div>
                <div class="w-px flex-1 bg-slate-200 mt-1"></div>
            </div>
            <div class="pb-4">
                <div class="text-[12px] text-slate-400 font-medium mb-0.5">${title}</div>
                <div class="text-[13.5px] font-bold text-slate-800">${text}</div>
            </div>
        `;
        timelineContainer.insertBefore(newItem, timelineContainer.firstChild);
    }

    const reportSlug = "{{ $report['slug'] ?? 'users' }}";
    const baseReturnUrl = "{{ route('admin.reports.index', array_filter(['from' => $from, 'to' => $to])) }}";

    // Load any previously saved status on init
    const initialSaved = localStorage.getItem('report_status_' + reportSlug);
    if (initialSaved) {
        statusSelect.value = initialSaved;
        updateBadge(initialSaved);
        if (initialSaved === 'Resolved') {
            btnMarkResolved.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            btnMarkResolved.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
            btnMarkResolved.disabled = true;
            resolveText.textContent = 'Resolved ✓';
        }
    }

    // Click "Mark as Resolved"
    btnMarkResolved?.addEventListener('click', function () {
        statusSelect.value = 'Resolved';
        updateBadge('Resolved');
        localStorage.setItem('report_status_' + reportSlug, 'Resolved');

        btnMarkResolved.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        btnMarkResolved.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
        btnMarkResolved.disabled = true;
        resolveText.textContent = 'Resolved ✓';

        addTimelineItem('Just now', 'Report marked as Resolved by Admin', true);
        showToast('Report marked as Resolved. Mengalihkan...');

        const targetUrl = baseReturnUrl + (baseReturnUrl.includes('?') ? '&' : '?') + 'updated_report=' + encodeURIComponent(reportSlug) + '&status=Resolved';
        setTimeout(function () {
            window.location.href = targetUrl;
        }, 500);
    });

    // Change status from select
    statusSelect?.addEventListener('change', function () {
        const val = this.value;
        updateBadge(val);
        localStorage.setItem('report_status_' + reportSlug, val);

        if (val === 'Resolved') {
            btnMarkResolved.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            btnMarkResolved.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
            btnMarkResolved.disabled = true;
            resolveText.textContent = 'Resolved ✓';
            addTimelineItem('Just now', 'Status updated to Resolved by Admin', true);
            showToast('Status updated to Resolved. Tersimpan!');
        } else {
            btnMarkResolved.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
            btnMarkResolved.classList.add('bg-blue-600', 'hover:bg-blue-700');
            btnMarkResolved.disabled = false;
            resolveText.textContent = 'Mark as Resolved';
            addTimelineItem('Just now', `Status updated to ${val} by Admin`);
            showToast(`Status updated to ${val}. Tersimpan!`);
        }
    });

    // Send Message Modal
    const messageModal = document.getElementById('message-modal');
    const btnSendMessage = document.getElementById('btn-send-message');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelModalBtn = document.getElementById('cancel-modal-btn');
    const submitMessageBtn = document.getElementById('submit-message-btn');
    const messageContent = document.getElementById('message-content');

    function openModal() {
        messageModal.classList.remove('hidden');
    }

    function closeModal() {
        messageModal.classList.add('hidden');
        if (messageContent) messageContent.value = '';
    }

    btnSendMessage?.addEventListener('click', openModal);
    closeModalBtn?.addEventListener('click', closeModal);
    cancelModalBtn?.addEventListener('click', closeModal);

    submitMessageBtn?.addEventListener('click', function () {
        const msg = messageContent.value.trim();
        if (!msg) {
            messageContent.focus();
            return;
        }
        closeModal();
        addTimelineItem('Just now', 'Message sent to Sarah Jenkins: "' + (msg.length > 35 ? msg.substring(0, 35) + '...' : msg) + '"');
        showToast('Message sent to Sarah Jenkins.');
    });
});
</script>
@endsection
