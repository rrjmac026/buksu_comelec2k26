<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes shimmerBar { 0%,100% { background-position:0% 0%; } 50% { background-position:100% 0%; } }

.acol-page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:28px; flex-wrap:wrap; animation:fadeUp .3s ease both; }
.acol-page-header-left { display:flex; align-items:center; gap:14px; }
.acol-back-btn { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:10px; flex-shrink:0; border:1px solid rgba(249,180,15,0.2); background:transparent; font-size:0.72rem; color:rgba(249,180,15,0.6); text-decoration:none; transition:all .18s; }
.acol-back-btn:hover { border-color:rgba(249,180,15,0.4); color:#f9b40f; background:rgba(249,180,15,0.06); }
.acol-page-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:#fffbf0; margin:0; }
.acol-page-sub { font-size:0.72rem; color:rgba(255,251,240,0.4); margin-top:3px; }
.acol-page-sub strong { color:rgba(249,180,15,0.7); }

.acol-toast { display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:600; background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2); color:#34d399; animation:fadeUp .35s ease both; }

.acol-grid { display:grid; grid-template-columns:260px 1fr; gap:16px; align-items:start; }
@media (max-width:860px) { .acol-grid { grid-template-columns:1fr; } }

.acol-profile-card {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow:hidden; padding:28px 24px 24px; text-align:center; margin-bottom:16px; animation:fadeUp .4s ease both;
}
.acol-profile-card::before { content:''; display:block; height:2px; margin:-28px -24px 24px; background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent); background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite; }
.acol-profile-avatar { width:80px; height:80px; border-radius:20px; margin:0 auto 14px; background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.25); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:#f9b40f; }
.acol-profile-name { font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:900; color:#fffbf0; margin-bottom:6px; }
.acol-profile-acronym { display:inline-flex; padding:3px 12px; border-radius:7px; font-family:monospace; font-size:0.78rem; font-weight:700; background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.18); color:rgba(249,180,15,0.8); margin-bottom:20px; }
.acol-profile-divider { height:1px; background:rgba(249,180,15,0.1); margin:0 0 16px; }
.acol-profile-btn { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:9px 16px; border-radius:10px; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700; cursor:pointer; transition:all .18s; text-decoration:none; border:none; margin-bottom:8px; }
.acol-profile-btn:last-child { margin-bottom:0; }
.acol-profile-btn-sky    { background:transparent; border:1px solid rgba(96,165,250,0.25); color:rgba(96,165,250,0.7); }
.acol-profile-btn-sky:hover { background:rgba(96,165,250,0.08); border-color:rgba(96,165,250,0.5); color:#93c5fd; }
.acol-profile-btn-danger { background:transparent; border:1px solid rgba(248,113,113,0.25); color:rgba(248,113,113,0.7); }
.acol-profile-btn-danger:hover { background:rgba(248,113,113,0.08); border-color:rgba(248,113,113,0.5); color:#f87171; }

.acol-stats-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px; }
.acol-stat-tile { background:rgba(26,0,32,0.88); border:1px solid rgba(249,180,15,0.15); border-radius:16px; padding:20px; animation:fadeUp .42s ease both; }
.acol-stat-tile-label { font-size:0.6rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(249,180,15,0.5); margin-bottom:8px; }
.acol-stat-tile-num { font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:900; line-height:1; background:linear-gradient(135deg,#f9b40f,#fcd558); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.acol-stat-tile-icon { float:right; width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1rem; }

.acol-table-card { background:rgba(26,0,32,0.88); backdrop-filter:blur(24px); border:1px solid rgba(249,180,15,0.18); border-radius:18px; box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06); overflow:hidden; animation:fadeUp .46s ease both; margin-bottom:16px; }
.acol-table-card:last-child { margin-bottom:0; }
.acol-table-card::before { content:''; display:block; height:2px; background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent); background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite; }
.acol-table-head { padding:18px 24px 14px; border-bottom:1px solid rgba(249,180,15,0.08); background:linear-gradient(to right,rgba(56,0,65,0.4),transparent); display:flex; align-items:center; gap:10px; }
.acol-table-head-title { font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:800; color:#fffbf0; }
.acol-table { width:100%; border-collapse:collapse; font-size:0.82rem; }
.acol-thead-row { background:linear-gradient(to right,rgba(56,0,65,0.4),transparent); border-bottom:1px solid rgba(249,180,15,0.1); }
.acol-thead-row th { padding:12px 24px; text-align:left; font-size:0.58rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(249,180,15,0.5); }
.acol-tbody-row { border-bottom:1px solid rgba(249,180,15,0.07); transition:background .18s; }
.acol-tbody-row:last-child { border-bottom:none; }
.acol-tbody-row:hover { background:rgba(249,180,15,0.04); }
.acol-tbody-row td { padding:13px 24px; color:rgba(255,251,240,0.85); vertical-align:middle; }

.acol-status-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:99px; font-size:0.65rem; font-weight:700; }
.acol-status-badge.active   { background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#34d399; }
.acol-status-badge.inactive { background:rgba(248,113,113,0.1); border:1px solid rgba(248,113,113,0.2); color:#f87171; }
.acol-pos-badge { display:inline-flex; padding:3px 10px; border-radius:99px; font-size:0.62rem; font-weight:700; background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.18); color:rgba(249,180,15,0.75); }
.acol-votes-badge { display:inline-flex; align-items:center; justify-content:center; padding:4px 14px; border-radius:99px; font-size:0.7rem; font-weight:800; background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#34d399; }

.acol-empty { padding:40px 24px; text-align:center; }
.acol-empty-icon  { font-size:2rem; color:rgba(249,180,15,0.1); margin-bottom:12px; display:block; }
.acol-empty-title { font-family:'Playfair Display',serif; font-size:0.9rem; font-weight:800; color:rgba(255,251,240,0.3); }

.acol-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 20px; border-radius:10px; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700; cursor:pointer; transition:all .18s; text-decoration:none; border:none; }
.acol-btn-ghost { background:transparent; border:1px solid rgba(249,180,15,0.2); color:rgba(249,180,15,0.6); }
.acol-btn-ghost:hover { background:rgba(249,180,15,0.06); color:#f9b40f; border-color:rgba(249,180,15,0.4); }

.acol-modal-wrap { padding:28px; background:rgba(26,0,32,0.98); }
.acol-modal-icon { width:50px; height:50px; border-radius:14px; flex-shrink:0; background:rgba(248,113,113,0.1); border:1px solid rgba(248,113,113,0.2); display:flex; align-items:center; justify-content:center; font-size:1.1rem; color:#f87171; }
.acol-modal-title { font-family:'Playfair Display',serif; font-size:1.05rem; font-weight:900; color:#fffbf0; margin-bottom:3px; }
.acol-modal-sub   { font-size:0.7rem; color:rgba(255,251,240,0.4); }
.acol-modal-body  { font-size:0.75rem; color:rgba(255,251,240,0.5); line-height:1.7; margin:16px 0 22px; }
.acol-modal-btns  { display:flex; gap:10px; justify-content:flex-end; }
.acol-m-cancel { padding:9px 18px; border-radius:9px; cursor:pointer; background:transparent; border:1px solid rgba(249,180,15,0.18); color:rgba(249,180,15,0.55); font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700; transition:all .18s; }
.acol-m-cancel:hover { background:rgba(249,180,15,0.06); color:#f9b40f; }
.acol-m-delete { padding:9px 20px; border-radius:9px; cursor:pointer; background:linear-gradient(135deg,#ef4444,#f87171); border:none; color:#fff; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700; box-shadow:0 3px 10px rgba(239,68,68,0.3); transition:all .18s; }
.acol-m-delete:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(239,68,68,0.45); }
</style>
@endpush

@if(session('success'))
<div class="acol-toast" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,4000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <i class="fas fa-circle-check" style="flex-shrink:0;"></i> {{ session('success') }}
</div>
@endif

<div class="acol-page-header">
    <div class="acol-page-header-left">
        <a href="{{ route('admin.colleges.index') }}" class="acol-back-btn"><i class="fas fa-arrow-left"></i></a>
        <div>
            <div class="acol-page-title">College Profile</div>
            <div class="acol-page-sub">Viewing details for <strong>{{ $college->name }}</strong></div>
        </div>
    </div>
    <a href="{{ route('admin.colleges.edit', $college) }}" class="acol-btn acol-btn-ghost">
        <i class="fas fa-pen" style="font-size:.65rem;"></i> Edit
    </a>
</div>

<div class="acol-grid">

    {{-- Left --}}
    <div>
        <div class="acol-profile-card">
            <div class="acol-profile-avatar">{{ strtoupper(substr($college->acronym, 0, 2)) }}</div>
            <div class="acol-profile-name">{{ $college->name }}</div>
            <div style="margin-bottom:20px;"><span class="acol-profile-acronym">{{ $college->acronym }}</span></div>
            <div class="acol-profile-divider"></div>
            <a href="{{ route('admin.colleges.edit', $college) }}" class="acol-profile-btn acol-profile-btn-sky">
                <i class="fas fa-pen" style="font-size:.65rem;"></i> Edit College
            </a>
            <button type="button" class="acol-profile-btn acol-profile-btn-danger" @click="$dispatch('open-modal', 'delete-college')">
                <i class="fas fa-trash" style="font-size:.65rem;"></i> Delete College
            </button>
        </div>
    </div>

    {{-- Right --}}
    <div>
        <div class="acol-stats-row">
            <div class="acol-stat-tile">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div class="acol-stat-tile-label">Total Voters</div>
                        <div class="acol-stat-tile-num">{{ $college->voters->count() }}</div>
                    </div>
                    <div class="acol-stat-tile-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                        <i class="fas fa-users" style="color:#34d399;"></i>
                    </div>
                </div>
            </div>
            <div class="acol-stat-tile">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div class="acol-stat-tile-label">Total Candidates</div>
                        <div class="acol-stat-tile-num" style="background:linear-gradient(135deg,#60a5fa,#93c5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $college->candidates->count() }}</div>
                    </div>
                    <div class="acol-stat-tile-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                        <i class="fas fa-user-tie" style="color:#60a5fa;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Voters table --}}
        <div class="acol-table-card">
            <div class="acol-table-head">
                <i class="fas fa-users" style="color:rgba(249,180,15,0.6);font-size:0.75rem;"></i>
                <span class="acol-table-head-title">
                    Recent Voters
                    <span style="font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:400;color:rgba(255,251,240,0.35);margin-left:6px;">({{ $college->voters->count() }})</span>
                </span>
            </div>
            @if($college->voters->count() > 0)
            <div style="overflow-x:auto;">
                <table class="acol-table">
                    <thead><tr class="acol-thead-row">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr></thead>
                    <tbody>
                        @foreach($college->voters->take(10) as $voter)
                        <tr class="acol-tbody-row">
                            <td style="font-weight:500;color:#fffbf0;">{{ $voter->name }}</td>
                            <td style="font-size:0.72rem;color:rgba(255,251,240,0.55);">{{ $voter->email }}</td>
                            <td>
                                @if($voter->status === 'active')
                                    <span class="acol-status-badge active"><span style="width:5px;height:5px;border-radius:50%;background:#34d399;display:inline-block;"></span> Active</span>
                                @else
                                    <span class="acol-status-badge inactive"><span style="width:5px;height:5px;border-radius:50%;background:#f87171;display:inline-block;"></span> Inactive</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($college->voters->count() > 10)
            <div style="padding:10px 24px;border-top:1px solid rgba(249,180,15,0.08);font-size:0.68rem;color:rgba(249,180,15,0.5);text-align:center;">
                Showing 10 of {{ $college->voters->count() }} voters
            </div>
            @endif
            @else
            <div class="acol-empty">
                <i class="fas fa-users acol-empty-icon"></i>
                <div class="acol-empty-title">No voters from this college</div>
            </div>
            @endif
        </div>

        {{-- Candidates table --}}
        <div class="acol-table-card">
            <div class="acol-table-head">
                <i class="fas fa-user-tie" style="color:rgba(249,180,15,0.6);font-size:0.75rem;"></i>
                <span class="acol-table-head-title">
                    Candidates
                    <span style="font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:400;color:rgba(255,251,240,0.35);margin-left:6px;">({{ $college->candidates->count() }})</span>
                </span>
            </div>
            @if($college->candidates->count() > 0)
            <div style="overflow-x:auto;">
                <table class="acol-table">
                    <thead><tr class="acol-thead-row">
                        <th>Name</th>
                        <th>Position</th>
                        <th>Party List</th>
                    </tr></thead>
                    <tbody>
                        @foreach($college->candidates->take(10) as $candidate)
                        <tr class="acol-tbody-row">
                            <td style="font-weight:500;color:#fffbf0;">{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                            <td>
                                @if($candidate->position)
                                    <span class="acol-pos-badge">{{ $candidate->position->name }}</span>
                                @else
                                    <span style="color:rgba(255,251,240,0.25);font-size:0.75rem;">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.75rem;color:rgba(255,251,240,0.65);">{{ $candidate->partylist?->name ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($college->candidates->count() > 10)
            <div style="padding:10px 24px;border-top:1px solid rgba(249,180,15,0.08);font-size:0.68rem;color:rgba(249,180,15,0.5);text-align:center;">
                Showing 10 of {{ $college->candidates->count() }} candidates
            </div>
            @endif
            @else
            <div class="acol-empty">
                <i class="fas fa-user-tie acol-empty-icon"></i>
                <div class="acol-empty-title">No candidates from this college</div>
            </div>
            @endif
        </div>
    </div>
</div>

<x-modal name="delete-college" focusable>
    <div class="acol-modal-wrap">
        <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:4px;">
            <div class="acol-modal-icon"><i class="fas fa-building-slash"></i></div>
            <div>
                <div class="acol-modal-title">Delete College</div>
                <div class="acol-modal-sub">This action cannot be undone.</div>
            </div>
        </div>
        <p class="acol-modal-body">
            Are you sure you want to delete <strong style="color:#fffbf0;">{{ $college->name }}</strong>?
            This college cannot have associated voters or candidates.
        </p>
        <div class="acol-modal-btns">
            <button class="acol-m-cancel" @click="$dispatch('close-modal', 'delete-college')">Cancel</button>
            <form method="POST" action="{{ route('admin.colleges.destroy', $college) }}" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="acol-m-delete"><i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete</button>
            </form>
        </div>
    </div>
</x-modal>

</x-app-layout>