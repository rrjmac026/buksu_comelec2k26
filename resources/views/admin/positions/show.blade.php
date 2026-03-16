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

/* ── Page header ── */
.apos-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; margin-bottom: 28px; flex-wrap: wrap;
    animation: fadeUp 0.3s ease both;
}
.apos-page-header-left { display: flex; align-items: center; gap: 14px; }
.apos-back-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
    border: 1px solid rgba(249,180,15,0.2); background: transparent;
    font-size: 0.72rem; color: rgba(249,180,15,0.6);
    text-decoration: none; transition: all 0.18s;
}
.apos-back-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.06); }
.apos-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem; font-weight: 900; color: #fffbf0; margin: 0;
}
.apos-page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); margin-top: 3px; }
.apos-page-sub strong { color: rgba(249,180,15,0.7); }

/* ── Glass card ── */
.apos-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
    animation: fadeUp .4s ease both;
    margin-bottom: 16px;
}
.apos-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

/* ── Toast ── */
.apos-toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 600;
    background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34d399;
    animation: fadeUp .35s ease both;
}

/* ── Grid layout ── */
.apos-grid {
    display: grid; grid-template-columns: 260px 1fr; gap: 16px; align-items: start;
}
@media (max-width: 768px) { .apos-grid { grid-template-columns: 1fr; } }

/* ── Profile card ── */
.apos-profile-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
    padding: 28px 24px;
    text-align: center;
    animation: fadeUp .4s ease both;
}
.apos-profile-card::before {
    content: ''; display: block; height: 2px; margin: -28px -24px 24px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

.apos-profile-avatar {
    width: 80px; height: 80px; border-radius: 20px; margin: 0 auto 16px;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem; color: #f9b40f;
}
.apos-profile-name {
    font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 900;
    color: #fffbf0; margin-bottom: 20px;
}

.apos-profile-divider { height: 1px; background: rgba(249,180,15,0.1); margin: 0 0 16px; }

.apos-profile-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 9px 16px; border-radius: 10px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; text-decoration: none; border: none;
    margin-bottom: 8px;
}
.apos-profile-btn:last-child { margin-bottom: 0; }
.apos-profile-btn-sky {
    background: transparent; border: 1px solid rgba(96,165,250,0.25); color: rgba(96,165,250,0.7);
}
.apos-profile-btn-sky:hover { background: rgba(96,165,250,0.08); border-color: rgba(96,165,250,0.5); color: #93c5fd; }
.apos-profile-btn-danger {
    background: transparent; border: 1px solid rgba(248,113,113,0.25); color: rgba(248,113,113,0.7);
}
.apos-profile-btn-danger:hover { background: rgba(248,113,113,0.08); border-color: rgba(248,113,113,0.5); color: #f87171; }

/* ── Stats row ── */
.apos-stats-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }

.apos-stat-tile {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 16px; padding: 20px;
    animation: fadeUp .42s ease both;
}
.apos-stat-tile::before { display: none; }
.apos-stat-tile-label {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5); margin-bottom: 8px;
}
.apos-stat-tile-num {
    font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, #f9b40f, #fcd558);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.apos-stat-tile-icon {
    float: right; width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
}

/* ── Candidates table card ── */
.apos-table-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
    animation: fadeUp .46s ease both;
}
.apos-table-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

.apos-table-head {
    padding: 18px 24px 14px;
    border-bottom: 1px solid rgba(249,180,15,0.08);
    background: linear-gradient(to right, rgba(56,0,65,0.4), transparent);
    display: flex; align-items: center; gap: 10px;
}
.apos-table-head-title {
    font-family: 'Playfair Display', serif; font-size: 0.95rem; font-weight: 800;
    color: #fffbf0;
}
.apos-table-head-icon { color: rgba(249,180,15,0.6); font-size: 0.8rem; }

.apos-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.apos-thead-row {
    background: linear-gradient(to right, rgba(56,0,65,0.4), transparent);
    border-bottom: 1px solid rgba(249,180,15,0.1);
}
.apos-thead-row th {
    padding: 12px 24px; text-align: left;
    font-size: 0.58rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5);
}
.apos-thead-row th:last-child { text-align: center; }

.apos-tbody-row {
    border-bottom: 1px solid rgba(249,180,15,0.07);
    transition: background .18s;
}
.apos-tbody-row:last-child { border-bottom: none; }
.apos-tbody-row:hover { background: rgba(249,180,15,0.04); }
.apos-tbody-row td { padding: 13px 24px; color: rgba(255,251,240,0.85); vertical-align: middle; }

.apos-cand-name {
    font-weight: 600; color: #fffbf0; text-decoration: none; transition: color .18s;
}
.apos-cand-name:hover { color: #f9b40f; }

.apos-party-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 99px; font-size: 0.62rem; font-weight: 700;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.75);
}
.apos-votes-badge {
    display: inline-flex; align-items: center; justify-content: center;
    padding: 4px 14px; border-radius: 99px; font-size: 0.7rem; font-weight: 800;
    background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2);
    color: #34d399;
}

/* ── Empty state ── */
.apos-empty {
    padding: 48px 24px; text-align: center;
}
.apos-empty-icon  { font-size: 2rem; color: rgba(249,180,15,0.1); margin-bottom: 12px; display: block; }
.apos-empty-title { font-family: 'Playfair Display', serif; font-size: 0.95rem; font-weight: 800; color: rgba(255,251,240,0.3); }

/* ── Header edit btn ── */
.apos-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 20px; border-radius: 10px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; text-decoration: none; border: none;
}
.apos-btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.6);
}
.apos-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; border-color: rgba(249,180,15,0.4); }

/* ── Delete modal ── */
.apos-modal-wrap { padding: 28px; background: rgba(26,0,32,0.98); }
.apos-modal-icon {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #f87171;
}
.apos-modal-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; margin-bottom: 3px; }
.apos-modal-sub   { font-size: 0.7rem; color: rgba(255,251,240,0.4); }
.apos-modal-body  { font-size: 0.75rem; color: rgba(255,251,240,0.5); line-height: 1.7; margin: 16px 0 22px; }
.apos-warning-box {
    padding: 10px 14px; border-radius: 9px; margin-bottom: 16px;
    background: rgba(248,113,113,0.06); border: 1px solid rgba(248,113,113,0.15);
    font-size: 0.68rem; color: rgba(248,113,113,0.8); display: flex; align-items: flex-start; gap: 8px;
}
.apos-modal-btns  { display: flex; gap: 10px; justify-content: flex-end; }
.apos-m-cancel {
    padding: 9px 18px; border-radius: 9px; cursor: pointer;
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.55); font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700; transition: all .18s;
}
.apos-m-cancel:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
.apos-m-delete {
    padding: 9px 20px; border-radius: 9px; cursor: pointer;
    background: linear-gradient(135deg, #ef4444, #f87171); border: none;
    color: #fff; font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(239,68,68,0.3); transition: all .18s;
}
.apos-m-delete:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(239,68,68,0.45); }
</style>
@endpush

{{-- Toast --}}
@if(session('success'))
<div class="apos-toast"
     x-data="{ show: true }" x-show="show"
     x-init="setTimeout(() => show = false, 4000)"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <i class="fas fa-circle-check" style="flex-shrink:0;"></i>
    {{ session('success') }}
</div>
@endif

{{-- Page Header --}}
<div class="apos-page-header">
    <div class="apos-page-header-left">
        <a href="{{ route('admin.positions.index') }}" class="apos-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="apos-page-title">Position Profile</div>
            <div class="apos-page-sub">Viewing details for <strong>{{ $position->name }}</strong></div>
        </div>
    </div>
    <a href="{{ route('admin.positions.edit', $position) }}" class="apos-btn apos-btn-ghost">
        <i class="fas fa-pen" style="font-size:.65rem;"></i> Edit
    </a>
</div>

<div class="apos-grid">

    {{-- Left: Profile card ── --}}
    <div>
        <div class="apos-profile-card">
            <div class="apos-profile-avatar">
                <i class="fas fa-sitemap"></i>
            </div>
            <div class="apos-profile-name">{{ $position->name }}</div>

            <div class="apos-profile-divider"></div>

            <a href="{{ route('admin.positions.edit', $position) }}" class="apos-profile-btn apos-profile-btn-sky">
                <i class="fas fa-pen" style="font-size:.65rem;"></i> Edit Position
            </a>
            <button type="button" class="apos-profile-btn apos-profile-btn-danger"
                    @click="$dispatch('open-modal', 'delete-position')">
                <i class="fas fa-trash" style="font-size:.65rem;"></i> Delete Position
            </button>
        </div>
    </div>

    {{-- Right: Stats + Table ── --}}
    <div>

        {{-- Stats row ── --}}
        <div class="apos-stats-row">
            <div class="apos-stat-tile">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div class="apos-stat-tile-label">Total Candidates</div>
                        <div class="apos-stat-tile-num">{{ $position->candidates->count() }}</div>
                    </div>
                    <div class="apos-stat-tile-icon"
                         style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                        <i class="fas fa-users" style="color:#60a5fa;"></i>
                    </div>
                </div>
            </div>

            <div class="apos-stat-tile">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div class="apos-stat-tile-label">Total Votes</div>
                        <div class="apos-stat-tile-num"
                             style="background:linear-gradient(135deg,#34d399,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                            {{ \App\Models\CastedVote::whereIn('candidate_id', $position->candidates->pluck('candidate_id'))->count() }}
                        </div>
                    </div>
                    <div class="apos-stat-tile-icon"
                         style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                        <i class="fas fa-check-double" style="color:#34d399;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Candidates table ── --}}
        <div class="apos-table-card">
            <div class="apos-table-head">
                <span class="apos-table-head-icon"><i class="fas fa-users"></i></span>
                <span class="apos-table-head-title">
                    Candidates
                    <span style="font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:400;color:rgba(255,251,240,0.35);margin-left:6px;">
                        ({{ $position->candidates->count() }})
                    </span>
                </span>
            </div>

            @if($position->candidates->count() > 0)
            <div style="overflow-x:auto;">
                <table class="apos-table">
                    <thead>
                        <tr class="apos-thead-row">
                            <th>Name</th>
                            <th class="hidden-sm">Party List</th>
                            <th class="hidden-lg">College</th>
                            <th>Votes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($position->candidates as $candidate)
                        <tr class="apos-tbody-row">
                            <td>
                                <a href="{{ route('admin.candidates.show', $candidate) }}" class="apos-cand-name">
                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                </a>
                            </td>
                            <td>
                                @if($candidate->partylist)
                                    <span class="apos-party-badge">{{ $candidate->partylist->name }}</span>
                                @else
                                    <span style="color:rgba(255,251,240,0.25);font-size:0.75rem;">—</span>
                                @endif
                            </td>
                            <td>
                                <span style="color:rgba(255,251,240,0.6);font-size:0.78rem;">
                                    {{ $candidate->college?->name ?? '—' }}
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <span class="apos-votes-badge">
                                    {{ \App\Models\CastedVote::where('candidate_id', $candidate->candidate_id)->count() }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="apos-empty">
                <i class="fas fa-inbox apos-empty-icon"></i>
                <div class="apos-empty-title">No candidates in this position yet</div>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Delete Modal --}}
<x-modal name="delete-position" focusable>
    <div class="apos-modal-wrap">
        <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:4px;">
            <div class="apos-modal-icon"><i class="fas fa-trash"></i></div>
            <div>
                <div class="apos-modal-title">Delete Position</div>
                <div class="apos-modal-sub">This action cannot be undone.</div>
            </div>
        </div>
        <p class="apos-modal-body">
            Are you sure you want to delete <strong style="color:#fffbf0;">{{ $position->name }}</strong>?
        </p>
        @if($position->candidates->count() > 0)
        <div class="apos-warning-box">
            <i class="fas fa-triangle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
            <span>This position has {{ $position->candidates->count() }} candidate(s). Deleting it may affect election data.</span>
        </div>
        @endif
        <div class="apos-modal-btns">
            <button class="apos-m-cancel" @click="$dispatch('close-modal', 'delete-position')">
                Cancel
            </button>
            <form method="POST" action="{{ route('admin.positions.destroy', $position) }}" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="apos-m-delete">
                    <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete
                </button>
            </form>
        </div>
    </div>
</x-modal>

</x-app-layout>