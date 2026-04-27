@php
    $dashboardRoute = match(Auth::user()->role) {
        'admin' => route('admin.dashboard'),
        'voter' => route('voter.dashboard'),
        default => '/',
    };
@endphp

<style>
    html, body {
        overflow-x: hidden;
        transform: none !important;
        filter: none !important;
    }

    .nav-fixed-shell {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 9999;
    }

    .nav-root {
        background: linear-gradient(90deg, rgba(18,0,32,0.97) 0%, rgba(10,0,20,0.98) 100%);
        backdrop-filter: blur(24px) saturate(1.6);
        -webkit-backdrop-filter: blur(24px) saturate(1.6);
        border-bottom: 1px solid rgba(249, 180, 15, 0.2);
        box-shadow: 0 1px 32px rgba(0,0,0,0.5);
        height: 64px;
        display: flex;
        align-items: center;
        position: relative;
    }
    .nav-root::after {
        content: '';
        position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(249,180,15,0.5), rgba(249,180,15,0.2), transparent);
        pointer-events: none;
    }

    .nav-spacer { height: 64px; flex-shrink: 0; }

    .nav-toggle {
        display: flex; align-items: center; justify-content: center;
        width: 40px; height: 40px; border-radius: 10px;
        color: #f9b40f; flex-shrink: 0;
        transition: background 0.18s, transform 0.18s;
        border: none; background: transparent; cursor: pointer;
    }
    .nav-toggle:hover { background: rgba(249,180,15,0.12); transform: scale(1.08); }

    .nav-logo-wrap { display: flex; align-items: center; gap: 10px; text-decoration: none; min-width: 0; }
    .nav-logo-img {
        width: 36px; height: 36px; object-fit: contain; flex-shrink: 0;
        border-radius: 9px;
        box-shadow: 0 0 16px rgba(249,180,15,0.2);
        border: 1.5px solid rgba(249,180,15,0.35);
    }
    .nav-logo-text { display: flex; flex-direction: column; line-height: 1.15; min-width: 0; overflow: hidden; }
    .nav-logo-name {
        font-size: 0.95rem; font-weight: 700; font-family: 'Playfair Display', serif;
        color: #fffbf0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .nav-logo-name .accent {
        background: linear-gradient(105deg, #f9b40f 0%, #fcd558 60%, #fff3c4 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .nav-logo-sub {
        font-size: 0.62rem; font-weight: 600; letter-spacing: 0.06em;
        color: rgba(249,180,15,0.6); text-transform: uppercase;
    }

    /* ── Profile button ── */
    .profile-btn {
        display: flex; align-items: center; gap: 8px;
        padding: 4px; border-radius: 10px;
        border: 1px solid transparent;
        background: transparent; cursor: pointer;
        transition: background 0.18s, border-color 0.18s;
        flex-shrink: 0;
    }
    .profile-btn:hover { background: rgba(249,180,15,0.08); border-color: rgba(249,180,15,0.15); }

    .avatar-circle {
        width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, #f9b40f, #fcd558);
        color: #380041; font-size: 0.9rem; font-weight: 900;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 12px rgba(249,180,15,0.4);
        font-family: 'Playfair Display', serif;
    }
    .avatar-circle-lg {
        width: 46px; height: 46px; border-radius: 12px; flex-shrink: 0;
        background: linear-gradient(135deg, #f9b40f, #fcd558);
        color: #380041; font-size: 1.2rem; font-weight: 900;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 16px rgba(249,180,15,0.4);
        font-family: 'Playfair Display', serif;
    }

    .profile-name-text {
        font-size: 0.82rem; font-weight: 600; color: #fffbf0; line-height: 1.2;
        display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px;
    }
    .profile-role-text { font-size: 0.68rem; color: rgba(249,180,15,0.65); display: block; }
    .chevron-icon { font-size: 0.65rem; color: rgba(249,180,15,0.4); transition: transform 0.2s, color 0.2s; }

    /* ═══════════════════════════════════════════════════
       THE KEY FIX:
       position:fixed + left:8px + right:8px on mobile
       means it ALWAYS fits within the viewport width.
       On larger screens we cap it and pin it to the right.
    ═══════════════════════════════════════════════════ */
    .dropdown-panel {
        position: fixed;
        top: 68px;
        left: 8px;
        right: 8px;
        z-index: 99999;
        background: rgba(12, 0, 22, 0.99);
        backdrop-filter: blur(28px) saturate(1.8);
        -webkit-backdrop-filter: blur(28px) saturate(1.8);
        border: 1px solid rgba(249,180,15,0.28);
        border-radius: 16px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.7), 0 0 0 1px rgba(249,180,15,0.05) inset;
        overflow: hidden;
    }
    .dropdown-panel::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(249,180,15,0.7), transparent);
        pointer-events: none; z-index: 1;
    }

    /* Tablet and up: fixed width, pinned to right */
    @media (min-width: 480px) {
        .dropdown-panel {
            left: auto;
            right: 12px;
            width: 290px;
        }
    }

    /* Profile hero */
    .profile-hero {
        padding: 14px 16px;
        background: linear-gradient(135deg, rgba(56,0,65,0.95) 0%, rgba(82,0,96,0.8) 100%);
        display: flex; align-items: center; gap: 12px;
        border-bottom: 1px solid rgba(249,180,15,0.12);
    }
    .profile-hero-info { min-width: 0; flex: 1; }
    .profile-hero-name {
        font-size: 0.9rem; font-weight: 700; color: #fffbf0; line-height: 1.3;
        word-break: break-word;
    }
    .profile-hero-badge {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 0.67rem; font-weight: 600; letter-spacing: 0.04em;
        padding: 2px 8px; border-radius: 99px;
        background: rgba(249,180,15,0.12); color: #f9b40f;
        border: 1px solid rgba(249,180,15,0.25); margin-top: 4px;
    }

    /* Menu items */
    .dropdown-menu-inner { padding: 6px; }
    .dropdown-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px; border-radius: 10px;
        cursor: pointer; text-decoration: none;
        transition: background 0.15s, transform 0.15s;
        width: 100%; background: transparent; border: none; text-align: left; color: inherit;
    }
    .dropdown-item:hover { background: rgba(249,180,15,0.08); transform: translateX(2px); }

    .dropdown-item-icon {
        width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: rgba(249,180,15,0.1); color: #f9b40f; font-size: 0.82rem;
        border: 1px solid rgba(249,180,15,0.15); transition: all 0.15s;
    }
    .dropdown-item:hover .dropdown-item-icon {
        background: linear-gradient(135deg, #f9b40f, #fcd558);
        color: #380041; border-color: #f9b40f;
        box-shadow: 0 2px 10px rgba(249,180,15,0.4);
    }
    .dropdown-item-icon.danger { background: rgba(239,68,68,0.1); color: #f87171; border-color: rgba(239,68,68,0.2); }
    .dropdown-item:hover .dropdown-item-icon.danger {
        background: rgba(239,68,68,0.2); color: #fca5a5; border-color: rgba(239,68,68,0.35);
    }

    .dropdown-item-text { flex: 1; min-width: 0; }
    .dropdown-item-label { font-size: 0.84rem; font-weight: 600; color: #fffbf0; display: block; }
    .dropdown-item-label.danger { color: #f87171; }
    .dropdown-item-desc { font-size: 0.7rem; color: rgba(255,251,240,0.38); display: block; margin-top: 1px; }
    .dropdown-item-desc.danger { color: rgba(248,113,113,0.5); }
    .dropdown-chevron { font-size: 0.62rem; color: rgba(249,180,15,0.25); flex-shrink: 0; }

    .toggle-track {
        width: 34px; height: 19px; border-radius: 99px;
        background: rgba(255,251,240,0.1); transition: background 0.2s;
        position: relative; flex-shrink: 0;
    }
    .toggle-track.active { background: linear-gradient(90deg, #f9b40f, #fcd558); }
    .toggle-thumb {
        position: absolute; top: 2px; left: 2px;
        width: 15px; height: 15px; border-radius: 50%; background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.3);
        transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1);
    }
    .toggle-thumb.active { transform: translateX(15px); }

    .dropdown-divider { margin: 4px 10px; border: none; border-top: 1px solid rgba(249,180,15,0.1); }
    .dropdown-footer {
        padding: 8px 16px; text-align: center;
        font-size: 0.67rem; color: rgba(249,180,15,0.35); letter-spacing: 0.05em;
        background: rgba(56,0,65,0.5); border-top: 1px solid rgba(249,180,15,0.1);
    }

    @media (max-width: 380px) {
        .nav-logo-sub { display: none; }
        .nav-logo-name { font-size: 0.82rem; }
    }
</style>

<div x-data="navigationComponent()" x-init="init()">

    <div class="nav-fixed-shell">
        <nav class="nav-root">
            <div style="width:100%;padding:0 12px;display:flex;justify-content:space-between;align-items:center;height:100%;gap:8px;">

                <!-- LEFT: Hamburger + Logo -->
                <div style="display:flex;align-items:center;gap:8px;min-width:0;flex:1;">
                    <button @click="$store.sidebar.toggle()" class="nav-toggle">
                        <i class="fas fa-bars-staggered" style="font-size:1rem;"></i>
                    </button>
                    <a href="{{ $dashboardRoute }}" class="nav-logo-wrap">
                        <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" class="nav-logo-img" />
                        <div class="nav-logo-text">
                            <span class="nav-logo-name">{{ config('app.name') }} <span class="accent">System</span></span>
                            <span class="nav-logo-sub">Online Voting System</span>
                        </div>
                    </a>
                </div>

                <!-- RIGHT: Avatar only on mobile, avatar+name on sm+ -->
                <div style="flex-shrink:0;">
                    <button @click="profileOpen = !profileOpen" class="profile-btn">
                        <div class="avatar-circle">
                            <span x-text="userInitial">{{ Auth::check() ? strtoupper(substr(Auth::user()->full_name, 0, 1)) : 'G' }}</span>
                        </div>
                        <div class="hidden sm:flex" style="flex-direction:column;">
                            <span class="profile-name-text" x-text="userName">{{ Auth::check() ? Auth::user()->full_name : 'Guest' }}</span>
                            <span class="profile-role-text">{{ Auth::check() ? ucfirst(Auth::user()->role) : '' }}</span>
                        </div>
                        <i class="fas fa-chevron-down chevron-icon"
                           :style="profileOpen ? 'transform:rotate(180deg);color:rgba(249,180,15,0.8)' : ''"></i>
                    </button>
                </div>

            </div>
        </nav>
    </div>

    <div class="nav-spacer"></div>

    {{--
        DROPDOWN is OUTSIDE the nav shell entirely.
        position:fixed with left:8px right:8px guarantees
        it never overflows the viewport on any screen size.
    --}}
    <div x-show="profileOpen"
         @click.away="profileOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
         x-cloak
         class="dropdown-panel">

        <div class="profile-hero">
            <div class="avatar-circle-lg">
                <span x-text="userInitial">{{ Auth::check() ? strtoupper(substr(Auth::user()->full_name, 0, 1)) : 'G' }}</span>
            </div>
            <div class="profile-hero-info">
                <div class="profile-hero-name" x-text="userName">{{ Auth::check() ? Auth::user()->full_name : 'Guest' }}</div>
                <div class="profile-hero-badge">
                    <i class="fas fa-shield-halved"></i>
                    {{ Auth::check() ? ucfirst(Auth::user()->role) : '' }}
                </div>
            </div>
        </div>

        <div class="dropdown-menu-inner">
            @if(Auth::check() && Auth::user()->role === 'admin')
            <a :href="profileEditRoute" class="dropdown-item">
                <div class="dropdown-item-icon"><i class="fas fa-user"></i></div>
                <div class="dropdown-item-text">
                    <span class="dropdown-item-label">My Profile</span>
                    <span class="dropdown-item-desc">Manage account settings</span>
                </div>
                <i class="fas fa-chevron-right dropdown-chevron"></i>
            </a>
            @endif

            <button @click="$store.darkMode.toggle()" class="dropdown-item">
                <div class="dropdown-item-icon">
                    <i :class="$store.darkMode.on ? 'fas fa-sun' : 'fas fa-moon'"></i>
                </div>
                <div class="dropdown-item-text">
                    <span class="dropdown-item-label" x-text="$store.darkMode.on ? 'Light Mode' : 'Dark Mode'"></span>
                    <span class="dropdown-item-desc">Switch theme appearance</span>
                </div>
                <div class="toggle-track" :class="{ 'active': $store.darkMode.on }">
                    <div class="toggle-thumb" :class="{ 'active': $store.darkMode.on }"></div>
                </div>
            </button>

            <hr class="dropdown-divider" />

            <button @click="logout()" class="dropdown-item">
                <div class="dropdown-item-icon danger"><i class="fas fa-sign-out-alt"></i></div>
                <div class="dropdown-item-text">
                    <span class="dropdown-item-label danger">Sign Out</span>
                    <span class="dropdown-item-desc danger">End your current session</span>
                </div>
                <i class="fas fa-chevron-right dropdown-chevron"></i>
            </button>
        </div>

        <div class="dropdown-footer">{{ config('app.name') }} · v2.0</div>
    </div>

</div>

<script>
function navigationComponent() {
    return {
        profileOpen: false,
        userName:    @json(Auth::check() ? Auth::user()->full_name : 'Guest'),
        userInitial: @json(Auth::check() ? strtoupper(substr(Auth::user()->full_name, 0, 1)) : 'G'),
        profileEditRoute: '{{ Auth::check() && Auth::user()->role === "admin" ? route("admin.profile.edit") : "" }}',
        logoutRoute:      '{{ route("logout") }}',
        csrfToken:        '{{ csrf_token() }}',

        init() {},

        logout() {
            if (confirm('Are you sure you want to log out?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = this.logoutRoute;
                const csrf = document.createElement('input');
                csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = this.csrfToken;
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }
        }
    }
}
</script>