{{-- ═══════════════════════════════════════
     ADMIN SIDEBAR NAVIGATION
     ═══════════════════════════════════════ --}}

@php
    $currentRoute = Route::currentRouteName();
    $is = fn(string $pattern) => Str::startsWith($currentRoute, $pattern) || $currentRoute === $pattern;
@endphp

{{-- ── Overview ── --}}
<div class="nav-section-label">Overview</div>

<a href="{{ route('admin.dashboard') }}"
   class="nav-link {{ $is('admin.dashboard') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-gauge-high"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Dashboard</span>
        <span class="nav-link-sub">System overview</span>
    </div>
</a>

{{-- ── Election Control ── --}}
<div class="nav-section-label">Election Control</div>

<a href="{{ route('admin.election.index') }}"
   class="nav-link {{ $is('admin.election') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-tower-broadcast"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Election Status</span>
        <span class="nav-link-sub">Start, pause, or end election</span>
    </div>
    @php $electionStatus = \App\Models\ElectionSetting::status(); @endphp
    @if($electionStatus === 'ongoing')
        <span class="nav-badge green">Live</span>
    @elseif($electionStatus === 'upcoming')
        <span class="nav-badge" style="background:rgba(249,180,15,0.12);color:#f9b40f;border:1px solid rgba(249,180,15,0.25);">Soon</span>
    @else
        <span class="nav-badge" style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.35);border:1px solid rgba(255,255,255,0.1);">Done</span>
    @endif
</a>

{{-- ── Election Setup ── --}}
<div class="nav-section-label">Election Setup</div>

<a href="{{ route('admin.positions.index') }}"
   class="nav-link {{ $is('admin.positions') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-sitemap"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Positions</span>
        <span class="nav-link-sub">Manage election positions</span>
    </div>
</a>

<a href="{{ route('admin.partylists.index') }}"
   class="nav-link {{ $is('admin.partylists') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-flag"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Partylists</span>
        <span class="nav-link-sub">Manage party affiliations</span>
    </div>
</a>

<a href="{{ route('admin.organizations.index') }}"
   class="nav-link {{ $is('admin.organizations') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-building-columns"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Organizations</span>
        <span class="nav-link-sub">Student organizations</span>
    </div>
</a>

<a href="{{ route('admin.colleges.index') }}"
   class="nav-link {{ $is('admin.colleges') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-graduation-cap"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Colleges</span>
        <span class="nav-link-sub">Manage college units</span>
    </div>
</a>

{{-- ── Candidates ── --}}
<div class="nav-section-label">Candidates</div>

<a href="{{ route('admin.candidates.index') }}"
   class="nav-link {{ $is('admin.candidates') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-id-card"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Candidates</span>
        <span class="nav-link-sub">View & manage candidates</span>
    </div>
</a>

{{-- ── Voters ── --}}
<div class="nav-section-label">Voters</div>

<a href="{{ route('admin.voters.index') }}"
   class="nav-link {{ $is('admin.voters') ? 'active' : '' }}">
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
    <div class="nav-link-icon"><i class="fas fa-scroll"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Vote Logs</span>
        <span class="nav-link-sub">All casted vote records</span>
    </div>
</a>

<a href="{{ route('admin.feedback.index') }}"
   class="nav-link {{ $is('admin.feedback') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-comment-dots"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Feedback</span>
        <span class="nav-link-sub">Voter feedback & ratings</span>
    </div>
</a>

<a href="{{ route('admin.reports.index') }}"
   class="nav-link {{ $is('admin.reports') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-file-alt"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Reports</span>
        <span class="nav-link-sub">Detailed election reports</span>
    </div>
</a>

<hr class="sidebar-divider">

{{-- ── System ── --}}
<div class="nav-section-label">System</div>

<a href="{{ route('admin.backups.index') }}"
   class="nav-link {{ $is('admin.backups') ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-database"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">Backups</span>
        <span class="nav-link-sub">Database backup & restore</span>
    </div>
    @php
        $latestBackup = \App\Models\DataBackup::where('status', 'completed')
            ->latest('completed_at')->first();
        $processingCount = \App\Models\DataBackup::where('status', 'processing')->count();
    @endphp
    @if($processingCount > 0)
        <span class="nav-badge" style="background:rgba(96,165,250,0.12);color:#60a5fa;border:1px solid rgba(96,165,250,0.25);">
            Running
        </span>
    @elseif($latestBackup && $latestBackup->completed_at->diffInHours() <= 24)
        <span class="nav-badge green">OK</span>
    @endif
</a>

<hr class="sidebar-divider">

{{-- ── Account ── --}}
<div class="nav-section-label">Account</div>

<a href="{{ route('admin.profile.edit') }}"
   class="nav-link {{ $is('admin.profile') || $currentRoute === 'profile.edit' ? 'active' : '' }}">
    <div class="nav-link-icon"><i class="fas fa-user-gear"></i></div>
    <div class="nav-link-text">
        <span class="nav-link-label">My Profile</span>
        <span class="nav-link-sub">Account settings</span>
    </div>
</a>