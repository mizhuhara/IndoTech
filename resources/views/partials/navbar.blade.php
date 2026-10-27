<header id="it-navbar">
    <div id="it-navbar-inner">

        {{-- Logo --}}
        <a href="/" id="it-logo">IndoTech</a>

        {{-- Desktop Nav --}}
        <nav id="it-nav">
            <a href="/" class="{{ request()->is('/') ? 'it-active' : '' }}">Home</a>
            <a href="/education" class="{{ request()->is('education*') || request()->is('campus*') ? 'it-active' : '' }}">Education</a>
            <a href="/industry" class="{{ request()->is('industry*') ? 'it-active' : '' }}">Industry</a>
            <a href="/career" class="{{ request()->is('career*') ? 'it-active' : '' }}">Career</a>
            <a href="/events" class="{{ request()->is('events*') ? 'it-active' : '' }}">Events</a>
            <a href="/community" class="{{ request()->is('community*') ? 'it-active' : '' }}">Community</a>
            <a href="/knowledge-hub" class="{{ request()->is('knowledge-hub*') ? 'it-active' : '' }}">Knowledge Hub</a>
        </nav>

        {{-- Actions --}}
        <div id="it-actions">
            @auth
                <div id="it-user" class="it-user">
                    <button type="button" id="it-user-btn" aria-haspopup="true" aria-expanded="false">
                        <span class="it-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        <span class="it-user-name">{{ Auth::user()->name }}</span>
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div id="it-user-menu" class="it-user-menu" hidden>
                        <div class="it-user-head">
                            <span class="it-user-role">
                                @if(Auth::user()->role === 'super_admin') Admin
                                @else {{ ucfirst(str_replace('-', ' ', Auth::user()->role)) }}
                                @endif
                            </span>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="it-user-item"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21a8 8 0 0 1 16 0"/></svg> Profil Saya</a>
                        @if (in_array(Auth::user()->role, ['super_admin', 'school', 'university', 'company']))
                            <a href="{{ route('dashboard') }}" class="it-user-item"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg> Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="it-user-item it-user-logout"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 21H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3m7 14 5-5-5-5m5 5H9"/></svg> Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="it-btn-signin">Sign In</a>
                <a href="/register" class="it-btn-signup">Sign Up</a>
            @endauth

            <button id="it-mobile-toggle" aria-label="Menu" aria-controls="it-mobile-menu" aria-expanded="false">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="it-mobile-menu">
        <a href="/" class="{{ request()->is('/') ? 'it-active' : '' }}">Home</a>
        <a href="/education" class="{{ request()->is('education*') || request()->is('campus*') ? 'it-active' : '' }}">Education</a>
        <a href="/industry" class="{{ request()->is('industry*') ? 'it-active' : '' }}">Industry</a>
        <a href="/career" class="{{ request()->is('career*') ? 'it-active' : '' }}">Career</a>
        <a href="/events" class="{{ request()->is('events*') ? 'it-active' : '' }}">Events</a>
        <a href="/community" class="{{ request()->is('community*') ? 'it-active' : '' }}">Community</a>
        <a href="/knowledge-hub" class="{{ request()->is('knowledge-hub*') ? 'it-active' : '' }}">Knowledge Hub</a>
        <div class="it-mobile-btns">
            @auth
                <a href="{{ route('profile.edit') }}" style="color:#2563eb;border:1.5px solid #2563eb;">Profil Saya</a>
                @if (in_array(Auth::user()->role, ['super_admin', 'school', 'university', 'company']))
                    <a href="/admin" style="color:#fff;background:#2563eb;">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                    @csrf
                    <button type="submit" style="width:100%;color:#2563eb;border:1.5px solid #2563eb;border-radius:8px;padding:8px 12px;background:transparent;font-weight:600;font-size:14px;cursor:pointer;">Logout</button>
                </form>
            @else
                <a href="/login" style="color:#2563eb;border:1.5px solid #2563eb;">Sign In</a>
                <a href="/register" style="color:#fff;background:#2563eb;">Sign Up</a>
            @endauth
        </div>
    </div>
</header>

<script>
    (function () {
        var btn = document.getElementById('it-mobile-toggle');
        var menu = document.getElementById('it-mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', function () {
                var open = menu.classList.toggle('it-open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        }

        // User dropdown
        var ubtn = document.getElementById('it-user-btn');
        var umenu = document.getElementById('it-user-menu');
        if (ubtn && umenu) {
            ubtn.addEventListener('click', function (e) {
                e.stopPropagation();
                var open = umenu.hidden;
                umenu.hidden = !open;
                ubtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
            document.addEventListener('click', function (e) {
                if (!ubtn.contains(e.target) && !umenu.contains(e.target)) {
                    umenu.hidden = true;
                    ubtn.setAttribute('aria-expanded', 'false');
                }
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') { umenu.hidden = true; ubtn.setAttribute('aria-expanded', 'false'); }
            });
        }
    })();
</script>