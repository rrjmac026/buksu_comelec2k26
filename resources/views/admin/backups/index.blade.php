<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes shimmerBar {
    0%,100% { background-position: 0% 0%; }
    50%      { background-position: 100% 0%; }
}
@keyframes pulse {
    0%,100% { opacity: 1; }
    50%      { opacity: .4; }
}
@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ── Stat strip ── */
.abk-stat-strip {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 20px;
}
@media (max-width: 640px) { .abk-stat-strip { grid-template-columns: 1fr 1fr; } }

.abk-stat-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 16px; padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: inset 0 1px 0 rgba(249,180,15,0.05);
    animation: fadeUp .4s ease both;
}
.abk-stat-icon {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
}
.abk-stat-num {
    font-family: 'Playfair Display', serif; font-size: 1.55rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, #f9b40f, #fcd558, #fff3c4);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.abk-stat-lbl {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.45); margin-top: 3px;
}

/* ── Page header ── */
.abk-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    animation: fadeUp .3s ease both;
}
.abk-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem; font-weight: 900; color: #fffbf0; margin: 0 0 3px;
}
.abk-page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); }

/* ── Toast ── */
.abk-toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 600;
    animation: fadeUp .35s ease both;
}
.abk-toast-success { background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
.abk-toast-error   { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }

/* ── Processing banner ── */
.abk-processing-banner {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 20px; border-radius: 12px; margin-bottom: 18px;
    background: rgba(96,165,250,0.06); border: 1px solid rgba(96,165,250,0.2);
    animation: fadeUp .35s ease both;
}
.abk-spin {
    width: 18px; height: 18px; border: 2px solid rgba(96,165,250,0.2);
    border-top-color: #60a5fa; border-radius: 50%; flex-shrink: 0;
    animation: spin .8s linear infinite;
}
.abk-prog-track {
    flex: 1; height: 6px; border-radius: 99px;
    background: rgba(96,165,250,0.1); overflow: hidden; margin-top: 6px;
}
.abk-prog-fill {
    height: 100%; border-radius: 99px;
    background: linear-gradient(90deg, #60a5fa, #93c5fd);
    transition: width .5s ease;
}

/* ── Buttons ── */
.abk-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px; border-radius: 9px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; border: none; white-space: nowrap;
    text-decoration: none;
}
.abk-btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 3px 12px rgba(249,180,15,0.3);
}
.abk-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(249,180,15,0.45); color: #380041; }
.abk-btn-sky {
    background: transparent; border: 1px solid rgba(96,165,250,0.25); color: rgba(96,165,250,0.7);
}
.abk-btn-sky:hover { background: rgba(96,165,250,0.08); border-color: rgba(96,165,250,0.5); color: #93c5fd; }
.abk-btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.55);
}
.abk-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }

/* ── Table card ── */
.abk-table-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
    animation: fadeUp .46s ease both;
}
.abk-table-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

.abk-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.abk-thead tr {
    background: linear-gradient(to right, rgba(56,0,65,0.5), transparent);
    border-bottom: 1px solid rgba(249,180,15,0.12);
}
.abk-thead th {
    padding: 14px 20px; text-align: left;
    font-size: 0.58rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.6);
}
.abk-tbody tr {
    border-bottom: 1px solid rgba(249,180,15,0.07);
    transition: background .18s;
}
.abk-tbody tr:last-child { border-bottom: none; }
.abk-tbody tr:hover { background: rgba(249,180,15,0.04); }
.abk-tbody td { padding: 14px 20px; color: rgba(255,251,240,0.85); vertical-align: middle; }

/* ── Badges ── */
.abk-type-badge {
    display: inline-flex; padding: 3px 10px; border-radius: 7px;
    font-size: 0.62rem; font-weight: 700;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.8);
}
.abk-type-badge.full {
    background: rgba(96,165,250,0.1); border-color: rgba(96,165,250,0.2);
    color: rgba(96,165,250,0.8);
}

.abk-status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 99px; font-size: 0.65rem; font-weight: 700;
}
.abk-status-badge.completed { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
.abk-status-badge.processing { background: rgba(96,165,250,0.1); border: 1px solid rgba(96,165,250,0.2); color: #60a5fa; }
.abk-status-badge.failed     { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2); color: #f87171; }
.abk-status-badge.pending    { background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.15); color: rgba(249,180,15,0.65); }

.abk-spin-sm {
    width: 10px; height: 10px;
    border: 1.5px solid rgba(96,165,250,0.2);
    border-top-color: #60a5fa; border-radius: 50%;
    animation: spin .8s linear infinite; display: inline-block; flex-shrink: 0;
}

/* ── Progress mini ── */
.abk-mini-track { width: 90px; height: 5px; border-radius: 99px; background: rgba(249,180,15,0.07); overflow: hidden; display: inline-block; vertical-align: middle; }
.abk-mini-fill  { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #60a5fa, #93c5fd); transition: width .5s; }

/* ── Action buttons ── */
.abk-action-btn {
    width: 30px; height: 30px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1px solid rgba(249,180,15,0.15); background: transparent;
    color: rgba(249,180,15,0.5); font-size: 0.65rem;
    cursor: pointer; transition: all .18s; text-decoration: none;
}
.abk-action-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.06); }
.abk-action-btn.sky { border-color: rgba(96,165,250,0.2); color: rgba(96,165,250,0.6); }
.abk-action-btn.sky:hover { border-color: rgba(96,165,250,0.5); color: #93c5fd; background: rgba(96,165,250,0.08); }
.abk-action-btn.danger { border-color: rgba(248,113,113,0.2); color: rgba(248,113,113,0.5); }
.abk-action-btn.danger:hover { border-color: rgba(248,113,113,0.45); color: #f87171; background: rgba(248,113,113,0.06); }
.abk-action-btn.amber { border-color: rgba(251,146,60,0.2); color: rgba(251,146,60,0.6); }
.abk-action-btn.amber:hover { border-color: rgba(251,146,60,0.45); color: #fb923c; background: rgba(251,146,60,0.08); }

/* ── Empty ── */
.abk-empty { padding: 60px 24px; text-align: center; }
.abk-empty-icon  { font-size: 2.5rem; color: rgba(249,180,15,0.1); margin-bottom: 14px; display: block; }
.abk-empty-title { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 800; color: rgba(255,251,240,0.35); margin-bottom: 6px; }
.abk-empty-sub   { font-size: 0.72rem; color: rgba(255,251,240,0.2); }

.abk-pagination { padding: 16px 20px; border-top: 1px solid rgba(249,180,15,0.1); }

/* ── Modal ── */
.abk-modal-backdrop {
    position: fixed; inset: 0; z-index: 50;
    background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center; padding: 16px;
}
.abk-modal {
    background: rgba(22,0,28,0.98);
    border: 1px solid rgba(249,180,15,0.25);
    border-radius: 20px; width: 100%; max-width: 420px;
    box-shadow: 0 24px 80px rgba(0,0,0,0.7);
    overflow: hidden;
    animation: fadeUp .3s ease both;
}
.abk-modal::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
}
.abk-modal-header {
    padding: 22px 24px 16px;
    border-bottom: 1px solid rgba(249,180,15,0.08);
    background: linear-gradient(to right, rgba(56,0,65,0.4), transparent);
}
.abk-modal-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; }
.abk-modal-sub   { font-size: 0.7rem; color: rgba(255,251,240,0.4); margin-top: 3px; }
.abk-modal-body  { padding: 20px 24px; }
.abk-modal-footer { padding: 16px 24px; border-top: 1px solid rgba(249,180,15,0.08); display: flex; gap: 10px; justify-content: flex-end; }

.abk-field-label {
    display: block; font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 7px;
}
.abk-select, .abk-input {
    width: 100%; background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
    border-radius: 10px; padding: 10px 14px;
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem; color: #fffbf0;
    outline: none; transition: border-color .2s;
    margin-bottom: 14px;
}
.abk-select:focus, .abk-input:focus { border-color: rgba(249,180,15,0.4); }
.abk-select { -webkit-appearance: none; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(249,180,15,0.5)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
}
.abk-select option { background: #1a0020; }

.abk-checkbox-row {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; border-radius: 10px;
    background: rgba(56,0,65,0.3); border: 1px solid rgba(249,180,15,0.1);
}
.abk-checkbox-row input[type="checkbox"] { accent-color: #f9b40f; width: 14px; height: 14px; }
.abk-checkbox-label { font-size: 0.75rem; color: rgba(255,251,240,0.65); }

.abk-hint { font-size: 0.62rem; color: rgba(255,251,240,0.25); margin-top: -10px; margin-bottom: 14px; padding-left: 2px; }

/* ── Delete confirm modal ── */
.abk-del-icon {
    width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
    background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: #f87171;
}
.abk-del-body { font-size: 0.75rem; color: rgba(255,251,240,0.5); line-height: 1.7; margin: 14px 0 20px; }
.abk-m-cancel {
    padding: 9px 18px; border-radius: 9px; cursor: pointer;
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.55); font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700; transition: all .18s;
}
.abk-m-cancel:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
.abk-m-delete {
    padding: 9px 20px; border-radius: 9px; cursor: pointer;
    background: linear-gradient(135deg, #ef4444, #f87171); border: none;
    color: #fff; font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(239,68,68,0.3); transition: all .18s;
}
.abk-m-delete:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(239,68,68,0.45); }

/* ── Test results panel ── */
.abk-test-panel {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.18); border-radius: 18px;
    overflow: hidden; margin-bottom: 16px;
    animation: fadeUp .4s ease both;
}
.abk-test-panel::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%; animation: shimmerBar 3s ease-in-out infinite;
}
.abk-test-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 20px; border-bottom: 1px solid rgba(249,180,15,0.07);
    font-size: 0.78rem;
}
.abk-test-row:last-child { border-bottom: none; }
.abk-test-key { color: rgba(255,251,240,0.5); font-size: 0.72rem; }
.abk-test-val { font-weight: 600; }
.abk-test-val.ok { color: #34d399; }
.abk-test-val.warn { color: #fb923c; }
.abk-test-val.err { color: #f87171; }
</style>
@endpush

<div style="padding: 0 0 60px;">

    {{-- Page Header --}}
    <div class="abk-page-header">
        <div>
            <h1 class="abk-page-title">Database Backups</h1>
            <p class="abk-page-sub">Manage and monitor all backup records</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <button onclick="openTestModal()" class="abk-btn abk-btn-sky">
                <i class="fas fa-flask" style="font-size:.62rem;"></i> Test System
            </button>
            <button onclick="openCreateModal()" class="abk-btn abk-btn-primary">
                <i class="fas fa-plus" style="font-size:.62rem;"></i> Create Backup
            </button>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="abk-toast abk-toast-success"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-circle-check" style="flex-shrink:0;"></i>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="abk-toast abk-toast-error"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i>
        {{ session('error') }}
    </div>
    @endif

    {{-- Processing Banner --}}
    @if(($stats['processing'] ?? 0) > 0)
    <div class="abk-processing-banner" id="processingBanner">
        <div class="abk-spin"></div>
        <div style="flex:1;">
            <div style="font-size:0.75rem;font-weight:700;color:#60a5fa;">
                {{ $stats['processing'] }} backup{{ $stats['processing'] > 1 ? 's' : '' }} in progress…
            </div>
            <div class="abk-prog-track" style="margin-top:6px;">
                <div class="abk-prog-fill" id="globalProgress" style="width:30%"></div>
            </div>
        </div>
        <span style="font-size:0.65rem;color:rgba(96,165,250,0.5);">Auto-refreshing</span>
    </div>
    @endif

    {{-- Stats Strip --}}
    <div class="abk-stat-strip">
        <div class="abk-stat-card" style="animation-delay:.06s;">
            <div class="abk-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-database" style="color:#f9b40f;"></i>
            </div>
            <div>
                <div class="abk-stat-num">{{ $stats['total'] ?? 0 }}</div>
                <div class="abk-stat-lbl">Total Backups</div>
            </div>
        </div>
        <div class="abk-stat-card" style="animation-delay:.1s;">
            <div class="abk-stat-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-circle-check" style="color:#34d399;"></i>
            </div>
            <div>
                <div class="abk-stat-num" style="background:linear-gradient(135deg,#34d399,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    {{ $stats['completed'] ?? 0 }}
                </div>
                <div class="abk-stat-lbl">Completed</div>
            </div>
        </div>
        <div class="abk-stat-card" style="animation-delay:.14s;">
            <div class="abk-stat-icon" style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);">
                <i class="fas fa-circle-xmark" style="color:#f87171;"></i>
            </div>
            <div>
                <div class="abk-stat-num" style="background:linear-gradient(135deg,#f87171,#fca5a5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    {{ $stats['failed'] ?? 0 }}
                </div>
                <div class="abk-stat-lbl">Failed</div>
            </div>
        </div>
        <div class="abk-stat-card" style="animation-delay:.18s;">
            <div class="abk-stat-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                <i class="fas fa-weight-hanging" style="color:#60a5fa;"></i>
            </div>
            <div>
                <div class="abk-stat-num" style="background:linear-gradient(135deg,#60a5fa,#93c5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    {{ $stats['formatted_total_size'] ?? '0 B' }}
                </div>
                <div class="abk-stat-lbl">Total Size</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="abk-table-card">
        <div style="overflow-x:auto;">
            <table class="abk-table">
                <thead class="abk-thead">
                    <tr>
                        <th>Backup Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Size</th>
                        <th>Expires</th>
                        <th>Created</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody class="abk-tbody">
                    @forelse($backups as $backup)
                    <tr data-backup-id="{{ $backup->id }}">
                        {{-- Name --}}
                        <td>
                            <div style="font-weight:600;color:#fffbf0;font-size:0.8rem;">
                                {{ $backup->backup_name }}
                            </div>
                            @if($backup->created_by && $backup->creator)
                            <div style="font-size:0.62rem;color:rgba(249,180,15,0.4);margin-top:2px;">
                                by {{ $backup->creator->full_name ?? $backup->creator->name }}
                            </div>
                            @endif
                        </td>

                        {{-- Type --}}
                        <td>
                            <span class="abk-type-badge {{ $backup->backup_type === 'full' ? 'full' : '' }}">
                                {{ ucfirst($backup->backup_type) }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="abk-status-badge {{ $backup->status }} backup-status">
                                @if($backup->status === 'processing')
                                    <span class="abk-spin-sm"></span>
                                @elseif($backup->status === 'completed')
                                    <i class="fas fa-check" style="font-size:.5rem;"></i>
                                @elseif($backup->status === 'failed')
                                    <i class="fas fa-xmark" style="font-size:.5rem;"></i>
                                @else
                                    <i class="fas fa-clock" style="font-size:.5rem;"></i>
                                @endif
                                {{ ucfirst($backup->status) }}
                            </span>
                        </td>

                        {{-- Progress --}}
                        <td>
                            @if($backup->status === 'processing')
                            <div>
                                <div class="abk-mini-track">
                                    <div class="abk-mini-fill backup-progress-bar"
                                         style="width:{{ $backup->progress ?? 0 }}%"></div>
                                </div>
                                <div style="font-size:0.6rem;color:rgba(96,165,250,0.6);margin-top:3px;" class="backup-progress-text">
                                    {{ $backup->progress ?? 0 }}%
                                </div>
                            </div>
                            @else
                            <span style="color:rgba(255,251,240,0.2);font-size:0.72rem;">—</span>
                            @endif
                        </td>

                        {{-- Size --}}
                        <td style="color:rgba(255,251,240,0.7);font-size:0.75rem;">
                            {{ $backup->formatted_size ?? '—' }}
                        </td>

                        {{-- Expires --}}
                        <td style="font-size:0.72rem;">
                            @if($backup->retention_until)
                                @if($backup->retention_until->isPast())
                                    <span style="color:#f87171;">Expired</span>
                                @elseif($backup->retention_until->diffInDays(now()) <= 3)
                                    <span style="color:#fb923c;">{{ $backup->retention_until->diffForHumans() }}</span>
                                @else
                                    <span style="color:rgba(255,251,240,0.4);">{{ $backup->retention_until->format('M d, Y') }}</span>
                                @endif
                            @else
                                <span style="color:rgba(255,251,240,0.2);">—</span>
                            @endif
                        </td>

                        {{-- Created --}}
                        <td style="font-size:0.72rem;color:rgba(255,251,240,0.5);">
                            {{ $backup->created_at->diffForHumans() }}
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                                @if($backup->status === 'completed')
                                <a href="{{ route('admin.backups.download', $backup) }}"
                                   class="abk-action-btn sky" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif

                                @if($backup->status === 'failed' && $backup->error_message)
                                <button type="button"
                                        class="abk-action-btn amber" title="View Error"
                                        onclick="showError('{{ addslashes($backup->error_message) }}')">
                                    <i class="fas fa-circle-exclamation"></i>
                                </button>
                                @endif

                                <button type="button"
                                        class="abk-action-btn danger" title="Delete"
                                        onclick="openDeleteModal({{ $backup->id }}, '{{ addslashes($backup->backup_name) }}')"
                                        {{ $backup->status === 'processing' ? 'disabled style=opacity:.3;cursor:not-allowed' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding:0;">
                            <div class="abk-empty">
                                <i class="fas fa-database abk-empty-icon"></i>
                                <div class="abk-empty-title">No backups yet</div>
                                <div class="abk-empty-sub">Create your first backup to get started.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($backups->hasPages())
        <div class="abk-pagination">
            {{ $backups->withQueryString()->links() }}
        </div>
        @endif
    </div>

    {{-- Cleanup button --}}
    @if(($stats['total'] ?? 0) > 0)
    <div style="margin-top:14px;display:flex;justify-content:flex-end;">
        <form method="POST" action="{{ route('admin.backups.cleanup') }}">
            @csrf
            <button type="submit" class="abk-btn abk-btn-ghost"
                    onclick="return confirm('Clean up all expired backups?')">
                <i class="fas fa-broom" style="font-size:.62rem;"></i> Clean Expired
            </button>
        </form>
    </div>
    @endif

</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- CREATE BACKUP MODAL                         --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="createModal" class="abk-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeCreateModal()">
    <div class="abk-modal">
        <div class="abk-modal-header">
            <div class="abk-modal-title">Create New Backup</div>
            <div class="abk-modal-sub">Configure and run a new database backup</div>
        </div>
        <form method="POST" action="{{ route('admin.backups.store') }}">
            @csrf
            <div class="abk-modal-body">

                <label class="abk-field-label">Backup Type</label>
                <select name="backup_type" class="abk-select">
                    <option value="database">Database only</option>
                    <option value="full">Full backup (database + files)</option>
                </select>

                <label class="abk-field-label">Retention Period</label>
                <input type="number" name="retention_days" value="30" min="1" max="365" class="abk-input">
                <div class="abk-hint">Backup will auto-delete after this many days</div>

                <div class="abk-checkbox-row">
                    <input type="checkbox" name="async" value="1" id="asyncCheck">
                    <label for="asyncCheck" class="abk-checkbox-label">
                        Run in background <span style="color:rgba(249,180,15,0.4);">(requires queue:work)</span>
                    </label>
                </div>

            </div>
            <div class="abk-modal-footer">
                <button type="button" class="abk-m-cancel" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="abk-btn abk-btn-primary" style="padding:9px 22px;">
                    <i class="fas fa-play" style="font-size:.62rem;"></i> Run Backup
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- DELETE CONFIRM MODAL                        --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="deleteModal" class="abk-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeDeleteModal()">
    <div class="abk-modal">
        <div class="abk-modal-header">
            <div style="display:flex;align-items:flex-start;gap:14px;">
                <div class="abk-del-icon"><i class="fas fa-trash"></i></div>
                <div>
                    <div class="abk-modal-title">Delete Backup</div>
                    <div class="abk-modal-sub">This action cannot be undone.</div>
                </div>
            </div>
        </div>
        <div class="abk-modal-body">
            <p class="abk-del-body">
                Are you sure you want to delete
                <strong id="deleteBackupName" style="color:#fffbf0;"></strong>?
                The backup file will be permanently removed from storage.
            </p>
        </div>
        <div class="abk-modal-footer">
            <button class="abk-m-cancel" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="abk-m-delete">
                    <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- TEST SYSTEM MODAL                           --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="testModal" class="abk-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeTestModal()">
    <div class="abk-modal" style="max-width:500px;">
        <div class="abk-modal-header">
            <div class="abk-modal-title">System Diagnostics</div>
            <div class="abk-modal-sub">Checking backup system health</div>
        </div>
        <div class="abk-modal-body" id="testModalBody">
            <div style="display:flex;align-items:center;gap:12px;padding:20px 0;justify-content:center;">
                <div class="abk-spin" style="width:24px;height:24px;border-width:3px;"></div>
                <span style="font-size:0.78rem;color:rgba(255,251,240,0.5);">Running diagnostics…</span>
            </div>
        </div>
        <div class="abk-modal-footer">
            <button class="abk-m-cancel" onclick="closeTestModal()">Close</button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- ERROR MODAL                                 --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="errorModal" class="abk-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeErrorModal()">
    <div class="abk-modal">
        <div class="abk-modal-header">
            <div class="abk-modal-title" style="color:#f87171;">Backup Error</div>
            <div class="abk-modal-sub">Something went wrong during this backup</div>
        </div>
        <div class="abk-modal-body">
            <div id="errorMessage" style="font-size:0.78rem;color:rgba(255,251,240,0.65);
                 background:rgba(248,113,113,0.06);border:1px solid rgba(248,113,113,0.15);
                 border-radius:10px;padding:14px 16px;line-height:1.7;word-break:break-all;">
            </div>
        </div>
        <div class="abk-modal-footer">
            <button class="abk-m-cancel" onclick="closeErrorModal()">Close</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
/* ── Modal helpers ─────────────────────────────────────────────── */
function openCreateModal()  { document.getElementById('createModal').style.display = 'flex'; }
function closeCreateModal() { document.getElementById('createModal').style.display = 'none'; }

function openDeleteModal(id, name) {
    document.getElementById('deleteBackupName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/backups/${id}`;
    document.getElementById('deleteModal').style.display = 'flex';
}
function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; }

function showError(msg) {
    document.getElementById('errorMessage').textContent = msg;
    document.getElementById('errorModal').style.display = 'flex';
}
function closeErrorModal() { document.getElementById('errorModal').style.display = 'none'; }

/* ── Test system ───────────────────────────────────────────────── */
async function openTestModal() {
    document.getElementById('testModal').style.display = 'flex';
    document.getElementById('testModalBody').innerHTML = `
        <div style="display:flex;align-items:center;gap:12px;padding:20px 0;justify-content:center;">
            <div class="abk-spin" style="width:24px;height:24px;border-width:3px;"></div>
            <span style="font-size:0.78rem;color:rgba(255,251,240,0.5);">Running diagnostics…</span>
        </div>`;

    try {
        const res  = await fetch('{{ route('admin.backups.test') }}', {
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const data = await res.json();
        renderTestResults(data);
    } catch (e) {
        document.getElementById('testModalBody').innerHTML =
            `<div style="color:#f87171;font-size:0.78rem;padding:12px 0;">Failed to run diagnostics: ${e.message}</div>`;
    }
}
function closeTestModal() { document.getElementById('testModal').style.display = 'none'; }

function renderTestResults(data) {
    const status = data.overall_status === 'ready';
    const statusColor = status ? '#34d399' : '#f87171';

    const rows = [
        { key: 'Overall',          val: data.overall_status,                                                  cls: status ? 'ok' : 'err' },
        { key: 'DB Connection',    val: data.tests?.database_connection?.status ?? '—',                       cls: data.tests?.database_connection?.status === 'success' ? 'ok' : 'err' },
        { key: 'Backup Directory', val: data.tests?.backup_directory?.writable ? 'Writable' : 'Not writable', cls: data.tests?.backup_directory?.writable ? 'ok' : 'err' },
        { key: 'Free Space',       val: data.tests?.backup_directory?.free_space ?? '—',                      cls: 'ok' },
        { key: 'mysqldump',        val: data.tests?.mysqldump?.status ?? '—',                                 cls: data.tests?.mysqldump?.status === 'available' ? 'ok' : 'warn' },
        { key: 'ZIP Extension',    val: data.tests?.php_extensions?.zip ?? '—',                              cls: data.tests?.php_extensions?.zip === 'installed' ? 'ok' : 'err' },
        { key: 'PDO Extension',    val: data.tests?.php_extensions?.pdo ?? '—',                              cls: data.tests?.php_extensions?.pdo === 'installed' ? 'ok' : 'err' },
        { key: 'Queue Driver',     val: data.tests?.queue_configuration?.driver ?? '—',                      cls: 'ok' },
    ];

    document.getElementById('testModalBody').innerHTML = `
        <div class="abk-test-panel" style="margin-bottom:0;">
            ${rows.map(r => `
            <div class="abk-test-row">
                <span class="abk-test-key">${r.key}</span>
                <span class="abk-test-val ${r.cls}">${r.val}</span>
            </div>`).join('')}
        </div>
        <div style="margin-top:12px;padding:10px 14px;border-radius:9px;font-size:0.72rem;
             background:${status ? 'rgba(52,211,153,0.06)' : 'rgba(248,113,113,0.06)'};
             border:1px solid ${status ? 'rgba(52,211,153,0.2)' : 'rgba(248,113,113,0.2)'};
             color:${statusColor};">
            ${data.message ?? ''}
        </div>`;
}

/* ── Progress polling ──────────────────────────────────────────── */
let pollingInterval = null;

@if(($stats['processing'] ?? 0) > 0)
startPolling();
@endif

function startPolling() {
    if (pollingInterval) return;
    pollingInterval = setInterval(pollProgress, 2500);
}

function stopPolling() {
    clearInterval(pollingInterval);
    pollingInterval = null;
}

async function pollProgress() {
    try {
        // Poll the statistics endpoint
        const res  = await fetch('{{ route('admin.backups.statistics') }}', {
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const json = await res.json();
        if (!json.success) return;

        const stats = json.data;

        // If nothing processing, reload page to show final state
        if ((stats.processing ?? 0) === 0) {
            stopPolling();
            window.location.reload();
        }
    } catch (e) { /* silent */ }
}

/* ── Keyboard escape ───────────────────────────────────────────── */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeDeleteModal();
        closeTestModal();
        closeErrorModal();
    }
});
</script>
@endpush
</x-app-layout>