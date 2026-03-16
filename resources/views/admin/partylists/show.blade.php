<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes shimmerBar { 0%,100% { background-position:0% 0%; } 50% { background-position:100% 0%; } }

.apl-page-header {
    display:flex; align-items:flex-start; justify-content:space-between;
    gap:16px; margin-bottom:28px; flex-wrap:wrap;
    animation:fadeUp .3s ease both;
}
.apl-page-header-left { display:flex; align-items:center; gap:14px; }
.apl-back-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:34px; height:34px; border-radius:10px; flex-shrink:0;
    border:1px solid rgba(249,180,15,0.2); background:transparent;
    font-size:0.72rem; color:rgba(249,180,15,0.6); text-decoration:none; transition:all .18s;
}
.apl-back-btn:hover { border-color:rgba(249,180,15,0.4); color:#f9b40f; background:rgba(249,180,15,0.06); }
.apl-page-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:#fffbf0; margin:0; }
.apl-page-sub   { font-size:0.72rem; color:rgba(255,251,240,0.4); margin-top:3px; }
.apl-page-sub strong { color:rgba(249,180,15,0.7); }

.apl-toast {
    display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:10px; margin-bottom:16px;
    font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:600;
    background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2); color:#34d399;
    animation:fadeUp .35s ease both;
}

.apl-grid {
    display:grid; grid-template-columns:260px 1fr; gap:16px; align-items:start;
}
@media (max-width:860px) { .apl-grid { grid-template-columns:1fr; } }

/* ── Profile card ── */
.apl-profile-card {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow:hidden; padding:28px 24px 24px; text-align:center; margin-bottom:16px;
    animation:fadeUp .4s ease both;
}
.apl-profile-card::before {
    content:''; display:block; height:2px; margin:-28px -24px 24px;
    background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}
.apl-profile-avatar {
    width:80px; height:80px; border-radius:20px; margin:0 auto 16px;
    background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.25);
    display:flex; align-items:center; justify-content:center;
    font-size:1.8rem; color:#f9b40f;
}
.apl-profile-name { font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:900; color:#fffbf0; margin-bottom:8px; }
.apl-profile-desc { font-size:0.72rem; color:rgba(255,251,240,0.45); line-height:1.65; margin-bottom:20px; }
.apl-profile-divider { height:1px; background:rgba(249,180,15,0.1); margin:0 0 16px; }

.apl-profile-btn {
    display:flex; align-items:center; justify-content:center; gap:8px;
    width:100%; padding:9px 16px; border-radius:10px;
    font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700;
    cursor:pointer; transition:all .18s; text-decoration:none; border:none; margin-bottom:8px;
}
.apl-profile-btn:last-child { margin-bottom:0; }
.apl-profile-btn-sky    { background:transparent; border:1px solid rgba(96,165,250,0.25); color:rgba(96,165,250,0.7); }
.apl-profile-btn-sky:hover { background:rgba(96,165,250,0.08); border-color:rgba(96,165,250,0.5); color:#93c5fd; }
.apl-profile-btn-danger { background:transparent; border:1px solid rgba(248,113,113,0.25); color:rgba(248,113,113,0.7); }
.apl-profile-btn-danger:hover { background:rgba(248,113,113,0.08); border-color:rgba(248,113,113,0.5); color:#f87171; }

/* ── Stats ── */
.apl-stats-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px; }
.apl-stat-tile {
    background:rgba(26,0,32,0.88); border:1px solid rgba(249,180,15,0.15);
    border-radius:16px; padding:20px; animation:fadeUp .42s ease both;
}
.apl-stat-tile-label {
    font-size:0.6rem; font-weight:700; text-transform:uppercase;
    letter-spacing:0.1em; color:rgba(249,180,15,0.5); margin-bottom:8px;
}
.apl-stat-tile-num {
    font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:900; line-height:1;
    background:linear-gradient(135deg,#f9b40f,#fcd558);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.apl-stat-tile-icon {
    float:right; width:44px; height:44px; border-radius:12px;
    display:flex; align-items:center; justify-content:center; font-size:1rem;
}

/* ── Table card ── */
.apl-table-card {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow:hidden; animation:fadeUp .46s ease both;
}
.apl-table-card::before {
    content:''; display:block; height:2px;
    background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}
.apl-table-head {
    padding:18px 24px 14px; border-bottom:1px solid rgba(249,180,15,0.08);
    background:linear-gradient(to right,rgba(56,0,65,0.4),transparent);
    display:flex; align-items:center; gap:10px;
}
.apl-table-head-title { font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:800; color:#fffbf0; }

.apl-table { width:100%; border-collapse:collapse; font-size:0.82rem; }
.apl-thead-row {
    background:linear-gradient(to right,rgba(56,0,65,0.4),transparent);
    border-bottom:1px solid rgba(249,180,15,0.1);
}
.apl-thead-row th {
    padding:12px 24px; text-align:left;
    font-size:0.58rem; font-weight:700; text-transform:uppercase;
    letter-spacing:0.1em; color:rgba(249,180,15,0.5);
}
.apl-thead-row th:last-child { text-align:center; }
.apl-tbody-row { border-bottom:1px solid rgba(249,180,15,0.07); transition:background .18s; }
.apl-tbody-row:last-child { border-bottom:none; }
.apl-tbody-row:hover { background:rgba(249,180,15,0.04); }
.apl-tbody-row td { padding:13px 24px; color:rgba(255,251,240,0.85); vertical-align:middle; }
.apl-tbody-row td:last-child { text-align:center; }

.apl-cand-link {
    font-weight:600; color:#fffbf0; text-decoration:none; transition:color .18s;
}
.apl-cand-link:hover { color:#f9b40f; }
.apl-pos-badge {
    display:inline-flex; align-items:center; padding:3px 10px; border-radius:99px;
    font-size:0.62rem; font-weight:700;
    background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.18); color:rgba(249,180,15,0.75);
}
.apl-college-text { font-size:0.72rem; color:rgba(255,251,240,0.5); }
.apl-votes-badge {
    display:inline-flex; align-items:center; justify-content:center;
    padding:4px 14px; border-radius:99px; font-size:0.7rem; font-weight:800;
    background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2); color:#34d399;
}

.apl-empty { padding:44px 24px; text-align:center; }
.apl-empty-icon  { font-size:2rem; color:rgba(249,180,15,0.1); margin-bottom:12px; display:block; }
.apl-empty-title { font-family:'Playfair Display',serif; font-size:0.9rem; font-weight:800; color:rgba(255,251,240,0.3); }

.apl-btn {
    display:inline-flex; align-items:center; gap:7px; padding:9px 20px; border-radius:10px;
    font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700;
    cursor:pointer; transition:all .18s; text-decoration:none; border:none;
}
.apl-btn-ghost { background:transparent; border:1px solid rgba(249,180,15,0.2); color:rgba(249,180,15,0.6); }
.apl-btn-ghost:hover { background:rgba(249,180,15,0.06); color:#f9b40f; border-color:rgba(249,180,15,0.4); }

.apl-modal-wrap { padding:28px; background:rgba(26,0,32,0.98); }
.apl-modal-icon {
    width:50px; height:50px; border-radius:14px; flex-shrink:0;
    background:rgba(248,113,113,0.1); border:1px solid rgba(248,113,113,0.2);
    display:flex; align-items:center; justify-content:center;
    font-size:1.1rem; color:#f87171;
}
.apl-modal-title { font-family:'Playfair Display',serif; font-size:1.05rem; font-weight:900; color:#fffbf0; margin-bottom:3px; }
.apl-modal-sub   { font-size:0.7rem; color:rgba(255,251,240,0.4); }
.apl-modal-body  { font-size:0.75rem; color:rgba(255,251,240,0.5); line-height:1.7; margin:16px 0 22px; }
.apl-warning-box {
    padding:10px 14px; border-radius:9px; margin-bottom:16px;
    background:rgba(248,113,113,0.06); border:1px solid rgba(248,113,113,0.15);
    font-size:0.68rem; color:rgba(248,113,113,0.8); display:flex; align-items:flex-start; gap:8px;
}
.apl-modal-btns { display:flex; gap:10px; justify-content:flex-end; }
.apl-m-cancel {
    padding:9px 18px; border-radius:9px; cursor:pointer;
    background:transparent; border:1px solid rgba(249,180,15,0.18);
    color:rgba(249,180,15,0.55); font-family:'DM Sans',sans-serif;
    font-size:0.75rem; font-weight:700; transition:all .18s;
}
.apl-m-cancel:hover { background:rgba(249,180,15,0.06); color:#f9b40f; }
.apl-m-delete {
    padding:9px 20px; border-radius:9px; cursor:pointer;
    background:linear-gradient(135deg,#ef4444,#f87171); border:none;
    color:#fff; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700;
    box-shadow:0 3px 10px rgba(239,68,68,0.3); transition:all .18s;
}
.apl-m-delete:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(239,68,68,0.45); }
</style>
@endpush

@if(session('success'))
<div class="apl-toast"
     x-data="{ show: true }" x-show="show"
     x-init="setTimeout(() => show = false, 4000)"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <i class="fas fa-circle-check" style="flex-shrink:0;"></i> {{ session('success') }}
</div>
@endif

<div class="apl-page-header">
    <div class="apl-page-header-left">
        <a href="{{ route('admin.partylists.index') }}" class="apl-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="apl-page-title">Partylist Profile</div>
            <div class="apl-page-sub">Viewing details for <strong>{{ $partylist->name }}</strong></div>
        </div>
    </div>
    <a href="{{ route('admin.partylists.edit', $partylist) }}" class="apl-btn apl-btn-ghost">
        <i class="fas fa-pen" style="font-size:.65rem;"></i> Edit
    </a>
</div>

<div class="apl-grid">

    {{-- Left ── --}}
    <div>
        <div class="apl-profile-card">
            <div class="apl-profile-avatar">
                <i class="fas fa-flag"></i>
            </div>
            <div class="apl-profile-name">{{ $partylist->name }}</div>
            @if($partylist->description)
            <div class="apl-profile-desc">{{ $partylist->description }}</div>
            @endif
            <div class="apl-profile-divider"></div>
            <a href="{{ route('admin.partylists.edit', $partylist) }}" class="apl-profile-btn apl-profile-btn-sky">
                <i class="fas fa-pen" style="font-size:.65rem;"></i> Edit Partylist
            </a>
            <button type="button" class="apl-profile-btn apl-profile-btn-danger"
                    @click="$dispatch('open-modal', 'delete-partylist')">
                <i class="fas fa-trash" style="font-size:.65rem;"></i> Delete Partylist
            </button>
        </div>
    </div>

    {{-- Right ── --}}
    <div>
        <div class="apl-stats-row">
            <div class="apl-stat-tile">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div class="apl-stat-tile-label">Total Candidates</div>
                        <div class="apl-stat-tile-num">{{ $partylist->candidates->count() }}</div>
                    </div>
                    <div class="apl-stat-tile-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                        <i class="fas fa-user-tie" style="color:#60a5fa;"></i>
                    </div>
                </div>
            </div>
            <div class="apl-stat-tile">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div class="apl-stat-tile-label">Total Votes</div>
                        <div class="apl-stat-tile-num" style="background:linear-gradient(135deg,#34d399,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                            {{ \App\Models\CastedVote::whereIn('candidate_id', $partylist->candidates->pluck('id'))->count() }}
                        </div>
                    </div>
                    <div class="apl-stat-tile-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                        <i class="fas fa-check-double" style="color:#34d399;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="apl-table-card">
            <div class="apl-table-head">
                <i class="fas fa-user-tie" style="color:rgba(249,180,15,0.6);font-size:0.75rem;"></i>
                <span class="apl-table-head-title">
                    Candidates
                    <span style="font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:400;color:rgba(255,251,240,0.35);margin-left:6px;">
                        ({{ $partylist->candidates->count() }})
                    </span>
                </span>
            </div>

            @if($partylist->candidates->count() > 0)
            <div style="overflow-x:auto;">
                <table class="apl-table">
                    <thead>
                        <tr class="apl-thead-row">
                            <th>Name</th>
                            <th>Position</th>
                            <th>College</th>
                            <th>Votes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partylist->candidates as $candidate)
                        <tr class="apl-tbody-row">
                            <td>
                                <a href="{{ route('admin.candidates.show', $candidate) }}" class="apl-cand-link">
                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                </a>
                            </td>
                            <td>
                                @if($candidate->position)
                                    <span class="apl-pos-badge">{{ $candidate->position->name }}</span>
                                @else
                                    <span style="color:rgba(255,251,240,0.25);font-size:0.75rem;">—</span>
                                @endif
                            </td>
                            <td class="apl-college-text">{{ $candidate->college?->name ?? '—' }}</td>
                            <td>
                                <span class="apl-votes-badge">
                                    {{ \App\Models\CastedVote::where('candidate_id', $candidate->id)->count() }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="apl-empty">
                <i class="fas fa-inbox apl-empty-icon"></i>
                <div class="apl-empty-title">No candidates in this partylist yet</div>
            </div>
            @endif
        </div>
    </div>
</div>

<x-modal name="delete-partylist" focusable>
    <div class="apl-modal-wrap">
        <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:4px;">
            <div class="apl-modal-icon"><i class="fas fa-flag"></i></div>
            <div>
                <div class="apl-modal-title">Delete Partylist</div>
                <div class="apl-modal-sub">This action cannot be undone.</div>
            </div>
        </div>
        <p class="apl-modal-body">
            Are you sure you want to delete <strong style="color:#fffbf0;">{{ $partylist->name }}</strong>?
        </p>
        @if($partylist->candidates->count() > 0)
        <div class="apl-warning-box">
            <i class="fas fa-triangle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
            <span>This partylist has {{ $partylist->candidates->count() }} candidate(s). Deleting it may affect election data.</span>
        </div>
        @endif
        <div class="apl-modal-btns">
            <button class="apl-m-cancel" @click="$dispatch('close-modal', 'delete-partylist')">Cancel</button>
            <form method="POST" action="{{ route('admin.partylists.destroy', $partylist) }}" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="apl-m-delete">
                    <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete Permanently
                </button>
            </form>
        </div>
    </div>
</x-modal>

</x-app-layout>