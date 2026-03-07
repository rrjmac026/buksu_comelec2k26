@php
    $role = auth()->user()->role;
@endphp

<style>
    /* ══════════════════════════════════════════
       SIDEBAR — White Violet Palette
       ══════════════════════════════════════════ */

    /* ── Backdrop ── */
    .sidebar-backdrop {
        position: fixed; inset: 0; z-index: 40;
        background: rgba(15, 10, 30, 0.45);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        animation: backdrop-in 0.2s ease;
    }
    @keyframes backdrop-in {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    /* ── Sidebar shell ── */
    .sidebar-shell {
        position: fixed; top: 0; left: 0; bottom: 0;
        width: 18rem; /* 288px / lg:72 equivalent */
        z-index: 45;
        display: flex; flex-direction: column;

        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(24px) saturate(1.6);
        -webkit-backdrop-filter: blur(24px) saturate(1.6);
        border-right: 1px solid rgba(139, 92, 246, 0.14);
        box-shadow:
            4px 0 32px rgba(109, 40, 217, 0.08),
            1px 0 0 rgba(139, 92, 246, 0.06);

        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .dark .sidebar-shell {
        background: rgba(15, 10, 30, 0.97);
        border-right-color: rgba(139, 92, 246, 0.2);
        box-shadow:
            4px 0 40px rgba(0, 0, 0, 0.4),
            0 0 0 0.5px rgba(139, 92, 246, 0.12);
    }

    /* ── Decorative top accent ── */
    .sidebar-shell::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #7c3aed 0%, #a78bfa 50%, #c4b5fd 100%);
        z-index: 1;
    }

    /* ── Sidebar header ── */
    .sidebar-header {
        height: 64px; /* matches nav height */
        display: flex; align-items: center;
        padding: 0 20px;
        border-bottom: 1px solid rgba(139, 92, 246, 0.1);
        flex-shrink: 0;
        background: linear-gradient(180deg, rgba(245, 243, 255, 0.8) 0%, transparent 100%);
    }
    .dark .sidebar-header {
        border-bottom-color: rgba(139, 92, 246, 0.16);
        background: linear-gradient(180deg, rgba(109, 40, 217, 0.1) 0%, transparent 100%);
    }

    .sidebar-brand {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none;
    }
    .sidebar-brand-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #a78bfa);
        box-shadow: 0 0 8px rgba(139, 92, 246, 0.5);
        animation: dot-pulse 2.5s ease-in-out infinite;
    }
    @keyframes dot-pulse {
        0%, 100% { box-shadow: 0 0 6px rgba(139,92,246,0.4); transform: scale(1); }
        50%       { box-shadow: 0 0 14px rgba(139,92,246,0.7); transform: scale(1.15); }
    }
    .sidebar-brand-label {
        font-size: 0.78rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
        background: linear-gradient(105deg, #6d28d9 0%, #8b5cf6 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    /* ── Nav scroll area ── */
    .sidebar-nav {
        flex: 1; overflow-y: auto;
        padding: 14px 12px;
        scrollbar-width: thin;
        scrollbar-color: rgba(139,92,246,0.2) transparent;
    }
    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(139,92,246,0.2); border-radius: 99px;
    }

    /* ── Section label ── */
    .nav-section-label {
        font-size: 0.63rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
        color: #a78bfa; padding: 12px 10px 6px;
        display: flex; align-items: center; gap: 6px;
    }
    .nav-section-label::after {
        content: ''; flex: 1; height: 1px;
        background: linear-gradient(90deg, rgba(139,92,246,0.2) 0%, transparent 100%);
    }
    .dark .nav-section-label { color: #6d28d9; }

    /* ── Nav link base ── */
    .nav-link {
        display: flex; align-items: center; gap: 11px;
        padding: 9px 12px; border-radius: 10px;
        text-decoration: none; cursor: pointer;
        position: relative; overflow: hidden;
        transition: background 0.18s, transform 0.15s, box-shadow 0.18s;
        margin-bottom: 2px;
        border: 1px solid transparent;
    }
    .nav-link:hover {
        background: rgba(139, 92, 246, 0.07);
        transform: translateX(3px);
        border-color: rgba(139, 92, 246, 0.1);
    }
    .dark .nav-link:hover {
        background: rgba(139, 92, 246, 0.12);
        border-color: rgba(139, 92, 246, 0.2);
    }

    /* ── Active state ── */
    .nav-link.active {
        background: linear-gradient(105deg, rgba(109,40,217,0.12) 0%, rgba(139,92,246,0.08) 100%);
        border-color: rgba(139, 92, 246, 0.22);
        box-shadow: 0 2px 12px rgba(109, 40, 217, 0.1), inset 0 0 0 0.5px rgba(139,92,246,0.1);
    }
    .dark .nav-link.active {
        background: linear-gradient(105deg, rgba(109,40,217,0.22) 0%, rgba(139,92,246,0.14) 100%);
        border-color: rgba(139, 92, 246, 0.32);
        box-shadow: 0 2px 16px rgba(109, 40, 217, 0.2), inset 0 0 0 0.5px rgba(139,92,246,0.2);
    }
    .nav-link.active::before {
        content: '';
        position: absolute; left: 0; top: 20%; bottom: 20%;
        width: 3px; border-radius: 0 3px 3px 0;
        background: linear-gradient(180deg, #7c3aed, #a78bfa);
    }

    /* ── Nav icon ── */
    .nav-link-icon {
        width: 32px; height: 32px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.82rem; flex-shrink: 0;
        background: rgba(139, 92, 246, 0.08);
        color: #6d28d9;
        transition: background 0.18s, color 0.18s, transform 0.18s;
    }
    .dark .nav-link-icon { background: rgba(139,92,246,0.15); color: #a78bfa; }
    .nav-link:hover .nav-link-icon {
        background: linear-gradient(135deg, rgba(109,40,217,0.15), rgba(139,92,246,0.15));
        transform: scale(1.08);
        color: #5b21b6;
    }
    .dark .nav-link:hover .nav-link-icon { color: #c4b5fd; }
    .nav-link.active .nav-link-icon {
        background: linear-gradient(135deg, #7c3aed, #a78bfa);
        color: #fff;
        box-shadow: 0 3px 12px rgba(109, 40, 217, 0.35);
    }

    /* ── Nav text ── */
    .nav-link-text { flex: 1; }
    .nav-link-label {
        font-size: 0.82rem; font-weight: 600; display: block;
        color: #3b0764;
        transition: color 0.15s;
    }
    .dark .nav-link-label { color: #ddd6fe; }
    .nav-link.active .nav-link-label { color: #5b21b6; }
    .dark .nav-link.active .nav-link-label { color: #e9d5ff; }
    .nav-link:hover .nav-link-label { color: #5b21b6; }
    .dark .nav-link:hover .nav-link-label { color: #e9d5ff; }

    .nav-link-sub {
        font-size: 0.68rem; color: #a78bfa; display: block; margin-top: 0.5px;
        transition: color 0.15s;
    }
    .dark .nav-link-sub { color: #6d28d9; }
    .nav-link.active .nav-link-sub { color: #7c3aed; }
    .dark .nav-link.active .nav-link-sub { color: #a78bfa; }

    /* ── Badge chip ── */
    .nav-badge {
        font-size: 0.62rem; font-weight: 700; padding: 2px 7px; border-radius: 99px;
        background: linear-gradient(135deg, #7c3aed, #a78bfa);
        color: #fff;
        box-shadow: 0 2px 8px rgba(109, 40, 217, 0.3);
        flex-shrink: 0;
    }
    .nav-badge.green {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.3);
    }
    .nav-badge.orange {
        background: linear-gradient(135deg, #ea580c, #f97316);
        box-shadow: 0 2px 8px rgba(234, 88, 12, 0.3);
    }

    /* ── Ripple effect on click ── */
    .nav-link::after {
        content: '';
        position: absolute; inset: 0; border-radius: inherit;
        background: radial-gradient(circle, rgba(139,92,246,0.25) 0%, transparent 70%);
        opacity: 0; transform: scale(0);
        transition: opacity 0.4s, transform 0.4s;
        pointer-events: none;
    }
    .nav-link:active::after {
        opacity: 1; transform: scale(1);
        transition: opacity 0s, transform 0s;
    }

    /* ── Collapsible group ── */
    .nav-group-btn {
        display: flex; align-items: center; gap: 11px;
        padding: 9px 12px; border-radius: 10px;
        cursor: pointer; width: 100%; border: none; background: transparent;
        margin-bottom: 2px;
        transition: background 0.15s;
    }
    .nav-group-btn:hover { background: rgba(139,92,246,0.07); }
    .dark .nav-group-btn:hover { background: rgba(139,92,246,0.12); }

    .nav-group-chevron {
        font-size: 0.65rem; color: #c4b5fd; margin-left: auto;
        transition: transform 0.25s cubic-bezier(0.4,0,0.2,1);
    }
    .nav-group-chevron.open { transform: rotate(180deg); }
    .dark .nav-group-chevron { color: #4c1d95; }

    .nav-group-children {
        padding-left: 14px;
        border-left: 2px solid rgba(139, 92, 246, 0.15);
        margin-left: 22px;
        margin-bottom: 4px;
        overflow: hidden;
    }
    .dark .nav-group-children { border-left-color: rgba(139,92,246,0.25); }

    /* ── Sidebar footer ── */
    .sidebar-footer {
        padding: 12px 16px;
        border-top: 1px solid rgba(139, 92, 246, 0.1);
        flex-shrink: 0;
        background: linear-gradient(0deg, rgba(245, 243, 255, 0.6) 0%, transparent 100%);
    }
    .dark .sidebar-footer {
        border-top-color: rgba(139, 92, 246, 0.18);
        background: linear-gradient(0deg, rgba(109, 40, 217, 0.08) 0%, transparent 100%);
    }

    .sidebar-footer-inner {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 10px;
        background: rgba(139, 92, 246, 0.06);
        border: 1px solid rgba(139, 92, 246, 0.1);
    }
    .dark .sidebar-footer-inner {
        background: rgba(139, 92, 246, 0.1);
        border-color: rgba(139, 92, 246, 0.2);
    }

    .footer-logo-dot {
        width: 28px; height: 28px; border-radius: 8px;
        background: linear-gradient(135deg, #7c3aed, #a78bfa);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 0.7rem;
        box-shadow: 0 2px 10px rgba(109,40,217,0.3);
        flex-shrink: 0;
    }
    .footer-text { flex: 1; }
    .footer-app-name {
        font-size: 0.75rem; font-weight: 700;
        color: #4c1d95; display: block; line-height: 1.2;
    }
    .dark .footer-app-name { color: #c4b5fd; }
    .footer-version {
        font-size: 0.63rem; color: #a78bfa; letter-spacing: 0.04em;
    }
    .dark .footer-version { color: #6d28d9; }
    .footer-status {
        width: 7px; height: 7px; border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 6px rgba(34, 197, 94, 0.5);
        animation: status-pulse 2s ease-in-out infinite;
    }
    @keyframes status-pulse {
        0%, 100% { box-shadow: 0 0 4px rgba(34,197,94,0.4); }
        50%       { box-shadow: 0 0 12px rgba(34,197,94,0.7); }
    }

    /* ── Divider ── */
    .sidebar-divider {
        margin: 6px 10px;
        border: none; border-top: 1px solid rgba(139,92,246,0.08);
    }
    .dark .sidebar-divider { border-top-color: rgba(139,92,246,0.15); }
</style>

<div x-data class="h-full">

    <!-- Mobile backdrop -->
    <div x-show="$store.sidebar.isOpen"
         x-cloak
         class="sidebar-backdrop lg:hidden"
         @click="$store.sidebar.isOpen = false">
    </div>

    <!-- Sidebar -->
    <aside x-show="$store.sidebar.isOpen"
           x-cloak
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 -translate-x-full"
           x-transition:enter-end="opacity-100 translate-x-0"
           x-transition:leave="transition ease-in duration-250"
           x-transition:leave-start="opacity-100 translate-x-0"
           x-transition:leave-end="opacity-0 -translate-x-full"
           class="sidebar-shell">

        <!-- Header -->
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <div class="sidebar-brand-dot"></div>
                <span class="sidebar-brand-label">Navigation</span>
            </div>
        </div>

        <!-- Nav links -->
        <nav class="sidebar-nav"
             @click="if (($event.target.tagName === 'A' || $event.target.closest('a')) && window.innerWidth < 1024) {
                 $store.sidebar.isOpen = false
             }">
            @if($role === 'admin')
                @include('layouts.sidebar-admin')
            @elseif($role === 'voter')
                @include('layouts.sidebar-voter')
            @endif
        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <div class="sidebar-footer-inner">
                <div class="footer-logo-dot">
                    <i class="fas fa-vote-yea"></i>
                </div>
                <div class="footer-text">
                    <span class="footer-app-name">{{ config('app.name') }}</span>
                    <span class="footer-version">v2.0 · Stable</span>
                </div>
                <div class="footer-status" title="System online"></div>
            </div>
        </div>

    </aside>
</div>