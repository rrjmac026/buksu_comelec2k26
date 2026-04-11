<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite('resources/css/voter/ballot/step.css')
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
                            <div class="c-party-badge">{{ $candidate->full_name }}</div>
                            <!-- @if($candidate->partylist)
                                <div><span class="c-party-badge">{{ $candidate->partylist->name }}</span></div>
                            @endif -->
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
                    $ballot     = session('ballot', []);
                    $posId      = $s['position_id'];
                    $ballotVal  = $ballot[$posId] ?? null;
                    $isVoted    = $ballotVal && $ballotVal !== 'skip';
                    $isLastStep = $s['step'] === $totalSteps;

                    // ✅ No DB queries — lookups from the preloaded collection
                    $candidate = null;
                    if ($isVoted && !$isLastStep && !is_array($ballotVal)) {
                        $candidate = $ballotCandidates[$ballotVal] ?? null;
                    }

                    $multiCandidates = collect();
                    if ($isVoted && !$isLastStep && is_array($ballotVal)) {
                        $multiCandidates = $ballotCandidates->only($ballotVal)->values();
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