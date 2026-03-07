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

            /* ── Body ── */
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
            nav.fixed {
                background: rgba(255,255,255,0.85) !important;
                backdrop-filter: blur(22px) saturate(1.8) !important;
                -webkit-backdrop-filter: blur(22px) saturate(1.8) !important;
                border-bottom: 1px solid rgba(139,92,246,0.15) !important;
                box-shadow: 0 1px 24px rgba(109,40,217,0.08) !important;
            }
            body.dark nav.fixed {
                background: rgba(15,10,30,0.9) !important;
                border-bottom-color: rgba(139,92,246,0.25) !important;
                box-shadow: 0 1px 32px rgba(109,40,217,0.2) !important;
            }
            nav.fixed::after {
                content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
                background: linear-gradient(90deg, var(--v700) 0%, var(--v400) 50%, transparent 100%);
                opacity: 0.4;
            }

            /* Logo image */
            nav .logo-img {
                height: 44px; width: 44px; object-fit: cover;
                border-radius: 12px;
                border: 2px solid rgba(139,92,246,0.3) !important;
                box-shadow: 0 2px 16px rgba(109,40,217,0.22);
                padding: 0 !important;
            }

            /* App name */
            nav .app-name { color: #1e1b4b !important; }
            body.dark nav .app-name { color: #f5f3ff !important; }
            nav .app-name .accent {
                background: linear-gradient(105deg, var(--v700), var(--v400));
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }

            /* Nav buttons */
            nav a.btn-nav {
                background: linear-gradient(135deg, var(--v700), var(--v500)) !important;
                color: #fff !important;
                border: 1px solid rgba(255,255,255,0.15) !important;
                box-shadow: 0 3px 16px rgba(109,40,217,0.3) !important;
                border-radius: 10px !important;
                font-weight: 600 !important;
                transition: all 0.2s !important;
            }
            nav a.btn-nav:hover {
                background: linear-gradient(135deg, var(--v800), var(--v600)) !important;
                transform: translateY(-1px);
                box-shadow: 0 6px 22px rgba(109,40,217,0.42) !important;
            }

            /* ── Hero ── */
            .hero-section { position: relative; z-index: 1; }

            /* Hero card */
            .hero-content-card {
                background: rgba(255,255,255,0.72) !important;
                backdrop-filter: blur(20px);
                border: 1px solid rgba(139,92,246,0.16) !important;
                border-radius: 24px !important;
                box-shadow: 0 4px 6px rgba(109,40,217,0.04), 0 20px 60px rgba(109,40,217,0.1), inset 0 1px 0 rgba(255,255,255,0.9) !important;
            }
            body.dark .hero-content-card {
                background: rgba(23,12,48,0.78) !important;
                border-color: rgba(139,92,246,0.25) !important;
                box-shadow: 0 4px 6px rgba(0,0,0,0.2), 0 20px 60px rgba(0,0,0,0.4), inset 0 1px 0 rgba(139,92,246,0.1) !important;
            }

            /* Eyebrow */
            .hero-eyebrow {
                display: inline-flex; align-items: center; gap: 7px;
                padding: 5px 13px; border-radius: 99px; margin-bottom: 12px;
                background: linear-gradient(135deg, rgba(109,40,217,0.1), rgba(139,92,246,0.08));
                border: 1px solid rgba(139,92,246,0.22);
                font-size: 0.7rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
                color: var(--v700);
            }
            body.dark .hero-eyebrow { color: var(--v400); background: rgba(139,92,246,0.15); border-color: rgba(139,92,246,0.3); }
            .eyebrow-dot {
                width: 7px; height: 7px; border-radius: 50%;
                background: linear-gradient(135deg, var(--v600), var(--v400));
                box-shadow: 0 0 8px rgba(139,92,246,0.6);
                animation: epulse 2s ease-in-out infinite;
            }
            @keyframes epulse { 0%,100%{box-shadow:0 0 6px rgba(139,92,246,0.4)} 50%{box-shadow:0 0 14px rgba(139,92,246,0.8)} }

            /* H1 */
            .hero-h1 { color: #1e1b4b !important; }
            body.dark .hero-h1 { color: #f5f3ff !important; }
            .hero-h1 .h1-accent {
                background: linear-gradient(105deg, var(--v700) 0%, var(--v500) 55%, var(--v300) 100%);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }

            /* Lead */
            .hero-lead { color: #4c1d95 !important; }
            body.dark .hero-lead { color: #c4b5fd !important; }

            /* ── Feature cards ── */
            .feature-card {
                background: rgba(245,243,255,0.75) !important;
                border: 1px solid rgba(139,92,246,0.14) !important;
                border-radius: 14px !important;
                transition: all 0.22s !important;
            }
            body.dark .feature-card {
                background: rgba(109,40,217,0.1) !important;
                border-color: rgba(139,92,246,0.22) !important;
            }
            .feature-card:hover {
                background: rgba(237,233,254,0.95) !important;
                border-color: rgba(139,92,246,0.32) !important;
                transform: translateY(-3px) !important;
                box-shadow: 0 8px 24px rgba(109,40,217,0.14) !important;
            }
            body.dark .feature-card:hover {
                background: rgba(109,40,217,0.2) !important;
                border-color: rgba(139,92,246,0.4) !important;
            }

            .feature-icon {
                width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
                display: flex; align-items: center; justify-content: center;
                background: linear-gradient(135deg, var(--v100), var(--v200)) !important;
                color: var(--v700) !important;
                font-size: 1.1rem !important;
                box-shadow: 0 2px 10px rgba(109,40,217,0.15);
                transition: all 0.22s;
            }
            body.dark .feature-icon { background: rgba(139,92,246,0.2) !important; color: var(--v400) !important; }
            .feature-card:hover .feature-icon {
                background: linear-gradient(135deg, var(--v700), var(--v400)) !important;
                color: #fff !important;
                box-shadow: 0 4px 16px rgba(109,40,217,0.38) !important;
            }

            .feature-title { color: #1e1b4b !important; font-weight: 700 !important; }
            body.dark .feature-title { color: #ede9fe !important; }
            .feature-desc { color: var(--v700) !important; opacity: 0.82; }
            body.dark .feature-desc { color: #a78bfa !important; }

            /* ── CTA buttons ── */
            a.cta-primary {
                background: linear-gradient(135deg, var(--v700), var(--v500)) !important;
                color: #fff !important;
                border: 1px solid rgba(255,255,255,0.15) !important;
                box-shadow: 0 4px 20px rgba(109,40,217,0.35) !important;
                border-radius: 12px !important;
                font-weight: 700 !important;
                transition: all 0.22s !important;
            }
            a.cta-primary:hover {
                background: linear-gradient(135deg, var(--v800), var(--v600)) !important;
                transform: translateY(-2px);
                box-shadow: 0 8px 28px rgba(109,40,217,0.48) !important;
            }

            /* ── Visual side ── */
            .visual-glow {
                position: absolute; inset: -24px; border-radius: 32px; z-index: 0;
                background: radial-gradient(ellipse at center, rgba(139,92,246,0.2), transparent 70%);
                filter: blur(28px);
                animation: vglow 4s ease-in-out infinite alternate;
                pointer-events: none;
            }
            @keyframes vglow { from{opacity:0.55;transform:scale(0.97)} to{opacity:1;transform:scale(1.04)} }

            .visual-img {
                border-radius: 20px !important;
                border: 2px solid rgba(139,92,246,0.22) !important;
                box-shadow: 0 20px 60px rgba(109,40,217,0.2) !important;
                transition: all 0.35s !important;
                position: relative; z-index: 1;
            }
            body.dark .visual-img {
                border-color: rgba(139,92,246,0.38) !important;
                box-shadow: 0 20px 60px rgba(0,0,0,0.55), 0 0 40px rgba(109,40,217,0.22) !important;
            }
            .visual-img:hover {
                transform: translateY(-6px) scale(1.015) !important;
                box-shadow: 0 30px 80px rgba(109,40,217,0.3) !important;
                border-color: rgba(139,92,246,0.45) !important;
            }

            /* Floating chips */
            .stat-chip {
                position: absolute; display: flex; align-items: center; gap: 8px;
                padding: 8px 13px; border-radius: 12px; z-index: 2;
                backdrop-filter: blur(16px);
                background: rgba(255,255,255,0.94);
                border: 1px solid rgba(139,92,246,0.2);
                box-shadow: 0 4px 20px rgba(109,40,217,0.15);
                font-size: 0.78rem; font-weight: 700; color: #1e1b4b;
                pointer-events: none;
            }
            body.dark .stat-chip { background: rgba(23,12,48,0.92); border-color: rgba(139,92,246,0.35); color: #ede9fe; }
            .sc-1 { top: 16px; left: -16px; animation: chipfloat 3s ease-in-out infinite alternate; }
            .sc-2 { bottom: 28px; right: -14px; animation: chipfloat 3s ease-in-out 1.5s infinite alternate; }
            @keyframes chipfloat { from{transform:translateY(0)} to{transform:translateY(-9px)} }
            .chip-icon { width: 26px; height: 26px; border-radius: 7px; background: linear-gradient(135deg, var(--v700), var(--v400)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.68rem; box-shadow: 0 2px 8px rgba(109,40,217,0.35); flex-shrink: 0; }
            .chip-lbl { font-size: 0.64rem; opacity: 0.7; display: block; line-height: 1; color: inherit; }
            .chip-val { font-size: 0.9rem; color: var(--v700); line-height: 1.3; display: block; }
            body.dark .chip-val { color: var(--v400); }

            /* Stats bar */
            .stats-row {
                display: flex; margin-top: 24px;
                background: rgba(255,255,255,0.65);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(139,92,246,0.13);
                border-radius: 16px; overflow: hidden;
                box-shadow: 0 4px 20px rgba(109,40,217,0.07);
            }
            body.dark .stats-row { background: rgba(23,12,48,0.65); border-color: rgba(139,92,246,0.22); }
            .s-item { flex: 1; padding: 14px 10px; text-align: center; border-right: 1px solid rgba(139,92,246,0.1); transition: background 0.2s; }
            body.dark .s-item { border-right-color: rgba(139,92,246,0.18); }
            .s-item:last-child { border-right: none; }
            .s-item:hover { background: rgba(139,92,246,0.06); }
            body.dark .s-item:hover { background: rgba(139,92,246,0.1); }
            .s-num { font-size: 1.1rem; font-weight: 800; background: linear-gradient(105deg, var(--v700), var(--v400)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
            .s-lbl { font-size: 0.62rem; font-weight: 600; color: #a78bfa; letter-spacing: 0.05em; text-transform: uppercase; margin-top: 2px; }
            body.dark .s-lbl { color: var(--v700); }

            /* ── Footer ── */
            footer {
                background: rgba(255,255,255,0.78) !important;
                backdrop-filter: blur(20px) !important;
                border-top: 1px solid rgba(139,92,246,0.13) !important;
            }
            body.dark footer { background: rgba(15,10,30,0.88) !important; border-top-color: rgba(139,92,246,0.22) !important; }
            footer p { color: var(--v700) !important; }
            body.dark footer p { color: #a78bfa !important; }
            .footer-accent { color: var(--v500) !important; font-weight: 700; }
            body.dark .footer-accent { color: var(--v400) !important; }

            /* ── Entrance animations ── */
            .fade-up { opacity: 0; transform: translateY(22px); animation: fadeup 0.7s ease forwards; }
            .d1{animation-delay:0.05s} .d2{animation-delay:0.2s} .d3{animation-delay:0.35s} .d4{animation-delay:0.5s} .d5{animation-delay:0.65s}
            .fade-right { opacity: 0; transform: translateX(28px); animation: faderight 0.8s ease 0.25s forwards; }
            @keyframes fadeup { to { opacity:1; transform:translateY(0) } }
            @keyframes faderight { to { opacity:1; transform:translateX(0) } }
        </style>
    </head>
    <body class="antialiased min-h-screen">

        <!-- Background orbs -->
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>

        <!-- Navigation -->
        @if (Route::has('login'))
            <nav class="fixed w-full z-20 top-0 start-0 border-b backdrop-blur-sm">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

                    <!-- Logo -->
                    <a href="/" class="flex items-center space-x-3">
                        <img src="{{ asset('assets/app_logo.png') }}" class="logo-img" alt="Logo" />
                        <span class="app-name self-center text-2xl font-bold whitespace-nowrap">
                            {{ config('app.name', 'Voting') }} <span class="accent">System</span>
                        </span>
                    </a>

                    <!-- Nav Actions -->
                    <div class="flex md:order-2 space-x-3">
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                   class="btn-nav text-sm px-4 py-2 text-center rounded-lg transition-colors duration-200">
                                    <i class="fas fa-shield-halved mr-2"></i>Admin Dashboard
                                </a>
                            @elseif(Auth::user()->role === 'voter')
                                <a href="{{ route('voter.dashboard') }}"
                                   class="btn-nav text-sm px-4 py-2 text-center rounded-lg transition-colors duration-200">
                                    <i class="fas fa-vote-yea mr-2"></i>Voter Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="btn-nav text-sm px-4 py-2 text-center rounded-lg transition-colors duration-200">
                                <i class="fas fa-right-to-bracket mr-2"></i>Login
                            </a>
                        @endauth
                    </div>

                </div>
            </nav>
        @endif

        <!-- Hero Section -->
        <div class="hero-section relative isolate px-6 pt-20 lg:px-8 min-h-screen flex items-center">
            <div class="mx-auto max-w-6xl py-12 sm:py-20 lg:py-24 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                    <!-- Text Content -->
                    <div class="hero-content-card p-8">

                        <div class="fade-up d1">
                            <div class="hero-eyebrow">
                                <div class="eyebrow-dot"></div>
                                Trusted Online Voting Platform
                            </div>
                        </div>

                        <h1 class="hero-h1 fade-up d2 text-4xl font-bold tracking-tight sm:text-6xl mb-6">
                            Your Vote <span class="h1-accent">Matters</span>
                        </h1>

                        <p class="hero-lead fade-up d3 text-lg leading-8 mb-8">
                            Welcome to our Online Voting System — where we ensure fair, transparent, and secure elections for everyone.
                        </p>

                        <div class="fade-up d3 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                            <!-- Voter Card -->
                            <div class="feature-card p-6">
                                <div class="flex items-center mb-3">
                                    <div class="feature-icon mr-3"><i class="fas fa-vote-yea"></i></div>
                                    <h3 class="feature-title">For Voters</h3>
                                </div>
                                <p class="feature-desc">
                                    Cast your vote easily and securely. Your identity stays private throughout the process.
                                </p>
                            </div>

                            <!-- Admin Card -->
                            <div class="feature-card p-6">
                                <div class="flex items-center mb-3">
                                    <div class="feature-icon mr-3"><i class="fas fa-shield-halved"></i></div>
                                    <h3 class="feature-title">For Admins</h3>
                                </div>
                                <p class="feature-desc">
                                    Manage elections, candidates, and results from a powerful and easy-to-use admin panel.
                                </p>
                            </div>

                            <!-- Secure Voting Card -->
                            <div class="feature-card p-6">
                                <div class="flex items-center mb-3">
                                    <div class="feature-icon mr-3"><i class="fas fa-shield-alt"></i></div>
                                    <h3 class="feature-title">Secure Voting</h3>
                                </div>
                                <p class="feature-desc">
                                    Advanced verification systems ensure your vote remains confidential and tamper-proof.
                                </p>
                            </div>

                            <!-- Transparent Results Card -->
                            <div class="feature-card p-6">
                                <div class="flex items-center mb-3">
                                    <div class="feature-icon mr-3"><i class="fas fa-chart-bar"></i></div>
                                    <h3 class="feature-title">Live Results</h3>
                                </div>
                                <p class="feature-desc">
                                    Real-time election results displayed transparently for all stakeholders to see.
                                </p>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="fade-up d4 mt-8 flex flex-wrap gap-4">
                            @guest
                                <a href="{{ route('login') }}"
                                   class="cta-primary inline-flex items-center gap-2 font-semibold rounded-lg text-sm px-6 py-3 transition-colors duration-200">
                                    <i class="fas fa-right-to-bracket"></i> Login to Vote
                                </a>
                            @else
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="cta-primary inline-flex items-center gap-2 font-semibold rounded-lg text-sm px-6 py-3 transition-colors duration-200">
                                        <i class="fas fa-shield-halved"></i> Go to Admin Dashboard
                                    </a>
                                @elseif(Auth::user()->role === 'voter')
                                    <a href="{{ route('voter.dashboard') }}"
                                       class="cta-primary inline-flex items-center gap-2 font-semibold rounded-lg text-sm px-6 py-3 transition-colors duration-200">
                                        <i class="fas fa-vote-yea"></i> Go to Voter Dashboard
                                    </a>
                                @endif
                            @endguest
                        </div>

                        <!-- Stats bar -->
                        <div class="fade-up d5 stats-row">
                            <div class="s-item"><div class="s-num">99.9%</div><div class="s-lbl">Uptime</div></div>
                            <div class="s-item"><div class="s-num">256-bit</div><div class="s-lbl">Encrypted</div></div>
                            <div class="s-item"><div class="s-num">Live</div><div class="s-lbl">Results</div></div>
                            <div class="s-item"><div class="s-num">Anon</div><div class="s-lbl">Ballots</div></div>
                        </div>
                    </div>

                    <!-- Image / Visual -->
                    <div class="fade-right relative group">
                        <!-- Floating chips -->
                        <div class="stat-chip sc-1">
                            <div class="chip-icon"><i class="fas fa-check"></i></div>
                            <div><span class="chip-lbl">Votes Cast</span><span class="chip-val">1,284</span></div>
                        </div>
                        <div class="stat-chip sc-2">
                            <div class="chip-icon"><i class="fas fa-bolt"></i></div>
                            <div><span class="chip-lbl">Live Now</span><span class="chip-val">2 Elections</span></div>
                        </div>

                        <div class="visual-glow"></div>
                        <img src="{{ asset('assets/app_logo.png') }}" alt="Voting System"
                             class="visual-img relative w-full shadow-lg">
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="border-t backdrop-blur-sm">
            <div class="max-w-screen-xl mx-auto py-6 px-4 text-center">
                <p class="text-sm">
                    © {{ date('Y') }} <span class="footer-accent">{{ config('app.name', 'Voting System') }}.</span> All rights reserved.
                </p>
            </div>
        </footer>

    </body>
</html>