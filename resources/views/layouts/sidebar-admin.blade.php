{{-- ═══════════════════════════════════════
     ADMIN SIDEBAR NAVIGATION
     ═══════════════════════════════════════ --}}

@php
    $currentRoute = Route::currentRouteName();
@endphp

{{-- ── Overview ── --}}
<div class="nav-section-label">Overview</div>

<a href="{{ route('admin.dashboard') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'admin.dashboard') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-gauge-high"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Dashboard</span>
        <span class="nav-link-sub">System overview</span>
    </div>
</a>

{{-- ── Election Setup ── --}}
<div class="nav-section-label">Election Setup</div>

<a href="{{ route('admin.positions.index') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'positions') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-sitemap"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Positions</span>
        <span class="nav-link-sub">Manage election positions</span>
    </div>
</a>

<a href="{{ route('admin.partylists.index') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'partylists') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-flag"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Partylists</span>
        <span class="nav-link-sub">Manage party affiliations</span>
    </div>
</a>

<a href="{{ route('admin.organizations.index') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'organizations') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-building-columns"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Organizations</span>
        <span class="nav-link-sub">Student organizations</span>
    </div>
</a>

<a href="{{ route('admin.colleges.index') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'colleges') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-graduation-cap"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Colleges</span>
        <span class="nav-link-sub">Manage college units</span>
    </div>
</a>

{{-- ── Candidates ── --}}
<div class="nav-section-label">Candidates</div>

<a href="{{ route('admin.candidates.index') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'candidates') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-id-card"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Candidates</span>
        <span class="nav-link-sub">View & manage candidates</span>
    </div>
</a>

{{-- ── Voters ── --}}
<div class="nav-section-label">Voters</div>

<a href="{{ route('admin.voters.index') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'admin.voters') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-users"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Voters</span>
        <span class="nav-link-sub">Manage voter accounts</span>
    </div>
</a>

{{-- ── Results & Reports ── --}}
<div class="nav-section-label">Results & Reports</div>

<a href="{{ route('admin.votes.results') }}"
   class="nav-link {{ $currentRoute === 'admin.votes.results' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-chart-bar"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Election Results</span>
        <span class="nav-link-sub">Live vote tallies</span>
    </div>
    <span class="nav-badge green">Live</span>
</a>

<a href="{{ route('admin.votes.index') }}"
   class="nav-link {{ $currentRoute === 'admin.votes.index' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-ballot-check"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Vote Logs</span>
        <span class="nav-link-sub">All casted vote records</span>
    </div>
</a>

<a href="{{ route('admin.feedback.index') }}"
   class="nav-link {{ Str::startsWith($currentRoute, 'admin.feedback') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-comment-dots"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Feedback</span>
        <span class="nav-link-sub">Voter feedback & ratings</span>
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