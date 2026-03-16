<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes shimmerBar { 0%,100% { background-position:0% 0%; } 50% { background-position:100% 0%; } }
@keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:.4; } }
@keyframes fillBar { from { width:0; } to { width:var(--bar-w); } }

/* ── Page header ── */
.avr-page-header {
    display:flex; align-items:flex-start; justify-content:space-between;
    gap:16px; margin-bottom:24px; flex-wrap:wrap; animation:fadeUp .3s ease both;
}
.avr-page-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:#fffbf0; margin:0 0 3px; }
.avr-page-sub { font-size:0.72rem; color:rgba(255,251,240,0.4); }
.avr-live-chip {
    display:inline-flex; align-items:center; gap:7px; padding:6px 14px; border-radius:99px;
    background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2);
    font-family:'DM Sans',sans-serif; font-size:0.68rem; font-weight:700; color:#34d399;
    white-space:nowrap;
}
.avr-live-dot { width:6px; height:6px; border-radius:50%; background:#34d399; animation:pulse 1.5s ease-in-out infinite; box-shadow:0 0 6px rgba(52,211,153,0.6); }

/* ── Stat strip ── */
.avr-stat-strip { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
@media (max-width:640px) { .avr-stat-strip { grid-template-columns:1fr 1fr; } }
.avr-stat-card {
    background:rgba(26,0,32,0.88); border:1px solid rgba(249,180,15,0.15);
    border-radius:16px; padding:18px 20px; display:flex; align-items:center; gap:14px;
    box-shadow:inset 0 1px 0 rgba(249,180,15,0.05); animation:fadeUp .4s ease both;
}
.avr-stat-icon { width:42px; height:42px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:0.9rem; }
.avr-stat-num {
    font-family:'Playfair Display',serif; font-size:1.55rem; font-weight:900; line-height:1;
    background:linear-gradient(135deg,#f9b40f,#fcd558,#fff3c4);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.avr-stat-lbl { font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(249,180,15,0.45); margin-top:3px; }

/* ── Turnout hero card ── */
.avr-turnout-card {
    background:rgba(26,0,32,0.88); border:1px solid rgba(249,180,15,0.18);
    border-radius:18px; padding:22px 28px; margin-bottom:20px;
    display:flex; align-items:center; gap:24px; flex-wrap:wrap;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    animation:fadeUp .38s ease both; overflow:hidden;
}
.avr-turnout-card::before {
    content:''; display:block; height:2px; width:calc(100% + 56px); margin:-22px -28px 18px;
    background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}
.avr-turnout-big { font-family:'Playfair Display',serif; font-size:3rem; font-weight:900; line-height:1; color:#f9b40f; }
.avr-turnout-label { font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(249,180,15,0.5); margin-bottom:4px; }
.avr-turnout-sub { font-size:0.72rem; color:rgba(255,251,240,0.4); margin-top:4px; }
.avr-turnout-bar-wrap { flex:1; min-width:200px; }
.avr-turnout-track { height:10px; border-radius:99px; background:rgba(249,180,15,0.07); overflow:hidden; margin:8px 0 6px; }
.avr-turnout-fill  { height:100%; border-radius:99px; background:linear-gradient(90deg,#f9b40f,#fcd558); }
.avr-bar-labels { display:flex; justify-content:space-between; }
.avr-bar-lbl { font-family:'DM Sans',sans-serif; font-size:0.6rem; color:rgba(255,251,240,0.25); }
.avr-bar-val  { font-family:'DM Sans',sans-serif; font-size:0.6rem; color:#f9b40f; font-weight:700; }

/* ── Position result card ── */
.avr-pos-card {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow:hidden; margin-bottom:16px; animation:fadeUp .44s ease both;
}
.avr-pos-card:last-child { margin-bottom:0; }
.avr-pos-card::before {
    content:''; display:block; height:2px;
    background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}
.avr-pos-header {
    padding:18px 28px 14px; border-bottom:1px solid rgba(249,180,15,0.08);
    background:linear-gradient(to right,rgba(56,0,65,0.4),transparent);
    display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;
}
.avr-pos-name { font-family:'Playfair Display',serif; font-size:1.05rem; font-weight:900; color:#fffbf0; }
.avr-pos-votes-total {
    display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:99px;
    background:rgba(249,180,15,0.08); border:1px solid rgba(249,180,15,0.15);
    font-family:'DM Sans',sans-serif; font-size:0.65rem; font-weight:700; color:rgba(249,180,15,0.7);
}
.avr-pos-body { padding:20px 28px; }
.avr-pos-empty { padding:32px 28px; text-align:center; }
.avr-pos-empty-icon  { font-size:1.8rem; color:rgba(249,180,15,0.1); margin-bottom:10px; display:block; }
.avr-pos-empty-title { font-family:'Playfair Display',serif; font-size:0.85rem; font-weight:800; color:rgba(255,251,240,0.25); }

/* ── Candidate row ── */
.avr-cand-row { margin-bottom:20px; }
.avr-cand-row:last-child { margin-bottom:0; }
.avr-cand-top { display:flex; align-items:center; gap:14px; margin-bottom:10px; }
.avr-cand-rank {
    width:26px; height:26px; border-radius:8px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-family:'Playfair Display',serif; font-size:0.75rem; font-weight:900;
}
.avr-cand-rank.r1 { background:linear-gradient(135deg,#f9b40f,#fcd558); color:#380041; box-shadow:0 2px 8px rgba(249,180,15,0.4); }
.avr-cand-rank.r2 { background:rgba(192,192,192,0.15); border:1px solid rgba(192,192,192,0.3); color:rgba(192,192,192,0.8); }
.avr-cand-rank.r3 { background:rgba(180,120,60,0.15); border:1px solid rgba(180,120,60,0.3); color:rgba(205,133,63,0.8); }
.avr-cand-rank.rn { background:rgba(249,180,15,0.05); border:1px solid rgba(249,180,15,0.1); color:rgba(249,180,15,0.35); }

.avr-cand-avatar {
    width:40px; height:40px; border-radius:12px; flex-shrink:0; overflow:hidden;
    background:linear-gradient(135deg,rgba(56,0,65,0.8),rgba(82,0,96,0.8));
    border:1px solid rgba(249,180,15,0.2);
    display:flex; align-items:center; justify-content:center;
    font-family:'Playfair Display',serif; font-size:1rem; font-weight:900; color:#f9b40f;
}
.avr-cand-info { flex:1; min-width:0; }
.avr-cand-name { font-weight:600; color:#fffbf0; font-size:0.88rem; }
.avr-cand-party {
    display:inline-flex; margin-top:3px; padding:2px 8px; border-radius:99px;
    font-size:0.6rem; font-weight:700;
    background:rgba(249,180,15,0.08); border:1px solid rgba(249,180,15,0.15); color:rgba(249,180,15,0.65);
}
.avr-cand-votes-wrap { text-align:right; flex-shrink:0; }
.avr-cand-votes-num { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:#f9b40f; line-height:1; }
.avr-cand-votes-pct { font-size:0.62rem; color:rgba(255,251,240,0.4); margin-top:2px; font-family:'DM Sans',sans-serif; }

/* ── Progress bar ── */
.avr-prog-track { height:6px; border-radius:99px; background:rgba(249,180,15,0.07); overflow:hidden; }
.avr-prog-fill  {
    height:100%; border-radius:99px;
    background:linear-gradient(90deg,#f9b40f,#fcd558);
    transition:width 1.2s cubic-bezier(.4,0,.2,1);
}
.avr-prog-fill.r1 { background:linear-gradient(90deg,#f9b40f,#fcd558); box-shadow:0 0 8px rgba(249,180,15,0.3); }
.avr-prog-fill.r2 { background:linear-gradient(90deg,rgba(192,192,192,0.5),rgba(192,192,192,0.3)); }
.avr-prog-fill.r3 { background:linear-gradient(90deg,rgba(205,133,63,0.6),rgba(205,133,63,0.3)); }
.avr-prog-fill.rn { background:rgba(249,180,15,0.2); }

/* ── Winner badge ── */
.avr-winner-badge {
    display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:99px;
    background:linear-gradient(135deg,rgba(249,180,15,0.15),rgba(252,213,88,0.1));
    border:1px solid rgba(249,180,15,0.3);
    font-size:0.6rem; font-weight:700; color:#f9b40f; margin-left:8px;
}

/* ── Divider between candidates ── */
.avr-cand-divider { height:1px; background:rgba(249,180,15,0.07); margin:20px 0; }
</style>
@endpush

<div style="padding:0 0 60px;">

    {{-- Page Header --}}
    <div class="avr-page-header">
        <div>
            <h1 class="avr-page-title">Election Results</h1>
            <p class="avr-page-sub">Real-time voting results by position</p>
        </div>
        <div class="avr-live-chip">
            <span class="avr-live-dot"></span> Live Results
        </div>
    </div>

    {{-- Stats strip --}}
    @php
        $totalVotes      = \App\Models\CastedVote::count();
        $totalCandidates = \App\Models\Candidate::count();
        $totalPositions  = \App\Models\Position::count();
    @endphp
    <div class="avr-stat-strip">
        <div class="avr-stat-card" style="animation-delay:.06s;">
            <div class="avr-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-check-circle" style="color:#f9b40f;"></i>
            </div>
            <div><div class="avr-stat-num">{{ number_format($totalVotes) }}</div><div class="avr-stat-lbl">Total Votes Cast</div></div>
        </div>
        <div class="avr-stat-card" style="animation-delay:.1s;">
            <div class="avr-stat-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-users" style="color:#34d399;"></i>
            </div>
            <div><div class="avr-stat-num" style="background:linear-gradient(135deg,#34d399,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ number_format($totalCandidates) }}</div><div class="avr-stat-lbl">Total Candidates</div></div>
        </div>
        <div class="avr-stat-card" style="animation-delay:.14s;">
            <div class="avr-stat-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                <i class="fas fa-list" style="color:#60a5fa;"></i>
            </div>
            <div><div class="avr-stat-num" style="background:linear-gradient(135deg,#60a5fa,#93c5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ number_format($totalPositions) }}</div><div class="avr-stat-lbl">Total Positions</div></div>
        </div>
    </div>

    {{-- Turnout hero --}}
    @php $turnoutPct = $totalVotersTurnout > 0 ? round((\App\Models\CastedVote::distinct('voter_id')->count('voter_id') / \App\Models\User::where('role','voter')->count()) * 100, 1) : 0; @endphp
    <div class="avr-turnout-card">
        <div>
            <div class="avr-turnout-label">Voter Turnout</div>
            <div class="avr-turnout-big">{{ $turnoutPct }}%</div>
            <div class="avr-turnout-sub">
                {{ number_format(\App\Models\CastedVote::distinct('voter_id')->count('voter_id')) }}
                of {{ number_format(\App\Models\User::where('role','voter')->count()) }} voters
            </div>
        </div>
        <div class="avr-turnout-bar-wrap">
            <div class="avr-bar-labels">
                <span class="avr-bar-lbl">Participation</span>
                <span class="avr-bar-val">{{ $turnoutPct }}%</span>
            </div>
            <div class="avr-turnout-track">
                <div class="avr-turnout-fill" style="width:{{ $turnoutPct }}%"></div>
            </div>
            <div class="avr-bar-labels">
                <span class="avr-bar-lbl">0%</span>
                <span class="avr-bar-lbl">100%</span>
            </div>
        </div>
    </div>

    {{-- Results by position --}}
    @forelse($results as $position)
    @php $positionTotalVotes = $position->candidates->sum('votes_count'); @endphp
    <div class="avr-pos-card">
        <div class="avr-pos-header">
            <span class="avr-pos-name">{{ $position->name }}</span>
            <span class="avr-pos-votes-total">
                <i class="fas fa-vote-yea" style="font-size:.58rem;"></i>
                {{ number_format($positionTotalVotes) }} vote{{ $positionTotalVotes !== 1 ? 's' : '' }}
            </span>
        </div>

        @if($position->candidates->count() > 0)
        <div class="avr-pos-body">
            @foreach($position->candidates as $idx => $candidate)
            @php
                $voteCount  = $candidate->votes_count ?? 0;
                $percentage = $positionTotalVotes > 0 ? round(($voteCount / $positionTotalVotes) * 100, 1) : 0;
                $rankClass  = $idx === 0 ? 'r1' : ($idx === 1 ? 'r2' : ($idx === 2 ? 'r3' : 'rn'));
                $isWinner   = $idx === 0 && $voteCount > 0;
            @endphp

            @if($idx > 0)<div class="avr-cand-divider"></div>@endif

            <div class="avr-cand-row">
                <div class="avr-cand-top">
                    <div class="avr-cand-rank {{ $rankClass }}">{{ $idx + 1 }}</div>
                    <div class="avr-cand-avatar">
                        @if($candidate->photo)
                            <img src="{{ asset('images/candidates/' . $candidate->photo) }}"
                                 alt="{{ $candidate->first_name }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{ strtoupper(substr($candidate->first_name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="avr-cand-info">
                        <div class="avr-cand-name">
                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                            @if($isWinner)
                            <span class="avr-winner-badge">
                                <i class="fas fa-trophy" style="font-size:.55rem;"></i> Leading
                            </span>
                            @endif
                        </div>
                        <span class="avr-cand-party">{{ $candidate->partylist?->name ?? 'Independent' }}</span>
                    </div>
                    <div class="avr-cand-votes-wrap">
                        <div class="avr-cand-votes-num">{{ number_format($voteCount) }}</div>
                        <div class="avr-cand-votes-pct">{{ $percentage }}%</div>
                    </div>
                </div>
                <div class="avr-prog-track">
                    <div class="avr-prog-fill {{ $rankClass }}" style="width:{{ $percentage }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="avr-pos-empty">
            <i class="fas fa-inbox avr-pos-empty-icon"></i>
            <div class="avr-pos-empty-title">No candidates for this position</div>
        </div>
        @endif
    </div>
    @empty
    <div style="background:rgba(26,0,32,0.88);border:1px solid rgba(249,180,15,0.15);border-radius:18px;padding:60px 24px;text-align:center;">
        <i class="fas fa-inbox" style="font-size:2.5rem;color:rgba(249,180,15,0.1);display:block;margin-bottom:14px;"></i>
        <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:800;color:rgba(255,251,240,0.3);">No positions found</div>
    </div>
    @endforelse

</div>
</x-app-layout>