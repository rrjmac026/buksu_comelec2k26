<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 style="font-family:'Orbitron',sans-serif;font-weight:700;font-size:1.1rem;color:#e0d7ff;letter-spacing:.04em;">
                    My Dashboard
                </h2>
                <p class="flex items-center gap-1.5 mt-0.5" style="font-size:0.7rem;color:#7c6fa0;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#34d399;display:inline-block;animation:vd-pulse 2s infinite;box-shadow:0 0 6px #34d399;"></span>
                    Welcome back, <span style="color:#a78bfa;font-weight:600;margin-left:3px;">{{ auth()->user()->name }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Voter status pill --}}
                @if(auth()->user()->hasVoted())
                    <div style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;background:rgba(52,211,153,0.12);border:1px solid rgba(52,211,153,0.3);">
                        <i class="fas fa-circle-check" style="color:#34d399;font-size:0.75rem;"></i>
                        <span style="font-size:0.72rem;font-weight:700;color:#34d399;">Vote Submitted</span>
                    </div>
                @else
                    <div style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;background:rgba(251,146,60,0.12);border:1px solid rgba(251,146,60,0.3);animation:vd-glowPulse 2.5s infinite;">
                        <i class="fas fa-circle-exclamation" style="color:#fb923c;font-size:0.75rem;"></i>
                        <span style="font-size:0.72rem;font-weight:700;color:#fb923c;">Not Yet Voted</span>
                    </div>
                @endif

                {{-- Vote now button --}}
                @if(!auth()->user()->hasVoted())
                <a href="{{ route('voter.vote') }}"
                   style="display:inline-flex;align-items:center;gap:7px;padding:8px 18px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#4f46e5);color:#fff;font-size:0.75rem;font-weight:700;text-decoration:none;box-shadow:0 0 20px rgba(124,58,237,0.5);transition:all .2s;font-family:'DM Sans',sans-serif;letter-spacing:.01em;"
                   onmouseover="this.style.transform='scale(1.04)';this.style.boxShadow='0 0 30px rgba(124,58,237,0.7)'"
                   onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 0 20px rgba(124,58,237,0.5)'">
                    <i class="fas fa-vote-yea" style="font-size:0.8rem;"></i>
                    Cast My Vote
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing:border-box; }
        :root {
            --glass: rgba(255,255,255,0.05);
            --glass-border: rgba(167,139,250,0.18);
            --glass-bright: rgba(255,255,255,0.08);
            --text-primary: #e0d7ff;
            --text-muted: #52525b;
            --accent: #7c3aed;
            --cyan: #22d3ee;
            --green: #34d399;
            --pink: #f472b6;
            --amber: #fb923c;
        }

        @keyframes vd-pulse { 0%,100%{opacity:1}50%{opacity:.4} }
        @keyframes vd-fadeUp { from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)} }
        @keyframes vd-glowPulse { 0%,100%{box-shadow:0 0 0 rgba(251,146,60,0)}50%{box-shadow:0 0 14px rgba(251,146,60,0.3)} }
        @keyframes vd-shimmer { 0%{background-position:-200% 0}100%{background-position:200% 0} }
        @keyframes vd-spin { to{transform:rotate(360deg)} }
        @keyframes vd-checkBounce { 0%{transform:scale(0)}60%{transform:scale(1.2)}100%{transform:scale(1)} }

        body { font-family:'DM Sans',sans-serif; }

        .vd-gc {
            background:var(--glass);
            backdrop-filter:blur(20px);
            -webkit-backdrop-filter:blur(20px);
            border:1px solid var(--glass-border);
            border-radius:16px;
            box-shadow:0 4px 30px rgba(109,40,217,0.1),inset 0 1px 0 rgba(255,255,255,0.07);
            animation:vd-fadeUp .5s ease both;
        }
        .vd-gc-bright {
            background:var(--glass-bright);
            backdrop-filter:blur(24px);
            -webkit-backdrop-filter:blur(24px);
            border:1px solid rgba(167,139,250,0.25);
            border-radius:16px;
            box-shadow:0 4px 40px rgba(109,40,217,0.15),inset 0 1px 0 rgba(255,255,255,0.1);
        }
        .vd-section-label {
            font-size:.62rem;font-weight:700;letter-spacing:.1em;
            text-transform:uppercase;color:#7c6fa0;
        }
        .vd-card-title {
            font-family:'Orbitron',sans-serif;font-size:.78rem;font-weight:700;
            color:var(--text-primary);letter-spacing:.02em;
        }
        .vd-stat-num {
            font-family:'Orbitron',sans-serif;font-size:1.6rem;font-weight:900;
            background:linear-gradient(135deg,#e0d7ff 0%,#c4b5fd 60%,#818cf8 100%);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
            line-height:1;
        }
        .vd-icon-box {
            width:42px;height:42px;border-radius:12px;
            display:flex;align-items:center;justify-content:center;
            font-size:.95rem;flex-shrink:0;color:#fff;
        }
        .vd-prog-track { height:6px;border-radius:99px;background:rgba(255,255,255,0.07);overflow:hidden; }
        .vd-prog-fill { height:100%;border-radius:99px;transition:width 1.2s cubic-bezier(.4,0,.2,1); }

        /* Voted / Not-voted hero banner */
        .vd-status-banner {
            border-radius:16px;padding:24px 28px;
            display:flex;align-items:center;gap:20px;
            position:relative;overflow:hidden;
        }
        .vd-status-banner::before {
            content:'';position:absolute;inset:0;
            background:linear-gradient(135deg,rgba(255,255,255,.06) 0%,transparent 60%);
            pointer-events:none;
        }
        .vd-status-banner.voted {
            background:linear-gradient(135deg,rgba(52,211,153,0.15),rgba(16,185,129,0.08));
            border:1px solid rgba(52,211,153,0.25);
        }
        .vd-status-banner.not-voted {
            background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(79,70,229,0.1));
            border:1px solid rgba(124,58,237,0.3);
        }
        .vd-check-icon {
            width:60px;height:60px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            flex-shrink:0;font-size:1.6rem;
            animation:vd-checkBounce .6s cubic-bezier(.4,0,.2,1) .3s both;
        }

        /* Candidate card */
        .vd-candidate-card {
            background:rgba(255,255,255,0.04);
            border:1px solid rgba(167,139,250,0.1);
            border-radius:14px;padding:14px;
            display:flex;align-items:center;gap:12px;
            transition:all .25s;cursor:default;
        }
        .vd-candidate-card:hover {
            background:rgba(167,139,250,0.08);
            border-color:rgba(167,139,250,0.22);
            transform:translateY(-2px);
            box-shadow:0 8px 24px rgba(124,58,237,0.12);
        }
        .vd-candidate-avatar {
            width:40px;height:40px;border-radius:12px;
            display:flex;align-items:center;justify-content:center;
            font-size:.8rem;font-weight:700;color:#fff;flex-shrink:0;
        }
        .vd-rank-medal { font-size:.9rem; }

        /* Info row */
        .vd-info-row {
            display:flex;align-items:center;justify-content:space-between;
            padding:10px 0;border-bottom:1px solid rgba(167,139,250,0.08);
        }
        .vd-info-row:last-child { border-bottom:none; }

        /* Vote history pill */
        .vd-vote-pill {
            display:flex;align-items:flex-start;gap:10px;
            padding:10px;border-radius:12px;
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(167,139,250,0.08);
            transition:background .2s;
        }
        .vd-vote-pill:hover { background:rgba(167,139,250,0.06); }

        /* Countdown */
        .vd-countdown-box {
            display:flex;flex-direction:column;align-items:center;
            padding:12px 16px;border-radius:12px;
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(167,139,250,0.15);
            min-width:60px;
        }
        .vd-countdown-num {
            font-family:'Orbitron',sans-serif;font-size:1.4rem;font-weight:900;
            color:#e0d7ff;line-height:1;
        }
        .vd-countdown-lbl { font-size:.58rem;color:#7c6fa0;font-weight:600;letter-spacing:.08em;text-transform:uppercase;margin-top:3px; }

        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:rgba(167,139,250,0.25);border-radius:99px; }
    </style>

    {{-- ═══════════════════════════════════════════
         ROW 1 — VOTING STATUS HERO BANNER
    ═══════════════════════════════════════════ --}}
    @php $hasVoted = auth()->user()->hasVoted(); @endphp

    <div class="vd-status-banner {{ $hasVoted ? 'voted' : 'not-voted' }} mb-5" style="animation:vd-fadeUp .4s ease both;">
        <div class="vd-check-icon" style="background:{{ $hasVoted ? 'rgba(52,211,153,0.2)' : 'rgba(124,58,237,0.2)' }};border:2px solid {{ $hasVoted ? 'rgba(52,211,153,0.4)' : 'rgba(124,58,237,0.4)' }};">
            @if($hasVoted)
                <i class="fas fa-check-double" style="color:#34d399;"></i>
            @else
                <i class="fas fa-ballot-check" style="color:#a78bfa;"></i>
            @endif
        </div>
        <div style="flex:1;">
            <div style="font-family:'Orbitron',sans-serif;font-size:.95rem;font-weight:700;color:#e0d7ff;margin-bottom:4px;">
                @if($hasVoted)
                    Your vote has been recorded!
                @else
                    You haven't voted yet
                @endif
            </div>
            <div style="font-size:.75rem;color:#a78bfa;max-width:520px;">
                @if($hasVoted)
                    Thank you for participating in this election. Your vote is anonymous and securely stored. Results will be announced after the election period ends.
                @else
                    The election is currently open. Exercise your right to vote and make your voice heard. Every vote counts toward shaping the leadership of your organization.
                @endif
            </div>
        </div>
        <div style="flex-shrink:0;text-align:right;">
            @if($hasVoted)
                <div style="font-size:.62rem;color:#7c6fa0;margin-bottom:3px;">Voted on</div>
                <div style="font-family:'Orbitron',sans-serif;font-size:.75rem;color:#34d399;font-weight:700;">
                    {{ auth()->user()->votes()->latest('voted_at')->value('voted_at')?->format('M d, Y · g:i A') ?? '—' }}
                </div>
            @else
                <a href="{{ route('voter.vote') }}"
                   style="display:inline-flex;align-items:center;gap:7px;padding:10px 22px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#4f46e5);color:#fff;font-size:.75rem;font-weight:700;text-decoration:none;box-shadow:0 0 22px rgba(124,58,237,0.5);transition:all .2s;"
                   onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fas fa-vote-yea"></i> Cast My Vote Now
                </a>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         ROW 2 — 4 STAT CARDS
    ═══════════════════════════════════════════ --}}
    @php
        $totalCandidates = \App\Models\Candidate::count();
        $totalPositions  = \App\Models\Position::count();
        $totalVoters     = \App\Models\User::where('role','voter')->count();
        $totalVotesCast  = \App\Models\CastedVote::distinct('voter_id')->count();
        $turnoutPct      = $totalVoters > 0 ? round(($totalVotesCast / $totalVoters) * 100, 1) : 0;
        $myVotesCount    = auth()->user()->votes()->count();

        $statCards = [
            ['label'=>'Total Candidates', 'value'=>$totalCandidates,  'icon'=>'fa-user-tie',     'bg'=>'linear-gradient(135deg,#7c3aed,#4f46e5)', 'glow'=>'rgba(124,58,237,.5)'],
            ['label'=>'Open Positions',   'value'=>$totalPositions,   'icon'=>'fa-list-check',   'bg'=>'linear-gradient(135deg,#0ea5e9,#6366f1)', 'glow'=>'rgba(14,165,233,.5)'],
            ['label'=>'Voter Turnout',    'value'=>$turnoutPct.'%',   'icon'=>'fa-percent',      'bg'=>'linear-gradient(135deg,#d946ef,#7c3aed)', 'glow'=>'rgba(217,70,239,.5)'],
            ['label'=>'My Votes Cast',    'value'=>$myVotesCount,     'icon'=>'fa-check-to-slot','bg'=>'linear-gradient(135deg,#059669,#0891b2)', 'glow'=>'rgba(16,185,129,.5)'],
        ];
    @endphp

    <div class="grid gap-4 mb-5" style="grid-template-columns:repeat(4,1fr);">
        @foreach($statCards as $i => $sc)
        <div class="vd-gc p-4 flex items-center gap-3 hover:scale-[1.02] transition-transform duration-200" style="animation-delay:{{ $i*0.06 }}s">
            <div class="vd-icon-box" style="background:{{ $sc['bg'] }};box-shadow:0 0 18px {{ $sc['glow'] }};">
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
         ROW 3 — PROFILE INFO + TURNOUT RING + ELECTION COUNTDOWN
    ═══════════════════════════════════════════ --}}
    <div class="grid gap-5 mb-5" style="grid-template-columns:1fr 220px 240px;">

        {{-- MY PROFILE CARD --}}
        <div class="vd-gc p-5" style="animation-delay:.12s">
            <div class="flex items-center justify-between mb-4">
                <h3 class="vd-card-title">My Profile</h3>
                <a href="{{ route('profile.edit') }}"
                   style="font-size:.68rem;font-weight:700;color:#a78bfa;text-decoration:none;display:flex;align-items:center;gap:4px;"
                   onmouseover="this.style.color='#c4b5fd'" onmouseout="this.style.color='#a78bfa'">
                    <i class="fas fa-pen" style="font-size:.55rem;"></i> Edit
                </a>
            </div>

            {{-- Avatar + name --}}
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;padding-bottom:16px;border-bottom:1px solid rgba(167,139,250,0.1);">
                <div style="width:52px;height:52px;border-radius:16px;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:700;color:#fff;flex-shrink:0;box-shadow:0 0 18px rgba(124,58,237,0.5);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:.85rem;font-weight:700;color:#e0d7ff;">{{ auth()->user()->name }}</div>
                    <div style="font-size:.68rem;color:#7c6fa0;margin-top:2px;">{{ auth()->user()->email }}</div>
                    <div style="display:inline-flex;align-items:center;gap:4px;margin-top:5px;padding:2px 9px;border-radius:20px;background:rgba(34,211,238,0.1);border:1px solid rgba(34,211,238,0.25);">
                        <span style="width:5px;height:5px;border-radius:50%;background:#22d3ee;display:inline-block;"></span>
                        <span style="font-size:.6rem;font-weight:700;color:#22d3ee;letter-spacing:.06em;">
                            {{ strtoupper(auth()->user()->status ?? 'Active') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Info rows --}}
            @php
                $infos = [
                    ['label'=>'Student No.',  'value'=> auth()->user()->student_number ?? '—',             'icon'=>'fa-id-card'],
                    ['label'=>'College',      'value'=> auth()->user()->college?->name ?? '—',             'icon'=>'fa-building-columns'],
                    ['label'=>'Course',       'value'=> auth()->user()->course ?? '—',                     'icon'=>'fa-book'],
                    ['label'=>'Year Level',   'value'=> auth()->user()->year_level ? 'Year '.auth()->user()->year_level : '—', 'icon'=>'fa-graduation-cap'],
                    ['label'=>'Sex',          'value'=> ucfirst(auth()->user()->sex ?? '—'),               'icon'=>'fa-venus-mars'],
                ];
            @endphp
            <div>
                @foreach($infos as $info)
                <div class="vd-info-row">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <i class="fas {{ $info['icon'] }}" style="width:14px;text-align:center;font-size:.7rem;color:#7c6fa0;"></i>
                        <span style="font-size:.7rem;color:#7c6fa0;">{{ $info['label'] }}</span>
                    </div>
                    <span style="font-size:.72rem;font-weight:600;color:#c4b5fd;text-align:right;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $info['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TURNOUT RING --}}
        <div class="vd-gc p-5 flex flex-col items-center" style="animation-delay:.18s">
            <h3 class="vd-card-title mb-1" style="align-self:flex-start;">Turnout</h3>
            <p class="vd-section-label mb-4" style="align-self:flex-start;">Election participation</p>

            {{-- SVG ring --}}
            <div style="position:relative;width:130px;height:130px;flex-shrink:0;">
                <svg width="130" height="130" viewBox="0 0 130 130" style="transform:rotate(-90deg);">
                    <circle cx="65" cy="65" r="54" fill="none" stroke="rgba(167,139,250,0.1)" stroke-width="12"/>
                    <circle cx="65" cy="65" r="54" fill="none"
                            stroke="url(#turnoutGrad)" stroke-width="12"
                            stroke-linecap="round"
                            stroke-dasharray="{{ round(2 * 3.14159 * 54, 1) }}"
                            stroke-dashoffset="{{ round(2 * 3.14159 * 54 * (1 - $turnoutPct/100), 1) }}"
                            style="transition:stroke-dashoffset 1.5s cubic-bezier(.4,0,.2,1);filter:drop-shadow(0 0 6px rgba(129,140,248,0.6));"/>
                    <defs>
                        <linearGradient id="turnoutGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#818cf8"/>
                            <stop offset="100%" stop-color="#22d3ee"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                    <div style="font-family:'Orbitron',sans-serif;font-size:1.3rem;font-weight:900;color:#e0d7ff;line-height:1;">{{ $turnoutPct }}%</div>
                    <div style="font-size:.58rem;color:#7c6fa0;font-weight:600;letter-spacing:.06em;margin-top:3px;">TURNOUT</div>
                </div>
            </div>

            <div style="width:100%;margin-top:18px;display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:.68rem;">
                    <span style="display:flex;align-items:center;gap:5px;color:#a1a1aa;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#818cf8;display:inline-block;"></span>Voted
                    </span>
                    <span style="font-weight:700;color:#818cf8;">{{ $totalVotesCast }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:.68rem;">
                    <span style="display:flex;align-items:center;gap:5px;color:#a1a1aa;">
                        <span style="width:8px;height:8px;border-radius:50%;background:rgba(167,139,250,0.3);display:inline-block;"></span>Remaining
                    </span>
                    <span style="font-weight:700;color:#7c6fa0;">{{ $totalVoters - $totalVotesCast }}</span>
                </div>
                <div class="vd-prog-track" style="margin-top:4px;">
                    <div class="vd-prog-fill" style="width:{{ $turnoutPct }}%;background:linear-gradient(90deg,#818cf8,#22d3ee);"></div>
                </div>
            </div>
        </div>

        {{-- ELECTION COUNTDOWN --}}
        <div class="vd-gc p-5 flex flex-col" style="animation-delay:.24s">
            <div class="flex items-center justify-between mb-4">
                <h3 class="vd-card-title">Election Period</h3>
                <span style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 8px #34d399;animation:vd-pulse 2s infinite;display:inline-block;"></span>
            </div>

            {{-- Live status --}}
            <div style="padding:10px 14px;border-radius:12px;background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);margin-bottom:16px;">
                <div style="font-size:.62rem;color:#7c6fa0;margin-bottom:2px;">Status</div>
                <div style="font-family:'Orbitron',sans-serif;font-size:.75rem;font-weight:700;color:#34d399;">
                    <i class="fas fa-circle" style="font-size:.45rem;animation:vd-pulse 1.5s infinite;"></i> LIVE NOW
                </div>
            </div>

            {{-- Countdown timer --}}
            <div style="display:flex;gap:8px;justify-content:center;margin-bottom:16px;" id="vd-countdown">
                <div class="vd-countdown-box">
                    <div class="vd-countdown-num" id="cd-hours">00</div>
                    <div class="vd-countdown-lbl">Hours</div>
                </div>
                <div style="display:flex;align-items:center;font-family:'Orbitron',sans-serif;font-size:1.2rem;color:#52525b;padding-bottom:18px;">:</div>
                <div class="vd-countdown-box">
                    <div class="vd-countdown-num" id="cd-mins">00</div>
                    <div class="vd-countdown-lbl">Mins</div>
                </div>
                <div style="display:flex;align-items:center;font-family:'Orbitron',sans-serif;font-size:1.2rem;color:#52525b;padding-bottom:18px;">:</div>
                <div class="vd-countdown-box">
                    <div class="vd-countdown-num" id="cd-secs">00</div>
                    <div class="vd-countdown-lbl">Secs</div>
                </div>
            </div>

            {{-- Election end time (set your actual end time below) --}}
            @php
                $electionEnd = \Carbon\Carbon::parse(config('election.end_date', now()->endOfDay()));
            @endphp
            <div style="text-align:center;margin-bottom:12px;">
                <div style="font-size:.62rem;color:#7c6fa0;">Closes on</div>
                <div style="font-size:.72rem;font-weight:700;color:#c4b5fd;margin-top:2px;">
                    {{ $electionEnd->format('F j, Y · g:i A') }}
                </div>
            </div>

            @if(!$hasVoted)
            <a href="{{ route('voter.vote') }}"
               style="display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#4f46e5);color:#fff;font-size:.72rem;font-weight:700;text-decoration:none;box-shadow:0 0 16px rgba(124,58,237,0.4);transition:all .2s;margin-top:auto;"
               onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-vote-yea"></i> Vote Before Time Runs Out
            </a>
            @else
            <div style="display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;border-radius:12px;background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);margin-top:auto;">
                <i class="fas fa-check-double" style="color:#34d399;font-size:.7rem;"></i>
                <span style="font-size:.72rem;font-weight:700;color:#34d399;">You've already voted!</span>
            </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         ROW 4 — TOP CANDIDATES + MY VOTE HISTORY
    ═══════════════════════════════════════════ --}}
    <div class="grid gap-5 mb-5" style="grid-template-columns:1fr 1fr;">

        {{-- TOP CANDIDATES --}}
        <div class="vd-gc p-5" style="animation-delay:.28s">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="vd-section-label">Leaderboard</p>
                    <h3 class="vd-card-title mt-1">Top Candidates</h3>
                </div>
                <a href="{{ route('voter.results') }}"
                   style="font-size:.68rem;font-weight:700;color:#a78bfa;text-decoration:none;"
                   onmouseover="this.style.color='#c4b5fd'" onmouseout="this.style.color='#a78bfa'">
                    View results <i class="fas fa-arrow-right" style="font-size:.6rem;"></i>
                </a>
            </div>

            @php
                $topCandidates = \App\Models\Candidate::withCount('votes')
                    ->orderByDesc('votes_count')
                    ->limit(6)
                    ->get();
                $maxVotes = $topCandidates->max('votes_count') ?: 1;
                $medals = ['🥇','🥈','🥉'];
                $candidateColors = [
                    'linear-gradient(135deg,#7c3aed,#4f46e5)',
                    'linear-gradient(135deg,#059669,#0891b2)',
                    'linear-gradient(135deg,#d946ef,#7c3aed)',
                    'linear-gradient(135deg,#f59e0b,#ef4444)',
                    'linear-gradient(135deg,#0ea5e9,#6366f1)',
                    'linear-gradient(135deg,#14b8a6,#0ea5e9)',
                ];
            @endphp

            <div style="display:flex;flex-direction:column;gap:10px;">
                @forelse($topCandidates as $i => $c)
                @php $pct = round(($c->votes_count / $maxVotes) * 100); @endphp
                <div class="vd-candidate-card">
                    {{-- Rank --}}
                    <div style="width:22px;text-align:center;flex-shrink:0;">
                        @if($i < 3)
                            <span class="vd-rank-medal">{{ $medals[$i] }}</span>
                        @else
                            <span style="font-size:.72rem;font-weight:700;color:#52525b;">{{ $i+1 }}</span>
                        @endif
                    </div>
                    {{-- Avatar --}}
                    <div class="vd-candidate-avatar" style="background:{{ $candidateColors[$i % count($candidateColors)] }};box-shadow:0 0 10px rgba(124,58,237,0.3);">
                        @if($c->photo)
                            <img src="{{ asset('images/candidates/'.$c->photo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:12px;">
                        @else
                            {{ strtoupper(substr($c->first_name, 0, 1)) }}
                        @endif
                    </div>
                    {{-- Info --}}
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                            <span style="font-size:.72rem;font-weight:600;color:#e0d7ff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;">
                                {{ $c->first_name }} {{ $c->last_name }}
                            </span>
                            <span style="font-size:.7rem;font-weight:700;color:#818cf8;margin-left:6px;flex-shrink:0;">{{ $c->votes_count }} votes</span>
                        </div>
                        <div class="vd-prog-track">
                            <div class="vd-prog-fill" style="width:{{ $pct }}%;background:linear-gradient(90deg,#7c3aed,#22d3ee);"></div>
                        </div>
                        <div style="font-size:.6rem;color:#52525b;margin-top:3px;">
                            {{ $c->position?->name ?? '—' }} · {{ $c->partylist?->name ?? '—' }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:30px;color:#52525b;font-size:.75rem;">
                    <i class="fas fa-user-tie" style="font-size:1.5rem;margin-bottom:8px;display:block;opacity:.3;"></i>
                    No candidates yet
                </div>
                @endforelse
            </div>
        </div>

        {{-- MY VOTE HISTORY --}}
        <div class="vd-gc p-5" style="animation-delay:.32s">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="vd-section-label">History</p>
                    <h3 class="vd-card-title mt-1">My Votes</h3>
                </div>
                @if($hasVoted)
                <span style="font-size:.65rem;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(52,211,153,0.12);border:1px solid rgba(52,211,153,0.25);color:#34d399;">
                    {{ $myVotesCount }} vote{{ $myVotesCount !== 1 ? 's' : '' }} cast
                </span>
                @endif
            </div>

            @php
                $myVotes = auth()->user()->votes()
                    ->with(['candidate', 'position'])
                    ->latest('voted_at')
                    ->get();
            @endphp

            @if($myVotes->isEmpty())
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:200px;text-align:center;">
                <div style="width:60px;height:60px;border-radius:50%;background:rgba(124,58,237,0.1);border:2px dashed rgba(124,58,237,0.3);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                    <i class="fas fa-ballot" style="color:#52525b;font-size:1.2rem;"></i>
                </div>
                <div style="font-size:.78rem;font-weight:600;color:#52525b;margin-bottom:6px;">No votes yet</div>
                <div style="font-size:.68rem;color:#3f3f46;margin-bottom:16px;">You haven't cast any votes in this election.</div>
                <a href="{{ route('voter.vote') }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#4f46e5);color:#fff;font-size:.72rem;font-weight:700;text-decoration:none;box-shadow:0 0 16px rgba(124,58,237,0.4);">
                    <i class="fas fa-vote-yea" style="font-size:.7rem;"></i> Vote Now
                </a>
            </div>
            @else
            <div style="display:flex;flex-direction:column;gap:8px;overflow-y:auto;max-height:340px;">
                @foreach($myVotes as $vote)
                <div class="vd-vote-pill">
                    <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#059669,#0891b2);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 10px rgba(16,185,129,0.3);">
                        <i class="fas fa-check" style="color:#fff;font-size:.65rem;"></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.72rem;font-weight:600;color:#e0d7ff;">
                            {{ $vote->candidate ? $vote->candidate->first_name.' '.$vote->candidate->last_name : '—' }}
                        </div>
                        <div style="font-size:.65rem;color:#a78bfa;margin-top:1px;">
                            {{ $vote->position?->name ?? $vote->candidate?->position?->name ?? '—' }}
                        </div>
                        <div style="font-size:.6rem;color:#52525b;margin-top:2px;">
                            {{ $vote->voted_at?->format('M d, Y · g:i A') ?? '—' }}
                        </div>
                    </div>
                    <div style="flex-shrink:0;">
                        <div style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 6px #34d399;"></div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Note about anonymity --}}
            <div style="margin-top:14px;padding:10px 12px;border-radius:10px;background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.15);display:flex;align-items:flex-start;gap:8px;">
                <i class="fas fa-shield-halved" style="color:#a78bfa;font-size:.75rem;margin-top:1px;flex-shrink:0;"></i>
                <p style="font-size:.62rem;color:#7c6fa0;margin:0;line-height:1.5;">
                    Your votes are securely recorded and anonymous. Candidate names are shown here for your reference only.
                </p>
            </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         ROW 5 — ALL POSITIONS OVERVIEW
    ═══════════════════════════════════════════ --}}
    <div class="vd-gc-bright p-5" style="animation:vd-fadeUp .5s ease both;animation-delay:.36s;">
        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="vd-section-label">Overview</p>
                <h3 class="vd-card-title mt-1">Positions & Candidates</h3>
            </div>
            @if(!$hasVoted)
            <a href="{{ route('voter.vote') }}"
               style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#4f46e5);color:#fff;font-size:.72rem;font-weight:700;text-decoration:none;box-shadow:0 0 16px rgba(124,58,237,0.4);">
                <i class="fas fa-vote-yea" style="font-size:.65rem;"></i> Go Vote
            </a>
            @endif
        </div>

        @php
            $positions = \App\Models\Position::with(['candidates' => function($q){
                $q->withCount('votes')->orderByDesc('votes_count');
            }])->get();
        @endphp

        <div class="grid gap-4" style="grid-template-columns:repeat(auto-fill,minmax(280px,1fr));">
            @forelse($positions as $pos)
            @php
                $posMax = $pos->candidates->max('votes_count') ?: 1;
                $posColors = ['linear-gradient(135deg,#7c3aed,#4f46e5)','linear-gradient(135deg,#059669,#0891b2)','linear-gradient(135deg,#d946ef,#7c3aed)','linear-gradient(135deg,#f59e0b,#ef4444)','linear-gradient(135deg,#0ea5e9,#6366f1)'];
            @endphp
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(167,139,250,0.1);border-radius:14px;padding:14px;">
                {{-- Position header --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;padding-bottom:10px;border-bottom:1px solid rgba(167,139,250,0.1);">
                    <div style="font-size:.72rem;font-weight:700;color:#c4b5fd;font-family:'Orbitron',sans-serif;letter-spacing:.02em;">
                        {{ $pos->name }}
                    </div>
                    <span style="font-size:.6rem;font-weight:700;padding:2px 8px;border-radius:20px;background:rgba(129,140,248,0.12);border:1px solid rgba(129,140,248,0.2);color:#818cf8;">
                        {{ $pos->candidates->count() }} candidates
                    </span>
                </div>

                {{-- Top 3 candidates for this position --}}
                <div style="display:flex;flex-direction:column;gap:7px;">
                    @forelse($pos->candidates->take(3) as $j => $c)
                    @php $cpct = round(($c->votes_count / $posMax) * 100); @endphp
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:#fff;flex-shrink:0;background:{{ $posColors[$j % count($posColors)] }};">
                            @if($c->photo)
                                <img src="{{ asset('images/candidates/'.$c->photo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                            @else
                                {{ strtoupper(substr($c->first_name,0,1)) }}
                            @endif
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:3px;">
                                <span style="font-size:.65rem;font-weight:600;color:#e0d7ff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px;">{{ $c->first_name }} {{ $c->last_name }}</span>
                                <span style="font-size:.62rem;font-weight:700;color:#7c6fa0;flex-shrink:0;margin-left:4px;">{{ $c->votes_count }}</span>
                            </div>
                            <div class="vd-prog-track" style="height:4px;">
                                <div class="vd-prog-fill" style="width:{{ $cpct }}%;background:{{ $j===0?'linear-gradient(90deg,#f59e0b,#fb923c)':($j===1?'linear-gradient(90deg,#818cf8,#22d3ee)':'linear-gradient(90deg,#52525b,#71717a)') }};"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="font-size:.65rem;color:#52525b;text-align:center;padding:8px 0;">No candidates</div>
                    @endforelse

                    @if($pos->candidates->count() > 3)
                    <div style="font-size:.62rem;color:#7c6fa0;text-align:center;margin-top:3px;">
                        +{{ $pos->candidates->count() - 3 }} more candidates
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:30px;color:#52525b;font-size:.75rem;grid-column:1/-1;">
                No positions configured yet
            </div>
            @endforelse
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         SCRIPTS: Countdown timer
    ═══════════════════════════════════════════ --}}
    <script>
    (() => {
        // ── Countdown to election end ─────────────────────────────
        const endTime = new Date('{{ $electionEnd->toIso8601String() }}').getTime();

        function updateCountdown() {
            const now = Date.now();
            const diff = endTime - now;

            if (diff <= 0) {
                document.getElementById('cd-hours').textContent = '00';
                document.getElementById('cd-mins').textContent  = '00';
                document.getElementById('cd-secs').textContent  = '00';
                return;
            }

            const h = Math.floor(diff / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);

            document.getElementById('cd-hours').textContent = String(h).padStart(2,'0');
            document.getElementById('cd-mins').textContent  = String(m).padStart(2,'0');
            document.getElementById('cd-secs').textContent  = String(s).padStart(2,'0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
    </script>

</x-app-layout>