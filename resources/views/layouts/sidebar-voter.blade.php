{{-- ═══════════════════════════════════════
     VOTER SIDEBAR NAVIGATION
     ═══════════════════════════════════════ --}}

@php
    $currentRoute = Route::currentRouteName();
    $hasVoted     = auth()->user()->hasVoted();
    $rawElectionStatus = $electionStatus ?? \App\Models\ElectionSetting::status();
    $voteStatus = $rawElectionStatus === 'upcoming' ? 'not_started' : $rawElectionStatus;
    $voteBlocked = in_array($voteStatus, ['not_started', 'ended'], true);
    $voteTooltip = $voteStatus === 'not_started'
        ? 'Voting will be available once the election starts'
        : 'Voting is closed because the election has ended';
@endphp

{{-- ── Overview ── --}}
<div class="nav-section-label">Overview</div>

<a href="{{ route('voter.dashboard') }}"
   class="nav-link {{ $currentRoute === 'voter.dashboard' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-gauge-high"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Dashboard</span>
        <span class="nav-link-sub">Your voting overview</span>
    </div>
</a>

{{-- ── Voting ── --}}
<div class="nav-section-label">Voting</div>

{{-- Always show Cast My Vote — the intro page handles already-voted state --}}
<a href="{{ route('voter.vote.intro') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'voter.vote') ? 'active' : '' }} {{ $voteBlocked ? 'opacity-70 cursor-not-allowed' : '' }}"
   data-tour="cast-vote-sidebar"
   data-election-guard="vote"
   title="{{ $voteBlocked ? $voteTooltip : '' }}"
   aria-disabled="{{ $voteBlocked ? 'true' : 'false' }}">
    <div class="nav-link-icon"><i class="fas fa-vote-yea"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Cast My Vote</span>
        <span class="nav-link-sub">{{ $hasVoted ? 'View your ballot' : 'Submit your ballot' }}</span>
    </div>
    @if($hasVoted)
        <span class="nav-badge green">Done</span>
    @else
        <span class="nav-badge">Vote</span>
    @endif
</a>


<hr class="sidebar-divider">

{{-- ── Account ── --}}
<div class="nav-section-label">Account</div>

<a href="{{ route('voter.feedback') }}"
   class="nav-link {{ $currentRoute === 'voter.feedback' ? 'active' : '' }}"
   data-tour="feedback-sidebar">
    <div class="nav-link-icon"><i class="fas fa-comment-dots"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Feedback</span>
        <span class="nav-link-sub">Share your experience</span>
    </div>
</a>