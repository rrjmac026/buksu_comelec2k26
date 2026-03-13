<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ─── Page wrapper ─── */
    .sv-wrap {
        max-width: 640px;
        margin: 32px auto;
        padding: 0 16px 60px;
        position: relative;
    }

    /* ─── Floating orbs background ─── */
    .sv-orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
        animation: orbFloat linear infinite;
    }
    .sv-orb-1 { width:360px;height:360px; background:rgba(52,211,153,0.09); top:-80px; right:-100px; animation-duration:20s; }
    .sv-orb-2 { width:280px;height:280px; background:rgba(249,180,15,0.07); bottom:10%; left:-80px; animation-duration:26s; animation-delay:-8s; }
    .sv-orb-3 { width:200px;height:200px; background:rgba(110,231,183,0.06); top:40%; right:5%;  animation-duration:18s; animation-delay:-5s; }
    @keyframes orbFloat {
        0%,100% { transform: translateY(0) scale(1); }
        50%      { transform: translateY(-30px) scale(1.05); }
    }

    /* ─── Main card ─── */
    .sv-card {
        background: rgba(22,0,28,0.92);
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
        border: 1px solid rgba(52,211,153,0.22);
        border-radius: 24px;
        box-shadow:
            0 0 0 1px rgba(52,211,153,0.06) inset,
            0 12px 60px rgba(0,0,0,0.55),
            0 0 80px rgba(52,211,153,0.06);
        overflow: hidden;
        position: relative;
        z-index: 1;
        animation: cardEntrance 0.7s cubic-bezier(0.22,1,0.36,1) both;
    }
    @keyframes cardEntrance {
        from { opacity:0; transform:translateY(32px) scale(0.96); }
        to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* Top shimmer bar */
    .sv-card::before {
        content:'';
        display:block; height:3px;
        background: linear-gradient(90deg,
            transparent 0%,
            rgba(52,211,153,0.2) 10%,
            #34d399 40%,
            #6ee7b7 60%,
            rgba(52,211,153,0.2) 90%,
            transparent 100%);
        animation: shimmerBar 3s ease-in-out infinite;
        background-size: 200% 100%;
    }
    @keyframes shimmerBar {
        0%,100% { background-position:0% 0%; }
        50%      { background-position:100% 0%; }
    }

    /* ─── GIF section ─── */
    .sv-gif-section {
        position: relative;
        display: flex;
        justify-content: center;
        padding: 44px 0 0;
    }

    .sv-gif-ring {
        position: relative;
        width: 190px;
        height: 190px;
    }

    /* Rotating dashed ring */
    .sv-gif-ring::before {
        content: '';
        position: absolute;
        inset: -10px;
        border-radius: 50%;
        border: 2px dashed rgba(52,211,153,0.35);
        animation: ringRotate 12s linear infinite;
    }
    /* Pulsing glow ring */
    .sv-gif-ring::after {
        content: '';
        position: absolute;
        inset: -20px;
        border-radius: 50%;
        border: 1px solid rgba(52,211,153,0.12);
        animation: ringPulse 2.5s ease-in-out infinite;
    }
    @keyframes ringRotate { to { transform: rotate(360deg); } }
    @keyframes ringPulse  {
        0%,100% { transform:scale(1);   opacity:0.5; }
        50%      { transform:scale(1.06); opacity:1; }
    }

    .sv-gif-frame {
        width: 190px;
        height: 190px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid rgba(52,211,153,0.4);
        box-shadow:
            0 0 0 6px rgba(52,211,153,0.06),
            0 0 50px rgba(52,211,153,0.2),
            0 8px 32px rgba(0,0,0,0.5);
        position: relative;
        z-index: 1;
        animation: gifBounce 0.7s cubic-bezier(0.34,1.56,0.64,1) 0.3s both;
    }
    @keyframes gifBounce {
        from { transform: scale(0.5); opacity:0; }
        to   { transform: scale(1);   opacity:1; }
    }
    .sv-gif-frame img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Badge on gif */
    .sv-gif-badge {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: linear-gradient(135deg, #34d399, #6ee7b7);
        color: #064e3b;
        font-size: 0.55rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 5px 10px;
        border-radius: 99px;
        z-index: 2;
        box-shadow: 0 2px 12px rgba(52,211,153,0.5);
        animation: badgePop 0.4s cubic-bezier(0.34,1.56,0.64,1) 0.8s both;
    }
    @keyframes badgePop {
        from { transform:scale(0); opacity:0; }
        to   { transform:scale(1); opacity:1; }
    }

    /* ─── Body text ─── */
    .sv-body {
        padding: 32px 40px 40px;
        text-align: center;
    }
    @media (max-width: 500px) { .sv-body { padding: 24px 22px 32px; } }

    .sv-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 900;
        line-height: 1.15;
        background: linear-gradient(135deg, #6ee7b7 0%, #34d399 50%, #a7f3d0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
        animation: titleSlide 0.5s ease 0.5s both;
    }
    @keyframes titleSlide {
        from { opacity:0; transform:translateY(12px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .sv-subtitle {
        font-size: 0.82rem;
        color: rgba(255,251,240,0.5);
        line-height: 1.8;
        max-width: 420px;
        margin: 0 auto 28px;
        animation: titleSlide 0.5s ease 0.6s both;
    }

    /* ─── TXN box ─── */
    .sv-txn-wrap {
        animation: titleSlide 0.5s ease 0.65s both;
        margin-bottom: 24px;
    }
    .sv-txn-box {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        padding: 14px 28px;
        border-radius: 14px;
        background: rgba(52,211,153,0.05);
        border: 1px solid rgba(52,211,153,0.18);
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }
    .sv-txn-box:hover {
        background: rgba(52,211,153,0.1);
        border-color: rgba(52,211,153,0.35);
        transform: translateY(-1px);
        box-shadow: 0 6px 24px rgba(52,211,153,0.12);
    }
    .sv-txn-box::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(52,211,153,0.08), transparent);
        opacity: 0;
        transition: opacity 0.2s;
    }
    .sv-txn-box:hover::after { opacity: 1; }

    .sv-txn-label {
        font-size: 0.58rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(52,211,153,0.5);
        margin-bottom: 6px;
    }
    .sv-txn-number {
        font-family: monospace;
        font-size: 0.92rem;
        font-weight: 700;
        color: #34d399;
        letter-spacing: 0.06em;
    }
    .sv-txn-hint {
        font-size: 0.58rem;
        color: rgba(52,211,153,0.35);
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ─── Stats pills ─── */
    .sv-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 28px;
        animation: titleSlide 0.5s ease 0.7s both;
    }
    .sv-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 99px;
        font-size: 0.68rem;
        font-weight: 700;
    }
    .sv-pill-green {
        background: rgba(52,211,153,0.1);
        border: 1px solid rgba(52,211,153,0.22);
        color: #34d399;
    }
    .sv-pill-gold {
        background: rgba(249,180,15,0.08);
        border: 1px solid rgba(249,180,15,0.2);
        color: rgba(249,180,15,0.85);
    }

    /* ─── Divider ─── */
    .sv-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(52,211,153,0.12), transparent);
        margin: 0 0 28px;
        animation: titleSlide 0.5s ease 0.75s both;
    }

    /* ─── Action buttons ─── */
    .sv-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
        animation: titleSlide 0.5s ease 0.8s both;
    }
    .sv-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 13px 32px;
        border-radius: 12px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        font-family: 'DM Sans', sans-serif;
        border: none;
        min-width: 240px;
        justify-content: center;
    }
    .sv-btn-primary {
        background: linear-gradient(135deg, #f9b40f, #fcd558);
        color: #380041;
        box-shadow: 0 4px 20px rgba(249,180,15,0.3), inset 0 1px 0 rgba(255,255,255,0.25);
    }
    .sv-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(249,180,15,0.5);
    }
    .sv-btn-secondary {
        background: transparent;
        border: 1px solid rgba(52,211,153,0.25);
        color: rgba(52,211,153,0.75);
    }
    .sv-btn-secondary:hover {
        background: rgba(52,211,153,0.07);
        color: #34d399;
        border-color: rgba(52,211,153,0.45);
        transform: translateY(-1px);
    }
    .sv-btn-ghost {
        background: transparent;
        border: 1px solid rgba(249,180,15,0.15);
        color: rgba(249,180,15,0.55);
        font-size: 0.72rem;
        padding: 9px 22px;
        min-width: unset;
    }
    .sv-btn-ghost:hover {
        background: rgba(249,180,15,0.06);
        color: rgba(249,180,15,0.85);
        border-color: rgba(249,180,15,0.3);
    }

    /* ─── Share strip ─── */
    .sv-share-strip {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        margin-top: 6px;
    }
    .sv-share-label {
        font-size: 0.62rem;
        color: rgba(255,251,240,0.2);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    /* ─── Integrity strip ─── */
    .sv-integrity {
        margin: 28px 40px 0;
        padding: 12px 16px;
        border-radius: 10px;
        background: rgba(249,180,15,0.03);
        border: 1px solid rgba(249,180,15,0.08);
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.66rem;
        color: rgba(255,251,240,0.3);
        line-height: 1.7;
    }
    @media (max-width: 500px) { .sv-integrity { margin: 24px 22px 0; } }

    /* ─── Confetti canvas ─── */
    #sv-confetti {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 9999;
    }

    /* ─── Copied tooltip ─── */
    .sv-copied-toast {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: rgba(52,211,153,0.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(52,211,153,0.3);
        color: #34d399;
        padding: 10px 20px;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s;
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .sv-copied-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
</style>
@endpush

{{-- Confetti canvas --}}
<canvas id="sv-confetti"></canvas>

{{-- Copied toast --}}
<div class="sv-copied-toast" id="sv-toast">
    <i class="fas fa-check"></i> Transaction number copied!
</div>

<div class="sv-wrap">

    {{-- Background orbs --}}
    <div class="sv-orb sv-orb-1"></div>
    <div class="sv-orb sv-orb-2"></div>
    <div class="sv-orb sv-orb-3"></div>

    <div class="sv-card">

        {{-- ── Peace Out GIF section ── --}}
        <div class="sv-gif-section">
            <div class="sv-gif-ring">
                <div class="sv-gif-frame">
                    <img src="{{ asset('assets/peaceOut.gif') }}" alt="Peace Out ✌️">
                </div>
                <div class="sv-gif-badge">✌️ Peace Out</div>
            </div>
        </div>

        {{-- ── Body ── --}}
        <div class="sv-body">

            <h1 class="sv-title">Vote Submitted! ✌️</h1>
            <p class="sv-subtitle">
                Your ballot is officially sealed and recorded.
                Thank you for exercising your right to vote —
                your voice shapes the future of this organization. You're done here, go touch some grass!
            </p>

            {{-- Stats pills --}}
            <div class="sv-stats">
                <span class="sv-pill sv-pill-green">
                    <i class="fas fa-check-double" style="font-size:0.6rem;"></i>
                    {{ $votedCount }} position{{ $votedCount !== 1 ? 's' : '' }} voted
                </span>
                <span class="sv-pill sv-pill-gold">
                    <i class="fas fa-shield-halved" style="font-size:0.6rem;"></i>
                    Ballot sealed &amp; secure
                </span>
            </div>

            {{-- Transaction box (clickable to copy) --}}
            <div class="sv-txn-wrap">
                <div class="sv-txn-box" onclick="copyTxn('{{ $txn }}')" title="Click to copy">
                    <div class="sv-txn-label">Transaction Number</div>
                    <div class="sv-txn-number" id="txn-display">{{ $txn }}</div>
                    <div class="sv-txn-hint">
                        <i class="fas fa-copy" style="font-size:0.52rem;"></i>
                        Click to copy
                    </div>
                </div>
            </div>

            <div class="sv-divider"></div>

            {{-- Actions --}}
            <div class="sv-actions">
                <a href="{{ route('voter.vote.details') }}" class="sv-btn sv-btn-primary">
                    <i class="fas fa-receipt"></i> View My Voting Details
                </a>
                <a href="{{ route('voter.dashboard') }}" class="sv-btn sv-btn-ghost">
                    <i class="fas fa-gauge-high"></i> Back to Dashboard
                </a>
            </div>

        </div>

        {{-- Integrity strip --}}
        <div class="sv-integrity">
            <i class="fas fa-lock" style="color:rgba(249,180,15,0.4);flex-shrink:0;margin-top:1px;font-size:0.72rem;"></i>
            <span>
                Your vote is <strong style="color:rgba(249,180,15,0.6);">anonymous and final.</strong>
                No one — including administrators — can link your identity to your specific choices.
                The integrity of this election is fully preserved.
            </span>
        </div>

        <div style="height:28px;"></div>

    </div>
</div>

@push('scripts')
<script>
// ── Confetti burst ────────────────────────────────────────────────────────
(function() {
    const canvas = document.getElementById('sv-confetti');
    const ctx    = canvas.getContext('2d');
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;

    const colors = ['#34d399','#6ee7b7','#f9b40f','#fcd558','#a7f3d0','#fffbf0','#fff3c4'];

    const pieces = Array.from({ length: 110 }, () => ({
        x:    Math.random() * canvas.width,
        y:    -Math.random() * canvas.height * 0.5,
        r:    Math.random() * 6 + 4,
        dx:   (Math.random() - 0.5) * 2,
        dy:   Math.random() * 3.5 + 1.5,
        rot:  Math.random() * 360,
        drot: (Math.random() - 0.5) * 5,
        col:  colors[Math.floor(Math.random() * colors.length)],
        shape: Math.random() > 0.5 ? 'rect' : 'circle',
        w:    Math.random() * 8 + 6,
        h:    Math.random() * 5 + 3,
        opacity: 1,
    }));

    let frame = 0;

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        let alive = false;

        pieces.forEach(p => {
            p.x   += p.dx;
            p.y   += p.dy;
            p.rot += p.drot;
            p.dy  += 0.04; // gravity
            if (p.y > canvas.height * 0.8) p.opacity -= 0.025;

            if (p.opacity <= 0) return;
            alive = true;

            ctx.save();
            ctx.globalAlpha = Math.max(0, p.opacity);
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rot * Math.PI / 180);
            ctx.fillStyle = p.col;

            if (p.shape === 'circle') {
                ctx.beginPath();
                ctx.arc(0, 0, p.r, 0, Math.PI * 2);
                ctx.fill();
            } else {
                ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
            }
            ctx.restore();
        });

        frame++;
        if (alive && frame < 300) requestAnimationFrame(draw);
        else canvas.remove();
    }

    // Delay start slightly so card animation finishes first
    setTimeout(draw, 500);
})();

// ── Copy TXN to clipboard ─────────────────────────────────────────────────
function copyTxn(txn) {
    navigator.clipboard.writeText(txn).then(() => {
        const toast = document.getElementById('sv-toast');
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2500);
    }).catch(() => {
        // Fallback for older browsers
        const el = document.createElement('textarea');
        el.value = txn;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        const toast = document.getElementById('sv-toast');
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2500);
    });
}
</script>
@endpush
</x-app-layout>