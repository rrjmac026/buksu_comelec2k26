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
        <nav class="site-nav">
            <a href="/" class="nav-brand">
                <img src="{{ asset('assets/app_logo.png') }}" class="nav-logo" alt="{{ config('app.name') }}">
                <div class="nav-name-block">
                    <span class="nav-name">BukSU COMELEC</span>
                    <span class="nav-tagline">Online Voting System</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link is-active">Home</a>
                <a href="{{ route('public.about') }}" class="nav-link">About</a>
                <a href="{{ route('public.elections') }}" class="nav-link">Elections</a>
                <a href="{{ route('public.how-it-works') }}" class="nav-link">How It Works</a>
                <a href="{{ route('public.contact') }}" class="nav-link">Contact</a>
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
            </div>
        </nav>
        @endif

        {{-- ══ PAGE BODY ══ --}}
        <div class="page-body">

            {{-- ── HERO SECTION ── --}}
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
                            <a href="#about" class="btn-secondary">
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

                            {{-- Countdown timer (upcoming + start date) --}}
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

                            {{-- Status orb (shown when no countdown / ongoing / ended) --}}
                            <div class="ec-orb-wrap" id="ec-orb-wrap">
                                <div class="ec-orb upcoming" id="ec-orb">
                                    <i class="fas fa-hourglass-start" id="ec-orb-icon"></i>
                                </div>
                                <div class="ec-orb-label upcoming" id="ec-orb-label">Election Soon</div>
                                <div class="ec-orb-hint" id="ec-orb-hint">Voting has not started yet</div>
                            </div>

                            {{-- Two-column stats --}}
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

                            {{-- View details link --}}
                            <a href="{{ route('login') }}" class="ec-details-link">
                                View Election Details
                                <i class="fas fa-arrow-right"></i>
                            </a>

                        </div>
                    </div>

                </div>{{-- end .hero-layout --}}
            </div>{{-- end .outer --}}

            {{-- ── TEAM SECTION ── --}}
            <section class="team-section" id="about">
                <div class="team-section-inner">

                    <div class="team-header-wrap">
                        <p class="team-section-tag">MEET THE TEAM</p>
                        <h2 class="team-heading">The Minds Behind the System</h2>
                        <p class="team-subtext">Dedicated developers and commission members building a secure and transparent voting platform.</p>
                        <span class="team-header-divider" aria-hidden="true"></span>
                    </div>

                    @php
                        $developmentTeam = [
                            [
                                'name' => 'Rey Rameses Jude "Jam" Macalutas III',
                                'role' => 'System Developer / Lead Developer',
                                'initials' => 'JM',
                                'avatar' => asset('assets/team/dev1.png'),
                                'description' => 'Leads system architecture and ensures secure, smooth platform performance.',
                                'facebook' => null,
                                'email' => null,
                            ],
                            [
                                'name' => 'Khyle Ivan Khim V. Amacna',
                                'role' => 'Head System Developer',
                                'avatar' => asset('assets/team/dev2.jpg'),
                                'initials' => 'KA',
                                'description' => 'Directs technical execution, aligning development tasks with project goals.',
                                'facebook' => null,
                                'email' => null,
                            ],
                            [
                                'name' => 'Bernardo DeLa Cerna Jr.',
                                'role' => 'System Developer / QA',
                                'avatar' => asset('assets/team/locked.png'),
                                'initials' => 'BC',
                                'description' => 'Handles quality assurance and testing to maintain reliability and trust.',
                                'facebook' => null,
                                'email' => null,
                            ],
                        ];

                        $commissionTeam = [
                            [
                                'name' => 'Mark Ian Mukara',
                                'role' => 'Adviser',
                                'initials' => 'MM',
                                'avatar' => asset('assets/team/6.png'),
                                'description' => 'Provides strategic guidance to keep election operations aligned and effective.',
                            ],
                            [
                                'name' => 'Roxanne Mae Ortega',
                                'role' => 'Head Commissioner',
                                'initials' => 'RO',
                                'avatar' => asset('assets/team/5.png'),
                                'description' => 'Leads commission execution and ensures every election process is on track.',
                            ],
                            [
                                'name' => 'Yassin Naga',
                                'role' => 'Internal Commissioner',
                                'initials' => 'YN',
                                'avatar' => asset('assets/team/2.png'),
                                'description' => 'Coordinates internal workflows and keeps team communication streamlined.',
                            ],
                            [
                                'name' => 'Steven Bagasbas',
                                'role' => 'External Commissioner',
                                'initials' => 'SB',
                                'avatar' => asset('assets/team/locked.png'),
                                'description' => 'Handles external coordination and supports clear public-facing communication.',
                            ],
                            [
                                'name' => 'Khisia Faith Llanera',
                                'role' => 'Logistics Commissioner',
                                'initials' => 'KL',
                                'avatar' => asset('assets/team/locked.png'),
                                'description' => 'Manages logistics and ensures election resources are prepared on time.',
                            ],
                            [
                                'name' => 'Elaine Mae Furog',
                                'role' => 'Canvass Commissioner',
                                'initials' => 'EF',
                                'avatar' => asset('assets/team/locked.png'),
                                'description' => 'Supports vote canvassing with a focus on accuracy and transparency.',
                            ],
                            [
                                'name' => 'Rhoda Princess Diones',
                                'role' => 'Campaign Commissioner',
                                'initials' => 'RD',
                                'avatar' => asset('assets/team/locked.png'),
                                'description' => 'Oversees campaign activities and enforces fair election participation.',
                            ],
                            [
                                'name' => 'Marian Gewan',
                                'role' => 'Creatives Commissioner',
                                'initials' => 'MG',
                                'avatar' => asset('assets/team/locked.png'),
                                'description' => 'Leads creative outputs that keep election communications clear and cohesive.',
                            ],
                            [
                                'name' => 'Axiel Ivan Pacquiao',
                                'role' => 'Local Commissioner on Campaign',
                                'initials' => 'AP',
                                'avatar' => asset('assets/team/4.png'),
                                'description' => 'Coordinates local campaign initiatives and supports outreach consistency.',
                            ],
                            [
                                'name' => 'Kurt Kein Daguyo',
                                'role' => 'Local Commissioner on Campaign',
                                'initials' => 'KD',
                                'avatar' => asset('assets/team/locked.png'),
                                'description' => 'Supports local campaign planning and helps maintain compliance standards.',
                            ],
                            [
                                'name' => 'Owen Jerusalem',
                                'role' => 'Local Commissioner on Creatives',
                                'initials' => 'OJ',
                                'avatar' => asset('assets/team/3.png'),
                                'description' => 'Contributes creative assets for local campaigns with consistent branding.',
                            ],
                            [
                                'name' => 'Gerardo Aranas Jr',
                                'role' => 'Local Commissioner on Creatives',
                                'initials' => 'GA',
                                'avatar' => asset('assets/team/locked.png'),
                                'description' => 'Supports design production for local initiatives and campaign visuals.',
                            ],
                        ];
                    @endphp

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
            </section>

        </div>{{-- end .page-body --}}

        <footer class="site-footer">
            <div class="footer-inner">
                <div class="footer-left">
                    <i class="fas fa-shield-halved footer-shield"></i>
                    &copy; {{ date('Y') }} <strong>{{ config('app.name', 'BukSU COMELEC') }}.</strong> All rights reserved.
                </div>
                <div class="footer-right">
                    Built for secure and transparent student elections.
                    <i class="fas fa-heart footer-heart"></i>
                </div>
            </div>
        </footer>

        {{-- ══ Live Stats + Countdown Script ══ --}}
        <script>
        (function () {
            const POLL_MS   = 10_000;
            const STATS_URL = '/public/stats';

            const STATUS_CFG = {
                upcoming: { icon: 'fa-hourglass-start', label: 'Election Soon',      hint: 'Voting has not started yet',          orbCls: 'upcoming', lblCls: 'upcoming', live: false },
                ongoing:  { icon: 'fa-circle-dot',      label: 'Election is LIVE',   hint: 'Polls are open — cast your vote',      orbCls: 'ongoing',  lblCls: 'ongoing',  live: true  },
                ended:    { icon: 'fa-flag-checkered',  label: 'Election Ended',     hint: 'Voting has officially closed',         orbCls: 'ended',    lblCls: 'ended',    live: false },
            };

            const ecOrb        = document.getElementById('ec-orb');
            const ecOrbIcon    = document.getElementById('ec-orb-icon');
            const ecOrbLabel   = document.getElementById('ec-orb-label');
            const ecOrbHint    = document.getElementById('ec-orb-hint');
            const ecOrbWrap    = document.getElementById('ec-orb-wrap');
            const ecName       = document.getElementById('ec-election-name');
            const ecLive       = document.getElementById('ec-live-strip');
            const ecVotes      = document.getElementById('ec-votes');
            const ecTotal      = document.getElementById('ec-total');
            const ecPart       = document.getElementById('ec-part');
            const ecFill       = document.getElementById('ec-fill');
            const ecPartPct    = document.getElementById('ec-part-pct');
            const ecLabelDot   = document.getElementById('ec-label-dot');
            const ecCdWrap     = document.getElementById('ec-countdown-wrap');
            const cdDays       = document.getElementById('cd-days');
            const cdHrs        = document.getElementById('cd-hrs');
            const cdMins       = document.getElementById('cd-mins');
            const cdSecs       = document.getElementById('cd-secs');
            const navLiveBadge = document.getElementById('nav-live-badge');

            let prevStatus     = null;
            let prevVotes      = null;
            let countdownTimer = null;
            let targetDate     = null;

            function pad(n) { return String(n).padStart(2, '0'); }

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
                const m = Math.floor((diff % 3600000)  / 60000);
                const s = Math.floor((diff % 60000)    / 1000);
                if (cdDays)  cdDays.textContent  = pad(d);
                if (cdHrs)   cdHrs.textContent   = pad(h);
                if (cdMins)  cdMins.textContent  = pad(m);
                if (cdSecs)  cdSecs.textContent  = pad(s);
            }

            function startCountdown(isoDate) {
                clearInterval(countdownTimer);
                targetDate = new Date(isoDate).getTime();
                if (isNaN(targetDate) || targetDate <= Date.now()) { targetDate = null; return false; }
                tickCountdown();
                countdownTimer = setInterval(tickCountdown, 1000);
                return true;
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

            function animFlash(el) {
                if (!el) return;
                el.classList.remove('ec-flash');
                void el.offsetWidth;
                el.classList.add('ec-flash');
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
                        prevVotes = cast;
                    }
                    if (ecTotal && total) ecTotal.textContent = total.toLocaleString();

                    if (total > 0) {
                        const pct = Math.min(100, Math.round((cast / total) * 100));
                        if (ecPart)    ecPart.style.display   = 'block';
                        if (ecFill)    ecFill.style.width      = pct + '%';
                        if (ecPartPct) ecPartPct.textContent   = pct + '%';
                    }
                } catch (e) {
                    console.warn('[Stats]', e.message);
                }
            }

            fetchStats();
            setInterval(fetchStats, POLL_MS);
        })();
        </script>

    </body>
</html>
