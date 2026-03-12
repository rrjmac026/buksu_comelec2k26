<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }

.ballot-wrap {
    max-width: 900px;
    margin: 24px auto;
    padding: 0 16px 60px;
}

/* ══ TOP PROGRESS BAR ══ */
.bw-top-bar {
    height: 3px;
    background: rgba(249,180,15,.12);
    border-radius: 99px;
    overflow: hidden;
    margin-bottom: 18px;
}
.bw-top-fill {
    height: 100%;
    background: linear-gradient(90deg, #f9b40f, #fcd558);
    border-radius: 99px;
    box-shadow: 0 0 8px rgba(249,180,15,.5);
    transition: width .5s ease;
}

/* ══ STEP DOTS ══ */
.step-pagination {
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.step-dot {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 800;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    border: 2px solid rgba(255,255,255,.15);
    color: rgba(255,255,255,.45);
    background: rgba(56,0,65,.6);
    transition: all .2s ease;
    flex-shrink: 0;
    cursor: default;
}
.step-dot.past {
    border-color: rgba(249,180,15,.35);
    color: rgba(249,180,15,.7);
    background: rgba(249,180,15,.08);
    cursor: pointer;
}
.step-dot.past:hover {
    border-color: #f9b40f; color: #f9b40f;
    background: rgba(249,180,15,.15);
    transform: scale(1.08);
}
.step-dot.current {
    border-color: #f9b40f;
    color: #380041;
    background: linear-gradient(135deg, #f9b40f, #fcd558);
    box-shadow: 0 0 14px rgba(249,180,15,.55);
    cursor: default;
}
.step-dot.selected-past {
    border-color: rgba(52,211,153,.4);
    color: #34d399;
    background: rgba(52,211,153,.1);
    cursor: pointer;
}
.step-dot.selected-past:hover {
    border-color: #34d399;
    background: rgba(52,211,153,.18);
    transform: scale(1.08);
}

/* ══ BALLOT CARD ══ */
.ballot-card {
    background: rgba(30,0,38,.9);
    border: 1px solid rgba(249,180,15,.18);
    border-radius: 18px;
    box-shadow: 0 8px 48px rgba(0,0,0,.5), inset 0 1px 0 rgba(249,180,15,.07);
    overflow: hidden;
    animation: fadeUp .35s ease both;
}
.ballot-card::before {
    content: '';
    display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes checkPop {
    0%   { transform: scale(0) rotate(-15deg); opacity: 0; }
    60%  { transform: scale(1.3) rotate(5deg);  opacity: 1; }
    100% { transform: scale(1)   rotate(0deg);  opacity: 1; }
}

/* ══ CARD HEADER ══ */
.card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    padding: 24px 28px 20px;
}
.pos-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; border-radius: 99px;
    background: rgba(249,180,15,.1);
    border: 1px solid rgba(249,180,15,.25);
    font-size: .6rem; font-weight: 800;
    letter-spacing: .1em; text-transform: uppercase;
    color: rgba(249,180,15,.8);
    margin-bottom: 8px;
}
.pos-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.65rem; font-weight: 900;
    color: #fffbf0; line-height: 1.1;
}
.pos-hint {
    font-size: .72rem;
    color: rgba(255,251,240,.35);
    margin-top: 5px;
}
.skip-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 18px; border-radius: 9px;
    border: 1px solid rgba(255,251,240,.18);
    background: transparent;
    font-size: .72rem; font-weight: 700;
    color: rgba(255,251,240,.45);
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    transition: all .18s;
    white-space: nowrap; flex-shrink: 0; margin-top: 4px;
}
.skip-btn:hover {
    border-color: rgba(255,251,240,.32);
    color: rgba(255,251,240,.75);
    background: rgba(255,255,255,.04);
}

/* ══ CANDIDATES ══ */
.candidates-area { padding: 4px 24px 24px; }

.candidates-grid {
    display: grid;
    gap: 16px;
    grid-template-columns: repeat(var(--col-count), 1fr);
}

/* ══ CANDIDATE CARD ══ */
.candidate-card {
    border-radius: 14px;
    border: 2px solid rgba(249,180,15,.1);
    background: rgba(56,0,65,.5);
    overflow: hidden;
    cursor: pointer;
    transition: border-color .22s ease, background .22s ease, box-shadow .22s ease, transform .22s ease;
    position: relative;
    display: flex;
    flex-direction: column;
}
.candidate-card:hover {
    border-color: rgba(249,180,15,.4);
    background: rgba(56,0,65,.85);
    transform: translateY(-4px);
    box-shadow: 0 14px 36px rgba(0,0,0,.4);
}
.candidate-card.is-selected {
    border-color: #f9b40f;
    background: rgba(249,180,15,.07);
    box-shadow: 0 0 0 1px rgba(249,180,15,.25), 0 12px 32px rgba(249,180,15,.14);
}

/* ── Checkmark badge — rendered via real DOM element, not ::after ── */
.check-badge {
    position: absolute;
    top: 12px; right: 12px;
    width: 30px; height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f9b40f, #fcd558);
    color: #380041;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem;
    box-shadow: 0 2px 12px rgba(249,180,15,.6);
    z-index: 10;
    animation: checkPop .32s cubic-bezier(.34,1.56,.64,1) both;
    /* pointer-events none so clicks still register on the card */
    pointer-events: none;
}

/* Photo */
.c-photo-wrap {
    width: 100%;
    height: 360px;
    overflow: hidden;
    background: rgba(26,0,32,1);
    flex-shrink: 0;
}
.c-photo {
    width: 100%; height: 100%;
    object-fit: cover;
    object-position: top center;
    display: block;
    transition: transform .3s ease;
}
.candidate-card:hover .c-photo { transform: scale(1.04); }

/* Initial placeholder */
.c-initial-wrap {
    width: 100%; height: 360px;
    background: linear-gradient(160deg, rgba(56,0,65,.9), rgba(26,0,32,1));
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.c-initial {
    width: 100px; height: 100px; border-radius: 50%;
    background: linear-gradient(135deg, #380041, #520060);
    border: 3px solid rgba(249,180,15,.3);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem; font-weight: 900; color: #f9b40f;
}

/* Info block */
.c-info {
    padding: 14px 16px 18px;
    text-align: center;
    background: rgba(26,0,32,.45);
    border-top: 1px solid rgba(249,180,15,.08);
    flex: 1;
}
.c-name {
    font-size: .95rem; font-weight: 800;
    color: #fffbf0; line-height: 1.3;
    margin-bottom: 8px;
    font-family: 'DM Sans', sans-serif;
}
.candidate-card.is-selected .c-name { color: #fcd558; }
.c-party-badge {
    display: inline-block;
    padding: 4px 14px; border-radius: 99px;
    font-size: .65rem; font-weight: 800;
    letter-spacing: .06em; text-transform: uppercase;
    background: rgba(249,180,15,.15);
    border: 1px solid rgba(249,180,15,.35);
    color: #f9b40f;
    margin-bottom: 7px;
}
.c-course { font-size: .68rem; color: rgba(255,251,240,.4); margin-top: 2px; }
.c-college { font-size: .63rem; color: rgba(255,251,240,.25); margin-top: 1px; }

.no-candidates {
    padding: 50px 28px; text-align: center;
    color: rgba(255,251,240,.2); font-size: .82rem;
}

/* ══ FOOTER ══ */
.card-footer {
    padding: 14px 28px 24px;
    border-top: 1px solid rgba(249,180,15,.07);
    display: flex; align-items: center;
    justify-content: space-between; gap: 12px;
}
.selection-hint {
    font-size: .7rem; color: rgba(255,251,240,.25);
    display: flex; align-items: center; gap: 6px;
}
.selection-chosen {
    font-size: .7rem; font-weight: 700; color: #f9b40f;
    display: flex; align-items: center; gap: 6px;
}
.btn-group { display: flex; gap: 10px; align-items: center; }
.btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 11px 22px; border-radius: 10px;
    font-size: .78rem; font-weight: 700;
    cursor: pointer; transition: all .18s;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none; border: none;
}
.btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 4px 16px rgba(249,180,15,.3), inset 0 1px 0 rgba(255,255,255,.2);
}
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(249,180,15,.45); }
.btn-primary[disabled], .btn-primary:disabled {
    opacity: .35; cursor: not-allowed; transform: none; box-shadow: none;
}
.btn-ghost {
    background: transparent;
    border: 1px solid rgba(249,180,15,.2);
    color: rgba(249,180,15,.65);
}
.btn-ghost:hover { background: rgba(249,180,15,.07); border-color: rgba(249,180,15,.35); color: #f9b40f; }

.err-alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 18px; border-radius: 12px;
    background: rgba(239,68,68,.09); border: 1px solid rgba(239,68,68,.22);
    margin-bottom: 16px;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 600px) {
    .card-header { padding: 16px 16px 14px; flex-direction: column; }
    .candidates-area { padding: 4px 14px 18px; }
    .candidates-grid { gap: 10px; grid-template-columns: repeat(2, 1fr) !important; }
    .c-photo-wrap, .c-initial-wrap { height: 200px; }
    .card-footer { padding: 12px 16px 20px; flex-direction: column; align-items: flex-start; }
    .btn-group { width: 100%; justify-content: flex-end; }
    .pos-title { font-size: 1.2rem; }
    .step-dot { width: 32px; height: 32px; font-size: .62rem; }
    .step-pagination { gap: 5px; }
}
</style>
@endpush

<div class="ballot-wrap" x-data="stepPage()" x-init="init()">

    {{-- Progress bar --}}
    <div class="bw-top-bar">
        <div class="bw-top-fill" style="width:{{ round(($step / $totalSteps) * 100) }}%"></div>
    </div>

    {{-- Step dots --}}
    <div class="step-pagination">
        @foreach($steps as $s)
            @php
                $isPast      = $s['step'] < $step;
                $isCurrent   = $s['step'] === $step;
                $wasSelected = $isPast && $s['status'] === 'selected';
                $dotClass    = $isCurrent ? 'current'
                             : ($wasSelected ? 'selected-past'
                             : ($isPast ? 'past' : 'pending'));
            @endphp
            @if($isPast)
                <a href="{{ route('voter.vote.step', $s['step']) }}"
                   class="step-dot {{ $dotClass }}"
                   title="Go back to: {{ $s['name'] }}">{{ $s['step'] }}</a>
            @else
                <span class="step-dot {{ $dotClass }}" title="{{ $s['name'] }}">{{ $s['step'] }}</span>
            @endif
        @endforeach
    </div>

    {{-- Errors --}}
    @if($errors->any())
    <div class="err-alert">
        <i class="fas fa-circle-exclamation" style="color:#f87171;flex-shrink:0;"></i>
        <span style="font-size:.73rem;font-weight:600;color:#f87171;">{{ $errors->first() }}</span>
    </div>
    @endif

    {{-- Main card --}}
    <div class="ballot-card">

        {{-- Header --}}
        <div class="card-header">
            <div>
                <div class="pos-badge">
                    <i class="fas fa-circle-dot"></i>
                    Position {{ $step }} of {{ $totalSteps }}
                </div>
                <div class="pos-title">{{ $position->name }}</div>
                <div class="pos-hint">Select one candidate below, or skip this position.</div>
            </div>
            <form method="POST" action="{{ route('voter.vote.step.save', $step) }}">
                @csrf
                <input type="hidden" name="action" value="skip">
                <button type="submit" class="skip-btn">
                    Skip <i class="fas fa-forward-step"></i>
                </button>
            </form>
        </div>

        {{-- Candidates --}}
        @php
            $count    = $position->candidates->count();
            $colCount = $count === 0 ? 1 : min($count, 4);
        @endphp

        <div class="candidates-area">
            @if($count === 0)
                <div class="no-candidates">
                    <i class="fas fa-user-slash" style="font-size:2rem;display:block;margin-bottom:12px;opacity:.18;"></i>
                    No candidates registered for this position.
                </div>
            @else
                <div class="candidates-grid" style="--col-count: {{ $colCount }};">
                    @foreach($position->candidates as $candidate)

                    {{-- NOTE: x-bind:class uses 'is-selected' (not 'selected') to avoid
                         conflict with any global CSS using .selected --}}
                    <div
                        class="candidate-card"
                        :class="{ 'is-selected': chosen === {{ $candidate->candidate_id }} }"
                        @click="select({{ $candidate->candidate_id }})"
                    >
                        {{-- ✅ Checkmark badge — real DOM element, always visible when chosen --}}
                        <div class="check-badge"
                             x-show="chosen === {{ $candidate->candidate_id }}"
                             x-cloak
                             style="display:none;">
                            <i class="fas fa-check"></i>
                        </div>

                        @if($candidate->photo)
                        <div class="c-photo-wrap">
                            <img src="{{ asset('images/candidates/' . $candidate->photo) }}"
                                 class="c-photo" alt="{{ $candidate->full_name }}">
                        </div>
                        @else
                        <div class="c-initial-wrap">
                            <div class="c-initial">{{ strtoupper(substr($candidate->first_name, 0, 1)) }}</div>
                        </div>
                        @endif

                        <div class="c-info">
                            <div class="c-name">{{ $candidate->full_name }}</div>
                            @if($candidate->partylist)
                                <div><span class="c-party-badge">{{ $candidate->partylist->name }}</span></div>
                            @endif
                            @if($candidate->course)
                                <div class="c-course">{{ $candidate->course }}</div>
                            @endif
                            @if($candidate->college)
                                <div class="c-college">{{ $candidate->college->acronym ?? $candidate->college->name }}</div>
                            @endif
                        </div>
                    </div>

                    @endforeach
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <form method="POST" action="{{ route('voter.vote.step.save', $step) }}" id="step-form">
            @csrf
            <input type="hidden" name="action" value="select">
            <input type="hidden" name="candidate_id" x-model="chosen">

            <div class="card-footer">
                <div>
                    <div class="selection-hint" x-show="!chosen">
                        <i class="fas fa-hand-pointer" style="font-size:.65rem;"></i>
                        Tap a candidate to select
                    </div>
                    <div class="selection-chosen" x-show="chosen" x-cloak>
                        <i class="fas fa-check-circle" style="color:#34d399;"></i>
                        <span x-text="chosenName"></span>
                    </div>
                </div>

                <div class="btn-group">
                    {{-- Back --}}
                    @if($step > 1)
                    <form method="POST" action="{{ route('voter.vote.step.save', $step) }}" style="margin:0;">
                        @csrf
                        <input type="hidden" name="action" value="back">
                        <button type="submit" class="btn btn-ghost">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                    </form>
                    @else
                    <a href="{{ route('voter.vote.intro') }}" class="btn btn-ghost">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    @endif

                    {{-- Next / Review --}}
                    <button type="submit" form="step-form" class="btn btn-primary"
                            :disabled="!chosen" x-bind:disabled="!chosen">
                        @if($step === $totalSteps)
                            Review Ballot <i class="fas fa-eye"></i>
                        @else
                            Next <i class="fas fa-arrow-right"></i>
                        @endif
                    </button>
                </div>
            </div>
        </form>

    </div>{{-- /.ballot-card --}}

</div>{{-- /.ballot-wrap --}}

@push('scripts')
<script>
function stepPage() {
    return {
        chosen: {{ $selectedId ?? 'null' }},
        chosenName: '',
        candidates: {
            @foreach($position->candidates as $c)
            {{ $c->candidate_id }}: '{{ addslashes($c->full_name) }}',
            @endforeach
        },
        init() {
            if (this.chosen) this.chosenName = this.candidates[this.chosen] ?? '';
        },
        select(id) {
            if (this.chosen === id) {
                this.chosen = null;
                this.chosenName = '';
            } else {
                this.chosen = id;
                this.chosenName = this.candidates[id] ?? '';
            }
        }
    }
}
</script>
@endpush
</x-app-layout>