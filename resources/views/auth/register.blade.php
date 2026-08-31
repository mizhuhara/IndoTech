<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up — IndoTech</title>

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
<body class="bg-slate-50 min-h-screen">

    {{-- ============ STEP 1: PICK ROLE ============ --}}
    <div id="step-role" class="min-h-screen flex items-center justify-center px-4 py-16">
        <div class="w-full max-w-4xl">

            <div class="text-center mb-10">
                <h1 class="text-[32px] font-bold text-slate-900">What role are you joining as?</h1>
                <p class="mt-2 text-[15px] text-slate-600">Choose your primary role to customize your IndoTech experience.</p>
            </div>

            <div id="role-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                @php
                    $roles = [
                        ['key' => 'student', 'title' => 'Student', 'desc' => 'Explore education, find internships, and develop your IT skills.', 'icon' => 'graduation'],
                        ['key' => 'teacher', 'title' => 'Teacher', 'desc' => 'Guide students and connect with the latest industry trends.', 'icon' => 'book'],
                        ['key' => 'lecturer', 'title' => 'Lecturer', 'desc' => 'Connect academic research with tech industry needs.', 'icon' => 'badge'],
                        ['key' => 'alumni', 'title' => 'Alumni', 'desc' => 'Stay connected, mentor students, and discover career opportunities.', 'icon' => 'award'],
                        ['key' => 'it-professional', 'title' => 'IT Professional', 'desc' => 'Build networks, find jobs, and share your expertise.', 'icon' => 'monitor'],
                        ['key' => 'school', 'title' => 'School', 'desc' => 'Showcase vocational programs and connect with industry.', 'icon' => 'school'],
                        ['key' => 'university', 'title' => 'University', 'desc' => 'Manage campus programs and industry partnerships.', 'icon' => 'landmark'],
                        ['key' => 'company', 'title' => 'Company', 'desc' => 'Recruit tech talent and promote your brand to the ecosystem.', 'icon' => 'office'],
                        ['key' => 'hr', 'title' => 'HR/Recruiter', 'desc' => "Find, track, and recruit Indonesia's top IT talent.", 'icon' => 'id-card'],
                    ];
                @endphp

                @foreach ($roles as $role)
                    <button type="button" data-role="{{ $role['key'] }}"
                            class="role-card group text-left bg-white border border-slate-200 rounded-xl p-5 transition hover:border-blue-400 hover:shadow-md outline-none focus:ring-2 focus:ring-blue-500/30">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                            @if ($role['icon'] === 'graduation')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-6-8v3c0 1.66 2.69 3 6 3s6-1.34 6-3v-3"/></svg>
                            @elseif ($role['icon'] === 'book')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.25C10.5 5 8.5 4.5 6 4.5H3v13h3c2.5 0 4.5.5 6 1.75m0-13c1.5-1.25 3.5-1.75 6-1.75h3v13h-3c-2.5 0-4.5.5-6 1.75m0-13v13"/></svg>
                            @elseif ($role['icon'] === 'badge')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="9" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M12.5 12.5 15 20l-3.5-2-2.5 2 2.5-9.5"/></svg>
                            @elseif ($role['icon'] === 'award')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="9" r="5"/><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 13.5 7 21l5-2.5L17 21l-1.5-7.5"/></svg>
                            @elseif ($role['icon'] === 'monitor')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="12" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8m-4-5v5"/></svg>
                            @elseif ($role['icon'] === 'school')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6"/></svg>
                            @elseif ($role['icon'] === 'landmark')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M4 9l8-5 8 5M5 12v6m4.5-6v6m5-6v6M19 12v6M3 21h18"/></svg>
                            @elseif ($role['icon'] === 'office')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h2m2 0h2m-6 4h2m2 0h2m-6 4h2m2 0h2M9 21v-3h6v3"/></svg>
                            @elseif ($role['icon'] === 'id-card')
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.5 16c.6-1.2 1.6-1.8 2.5-1.8s1.9.6 2.5 1.8M14 10h4m-4 3h4"/></svg>
                            @endif
                        </div>
                        <h3 class="text-[15px] font-bold text-slate-900">{{ $role['title'] }}</h3>
                        <p class="mt-1 text-[13px] text-slate-600 leading-relaxed">{{ $role['desc'] }}</p>
                    </button>
                @endforeach
            </div>

            {{-- Continue --}}
            <div class="mt-10 text-center">
                <button id="btn-continue" type="button" disabled
                        class="inline-flex items-center justify-center gap-2 w-80 max-w-full h-12 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-[15px] font-semibold transition opacity-50 cursor-not-allowed">
                    Continue
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </button>
            </div>

        </div>
    </div>

    {{-- ============ STEP 2: ACCOUNT FORM ============ --}}
    <div id="step-form" class="hidden min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg bg-white border border-slate-200 rounded-2xl px-8 py-10">

            {{-- Header --}}
            <div class="text-center">
                <span class="text-2xl font-extrabold tracking-tight text-blue-700">IndoTech</span>
                <h1 class="mt-3 text-[26px] font-bold text-gray-900">Create Your Account</h1>
                <p class="mt-1.5 text-[14px] text-gray-500">Join us in bridging Indonesian Education and Global IT.</p>
            </div>

            <form action="{{ url('/register') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                <input type="hidden" name="role" id="input-role" value="">

                {{-- Role chips --}}
                <div>
                    <label class="block text-[13.5px] font-semibold text-gray-900">I'm registering as:</label>
                    <div id="role-chips" class="mt-2 flex gap-2 overflow-x-auto pb-1">
                        @foreach ($roles as $role)
                            <button type="button" data-rolechip="{{ $role['key'] }}"
                                    class="chip shrink-0 px-4 py-2 rounded-full border text-[13px] font-medium bg-white border-gray-200 text-gray-600 whitespace-nowrap transition hover:border-blue-400">
                                {{ $role['title'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Full Name --}}
                <div>
                    <label for="name" class="block text-[13.5px] font-semibold text-gray-900">Full Name</label>
                    <div class="relative mt-2">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21c1.5-3.5 4.5-5 8-5s6.5 1.5 8 5"/></svg>
                        <input id="name" name="name" type="text" required placeholder="Enter your full name"
                               class="w-full h-[46px] pl-11 pr-4 rounded-lg border border-gray-300 text-[14px] text-gray-900 placeholder-gray-400 bg-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[13.5px] font-semibold text-gray-900">Email Address</label>
                    <div class="relative mt-2">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8 6 8-6"/></svg>
                        <input id="email" name="email" type="email" required placeholder="Enter your email"
                               class="w-full h-[46px] pl-11 pr-4 rounded-lg border border-gray-300 text-[14px] text-gray-900 placeholder-gray-400 bg-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[13.5px] font-semibold text-gray-900">Password</label>
                    <div class="relative mt-2">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="9" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                        <input id="password" name="password" type="password" required placeholder="Create a password"
                               class="w-full h-[46px] pl-11 pr-11 rounded-lg border border-gray-300 text-[14px] text-gray-900 placeholder-gray-400 bg-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <button type="button" data-toggle-pw aria-label="Show password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                            <svg data-icon-eye class="hidden" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"/><circle cx="12" cy="12" r="2.5"/></svg>
                            <svg data-icon-eye-off width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.5 5.2A10.4 10.4 0 0 1 12 5c6.5 0 10 7 10 7a17 17 0 0 1-3.2 4M6.6 6.6A16.6 16.6 0 0 0 2 12s3.5 7 10 7a9.8 9.8 0 0 0 4.6-1.1M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-[13.5px] font-semibold text-gray-900">Confirm Password</label>
                    <div class="relative mt-2">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="9" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Confirm your password"
                               class="w-full h-[46px] pl-11 pr-4 rounded-lg border border-gray-300 text-[14px] text-gray-900 placeholder-gray-400 bg-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>

                {{-- Terms --}}
                <label class="flex items-start gap-2.5 cursor-pointer select-none">
                    <input id="agree" type="checkbox" class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500/30">
                    <span class="text-[13px] text-gray-600">I agree to the <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Terms and Conditions</a> and <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Privacy Policy</a>.</span>
                </label>

                {{-- Sign Up --}}
                <button id="btn-signup" type="submit" disabled
                        class="flex items-center justify-center gap-2 w-full h-[46px] rounded-lg bg-blue-700 text-white text-[14.5px] font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed hover:enabled:bg-blue-800">
                    Sign Up
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </button>
            </form>

            {{-- Footer --}}
            <p class="mt-6 text-center text-[14px] text-gray-500">
                Already have an account?
                <a href="{{ url('/login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Sign in here</a>
            </p>
        </div>
    </div>

    <script>
        (function () {
            var selected = null;

            // Step 1: select role card
            document.querySelectorAll('.role-card').forEach(function (card) {
                card.addEventListener('click', function () {
                    document.querySelectorAll('.role-card').forEach(function (c) {
                        c.classList.remove('border-blue-500', 'bg-blue-50/40', 'ring-2', 'ring-blue-500/20');
                        c.classList.add('border-slate-200');
                    });
                    card.classList.remove('border-slate-200');
                    card.classList.add('border-blue-500', 'bg-blue-50/40', 'ring-2', 'ring-blue-500/20');
                    selected = card.dataset.role;
                    document.getElementById('btn-continue').disabled = false;
                    document.getElementById('btn-continue').classList.remove('opacity-50', 'cursor-not-allowed');
                });
            });

            // Continue -> step 2
            document.getElementById('btn-continue').addEventListener('click', function () {
                var role = selected;
                document.getElementById('input-role').value = role;
                document.querySelectorAll('.chip').forEach(function (chip) {
                    chip.classList.toggle('bg-blue-50', chip.dataset.rolechip === role);
                    chip.classList.toggle('border-blue-500', chip.dataset.rolechip === role);
                    chip.classList.toggle('text-blue-600', chip.dataset.rolechip === role);
                    chip.classList.toggle('bg-white', chip.dataset.rolechip !== role);
                    chip.classList.toggle('border-gray-200', chip.dataset.rolechip !== role);
                    chip.classList.toggle('text-gray-600', chip.dataset.rolechip !== role);
                });
                document.getElementById('step-role').classList.add('hidden');
                document.getElementById('step-form').classList.remove('hidden');
                document.body.classList.remove('bg-slate-50');
                document.body.classList.add('bg-white');
                window.scrollTo(0, 0);
            });

            // Step 2: chips switch role
            document.querySelectorAll('.chip').forEach(function (chip) {
                chip.addEventListener('click', function () {
                    selected = chip.dataset.rolechip;
                    document.getElementById('input-role').value = selected;
                    document.querySelectorAll('.chip').forEach(function (c) {
                        var on = c.dataset.rolechip === selected;
                        c.classList.toggle('bg-blue-50', on);
                        c.classList.toggle('border-blue-500', on);
                        c.classList.toggle('text-blue-600', on);
                        c.classList.toggle('bg-white', !on);
                        c.classList.toggle('border-gray-200', !on);
                        c.classList.toggle('text-gray-600', !on);
                    });
                });
            });

            // Show/hide password
            document.querySelector('[data-toggle-pw]').addEventListener('click', function () {
                var input = document.getElementById('password');
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                this.querySelector('[data-icon-eye]').classList.toggle('hidden', !show);
                this.querySelector('[data-icon-eye-off]').classList.toggle('hidden', show);
            });

            // Enable Sign Up only when agreed + form valid
            var agree = document.getElementById('agree');
            var btn = document.getElementById('btn-signup');
            var form = btn.closest('form');
            function updateBtn() {
                var enabled = agree.checked && form.checkValidity();
                btn.disabled = !enabled;
                btn.classList.toggle('disabled:opacity-50', !enabled);
            }
            agree.addEventListener('change', updateBtn);
            ['name', 'email', 'password', 'password_confirmation'].forEach(function (id) {
                document.getElementById(id).addEventListener('input', updateBtn);
            });
        })();
    </script>

</body>
</html>