@php
    $tagClass = match($job['category']) {
        'internship' => 'internship',
        'freelance' => 'freelance',
        'remote' => 'remote',
        'graduate' => 'graduate',
        default => 'jobs',
    };
    $tagLabel = $tabs[$job['category']] ?? 'Jobs';
@endphp

<article class="cr-card" id="job-{{ $job['id'] }}">
    <img src="{{ $job['image'] ?? 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=200&fit=crop' }}" alt="{{ $job['company'] }} logo" class="cr-card-image">
    <div class="cr-card-top">
        <div class="cr-logo" style="background: {{ $job['logo_color'] }}">{{ $job['logo_text'] }}</div>
        <span class="cr-tag {{ $tagClass }}">{{ $tagLabel }}</span>
    </div>

    <h3 class="cr-card-title">{{ $job['title'] }}</h3>
    <p class="cr-card-company">{{ $job['company'] }}</p>

    <div class="cr-meta">
        <span class="cr-meta-item">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            {{ $job['salary_range'] }}
        </span>
        <span class="cr-meta-item">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
            </svg>
            {{ $job['location'] }}
        </span>
        <span class="cr-meta-item">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
            </svg>
            {{ $job['job_type'] }} · {{ $job['experience'] }}
        </span>
        <span class="cr-meta-item">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
            </svg>
            Closes: {{ $job['deadline'] }}
        </span>
    </div>

    <div class="cr-skill-row">
        @foreach($job['skills'] as $skill)
            <span class="cr-chip">{{ $skill }}</span>
        @endforeach
    </div>

    <p class="cr-desc">{{ $job['description'] }}</p>

    <div class="cr-card-bottom">
        <span class="it-status"><span class="it-status-dot"></span> {{ $job['status'] }}</span>
        <a href="#apply-{{ $job['id'] }}" class="cr-apply" id="apply-{{ $job['id'] }}">Apply Now</a>
    </div>
</article>
