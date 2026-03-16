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
.apos-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem; font-weight: 900; color: #fffbf0; margin: 0 0 3px;
}
.apos-page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); margin: 0 0 24px; }

/* ── Glass card base ── */
.apos-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
}
.apos-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

/* ── Stat strip ── */
.apos-stat-strip {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 20px;
}
@media (max-width: 640px) { .apos-stat-strip { grid-template-columns: 1fr 1fr; } }

.apos-stat-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 16px; padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: inset 0 1px 0 rgba(249,180,15,0.05);
    animation: fadeUp .4s ease both;
}
.apos-stat-icon {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
}
.apos-stat-num {
    font-family: 'Playfair Display', serif; font-size: 1.55rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, #f9b40f, #fcd558, #fff3c4);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.apos-stat-lbl {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.45); margin-top: 3px;
}

/* ── Filter bar ── */
.apos-filter-bar {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.14);
    border-radius: 14px; padding: 16px 20px;
    margin-bottom: 18px;
    display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;
    animation: fadeUp .42s ease both;
}
.apos-filter-label {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 6px;
}
.apos-input {
    background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
    border-radius: 9px; padding: 8px 12px 8px 32px;
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem; color: #fffbf0;
    outline: none; width: 100%; transition: border-color .2s, box-shadow .2s;
}
.apos-input::placeholder { color: rgba(255,251,240,0.2); }
.apos-input:focus { border-color: rgba(249,180,15,0.4); box-shadow: 0 0 0 3px rgba(249,180,15,0.06); }

.apos-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px; border-radius: 9px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; border: none; white-space: nowrap;
    text-decoration: none;
}
.apos-btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 3px 12px rgba(249,180,15,0.3);
}
.apos-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(249,180,15,0.45); }
.apos-btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.55);
}
.apos-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
.apos-btn-gold-outline {
    background: transparent;
    border: 1px solid rgba(249,180,15,0.2);
    color: rgba(249,180,15,0.55);
    padding: 9px 18px; border-radius: 9px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    display: inline-flex; align-items: center; gap: 6px;
    text-decoration: none; transition: all .18s;
}
.apos-btn-gold-outline:hover { background: rgba(249,180,15,0.06); color: #f9b40f; border-color: rgba(249,180,15,0.4); }

/* ── Table card ── */
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

.apos-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.apos-thead tr {
    background: linear-gradient(to right, rgba(56,0,65,0.5), transparent);
    border-bottom: 1px solid rgba(249,180,15,0.12);
}
.apos-thead th {
    padding: 14px 20px; text-align: left;
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.6);
}
.apos-thead th:last-child { text-align: right; }

.apos-tbody tr {
    border-bottom: 1px solid rgba(249,180,15,0.07);
    transition: background .18s;
}
.apos-tbody tr:last-child { border-bottom: none; }
.apos-tbody tr:hover { background: rgba(249,180,15,0.04); }
.apos-tbody td { padding: 14px 20px; color: rgba(255,251,240,0.85); vertical-align: middle; }
.apos-tbody td:last-child { text-align: right; }

/* ── Position icon ── */
.apos-icon-wrap {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; color: #f9b40f;
}

.apos-pos-name {
    font-family: 'Playfair Display', serif; font-weight: 700;
    font-size: 0.9rem; color: #fffbf0;
}

/* ── Candidates badge ── */
.apos-cands-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 99px;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.2);
    font-size: 0.68rem; font-weight: 700; color: #f9b40f;
}

/* ── Action buttons ── */
.apos-action-btn {
    width: 30px; height: 30px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1px solid rgba(249,180,15,0.15); background: transparent;
    color: rgba(249,180,15,0.5); font-size: 0.65rem;
    cursor: pointer; transition: all .18s; text-decoration: none;
}
.apos-action-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.06); }
.apos-action-btn.sky { border-color: rgba(96,165,250,0.2); color: rgba(96,165,250,0.6); }
.apos-action-btn.sky:hover { border-color: rgba(96,165,250,0.5); color: #93c5fd; background: rgba(96,165,250,0.08); }
.apos-action-btn.danger { border-color: rgba(248,113,113,0.2); color: rgba(248,113,113,0.5); }
.apos-action-btn.danger:hover { border-color: rgba(248,113,113,0.45); color: #f87171; background: rgba(248,113,113,0.06); }

/* ── Empty state ── */
.apos-empty {
    padding: 60px 24px; text-align: center; animation: fadeUp .4s ease both;
}
.apos-empty-icon  { font-size: 2.5rem; color: rgba(249,180,15,0.1); margin-bottom: 14px; display: block; }
.apos-empty-title { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 800; color: rgba(255,251,240,0.35); margin-bottom: 6px; }
.apos-empty-sub   { font-size: 0.72rem; color: rgba(255,251,240,0.2); }

/* ── Toast ── */
.apos-toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
    font-size: 0.75rem; font-weight: 600;
    animation: fadeUp .35s ease both;
}
.apos-toast-success {
    background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34d399;
}
.apos-toast-error {
    background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #f87171;
}

/* ── Pagination override ── */
.apos-pagination { padding: 16px 20px; border-top: 1px solid rgba(249,180,15,0.1); }

/* ── Page header row ── */
.apos-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    animation: fadeUp .3s ease both;
}
</style>
@endpush

<div style="padding: 0 0 60px;">

    {{-- Page Header --}}
    <div class="apos-page-header">
        <div>
            <h1 class="apos-page-title">Position Management</h1>
            <p class="apos-page-sub">Manage all election positions</p>
        </div>
        <a href="{{ route('admin.positions.create') }}" class="apos-btn apos-btn-primary">
            <i class="fas fa-plus" style="font-size:.62rem;"></i> Add Position
        </a>
    </div>

    {{-- Toasts --}}
    @if(session('success'))
    <div class="apos-toast apos-toast-success"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-circle-check" style="flex-shrink:0;"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="apos-toast apos-toast-error"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i>
        {{ session('error') }}
    </div>
    @endif

    {{-- Stat Strip --}}
    @php
        $total           = $positions->total();
        $totalCandidates = \App\Models\Candidate::count();
        $totalVotes      = \App\Models\CastedVote::count();
        $avgCandidates   = $total > 0 ? round($totalCandidates / $total) : 0;
    @endphp

    <div class="apos-stat-strip">
        <div class="apos-stat-card" style="animation-delay:.06s;">
            <div class="apos-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-sitemap" style="color:#f9b40f;"></i>
            </div>
            <div>
                <div class="apos-stat-num">{{ $total }}</div>
                <div class="apos-stat-lbl">Total Positions</div>
            </div>
        </div>
        <div class="apos-stat-card" style="animation-delay:.1s;">
            <div class="apos-stat-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-users" style="color:#34d399;"></i>
            </div>
            <div>
                <div class="apos-stat-num" style="background:linear-gradient(135deg,#34d399,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $totalCandidates }}</div>
                <div class="apos-stat-lbl">Total Candidates</div>
            </div>
        </div>
        <div class="apos-stat-card" style="animation-delay:.14s;">
            <div class="apos-stat-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                <i class="fas fa-check-double" style="color:#60a5fa;"></i>
            </div>
            <div>
                <div class="apos-stat-num" style="background:linear-gradient(135deg,#60a5fa,#93c5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $totalVotes }}</div>
                <div class="apos-stat-lbl">Total Votes</div>
            </div>
        </div>
        <div class="apos-stat-card" style="animation-delay:.18s;">
            <div class="apos-stat-icon" style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);">
                <i class="fas fa-chart-column" style="color:#f87171;"></i>
            </div>
            <div>
                <div class="apos-stat-num" style="background:linear-gradient(135deg,#f87171,#fca5a5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $avgCandidates }}</div>
                <div class="apos-stat-lbl">Avg Candidates/Pos</div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="apos-filter-bar">
        <form method="GET" action="{{ route('admin.positions.index') }}"
              style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;width:100%;">
            <div style="flex:1;min-width:200px;">
                <div class="apos-filter-label">Search</div>
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:0.6rem;color:rgba(249,180,15,0.35);pointer-events:none;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Position name…" class="apos-input">
                </div>
            </div>
            <button type="submit" class="apos-btn apos-btn-primary">
                <i class="fas fa-filter" style="font-size:.62rem;"></i> Search
            </button>
            @if(request('search'))
            <a href="{{ route('admin.positions.index') }}" class="apos-btn apos-btn-ghost">
                <i class="fas fa-xmark" style="font-size:.62rem;"></i> Clear
            </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="apos-table-card">
        <div style="overflow-x:auto;">
            <table class="apos-table">
                <thead class="apos-thead">
                    <tr>
                        <th>Position</th>
                        <th style="text-align:center;">Candidates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="apos-tbody">
                    @forelse($positions as $position)
                    <tr>
                        {{-- Position --}}
                        <td>
                            <a href="{{ route('admin.positions.show', $position) }}"
                               style="display:flex;align-items:center;gap:12px;text-decoration:none;">
                                <div class="apos-icon-wrap">
                                    <i class="fas fa-sitemap"></i>
                                </div>
                                <span class="apos-pos-name">{{ $position->name }}</span>
                            </a>
                        </td>

                        {{-- Candidates count --}}
                        <td style="text-align:center;">
                            <span class="apos-cands-badge">
                                <i class="fas fa-users" style="font-size:.6rem;"></i>
                                {{ $position->candidates_count ?? 0 }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                                <a href="{{ route('admin.positions.show', $position) }}"
                                   class="apos-action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.positions.edit', $position) }}"
                                   class="apos-action-btn sky" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button"
                                        class="apos-action-btn danger" title="Delete"
                                        onclick="if(confirm('Are you sure? This cannot be undone.'){{ $position->candidates_count ?? 0 > 0 ? " && confirm('This position has candidates. Continue?')" : '' }}) { document.getElementById('del-pos-{{ $position->id }}').submit(); }">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="del-pos-{{ $position->id }}"
                                      method="POST"
                                      action="{{ route('admin.positions.destroy', $position) }}"
                                      style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding:0;">
                            <div class="apos-empty">
                                <i class="fas fa-inbox apos-empty-icon"></i>
                                <div class="apos-empty-title">No positions found</div>
                                <div class="apos-empty-sub">
                                    @if(request('search'))
                                        Try adjusting your search.
                                    @else
                                        Add a position to get started.
                                    @endif
                                </div>
                                @if(request('search'))
                                <a href="{{ route('admin.positions.index') }}"
                                   class="apos-btn-gold-outline" style="margin-top:16px;display:inline-flex;">
                                    <i class="fas fa-xmark" style="font-size:.62rem;"></i> Clear search
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($positions->hasPages())
        <div class="apos-pagination">
            {{ $positions->links() }}
        </div>
        @endif
    </div>

</div>
</x-app-layout>