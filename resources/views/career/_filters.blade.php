@php
    $selectedJobTypes = (array) request('job_type', []);
    $selectedExperience = (array) request('experience', []);
    $selectedSalary = (array) request('salary', []);
    $selectedSkills = (array) request('skills', []);
@endphp

<aside class="cr-sidebar" id="cr-sidebar">
    <form method="GET" action="{{ route('career.index') }}" id="cr-filter-form">
        <input type="hidden" name="type" value="{{ $tab }}">
        @if(request('q'))
            <input type="hidden" name="q" value="{{ request('q') }}">
        @endif

        <div class="cr-filter-head">
            <h2>Filters</h2>
            <a href="{{ route('career.index', ['type' => $tab]) }}" class="cr-clear">Clear all</a>
        </div>

        <section class="cr-filter-group">
            <h3>Job Type</h3>
            @foreach($jobTypes as $type)
                <label class="cr-check">
                    <input type="checkbox" name="job_type[]" value="{{ $type }}"
                           {{ in_array($type, $selectedJobTypes) ? 'checked' : '' }}
                           onchange="this.form.submit()">
                    <span>{{ $type }}</span>
                </label>
            @endforeach
        </section>

        <section class="cr-filter-group">
            <h3>Experience Level</h3>
            @foreach($experienceLevels as $level)
                <label class="cr-check">
                    <input type="checkbox" name="experience[]" value="{{ $level }}"
                           {{ in_array($level, $selectedExperience) ? 'checked' : '' }}
                           onchange="this.form.submit()">
                    <span>{{ $level }}</span>
                </label>
            @endforeach
        </section>

        <section class="cr-filter-group">
            <h3>Salary Range</h3>
            @foreach($salaryRanges as $range)
                <label class="cr-check">
                    <input type="checkbox" name="salary[]" value="{{ $range }}"
                           {{ in_array($range, $selectedSalary) ? 'checked' : '' }}
                           onchange="this.form.submit()">
                    <span>{{ $range }}</span>
                </label>
            @endforeach
        </section>

        <section class="cr-filter-group">
            <h3>Skills</h3>
            <div class="cr-skills">
                @foreach($allSkills as $skill)
                    <label class="cr-skill {{ in_array($skill, $selectedSkills) ? 'on' : '' }}">
                        <input type="checkbox" name="skills[]" value="{{ $skill }}"
                               {{ in_array($skill, $selectedSkills) ? 'checked' : '' }}
                               onchange="this.form.submit()">
                        {{ $skill }}
                    </label>
                @endforeach
            </div>
        </section>
    </form>
</aside>
