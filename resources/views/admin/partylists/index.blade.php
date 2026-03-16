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

.apl-stat-strip {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 20px;
}
@media (max-width: 640px) { .apl-stat-strip { grid-template-columns: 1fr 1fr; } }

.apl-stat-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 16px; padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: inset 0 1px 0 rgba(249,180,15,0.05);
    animation: fadeUp .4s ease both;
}
.apl-stat-icon {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
}
.apl-stat-num {
    font-family: 'Playfair Display', serif; font-size: 1.55rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, #f9b40f, #fcd558, #fff3c4);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.apl-stat-lbl {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.45); margin-top: 3px;
}

.apl-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    animation: fadeUp .3s ease both;
}
.apl-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem; font-weight: 900; color: #fffbf0; margin: 0 0 3px;
}
.apl-page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); }

.apl-filter-bar {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.14);
    border-radius: 14px; padding: 16px 20px;
    margin-bottom: 18px;
    display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;
    animation: fadeUp .42s ease both;
}
.apl-filter-label {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 6px;
}
.apl-input {
    background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
    border-radius: 9px; padding: 8px 12px 8px 32px;
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem; color: #fffbf0;
    outline: none; width: 100%; transition: border-color .2s, box-shadow .2s;
}
.apl-input::placeholder { color: rgba(255,251,240,0.2); }
.apl-input:focus { border-color: rgba(249,180,15,0.4); box-shadow: 0 0 0 3px rgba(249,180,15,0.06); }

.apl-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px; border-radius: 9px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; border: none; white-space: nowrap;
    text-decoration: none;
}
.apl-btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 3px 12px rgba(249,180,15,0.3);
}
.apl-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(249,180,15,0.45); color: #380041; }
.apl-btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.55);
}
.apl-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }

.apl-table-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
    animation: fadeUp .46s ease both;
}
.apl-table-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

.apl-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.apl-thead tr {
    background: linear-gradient(to right, rgba(56,0,65,0.5), transparent);
    border-bottom: 1px solid rgba(249,180,15,0.12);
}
.apl-thead th {
    padding: 14px 20px; text-align: left;
    font-size: 0.58rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.6);
}
.apl-thead th:last-child { text-align: right; }
.apl-tbody tr {
    border-bottom: 1px solid rgba(249,180,15,0.07);
    transition: background .18s;
}
.apl-tbody tr:last-child { border-bottom: none; }
.apl-tbody tr:hover { background: rgba(249,180,15,0.04); }
.apl-tbody td { padding: 14px 20px; color: rgba(255,251,240,0.85); vertical-align: middle; }
.apl-tbody td:last-child { text-align: right; }

.apl-party-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; color: #f9b40f;
}
.apl-party-name { font-weight: 600; color: #fffbf0; }
.apl-desc-text  { font-size: 0.72rem; color: rgba(255,251,240,0.45); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 240px; }

.apl-cands-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 99px;
    background: rgba(96,165,250,0.1); border: 1px solid rgba(96,165,250,0.2);
    font-size: 0.65rem; font-weight: 700; color: #60a5fa;
}

.apl-action-btn {
    width: 30px; height: 30px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1px solid rgba(249,180,15,0.15); background: transparent;
    color: rgba(249,180,15,0.5); font-size: 0.65rem;
    cursor: pointer; transition: all .18s; text-decoration: none;
}
.apl-action-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.06); }
.apl-action-btn.sky { border-color: rgba(96,165,250,0.2); color: rgba(96,165,250,0.6); }
.apl-action-btn.sky:hover { border-color: rgba(96,165,250,0.5); color: #93c5fd; background: rgba(96,165,250,0.08); }
.apl-action-btn.danger { border-color: rgba(248,113,113,0.2); color: rgba(248,113,113,0.5); }
.apl-action-btn.danger:hover { border-color: rgba(248,113,113,0.45); color: #f87171; background: rgba(248,113,113,0.06); }

.apl-empty { padding: 60px 24px; text-align: center; }
.apl-empty-icon  { font-size: 2.5rem; color: rgba(249,180,15,0.1); margin-bottom: 14px; display: block; }
.apl-empty-title { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 800; color: rgba(255,251,240,0.35); margin-bottom: 6px; }
.apl-empty-sub   { font-size: 0.72rem; color: rgba(255,251,240,0.2); }

.apl-toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 600;
    animation: fadeUp .35s ease both;
}
.apl-toast-success { background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
.apl-toast-error   { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }

.apl-pagination { padding: 16px 20px; border-top: 1px solid rgba(249,180,15,0.1); }

.apl-modal-wrap { padding: 28px; background: rgba(26,0,32,0.98); }
.apl-modal-icon {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #f87171;
}
.apl-modal-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; margin-bottom: 3px; }
.apl-modal-sub   { font-size: 0.7rem; color: rgba(255,251,240,0.4); }
.apl-modal-body  { font-size: 0.75rem; color: rgba(255,251,240,0.5); line-height: 1.7; margin: 16px 0 22px; }
.apl-warning-box {
    padding: 10px 14px; border-radius: 9px; margin-bottom: 16px;
    background: rgba(248,113,113,0.06); border: 1px solid rgba(248,113,113,0.15);
    font-size: 0.68rem; color: rgba(248,113,113,0.8); display: flex; align-items: flex-start; gap: 8px;
}
.apl-modal-btns { display: flex; gap: 10px; justify-content: flex-end; }
.apl-m-cancel {
    padding: 9px 18px; border-radius: 9px; cursor: pointer;
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.55); font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700; transition: all .18s;
}
.apl-m-cancel:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
.apl-m-delete {
    padding: 9px 20px; border-radius: 9px; cursor: pointer;
    background: linear-gradient(135deg, #ef4444, #f87171); border: none;
    color: #fff; font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(239,68,68,0.3); transition: all .18s;
}
.apl-m-delete:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(239,68,68,0.45); }
</style>
@endpush

<div style="padding: 0 0 60px;">

    <div class="apl-page-header">
        <div>
            <h1 class="apl-page-title">Partylist Management</h1>
            <p class="apl-page-sub">Manage all registered partylists</p>
        </div>
        <a href="{{ route('admin.partylists.create') }}" class="apl-btn apl-btn-primary">
            <i class="fas fa-plus" style="font-size:.62rem;"></i> Add Partylist
        </a>
    </div>

    @if(session('success'))
    <div class="apl-toast apl-toast-success"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-circle-check" style="flex-shrink:0;"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="apl-toast apl-toast-error"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i> {{ session('error') }}
    </div>
    @endif

    {{-- Stats --}}
    @php
        $total           = $partylists->total();
        $totalCandidates = \App\Models\Candidate::whereNotNull('partylist_id')->count();
        $totalVotes      = \App\Models\CastedVote::count();
        $avgCandidates   = $total > 0 ? round($totalCandidates / $total) : 0;
    @endphp
    <div class="apl-stat-strip">
        <div class="apl-stat-card" style="animation-delay:.06s;">
            <div class="apl-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-flag" style="color:#f9b40f;"></i>
            </div>
            <div>
                <div class="apl-stat-num">{{ $total }}</div>
                <div class="apl-stat-lbl">Total Partylists</div>
            </div>
        </div>
        <div class="apl-stat-card" style="animation-delay:.1s;">
            <div class="apl-stat-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-user-tie" style="color:#34d399;"></i>
            </div>
            <div>
                <div class="apl-stat-num" style="background:linear-gradient(135deg,#34d399,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $totalCandidates }}</div>
                <div class="apl-stat-lbl">Total Candidates</div>
            </div>
        </div>
        <div class="apl-stat-card" style="animation-delay:.14s;">
            <div class="apl-stat-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                <i class="fas fa-check-double" style="color:#60a5fa;"></i>
            </div>
            <div>
                <div class="apl-stat-num" style="background:linear-gradient(135deg,#60a5fa,#93c5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $totalVotes }}</div>
                <div class="apl-stat-lbl">Total Votes</div>
            </div>
        </div>
        <div class="apl-stat-card" style="animation-delay:.18s;">
            <div class="apl-stat-icon" style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);">
                <i class="fas fa-chart-column" style="color:#f87171;"></i>
            </div>
            <div>
                <div class="apl-stat-num" style="background:linear-gradient(135deg,#f87171,#fca5a5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $avgCandidates }}</div>
                <div class="apl-stat-lbl">Avg Candidates/List</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="apl-filter-bar">
        <form method="GET" action="{{ route('admin.partylists.index') }}"
              style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;width:100%;">
            <div style="flex:1;min-width:200px;">
                <div class="apl-filter-label">Search</div>
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:0.6rem;color:rgba(249,180,15,0.35);pointer-events:none;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Partylist name…" class="apl-input">
                </div>
            </div>
            <button type="submit" class="apl-btn apl-btn-primary">
                <i class="fas fa-filter" style="font-size:.62rem;"></i> Search
            </button>
            @if(request('search'))
            <a href="{{ route('admin.partylists.index') }}" class="apl-btn apl-btn-ghost">
                <i class="fas fa-xmark" style="font-size:.62rem;"></i> Clear
            </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="apl-table-card">
        <div style="overflow-x:auto;">
            <table class="apl-table">
                <thead class="apl-thead">
                    <tr>
                        <th>Partylist</th>
                        <th>Description</th>
                        <th style="text-align:center;">Candidates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="apl-tbody">
                    @forelse($partylists as $partylist)
                    <tr>
                        <td>
                            <a href="{{ route('admin.partylists.show', $partylist) }}"
                               style="display:flex;align-items:center;gap:12px;text-decoration:none;">
                                <div class="apl-party-icon">
                                    <i class="fas fa-flag"></i>
                                </div>
                                <span class="apl-party-name">{{ $partylist->name }}</span>
                            </a>
                        </td>
                        <td>
                            <span class="apl-desc-text">{{ $partylist->description ?? '—' }}</span>
                        </td>
                        <td style="text-align:center;">
                            <span class="apl-cands-badge">
                                <i class="fas fa-user-tie" style="font-size:.58rem;"></i>
                                {{ $partylist->candidates_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                                <a href="{{ route('admin.partylists.show', $partylist) }}"
                                   class="apl-action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.partylists.edit', $partylist) }}"
                                   class="apl-action-btn sky" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button"
                                        class="apl-action-btn danger" title="Delete"
                                        @click="$dispatch('open-modal', 'delete-pl-{{ $partylist->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <x-modal name="delete-pl-{{ $partylist->id }}" focusable>
                                <div class="apl-modal-wrap">
                                    <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:4px;">
                                        <div class="apl-modal-icon"><i class="fas fa-flag"></i></div>
                                        <div>
                                            <div class="apl-modal-title">Delete Partylist</div>
                                            <div class="apl-modal-sub">This action cannot be undone.</div>
                                        </div>
                                    </div>
                                    <p class="apl-modal-body">
                                        Are you sure you want to delete
                                        <strong style="color:#fffbf0;">{{ $partylist->name }}</strong>?
                                    </p>
                                    @if(($partylist->candidates_count ?? 0) > 0)
                                    <div class="apl-warning-box">
                                        <i class="fas fa-triangle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
                                        <span>This partylist has {{ $partylist->candidates_count }} candidate(s). Deleting it may affect election data.</span>
                                    </div>
                                    @endif
                                    <div class="apl-modal-btns">
                                        <button class="apl-m-cancel" x-on:click="$dispatch('close')">Cancel</button>
                                        <form method="POST" action="{{ route('admin.partylists.destroy', $partylist) }}" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="apl-m-delete">
                                                <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding:0;">
                            <div class="apl-empty">
                                <i class="fas fa-flag apl-empty-icon"></i>
                                <div class="apl-empty-title">No partylists found</div>
                                <div class="apl-empty-sub">
                                    @if(request('search')) Try adjusting your search.
                                    @else Add the first partylist to get started.
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($partylists->hasPages())
        <div class="apl-pagination">{{ $partylists->links() }}</div>
        @endif
    </div>

</div>
</x-app-layout>