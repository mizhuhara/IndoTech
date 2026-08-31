<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin — IndoTech')</title>

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
                        colors: {
                            brand: {
                                50: '#eef4ff',
                                100: '#d9e6ff',
                                500: '#1a73e8',
                                600: '#0b57d0',
                                700: '#0842a0',
                            }
                        },
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
    @stack('styles')
</head>
<body class="bg-[#f8fafd] min-h-screen text-slate-800 antialiased selection:bg-blue-500 selection:text-white">

<div class="flex min-h-screen">
    {{-- ===== SIDEBAR ===== --}}
    @include('admin.partials.sidebar')

    {{-- ===== MAIN WRAPPER ===== --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Header --}}
        @include('admin.partials.header')

        {{-- Main Content --}}
        <main class="flex-1 p-8">
            {{-- Flash Alert Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between text-sm shadow-sm animate-fade-in">
                    <div class="flex items-center gap-2.5">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-emerald-600"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 font-bold">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
