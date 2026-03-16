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
.ac-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; margin-bottom: 28px; flex-wrap: wrap;
    animation: fadeUp .3s ease both;
}
.ac-page-header-left { display: flex; align-items: center; gap: 14px; }
.ac-back-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
    border: 1px solid rgba(249,180,15,0.2); background: transparent;
    font-size: 0.72rem; color: rgba(249,180,15,0.6);
    text-decoration: none; transition: all .18s;
}
.ac-back-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.06); }
.ac-page-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:#fffbf0; margin:0; }
.ac-page-sub   { font-size:0.72rem; color:rgba(255,251,240,0.4); margin-top:3px; }
.ac-page-sub strong { color:rgba(249,180,15,0.7); }

/* ── Toast ── */
.ac-toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 600;
    background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34d399;
    animation: fadeUp .35s ease both;
}

/* ── Grid ── */
.ac-grid {
    display: grid; grid-template-columns: 280px 1fr; gap: 16px; align-items: start;
}
@media (max-width: 860px) { .ac-grid { grid-template-columns: 1fr; } }

/* ── Glass card ── */
.ac-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
    animation: fadeUp .4s ease both;
    margin-bottom: 16px;
}
.ac-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}
.ac-card:last-child { margin-bottom: 0; }

/* ── Profile card ── */
.ac-profile-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
    padding: 28px 24px 24px;
    text-align: center;
    margin-bottom: 16px;
    animation: fadeUp .4s ease both;
}
.ac-profile-card::before {
    content: ''; display: block; height: 2px; margin: -28px -24px 24px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

.ac-profile-avatar {
    width: 96px; height: 96px; border-radius: 20px; margin: 0 auto 14px;
    background: linear-gradient(135deg, rgba(56,0,65,0.8), rgba(82,0,96,0.8));
    border: 2px solid rgba(249,180,15,0.3);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif; font-size: 2.4rem; font-weight: 900; color: #f9b40f;
    overflow: hidden;
}
.ac-profile-name {
    font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 900;
    color: #fffbf0; margin-bottom: 4px;
}
.ac-profile-pos { font-size: 0.72rem; color: rgba(249,180,15,0.6); margin-bottom: 20px; }
.ac-profile-divider { height: 1px; background: rgba(249,180,15,0.1); margin: 0 0 16px; }

.ac-profile-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 9px 16px; border-radius: 10px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; text-decoration: none; border: none;
    margin-bottom: 8px;
}
.ac-profile-btn:last-child { margin-bottom: 0; }
.ac-profile-btn-sky    { background:transparent; border:1px solid rgba(96,165,250,0.25); color:rgba(96,165,250,0.7); }
.ac-profile-btn-sky:hover { background:rgba(96,165,250,0.08); border-color:rgba(96,165,250,0.5); color:#93c5fd; }
.ac-profile-btn-danger { background:transparent; border:1px solid rgba(248,113,113,0.25); color:rgba(248,113,113,0.7); }
.ac-profile-btn-danger:hover { background:rgba(248,113,113,0.08); border-color:rgba(248,113,113,0.5); color:#f87171; }

/* ── Info cards ── */
.ac-info-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 16px; padding: 18px 20px;
    margin-bottom: 12px; animation: fadeUp .42s ease both;
}
.ac-info-card:last-child { margin-bottom: 0; }
.ac-info-title {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5);
    display: flex; align-items: center; gap: 7px; margin-bottom: 14px;
}
.ac-info-row { margin-bottom: 10px; }
.ac-info-row:last-child { margin-bottom: 0; }
.ac-info-key { font-size: 0.58rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(249,180,15,0.4); margin-bottom: 3px; }
.ac-info-val { font-size: 0.78rem; color: rgba(255,251,240,0.85); font-weight: 500; }

/* ── Stats row ── */
.ac-stats-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
.ac-stat-tile {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 16px; padding: 20px;
    animation: fadeUp .42s ease both;
}
.ac-stat-tile-label {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5); margin-bottom: 8px;
}
.ac-stat-tile-num {
    font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, #f9b40f, #fcd558);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.ac-stat-tile-icon {
    float: right; width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
}

/* ── Platform card ── */
.ac-platform-text {
    font-size: 0.82rem; color: rgba(255,251,240,0.65); line-height: 1.8;
    white-space: pre-wrap;
}

/* ── Votes table card ── */
.ac-table-head {
    padding: 18px 24px 14px;
    border-bottom: 1px solid rgba(249,180,15,0.08);
    background: linear-gradient(to right, rgba(56,0,65,0.4), transparent);
    display: flex; align-items: center; gap: 10px;
}
.ac-table-head-title {
    font-family: 'Playfair Display', serif; font-size: 0.95rem; font-weight: 800; color: #fffbf0;
}

.ac-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.ac-thead-row {
    background: linear-gradient(to right, rgba(56,0,65,0.4), transparent);
    border-bottom: 1px solid rgba(249,180,15,0.1);
}
.ac-thead-row th {
    padding: 12px 24px; text-align: left;
    font-size: 0.58rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5);
}
.ac-tbody-row { border-bottom: 1px solid rgba(249,180,15,0.07); transition: background .18s; }
.ac-tbody-row:last-child { border-bottom: none; }
.ac-tbody-row:hover { background: rgba(249,180,15,0.04); }
.ac-tbody-row td { padding: 13px 24px; color: rgba(255,251,240,0.8); vertical-align: middle; }

.ac-txn-code {
    font-family: monospace; font-size: 0.72rem;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.15);
    color: rgba(249,180,15,0.75); padding: 3px 10px; border-radius: 6px;
}

/* ── Empty state ── */
.ac-empty { padding: 40px 24px; text-align: center; }
.ac-empty-icon  { font-size: 2rem; color: rgba(249,180,15,0.1); margin-bottom: 10px; display: block; }
.ac-empty-title { font-family: 'Playfair Display', serif; font-size: 0.9rem; font-weight: 800; color: rgba(255,251,240,0.3); }

/* ── Btn ── */
.ac-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 20px; border-radius: 10px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; text-decoration: none; border: none;
}
.ac-btn-ghost { background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.6); }
.ac-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; border-color: rgba(249,180,15,0.4); }

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

{{-- Toast --}}
@if(session('success'))
<div class="ac-toast"
     x-data="{ show: true }" x-show="show"
     x-init="setTimeout(() => show = false, 4000)"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <i class="fas fa-circle-check" style="flex-shrink:0;"></i>
    {{ session('success') }}
</div>
@endif

{{-- Page Header --}}
<div class="ac-page-header">
    <div class="ac-page-header-left">
        <a href="{{ route('admin.candidates.index') }}" class="ac-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="ac-page-title">Candidate Profile</div>
            <div class="ac-page-sub">Viewing details for <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong></div>
        </div>
    </div>
    <a href="{{ route('admin.candidates.edit', $candidate) }}" class="ac-btn ac-btn-ghost">
        <i class="fas fa-pen" style="font-size:.65rem;"></i> Edit
    </a>
</div>

<div class="ac-grid">

    {{-- Left column ── --}}
    <div>
        {{-- Profile card --}}
        <div class="ac-profile-card">
            <div class="ac-profile-avatar">
                @if($candidate->photo)
                    <img src="{{ asset('images/candidates/' . $candidate->photo) }}"
                         alt="{{ $candidate->first_name }}"
                         style="width:100%;height:100%;object-fit:cover;">
                @else
                    {{ strtoupper(substr($candidate->first_name, 0, 1)) }}
                @endif
            </div>
            <div class="ac-profile-name">
                {{ $candidate->first_name }} {{ $candidate->middle_name ? $candidate->middle_name . ' ' : '' }}{{ $candidate->last_name }}
            </div>
            <div class="ac-profile-pos">{{ $candidate->position?->name ?? 'No position assigned' }}</div>
            <div class="ac-profile-divider"></div>
            <a href="{{ route('admin.candidates.edit', $candidate) }}" class="ac-profile-btn ac-profile-btn-sky">
                <i class="fas fa-pen" style="font-size:.65rem;"></i> Edit Candidate
            </a>
            <button type="button" class="ac-profile-btn ac-profile-btn-danger"
                    @click="$dispatch('open-modal', 'delete-candidate')">
                <i class="fas fa-trash" style="font-size:.65rem;"></i> Delete Candidate
            </button>
        </div>

        {{-- Academic info --}}
        <div class="ac-info-card">
            <div class="ac-info-title">
                <i class="fas fa-graduation-cap" style="color:#60a5fa;font-size:.7rem;"></i>
                Academic Info
            </div>
            <div class="ac-info-row">
                <div class="ac-info-key">College</div>
                <div class="ac-info-val">{{ $candidate->college?->name ?? '—' }}</div>
            </div>
            <div class="ac-info-row">
                <div class="ac-info-key">Course</div>
                <div class="ac-info-val">{{ $candidate->course ?? '—' }}</div>
            </div>
        </div>

        {{-- Election info --}}
        <div class="ac-info-card">
            <div class="ac-info-title">
                <i class="fas fa-vote-yea" style="color:#34d399;font-size:.7rem;"></i>
                Election Info
            </div>
            <div class="ac-info-row">
                <div class="ac-info-key">Position</div>
                <div class="ac-info-val">{{ $candidate->position?->name ?? '—' }}</div>
            </div>
            <div class="ac-info-row">
                <div class="ac-info-key">Party List</div>
                <div class="ac-info-val">{{ $candidate->partylist?->name ?? '—' }}</div>
            </div>
            <div class="ac-info-row">
                <div class="ac-info-key">Organization</div>
                <div class="ac-info-val">{{ $candidate->organization?->name ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Right column ── --}}
    <div>

        {{-- Stats row --}}
        <div class="ac-stats-row">
            <div class="ac-stat-tile">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div class="ac-stat-tile-label">Total Votes</div>
                        <div class="ac-stat-tile-num">{{ $candidate->votes()->count() }}</div>
                    </div>
                    <div class="ac-stat-tile-icon"
                         style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                        <i class="fas fa-vote-yea" style="color:#60a5fa;"></i>
                    </div>
                </div>
            </div>
            <div class="ac-stat-tile">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                    <div>
                        <div class="ac-stat-tile-label">Created</div>
                        <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:800;color:#f9b40f;margin-top:4px;">
                            {{ $candidate->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    <div class="ac-stat-tile-icon"
                         style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                        <i class="fas fa-calendar" style="color:#f9b40f;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Platform --}}
        @if($candidate->platform)
        <div class="ac-card" style="animation-delay:.1s;">
            <div style="padding:18px 24px 14px;border-bottom:1px solid rgba(249,180,15,0.08);
                        background:linear-gradient(to right,rgba(56,0,65,0.4),transparent);
                        display:flex;align-items:center;gap:10px;">
                <i class="fas fa-microphone" style="color:#f87171;font-size:0.75rem;"></i>
                <span style="font-family:'Playfair Display',serif;font-size:0.95rem;font-weight:800;color:#fffbf0;">Campaign Platform</span>
            </div>
            <div style="padding:20px 24px;">
                <p class="ac-platform-text">{{ $candidate->platform }}</p>
            </div>
        </div>
        @endif

        {{-- Recent Votes table --}}
        <div class="ac-card" style="animation-delay:.14s;">
            <div class="ac-table-head">
                <i class="fas fa-list" style="color:rgba(249,180,15,0.6);font-size:0.75rem;"></i>
                <span class="ac-table-head-title">
                    Recent Votes
                    <span style="font-family:'DM Sans',sans-serif;font-size:0.7rem;font-weight:400;color:rgba(255,251,240,0.35);margin-left:6px;">
                        ({{ $candidate->votes()->count() }})
                    </span>
                </span>
            </div>

            @if($candidate->votes()->exists())
            <div style="overflow-x:auto;">
                <table class="ac-table">
                    <thead>
                        <tr class="ac-thead-row">
                            <th>Transaction</th>
                            <th>Voter</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidate->votes()->with('voter')->latest('voted_at')->take(10)->get() as $vote)
                        <tr class="ac-tbody-row">
                            <td>
                                <span class="ac-txn-code">{{ $vote->transaction_number ?? '—' }}</span>
                            </td>
                            <td style="font-weight:500;color:#fffbf0;">
                                {{ $vote->voter ? $vote->voter->full_name : 'Anonymous' }}
                            </td>
                            <td style="font-size:0.72rem;color:rgba(249,180,15,0.6);">
                                {{ $vote->voted_at?->format('M d, Y H:i') ?? '—' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($candidate->votes()->count() > 10)
            <div style="padding:10px 24px;border-top:1px solid rgba(249,180,15,0.08);
                        font-size:0.68rem;color:rgba(249,180,15,0.5);text-align:center;">
                Showing 10 of {{ $candidate->votes()->count() }} votes
            </div>
            @endif
            @else
            <div class="ac-empty">
                <i class="fas fa-inbox ac-empty-icon"></i>
                <div class="ac-empty-title">No votes yet</div>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Delete Modal --}}
<x-modal name="delete-candidate" focusable>
    <div class="ac-modal-wrap">
        <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:4px;">
            <div class="ac-modal-icon"><i class="fas fa-user-slash"></i></div>
            <div>
                <div class="ac-modal-title">Delete Candidate</div>
                <div class="ac-modal-sub">This action cannot be undone.</div>
            </div>
        </div>
        <p class="ac-modal-body">
            Are you sure you want to delete
            <strong style="color:#fffbf0;">{{ $candidate->first_name }} {{ $candidate->last_name }}</strong>?
            All associated data will be removed.
        </p>
        <div class="ac-modal-btns">
            <button class="ac-m-cancel" x-on:click="$dispatch('close')">Cancel</button>
            <form method="POST" action="{{ route('admin.candidates.destroy', $candidate) }}" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="ac-m-delete">
                    <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete
                </button>
            </form>
        </div>
    </div>
</x-modal>

</x-app-layout>