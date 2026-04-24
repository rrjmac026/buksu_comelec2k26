<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" style="background:#1e0025;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Voting System') }}</title>
        <link rel="icon" href="{{ asset('images/tab_icon.png') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/css/welcome.css', 'resources/js/app.js', 'resources/js/welcome.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            /* ══ THREE-COL OVERRIDE (only active on this page) ══ */
            .two-col {
                grid-template-columns: 1fr 1fr 1fr !important;
                max-width: 1140px !important;
                align-items: stretch !important;
            }

            /* stretch the center card to full row height */
            .ec-status-card {
                height: 100%;
                display: flex;
                flex-direction: column;
            }
            .ec-card-inner {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            /* ════════════════════════════════════
               ELECTION STATUS CARD
            ════════════════════════════════════ */
            .ec-status-card {
                background: rgba(30,0,37,0.78);
                border: 1px solid rgba(249,180,15,0.2);
                border-radius: 20px;
                position: relative;
                overflow: hidden;
                box-shadow: 0 0 0 1px rgba(249,180,15,0.06) inset, 0 20px 60px rgba(0,0,0,0.5);
            }
            /* same gold top-line as .panel */
            .ec-status-card::before {
                content: '';
                position: absolute; top: 0; left: 0; right: 0; height: 1px;
                background: linear-gradient(90deg, transparent, rgba(249,180,15,0.5), transparent);
                z-index: 2;
            }

            .ec-card-inner { padding: 32px 28px 28px; }

            /* ── section label ── */
            .ec-section-lbl {
                font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
                letter-spacing: 0.13em; color: rgba(249,180,15,0.45);
                text-align: center; margin-bottom: 18px;
            }

            /* ── election name box ── */
            .ec-name-box {
                background: rgba(249,180,15,0.05);
                border: 1px solid rgba(249,180,15,0.14);
                border-radius: 12px;
                padding: 14px 18px; text-align: center;
                margin-bottom: 22px;
            }
            .ec-name-eyebrow {
                font-size: 0.55rem; font-weight: 700; text-transform: uppercase;
                letter-spacing: 0.12em; color: rgba(255,251,240,0.3);
                margin-bottom: 5px;
            }
            #ec-election-name {
                font-family: 'Playfair Display', Georgia, serif;
                font-size: 1rem; font-weight: 800;
                color: #fffbf0; line-height: 1.3;
            }

            /* ── big status orb ── */
            .ec-orb-wrap {
                display: flex; flex-direction: column; align-items: center;
                margin-bottom: 18px;
            }
            .ec-orb {
                width: 90px; height: 90px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                font-size: 2rem; margin-bottom: 13px; position: relative;
                transition: background 0.6s ease, box-shadow 0.6s ease;
            }
            .ec-orb::before {
                content: ''; position: absolute; inset: -5px; border-radius: 50%;
                border: 2px solid transparent;
                transition: border-color 0.6s ease;
            }
            .ec-orb.upcoming {
                background: rgba(249,180,15,0.12);
                box-shadow: 0 0 28px rgba(249,180,15,0.2);
            }
            .ec-orb.upcoming::before { border-color: rgba(249,180,15,0.28); }
            .ec-orb.ongoing {
                background: rgba(52,211,153,0.12);
                box-shadow: 0 0 38px rgba(52,211,153,0.3);
                animation: ec-orb-live 2s ease-in-out infinite;
            }
            .ec-orb.ongoing::before {
                border-color: rgba(52,211,153,0.45);
                animation: ec-ring-spin 3s linear infinite;
            }
            .ec-orb.ended {
                background: rgba(255,255,255,0.04);
                box-shadow: none;
            }
            .ec-orb.ended::before { border-color: rgba(255,255,255,0.1); }

            @keyframes ec-orb-live {
                0%,100% { box-shadow: 0 0 28px rgba(52,211,153,0.25); }
                50%      { box-shadow: 0 0 52px rgba(52,211,153,0.55); }
            }
            @keyframes ec-ring-spin { to { transform: rotate(360deg); } }

            .ec-orb-label {
                font-family: 'Playfair Display', Georgia, serif;
                font-size: 1.25rem; font-weight: 900; text-align: center;
                transition: color 0.5s ease;
            }
            .ec-orb-label.upcoming { color: #f9b40f; }
            .ec-orb-label.ongoing  { color: #34d399; }
            .ec-orb-label.ended    { color: rgba(255,255,255,0.38); }

            .ec-orb-hint {
                font-size: 0.58rem; color: rgba(255,251,240,0.3);
                text-align: center; margin-top: 4px; line-height: 1.5;
            }

            /* ── stat rows ── */
            .ec-stats { display: flex; flex-direction: column; gap: 10px; margin-bottom: 14px; }
            .ec-stat-row {
                display: flex; align-items: center; justify-content: space-between;
                padding: 13px 16px; border-radius: 12px;
                background: rgba(255,255,255,0.025);
                border: 1px solid rgba(255,255,255,0.05);
            }
            .ec-stat-icon {
                width: 32px; height: 32px; border-radius: 9px;
                display: flex; align-items: center; justify-content: center;
                font-size: 0.78rem; flex-shrink: 0;
            }
            .ec-stat-icon.gold  { background: rgba(249,180,15,0.1);  color: #f9b40f; }
            .ec-stat-icon.green { background: rgba(52,211,153,0.08); color: #34d399; }
            .ec-stat-lbl { font-size: 0.68rem; color: rgba(255,251,240,0.35); margin-left: 11px; flex: 1; }
            .ec-stat-val {
                font-family: 'Playfair Display', Georgia, serif;
                font-size: 1.05rem; font-weight: 900; color: #fffbf0;
            }

            /* ── participation mini bar ── */
            .ec-part {
                padding: 14px 16px;
                background: rgba(249,180,15,0.04);
                border: 1px solid rgba(249,180,15,0.09);
                border-radius: 12px;
                display: none;
            }
            .ec-part-hd {
                display: flex; justify-content: space-between; margin-bottom: 9px;
            }
            .ec-part-lbl {
                font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
                letter-spacing: 0.1em; color: rgba(255,251,240,0.3);
            }
            #ec-part-pct {
                font-family: 'Playfair Display', Georgia, serif;
                font-size: 0.78rem; font-weight: 900; color: #f9b40f;
            }
            .ec-track {
                height: 4px; border-radius: 4px;
                background: rgba(255,255,255,0.06); overflow: hidden;
            }
            #ec-fill {
                height: 100%; width: 0%; border-radius: 4px;
                background: linear-gradient(90deg, #f9b40f, #fcd558);
                transition: width 1.4s cubic-bezier(0.4,0,0.2,1);
            }
            .ec-part-sub {
                margin-top: 6px; font-size: 0.55rem;
                color: rgba(255,251,240,0.25); text-align: right;
            }

            /* ── live strip ── */
            .ec-live-strip {
                display: none;
                align-items: center; justify-content: center; gap: 7px;
                margin-top: 12px; padding: 7px 12px; border-radius: 20px;
                background: rgba(52,211,153,0.07);
                border: 1px solid rgba(52,211,153,0.18);
                font-size: 0.6rem; font-weight: 700; color: #34d399;
            }
            .ec-live-dot {
                width: 6px; height: 6px; border-radius: 50%;
                background: #34d399;
                animation: ec-ldot 1.2s ease-in-out infinite;
            }
            @keyframes ec-ldot {
                0%,100% { box-shadow: 0 0 0 0 rgba(52,211,153,0.6); }
                50%      { box-shadow: 0 0 0 5px rgba(52,211,153,0); }
            }

            /* ── stat update flash ── */
            .ec-stat-updated { animation: ec-pop 0.35s ease; }
            @keyframes ec-pop {
                0%   { opacity: 0.4; transform: scale(0.88); }
                60%  { transform: scale(1.08); }
                100% { opacity: 1;   transform: scale(1); }
            }

            /* ══ RESPONSIVE ══ */
            @media (max-width: 900px) {
                .two-col {
                    grid-template-columns: 1fr !important;
                }
                .ec-status-card { order: -1; }
            }
            @media (max-width: 768px) {
                .two-col { grid-template-columns: 1fr !important; }
            }
        </style>
    </head>
    <body class="antialiased" style="background:#1e0025;min-height:100vh;display:flex;flex-direction:column;" x-data>

        {{-- Nav --}}
        @if (Route::has('login'))
        <nav style="position:fixed;top:0;left:0;right:0;z-index:50;height:60px;display:flex;align-items:center;padding:0 32px;background:rgba(26,0,32,0.9);backdrop-filter:blur(20px);border-bottom:1px solid rgba(249,180,15,0.2);">
            <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;flex:1;">
                <img src="{{ asset('assets/app_logo.png') }}"
                    style="height:38px;width:38px;object-fit:cover;border-radius:8px;border:1.5px solid rgba(249,180,15,0.4);">
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

            <div class="outer">
                <div class="grid-bg"></div>

                {{-- NOW THREE COLUMNS: left | status card | right --}}
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

                    <!-- ── CENTER: Election Status Card (NEW) ── -->
                    <div class="ec-status-card">
                        <div class="ec-card-inner">

                            <div class="ec-section-lbl">Live Election Status</div>

                            {{-- Election name --}}
                            <div class="ec-name-box">
                                <div class="ec-name-eyebrow">Current Election</div>
                                <div id="ec-election-name">Loading…</div>
                            </div>

                            {{-- Big animated orb --}}
                            <div class="ec-orb-wrap">
                                <div class="ec-orb upcoming" id="ec-orb">
                                    <i class="fas fa-hourglass-start" id="ec-orb-icon"></i>
                                </div>
                                <div class="ec-orb-label upcoming" id="ec-orb-label">Election Soon</div>
                                <div class="ec-orb-hint" id="ec-orb-hint">Voting has not started yet</div>
                            </div>

                            {{-- Stat rows --}}
                            <div class="ec-stats">
                                <div class="ec-stat-row">
                                    <div class="ec-stat-icon gold"><i class="fas fa-vote-yea"></i></div>
                                    <span class="ec-stat-lbl">Votes Cast</span>
                                    <span class="ec-stat-val" id="ec-votes">—</span>
                                </div>
                                <div class="ec-stat-row">
                                    <div class="ec-stat-icon green"><i class="fas fa-users"></i></div>
                                    <span class="ec-stat-lbl">Total Voters</span>
                                    <span class="ec-stat-val" id="ec-total">—</span>
                                </div>
                            </div>

                            {{-- Mini participation bar --}}
                            <div class="ec-part" id="ec-part">
                                <div class="ec-part-hd">
                                    <span class="ec-part-lbl">Participation</span>
                                    <span id="ec-part-pct">0%</span>
                                </div>
                                <div class="ec-track"><div id="ec-fill"></div></div>
                                <div class="ec-part-sub" id="ec-part-sub"></div>
                            </div>

                            {{-- Live strip (only when ongoing) --}}
                            <div class="ec-live-strip" id="ec-live-strip">
                                <div class="ec-live-dot"></div>
                                Voting is open right now
                            </div>

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

        </div>

        <footer style="background:rgba(26,0,32,0.95);border-top:1px solid rgba(249,180,15,0.15);text-align:center;padding:16px 40px;">
            <p style="color:rgba(255,251,240,0.45);font-size:0.8rem;margin:0;">
                &copy; {{ date('Y') }} <span style="color:#f9b40f;font-weight:700;">{{ config('app.name', 'Voting System') }}.</span> All rights reserved.
            </p>
        </footer>

        {{-- ── Live Stats Polling Script ── --}}
        <script>
        (function () {
            const POLL_MS   = 10_000;
            const STATS_URL = '/public/stats';

            const STATUS_CFG = {
                upcoming: {
                    icon:     'fa-hourglass-start',
                    label:    'Election Soon',
                    hint:     'Voting has not started yet',
                    orbCls:   'upcoming',
                    lblCls:   'upcoming',
                    live:     false,
                },
                ongoing: {
                    icon:     'fa-circle-dot',
                    label:    'Election is LIVE',
                    hint:     'Polls are open — cast your vote',
                    orbCls:   'ongoing',
                    lblCls:   'ongoing',
                    live:     true,
                },
                ended: {
                    icon:     'fa-flag-checkered',
                    label:    'Election Ended',
                    hint:     'Voting has officially closed',
                    orbCls:   'ended',
                    lblCls:   'ended',
                    live:     false,
                },
            };

            // DOM refs — center card
            const ecOrb       = document.getElementById('ec-orb');
            const ecOrbIcon   = document.getElementById('ec-orb-icon');
            const ecOrbLabel  = document.getElementById('ec-orb-label');
            const ecOrbHint   = document.getElementById('ec-orb-hint');
            const ecName      = document.getElementById('ec-election-name');
            const ecLive      = document.getElementById('ec-live-strip');
            const ecVotes     = document.getElementById('ec-votes');
            const ecTotal     = document.getElementById('ec-total');
            const ecPart      = document.getElementById('ec-part');
            const ecFill      = document.getElementById('ec-fill');
            const ecPartPct   = document.getElementById('ec-part-pct');
            const ecPartSub   = document.getElementById('ec-part-sub');

            // DOM refs — left card stat
            const leftVotes   = document.getElementById('stat-votes-cast');

            let prevStatus = null;
            let prevVotes  = null;

            function applyStatus(status) {
                if (status === prevStatus) return;
                prevStatus = status;
                const cfg = STATUS_CFG[status] || STATUS_CFG.upcoming;

                if (ecOrb)      ecOrb.className      = 'ec-orb ' + cfg.orbCls;
                if (ecOrbIcon)  ecOrbIcon.className   = 'fas ' + cfg.icon;
                if (ecOrbLabel) { ecOrbLabel.className = 'ec-orb-label ' + cfg.lblCls; ecOrbLabel.textContent = cfg.label; }
                if (ecOrbHint)  ecOrbHint.textContent  = cfg.hint;
                if (ecLive)     ecLive.style.display   = cfg.live ? 'flex' : 'none';
            }

            function animCount(el) {
                if (!el) return;
                el.classList.remove('ec-stat-updated');
                void el.offsetWidth;
                el.classList.add('ec-stat-updated');
            }

            function updateVotes(cast, total) {
                if (cast !== prevVotes) {
                    if (leftVotes) { leftVotes.textContent = cast.toLocaleString(); animCount(leftVotes); }
                    if (ecVotes)     ecVotes.textContent   = cast.toLocaleString();
                    prevVotes = cast;
                }
                if (ecTotal && total) ecTotal.textContent = total.toLocaleString();
            }

            function updateParticipation(cast, total) {
                if (!total || total === 0) return;
                const pct     = Math.min(100, Math.round((cast / total) * 100));
                const display = pct + '%';

                if (ecPart)    ecPart.style.display  = 'block';
                if (ecFill)    ecFill.style.width     = display;
                if (ecPartPct) ecPartPct.textContent  = display;
                if (ecPartSub) ecPartSub.textContent  = cast.toLocaleString() + ' of ' + total.toLocaleString() + ' voters';
            }

            async function fetchStats() {
                try {
                    const res  = await fetch(STATS_URL, { headers: { 'Accept': 'application/json' }, cache: 'no-store' });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();

                    if (ecName && data.election_name) ecName.textContent = data.election_name;
                    applyStatus(data.status);
                    updateVotes(data.votes_cast ?? 0, data.total_voters ?? 0);
                    updateParticipation(data.votes_cast ?? 0, data.total_voters ?? 0);
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