<x-app-layout>
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Welcome Section --}}
    <div class="vd-gc p-6 mb-6" style="background:linear-gradient(135deg,rgba(56,0,65,0.85),rgba(82,0,96,0.75));border:1px solid rgba(249,180,15,0.2);animation:vd-fadeUp .5s ease both;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
            <div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:900;color:#fffbf0;margin:0 0 8px 0;">Welcome, {{ $voter->full_name }}! 👋</h2>
                <p style="font-size:0.85rem;color:rgba(255,251,240,0.6);margin:0;line-height:1.6;">{{ $hasVoted ? "Thank you for casting your vote! Your participation helps shape the future of our organization." : "You're invited to participate in this important election. Your voice matters—cast your vote now!" }}</p>
            </div>
            <div style="padding:12px 20px;border-radius:12px;background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.25);text-align:center;flex-shrink:0;">
                <div style="font-family:'Playfair Display',serif;font-size:0.95rem;font-weight:800;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ now()->format('l, F j, Y') }}</div>
            </div>
        </div>
    </div>

    <style>
        * { box-sizing:border-box; }
        :root {
            --gold:      #f9b40f;
            --gold-lt:   #fcd558;
            --gold-dk:   #c98a00;
            --gold-pale: rgba(249,180,15,0.1);
            --violet:    #380041;
            --violet-md: #520060;
            --violet-lt: #6b0080;
            --cream:     #fffbf0;
            --ink:       #1a0020;
            --glass:     rgba(30,0,37,0.7);
            --glass-border: rgba(249,180,15,0.15);
        }

        @media (prefers-color-scheme: light) {
            :root {
                --cream: #1a0020;
                --ink: #fffbf0;
                --glass: rgba(255,255,255,0.9);
                --glass-border: rgba(201,138,0,0.2);
            }
            body { background-color: #f9f5f0 !important; }
            .vd-section-label { color: rgba(201,138,0,0.6) !important; }
            .vd-card-title { color: #1a0020 !important; }
            .welcome-banner {
                background: linear-gradient(135deg, rgba(56,0,65,0.92), rgba(82,0,96,0.8)) !important;
                border-color: rgba(249,180,15,0.25) !important;
            }
            .welcome-banner h2 { color: #fffbf0 !important; }
            .welcome-banner p  { color: rgba(255,251,240,0.6) !important; }
            .welcome-banner .date-chip {
                background: rgba(249,180,15,0.12) !important;
                border-color: rgba(249,180,15,0.25) !important;
            }
        }

        @keyframes vd-pulse      { 0%,100%{opacity:1}50%{opacity:.4} }
        @keyframes vd-fadeUp     { from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)} }
        @keyframes vd-glowPulse  { 0%,100%{box-shadow:0 0 0 rgba(249,180,15,0)}50%{box-shadow:0 0 14px rgba(249,180,15,0.3)} }
        @keyframes vd-checkBounce{ 0%{transform:scale(0)}60%{transform:scale(1.2)}100%{transform:scale(1)} }

        body { font-family:'DM Sans',sans-serif; }

        .vd-gc {
            background: var(--glass);
            backdrop-filter:blur(20px);
            -webkit-backdrop-filter:blur(20px);
            border:1px solid var(--glass-border);
            border-radius:16px;
            box-shadow:0 4px 30px rgba(0,0,0,0.3), inset 0 1px 0 rgba(249,180,15,0.06);
            animation:vd-fadeUp .5s ease both;
            position:relative;
            overflow:hidden;
        }
        @media (prefers-color-scheme: light) {
            .vd-gc {
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }
        }
        .vd-gc::before {
            content:'';
            position:absolute;top:0;left:0;right:0;height:1px;
            background:linear-gradient(90deg,transparent,rgba(249,180,15,0.3),transparent);
            pointer-events:none;
        }

        .vd-section-label {
            font-size:.62rem;font-weight:700;letter-spacing:.1em;
            text-transform:uppercase;color:rgba(249,180,15,0.5);margin:0;
        }
        .vd-card-title {
            font-family:'Playfair Display',serif;font-size:.9rem;font-weight:800;
            color:var(--cream);letter-spacing:.01em;margin:0;
        }
        .vd-stat-num {
            font-family:'Playfair Display',serif;font-size:1.7rem;font-weight:900;
            background:linear-gradient(135deg,var(--gold) 0%,var(--gold-lt) 60%,#fff3c4 100%);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
            line-height:1;
        }
        .vd-icon-box {
            width:42px;height:42px;border-radius:12px;
            display:flex;align-items:center;justify-content:center;
            font-size:.95rem;flex-shrink:0;color:#fff;
        }
        .vd-prog-track { height:6px;border-radius:99px;background:rgba(249,180,15,0.08);overflow:hidden; }
        .vd-prog-fill  { height:100%;border-radius:99px;transition:width 1.2s cubic-bezier(.4,0,.2,1); }

        .vd-status-banner {
            border-radius:16px;padding:24px 28px;
            display:flex;align-items:center;gap:20px;
            position:relative;overflow:hidden;
        }
        .vd-status-banner::before {
            content:'';position:absolute;inset:0;
            background:linear-gradient(135deg,rgba(249,180,15,0.06) 0%,transparent 60%);
            pointer-events:none;
        }
        .vd-status-banner::after {
            content:'';position:absolute;top:0;left:0;right:0;height:1px;
            background:linear-gradient(90deg,transparent,rgba(249,180,15,0.4),transparent);
            pointer-events:none;
        }
        .vd-status-banner.voted     { background:linear-gradient(135deg,rgba(52,211,153,0.12),rgba(16,185,129,0.06));border:1px solid rgba(52,211,153,0.2); }
        .vd-status-banner.not-voted { background:linear-gradient(135deg,rgba(56,0,65,0.8),rgba(82,0,96,0.6));border:1px solid rgba(249,180,15,0.2); }
        @media (prefers-color-scheme: light) {
            .vd-status-banner.voted { background:linear-gradient(135deg,rgba(52,211,153,0.08),rgba(16,185,129,0.04));border:1px solid rgba(52,211,153,0.25); }
            .vd-status-banner.not-voted { background:linear-gradient(135deg,rgba(249,180,15,0.06),rgba(201,138,0,0.04));border:1px solid rgba(201,138,0,0.2); }
        }

        .vd-check-icon {
            width:60px;height:60px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            flex-shrink:0;font-size:1.6rem;
            animation:vd-checkBounce .6s cubic-bezier(.4,0,.2,1) .3s both;
        }
        .vd-info-row {
            display:flex;align-items:center;justify-content:space-between;
            padding:10px 0;border-bottom:1px solid rgba(249,180,15,0.07);
        }
        .vd-info-row:last-child { border-bottom:none; }
        .vd-countdown-box {
            display:flex;flex-direction:column;align-items:center;
            padding:12px 16px;border-radius:12px;
            background:rgba(56,0,65,0.7);border:1px solid rgba(249,180,15,0.15);min-width:60px;
        }
        .vd-countdown-num {
            font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:900;
            background:linear-gradient(135deg,var(--gold),var(--gold-lt));
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
            line-height:1;
        }
        .vd-countdown-lbl { font-size:.58rem;color:rgba(249,180,15,0.5);font-weight:600;letter-spacing:.08em;text-transform:uppercase;margin-top:3px; }

        .vd-cta-btn {
            display:inline-flex;align-items:center;gap:7px;
            padding:10px 22px;border-radius:10px;
            background:linear-gradient(135deg,#f9b40f,#fcd558);
            color:#380041;font-size:.75rem;font-weight:700;text-decoration:none;
            box-shadow:0 4px 20px rgba(249,180,15,0.35),inset 0 1px 0 rgba(255,255,255,0.2);
            border:1px solid rgba(249,180,15,0.5);
            transition:all .2s;
        }
        .vd-cta-btn:hover { transform:translateY(-2px);box-shadow:0 8px 28px rgba(249,180,15,0.5); }

        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:rgba(249,180,15,0.2);border-radius:99px; }
        @media (prefers-color-scheme: light) {
            ::-webkit-scrollbar-thumb { background:rgba(201,138,0,0.2); }
        }
    </style>

    {{-- ═══════════════════════════════════════════
         SESSION FLASH MESSAGES
    ═══════════════════════════════════════════ --}}
    @if(session('error'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);margin-bottom:20px;animation:vd-fadeUp .4s ease both;">
        <i class="fas fa-circle-xmark" style="color:#f87171;font-size:.85rem;flex-shrink:0;"></i>
        <span style="font-size:.75rem;font-weight:600;color:#f87171;">{{ session('error') }}</span>
    </div>
    @endif
    @if(session('info'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:12px;background:rgba(249,180,15,0.08);border:1px solid rgba(249,180,15,0.2);margin-bottom:20px;animation:vd-fadeUp .4s ease both;">
        <i class="fas fa-circle-info" style="color:#f9b40f;font-size:.85rem;flex-shrink:0;"></i>
        <span style="font-size:.75rem;font-weight:600;color:#f9b40f;">{{ session('info') }}</span>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════
         ROW 1 — VOTING STATUS HERO BANNER
    ═══════════════════════════════════════════ --}}
    <div class="vd-status-banner {{ $hasVoted ? 'voted' : 'not-voted' }} mb-5"
         style="animation:vd-fadeUp .4s ease both;">
        <div class="vd-check-icon"
             style="background:{{ $hasVoted ? 'rgba(52,211,153,0.15)' : 'rgba(249,180,15,0.12)' }};
                    border:2px solid {{ $hasVoted ? 'rgba(52,211,153,0.35)' : 'rgba(249,180,15,0.3)' }};">
            <i class="fas {{ $hasVoted ? 'fa-check-double' : 'fa-ballot-check' }}"
               style="color:{{ $hasVoted ? '#34d399' : '#f9b40f' }};"></i>
        </div>

        <div style="flex:1;">
            <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:800;color:#fffbf0;margin-bottom:4px;">
                {{ $hasVoted ? 'Your vote has been recorded!' : "You haven't voted yet" }}
            </div>
            <div style="font-size:.75rem;color:rgba(255,251,240,0.55);max-width:520px;line-height:1.6;">
                @if($hasVoted)
                    Thank you for participating in this election. Your vote is anonymous and securely stored. Results will be announced after the election period ends.
                @else
                    The election is currently open. Exercise your right to vote and make your voice heard. Every vote counts toward shaping the leadership of your organization.
                @endif
            </div>
        </div>

        <div style="flex-shrink:0;text-align:right;">
            @if($hasVoted)
                <div style="font-size:.62rem;color:rgba(255,251,240,0.35);margin-bottom:3px;">Voted on</div>
                <div style="font-family:'Playfair Display',serif;font-size:.8rem;color:#34d399;font-weight:700;">
                    {{ $myVotes->first()?->voted_at?->format('M d, Y · g:i A') ?? '—' }}
                </div>
            @else
                <a href="{{ route('voter.vote') }}" class="vd-cta-btn">
                    <i class="fas fa-vote-yea"></i> Cast My Vote Now
                </a>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         ROW 2 — 4 STAT CARDS
    ═══════════════════════════════════════════ --}}
    @php
        $statCards = [
            ['label' => 'Total Candidates', 'value' => $totalCandidates, 'icon' => 'fa-user-tie',      'bg' => 'linear-gradient(135deg,#f9b40f,#fcd558)',  'glow' => 'rgba(249,180,15,.45)', 'color' => '#380041'],
            ['label' => 'Open Positions',   'value' => $totalPositions,  'icon' => 'fa-list-check',    'bg' => 'linear-gradient(135deg,#c98a00,#f9b40f)',  'glow' => 'rgba(201,138,0,.45)',  'color' => '#1a0020'],
            ['label' => 'Voter Turnout',    'value' => $turnoutPct . '%','icon' => 'fa-percent',       'bg' => 'linear-gradient(135deg,#fcd558,#f9b40f)',  'glow' => 'rgba(252,213,88,.4)',  'color' => '#380041'],
            ['label' => 'My Votes Cast',    'value' => $myVotesCount,    'icon' => 'fa-check-to-slot', 'bg' => 'linear-gradient(135deg,#059669,#0891b2)',  'glow' => 'rgba(16,185,129,.45)', 'color' => '#fff'],
        ];
    @endphp

    <div class="grid gap-4 mb-5" style="grid-template-columns:repeat(4,1fr);">
        @foreach($statCards as $i => $sc)
        <div class="vd-gc p-4 flex items-center gap-3 hover:scale-[1.02] transition-transform duration-200"
             style="animation-delay:{{ $i * 0.06 }}s">
            <div class="vd-icon-box" style="background:{{ $sc['bg'] }};box-shadow:0 0 18px {{ $sc['glow'] }};color:{{ $sc['color'] }};">
                <i class="fas {{ $sc['icon'] }}"></i>
            </div>
            <div class="min-w-0">
                <div class="vd-stat-num">{{ $sc['value'] }}</div>
                <div class="vd-section-label mt-1">{{ $sc['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════
         ROW 3 — PROFILE + TURNOUT RING + COUNTDOWN
    ═══════════════════════════════════════════ --}}
    <div class="grid gap-5 mb-5" style="grid-template-columns:1fr 220px 240px;">

        {{-- MY PROFILE --}}
        <div class="vd-gc p-5" style="animation-delay:.12s">
            <div class="flex items-center justify-between mb-4">
                <h3 class="vd-card-title">My Profile</h3>
                <a href="{{ route('profile.edit') }}"
                   style="font-size:.68rem;font-weight:700;color:rgba(249,180,15,0.7);text-decoration:none;display:flex;align-items:center;gap:4px;padding:4px 10px;border-radius:6px;border:1px solid rgba(249,180,15,0.15);transition:all .2s;"
                   onmouseover="this.style.color='#f9b40f';this.style.borderColor='rgba(249,180,15,0.35)'"
                   onmouseout="this.style.color='rgba(249,180,15,0.7)';this.style.borderColor='rgba(249,180,15,0.15)'">
                    <i class="fas fa-pen" style="font-size:.55rem;"></i> Edit
                </a>
            </div>

            <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;padding-bottom:16px;border-bottom:1px solid rgba(249,180,15,0.08);">
                <div style="width:52px;height:52px;border-radius:16px;background:linear-gradient(135deg,#f9b40f,#fcd558);display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:900;color:#380041;flex-shrink:0;box-shadow:0 0 20px rgba(249,180,15,0.4);font-family:'Playfair Display',serif;">
                    {{ strtoupper(substr($voter->full_name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:.88rem;font-weight:700;color:#fffbf0;">{{ $voter->full_name }}</div>
                    <div style="font-size:.68rem;color:rgba(255,251,240,0.4);margin-top:2px;">{{ $voter->email }}</div>
                    <div style="display:inline-flex;align-items:center;gap:4px;margin-top:5px;padding:2px 9px;border-radius:20px;background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                        <span style="width:5px;height:5px;border-radius:50%;background:#34d399;display:inline-block;"></span>
                        <span style="font-size:.6rem;font-weight:700;color:#34d399;letter-spacing:.06em;">
                            {{ strtoupper($voter->status ?? 'Active') }}
                        </span>
                    </div>
                </div>
            </div>

            @php
                $infos = [
                    ['label' => 'Student No.', 'value' => $voter->student_number ?? '—',                               'icon' => 'fa-id-card'],
                    ['label' => 'College',     'value' => $voter->college?->name ?? '—',                               'icon' => 'fa-building-columns'],
                    ['label' => 'Course',      'value' => $voter->course ?? '—',                                       'icon' => 'fa-book'],
                    ['label' => 'Year Level',  'value' => $voter->year_level ? 'Year ' . $voter->year_level : '—',     'icon' => 'fa-graduation-cap'],
                    ['label' => 'Sex',         'value' => ucfirst($voter->sex ?? '—'),                                 'icon' => 'fa-venus-mars'],
                ];
            @endphp
            <div>
                @foreach($infos as $info)
                <div class="vd-info-row">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <i class="fas {{ $info['icon'] }}" style="width:14px;text-align:center;font-size:.7rem;color:rgba(249,180,15,0.4);"></i>
                        <span style="font-size:.7rem;color:rgba(255,251,240,0.4);">{{ $info['label'] }}</span>
                    </div>
                    <span style="font-size:.72rem;font-weight:600;color:rgba(249,180,15,0.85);text-align:right;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $info['value'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TURNOUT RING --}}
        @php $circumference = round(2 * 3.14159 * 54, 1); @endphp
        <div class="vd-gc p-5 flex flex-col items-center" style="animation-delay:.18s">
            <h3 class="vd-card-title mb-1" style="align-self:flex-start;">Turnout</h3>
            <p class="vd-section-label mb-4" style="align-self:flex-start;">Election participation</p>

            <div style="position:relative;width:130px;height:130px;flex-shrink:0;">
                <svg width="130" height="130" viewBox="0 0 130 130" style="transform:rotate(-90deg);">
                    <circle cx="65" cy="65" r="54" fill="none" stroke="rgba(249,180,15,0.08)" stroke-width="12"/>
                    <circle cx="65" cy="65" r="54" fill="none"
                            stroke="url(#turnoutGrad)" stroke-width="12"
                            stroke-linecap="round"
                            stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ round($circumference * (1 - $turnoutPct / 100), 1) }}"
                            style="transition:stroke-dashoffset 1.5s cubic-bezier(.4,0,.2,1);filter:drop-shadow(0 0 8px rgba(249,180,15,0.5));"/>
                    <defs>
                        <linearGradient id="turnoutGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#f9b40f"/>
                            <stop offset="100%" stop-color="#fcd558"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                    <div style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:900;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;">{{ $turnoutPct }}%</div>
                    <div style="font-size:.55rem;color:rgba(249,180,15,0.5);font-weight:700;letter-spacing:.08em;margin-top:3px;">TURNOUT</div>
                </div>
            </div>

            <div style="width:100%;margin-top:18px;display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:.68rem;">
                    <span style="display:flex;align-items:center;gap:5px;color:rgba(255,251,240,0.45);">
                        <span style="width:8px;height:8px;border-radius:50%;background:#f9b40f;display:inline-block;"></span>Voted
                    </span>
                    <span style="font-weight:700;color:#f9b40f;">{{ $totalVotesCast }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:.68rem;">
                    <span style="display:flex;align-items:center;gap:5px;color:rgba(255,251,240,0.45);">
                        <span style="width:8px;height:8px;border-radius:50%;background:rgba(249,180,15,0.2);display:inline-block;"></span>Remaining
                    </span>
                    <span style="font-weight:700;color:rgba(249,180,15,0.4);">{{ $totalVoters - $totalVotesCast }}</span>
                </div>
                <div class="vd-prog-track" style="margin-top:4px;">
                    <div class="vd-prog-fill" style="width:{{ $turnoutPct }}%;background:linear-gradient(90deg,#f9b40f,#fcd558);"></div>
                </div>
            </div>
        </div>

        {{-- ELECTION COUNTDOWN --}}
        <div class="vd-gc p-5 flex flex-col" style="animation-delay:.24s">
            <div class="flex items-center justify-between mb-4">
                <h3 class="vd-card-title">Election Period</h3>
                <span style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 8px #34d399;animation:vd-pulse 2s infinite;display:inline-block;"></span>
            </div>

            <div style="padding:10px 14px;border-radius:12px;background:rgba(52,211,153,0.07);border:1px solid rgba(52,211,153,0.18);margin-bottom:16px;">
                <div style="font-size:.62rem;color:rgba(255,251,240,0.35);margin-bottom:2px;">Status</div>
                <div style="font-family:'Playfair Display',serif;font-size:.8rem;font-weight:800;color:#34d399;">
                    <i class="fas fa-circle" style="font-size:.45rem;animation:vd-pulse 1.5s infinite;"></i> LIVE NOW
                </div>
            </div>

            <div style="display:flex;gap:8px;justify-content:center;margin-bottom:16px;">
                <div class="vd-countdown-box">
                    <div class="vd-countdown-num" id="cd-hours">00</div>
                    <div class="vd-countdown-lbl">Hours</div>
                </div>
                <div style="display:flex;align-items:center;font-family:'Playfair Display',serif;font-size:1.3rem;color:rgba(249,180,15,0.3);padding-bottom:18px;font-weight:900;">:</div>
                <div class="vd-countdown-box">
                    <div class="vd-countdown-num" id="cd-mins">00</div>
                    <div class="vd-countdown-lbl">Mins</div>
                </div>
                <div style="display:flex;align-items:center;font-family:'Playfair Display',serif;font-size:1.3rem;color:rgba(249,180,15,0.3);padding-bottom:18px;font-weight:900;">:</div>
                <div class="vd-countdown-box">
                    <div class="vd-countdown-num" id="cd-secs">00</div>
                    <div class="vd-countdown-lbl">Secs</div>
                </div>
            </div>

            <div style="text-align:center;margin-bottom:12px;">
                <div style="font-size:.62rem;color:rgba(255,251,240,0.35);">Closes on</div>
                <div style="font-size:.72rem;font-weight:700;color:rgba(249,180,15,0.8);margin-top:2px;">
                    {{ $electionEnd->format('F j, Y · g:i A') }}
                </div>
            </div>

            @if(!$hasVoted)
            <a href="{{ route('voter.vote') }}" class="vd-cta-btn" style="justify-content:center;margin-top:auto;"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-vote-yea"></i> Vote Before Time Runs Out
            </a>
            @else
            <div style="display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;border-radius:12px;background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.18);margin-top:auto;">
                <i class="fas fa-check-double" style="color:#34d399;font-size:.7rem;"></i>
                <span style="font-size:.72rem;font-weight:700;color:#34d399;">You've already voted!</span>
            </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         SCRIPTS
    ═══════════════════════════════════════════ --}}
    <script>
    (() => {
        const endTime = new Date('{{ $electionEnd->toIso8601String() }}').getTime();

        function updateCountdown() {
            const diff = endTime - Date.now();

            if (diff <= 0) {
                ['cd-hours', 'cd-mins', 'cd-secs'].forEach(id => {
                    document.getElementById(id).textContent = '00';
                });
                return;
            }

            const h = Math.floor(diff / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);

            document.getElementById('cd-hours').textContent = String(h).padStart(2, '0');
            document.getElementById('cd-mins').textContent  = String(m).padStart(2, '0');
            document.getElementById('cd-secs').textContent  = String(s).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
    </script>

</x-app-layout>