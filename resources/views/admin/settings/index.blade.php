<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Mobile improvements for modals */
    @media(max-width: 640px) {
        .schedule-grid {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
        }
    }
</style>
@endpush
@include('admin.settings.partials._styles')

<div class="st-wrap">

    {{-- Page Header --}}
    <div class="st-page-header">
        <div>
            <h1 class="st-page-title">Settings</h1>
            <p class="st-page-sub">Manage election control and system backups</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="st-toast st-toast-success"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-circle-check" style="flex-shrink:0;"></i>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="st-toast st-toast-error"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i>
        {{ session('error') }}
    </div>
    @endif

    {{-- Tab Bar --}}
    <div class="st-tab-bar">
        <button class="st-tab {{ $activeTab === 'election' ? 'active' : '' }}"
                onclick="switchTab('election')">
            <i class="fas fa-tower-broadcast"></i>
            Election
            @if($status === 'ongoing')
                <span class="st-tab-dot"></span>
            @endif
        </button>
        <button class="st-tab {{ $activeTab === 'backups' ? 'active' : '' }}"
                onclick="switchTab('backups')">
            <i class="fas fa-database"></i>
            Backups
            @if(($stats['processing'] ?? 0) > 0)
                <span class="st-tab-dot" style="background:#60a5fa;box-shadow:0 0 6px rgba(96,165,250,0.7);"></span>
            @elseif(($stats['failed'] ?? 0) > 0)
                <span class="st-tab-dot" style="background:#f87171;box-shadow:0 0 6px rgba(248,113,113,0.7);animation:none;"></span>
            @endif
        </button>
    </div>

    {{-- ══════════════════════════════════════
         ELECTION TAB
    ══════════════════════════════════════ --}}
    <div id="tab-election" class="st-panel {{ $activeTab === 'election' ? 'active' : '' }}">

        {{-- Status Control Card --}}
        <div class="ec-card">
            <div class="ec-header">
                <div class="ec-title">Election Status</div>
                <div class="ec-sub">Controls what voters and the public see on the welcome page.</div>
            </div>
            <div class="ec-body">

                <div class="status-display {{ $status }}">
                    <div class="status-dot {{ $status }}"></div>
                    <div>
                        <div class="status-label {{ $status }}">
                            @if($status === 'upcoming') Election Soon
                            @elseif($status === 'ongoing') Election is LIVE
                            @else Election Ended
                            @endif
                        </div>
                        <div class="status-hint">Currently active status — visible to all users.</div>
                    </div>
                </div>

                <div class="status-section-title">Set New Status</div>
                <div class="status-btns">
                    <button type="button" onclick="openStatusConfirmModal('upcoming', 'Upcoming', 'Election Soon')" class="status-btn btn-upcoming {{ $status === 'upcoming' ? 'active' : '' }}">
                        <i class="fas fa-hourglass-start"></i>
                        <span>Upcoming</span>
                        <span style="font-size:0.6rem;opacity:0.65;font-weight:400;">Election Soon</span>
                    </button>

                    <button type="button" onclick="openStatusConfirmModal('ongoing', 'Ongoing', 'Election Live')" class="status-btn btn-ongoing {{ $status === 'ongoing' ? 'active' : '' }}">
                        <i class="fas fa-circle-dot"></i>
                        <span>Ongoing</span>
                        <span style="font-size:0.6rem;opacity:0.65;font-weight:400;">Election Live</span>
                    </button>

                    <button type="button" onclick="openStatusConfirmModal('ended', 'Ended', 'Election Done')" class="status-btn btn-ended {{ $status === 'ended' ? 'active' : '' }}">
                        <i class="fas fa-flag-checkered"></i>
                        <span>Ended</span>
                        <span style="font-size:0.6rem;opacity:0.65;font-weight:400;">Election Done</span>
                    </button>
                </div>

                @if($status === 'ongoing')
                <div class="warning-box">
                    <i class="fas fa-triangle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
                    <span>
                        The election is currently <strong>LIVE</strong>. Voters can cast ballots right now.
                        Only mark as <strong>Ended</strong> when voting is officially closed.
                    </span>
                </div>
                @endif

            </div>
        </div>

        {{-- Election Name Card --}}
        <div class="ec-card">
            <div class="ec-header">
                <div class="ec-title">Election Name</div>
                <div class="ec-sub">Displayed on the public welcome page and voter dashboard.</div>
            </div>
            <div class="ec-body">
                <form method="POST" action="{{ route('admin.settings.election.name') }}">
                    @csrf
                    <div class="name-row">
                        <div class="name-input-wrap">
                            <label class="field-label">Election Name</label>
                            <input type="text"
                                   name="election_name"
                                   class="field-input"
                                   value="{{ old('election_name', $electionName) }}"
                                   placeholder="e.g. Student Council Election 2026"
                                   maxlength="100">
                        </div>
                        <button type="submit" class="save-btn">
                            <i class="fas fa-floppy-disk"></i> Save
                        </button>
                    </div>
                    @error('election_name')
                        <div style="font-size:0.68rem;color:#f87171;margin-top:6px;">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
        {{-- Reset Votes Card --}}
        <div class="ec-card" style="border-color:rgba(248,113,113,0.25);">
            <div class="ec-header" style="border-bottom-color:rgba(248,113,113,0.1);">
                <div class="ec-title" style="color:#f87171;">Danger Zone</div>
                <div class="ec-sub">Irreversible actions — proceed with extreme caution.</div>
            </div>
            <div class="ec-body">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                    <div style="flex:1;min-width:200px;">
                        <div style="font-size:0.82rem;font-weight:700;color:#fffbf0;margin-bottom:4px;">
                            Reset All Votes
                        </div>
                        <div style="font-size:0.7rem;color:rgba(255,251,240,0.4);line-height:1.6;">
                            Permanently deletes every ballot cast. This cannot be undone.
                            Use only to restart the election from a clean slate.
                        </div>
                    </div>
                    <button type="button"
                            onclick="openResetVotesModal()"
                            class="abk-btn"
                            style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.25);
                                color:rgba(248,113,113,0.8);white-space:nowrap;flex-shrink:0;">
                        <i class="fas fa-trash-can" style="font-size:.62rem;"></i> Reset All Votes
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         BACKUPS TAB
    ══════════════════════════════════════ --}}
    <div id="tab-backups" class="st-panel {{ $activeTab === 'backups' ? 'active' : '' }}">

        {{-- Toolbar --}}
        <div style="display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-bottom:20px;">
            <button onclick="openTestModal()" class="abk-btn abk-btn-sky">
                <i class="fas fa-flask" style="font-size:.62rem;"></i> Test System
            </button>
            <button onclick="openCreateModal()" class="abk-btn abk-btn-primary">
                <i class="fas fa-plus" style="font-size:.62rem;"></i> Create Backup
            </button>
        </div>

        {{-- Processing Banner --}}
        @if(($stats['processing'] ?? 0) > 0)
        <div class="abk-processing-banner" id="processingBanner">
            <div class="abk-spin"></div>
            <div style="flex:1;">
                <div style="font-size:0.75rem;font-weight:700;color:#60a5fa;">
                    {{ $stats['processing'] }} backup{{ $stats['processing'] > 1 ? 's' : '' }} in progress…
                </div>
                <div class="abk-prog-track">
                    <div class="abk-prog-fill" id="globalProgress" style="width:30%"></div>
                </div>
            </div>
            <span style="font-size:0.65rem;color:rgba(96,165,250,0.5);">Auto-refreshing</span>
        </div>
        @endif

        {{-- Stat Strip --}}
        <div class="abk-stat-strip">
            <div class="abk-stat-card" style="animation-delay:.06s;">
                <div class="abk-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                    <i class="fas fa-database" style="color:#f9b40f;"></i>
                </div>
                <div>
                    <div class="abk-stat-num">{{ $stats['total'] ?? 0 }}</div>
                    <div class="abk-stat-lbl">Total</div>
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

        {{-- Backups Table --}}
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
                            <td>
                                <div style="font-weight:600;color:#fffbf0;font-size:0.8rem;">{{ $backup->backup_name }}</div>
                                @if($backup->created_by && $backup->creator)
                                <div style="font-size:0.62rem;color:rgba(249,180,15,0.4);margin-top:2px;">
                                    by {{ $backup->creator->full_name ?? $backup->creator->name }}
                                </div>
                                @endif
                            </td>
                            <td>
                                <span class="abk-type-badge {{ $backup->backup_type === 'full' ? 'full' : '' }}">
                                    {{ ucfirst($backup->backup_type) }}
                                </span>
                            </td>
                            <td>
                                <span class="abk-status-badge {{ $backup->status }} backup-status">
                                    @if($backup->status === 'processing')   <span class="abk-spin-sm"></span>
                                    @elseif($backup->status === 'completed') <i class="fas fa-check" style="font-size:.5rem;"></i>
                                    @elseif($backup->status === 'failed')    <i class="fas fa-xmark" style="font-size:.5rem;"></i>
                                    @else                                    <i class="fas fa-clock" style="font-size:.5rem;"></i>
                                    @endif
                                    {{ ucfirst($backup->status) }}
                                </span>
                            </td>
                            <td>
                                @if($backup->status === 'processing')
                                <div>
                                    <div class="abk-mini-track">
                                        <div class="abk-mini-fill backup-progress-bar" style="width:{{ $backup->progress ?? 0 }}%"></div>
                                    </div>
                                    <div style="font-size:0.6rem;color:rgba(96,165,250,0.6);margin-top:3px;" class="backup-progress-text">
                                        {{ $backup->progress ?? 0 }}%
                                    </div>
                                </div>
                                @else
                                <span style="color:rgba(255,251,240,0.2);font-size:0.72rem;">—</span>
                                @endif
                            </td>
                            <td style="color:rgba(255,251,240,0.7);font-size:0.75rem;">{{ $backup->formatted_size ?? '—' }}</td>
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
                            <td style="font-size:0.72rem;color:rgba(255,251,240,0.5);">{{ $backup->created_at->diffForHumans() }}</td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                                    @if($backup->status === 'completed')
                                    <a href="{{ route('admin.settings.backups.download', $backup) }}"
                                       class="abk-action-btn sky" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @endif
                                    @if($backup->status === 'failed' && $backup->error_message)
                                    <button type="button" class="abk-action-btn amber" title="View Error"
                                            onclick="showError('{{ addslashes($backup->error_message) }}')">
                                        <i class="fas fa-circle-exclamation"></i>
                                    </button>
                                    @endif
                                    <button type="button" class="abk-action-btn danger" title="Delete"
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
            <div class="abk-pagination">{{ $backups->withQueryString()->links() }}</div>
            @endif
        </div>

        {{-- Cleanup --}}
        @if(($stats['total'] ?? 0) > 0)
        <div style="margin-top:14px;display:flex;justify-content:flex-end;">
            <form method="POST" action="{{ route('admin.settings.backups.cleanup') }}">
                @csrf
                <button type="submit" class="abk-btn abk-btn-ghost"
                        onclick="return confirm('Clean up all expired backups?')">
                    <i class="fas fa-broom" style="font-size:.62rem;"></i> Clean Expired
                </button>
            </form>
        </div>
        @endif

    </div>{{-- /tab-backups --}}

</div>{{-- /st-wrap --}}

{{-- ═══════════════════════════════════════════ --}}
{{-- CREATE BACKUP MODAL                         --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="createModal" class="st-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeCreateModal()">
    <div class="st-modal">
        <div class="st-modal-header">
            <div class="st-modal-title">Create New Backup</div>
            <div class="st-modal-sub">Configure and run a new database backup</div>
        </div>
        <form method="POST" action="{{ route('admin.settings.backups.store') }}" style="display:flex;flex-direction:column;min-height:0;">
            @csrf
            <div class="st-modal-body">
                <label class="abk-field-label">Backup Type</label>
                <select name="backup_type" class="abk-select" style="margin-bottom:16px;">
                    <option value="database">Database only</option>
                    <option value="full">Full backup (database + files)</option>
                </select>
                <label class="abk-field-label">Retention Period (days)</label>
                <input type="number" name="retention_days" value="30" min="1" max="365" class="abk-input" style="margin-bottom:6px;">
                <div class="abk-hint">Backup will auto-delete after this many days</div>
                <div class="abk-checkbox-row" style="margin-bottom:0;">
                    <input type="checkbox" name="async" value="1" id="asyncCheck">
                    <label for="asyncCheck" class="abk-checkbox-label">
                        Run in background <span style="color:rgba(249,180,15,0.4);">(requires queue:work)</span>
                    </label>
                </div>
            </div>
            <div class="st-modal-footer">
                <button type="button" class="st-m-cancel" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="abk-btn abk-btn-primary" style="padding:9px 22px;white-space:nowrap;">
                    <i class="fas fa-play" style="font-size:.62rem;"></i> Run Backup
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- STATUS CONFIRM MODAL                        --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="statusModal" class="st-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeStatusConfirmModal()">
    <div class="st-modal">
        <div class="st-modal-header">
            <div style="display:flex;align-items:flex-start;gap:12px;">
                <div class="abk-del-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);"><i class="fas fa-tower-broadcast" style="color:#f9b40f;"></i></div>
                <div style="min-width:0;flex:1;">
                    <div class="st-modal-title">Change Election Status</div>
                    <div class="st-modal-sub">This will affect what voters and the public see.</div>
                </div>
            </div>
        </div>
        <div class="st-modal-body">
            <p class="abk-del-body" style="margin-bottom:16px;margin-top:0;">
                Are you sure you want to change the election status to
                <strong id="statusModalNewStatus" style="color:#fffbf0;"></strong>?
            </p>
            <div id="statusWarningBox" style="display:none;padding:12px 14px;border-radius:9px;font-size:0.72rem;background:rgba(248,113,113,0.06);border:1px solid rgba(248,113,113,0.2);color:rgba(248,113,113,0.8);line-height:1.6;">
            </div>
            <div id="statusModalScheduleCard" style="display:none;margin-top:16px;">
                <div style="border-radius:14px;padding:16px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:12px;flex-wrap:wrap;">
                        <div style="min-width:0;flex:1;">
                            <div style="font-size:0.88rem;font-weight:700;color:#fffbf0;">Election Schedule</div>
                            <div style="font-size:0.7rem;color:rgba(255,251,240,0.55);margin-top:2px;">Review the current countdown target.</div>
                        </div>
                        <div id="statusModalScheduleBadge" style="font-size:0.62rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;padding:6px 11px;border-radius:999px;background:rgba(249,180,15,0.1);color:#f9b40f;border:1px solid rgba(249,180,15,0.2);white-space:nowrap;flex-shrink:0;">
                            Upcoming
                        </div>
                    </div>
                    <div id="statusModalScheduleContent" style="font-size:0.75rem;color:rgba(255,251,240,0.7);line-height:1.6;"></div>
                </div>
            </div>
            <div id="statusModalScheduleFields" style="display:none;margin-top:16px;"></div>
        </div>
        <div class="st-modal-footer">
            <button class="st-m-cancel" onclick="closeStatusConfirmModal()">Cancel</button>
            <form id="statusForm" method="POST" action="{{ route('admin.settings.election.status') }}" style="margin:0;">
                @csrf
                <input type="hidden" id="statusInput" name="status" value="">
                <button type="button" class="st-m-delete" style="background:linear-gradient(135deg,#f9b40f,#fcd558);color:#380041;" onclick="submitStatusForm()">
                    <i class="fas fa-tower-broadcast" style="font-size:.62rem;margin-right:4px;"></i> Confirm
                </button>
            </form>
        </div>
    </div>
</div>

{{-- DELETE CONFIRM MODAL                        --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="deleteModal" class="st-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeDeleteModal()">
    <div class="st-modal">
        <div class="st-modal-header">
            <div style="display:flex;align-items:flex-start;gap:12px;">
                <div class="abk-del-icon"><i class="fas fa-trash"></i></div>
                <div style="min-width:0;flex:1;">
                    <div class="st-modal-title">Delete Backup</div>
                    <div class="st-modal-sub">This action cannot be undone.</div>
                </div>
            </div>
        </div>
        <div class="st-modal-body">
            <p class="abk-del-body" style="margin-top:0;">
                Are you sure you want to delete
                <strong id="deleteBackupName" style="color:#fffbf0;"></strong>?
                The backup file will be permanently removed from storage.
            </p>
        </div>
        <div class="st-modal-footer">
            <button class="st-m-cancel" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="margin:0;flex:1;min-width:140px;">
                @csrf @method('DELETE')
                <button type="submit" class="st-m-delete" style="width:100%;">
                    <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- TEST SYSTEM MODAL                           --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="testModal" class="st-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeTestModal()">
    <div class="st-modal" style="max-width:540px;">
        <div class="st-modal-header">
            <div class="st-modal-title">System Diagnostics</div>
            <div class="st-modal-sub">Checking backup system health</div>
        </div>
        <div class="st-modal-body" id="testModalBody">
            <div style="display:flex;align-items:center;gap:12px;padding:20px 0;justify-content:center;">
                <div class="abk-spin" style="width:24px;height:24px;border-width:3px;"></div>
                <span style="font-size:0.78rem;color:rgba(255,251,240,0.5);">Running diagnostics…</span>
            </div>
        </div>
        <div class="st-modal-footer">
            <button class="st-m-cancel" onclick="closeTestModal()">Close</button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════ --}}
{{-- ERROR MODAL                                 --}}
{{-- ═══════════════════════════════════════════ --}}
<div id="errorModal" class="st-modal-backdrop" style="display:none;"
     onclick="if(event.target===this) closeErrorModal()">
    <div class="st-modal">
        <div class="st-modal-header">
            <div class="st-modal-title" style="color:#f87171;">Backup Error</div>
            <div class="st-modal-sub">Something went wrong during this backup</div>
        </div>
        <div class="st-modal-body">
            <div id="errorMessage" style="font-size:0.78rem;color:rgba(255,251,240,0.65);
                 background:rgba(248,113,113,0.06);border:1px solid rgba(248,113,113,0.15);
                 border-radius:10px;padding:14px 16px;line-height:1.7;word-break:break-word;margin:0;">
            </div>
        </div>
        <div class="st-modal-footer">
            <button class="st-m-cancel" onclick="closeErrorModal()">Close</button>
        </div>
    </div>
</div>

@push('scripts')
@include('admin.settings.partials._scripts')
@endpush
</x-app-layout>