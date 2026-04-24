{{--
    Voter Election Status Banner
    ─────────────────────────────────────────────────────────────
    Include at the TOP of voter/dashboard.blade.php:

        @include('voter.partials.election-status-banner')

    Requires $electionStatus to be shared via ElectionStatusMiddleware.
    The middleware also flashes 'election_blocked' when a vote route
    is accessed at the wrong time — that message is shown here too.
--}}

@php
    // Fallback in case middleware hasn't shared the variable yet
    $electionStatus ??= \App\Models\ElectionSetting::status();
    $electionName   ??= \App\Models\ElectionSetting::get('election_name', 'Student Council Election');
@endphp

{{-- ── Blocked redirect flash ──────────────────────────────────────── --}}
@if(session('election_blocked') === 'upcoming')
<div style="
    display:flex; align-items:center; gap:12px;
    padding:14px 20px; border-radius:14px; margin-bottom:18px;
    background:rgba(249,180,15,0.07); border:1px solid rgba(249,180,15,0.25);
    animation:fadeUp .35s ease both;
">
    <i class="fas fa-circle-exclamation" style="color:#f9b40f;font-size:1rem;flex-shrink:0;"></i>
    <span style="font-size:0.75rem;font-weight:600;color:rgba(249,180,15,0.85);">
        Voting is not open yet — the election hasn't started. Please check back later.
    </span>
</div>

@elseif(session('election_blocked') === 'ended')
<div style="
    display:flex; align-items:center; gap:12px;
    padding:14px 20px; border-radius:14px; margin-bottom:18px;
    background:rgba(239,68,68,0.07); border:1px solid rgba(239,68,68,0.2);
    animation:fadeUp .35s ease both;
">
    <i class="fas fa-circle-exclamation" style="color:#f87171;font-size:1rem;flex-shrink:0;"></i>
    <span style="font-size:0.75rem;font-weight:600;color:rgba(248,113,113,0.85);">
        Voting is closed — the election has already ended. Thank you for your participation!
    </span>
</div>
@endif

{{-- ── Main status banner ───────────────────────────────────────────── --}}
@if($electionStatus === 'upcoming')
{{-- ════ UPCOMING ════ --}}
<div style="
    display:flex; align-items:center; gap:16px;
    padding:20px 24px; border-radius:16px; margin-bottom:20px;
    background:rgba(249,180,15,0.07); border:1px solid rgba(249,180,15,0.22);
    position:relative; overflow:hidden;
    animation:fadeUp .4s ease both;
">
    {{-- Glow orb --}}
    <div style="
        position:absolute; right:-40px; top:-40px;
        width:160px; height:160px; border-radius:50%;
        background:radial-gradient(circle, rgba(249,180,15,0.12), transparent 70%);
        pointer-events:none;
    "></div>

    <div style="
        width:48px; height:48px; border-radius:14px; flex-shrink:0;
        background:rgba(249,180,15,0.12); border:1px solid rgba(249,180,15,0.3);
        display:flex; align-items:center; justify-content:center;
        color:#f9b40f; font-size:1.2rem;
    ">
        <i class="fas fa-hourglass-start"></i>
    </div>

    <div style="flex:1; min-width:0;">
        <div style="
            font-family:'Playfair Display',serif;
            font-size:0.95rem; font-weight:900; color:#f9b40f; margin-bottom:4px;
        ">
            Election Coming Soon
        </div>
        <div style="font-size:0.72rem; color:rgba(249,180,15,0.6); line-height:1.6;">
            <strong style="color:rgba(249,180,15,0.8);">{{ $electionName }}</strong>
            has not opened yet. Voting will be enabled once the election begins — stay tuned!
        </div>
    </div>

    <div style="
        padding:6px 16px; border-radius:99px; flex-shrink:0;
        background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.3);
        font-size:0.62rem; font-weight:800; color:#f9b40f; letter-spacing:0.1em;
    ">
        UPCOMING
    </div>
</div>

@elseif($electionStatus === 'ongoing')
{{-- ════ ONGOING ════ --}}
<div style="
    display:flex; align-items:center; gap:16px;
    padding:20px 24px; border-radius:16px; margin-bottom:20px;
    background:rgba(52,211,153,0.06); border:1px solid rgba(52,211,153,0.25);
    position:relative; overflow:hidden;
    animation:fadeUp .4s ease both;
">
    {{-- Glow orb --}}
    <div style="
        position:absolute; right:-40px; top:-40px;
        width:160px; height:160px; border-radius:50%;
        background:radial-gradient(circle, rgba(52,211,153,0.1), transparent 70%);
        pointer-events:none;
    "></div>

    <div style="
        width:48px; height:48px; border-radius:14px; flex-shrink:0;
        background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3);
        display:flex; align-items:center; justify-content:center;
        color:#34d399; font-size:1.2rem;
    ">
        <i class="fas fa-circle-dot" style="animation:pulse-green 1.5s ease-in-out infinite;"></i>
    </div>

    <div style="flex:1; min-width:0;">
        <div style="
            font-family:'Playfair Display',serif;
            font-size:0.95rem; font-weight:900; color:#34d399; margin-bottom:4px;
        ">
            Election is Live!
        </div>
        <div style="font-size:0.72rem; color:rgba(52,211,153,0.65); line-height:1.6;">
            <strong style="color:rgba(52,211,153,0.85);">{{ $electionName }}</strong>
            is now open. Cast your ballot before voting closes!
        </div>
    </div>

    @if(!auth()->user()->hasVoted())
    <a href="{{ route('voter.vote.intro') }}" style="
        display:inline-flex; align-items:center; gap:7px;
        padding:10px 20px; border-radius:10px; flex-shrink:0;
        background:linear-gradient(135deg,#34d399,#6ee7b7);
        color:#064e3b; font-size:0.75rem; font-weight:800;
        text-decoration:none; border:none;
        box-shadow:0 4px 16px rgba(52,211,153,0.35);
        transition:all .18s; font-family:'DM Sans',sans-serif;
    "
    onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 24px rgba(52,211,153,0.5)'"
    onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(52,211,153,0.35)'">
        <i class="fas fa-vote-yea"></i> Vote Now
    </a>
    @else
    <div style="
        display:inline-flex; align-items:center; gap:6px;
        padding:6px 16px; border-radius:99px; flex-shrink:0;
        background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3);
        font-size:0.65rem; font-weight:800; color:#34d399; letter-spacing:0.08em;
    ">
        <i class="fas fa-check-double" style="font-size:0.6rem;"></i> VOTED
    </div>
    @endif
</div>

@elseif($electionStatus === 'ended')
{{-- ════ ENDED ════ --}}
<div style="
    display:flex; align-items:center; gap:16px;
    padding:20px 24px; border-radius:16px; margin-bottom:20px;
    background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);
    position:relative; overflow:hidden;
    animation:fadeUp .4s ease both;
">
    <div style="
        width:48px; height:48px; border-radius:14px; flex-shrink:0;
        background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);
        display:flex; align-items:center; justify-content:center;
        color:rgba(255,255,255,0.35); font-size:1.2rem;
    ">
        <i class="fas fa-flag-checkered"></i>
    </div>

    <div style="flex:1; min-width:0;">
        <div style="
            font-family:'Playfair Display',serif;
            font-size:0.95rem; font-weight:900;
            color:rgba(255,255,255,0.45); margin-bottom:4px;
        ">
            Election Has Ended
        </div>
        <div style="font-size:0.72rem; color:rgba(255,255,255,0.28); line-height:1.6;">
            <strong style="color:rgba(255,255,255,0.4);">{{ $electionName }}</strong>
            voting period is now closed. Thank you to everyone who participated!
        </div>
    </div>

    <div style="
        padding:6px 16px; border-radius:99px; flex-shrink:0;
        background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1);
        font-size:0.62rem; font-weight:800;
        color:rgba(255,255,255,0.3); letter-spacing:0.1em;
    ">
        ENDED
    </div>
</div>
@endif

<style>
@keyframes pulse-green {
    0%,100% { opacity:1; }
    50%      { opacity:0.5; }
}
</style>
