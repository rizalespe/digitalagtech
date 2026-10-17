@extends('layouts.app')

@section('title', 'Assessment Result — ' . $attempt->startup_name)

@push('styles')
<style>
/* ── Result page ── */
.result-hero {
    background: var(--green-800);
    padding: 56px var(--pad-x) 48px;
    color: #fff;
}
.assessment-steps {
    display: flex;
    align-items: center;
    gap: 0;
    margin-bottom: 32px;
}
.step-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: rgba(255,255,255,.45);
}
.step-item.active { color: #fff; }
.step-item.done { color: rgba(255,255,255,.7); }
.step-num {
    width: 28px; height: 28px;
    border-radius: 50%;
    border: 2px solid currentColor;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; flex-shrink: 0;
}
.step-item.active .step-num { background: var(--green-400); border-color: var(--green-400); color: #fff; }
.step-item.done .step-num { background: rgba(255,255,255,.2); border-color: rgba(255,255,255,.4); }
.step-sep { width: 40px; height: 2px; background: rgba(255,255,255,.2); margin: 0 8px; }

.result-hero-inner { max-width: 860px; margin: 0 auto; }

.stage-badge-row { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 16px; }
.stage-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: .04em;
    text-transform: uppercase;
}
.stage-discover { background: #f5a623; color: #5a3500; }
.stage-build    { background: #4fc3f7; color: #0d3047; }
.stage-scale    { background: #66bb6a; color: #1b3a1b; }

.result-hero h1 { font-family: var(--font-display); font-size: clamp(24px,3.5vw,38px); font-weight: 600; margin-bottom: 6px; }
.result-hero .meta { color: rgba(255,255,255,.7); font-size: 14px; }

/* Score gauge */
.score-row {
    display: flex;
    align-items: center;
    gap: 24px;
    margin-top: 28px;
    flex-wrap: wrap;
}
.score-circle-wrap { position: relative; width: 90px; height: 90px; flex-shrink: 0; }
.score-circle-wrap svg { transform: rotate(-90deg); }
.score-circle-text {
    position: absolute; inset: 0;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
}
.score-circle-text .pct { font-size: 22px; font-weight: 800; color: #fff; }
.score-circle-text .lbl { font-size: 10px; color: rgba(255,255,255,.6); font-weight: 600; text-transform: uppercase; letter-spacing: .06em; }
.score-desc { flex: 1; }
.score-desc p { color: rgba(255,255,255,.85); font-size: 15px; line-height: 1.6; }

/* ── Body ── */
.result-body { max-width: 860px; margin: 0 auto; padding: 48px var(--pad-x) 80px; }

.result-section-title { font-size: 11px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--fg-subtle); margin-bottom: 14px; }

/* Dimension scores */
.dim-grid { display: flex; flex-direction: column; gap: 10px; margin-bottom: 40px; }
.dim-row {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 14px 18px;
    display: grid;
    grid-template-columns: 1fr 80px 120px;
    align-items: center;
    gap: 12px;
}
@media (max-width: 600px) { .dim-row { grid-template-columns: 1fr; } }
.dim-name { font-size: 14px; font-weight: 600; }
.dim-answer { font-size: 13px; color: var(--fg-muted); }
.dim-bar-wrap { display: flex; align-items: center; gap: 8px; }
.dim-bar-track { flex: 1; height: 6px; background: var(--border); border-radius: 3px; overflow: hidden; }
.dim-bar-fill { height: 100%; border-radius: 3px; transition: width .5s; }
.dim-score-lbl { font-size: 12px; font-weight: 700; color: var(--fg-muted); white-space: nowrap; }

/* Stage description card */
.stage-card {
    border-radius: var(--radius-md);
    padding: 28px;
    margin-bottom: 40px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
}
.stage-card.discover { background: #fff8ec; border: 1.5px solid #f5c872; }
.stage-card.build    { background: #eaf7fc; border: 1.5px solid #7dd3f0; }
.stage-card.scale    { background: #eafbea; border: 1.5px solid #81c784; }
[data-theme=dark] .stage-card.discover { background: #2d2100; border-color: #8a6a00; }
[data-theme=dark] .stage-card.build    { background: #002030; border-color: #1a6480; }
[data-theme=dark] .stage-card.scale    { background: #0b2510; border-color: #2d6e30; }
.stage-card-icon { font-size: 32px; flex-shrink: 0; }
.stage-card-body h3 { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
.stage-card-body p  { font-size: 14px; line-height: 1.65; color: var(--fg-muted); }

/* Recommended toolkits */
.toolkits-row { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; }
.toolkit-chip {
    padding: 8px 16px;
    border-radius: 100px;
    border: 1.5px solid var(--green-600);
    color: var(--green-800);
    font-size: 13px; font-weight: 600;
    text-decoration: none;
    transition: background .15s;
}
.toolkit-chip:hover { background: var(--green-50); }

/* Events */
.events-list { display: grid; gap: 14px; margin-bottom: 40px; }
.event-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 18px 22px;
    text-decoration: none;
    color: inherit;
    transition: border-color .15s, box-shadow .15s;
}
.event-card:hover { border-color: var(--green-500); box-shadow: 0 2px 12px rgba(0,0,0,.06); }
.event-date-box {
    width: 52px; height: 56px;
    background: var(--green-700);
    color: #fff;
    border-radius: 10px;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.event-date-box .day  { font-size: 20px; font-weight: 800; line-height: 1; }
.event-date-box .mon  { font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; opacity: .8; }
.event-info { flex: 1; min-width: 0; }
.event-info h4 { font-size: 15px; font-weight: 700; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.event-info p  { font-size: 13px; color: var(--fg-muted); }
.event-reg-btn { padding: 8px 18px; border-radius: 8px; background: var(--green-700); color: #fff; font-size: 13px; font-weight: 700; white-space: nowrap; flex-shrink: 0; }

/* CTA */
.result-cta { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px; }
</style>
@endpush

@section('content')
@php
    $score = $attempt->total_score;
    $stageClass = strtolower($attempt->stage);

    $stageDescriptions = [
        'Discover' => [
            'icon' => '🌱',
            'title' => 'You\'re at the Discover Stage',
            'text' => 'Your startup is in the early exploration phase. Focus on deeply understanding the problem you\'re solving and validating your assumptions with real users. This is the most critical — and exciting — phase of your journey.',
        ],
        'Build' => [
            'icon' => '🔨',
            'title' => 'You\'re at the Build Stage',
            'text' => 'You have a clear problem and early validation. Now it\'s time to build a product that users love, establish repeatable processes, and prove your business model. Stay lean and iterate quickly based on feedback.',
        ],
        'Scale' => [
            'icon' => '🚀',
            'title' => 'You\'re at the Scale Stage',
            'text' => 'Congratulations — you have a proven model! Focus on accelerating growth, expanding to new markets, building your team, and securing the partnerships and capital needed to reach your full potential.',
        ],
    ];
    $stageInfo = $stageDescriptions[$attempt->stage] ?? $stageDescriptions['Discover'];

    // Build per-dimension answer map
    $answerMap = $attempt->answers->keyBy(fn ($a) => $a->assessment_question_id);
@endphp

<div class="assessment-page">

    <div class="result-hero">
        <div class="result-hero-inner">
            <div class="assessment-steps">
                <div class="step-item done">
                    <span class="step-num">01</span>
                    <span class="step-label">Diagnose Test</span>
                </div>
                <span class="step-sep"></span>
                <div class="step-item active">
                    <span class="step-num">02</span>
                    <span class="step-label">Test Result</span>
                </div>
                <span class="step-sep"></span>
                <div class="step-item">
                    <span class="step-num">03</span>
                    <span class="step-label">Event Registration</span>
                </div>
            </div>

            <div class="stage-badge-row">
                <span class="stage-badge stage-{{ $stageClass }}">{{ $attempt->stage }} Stage</span>
                <span style="color:rgba(255,255,255,.55);font-size:13px">{{ $attempt->sector }}</span>
            </div>

            <h1>{{ $attempt->startup_name }}</h1>
            <p class="meta">{{ $attempt->founder_name }} &middot; Completed {{ $attempt->completed_at?->format('d M Y') }}</p>

            <div class="score-row">
                @php
                    $radius = 36;
                    $circumference = 2 * M_PI * $radius;
                    $dash = round($score / 100 * $circumference, 2);
                @endphp
                <div class="score-circle-wrap">
                    <svg width="90" height="90" viewBox="0 0 90 90">
                        <circle cx="45" cy="45" r="{{ $radius }}" stroke="rgba(255,255,255,.15)" stroke-width="7" fill="none" />
                        <circle cx="45" cy="45" r="{{ $radius }}"
                            stroke="#{{ $attempt->stage === 'Scale' ? '66bb6a' : ($attempt->stage === 'Build' ? '4fc3f7' : 'f5a623') }}"
                            stroke-width="7" fill="none"
                            stroke-dasharray="{{ $dash }} {{ $circumference }}"
                            stroke-linecap="round" />
                    </svg>
                    <div class="score-circle-text">
                        <span class="pct">{{ $score }}%</span>
                        <span class="lbl">Score</span>
                    </div>
                </div>
                <div class="score-desc">
                    <p>Your startup scored <strong>{{ $score }}%</strong> across {{ $attempt->answers->count() }} diagnostic dimensions. {{ $stageInfo['text'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="result-body">

        {{-- Stage explanation card --}}
        <div class="stage-card {{ $stageClass }}">
            <span class="stage-card-icon">{{ $stageInfo['icon'] }}</span>
            <div class="stage-card-body">
                <h3>{{ $stageInfo['title'] }}</h3>
                <p>{{ $stageInfo['text'] }}</p>
            </div>
        </div>

        {{-- Per-dimension breakdown --}}
        <p class="result-section-title">Dimension Breakdown</p>
        <div class="dim-grid">
            @foreach($attempt->answers as $answer)
                @php
                    $option = $answer->option;
                    $barPct = $option ? round($option->score / 5 * 100) : 0;
                    $barColor = $barPct >= 80 ? '#66bb6a' : ($barPct >= 60 ? '#4fc3f7' : ($barPct >= 40 ? '#f5a623' : '#ef5350'));
                @endphp
                <div class="dim-row">
                    <div>
                        <p class="dim-name">{{ $answer->question->dimension->name ?? '—' }}</p>
                        <p class="dim-answer">Option {{ $option?->label }}: {{ Str::limit($option?->text, 70) }}</p>
                    </div>
                    <div class="dim-bar-wrap" style="grid-column:2/3">
                        <div class="dim-bar-track">
                            <div class="dim-bar-fill" style="width:{{ $barPct }}%;background:{{ $barColor }}"></div>
                        </div>
                    </div>
                    <p class="dim-score-lbl">{{ $option?->score ?? 0 }}/5</p>
                </div>
            @endforeach
        </div>

        {{-- Recommended toolkits --}}
        @if(count($recommendedToolkits))
        <p class="result-section-title">Recommended Learning Paths</p>
        <div class="toolkits-row">
            @foreach($recommendedToolkits as $tk)
                <a href="{{ route('programs.self-learning') }}#toolkit" class="toolkit-chip">{{ $tk }}</a>
            @endforeach
        </div>
        @endif

        {{-- Upcoming events --}}
        @if($upcomingEvents->isNotEmpty())
        <p class="result-section-title">Register for an Upcoming Event</p>
        <div class="events-list">
            @foreach($upcomingEvents as $event)
            <a href="{{ route('events.show', $event) }}" class="event-card">
                <div class="event-date-box">
                    <span class="day">{{ $event->starts_at->format('d') }}</span>
                    <span class="mon">{{ $event->starts_at->format('M') }}</span>
                </div>
                <div class="event-info">
                    <h4>{{ $event->title }}</h4>
                    <p>{{ $event->starts_at->format('D, d M Y') }} &middot; {{ $event->location ?? 'Online' }}</p>
                </div>
                <span class="event-reg-btn">Register</span>
            </a>
            @endforeach
        </div>
        @endif

        <div class="result-cta">
            <a href="{{ route('assessment.index') }}" class="btn btn-outline">Retake Assessment</a>
            <a href="{{ route('programs.self-learning') }}" class="btn btn-primary">Explore Learning Programs</a>
        </div>
    </div>
</div>
@endsection
