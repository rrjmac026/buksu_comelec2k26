<x-app-layout>
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
    </style>

    {{-- ── Flash Messages ──────────────────────────────────────────── --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg"
             style="background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.4); color: #34d399;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ── Page Header ─────────────────────────────────────────────── --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold" style="color: #fcd558;">Activity Logs</h1>
            <p class="text-sm mt-0.5" style="color: rgba(255, 251, 240, 0.6);">Real-time login &amp; logout activity</p>
        </div>
        <div class="flex items-center gap-2 text-xs px-3 py-1.5 rounded-lg"
             style="background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.3); color: #6ee7b7;">
            <span id="live-dot" class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Live &mdash; updated <span id="last-updated" class="ml-1 font-mono">—</span>
        </div>
    </div>

    {{-- ── KPI Cards ───────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        @foreach([
            ['id' => 'stat-active', 'label' => 'Active Now',   'value' => $stats['active_now'],   'icon' => 'fa-circle-dot',        'color' => 'from-emerald-500 to-emerald-400'],
            ['id' => 'stat-logins', 'label' => 'Logins Today', 'value' => $stats['logins_today'], 'icon' => 'fa-arrow-right-to-arc', 'color' => 'from-[#fcd558] to-[#f9b40f]'],
            ['id' => 'stat-total',  'label' => 'Events Today', 'value' => $stats['total_today'],  'icon' => 'fa-clock-rotate-left',  'color' => 'from-[#6b0080] to-[#520060]'],
        ] as $stat)
        <div class="relative overflow-hidden rounded-2xl p-4 flex items-center gap-3 transition-all duration-300 hover:shadow-lg"
             style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2); box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
            <div class="absolute inset-0 bg-gradient-to-r from-[#f9b40f]/5 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
            <div class="relative w-12 h-12 rounded-lg bg-gradient-to-br {{ $stat['color'] }}
                        flex items-center justify-center text-white shadow-lg flex-shrink-0">
                <i class="fas {{ $stat['icon'] }} text-base"></i>
            </div>
            <div class="relative">
                <div id="{{ $stat['id'] }}" class="text-2xl font-bold" style="color: #fcd558;">{{ $stat['value'] }}</div>
                <div class="text-xs font-medium uppercase tracking-wider" style="color: rgba(252, 213, 88, 0.7);">{{ $stat['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Live Feed ───────────────────────────────────────────────── --}}
    <div class="relative rounded-2xl overflow-hidden shadow-lg mb-6"
         style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2);">
        <div class="absolute inset-0 bg-gradient-to-r from-[#f9b40f]/5 to-transparent opacity-50 pointer-events-none"></div>

        <div class="relative flex items-center justify-between px-5 py-4"
             style="border-bottom: 1px solid rgba(249, 180, 15, 0.2); background: linear-gradient(to right, rgba(56, 0, 65, 0.6), transparent);">
            <h2 class="font-bold flex items-center gap-2" style="color: #fcd558;">
                <i class="fas fa-satellite-dish text-sm"></i> Live Activity Feed
            </h2>
            <span class="text-xs" style="color: rgba(255, 251, 240, 0.4);">Refreshes every 5 s</span>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background: linear-gradient(to right, rgba(56, 0, 65, 0.6), transparent); border-bottom: 1px solid rgba(249, 180, 15, 0.2);">
                        <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider" style="color: #fcd558;">Event</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider" style="color: #fcd558;">Name</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider hidden md:table-cell" style="color: #fcd558;">Email</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider hidden sm:table-cell" style="color: #fcd558;">Role</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider hidden lg:table-cell" style="color: #fcd558;">IP Address</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold uppercase tracking-wider" style="color: #fcd558;">Time</th>
                    </tr>
                </thead>
                <tbody id="live-feed" style="border-collapse: collapse;">
                    <tr id="feed-placeholder">
                        <td colspan="6" class="px-5 py-10 text-center text-sm"
                            style="color: rgba(255, 251, 240, 0.4);">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Loading…
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Live polling script ─────────────────────────────────────── --}}
    @push('scripts')
    <script>
    const LIVE_URL = "{{ route('admin.activity-logs.live') }}";

    function eventBadge(event) {
        if (event === 'login')
            return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold"
                         style="background:rgba(52,211,153,0.2);color:#6ee7b7;border:1px solid rgba(52,211,153,0.4);">
                        <i class="fas fa-arrow-right-to-bracket"></i> Login</span>`;
        if (event === 'logout')
            return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold"
                         style="background:rgba(255,251,240,0.08);color:rgba(255,251,240,0.6);border:1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-arrow-right-from-bracket"></i> Logout</span>`;
        return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold"
                     style="background:rgba(239,68,68,0.2);color:#f87171;border:1px solid rgba(239,68,68,0.4);">
                    <i class="fas fa-circle-xmark"></i> Failed</span>`;
    }

    function roleBadge(role) {
        if (role === 'admin')
            return `<span class="px-2.5 py-1 rounded-lg text-xs font-bold"
                         style="background:rgba(249,180,15,0.2);color:#fcd558;border:1px solid rgba(249,180,15,0.3);">Admin</span>`;
        if (role === 'voter')
            return `<span class="px-2.5 py-1 rounded-lg text-xs font-bold"
                         style="background:rgba(96,165,250,0.2);color:#93c5fd;border:1px solid rgba(96,165,250,0.3);">Voter</span>`;
        return `<span style="color:rgba(255,251,240,0.35);">—</span>`;
    }

    let lastId = 0;

    async function fetchLive() {
        try {
            const res  = await fetch(LIVE_URL);
            const data = await res.json();

            document.getElementById('stat-active').textContent = data.active_now;
            document.getElementById('stat-logins').textContent = data.logins_today;
            document.getElementById('stat-total').textContent  = data.total_today;
            document.getElementById('last-updated').textContent = data.timestamp;

            const tbody      = document.getElementById('live-feed');
            const placeholder = document.getElementById('feed-placeholder');
            if (placeholder) placeholder.remove();

            const newRows = data.logs.filter(l => l.id > lastId);
            if (newRows.length > 0) lastId = data.logs[0]?.id ?? lastId;

            tbody.innerHTML = data.logs.map((l, i) => {
                const isNew = i === 0 && newRows.length > 0;
                const initial = (l.full_name && l.full_name !== '—') ? l.full_name.charAt(0).toUpperCase() : '?';
                return `
                <tr style="border-bottom:1px solid rgba(249,180,15,0.1);
                            background:${isNew ? 'linear-gradient(to right,rgba(249,180,15,0.08),transparent)' : 'linear-gradient(to right,rgba(249,180,15,0.02),transparent)'};"
                    onmouseover="this.style.background='linear-gradient(to right,rgba(249,180,15,0.06),transparent)';"
                    onmouseout="this.style.background='${isNew ? 'linear-gradient(to right,rgba(249,180,15,0.08),transparent)' : 'linear-gradient(to right,rgba(249,180,15,0.02),transparent)'}';">
                    <td class="px-5 py-3.5">${eventBadge(l.event)}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0"
                                 style="background:linear-gradient(to bottom right,#fcd558,#f9b40f);color:#1e0025;box-shadow:0 2px 8px rgba(249,180,15,0.3);">
                                ${initial}
                            </div>
                            <span class="font-semibold" style="color:#fffbf0;">${l.full_name}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 hidden md:table-cell" style="color:rgba(255,251,240,0.6);">${l.email}</td>
                    <td class="px-5 py-3.5 hidden sm:table-cell">${roleBadge(l.role)}</td>
                    <td class="px-5 py-3.5 hidden lg:table-cell">
                        <span class="font-mono text-xs px-2 py-0.5 rounded"
                              style="background:rgba(249,180,15,0.1);color:rgba(252,213,88,0.7);">${l.ip}</span>
                    </td>
                    <td class="px-5 py-3.5 text-xs whitespace-nowrap" style="color:rgba(255,251,240,0.6);"
                        title="${l.time_full}">${l.time}</td>
                </tr>`;
            }).join('') || `<tr><td colspan="6" class="px-5 py-10 text-center text-sm"
                                    style="color:rgba(255,251,240,0.4);">No activity yet.</td></tr>`;

            const dot = document.getElementById('live-dot');
            dot.classList.remove('bg-red-400');
            dot.classList.add('bg-emerald-400', 'animate-pulse');

        } catch (e) {
            const dot = document.getElementById('live-dot');
            dot.classList.remove('bg-emerald-400', 'animate-pulse');
            dot.classList.add('bg-red-400');
        }
    }

    fetchLive();
    setInterval(fetchLive, 5000);
    </script>
    @endpush

</x-app-layout>