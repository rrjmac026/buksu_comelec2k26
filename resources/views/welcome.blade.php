<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Voting System') }}</title>
        <link rel="icon" href="{{ asset('images/tab_icon.png') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --gold:      #f9b40f;
                --gold-lt:   #fcd558;
                --gold-dk:   #c98a00;
                --gold-pale: #fef3c7;
                --violet:    #380041;
                --violet-md: #520060;
                --violet-lt: #6b0080;
                --violet-xl: #1e0025;
                --cream:     #fffbf0;
                --ink:       #1a0020;
            }

            *, *::before, *::after { box-sizing: border-box; }

            html, body {
                height: 100%; margin: 0; padding: 0;
                font-family: 'DM Sans', sans-serif;
            }

            /* ── Light Mode Overrides ── */
            html:not(.dark) body {
                background: #f5f0ff;
                background-image:
                    radial-gradient(ellipse 90% 70% at 0% 0%, rgba(200,160,220,0.4) 0%, transparent 55%),
                    radial-gradient(ellipse 70% 60% at 100% 100%, rgba(180,130,210,0.3) 0%, transparent 55%);
                color: var(--ink);
            }

            html:not(.dark) nav.top-nav {
                background: rgba(255, 250, 245, 0.92);
                border-bottom-color: rgba(180, 100, 0, 0.2);
            }

            html:not(.dark) .grid-lines {
                background-image:
                    linear-gradient(rgba(100,0,120,0.06) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(100,0,120,0.06) 1px, transparent 1px);
            }

            html:not(.dark) .hero-card {
                background: rgba(255, 250, 245, 0.92);
                border-color: rgba(180, 100, 0, 0.2);
                box-shadow: 0 24px 80px rgba(100, 0, 120, 0.12);
            }

            html:not(.dark) .hero-h1 { color: var(--violet); }
            html:not(.dark) .hero-lead { color: rgba(30, 0, 40, 0.65); }

            html:not(.dark) .feature-card {
                background: rgba(255, 245, 255, 0.8);
                border-color: rgba(180, 100, 0, 0.15);
            }
            html:not(.dark) .feature-title { color: var(--violet); }
            html:not(.dark) .feature-desc { color: rgba(30, 0, 40, 0.6); }

            html:not(.dark) .stats-bar {
                background: rgba(255, 245, 255, 0.7);
                border-color: rgba(180, 100, 0, 0.15);
            }

            html:not(.dark) .login-form-side {
                background: rgba(255, 250, 245, 0.97);
                border-left-color: rgba(180, 100, 0, 0.15);
            }

            html:not(.dark) footer {
                background: rgba(245, 235, 255, 0.95);
                border-top-color: rgba(180, 100, 0, 0.15);
            }
            html:not(.dark) footer p { color: rgba(30, 0, 40, 0.45); }

            body {
                background: var(--violet-xl);
                background-image:
                    radial-gradient(ellipse 90% 70% at 5% -5%, rgba(56,0,65,0.9) 0%, transparent 55%),
                    radial-gradient(ellipse 70% 60% at 95% 95%, rgba(82,0,96,0.7) 0%, transparent 55%),
                    radial-gradient(ellipse 50% 40% at 50% 50%, rgba(249,180,15,0.04) 0%, transparent 70%);
                color: var(--cream);
                overflow-x: hidden;
            }

            body::before {
                content: '';
                position: fixed; inset: 0; z-index: 0; pointer-events: none;
                opacity: 0.03;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
                background-size: 200px 200px;
            }

            /* ── Floating orbs ── */
            .orb {
                position: fixed; border-radius: 50%; pointer-events: none; z-index: 0;
                filter: blur(80px); opacity: 0.55;
            }
            .orb-1 {
                width: 600px; height: 600px; top: -200px; left: -150px;
                background: radial-gradient(circle, rgba(56,0,65,0.8), rgba(82,0,96,0.4), transparent 70%);
                animation: orb1 18s ease-in-out infinite alternate;
            }
            .orb-2 {
                width: 500px; height: 500px; bottom: -150px; right: -100px;
                background: radial-gradient(circle, rgba(249,180,15,0.15), rgba(82,0,96,0.3), transparent 70%);
                animation: orb2 22s ease-in-out infinite alternate;
            }
            .orb-3 {
                width: 300px; height: 300px; top: 40%; left: 55%;
                background: radial-gradient(circle, rgba(249,180,15,0.1), transparent 70%);
                animation: orb1 14s ease-in-out 3s infinite alternate;
            }
            @keyframes orb1 { from{transform:translate(0,0) scale(1)} to{transform:translate(50px,40px) scale(1.05)} }
            @keyframes orb2 { from{transform:translate(0,0) scale(1)} to{transform:translate(-40px,-50px) scale(1.08)} }

            .grid-lines {
                position: fixed; inset: 0; z-index: 0; pointer-events: none;
                background-image:
                    linear-gradient(rgba(249,180,15,0.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(249,180,15,0.04) 1px, transparent 1px);
                background-size: 60px 60px;
            }

            /* ── Nav ── */
            nav.top-nav {
                position: fixed; top: 0; left: 0; right: 0; z-index: 50;
                height: 70px;
                display: flex; align-items: center;
                padding: 0 40px;
                background: rgba(26,0,32,0.85);
                backdrop-filter: blur(24px) saturate(1.6);
                border-bottom: 1px solid rgba(249,180,15,0.2);
            }
            nav.top-nav::after {
                content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
                background: linear-gradient(90deg, transparent, var(--gold), rgba(249,180,15,0.4), transparent);
            }

            .nav-logo { display: flex; align-items: center; gap: 13px; text-decoration: none; flex: 1; }
            .nav-logo img {
                height: 42px; width: 42px; object-fit: cover;
                border-radius: 10px;
                border: 1.5px solid rgba(249,180,15,0.4);
                box-shadow: 0 0 16px rgba(249,180,15,0.2);
            }
            .nav-app-name {
                font-family: 'Playfair Display', serif;
                font-size: 1.15rem; font-weight: 700; letter-spacing: 0.01em;
                color: var(--cream);
            }
            .nav-app-name .accent { color: var(--gold); }

            .btn-nav {
                display: inline-flex; align-items: center; gap: 8px;
                padding: 9px 22px; border-radius: 8px;
                font-size: 0.82rem; font-weight: 600; text-decoration: none; letter-spacing: 0.03em;
                color: var(--violet) !important;
                background: linear-gradient(135deg, var(--gold), var(--gold-lt));
                border: 1px solid rgba(249,180,15,0.5);
                box-shadow: 0 3px 20px rgba(249,180,15,0.25), inset 0 1px 0 rgba(255,255,255,0.2);
                transition: all 0.22s;
                font-family: 'DM Sans', sans-serif;
            }
            .btn-nav:hover {
                background: linear-gradient(135deg, var(--gold-lt), var(--gold));
                transform: translateY(-2px);
                box-shadow: 0 8px 28px rgba(249,180,15,0.4);
            }

            /* ── Page layout ── */
            .page-wrap { min-height: 100vh; display: flex; flex-direction: column; position: relative; z-index: 1; }

            .hero-section {
                flex: 1; display: flex; align-items: center;
                padding-top: 70px;
            }

            .hero-inner {
                width: 100%; max-width: 1220px; margin: 0 auto;
                padding: 56px 40px;
                display: grid; grid-template-columns: 1.05fr 0.95fr;
                gap: 52px; align-items: center;
            }

            @media (max-width: 1024px) {
                .hero-inner { grid-template-columns: 1fr; padding: 40px 24px; gap: 32px; }
                .visual-col { display: none; }
            }

            .gold-rule {
                width: 56px; height: 3px; border-radius: 2px;
                background: linear-gradient(90deg, var(--gold), var(--gold-lt));
                margin-bottom: 20px;
            }

            /* ── Left card ── */
            .hero-card {
                background: rgba(30,0,37,0.7);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(249,180,15,0.18);
                border-radius: 20px;
                padding: 44px;
                box-shadow:
                    0 0 0 1px rgba(249,180,15,0.06) inset,
                    0 24px 80px rgba(0,0,0,0.5),
                    0 0 60px rgba(249,180,15,0.04);
                position: relative; overflow: hidden;
            }
            .hero-card::before {
                content: '';
                position: absolute; top: 0; left: 0; right: 0; height: 1px;
                background: linear-gradient(90deg, transparent, rgba(249,180,15,0.5), transparent);
            }

            .eyebrow {
                display: inline-flex; align-items: center; gap: 8px;
                padding: 5px 14px; border-radius: 4px; margin-bottom: 18px;
                background: rgba(249,180,15,0.1);
                border: 1px solid rgba(249,180,15,0.3);
                font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
                color: var(--gold);
            }
            .eyebrow-dot {
                width: 6px; height: 6px; border-radius: 50%;
                background: var(--gold);
                box-shadow: 0 0 8px rgba(249,180,15,0.8);
                animation: epulse 2s ease-in-out infinite;
                flex-shrink: 0;
            }
            @keyframes epulse { 0%,100%{box-shadow:0 0 6px rgba(249,180,15,0.5)} 50%{box-shadow:0 0 16px rgba(249,180,15,1)} }

            .hero-h1 {
                font-family: 'Playfair Display', serif;
                font-size: clamp(2.2rem, 4.5vw, 3.5rem);
                font-weight: 900; line-height: 1.1;
                letter-spacing: -0.01em;
                color: var(--cream);
                margin: 0 0 14px;
            }
            .h1-accent {
                background: linear-gradient(105deg, var(--gold) 0%, var(--gold-lt) 60%, #fff3c4 100%);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }

            .hero-lead {
                font-size: 0.95rem; line-height: 1.75;
                color: rgba(255,251,240,0.7); margin-bottom: 28px;
                font-weight: 300;
            }

            .feature-grid {
                display: grid; grid-template-columns: 1fr 1fr;
                gap: 12px; margin-bottom: 30px;
            }
            .feature-card {
                background: rgba(56,0,65,0.5);
                border: 1px solid rgba(249,180,15,0.12);
                border-radius: 12px; padding: 16px;
                transition: all 0.25s;
                position: relative; overflow: hidden;
            }
            .feature-card::after {
                content: '';
                position: absolute; top: 0; left: 0; right: 0; height: 1px;
                background: linear-gradient(90deg, transparent, rgba(249,180,15,0.3), transparent);
                opacity: 0; transition: opacity 0.25s;
            }
            .feature-card:hover { border-color: rgba(249,180,15,0.3); transform: translateY(-3px); background: rgba(82,0,96,0.5); }
            .feature-card:hover::after { opacity: 1; }
            .feature-head { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
            .feature-icon {
                width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
                display: flex; align-items: center; justify-content: center;
                background: rgba(249,180,15,0.12);
                color: var(--gold); font-size: 0.9rem;
                border: 1px solid rgba(249,180,15,0.2);
                transition: all 0.25s;
            }
            .feature-card:hover .feature-icon {
                background: var(--gold);
                color: var(--violet);
                border-color: var(--gold);
                box-shadow: 0 4px 16px rgba(249,180,15,0.35);
            }
            .feature-title { font-size: 0.82rem; font-weight: 700; color: var(--cream); }
            .feature-desc { font-size: 0.74rem; color: rgba(255,251,240,0.55); line-height: 1.55; }

            .cta-row { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 28px; }
            .cta-primary {
                display: inline-flex; align-items: center; gap: 9px;
                padding: 13px 28px; border-radius: 8px;
                font-size: 0.88rem; font-weight: 700; text-decoration: none; letter-spacing: 0.03em;
                color: var(--violet) !important;
                background: linear-gradient(135deg, var(--gold), var(--gold-lt));
                box-shadow: 0 4px 24px rgba(249,180,15,0.35), inset 0 1px 0 rgba(255,255,255,0.2);
                transition: all 0.22s;
                font-family: 'DM Sans', sans-serif;
            }
            .cta-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 32px rgba(249,180,15,0.5);
            }

            /* ── Stats bar ── */
            .stats-bar {
                display: flex;
                background: rgba(56,0,65,0.6);
                border: 1px solid rgba(249,180,15,0.15);
                border-radius: 12px; overflow: hidden;
            }
            .s-item {
                flex: 1; padding: 14px 8px; text-align: center;
                border-right: 1px solid rgba(249,180,15,0.1);
                transition: background 0.2s;
            }
            .s-item:last-child { border-right: none; }
            .s-item:hover { background: rgba(249,180,15,0.07); }
            .s-num {
                font-family: 'Playfair Display', serif;
                font-size: 1rem; font-weight: 800;
                background: linear-gradient(105deg, var(--gold), var(--gold-lt));
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }
            .s-lbl { font-size: 0.58rem; font-weight: 600; color: rgba(249,180,15,0.55); letter-spacing: 0.08em; text-transform: uppercase; margin-top: 2px; }

            /* ── Right visual col ── */
            .visual-col { position: relative; }

            .visual-card {
                position: relative;
                background: rgba(30,0,37,0.75);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(249,180,15,0.2);
                border-radius: 20px;
                padding: 36px;
                box-shadow: 0 24px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(249,180,15,0.06) inset;
                overflow: hidden;
            }
            .visual-card::before {
                content: '';
                position: absolute; top: 0; left: 0; right: 0; height: 1px;
                background: linear-gradient(90deg, transparent, rgba(249,180,15,0.6), transparent);
            }

            .visual-glow {
                position: absolute; inset: -20px; border-radius: 32px; z-index: 0;
                background: radial-gradient(ellipse at center, rgba(249,180,15,0.07), transparent 70%);
                filter: blur(24px);
                animation: vglow 5s ease-in-out infinite alternate;
                pointer-events: none;
            }
            @keyframes vglow { from{opacity:0.4;transform:scale(0.97)} to{opacity:1;transform:scale(1.03)} }

            .visual-img-wrap {
                position: relative; z-index: 1;
                display: flex; align-items: center; justify-content: center;
            }
            .visual-img {
                width: 100%; max-width: 300px;
                border-radius: 14px;
                border: 2px solid rgba(249,180,15,0.25);
                box-shadow: 0 12px 40px rgba(0,0,0,0.5), 0 0 30px rgba(249,180,15,0.1);
                transition: all 0.35s;
                display: block; margin: 0 auto;
            }
            .visual-img:hover { transform: translateY(-6px) scale(1.015); box-shadow: 0 24px 60px rgba(0,0,0,0.6), 0 0 40px rgba(249,180,15,0.2); }

            /* ── Floating chips — these are now LIVE ── */
            .stat-chip {
                position: absolute; display: flex; align-items: center; gap: 9px;
                padding: 9px 14px; border-radius: 10px; z-index: 3;
                backdrop-filter: blur(16px);
                background: rgba(26,0,32,0.95);
                border: 1px solid rgba(249,180,15,0.3);
                box-shadow: 0 4px 20px rgba(0,0,0,0.4), 0 0 12px rgba(249,180,15,0.1);
                font-size: 0.78rem; font-weight: 700; color: var(--cream);
                pointer-events: none;
                transition: all 0.4s ease;
            }
            .sc-1 { top: -14px; left: -14px; animation: chipfloat 3.5s ease-in-out infinite alternate; }
            .sc-2 { bottom: -14px; right: -14px; animation: chipfloat 3.5s ease-in-out 1.5s infinite alternate; }
            @keyframes chipfloat { from{transform:translateY(0)} to{transform:translateY(-10px)} }
            .chip-icon {
                width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0;
                background: linear-gradient(135deg, var(--gold), var(--gold-lt));
                display: flex; align-items: center; justify-content: center;
                color: var(--violet); font-size: 0.75rem;
                box-shadow: 0 2px 10px rgba(249,180,15,0.4);
            }
            /* Live Now chip — color changes with election status */
            .chip-icon.status-ongoing  { background: linear-gradient(135deg, #34d399, #6ee7b7); color: #064e3b; }
            .chip-icon.status-ended    { background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.6); }
            .chip-icon.status-upcoming { background: linear-gradient(135deg, var(--gold), var(--gold-lt)); color: var(--violet); }

            .chip-lbl { font-size: 0.6rem; color: rgba(255,251,240,0.55); display: block; line-height: 1; margin-bottom: 2px; }
            .chip-val { font-size: 0.9rem; color: var(--gold); line-height: 1.2; display: block; font-family: 'Playfair Display', serif; }
            .chip-val.status-ongoing { color: #34d399; }
            .chip-val.status-ended   { color: rgba(255,255,255,0.45); }

            /* Pulsing live dot */
            .live-dot {
                display: inline-block;
                width: 7px; height: 7px; border-radius: 50%;
                background: #34d399;
                margin-right: 4px;
                animation: livepulse 1.2s ease-in-out infinite;
                vertical-align: middle;
            }
            @keyframes livepulse {
                0%,100% { box-shadow: 0 0 4px rgba(52,211,153,0.4); }
                50%      { box-shadow: 0 0 12px rgba(52,211,153,1); }
            }

            .visual-info {
                display: grid; grid-template-columns: 1fr 1fr;
                gap: 10px; margin-top: 22px; position: relative; z-index: 1;
            }
            .v-info-item {
                background: rgba(56,0,65,0.6);
                border: 1px solid rgba(249,180,15,0.12);
                border-radius: 10px; padding: 13px; text-align: center;
                transition: all 0.22s;
            }
            .v-info-item:hover { border-color: rgba(249,180,15,0.3); background: rgba(82,0,96,0.5); }
            .v-info-num {
                font-family: 'Playfair Display', serif;
                font-size: 1.1rem; font-weight: 800;
                background: linear-gradient(105deg, var(--gold), var(--gold-lt));
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }
            .v-info-lbl { font-size: 0.6rem; color: rgba(249,180,15,0.55); font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; margin-top: 3px; }

            /* ── Footer ── */
            footer {
                position: relative; z-index: 1;
                background: rgba(26,0,32,0.9);
                backdrop-filter: blur(20px);
                border-top: 1px solid rgba(249,180,15,0.15);
            }
            footer p { color: rgba(255,251,240,0.45); font-size: 0.8rem; margin: 0; }
            .footer-accent { color: var(--gold); font-weight: 700; }

            .fade-up { opacity: 0; transform: translateY(22px); animation: fadeup 0.7s ease forwards; }
            .d1{animation-delay:0.05s}.d2{animation-delay:0.2s}.d3{animation-delay:0.35s}.d4{animation-delay:0.5s}.d5{animation-delay:0.65s}
            .fade-right { opacity: 0; transform: translateX(28px); animation: faderight 0.75s ease 0.25s forwards; }
            @keyframes fadeup { to { opacity:1; transform:translateY(0) } }
            @keyframes faderight { to { opacity:1; transform:translateX(0) } }

            /* Number counter animation */
            @keyframes countUp { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
            .count-updated { animation: countUp 0.35s ease; }
        </style>
    </head>
    <body class="antialiased" x-data>

        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="grid-lines"></div>

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

                    {{-- Left --}}
                    <div class="fade-up d1">
                        <div class="hero-card">

                            <div class="eyebrow">
                                <div class="eyebrow-dot"></div>
                                Trusted Online Voting Platform
                            </div>

                            <div class="gold-rule"></div>

                            <h1 class="hero-h1 fade-up d2">
                                Your Vote <span class="h1-accent">Matters</span>
                            </h1>

                            <p class="hero-lead fade-up d3">
                                Welcome to our Online Voting System — ensuring fair, transparent, and secure elections for every student voice.
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

                            {{-- ── Stats bar — live data ── --}}
                            <div class="stats-bar fade-up d5">
                                <div class="s-item">
                                    <div class="s-num" id="stat-uptime">99.9%</div>
                                    <div class="s-lbl">Uptime</div>
                                </div>
                                <div class="s-item">
                                    <div class="s-num">256-bit</div>
                                    <div class="s-lbl">Encrypted</div>
                                </div>
                                <div class="s-item">
                                    {{-- Live votes cast counter --}}
                                    <div class="s-num" id="stat-votes-cast">—</div>
                                    <div class="s-lbl">Votes Cast</div>
                                </div>
                                <div class="s-item">
                                    <div class="s-num">Anon</div>
                                    <div class="s-lbl">Ballots</div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Right: Visual --}}
                    <div class="visual-col fade-right">

                        {{-- Chip 1 — Votes Cast (LIVE) --}}
                        <div class="stat-chip sc-1">
                            <div class="chip-icon" id="chip-votes-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <span class="chip-lbl">Votes Cast</span>
                                <span class="chip-val" id="chip-votes-val">—</span>
                            </div>
                        </div>

                        {{-- Chip 2 — Election Status (LIVE) --}}
                        <div class="stat-chip sc-2" id="chip-status-wrap">
                            <div class="chip-icon status-upcoming" id="chip-status-icon">
                                <i class="fas fa-bolt" id="chip-status-fa"></i>
                            </div>
                            <div>
                                <span class="chip-lbl" id="chip-status-lbl">Live Now</span>
                                <span class="chip-val status-upcoming" id="chip-status-val">Loading…</span>
                            </div>
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
                                    <div class="v-info-num" id="visual-votes">—</div>
                                    <div class="v-info-lbl">Votes Cast</div>
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
                <div style="max-width:1220px;margin:0 auto;padding:18px 40px;text-align:center;">
                    <p>
                        © {{ date('Y') }} <span class="footer-accent">{{ config('app.name', 'Voting System') }}.</span>
                        All rights reserved.
                    </p>
                </div>
            </footer>

        </div>

        <script>
        // Apply saved theme immediately to prevent flash
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                init() {
                    const theme = localStorage.getItem('theme');
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.on = theme === 'dark' || (!theme && prefersDark);
                    document.documentElement.classList.toggle('dark', this.on);
                },
                on: false,
                toggle() {
                    this.on = !this.on;
                    localStorage.setItem('theme', this.on ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark', this.on);
                }
            });
        });

        // ── Live Stats Polling ────────────────────────────────────────────────
        (function () {
            const els = {
                statVotes:    document.getElementById('stat-votes-cast'),
                chipVotesVal: document.getElementById('chip-votes-val'),
                chipStatusVal:document.getElementById('chip-status-val'),
                chipStatusLbl:document.getElementById('chip-status-lbl'),
                chipStatusIcon:document.getElementById('chip-status-icon'),
                chipStatusFa: document.getElementById('chip-status-fa'),
                visualVotes:  document.getElementById('visual-votes'),
            };

            // Status → visual config map
            const statusConfig = {
                upcoming: {
                    label:      'Election Soon',
                    chipLbl:    'Coming Up',
                    icon:       'fas fa-hourglass-start',
                    iconClass:  'status-upcoming',
                    valClass:   '',
                    chipBorder: 'rgba(249,180,15,0.3)',
                    dot:        false,
                },
                ongoing: {
                    label:      'Election Live',
                    chipLbl:    'Live Now',
                    icon:       'fas fa-circle-dot',
                    iconClass:  'status-ongoing',
                    valClass:   'status-ongoing',
                    chipBorder: 'rgba(52,211,153,0.4)',
                    dot:        true,
                },
                ended: {
                    label:      'Election Ended',
                    chipLbl:    'Concluded',
                    icon:       'fas fa-flag-checkered',
                    iconClass:  'status-ended',
                    valClass:   'status-ended',
                    chipBorder: 'rgba(255,255,255,0.12)',
                    dot:        false,
                },
            };

            let prevVotes = null;

            function animateUpdate(el, newText) {
                el.classList.remove('count-updated');
                void el.offsetWidth; // force reflow
                el.textContent = newText;
                el.classList.add('count-updated');
            }

            function applyStatus(status) {
                const cfg = statusConfig[status] || statusConfig.upcoming;

                // Status chip value
                if (cfg.dot) {
                    els.chipStatusVal.innerHTML = '<span class="live-dot"></span>' + cfg.label;
                } else {
                    els.chipStatusVal.textContent = cfg.label;
                }

                // Remove all known status classes and apply correct one
                ['status-upcoming','status-ongoing','status-ended'].forEach(c => {
                    els.chipStatusVal.classList.remove(c);
                    els.chipStatusIcon.classList.remove(c);
                });
                if (cfg.valClass) els.chipStatusVal.classList.add(cfg.valClass);
                els.chipStatusIcon.classList.add(cfg.iconClass);

                // Icon
                els.chipStatusFa.className = cfg.icon;

                // Label above value
                els.chipStatusLbl.textContent = cfg.chipLbl;

                // Chip border colour (subtle status tint)
                const wrap = document.getElementById('chip-status-wrap');
                if (wrap) wrap.style.borderColor = cfg.chipBorder;
            }

            function fetchStats() {
                fetch('/public/stats')
                    .then(r => r.json())
                    .then(data => {
                        const votesCast = data.votes_cast ?? 0;
                        const status    = data.status ?? 'upcoming';

                        // Only animate if value changed
                        if (votesCast !== prevVotes) {
                            const display = votesCast.toLocaleString();
                            animateUpdate(els.statVotes,    display);
                            animateUpdate(els.chipVotesVal, display);
                            animateUpdate(els.visualVotes,  display);
                            prevVotes = votesCast;
                        }

                        applyStatus(status);
                    })
                    .catch(() => {
                        // Silently fail — don't break the page
                    });
            }

            // Initial fetch immediately, then every 15 seconds
            fetchStats();
            setInterval(fetchStats, 15000);
        })();
        </script>
    </body>
</html>