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
    0%,100% { opacity: 1; } 50% { opacity: .5; }
}

/* ── Stat strip ── */
.ac-stat-strip {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 20px;
}
@media (max-width: 640px) { .ac-stat-strip { grid-template-columns: 1fr 1fr; } }

.ac-stat-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 16px; padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: inset 0 1px 0 rgba(249,180,15,0.05);
    animation: fadeUp .4s ease both;
}
.ac-stat-icon {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
}
.ac-stat-num {
    font-family: 'Playfair Display', serif; font-size: 1.55rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, #f9b40f, #fcd558, #fff3c4);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.ac-stat-lbl {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.45); margin-top: 3px;
}

/* ── Page header ── */
.ac-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    animation: fadeUp .3s ease both;
}
.ac-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem; font-weight: 900; color: #fffbf0; margin: 0 0 3px;
}
.ac-page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); }

/* ── Filter bar ── */
.ac-filter-bar {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.14);
    border-radius: 14px; padding: 16px 20px;
    margin-bottom: 18px;
    display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;
    animation: fadeUp .42s ease both;
}
.ac-filter-label {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 6px;
}
.ac-input {
    background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
    border-radius: 9px; padding: 8px 12px 8px 32px;
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem; color: #fffbf0;
    outline: none; width: 100%; transition: border-color .2s, box-shadow .2s;
}
.ac-input::placeholder { color: rgba(255,251,240,0.2); }
.ac-input:focus { border-color: rgba(249,180,15,0.4); box-shadow: 0 0 0 3px rgba(249,180,15,0.06); }
.ac-select {
    background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
    border-radius: 9px; padding: 8px 28px 8px 12px;
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem; color: #fffbf0;
    outline: none; width: 100%; transition: border-color .2s;
    -webkit-appearance: none; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(249,180,15,0.5)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
}
.ac-select:focus { border-color: rgba(249,180,15,0.4); }
.ac-select option { background: #1a0020; }

.ac-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px; border-radius: 9px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; border: none; white-space: nowrap;
    text-decoration: none;
}
.ac-btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 3px 12px rgba(249,180,15,0.3);
}
.ac-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(249,180,15,0.45); color: #380041; }
.ac-btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.55);
}
.ac-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }

/* ── Table card ── */
.ac-table-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
    animation: fadeUp .46s ease both;
}
.ac-table-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

.ac-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.ac-thead tr {
    background: linear-gradient(to right, rgba(56,0,65,0.5), transparent);
    border-bottom: 1px solid rgba(249,180,15,0.12);
}
.ac-thead th {
    padding: 14px 20px; text-align: left;
    font-size: 0.58rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.6);
}
.ac-thead th:last-child { text-align: right; }

.ac-tbody tr {
    border-bottom: 1px solid rgba(249,180,15,0.07);
    transition: background .18s;
}
.ac-tbody tr:last-child { border-bottom: none; }
.ac-tbody tr:hover { background: rgba(249,180,15,0.04); }
.ac-tbody td { padding: 14px 20px; color: rgba(255,251,240,0.85); vertical-align: middle; }
.ac-tbody td:last-child { text-align: right; }

/* ── Avatar ── */
.ac-avatar {
    width: 38px; height: 38px; border-radius: 11px; flex-shrink: 0;
    background: linear-gradient(135deg, rgba(56,0,65,0.8), rgba(82,0,96,0.8));
    border: 1px solid rgba(249,180,15,0.25);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 900; color: #f9b40f;
    overflow: hidden;
}
.ac-org-name { font-weight: 600; color: #fffbf0; }
.ac-org-desc  { font-size: 0.65rem; color: rgba(249,180,15,0.5); margin-top: 2px; }

/* ── Badges ── */
.ac-college-badge {
    display: inline-flex; align-items: center;
    padding: 3px 10px; border-radius: 99px; font-size: 0.65rem; font-weight: 600;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.75);
}
.ac-count-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 99px; font-size: 0.65rem; font-weight: 700;
    background: rgba(96,165,250,0.1); border: 1px solid rgba(96,165,250,0.2);
    color: #60a5fa;
}

/* ── Action buttons ── */
.ac-action-btn {
    width: 30px; height: 30px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    border: 1px solid rgba(249,180,15,0.15); background: transparent;
    color: rgba(249,180,15,0.5); font-size: 0.65rem;
    cursor: pointer; transition: all .18s; text-decoration: none;
}
.ac-action-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.06); }
.ac-action-btn.sky { border-color: rgba(96,165,250,0.2); color: rgba(96,165,250,0.6); }
.ac-action-btn.sky:hover { border-color: rgba(96,165,250,0.5); color: #93c5fd; background: rgba(96,165,250,0.08); }
.ac-action-btn.danger { border-color: rgba(248,113,113,0.2); color: rgba(248,113,113,0.5); }
.ac-action-btn.danger:hover { border-color: rgba(248,113,113,0.45); color: #f87171; background: rgba(248,113,113,0.06); }

/* ── Empty state ── */
.ac-empty { padding: 60px 24px; text-align: center; }
.ac-empty-icon  { font-size: 2.5rem; color: rgba(249,180,15,0.1); margin-bottom: 14px; display: block; }
.ac-empty-title { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 800; color: rgba(255,251,240,0.35); margin-bottom: 6px; }
.ac-empty-sub   { font-size: 0.72rem; color: rgba(255,251,240,0.2); }

/* ── Toasts ── */
.ac-toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 600;
    animation: fadeUp .35s ease both;
}
.ac-toast-success { background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
.ac-toast-error   { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }

/* ── Pagination ── */
.ac-pagination { padding: 16px 20px; border-top: 1px solid rgba(249,180,15,0.1); }

/* ── Delete modal ── */
.ac-modal-wrap  { padding: 28px; background: rgba(26,0,32,0.98); }
.ac-modal-icon  {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #f87171;
}
.ac-modal-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; margin-bottom: 3px; }
.ac-modal-sub   { font-size: 0.7rem; color: rgba(255,251,240,0.4); }
.ac-modal-body  { font-size: 0.75rem; color: rgba(255,251,240,0.5); line-height: 1.7; margin: 16px 0 22px; }
.ac-modal-btns  { display: flex; gap: 10px; justify-content: flex-end; }
.ac-m-cancel {
    padding: 9px 18px; border-radius: 9px; cursor: pointer;
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.55); font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700; transition: all .18s;
}
.ac-m-cancel:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
.ac-m-delete {
    padding: 9px 20px; border-radius: 9px; cursor: pointer;
    background: linear-gradient(135deg, #ef4444, #f87171); border: none;
    color: #fff; font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(239,68,68,0.3); transition: all .18s;
}
.ac-m-delete:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(239,68,68,0.45); }
</style>
@endpush

<div style="padding: 0 0 60px;">

    {{-- Page Header --}}
    <div class="ac-page-header">
        <div>
            <h1 class="ac-page-title">Organization Management</h1>
            <p class="ac-page-sub">Manage all registered organizations</p>
        </div>
        <a href="{{ route('admin.organizations.create') }}" class="ac-btn ac-btn-primary">
            <i class="fas fa-plus" style="font-size:.62rem;"></i> Add Organization
        </a>
    </div>

    {{-- Toasts --}}
    @if(session('success'))
    <div class="ac-toast ac-toast-success"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-circle-check" style="flex-shrink:0;"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="ac-toast ac-toast-error"
         x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i> {{ session('error') }}
    </div>
    @endif

    {{-- Stats --}}
    @php
        $total           = $organizations->total();
        $totalCandidates = $organizations->sum('candidates_count');
        $collegesCount   = $organizations->groupBy('college_id')->count();
        $totalPositions  = \App\Models\Position::count();
    @endphp
    <div class="ac-stat-strip">
        <div class="ac-stat-card" style="animation-delay:.06s;">
            <div class="ac-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-sitemap" style="color:#f9b40f;"></i>
            </div>
            <div>
                <div class="ac-stat-num">{{ $total }}</div>
                <div class="ac-stat-lbl">Total Organizations</div>
            </div>
        </div>
        <div class="ac-stat-card" style="animation-delay:.1s;">
            <div class="ac-stat-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-list" style="color:#34d399;"></i>
            </div>
            <div>
                <div class="ac-stat-num" style="background:linear-gradient(135deg,#34d399,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $totalPositions }}</div>
                <div class="ac-stat-lbl">Total Positions</div>
            </div>
        </div>
        <div class="ac-stat-card" style="animation-delay:.14s;">
            <div class="ac-stat-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                <i class="fas fa-building" style="color:#60a5fa;"></i>
            </div>
            <div>
                <div class="ac-stat-num" style="background:linear-gradient(135deg,#60a5fa,#93c5fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $collegesCount }}</div>
                <div class="ac-stat-lbl">Colleges</div>
            </div>
        </div>
        <div class="ac-stat-card" style="animation-delay:.18s;">
            <div class="ac-stat-icon" style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);">
                <i class="fas fa-user-tie" style="color:#f87171;"></i>
            </div>
            <div>
                <div class="ac-stat-num" style="background:linear-gradient(135deg,#f87171,#fca5a5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $totalCandidates }}</div>
                <div class="ac-stat-lbl">Total Candidates</div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="ac-filter-bar">
        <form method="GET" action="{{ route('admin.organizations.index') }}" class="flex flex-wrap gap-2 items-end w-full">
            <div class="flex-1 min-w-[160px]">
                <label class="ac-filter-label">Search</label>
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:rgba(249,180,15,0.3);font-size:0.7rem;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Organization name..."
                           class="ac-input" style="padding-left:32px;width:100%;">
                </div>
            </div>

            <div class="flex-1 min-w-[140px]">
                <label class="ac-filter-label">College</label>
                <select name="college_id" class="ac-select" style="width:100%;">
                    <option value="">All Colleges</option>
                    @foreach(\App\Models\College::orderBy('name')->get() as $college)
                        <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>
                            {{ $college->acronym }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="ac-btn ac-btn-primary">
                    <i class="fas fa-filter" style="font-size:.62rem;"></i> Search
                </button>
                @if(request('search') || request('college_id'))
                    <a href="{{ route('admin.organizations.index') }}" class="ac-btn ac-btn-ghost">
                        <i class="fas fa-xmark" style="font-size:.62rem;"></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="ac-table-card">
        <table class="ac-table">
            <thead class="ac-thead">
                <tr>
                    <th>Organization</th>
                    <th>College</th>
                    <th style="text-align:center;">Candidates</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="ac-tbody">
                @forelse($organizations as $organization)
                <tr>
                    <td>
                        <a href="{{ route('admin.organizations.show', $organization) }}" style="display:flex;align-items:center;gap:10px;color:inherit;text-decoration:none;">
                            <div class="ac-avatar">
                                {{ strtoupper(substr($organization->acronym ?? $organization->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="ac-org-name">{{ $organization->name }}</div>
                                <div class="ac-org-desc">{{ $organization->acronym ?? '—' }}</div>
                            </div>
                        </a>
                    </td>
                    <td>
                        <span class="ac-college-badge">
                            {{ $organization->college?->acronym ?? '—' }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <span class="ac-count-badge">
                            <i class="fas fa-user-tie" style="font-size:.6rem;"></i>
                            {{ $organization->candidates_count ?? 0 }}
                        </span>
                    </td>
                    <td style="display:flex;justify-content:flex-end;gap:8px;">
                        <!-- <a href="{{ route('admin.organizations.show', $organization) }}" class="ac-action-btn sky" title="View">
                            <i class="fas fa-eye"></i>
                        </a> -->
                        <a href="{{ route('admin.organizations.edit', $organization) }}" class="ac-action-btn" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button type="button" @click="$dispatch('open-modal', 'delete-org-{{ $organization->id }}')" class="ac-action-btn danger" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>

                        {{-- Delete Modal --}}
                        <x-modal name="delete-org-{{ $organization->id }}" :show="false" maxWidth="sm">
                            <div class="ac-modal-wrap">
                                <div style="display:flex;gap:14px;margin-bottom:16px;">
                                    <div class="ac-modal-icon">
                                        <i class="fas fa-trash-can"></i>
                                    </div>
                                    <div style="flex:1;">
                                        <div class="ac-modal-title">Delete Organization?</div>
                                        <div class="ac-modal-sub">This action cannot be undone</div>
                                    </div>
                                </div>
                                <div class="ac-modal-body">
                                    Are you sure you want to delete <strong>{{ $organization->name }}</strong>? All associated data may be affected.
                                </div>
                                <div class="ac-modal-btns">
                                    <button class="ac-m-cancel" @click="$dispatch('close')">Cancel</button>
                                    <form method="POST" action="{{ route('admin.organizations.destroy', $organization) }}" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ac-m-delete">
                                            <i class="fas fa-trash" style="margin-right:6px;"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </x-modal>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="ac-empty">
                            <i class="fas fa-inbox ac-empty-icon"></i>
                            <div class="ac-empty-title">No Organizations Found</div>
                            <div class="ac-empty-sub">Start by creating your first organization</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($organizations->hasPages())
    <div class="ac-pagination">
        {{ $organizations->links() }}
    </div>
    @endif

</div>
</x-app-layout>