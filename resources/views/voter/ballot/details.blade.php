<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
.vd-wrap { max-width: 760px; margin: 32px auto; padding: 0 16px 60px; }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Page header ── */
.page-header {
    display: flex; align-items: center; gap: 14px; margin-bottom: 24px;
    animation: fadeUp 0.35s ease both;
}
.back-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 9px;
    border: 1px solid rgba(249,180,15,0.2); background: transparent;
    font-size: 0.7rem; font-weight: 600; color: rgba(249,180,15,0.6);
    text-decoration: none; transition: all 0.18s; font-family: 'DM Sans', sans-serif;
    flex-shrink: 0;
}
.back-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.05); }
.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem; font-weight: 900; color: #fffbf0;
}
.page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); margin-top: 2px; }

/* ── Receipt card ── */
.receipt-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.2);
    border-radius: 20px;
    box-shadow: 0 8px 48px rgba(0,0,0,0.45), inset 0 1px 0 rgba(249,180,15,0.07);
    overflow: hidden;
    animation: fadeUp 0.4s ease both;
}
.receipt-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
}

/* ── Receipt header ── */
.receipt-header {
    padding: 28px 32px 24px;
    border-bottom: 1px solid rgba(249,180,15,0.08);
    display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;
    flex-wrap: wrap;
}
.receipt-seal { display: flex; align-items: center; gap: 14px; }
.seal-icon {
    width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; color: #f9b40f;
}
.receipt-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem; font-weight: 900; color: #fffbf0; margin-bottom: 4px;
}
.receipt-sub { font-size: 0.7rem; color: rgba(255,251,240,0.4); line-height: 1.6; }
.txn-badge { display: flex; flex-direction: column; align-items: flex-end; gap: 3px; }
.txn-label { font-size: 0.58rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(249,180,15,0.45); }
.txn-value { font-family: monospace; font-size: 0.82rem; font-weight: 700; color: #f9b40f; letter-spacing: 0.06em; }

/* ── Meta grid ── */
.meta-grid {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 0;
    border-bottom: 1px solid rgba(249,180,15,0.08);
}
@media (min-width: 560px) { .meta-grid { grid-template-columns: repeat(4, 1fr); } }
.meta-cell { padding: 16px 20px; border-right: 1px solid rgba(249,180,15,0.06); }
.meta-cell:last-child { border-right: none; }
.meta-cell:nth-child(2) { border-right: 1px solid rgba(249,180,15,0.06); }
@media (max-width: 559px) {
    .meta-cell:nth-child(even) { border-right: none; }
    .meta-cell:nth-child(1), .meta-cell:nth-child(2) { border-bottom: 1px solid rgba(249,180,15,0.06); }
}
.meta-lbl { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(249,180,15,0.4); margin-bottom: 4px; }
.meta-val { font-size: 0.78rem; font-weight: 700; color: #fffbf0; }

/* ── Votes list ── */
.votes-section { padding: 24px 32px; }
.votes-section-title {
    font-size: 0.62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5); margin-bottom: 16px;
}

/* Single-vote row */
.vote-row {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 16px; border-radius: 14px;
    border: 1px solid rgba(52,211,153,0.12);
    background: rgba(52,211,153,0.03);
    margin-bottom: 8px;
    transition: all 0.18s;
    animation: fadeUp 0.4s ease both;
}
.vote-row:hover { border-color: rgba(52,211,153,0.22); background: rgba(52,211,153,0.06); }

/* Multi-vote group */
.vote-group {
    border-radius: 14px;
    border: 1px solid rgba(52,211,153,0.12);
    background: rgba(52,211,153,0.03);
    margin-bottom: 8px;
    overflow: hidden;
    animation: fadeUp 0.4s ease both;
    transition: all 0.18s;
}
.vote-group:hover { border-color: rgba(52,211,153,0.22); background: rgba(52,211,153,0.06); }

.vote-group-header {
    display: flex; align-items: center; gap: 14px;
    padding: 12px 16px 8px;
}
.vote-group-item {
    display: flex; align-items: center; gap: 14px;
    padding: 6px 16px 10px;
    border-top: 1px solid rgba(52,211,153,0.06);
}

/* Skipped styles */
.vote-row.skipped,
.vote-group.skipped {
    opacity: 0.45;
    border-color: rgba(255,255,255,0.06);
    background: rgba(255,255,255,0.02);
}

.step-num {
    width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.62rem; font-weight: 800; color: rgba(249,180,15,0.7);
}
.step-num.skipped { border-color: rgba(255,255,255,0.08); color: rgba(255,255,255,0.2); }

.candidate-avatar {
    width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
    object-fit: cover; border: 2px solid rgba(52,211,153,0.25);
}
.candidate-initial {
    width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #380041, #520060);
    border: 2px solid rgba(52,211,153,0.25);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem; font-weight: 900; color: #f9b40f;
}
.candidate-initial.skipped { border-color: rgba(255,255,255,0.08); }

/* Smaller avatar for group items */
.candidate-avatar-sm {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    object-fit: cover; border: 2px solid rgba(52,211,153,0.2);
}
.candidate-initial-sm {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #380041, #520060);
    border: 2px solid rgba(52,211,153,0.2);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 0.85rem; font-weight: 900; color: #f9b40f;
}

.vote-info { flex: 1; min-width: 0; }
.vote-position {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 2px;
}
.vote-candidate { font-size: 0.82rem; font-weight: 700; color: #fffbf0; }
.vote-candidate-sm { font-size: 0.75rem; font-weight: 700; color: #fffbf0; }
.vote-party { font-size: 0.65rem; color: rgba(249,180,15,0.45); margin-top: 2px; }
.vote-college { font-size: 0.6rem; color: rgba(255,251,240,0.25); margin-top: 1px; }

/* Multi-vote count badge */
.multi-count-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 99px;
    font-size: 0.6rem; font-weight: 700;
    background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2);
    color: #34d399; margin-top: 3px;
}

.vote-check {
    flex-shrink: 0; width: 28px; height: 28px; border-radius: 50%;
    background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.3);
    display: flex; align-items: center; justify-content: center;
    color: #34d399; font-size: 0.65rem;
}

/* ── Stats bar ── */
.stats-bar { margin: 0 32px 24px; display: flex; gap: 10px; flex-wrap: wrap; }
.stat-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 14px; border-radius: 99px; font-size: 0.65rem; font-weight: 700;
}
.stat-pill.green  { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
.stat-pill.gold   { background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.18); color: rgba(249,180,15,0.8); }
.stat-pill.muted  { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.3); }

/* ── Integrity notice ── */
.integrity-notice {
    margin: 0 32px 28px;
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: 10px;
    background: rgba(249,180,15,0.04); border: 1px solid rgba(249,180,15,0.1);
    font-size: 0.68rem; color: rgba(255,251,240,0.4); line-height: 1.65;
}

@media (max-width: 600px) {
    .receipt-header  { padding: 20px; }
    .meta-cell       { padding: 12px 16px; }
    .votes-section   { padding: 18px 20px; }
    .stats-bar       { margin: 0 20px 18px; }
    .integrity-notice{ margin: 0 20px 24px; }
    .page-title      { font-size: 1.1rem; }
}
</style>
@endpush

<div class="vd-wrap">

    {{-- Page header --}}
    <div class="page-header">
        <a href="{{ route('voter.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left" style="font-size:0.6rem;"></i> Back
        </a>
        <div>
            <div class="page-title">My Voting Details</div>
            <div class="page-sub">Official record of your ballot submissions</div>
        </div>
    </div>

    <div class="receipt-card">

        {{-- Receipt header --}}
        <div class="receipt-header">
            <div class="receipt-seal">
                <div class="seal-icon"><i class="fas fa-receipt"></i></div>
                <div>
                    <div class="receipt-title">Official Vote Receipt</div>
                    <div class="receipt-sub">
                        Your ballot has been permanently sealed and recorded.<br>
                        This record is for your reference only.
                    </div>
                </div>
            </div>
            <div class="txn-badge">
                <div class="txn-label">Transaction No.</div>
                <div class="txn-value">{{ $txn }}</div>
            </div>
        </div>

        {{-- Meta grid --}}
        <div class="meta-grid">
            <div class="meta-cell">
                <div class="meta-lbl">Voter</div>
                <div class="meta-val">{{ $voter->full_name }}</div>
            </div>
            <div class="meta-cell">
                <div class="meta-lbl">Student No.</div>
                <div class="meta-val">{{ $voter->student_number ?? '—' }}</div>
            </div>
            <div class="meta-cell">
                <div class="meta-lbl">Date Voted</div>
                <div class="meta-val">{{ $votedAt->format('M d, Y') }}</div>
            </div>
            <div class="meta-cell">
                <div class="meta-lbl">Time Voted</div>
                <div class="meta-val">{{ $votedAt->format('g:i A') }}</div>
            </div>
        </div>

        {{-- Stats pills --}}
        <div class="stats-bar" style="margin-top:20px;">
            <span class="stat-pill green">
                <i class="fas fa-check-circle"></i>
                {{ $totalVoted }} candidate{{ $totalVoted !== 1 ? 's' : '' }} voted
            </span>
            @if($totalSkipped > 0)
            <span class="stat-pill muted">
                <i class="fas fa-forward"></i>
                {{ $totalSkipped }} skipped
            </span>
            @endif
            <span class="stat-pill gold">
                <i class="fas fa-shield-halved"></i>
                Ballot sealed &amp; secure
            </span>
        </div>

        {{-- Votes list --}}
        <div class="votes-section">
            <div class="votes-section-title">Candidates You Voted For</div>

            @foreach($allPositions as $idx => $position)
            @php
                // $votesByPosition is grouped by position_id → Collection of CastedVote rows
                $votes      = $votesByPosition->get($position->id);          // Collection|null
                $isMulti    = ($position->max_votes ?? 1) > 1;
                $hasVotes   = $votes && $votes->whereNotNull('candidate_id')->count() > 0;
                $votedVotes = $votes ? $votes->whereNotNull('candidate_id') : collect();
            @endphp

            @if($isMulti)
                {{-- ── MULTI-VOTE POSITION (e.g. Senator) ── --}}
                @if($hasVotes)
                <div class="vote-group" style="animation-delay:{{ $idx * 0.04 }}s;">

                    {{-- Group header --}}
                    <div class="vote-group-header">
                        <div class="step-num">{{ $idx + 1 }}</div>
                        <div class="vote-info">
                            <div class="vote-position">{{ $position->name }}</div>
                            <div class="multi-count-badge">
                                <i class="fas fa-check-double" style="font-size:0.5rem;"></i>
                                {{ $votedVotes->count() }} candidate{{ $votedVotes->count() !== 1 ? 's' : '' }} selected
                            </div>
                        </div>
                        <div class="vote-check"><i class="fas fa-check"></i></div>
                    </div>

                    {{-- Each senator voted for --}}
                    @foreach($votedVotes as $vote)
                    <div class="vote-group-item">
                        <div style="width:28px;flex-shrink:0;"></div>{{-- align with step-num --}}
                        @if($vote->candidate?->photo)
                            <img src="{{ asset('images/candidates/' . $vote->candidate->photo) }}"
                                 class="candidate-avatar-sm" alt="{{ $vote->candidate->full_name }}">
                        @else
                            <div class="candidate-initial-sm">
                                {{ strtoupper(substr($vote->candidate?->first_name ?? '?', 0, 1)) }}
                            </div>
                        @endif
                        <div class="vote-info">
                            <div class="vote-candidate-sm">{{ $vote->candidate?->full_name ?? '—' }}</div>
                            @if($vote->candidate?->partylist)
                                <div class="vote-party">{{ $vote->candidate->partylist->name }}</div>
                            @endif
                            @if($vote->candidate?->college)
                                <div class="vote-college">{{ $vote->candidate->college->acronym ?? $vote->candidate->college->name }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
                @else
                {{-- Multi-vote skipped --}}
                <div class="vote-group skipped" style="animation-delay:{{ $idx * 0.04 }}s;">
                    <div class="vote-group-header">
                        <div class="step-num skipped">{{ $idx + 1 }}</div>
                        <div class="candidate-initial skipped">
                            <i class="fas fa-forward" style="font-size:0.7rem;color:rgba(255,255,255,0.2);"></i>
                        </div>
                        <div class="vote-info">
                            <div class="vote-position">{{ $position->name }}</div>
                            <div class="vote-candidate" style="color:rgba(255,251,240,0.25);font-style:italic;font-weight:400;">
                                Skipped — no vote recorded
                            </div>
                        </div>
                        <div class="vote-check" style="background:transparent;border-color:rgba(255,255,255,0.08);">
                            <i class="fas fa-minus" style="color:rgba(255,255,255,0.15);"></i>
                        </div>
                    </div>
                </div>
                @endif

            @else
                {{-- ── SINGLE-VOTE POSITION ── --}}
                @php $vote = $votedVotes->first(); @endphp

                @if($vote && $vote->candidate)
                <div class="vote-row" style="animation-delay:{{ $idx * 0.04 }}s;">
                    <div class="step-num">{{ $idx + 1 }}</div>

                    @if($vote->candidate->photo)
                        <img src="{{ asset('images/candidates/' . $vote->candidate->photo) }}"
                             class="candidate-avatar" alt="{{ $vote->candidate->full_name }}">
                    @else
                        <div class="candidate-initial">
                            {{ strtoupper(substr($vote->candidate->first_name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="vote-info">
                        <div class="vote-position">{{ $position->name }}</div>
                        <div class="vote-candidate">{{ $vote->candidate->full_name }}</div>
                        @if($vote->candidate->partylist)
                            <div class="vote-party">{{ $vote->candidate->partylist->name }}</div>
                        @endif
                        @if($vote->candidate->college)
                            <div class="vote-college">{{ $vote->candidate->college->acronym ?? $vote->candidate->college->name }}</div>
                        @endif
                    </div>

                    <div class="vote-check"><i class="fas fa-check"></i></div>
                </div>

                @else
                {{-- Single-vote skipped --}}
                <div class="vote-row skipped" style="animation-delay:{{ $idx * 0.04 }}s;">
                    <div class="step-num skipped">{{ $idx + 1 }}</div>
                    <div class="candidate-initial skipped">
                        <i class="fas fa-forward" style="font-size:0.7rem;color:rgba(255,255,255,0.2);"></i>
                    </div>
                    <div class="vote-info">
                        <div class="vote-position">{{ $position->name }}</div>
                        <div class="vote-candidate" style="color:rgba(255,251,240,0.25);font-style:italic;font-weight:400;">
                            Skipped — no vote recorded
                        </div>
                    </div>
                    <div class="vote-check" style="background:transparent;border-color:rgba(255,255,255,0.08);">
                        <i class="fas fa-minus" style="color:rgba(255,255,255,0.15);"></i>
                    </div>
                </div>
                @endif
            @endif

            @endforeach
        </div>

        {{-- Integrity notice --}}
        <div class="integrity-notice">
            <i class="fas fa-lock" style="color:rgba(249,180,15,0.5);flex-shrink:0;margin-top:1px;"></i>
            <span>
                Your vote is <strong style="color:rgba(249,180,15,0.7);">anonymous and final</strong>.
                Candidate names are shown here only for your personal reference.
                No one else — including administrators — can link this receipt to your identity.
                The integrity of the election is fully preserved.
            </span>
        </div>

    </div>
</div>
</x-app-layout>