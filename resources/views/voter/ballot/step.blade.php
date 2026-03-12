<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }
    .ballot-wrap { max-width: 760px; margin: 32px auto; padding: 0 16px 60px; }

    /* ── Progress ── */
    .bw-progress { margin-bottom: 28px; }
    .bw-progress-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 8px;
    }
    .bw-progress-label { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(249,180,15,0.5); }
    .bw-progress-count { font-size: 0.65rem; font-weight: 700; color: rgba(249,180,15,0.5); }
    .bw-track { height: 3px; background: rgba(249,180,15,0.08); border-radius: 99px; overflow: hidden; }
    .bw-fill  { height: 100%; background: linear-gradient(90deg,#f9b40f,#fcd558); border-radius: 99px; transition: width 0.5s ease; box-shadow: 0 0 8px rgba(249,180,15,0.4); }

    .bw-dots { display: flex; gap: 5px; justify-content: center; flex-wrap: wrap; margin-top: 12px; }
    .bw-dot {
        height: 6px; border-radius: 99px;
        transition: all 0.25s ease;
        flex-shrink: 0;
    }
    .bw-dot.pending  { width: 6px;  background: rgba(249,180,15,0.12); }
    .bw-dot.current  { width: 20px; background: #f9b40f; box-shadow: 0 0 8px rgba(249,180,15,0.5); }
    .bw-dot.selected { width: 6px;  background: #34d399; }
    .bw-dot.skipped  { width: 6px;  background: rgba(255,255,255,0.12); }

    /* ── Card ── */
    .ballot-card {
        background: rgba(26,0,32,0.88);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(249,180,15,0.18);
        border-radius: 20px;
        box-shadow: 0 8px 48px rgba(0,0,0,0.45), inset 0 1px 0 rgba(249,180,15,0.07);
        overflow: hidden;
        animation: fadeUp 0.4s ease both;
    }
    .ballot-card::before {
        content: ''; display: block; height: 2px;
        background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes checkPop {
        0%  { transform: scale(0) rotate(-10deg); }
        60% { transform: scale(1.2) rotate(3deg); }
        100%{ transform: scale(1) rotate(0); }
    }

    /* ── Step header ── */
    .step-header {
        padding: 28px 32px 0;
        display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;
    }
    .pos-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 99px;
        background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.18);
        font-size: 0.6rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
        color: rgba(249,180,15,0.7); margin-bottom: 7px;
    }
    .pos-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem; font-weight: 900; color: #fffbf0;
    }
    .pos-hint { font-size: 0.68rem; color: rgba(255,251,240,0.35); margin-top: 4px; }

    .skip-btn {
        flex-shrink: 0; padding: 7px 16px; border-radius: 8px;
        border: 1px solid rgba(255,251,240,0.1); background: transparent;
        font-size: 0.68rem; font-weight: 600; color: rgba(255,251,240,0.3);
        cursor: pointer; transition: all 0.18s; white-space: nowrap; margin-top: 6px;
        font-family: 'DM Sans', sans-serif;
    }
    .skip-btn:hover {
        border-color: rgba(255,251,240,0.22); color: rgba(255,251,240,0.6);
        background: rgba(255,251,240,0.04);
    }

    /* ── Candidates grid ── */
    .candidates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
        gap: 12px;
        padding: 24px 32px;
    }

    .candidate-card {
        position: relative;
        border-radius: 14px;
        border: 1.5px solid rgba(249,180,15,0.1);
        background: rgba(56,0,65,0.45);
        padding: 20px 14px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex; flex-direction: column; align-items: center;
        text-align: center; gap: 8px;
        user-select: none;
    }
    .candidate-card:hover {
        border-color: rgba(249,180,15,0.3);
        background: rgba(56,0,65,0.75);
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.35);
    }
    .candidate-card.selected {
        border-color: #f9b40f;
        background: rgba(249,180,15,0.08);
        box-shadow: 0 0 0 1px rgba(249,180,15,0.25), 0 8px 28px rgba(249,180,15,0.12);
    }
    .candidate-card.selected::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; top: 9px; right: 9px;
        width: 22px; height: 22px; border-radius: 50%;
        background: linear-gradient(135deg, #f9b40f, #fcd558);
        color: #380041; font-size: 0.62rem;
        display: flex; align-items: center; justify-content: center;
        animation: checkPop 0.3s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    .c-photo {
        width: 70px; height: 70px; border-radius: 50%; object-fit: cover;
        border: 2px solid rgba(249,180,15,0.18);
        transition: border-color 0.2s;
    }
    .c-initial {
        width: 70px; height: 70px; border-radius: 50%;
        background: linear-gradient(135deg,#380041,#520060);
        border: 2px solid rgba(249,180,15,0.18);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem; font-weight: 900; color: #f9b40f;
        flex-shrink: 0; transition: all 0.2s;
    }
    .candidate-card.selected .c-initial,
    .candidate-card.selected .c-photo {
        border-color: #f9b40f;
        box-shadow: 0 0 16px rgba(249,180,15,0.3);
    }

    .c-name { font-size: 0.78rem; font-weight: 700; color: #fffbf0; line-height: 1.3; }
    .candidate-card.selected .c-name { color: #fcd558; }
    .c-party { font-size: 0.62rem; color: rgba(249,180,15,0.5); font-weight: 600; }
    .c-college { font-size: 0.58rem; color: rgba(255,251,240,0.25); margin-top: 2px; }

    .no-candidates {
        padding: 40px 32px; text-align: center;
        color: rgba(255,251,240,0.25); font-size: 0.78rem;
    }

    /* ── Footer ── */
    .step-footer {
        padding: 16px 32px 28px;
        border-top: 1px solid rgba(249,180,15,0.07);
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
    }
    .selection-hint { font-size: 0.68rem; color: rgba(255,251,240,0.25); display: flex; align-items: center; gap: 6px; }
    .selection-chosen { font-size: 0.68rem; font-weight: 700; color: #f9b40f; display: flex; align-items: center; gap: 6px; }

    .btn-group { display: flex; gap: 10px; align-items: center; }
    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 20px; border-radius: 10px;
        font-size: 0.76rem; font-weight: 700;
        cursor: pointer; transition: all 0.18s; border: none;
        font-family: 'DM Sans', sans-serif; text-decoration: none;
    }
    .btn-primary {
        background: linear-gradient(135deg,#f9b40f,#fcd558); color: #380041;
        box-shadow: 0 4px 16px rgba(249,180,15,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(249,180,15,0.45); }
    .btn-primary:disabled { opacity: 0.35; cursor: not-allowed; transform: none; }
    .btn-ghost {
        background: transparent; border: 1px solid rgba(249,180,15,0.2);
        color: rgba(249,180,15,0.65);
    }
    .btn-ghost:hover { background: rgba(249,180,15,0.07); border-color: rgba(249,180,15,0.35); color: #f9b40f; }

    @media (max-width: 600px) {
        .step-header { padding: 20px 20px 0; flex-direction: column; }
        .candidates-grid { padding: 16px 20px; grid-template-columns: repeat(2,1fr); }
        .step-footer { padding: 14px 20px 22px; flex-direction: column; align-items: flex-start; gap: 14px; }
        .btn-group { width: 100%; justify-content: flex-end; }
        .pos-title { font-size: 1.1rem; }
    }
</style>
@endpush

<div class="ballot-wrap">

    {{-- ── Progress ── --}}
    <div class="bw-progress">
        <div class="bw-progress-header">
            <span class="bw-progress-label">Ballot Progress</span>
            <span class="bw-progress-count">Step {{ $step }} of {{ $totalSteps }}</span>
        </div>
        <div class="bw-track">
            <div class="bw-fill" style="width:{{ round(($step / $totalSteps) * 100) }}%"></div>
        </div>
        <div class="bw-dots">
            @foreach($steps as $s)
                <div class="bw-dot {{ $s['status'] }}" title="{{ $s['name'] }}"></div>
            @endforeach
        </div>
    </div>

    {{-- ── Errors ── --}}
    @if($errors->any())
    <div style="display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.09);border:1px solid rgba(239,68,68,0.22);margin-bottom:16px;">
        <i class="fas fa-circle-exclamation" style="color:#f87171;flex-shrink:0;"></i>
        <span style="font-size:0.73rem;font-weight:600;color:#f87171;">{{ $errors->first() }}</span>
    </div>
    @endif

    {{-- ── Main card ── --}}
    <div class="ballot-card" x-data="stepPage()" x-init="init()">

        {{-- Header --}}
        <div class="step-header">
            <div>
                <div class="pos-badge">
                    <i class="fas fa-circle-dot"></i>
                    Position {{ $step }} of {{ $totalSteps }}
                </div>
                <div class="pos-title">{{ $position->name }}</div>
                <div class="pos-hint">Select one candidate below, or skip this position.</div>
            </div>

            {{-- Skip is its own mini-form --}}
            <form method="POST" action="{{ route('voter.vote.step.save', $step) }}">
                @csrf
                <input type="hidden" name="action" value="skip">
                <button type="submit" class="skip-btn">
                    Skip <i class="fas fa-forward" style="font-size:0.6rem;"></i>
                </button>
            </form>
        </div>

        {{-- Candidates --}}
        @if($position->candidates->isEmpty())
            <div class="no-candidates">
                <i class="fas fa-user-slash" style="font-size:1.6rem;margin-bottom:10px;display:block;opacity:0.25;"></i>
                No candidates registered for this position.
            </div>
        @else
        <div class="candidates-grid">
            @foreach($position->candidates as $candidate)
            <div
                class="candidate-card {{ $selectedId == $candidate->candidate_id ? 'selected' : '' }}"
                @click="select({{ $candidate->candidate_id }})"
                :class="{ 'selected': chosen === {{ $candidate->candidate_id }} }"
                x-bind:class="chosen === {{ $candidate->candidate_id }} ? 'candidate-card selected' : 'candidate-card'"
            >
                @if($candidate->photo)
                    <img src="{{ asset('images/candidates/' . $candidate->photo) }}" class="c-photo" alt="{{ $candidate->full_name }}">
                @else
                    <div class="c-initial">{{ strtoupper(substr($candidate->first_name, 0, 1)) }}</div>
                @endif

                <div class="c-name">{{ $candidate->full_name }}</div>
                @if($candidate->partylist)
                    <div class="c-party">{{ $candidate->partylist->name }}</div>
                @endif
                @if($candidate->college)
                    <div class="c-college">{{ $candidate->college->acronym ?? $candidate->college->name }}</div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- Footer --}}
        <form method="POST" action="{{ route('voter.vote.step.save', $step) }}" id="step-form">
            @csrf
            <input type="hidden" name="action" value="select">
            <input type="hidden" name="candidate_id" x-model="chosen" id="candidate-input">

            <div class="step-footer">
                <div>
                    <div class="selection-hint" x-show="!chosen">
                        <i class="fas fa-hand-pointer" style="font-size:0.65rem;"></i>
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

                    {{-- Next --}}
                    <button
                        type="submit"
                        form="step-form"
                        class="btn btn-primary"
                        :disabled="!chosen"
                        x-bind:disabled="!chosen"
                    >
                        @if($step === $totalSteps)
                            Review Ballot <i class="fas fa-eye"></i>
                        @else
                            Next <i class="fas fa-arrow-right"></i>
                        @endif
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

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
            if (this.chosen) {
                this.chosenName = this.candidates[this.chosen] ?? '';
            }
        },

        select(id) {
            // Toggle off if already selected
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