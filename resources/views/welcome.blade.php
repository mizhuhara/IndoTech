@extends('layouts.app')

@section('title', 'IndoTech — Connect With Indonesia\'s IT Ecosystem')

@section('content')
    {{-- HERO --}}
    <section class="it-hero">
        <div class="it-hero-content">
            <h1>Connect With Indonesia's IT Ecosystem</h1>
            <p class="it-hero-sub">
                Your premier platform for discovering top education, leading tech companies,
                vibrant communities, and career opportunities in Indonesia's digital landscape.
            </p>

            {{-- Search Bar --}}
            <form class="it-hero-search" action="/search" method="GET">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="q" placeholder="Search for campuses, schools, companies, jobs, internships, events, courses, or opportunities...">
                <button type="submit">Search</button>
            </form>

            {{-- Category Icons --}}
            <div class="it-categories">
                <a href="/campus" class="it-cat-item">
                    <span class="it-cat-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                        </svg>
                    </span>
                    Campus
                </a>
                <a href="/vocational" class="it-cat-item">
                    <span class="it-cat-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/>
                        </svg>
                    </span>
                    Vocational School
                </a>
                <a href="/company" class="it-cat-item">
                    <span class="it-cat-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                        </svg>
                    </span>
                    Company
                </a>
                <a href="/jobs" class="it-cat-item">
                    <span class="it-cat-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                    </span>
                    Jobs
                </a>
                <a href="/internship" class="it-cat-item">
                    <span class="it-cat-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                    </span>
                    Internship
                </a>
                <a href="/scholarship" class="it-cat-item">
                    <span class="it-cat-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </span>
                    Scholarship
                </a>
                <a href="/events" class="it-cat-item">
                    <span class="it-cat-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                    </span>
                    Events
                </a>
                <a href="/knowledge-hub" class="it-cat-item">
                    <span class="it-cat-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </span>
                    Knowledge
                </a>
            </div>
        </div>
    </section>

    {{-- FEATURED OPPORTUNITIES --}}
    <section class="it-featured">
        <div class="it-featured-header">
            <div>
                <h2>Featured Opportunities</h2>
                <p>Discover curated opportunities to advance your tech career.</p>
            </div>
            <a href="/opportunities">View All &rarr;</a>
        </div>

        <div class="it-cards-grid">
            {{-- Card 1: Jobs --}}
            <div class="it-card">
                <div class="it-card-top">
                    <div class="it-card-logo" style="background:#16a34a;">GT</div>
                    <span class="it-card-tag jobs">Jobs</span>
                </div>
                <h3 class="it-card-title">Senior Frontend Developer</h3>
                <p class="it-card-company">GoTech Indonesia</p>
                <div class="it-card-details">
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        Jakarta, Indonesia (Hybrid)
                    </div>
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        Full-Time
                    </div>
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        Closes: Oct 30, 2024
                    </div>
                </div>
                <div class="it-card-bottom">
                    <span class="it-status"><span class="it-status-dot"></span> Open</span>
                    <a href="#" class="it-apply-btn">Apply Now</a>
                </div>
            </div>

            {{-- Card 2: Internship --}}
            <div class="it-card">
                <div class="it-card-top">
                    <div class="it-card-logo" style="background:#2563eb;">DF</div>
                    <span class="it-card-tag internship">Internship</span>
                </div>
                <h3 class="it-card-title">Data Science Internship</h3>
                <p class="it-card-company">DataFlow Analytics</p>
                <div class="it-card-details">
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        Bandung, Indonesia (Remote)
                    </div>
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        3 Months
                    </div>
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        Closes: Nov 15, 2024
                    </div>
                </div>
                <div class="it-card-bottom">
                    <span class="it-status"><span class="it-status-dot"></span> Open</span>
                    <a href="#" class="it-apply-btn">Apply Now</a>
                </div>
            </div>

            {{-- Card 3: Scholarship --}}
            <div class="it-card">
                <div class="it-card-top">
                    <div class="it-card-logo" style="background:#7c3aed;">MC</div>
                    <span class="it-card-tag scholarship">Scholarship</span>
                </div>
                <h3 class="it-card-title">Future Tech Leaders Scholarship</h3>
                <p class="it-card-company">Ministry of Communication and IT</p>
                <div class="it-card-details">
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                        National (Indonesia)
                    </div>
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347"/>
                        </svg>
                        Bachelor's Degree
                    </div>
                    <div class="it-card-detail">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                        </svg>
                        Closes: Dec 01, 2024
                    </div>
                </div>
                <div class="it-card-bottom">
                    <span class="it-status"><span class="it-status-dot"></span> Open</span>
                    <a href="#" class="it-apply-btn">Apply Now</a>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <div class="it-cta-wrap">
        <div class="it-cta">
            <div class="it-cta-text">
                <h2>Build Your Future in Technology</h2>
                <p>Join Indonesia's rapidly growing IT ecosystem.
                   Connect with peers, find mentors, and discover opportunities
                   that match your skills.</p>
            </div>
            <div class="it-cta-btns">
                <a href="/register" class="it-cta-btn-primary">Create Your Profile</a>
                <a href="/opportunities" class="it-cta-btn-secondary">Explore Opportunities</a>
            </div>
        </div>
    </div>
@endsection