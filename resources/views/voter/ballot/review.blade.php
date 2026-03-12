<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
.ballot-wrap { max-width: 680px; margin: 36px auto; padding: 0 16px 60px; }

.ballot-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.2);
    border-radius: 20px;
    box-shadow: 0 8px 48px rgba(0,0,0,0.45), inset 0 1px 0 rgba(249,180,15,0.07);
    overflow: hidden;
    animation: fadeUp 0.4s ease both;
}
.ballot-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Header ── */
.review-header {
    padding: 32px 36px 0;
    display: flex; align-items: flex-start; gap: 16px;
}
.review-icon {
    width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.2);
    display: flex; align-items: center; justify-content: center;
    color: #f9b40f; font-size: 1.1rem;
}
.review-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem; font-weight: 900; color: #fffbf0; margin-bottom: 4px;
}
.review-sub { font-size: 0.72rem; color: rgba(255,251,240,0.45); line-height: 1.6; }

/* ── Summary pills ── */
.review-summary {
    display: flex; gap: 10px; padding: 20px 36px 0; flex-wrap: wrap;
}
.summary-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 99px; font-size: 0.65rem; font-weight: 700;
    letter-spacing: 0.05em;
}
.summary-pill.voted   { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
.summary-pill.skipped { background: rgba(255,251,240,0.05); border: 1px solid rgba(255,251,240,0.08); color: rgba(255,251,240,0.3); }

/* ── Review list ── */
.review-list { padding: 20px 36px; display: flex; flex-direction: column; gap: 8px; }

.review-row {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 16px; border-radius: 12px;
    border: 1px solid rgba(249,180,15,0.08);
    background: rgba(56,0,65,0.4);
    transition: all 0.18s;
}
.review-row.has-vote {
    border-color: rgba(52,211,153,0.15);
    background: rgba(52,211,153,0.03);
}
.review-row.is-skipped {
    opacity: 0.5;
}

.rv-status-dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
}
.rv-status-dot.voted   { background: #34d399; box-shadow: 0 0 6px rgba(52,211,153,0.5); }
.rv-status-dot.skipped { background: rgba(255,255,255,0.12); }

.rv-info { flex: 1; min-width: 0; }
.rv-position { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 2px; }
.rv-candidate { font-size: 0.8rem; font-weight: 700; color: #fffbf0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rv-candidate.skipped-label { color: rgba(255,251,240,0.25); font-style: italic; font-weight: 400; }
.rv-party { font-size: 0.62rem; color: rgba(249,180,15,0.4); margin-top: 1px; }

.rv-edit-btn {
    flex-shrink: 0; padding: 5px 12px; border-radius: 7px;
    border: 1px solid rgba(249,180,15,0.12); background: transparent;
    font-size: 0.62rem; font-weight: 600; color: rgba(249,180,15,0.45);
    cursor: pointer; transition: all 0.18s; text-decoration: none;
    font-family: 'DM Sans', sans-serif;
    display: inline-flex; align-items: center; gap: 5px;
}
.rv-edit-btn:hover {
    border-color: rgba(249,180,15,0.3); color: #f9b40f;
    background: rgba(249,180,15,0.06);
}

/* ── Warning ── */
.review-warning {
    margin: 0 36px 20px;
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: 10px;
    background: rgba(249,180,15,0.05); border: 1px solid rgba(249,180,15,0.12);
    font-size: 0.7rem; color: rgba(249,180,15,0.65); line-height: 1.6;
}

/* ── Footer ── */
.review-footer {
    padding: 20px 36px 32px;
    border-top: 1px solid rgba(249,180,15,0.07);
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    flex-wrap: wrap;
}
.btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 11px 22px; border-radius: 10px;
    font-size: 0.78rem; font-weight: 700;
    cursor: pointer; transition: all 0.18s; border: none;
    font-family: 'DM Sans', sans-serif; text-decoration: none;
}
.btn-submit {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 4px 16px rgba(249,180,15,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
}
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(249,180,15,0.45); }
.btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.2);
    color: rgba(249,180,15,0.65);
}
.btn-ghost:hover { background: rgba(249,180,15,0.07); color: #f9b40f; border-color: rgba(249,180,15,0.35); }

/* ── Confirm modal overlay ── */
.confirm-overlay {
    position: fixed; inset: 0; z-index: 999;
    background: rgba(10,0,15,0.8); backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    padding: 16px;
    animation: fadeIn 0.2s ease;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.confirm-box {
    background: rgba(26,0,32,0.98);
    border: 1px solid rgba(249,180,15,0.25);
    border-radius: 18px;
    padding: 36px 32px;
    max-width: 420px; width: 100%;
    text-align: center;
    box-shadow: 0 16px 60px rgba(0,0,0,0.6);
    animation: popIn 0.3s cubic-bezier(0.34,1.56,0.64,1) both;
}
@keyframes popIn {
    from { opacity: 0; transform: scale(0.88); }
    to   { opacity: 1; transform: scale(1); }
}
.confirm-box::before {
    content: ''; display: block; height: 2px; border-radius: 99px;
    background: linear-gradient(90deg, transparent, #f9b40f, transparent);
    margin: -36px -32px 28px;
}
.confirm-icon {
    width: 60px; height: 60px; border-radius: 50%;
    background: rgba(249,180,15,0.1); border: 2px solid rgba(249,180,15,0.25);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px; font-size: 1.5rem; color: #f9b40f;
}
.confirm-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem; font-weight: 900; color: #fffbf0; margin-bottom: 8px;
}
.confirm-body { font-size: 0.73rem; color: rgba(255,251,240,0.45); line-height: 1.7; margin-bottom: 24px; }
.confirm-btns { display: flex; gap: 10px; justify-content: center; }
.btn-confirm-yes {
    background: linear-gradient(135deg,#f9b40f,#fcd558); color: #380041;
    padding: 10px 28px; border-radius: 10px;
    font-size: 0.78rem; font-weight: 800; border: none; cursor: pointer;
    font-family: 'DM Sans', sans-serif; transition: all 0.18s;
}
.btn-confirm-yes:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(249,180,15,0.4); }
.btn-confirm-no {
    background: transparent; color: rgba(255,251,240,0.45);
    padding: 10px 22px; border-radius: 10px;
    font-size: 0.78rem; font-weight: 600; border: 1px solid rgba(255,255,255,0.08);
    cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all 0.18s;
}
.btn-confirm-no:hover { color: rgba(255,251,240,0.7); border-color: rgba(255,255,255,0.18); }

@media (max-width: 600px) {
    .review-header, .review-list, .review-warning, .review-footer { padding-left: 20px; padding-right: 20px; }
    .review-summary { padding: 16px 20px 0; }
}
</style>
@endpush

<div class="ballot-wrap" x-data="{ showConfirm: false }">

    @if(session('error'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.09);border:1px solid rgba(239,68,68,0.22);margin-bottom:16px;">
        <i class="fas fa-circle-exclamation" style="color:#f87171;flex-shrink:0;font-size:0.85rem;"></i>
        <span style="font-size:0.73rem;font-weight:600;color:#f87171;">{{ session('error') }}</span>
    </div>
    @endif

    <div class="ballot-card">

        {{-- Header --}}
        <div class="review-header">
            <div class="review-icon"><i class="fas fa-magnifying-glass-chart"></i></div>
            <div>
                <div class="review-title">Review Your Ballot</div>
                <div class="review-sub">
                    Check your selections carefully. You can go back and change any position before submitting.
                    Once confirmed, your vote is <strong style="color:#fcd558;">final and cannot be changed.</strong>
                </div>
            </div>
        </div>

        {{-- Summary pills --}}
        <div class="review-summary">
            <span class="summary-pill voted">
                <i class="fas fa-check-circle"></i>
                {{ $totalSelected }} selected
            </span>
            @if($totalSkipped > 0)
            <span class="summary-pill skipped">
                <i class="fas fa-forward"></i>
                {{ $totalSkipped }} skipped
            </span>
            @endif
        </div>

        {{-- Review list --}}
        <div class="review-list">
            @foreach($reviewRows as $idx => $row)
            <div class="review-row {{ !$row['skipped'] ? 'has-vote' : 'is-skipped' }}">

                <div class="rv-status-dot {{ !$row['skipped'] ? 'voted' : 'skipped' }}"></div>

                <div class="rv-info">
                    <div class="rv-position">{{ $row['position']->name }}</div>
                    @if(!$row['skipped'] && $row['candidate'])
                        <div class="rv-candidate">{{ $row['candidate']->full_name }}</div>
                        @if($row['candidate']->partylist)
                            <div class="rv-party">{{ $row['candidate']->partylist->name }}</div>
                        @endif
                    @else
                        <div class="rv-candidate skipped-label">Skipped — no vote recorded</div>
                    @endif
                </div>

                {{-- Go back to that specific step to change --}}
                <a href="{{ route('voter.vote.step', $idx + 1) }}" class="rv-edit-btn">
                    <i class="fas fa-pen" style="font-size:0.55rem;"></i> Change
                </a>

            </div>
            @endforeach
        </div>

        {{-- Warning --}}
        <div class="review-warning">
            <i class="fas fa-triangle-exclamation" style="color:#f9b40f;flex-shrink:0;margin-top:1px;font-size:0.82rem;"></i>
            <span>
                By clicking <strong style="color:#f9b40f;">Submit Ballot</strong>, you confirm that these are your final choices.
                This action is irreversible and your selections will be permanently recorded.
            </span>
        </div>

        {{-- Footer --}}
        <div class="review-footer">
            <a href="{{ route('voter.vote.step', count($reviewRows)) }}" class="btn btn-ghost">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <button type="button" class="btn btn-submit" @click="showConfirm = true">
                <i class="fas fa-paper-plane"></i> Submit Ballot
            </button>
        </div>

    </div>

    {{-- ── Confirm modal ── --}}
    <div class="confirm-overlay" x-show="showConfirm" x-cloak @click.self="showConfirm = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="confirm-box" @click.stop>
            <div class="confirm-icon"><i class="fas fa-seal-exclamation"></i></div>
            <div class="confirm-title">Seal Your Ballot?</div>
            <div class="confirm-body">
                You're about to officially submit your vote.
                <strong style="color:#fcd558;">This cannot be undone.</strong>
                Are you absolutely sure your selections are correct?
            </div>
            <div class="confirm-btns">
                <button class="btn-confirm-no" @click="showConfirm = false">Go Back</button>
                <form method="POST" action="{{ route('voter.vote.store') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-confirm-yes">
                        <i class="fas fa-check" style="font-size:0.75rem;"></i> Yes, Submit
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
</x-app-layout>