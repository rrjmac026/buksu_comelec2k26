<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background:#1e0025;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Voting System') }}</title>
        <link rel="icon" href="{{ asset('images/tab_icon.png') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="antialiased" style="background:#1e0025;min-height:100vh;display:flex;flex-direction:column;" x-data>

        {{-- Nav --}}
        @if (Route::has('login'))
        <nav style="position:fixed;top:0;left:0;right:0;z-index:50;height:60px;display:flex;align-items:center;padding:0 32px;background:rgba(26,0,32,0.9);backdrop-filter:blur(20px);border-bottom:1px solid rgba(249,180,15,0.2);">
            <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;flex:1;">
                <img src="{{ asset('assets/app_logo.png') }}" style="height:38px;width:38px;object-fit:cover;border-radius:8px;border:1.5px solid rgba(249,180,15,0.4);">
                <span style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#fffbf0;">
                    {{ config('app.name', 'BukSU') }} <span style="color:#f9b40f;">System</span>
                </span>
            </a>
            <div>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:8px;font-size:0.82rem;font-weight:600;text-decoration:none;color:#380041;background:linear-gradient(135deg,#f9b40f,#fcd558);font-family:'DM Sans',sans-serif;"><i class="fas fa-shield-halved"></i> Admin Dashboard</a>
                    @elseif(Auth::user()->role === 'voter')
                        <a href="{{ route('voter.dashboard') }}" style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:8px;font-size:0.82rem;font-weight:600;text-decoration:none;color:#380041;background:linear-gradient(135deg,#f9b40f,#fcd558);font-family:'DM Sans',sans-serif;"><i class="fas fa-vote-yea"></i> Voter Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:8px;font-size:0.82rem;font-weight:600;text-decoration:none;color:#380041;background:linear-gradient(135deg,#f9b40f,#fcd558);font-family:'DM Sans',sans-serif;"><i class="fas fa-right-to-bracket"></i> Login</a>
                @endauth
            </div>
        </nav>
        @endif

        <div style="padding-top:60px;flex:1;display:flex;flex-direction:column;">

<style>
  html, body { background: #1e0025; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --gold: #f9b40f; --gold-lt: #fcd558; --violet: #380041;
    --violet-md: #520060; --violet-xl: #1e0025; --cream: #fffbf0;
  }

  .outer {
    width: 100%; min-height: calc(100vh - 60px - 57px);
    background: #1e0025;
    background-image:
      radial-gradient(ellipse 80% 60% at 10% 10%, rgba(82,0,96,0.7) 0%, transparent 55%),
      radial-gradient(ellipse 60% 50% at 90% 90%, rgba(56,0,65,0.5) 0%, transparent 55%);
    display: flex; align-items: center; justify-content: center;
    padding: 32px 20px; position: relative; overflow: hidden;
    font-family: 'DM Sans', 'Segoe UI', sans-serif;
    flex: 1;
  }
  .grid-bg {
    position: absolute; inset: 0; pointer-events: none;
    background-image:
      linear-gradient(rgba(249,180,15,0.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(249,180,15,0.04) 1px, transparent 1px);
    background-size: 50px 50px;
  }

  .two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    max-width: 900px; width: 100%;
    position: relative; z-index: 1;
    align-items: start;
  }

  /* ── Shared card base ── */
  .panel {
    background: rgba(30,0,37,0.78);
    border: 1px solid rgba(249,180,15,0.2);
    border-radius: 20px;
    position: relative; overflow: hidden;
    box-shadow: 0 0 0 1px rgba(249,180,15,0.06) inset, 0 20px 60px rgba(0,0,0,0.5);
  }
  .panel::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(249,180,15,0.5), transparent);
    z-index: 2;
  }

  /* ── LEFT panel ── */
  .left-panel { padding: 32px 28px; }

  .eyebrow {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 4px 12px; border-radius: 4px; margin-bottom: 14px;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.3);
    font-size: 0.58rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--gold);
  }
  .eyebrow-dot {
    width: 6px; height: 6px; border-radius: 50%; background: var(--gold);
    animation: epulse 2s ease-in-out infinite; flex-shrink: 0;
  }
  @keyframes epulse { 0%,100%{box-shadow:0 0 6px rgba(249,180,15,0.5)} 50%{box-shadow:0 0 16px rgba(249,180,15,1)} }
  .gold-rule { width: 44px; height: 3px; border-radius: 2px; background: linear-gradient(90deg, var(--gold), var(--gold-lt)); margin-bottom: 12px; }

  .hero-h1 {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 2rem; font-weight: 900; line-height: 1.1;
    color: var(--cream); margin-bottom: 10px;
  }
  .h1-accent {
    background: linear-gradient(105deg, var(--gold) 0%, var(--gold-lt) 60%, #fff3c4 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
  }
  .hero-lead { font-size: 0.8rem; line-height: 1.7; color: rgba(255,251,240,0.65); margin-bottom: 16px; }

  .logo-showcase { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px; margin-bottom: 20px; padding: 8px 0; }
  .logo-img-wrap { position: relative; display: inline-block; }
  .logo-glow { position: absolute; inset: -18px; border-radius: 50%; z-index: 0; background: radial-gradient(ellipse at center, rgba(249,180,15,0.18), transparent 70%); filter: blur(16px); animation: vglow 5s ease-in-out infinite alternate; }
  @keyframes vglow { from{opacity:0.4;transform:scale(0.97)} to{opacity:1;transform:scale(1.04)} }
  .logo-img { position: relative; z-index: 1; width: 240px; height: 240px; object-fit: contain; border-radius: 18px; border: 2px solid rgba(249,180,15,0.28); box-shadow: 0 14px 48px rgba(0,0,0,0.55), 0 0 36px rgba(249,180,15,0.1); display: block; transition: all 0.35s; }
  .logo-img:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 22px 56px rgba(0,0,0,0.65), 0 0 48px rgba(249,180,15,0.2); }
  .logo-chips { display: flex; flex-wrap: wrap; justify-content: center; gap: 7px; }
  .logo-chip { display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px; border-radius: 6px; background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.25); font-size: 0.6rem; font-weight: 700; color: rgba(249,180,15,0.88); }

  .cta-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px; border-radius: 8px;
    font-size: 0.8rem; font-weight: 700; letter-spacing: 0.03em;
    color: var(--violet); background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    box-shadow: 0 4px 20px rgba(249,180,15,0.3); cursor: pointer; border: none; font-family: inherit;
    margin-bottom: 16px; transition: transform 0.2s, box-shadow 0.2s;
  }
  .cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 26px rgba(249,180,15,0.45); }

  .stats-bar {
    display: flex; background: rgba(56,0,65,0.6);
    border: 1px solid rgba(249,180,15,0.15); border-radius: 10px; overflow: hidden;
  }
  .s-item { flex: 1; padding: 8px 4px; text-align: center; border-right: 1px solid rgba(249,180,15,0.1); }
  .s-item:last-child { border-right: none; }
  .s-num {
    font-family: 'Playfair Display', Georgia, serif; font-size: 0.8rem; font-weight: 800;
    background: linear-gradient(105deg, var(--gold), var(--gold-lt));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
  }
  .s-lbl { font-size: 0.48rem; font-weight: 600; color: rgba(249,180,15,0.55); letter-spacing: 0.08em; text-transform: uppercase; margin-top: 2px; }

  /* ── RIGHT panel ── */
  .right-panel { overflow: hidden; }

  /* Right panel header */
  .right-header {
    padding: 22px 24px 16px;
    border-bottom: 1px solid rgba(249,180,15,0.1);
    text-align: center;
  }
  .right-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 3px 10px; border-radius: 4px; margin-bottom: 8px;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.3);
    font-size: 0.56rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--gold);
  }
  .right-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 1.3rem; font-weight: 900; color: var(--cream); line-height: 1.2;
  }
  .right-sub { font-size: 0.68rem; color: rgba(255,251,240,0.45); margin-top: 4px; }

  /* Slide viewport inside right panel */
  .slide-viewport {
    height: 400px;
    overflow: hidden;
    position: relative;
  }
  /* Fade edges */
  .slide-viewport::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 40px;
    background: linear-gradient(transparent, rgba(30,0,37,0.6));
    pointer-events: none; z-index: 2;
  }

  .slide-strip {
    display: flex; flex-direction: column;
    transition: transform 0.85s cubic-bezier(0.77, 0, 0.175, 1);
    will-change: transform;
  }

  /* Each member slide */
  .member-slide {
    min-height: 400px; flex-shrink: 0;
    padding: 24px 24px 20px;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
  }

  .avatar-wrap { width: 160px; height: 160px; margin: 0 auto 16px; position: relative; }
  .avatar {
    width: 160px; height: 160px; border-radius: 50%;
    border: 3px solid rgba(249,180,15,0.45);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 3rem; font-weight: 900; color: var(--gold);
    overflow: hidden;
    box-shadow: 0 0 24px rgba(249,180,15,0.15);
  }
  .avatar img { width: 100%; height: 100%; object-fit: cover; object-position: top center; display: block; }
  .av1 { background: linear-gradient(135deg, #2d003a, #520060); }
  .av2 { background: linear-gradient(135deg, #1e0025, #3a0045); }
  .av3 { background: linear-gradient(135deg, #2a0035, #4a005a); }

  .spin-ring {
    position: absolute; inset: -6px; border-radius: 50%;
    border: 2px solid transparent;
    border-top-color: var(--gold);
    border-right-color: rgba(249,180,15,0.25);
    animation: spin 4s linear infinite;
  }
  @keyframes spin { to { transform: rotate(360deg); } }
  .member-num {
    position: absolute; top: -2px; right: -2px;
    width: 22px; height: 22px; border-radius: 50%;
    background: var(--gold); color: var(--violet);
    font-size: 0.6rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid #1e0025;
  }

  .member-name {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 1.15rem; font-weight: 800; color: var(--cream); margin-bottom: 3px; text-align: center;
  }
  .member-role {
    font-size: 0.58rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 10px; text-align: center;
  }

  .contrib-bar { background: rgba(249,180,15,0.07); border-radius: 8px; padding: 10px 14px; width: 100%; }
  .contrib-label { font-size: 0.55rem; font-weight: 700; color: rgba(249,180,15,0.5); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 7px; }
  .contrib-item { display: flex; align-items: center; gap: 7px; margin-bottom: 4px; }
  .contrib-item:last-child { margin-bottom: 0; }
  .contrib-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
  .contrib-text { font-size: 0.63rem; color: rgba(255,251,240,0.55); }

  /* Right panel footer */
  .right-footer {
    padding: 12px 24px 16px;
    border-top: 1px solid rgba(249,180,15,0.1);
    display: flex; align-items: center; justify-content: space-between;
  }
  .dots { display: flex; gap: 6px; align-items: center; }
  .dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: rgba(249,180,15,0.2); transition: all 0.35s; cursor: pointer;
  }
  .dot.active { background: var(--gold); width: 18px; border-radius: 3px; box-shadow: 0 0 8px rgba(249,180,15,0.5); }

  .nav-btns { display: flex; gap: 6px; }
  .nav-btn {
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.25);
    color: var(--gold); font-size: 0.7rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.2s;
  }
  .nav-btn:hover { background: rgba(249,180,15,0.22); transform: scale(1.1); }
  .nav-btn:disabled { opacity: 0.3; cursor: default; transform: none; }

  .slide-counter { font-size: 0.6rem; font-weight: 700; color: rgba(249,180,15,0.45); letter-spacing: 0.06em; }

  /* progress bar */
  .progress-wrap { height: 2px; background: rgba(249,180,15,0.1); }
  .progress-bar {
    height: 2px; background: linear-gradient(90deg, var(--gold), var(--gold-lt));
    transition: width 4s linear;
    box-shadow: 0 0 6px rgba(249,180,15,0.4);
  }

  /* ══════════════════════════════════════
     RESPONSIVE — Mobile & Tablet
  ══════════════════════════════════════ */

  /* Tablet: stack columns */
  @media (max-width: 768px) {
    .outer {
      padding: 16px 12px;
      min-height: unset;
      align-items: flex-start;
    }

    .two-col {
      grid-template-columns: 1fr;
      gap: 16px;
      max-width: 100%;
    }

    /* Left panel */
    .left-panel { padding: 24px 20px; }

    .hero-h1 { font-size: 1.6rem; }
    .hero-lead { font-size: 0.78rem; margin-bottom: 14px; }

    .logo-img { width: 160px !important; height: 160px !important; }
    .logo-showcase { gap: 12px; margin-bottom: 16px; }
    .logo-chips { gap: 6px; }
    .logo-chip { font-size: 0.58rem; padding: 3px 9px; }

    .stats-bar { border-radius: 8px; }
    .s-item { padding: 8px 4px; }
    .s-num { font-size: 0.72rem; }
    .s-lbl { font-size: 0.42rem; }

    /* Right panel */
    .right-header { padding: 18px 20px 14px; }
    .right-title { font-size: 1.15rem; }
    .right-sub { font-size: 0.62rem; }

    .slide-viewport { height: 380px; }
    .member-slide { min-height: 380px; padding: 20px 18px 16px; }

    .avatar { width: 90px !important; height: 90px !important; font-size: 1.8rem; border-radius: 50% !important; }
    .avatar-wrap { width: 90px !important; height: 90px !important; margin-bottom: 12px; }
    .member-name { font-size: 1rem; }
    .contrib-bar { padding: 8px 12px; }
    .contrib-text { font-size: 0.6rem; }

    .right-footer { padding: 10px 18px 14px; }
  }

  /* Small mobile */
  @media (max-width: 480px) {
    .outer { padding: 12px 10px; }

    nav { padding: 0 16px !important; }
    nav span { font-size: 0.9rem !important; }
    nav img { height: 32px !important; width: 32px !important; }
    nav a[style] { padding: 6px 14px !important; font-size: 0.75rem !important; }

    .left-panel { padding: 20px 16px; }
    .hero-h1 { font-size: 1.4rem; }
    .eyebrow { font-size: 0.52rem; padding: 3px 10px; }
    .gold-rule { width: 36px; margin-bottom: 10px; }

    .logo-img { width: 130px !important; height: 130px !important; }
    .logo-chips { gap: 5px; }
    .logo-chip { font-size: 0.54rem; padding: 3px 8px; }

    .s-num { font-size: 0.65rem; }
    .s-lbl { font-size: 0.38rem; letter-spacing: 0.04em; }
    .s-item { padding: 7px 2px; }

    .right-title { font-size: 1rem; }
    .right-eyebrow { font-size: 0.5rem; }

    .slide-viewport { height: 360px; }
    .member-slide { min-height: 360px; padding: 16px 14px; }
    .avatar { width: 80px !important; height: 80px !important; font-size: 1.6rem; border-radius: 50% !important; }
    .avatar-wrap { width: 80px !important; height: 80px !important; }
    .spin-ring { inset: -4px; border-radius: 50% !important; }
    .member-name { font-size: 0.95rem; }
    .member-role { font-size: 0.52rem; margin-bottom: 8px; }
    .contrib-bar { padding: 7px 10px; }
    .contrib-label { font-size: 0.5rem; margin-bottom: 5px; }
    .contrib-text { font-size: 0.58rem; }
    .contrib-item { gap: 5px; margin-bottom: 3px; }

    .right-footer { padding: 8px 14px 12px; }
    .slide-counter { font-size: 0.54rem; }
    .nav-btn { width: 24px; height: 24px; font-size: 0.6rem; }
    .dot { width: 5px; height: 5px; }
    .dot.active { width: 14px; }
  }

</style>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="outer">
  <div class="grid-bg"></div>

  <div class="two-col">

    <!-- ── LEFT: Vote Matters ── -->
    <div class="panel left-panel">
      <div class="eyebrow"><div class="eyebrow-dot"></div> Trusted Online Voting Platform</div>
      <div class="gold-rule"></div>
      <h1 class="hero-h1">Your Vote <span class="h1-accent">Matters</span></h1>
      <p class="hero-lead">Welcome to our Online Voting System — ensuring fair, transparent, and secure elections for every student voice.</p>
      <div class="logo-showcase">
        <div class="logo-img-wrap">
          <div class="logo-glow"></div>
          <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" class="logo-img">
        </div>
        <div class="logo-chips">
          <span class="logo-chip"><i class="fas fa-shield-alt" style="font-size:0.58rem"></i> Secure</span>
          <span class="logo-chip"><i class="fas fa-eye" style="font-size:0.58rem"></i> Transparent</span>
          <span class="logo-chip"><i class="fas fa-bolt" style="font-size:0.58rem"></i> Real-time</span>
          <span class="logo-chip"><i class="fas fa-user-secret" style="font-size:0.58rem"></i> Anonymous</span>
        </div>
      </div>

      <div class="stats-bar">
        <div class="s-item"><div class="s-num">99.9%</div><div class="s-lbl">Uptime</div></div>
        <div class="s-item"><div class="s-num">256-bit</div><div class="s-lbl">Encrypted</div></div>
        <div class="s-item"><div class="s-num" id="stat-votes-cast">0</div><div class="s-lbl">Votes Cast</div></div>
        <div class="s-item"><div class="s-num">Anon</div><div class="s-lbl">Ballots</div></div>
      </div>
    </div>

    <!-- ── RIGHT: Team slider ── -->
    <div class="panel right-panel">
      <div class="right-header">
        <div class="right-eyebrow"><i class="fas fa-laptop-code" style="font-size:0.55rem"></i>&nbsp; System Developers</div>
        <div class="right-title">Meet the <span class="h1-accent">IT Team</span></div>
        <div class="right-sub">The people who built this platform</div>
      </div>

      <div class="progress-wrap"><div class="progress-bar" id="pbar" style="width:0%"></div></div>

      <div class="slide-viewport">
        <div class="slide-strip" id="strip">

          <!-- Dev 1 -->
          <div class="member-slide">
            <div class="avatar-wrap">
              <div class="avatar av1"><img src="{{ asset('assets/team/dev1.jpg') }}" alt="Dev 1" onerror="this.parentElement.innerHTML='JD'"></div>
              <div class="spin-ring"></div>
              <div class="member-num">1</div>
            </div>
            <div class="member-name">Rey Rameses Jude "Jam" Macalutas III</div>
            <div class="member-role">System Developer / Lead Developer</div>
            <div class="contrib-bar">
              <div class="contrib-label">Key Contributions</div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Built the full-stack system end-to-end</div></div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Designed the overall look & feel of the app</div></div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Kept the codebase clean & running solid</div></div>
            </div>
          </div>

          <!-- Dev 2 -->
          <div class="member-slide">
            <div class="avatar-wrap">
              <div class="avatar av2"><img src="{{ asset('assets/team/dev2.jpg') }}" alt="Dev 2" onerror="this.parentElement.innerHTML='MS'"></div>
              <div class="spin-ring"></div>
              <div class="member-num">2</div>
            </div>
            <div class="member-name">Khyle Ivan Kim Amacna</div>
            <div class="member-role">Head System Developer</div>
            <div class="contrib-bar">
              <div class="contrib-label">Key Contributions</div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Led the team & kept everything moving</div></div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Crafted intuitive UI/UX experiences</div></div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Made sure every screen looks just right</div></div>
            </div>
          </div>

          <!-- Dev 3 -->
          <div class="member-slide">
            <div class="avatar-wrap">
              <div class="avatar av3"><img src="{{ asset('assets/team/dev3.jpg') }}" alt="Dev 3" onerror="this.parentElement.innerHTML='AR'"></div>
              <div class="spin-ring"></div>
              <div class="member-num">3</div>
            </div>
            <div class="member-name">Bernardo DeLa Cerna Jr.</div>
            <div class="member-role">System Developer / QA</div>
            <div class="contrib-bar">
              <div class="contrib-label">Key Contributions</div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Tested & caught bugs before they cause trouble</div></div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Handled & cleaned up all the messy data</div></div>
              <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Made sure the numbers always add up right</div></div>
            </div>
          </div>

        </div>
      </div>

      <div class="right-footer">
        <span class="slide-counter" id="counter">1 / 3</span>
        <div class="dots" id="dots"></div>
        <div class="nav-btns">
          <button class="nav-btn" id="prevBtn" onclick="go(-1)" disabled><i class="fas fa-chevron-up"></i></button>
          <button class="nav-btn" id="nextBtn" onclick="go(1)"><i class="fas fa-chevron-down"></i></button>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  const total = 3;
  let current = 0;
  let autoTimer, pbarTimer;
  function getSlideH() {
    if (window.innerWidth <= 480) return 360;
    if (window.innerWidth <= 768) return 380;
    return 400;
  }
  let SLIDE_H = getSlideH();
  window.addEventListener('resize', () => {
    SLIDE_H = getSlideH();
    strip.style.transition = 'none';
    strip.style.transform = 'translateY(-' + (current * SLIDE_H) + 'px)';
  });

  const strip = document.getElementById('strip');
  const dotsEl = document.getElementById('dots');
  const counter = document.getElementById('counter');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const pbar = document.getElementById('pbar');

  for (let i = 0; i < total; i++) {
    const d = document.createElement('div');
    d.className = 'dot' + (i === 0 ? ' active' : '');
    d.onclick = () => { goTo(i); resetAuto(); };
    dotsEl.appendChild(d);
  }

  function goTo(idx) {
    current = (idx + total) % total;
    strip.style.transform = `translateY(-${current * SLIDE_H}px)`;
    document.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === current));
    counter.textContent = `${current + 1} / ${total}`;
    prevBtn.disabled = current === 0;
    nextBtn.disabled = current === total - 1;
    startProgress();
  }

  function go(dir) { goTo(current + dir); resetAuto(); }

  function startProgress() {
    pbar.style.transition = 'none';
    pbar.style.width = '0%';
    requestAnimationFrame(() => requestAnimationFrame(() => {
      pbar.style.transition = 'width 4s linear';
      pbar.style.width = '100%';
    }));
  }

  function resetAuto() {
    clearInterval(autoTimer);
    autoTimer = setInterval(() => {
      goTo(current < total - 1 ? current + 1 : 0);
    }, 4000);
  }

  setTimeout(() => { resetAuto(); startProgress(); }, 1500);
</script>

        </div>

        <footer style="background:rgba(26,0,32,0.95);border-top:1px solid rgba(249,180,15,0.15);text-align:center;padding:16px 40px;">
            <p style="color:rgba(255,251,240,0.45);font-size:0.8rem;margin:0;">
                &copy; {{ date('Y') }} <span style="color:#f9b40f;font-weight:700;">{{ config('app.name', 'Voting System') }}.</span> All rights reserved.
            </p>
        </footer>

        <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                init() { this.on = localStorage.getItem('theme') === 'dark'; document.documentElement.classList.toggle('dark', this.on); },
                on: false,
                toggle() { this.on = !this.on; localStorage.setItem('theme', this.on ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', this.on); }
            });
        });

        // Live stats
        (function(){
            const el = document.getElementById('stat-votes-cast');
            let prev = null;
            function fetch_stats() {
                fetch('/public/stats').then(r=>r.json()).then(d=>{
                    const v = d.votes_cast ?? 0;
                    if(v !== prev && el){ el.textContent = v.toLocaleString(); prev = v; }
                }).catch(()=>{});
            }
            fetch_stats(); setInterval(fetch_stats, 15000);
        })();
        </script>
    </body>
</html>