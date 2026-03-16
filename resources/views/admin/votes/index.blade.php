<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes shimmerBar { 0%,100% { background-position:0% 0%; } 50% { background-position:100% 0%; } }
@keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:.4; } }

.avt-stat-strip { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px; }
@media (max-width:640px) { .avt-stat-strip { grid-template-columns:1fr 1fr; } }

.avt-stat-card {
    background:rgba(26,0,32,0.88); border:1px solid rgba(249,180,15,0.15);
    border-radius:16px; padding:18px 20px; display:flex; align-items:center; gap:14px;
    box-shadow:inset 0 1px 0 rgba(249,180,15,0.05); animation:fadeUp .4s ease both;
}
.avt-stat-icon { width:42px; height:42px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:0.9rem; }
.avt-stat-num {
    font-family:'Playfair Display',serif; font-size:1.55rem; font-weight:900; line-height:1;
    background:linear-gradient(135deg,#f9b40f,#fcd558,#fff3c4);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.avt-stat-lbl { font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(249,180,15,0.45); margin-top:3px; }

.avt-page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; animation:fadeUp .3s ease both; }
.avt-page-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:#fffbf0; margin:0 0 3px; }
.avt-page-sub { font-size:0.72rem; color:rgba(255,251,240,0.4); }

/* live chip */
.avt-live-chip {
    display:inline-flex; align-items:center; gap:7px;
    padding:6px 14px; border-radius:99px;
    background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2);
    font-family:'DM Sans',sans-serif; font-size:0.68rem; font-weight:700; color:#34d399;
}
.avt-live-dot { width:6px; height:6px; border-radius:50%; background:#34d399; animation:pulse 1.5s ease-in-out infinite; box-shadow:0 0 6px rgba(52,211,153,0.6); }

/* turnout bar */
.avt-turnout-card {
    background:rgba(26,0,32,0.88); border:1px solid rgba(249,180,15,0.18);
    border-radius:18px; padding:20px 24px; margin-bottom:18px;
    display:flex; align-items:center; gap:20px; flex-wrap:wrap;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    animation:fadeUp .38s ease both;
}
.avt-turnout-card::before {
    content:''; display:block; height:2px; width:100%; margin:-20px -24px 16px;
    background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}
.avt-turnout-label { font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(249,180,15,0.5); margin-bottom:4px; }
.avt-turnout-pct { font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; color:#f9b40f; line-height:1; }
.avt-turnout-sub { font-size:0.68rem; color:rgba(255,251,240,0.4); margin-top:3px; }
.avt-turnout-bar-wrap { flex:1; min-width:180px; }
.avt-turnout-track { height:8px; border-radius:99px; background:rgba(249,180,15,0.08); overflow:hidden; margin-top:8px; }
.avt-turnout-fill  { height:100%; border-radius:99px; background:linear-gradient(90deg,#f9b40f,#fcd558); transition:width 1s; }

.avt-filter-bar {
    background:rgba(26,0,32,0.88); border:1px solid rgba(249,180,15,0.14);
    border-radius:14px; padding:16px 20px; margin-bottom:18px;
    display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;
    animation:fadeUp .42s ease both;
}
.avt-filter-label { font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:rgba(249,180,15,0.5); margin-bottom:6px; }
.avt-input {
    background:rgba(56,0,65,0.6); border:1px solid rgba(249,180,15,0.15);
    border-radius:9px; padding:8px 12px 8px 32px;
    font-family:'DM Sans',sans-serif; font-size:0.78rem; color:#fffbf0;
    outline:none; width:100%; transition:border-color .2s, box-shadow .2s;
}
.avt-input::placeholder { color:rgba(255,251,240,0.2); }
.avt-input:focus { border-color:rgba(249,180,15,0.4); box-shadow:0 0 0 3px rgba(249,180,15,0.06); }

.avt-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:9px; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700; cursor:pointer; transition:all .18s; border:none; white-space:nowrap; text-decoration:none; }
.avt-btn-primary { background:linear-gradient(135deg,#f9b40f,#fcd558); color:#380041; box-shadow:0 3px 12px rgba(249,180,15,0.3); }
.avt-btn-primary:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(249,180,15,0.45); color:#380041; }
.avt-btn-ghost { background:transparent; border:1px solid rgba(249,180,15,0.2); color:rgba(249,180,15,0.55); }
.avt-btn-ghost:hover { background:rgba(249,180,15,0.06); color:#f9b40f; }

.avt-table-card {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow:hidden; animation:fadeUp .46s ease both;
}
.avt-table-card::before {
    content:''; display:block; height:2px;
    background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}

.avt-table { width:100%; border-collapse:collapse; font-size:0.82rem; }
.avt-thead tr { background:linear-gradient(to right,rgba(56,0,65,0.5),transparent); border-bottom:1px solid rgba(249,180,15,0.12); }
.avt-thead th { padding:14px 20px; text-align:left; font-size:0.58rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(249,180,15,0.6); }
.avt-tbody tr { border-bottom:1px solid rgba(249,180,15,0.07); transition:background .18s; }
.avt-tbody tr:last-child { border-bottom:none; }
.avt-tbody tr:hover { background:rgba(249,180,15,0.04); }
.avt-tbody td { padding:14px 20px; color:rgba(255,251,240,0.85); vertical-align:middle; }

.avt-voter-avatar {
    width:38px; height:38px; border-radius:11px; flex-shrink:0;
    background:linear-gradient(135deg,rgba(56,0,65,0.8),rgba(82,0,96,0.8));
    border:1px solid rgba(249,180,15,0.25);
    display:flex; align-items:center; justify-content:center;
    font-family:'Playfair Display',serif; font-size:1rem; font-weight:900; color:#f9b40f;
}
.avt-voter-name  { font-weight:600; color:#fffbf0; }
.avt-voter-email { font-size:0.65rem; color:rgba(249,180,15,0.5); margin-top:2px; }

.avt-txn-code {
    font-family:monospace; font-size:0.72rem;
    background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.15);
    color:rgba(249,180,15,0.8); padding:4px 12px; border-radius:7px;
    display:inline-block;
}

.avt-date-text { font-size:0.75rem; color:rgba(255,251,240,0.75); }
.avt-time-text { font-size:0.65rem; color:rgba(249,180,15,0.5); margin-top:2px; }

.avt-empty { padding:60px 24px; text-align:center; }
.avt-empty-icon  { font-size:2.5rem; color:rgba(249,180,15,0.1); margin-bottom:14px; display:block; }
.avt-empty-title { font-family:'Playfair Display',serif; font-size:1rem; font-weight:800; color:rgba(255,251,240,0.35); margin-bottom:6px; }
.avt-empty-sub   { font-size:0.72rem; color:rgba(255,251,240,0.2); }

.avt-toast { display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:600; animation:fadeUp .35s ease both; }
.avt-toast-success { background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2); color:#34d399; }
.avt-toast-error   { background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2); color:#f87171; }

.avt-pagination { padding:16px 20px; border-top:1px solid rgba(249,180,15,0.1); }
</style>
@endpush

<div style="padding:0 0 60px;">

    <div class="avt-page-header">
        <div>
            <h1 class="avt-page-title">Ballot Log</h1>
            <p class="avt-page-sub">All submitted ballot transactions</p>
        </div>
        <div class="avt-live-chip">
            <span class="avt-live-dot"></span> Live Data
        </div>
    </div>

    @if(session('success'))
    <div class="avt-toast avt-toast-success" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,4000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-circle-check" style="flex-shrink:0;"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="avt-toast avt-toast-error" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,4000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i> {{ session('error') }}
    </div>
    @endif

    {{-- Stats --}}
    @php
        $totalTransactions = $transactions->total();
        $totalUniqueVoters = \App\Models\CastedVote::distinct('voter_id')->count('voter_id');
        $totalVoters       = \App\Models\User::where('role','voter')->count();
        $turnoutPct        = $totalVoters > 0 ? round(($totalUniqueVoters / $totalVoters) * 100, 1) : 0;
    @endphp
    <div class="avt-stat-strip">
        <div class="avt-stat-card" style="animation-delay:.06s;">
            <div class="avt-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-scroll" style="color:#f9b40f;"></i>
            </div>
            <div><div class="avt-stat-num">{{ number_format($totalTransactions) }}</div><div class="avt-stat-lbl">Total Ballots</div></div>
        </div>
        <div class="avt-stat-card" style="animation-delay:.1s;">
            <div class="avt-stat-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-users" style="color:#34d399;"></i>
            </div>
            <div><div class="avt-stat-num" style="background:linear-gradient(135deg,#34d399,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ number_format($totalUniqueVoters) }}</div><div class="avt-stat-lbl">Unique Voters</div></div>
        </div>
        <div class="avt-stat-card" style="animation-delay:.14s;">
            <div class="avt-stat-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                <i class="fas fa-user-group" style="color:#60a5fa;"></i>
            </div>
            <div><div class="avt-stat-num" style="background:linear-gradient(135deg,#60a5fa,#93c5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ number_format($totalVoters) }}</div><div class="avt-stat-lbl">Total Voters</div></div>
        </div>
        <div class="avt-stat-card" style="animation-delay:.18s;">
            <div class="avt-stat-icon" style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);">
                <i class="fas fa-percent" style="color:#f87171;"></i>
            </div>
            <div><div class="avt-stat-num" style="background:linear-gradient(135deg,#f87171,#fca5a5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $turnoutPct }}%</div><div class="avt-stat-lbl">Voter Turnout</div></div>
        </div>
    </div>

    {{-- Turnout bar --}}
    <div class="avt-turnout-card">
        <div>
            <div class="avt-turnout-label">Overall Turnout</div>
            <div class="avt-turnout-pct">{{ $turnoutPct }}%</div>
            <div class="avt-turnout-sub">{{ number_format($totalUniqueVoters) }} of {{ number_format($totalVoters) }} voters</div>
        </div>
        <div class="avt-turnout-bar-wrap">
            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                <span style="font-size:0.6rem;color:rgba(255,251,240,0.3);font-family:'DM Sans',sans-serif;">Voted</span>
                <span style="font-size:0.6rem;color:#f9b40f;font-family:'DM Sans',sans-serif;font-weight:700;">{{ $turnoutPct }}%</span>
            </div>
            <div class="avt-turnout-track">
                <div class="avt-turnout-fill" style="width:{{ $turnoutPct }}%"></div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:4px;">
                <span style="font-size:0.6rem;color:rgba(255,251,240,0.25);font-family:'DM Sans',sans-serif;">0%</span>
                <span style="font-size:0.6rem;color:rgba(255,251,240,0.25);font-family:'DM Sans',sans-serif;">100%</span>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="avt-filter-bar">
        <form method="GET" action="{{ route('admin.votes.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;width:100%;">
            <div style="flex:1;min-width:220px;">
                <div class="avt-filter-label">Search</div>
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:0.6rem;color:rgba(249,180,15,0.35);pointer-events:none;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Voter name, email, transaction #…" class="avt-input">
                </div>
            </div>
            <button type="submit" class="avt-btn avt-btn-primary">
                <i class="fas fa-filter" style="font-size:.62rem;"></i> Filter
            </button>
            @if(request('search'))
            <a href="{{ route('admin.votes.index') }}" class="avt-btn avt-btn-ghost">
                <i class="fas fa-xmark" style="font-size:.62rem;"></i> Clear
            </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="avt-table-card">
        @if($transactions->count() > 0)
        <div style="overflow-x:auto;">
            <table class="avt-table">
                <thead class="avt-thead">
                    <tr>
                        <th>Voter</th>
                        <th>Transaction #</th>
                        <th>Date &amp; Time</th>
                    </tr>
                </thead>
                <tbody class="avt-tbody">
                    @foreach($transactions as $txn)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div class="avt-voter-avatar">
                                    {{ strtoupper(substr($txn->voter?->full_name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="avt-voter-name">{{ $txn->voter?->full_name ?? 'Unknown' }}</div>
                                    <div class="avt-voter-email">{{ $txn->voter?->email ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="avt-txn-code">{{ $txn->transaction_number ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div class="avt-date-text">{{ $txn->voted_at?->format('M d, Y') ?? '—' }}</div>
                            <div class="avt-time-text">{{ $txn->voted_at?->format('h:i A') ?? '' }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="avt-pagination">{{ $transactions->links() }}</div>
        @else
        <div class="avt-empty">
            <i class="fas fa-inbox avt-empty-icon"></i>
            <div class="avt-empty-title">No vote records found</div>
            <div class="avt-empty-sub">
                @if(request('search')) Try adjusting your search.
                @else No ballots have been submitted yet.
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
</x-app-layout>