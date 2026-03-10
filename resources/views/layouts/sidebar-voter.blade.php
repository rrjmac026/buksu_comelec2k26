{{-- ═══════════════════════════════════════
     VOTER SIDEBAR NAVIGATION
     ═══════════════════════════════════════ --}}

@php
    $currentRoute = Route::currentRouteName();
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

<a href="#"
   class="nav-link {{ $currentRoute === 'voter.vote' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-vote-yea"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Cast My Vote</span>
        <span class="nav-link-sub">Submit your ballot</span>
    </div>
    <span class="nav-badge">Vote</span>
</a>

{{-- ── Election Info ── --}}
<div class="nav-section-label">Election Info</div>

<a href="#"
   class="nav-link {{ $currentRoute === 'voter.candidates' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-id-card"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">View Candidates</span>
        <span class="nav-link-sub">Browse all candidates</span>
    </div>
</a>

<hr class="sidebar-divider">

{{-- ── Account ── --}}
<div class="nav-section-label">Account</div>

<a href="{{ route('profile.edit') }}"
   class="nav-link {{ $currentRoute === 'profile.edit' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-user-gear"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">My Profile</span>
        <span class="nav-link-sub">Account settings</span>
    </div>
</a>