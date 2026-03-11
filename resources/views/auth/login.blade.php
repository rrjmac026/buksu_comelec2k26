<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — {{ config('app.name', 'Voting System') }}</title>
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

        /* Welcome page light overrides */
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

        /* Login page light overrides */
        html:not(.dark) .login-form-side {
            background: rgba(255, 250, 245, 0.97);
            border-left-color: rgba(180, 100, 0, 0.15);
        }

        html:not(.dark) .form-heading { color: var(--violet); }
        html:not(.dark) .form-subtext { color: rgba(30, 0, 40, 0.55); }
        html:not(.dark) .field-label { color: rgba(30, 0, 40, 0.75); }

        html:not(.dark) .field-input {
            background: rgba(245, 235, 255, 0.8);
            border-color: rgba(180, 100, 0, 0.2);
            color: var(--ink);
        }
        html:not(.dark) .field-input:focus {
            background: #fff;
            border-color: var(--gold-dk);
        }

        html:not(.dark) .role-toggle {
            background: rgba(245, 235, 255, 0.8);
            border-color: rgba(180, 100, 0, 0.18);
        }

        html:not(.dark) .login-side {
            background: linear-gradient(160deg, #e8d0f0 0%, #d4b8e8 55%, #c4a0d8 100%);
        }

        html:not(.dark) footer {
            background: rgba(245, 235, 255, 0.95);
            border-top-color: rgba(180, 100, 0, 0.15);
        }
        html:not(.dark) footer p { color: rgba(30, 0, 40, 0.45); }

        body {
            background: var(--violet-xl);
            background-image:
                radial-gradient(ellipse 90% 70% at 0% 0%, rgba(56,0,65,0.95) 0%, transparent 55%),
                radial-gradient(ellipse 70% 60% at 100% 100%, rgba(82,0,96,0.7) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(249,180,15,0.03) 0%, transparent 70%);
            color: var(--cream);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* ── Noise ── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size: 200px 200px;
        }

        /* ── Google OAuth Button ── */
        .google-login-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.25rem;
            margin-top: 2rem;
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.85rem 1.5rem;
            background: #fff;
            color: #3c4043;
            font-size: 0.95rem;
            font-weight: 600;
            border: 1.5px solid #dadce0;
            border-radius: 0.6rem;
            text-decoration: none;
            transition: box-shadow 0.2s ease, background 0.2s ease;
            cursor: pointer;
        }

        .google-btn:hover {
            background: #f8f9fa;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
            border-color: #bbb;
        }

        .google-btn:active {
            background: #f1f3f4;
        }

        .google-icon {
            width: 1.3rem;
            height: 1.3rem;
            flex-shrink: 0;
        }

        .google-hint {
            font-size: 0.78rem;
            color: #9ca3af;
            text-align: center;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .google-hint i {
            color: #6b7280;
        }

        .grid-lines {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(249,180,15,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(249,180,15,0.035) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* ── Orbs ── */
        .orb {
            position: fixed; border-radius: 50%; pointer-events: none; z-index: 0;
            filter: blur(80px); opacity: 0.55;
        }
        .orb-1 { width: 600px; height: 600px; top: -200px; left: -150px; background: radial-gradient(circle, rgba(56,0,65,0.8), rgba(82,0,96,0.4), transparent 70%); animation: orb1 18s ease-in-out infinite alternate; }
        .orb-2 { width: 500px; height: 500px; bottom: -150px; right: -100px; background: radial-gradient(circle, rgba(249,180,15,0.12), rgba(82,0,96,0.3), transparent 70%); animation: orb2 22s ease-in-out infinite alternate; }
        @keyframes orb1 { from{transform:translate(0,0)} to{transform:translate(50px,40px)} }
        @keyframes orb2 { from{transform:translate(0,0)} to{transform:translate(-40px,-50px)} }

        /* ── Nav ── */
        nav.top-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 50;
            height: 70px;
            display: flex; align-items: center;
            padding: 0 40px;
            background: rgba(26,0,32,0.9);
            backdrop-filter: blur(24px) saturate(1.6);
            border-bottom: 1px solid rgba(249,180,15,0.18);
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
            font-size: 1.15rem; font-weight: 700;
            color: var(--cream);
        }
        .nav-app-name .accent { color: var(--gold); }

        .btn-nav-ghost {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 20px; border-radius: 8px;
            font-size: 0.82rem; font-weight: 600; text-decoration: none; letter-spacing: 0.02em;
            color: var(--gold) !important;
            background: transparent;
            border: 1.5px solid rgba(249,180,15,0.3);
            transition: all 0.22s;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-nav-ghost:hover {
            background: rgba(249,180,15,0.08);
            border-color: var(--gold);
            box-shadow: 0 0 16px rgba(249,180,15,0.15);
        }

        /* ── Page layout ── */
        .page-wrap {
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding: 100px 24px 48px;
            position: relative; z-index: 1;
        }

        /* ── Login container ── */
        .login-container {
            width: 100%; max-width: 980px;
            display: grid; grid-template-columns: 1fr 1fr;
            border-radius: 20px; overflow: hidden;
            box-shadow: 0 32px 100px rgba(0,0,0,0.6), 0 0 0 1px rgba(249,180,15,0.15);
            animation: fadeup 0.65s ease forwards;
        }

        @media (max-width: 768px) {
            .login-container { grid-template-columns: 1fr; max-width: 480px; }
            .login-side { display: none; }
        }

        /* ── Left decorative side ── */
        .login-side {
            background: linear-gradient(160deg, var(--violet) 0%, var(--violet-xl) 55%, #0d0015 100%);
            padding: 52px 40px;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .login-side::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 15%, rgba(249,180,15,0.08), transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 85%, rgba(82,0,96,0.6), transparent 55%);
            pointer-events: none;
        }
        /* Diagonal gold accent line */
        .login-side::after {
            content: '';
            position: absolute; top: 0; right: 0;
            width: 1px; height: 100%;
            background: linear-gradient(180deg, transparent, rgba(249,180,15,0.4), rgba(249,180,15,0.2), transparent);
        }
        .side-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(249,180,15,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(249,180,15,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .side-top { position: relative; z-index: 1; }
        .side-logo-wrap { display: flex; align-items: center; gap: 13px; margin-bottom: 44px; }
        .side-logo-img {
            width: 50px; height: 50px; border-radius: 12px; object-fit: cover;
            border: 2px solid rgba(249,180,15,0.35);
            box-shadow: 0 0 20px rgba(249,180,15,0.15);
        }
        .side-app-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 700; color: var(--cream);
        }
        .side-app-name span { color: var(--gold); }

        .side-gold-rule { width: 48px; height: 3px; border-radius: 2px; background: linear-gradient(90deg, var(--gold), var(--gold-lt)); margin-bottom: 20px; }

        .side-headline {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem; font-weight: 900; color: var(--cream);
            line-height: 1.15; letter-spacing: -0.01em; margin-bottom: 14px;
        }
        .side-headline .hl-accent {
            background: linear-gradient(105deg, var(--gold), var(--gold-lt));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .side-lead {
            font-size: 0.87rem; color: rgba(255,251,240,0.6); line-height: 1.75; margin-bottom: 32px;
            font-weight: 300;
        }

        .side-features { display: flex; flex-direction: column; gap: 12px; }
        .side-feat {
            display: flex; align-items: flex-start; gap: 13px;
            padding: 14px 16px;
            background: rgba(249,180,15,0.05);
            border: 1px solid rgba(249,180,15,0.12);
            border-radius: 12px;
            transition: all 0.22s;
        }
        .side-feat:hover { background: rgba(249,180,15,0.1); transform: translateX(4px); border-color: rgba(249,180,15,0.25); }
        .side-feat-icon {
            width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--gold), var(--gold-lt));
            display: flex; align-items: center; justify-content: center;
            color: var(--violet); font-size: 0.82rem;
            box-shadow: 0 2px 12px rgba(249,180,15,0.3);
        }
        .side-feat-title { font-size: 0.8rem; font-weight: 700; color: var(--gold-lt); margin-bottom: 2px; }
        .side-feat-desc { font-size: 0.72rem; color: rgba(255,251,240,0.55); line-height: 1.5; }

        .side-bottom { position: relative; z-index: 1; }
        .side-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 32px; }
        .side-stat {
            background: rgba(249,180,15,0.06);
            border: 1px solid rgba(249,180,15,0.14);
            border-radius: 10px; padding: 14px 10px; text-align: center;
            transition: all 0.22s;
        }
        .side-stat:hover { background: rgba(249,180,15,0.12); }
        .side-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem; font-weight: 800; color: var(--gold);
        }
        .side-stat-lbl { font-size: 0.6rem; color: rgba(249,180,15,0.55); font-weight: 600; letter-spacing: 0.07em; text-transform: uppercase; margin-top: 2px; }

        /* ── Right form side ── */
        .login-form-side {
            background: rgba(26,0,32,0.95);
            backdrop-filter: blur(24px);
            padding: 52px 48px;
            display: flex; flex-direction: column; justify-content: center;
            border-left: 1px solid rgba(249,180,15,0.12);
        }

        /* ── Role Toggle ── */
        .role-toggle {
            display: flex;
            background: rgba(56,0,65,0.8);
            border: 1px solid rgba(249,180,15,0.18);
            border-radius: 12px;
            padding: 5px; gap: 5px;
            margin-bottom: 30px;
        }
        .role-btn {
            flex: 1; padding: 9px 14px;
            border: none; cursor: pointer;
            border-radius: 8px;
            font-size: 0.8rem; font-weight: 700; letter-spacing: 0.02em;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            transition: all 0.22s;
            background: transparent;
            color: rgba(249,180,15,0.6);
            font-family: 'DM Sans', sans-serif;
        }
        .role-btn.active {
            background: linear-gradient(135deg, var(--gold), var(--gold-lt));
            color: var(--violet);
            box-shadow: 0 4px 18px rgba(249,180,15,0.3);
        }
        .role-btn:hover:not(.active) {
            background: rgba(249,180,15,0.08);
            color: var(--gold);
        }

        /* ── Form header ── */
        .gold-rule-sm { width: 40px; height: 2px; border-radius: 2px; background: linear-gradient(90deg, var(--gold), var(--gold-lt)); margin-bottom: 14px; }

        .form-eyebrow {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 4px 12px; border-radius: 4px; margin-bottom: 10px;
            background: rgba(249,180,15,0.1);
            border: 1px solid rgba(249,180,15,0.25);
            font-size: 0.63rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--gold);
        }
        .eyebrow-dot {
            width: 5px; height: 5px; border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 6px rgba(249,180,15,0.8);
            animation: epulse 2s ease-in-out infinite;
        }
        @keyframes epulse { 0%,100%{box-shadow:0 0 5px rgba(249,180,15,0.5)} 50%{box-shadow:0 0 14px rgba(249,180,15,1)} }

        .form-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; font-weight: 900;
            letter-spacing: -0.01em; margin: 0 0 6px;
            color: var(--cream);
        }
        .form-heading .h-accent {
            background: linear-gradient(105deg, var(--gold), var(--gold-lt));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .form-subtext { font-size: 0.82rem; color: rgba(255,251,240,0.5); margin-bottom: 26px; font-weight: 300; }

        /* ── Admin badge ── */
        .admin-badge {
            display: none; align-items: center; gap: 10px;
            padding: 11px 14px;
            background: rgba(249,180,15,0.07);
            border: 1px solid rgba(249,180,15,0.25);
            border-radius: 10px; margin-bottom: 20px;
            font-size: 0.78rem; font-weight: 600; color: var(--gold-lt);
        }
        .admin-badge.visible { display: flex; }
        .admin-badge-icon {
            width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--gold), var(--gold-lt));
            display: flex; align-items: center; justify-content: center;
            color: var(--violet); font-size: 0.78rem;
        }

        /* ── Form fields ── */
        .field-group { margin-bottom: 18px; }
        .field-label {
            display: block; font-size: 0.76rem; font-weight: 700;
            color: rgba(255,251,240,0.8); margin-bottom: 7px; letter-spacing: 0.03em; text-transform: uppercase;
        }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: rgba(249,180,15,0.4); font-size: 0.82rem; pointer-events: none;
            transition: color 0.2s;
        }
        .field-input {
            width: 100%; padding: 12px 14px 12px 40px;
            border-radius: 10px;
            border: 1.5px solid rgba(249,180,15,0.15);
            background: rgba(56,0,65,0.5);
            color: var(--cream);
            font-size: 0.875rem; font-family: 'DM Sans', sans-serif;
            transition: all 0.2s; outline: none;
        }
        .field-input::placeholder { color: rgba(255,251,240,0.25); }
        .field-input:focus {
            border-color: rgba(249,180,15,0.6);
            background: rgba(56,0,65,0.8);
            box-shadow: 0 0 0 3px rgba(249,180,15,0.08), 0 2px 16px rgba(249,180,15,0.07);
        }
        .field-input:focus ~ .input-icon,
        .input-wrap:focus-within .input-icon { color: var(--gold); }

        /* Error */
        .field-error { font-size: 0.72rem; color: #f87171; margin-top: 5px; display: flex; align-items: center; gap: 5px; }

        /* ── Remember + Forgot ── */
        .form-row-mid {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 22px;
        }
        .remember-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.78rem; color: rgba(255,251,240,0.5); cursor: pointer;
        }
        .remember-cb {
            width: 16px; height: 16px;
            accent-color: var(--gold); cursor: pointer;
        }
        .forgot-link {
            font-size: 0.78rem; font-weight: 600; text-decoration: none;
            color: var(--gold);
            transition: all 0.2s; opacity: 0.75;
        }
        .forgot-link:hover { opacity: 1; text-decoration: underline; }

        /* ── Submit button ── */
        .submit-btn {
            width: 100%; padding: 13px 20px;
            border: none; border-radius: 10px; cursor: pointer;
            font-size: 0.88rem; font-weight: 700; letter-spacing: 0.03em;
            color: var(--violet);
            background: linear-gradient(135deg, var(--gold), var(--gold-lt));
            box-shadow: 0 4px 24px rgba(249,180,15,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center; gap: 9px;
            transition: all 0.22s; font-family: 'DM Sans', sans-serif;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(249,180,15,0.45);
        }
        .submit-btn:active { transform: translateY(0); }

        /* Admin submit variant */
        .submit-btn.admin-mode {
            background: linear-gradient(135deg, var(--gold-dk), var(--gold));
        }

        /* ── Back link ── */
        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.78rem; font-weight: 600; text-decoration: none;
            color: rgba(249,180,15,0.5); margin-top: 18px;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--gold); }

        /* ── Session status ── */
        .session-status {
            padding: 10px 14px; border-radius: 8px; margin-bottom: 16px;
            font-size: 0.8rem; font-weight: 600;
            background: rgba(249,180,15,0.1);
            border: 1px solid rgba(249,180,15,0.25);
            color: var(--gold-lt);
        }

        /* ── Animations ── */
        @keyframes fadeup { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:translateY(0)} }
        .form-panel { transition: opacity 0.22s ease; }
        .form-panel.hidden { display: none; }

        /* Footer */
        footer {
            position: relative; z-index: 1;
            background: rgba(26,0,32,0.95);
            border-top: 1px solid rgba(249,180,15,0.12);
        }
        footer p { color: rgba(255,251,240,0.35); font-size: 0.8rem; margin: 0; }
        .footer-accent { color: var(--gold); font-weight: 700; }
    </style>
</head>
<body class="antialiased" x-data>

    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="grid-lines"></div>

    {{-- ── Navigation ── --}}
    <nav class="top-nav">
        <a href="/" class="nav-logo">
            <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" />
            <span class="nav-app-name">
                {{ config('app.name', 'BukSU') }} <span class="accent">System</span>
            </span>
        </a>
        <a href="/" class="btn-nav-ghost">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </nav>

    {{-- ── Main ── --}}
    <div class="page-wrap">
        <div class="login-container">

            {{-- ── Left side ── --}}
            <div class="login-side">
                <div class="side-grid"></div>

                <div class="side-top">
                    <div class="side-logo-wrap">
                        <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" class="side-logo-img">
                        <span class="side-app-name">{{ config('app.name', 'BukSU') }} <span>System</span></span>
                    </div>

                    <div class="side-gold-rule"></div>
                    <h2 class="side-headline">
                        Your Vote <span class="hl-accent">Shapes</span><br>the Future
                    </h2>
                    <p class="side-lead">
                        Secure, transparent, and fair — every voice counts in our digital democracy platform.
                    </p>

                    <div class="side-features">
                        <div class="side-feat">
                            <div class="side-feat-icon"><i class="fas fa-shield-alt"></i></div>
                            <div>
                                <div class="side-feat-title">End-to-End Encrypted</div>
                                <div class="side-feat-desc">Your ballot is secured with SHA-256 hashing and unique transaction numbers.</div>
                            </div>
                        </div>
                        <div class="side-feat">
                            <div class="side-feat-icon"><i class="fas fa-chart-bar"></i></div>
                            <div>
                                <div class="side-feat-title">Live Results</div>
                                <div class="side-feat-desc">Real-time vote tallying with transparent, verifiable outcomes.</div>
                            </div>
                        </div>
                        <div class="side-feat">
                            <div class="side-feat-icon"><i class="fas fa-user-secret"></i></div>
                            <div>
                                <div class="side-feat-title">Anonymous Ballots</div>
                                <div class="side-feat-desc">Your identity is protected — only your vote is recorded.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="side-bottom">
                </div>
            </div>

            {{-- ── Right form side ── --}}
            <div class="login-form-side">

                @if (session('status'))
                    <div class="session-status">
                        <i class="fas fa-circle-check" style="margin-right:6px;"></i>
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Role Toggle --}}
                <div class="role-toggle" role="tablist">
                    <button class="role-btn active" id="tab-voter" role="tab" aria-selected="true" onclick="switchRole('voter')" type="button">
                        <i class="fas fa-vote-yea"></i> Voter Login
                    </button>
                    <button class="role-btn" id="tab-admin" role="tab" aria-selected="false" onclick="switchRole('admin')" type="button">
                        <i class="fas fa-shield-halved"></i> Admin Login
                    </button>
                </div>

                {{-- ── VOTER PANEL ── --}}
                <div class="form-panel" id="panel-voter">
                    <div class="form-eyebrow">
                        <div class="eyebrow-dot"></div> Voter Portal
                    </div>
                    <h1 class="form-heading">Welcome <span class="h-accent">Back</span></h1>
                    <p class="form-subtext">Sign in with your Google account to cast your vote and view election results.</p>

                    {{-- Session errors (e.g. inactive account, admin tried Google login) --}}
                    @if (session('error'))
                        <div class="field-error" style="margin-bottom: 1rem;">
                            <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="google-login-wrapper">
                        <a href="{{ route('auth.google') }}" class="google-btn">
                            <svg class="google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span>Continue with Google</span>
                        </a>

                        <p class="google-hint">
                            <i class="fas fa-shield-halved"></i>
                            Only registered student accounts are allowed to vote.
                        </p>
                    </div>
                </div>

                {{-- ── ADMIN PANEL ── --}}
                <div class="form-panel hidden" id="panel-admin">
                    <div class="form-eyebrow" style="background:rgba(249,180,15,0.06);border-color:rgba(249,180,15,0.2);">
                        <div class="eyebrow-dot"></div> Admin Portal
                    </div>
                    <h1 class="form-heading">Admin <span class="h-accent">Access</span></h1>
                    <p class="form-subtext">Restricted area — authorized administrators only.</p>

                    <div class="admin-badge visible">
                        <div class="admin-badge-icon"><i class="fas fa-shield-halved"></i></div>
                        <div><strong>Secure Admin Login</strong> — All access is logged and monitored.</div>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="hidden" name="login_as" value="admin">

                        <div class="field-group">
                            <label class="field-label" for="admin_email">Admin Email</label>
                            <div class="input-wrap">
                                <i class="fas fa-id-badge input-icon"></i>
                                <input id="admin_email" name="email" type="email" class="field-input"
                                    placeholder="admin@domain.com" value="{{ old('email') }}"
                                    required autocomplete="username" />
                            </div>
                            @error('email')
                                <div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="admin_password">Admin Password</label>
                            <div class="input-wrap">
                                <i class="fas fa-key input-icon"></i>
                                <input id="admin_password" name="password" type="password" class="field-input"
                                    placeholder="••••••••" required autocomplete="current-password" />
                            </div>
                            @error('password')
                                <div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row-mid">
                            <label class="remember-label">
                                <input type="checkbox" name="remember" class="remember-cb"> Remember me
                            </label>
                        </div>

                        <button type="submit" class="submit-btn admin-mode">
                            <i class="fas fa-shield-halved"></i> Sign In as Admin
                        </button>
                    </form>
                </div>

                <a href="/" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>

            </div>

        </div>
    </div>

    {{-- Footer --}}
    <footer>
        <div style="max-width:1220px;margin:0 auto;padding:16px 40px;text-align:center;">
            <p>
                © {{ date('Y') }} <span class="footer-accent">{{ config('app.name', 'Voting System') }}.</span>
                All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        function switchRole(role) {
            const voterTab   = document.getElementById('tab-voter');
            const adminTab   = document.getElementById('tab-admin');
            const voterPanel = document.getElementById('panel-voter');
            const adminPanel = document.getElementById('panel-admin');

            if (role === 'voter') {
                voterTab.classList.add('active');    adminTab.classList.remove('active');
                voterPanel.classList.remove('hidden'); adminPanel.classList.add('hidden');
                voterTab.setAttribute('aria-selected', 'true');
                adminTab.setAttribute('aria-selected', 'false');
            } else {
                adminTab.classList.add('active');    voterTab.classList.remove('active');
                adminPanel.classList.remove('hidden'); voterPanel.classList.add('hidden');
                adminTab.setAttribute('aria-selected', 'true');
                voterTab.setAttribute('aria-selected', 'false');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            if ("{{ old('login_as') }}" === 'admin') switchRole('admin');
        });
    </script>
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
</script>

</body>
</html>