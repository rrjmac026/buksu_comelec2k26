<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Voting System') }}</title>
        <link rel="icon" href="{{ asset('images/tab_icon.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --v50:#f5f3ff;--v100:#ede9fe;--v200:#ddd6fe;--v300:#c4b5fd;
                --v400:#a78bfa;--v500:#8b5cf6;--v600:#7c3aed;--v700:#6d28d9;
                --v800:#5b21b6;--v900:#4c1d95;
            }

            html, body { height: 100%; margin: 0; }

            body {
                background: var(--v50);
                background-image:
                    radial-gradient(ellipse 80% 60% at 10% -10%, rgba(139,92,246,0.14) 0%, transparent 60%),
                    radial-gradient(ellipse 60% 50% at 90% 100%, rgba(109,40,217,0.1) 0%, transparent 55%);
            }
            body.dark {
                background: #0f0a1e;
                background-image:
                    radial-gradient(ellipse 80% 60% at 10% -10%, rgba(109,40,217,0.28) 0%, transparent 60%),
                    radial-gradient(ellipse 60% 50% at 90% 100%, rgba(76,29,149,0.22) 0%, transparent 55%);
            }

            /* ── Floating orbs ── */
            .orb {
                position: fixed; border-radius: 50%; pointer-events: none; z-index: 0;
                filter: blur(72px); opacity: 0.5;
            }
            .orb-1 { width: 520px; height: 520px; top: -140px; left: -120px; background: radial-gradient(circle, rgba(167,139,250,0.4), transparent 70%); animation: orb1 15s ease-in-out infinite alternate; }
            .orb-2 { width: 420px; height: 420px; bottom: -100px; right: -100px; background: radial-gradient(circle, rgba(109,40,217,0.32), transparent 70%); animation: orb2 19s ease-in-out infinite alternate; }
            body.dark .orb { opacity: 0.65; }
            @keyframes orb1 { from{transform:translate(0,0)} to{transform:translate(40px,30px)} }
            @keyframes orb2 { from{transform:translate(0,0)} to{transform:translate(-30px,-35px)} }

            /* ── Nav ── */
            nav.top-nav {
                position: fixed; top: 0; left: 0; right: 0; z-index: 50;
                height: 68px;
                display: flex; align-items: center;
                padding: 0 32px;
                background: rgba(255,255,255,0.88);
                backdrop-filter: blur(22px) saturate(1.8);
                -webkit-backdrop-filter: blur(22px) saturate(1.8);
                border-bottom: 1px solid rgba(139,92,246,0.15);
                box-shadow: 0 1px 24px rgba(109,40,217,0.08);
            }
            body.dark nav.top-nav {
                background: rgba(15,10,30,0.92);
                border-bottom-color: rgba(139,92,246,0.25);
                box-shadow: 0 1px 32px rgba(109,40,217,0.2);
            }
            nav.top-nav::after {
                content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
                background: linear-gradient(90deg, var(--v700) 0%, var(--v400) 50%, transparent 100%);
                opacity: 0.35;
            }

            .nav-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; flex: 1; }
            .nav-logo img {
                height: 40px; width: 40px; object-fit: cover;
                border-radius: 10px;
                border: 1.5px solid rgba(139,92,246,0.3);
                box-shadow: 0 2px 14px rgba(109,40,217,0.2);
            }
            .nav-app-name {
                font-size: 1.1rem; font-weight: 800; letter-spacing: -0.01em;
                color: #1e1b4b;
            }
            body.dark .nav-app-name { color: #f5f3ff; }
            .nav-app-name .accent {
                background: linear-gradient(105deg, var(--v700), var(--v400));
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }

            .btn-nav {
                display: inline-flex; align-items: center; gap: 7px;
                padding: 9px 18px; border-radius: 10px;
                font-size: 0.85rem; font-weight: 600; text-decoration: none;
                color: #fff !important;
                background: linear-gradient(135deg, var(--v700), var(--v500));
                border: 1px solid rgba(255,255,255,0.15);
                box-shadow: 0 3px 16px rgba(109,40,217,0.3);
                transition: all 0.2s;
            }
            .btn-nav:hover {
                background: linear-gradient(135deg, var(--v800), var(--v600));
                transform: translateY(-1px);
                box-shadow: 0 6px 22px rgba(109,40,217,0.42);
            }

            /* ── Main layout ── */
            .page-wrap {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .hero-section {
                flex: 1;
                display: flex;
                align-items: center;
                padding-top: 68px; /* nav height */
                position: relative;
                z-index: 1;
            }

            .hero-inner {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 48px 32px;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 48px;
                align-items: center;
            }

            @media (max-width: 1024px) {
                .hero-inner {
                    grid-template-columns: 1fr;
                    padding: 40px 24px;
                    gap: 32px;
                }
                .visual-col { display: none; }
            }

            /* ── Left card ── */
            .hero-card {
                background: rgba(255,255,255,0.75);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(139,92,246,0.16);
                border-radius: 24px;
                padding: 40px;
                box-shadow: 0 4px 6px rgba(109,40,217,0.04), 0 20px 60px rgba(109,40,217,0.1), inset 0 1px 0 rgba(255,255,255,0.9);
            }
            body.dark .hero-card {
                background: rgba(23,12,48,0.8);
                border-color: rgba(139,92,246,0.25);
                box-shadow: 0 4px 6px rgba(0,0,0,0.2), 0 20px 60px rgba(0,0,0,0.4), inset 0 1px 0 rgba(139,92,246,0.1);
            }

            /* Eyebrow */
            .eyebrow {
                display: inline-flex; align-items: center; gap: 7px;
                padding: 5px 13px; border-radius: 99px; margin-bottom: 16px;
                background: linear-gradient(135deg, rgba(109,40,217,0.1), rgba(139,92,246,0.08));
                border: 1px solid rgba(139,92,246,0.22);
                font-size: 0.68rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
                color: var(--v700);
            }
            body.dark .eyebrow { color: var(--v400); background: rgba(139,92,246,0.15); border-color: rgba(139,92,246,0.3); }
            .eyebrow-dot {
                width: 7px; height: 7px; border-radius: 50%;
                background: linear-gradient(135deg, var(--v600), var(--v400));
                box-shadow: 0 0 8px rgba(139,92,246,0.6);
                animation: epulse 2s ease-in-out infinite;
                flex-shrink: 0;
            }
            @keyframes epulse { 0%,100%{box-shadow:0 0 6px rgba(139,92,246,0.4)} 50%{box-shadow:0 0 14px rgba(139,92,246,0.8)} }

            /* Heading */
            .hero-h1 {
                font-size: clamp(2rem, 4vw, 3.2rem);
                font-weight: 800; line-height: 1.15;
                letter-spacing: -0.02em;
                color: #1e1b4b;
                margin: 0 0 12px;
            }
            body.dark .hero-h1 { color: #f5f3ff; }
            .h1-accent {
                background: linear-gradient(105deg, var(--v700) 0%, var(--v500) 55%, var(--v300) 100%);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }

            .hero-lead {
                font-size: 0.95rem; line-height: 1.7;
                color: #4c1d95; margin-bottom: 24px;
            }
            body.dark .hero-lead { color: #c4b5fd; }

            /* Feature cards */
            .feature-grid {
                display: grid; grid-template-columns: 1fr 1fr;
                gap: 12px; margin-bottom: 28px;
            }
            .feature-card {
                background: rgba(245,243,255,0.75);
                border: 1px solid rgba(139,92,246,0.14);
                border-radius: 14px; padding: 16px;
                transition: all 0.22s;
            }
            body.dark .feature-card {
                background: rgba(109,40,217,0.1);
                border-color: rgba(139,92,246,0.22);
            }
            .feature-card:hover {
                background: rgba(237,233,254,0.95);
                border-color: rgba(139,92,246,0.32);
                transform: translateY(-3px);
                box-shadow: 0 8px 24px rgba(109,40,217,0.14);
            }
            body.dark .feature-card:hover {
                background: rgba(109,40,217,0.2);
                border-color: rgba(139,92,246,0.4);
            }
            .feature-head { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
            .feature-icon {
                width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
                display: flex; align-items: center; justify-content: center;
                background: linear-gradient(135deg, var(--v100), var(--v200));
                color: var(--v700); font-size: 0.95rem;
                box-shadow: 0 2px 10px rgba(109,40,217,0.15);
                transition: all 0.22s;
            }
            body.dark .feature-icon { background: rgba(139,92,246,0.2); color: var(--v400); }
            .feature-card:hover .feature-icon {
                background: linear-gradient(135deg, var(--v700), var(--v400));
                color: #fff;
                box-shadow: 0 4px 16px rgba(109,40,217,0.38);
            }
            .feature-title { font-size: 0.82rem; font-weight: 700; color: #1e1b4b; }
            body.dark .feature-title { color: #ede9fe; }
            .feature-desc { font-size: 0.75rem; color: var(--v700); opacity: 0.82; line-height: 1.5; }
            body.dark .feature-desc { color: #a78bfa; }

            /* CTA */
            .cta-row { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
            .cta-primary {
                display: inline-flex; align-items: center; gap: 8px;
                padding: 11px 24px; border-radius: 12px;
                font-size: 0.88rem; font-weight: 700; text-decoration: none;
                color: #fff !important;
                background: linear-gradient(135deg, var(--v700), var(--v500));
                border: 1px solid rgba(255,255,255,0.15);
                box-shadow: 0 4px 20px rgba(109,40,217,0.35);
                transition: all 0.22s;
            }
            .cta-primary:hover {
                background: linear-gradient(135deg, var(--v800), var(--v600));
                transform: translateY(-2px);
                box-shadow: 0 8px 28px rgba(109,40,217,0.48);
            }

            /* Stats bar */
            .stats-bar {
                display: flex;
                background: rgba(255,255,255,0.65);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(139,92,246,0.13);
                border-radius: 14px; overflow: hidden;
                box-shadow: 0 4px 20px rgba(109,40,217,0.07);
            }
            body.dark .stats-bar { background: rgba(23,12,48,0.65); border-color: rgba(139,92,246,0.22); }
            .s-item { flex: 1; padding: 14px 8px; text-align: center; border-right: 1px solid rgba(139,92,246,0.1); transition: background 0.2s; }
            body.dark .s-item { border-right-color: rgba(139,92,246,0.18); }
            .s-item:last-child { border-right: none; }
            .s-item:hover { background: rgba(139,92,246,0.06); }
            .s-num { font-size: 1rem; font-weight: 800; background: linear-gradient(105deg, var(--v700), var(--v400)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
            .s-lbl { font-size: 0.6rem; font-weight: 600; color: #a78bfa; letter-spacing: 0.05em; text-transform: uppercase; margin-top: 2px; }
            body.dark .s-lbl { color: var(--v700); }

            /* ── Right visual col ── */
            .visual-col { position: relative; }

            .visual-card {
                position: relative;
                background: rgba(255,255,255,0.6);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(139,92,246,0.2);
                border-radius: 24px;
                padding: 32px;
                box-shadow: 0 20px 60px rgba(109,40,217,0.15);
                overflow: hidden;
            }
            body.dark .visual-card {
                background: rgba(23,12,48,0.7);
                border-color: rgba(139,92,246,0.3);
                box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 40px rgba(109,40,217,0.15);
            }

            .visual-glow {
                position: absolute; inset: -20px; border-radius: 32px; z-index: 0;
                background: radial-gradient(ellipse at center, rgba(139,92,246,0.18), transparent 70%);
                filter: blur(24px);
                animation: vglow 4s ease-in-out infinite alternate;
                pointer-events: none;
            }
            @keyframes vglow { from{opacity:0.5;transform:scale(0.97)} to{opacity:1;transform:scale(1.03)} }

            .visual-img-wrap {
                position: relative; z-index: 1;
                display: flex; align-items: center; justify-content: center;
            }
            .visual-img {
                width: 100%; max-width: 320px;
                border-radius: 16px;
                border: 2px solid rgba(139,92,246,0.22);
                box-shadow: 0 12px 40px rgba(109,40,217,0.2);
                transition: all 0.35s;
                display: block; margin: 0 auto;
            }
            body.dark .visual-img {
                border-color: rgba(139,92,246,0.38);
                box-shadow: 0 12px 40px rgba(0,0,0,0.5), 0 0 30px rgba(109,40,217,0.2);
            }
            .visual-img:hover {
                transform: translateY(-6px) scale(1.015);
                box-shadow: 0 24px 60px rgba(109,40,217,0.3);
            }

            /* Floating chips */
            .stat-chip {
                position: absolute; display: flex; align-items: center; gap: 8px;
                padding: 8px 13px; border-radius: 12px; z-index: 3;
                backdrop-filter: blur(16px);
                background: rgba(255,255,255,0.95);
                border: 1px solid rgba(139,92,246,0.2);
                box-shadow: 0 4px 20px rgba(109,40,217,0.15);
                font-size: 0.78rem; font-weight: 700; color: #1e1b4b;
                pointer-events: none;
            }
            body.dark .stat-chip { background: rgba(23,12,48,0.94); border-color: rgba(139,92,246,0.35); color: #ede9fe; }
            .sc-1 { top: -14px; left: -14px; animation: chipfloat 3s ease-in-out infinite alternate; }
            .sc-2 { bottom: -14px; right: -14px; animation: chipfloat 3s ease-in-out 1.5s infinite alternate; }
            @keyframes chipfloat { from{transform:translateY(0)} to{transform:translateY(-8px)} }
            .chip-icon {
                width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
                background: linear-gradient(135deg, var(--v700), var(--v400));
                display: flex; align-items: center; justify-content: center;
                color: #fff; font-size: 0.72rem;
                box-shadow: 0 2px 8px rgba(109,40,217,0.35);
            }
            .chip-lbl { font-size: 0.62rem; opacity: 0.65; display: block; line-height: 1; }
            .chip-val { font-size: 0.92rem; color: var(--v700); line-height: 1.3; display: block; }
            body.dark .chip-val { color: var(--v400); }

            /* Info row inside visual card */
            .visual-info {
                display: grid; grid-template-columns: 1fr 1fr;
                gap: 10px; margin-top: 20px; position: relative; z-index: 1;
            }
            .v-info-item {
                background: rgba(245,243,255,0.7);
                border: 1px solid rgba(139,92,246,0.12);
                border-radius: 12px; padding: 12px;
                text-align: center;
            }
            body.dark .v-info-item {
                background: rgba(109,40,217,0.1);
                border-color: rgba(139,92,246,0.2);
            }
            .v-info-num { font-size: 1.2rem; font-weight: 800; background: linear-gradient(105deg, var(--v700), var(--v400)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
            .v-info-lbl { font-size: 0.65rem; color: #a78bfa; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase; margin-top: 2px; }
            body.dark .v-info-lbl { color: var(--v600); }

            /* ── Footer ── */
            footer {
                position: relative; z-index: 1;
                background: rgba(255,255,255,0.78);
                backdrop-filter: blur(20px);
                border-top: 1px solid rgba(139,92,246,0.13);
            }
            body.dark footer { background: rgba(15,10,30,0.88); border-top-color: rgba(139,92,246,0.22); }
            footer p { color: var(--v700); font-size: 0.8rem; }
            body.dark footer p { color: #a78bfa; }
            .footer-accent { color: var(--v500); font-weight: 700; }
            body.dark .footer-accent { color: var(--v400); }

            /* ── Animations ── */
            .fade-up { opacity: 0; transform: translateY(20px); animation: fadeup 0.65s ease forwards; }
            .d1{animation-delay:0.05s}.d2{animation-delay:0.18s}.d3{animation-delay:0.3s}.d4{animation-delay:0.42s}.d5{animation-delay:0.54s}
            .fade-right { opacity: 0; transform: translateX(24px); animation: faderight 0.75s ease 0.2s forwards; }
            @keyframes fadeup { to { opacity:1; transform:translateY(0) } }
            @keyframes faderight { to { opacity:1; transform:translateX(0) } }
        </style>
    </head>
    <body class="antialiased">

        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>

        <div class="page-wrap">

            {{-- ── Navigation ── --}}
            @if (Route::has('login'))
            <nav class="top-nav">
                <a href="/" class="nav-logo">
                    <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" />
                    <span class="nav-app-name">
                        {{ config('app.name', 'BukSU') }} <span class="accent">System</span>
                    </span>
                </a>

                <div>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn-nav">
                                <i class="fas fa-shield-halved"></i> Admin Dashboard
                            </a>
                        @elseif(Auth::user()->role === 'voter')
                            <a href="{{ route('voter.dashboard') }}" class="btn-nav">
                                <i class="fas fa-vote-yea"></i> Voter Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-nav">
                            <i class="fas fa-right-to-bracket"></i> Login
                        </a>
                    @endauth
                </div>
            </nav>
            @endif

            {{-- ── Hero ── --}}
            <section class="hero-section">
                <div class="hero-inner">

                    {{-- Left: Content --}}
                    <div class="fade-up d1">
                        <div class="hero-card">

                            <div class="eyebrow">
                                <div class="eyebrow-dot"></div>
                                Trusted Online Voting Platform
                            </div>

                            <h1 class="hero-h1 fade-up d2">
                                Your Vote <span class="h1-accent">Matters</span>
                            </h1>

                            <p class="hero-lead fade-up d3">
                                Welcome to our Online Voting System — ensuring fair, transparent, and secure elections for everyone.
                            </p>

                            <div class="feature-grid fade-up d3">
                                <div class="feature-card">
                                    <div class="feature-head">
                                        <div class="feature-icon"><i class="fas fa-vote-yea"></i></div>
                                        <span class="feature-title">For Voters</span>
                                    </div>
                                    <p class="feature-desc">Cast your vote easily and securely. Your identity stays private throughout.</p>
                                </div>
                                <div class="feature-card">
                                    <div class="feature-head">
                                        <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                                        <span class="feature-title">For Admins</span>
                                    </div>
                                    <p class="feature-desc">Manage elections, candidates, and results from a powerful admin panel.</p>
                                </div>
                                <div class="feature-card">
                                    <div class="feature-head">
                                        <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                                        <span class="feature-title">Secure Voting</span>
                                    </div>
                                    <p class="feature-desc">Advanced verification keeps your ballot confidential and tamper-proof.</p>
                                </div>
                                <div class="feature-card">
                                    <div class="feature-head">
                                        <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                                        <span class="feature-title">Live Results</span>
                                    </div>
                                    <p class="feature-desc">Real-time results displayed transparently for all stakeholders.</p>
                                </div>
                            </div>

                            <div class="cta-row fade-up d4">
                                @guest
                                    <a href="{{ route('login') }}" class="cta-primary">
                                        <i class="fas fa-right-to-bracket"></i> Login to Vote
                                    </a>
                                @else
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}" class="cta-primary">
                                            <i class="fas fa-shield-halved"></i> Go to Admin Dashboard
                                        </a>
                                    @elseif(Auth::user()->role === 'voter')
                                        <a href="{{ route('voter.dashboard') }}" class="cta-primary">
                                            <i class="fas fa-vote-yea"></i> Go to Voter Dashboard
                                        </a>
                                    @endif
                                @endguest
                            </div>

                            <div class="stats-bar fade-up d5">
                                <div class="s-item"><div class="s-num">99.9%</div><div class="s-lbl">Uptime</div></div>
                                <div class="s-item"><div class="s-num">256-bit</div><div class="s-lbl">Encrypted</div></div>
                                <div class="s-item"><div class="s-num">Live</div><div class="s-lbl">Results</div></div>
                                <div class="s-item"><div class="s-num">Anon</div><div class="s-lbl">Ballots</div></div>
                            </div>

                        </div>
                    </div>

                    {{-- Right: Visual --}}
                    <div class="visual-col fade-right">
                        <div class="stat-chip sc-1">
                            <div class="chip-icon"><i class="fas fa-check"></i></div>
                            <div><span class="chip-lbl">Votes Cast</span><span class="chip-val">1,284</span></div>
                        </div>
                        <div class="stat-chip sc-2">
                            <div class="chip-icon"><i class="fas fa-bolt"></i></div>
                            <div><span class="chip-lbl">Live Now</span><span class="chip-val">2 Elections</span></div>
                        </div>

                        <div class="visual-card">
                            <div class="visual-glow"></div>

                            <div class="visual-img-wrap">
                                <img src="{{ asset('assets/app_logo.png') }}" alt="Voting System" class="visual-img">
                            </div>

                            <div class="visual-info">
                                <div class="v-info-item">
                                    <div class="v-info-num">100%</div>
                                    <div class="v-info-lbl">Transparent</div>
                                </div>
                                <div class="v-info-item">
                                    <div class="v-info-num">Secure</div>
                                    <div class="v-info-lbl">End-to-End</div>
                                </div>
                                <div class="v-info-item">
                                    <div class="v-info-num">Real‑time</div>
                                    <div class="v-info-lbl">Vote Tally</div>
                                </div>
                                <div class="v-info-item">
                                    <div class="v-info-num">Anonymous</div>
                                    <div class="v-info-lbl">Ballots</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- ── Footer ── --}}
            <footer>
                <div class="max-w-screen-xl mx-auto py-5 px-8 text-center">
                    <p>
                        © {{ date('Y') }} <span class="footer-accent">{{ config('app.name', 'Voting System') }}.</span>
                        All rights reserved.
                    </p>
                </div>
            </footer>

        </div>
    </body>
</html>