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
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}

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
    .intro-body { padding: 32px 24px; }
    .intro-title { font-size: 1.4rem; }
}
</style>
@endpush

<div class="ballot-wrap">
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
</div>
</x-app-layout>