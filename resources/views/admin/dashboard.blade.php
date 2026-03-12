<x-app-layout>
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Welcome Section --}}
    <div class="gc p-6 mb-6" style="background:linear-gradient(135deg,rgba(56,0,65,0.85),rgba(82,0,96,0.75));border:1px solid rgba(249,180,15,0.2);animation:fadeInUp .5s ease both;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
            <div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:900;color:#fffbf0;margin:0 0 8px 0;">Welcome back, {{ auth()->user()->full_name }}!</h2>
                <p style="font-size:0.85rem;color:rgba(255,251,240,0.6);margin:0;line-height:1.6;">Here's an overview of your election management dashboard. Monitor voting activity, manage candidates, and track system performance in real-time.</p>
            </div>
            <div style="padding:12px 20px;border-radius:12px;background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.25);text-align:center;flex-shrink:0;">
                <div style="font-family:'Playfair Display',serif;font-size:0.95rem;font-weight:800;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ now()->format('l, F j, Y') }}</div>
            </div>
        </div>
    </div>

    <style>
        * { box-sizing: border-box; }

        :root {
            --glass:        rgba(30, 0, 37, 0.7);
            --glass-border: rgba(249, 180, 15, 0.15);
            --glass-bright: rgba(30, 0, 37, 0.85);
            --text-primary: #fffbf0;
            --text-muted:   rgba(255, 251, 240, 0.35);
            --gold:         #f9b40f;
            --gold-lt:      #fcd558;
            --gold-dk:      #c98a00;
            --violet:       #380041;
            --violet-md:    #520060;
            --ink:          #1a0020;
        }

        @media (prefers-color-scheme: light) {
            :root {
                --glass:        rgba(255, 255, 255, 0.9);
                --glass-border: rgba(201, 138, 0, 0.2);
                --glass-bright: rgba(255, 255, 255, 0.95);
                --text-primary: #1a0020;
                --text-muted:   rgba(26, 0, 32, 0.45);
            }
            body, .dashboard-wrap { background-color: #f9f5f0 !important; }
            .section-label { color: rgba(201, 138, 0, 0.6) !important; }
            .card-title { color: #1a0020 !important; }
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

        @keyframes pulse      { 0%,100%{opacity:1} 50%{opacity:.4} }
        @keyframes fadeInUp   { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        @keyframes spin        { to{transform:rotate(360deg)} }
        @keyframes glowPulse  { 0%,100%{box-shadow:0 0 20px rgba(249,180,15,0.3)} 50%{box-shadow:0 0 40px rgba(249,180,15,0.6)} }

        body, .dashboard-wrap { font-family: 'DM Sans', sans-serif; }

        /* ── Glass card ── */
        .gc {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.3), inset 0 1px 0 rgba(249,180,15,0.05);
            animation: fadeInUp .5s ease both;
            position: relative;
        }
        @media (prefers-color-scheme: light) {
            .gc {
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }
        }
        .gc::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(249,180,15,0.3), transparent);
            border-radius: 16px 16px 0 0; pointer-events: none;
        }
        .gc-bright {
            background: var(--glass-bright);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(249, 180, 15, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 40px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.07);
            position: relative;
        }
        @media (prefers-color-scheme: light) {
            .gc-bright {
                border: 1px solid rgba(201, 138, 0, 0.15);
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }
        }
        .gc-bright::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(249,180,15,0.4), transparent);
            border-radius: 16px 16px 0 0; pointer-events: none;
        }

        .section-label {
            font-size: 0.65rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: rgba(249,180,15,0.5);
        }
        .card-title {
            font-family: 'Playfair Display', serif; font-size: 0.88rem; font-weight: 800;
            color: var(--text-primary); letter-spacing: .01em;
        }
        .stat-number {
            font-family: 'Playfair Display', serif; font-size: 1.55rem; font-weight: 900;
            background: linear-gradient(135deg, #f9b40f 0%, #fcd558 60%, #fff3c4 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            line-height: 1;
        }
        .stat-delta {
            font-size: 0.65rem; font-weight: 700; color: #34d399;
            display: flex; align-items: center; gap: 2px;
        }
        .stat-delta.neg { color: #f87171; }
        @media (prefers-color-scheme: light) {
            .stat-delta { color: #059669; }
            .stat-delta.neg { color: #dc2626; }
        }

        .icon-box {
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; flex-shrink: 0; color: #fff;
        }
        .prog-bar { height: 5px; border-radius: 99px; background: rgba(249,180,15,0.08); }
        .prog-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #f9b40f, #fcd558); transition: width .8s cubic-bezier(.4,0,.2,1); }

        .vote-row {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 9px; border-radius: 12px;
            background: rgba(249,180,15,0.03);
            border: 1px solid rgba(249,180,15,0.07);
            transition: background .2s;
        }
        .vote-row:hover { background: rgba(249,180,15,0.07); }
        @media (prefers-color-scheme: light) {
            .vote-row {
                background: rgba(201, 138, 0, 0.04);
                border: 1px solid rgba(201, 138, 0, 0.1);
            }
            .vote-row:hover { background: rgba(201, 138, 0, 0.08); }
        }

        .member-row {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: 12px;
            transition: background .2s; cursor: pointer;
        }
        .member-row:hover { background: rgba(249,180,15,0.06); }
        @media (prefers-color-scheme: light) {
            .member-row:hover { background: rgba(201, 138, 0, 0.08); }
        }
        .member-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 900; flex-shrink: 0;
            font-family: 'Playfair Display', serif;
        }

        /* Gauge */
        .gauge-wrap { position: relative; width: 130px; height: 80px; margin: 0 auto; }
        .gauge-svg  { width: 130px; height: 80px; }
        .gauge-needle {
            position: absolute; bottom: 8px; left: 50%;
            width: 2px; height: 50px;
            background: linear-gradient(to top, #f9b40f, rgba(249,180,15,0));
            transform-origin: bottom center; border-radius: 2px;
            transform: translateX(-50%) rotate(-30deg);
            transition: transform 1.5s cubic-bezier(.4,0,.2,1);
        }

        /* Table */
        .dash-table th {
            font-size: 0.65rem; font-weight: 700; letter-spacing: .08em;
            text-transform: uppercase; color: rgba(249,180,15,0.5);
            padding: 10px 12px; text-align: left;
            border-bottom: 1px solid rgba(249,180,15,0.12);
        }
        .dash-table td {
            padding: 10px 12px; font-size: 0.75rem; color: var(--text-primary);
            border-bottom: 1px solid rgba(249,180,15,0.05);
        }
        .dash-table tr:hover td { background: rgba(249,180,15,0.04); }
        @media (prefers-color-scheme: light) {
            .dash-table th { color: rgba(201, 138, 0, 0.6); border-bottom: 1px solid rgba(201, 138, 0, 0.12); }
            .dash-table td { border-bottom: 1px solid rgba(201, 138, 0, 0.05); }
            .dash-table tr:hover td { background: rgba(201, 138, 0, 0.04); }
        }
        .dash-table tr:last-child td { border-bottom: none; }

        .status-badge {
            display: inline-block; padding: 2px 10px; border-radius: 20px;
            font-size: 0.65rem; font-weight: 700; letter-spacing: .04em;
        }
        .status-active  { background: rgba(52,211,153,0.12);  color: #34d399; border: 1px solid rgba(52,211,153,0.25); }
        .status-new     { background: rgba(249,180,15,0.12);  color: #f9b40f; border: 1px solid rgba(249,180,15,0.25); }
        .status-pending { background: rgba(251,146,60,0.12);  color: #fb923c; border: 1px solid rgba(251,146,60,0.25); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(249,180,15,0.2); border-radius: 99px; }

        .dot-menu { color: rgba(249,180,15,0.3); cursor: pointer; font-size: 1rem; transition: color .2s; }
        .dot-menu:hover { color: rgba(249,180,15,0.7); }
    </style>

    {{-- ══════════════════════════════════════════════════════════
         ROW 1 — STAT CARDS (8 metrics)
    ══════════════════════════════════════════════════════════ --}}
    @php
        $cards = [
            ['id'=>'stat-voters',     'label'=>'Total Voters',   'icon'=>'fa-users',             'glow'=>'rgba(249,180,15,.5)',  'bg'=>'linear-gradient(135deg,#f9b40f,#fcd558)',  'color'=>'#380041', 'value'=> $stats['total_voters'],     'delta'=>'+5.57%'],
            ['id'=>'stat-votes',      'label'=>'Votes Cast',      'icon'=>'fa-check-to-slot',     'glow'=>'rgba(16,185,129,.5)', 'bg'=>'linear-gradient(135deg,#059669,#0891b2)',  'color'=>'#fff',    'value'=> $stats['total_votes'],      'delta'=>'+29.75%'],
            ['id'=>'stat-candidates', 'label'=>'Candidates',      'icon'=>'fa-user-tie',          'glow'=>'rgba(249,180,15,.4)', 'bg'=>'linear-gradient(135deg,#c98a00,#f9b40f)',  'color'=>'#1a0020', 'value'=> $stats['total_candidates'], 'delta'=>'+4.88%'],
            ['id'=>'stat-positions',  'label'=>'Positions',       'icon'=>'fa-list-check',        'glow'=>'rgba(252,213,88,.4)', 'bg'=>'linear-gradient(135deg,#fcd558,#f9b40f)',  'color'=>'#380041', 'value'=> $stats['total_positions'],  'delta'=>'+2.1%'],
            ['id'=>'stat-partylists', 'label'=>'Partylists',      'icon'=>'fa-flag',              'glow'=>'rgba(239,68,68,.4)',  'bg'=>'linear-gradient(135deg,#ef4444,#ec4899)',  'color'=>'#fff',    'value'=> $stats['total_partylists'], 'delta'=>'+1.3%'],
            ['id'=>'stat-colleges',   'label'=>'Colleges',        'icon'=>'fa-building-columns',  'glow'=>'rgba(249,180,15,.3)', 'bg'=>'linear-gradient(135deg,#380041,#520060)',  'color'=>'#f9b40f', 'value'=> $stats['total_colleges'],  'delta'=>'Stable'],
            ['id'=>'stat-orgs',       'label'=>'Organizations',   'icon'=>'fa-sitemap',           'glow'=>'rgba(20,184,166,.4)', 'bg'=>'linear-gradient(135deg,#14b8a6,#0ea5e9)',  'color'=>'#fff',    'value'=> $stats['total_orgs'],      'delta'=>'+3.2%'],
            ['id'=>'stat-turnout',    'label'=>'Voter Turnout',   'icon'=>'fa-percent',           'glow'=>'rgba(249,180,15,.5)', 'bg'=>'linear-gradient(135deg,#f9b40f,#c98a00)',  'color'=>'#1a0020', 'value'=> '—',                        'delta'=>'Live'],
        ];
    @endphp

    <div class="grid gap-4 mb-5" style="grid-template-columns:repeat(4,1fr);">
        @foreach($cards as $i => $card)
        <div class="gc p-4 flex items-center gap-3 hover:scale-[1.02] transition-transform duration-200" style="animation-delay:{{ $i * 0.05 }}s">
            <div class="icon-box" style="background:{{ $card['bg'] }};box-shadow:0 0 20px {{ $card['glow'] }};color:{{ $card['color'] }};">
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

        {{-- DATA ANALYTICS CARD --}}
        <div style="background:rgba(30,0,37,0.8);backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);border:1px solid rgba(249,180,15,0.2);border-radius:18px;box-shadow:0 4px 40px rgba(0,0,0,0.35),inset 0 1px 0 rgba(249,180,15,0.07);padding:20px;animation:fadeInUp .5s ease both;animation-delay:.1s;position:relative;">
            <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(249,180,15,0.45),transparent);border-radius:18px 18px 0 0;pointer-events:none;"></div>

            {{-- TOP BAR --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <h3 style="font-family:'Playfair Display',serif;font-size:0.92rem;font-weight:800;color:#fffbf0;letter-spacing:.01em;margin:0;">Data Analytics</h3>
                <div style="display:flex;gap:8px;">
                    <button style="display:flex;align-items:center;gap:5px;background:rgba(249,180,15,0.08);border:1px solid rgba(249,180,15,0.2);border-radius:8px;padding:4px 12px;font-size:0.7rem;color:#f9b40f;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .2s;" onmouseover="this.style.background='rgba(249,180,15,0.14)'" onmouseout="this.style.background='rgba(249,180,15,0.08)'">
                        All <i class="fas fa-chevron-down" style="font-size:0.55rem;"></i>
                    </button>
                    <button style="display:flex;align-items:center;gap:5px;background:rgba(249,180,15,0.08);border:1px solid rgba(249,180,15,0.2);border-radius:8px;padding:4px 12px;font-size:0.7rem;color:#f9b40f;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .2s;" onmouseover="this.style.background='rgba(249,180,15,0.14)'" onmouseout="this.style.background='rgba(249,180,15,0.08)'">
                        Filters <i class="fas fa-chevron-down" style="font-size:0.55rem;"></i>
                    </button>
                </div>
            </div>

            {{-- 3 METRIC NUMBERS --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:0;margin-bottom:14px;border-bottom:1px solid rgba(249,180,15,0.1);padding-bottom:14px;">
                <div>
                    <div style="font-size:0.65rem;color:rgba(249,180,15,0.5);font-weight:600;margin-bottom:2px;text-transform:uppercase;letter-spacing:.06em;">Total</div>
                    <div id="analytic-voters" style="font-family:'Playfair Display',serif;font-size:1.35rem;font-weight:900;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">{{ number_format($stats['total_voters']) }}</div>
                    <div style="display:flex;align-items:center;gap:3px;margin-top:3px;">
                        <i class="fas fa-arrow-up" style="font-size:0.5rem;color:#34d399;"></i>
                        <span id="analytic-voters-delta" style="font-size:0.65rem;font-weight:700;color:#34d399;">—</span>
                    </div>
                </div>
                <div>
                    <div style="font-size:0.65rem;color:rgba(249,180,15,0.5);font-weight:600;margin-bottom:2px;text-transform:uppercase;letter-spacing:.06em;">Votes Cast</div>
                    <div id="analytic-votes" style="font-family:'Playfair Display',serif;font-size:1.35rem;font-weight:900;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">{{ number_format($stats['total_votes']) }}</div>
                    <div style="display:flex;align-items:center;gap:3px;margin-top:3px;">
                        <i class="fas fa-arrow-up" style="font-size:0.5rem;color:#34d399;"></i>
                        <span id="analytic-votes-delta" style="font-size:0.65rem;font-weight:700;color:#34d399;">—</span>
                    </div>
                </div>
                <div>
                    <div style="font-size:0.65rem;color:rgba(249,180,15,0.5);font-weight:600;margin-bottom:2px;text-transform:uppercase;letter-spacing:.06em;">Turnout Rate</div>
                    <div id="analytic-turnout" style="font-family:'Playfair Display',serif;font-size:1.35rem;font-weight:900;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.1;">—%</div>
                    <div style="display:flex;align-items:center;gap:3px;margin-top:3px;">
                        <i class="fas fa-circle" style="font-size:0.4rem;color:#34d399;animation:pulse 1.5s infinite;"></i>
                        <span style="font-size:0.65rem;font-weight:700;color:#34d399;">Live · <span id="refresh-label">10s</span></span>
                    </div>
                </div>
            </div>

            {{-- 3-COLUMN CHARTS --}}
            <div style="display:grid;grid-template-columns:1fr 1fr 200px;gap:16px;align-items:end;">

                {{-- Line Chart --}}
                <div>
                    <div style="position:relative;height:150px;">
                        <canvas id="chartLine"></canvas>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:0 4px;margin-top:4px;">
                        @foreach(['Jan','Feb','Mar','Apr','May'] as $m)
                        <span style="font-size:0.6rem;color:rgba(249,180,15,0.3);">{{ $m }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- Bar Chart --}}
                <div>
                    <div style="position:relative;height:150px;">
                        <canvas id="chartBar"></canvas>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:0 4px;margin-top:4px;">
                        @foreach(['Jan','Feb','Mar','Apr','May'] as $m)
                        <span style="font-size:0.6rem;color:rgba(249,180,15,0.3);">{{ $m }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- Doughnut + Legend --}}
                <div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                    <div style="position:relative;width:140px;height:140px;">
                        <canvas id="chartTurnout" style="position:absolute;top:0;left:0;width:140px!important;height:140px!important;"></canvas>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;">
                            <div id="turnout-center-pct" style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:900;background:linear-gradient(135deg,#f9b40f,#fcd558);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"></div>
                        </div>
                    </div>
                    <div style="width:100%;display:flex;flex-direction:column;gap:6px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span style="display:flex;align-items:center;gap:6px;font-size:0.68rem;color:rgba(255,251,240,0.6);">
                                <span style="width:10px;height:10px;border-radius:50%;background:#f9b40f;display:inline-block;box-shadow:0 0 6px rgba(249,180,15,0.6);flex-shrink:0;"></span>
                                Voted
                            </span>
                            <span id="pct-voted" style="font-size:0.72rem;font-weight:700;color:#f9b40f;">—%</span>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span style="display:flex;align-items:center;gap:6px;font-size:0.68rem;color:rgba(255,251,240,0.6);">
                                <span style="width:10px;height:10px;border-radius:50%;background:rgba(249,180,15,0.25);display:inline-block;border:1px solid rgba(249,180,15,0.3);flex-shrink:0;"></span>
                                Not yet
                            </span>
                            <span id="pct-not" style="font-size:0.72rem;font-weight:700;color:rgba(249,180,15,0.45);">—%</span>
                        </div>
                        <div style="margin-top:2px;padding:6px 8px;border-radius:8px;background:rgba(249,180,15,0.06);border:1px solid rgba(249,180,15,0.15);text-align:center;">
                            <div style="font-size:0.6rem;color:rgba(249,180,15,0.4);">Remaining</div>
                            <div id="remaining-voters" style="font-family:'Playfair Display',serif;font-size:0.78rem;font-weight:800;color:#f9b40f;margin-top:1px;">—</div>
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
                    <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#f9b40f,#fcd558);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.65rem;font-weight:900;color:#380041;font-family:'Playfair Display',serif;">
                        {{ strtoupper(substr($vote->voter?->full_name ?? 'U', 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.72rem;font-weight:600;color:#fffbf0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $vote->voter?->full_name ?? 'Unknown' }}
                        </div>
                        <div style="font-size:0.65rem;color:rgba(249,180,15,0.5);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $vote->candidate ? $vote->candidate->first_name.' '.$vote->candidate->last_name : '—' }}
                        </div>
                        <div style="font-size:0.62rem;color:rgba(255,251,240,0.25);margin-top:1px;">{{ $vote->voted_at?->diffForHumans() ?? '—' }}</div>
                    </div>
                    <div style="width:7px;height:7px;border-radius:50%;background:#34d399;flex-shrink:0;margin-top:4px;box-shadow:0 0 6px #34d399;"></div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('admin.votes.index') }}"
               style="display:flex;align-items:center;justify-content:center;gap:5px;margin-top:14px;font-size:0.7rem;font-weight:700;color:#f9b40f;text-decoration:none;padding:8px;border-radius:10px;background:rgba(249,180,15,0.08);border:1px solid rgba(249,180,15,0.18);transition:background .2s;"
               onmouseover="this.style.background='rgba(249,180,15,0.14)'" onmouseout="this.style.background='rgba(249,180,15,0.08)'">
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
                    <path d="M 15 75 A 55 55 0 0 1 125 75"
                          fill="none" stroke="rgba(249,180,15,0.1)" stroke-width="14" stroke-linecap="round"/>
                    <path d="M 15 75 A 55 55 0 0 1 52 23"
                          fill="none" stroke="#34d399" stroke-width="14" stroke-linecap="round" opacity=".7"/>
                    <path d="M 52 23 A 55 55 0 0 1 88 23"
                          fill="none" stroke="#f9b40f" stroke-width="14" stroke-linecap="round" opacity=".8"/>
                    <path d="M 88 23 A 55 55 0 0 1 125 75"
                          fill="none" stroke="#f472b6" stroke-width="14" stroke-linecap="round" opacity=".7"/>
                    <path d="M 15 75 A 55 55 0 0 1 125 75"
                          fill="none" stroke="url(#gaugeGrad)" stroke-width="6" stroke-linecap="round" opacity=".9"/>
                    <defs>
                        <linearGradient id="gaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#34d399"/>
                            <stop offset="50%" stop-color="#f9b40f"/>
                            <stop offset="100%" stop-color="#f472b6"/>
                        </linearGradient>
                    </defs>
                    <circle cx="70" cy="75" r="5" fill="#f9b40f" style="filter:drop-shadow(0 0 6px #f9b40f)"/>
                </svg>
                <div id="gauge-needle" class="gauge-needle"></div>
            </div>

            <div style="text-align:center;margin-bottom:12px;">
                <div id="system-status-label" style="font-family:'Playfair Display',serif;font-size:0.82rem;font-weight:800;color:#34d399;">Operational</div>
                <div style="font-size:0.62rem;color:rgba(255,251,240,0.3);margin-top:2px;">All systems normal</div>
            </div>

            <div class="space-y-2">
                @php
                    $metrics = [
                        ['label'=>'Uptime',   'val'=>'99.9%', 'pct'=>99, 'color'=>'#34d399'],
                        ['label'=>'Response', 'val'=>'42ms',  'pct'=>85, 'color'=>'#f9b40f'],
                        ['label'=>'Load',     'val'=>'23%',   'pct'=>23, 'color'=>'#f472b6'],
                    ];
                @endphp
                @foreach($metrics as $m)
                <div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:3px;">
                        <span style="font-size:0.65rem;color:rgba(255,251,240,0.35);">{{ $m['label'] }}</span>
                        <span style="font-size:0.65rem;font-weight:700;color:{{ $m['color'] }};">{{ $m['val'] }}</span>
                    </div>
                    <div class="prog-bar">
                        <div style="height:100%;border-radius:99px;width:{{ $m['pct'] }}%;background:linear-gradient(90deg,{{ $m['color'] }}88,{{ $m['color'] }});transition:width .8s;"></div>
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
                $memberGradients = [
                    'linear-gradient(135deg,#f9b40f,#fcd558)',
                    'linear-gradient(135deg,#059669,#0891b2)',
                    'linear-gradient(135deg,#d946ef,#f9b40f)',
                    'linear-gradient(135deg,#c98a00,#f9b40f)',
                    'linear-gradient(135deg,#0ea5e9,#6366f1)',
                ];
                $memberTextColors = ['#380041','#fff','#fff','#1a0020','#fff'];
            @endphp

            <div class="space-y-1" id="team-members-list">
                @foreach($teamMembers->take(5) as $i => $c)
                <div class="member-row">
                    <div class="member-avatar"
                         style="background:{{ $memberGradients[$i % count($memberGradients)] }};box-shadow:0 0 10px rgba(249,180,15,0.25);color:{{ $memberTextColors[$i % count($memberTextColors)] }};">
                        {{ strtoupper(substr($c->name, 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.72rem;font-weight:600;color:#fffbf0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $c->name }}
                        </div>
                        <div style="font-size:0.62rem;color:rgba(249,180,15,0.5);">
                            {{ ucfirst($c->role) }}
                        </div>
                    </div>
                    <div style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 6px #34d399;flex-shrink:0;"></div>
                </div>
                @endforeach
            </div>

            <div style="margin-top:14px;padding-top:12px;border-top:1px solid rgba(249,180,15,0.1);">
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.68rem;color:rgba(255,251,240,0.35);">
                    <span>{{ $teamMembers->count() }} admin{{ $teamMembers->count() !== 1 ? 's' : '' }} total</span>
                    <a href="{{ route('admin.candidates.index') }}"
                       style="color:#f9b40f;font-weight:700;text-decoration:none;font-size:0.68rem;transition:color .2s;"
                       onmouseover="this.style.color='#fcd558'" onmouseout="this.style.color='#f9b40f'">
                        View all <i class="fas fa-arrow-right" style="font-size:0.6rem;"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- TOP CANDIDATES --}}
        <div class="gc p-5" style="animation-delay:.3s">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="section-label">Leaderboard</p>
                    <h3 class="card-title mt-1">Top Candidates</h3>
                </div>
                <a href="{{ route('admin.votes.results') }}"
                   style="font-size:0.68rem;font-weight:700;color:#f9b40f;text-decoration:none;transition:color .2s;"
                   onmouseover="this.style.color='#fcd558'" onmouseout="this.style.color='#f9b40f'">
                    View all <i class="fas fa-arrow-right" style="font-size:0.6rem;"></i>
                </a>
            </div>
            <div id="top-candidates-list" class="space-y-3">
                @foreach($topCandidates as $i => $c)
                @php $pct = $stats['total_votes'] > 0 ? round(($c->votes_count / $stats['total_votes']) * 100, 1) : 0; @endphp
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="width:18px;font-size:0.7rem;font-weight:700;color:{{ $i===0?'#f9b40f':($i===1?'rgba(255,251,240,0.5)':($i===2?'#c98a00':'rgba(255,251,240,0.2)')) }};text-align:center;flex-shrink:0;">{{ $i+1 }}</span>
                    <div style="width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#f9b40f,#fcd558);display:flex;align-items:center;justify-content:center;color:#380041;font-size:0.7rem;font-weight:900;flex-shrink:0;box-shadow:0 0 10px rgba(249,180,15,0.35);font-family:'Playfair Display',serif;">
                        {{ strtoupper(substr($c->first_name, 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                            <span style="font-size:0.72rem;font-weight:600;color:#fffbf0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">{{ $c->first_name }} {{ $c->last_name }}</span>
                            <span style="font-size:0.7rem;font-weight:700;color:#f9b40f;margin-left:6px;flex-shrink:0;">{{ $c->votes_count }}</span>
                        </div>
                        <div class="prog-bar">
                            <div class="prog-fill" style="width:{{ $pct }}%"></div>
                        </div>
                        <div style="font-size:0.6rem;color:rgba(255,251,240,0.3);margin-top:2px;">{{ $c->position?->name ?? '—' }} · {{ $pct }}%</div>
                    </div>
                </div>
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
        Chart.defaults.color = 'rgba(249,180,15,0.4)';
        Chart.defaults.font.family = "'DM Sans', sans-serif";

        const tooltipDefaults = {
            backgroundColor: 'rgba(22,0,28,.97)',
            borderColor: 'rgba(249,180,15,.25)',
            borderWidth: 1,
            titleColor: '#f9b40f',
            bodyColor: '#fffbf0',
            padding: 10,
        };

        function grad(ctx, c1, c2, h=150) {
            const g = ctx.createLinearGradient(0,0,0,h);
            g.addColorStop(0,c1); g.addColorStop(1,c2); return g;
        }

        const scaleDefaults = {
            x: {
                grid:{ color:'rgba(249,180,15,.05)', drawBorder:false },
                border:{ display:false },
                ticks:{ display:false },
            },
            y: {
                grid:{ color:'rgba(249,180,15,.05)', drawBorder:false },
                border:{ display:false },
                ticks:{ font:{size:9}, color:'rgba(249,180,15,0.3)', maxTicksLimit:5 },
                beginAtZero:true,
            }
        };

        // ══ Line Chart ══
        const ctxLine = document.getElementById('chartLine').getContext('2d');
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May'],
                datasets: [
                    {
                        label: 'Voters',
                        data: [],
                        borderColor: '#f9b40f',
                        backgroundColor: grad(ctxLine,'rgba(249,180,15,0.35)','rgba(249,180,15,0.02)'),
                        borderWidth: 2.5, fill: true, tension: 0.5,
                        pointBackgroundColor: '#f9b40f',
                        pointBorderColor: 'rgba(22,0,28,.9)',
                        pointBorderWidth: 1.5, pointRadius: 3.5, pointHoverRadius: 6,
                    },
                    {
                        label: 'Votes',
                        data: [],
                        borderColor: '#fcd558',
                        backgroundColor: grad(ctxLine,'rgba(252,213,88,0.2)','rgba(252,213,88,0.02)'),
                        borderWidth: 2, fill: true, tension: 0.5,
                        pointBackgroundColor: '#fcd558',
                        pointBorderColor: 'rgba(22,0,28,.9)',
                        pointBorderWidth: 1.5, pointRadius: 3, pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                animation:{ duration:700, easing:'easeInOutQuart' },
                plugins:{ legend:{display:false}, tooltip:{...tooltipDefaults, callbacks:{ label: c => ` ${c.dataset.label}: ${c.parsed.y.toLocaleString()}` }} },
                scales: scaleDefaults,
            }
        });

        // ══ Bar Chart ══
        const ctxBar = document.getElementById('chartBar').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May'],
                datasets: [
                    {
                        label: 'Voters',
                        data: [],
                        backgroundColor: 'rgba(249,180,15,0.7)',
                        borderColor: 'rgba(249,180,15,1)',
                        borderWidth: 1,
                        borderRadius: { topLeft:4, topRight:4 },
                        borderSkipped: false,
                        barPercentage: 0.45, categoryPercentage: 0.8,
                    },
                    {
                        label: 'Votes',
                        data: [],
                        backgroundColor: 'rgba(252,213,88,0.6)',
                        borderColor: 'rgba(252,213,88,1)',
                        borderWidth: 1,
                        borderRadius: { topLeft:4, topRight:4 },
                        borderSkipped: false,
                        barPercentage: 0.45, categoryPercentage: 0.8,
                    }
                ]
            },
            options: {
                responsive:true, maintainAspectRatio:false,
                animation:{ duration:700, easing:'easeInOutQuart' },
                plugins:{ legend:{display:false}, tooltip:{...tooltipDefaults, callbacks:{ label: c => ` ${c.dataset.label}: ${c.parsed.y.toLocaleString()}` }} },
                scales: scaleDefaults,
            }
        });

        // ══ Doughnut Chart ══
        const ctxTurn = document.getElementById('chartTurnout').getContext('2d');
        const turnoutChart = new Chart(ctxTurn, {
            type: 'doughnut',
            data: {
                labels: ['Voted','Not Yet'],
                datasets: [{
                    data: [0,1],
                    backgroundColor: ['rgba(249,180,15,0.85)','rgba(56,0,65,0.6)'],
                    borderColor: ['rgba(249,180,15,0.5)','rgba(249,180,15,0.1)'],
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options:{
                responsive:false, maintainAspectRatio:false, cutout:'55%',
                animation:{ duration:900, easing:'easeInOutQuart' },
                plugins:{ legend:{display:false}, tooltip:{...tooltipDefaults, callbacks:{ label: c => ` ${c.label}: ${c.parsed.toLocaleString()} voters` }} }
            }
        });

        // ══ Gauge needle ══
        function setGaugeAngle(pct) {
            const angle = -120 + (pct/100)*180;
            const needle = document.getElementById('gauge-needle');
            if(!needle) return;
            needle.style.transform = `translateX(-50%) rotate(${angle}deg)`;
            const color = pct>80 ? '#34d399' : pct>50 ? '#f9b40f' : '#f472b6';
            needle.style.background = `linear-gradient(to top,${color},transparent)`;
            const lbl = document.getElementById('system-status-label');
            if(lbl){ lbl.style.color=color; lbl.textContent=pct>80?'Operational':pct>50?'Degraded':'Critical'; }
        }
        setTimeout(()=>setGaugeAngle(75),400);

        // ══ Counter animation ══
        function animateCount(el, newVal) {
            const cur = parseInt(el.textContent.replace(/[^0-9]/g,''))||0;
            if(cur===newVal) return;
            const steps=24, diff=newVal-cur, dur=500; let step=0;
            const t=setInterval(()=>{
                step++;
                el.textContent=Math.round(cur+(diff*step/steps)).toLocaleString();
                if(step>=steps){el.textContent=newVal.toLocaleString();clearInterval(t);}
            },dur/steps);
        }

        // ══ Render recent votes ══
        function renderRecentVotes(votes) {
            const list=document.getElementById('recent-votes-list');
            if(!votes||!votes.length) return;
            list.innerHTML=votes.map(v=>`
                <div class="vote-row">
                    <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#f9b40f,#fcd558);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.65rem;font-weight:900;color:#380041;font-family:'Playfair Display',serif;">${(v.voter||'U')[0].toUpperCase()}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.72rem;font-weight:600;color:#fffbf0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${v.voter}</div>
                        <div style="font-size:0.65rem;color:rgba(249,180,15,0.5);">${v.candidate}</div>
                        <div style="font-size:0.62rem;color:rgba(255,251,240,0.25);margin-top:1px;">${v.voted_at}</div>
                    </div>
                    <div style="width:7px;height:7px;border-radius:50%;background:#34d399;flex-shrink:0;margin-top:4px;box-shadow:0 0 6px #34d399;"></div>
                </div>`).join('');
        }

        // ══ Render top candidates ══
        function renderTopCandidates(candidates, totalVotes) {
            const list=document.getElementById('top-candidates-list');
            if(!candidates||!candidates.length) return;
            const rankColors=['#f9b40f','rgba(255,251,240,0.5)','#c98a00'];
            list.innerHTML=candidates.map((c,i)=>{
                const pct=totalVotes>0?((c.votes/totalVotes)*100).toFixed(1):0;
                return `
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="width:18px;font-size:0.7rem;font-weight:700;color:${rankColors[i]||'rgba(255,251,240,0.2)'};text-align:center;flex-shrink:0;">${i+1}</span>
                    <div style="width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#f9b40f,#fcd558);display:flex;align-items:center;justify-content:center;color:#380041;font-size:0.7rem;font-weight:900;flex-shrink:0;box-shadow:0 0 10px rgba(249,180,15,0.35);font-family:'Playfair Display',serif;">${(c.name||'U')[0].toUpperCase()}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                            <span style="font-size:0.72rem;font-weight:600;color:#fffbf0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px;">${c.name}</span>
                            <span style="font-size:0.7rem;font-weight:700;color:#f9b40f;margin-left:6px;flex-shrink:0;">${c.votes}</span>
                        </div>
                        <div class="prog-bar"><div class="prog-fill" style="width:${pct}%"></div></div>
                        <div style="font-size:0.6rem;color:rgba(255,251,240,0.3);margin-top:2px;">${c.position} · ${pct}%</div>
                    </div>
                </div>`;
            }).join('');
        }

        // ══ Table search ══
        window.filterTable=function(q){
            document.querySelectorAll('#table-body tr').forEach(row=>{
                row.style.display=(row.dataset.search||'').includes(q.toLowerCase())?'':'none';
            });
        };

        // ══ Live fetch ══
        async function fetchLive() {
            try {
                const res=await fetch('{{ route('admin.dashboard.live') }}',{
                    headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}
                });
                if(!res.ok) return;
                const d=await res.json();

                const map={
                    'stat-voters':d.stats.total_voters,'stat-votes':d.stats.total_votes,
                    'stat-candidates':d.stats.total_candidates,'stat-positions':d.stats.total_positions,
                    'stat-partylists':d.stats.total_partylists,'stat-colleges':d.stats.total_colleges,
                    'stat-orgs':d.stats.total_orgs,
                };
                Object.entries(map).forEach(([id,val])=>{
                    const el=document.getElementById(id); if(el) animateCount(el,val);
                });

                const av=document.getElementById('analytic-voters'); if(av) animateCount(av,d.stats.total_voters);
                const avv=document.getElementById('analytic-votes'); if(avv) animateCount(avv,d.stats.total_votes);

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

                if(d.monthlyTrend&&d.monthlyTrend.length){
                    const labels=d.monthlyTrend.map(m=>m.month);
                    const voters=d.monthlyTrend.map(m=>m.voters);
                    const votes=d.monthlyTrend.map(m=>m.votes);
                    lineChart.data.labels=labels; lineChart.data.datasets[0].data=voters; lineChart.data.datasets[1].data=votes; lineChart.update('active');
                    barChart.data.labels=labels; barChart.data.datasets[0].data=voters; barChart.data.datasets[1].data=votes; barChart.update('active');
                    if(d.monthlyTrend.length>=2){
                        const len=d.monthlyTrend.length, cur=d.monthlyTrend[len-1], prev=d.monthlyTrend[len-2];
                        const vd=cur.voters-prev.voters, wd=cur.votes-prev.votes;
                        const e1=document.getElementById('analytic-voters-delta'); if(e1) e1.textContent=(vd>=0?'+':'')+vd.toLocaleString();
                        const e2=document.getElementById('analytic-votes-delta'); if(e2) e2.textContent=(wd>=0?'+':'')+wd.toLocaleString();
                    }
                }

                setGaugeAngle(parseFloat(pct)||75);
                renderRecentVotes(d.recentVotes);
                renderTopCandidates(d.topCandidates,d.stats.total_votes);

                const lu=document.getElementById('last-updated'); if(lu) lu.textContent=d.timestamp;

            } catch(e){ console.warn('Live poll error:',e); }
        }

        // ══ Polling ══
        let pollTimer=null;
        function startPolling(ms){
            if(pollTimer) clearInterval(pollTimer);
            if(ms>0) pollTimer=setInterval(fetchLive,ms);
            const rl=document.getElementById('refresh-label'); if(rl) rl.textContent=ms>0?(ms/1000)+'s':'paused';
        }
        document.getElementById('refresh-interval').addEventListener('change',function(){
            startPolling(parseInt(this.value));
        });

        fetchLive();
        startPolling(10000);
    })();
    </script>

</x-app-layout>