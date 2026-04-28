<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Voting System') }}</title>
        <link rel="icon" href="{{ asset('images/tab_icon.png') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;0,900;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/css/welcome.css', 'resources/js/app.js', 'resources/js/welcome.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
        /* ══ LOGIN MODAL ══════════════════════════════════════════════════════ */
            .lm-overlay {
                position: fixed; inset: 0; z-index: 300;
                background: rgba(8, 0, 16, 0.78);
                backdrop-filter: blur(10px) saturate(1.2);
                display: flex; align-items: center; justify-content: center;
                padding: 16px;
            }
            /* Backdrop fade */
            .lm-ef  { opacity: 0; }
            .lm-et  { opacity: 1; }
            .lm-enter { transition: opacity 0.3s ease; }
            .lm-leave { transition: opacity 0.2s ease; }
            /* Box scale+fade */
            .lm-box-from { opacity: 0; transform: scale(0.96) translateY(14px); }
            .lm-box-to   { opacity: 1; transform: scale(1)    translateY(0); }
            .lm-box-enter { transition: opacity 0.32s cubic-bezier(.22,1,.36,1), transform 0.32s cubic-bezier(.22,1,.36,1); }
            .lm-box-leave { transition: opacity 0.2s ease, transform 0.2s ease; }
            /* Panel fade */
            .lm-panel-from { opacity: 0; transform: translateY(8px); }
            .lm-panel-to   { opacity: 1; transform: translateY(0); }
            .lm-panel-enter { transition: opacity 0.22s ease, transform 0.22s ease; }

            .lm-box {
                position: relative; width: 100%; max-width: 980px;
                display: grid; grid-template-columns: 1fr 1fr;
                border-radius: 22px; overflow: hidden;
                background: #1a0026;
                box-shadow: 0 0 0 1px rgba(249,180,15,0.18), 0 40px 90px rgba(0,0,0,0.75), 0 0 60px rgba(120,0,180,0.2);
                max-height: 92vh; overflow-y: auto;
            }
            @media (max-width: 700px) {
                .lm-box { grid-template-columns: 1fr; max-width: 420px; }
                .lm-left-panel { display: none; }
            }

            /* Close button */
            .lm-close {
                position: absolute; top: 14px; right: 14px; z-index: 20;
                width: 34px; height: 34px; border-radius: 8px;
                background: rgba(249,180,15,0.07);
                border: 1px solid rgba(249,180,15,0.2);
                color: rgba(249,180,15,0.65);
                display: flex; align-items: center; justify-content: center;
                cursor: pointer; font-size: 0.9rem;
                transition: all 0.22s;
            }
            .lm-close:hover {
                background: rgba(249,180,15,0.18); color: #fcd558;
                transform: rotate(90deg);
                box-shadow: 0 0 12px rgba(249,180,15,0.2);
            }

            /* ── Left info panel ── */
            .lm-left-panel {
                background: linear-gradient(160deg, #380041 0%, #1e0025 55%, #0c0014 100%);
                padding: 46px 36px; display: flex; flex-direction: column;
                position: relative; overflow: hidden;
            }
            .lm-left-panel::before {
                content: ''; position: absolute; inset: 0; pointer-events: none;
                background:
                    radial-gradient(ellipse 80% 60% at 20% 15%, rgba(249,180,15,0.09), transparent 60%),
                    radial-gradient(ellipse 60% 50% at 80% 85%, rgba(82,0,96,0.55), transparent 55%);
            }
            .lm-left-panel::after {
                content: ''; position: absolute; top: 0; right: 0;
                width: 1px; height: 100%;
                background: linear-gradient(180deg, transparent, rgba(249,180,15,0.45), rgba(249,180,15,0.18), transparent);
            }
            .lm-side-grid {
                position: absolute; inset: 0; pointer-events: none;
                background-image:
                    linear-gradient(rgba(249,180,15,0.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(249,180,15,0.04) 1px, transparent 1px);
                background-size: 40px 40px;
            }
            .lm-side-inner { position: relative; z-index: 1; }
            .lm-logo-wrap { display: flex; align-items: center; gap: 12px; margin-bottom: 34px; }
            .lm-logo-img {
                width: 44px; height: 44px; border-radius: 11px; object-fit: cover;
                border: 2px solid rgba(249,180,15,0.35);
                box-shadow: 0 0 18px rgba(249,180,15,0.18);
            }
            .lm-app-nm {
                font-family: 'Playfair Display', serif;
                font-size: 1rem; font-weight: 700; color: #fffbf0;
            }
            .lm-app-nm span { color: #f9b40f; }
            .lm-gold-rule { width: 44px; height: 3px; border-radius: 2px; background: linear-gradient(90deg, #f9b40f, #fcd558); margin-bottom: 18px; }
            .lm-headline {
                font-family: 'Playfair Display', serif;
                font-size: 1.8rem; font-weight: 900; color: #fffbf0;
                line-height: 1.15; margin-bottom: 12px; letter-spacing: -0.01em;
            }
            .lm-hl-accent {
                background: linear-gradient(105deg, #f9b40f, #fcd558);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }
            .lm-lead { font-size: 0.83rem; color: rgba(255,251,240,0.55); line-height: 1.72; margin-bottom: 28px; font-weight: 300; }
            .lm-features { display: flex; flex-direction: column; gap: 10px; }
            .lm-feat {
                display: flex; align-items: flex-start; gap: 12px;
                padding: 12px 14px;
                background: rgba(249,180,15,0.05); border: 1px solid rgba(249,180,15,0.12);
                border-radius: 10px; transition: all 0.2s;
            }
            .lm-feat:hover { background: rgba(249,180,15,0.1); transform: translateX(4px); border-color: rgba(249,180,15,0.28); }
            .lm-feat-icon {
                width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
                background: linear-gradient(135deg, #f9b40f, #fcd558);
                display: flex; align-items: center; justify-content: center;
                color: #380041; font-size: 0.78rem;
                box-shadow: 0 2px 12px rgba(249,180,15,0.3);
            }
            .lm-feat-title { font-size: 0.77rem; font-weight: 700; color: #fcd558; margin-bottom: 2px; }
            .lm-feat-desc  { font-size: 0.69rem; color: rgba(255,251,240,0.5); line-height: 1.5; }

            /* ── Right form panel ── */
            .lm-right-panel {
                background: rgba(24, 0, 34, 0.97);
                padding: 46px 40px;
                display: flex; flex-direction: column; justify-content: center;
                border-left: 1px solid rgba(249,180,15,0.1);
                position: relative;
            }
            /* Tabs */
            .lm-tabs {
                display: flex;
                background: rgba(56,0,65,0.8); border: 1px solid rgba(249,180,15,0.18);
                border-radius: 12px; padding: 5px; gap: 5px; margin-bottom: 26px;
            }
            .lm-tab {
                flex: 1; padding: 9px 10px; border: none; cursor: pointer;
                border-radius: 8px; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.02em;
                display: flex; align-items: center; justify-content: center; gap: 6px;
                transition: all 0.22s; background: transparent; color: rgba(249,180,15,0.5);
                font-family: 'DM Sans', sans-serif;
            }
            .lm-tab--active {
                background: linear-gradient(135deg, #f9b40f, #fcd558);
                color: #380041; box-shadow: 0 4px 18px rgba(249,180,15,0.3);
            }
            .lm-tab:not(.lm-tab--active):hover { background: rgba(249,180,15,0.08); color: #f9b40f; }

            /* Form header */
            .lm-eyebrow {
                display: inline-flex; align-items: center; gap: 7px;
                padding: 4px 11px; border-radius: 4px; margin-bottom: 10px;
                background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.25);
                font-size: 0.6rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
                color: #f9b40f;
            }
            .lm-eyebrow-dot {
                width: 5px; height: 5px; border-radius: 50%; background: #f9b40f;
                box-shadow: 0 0 6px rgba(249,180,15,0.8);
                animation: lm-ep 2s ease-in-out infinite;
            }
            @keyframes lm-ep { 0%,100%{box-shadow:0 0 5px rgba(249,180,15,0.5)} 50%{box-shadow:0 0 14px rgba(249,180,15,1)} }
            .lm-form-heading {
                font-family: 'Playfair Display', serif;
                font-size: 1.7rem; font-weight: 900; color: #fffbf0; margin: 0 0 6px;
            }
            .lm-h-accent { background: linear-gradient(105deg, #f9b40f, #fcd558); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
            .lm-form-sub { font-size: 0.8rem; color: rgba(255,251,240,0.5); margin-bottom: 24px; font-weight: 300; }

            /* Google button */
            .lm-google-wrap { display: flex; flex-direction: column; align-items: center; gap: 1rem; margin-top: 1.5rem; }
            .lm-google-btn {
                display: flex; align-items: center; justify-content: center; gap: 0.75rem;
                width: 100%; padding: 0.88rem 1.5rem;
                background: #fff; color: #3c4043;
                font-size: 0.92rem; font-weight: 600;
                border: 1.5px solid #dadce0; border-radius: 0.65rem;
                text-decoration: none; transition: box-shadow 0.22s, background 0.2s, border-color 0.2s;
                cursor: pointer;
            }
            .lm-google-btn:hover {
                background: #f8f9fa;
                box-shadow: 0 3px 20px rgba(0,0,0,0.13), 0 0 0 2px rgba(249,180,15,0.18);
                border-color: #bbb;
            }
            .lm-google-icon { width: 1.2rem; height: 1.2rem; flex-shrink: 0; }
            .lm-google-hint { font-size: 0.73rem; color: rgba(255,251,240,0.32); text-align: center; display: flex; align-items: center; gap: 0.4rem; }

            /* Admin badge */
            .lm-admin-badge {
                display: flex; align-items: center; gap: 10px; padding: 10px 14px;
                background: rgba(249,180,15,0.07); border: 1px solid rgba(249,180,15,0.25);
                border-radius: 10px; margin-bottom: 16px;
                font-size: 0.74rem; font-weight: 600; color: #fcd558;
            }
            .lm-admin-icon {
                width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
                background: linear-gradient(135deg, #f9b40f, #fcd558);
                display: flex; align-items: center; justify-content: center;
                color: #380041; font-size: 0.72rem;
            }

            /* Fields */
            .lm-field { margin-bottom: 15px; }
            .lm-label {
                display: block; font-size: 0.7rem; font-weight: 700;
                color: rgba(255,251,240,0.8); margin-bottom: 6px;
                letter-spacing: 0.04em; text-transform: uppercase;
            }
            .lm-input-wrap { position: relative; }
            .lm-input-icon {
                position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
                color: rgba(249,180,15,0.4); font-size: 0.78rem; pointer-events: none;
                transition: color 0.2s;
            }
            .lm-input-wrap:focus-within .lm-input-icon { color: #f9b40f; }
            .lm-input {
                width: 100%; padding: 11px 13px 11px 38px;
                border-radius: 10px; border: 1.5px solid rgba(249,180,15,0.15);
                background: rgba(56,0,65,0.5); color: #fffbf0;
                font-size: 0.85rem; font-family: 'DM Sans', sans-serif;
                transition: all 0.2s; outline: none;
            }
            .lm-input::placeholder { color: rgba(255,251,240,0.22); }
            .lm-input:focus {
                border-color: rgba(249,180,15,0.6);
                background: rgba(56,0,65,0.8);
                box-shadow: 0 0 0 3px rgba(249,180,15,0.09);
            }
            .lm-input--error { border-color: rgba(248,113,113,0.6); }
            .lm-field-error { font-size: 0.69rem; color: #f87171; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
            .lm-remember { display: flex; align-items: center; gap: 7px; font-size: 0.75rem; color: rgba(255,251,240,0.45); cursor: pointer; }
            .lm-remember-cb { width: 15px; height: 15px; accent-color: #f9b40f; cursor: pointer; }

            /* Submit button */
            .lm-submit {
                width: 100%; padding: 12px 20px; border: none; border-radius: 10px;
                cursor: pointer; font-size: 0.85rem; font-weight: 700; letter-spacing: 0.03em;
                color: #2a0030;
                background: linear-gradient(135deg, #c98a00, #f9b40f, #fcd558);
                box-shadow: 0 4px 24px rgba(249,180,15,0.32);
                display: flex; align-items: center; justify-content: center; gap: 8px;
                transition: all 0.22s; font-family: 'DM Sans', sans-serif;
            }
            .lm-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(249,180,15,0.48); }
            .lm-submit:active { transform: translateY(0); }

            /* Session status */
            .lm-session-status {
                padding: 9px 13px; border-radius: 8px; margin-bottom: 14px;
                font-size: 0.77rem; font-weight: 600;
                background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.25); color: #fcd558;
            }
        </style>
    </head>
    <body class="antialiased"
          x-data="{ loginOpen: false, loginTab: 'voter' }"
          x-init="$watch('loginOpen', function(v){ document.body.style.overflow = v ? 'hidden' : ''; })">

        {{-- ══ NAVBAR ══ --}}
        @if (Route::has('login'))
        <nav class="site-nav" id="site-nav">
            <a href="#home" class="nav-brand" onclick="smoothScrollTo('home')">
                <img src="{{ asset('assets/app_logo.png') }}" class="nav-logo" alt="{{ config('app.name') }}">
                <div class="nav-name-block">
                    <span class="nav-name">BukSU COMELEC</span>
                    <span class="nav-tagline">Online Voting System</span>
                </div>
            </a>

            <div class="nav-links" id="nav-links">
                <a href="#home"         class="nav-link is-active" data-section="home">Home</a>
                <a href="#about"        class="nav-link"           data-section="about">About</a>
                <a href="#election"     class="nav-link"           data-section="election">Election</a>
                <a href="#how-it-works" class="nav-link"           data-section="how-it-works">How It Works</a>
                <a href="#meet-the-team" class="nav-link"          data-section="meet-the-team">Meet the Team</a>
                <a href="#contact"      class="nav-link"           data-section="contact">Contact</a>
            </div>

            <div class="nav-actions">
                <div class="nav-live-badge" id="nav-live-badge">
                    <span class="nav-live-dot"></span>
                    <span>LIVE SYSTEM</span>
                </div>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-cta-btn">
                            <i class="fas fa-shield-halved"></i> <span>Admin Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role === 'voter')
                        <a href="{{ route('voter.dashboard') }}" class="nav-cta-btn">
                            <i class="fas fa-vote-yea"></i> <span>Voter Dashboard</span>
                        </a>
                    @endif
                @else
                    <button type="button" class="nav-cta-btn"
                       @click="loginOpen = true; loginTab = 'voter'">
                        <i class="fas fa-right-to-bracket"></i> <span>Login</span>
                    </button>
                @endauth

                {{-- Mobile hamburger --}}
                <button class="nav-hamburger" id="nav-hamburger" aria-label="Toggle navigation menu" aria-expanded="false">
                    <span class="hamburger-bar"></span>
                    <span class="hamburger-bar"></span>
                    <span class="hamburger-bar"></span>
                </button>
            </div>
        </nav>

        {{-- ── Mobile Drawer ── --}}
        <div class="mobile-drawer" id="mobile-drawer" aria-hidden="true">
            <div class="mobile-drawer-inner">
                <a href="#home"         class="mobile-nav-link" data-section="home">
                    <i class="fas fa-house"></i> Home
                </a>
                <a href="#about"        class="mobile-nav-link" data-section="about">
                    <i class="fas fa-shield-halved"></i> About
                </a>
                <a href="#election"     class="mobile-nav-link" data-section="election">
                    <i class="fas fa-vote-yea"></i> Election
                </a>
                <a href="#how-it-works" class="mobile-nav-link" data-section="how-it-works">
                    <i class="fas fa-circle-question"></i> How It Works
                </a>
                <a href="#meet-the-team" class="mobile-nav-link" data-section="meet-the-team">
                    <i class="fas fa-users"></i> Meet the Team
                </a>
                <a href="#contact"      class="mobile-nav-link" data-section="contact">
                    <i class="fas fa-envelope"></i> Contact
                </a>
                <div class="mobile-drawer-divider"></div>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="mobile-nav-cta">
                            <i class="fas fa-shield-halved"></i> Admin Dashboard
                        </a>
                    @elseif(Auth::user()->role === 'voter')
                        <a href="{{ route('voter.dashboard') }}" class="mobile-nav-cta">
                            <i class="fas fa-vote-yea"></i> Voter Dashboard
                        </a>
                    @endif
                @else
                    <button type="button" class="mobile-nav-cta"
                       @click="loginOpen = true; loginTab = 'voter'">
                        <i class="fas fa-right-to-bracket"></i> Login
                    </button>
                @endauth
            </div>
        </div>
        @endif

        {{-- ══ PAGE BODY ══ --}}
        <div class="page-body">

            {{-- ════════════════════════════════════════════
                 HOME SECTION
            ════════════════════════════════════════════ --}}
            <section id="home" class="section-scroll-target scroll-mt-24">
                <div class="outer w-full px-4 sm:px-6 lg:px-8">
                    <div class="grid-bg"></div>
                    <div class="grid-dots"></div>

                    <div class="hero-layout">

                        {{-- LEFT: Hero text --}}
                        <div class="hero-left">
                            <div class="eyebrow">
                                <i class="fas fa-shield-halved" style="font-size:0.6rem"></i>
                                Trusted Online Voting Platform
                            </div>

                            <h1 class="hero-h1 text-3xl sm:text-4xl lg:text-6xl break-words">
                                Your Vote<br>
                                <span class="h1-accent">Matters</span>
                            </h1>

                            <p class="hero-lead text-sm sm:text-base break-words">
                                We ensure fair, transparent, and secure elections for every student voice. Built with integrity, powered by technology.
                            </p>

                            <div class="hero-cta-row">
                                @auth
                                    @if(Auth::user()->role === 'voter')
                                        <a href="{{ route('voter.dashboard') }}" class="btn-primary">
                                            Vote Now <i class="fas fa-arrow-right"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                                            Dashboard <i class="fas fa-arrow-right"></i>
                                        </a>
                                    @endif
                                @else
                                    <button type="button" class="btn-primary"
                                       @click="loginOpen = true; loginTab = 'voter'">
                                        Vote Now <i class="fas fa-arrow-right"></i>
                                    </button>
                                @endauth
                                <a href="#about" class="btn-secondary" onclick="smoothScrollTo('about'); return false;">
                                    <i class="fas fa-circle-info"></i> Learn More
                                </a>
                            </div>

                            {{-- Trust Stats Bar --}}
                            <div class="trust-bar">
                                <div class="trust-item">
                                    <div class="trust-icon"><i class="fas fa-shield-halved"></i></div>
                                    <div class="trust-text">
                                        <div class="trust-val">99.9%</div>
                                        <div class="trust-lbl">Uptime</div>
                                    </div>
                                </div>
                                <div class="trust-sep"></div>
                                <div class="trust-item">
                                    <div class="trust-icon"><i class="fas fa-lock"></i></div>
                                    <div class="trust-text">
                                        <div class="trust-val">256-bit</div>
                                        <div class="trust-lbl">Encryption</div>
                                    </div>
                                </div>
                                <div class="trust-sep"></div>
                                <div class="trust-item">
                                    <div class="trust-icon"><i class="fas fa-user-secret"></i></div>
                                    <div class="trust-text">
                                        <div class="trust-val">Anonymous</div>
                                        <div class="trust-lbl">Voting</div>
                                    </div>
                                </div>
                                <div class="trust-sep"></div>
                                <div class="trust-item">
                                    <div class="trust-icon"><i class="fas fa-bolt"></i></div>
                                    <div class="trust-text">
                                        <div class="trust-val">Real-time</div>
                                        <div class="trust-lbl">Results</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CENTER: Ballot Box Visual --}}
                        <div class="hero-visual">
                            <div class="centerpiece-wrap">
                                <img src="{{ asset('center.png') }}" alt="Voting ballot box visual" class="centerpiece-img w-full max-w-[280px] sm:max-w-[360px] lg:max-w-[460px] mx-auto">
                            </div>
                        </div>

                        {{-- RIGHT: Election Status Card --}}
                        <div class="ec-card">
                            <div class="ec-inner">

                                <div class="ec-section-label">
                                    <span class="ec-label-dot" id="ec-label-dot"></span>
                                    Live Election Status
                                </div>

                                <div class="ec-name-group">
                                    <div class="ec-election-name" id="ec-election-name">Student Government Election</div>
                                    <div class="ec-tagline">Secure. Transparent. Trusted.</div>
                                </div>

                                <div class="ec-divider"></div>

                                {{-- Countdown timer --}}
                                <div class="ec-countdown-section" id="ec-countdown-wrap" style="display:none;">
                                    <div class="ec-cd-header">
                                        <i class="fas fa-calendar-alt" id="ec-cd-icon"></i>
                                        <span id="ec-cd-header-text">Election Starts In</span>
                                    </div>
                                    <div class="ec-countdown">
                                        <div class="ec-cd-block">
                                            <div class="ec-cd-num" id="cd-days">00</div>
                                            <div class="ec-cd-lbl">DAYS</div>
                                        </div>
                                        <div class="ec-cd-sep">:</div>
                                        <div class="ec-cd-block">
                                            <div class="ec-cd-num" id="cd-hrs">00</div>
                                            <div class="ec-cd-lbl">HRS</div>
                                        </div>
                                        <div class="ec-cd-sep">:</div>
                                        <div class="ec-cd-block">
                                            <div class="ec-cd-num" id="cd-mins">00</div>
                                            <div class="ec-cd-lbl">MINS</div>
                                        </div>
                                        <div class="ec-cd-sep">:</div>
                                        <div class="ec-cd-block">
                                            <div class="ec-cd-num" id="cd-secs">00</div>
                                            <div class="ec-cd-lbl">SECS</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status orb --}}
                                <div class="ec-orb-wrap" id="ec-orb-wrap">
                                    <div class="ec-orb upcoming" id="ec-orb">
                                        <i class="fas fa-hourglass-start" id="ec-orb-icon"></i>
                                    </div>
                                    <div class="ec-orb-label upcoming" id="ec-orb-label">Election Soon</div>
                                    <div class="ec-orb-hint" id="ec-orb-hint">Voting has not started yet</div>
                                </div>

                                {{-- Stats --}}
                                <div class="ec-stats-dual">
                                    <div class="ec-stat-box">
                                        <div class="ec-stat-row-label">
                                            <i class="fas fa-check-to-slot"></i> Votes Cast
                                        </div>
                                        <div class="ec-stat-big" id="ec-votes">0</div>
                                    </div>
                                    <div class="ec-stat-box">
                                        <div class="ec-stat-row-label">
                                            <i class="fas fa-users"></i> Total Voters
                                        </div>
                                        <div class="ec-stat-big" id="ec-total">—</div>
                                    </div>
                                </div>

                                {{-- Progress bar --}}
                                <div class="ec-progress-block" id="ec-part">
                                    <div class="ec-prog-header">
                                        <span class="ec-prog-lbl">Progress to Start</span>
                                        <span class="ec-prog-pct" id="ec-part-pct">0%</span>
                                    </div>
                                    <div class="ec-track">
                                        <div class="ec-fill" id="ec-fill"></div>
                                    </div>
                                </div>

                                {{-- Live strip --}}
                                <div class="ec-live-strip" id="ec-live-strip">
                                    <div class="ec-live-dot"></div>
                                    Voting is open right now
                                </div>

                                {{-- View details --}}
                                <a href="#election" class="ec-details-link" onclick="smoothScrollTo('election'); return false;">
                                    View Election Details
                                    <i class="fas fa-arrow-right"></i>
                                </a>

                            </div>
                        </div>

                    </div>{{-- end .hero-layout --}}
                </div>{{-- end .outer --}}
            </section>{{-- end #home --}}


            {{-- ════════════════════════════════════════════
                 ABOUT SECTION
            ════════════════════════════════════════════ --}}
            <section id="about" class="landing-section section-scroll-target scroll-mt-24">
                <div class="ls-inner w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <header class="ls-header ls-reveal">
                        <span class="ls-tag"><i class="fas fa-shield-halved"></i> About the System</span>
                        <h2 class="ls-title text-2xl sm:text-3xl lg:text-4xl break-words">Secure Elections for <span class="h1-accent">Every Student</span></h2>
                        <p class="ls-subtitle text-sm sm:text-base break-words">Built on transparency, powered by technology — ensuring every vote is fair, private, and counted.</p>
                    </header>

                    {{-- Value cards --}}
                    <div class="about-values ls-reveal">
                        <div class="about-val-card">
                            <div class="about-val-icon"><i class="fas fa-eye"></i></div>
                            <h4 class="about-val-title">Transparent</h4>
                            <p class="about-val-desc">Every step of the election process is open and verifiable, building trust from nomination to results.</p>
                        </div>
                        <div class="about-val-card">
                            <div class="about-val-icon"><i class="fas fa-lock"></i></div>
                            <h4 class="about-val-title">Secure</h4>
                            <p class="about-val-desc">Military-grade encryption protects each ballot, ensuring that votes cannot be tampered with or traced.</p>
                        </div>
                        <div class="about-val-card">
                            <div class="about-val-icon"><i class="fas fa-mobile-screen-button"></i></div>
                            <h4 class="about-val-title">Accessible</h4>
                            <p class="about-val-desc">Vote anytime, anywhere — a responsive platform designed for every device across the campus network.</p>
                        </div>
                        <div class="about-val-card">
                            <div class="about-val-icon"><i class="fas fa-users"></i></div>
                            <h4 class="about-val-title">Student-Powered</h4>
                            <p class="about-val-desc">Designed by students, for students — putting the future of BukSU student governance directly in your hands.</p>
                        </div>
                    </div>

                    {{-- ── Org Chart ── --}}
                    @php
                        $adviser = ['name' => 'Mark Ian Mukara', 'role' => 'Adviser', 'initials' => 'MM', 'avatar' => asset('assets/team/6.png'), 'description' => 'Provides strategic guidance to keep election operations aligned and effective.'];

                        $commissionMembers = [
                            ['name' => 'Roxanne Mae Ortega',    'role' => 'Head Commissioner',                'initials' => 'RO', 'avatar' => asset('assets/team/5.png'),      'description' => 'Leads commission execution and ensures every election process is on track.'],
                            ['name' => 'Yassin Naga',           'role' => 'Internal Commissioner',           'initials' => 'YN', 'avatar' => asset('assets/team/2.png'),      'description' => 'Coordinates internal workflows and keeps team communication streamlined.'],
                            ['name' => 'Steven Bagasbas',       'role' => 'External Commissioner',           'initials' => 'SB', 'avatar' => asset('assets/team/locked.png'), 'description' => 'Handles external coordination and supports clear public-facing communication.'],
                            ['name' => 'Khisia Faith Llanera',  'role' => 'Logistics Commissioner',          'initials' => 'KL', 'avatar' => asset('assets/team/locked.png'), 'description' => 'Manages logistics and ensures election resources are prepared on time.'],
                            ['name' => 'Elaine Mae Furog',      'role' => 'Canvass Commissioner',            'initials' => 'EF', 'avatar' => asset('assets/team/locked.png'), 'description' => 'Supports vote canvassing with a focus on accuracy and transparency.'],
                            ['name' => 'Rhoda Princess Diones', 'role' => 'Campaign Commissioner',           'initials' => 'RD', 'avatar' => asset('assets/team/locked.png'), 'description' => 'Oversees campaign activities and enforces fair election participation.'],
                            ['name' => 'Marian Gewan',          'role' => 'Creatives Commissioner',          'initials' => 'MG', 'avatar' => asset('assets/team/locked.png'), 'description' => 'Leads creative outputs that keep election communications clear and cohesive.'],
                            ['name' => 'Axiel Ivan Pacquiao',   'role' => 'Local Commissioner on Campaign',  'initials' => 'AP', 'avatar' => asset('assets/team/4.png'),      'description' => 'Coordinates local campaign initiatives and supports outreach consistency.'],
                            ['name' => 'Kurt Kein Daguyo',      'role' => 'Local Commissioner on Campaign',  'initials' => 'KD', 'avatar' => asset('assets/team/locked.png'), 'description' => 'Supports local campaign planning and helps maintain compliance standards.'],
                            ['name' => 'Owen Jerusalem',        'role' => 'Local Commissioner on Creatives', 'initials' => 'OJ', 'avatar' => asset('assets/team/3.png'),      'description' => 'Contributes creative assets for local campaigns with consistent branding.'],
                            ['name' => 'Gerardo Aranas Jr',     'role' => 'Local Commissioner on Creatives', 'initials' => 'GA', 'avatar' => asset('assets/team/locked.png'), 'description' => 'Supports design production for local initiatives and campaign visuals.'],
                        ];

                        $developmentTeam = [
                            ['name' => 'Rey Rameses Jude "Jam" Macalutas III', 'role' => 'System Developer / Lead Developer', 'initials' => 'JM', 'avatar' => asset('assets/team/dev1.png'), 'description' => 'Leads system architecture and ensures secure, smooth platform performance.'],
                            ['name' => 'Khyle Ivan Khim V. Amacna',            'role' => 'Head System Developer',            'initials' => 'KA', 'avatar' => asset('assets/team/dev2.jpg'),  'description' => 'Directs technical execution, aligning development tasks with project goals.'],
                            ['name' => 'Bernardo DeLa Cerna Jr.',              'role' => 'System Developer / QA',            'initials' => 'BC', 'avatar' => asset('assets/team/locked.png'),'description' => 'Handles quality assurance and testing to maintain reliability and trust.'],
                        ];
                    @endphp

                </div>
            </section>{{-- end #about --}}


            {{-- ════════════════════════════════════════════
                 ELECTIONS SECTION
            ════════════════════════════════════════════ --}}
            <section id="election" class="landing-section section-scroll-target scroll-mt-24 ls-alt-bg">
                <div class="ls-inner w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <header class="ls-header ls-reveal">
                        <span class="ls-tag"><i class="fas fa-vote-yea"></i> Elections</span>
                        <h2 class="ls-title text-2xl sm:text-3xl lg:text-4xl break-words">Student Government <span class="h1-accent">Election</span></h2>
                        <p class="ls-subtitle text-sm sm:text-base break-words">Participate in secure, transparent, and reliable digital elections designed for every BukSU student.</p>
                    </header>

                    <div class="ls-elections-layout ls-reveal" data-election-page>
                        {{-- Overview card --}}
                        <div class="ls-glass-card ls-elections-left">
                            <h2 class="ls-card-title">Election Overview</h2>
                            <div class="ls-meta-grid">
                                <div class="ls-meta-item">
                                    <div class="ls-meta-label">Election Name</div>
                                    <div class="ls-meta-value">BukSU Student Government Election 2026</div>
                                </div>
                                <div class="ls-meta-item">
                                    <div class="ls-meta-label">Status</div>
                                    <div class="ls-meta-value" id="ls-status-label">Upcoming</div>
                                </div>
                                <div class="ls-meta-item">
                                    <div class="ls-meta-label">Voting Date</div>
                                    <div class="ls-meta-value">April 25, 2026</div>
                                </div>
                                <div class="ls-meta-item">
                                    <div class="ls-meta-label">Eligibility</div>
                                    <div class="ls-meta-value">All enrolled students</div>
                                </div>
                            </div>

                            <div class="ls-cta-row">
                                <div>
                                    <strong style="color:var(--cream)">Make your voice count</strong>
                                    <div style="color:var(--cream-dim);font-size:.84rem;margin-top:4px;">in shaping your organization's future.</div>
                                </div>
                                @auth
                                    @if(Auth::user()->role === 'voter')
                                        <a href="{{ route('voter.dashboard') }}" class="btn-primary" id="ls-vote-btn">Vote Now</a>
                                    @else
                                        <a href="{{ route('admin.dashboard') }}" class="btn-primary">Dashboard</a>
                                    @endif
                                @else
                                    <button type="button" class="btn-primary" id="ls-vote-btn"
                                       @click="loginOpen = true; loginTab = 'voter'">Vote Now</button>
                                @endauth
                            </div>
                            <p class="ls-vote-hint" id="ls-vote-hint">Voting will be available once the election starts.</p>
                        </div>

                        {{-- Status card --}}
                        <div class="ls-glass-card ls-elections-right">
                            <div class="ls-status-chip">LIVE ELECTION STATUS</div>
                            <h3 class="ls-status-title">Student Government Election</h3>

                            <div style="display:flex;align-items:center;gap:10px;">
                                <i class="fas fa-hourglass-start" id="ls-status-icon" style="color:var(--gold);"></i>
                                <strong id="ls-elec-status-label">Election Soon</strong>
                            </div>
                            <p style="color:var(--cream-dim);font-size:.88rem;margin-top:8px;" id="ls-elec-status-hint">Voting has not started yet</p>

                            <div class="ls-stats-row">
                                <div class="ls-meta-item">
                                    <div class="ls-meta-label">Votes Cast</div>
                                    <div class="ls-meta-value" id="ls-votes">0</div>
                                </div>
                                <div class="ls-meta-item">
                                    <div class="ls-meta-label">Total Voters</div>
                                    <div class="ls-meta-value" id="ls-total">—</div>
                                </div>
                            </div>

                            <div class="ls-meta-label" style="margin-bottom:6px;">
                                Participation <span id="ls-pct">0%</span>
                            </div>
                            <div class="ls-progress-track">
                                <div class="ls-progress-fill" id="ls-fill"></div>
                            </div>

                            <button type="button" class="btn-primary" style="display:inline-flex;margin-top:20px;text-decoration:none;"
                               @click="loginOpen = true; loginTab = 'voter'">
                                View Election Details <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </section>{{-- end #election --}}


            {{-- ════════════════════════════════════════════
                 HOW IT WORKS SECTION
            ════════════════════════════════════════════ --}}
            <section id="how-it-works" class="landing-section section-scroll-target scroll-mt-24">
                <div class="ls-inner w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <header class="ls-header ls-reveal">
                        <span class="ls-tag"><i class="fas fa-circle-question"></i> How It Works</span>
                        <h2 class="ls-title text-2xl sm:text-3xl lg:text-4xl break-words">Simple Steps to <span class="h1-accent">Cast Your Vote</span></h2>
                        <p class="ls-subtitle text-sm sm:text-base break-words">A straightforward, secure voting process designed to be completed in minutes.</p>
                    </header>

                    <div class="ls-steps ls-reveal">
                        <div class="ls-step">
                            <div class="ls-step-num">1</div>
                            <div class="ls-step-connector"></div>
                            <div class="ls-glass-card ls-step-card">
                                <div class="ls-step-icon"><i class="fas fa-right-to-bracket"></i></div>
                                <h4 class="ls-step-title">Login Securely</h4>
                                <p class="ls-step-desc">Access the system using your student credentials provided by the registrar.</p>
                            </div>
                        </div>
                        <div class="ls-step">
                            <div class="ls-step-num">2</div>
                            <div class="ls-step-connector"></div>
                            <div class="ls-glass-card ls-step-card">
                                <div class="ls-step-icon"><i class="fas fa-id-card-clip"></i></div>
                                <h4 class="ls-step-title">Verify Identity</h4>
                                <p class="ls-step-desc">Your eligibility is verified automatically — only enrolled students can participate.</p>
                            </div>
                        </div>
                        <div class="ls-step">
                            <div class="ls-step-num">3</div>
                            <div class="ls-step-connector"></div>
                            <div class="ls-glass-card ls-step-card">
                                <div class="ls-step-icon"><i class="fas fa-list-check"></i></div>
                                <h4 class="ls-step-title">Review Candidates</h4>
                                <p class="ls-step-desc">Browse candidate profiles and platforms before making your decision.</p>
                            </div>
                        </div>
                        <div class="ls-step">
                            <div class="ls-step-num">4</div>
                            <div class="ls-step-connector"></div>
                            <div class="ls-glass-card ls-step-card">
                                <div class="ls-step-icon"><i class="fas fa-check-to-slot"></i></div>
                                <h4 class="ls-step-title">Cast Your Vote</h4>
                                <p class="ls-step-desc">Select your candidates and submit your encrypted ballot with one click.</p>
                            </div>
                        </div>
                        <div class="ls-step">
                            <div class="ls-step-num">5</div>
                            <div class="ls-step-connector" style="opacity:0"></div>
                            <div class="ls-glass-card ls-step-card">
                                <div class="ls-step-icon"><i class="fas fa-chart-bar"></i></div>
                                <h4 class="ls-step-title">Results Published</h4>
                                <p class="ls-step-desc">Tallied results are published transparently once voting officially closes.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Feature pills --}}
                    <div class="ls-features ls-reveal">
                        <div class="ls-glass-card ls-feature-card">
                            <div class="ls-feat-icon"><i class="fas fa-lock"></i></div>
                            <span class="ls-feat-label">Secure Voting</span>
                        </div>
                        <div class="ls-glass-card ls-feature-card">
                            <div class="ls-feat-icon"><i class="fas fa-bolt"></i></div>
                            <span class="ls-feat-label">Real-Time Results</span>
                        </div>
                        <div class="ls-glass-card ls-feature-card">
                            <div class="ls-feat-icon"><i class="fas fa-file-lines"></i></div>
                            <span class="ls-feat-label">Transparent Process</span>
                        </div>
                        <div class="ls-glass-card ls-feature-card">
                            <div class="ls-feat-icon"><i class="fas fa-user-secret"></i></div>
                            <span class="ls-feat-label">Anonymous Ballots</span>
                        </div>
                    </div>

                </div>
            </section>{{-- end #how-it-works --}}

            {{-- ════════════════════════════════════════════
                 MEET THE TEAM SECTION
            ════════════════════════════════════════════ --}}
            <section id="meet-the-team" class="landing-section section-scroll-target scroll-mt-24 ls-alt-bg">
                <div class="ls-inner w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="org-chart ls-reveal">
                        <div class="org-header">
                            <p class="org-eyebrow">MEET THE TEAM</p>
                            <h2 class="org-title text-2xl sm:text-3xl lg:text-4xl break-words">The Minds Behind <span class="h1-accent">the System</span></h2>
                            <p class="org-subtitle text-sm sm:text-base break-words">Dedicated developers and commission members building a secure and transparent voting platform.</p>
                        </div>
                        <div class="org-flow">
                            <div class="org-node team-card-animate">
                                <article class="team-card org-leader-card">
                                    <div class="tc-image-wrap">
                                        <img src="{{ asset('assets/team/joy.png') }}" alt="Dr. Joy M. Mirasol" class="tc-image"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='none'; this.parentElement.querySelector('.tc-av-fallback').style.display='flex';">
                                        <div class="tc-image-overlay"></div>
                                        <div class="tc-av-fallback tc-av-fallback--icon" style="display:none;">
                                            <i class="fas fa-university"></i>
                                        </div>
                                    </div>
                                    <div class="tc-content">
                                        <h4 class="tc-name">Dr. Joy M. Mirasol</h4>
                                        <p class="tc-role">University President</p>
                                        <p class="tc-description">Provides overall direction and institutional governance for all university-sanctioned activities.</p>
                                    </div>
                                </article>
                            </div>
                            <div class="org-line team-card-animate" aria-hidden="true">
                                <span class="org-line-dot"></span>
                                <span class="org-line-track"></span>
                                <span class="org-line-dot"></span>
                            </div>
                            <div class="org-node team-card-animate">
                                <article class="team-card org-leader-card">
                                    <div class="tc-image-wrap">
                                        <img src="{{ asset('assets/team/tan.png') }}" alt="Dr. Lincoln V. Tan" class="tc-image"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='none'; this.parentElement.querySelector('.tc-av-fallback').style.display='flex';">
                                        <div class="tc-image-overlay"></div>
                                        <div class="tc-av-fallback tc-av-fallback--icon" style="display:none;">
                                            <i class="fas fa-person-chalkboard"></i>
                                        </div>
                                    </div>
                                    <div class="tc-content">
                                        <h4 class="tc-name">Dr. Lincoln V. Tan</h4>
                                        <p class="tc-role">VP &mdash; Culture, Arts &amp; Student Services</p>
                                        <p class="tc-description">Oversees student welfare initiatives and ensures campus activities align with university values.</p>
                                    </div>
                                </article>
                            </div>
                            <div class="org-line team-card-animate" aria-hidden="true">
                                <span class="org-line-dot"></span>
                                <span class="org-line-track"></span>
                                <span class="org-line-dot"></span>
                            </div>
                            <div class="org-node team-card-animate">
                                <article class="team-card org-leader-card">
                                    <div class="tc-image-wrap">
                                        <img src="{{ asset('assets/team/enzo.png') }}" alt="Dr. Lorenzo B. Dinlayan III" class="tc-image"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='none'; this.parentElement.querySelector('.tc-av-fallback').style.display='flex';">
                                        <div class="tc-image-overlay"></div>
                                        <div class="tc-av-fallback tc-av-fallback--icon" style="display:none;">
                                            <i class="fas fa-sitemap"></i>
                                        </div>
                                    </div>
                                    <div class="tc-content">
                                        <h4 class="tc-name">Dr. Lorenzo B. Dinlayan III</h4>
                                        <p class="tc-role">Director &mdash; Student Leadership &amp; Dev. Unit</p>
                                        <p class="tc-description">Guides student organizations and oversees the implementation of student leadership programs.</p>
                                    </div>
                                </article>
                            </div>
                            <div class="org-line org-line--to-section team-card-animate" aria-hidden="true">
                                <span class="org-line-dot"></span>
                                <span class="org-line-track"></span>
                                <span class="org-line-label">COMELEC Commission</span>
                                <span class="org-line-track"></span>
                                <span class="org-line-dot"></span>
                            </div>
                            <div class="org-section team-card-animate">
                                <div class="org-section-header">
                                    <i class="fas fa-shield-halved"></i>
                                    <span>COMELEC Commission Team</span>
                                </div>
                                <div class="org-adviser-wrap team-card-animate">
                                    <article class="team-card org-leader-card">
                                        <div class="tc-image-wrap">
                                            <img src="{{ $adviser['avatar'] }}" alt="{{ $adviser['name'] }}" class="tc-image"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='none'; this.parentElement.querySelector('.tc-av-fallback').style.display='flex';">
                                            <div class="tc-image-overlay"></div>
                                            <div class="tc-av-fallback" style="display:none;">{{ $adviser['initials'] }}</div>
                                        </div>
                                        <div class="tc-content">
                                            <h4 class="tc-name">{{ $adviser['name'] }}</h4>
                                            <p class="tc-role">{{ $adviser['role'] }}</p>
                                            <p class="tc-description">{{ $adviser['description'] }}</p>
                                            <div class="tc-socials">
                                                <a href="#" class="tc-social" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                                <a href="#" class="tc-social" aria-label="Email"><i class="fas fa-envelope"></i></a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="org-adviser-divider" aria-hidden="true">
                                    <span class="org-line-dot"></span>
                                    <span class="org-line-track" style="height:28px;"></span>
                                    <span class="org-line-dot"></span>
                                </div>
                                <div class="team-cards-grid">
                                    @foreach ($commissionMembers as $m)
                                        <article class="team-card team-card-animate">
                                            <div class="tc-image-wrap">
                                                <img src="{{ $m['avatar'] }}" alt="{{ $m['name'] }}" class="tc-image"
                                                    onerror="this.style.display='none'; this.parentElement.querySelector('.tc-av-fallback').style.display='flex';">
                                                <div class="tc-image-overlay"></div>
                                                <div class="tc-av-fallback" style="display:none;">{{ $m['initials'] }}</div>
                                            </div>
                                            <div class="tc-content">
                                                <h4 class="tc-name">{{ $m['name'] }}</h4>
                                                <p class="tc-role">{{ $m['role'] }}</p>
                                                <p class="tc-description">{{ $m['description'] }}</p>
                                                <div class="tc-socials">
                                                    <a href="#" class="tc-social" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                                    <a href="#" class="tc-social" aria-label="Email"><i class="fas fa-envelope"></i></a>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                                <div class="org-dev-subsection">
                                    <div class="org-dev-label">
                                        <span class="org-dev-line"></span>
                                        <span class="org-dev-text"><i class="fas fa-code"></i> Development Team</span>
                                        <span class="org-dev-line"></span>
                                    </div>
                                    <div class="team-cards-grid team-cards-grid--development">
                                        @foreach ($developmentTeam as $m)
                                            <article class="team-card team-card-animate">
                                                <div class="tc-image-wrap">
                                                    <img src="{{ $m['avatar'] }}" alt="{{ $m['name'] }}" class="tc-image"
                                                        onerror="this.style.display='none'; this.parentElement.querySelector('.tc-av-fallback').style.display='flex';">
                                                    <div class="tc-image-overlay"></div>
                                                    <div class="tc-av-fallback" style="display:none;">{{ $m['initials'] }}</div>
                                                </div>
                                                <div class="tc-content">
                                                    <h4 class="tc-name">{{ $m['name'] }}</h4>
                                                    <p class="tc-role">{{ $m['role'] }}</p>
                                                    <p class="tc-description">{{ $m['description'] }}</p>
                                                    <div class="tc-socials">
                                                        <a href="#" class="tc-social" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                                        <a href="#" class="tc-social" aria-label="Email"><i class="fas fa-envelope"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>{{-- end #meet-the-team --}}


            {{-- ════════════════════════════════════════════
                 CONTACT SECTION
            ════════════════════════════════════════════ --}}
            <section id="contact" class="landing-section section-scroll-target scroll-mt-24 ls-alt-bg">
                <div class="ls-inner w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <header class="ls-header ls-reveal">
                        <span class="ls-tag"><i class="fas fa-envelope"></i> Contact</span>
                        <h2 class="ls-title text-2xl sm:text-3xl lg:text-4xl break-words">Get in <span class="h1-accent">Touch</span></h2>
                        <p class="ls-subtitle text-sm sm:text-base break-words">We're here to assist you with any concerns about the election or the system.</p>
                    </header>

                    <div class="ls-contact-layout ls-reveal">

                        {{-- Info panel --}}
                        <div class="ls-glass-card ls-contact-panel">
                            <h3 class="ls-card-title" style="margin-top:0;">Contact Information</h3>
                            <div class="ls-contact-list">
                                <div class="ls-contact-row">
                                    <div class="ls-contact-icon"><i class="fas fa-building-columns"></i></div>
                                    <div>
                                        <div class="ls-contact-label">Organization</div>
                                        <div class="ls-contact-value">BukSU COMELEC</div>
                                    </div>
                                </div>
                                <div class="ls-contact-row">
                                    <div class="ls-contact-icon"><i class="fas fa-envelope"></i></div>
                                    <div>
                                        <div class="ls-contact-label">Email</div>
                                        <div class="ls-contact-value">comelec@buksu.edu.ph</div>
                                    </div>
                                </div>
                                <div class="ls-contact-row">
                                    <div class="ls-contact-icon"><i class="fas fa-location-dot"></i></div>
                                    <div>
                                        <div class="ls-contact-label">Location</div>
                                        <div class="ls-contact-value">Bukidnon State University</div>
                                    </div>
                                </div>
                                <div class="ls-contact-row">
                                    <div class="ls-contact-icon"><i class="fas fa-clock"></i></div>
                                    <div>
                                        <div class="ls-contact-label">Office Hours</div>
                                        <div class="ls-contact-value">Mon–Fri &nbsp;|&nbsp; 8:00 AM – 5:00 PM</div>
                                    </div>
                                </div>
                            </div>

                            <div class="ls-contact-note">
                                <i class="fas fa-circle-info"></i>
                                For urgent election concerns, please contact your College COMELEC representative.
                            </div>
                        </div>

                        {{-- Message form --}}
                        <div class="ls-glass-card ls-contact-panel">
                            <h3 class="ls-card-title" style="margin-top:0;">Send a Message</h3>
                            <form class="ls-form" id="ls-contact-form">
                                <div class="ls-form-field" id="lsf-name">
                                    <label for="ls_full_name">Full Name</label>
                                    <input id="ls_full_name" name="full_name" type="text" placeholder="Your full name">
                                </div>
                                <div class="ls-form-field" id="lsf-email">
                                    <label for="ls_email">Email Address</label>
                                    <input id="ls_email" name="email" type="email" placeholder="your@email.com">
                                </div>
                                <div class="ls-form-field" id="lsf-subject">
                                    <label for="ls_subject">Subject</label>
                                    <input id="ls_subject" name="subject" type="text" placeholder="What is this about?">
                                </div>
                                <div class="ls-form-field" id="lsf-message">
                                    <label for="ls_message">Message</label>
                                    <textarea id="ls_message" name="message" rows="4" placeholder="Your message here..."></textarea>
                                </div>
                                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                                    <i class="fas fa-paper-plane"></i> Send Message
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </section>{{-- end #contact --}}

        </div>{{-- end .page-body --}}

        {{-- ══ FOOTER ══ --}}
        <footer class="site-footer">
            <div class="footer-inner">
                <div class="footer-left">
                    <i class="fas fa-shield-halved footer-shield"></i>
                    &copy; {{ date('Y') }} <strong>{{ config('app.name', 'BukSU COMELEC') }}.</strong> All rights reserved.
                </div>
                <div class="footer-center">
                    <a href="#home"         onclick="smoothScrollTo('home');return false;">Home</a>
                    <a href="#about"        onclick="smoothScrollTo('about');return false;">About</a>
                    <a href="#election"     onclick="smoothScrollTo('election');return false;">Election</a>
                    <a href="#how-it-works" onclick="smoothScrollTo('how-it-works');return false;">How It Works</a>
                    <a href="#meet-the-team" onclick="smoothScrollTo('meet-the-team');return false;">Meet the Team</a>
                    <a href="#contact"      onclick="smoothScrollTo('contact');return false;">Contact</a>
                </div>
                <div class="footer-right">
                    Built for secure and transparent student elections.
                    <i class="fas fa-heart footer-heart"></i>
                </div>
            </div>
        </footer>

        {{-- Toast container --}}
        <div class="ls-toast-stack" id="ls-toast-stack"></div>

        {{-- ══ LOGIN MODAL ══════════════════════════════════════════════════ --}}
        @guest
        <div x-show="loginOpen"
             class="lm-overlay"
             x-transition:enter="lm-enter"
             x-transition:enter-start="lm-ef"
             x-transition:enter-end="lm-et"
             x-transition:leave="lm-leave"
             x-transition:leave-start="lm-et"
             x-transition:leave-end="lm-ef"
             @click.self="loginOpen = false"
             @keydown.escape.window="loginOpen = false"
             style="display:none;"
             role="dialog" aria-modal="true" aria-label="Login">

            <div class="lm-box"
                 x-transition:enter="lm-box-enter"
                 x-transition:enter-start="lm-box-from"
                 x-transition:enter-end="lm-box-to"
                 x-transition:leave="lm-box-leave"
                 x-transition:leave-start="lm-box-to"
                 x-transition:leave-end="lm-box-from"
                 @click.stop>

                {{-- Close button --}}
                <button class="lm-close" @click="loginOpen = false" type="button" aria-label="Close modal">
                    <i class="fas fa-xmark"></i>
                </button>

                {{-- ── LEFT INFO PANEL ── --}}
                <div class="lm-left-panel">
                    <div class="lm-side-grid"></div>
                    <div class="lm-side-inner">
                        <div class="lm-logo-wrap">
                            <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" class="lm-logo-img">
                            <span class="lm-app-nm">{{ config('app.name', 'BukSU') }} <span>System</span></span>
                        </div>

                        <div class="lm-gold-rule"></div>
                        <h2 class="lm-headline">
                            Your Vote <span class="lm-hl-accent">Shapes</span><br>the Future
                        </h2>
                        <p class="lm-lead">
                            Secure, transparent, and fair — every voice counts in our digital democracy platform.
                        </p>

                        <div class="lm-features">
                            <div class="lm-feat">
                                <div class="lm-feat-icon"><i class="fas fa-shield-alt"></i></div>
                                <div>
                                    <div class="lm-feat-title">End-to-End Encrypted</div>
                                    <div class="lm-feat-desc">Your ballot is secured with SHA-256 hashing and unique transaction numbers.</div>
                                </div>
                            </div>
                            <div class="lm-feat">
                                <div class="lm-feat-icon"><i class="fas fa-chart-bar"></i></div>
                                <div>
                                    <div class="lm-feat-title">Live Results</div>
                                    <div class="lm-feat-desc">Real-time vote tallying with transparent, verifiable outcomes.</div>
                                </div>
                            </div>
                            <div class="lm-feat">
                                <div class="lm-feat-icon"><i class="fas fa-user-secret"></i></div>
                                <div>
                                    <div class="lm-feat-title">Anonymous Ballots</div>
                                    <div class="lm-feat-desc">Your identity is protected — only your vote is recorded.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── RIGHT FORM PANEL ── --}}
                <div class="lm-right-panel">

                    {{-- Tabs --}}
                    <div class="lm-tabs" role="tablist">
                        <button class="lm-tab"
                                :class="{ 'lm-tab--active': loginTab === 'voter' }"
                                @click="loginTab = 'voter'"
                                type="button" role="tab"
                                :aria-selected="loginTab === 'voter'">
                            <i class="fas fa-vote-yea"></i> Voter Login
                        </button>
                        <button class="lm-tab"
                                :class="{ 'lm-tab--active': loginTab === 'admin' }"
                                @click="loginTab = 'admin'"
                                type="button" role="tab"
                                :aria-selected="loginTab === 'admin'">
                            <i class="fas fa-shield-halved"></i> Admin Login
                        </button>
                    </div>

                    @if(session('status'))
                        <div class="lm-session-status">
                            <i class="fas fa-circle-check" style="margin-right:5px;"></i>{{ session('status') }}
                        </div>
                    @endif

                    {{-- ── VOTER PANEL ── --}}
                    <div x-show="loginTab === 'voter'"
                         x-transition:enter="lm-panel-enter"
                         x-transition:enter-start="lm-panel-from"
                         x-transition:enter-end="lm-panel-to"
                         style="display:none;">
                        <div class="lm-eyebrow">
                            <div class="lm-eyebrow-dot"></div> Voter Portal
                        </div>
                        <h1 class="lm-form-heading">Welcome <span class="lm-h-accent">Back</span></h1>
                        <p class="lm-form-sub">Sign in with your Google account to cast your vote and view election results.</p>

                        @if(session('error'))
                            <div class="lm-field-error" style="margin-bottom:1rem; font-size:0.8rem; padding:10px 14px; border-radius:8px; background:rgba(248,113,113,0.1); border:1px solid rgba(248,113,113,0.3);">
                                <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
                            </div>
                        @endif

                        <div class="lm-google-wrap">
                            <a href="{{ route('auth.google') }}" class="lm-google-btn">
                                <svg class="lm-google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span>Continue with Google</span>
                            </a>
                            <p class="lm-google-hint">
                                <i class="fas fa-shield-halved"></i>
                                Only registered student accounts are allowed to vote.
                            </p>
                        </div>
                    </div>

                    {{-- ── ADMIN PANEL ── --}}
                    <div x-show="loginTab === 'admin'"
                         x-transition:enter="lm-panel-enter"
                         x-transition:enter-start="lm-panel-from"
                         x-transition:enter-end="lm-panel-to"
                         style="display:none;">
                        <div class="lm-eyebrow" style="background:rgba(249,180,15,0.06);border-color:rgba(249,180,15,0.22);">
                            <div class="lm-eyebrow-dot"></div> Admin Portal
                        </div>
                        <h1 class="lm-form-heading">Admin <span class="lm-h-accent">Access</span></h1>
                        <p class="lm-form-sub">Restricted area — authorized administrators only.</p>

                        <div class="lm-admin-badge">
                            <div class="lm-admin-icon"><i class="fas fa-shield-halved"></i></div>
                            <div><strong>Secure Admin Login</strong> — All access is logged and monitored.</div>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="login_as" value="admin">

                            <div class="lm-field">
                                <label class="lm-label" for="lm_email">Admin Email</label>
                                <div class="lm-input-wrap">
                                    <i class="fas fa-id-badge lm-input-icon"></i>
                                    <input id="lm_email" name="email" type="email"
                                           class="lm-input {{ $errors->has('email') ? 'lm-input--error' : '' }}"
                                           placeholder="admin@domain.com"
                                           value="{{ old('email') }}"
                                           required autocomplete="username">
                                </div>
                                @error('email')
                                    <div class="lm-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="lm-field">
                                <label class="lm-label" for="lm_password">Admin Password</label>
                                <div class="lm-input-wrap">
                                    <i class="fas fa-key lm-input-icon"></i>
                                    <input id="lm_password" name="password" type="password"
                                           class="lm-input {{ $errors->has('password') ? 'lm-input--error' : '' }}"
                                           placeholder="••••••••"
                                           required autocomplete="current-password">
                                </div>
                                @error('password')
                                    <div class="lm-field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div style="margin-bottom:18px;">
                                <label class="lm-remember">
                                    <input type="checkbox" name="remember" class="lm-remember-cb"> Remember me
                                </label>
                            </div>

                            <button type="submit" class="lm-submit">
                                <i class="fas fa-shield-halved"></i> Sign In as Admin
                            </button>
                        </form>
                    </div>

                </div>{{-- end .lm-right-panel --}}
            </div>{{-- end .lm-box --}}
        </div>{{-- end .lm-overlay --}}
        @endguest

        {{-- Auto-reopen modal when admin login fails and redirects back here --}}
        @if($errors->any() && old('login_as') === 'admin')
        <script>
            document.addEventListener('alpine:initialized', function () {
                var vm = Alpine.$data(document.body);
                vm.loginTab = 'admin';
                vm.loginOpen = true;
            });
        </script>
        @endif

        {{-- ══ Scripts ══ --}}
        <script>
        // ── Smooth scroll utility ──────────────────────────────────────
        function smoothScrollTo(sectionId) {
            const el = document.getElementById(sectionId);
            if (!el) return;
            const offset = 68; // navbar height
            const top = el.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        }

        // ── Hero card live stats ───────────────────────────────────────
        (function () {
            const POLL_MS   = 10_000;
            const STATS_URL = '/public/stats';

            const STATUS_CFG = {
                upcoming: { icon: 'fa-hourglass-start', label: 'Election Soon',    hint: 'Voting has not started yet',     orbCls: 'upcoming', lblCls: 'upcoming', live: false },
                ongoing:  { icon: 'fa-circle-dot',      label: 'Election is LIVE', hint: 'Polls are open — cast your vote', orbCls: 'ongoing',  lblCls: 'ongoing',  live: true  },
                ended:    { icon: 'fa-flag-checkered',  label: 'Election Ended',   hint: 'Voting has officially closed',    orbCls: 'ended',    lblCls: 'ended',    live: false },
            };

            const $ = id => document.getElementById(id);

            const ecOrb        = $('ec-orb');
            const ecOrbIcon    = $('ec-orb-icon');
            const ecOrbLabel   = $('ec-orb-label');
            const ecOrbHint    = $('ec-orb-hint');
            const ecOrbWrap    = $('ec-orb-wrap');
            const ecName       = $('ec-election-name');
            const ecLive       = $('ec-live-strip');
            const ecVotes      = $('ec-votes');
            const ecTotal      = $('ec-total');
            const ecPart       = $('ec-part');
            const ecFill       = $('ec-fill');
            const ecPartPct    = $('ec-part-pct');
            const ecLabelDot   = $('ec-label-dot');
            const ecCdWrap     = $('ec-countdown-wrap');
            const cdDays       = $('cd-days');
            const cdHrs        = $('cd-hrs');
            const cdMins       = $('cd-mins');
            const cdSecs       = $('cd-secs');
            const navLiveBadge = $('nav-live-badge');

            // Elections section elements
            const lsVotes       = $('ls-votes');
            const lsTotal       = $('ls-total');
            const lsPct         = $('ls-pct');
            const lsFill        = $('ls-fill');
            const lsStatusIcon  = $('ls-status-icon');
            const lsStatusLabel = $('ls-elec-status-label');
            const lsStatusHint  = $('ls-elec-status-hint');
            const lsStatusVal   = $('ls-status-label');

            let prevStatus = null, prevVotes = null, countdownTimer = null, targetDate = null;

            function pad(n) { return String(n).padStart(2,'0'); }

            function tickCountdown() {
                if (!targetDate) return;
                const diff = targetDate - Date.now();
                if (diff <= 0) {
                    if (ecCdWrap)  ecCdWrap.style.display  = 'none';
                    if (ecOrbWrap) ecOrbWrap.style.display = 'flex';
                    clearInterval(countdownTimer);
                    return;
                }
                const d = Math.floor(diff / 86400000);
                const h = Math.floor((diff % 86400000) / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);
                if (cdDays) cdDays.textContent = pad(d);
                if (cdHrs)  cdHrs.textContent  = pad(h);
                if (cdMins) cdMins.textContent  = pad(m);
                if (cdSecs) cdSecs.textContent  = pad(s);
            }

            function startCountdown(isoDate) {
                clearInterval(countdownTimer);
                targetDate = new Date(isoDate).getTime();
                if (isNaN(targetDate) || targetDate <= Date.now()) { targetDate = null; return false; }
                tickCountdown();
                countdownTimer = setInterval(tickCountdown, 1000);
                return true;
            }

            function animFlash(el) {
                if (!el) return;
                el.classList.remove('ec-flash');
                void el.offsetWidth;
                el.classList.add('ec-flash');
            }

            function applyStatus(status, electionStart, electionEnd) {
                const cfg = STATUS_CFG[status] || STATUS_CFG.upcoming;
                if (ecOrb)      ecOrb.className      = 'ec-orb ' + cfg.orbCls;
                if (ecOrbIcon)  ecOrbIcon.className   = 'fas ' + cfg.icon;
                if (ecOrbLabel) { ecOrbLabel.className = 'ec-orb-label ' + cfg.lblCls; ecOrbLabel.textContent = cfg.label; }
                if (ecOrbHint)  ecOrbHint.textContent  = cfg.hint;
                if (ecLive)     ecLive.style.display   = cfg.live ? 'flex' : 'none';
                if (ecLabelDot) ecLabelDot.className   = cfg.live ? 'ec-label-dot live' : 'ec-label-dot';
                if (navLiveBadge) navLiveBadge.className = cfg.live ? 'nav-live-badge is-live' : 'nav-live-badge';

                // Elections section status
                if (lsStatusIcon)  lsStatusIcon.className   = 'fas ' + cfg.icon;
                if (lsStatusLabel) lsStatusLabel.textContent = cfg.label;
                if (lsStatusHint)  lsStatusHint.textContent  = cfg.hint;
                if (lsStatusVal)   lsStatusVal.textContent   = cfg.label;

                const cdHeaderText = document.getElementById('ec-cd-header-text');
                const cdIcon       = document.getElementById('ec-cd-icon');

                // ── UPCOMING: count down to start ──────────────────────────────
                if (status === 'upcoming' && electionStart) {
                    const shown = startCountdown(electionStart);
                    if (shown) {
                        if (cdHeaderText) cdHeaderText.textContent = 'Election Starts In';
                        if (cdIcon)       cdIcon.className         = 'fas fa-calendar-alt';
                        if (ecCdWrap)  ecCdWrap.style.display  = 'block';
                        if (ecOrbWrap) ecOrbWrap.style.display = 'none';
                        return;
                    }
                } else if (status === 'upcoming') {
                    if (cdHeaderText) cdHeaderText.textContent = 'Election Starting Soon';
                    if (cdIcon)       cdIcon.className         = 'fas fa-hourglass-start';
                    if (ecCdWrap)  ecCdWrap.style.display  = 'block';
                    if (ecOrbWrap) ecOrbWrap.style.display = 'none';
                    return;
                }

                // ── ONGOING: count down to end ─────────────────────────────────
                if (status === 'ongoing' && electionEnd) {
                    const shown = startCountdown(electionEnd);
                    if (shown) {
                        if (cdHeaderText) cdHeaderText.textContent = 'Voting Closes In';
                        if (cdIcon)       cdIcon.className         = 'fas fa-hourglass-half';
                        if (ecCdWrap)  ecCdWrap.style.display  = 'block';
                        if (ecOrbWrap) ecOrbWrap.style.display = 'none';
                        return;
                    }
                }

                // ── ENDED or no dates set ──────────────────────────────────────
                clearInterval(countdownTimer);
                if (ecCdWrap)  ecCdWrap.style.display  = 'none';
                if (ecOrbWrap) ecOrbWrap.style.display = 'flex';
                prevStatus = status;
            }

            async function fetchStats() {
                try {
                    const res  = await fetch(STATS_URL, { headers: { 'Accept': 'application/json' }, cache: 'no-store' });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();

                    if (ecName && data.election_name) ecName.textContent = data.election_name;
                    applyStatus(data.status, data.election_start, data.election_end);

                    const cast  = data.votes_cast   ?? 0;
                    const total = data.total_voters ?? 0;

                    if (cast !== prevVotes) {
                        if (ecVotes) { ecVotes.textContent = cast.toLocaleString(); animFlash(ecVotes); }
                        if (lsVotes) lsVotes.textContent = cast.toLocaleString();
                        prevVotes = cast;
                    }
                    if (ecTotal && total) ecTotal.textContent = total.toLocaleString();
                    if (lsTotal && total) lsTotal.textContent = total.toLocaleString();

                    if (total > 0) {
                        const pct = Math.min(100, Math.round((cast / total) * 100));
                        if (ecPart)    ecPart.style.display  = 'block';
                        if (ecFill)    ecFill.style.width    = pct + '%';
                        if (ecPartPct) ecPartPct.textContent = pct + '%';
                        if (lsPct)     lsPct.textContent     = pct + '%';
                        if (lsFill)    lsFill.style.width    = pct + '%';
                    }
                } catch (e) {
                    console.warn('[Stats]', e.message);
                }
            }

            fetchStats();
            setInterval(fetchStats, POLL_MS);
        })();

        // ── Contact form ───────────────────────────────────────────────
        (function () {
            const form = document.getElementById('ls-contact-form');
            const stack = document.getElementById('ls-toast-stack');
            if (!form) return;

            function toast(msg, type) {
                if (!stack) return;
                const t = document.createElement('div');
                t.className = 'ls-toast' + (type === 'error' ? ' ls-toast--error' : '');
                t.textContent = msg;
                stack.appendChild(t);
                setTimeout(() => t.remove(), 3200);
            }

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const fields = [
                    { id: 'lsf-name',    input: form.querySelector('#ls_full_name') },
                    { id: 'lsf-email',   input: form.querySelector('#ls_email') },
                    { id: 'lsf-subject', input: form.querySelector('#ls_subject') },
                    { id: 'lsf-message', input: form.querySelector('#ls_message') },
                ];
                let hasError = false;
                fields.forEach(({ id, input }) => {
                    const wrap = document.getElementById(id);
                    if (!input || !input.value.trim()) {
                        hasError = true;
                        wrap?.classList.add('ls-form-field--error');
                    } else {
                        wrap?.classList.remove('ls-form-field--error');
                    }
                });
                if (hasError) { toast('Please complete all required fields.', 'error'); return; }
                form.reset();
                toast('Message sent successfully!');
            });
        })();
        </script>

    </body>
</html>
