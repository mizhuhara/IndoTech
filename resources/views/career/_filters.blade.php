@php
    $selectedJobTypes = (array) request('job_type', []);
    $selectedExperience = (array) request('experience', []);
    $selectedSalary = (array) request('salary', []);
    $selectedSkills = (array) request('skills', []);
    $totalActiveFilters = count($selectedJobTypes) + count($selectedExperience) + count($selectedSalary) + count($selectedSkills);
@endphp

<aside class="cr-sidebar" id="cr-sidebar">
    <form method="GET" action="{{ route('career.index') }}" id="cr-filter-form">
        <input type="hidden" name="type" value="{{ $tab }}">
        @if(request('q'))
            <input type="hidden" name="q" value="{{ request('q') }}">
        @endif

        <div class="cr-filter-card">
            {{-- Header --}}
            <div class="cr-filter-header">
                <div class="cr-filter-title-wrap">
                    <span class="cr-filter-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                    </span>
                    <h2 class="cr-filter-title">Filter Lowongan</h2>
                    @if($totalActiveFilters > 0)
                        <span style="font-size: 11px; font-weight: 700; background: #eff6ff; color: #2563eb; padding: 2px 7px; border-radius: 99px;">{{ $totalActiveFilters }}</span>
                    @endif
                </div>
                @if($totalActiveFilters > 0 || request('q'))
                    <a href="{{ route('career.index', ['type' => $tab]) }}" class="cr-clear">Reset</a>
                @endif
            </div>

            {{-- Job Type --}}
            <section class="cr-filter-section">
                <div class="cr-filter-section-title">
                    <span>Tipe Pekerjaan</span>
                </div>
                <div class="cr-check-row">
                    @foreach($jobTypes as $type)
                        @php $isChecked = in_array($type, $selectedJobTypes); @endphp
                        <label class="cr-check-item {{ $isChecked ? 'active' : '' }}">
                            <input type="checkbox" name="job_type[]" value="{{ $type }}"
                                   {{ $isChecked ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>{{ $type }}</span>
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Experience Level --}}
            <section class="cr-filter-section">
                <div class="cr-filter-section-title">
                    <span>Pengalaman</span>
                </div>
                <div class="cr-check-row">
                    @foreach($experienceLevels as $level)
                        @php $isChecked = in_array($level, $selectedExperience); @endphp
                        <label class="cr-check-item {{ $isChecked ? 'active' : '' }}">
                            <input type="checkbox" name="experience[]" value="{{ $level }}"
                                   {{ $isChecked ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>{{ $level }} Level</span>
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Salary Range --}}
            <section class="cr-filter-section">
                <div class="cr-filter-section-title">
                    <span>Estimasi Gaji</span>
                </div>
                <div class="cr-check-row">
                    @foreach($salaryRanges as $range)
                        @php $isChecked = in_array($range, $selectedSalary); @endphp
                        <label class="cr-check-item {{ $isChecked ? 'active' : '' }}">
                            <input type="checkbox" name="salary[]" value="{{ $range }}"
                                   {{ $isChecked ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>{{ $range }}</span>
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Skills --}}
            <section class="cr-filter-section">
                <div class="cr-filter-section-title">
                    <span>Keahlian Populer</span>
                </div>
                <div class="cr-skills-cloud">
                    @foreach($allSkills as $skill)
                        @php $isChecked = in_array($skill, $selectedSkills); @endphp
                        <label class="cr-skill-pill {{ $isChecked ? 'active' : '' }}">
                            <input type="checkbox" name="skills[]" value="{{ $skill }}"
                                   {{ $isChecked ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span>{{ $skill }}</span>
                        </label>
                    @endforeach
                </div>
            </section>
        </div>
    </form>
</aside>
