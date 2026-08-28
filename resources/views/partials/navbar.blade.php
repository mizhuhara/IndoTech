<header id="it-navbar">
    <div id="it-navbar-inner">

        {{-- Logo --}}
        <a href="/" id="it-logo">IndoTech</a>

        {{-- Desktop Nav --}}
        <nav id="it-nav">
            <a href="/" class="{{ request()->is('/') ? 'it-active' : '' }}">Home</a>
            <a href="/education" class="{{ request()->is('education*') ? 'it-active' : '' }}">Education</a>
            <a href="/industry" class="{{ request()->is('industry*') ? 'it-active' : '' }}">Industry</a>
            <a href="/career" class="{{ request()->is('career*') ? 'it-active' : '' }}">Career</a>
            <a href="/events" class="{{ request()->is('events*') ? 'it-active' : '' }}">Events</a>
            <a href="/knowledge-hub" class="{{ request()->is('knowledge-hub*') ? 'it-active' : '' }}">Knowledge Hub</a>
        </nav>

        {{-- Actions --}}
        <div id="it-actions">
            <button id="it-search-btn" aria-label="Search">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
            <a href="/login" class="it-btn-signin">Sign In</a>
            <a href="/register" class="it-btn-signup">Sign Up</a>

            <button id="it-mobile-toggle" aria-label="Menu">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="it-mobile-menu">
        <a href="/" class="{{ request()->is('/') ? 'it-active' : '' }}">Home</a>
        <a href="/education" class="{{ request()->is('education*') ? 'it-active' : '' }}">Education</a>
        <a href="/industry" class="{{ request()->is('industry*') ? 'it-active' : '' }}">Industry</a>
        <a href="/career" class="{{ request()->is('career*') ? 'it-active' : '' }}">Career</a>
        <a href="/events" class="{{ request()->is('events*') ? 'it-active' : '' }}">Events</a>
        <a href="/knowledge-hub" class="{{ request()->is('knowledge-hub*') ? 'it-active' : '' }}">Knowledge Hub</a>
        <div class="it-mobile-btns">
            <a href="/login" style="color:#2563eb;border:1.5px solid #2563eb;">Sign In</a>
            <a href="/register" style="color:#fff;background:#2563eb;">Sign Up</a>
        </div>
    </div>
</header>

<script>
    (function () {
        var btn = document.getElementById('it-mobile-toggle');
        var menu = document.getElementById('it-mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', function () {
                menu.classList.toggle('it-open');
            });
        }
    })();
</script>