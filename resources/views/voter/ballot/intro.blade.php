<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
.ballot-wrap { max-width: 640px; margin: 40px auto; padding: 0 16px; }

.ballot-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.2);
    border-radius: 20px;
    box-shadow: 0 8px 48px rgba(0,0,0,0.5), inset 0 1px 0 rgba(249,180,15,0.08);
    overflow: hidden;
    animation: fadeUp 0.45s ease both;
}
.ballot-card::before {
    content: '';
    display: block; height: 3px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
}

/* ── Already Voted card — green accent ── */
.ballot-card.voted-card {
    border-color: rgba(52,211,153,0.25);
    box-shadow: 0 8px 48px rgba(0,0,0,0.5), 0 0 40px rgba(52,211,153,0.06), inset 0 1px 0 rgba(52,211,153,0.08);
}
.ballot-card.voted-card::before {
    background: linear-gradient(90deg, transparent, #34d399, #6ee7b7, transparent);
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ══════════════════════════
   ALREADY-VOTED STATE
══════════════════════════ */
.voted-body { padding: 44px 40px; text-align: center; }

.peace-gif-wrap {
    width: 160px; height: 160px;
    margin: 0 auto 24px;
    border-radius: 20px;
    overflow: hidden;
    border: 2px solid rgba(52,211,153,0.2);
    box-shadow: 0 0 40px rgba(52,211,153,0.15);
}
.peace-gif-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}

.voted-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem; font-weight: 900;
    background: linear-gradient(135deg, #6ee7b7 0%, #34d399 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
}
.voted-sub {
    font-size: 0.8rem; color: rgba(255,251,240,0.5);
    line-height: 1.75; max-width: 400px; margin: 0 auto 28px;
}

.txn-box {
    display: inline-flex; flex-direction: column; align-items: center;
    padding: 12px 24px; border-radius: 12px; margin-bottom: 28px;
    background: rgba(52,211,153,0.06); border: 1px solid rgba(52,211,153,0.18);
}
.txn-label { font-size: 0.6rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(52,211,153,0.5); margin-bottom: 5px; }
.txn-number { font-family: monospace; font-size: 0.85rem; font-weight: 700; color: #34d399; letter-spacing: 0.06em; }

.voted-actions { display: flex; flex-direction: column; gap: 10px; align-items: center; }
.btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 28px; border-radius: 10px; font-size: 0.78rem; font-weight: 700;
    cursor: pointer; transition: all 0.18s; text-decoration: none;
    font-family: 'DM Sans', sans-serif; border: none;
}
.btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 4px 16px rgba(249,180,15,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
}
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(249,180,15,0.45); }
.btn-ghost {
    background: transparent; border: 1px solid rgba(52,211,153,0.25);
    color: rgba(52,211,153,0.7);
}
.btn-ghost:hover { background: rgba(52,211,153,0.07); color: #34d399; border-color: rgba(52,211,153,0.4); }

.voted-meta-row {
    display: flex; gap: 14px; flex-wrap: wrap; justify-content: center; margin-bottom: 28px;
}
.voted-meta-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 14px; border-radius: 99px;
    font-size: 0.65rem; font-weight: 700;
}
.voted-meta-pill.green { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
.voted-meta-pill.gold  { background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.18); color: rgba(249,180,15,0.8); }

/* ══════════════════════════
   NORMAL (not-yet-voted) STATE
══════════════════════════ */
.intro-body { padding: 48px 44px; text-align: center; }

.intro-seal {
    width: 88px; height: 88px; border-radius: 50%;
    background: radial-gradient(circle at 40% 35%, rgba(249,180,15,0.18), rgba(249,180,15,0.05));
    border: 2px solid rgba(249,180,15,0.3);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 28px;
    font-size: 2.4rem;
    box-shadow: 0 0 40px rgba(249,180,15,0.15), inset 0 0 20px rgba(249,180,15,0.05);
}

.intro-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem; font-weight: 900;
    background: linear-gradient(135deg, #fffbf0 0%, #fcd558 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
}
.intro-sub {
    font-size: 0.82rem; color: rgba(255,251,240,0.5);
    line-height: 1.75; max-width: 420px; margin: 0 auto 36px;
}

.reminders { display: flex; flex-direction: column; gap: 10px; text-align: left; margin-bottom: 36px; }

.reminder {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 16px; border-radius: 12px;
    background: rgba(249,180,15,0.05);
    border: 1px solid rgba(249,180,15,0.1);
    animation: fadeUp 0.4s ease both;
}
.reminder:nth-child(1) { animation-delay: 0.08s; }
.reminder:nth-child(2) { animation-delay: 0.14s; }
.reminder:nth-child(3) { animation-delay: 0.20s; }
.reminder:nth-child(4) { animation-delay: 0.26s; }

.reminder-icon {
    width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.15);
    display: flex; align-items: center; justify-content: center;
    color: #f9b40f; font-size: 0.78rem;
}
.reminder-text {
    font-size: 0.73rem; color: rgba(255,251,240,0.6);
    line-height: 1.6; padding-top: 4px;
}
.reminder-text strong { color: #fcd558; font-weight: 700; }

.intro-meta {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 6px 14px; border-radius: 99px;
    background: rgba(249,180,15,0.07); border: 1px solid rgba(249,180,15,0.15);
    font-size: 0.68rem; color: rgba(249,180,15,0.65);
    font-weight: 600; letter-spacing: 0.05em;
    margin-bottom: 24px;
}

.btn-start {
    display: inline-flex; align-items: center; gap: 9px;
    padding: 14px 40px; border-radius: 12px;
    background: linear-gradient(135deg, #f9b40f, #fcd558);
    color: #380041; font-size: 0.88rem; font-weight: 800;
    text-decoration: none; border: none; cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    box-shadow: 0 4px 20px rgba(249,180,15,0.35), inset 0 1px 0 rgba(255,255,255,0.2);
    transition: all 0.2s;
    letter-spacing: 0.01em;
}
.btn-start:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(249,180,15,0.5);
}

@media (max-width: 600px) {
    .intro-body  { padding: 32px 24px; }
    .intro-title { font-size: 1.4rem; }
    .voted-body  { padding: 32px 24px; }
    .voted-title { font-size: 1.3rem; }
    .peace-gif-wrap { width: 130px; height: 130px; }
}
</style>
@endpush

<div class="ballot-wrap">

    @if(auth()->user()->hasVoted())
    {{-- ══════════════════════════════════════════
         ALREADY VOTED STATE
    ══════════════════════════════════════════ --}}
    @php
        $lastVote = auth()->user()->votes()->latest('voted_at')->first();
        $txn      = $lastVote?->transaction_number ?? '—';
        $votedAt  = $lastVote?->voted_at;
        $voteCount = auth()->user()->votes()->whereNotNull('candidate_id')->count();
    @endphp

    <div class="ballot-card voted-card">
        <div class="voted-body">

            {{-- Peace Out GIF --}}
            <div class="peace-gif-wrap">
                <img src="{{ asset('assets/peaceOut.gif') }}" alt="Peace Out">
            </div>

            <h1 class="voted-title">You've Already Voted!</h1>
            <p class="voted-sub">
                Your ballot has been officially recorded and sealed.
                There's nothing left to do here — sit back and watch the results roll in! ✌️
            </p>

            {{-- Stats pills --}}
            <div class="voted-meta-row">
                <span class="voted-meta-pill green">
                    <i class="fas fa-check-double"></i>
                    {{ $voteCount }} position{{ $voteCount !== 1 ? 's' : '' }} voted
                </span>
                @if($votedAt)
                <span class="voted-meta-pill gold">
                    <i class="fas fa-clock"></i>
                    {{ $votedAt->format('M d, Y · g:i A') }}
                </span>
                @endif
            </div>

            {{-- Transaction number --}}
            @if($txn !== '—')
            <div class="txn-box">
                <div class="txn-label">Transaction Number</div>
                <div class="txn-number">{{ $txn }}</div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="voted-actions">
                <a href="{{ route('voter.vote.details') }}" class="btn btn-primary">
                    <i class="fas fa-receipt"></i> View My Voting Details
                </a>
                <a href="{{ route('voter.results') }}" class="btn btn-ghost">
                    <i class="fas fa-chart-bar"></i> See Live Results
                </a>
            </div>

        </div>
    </div>

    @else
    {{-- ══════════════════════════════════════════
         NORMAL INTRO STATE
    ══════════════════════════════════════════ --}}
    <div class="ballot-card">
        <div class="intro-body">

            <div class="intro-seal">🗳️</div>

            <h1 class="intro-title">Official Ballot</h1>
            <p class="intro-sub">
                You are about to cast your official vote for this election.
                Please read the reminders below before you begin.
            </p>

            <div class="intro-meta">
                <i class="fas fa-list-check"></i>
                {{ $totalPositions }} position{{ $totalPositions !== 1 ? 's' : '' }} to vote on
            </div>

            <div class="reminders">
                <div class="reminder">
                    <div class="reminder-icon"><i class="fas fa-shield-halved"></i></div>
                    <div class="reminder-text">Your vote is <strong>anonymous and final</strong>. Once submitted, it cannot be changed or recalled.</div>
                </div>
                <div class="reminder">
                    <div class="reminder-icon"><i class="fas fa-forward-step"></i></div>
                    <div class="reminder-text">You may <strong>skip any position</strong>. Skipped positions will not record a vote — this is allowed.</div>
                </div>
                <div class="reminder">
                    <div class="reminder-icon"><i class="fas fa-magnifying-glass-chart"></i></div>
                    <div class="reminder-text">A <strong>review screen</strong> will appear after all positions so you can confirm your selections before submitting.</div>
                </div>
                <div class="reminder">
                    <div class="reminder-icon"><i class="fas fa-circle-exclamation"></i></div>
                    <div class="reminder-text">You may only vote <strong>once</strong>. Once confirmed, your ballot is permanently sealed.</div>
                </div>
            </div>

            <a href="{{ route('voter.vote.step', 1) }}" class="btn-start">
                <i class="fas fa-vote-yea"></i> Begin Voting
            </a>

        </div>
    </div>
    @endif

</div>
</x-app-layout>