<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Admin Dashboard</h2>
                <p class="text-xs text-violet-500 dark:text-violet-400 mt-0.5 flex items-center gap-1.5">
                    <span id="live-dot" class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Live · Last updated: <span id="last-updated" class="font-semibold">—</span>
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500 dark:text-gray-400">Auto-refresh every</span>
                <select id="refresh-interval"
                        class="text-xs px-2 py-1 rounded-lg border border-violet-200 dark:border-violet-700
                               bg-white dark:bg-violet-950/40 text-gray-700 dark:text-gray-300
                               focus:outline-none focus:ring-2 focus:ring-violet-400">
                    <option value="5000">5s</option>
                    <option value="10000" selected>10s</option>
                    <option value="30000">30s</option>
                    <option value="0">Off</option>
                </select>
            </div>
        </div>
    </x-slot>

    {{-- ── Stat Cards ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @php
            $cards = [
                ['id'=>'stat-voters',     'label'=>'Total Voters',     'icon'=>'fa-users',       'color'=>'from-violet-600 to-violet-400', 'value'=> $stats['total_voters']],
                ['id'=>'stat-votes',      'label'=>'Votes Cast',       'icon'=>'fa-check-to-slot','color'=>'from-emerald-600 to-emerald-400','value'=> $stats['total_votes']],
                ['id'=>'stat-candidates', 'label'=>'Candidates',       'icon'=>'fa-user-tie',    'color'=>'from-sky-600 to-sky-400',      'value'=> $stats['total_candidates']],
                ['id'=>'stat-positions',  'label'=>'Positions',        'icon'=>'fa-list-check',  'color'=>'from-amber-500 to-amber-400',  'value'=> $stats['total_positions']],
                ['id'=>'stat-partylists', 'label'=>'Partylists',       'icon'=>'fa-flag',        'color'=>'from-rose-600 to-rose-400',    'value'=> $stats['total_partylists']],
                ['id'=>'stat-colleges',   'label'=>'Colleges',         'icon'=>'fa-building-columns','color'=>'from-indigo-600 to-indigo-400','value'=> $stats['total_colleges']],
                ['id'=>'stat-orgs',       'label'=>'Organizations',    'icon'=>'fa-sitemap',     'color'=>'from-teal-600 to-teal-400',    'value'=> $stats['total_orgs']],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50
                    shadow-sm p-4 flex items-center gap-3 transition-all duration-300">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $card['color'] }}
                        flex items-center justify-center text-white shadow-md flex-shrink-0">
                <i class="fas {{ $card['icon'] }} text-sm"></i>
            </div>
            <div>
                <div id="{{ $card['id'] }}" class="text-2xl font-bold text-gray-800 dark:text-gray-100 tabular-nums transition-all duration-500">
                    {{ $card['value'] }}
                </div>
                <div class="text-xs text-violet-500 dark:text-violet-400 font-medium">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach

        {{-- Turnout % card --}}
        <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50
                    shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-fuchsia-600 to-fuchsia-400
                        flex items-center justify-center text-white shadow-md flex-shrink-0">
                <i class="fas fa-percent text-sm"></i>
            </div>
            <div>
                <div id="stat-turnout" class="text-2xl font-bold text-gray-800 dark:text-gray-100 tabular-nums">—</div>
                <div class="text-xs text-violet-500 dark:text-violet-400 font-medium">Voter Turnout</div>
            </div>
        </div>
    </div>

    {{-- ── Charts Row ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- Votes by Position (Bar) --}}
        <div class="lg:col-span-2 bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Votes by Position</h3>
                    <p class="text-xs text-violet-400 mt-0.5">Total votes cast per position</p>
                </div>
                <span class="text-xs bg-violet-100 dark:bg-violet-900/40 text-violet-600 dark:text-violet-400 px-2.5 py-1 rounded-lg font-semibold">
                    <i class="fas fa-bar-chart mr-1"></i>Live
                </span>
            </div>
            <div class="relative" style="height:220px">
                <canvas id="chartPositions"></canvas>
            </div>
        </div>

        {{-- Voter Turnout (Doughnut) --}}
        <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Voter Turnout</h3>
                    <p class="text-xs text-violet-400 mt-0.5">Voted vs. not yet voted</p>
                </div>
                <span class="text-xs bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 px-2.5 py-1 rounded-lg font-semibold">
                    <i class="fas fa-circle-notch mr-1"></i>Live
                </span>
            </div>
            <div class="relative flex items-center justify-center" style="height:180px">
                <canvas id="chartTurnout"></canvas>
                <div class="absolute text-center pointer-events-none">
                    <div id="turnout-center-pct" class="text-2xl font-black text-gray-800 dark:text-gray-100">—</div>
                    <div class="text-xs text-violet-400 font-medium">turnout</div>
                </div>
            </div>
            <div class="flex justify-center gap-4 mt-3 text-xs font-semibold">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span><span class="text-gray-600 dark:text-gray-400">Voted</span></span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-violet-200 inline-block"></span><span class="text-gray-600 dark:text-gray-400">Not yet</span></span>
            </div>
        </div>
    </div>

    {{-- ── Bottom Row: Top Candidates + Recent Votes ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Top Candidates --}}
        <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Top Candidates</h3>
                <a href="{{ route('admin.votes.results') }}"
                   class="text-xs text-violet-500 hover:text-violet-700 dark:hover:text-violet-300 font-semibold transition">
                    View all <i class="fas fa-arrow-right ml-0.5"></i>
                </a>
            </div>
            <div id="top-candidates-list" class="space-y-3">
                @foreach($topCandidates as $i => $c)
                @php $pct = $stats['total_votes'] > 0 ? round(($c->votes_count / $stats['total_votes']) * 100, 1) : 0; @endphp
                <div class="flex items-center gap-3">
                    <span class="w-5 text-xs font-bold text-violet-400 text-center flex-shrink-0">{{ $i+1 }}</span>
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-violet-600 to-violet-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm">
                        {{ strtoupper(substr($c->first_name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $c->first_name }} {{ $c->last_name }}</span>
                            <span class="text-xs font-bold text-violet-600 dark:text-violet-400 ml-2 flex-shrink-0">{{ $c->votes_count }} votes</span>
                        </div>
                        <div class="w-full bg-violet-100 dark:bg-violet-900/40 rounded-full h-1.5">
                            <div class="bg-gradient-to-r from-violet-600 to-violet-400 h-1.5 rounded-full transition-all duration-700"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $c->position?->name ?? '—' }} · {{ $c->partylist?->name ?? '—' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Votes --}}
        <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 dark:text-gray-100 text-sm">Recent Votes</h3>
                <a href="{{ route('admin.votes.index') }}"
                   class="text-xs text-violet-500 hover:text-violet-700 dark:hover:text-violet-300 font-semibold transition">
                    View all <i class="fas fa-arrow-right ml-0.5"></i>
                </a>
            </div>
            <div id="recent-votes-list" class="space-y-2.5 overflow-y-auto" style="max-height:320px">
                @foreach($recentVotes as $vote)
                <div class="flex items-start gap-3 p-2.5 rounded-xl bg-violet-50/50 dark:bg-violet-900/20 border border-violet-100/50 dark:border-violet-800/30">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-400 flex items-center justify-center text-white text-xs flex-shrink-0 shadow-sm mt-0.5">
                        <i class="fas fa-check text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $vote->voter?->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            voted for <span class="text-violet-600 dark:text-violet-400 font-medium">
                                {{ $vote->candidate ? ($vote->candidate->first_name . ' ' . $vote->candidate->last_name) : '—' }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $vote->position?->name ?? '—' }}</div>
                    </div>
                    <div class="text-xs text-gray-400 flex-shrink-0 mt-0.5">{{ $vote->voted_at?->diffForHumans() ?? '—' }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Chart.js + Live Polling ── --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
    (() => {
        const isDark = () => document.documentElement.classList.contains('dark');

        // ── Chart: Positions Bar ──────────────────────────────────
        const ctxPos = document.getElementById('chartPositions').getContext('2d');
        const posChart = new Chart(ctxPos, {
            type: 'bar',
            data: {
                labels: @json($topCandidates->pluck('position.name')->unique()->values()),
                datasets: [{
                    label: 'Votes',
                    data: [],
                    backgroundColor: 'rgba(124, 58, 237, 0.75)',
                    borderColor: 'rgba(124, 58, 237, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { callbacks: {
                    label: ctx => ` ${ctx.parsed.y} votes`
                }}},
                scales: {
                    x: { grid: { display: false }, ticks: { color: isDark() ? '#a78bfa' : '#7c3aed', font: { size: 11 } } },
                    y: { grid: { color: isDark() ? 'rgba(139,92,246,0.1)' : 'rgba(139,92,246,0.08)' },
                         ticks: { color: isDark() ? '#a78bfa' : '#7c3aed', font: { size: 11 }, stepSize: 1 },
                         beginAtZero: true }
                }
            }
        });

        // ── Chart: Turnout Doughnut ───────────────────────────────
        const ctxTurn = document.getElementById('chartTurnout').getContext('2d');
        const turnoutChart = new Chart(ctxTurn, {
            type: 'doughnut',
            data: {
                labels: ['Voted', 'Not Yet'],
                datasets: [{
                    data: [0, 1],
                    backgroundColor: ['rgba(52,211,153,0.85)', 'rgba(196,181,253,0.4)'],
                    borderColor: [isDark() ? '#1a0936' : '#fff', isDark() ? '#1a0936' : '#fff'],
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: { legend: { display: false }, tooltip: { callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed} voters`
                }}}
            }
        });

        // ── Counter animation ─────────────────────────────────────
        function animateCount(el, newVal) {
            const cur = parseInt(el.textContent.replace(/\D/g, '')) || 0;
            if (cur === newVal) return;
            const steps = 20, diff = newVal - cur, dur = 400;
            let step = 0;
            const t = setInterval(() => {
                step++;
                el.textContent = Math.round(cur + (diff * step / steps)).toLocaleString();
                if (step >= steps) { el.textContent = newVal.toLocaleString(); clearInterval(t); }
            }, dur / steps);
        }

        // ── Render recent votes ───────────────────────────────────
        function renderRecentVotes(votes) {
            const list = document.getElementById('recent-votes-list');
            if (!votes.length) return;
            list.innerHTML = votes.map(v => `
                <div class="flex items-start gap-3 p-2.5 rounded-xl bg-violet-50/50 dark:bg-violet-900/20 border border-violet-100/50 dark:border-violet-800/30">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-400 flex items-center justify-center text-white text-xs flex-shrink-0 shadow-sm mt-0.5">
                        <i class="fas fa-check text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-semibold text-gray-800 dark:text-gray-100 truncate">${v.voter}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">voted for <span class="text-violet-600 dark:text-violet-400 font-medium">${v.candidate}</span></div>
                        <div class="text-xs text-gray-400 mt-0.5">${v.position}</div>
                    </div>
                    <div class="text-xs text-gray-400 flex-shrink-0 mt-0.5">${v.voted_at}</div>
                </div>
            `).join('');
        }

        // ── Render top candidates ─────────────────────────────────
        function renderTopCandidates(candidates, totalVotes) {
            const list = document.getElementById('top-candidates-list');
            if (!candidates.length) return;
            list.innerHTML = candidates.map((c, i) => {
                const pct = totalVotes > 0 ? ((c.votes / totalVotes) * 100).toFixed(1) : 0;
                const initial = (c.name || 'U')[0].toUpperCase();
                return `
                <div class="flex items-center gap-3">
                    <span class="w-5 text-xs font-bold text-violet-400 text-center flex-shrink-0">${i+1}</span>
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-violet-600 to-violet-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm">${initial}</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-semibold text-gray-800 dark:text-gray-100 truncate">${c.name}</span>
                            <span class="text-xs font-bold text-violet-600 dark:text-violet-400 ml-2 flex-shrink-0">${c.votes} votes</span>
                        </div>
                        <div class="w-full bg-violet-100 dark:bg-violet-900/40 rounded-full h-1.5">
                            <div class="bg-gradient-to-r from-violet-600 to-violet-400 h-1.5 rounded-full transition-all duration-700" style="width:${pct}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">${c.position} · ${c.partylist}</div>
                    </div>
                </div>`;
            }).join('');
        }

        // ── Main fetch ────────────────────────────────────────────
        async function fetchLive() {
            try {
                const res = await fetch('{{ route('admin.dashboard.live') }}', {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) return;
                const d = await res.json();

                // Update stat cards
                const map = {
                    'stat-voters': d.stats.total_voters,
                    'stat-votes': d.stats.total_votes,
                    'stat-candidates': d.stats.total_candidates,
                    'stat-positions': d.stats.total_positions,
                    'stat-partylists': d.stats.total_partylists,
                    'stat-colleges': d.stats.total_colleges,
                    'stat-orgs': d.stats.total_orgs,
                };
                Object.entries(map).forEach(([id, val]) => {
                    const el = document.getElementById(id);
                    if (el) animateCount(el, val);
                });

                // Turnout
                const { voted, not_voted } = d.turnout;
                const total = voted + not_voted;
                const pct = total > 0 ? ((voted / total) * 100).toFixed(1) : 0;
                const turnEl = document.getElementById('stat-turnout');
                if (turnEl) turnEl.textContent = pct + '%';
                const centerEl = document.getElementById('turnout-center-pct');
                if (centerEl) centerEl.textContent = pct + '%';
                turnoutChart.data.datasets[0].data = [voted, not_voted];
                turnoutChart.update('active');

                // Bar chart
                posChart.data.labels = d.votesByPosition.map(p => p.label);
                posChart.data.datasets[0].data = d.votesByPosition.map(p => p.count);
                posChart.update('active');

                // Lists
                renderRecentVotes(d.recentVotes);
                renderTopCandidates(d.topCandidates, d.stats.total_votes);

                document.getElementById('last-updated').textContent = d.timestamp;

            } catch (e) {
                console.warn('Live poll error:', e);
            }
        }

        // ── Polling interval ──────────────────────────────────────
        let pollTimer = null;
        function startPolling(ms) {
            if (pollTimer) clearInterval(pollTimer);
            if (ms > 0) pollTimer = setInterval(fetchLive, ms);
        }

        document.getElementById('refresh-interval').addEventListener('change', function () {
            startPolling(parseInt(this.value));
        });

        // Initial fetch + start
        fetchLive();
        startPolling(10000);
    })();
    </script>

</x-app-layout>