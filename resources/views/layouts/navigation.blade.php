@php
    $dashboardRoute = match(Auth::user()->role) {
        'admin' => route('admin.dashboard'),
        'voter' => route('voter.dashboard'),
        default => '/',
    };
@endphp

<style>
    /* ── Navigation Core ── */
    .nav-root {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px) saturate(1.8);
        -webkit-backdrop-filter: blur(20px) saturate(1.8);
        border-bottom: 1px solid rgba(139, 92, 246, 0.12);
        box-shadow: 0 1px 24px rgba(109, 40, 217, 0.07);
        transition: background 0.3s, box-shadow 0.3s;
    }
    .dark .nav-root {
        background: rgba(15, 10, 30, 0.92);
        border-bottom: 1px solid rgba(139, 92, 246, 0.18);
        box-shadow: 0 1px 32px rgba(109, 40, 217, 0.18);
    }

    /* ── Sidebar toggle ── */
    .nav-toggle {
        display: flex; align-items: center; justify-content: center;
        width: 40px; height: 40px; border-radius: 10px;
        color: #7c3aed;
        transition: background 0.18s, transform 0.18s, color 0.18s;
    }
    .nav-toggle:hover {
        background: rgba(139, 92, 246, 0.1);
        transform: scale(1.08);
    }
    .dark .nav-toggle { color: #a78bfa; }
    .dark .nav-toggle:hover { background: rgba(139, 92, 246, 0.18); }

    /* ── Logo ── */
    .nav-logo-wrap {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none;
    }
    .nav-logo-img {
        width: 36px; height: 36px; object-fit: contain;
        border-radius: 9px;
        box-shadow: 0 2px 12px rgba(109, 40, 217, 0.18);
        border: 1.5px solid rgba(139, 92, 246, 0.18);
    }
    .nav-logo-text { display: flex; flex-direction: column; line-height: 1.15; }
    .nav-logo-name {
        font-size: 0.97rem; font-weight: 700; letter-spacing: -0.01em;
        background: linear-gradient(105deg, #6d28d9 0%, #8b5cf6 60%, #a78bfa 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .nav-logo-sub {
        font-size: 0.67rem; font-weight: 500; letter-spacing: 0.04em;
        color: #a78bfa; text-transform: uppercase;
    }
    .dark .nav-logo-sub { color: #7c3aed; }

    /* ── Icon buttons (bell, profile) ── */
    .nav-icon-btn {
        position: relative; display: flex; align-items: center; justify-content: center;
        width: 38px; height: 38px; border-radius: 10px;
        color: #6d28d9; font-size: 1rem;
        transition: background 0.18s, transform 0.18s, color 0.18s;
    }
    .nav-icon-btn:hover {
        background: rgba(139, 92, 246, 0.1);
        transform: scale(1.08);
        color: #4c1d95;
    }
    .dark .nav-icon-btn { color: #a78bfa; }
    .dark .nav-icon-btn:hover { background: rgba(139, 92, 246, 0.2); color: #ede9fe; }

    /* ── Notification badge ── */
    .notif-badge {
        position: absolute; top: 4px; right: 4px;
        min-width: 17px; height: 17px; border-radius: 99px;
        background: linear-gradient(135deg, #7c3aed, #a78bfa);
        color: #fff; font-size: 0.62rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        padding: 0 3px;
        box-shadow: 0 0 0 2px #fff, 0 2px 8px rgba(109,40,217,0.3);
        animation: badge-pop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .dark .notif-badge { box-shadow: 0 0 0 2px #0f0a1e, 0 2px 8px rgba(139,92,246,0.4); }
    @keyframes badge-pop {
        0% { transform: scale(0); }
        100% { transform: scale(1); }
    }

    /* ── Dropdown Panel ── */
    .dropdown-panel {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(139, 92, 246, 0.14);
        border-radius: 16px;
        box-shadow:
            0 4px 6px rgba(109, 40, 217, 0.04),
            0 12px 40px rgba(109, 40, 217, 0.12),
            0 0 0 0.5px rgba(139, 92, 246, 0.08);
        overflow: hidden;
    }
    .dark .dropdown-panel {
        background: rgba(23, 12, 48, 0.97);
        border-color: rgba(139, 92, 246, 0.25);
        box-shadow:
            0 4px 6px rgba(0, 0, 0, 0.2),
            0 12px 40px rgba(0, 0, 0, 0.35),
            0 0 0 0.5px rgba(139, 92, 246, 0.15);
    }

    /* ── Notification items ── */
    .notif-header {
        padding: 14px 16px 10px;
        display: flex; align-items: center; justify-content: space-between;
        border-bottom: 1px solid rgba(139, 92, 246, 0.1);
    }
    .dark .notif-header { border-bottom-color: rgba(139, 92, 246, 0.18); }
    .notif-header-title {
        font-size: 0.82rem; font-weight: 700; letter-spacing: 0.03em;
        color: #4c1d95; display: flex; align-items: center; gap: 6px;
    }
    .dark .notif-header-title { color: #c4b5fd; }
    .notif-header-badge {
        font-size: 0.68rem; font-weight: 600; padding: 2px 8px; border-radius: 99px;
        background: linear-gradient(135deg, #7c3aed22, #a78bfa22);
        color: #7c3aed; border: 1px solid rgba(139, 92, 246, 0.2);
    }
    .dark .notif-header-badge { color: #a78bfa; background: rgba(139,92,246,0.15); }

    .notif-list { max-height: 320px; overflow-y: auto; padding: 6px 0; }
    .notif-list::-webkit-scrollbar { width: 4px; }
    .notif-list::-webkit-scrollbar-track { background: transparent; }
    .notif-list::-webkit-scrollbar-thumb {
        background: rgba(139, 92, 246, 0.25); border-radius: 99px;
    }

    .notif-item {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 10px 16px; cursor: pointer;
        transition: background 0.15s;
        position: relative;
        text-decoration: none;
    }
    .notif-item:hover { background: rgba(139, 92, 246, 0.06); }
    .dark .notif-item:hover { background: rgba(139, 92, 246, 0.12); }

    .notif-icon {
        width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        color: #7c3aed; font-size: 0.78rem;
    }
    .dark .notif-icon { background: rgba(139, 92, 246, 0.2); color: #a78bfa; }

    .notif-content { flex: 1; min-width: 0; }
    .notif-title {
        font-size: 0.8rem; font-weight: 600; color: #1e1b4b;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .dark .notif-title { color: #ede9fe; }
    .notif-msg {
        font-size: 0.73rem; color: #6d28d9; margin-top: 1px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        opacity: 0.75;
    }
    .dark .notif-msg { color: #a78bfa; }
    .notif-time { font-size: 0.67rem; color: #a78bfa; margin-top: 2px; }
    .dark .notif-time { color: #6d28d9; }

    .notif-unread-dot {
        width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; margin-top: 6px;
        background: linear-gradient(135deg, #7c3aed, #a78bfa);
        box-shadow: 0 0 6px rgba(139, 92, 246, 0.5);
    }
    .notif-empty {
        padding: 28px 16px; text-align: center; color: #a78bfa;
    }
    .dark .notif-empty { color: #6d28d9; }
    .notif-empty i { font-size: 1.6rem; margin-bottom: 8px; opacity: 0.5; display: block; }
    .notif-empty p { font-size: 0.8rem; }

    /* ── Profile button ── */
    .profile-btn {
        display: flex; align-items: center; gap: 10px;
        padding: 5px 10px 5px 5px; border-radius: 12px;
        transition: background 0.18s;
        cursor: pointer;
    }
    .profile-btn:hover { background: rgba(139, 92, 246, 0.08); }
    .dark .profile-btn:hover { background: rgba(139, 92, 246, 0.15); }

    .avatar-circle {
        width: 34px; height: 34px; border-radius: 10px;
        background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);
        color: #fff; font-size: 0.88rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 12px rgba(109, 40, 217, 0.3);
        flex-shrink: 0;
    }
    .avatar-circle-lg {
        width: 52px; height: 52px; border-radius: 14px; font-size: 1.3rem;
        background: linear-gradient(135deg, #6d28d9 0%, #a78bfa 100%);
        color: #fff; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 20px rgba(109, 40, 217, 0.35);
        flex-shrink: 0;
    }

    .profile-name {
        font-size: 0.82rem; font-weight: 600; color: #1e1b4b; line-height: 1.2;
    }
    .dark .profile-name { color: #ede9fe; }
    .profile-role {
        font-size: 0.7rem; color: #7c3aed; letter-spacing: 0.03em;
    }
    .dark .profile-role { color: #a78bfa; }
    .chevron-icon {
        font-size: 0.7rem; color: #a78bfa;
        transition: transform 0.2s;
    }

    /* ── Profile dropdown hero ── */
    .profile-hero {
        padding: 16px;
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
        display: flex; align-items: center; gap: 12px;
        border-bottom: 1px solid rgba(139, 92, 246, 0.12);
    }
    .dark .profile-hero {
        background: linear-gradient(135deg, rgba(109,40,217,0.18) 0%, rgba(139,92,246,0.12) 100%);
        border-bottom-color: rgba(139, 92, 246, 0.2);
    }
    .profile-hero-name {
        font-size: 0.9rem; font-weight: 700; color: #1e1b4b; line-height: 1.2;
    }
    .dark .profile-hero-name { color: #ede9fe; }
    .profile-hero-badge {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 0.68rem; font-weight: 600; letter-spacing: 0.04em;
        padding: 2px 8px; border-radius: 99px;
        background: linear-gradient(135deg, rgba(109,40,217,0.12), rgba(139,92,246,0.12));
        color: #6d28d9; border: 1px solid rgba(139, 92, 246, 0.2);
        margin-top: 3px;
    }
    .dark .profile-hero-badge { color: #a78bfa; border-color: rgba(139,92,246,0.3); }

    /* ── Dropdown menu items ── */
    .dropdown-menu { padding: 6px; }
    .dropdown-item {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 10px; border-radius: 10px;
        cursor: pointer; text-decoration: none;
        transition: background 0.15s, transform 0.15s;
        width: 100%;
    }
    .dropdown-item:hover {
        background: rgba(139, 92, 246, 0.08);
        transform: translateX(2px);
    }
    .dark .dropdown-item:hover { background: rgba(139, 92, 246, 0.14); }

    .dropdown-item-icon {
        width: 32px; height: 32px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        color: #7c3aed; font-size: 0.82rem; flex-shrink: 0;
        transition: background 0.15s;
    }
    .dark .dropdown-item-icon { background: rgba(139,92,246,0.18); color: #a78bfa; }
    .dropdown-item:hover .dropdown-item-icon {
        background: linear-gradient(135deg, #ddd6fe, #c4b5fd);
    }
    .dark .dropdown-item:hover .dropdown-item-icon { background: rgba(139,92,246,0.28); }

    .dropdown-item-icon.danger { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
    .dark .dropdown-item-icon.danger { background: rgba(239,68,68,0.15); color: #f87171; }
    .dropdown-item:hover .dropdown-item-icon.danger { background: rgba(239,68,68,0.18); }

    .dropdown-item-text { flex: 1; }
    .dropdown-item-label {
        font-size: 0.82rem; font-weight: 600; color: #1e1b4b; display: block;
    }
    .dark .dropdown-item-label { color: #ede9fe; }
    .dropdown-item-label.danger { color: #dc2626; }
    .dark .dropdown-item-label.danger { color: #f87171; }
    .dropdown-item-desc {
        font-size: 0.7rem; color: #7c3aed; opacity: 0.75;
    }
    .dark .dropdown-item-desc { color: #a78bfa; }
    .dropdown-item-desc.danger { color: #dc2626; opacity: 0.65; }

    .dropdown-chevron { font-size: 0.65rem; color: #c4b5fd; }
    .dark .dropdown-chevron { color: #4c1d95; }

    /* ── Toggle switch ── */
    .toggle-track {
        width: 34px; height: 19px; border-radius: 99px;
        background: #e2e8f0;
        transition: background 0.2s;
        position: relative; flex-shrink: 0;
    }
    .toggle-track.active {
        background: linear-gradient(90deg, #7c3aed, #a78bfa);
    }
    .toggle-thumb {
        position: absolute; top: 2px; left: 2px;
        width: 15px; height: 15px; border-radius: 50%;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.18);
        transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1);
    }
    .toggle-thumb.active { transform: translateX(15px); }

    /* ── Divider ── */
    .dropdown-divider {
        margin: 4px 10px;
        border: none; border-top: 1px solid rgba(139, 92, 246, 0.1);
    }
    .dark .dropdown-divider { border-top-color: rgba(139,92,246,0.18); }

    /* ── Dropdown footer ── */
    .dropdown-footer {
        padding: 8px 16px;
        text-align: center;
        font-size: 0.67rem; color: #c4b5fd; letter-spacing: 0.05em;
        background: rgba(139, 92, 246, 0.04);
        border-top: 1px solid rgba(139, 92, 246, 0.08);
    }
    .dark .dropdown-footer {
        color: #4c1d95;
        background: rgba(139, 92, 246, 0.07);
        border-top-color: rgba(139, 92, 246, 0.15);
    }

    /* ── Spinner ── */
    .spin { animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── Pulse glow on bell icon when unread ── */
    .bell-pulse::after {
        content: '';
        position: absolute; inset: 0; border-radius: 10px;
        background: rgba(139, 92, 246, 0.2);
        animation: bell-glow 1.8s ease-in-out infinite;
    }
    @keyframes bell-glow {
        0%, 100% { opacity: 0; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.15); }
    }
</style>

<div x-data="navigationComponent()" x-init="init()">
    <nav class="nav-root fixed top-0 left-0 right-0 z-50">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- Left Side -->
                <div class="flex items-center gap-3">
                    <!-- Sidebar Toggle -->
                    <button @click="$store.sidebar.toggle()" class="nav-toggle border-0 bg-transparent cursor-pointer">
                        <i class="fas fa-bars-staggered text-base"></i>
                    </button>

                    <!-- Logo + App Name -->
                    <a href="{{ $dashboardRoute }}" class="nav-logo-wrap">
                        <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" class="nav-logo-img" />
                        <div class="nav-logo-text">
                            <span class="nav-logo-name">{{ config('app.name') }}</span>
                            <span class="nav-logo-sub">Online Voting System</span>
                        </div>
                    </a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-2">

                    <!-- Notification Bell -->
                    <div class="relative">
                        <button @click="toggleNotifications()"
                                class="nav-icon-btn border-0 bg-transparent cursor-pointer"
                                :class="{ 'bell-pulse': unreadCount > 0 }">
                            <i class="fas fa-bell"></i>
                            <div x-show="unreadCount > 0" x-transition class="notif-badge">
                                <span x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
                            </div>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="notificationOpen"
                             @click.away="notificationOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             x-cloak
                             class="dropdown-panel absolute right-0 mt-3 w-80">

                            <!-- Header -->
                            <div class="notif-header">
                                <span class="notif-header-title">
                                    <i class="fas fa-bell"></i> Notifications
                                </span>
                                <div class="flex items-center gap-2">
                                    <div x-show="loading" class="spin w-3.5 h-3.5 border-2 border-violet-400 border-t-transparent rounded-full"></div>
                                    <span x-show="unreadCount > 0 && !loading" class="notif-header-badge" x-text="unreadCount + ' unread'"></span>
                                    <span x-show="!loading && allRead" class="notif-header-badge" style="color: #16a34a; background: rgba(22,163,74,0.1); border-color: rgba(22,163,74,0.2);">
                                        <i class="fas fa-check-circle mr-1"></i>All read
                                    </span>
                                </div>
                            </div>

                            <!-- List -->
                            <div class="notif-list">
                                <template x-for="notif in notifications" :key="notif.id">
                                    <a :href="notif.link || '#'"
                                       @click="notif.link ? handleNotificationClick($event, notif) : $event.preventDefault()"
                                       class="notif-item"
                                       :class="{ 'bg-violet-50/60 dark:bg-violet-900/10': !notif.is_read }">
                                        <div class="notif-icon">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        <div class="notif-content">
                                            <div class="notif-title" x-text="notif.title"></div>
                                            <div class="notif-msg" x-text="notif.message"></div>
                                            <div class="notif-time" x-text="notif.created_at"></div>
                                        </div>
                                        <div x-show="!notif.is_read" class="notif-unread-dot"></div>
                                    </a>
                                </template>

                                <div x-show="notifications.length === 0" class="notif-empty">
                                    <i class="fas fa-bell-slash"></i>
                                    <p>No notifications yet</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Button -->
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" class="profile-btn border-0 bg-transparent cursor-pointer">
                            <div class="avatar-circle">
                                <span x-text="userInitial">{{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'G' }}</span>
                            </div>
                            <div class="hidden sm:block text-left">
                                <div class="profile-name" x-text="userName">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
                                <div class="profile-role">{{ Auth::check() ? ucfirst(Auth::user()->role) : '' }}</div>
                            </div>
                            <i class="fas fa-chevron-down chevron-icon" :style="profileOpen ? 'transform:rotate(180deg)' : ''"></i>
                        </button>

                        <!-- Profile Dropdown -->
                        <div x-show="profileOpen"
                             @click.away="profileOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                             x-cloak
                             class="dropdown-panel absolute right-0 mt-3 w-64">

                            <!-- Hero -->
                            <div class="profile-hero">
                                <div class="avatar-circle-lg">
                                    <span x-text="userInitial">{{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'G' }}</span>
                                </div>
                                <div>
                                    <div class="profile-hero-name" x-text="userName">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
                                    <div class="profile-hero-badge">
                                        <i class="fas fa-shield-halved"></i>
                                        {{ Auth::check() ? ucfirst(Auth::user()->role) : '' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Menu -->
                            <div class="dropdown-menu">
                                <a :href="profileEditRoute" class="dropdown-item">
                                    <div class="dropdown-item-icon"><i class="fas fa-user"></i></div>
                                    <div class="dropdown-item-text">
                                        <span class="dropdown-item-label">My Profile</span>
                                        <span class="dropdown-item-desc">Manage account settings</span>
                                    </div>
                                    <i class="fas fa-chevron-right dropdown-chevron"></i>
                                </a>

                                <button @click="$store.darkMode.toggle()" class="dropdown-item">
                                    <div class="dropdown-item-icon">
                                        <template x-if="$store.darkMode.on"><i class="fas fa-sun"></i></template>
                                        <template x-if="!$store.darkMode.on"><i class="fas fa-moon"></i></template>
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

                            <!-- Footer -->
                            <div class="dropdown-footer">
                                {{ config('app.name') }} · v1.0
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </nav>
</div>

<script>
function navigationComponent() {
    return {
        notificationOpen: false,
        profileOpen: false,
        loading: false,
        allRead: false,

        userName: @json(Auth::check() ? Auth::user()->name : 'Guest'),
        userInitial: @json(Auth::check() ? substr(Auth::user()->name, 0, 1) : 'G'),
        unreadCount: 0,
        notifications: [],

        profileEditRoute: '{{ route("profile.edit") }}',
        logoutRoute: '{{ route("logout") }}',
        csrfToken: '{{ csrf_token() }}',

        init() {
            this.updateUnreadCount();
            this.updateAllReadStatus();
        },

        toggleNotifications() {
            this.notificationOpen = !this.notificationOpen;
        },

        handleNotificationClick(event, notif) {
            if (!notif.is_read) {
                notif.is_read = true;
                this.updateUnreadCount();
                this.updateAllReadStatus();
            }
            this.notificationOpen = false;
        },

        updateUnreadCount() {
            this.unreadCount = this.notifications.filter(n => !n.is_read).length;
        },

        updateAllReadStatus() {
            this.allRead = this.notifications.length > 0 && this.unreadCount === 0;
        },

        logout() {
            if (confirm('Are you sure you want to log out?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = this.logoutRoute;
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = this.csrfToken;
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }
        }
    }
}
</script>