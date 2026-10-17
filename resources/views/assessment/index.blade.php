@extends('layouts.app')

@section('title', 'Diagnose Test — Startup Assessment')

@push('styles')
<style>
/* ── Assessment page ── */
.assessment-page { background: var(--bg); }

.assessment-hero {
    background: var(--green-800);
    padding: 56px var(--pad-x) 40px;
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
.step-num {
    width: 28px; height: 28px;
    border-radius: 50%;
    border: 2px solid currentColor;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; flex-shrink: 0;
}
.step-item.active .step-num { background: var(--green-400); border-color: var(--green-400); color: #fff; }
.step-sep { width: 40px; height: 2px; background: rgba(255,255,255,.2); margin: 0 8px; }

.assessment-hero h1 { font-family: var(--font-display); font-size: clamp(26px,4vw,40px); font-weight: 600; }
.assessment-hero p { color: rgba(255,255,255,.75); margin-top: 10px; font-size: 16px; }

/* ── Form layout ── */
.assessment-body { max-width: 960px; margin: 0 auto; padding: 48px var(--pad-x) 80px; }

.form-section {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    margin-bottom: 24px;
    overflow: hidden;
}
.form-section-header {
    padding: 18px 28px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 12px;
}
.form-section-letter {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: var(--green-700);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 800; flex-shrink: 0;
}
.form-section-header h2 { font-size: 15px; font-weight: 700; }
.form-section-header p { font-size: 13px; color: var(--fg-muted); margin-top: 2px; }
.form-section-body { padding: 28px; }

/* ── Info fields ── */
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
@media (max-width: 600px) { .info-grid { grid-template-columns: 1fr; } }

.field-label { font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block; }
.field-label .req { color: #c0392b; }
.text-input {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    background: var(--bg);
    color: var(--fg);
    transition: border-color .15s;
}
.text-input:focus { outline: none; border-color: var(--green-600); }
.text-input.is-invalid { border-color: #e4a69d; }
.field-error { font-size: 12px; color: #c0392b; font-weight: 600; margin-top: 5px; }

/* ── Questions ── */
.question-block { padding: 24px 28px; border-bottom: 1px solid var(--border); }
.question-block:last-child { border-bottom: none; }
.question-counter {
    font-size: 11px; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: var(--green-600); margin-bottom: 6px;
}
.question-text { font-size: 15px; font-weight: 600; line-height: 1.5; margin-bottom: 16px; }
.question-dim { font-size: 12px; color: var(--fg-muted); font-weight: 600; margin-bottom: 4px; }

.options-list { display: flex; flex-direction: column; gap: 8px; }
.option-label {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 16px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    transition: border-color .15s, background .15s;
}
.option-label:hover { border-color: var(--green-500); background: var(--green-50); }
.option-label input[type=radio] { display: none; }
.option-label input[type=radio]:checked ~ .option-content { color: var(--green-800); }
.option-label:has(input:checked) {
    border-color: var(--green-600);
    background: var(--green-50);
}
.option-badge {
    width: 26px; height: 26px; border-radius: 50%;
    border: 2px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 800;
    flex-shrink: 0; margin-top: 1px;
    transition: border-color .15s, background .15s, color .15s;
    color: var(--fg-subtle);
}
.option-label:has(input:checked) .option-badge {
    background: var(--green-700); border-color: var(--green-700); color: #fff;
}
.option-content { font-size: 14px; line-height: 1.55; }

/* ── Progress bar ── */
.progress-bar-wrap {
    position: sticky;
    top: 0;
    background: var(--bg);
    border-bottom: 1px solid var(--border);
    padding: 12px var(--pad-x);
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 16px;
}
.progress-track { flex: 1; height: 6px; background: var(--border); border-radius: 3px; overflow: hidden; }
.progress-fill { height: 100%; background: var(--green-600); border-radius: 3px; transition: width .3s; width: 0%; }
.progress-label { font-size: 13px; font-weight: 600; color: var(--fg-muted); white-space: nowrap; }

/* ── Submit ── */
.assessment-submit {
    margin-top: 32px;
    display: flex;
    justify-content: flex-end;
}
</style>
@endpush

@section('content')

<div class="assessment-page">

    <div class="assessment-hero">
        <div style="max-width:960px;margin:0 auto">
            <div class="assessment-steps">
                <div class="step-item active">
                    <span class="step-num">01</span>
                    <span class="step-label">Diagnose Test</span>
                </div>
                <span class="step-sep"></span>
                <div class="step-item">
                    <span class="step-num">02</span>
                    <span class="step-label">Test Result</span>
                </div>
                <span class="step-sep"></span>
                <div class="step-item">
                    <span class="step-num">03</span>
                    <span class="step-label">Event Registration</span>
                </div>
            </div>
            <h1>Diagnose Your Startup</h1>
            <p>Answer a few questions to understand your startup stage and discover the next steps for your journey.</p>
        </div>
    </div>

    {{-- Sticky progress bar --}}
    <div class="progress-bar-wrap" id="progressBar">
        <div class="progress-track"><div class="progress-fill" id="progressFill"></div></div>
        <span class="progress-label"><span id="progressCount">0</span>/{{ $dimensions->count() }} questions answered</span>
    </div>

    <div class="assessment-body">

        @if ($errors->any())
            <div style="background:#fdecea;color:#8a1f12;padding:14px 18px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:24px">
                Please answer all {{ $dimensions->count() }} questions before submitting.
            </div>
        @endif

        <form action="{{ route('assessment.store') }}" method="POST" id="assessmentForm">
            @csrf

            {{-- Section A: Startup Info --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="form-section-letter">A</div>
                    <div>
                        <h2>Startup Information</h2>
                        <p>Tell us about your startup identity</p>
                    </div>
                </div>
                <div class="form-section-body">
                    <div class="info-grid">
                        <div>
                            <label class="field-label" for="startup_name">Startup / Business Name <span class="req">*</span></label>
                            <input type="text" id="startup_name" name="startup_name" class="text-input @error('startup_name') is-invalid @enderror"
                                value="{{ old('startup_name') }}" placeholder="e.g. GreenHarvest Technologies" required>
                            @error('startup_name') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="field-label" for="founder_name">Founder / Team Name <span class="req">*</span></label>
                            <input type="text" id="founder_name" name="founder_name" class="text-input @error('founder_name') is-invalid @enderror"
                                value="{{ old('founder_name') }}" placeholder="e.g. Andi Wijaya & Team" required>
                            @error('founder_name') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div style="grid-column:1/-1">
                            <label class="field-label" for="sector">Business Sector <span class="req">*</span></label>
                            <select id="sector" name="sector" class="text-input @error('sector') is-invalid @enderror" required>
                                <option value="" disabled @selected(!old('sector'))>Select your business sector</option>
                                @foreach($sectors as $s)
                                    <option value="{{ $s }}" @selected(old('sector') === $s)>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('sector') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section B: Questions --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="form-section-letter">B</div>
                    <div>
                        <h2>Startup Diagnosis</h2>
                        <p>{{ $dimensions->count() }} diagnostic questions to assess your startup stage</p>
                    </div>
                </div>

                @foreach($dimensions as $i => $dimension)
                    @php $question = $dimension->questions->first(); @endphp
                    @if($question)
                    <div class="question-block">
                        <p class="question-dim">{{ $dimension->name }}</p>
                        <p class="question-counter">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="question-text">{{ $question->question }}</p>
                        <div class="options-list" data-question="{{ $question->id }}">
                            @foreach($question->options as $option)
                            <label class="option-label">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                    @checked(old("answers.{$question->id}") == $option->id)>
                                <span class="option-badge">{{ $option->label }}</span>
                                <span class="option-content">{{ $option->text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <div class="assessment-submit">
                <button type="submit" class="btn btn-primary" style="padding:14px 40px;font-size:15px">
                    Continue to Results
                    <x-icon name="arrow-right" style="width:16px;height:16px;margin-left:6px" />
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const total = {{ $dimensions->count() }};
    const fill  = document.getElementById('progressFill');
    const count = document.getElementById('progressCount');

    function update() {
        const answered = document.querySelectorAll('input[type=radio]:checked').length;
        fill.style.width = (answered / total * 100) + '%';
        count.textContent = answered;
    }

    document.querySelectorAll('input[type=radio]').forEach(r => r.addEventListener('change', update));
    update();
})();
</script>
@endpush
@endsection
