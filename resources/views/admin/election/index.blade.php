<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
.ec-wrap { max-width: 680px; margin: 40px auto; padding: 0 16px 60px; }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

.ec-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.2);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 48px rgba(0,0,0,0.45);
    animation: fadeUp 0.4s ease both;
    margin-bottom: 20px;
}
.ec-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
}

.ec-header { padding: 24px 28px 20px; border-bottom: 1px solid rgba(249,180,15,0.08); }
.ec-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem; font-weight: 900; color: #fffbf0;
}
.ec-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); margin-top: 4px; }

.ec-body { padding: 24px 28px; }

/* ── Current status badge ── */
.status-display {
    display: flex; align-items: center; gap: 14px;
    padding: 16px 20px; border-radius: 14px;
    margin-bottom: 24px;
}
.status-display.upcoming { background: rgba(249,180,15,0.07); border: 1px solid rgba(249,180,15,0.2); }
.status-display.ongoing  { background: rgba(52,211,153,0.07); border: 1px solid rgba(52,211,153,0.25); }
.status-display.ended    { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); }

.status-dot {
    width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0;
}
.status-dot.upcoming { background: #f9b40f; box-shadow: 0 0 8px rgba(249,180,15,0.6); }
.status-dot.ongoing  {
    background: #34d399;
    box-shadow: 0 0 8px rgba(52,211,153,0.6);
    animation: pulse-dot 1.5s ease-in-out infinite;
}
@keyframes pulse-dot {
    0%,100% { box-shadow: 0 0 6px rgba(52,211,153,0.5); }
    50%      { box-shadow: 0 0 18px rgba(52,211,153,1); }
}
.status-dot.ended { background: rgba(255,255,255,0.2); }

.status-label { font-size: 0.88rem; font-weight: 700; }
.status-label.upcoming { color: #f9b40f; }
.status-label.ongoing  { color: #34d399; }
.status-label.ended    { color: rgba(255,255,255,0.4); }
.status-hint { font-size: 0.65rem; color: rgba(255,251,240,0.35); margin-top: 2px; }

/* ── Status buttons ── */
.status-section-title {
    font-size: 0.62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5); margin-bottom: 12px;
}

.status-btns { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 24px; }

.status-btn {
    flex: 1; min-width: 140px;
    padding: 14px 18px; border-radius: 12px; border: none; cursor: pointer;
    font-size: 0.78rem; font-weight: 700; font-family: 'DM Sans', sans-serif;
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    transition: all 0.2s;
}
.status-btn i { font-size: 1.1rem; }

.btn-upcoming {
    background: rgba(249,180,15,0.1); border: 2px solid rgba(249,180,15,0.25);
    color: rgba(249,180,15,0.8);
}
.btn-upcoming:hover, .btn-upcoming.active {
    background: rgba(249,180,15,0.18); border-color: #f9b40f;
    color: #f9b40f; transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(249,180,15,0.2);
}
.btn-upcoming.active { box-shadow: 0 0 0 2px rgba(249,180,15,0.4); }

.btn-ongoing {
    background: rgba(52,211,153,0.1); border: 2px solid rgba(52,211,153,0.25);
    color: rgba(52,211,153,0.8);
}
.btn-ongoing:hover, .btn-ongoing.active {
    background: rgba(52,211,153,0.18); border-color: #34d399;
    color: #34d399; transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52,211,153,0.2);
}
.btn-ongoing.active { box-shadow: 0 0 0 2px rgba(52,211,153,0.4); }

.btn-ended {
    background: rgba(255,255,255,0.04); border: 2px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.4);
}
.btn-ended:hover, .btn-ended.active {
    background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.25);
    color: rgba(255,255,255,0.7); transform: translateY(-2px);
}
.btn-ended.active { box-shadow: 0 0 0 2px rgba(255,255,255,0.15); }

/* ── Election name form ── */
.name-row {
    display: flex; gap: 10px; align-items: flex-end;
}
.name-input-wrap { flex: 1; }
.field-label {
    display: block; font-size: 0.62rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: rgba(249,180,15,0.5); margin-bottom: 6px;
}
.field-input {
    width: 100%; padding: 10px 14px; border-radius: 10px;
    background: rgba(56,0,65,0.5); border: 1px solid rgba(249,180,15,0.15);
    color: #fffbf0; font-size: 0.82rem; font-family: 'DM Sans', sans-serif;
    transition: border-color 0.18s;
    outline: none;
}
.field-input:focus { border-color: rgba(249,180,15,0.45); }
.save-btn {
    padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer;
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    font-size: 0.78rem; font-weight: 700; font-family: 'DM Sans', sans-serif;
    transition: all 0.18s; white-space: nowrap;
}
.save-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(249,180,15,0.35); }

/* ── Alert ── */
.alert-success {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 18px; border-radius: 12px;
    background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2);
    font-size: 0.73rem; font-weight: 600; color: #34d399;
    margin-bottom: 20px; animation: fadeUp 0.3s ease;
}

/* ── Warning box ── */
.warning-box {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: 10px;
    background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.15);
    font-size: 0.68rem; color: rgba(248,113,113,0.8); line-height: 1.65;
}
</style>
@endpush

<div class="ec-wrap">

    {{-- Page heading --}}
    <div style="margin-bottom:20px;animation:fadeUp 0.3s ease both;">
        <div style="font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:900;color:#fffbf0;">
            Election Control Panel
        </div>
        <div style="font-size:0.72rem;color:rgba(255,251,240,0.4);margin-top:3px;">
            Manage the election lifecycle visible to voters and the public.
        </div>
    </div>

    {{-- Success flash --}}
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Status Control Card ── --}}
    <div class="ec-card">
        <div class="ec-header">
            <div class="ec-title">Election Status</div>
            <div class="ec-sub">Controls what voters and the public see on the welcome page.</div>
        </div>
        <div class="ec-body">

            {{-- Current status display --}}
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

            {{-- Status buttons --}}
            <div class="status-section-title">Set New Status</div>
            <div class="status-btns">

                <form method="POST" action="{{ route('admin.election.status') }}" style="flex:1;min-width:140px;display:contents;">
                    @csrf
                    <input type="hidden" name="status" value="upcoming">
                    <button type="submit"
                            class="status-btn btn-upcoming {{ $status === 'upcoming' ? 'active' : '' }}">
                        <i class="fas fa-hourglass-start"></i>
                        <span>Upcoming</span>
                        <span style="font-size:0.6rem;opacity:0.65;font-weight:400;">Election Soon</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.election.status') }}" style="flex:1;min-width:140px;display:contents;">
                    @csrf
                    <input type="hidden" name="status" value="ongoing">
                    <button type="submit"
                            class="status-btn btn-ongoing {{ $status === 'ongoing' ? 'active' : '' }}">
                        <i class="fas fa-circle-dot"></i>
                        <span>Ongoing</span>
                        <span style="font-size:0.6rem;opacity:0.65;font-weight:400;">Election Live</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.election.status') }}" style="flex:1;min-width:140px;display:contents;">
                    @csrf
                    <input type="hidden" name="status" value="ended">
                    <button type="submit"
                            class="status-btn btn-ended {{ $status === 'ended' ? 'active' : '' }}">
                        <i class="fas fa-flag-checkered"></i>
                        <span>Ended</span>
                        <span style="font-size:0.6rem;opacity:0.65;font-weight:400;">Election Done</span>
                    </button>
                </form>

            </div>

            {{-- Warning --}}
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

    {{-- ── Election Name Card ── --}}
    <div class="ec-card">
        <div class="ec-header">
            <div class="ec-title">Election Name</div>
            <div class="ec-sub">Displayed on the public welcome page and voter dashboard.</div>
        </div>
        <div class="ec-body">
            <form method="POST" action="{{ route('admin.election.name') }}">
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

</div>
</x-app-layout>