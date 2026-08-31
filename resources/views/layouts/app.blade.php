<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'IndoTech'))</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                body { font-family: 'Plus Jakarta Sans', sans-serif; }
            </style>
        @endif

        {{-- ===== NAVBAR & FOOTER STYLES ===== --}}
        <style>
        /* ---- UTILITIES ---- */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ---- NAVBAR ---- */
        #it-navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        #it-navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            height: 62px;
        }
        #it-logo {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            text-decoration: none;
            letter-spacing: -0.5px;
            flex-shrink: 0;
        }
        #it-nav {
            display: flex;
            align-items: stretch;
            height: 100%;
        }
        #it-nav a {
            display: flex;
            align-items: center;
            padding: 0 13px;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            text-decoration: none;
            border-bottom: 2.5px solid transparent;
            transition: color 0.15s, border-color 0.15s;
            white-space: nowrap;
        }
        #it-nav a:hover { color: #2563eb; }
        #it-nav a.it-active {
            color: #2563eb;
            font-weight: 600;
            border-bottom-color: #2563eb;
        }
        #it-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        #it-search-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 7px;
            color: #64748b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s, color 0.15s;
            line-height: 0;
        }
        #it-search-btn:hover { background: #f1f5f9; color: #0f172a; }
        .it-btn-signin {
            display: inline-flex !important;
            align-items: center;
            padding: 7px 16px;
            font-size: 13.5px;
            font-weight: 600;
            color: #2563eb !important;
            border: 1.5px solid #2563eb;
            border-radius: 8px;
            text-decoration: none;
            background: transparent;
            white-space: nowrap;
            transition: background 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .it-btn-signin:hover { background: #eff6ff; }
        .it-btn-signup {
            display: inline-flex !important;
            align-items: center;
            padding: 7px 16px;
            font-size: 13.5px;
            font-weight: 600;
            color: #ffffff !important;
            background: #2563eb;
            border: 1.5px solid #2563eb;
            border-radius: 8px;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.15s;
            box-shadow: 0 1px 4px rgba(37,99,235,0.25);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .it-btn-signup:hover { background: #1d4ed8; border-color: #1d4ed8; }

        /* Mobile menu toggle — hidden by default on desktop */
        #it-mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            color: #475569;
            border-radius: 8px;
            line-height: 0;
        }
        #it-mobile-menu {
            display: none;
            border-top: 1px solid #f1f5f9;
            background: #ffffff;
            padding: 10px 20px 16px;
        }
        #it-mobile-menu a {
            display: block;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            text-decoration: none;
            border-radius: 7px;
            transition: background 0.12s, color 0.12s;
        }
        #it-mobile-menu a:hover,
        #it-mobile-menu a.it-active { color: #2563eb; background: #eff6ff; }
        .it-mobile-btns {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }
        .it-mobile-btns a {
            flex: 1;
            text-align: center;
            padding: 8px 12px !important;
            border-radius: 8px !important;
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 860px) {
            #it-nav { display: none; }
            .it-btn-signin, .it-btn-signup { display: none !important; }
            #it-mobile-toggle { display: flex; }
            #it-mobile-menu.it-open { display: block; }
        }

        /* ---- FOOTER ---- */
        #it-footer {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding-top: 56px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        #it-footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .it-footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 48px;
        }
        @media (max-width: 767px) {
            .it-footer-grid { grid-template-columns: 1fr; gap: 32px; }
        }
        .it-f-brand {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            text-decoration: none;
            letter-spacing: -0.5px;
            display: inline-block;
        }
        .it-f-tagline {
            font-size: 13.5px;
            font-weight: 600;
            color: #2563eb;
            margin-top: 5px;
            line-height: 1.45;
        }
        .it-f-desc {
            font-size: 13.5px;
            color: #64748b;
            margin-top: 10px;
            line-height: 1.65;
            max-width: 290px;
        }
        .it-social-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }
        .it-si {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1.5px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            text-decoration: none;
            transition: all 0.15s;
            line-height: 0;
        }
        .it-si:hover { background: #f8fafc; }
        .it-si.li:hover { border-color: #0077b5; color: #0077b5; }
        .it-si.tw:hover { border-color: #1da1f2; color: #1da1f2; }
        .it-si.ig:hover { border-color: #e1306c; color: #e1306c; }
        .it-si.yt:hover { border-color: #ff0000; color: #ff0000; }

        .it-f-col-title {
            font-size: 12.5px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin: 0 0 16px;
        }
        .it-f-links { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
        .it-f-links a { font-size: 14px; color: #475569; text-decoration: none; transition: color 0.15s; }
        .it-f-links a:hover { color: #2563eb; }

        .it-contact-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px; }
        .it-ci {
            display: flex;
            align-items: center;
            gap: 11px;
            font-size: 14px;
            color: #475569;
        }
        .it-ci a { color: #475569; text-decoration: none; transition: color 0.15s; }
        .it-ci a:hover { color: #2563eb; }
        .it-ci-icon {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            line-height: 0;
        }
        .it-ci-icon.email    { background: #dbeafe; color: #2563eb; }
        .it-ci-icon.phone    { background: #dcfce7; color: #16a34a; }
        .it-ci-icon.location { background: #fee2e2; color: #dc2626; }

        .it-footer-bottom {
            margin-top: 48px;
            border-top: 1px solid #e2e8f0;
            padding: 18px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .it-footer-copy { font-size: 12.5px; color: #94a3b8; margin: 0; }
        .it-footer-legal { display: flex; align-items: center; gap: 18px; }
        .it-footer-legal a { font-size: 12.5px; color: #94a3b8; text-decoration: none; transition: color 0.15s; }
        .it-footer-legal a:hover { color: #2563eb; }

        /* ---- HERO SECTION ---- */
        .it-hero {
            position: relative;
            background: linear-gradient(180deg, #eef4ff 0%, #f8fafc 100%);
            padding: 64px 24px 48px;
            text-align: center;
            overflow: hidden;
        }
        .it-hero::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }
        .it-hero::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(147,197,253,0.12) 0%, transparent 70%);
            border-radius: 50%;
        }
        .it-hero-content {
            position: relative;
            z-index: 1;
            max-width: 750px;
            margin: 0 auto;
        }
        .it-hero h1 {
            font-size: 40px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin: 0;
        }
        @media (min-width: 768px) {
            .it-hero h1 { font-size: 48px; }
        }
        .it-hero-sub {
            font-size: 15px;
            color: #64748b;
            max-width: 560px;
            margin: 16px auto 0;
            line-height: 1.65;
        }

        /* Hero Search */
        .it-hero-search {
            max-width: 560px;
            margin: 32px auto 0;
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 5px 5px 5px 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .it-hero-search svg {
            color: #94a3b8;
            flex-shrink: 0;
            margin-right: 10px;
        }
        .it-hero-search input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 14px;
            color: #334155;
            background: transparent;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-width: 0;
        }
        .it-hero-search input::placeholder { color: #94a3b8; }
        .it-hero-search button {
            background: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 50px;
            padding: 10px 28px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .it-hero-search button:hover { background: #1d4ed8; }

        /* Category Icons */
        .it-categories {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-top: 44px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .it-cat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #475569;
            font-size: 12px;
            font-weight: 500;
            width: 80px;
            transition: color 0.15s;
            cursor: pointer;
        }
        .it-cat-item:hover { color: #2563eb; }
        .it-cat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.15s, box-shadow 0.15s;
            line-height: 0;
        }
        .it-cat-item:hover .it-cat-icon {
            border-color: #93c5fd;
            box-shadow: 0 2px 8px rgba(59,130,246,0.1);
        }

        /* ---- FEATURED OPPORTUNITIES ---- */
        .it-featured {
            max-width: 1200px;
            margin: 0 auto;
            padding: 56px 24px;
        }
        .it-featured-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 28px;
        }
        .it-featured-header h2 {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }
        .it-featured-header p {
            font-size: 14px;
            color: #64748b;
            margin: 4px 0 0;
        }
        .it-featured-header a {
            font-size: 14px;
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
            white-space: nowrap;
            transition: color 0.15s;
        }
        .it-featured-header a:hover { color: #1d4ed8; }

        .it-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        @media (max-width: 860px) {
            .it-cards-grid { grid-template-columns: 1fr; }
        }

        /* Opportunity Card */
        .it-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px;
            transition: box-shadow 0.2s, transform 0.2s;
            display: flex;
            flex-direction: column;
        }
        .it-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .it-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .it-card-logo {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: #ffffff;
            flex-shrink: 0;
        }
        .it-card-tag {
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 5px;
        }
        .it-card-tag.jobs        { background: #dbeafe; color: #2563eb; }
        .it-card-tag.internship  { background: #fef3c7; color: #d97706; }
        .it-card-tag.scholarship { background: #ede9fe; color: #7c3aed; }

        .it-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 2px;
        }
        .it-card-company {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }
        .it-card-details {
            margin-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .it-card-detail {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12.5px;
            color: #64748b;
        }
        .it-card-detail svg { color: #94a3b8; flex-shrink: 0; }

        .it-card-bottom {
            margin-top: auto;
            padding-top: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .it-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 600;
            color: #16a34a;
        }
        .it-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #16a34a;
        }
        .it-apply-btn {
            font-size: 13px;
            font-weight: 600;
            color: #2563eb;
            text-decoration: none;
            transition: color 0.15s;
        }
        .it-apply-btn:hover { color: #1d4ed8; }

        /* ---- CTA SECTION ---- */
        .it-cta-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px 56px;
        }
        .it-cta {
            background: #1e293b;
            border-radius: 20px;
            padding: 52px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            flex-wrap: wrap;
        }
        @media (max-width: 768px) {
            .it-cta { flex-direction: column; text-align: center; }
        }
        .it-cta-text h2 {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 8px;
        }
        .it-cta-text p {
            font-size: 14px;
            color: #94a3b8;
            margin: 0;
            max-width: 400px;
            line-height: 1.6;
        }
        .it-cta-btns {
            display: flex;
            gap: 12px;
            flex-shrink: 0;
        }
        .it-cta-btn-primary {
            display: inline-flex;
            align-items: center;
            padding: 11px 24px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            background: #dc2626;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            white-space: nowrap;
        }
        .it-cta-btn-primary:hover { background: #b91c1c; }
        .it-cta-btn-secondary {
            display: inline-flex;
            align-items: center;
            padding: 11px 24px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            background: transparent;
            border: 1.5px solid #475569;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            white-space: nowrap;
        }
        .it-cta-btn-secondary:hover { background: rgba(255,255,255,0.05); border-color: #94a3b8; }
        </style>
    </head>

    <body class="bg-slate-50 text-slate-800 antialiased">
        @include('partials.navbar')

        <main>
            @yield('content')
        </main>

        @include('partials.footer')
    </body>
</html>