{{-- ═══════════════════════════════════════
     VOTER SIDEBAR NAVIGATION
     ═══════════════════════════════════════ --}}

@php
    $currentRoute = Route::currentRouteName();
    $hasVoted     = auth()->user()->hasVoted();
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
   class="nav-link {{ Str::startsWith($currentRoute, 'voter.vote') ? 'active' : '' }}">
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

{{-- ── Election Info ── --}}
<div class="nav-section-label">Election Info</div>

<a href="{{ route('voter.results') }}"
   class="nav-link {{ $currentRoute === 'voter.results' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-chart-bar"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Election Results</span>
        <span class="nav-link-sub">Live vote standings</span>
    </div>
    <span class="nav-badge green">Live</span>
</a>

<hr class="sidebar-divider">

{{-- ── Account ── --}}
<div class="nav-section-label">Account</div>

<a href="{{ route('voter.feedback') }}"
   class="nav-link {{ $currentRoute === 'voter.feedback' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-comment-dots"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Feedback</span>
        <span class="nav-link-sub">Share your experience</span>
    </div>
</a>

<a href="{{ route('profile.edit') }}"
   class="nav-link {{ $currentRoute === 'profile.edit' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-user-gear"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">My Profile</span>
        <span class="nav-link-sub">Account settings</span>
    </div>
</a>