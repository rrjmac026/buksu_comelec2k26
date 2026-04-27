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
    </head>
    <body class="antialiased" x-data>

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
                <a href="#elections"    class="nav-link"           data-section="elections">Elections</a>
                <a href="#how-it-works" class="nav-link"           data-section="how-it-works">How It Works</a>
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
                    <a href="{{ route('login') }}" class="nav-cta-btn">
                        <i class="fas fa-right-to-bracket"></i> <span>Login</span>
                    </a>
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
                <a href="#elections"    class="mobile-nav-link" data-section="elections">
                    <i class="fas fa-vote-yea"></i> Elections
                </a>
                <a href="#how-it-works" class="mobile-nav-link" data-section="how-it-works">
                    <i class="fas fa-circle-question"></i> How It Works
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
                    <a href="{{ route('login') }}" class="mobile-nav-cta">
                        <i class="fas fa-right-to-bracket"></i> Login
                    </a>
                @endauth
            </div>
        </div>
        @endif

        {{-- ══ PAGE BODY ══ --}}
        <div class="page-body">

            {{-- ════════════════════════════════════════════
                 HOME SECTION
            ════════════════════════════════════════════ --}}
            <section id="home" class="section-scroll-target">
                <div class="outer">
                    <div class="grid-bg"></div>
                    <div class="grid-dots"></div>

                    <div class="hero-layout">

                        {{-- LEFT: Hero text --}}
                        <div class="hero-left">
                            <div class="eyebrow">
                                <i class="fas fa-shield-halved" style="font-size:0.6rem"></i>
                                Trusted Online Voting Platform
                            </div>

                            <h1 class="hero-h1">
                                Your Vote<br>
                                <span class="h1-accent">Matters</span>
                            </h1>

                            <p class="hero-lead">
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
                                    <a href="{{ route('login') }}" class="btn-primary">
                                        Vote Now <i class="fas fa-arrow-right"></i>
                                    </a>
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
                                <img src="{{ asset('center.png') }}" alt="Voting ballot box visual" class="centerpiece-img">
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
                                        <i class="fas fa-calendar-alt"></i>
                                        Election Starts In
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
                                <a href="#elections" class="ec-details-link" onclick="smoothScrollTo('elections'); return false;">
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
            <section id="about" class="landing-section section-scroll-target">
                <div class="ls-inner">

                    <header class="ls-header ls-reveal">
                        <span class="ls-tag"><i class="fas fa-shield-halved"></i> About the System</span>
                        <h2 class="ls-title">Secure Elections for <span class="h1-accent">Every Student</span></h2>
                        <p class="ls-subtitle">Built on transparency, powered by technology — ensuring every vote is fair, private, and counted.</p>
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

                    {{-- Team Section --}}
                    @php
                        $developmentTeam = [
                            [
                                'name'        => 'Rey Rameses Jude "Jam" Macalutas III',
                                'role'        => 'System Developer / Lead Developer',
                                'initials'    => 'JM',
                                'avatar'      => asset('assets/team/dev1.png'),
                                'description' => 'Leads system architecture and ensures secure, smooth platform performance.',
                            ],
                            [
                                'name'        => 'Khyle Ivan Khim V. Amacna',
                                'role'        => 'Head System Developer',
                                'avatar'      => asset('assets/team/dev2.jpg'),
                                'initials'    => 'KA',
                                'description' => 'Directs technical execution, aligning development tasks with project goals.',
                            ],
                            [
                                'name'        => 'Bernardo DeLa Cerna Jr.',
                                'role'        => 'System Developer / QA',
                                'avatar'      => asset('assets/team/locked.png'),
                                'initials'    => 'BC',
                                'description' => 'Handles quality assurance and testing to maintain reliability and trust.',
                            ],
                        ];

                        $commissionTeam = [
                            ['name' => 'Mark Ian Mukara',       'role' => 'Adviser',                          'initials' => 'MM', 'avatar' => asset('assets/team/6.png'),      'description' => 'Provides strategic guidance to keep election operations aligned and effective.'],
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
                    @endphp

                    <div class="team-section-inner ls-reveal">

                        <div class="team-header-wrap">
                            <p class="team-section-tag">MEET THE TEAM</p>
                            <h2 class="team-heading">The Minds Behind the System</h2>
                            <p class="team-subtext">Dedicated developers and commission members building a secure and transparent voting platform.</p>
                            <span class="team-header-divider" aria-hidden="true"></span>
                        </div>

                        <div class="team-group">
                            <div class="team-mid-divider team-mid-divider--top" aria-hidden="true">
                                <span class="team-mid-line"></span>
                                <span class="team-mid-label"><i class="fas fa-code"></i> Development Team</span>
                                <span class="team-mid-line"></span>
                            </div>
                            <div class="team-cards-grid team-cards-grid--development">
                                @foreach ($developmentTeam as $member)
                                    <article class="team-card team-card-animate">
                                        <div class="tc-image-wrap">
                                            <img src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}" class="tc-image"
                                                onerror="this.style.display='none'; this.parentElement.querySelector('.tc-av-fallback').style.display='flex';">
                                            <div class="tc-image-overlay"></div>
                                            <div class="tc-av-fallback" style="display:none;">{{ $member['initials'] }}</div>
                                        </div>
                                        <div class="tc-content">
                                            <h4 class="tc-name">{{ $member['name'] }}</h4>
                                            <p class="tc-role">{{ $member['role'] }}</p>
                                            <p class="tc-description">{{ $member['description'] }}</p>
                                            <div class="tc-socials">
                                                <a href="#" class="tc-social" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                                <a href="#" class="tc-social" aria-label="Email"><i class="fas fa-envelope"></i></a>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <div class="team-mid-divider" aria-hidden="true">
                            <span class="team-mid-line"></span>
                            <span class="team-mid-label"><i class="fas fa-shield-halved"></i> COMELEC Commission Team</span>
                            <span class="team-mid-line"></span>
                        </div>

                        <div class="team-group">
                            <div class="team-cards-grid">
                                @foreach ($commissionTeam as $member)
                                    <article class="team-card team-card-animate">
                                        <div class="tc-image-wrap">
                                            <img src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}" class="tc-image"
                                                onerror="this.style.display='none'; this.parentElement.querySelector('.tc-av-fallback').style.display='flex';">
                                            <div class="tc-image-overlay"></div>
                                            <div class="tc-av-fallback" style="display:none;">{{ $member['initials'] }}</div>
                                        </div>
                                        <div class="tc-content">
                                            <h4 class="tc-name">{{ $member['name'] }}</h4>
                                            <p class="tc-role">{{ $member['role'] }}</p>
                                            <p class="tc-description">{{ $member['description'] }}</p>
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
            </section>{{-- end #about --}}


            {{-- ════════════════════════════════════════════
                 ELECTIONS SECTION
            ════════════════════════════════════════════ --}}
            <section id="elections" class="landing-section section-scroll-target ls-alt-bg">
                <div class="ls-inner">

                    <header class="ls-header ls-reveal">
                        <span class="ls-tag"><i class="fas fa-vote-yea"></i> Elections</span>
                        <h2 class="ls-title">Student Government <span class="h1-accent">Elections</span></h2>
                        <p class="ls-subtitle">Participate in secure, transparent, and reliable digital elections designed for every BukSU student.</p>
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
                                    <a href="{{ route('login') }}" class="btn-primary" id="ls-vote-btn" title="Login to vote">Vote Now</a>
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

                            <a href="{{ route('login') }}" class="btn-primary" style="display:inline-block;margin-top:20px;text-decoration:none;">
                                View Election Details <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </section>{{-- end #elections --}}


            {{-- ════════════════════════════════════════════
                 HOW IT WORKS SECTION
            ════════════════════════════════════════════ --}}
            <section id="how-it-works" class="landing-section section-scroll-target">
                <div class="ls-inner">

                    <header class="ls-header ls-reveal">
                        <span class="ls-tag"><i class="fas fa-circle-question"></i> How It Works</span>
                        <h2 class="ls-title">Simple Steps to <span class="h1-accent">Cast Your Vote</span></h2>
                        <p class="ls-subtitle">A straightforward, secure voting process designed to be completed in minutes.</p>
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
                 CONTACT SECTION
            ════════════════════════════════════════════ --}}
            <section id="contact" class="landing-section section-scroll-target ls-alt-bg">
                <div class="ls-inner">

                    <header class="ls-header ls-reveal">
                        <span class="ls-tag"><i class="fas fa-envelope"></i> Contact</span>
                        <h2 class="ls-title">Get in <span class="h1-accent">Touch</span></h2>
                        <p class="ls-subtitle">We're here to assist you with any concerns about the election or the system.</p>
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
                    <a href="#elections"    onclick="smoothScrollTo('elections');return false;">Elections</a>
                    <a href="#how-it-works" onclick="smoothScrollTo('how-it-works');return false;">How It Works</a>
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

            function applyStatus(status, electionStart) {
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

                if (status === 'upcoming' && electionStart) {
                    const shown = startCountdown(electionStart);
                    if (shown) {
                        if (ecCdWrap)  ecCdWrap.style.display  = 'block';
                        if (ecOrbWrap) ecOrbWrap.style.display = 'none';
                        return;
                    }
                } else {
                    clearInterval(countdownTimer);
                }
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
                    applyStatus(data.status, data.election_start);

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
