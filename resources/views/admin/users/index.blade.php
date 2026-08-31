<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users — IndoTech Admin</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script>
        if (window.tailwind) {
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    },
                },
            };
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-slate-800 antialiased">

<div class="flex min-h-screen">

    {{-- ===== SIDEBAR PARTIAL ===== --}}
    @include('admin.partials.sidebar')

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Header Bar --}}
        <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center gap-4">
            {{-- Breadcrumb --}}
            <div class="text-[13px] text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Home</a>
                <span class="mx-1.5">›</span>
                <span class="text-slate-900 font-medium">User Management</span>
            </div>

            <div class="flex-1"></div>

            {{-- Search Bar --}}
            <form action="{{ route('admin.users.index') }}" method="GET" class="hidden md:flex items-center gap-2 bg-slate-100 rounded-lg px-3 h-9 w-64">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-slate-400">
                    <circle cx="11" cy="11" r="7"/>
                    <path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search data..." class="bg-transparent outline-none text-[13px] text-slate-700 placeholder-slate-400 flex-1 min-w-0">
            </form>

            {{-- Icons --}}
            <button class="relative p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition" aria-label="Notifications">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.5-1.5V11a5.5 5.5 0 0 0-4-5.3V5a1.5 1.5 0 0 0-3 0v.7a5.5 5.5 0 0 0-4 5.3v4.5L6 17h5m4 0v1a3 3 0 0 1-6 0v-1"/></svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500"></span>
            </button>
            <button class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition" aria-label="Help">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.9"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 9a2.5 2.5 0 0 1 4.9.8c0 1.7-2.4 2.2-2.4 3.7m0 3h.01"/></svg>
            </button>

            {{-- Profile --}}
            <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&h=100&fit=crop" 
                     alt="Admin User" 
                     class="w-9 h-9 rounded-full object-cover border border-slate-200">
                <div class="hidden sm:block">
                    <div class="text-[13px] font-semibold text-slate-900 leading-none">Admin User</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Superadmin</div>
                </div>
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="text-slate-400"><path d="m8 10 4 4 4-4"/></svg>
            </div>
        </header>

        {{-- Main Page Content --}}
        <main class="flex-1 p-6 space-y-6">

            {{-- Title --}}
            <div>
                <h1 class="text-[22px] font-bold text-slate-900">User Management</h1>
                <p class="text-[13px] text-slate-500 mt-0.5">Manage system users, roles, and status active settings.</p>
            </div>

            {{-- Main Table Card Container --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                
                {{-- Table Top Bar: Title + Actions --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">
                        System User List
                    </h2>

                    {{-- Right Filter & Export Buttons --}}
                    <div class="flex items-center gap-2.5">
                        <button onclick="toggleModal('modal-filter')" 
                                class="inline-flex items-center justify-center gap-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-3.5 py-1.5 rounded-full text-xs shadow-sm transition">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L4.35 21l3.39-.62A8.94 8.94 0 0012 21c4.97 0 9-4.03 9-9s-4.03-9-9-9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h3m-4.5 4h6m-3 4h3"/></svg>
                            <span>Filter</span>
                        </button>

                        <button onclick="alert('Exporting user report...')" 
                                class="inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3.5 py-1.5 rounded-full text-xs shadow-sm transition">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            <span>Export</span>
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-50/50 border-y border-slate-100 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                                <th class="py-3 px-4 rounded-l-lg">User Name</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Role</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center rounded-r-lg">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-[13px] text-slate-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            @if(($user['avatar_type'] ?? '') === 'image' && !empty($user['avatar']))
                                                <img src="{{ $user['avatar'] }}" alt="{{ $user['name'] }}" 
                                                     class="w-9 h-9 rounded-full object-cover shrink-0 border border-slate-200">
                                            @else
                                                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs shrink-0">
                                                    {{ $user['initials'] ?? substr($user['name'], 0, 2) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $user['name'] }}</div>
                                                <div class="text-[11px] text-slate-400 mt-0.5">Joined: {{ $user['joined'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-medium">{{ $user['email'] }}</td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $user['role'] }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $user['status_color'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            <span>{{ $user['status'] }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center justify-center gap-2.5 text-slate-400">
                                            <button onclick="alert('Edit user: {{ $user['name'] }}')" class="hover:text-blue-600 transition" title="Edit">
                                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/></svg>
                                            </button>
                                            <button onclick="if(confirm('Delete {{ $user['name'] }}?')) alert('Deleted');" class="hover:text-red-600 transition" title="Delete">
                                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-6 text-center text-slate-400">No users found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6 pt-4 border-t border-slate-100 text-xs text-slate-500 font-medium">
                    <div>Showing 1-3 of {{ $totalUsersCount }} users</div>
                    <div class="flex items-center gap-1.5">
                        <button disabled class="w-8 h-8 rounded-lg border border-slate-200 text-slate-300 flex items-center justify-center opacity-50">&lsaquo;</button>
                        <button class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold shadow-sm">1</button>
                        <a href="?page=2" class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center font-semibold transition">2</a>
                        <a href="?page=3" class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center font-semibold transition">3</a>
                        <span class="px-1 text-slate-400">...</span>
                        <a href="?page=2" class="w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">&rsaquo;</a>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

{{-- Modal Filter --}}
<div id="modal-filter" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 max-w-sm w-full shadow-xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Filter Users</h3>
            <button onclick="toggleModal('modal-filter')" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>
        <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4 text-xs font-medium">
            <div>
                <label class="block text-slate-700 mb-1 font-semibold">Filter by Status</label>
                <select name="status" class="w-full border border-slate-200 rounded-lg px-3 py-2 outline-none focus:border-blue-600">
                    <option value="all">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="toggleModal('modal-filter')" class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-slate-600 font-semibold">Cancel</button>
                <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-blue-600 text-white font-semibold shadow-sm hover:bg-blue-700">Apply Filter</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.toggle('hidden');
    }
</script>

</body>
</html>
