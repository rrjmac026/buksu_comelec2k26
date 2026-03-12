<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
.ballot-wrap { max-width: 560px; margin: 48px auto; padding: 0 16px; }

.ballot-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(52,211,153,0.2);
    border-radius: 20px;
    box-shadow: 0 8px 48px rgba(0,0,0,0.45), 0 0 40px rgba(52,211,153,0.05), inset 0 1px 0 rgba(52,211,153,0.07);
    overflow: hidden;
    animation: fadeUp 0.5s ease both;
}
.ballot-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #34d399, #6ee7b7, transparent);
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes checkPop {
    0%  { transform: scale(0) rotate(-15deg); }
    60% { transform: scale(1.2) rotate(4deg); }
    100%{ transform: scale(1) rotate(0); }
}
@keyframes ring {
    0%   { transform: scale(0.7); opacity: 0; }
    60%  { transform: scale(1.15); opacity: 0.4; }
    100% { transform: scale(1.4); opacity: 0; }
}

.success-body { padding: 52px 44px; text-align: center; }

.success-icon-wrap {
    position: relative; width: 90px; height: 90px;
    margin: 0 auto 28px;
}
.success-ring {
    position: absolute; inset: -10px; border-radius: 50%;
    border: 2px solid rgba(52,211,153,0.4);
    animation: ring 2s ease-in-out 0.4s infinite;
}
.success-icon {
    width: 90px; height: 90px; border-radius: 50%;
    background: radial-gradient(circle at 40% 35%, rgba(52,211,153,0.18), rgba(52,211,153,0.06));
    border: 2px solid rgba(52,211,153,0.35);
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem; color: #34d399;
    box-shadow: 0 0 40px rgba(52,211,153,0.2);
    animation: checkPop 0.5s cubic-bezier(0.34,1.56,0.64,1) 0.1s both;
}

.success-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem; font-weight: 900;
    background: linear-gradient(135deg, #6ee7b7, #34d399);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text; margin-bottom: 10px;
}
.success-sub {
    font-size: 0.8rem; color: rgba(255,251,240,0.45);
    line-height: 1.75; max-width: 380px; margin: 0 auto 28px;
}

.txn-box {
    display: inline-flex; flex-direction: column; align-items: center;
    padding: 14px 24px; border-radius: 12px; margin-bottom: 28px;
    background: rgba(52,211,153,0.06); border: 1px solid rgba(52,211,153,0.18);
}
.txn-label { font-size: 0.6rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(52,211,153,0.5); margin-bottom: 5px; }
.txn-number { font-family: monospace; font-size: 0.88rem; font-weight: 700; color: #34d399; letter-spacing: 0.06em; }

.votes-count {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 6px 16px; border-radius: 99px;
    background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.15);
    font-size: 0.68rem; font-weight: 700; color: rgba(249,180,15,0.7);
    margin-bottom: 32px;
}

.success-actions { display: flex; flex-direction: column; gap: 10px; align-items: center; }
.btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 28px; border-radius: 10px; font-size: 0.78rem; font-weight: 700;
    cursor: pointer; transition: all 0.18s; text-decoration: none;
    font-family: 'DM Sans', sans-serif; border: none;
}
.btn-primary {
    background: linear-gradient(135deg,#f9b40f,#fcd558); color: #380041;
    box-shadow: 0 4px 16px rgba(249,180,15,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
}
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(249,180,15,0.45); }
.btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.6);
}
.btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; border-color: rgba(249,180,15,0.3); }

.confetti-wrap { pointer-events: none; position: fixed; inset: 0; z-index: 999; overflow: hidden; }
.confetti-piece {
    position: absolute; top: -20px; width: 8px; height: 14px; border-radius: 2px;
    animation: confettiFall linear both;
}
@keyframes confettiFall {
    0%   { transform: translateY(0) rotate(0deg) scale(1); opacity: 1; }
    80%  { opacity: 1; }
    100% { transform: translateY(110vh) rotate(720deg) scale(0.6); opacity: 0; }
}
</style>
@endpush

<div class="confetti-wrap" id="confetti-wrap"></div>

<div class="ballot-wrap">
    <div class="ballot-card">
        <div class="success-body">

            <div class="success-icon-wrap">
                <div class="success-ring"></div>
                <div class="success-icon"><i class="fas fa-check-double"></i></div>
            </div>

            <h1 class="success-title">Vote Submitted!</h1>
            <p class="success-sub">
                Your ballot has been officially recorded and sealed.
                Thank you for participating in this election — your voice matters.
            </p>

            <div class="txn-box">
                <div class="txn-label">Transaction Number</div>
                <div class="txn-number">{{ $txn }}</div>
            </div>

            <div><div class="votes-count">
                <i class="fas fa-check-circle" style="color:#34d399;font-size:0.72rem;"></i>
                {{ $votedCount }} position{{ $votedCount !== 1 ? 's' : '' }} voted on
            </div></div>

            <div class="success-actions">
                <a href="{{ route('voter.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-gauge-high"></i> Back to Dashboard
                </a>
                <a href="{{ route('voter.results') }}" class="btn btn-ghost">
                    <i class="fas fa-chart-bar"></i> View Live Results
                </a>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
// Confetti burst on load
(function() {
    const colors = ['#f9b40f','#fcd558','#34d399','#6ee7b7','#fff3c4','#fffbf0'];
    const wrap   = document.getElementById('confetti-wrap');
    const count  = 80;

    for (let i = 0; i < count; i++) {
        const el = document.createElement('div');
        el.className = 'confetti-piece';
        el.style.left     = Math.random() * 100 + 'vw';
        el.style.background = colors[Math.floor(Math.random() * colors.length)];
        el.style.width    = (Math.random() * 6 + 5) + 'px';
        el.style.height   = (Math.random() * 8 + 10) + 'px';
        el.style.animationDuration  = (Math.random() * 2 + 2) + 's';
        el.style.animationDelay     = (Math.random() * 1.2) + 's';
        el.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
        wrap.appendChild(el);
    }

    // Clean up confetti after 5s
    setTimeout(() => wrap.remove(), 5500);
})();
</script>
@endpush
</x-app-layout>