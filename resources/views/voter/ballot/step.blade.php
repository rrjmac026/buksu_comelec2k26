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

    /* ══ MULTI-VOTE COUNTER BADGE ══ */
    .multi-counter {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px; border-radius: 99px;
        background: rgba(249,180,15,.1); border: 1px solid rgba(249,180,15,.25);
        font-size: .72rem; font-weight: 700; color: rgba(249,180,15,.85);
        margin-top: 8px;
        transition: all .2s;
    }
    .multi-counter.at-max {
        background: rgba(52,211,153,.1); border-color: rgba(52,211,153,.35);
        color: #34d399;
    }
    .multi-counter-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: rgba(249,180,15,.7);
        animation: pulse 1.5s ease infinite;
    }
    .multi-counter.at-max .multi-counter-dot { background: #34d399; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

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
        user-select: none;
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
    /* When max reached, dim unselected cards — but keep clicks going so Alpine handles it */
    .candidate-card.is-maxed {
        opacity: .4;
        transform: none !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }

    /* ── Checkmark badge ── */
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
    .c-course  { font-size: .68rem; color: rgba(255,251,240,.4); margin-top: 2px; }
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
    .btn-primary:disabled {
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

    /* ══ VIEW ALL VOTED MODAL ══ */
    .vav-overlay {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(10,0,15,.82);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: flex; align-items: center; justify-content: center;
        padding: 16px;
    }
    .vav-box {
        background: rgba(22,0,28,.97);
        border: 1px solid rgba(249,180,15,.22);
        border-radius: 20px;
        width: 100%; max-width: 500px;
        max-height: 88vh;
        display: flex; flex-direction: column;
        box-shadow: 0 24px 72px rgba(0,0,0,.75);
        overflow: hidden;
        animation: vavSlideUp .28s cubic-bezier(.34,1.2,.64,1) both;
    }
    @keyframes vavSlideUp { from { opacity: 0; transform: translateY(28px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .vav-box::before {
        content: ''; display: block; height: 2px; flex-shrink: 0;
        background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    }
    .vav-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 22px 14px; flex-shrink: 0;
        border-bottom: 1px solid rgba(249,180,15,.08);
    }
    .vav-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; }
    .vav-sub { font-size: .62rem; color: rgba(255,251,240,.35); margin-top: 3px; }
    .vav-close {
        width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
        border: 1px solid rgba(249,180,15,.18); background: transparent;
        color: rgba(249,180,15,.55); font-size: .72rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .18s;
    }
    .vav-close:hover { border-color: rgba(249,180,15,.4); color: #f9b40f; background: rgba(249,180,15,.07); }
    .vav-body { overflow-y: auto; flex: 1; padding: 14px 20px 6px; }
    .vav-body::-webkit-scrollbar { width: 3px; }
    .vav-body::-webkit-scrollbar-thumb { background: rgba(249,180,15,.2); border-radius: 99px; }
    .vav-row {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 12px; border-radius: 12px; margin-bottom: 6px;
        border: 1px solid rgba(52,211,153,.12);
        background: rgba(52,211,153,.03);
        transition: background .15s;
    }
    .vav-row:hover { background: rgba(52,211,153,.07); }
    .vav-row.vav-skipped { border-color: rgba(255,255,255,.05); background: transparent; opacity: .42; }
    .vav-num {
        width: 26px; height: 26px; border-radius: 50%; flex-shrink: 0;
        background: rgba(249,180,15,.1); border: 1px solid rgba(249,180,15,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: .58rem; font-weight: 800; color: rgba(249,180,15,.7);
    }
    .vav-avatar { width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0; object-fit: cover; border: 2px solid rgba(52,211,153,.3); }
    .vav-initial {
        width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, #380041, #520060);
        border: 2px solid rgba(52,211,153,.25);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 900; color: #f9b40f;
    }
    .vav-info { flex: 1; min-width: 0; }
    .vav-pos { font-size: .58rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: rgba(249,180,15,.45); margin-bottom: 2px; }
    .vav-name { font-size: .78rem; font-weight: 700; color: #fffbf0; }
    .vav-name.vav-empty { color: rgba(255,251,240,.22); font-style: italic; font-weight: 400; }
    .vav-party { font-size: .62rem; color: rgba(249,180,15,.4); margin-top: 1px; }
    .vav-tick { width: 24px; height: 24px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: .6rem; }
    .vav-tick.voted   { background: rgba(52,211,153,.1); border: 1px solid rgba(52,211,153,.3); color: #34d399; }
    .vav-tick.skipped { background: transparent; border: 1px solid rgba(255,255,255,.08); color: rgba(255,255,255,.15); }
    .vav-footer { padding: 12px 20px 18px; flex-shrink: 0; border-top: 1px solid rgba(249,180,15,.07); }
    .vav-note {
        display: flex; align-items: flex-start; gap: 8px;
        padding: 10px 14px; border-radius: 10px; margin-bottom: 12px;
        background: rgba(249,180,15,.04); border: 1px solid rgba(249,180,15,.1);
        font-size: .64rem; color: rgba(255,251,240,.38); line-height: 1.65;
    }
    .vav-review-btn {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 11px; border-radius: 10px; border: none; cursor: pointer;
        background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
        font-size: .78rem; font-weight: 800; font-family: 'DM Sans', sans-serif;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(249,180,15,.3), inset 0 1px 0 rgba(255,255,255,.2);
        transition: all .18s;
    }
    .vav-review-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(249,180,15,.45); }

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

@php
    $isMulti  = ($position->max_votes ?? 1) > 1;
    $maxVotes = (int) ($position->max_votes ?? 1);

    // Normalise pre-selected IDs from session
    if ($isMulti) {
        $preSelected = is_array($selectedId) ? array_map('intval', $selectedId) : [];
    } else {
        $preSelected = $selectedId ? (int) $selectedId : null;
    }
@endphp

<div class="ballot-wrap"
     x-data="stepPage()"
     x-init="init()"
     @keydown.escape.window="showVoted = false">

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
                $dotClass    = $isCurrent    ? 'current'
                             : ($wasSelected ? 'selected-past'
                             : ($isPast      ? 'past' : 'pending'));
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

                @if($isMulti)
                    {{-- Multi-vote instructions + live counter --}}
                    <div class="pos-hint">Select up to <strong style="color:#f9b40f;">{{ $maxVotes }}</strong> candidates. Click again to deselect.</div>
                    <div class="multi-counter" :class="{ 'at-max': atMax }">
                        <div class="multi-counter-dot"></div>
                        <span x-text="chosenCount + ' / {{ $maxVotes }} selected'"></span>
                        <span x-show="atMax" style="font-size:.65rem;opacity:.8;">&nbsp;— max reached</span>
                    </div>
                @else
                    <div class="pos-hint">Select one candidate below, or skip this position.</div>
                @endif
            </div>

            {{-- Skip button --}}
            <form method="POST" action="{{ route('voter.vote.step.save', $step) }}">
                @csrf
                <input type="hidden" name="action" value="skip">
                <button type="submit" class="skip-btn">
                    Skip <i class="fas fa-forward-step"></i>
                </button>
            </form>
        </div>

        {{-- Candidates grid --}}
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
                    <div
                        class="candidate-card"
                        :class="{
                            'is-selected': isSelected({{ $candidate->candidate_id }}),
                            'is-maxed':    !isSelected({{ $candidate->candidate_id }}) && atMax
                        }"
                        @click="toggle({{ $candidate->candidate_id }})"
                    >
                        {{-- Checkmark badge --}}
                        <div class="check-badge"
                             x-show="isSelected({{ $candidate->candidate_id }})"
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

        {{-- Hidden submission form --}}
        <form method="POST" action="{{ route('voter.vote.step.save', $step) }}" id="step-form">
            @csrf
            <input type="hidden" name="action" value="select">
            @if($isMulti)
                {{-- Multi-vote: hidden inputs injected by JS before submit --}}
                <div id="multi-vote-inputs"></div>
            @else
                {{-- Single-vote: one hidden input bound to Alpine --}}
                <input type="hidden" name="candidate_id" id="single-vote-input" value="">
            @endif
        </form>

        {{-- Footer --}}
        <div class="card-footer">
            <div>
                @if($isMulti)
                    <div class="selection-hint" x-show="chosenCount === 0">
                        <i class="fas fa-hand-pointer" style="font-size:.65rem;"></i>
                        Tap candidates to select (up to {{ $maxVotes }})
                    </div>
                    <div class="selection-chosen" x-show="chosenCount > 0" x-cloak>
                        <i class="fas fa-check-circle" style="color:#34d399;"></i>
                        <span x-text="chosenCount + ' candidate' + (chosenCount > 1 ? 's' : '') + ' selected'"></span>
                    </div>
                @else
                    <div class="selection-hint" x-show="!singleChosen">
                        <i class="fas fa-hand-pointer" style="font-size:.65rem;"></i>
                        Tap a candidate to select
                    </div>
                    <div class="selection-chosen" x-show="singleChosen" x-cloak>
                        <i class="fas fa-check-circle" style="color:#34d399;"></i>
                        <span x-text="chosenName"></span>
                    </div>
                @endif
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

                {{-- Next / View All --}}
                @if($step === $totalSteps)
                    <button type="button" class="btn btn-primary" @click="showVoted = true">
                        <i class="fas fa-list-check"></i> View All Candidates Voted
                    </button>
                @else
                    <button type="button" class="btn btn-primary"
                            :disabled="!hasSelection"
                            @click="submitStep()">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                @endif
            </div>
        </div>

    </div>{{-- /.ballot-card --}}


    {{-- ══ VIEW ALL CANDIDATES VOTED MODAL ══ --}}
    <div class="vav-overlay"
         x-show="showVoted"
         x-cloak
         style="display:none;"
         @click.self="showVoted = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="vav-box" @click.stop>

            <div class="vav-header">
                <div>
                    <div class="vav-title">Your Ballot So Far</div>
                    <div class="vav-sub">Review all positions before submitting</div>
                </div>
                <button class="vav-close" type="button" @click="showVoted = false">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <div class="vav-body">
                @foreach($steps as $idx => $s)
                @php
                    $ballot      = session('ballot', []);
                    $posId       = $s['position_id'];
                    $ballotVal   = $ballot[$posId] ?? null;
                    $isVoted     = $ballotVal && $ballotVal !== 'skip';
                    $isLastStep  = $s['step'] === $totalSteps;

                    $candidate = null;
                    if ($isVoted && !$isLastStep && !is_array($ballotVal)) {
                        $candidate = \App\Models\Candidate::with(['partylist'])
                            ->where('candidate_id', $ballotVal)
                            ->first();
                    }
                    // Multi-vote (array) for previous steps
                    $multiCandidates = [];
                    if ($isVoted && !$isLastStep && is_array($ballotVal)) {
                        $multiCandidates = \App\Models\Candidate::with(['partylist'])
                            ->whereIn('candidate_id', $ballotVal)
                            ->get();
                    }
                @endphp

                @if($isLastStep)
                {{-- Last step: driven by Alpine --}}
                <template x-if="{{ $isMulti ? 'true' : 'false' }}">
                    {{-- Multi-vote last step --}}
                    <div>
                        <template x-if="chosenCount === 0">
                            <div class="vav-row vav-skipped">
                                <div class="vav-num">{{ $s['step'] }}</div>
                                <div class="vav-initial" style="border-color:rgba(255,255,255,0.08);">
                                    <i class="fas fa-minus" style="font-size:.65rem;color:rgba(255,255,255,0.2);"></i>
                                </div>
                                <div class="vav-info">
                                    <div class="vav-pos">{{ $s['name'] }}</div>
                                    <div class="vav-name vav-empty">Not yet selected</div>
                                </div>
                                <div class="vav-tick skipped"><i class="fas fa-minus"></i></div>
                            </div>
                        </template>
                        <template x-if="chosenCount > 0">
                            <div>
                                <template x-for="(id, i) in multiChosen" :key="id">
                                    <div class="vav-row">
                                        <div class="vav-num" x-text="i === 0 ? '{{ $s['step'] }}' : ''"></div>
                                        <div class="vav-initial">
                                            <span x-text="lastStepCandidates[id] ? lastStepCandidates[id].initial : '?'"></span>
                                        </div>
                                        <div class="vav-info">
                                            <div class="vav-pos" x-show="i === 0">{{ $s['name'] }}</div>
                                            <div class="vav-name" x-text="lastStepCandidates[id] ? lastStepCandidates[id].name : ''"></div>
                                            <div class="vav-party" x-text="lastStepCandidates[id] ? lastStepCandidates[id].party : ''"></div>
                                        </div>
                                        <div class="vav-tick voted"><i class="fas fa-check"></i></div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="{{ $isMulti ? 'false' : 'true' }}">
                    {{-- Single-vote last step --}}
                    <div :class="['vav-row', singleChosen ? '' : 'vav-skipped']">
                        <div class="vav-num">{{ $s['step'] }}</div>
                        <div class="vav-initial">
                            <span x-text="singleChosen && lastStepCandidates[singleChosen] ? lastStepCandidates[singleChosen].initial : '—'"></span>
                        </div>
                        <div class="vav-info">
                            <div class="vav-pos">{{ $s['name'] }}</div>
                            <div :class="['vav-name', singleChosen ? '' : 'vav-empty']"
                                 x-text="singleChosen && lastStepCandidates[singleChosen] ? lastStepCandidates[singleChosen].name : 'Not yet selected'"></div>
                            <div class="vav-party"
                                 x-show="singleChosen && lastStepCandidates[singleChosen]"
                                 x-text="singleChosen && lastStepCandidates[singleChosen] ? lastStepCandidates[singleChosen].party : ''"></div>
                        </div>
                        <div :class="['vav-tick', singleChosen ? 'voted' : 'skipped']">
                            <i :class="singleChosen ? 'fas fa-check' : 'fas fa-minus'"></i>
                        </div>
                    </div>
                </template>

                @elseif($isVoted && count($multiCandidates) > 0)
                {{-- Previous multi-vote step with selections --}}
                @foreach($multiCandidates as $mc)
                <div class="vav-row">
                    <div class="vav-num">{{ $loop->first ? $s['step'] : '' }}</div>
                    @if($mc->photo)
                        <img src="{{ asset('images/candidates/' . $mc->photo) }}" class="vav-avatar" alt="{{ $mc->full_name }}">
                    @else
                        <div class="vav-initial">{{ strtoupper(substr($mc->first_name, 0, 1)) }}</div>
                    @endif
                    <div class="vav-info">
                        @if($loop->first)<div class="vav-pos">{{ $s['name'] }}</div>@endif
                        <div class="vav-name">{{ $mc->full_name }}</div>
                        @if($mc->partylist)<div class="vav-party">{{ $mc->partylist->name }}</div>@endif
                    </div>
                    <div class="vav-tick voted"><i class="fas fa-check"></i></div>
                </div>
                @endforeach

                @else
                {{-- Previous single-vote or skipped step --}}
                <div class="vav-row {{ !$isVoted ? 'vav-skipped' : '' }}">
                    <div class="vav-num">{{ $s['step'] }}</div>
                    @if($isVoted && $candidate)
                        @if($candidate->photo)
                            <img src="{{ asset('images/candidates/' . $candidate->photo) }}" class="vav-avatar" alt="{{ $candidate->full_name }}">
                        @else
                            <div class="vav-initial">{{ strtoupper(substr($candidate->first_name, 0, 1)) }}</div>
                        @endif
                    @else
                        <div class="vav-initial" style="border-color:rgba(255,255,255,0.08);">
                            <i class="fas fa-minus" style="font-size:.65rem;color:rgba(255,255,255,0.2);"></i>
                        </div>
                    @endif
                    <div class="vav-info">
                        <div class="vav-pos">{{ $s['name'] }}</div>
                        @if($isVoted && $candidate)
                            <div class="vav-name">{{ $candidate->full_name }}</div>
                            @if($candidate->partylist)<div class="vav-party">{{ $candidate->partylist->name }}</div>@endif
                        @else
                            <div class="vav-name vav-empty">{{ $ballotVal === 'skip' ? 'Skipped' : 'Not yet voted' }}</div>
                        @endif
                    </div>
                    <div class="vav-tick {{ $isVoted ? 'voted' : 'skipped' }}">
                        <i class="{{ $isVoted ? 'fas fa-check' : 'fas fa-minus' }}"></i>
                    </div>
                </div>
                @endif

                @endforeach
            </div>

            <div class="vav-footer">
                <div class="vav-note">
                    <i class="fas fa-circle-info" style="color:rgba(249,180,15,.5);flex-shrink:0;margin-top:1px;"></i>
                    <span>
                        Skipped positions will not record a vote — that is allowed.
                        Click <strong style="color:rgba(249,180,15,.7);">Review &amp; Submit</strong> when you're ready to finalise.
                    </span>
                </div>
                <button type="button" class="vav-review-btn" @click="goToReview()">
                    <i class="fas fa-paper-plane"></i> Review &amp; Submit Ballot
                </button>
            </div>

        </div>
    </div>{{-- /.vav-overlay --}}

</div>{{-- /.ballot-wrap --}}

{{-- Hidden skip form for last step when nothing chosen --}}
<form id="skip-form-last"
      method="POST"
      action="{{ route('voter.vote.step.save', $step) }}"
      style="display:none;">
    @csrf
    <input type="hidden" name="action" value="skip">
</form>

@push('scripts')
<script>
function stepPage() {
    const IS_MULTI  = {{ $isMulti ? 'true' : 'false' }};
    const MAX_VOTES = {{ $maxVotes }};

    // Pre-populate from server (session-restored selections)
    @if($isMulti)
        const PRE_MULTI  = {{ json_encode($preSelected) }};  // int[]
    @else
        const PRE_SINGLE = {{ $preSelected ?? 'null' }};     // int|null
    @endif

    // Candidate lookup map for the last-step modal
    const CANDIDATES = {
        @foreach($position->candidates as $c)
        {{ $c->candidate_id }}: {
            name:     '{{ addslashes($c->full_name) }}',
            party:    '{{ addslashes($c->partylist?->name ?? '') }}',
            initial:  '{{ strtoupper(substr($c->first_name, 0, 1)) }}',
            photo:    {{ $c->photo ? 'true' : 'false' }},
            photoUrl: '{{ $c->photo ? asset('images/candidates/' . $c->photo) : '' }}',
        },
        @endforeach
    };

    return {
        // ── State ──────────────────────────────────────────────
        isMulti:   IS_MULTI,
        maxVotes:  MAX_VOTES,
        showVoted: false,

        // Multi-vote: array of selected candidate IDs
        multiChosen: IS_MULTI ? [...PRE_MULTI] : [],

        // Single-vote: one ID or null
        singleChosen: IS_MULTI ? null : PRE_SINGLE,
        chosenName: '',

        lastStepCandidates: CANDIDATES,

        // ── Computed ───────────────────────────────────────────
        get chosenCount() {
            return this.isMulti ? this.multiChosen.length : (this.singleChosen ? 1 : 0);
        },
        get atMax() {
            return this.isMulti && this.multiChosen.length >= this.maxVotes;
        },
        get hasSelection() {
            return this.isMulti ? this.multiChosen.length > 0 : !!this.singleChosen;
        },

        // ── Helpers ────────────────────────────────────────────
        isSelected(id) {
            if (this.isMulti) {
                return this.multiChosen.some(v => v === id);
            }
            return this.singleChosen === id;
        },

        // ── Toggle selection ───────────────────────────────────
        toggle(id) {
            if (this.isMulti) {
                const idx = this.multiChosen.findIndex(v => v === id);
                if (idx > -1) {
                    // Deselect
                    this.multiChosen.splice(idx, 1);
                } else if (this.multiChosen.length < this.maxVotes) {
                    // Select (only if under limit)
                    this.multiChosen.push(id);
                }
                // If at max and card not selected, click is silently ignored
            } else {
                if (this.singleChosen === id) {
                    this.singleChosen = null;
                    this.chosenName   = '';
                } else {
                    this.singleChosen = id;
                    this.chosenName   = CANDIDATES[id] ? CANDIDATES[id].name : '';
                }
            }
        },

        // ── Init ───────────────────────────────────────────────
        init() {
            if (!this.isMulti && this.singleChosen) {
                this.chosenName = CANDIDATES[this.singleChosen]?.name ?? '';
            }
        },

        // ── Submit the step form ───────────────────────────────
        submitStep() {
            if (!this.hasSelection) return;

            if (this.isMulti) {
                // Inject hidden inputs for each selected candidate
                const container = document.getElementById('multi-vote-inputs');
                container.innerHTML = '';
                this.multiChosen.forEach(id => {
                    const inp = document.createElement('input');
                    inp.type  = 'hidden';
                    inp.name  = 'candidate_ids[]';
                    inp.value = id;
                    container.appendChild(inp);
                });
            } else {
                document.getElementById('single-vote-input').value = this.singleChosen;
            }

            document.getElementById('step-form').submit();
        },

        // ── "Review & Submit" from last-step modal ─────────────
        goToReview() {
            if (this.hasSelection) {
                this.submitStep();
            } else {
                // Nothing selected on last step — skip it and go to review
                document.getElementById('skip-form-last').submit();
            }
        },
    };
}
</script>
@endpush
</x-app-layout>