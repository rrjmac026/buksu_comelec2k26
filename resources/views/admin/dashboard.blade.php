<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 style="font-family:'Orbitron',sans-serif;font-weight:700;font-size:1.1rem;color:#e0d7ff;letter-spacing:.04em;">
                    Admin Dashboard
                </h2>
                <p class="flex items-center gap-1.5 mt-0.5" style="font-size:0.7rem;color:#7c6fa0;">
                    <span id="live-dot" style="width:7px;height:7px;border-radius:50%;background:#34d399;display:inline-block;animation:pulse 2s infinite;box-shadow:0 0 6px #34d399;"></span>
                    Live · Last updated: <span id="last-updated" style="color:#a78bfa;font-weight:600;">—</span>
                </p>
            </div>
            <div class="flex items-center gap-3">
                <select id="refresh-interval"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(167,139,250,0.2);border-radius:10px;padding:6px 10px;font-size:0.72rem;color:#c4b5fd;outline:none;font-family:'DM Sans',sans-serif;cursor:pointer;">
                    <option value="5000">5s</option>
                    <option value="10000" selected>10s</option>
                    <option value="30000">30s</option>
                    <option value="0">Off</option>
                </select>
            </div>
        </div>
    </x-slot>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        :root {
            --glass: rgba(255,255,255,0.05);
            --glass-border: rgba(167,139,250,0.18);
            --glass-bright: rgba(255,255,255,0.08);
            --text-primary: #e0d7ff;
            --text-secondary: #a78bfa;
            --text-muted: #52525b;
            --accent: #7c3aed;
            --accent2: #4f46e5;
            --cyan: #22d3ee;
            --green: #34d399;
            --pink: #f472b6;
        }

        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
        @keyframes fadeInUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        @keyframes spin { to{transform:rotate(360deg)} }
        @keyframes glowPulse { 0%,100%{box-shadow:0 0 20px rgba(124,58,237,0.4)} 50%{box-shadow:0 0 40px rgba(124,58,237,0.7)} }
        @keyframes needleSpin { from{transform:rotate(-120deg)} to{transform:rotate(var(--needle-angle,-30deg))} }

        body, .dashboard-wrap { font-family:'DM Sans',sans-serif; }

        .gc { /* glass card */
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(109,40,217,0.1), inset 0 1px 0 rgba(255,255,255,0.07);
            animation: fadeInUp .5s ease both;
        }
        .gc-bright {
            background: var(--glass-bright);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(167,139,250,0.25);
            border-radius: 16px;
            box-shadow: 0 4px 40px rgba(109,40,217,0.15), inset 0 1px 0 rgba(255,255,255,0.1);
        }

        .section-label {
            font-size:0.65rem;font-weight:700;letter-spacing:.1em;
            text-transform:uppercase;color:#7c6fa0;
        }
        .card-title {
            font-family:'Orbitron',sans-serif;font-size:0.78rem;font-weight:700;
            color:var(--text-primary);letter-spacing:.02em;
        }
        .stat-number {
            font-family:'Orbitron',sans-serif;font-size:1.55rem;font-weight:900;
            background:linear-gradient(135deg,#e0d7ff 0%,#c4b5fd 60%,#818cf8 100%);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
            line-height:1;
        }
        .stat-delta {
            font-size:0.65rem;font-weight:700;color:#34d399;
            display:flex;align-items:center;gap:2px;
        }
        .stat-delta.neg { color:#f87171; }

        .neon-badge {
            display:inline-flex;align-items:center;gap:4px;
            background:rgba(109,40,217,0.25);
            border:1px solid rgba(167,139,250,0.35);
            color:#c4b5fd;font-size:0.65rem;font-weight:700;
            padding:3px 10px;border-radius:20px;letter-spacing:.05em;
        }
        .icon-box {
            width:40px;height:40px;border-radius:12px;
            display:flex;align-items:center;justify-content:center;
            font-size:0.9rem;flex-shrink:0;color:#fff;
        }
        .prog-bar { height:5px;border-radius:99px;background:rgba(255,255,255,0.07); }
        .prog-fill { height:100%;border-radius:99px;background:linear-gradient(90deg,#7c3aed,#22d3ee);transition:width .8s cubic-bezier(.4,0,.2,1); }

        .vote-row {
            display:flex;align-items:flex-start;gap:10px;
            padding:9px;border-radius:12px;
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(167,139,250,0.08);
            transition:background .2s;
        }
        .vote-row:hover { background:rgba(167,139,250,0.06); }

        .member-row {
            display:flex;align-items:center;gap:10px;
            padding:8px 10px;border-radius:12px;
            transition:background .2s;cursor:pointer;
        }
        .member-row:hover { background:rgba(167,139,250,0.07); }
        .member-avatar {
            width:34px;height:34px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            font-size:0.75rem;font-weight:700;color:#fff;flex-shrink:0;
        }

        /* Gauge */
        .gauge-wrap { position:relative;width:130px;height:80px;margin:0 auto; }
        .gauge-svg { width:130px;height:80px; }
        .gauge-needle {
            position:absolute;bottom:4px;left:50%;
            width:2px;height:52px;
            background:linear-gradient(to top,#f472b6,transparent);
            transform-origin:bottom center;
            border-radius:2px;
            animation:needleSpin 1.5s cubic-bezier(.4,0,.2,1) both .3s;
        }
        .gauge-dot {
            position:absolute;bottom:0px;left:50%;
            transform:translateX(-50%);
            width:10px;height:10px;border-radius:50%;
            background:#f472b6;box-shadow:0 0 10px #f472b6;
        }

        /* Table */
        .dash-table th {
            font-size:0.65rem;font-weight:700;letter-spacing:.08em;
            text-transform:uppercase;color:#7c6fa0;
            padding:10px 12px;text-align:left;
            border-bottom:1px solid rgba(167,139,250,0.12);
        }
        .dash-table td {
            padding:10px 12px;font-size:0.75rem;color:var(--text-primary);
            border-bottom:1px solid rgba(167,139,250,0.06);
        }
        .dash-table tr:hover td { background:rgba(167,139,250,0.05); }
        .dash-table tr:last-child td { border-bottom:none; }

        .status-badge {
            display:inline-block;padding:2px 10px;border-radius:20px;
            font-size:0.65rem;font-weight:700;letter-spacing:.04em;
        }
        .status-active { background:rgba(52,211,153,0.15);color:#34d399;border:1px solid rgba(52,211,153,0.3); }
        .status-new { background:rgba(34,211,238,0.15);color:#22d3ee;border:1px solid rgba(34,211,238,0.3); }
        .status-pending { background:rgba(251,146,60,0.15);color:#fb923c;border:1px solid rgba(251,146,60,0.3); }

        /* Scrollbar */
        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:rgba(167,139,250,0.25);border-radius:99px; }

        .dot-menu { color:#7c6fa0;cursor:pointer;font-size:1rem;transition:color .2s; }
        .dot-menu:hover { color:#c4b5fd; }
    </style>

    {{-- ══════════════════════════════════════════════════════════
         ROW 1 — STAT CARDS (8 metrics)
    ══════════════════════════════════════════════════════════ --}}
    @php
        $cards = [
            ['id'=>'stat-voters',     'label'=>'Total Voters',   'icon'=>'fa-users',             'glow'=>'rgba(124,58,237,.6)',  'bg'=>'linear-gradient(135deg,#7c3aed,#4f46e5)', 'value'=> $stats['total_voters'],     'delta'=>'+5.57%'],
            ['id'=>'stat-votes',      'label'=>'Votes Cast',      'icon'=>'fa-check-to-slot',     'glow'=>'rgba(16,185,129,.6)', 'bg'=>'linear-gradient(135deg,#059669,#0891b2)', 'value'=> $stats['total_votes'],      'delta'=>'+29.75%'],
            ['id'=>'stat-candidates', 'label'=>'Candidates',      'icon'=>'fa-user-tie',          'glow'=>'rgba(14,165,233,.6)', 'bg'=>'linear-gradient(135deg,#0ea5e9,#6366f1)', 'value'=> $stats['total_candidates'], 'delta'=>'+4.88%'],
            ['id'=>'stat-positions',  'label'=>'Positions',       'icon'=>'fa-list-check',        'glow'=>'rgba(245,158,11,.6)', 'bg'=>'linear-gradient(135deg,#f59e0b,#ef4444)', 'value'=> $stats['total_positions'],  'delta'=>'+2.1%'],
            ['id'=>'stat-partylists', 'label'=>'Partylists',      'icon'=>'fa-flag',              'glow'=>'rgba(239,68,68,.6)',  'bg'=>'linear-gradient(135deg,#ef4444,#ec4899)', 'value'=> $stats['total_partylists'], 'delta'=>'+1.3%'],
            ['id'=>'stat-colleges',   'label'=>'Colleges',        'icon'=>'fa-building-columns',  'glow'=>'rgba(99,102,241,.6)', 'bg'=>'linear-gradient(135deg,#6366f1,#8b5cf6)', 'value'=> $stats['total_colleges'],  'delta'=>'Stable'],
            ['id'=>'stat-orgs',       'label'=>'Organizations',   'icon'=>'fa-sitemap',           'glow'=>'rgba(20,184,166,.6)', 'bg'=>'linear-gradient(135deg,#14b8a6,#0ea5e9)', 'value'=> $stats['total_orgs'],      'delta'=>'+3.2%'],
            ['id'=>'stat-turnout',    'label'=>'Voter Turnout',   'icon'=>'fa-percent',           'glow'=>'rgba(217,70,239,.6)', 'bg'=>'linear-gradient(135deg,#d946ef,#7c3aed)', 'value'=> '—',                        'delta'=>'Live'],
        ];
    @endphp

    <div class="grid gap-4 mb-5" style="grid-template-columns:repeat(4,1fr);">
        @foreach($cards as $i => $card)
        <div class="gc p-4 flex items-center gap-3 hover:scale-[1.02] transition-transform duration-200" style="animation-delay:{{ $i * 0.05 }}s">
            <div class="icon-box" style="background:{{ $card['bg'] }};box-shadow:0 0 20px {{ $card['glow'] }};">
                <i class="fas {{ $card['icon'] }}"></i>
            </div>
            <div class="min-w-0">
                <div id="{{ $card['id'] }}" class="stat-number tabular-nums">{{ $card['value'] }}</div>
                <div class="section-label mt-1">{{ $card['label'] }}</div>
                <div class="stat-delta mt-0.5{{ str_starts_with($card['delta'],'-') ? ' neg' : '' }}">
                    <i class="fas fa-arrow-{{ str_starts_with($card['delta'],'-') ? 'down' : 'up' }}" style="font-size:0.55rem;"></i>
                    {{ $card['delta'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════════════
         ROW 2 — DATA ANALYTICS (big) + RECENT ACTIVITY (right)
    ══════════════════════════════════════════════════════════ --}}
    <div class="grid gap-5 mb-5" style="grid-template-columns:1fr 320px;">

        {{-- DATA ANALYTICS CARD — copied from reference image --}}
        <div style="background:rgba(255,255,255,0.07);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(167,139,250,0.22);border-radius:18px;box-shadow:0 4px 40px rgba(109,40,217,0.18),inset 0 1px 0 rgba(255,255,255,0.1);padding:20px;animation:fadeInUp .5s ease both;animation-delay:.1s;">

            {{-- TOP BAR: title left, All+Filters right (exactly like image) --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <h3 style="font-family:'Orbitron',sans-serif;font-size:0.85rem;font-weight:700;color:#e0d7ff;letter-spacing:.02em;margin:0;">Data Analytics</h3>
                <div style="display:flex;gap:8px;">
                    <button style="display:flex;align-items:center;gap:5px;background:rgba(255,255,255,0.08);border:1px solid rgba(167,139,250,0.25);border-radius:8px;padding:4px 12px;font-size:0.7rem;color:#c4b5fd;cursor:pointer;font-family:'DM Sans',sans-serif;">
                        All <i class="fas fa-chevron-down" style="font-size:0.55rem;"></i>
                    </button>
                    <button style="display:flex;align-items:center;gap:5px;background:rgba(255,255,255,0.08);border:1px solid rgba(167,139,250,0.25);border-radius:8px;padding:4px 12px;font-size:0.7rem;color:#c4b5fd;cursor:pointer;font-family:'DM Sans',sans-serif;">
                        Filters <i class="fas fa-chevron-down" style="font-size:0.55rem;"></i>
                    </button>
                </div>
            </div>

            {{-- 3 METRIC NUMBERS (like image: Total / Average / Earnrange analysis) --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:0;margin-bottom:14px;border-bottom:1px solid rgba(167,139,250,0.1);padding-bottom:14px;">
                <div>
                    <div style="font-size:0.65rem;color:#a78bfa;font-weight:500;margin-bottom:2px;">Total</div>
                    <div id="analytic-voters" style="font-family:'Orbitron',sans-serif;font-size:1.35rem;font-weight:900;background:linear-gradient(135deg,#22d3ee,#818cf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">{{ number_format($stats['total_voters']) }}</div>
                    <div style="display:flex;align-items:center;gap:3px;margin-top:3px;">
                        <i class="fas fa-arrow-up" style="font-size:0.5rem;color:#34d399;"></i>
                        <span id="analytic-voters-delta" style="font-size:0.65rem;font-weight:700;color:#34d399;">—</span>
                    </div>
                </div>
                <div>
                    <div style="font-size:0.65rem;color:#a78bfa;font-weight:500;margin-bottom:2px;">Votes Cast</div>
                    <div id="analytic-votes" style="font-family:'Orbitron',sans-serif;font-size:1.35rem;font-weight:900;background:linear-gradient(135deg,#22d3ee,#818cf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">{{ number_format($stats['total_votes']) }}</div>
                    <div style="display:flex;align-items:center;gap:3px;margin-top:3px;">
                        <i class="fas fa-arrow-up" style="font-size:0.5rem;color:#34d399;"></i>
                        <span id="analytic-votes-delta" style="font-size:0.65rem;font-weight:700;color:#34d399;">—</span>
                    </div>
                </div>
                <div>
                    <div style="font-size:0.65rem;color:#a78bfa;font-weight:500;margin-bottom:2px;">Turnout Rate</div>
                    <div id="analytic-turnout" style="font-family:'Orbitron',sans-serif;font-size:1.35rem;font-weight:900;background:linear-gradient(135deg,#22d3ee,#818cf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">—%</div>
                    <div style="display:flex;align-items:center;gap:3px;margin-top:3px;">
                        <i class="fas fa-arrow-up" style="font-size:0.5rem;color:#34d399;"></i>
                        <span style="font-size:0.65rem;font-weight:700;color:#34d399;">Live · <span id="refresh-label">10s</span></span>
                    </div>
                </div>
            </div>

            {{-- 3-COLUMN CHARTS: Line | Bar | Pie (exact layout from image) --}}
            <div style="display:grid;grid-template-columns:1fr 1fr 200px;gap:16px;align-items:end;">

                {{-- LEFT: Line Chart (two lines, cyan + purple, filled, smooth — like image left chart) --}}
                <div>
                    <div style="position:relative;height:150px;">
                        <canvas id="chartLine"></canvas>
                    </div>
                    {{-- X axis labels like image --}}
                    <div style="display:flex;justify-content:space-between;padding:0 4px;margin-top:4px;">
                        <span style="font-size:0.6rem;color:#52525b;">Jan</span>
                        <span style="font-size:0.6rem;color:#52525b;">Feb</span>
                        <span style="font-size:0.6rem;color:#52525b;">Mar</span>
                        <span style="font-size:0.6rem;color:#52525b;">Apr</span>
                        <span style="font-size:0.6rem;color:#52525b;">May</span>
                    </div>
                </div>

                {{-- MIDDLE: Grouped Bar Chart (cyan + purple alternating bars — like image middle) --}}
                <div>
                    <div style="position:relative;height:150px;">
                        <canvas id="chartBar"></canvas>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:0 4px;margin-top:4px;">
                        <span style="font-size:0.6rem;color:#52525b;">Jan</span>
                        <span style="font-size:0.6rem;color:#52525b;">Feb</span>
                        <span style="font-size:0.6rem;color:#52525b;">Mar</span>
                        <span style="font-size:0.6rem;color:#52525b;">Apr</span>
                        <span style="font-size:0.6rem;color:#52525b;">May</span>
                    </div>
                </div>

                {{-- RIGHT: Large Pie/Doughnut + legend (like image right side) --}}
                <div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                    {{-- Pie chart — no center text, matches image --}}
                    <div style="position:relative;width:140px;height:140px;">
                        <canvas id="chartTurnout" style="position:absolute;top:0;left:0;width:140px!important;height:140px!important;"></canvas>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;">
                            <div id="turnout-center-pct" style="font-family:'Orbitron',sans-serif;font-size:1rem;font-weight:900;color:#e0d7ff;"></div>
                        </div>
                    </div>
                    {{-- Legend exactly like image --}}
                    <div style="width:100%;display:flex;flex-direction:column;gap:6px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span style="display:flex;align-items:center;gap:6px;font-size:0.68rem;color:#c4b5fd;">
                                <span style="width:10px;height:10px;border-radius:50%;background:#22d3ee;display:inline-block;box-shadow:0 0 6px #22d3ee;flex-shrink:0;"></span>
                                Voted
                            </span>
                            <span id="pct-voted" style="font-size:0.72rem;font-weight:700;color:#e0d7ff;">—%</span>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span style="display:flex;align-items:center;gap:6px;font-size:0.68rem;color:#c4b5fd;">
                                <span style="width:10px;height:10px;border-radius:50%;background:#818cf8;display:inline-block;box-shadow:0 0 6px #818cf8;flex-shrink:0;"></span>
                                Not yet
                            </span>
                            <span id="pct-not" style="font-size:0.72rem;font-weight:700;color:#e0d7ff;">—%</span>
                        </div>
                        <div style="margin-top:2px;padding:6px 8px;border-radius:8px;background:rgba(34,211,238,0.07);border:1px solid rgba(34,211,238,0.15);text-align:center;">
                            <div style="font-size:0.6rem;color:#7c6fa0;">Remaining</div>
                            <div id="remaining-voters" style="font-family:'Orbitron',sans-serif;font-size:0.78rem;font-weight:700;color:#22d3ee;margin-top:1px;">—</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RECENT ACTIVITY CARD --}}
        <div class="gc p-5" style="animation-delay:.15s">
            <div class="flex items-center justify-between mb-4">
                <h3 class="card-title">Recent Activity</h3>
                <span class="dot-menu">···</span>
            </div>
            <div id="recent-votes-list" class="space-y-2 overflow-y-auto" style="max-height:340px;">
                @foreach($recentVotes as $vote)
                <div class="vote-row">
                    <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.65rem;font-weight:700;color:#fff;">
                        {{ strtoupper(substr($vote->voter?->name ?? 'U', 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.72rem;font-weight:600;color:#e0d7ff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $vote->voter?->name ?? 'Unknown' }}
                        </div>
                        <div style="font-size:0.65rem;color:#7c6fa0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $vote->candidate ? $vote->candidate->first_name.' '.$vote->candidate->last_name : '—' }}
                        </div>
                        <div style="font-size:0.62rem;color:#52525b;margin-top:1px;">{{ $vote->voted_at?->diffForHumans() ?? '—' }}</div>
                    </div>
                    <div style="width:7px;height:7px;border-radius:50%;background:#34d399;flex-shrink:0;margin-top:4px;box-shadow:0 0 6px #34d399;"></div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('admin.votes.index') }}"
               style="display:flex;align-items:center;justify-content:center;gap:5px;margin-top:14px;font-size:0.7rem;font-weight:700;color:#a78bfa;text-decoration:none;padding:8px;border-radius:10px;background:rgba(124,58,237,0.1);border:1px solid rgba(124,58,237,0.2);transition:background .2s;"
               onmouseover="this.style.background='rgba(124,58,237,0.2)'" onmouseout="this.style.background='rgba(124,58,237,0.1)'">
                View all activity <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i>
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         ROW 3 — SYSTEM STATUS + TEAM MEMBERS + TOP CANDIDATES
    ══════════════════════════════════════════════════════════ --}}
    <div class="grid gap-5 mb-5" style="grid-template-columns:220px 260px 1fr;">

        {{-- SYSTEM STATUS CARD --}}
        <div class="gc p-5 flex flex-col" style="animation-delay:.2s">
            <div class="flex items-center justify-between mb-3">
                <h3 class="card-title">System Status</h3>
                <span class="dot-menu">···</span>
            </div>

            {{-- Gauge speedometer --}}
            <div style="position:relative;width:140px;height:90px;margin:8px auto 4px;">
                <svg viewBox="0 0 140 80" width="140" height="80" style="display:block;">
                    {{-- Background arc --}}
                    <path d="M 15 75 A 55 55 0 0 1 125 75"
                          fill="none" stroke="rgba(167,139,250,0.12)" stroke-width="14" stroke-linecap="round"/>
                    {{-- Colored arc segments --}}
                    <path d="M 15 75 A 55 55 0 0 1 52 23"
                          fill="none" stroke="#34d399" stroke-width="14" stroke-linecap="round" opacity=".7"/>
                    <path d="M 52 23 A 55 55 0 0 1 88 23"
                          fill="none" stroke="#22d3ee" stroke-width="14" stroke-linecap="round" opacity=".7"/>
                    <path d="M 88 23 A 55 55 0 0 1 125 75"
                          fill="none" stroke="#f472b6" stroke-width="14" stroke-linecap="round" opacity=".7"/>
                    {{-- Glow overlay --}}
                    <path d="M 15 75 A 55 55 0 0 1 125 75"
                          fill="none" stroke="url(#gaugeGrad)" stroke-width="6" stroke-linecap="round" opacity=".9"/>
                    <defs>
                        <linearGradient id="gaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#34d399"/>
                            <stop offset="50%" stop-color="#22d3ee"/>
                            <stop offset="100%" stop-color="#f472b6"/>
                        </linearGradient>
                    </defs>
                    {{-- Center dot --}}
                    <circle cx="70" cy="75" r="5" fill="#f472b6" style="filter:drop-shadow(0 0 6px #f472b6)"/>
                </svg>
                {{-- Needle (CSS animated) --}}
                <div id="gauge-needle" style="position:absolute;bottom:8px;left:50%;width:2px;height:50px;background:linear-gradient(to top,#f472b6,rgba(244,114,182,0));transform-origin:bottom center;border-radius:2px;transform:translateX(-50%) rotate(-30deg);transition:transform 1.5s cubic-bezier(.4,0,.2,1);">
                </div>
            </div>

            <div style="text-align:center;margin-bottom:12px;">
                <div id="system-status-label" style="font-family:'Orbitron',sans-serif;font-size:0.75rem;font-weight:700;color:#34d399;">Operational</div>
                <div style="font-size:0.62rem;color:#52525b;margin-top:2px;">All systems normal</div>
            </div>

            {{-- Status metrics --}}
            <div class="space-y-2">
                @php
                    $metrics = [
                        ['label'=>'Uptime',     'val'=>'99.9%', 'pct'=>99, 'color'=>'#34d399'],
                        ['label'=>'Response',   'val'=>'42ms',  'pct'=>85, 'color'=>'#22d3ee'],
                        ['label'=>'Load',       'val'=>'23%',   'pct'=>23, 'color'=>'#f472b6'],
                    ];
                @endphp
                @foreach($metrics as $m)
                <div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:3px;">
                        <span style="font-size:0.65rem;color:#7c6fa0;">{{ $m['label'] }}</span>
                        <span style="font-size:0.65rem;font-weight:700;color:{{ $m['color'] }};">{{ $m['val'] }}</span>
                    </div>
                    <div class="prog-bar">
                        <div class="prog-fill" style="width:{{ $m['pct'] }}%;background:linear-gradient(90deg,{{ $m['color'] }}99,{{ $m['color'] }});"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TEAM MEMBERS CARD --}}
        <div class="gc p-5" style="animation-delay:.25s">
            <div class="flex items-center justify-between mb-3">
                <h3 class="card-title">Team Members</h3>
                <span class="dot-menu">···</span>
            </div>

            @php
                $memberColors = [
                    'linear-gradient(135deg,#7c3aed,#4f46e5)',
                    'linear-gradient(135deg,#059669,#0891b2)',
                    'linear-gradient(135deg,#d946ef,#7c3aed)',
                    'linear-gradient(135deg,#f59e0b,#ef4444)',
                    'linear-gradient(135deg,#0ea5e9,#6366f1)',
                ];
                $memberRoles = ['President','Vice President','Secretary','Treasurer','Auditor'];
            @endphp

            <div class="space-y-1" id="team-members-list">
                @foreach($teamMembers->take(5) as $i => $c)
                <div class="member-row">
                    <div class="member-avatar" style="background:{{ $memberColors[$i % count($memberColors)] }};box-shadow:0 0 10px rgba(124,58,237,0.35);">
                        {{ strtoupper(substr($c->name, 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.72rem;font-weight:600;color:#e0d7ff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $c->name }}
                        </div>
                        <div style="font-size:0.62rem;color:#7c6fa0;">
                            {{ ucfirst($c->role) }}
                        </div>
                    </div>
                    <div style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 6px #34d399;flex-shrink:0;"></div>
                </div>
                @endforeach
            </div>

            <div style="margin-top:14px;padding-top:12px;border-top:1px solid rgba(167,139,250,0.1);">
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.68rem;color:#7c6fa0;">
                    <span>{{ $teamMembers->count() }} admin{{ $teamMembers->count() !== 1 ? 's' : '' }} total</span>
                    <a href="{{ route('admin.candidates.index') }}"
                       style="color:#a78bfa;font-weight:700;text-decoration:none;font-size:0.68rem;">
                        View all <i class="fas fa-arrow-right" style="font-size:0.6rem;"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- TOP CANDIDATES (right side of row 3) --}}
        <div class="gc p-5" style="animation-delay:.3s">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="section-label">Leaderboard</p>
                    <h3 class="card-title mt-1">Top Candidates</h3>
                </div>
                <a href="{{ route('admin.votes.results') }}"
                   style="font-size:0.68rem;font-weight:700;color:#a78bfa;text-decoration:none;">
                    View all <i class="fas fa-arrow-right" style="font-size:0.6rem;"></i>
                </a>
            </div>
            <div id="top-candidates-list" class="space-y-3">
                @foreach($topCandidates as $i => $c)
                @php $pct = $stats['total_votes'] > 0 ? round(($c->votes_count / $stats['total_votes']) * 100, 1) : 0; @endphp
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="width:18px;font-size:0.7rem;font-weight:700;color:{{ $i===0?'#f59e0b':($i===1?'#a1a1aa':($i===2?'#fb923c':'#52525b')) }};text-align:center;flex-shrink:0;">{{ $i+1 }}</span>
                    <div style="width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:700;flex-shrink:0;box-shadow:0 0 10px rgba(124,58,237,0.4);">
                        {{ strtoupper(substr($c->first_name, 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                            <span style="font-size:0.72rem;font-weight:600;color:#e0d7ff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">{{ $c->first_name }} {{ $c->last_name }}</span>
                            <span style="font-size:0.7rem;font-weight:700;color:#818cf8;margin-left:6px;flex-shrink:0;">{{ $c->votes_count }}</span>
                        </div>
                        <div class="prog-bar">
                            <div class="prog-fill" style="width:{{ $pct }}%"></div>
                        </div>
                        <div style="font-size:0.6rem;color:#52525b;margin-top:2px;">{{ $c->position?->name ?? '—' }} · {{ $pct }}%</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         ROW 4 — MASTER RECORD TABLE
    ══════════════════════════════════════════════════════════ --}}
    <div class="gc-bright p-5" style="animation-delay:.35s">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="section-label">Records</p>
                <h3 class="card-title mt-1">Master Record</h3>
            </div>
            <div class="flex items-center gap-2">
                <div style="position:relative;">
                    <input type="text" id="table-search" placeholder="Search..."
                           style="background:rgba(255,255,255,0.05);border:1px solid rgba(167,139,250,0.2);border-radius:10px;padding:6px 12px 6px 30px;font-size:0.72rem;color:#e0d7ff;outline:none;font-family:'DM Sans',sans-serif;width:160px;"
                           oninput="filterTable(this.value)"
                           onfocus="this.style.borderColor='rgba(167,139,250,0.45)'" onblur="this.style.borderColor='rgba(167,139,250,0.2)'">
                    <i class="fas fa-search" style="position:absolute;left:9px;top:50%;transform:translateY(-50%);color:#7c6fa0;font-size:0.65rem;"></i>
                </div>
                <select style="background:rgba(255,255,255,0.05);border:1px solid rgba(167,139,250,0.2);border-radius:10px;padding:6px 10px;font-size:0.72rem;color:#c4b5fd;outline:none;font-family:'DM Sans',sans-serif;">
                    <option>All time</option><option>This week</option><option>This month</option>
                </select>
                <select style="background:rgba(255,255,255,0.05);border:1px solid rgba(167,139,250,0.2);border-radius:10px;padding:6px 10px;font-size:0.72rem;color:#c4b5fd;outline:none;font-family:'DM Sans',sans-serif;">
                    <option>Filter</option><option>Active</option><option>New</option>
                </select>
                <a href="{{ route('admin.candidates.create') }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#4f46e5);color:#fff;font-size:0.72rem;font-weight:700;text-decoration:none;box-shadow:0 0 18px rgba(124,58,237,0.4);transition:transform .2s,box-shadow .2s;"
                   onmouseover="this.style.transform='scale(1.04)';this.style.boxShadow='0 0 28px rgba(124,58,237,0.6)'"
                   onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 0 18px rgba(124,58,237,0.4)'">
                    <i class="fas fa-plus" style="font-size:0.65rem;"></i> Add New
                </a>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="dash-table" style="width:100%;border-collapse:collapse;" id="master-table">
                <thead>
                    <tr>
                        <th style="cursor:pointer;">ID <i class="fas fa-sort" style="font-size:0.55rem;opacity:.4;margin-left:3px;"></i></th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Party / College</th>
                        <th style="cursor:pointer;">Votes <i class="fas fa-sort-down" style="font-size:0.55rem;margin-left:3px;"></i></th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach($topCandidates as $i => $c)
                    <tr data-search="{{ strtolower($c->first_name.' '.$c->last_name.' '.($c->position?->name ?? '')) }}">
                        <td style="color:#52525b;">
                            #{{ str_pad(10001 + $i, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:30px;height:30px;border-radius:9px;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.65rem;font-weight:700;flex-shrink:0;">
                                    @if($c->photo)
                                        <img src="{{ asset('images/candidates/'.$c->photo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:9px;">
                                    @else
                                        {{ strtoupper(substr($c->first_name,0,1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight:600;color:#e0d7ff;font-size:0.72rem;">{{ $c->first_name }} {{ $c->last_name }}</div>
                                    <div style="font-size:0.62rem;color:#52525b;">{{ $c->course ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color:#a78bfa;font-weight:500;">{{ $c->position?->name ?? '—' }}</td>
                        <td>
                            <div style="font-size:0.72rem;color:#c4b5fd;font-weight:500;">{{ $c->partylist?->name ?? '—' }}</div>
                            <div style="font-size:0.62rem;color:#52525b;">{{ $c->college?->acronym ?? '—' }}</div>
                        </td>
                        <td>
                            <span style="font-family:'Orbitron',sans-serif;font-size:0.72rem;font-weight:700;color:#818cf8;">{{ $c->votes_count }}</span>
                        </td>
                        <td>
                            @if($i % 3 === 0)
                                <span class="status-badge status-active">Active</span>
                            @elseif($i % 3 === 1)
                                <span class="status-badge status-new">New</span>
                            @else
                                <span class="status-badge status-pending">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:5px;">
                                <a href="{{ route('admin.candidates.show', $c) }}"
                                   style="width:28px;height:28px;border-radius:8px;background:rgba(14,165,233,0.12);border:1px solid rgba(14,165,233,0.2);display:flex;align-items:center;justify-content:center;color:#38bdf8;text-decoration:none;transition:background .2s;"
                                   onmouseover="this.style.background='rgba(14,165,233,0.25)'" onmouseout="this.style.background='rgba(14,165,233,0.12)'">
                                    <i class="fas fa-eye" style="font-size:0.6rem;"></i>
                                </a>
                                <a href="{{ route('admin.candidates.edit', $c) }}"
                                   style="width:28px;height:28px;border-radius:8px;background:rgba(124,58,237,0.12);border:1px solid rgba(124,58,237,0.2);display:flex;align-items:center;justify-content:center;color:#a78bfa;text-decoration:none;transition:background .2s;"
                                   onmouseover="this.style.background='rgba(124,58,237,0.25)'" onmouseout="this.style.background='rgba(124,58,237,0.12)'">
                                    <i class="fas fa-pen" style="font-size:0.6rem;"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination row --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;padding-top:12px;border-top:1px solid rgba(167,139,250,0.1);">
            <span style="font-size:0.68rem;color:#52525b;">Showing {{ $topCandidates->count() }} candidates</span>
            <div style="display:flex;gap:5px;">
                @foreach([1,2,3] as $p)
                <button style="width:28px;height:28px;border-radius:8px;border:1px solid rgba(167,139,250,{{ $p===1?'0.4':'0.15' }});background:rgba(124,58,237,{{ $p===1?'0.25':'0.05' }});color:{{ $p===1?'#c4b5fd':'#52525b' }};font-size:0.7rem;font-weight:700;cursor:pointer;">
                    {{ $p }}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SCRIPTS: Chart.js + Live Polling
    ══════════════════════════════════════════════════════════ --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
    (() => {
        Chart.defaults.color = '#7c6fa0';
        Chart.defaults.font.family = "'DM Sans', sans-serif";

        const tooltipDefaults = {
            backgroundColor:'rgba(10,6,30,.95)',
            borderColor:'rgba(167,139,250,.3)',
            borderWidth:1,
            titleColor:'#c4b5fd',
            bodyColor:'#e0d7ff',
            padding:10,
        };

        function grad(ctx, c1, c2, h=150) {
            const g = ctx.createLinearGradient(0,0,0,h);
            g.addColorStop(0,c1); g.addColorStop(1,c2); return g;
        }

        const scaleDefaults = {
            x: {
                grid:{ color:'rgba(167,139,250,.06)', drawBorder:false },
                border:{ display:false },
                ticks:{ display:false }, // hide — we show custom labels below
            },
            y: {
                grid:{ color:'rgba(167,139,250,.06)', drawBorder:false },
                border:{ display:false },
                ticks:{ font:{size:9}, color:'#52525b', maxTicksLimit:5 },
                beginAtZero:true,
            }
        };

        // ══ LEFT: Line Chart (cyan + purple filled lines, like image) ══
        const ctxLine = document.getElementById('chartLine').getContext('2d');
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May'],
                datasets: [
                    {
                        label: 'Voters',
                        data: [],
                        borderColor: '#818cf8',
                        backgroundColor: grad(ctxLine,'rgba(129,140,248,0.45)','rgba(129,140,248,0.02)'),
                        borderWidth: 2.5, fill: true, tension: 0.5,
                        pointBackgroundColor: '#818cf8',
                        pointBorderColor: 'rgba(10,6,30,.9)',
                        pointBorderWidth: 1.5,
                        pointRadius: 3.5, pointHoverRadius: 6,
                    },
                    {
                        label: 'Votes',
                        data: [],
                        borderColor: '#22d3ee',
                        backgroundColor: grad(ctxLine,'rgba(34,211,238,0.35)','rgba(34,211,238,0.02)'),
                        borderWidth: 2.5, fill: true, tension: 0.5,
                        pointBackgroundColor: '#22d3ee',
                        pointBorderColor: 'rgba(10,6,30,.9)',
                        pointBorderWidth: 1.5,
                        pointRadius: 3.5, pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                animation:{ duration:700, easing:'easeInOutQuart' },
                plugins:{
                    legend:{display:false},
                    tooltip:{...tooltipDefaults, callbacks:{
                        label: c => ` ${c.dataset.label}: ${c.parsed.y.toLocaleString()}`
                    }}
                },
                scales: scaleDefaults,
            }
        });

        // ══ MIDDLE: Grouped Bar Chart (cyan + purple, like image) ══
        const ctxBar = document.getElementById('chartBar').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May'],
                datasets: [
                    {
                        label: 'Voters',
                        data: [],
                        backgroundColor: 'rgba(129,140,248,0.75)',
                        borderColor: 'rgba(129,140,248,1)',
                        borderWidth: 1,
                        borderRadius: { topLeft:4, topRight:4 },
                        borderSkipped: false,
                        barPercentage: 0.45,
                        categoryPercentage: 0.8,
                    },
                    {
                        label: 'Votes',
                        data: [],
                        backgroundColor: 'rgba(34,211,238,0.75)',
                        borderColor: 'rgba(34,211,238,1)',
                        borderWidth: 1,
                        borderRadius: { topLeft:4, topRight:4 },
                        borderSkipped: false,
                        barPercentage: 0.45,
                        categoryPercentage: 0.8,
                    }
                ]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                animation:{ duration:700, easing:'easeInOutQuart' },
                plugins:{
                    legend:{display:false},
                    tooltip:{...tooltipDefaults, callbacks:{
                        label: c => ` ${c.dataset.label}: ${c.parsed.y.toLocaleString()}`
                    }}
                },
                scales: scaleDefaults,
            }
        });

        // ══ RIGHT: Pie/Doughnut (like image — large, cyan + purple) ══
        const ctxTurn = document.getElementById('chartTurnout').getContext('2d');
        const turnoutChart = new Chart(ctxTurn, {
            type: 'doughnut',
            data: {
                labels: ['Voted','Not Yet'],
                datasets: [{
                    data: [0,1],
                    backgroundColor: ['rgba(34,211,238,0.85)','rgba(129,140,248,0.75)'],
                    borderColor: ['rgba(34,211,238,0.4)','rgba(129,140,248,0.4)'],
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options:{
                responsive:false,   // fixed size canvas, no responsive resize
                maintainAspectRatio:false,
                cutout:'55%',       // less cutout = thicker pie like image
                animation:{ duration:900, easing:'easeInOutQuart' },
                plugins:{
                    legend:{display:false},
                    tooltip:{...tooltipDefaults, callbacks:{
                        label: c => ` ${c.label}: ${c.parsed.toLocaleString()} voters`
                    }}
                }
            }
        });

        // ══ Gauge needle ══════════════════════════════════════════
        function setGaugeAngle(pct) {
            const angle = -120 + (pct/100)*180;
            const needle = document.getElementById('gauge-needle');
            if(!needle) return;
            needle.style.transform = `translateX(-50%) rotate(${angle}deg)`;
            const color = pct>80?'#34d399':pct>50?'#22d3ee':'#f472b6';
            needle.style.background = `linear-gradient(to top,${color},transparent)`;
            const lbl = document.getElementById('system-status-label');
            if(lbl){ lbl.style.color=color; lbl.textContent=pct>80?'Operational':pct>50?'Degraded':'Critical'; }
        }
        setTimeout(()=>setGaugeAngle(75),400);

        // ══ Counter animation ═════════════════════════════════════
        function animateCount(el, newVal) {
            const cur = parseInt(el.textContent.replace(/[^0-9]/g,''))||0;
            if(cur===newVal) return;
            const steps=24,diff=newVal-cur,dur=500; let step=0;
            const t=setInterval(()=>{
                step++;
                el.textContent=Math.round(cur+(diff*step/steps)).toLocaleString();
                if(step>=steps){el.textContent=newVal.toLocaleString();clearInterval(t);}
            },dur/steps);
        }

        // ══ Render recent votes ═══════════════════════════════════
        function renderRecentVotes(votes) {
            const list=document.getElementById('recent-votes-list');
            if(!votes||!votes.length) return;
            list.innerHTML=votes.map(v=>`
                <div class="vote-row">
                    <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.65rem;font-weight:700;color:#fff;">${(v.voter||'U')[0].toUpperCase()}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.72rem;font-weight:600;color:#e0d7ff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${v.voter}</div>
                        <div style="font-size:0.65rem;color:#7c6fa0;">${v.candidate}</div>
                        <div style="font-size:0.62rem;color:#52525b;margin-top:1px;">${v.voted_at}</div>
                    </div>
                    <div style="width:7px;height:7px;border-radius:50%;background:#34d399;flex-shrink:0;margin-top:4px;box-shadow:0 0 6px #34d399;"></div>
                </div>`).join('');
        }

        // ══ Render top candidates ═════════════════════════════════
        function renderTopCandidates(candidates,totalVotes) {
            const list=document.getElementById('top-candidates-list');
            if(!candidates||!candidates.length) return;
            const rankColors=['#f59e0b','#a1a1aa','#fb923c'];
            list.innerHTML=candidates.map((c,i)=>{
                const pct=totalVotes>0?((c.votes/totalVotes)*100).toFixed(1):0;
                return `
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="width:18px;font-size:0.7rem;font-weight:700;color:${rankColors[i]||'#52525b'};text-align:center;flex-shrink:0;">${i+1}</span>
                    <div style="width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#4f46e5);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:700;flex-shrink:0;">${(c.name||'U')[0].toUpperCase()}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                            <span style="font-size:0.72rem;font-weight:600;color:#e0d7ff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">${c.name}</span>
                            <span style="font-size:0.7rem;font-weight:700;color:#818cf8;margin-left:6px;flex-shrink:0;">${c.votes}</span>
                        </div>
                        <div class="prog-bar"><div class="prog-fill" style="width:${pct}%"></div></div>
                        <div style="font-size:0.6rem;color:#52525b;margin-top:2px;">${c.position} · ${pct}%</div>
                    </div>
                </div>`;
            }).join('');
        }

        // ══ Table search ══════════════════════════════════════════
        window.filterTable=function(q){
            document.querySelectorAll('#table-body tr').forEach(row=>{
                row.style.display=(row.dataset.search||'').includes(q.toLowerCase())?'':'none';
            });
        };

        // ══ Main live fetch ═══════════════════════════════════════
        async function fetchLive() {
            try {
                const res=await fetch('{{ route('admin.dashboard.live') }}',{
                    headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}
                });
                if(!res.ok) return;
                const d=await res.json();

                // Stat cards
                const map={
                    'stat-voters':d.stats.total_voters,'stat-votes':d.stats.total_votes,
                    'stat-candidates':d.stats.total_candidates,'stat-positions':d.stats.total_positions,
                    'stat-partylists':d.stats.total_partylists,'stat-colleges':d.stats.total_colleges,
                    'stat-orgs':d.stats.total_orgs,
                };
                Object.entries(map).forEach(([id,val])=>{
                    const el=document.getElementById(id); if(el) animateCount(el,val);
                });

                // Analytics top numbers
                const av=document.getElementById('analytic-voters'); if(av) animateCount(av,d.stats.total_voters);
                const avv=document.getElementById('analytic-votes'); if(avv) animateCount(avv,d.stats.total_votes);

                // Turnout
                const {voted,not_voted}=d.turnout;
                const total=voted+not_voted;
                const pct=total>0?((voted/total)*100).toFixed(1):0;
                const notPct=total>0?(100-parseFloat(pct)).toFixed(1):0;

                ['stat-turnout','analytic-turnout','turnout-center-pct'].forEach(id=>{
                    const el=document.getElementById(id); if(el) el.textContent=pct+'%';
                });
                const pv=document.getElementById('pct-voted'); if(pv) pv.textContent=pct+'%';
                const pn=document.getElementById('pct-not'); if(pn) pn.textContent=notPct+'%';
                const rv=document.getElementById('remaining-voters'); if(rv) rv.textContent=not_voted.toLocaleString()+' voters';

                turnoutChart.data.datasets[0].data=[voted,not_voted];
                turnoutChart.update('active');

                // Monthly trend → line + bar charts
                if(d.monthlyTrend&&d.monthlyTrend.length){
                    const labels=d.monthlyTrend.map(m=>m.month);
                    const voters=d.monthlyTrend.map(m=>m.voters);
                    const votes=d.monthlyTrend.map(m=>m.votes);

                    // Line chart
                    lineChart.data.labels=labels;
                    lineChart.data.datasets[0].data=voters;
                    lineChart.data.datasets[1].data=votes;
                    lineChart.update('active');

                    // Bar chart (same data grouped)
                    barChart.data.labels=labels;
                    barChart.data.datasets[0].data=voters;
                    barChart.data.datasets[1].data=votes;
                    barChart.update('active');

                    // Month-over-month deltas
                    if(d.monthlyTrend.length>=2){
                        const len=d.monthlyTrend.length;
                        const cur=d.monthlyTrend[len-1], prev=d.monthlyTrend[len-2];
                        const vd=cur.voters-prev.voters, wd=cur.votes-prev.votes;
                        const e1=document.getElementById('analytic-voters-delta');
                        if(e1) e1.textContent=(vd>=0?'+':'')+vd.toLocaleString();
                        const e2=document.getElementById('analytic-votes-delta');
                        if(e2) e2.textContent=(wd>=0?'+':'')+wd.toLocaleString();
                    }
                }

                // Gauge
                setGaugeAngle(parseFloat(pct)||75);

                // Lists
                renderRecentVotes(d.recentVotes);
                renderTopCandidates(d.topCandidates,d.stats.total_votes);

                // Timestamp
                const lu=document.getElementById('last-updated'); if(lu) lu.textContent=d.timestamp;

            } catch(e){ console.warn('Live poll error:',e); }
        }

        // ══ Polling ═══════════════════════════════════════════════
        let pollTimer=null;
        function startPolling(ms){
            if(pollTimer) clearInterval(pollTimer);
            if(ms>0) pollTimer=setInterval(fetchLive,ms);
            const rl=document.getElementById('refresh-label');
            if(rl) rl.textContent=ms>0?(ms/1000)+'s':'paused';
        }
        document.getElementById('refresh-interval').addEventListener('change',function(){
            startPolling(parseInt(this.value));
        });

        fetchLive();
        startPolling(10000);
    })();
    </script>

</x-app-layout>