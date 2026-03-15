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
.afb-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem; font-weight: 900; color: #fffbf0; margin: 0 0 3px;
}
.afb-page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); margin: 0 0 24px; }

/* ── Glass card base ── */
.afb-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow: hidden;
}
.afb-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

/* ── Stat strip ── */
.afb-stat-strip {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 14px; margin-bottom: 16px;
}
@media (max-width: 560px) { .afb-stat-strip { grid-template-columns: 1fr 1fr; } }

.afb-stat-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 16px; padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: inset 0 1px 0 rgba(249,180,15,0.05);
    animation: fadeUp .4s ease both;
}
.afb-stat-icon {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 0.92rem;
}
.afb-stat-num {
    font-family: 'Playfair Display', serif; font-size: 1.55rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, #f9b40f, #fcd558, #fff3c4);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.afb-stat-num.green {
    background: linear-gradient(135deg, #34d399, #6ee7b7);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.afb-stat-lbl {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.45); margin-top: 3px;
}

/* ── Top row: overall + breakdown ── */
.afb-top-row {
    display: grid; grid-template-columns: 280px 1fr;
    gap: 16px; margin-bottom: 16px;
}
@media (max-width: 720px) { .afb-top-row { grid-template-columns: 1fr; } }

.afb-overall-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px; padding: 28px 24px;
    display: flex; flex-direction: column; align-items: center;
    text-align: center;
    box-shadow: inset 0 1px 0 rgba(249,180,15,0.06);
    animation: fadeUp .42s ease both;
}
.afb-section-label {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5);
}
.afb-big-num {
    font-family: 'Playfair Display', serif;
    font-size: 5.5rem; font-weight: 900; line-height: 1; margin: 6px 0;
    background: linear-gradient(135deg, #f9b40f 0%, #fcd558 55%, #fff3c4 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.afb-stars-row { display: flex; gap: 5px; margin-bottom: 6px; }
.afb-s-fill  { font-size: 1.25rem; color: #f9b40f; text-shadow: 0 0 8px rgba(249,180,15,0.5); }
.afb-s-half  { font-size: 1.25rem; color: rgba(249,180,15,0.5); }
.afb-s-empty { font-size: 1.25rem; color: rgba(249,180,15,0.12); }
.afb-review-count { font-size: 0.7rem; color: rgba(255,251,240,0.35); margin-bottom: 16px; }

.afb-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 99px; font-size: 0.62rem; font-weight: 700;
}
.afb-pill-green { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: #34d399; }
.afb-pill-gold  { background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.18); color: rgba(249,180,15,0.8); }

.afb-breakdown-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px; padding: 24px 28px;
    box-shadow: inset 0 1px 0 rgba(249,180,15,0.06);
    animation: fadeUp .44s ease both;
}
.afb-bar-row { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
.afb-bar-row:last-child { margin-bottom: 0; }
.afb-bar-lbl {
    width: 38px; text-align: right; flex-shrink: 0;
    font-size: 0.7rem; font-weight: 700; color: rgba(255,251,240,0.5);
    display: flex; align-items: center; gap: 3px; justify-content: flex-end;
}
.afb-bar-lbl i { font-size: 0.6rem; color: #f9b40f; }
.afb-bar-track { flex: 1; height: 8px; border-radius: 99px; background: rgba(249,180,15,0.07); overflow: hidden; }
.afb-bar-fill  { height: 100%; border-radius: 99px; transition: width 1s cubic-bezier(.4,0,.2,1); }
.afb-bar-fill.c5 { background: linear-gradient(90deg, #34d399, #6ee7b7); }
.afb-bar-fill.c4 { background: linear-gradient(90deg, #f9b40f, #fcd558); }
.afb-bar-fill.c3 { background: linear-gradient(90deg, #fb923c, #fbbf24); }
.afb-bar-fill.c2 { background: linear-gradient(90deg, #f87171, #fb923c); }
.afb-bar-fill.c1 { background: linear-gradient(90deg, #ef4444, #f87171); }
.afb-bar-count  { width: 56px; flex-shrink: 0; text-align: right; font-size: 0.67rem; font-weight: 700; color: rgba(255,251,240,0.3); }

/* ── Filter bar ── */
.afb-filter-bar {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.14);
    border-radius: 14px; padding: 16px 20px;
    margin-bottom: 18px;
    display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;
    animation: fadeUp .46s ease both;
}
.afb-filter-label {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 6px;
}
.afb-input {
    background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
    border-radius: 9px; padding: 8px 12px 8px 32px;
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem; color: #fffbf0;
    outline: none; width: 100%; transition: border-color .2s, box-shadow .2s;
}
.afb-input::placeholder { color: rgba(255,251,240,0.2); }
.afb-input:focus { border-color: rgba(249,180,15,0.4); box-shadow: 0 0 0 3px rgba(249,180,15,0.06); }
.afb-select {
    background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
    border-radius: 9px; padding: 8px 28px 8px 12px;
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem; color: #fffbf0;
    outline: none; width: 100%; transition: border-color .2s;
    -webkit-appearance: none; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(249,180,15,0.5)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
}
.afb-select:focus { border-color: rgba(249,180,15,0.4); }
.afb-select option { background: #1a0020; }

.afb-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px; border-radius: 9px;
    font-family: 'DM Sans', sans-serif; font-size: 0.75rem; font-weight: 700;
    cursor: pointer; transition: all .18s; border: none; white-space: nowrap;
    text-decoration: none;
}
.afb-btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 3px 12px rgba(249,180,15,0.3);
}
.afb-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(249,180,15,0.45); }
.afb-btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.55);
}
.afb-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }

/* ── Feedback cards ── */
.afb-feedback-card {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 18px; overflow: hidden; margin-bottom: 14px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3), inset 0 1px 0 rgba(249,180,15,0.05);
    transition: border-color .2s, box-shadow .2s;
    animation: fadeUp .4s ease both;
}
.afb-feedback-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, rgba(249,180,15,0.3), transparent);
}
.afb-feedback-card:hover {
    border-color: rgba(249,180,15,0.3);
    box-shadow: 0 8px 36px rgba(0,0,0,0.4), inset 0 1px 0 rgba(249,180,15,0.08);
}
.afb-card-body { padding: 20px 24px 18px; }

.afb-avatar {
    width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg, #380041, #520060);
    border: 1px solid rgba(249,180,15,0.25);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 900; color: #f9b40f;
}
.afb-voter-name {
    font-family: 'Playfair Display', serif;
    font-size: 0.98rem; font-weight: 800; color: #fffbf0;
}
.afb-voter-email { font-size: 0.68rem; color: rgba(249,180,15,0.5); margin-top: 2px; }
.afb-voter-meta  { font-size: 0.65rem; color: rgba(255,251,240,0.28); margin-top: 2px; }

/* Rating badge */
.afb-rating-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 99px; font-size: 0.72rem; font-weight: 800;
}
.rb-high { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.25); color: #34d399; }
.rb-mid  { background: rgba(251,146,60,0.1); border: 1px solid rgba(251,146,60,0.25); color: #fb923c; }
.rb-low  { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.25); color: #f87171; }

/* Stars in card */
.afb-card-stars { display: flex; gap: 4px; align-items: center; margin: 12px 0; }
.cs-fill  { font-size: 1.05rem; color: #f9b40f; text-shadow: 0 0 8px rgba(249,180,15,0.45); }
.cs-empty { font-size: 1.05rem; color: rgba(249,180,15,0.12); }
.cs-lbl   { font-size: 0.67rem; font-weight: 700; color: rgba(255,251,240,0.35); margin-left: 6px; }

/* Quote box */
.afb-quote-box {
    background: rgba(56,0,65,0.4); border: 1px solid rgba(249,180,15,0.1);
    border-radius: 12px; padding: 14px 18px; position: relative; overflow: hidden;
}
.afb-qmark-open {
    position: absolute; top: -6px; left: 10px;
    font-family: 'Playfair Display', serif; font-size: 4.5rem; font-weight: 900;
    line-height: 1; color: rgba(249,180,15,0.05); pointer-events: none; user-select: none;
}
.afb-qmark-close {
    position: absolute; bottom: -18px; right: 10px;
    font-family: 'Playfair Display', serif; font-size: 4.5rem; font-weight: 900;
    line-height: 1; color: rgba(249,180,15,0.05); pointer-events: none; user-select: none;
}
.afb-quote-text {
    font-size: 0.82rem; color: rgba(255,251,240,0.65); line-height: 1.75;
    font-style: italic; position: relative; z-index: 1; padding: 0 4px;
}

/* Card footer */
.afb-card-footer {
    display: flex; align-items: center; justify-content: space-between;
    gap: 10px; padding: 11px 24px 13px;
    border-top: 1px solid rgba(249,180,15,0.07); flex-wrap: wrap;
}
.afb-date-text { font-size: 0.63rem; color: rgba(255,251,240,0.27); display: flex; align-items: center; gap: 5px; }
.afb-actions   { display: flex; gap: 6px; }

.afb-action-btn {
    width: 32px; height: 32px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid rgba(249,180,15,0.15); background: transparent;
    color: rgba(249,180,15,0.5); font-size: 0.68rem;
    cursor: pointer; transition: all .18s; text-decoration: none;
}
.afb-action-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.06); }
.afb-action-btn.danger { border-color: rgba(248,113,113,0.2); color: rgba(248,113,113,0.5); }
.afb-action-btn.danger:hover { border-color: rgba(248,113,113,0.45); color: #f87171; background: rgba(248,113,113,0.06); }

/* ── Empty state ── */
.afb-empty {
    background: rgba(26,0,32,0.88);
    border: 1px solid rgba(249,180,15,0.12);
    border-radius: 18px; padding: 60px 24px; text-align: center;
    animation: fadeUp .4s ease both;
}
.afb-empty-icon  { font-size: 2.5rem; color: rgba(249,180,15,0.1); margin-bottom: 14px; display: block; }
.afb-empty-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 800; color: rgba(255,251,240,0.35); margin-bottom: 6px; }
.afb-empty-sub   { font-size: 0.72rem; color: rgba(255,251,240,0.2); }

/* ── Delete modal ── */
.afb-modal-wrap  { padding: 28px; background: rgba(26,0,32,0.98); }
.afb-modal-icon  {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #f87171;
}
.afb-modal-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; margin-bottom: 3px; }
.afb-modal-sub   { font-size: 0.7rem; color: rgba(255,251,240,0.4); }
.afb-modal-body  { font-size: 0.75rem; color: rgba(255,251,240,0.5); line-height: 1.7; margin: 16px 0 22px; }
.afb-modal-btns  { display: flex; gap: 10px; justify-content: flex-end; }
.afb-m-cancel {
    padding: 9px 18px; border-radius: 9px; cursor: pointer;
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.55); font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700; transition: all .18s;
}
.afb-m-cancel:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
.afb-m-delete {
    padding: 9px 20px; border-radius: 9px; cursor: pointer;
    background: linear-gradient(135deg, #ef4444, #f87171); border: none;
    color: #fff; font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(239,68,68,0.3); transition: all .18s;
}
.afb-m-delete:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(239,68,68,0.45); }

/* ── Toast ── */
.afb-toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;
    background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2);
    font-size: 0.75rem; font-weight: 600; color: #34d399;
    animation: fadeUp .35s ease both;
}

@media (max-width: 600px) {
    .afb-card-body   { padding: 16px 16px 14px; }
    .afb-card-footer { padding: 10px 16px 12px; }
}
</style>
@endpush

<div style="padding: 0 0 60px;">

    <h1 class="afb-page-title">Feedback &amp; Reviews</h1>
    <p class="afb-page-sub">Track ratings and voter reviews to improve the election experience</p>

    {{-- Success toast --}}
    @if(session('success'))
    <div class="afb-toast" x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <i class="fas fa-circle-check" style="flex-shrink:0;"></i>
        {{ session('success') }}
    </div>
    @endif

    @php
        $total     = $feedbacks->total();
        $avgRating = round($averageRating, 1);
        $ratingLabels = [1=>'Poor', 2=>'Fair', 3=>'Good', 4=>'Great', 5=>'Excellent'];
    @endphp

    {{-- ── Stat strip ── --}}
    <div class="afb-stat-strip">
        <div class="afb-stat-card" style="animation-delay:.06s;">
            <div class="afb-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-comments" style="color:#f9b40f;"></i>
            </div>
            <div>
                <div class="afb-stat-num">{{ $total }}</div>
                <div class="afb-stat-lbl">Total Feedback</div>
            </div>
        </div>
        <div class="afb-stat-card" style="animation-delay:.1s;">
            <div class="afb-stat-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-star" style="color:#f9b40f;"></i>
            </div>
            <div>
                <div class="afb-stat-num">{{ number_format($avgRating, 1) }}</div>
                <div class="afb-stat-lbl">Average Rating</div>
            </div>
        </div>
        <div class="afb-stat-card" style="animation-delay:.14s;">
            <div class="afb-stat-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                <i class="fas fa-heart" style="color:#34d399;"></i>
            </div>
            <div>
                <div class="afb-stat-num green">{{ $ratingCounts->get(5, 0) }}</div>
                <div class="afb-stat-lbl">Five-Star Ratings</div>
            </div>
        </div>
    </div>

    {{-- ── Overall + Breakdown ── --}}
    <div class="afb-top-row">

        <div class="afb-overall-card">
            <div class="afb-section-label" style="margin-bottom:4px;">Overall Rating</div>
            <div class="afb-big-num">{{ number_format($avgRating, 1) }}</div>

            <div class="afb-stars-row">
                @php $rounded = round($avgRating * 2) / 2; @endphp
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($rounded))
                        <span class="afb-s-fill">★</span>
                    @elseif($i - 0.5 == $rounded)
                        <span class="afb-s-half">★</span>
                    @else
                        <span class="afb-s-empty">★</span>
                    @endif
                @endfor
            </div>

            <div class="afb-review-count">
                Based on <strong style="color:rgba(249,180,15,0.7);">{{ $total }}</strong>
                review{{ $total !== 1 ? 's' : '' }}
            </div>

            <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center;">
                <span class="afb-pill afb-pill-green">
                    <i class="fas fa-heart" style="font-size:.5rem;"></i>
                    {{ $ratingCounts->get(5, 0) }} five-star
                </span>
                <span class="afb-pill afb-pill-gold">
                    <i class="fas fa-comments" style="font-size:.5rem;"></i>
                    {{ $total }} total
                </span>
            </div>
        </div>

        <div class="afb-breakdown-card">
            <div class="afb-section-label" style="margin-bottom:18px;">Rating Distribution</div>
            @php $barClass = [5=>'c5', 4=>'c4', 3=>'c3', 2=>'c2', 1=>'c1']; @endphp
            @foreach([5, 4, 3, 2, 1] as $star)
            @php
                $cnt = $ratingCounts->get($star, 0) ?? 0;
                $pct = $total > 0 ? round(($cnt / $total) * 100) : 0;
            @endphp
            <div class="afb-bar-row">
                <div class="afb-bar-lbl">{{ $star }} <i class="fas fa-star"></i></div>
                <div class="afb-bar-track">
                    <div class="afb-bar-fill {{ $barClass[$star] }}" style="width:{{ $pct }}%"></div>
                </div>
                <div class="afb-bar-count">{{ $cnt }} <span style="color:rgba(255,251,240,0.18);">({{ $pct }}%)</span></div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Filter bar ── --}}
    <div class="afb-filter-bar">
        <form method="GET" action="{{ route('admin.feedback.index') }}"
              style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;width:100%;">

            <div style="flex:1;min-width:180px;">
                <div class="afb-filter-label">Search</div>
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:0.6rem;color:rgba(249,180,15,0.35);pointer-events:none;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Name, email or feedback…" class="afb-input">
                </div>
            </div>

            <div style="min-width:148px;">
                <div class="afb-filter-label">Rating</div>
                <select name="rating" class="afb-select">
                    <option value="">All Ratings</option>
                    @foreach([5, 4, 3, 2, 1] as $r)
                    <option value="{{ $r }}" {{ request('rating') == $r ? 'selected' : '' }}>
                        {{ $r }} Star{{ $r > 1 ? 's' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="afb-btn afb-btn-primary">
                <i class="fas fa-filter" style="font-size:.62rem;"></i> Filter
            </button>
            @if(request()->hasAny(['search','rating']))
            <a href="{{ route('admin.feedback.index') }}" class="afb-btn afb-btn-ghost">
                <i class="fas fa-xmark" style="font-size:.62rem;"></i> Clear
            </a>
            @endif
        </form>
    </div>

    {{-- ── Feedback cards ── --}}
    @forelse($feedbacks as $idx => $feedback)
    @php
        $rbClass = match(true) {
            $feedback->rating >= 4 => 'rb-high',
            $feedback->rating == 3 => 'rb-mid',
            default                => 'rb-low',
        };
    @endphp

    <div class="afb-feedback-card" style="animation-delay:{{ $idx * 0.04 }}s;">

        <div class="afb-card-body">

            {{-- Top: user info + rating badge --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:14px;flex-wrap:wrap;">

                <div style="display:flex;align-items:center;gap:14px;flex:1;min-width:0;">
                    <div class="afb-avatar">
                        {{ strtoupper(substr($feedback->user->full_name ?? 'U', 0, 1)) }}
                    </div>
                    <div style="min-width:0;">
                        <div class="afb-voter-name">{{ $feedback->user->full_name ?? 'Unknown Voter' }}</div>
                        <div class="afb-voter-email">{{ $feedback->user->email ?? '—' }}</div>
                        @if(($feedback->user->course ?? null) || ($feedback->user->college ?? null))
                        <div class="afb-voter-meta">
                            {{ $feedback->user->course ?? '' }}
                            @if($feedback->user->college)
                                {{ $feedback->user->course ? '—' : '' }}
                                {{ $feedback->user->college->acronym ?? $feedback->user->college->name }}
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <span class="afb-rating-badge {{ $rbClass }}">
                    <i class="fas fa-star" style="font-size:.6rem;"></i>
                    {{ $feedback->rating }} / 5 &mdash; {{ $ratingLabels[$feedback->rating] ?? '' }}
                </span>
            </div>

            {{-- Stars visual --}}
            <div class="afb-card-stars">
                @for($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $feedback->rating ? 'cs-fill' : 'cs-empty' }}">★</span>
                @endfor
                <span class="cs-lbl">{{ $feedback->rating }} out of 5</span>
            </div>

            {{-- Quote --}}
            <div class="afb-quote-box">
                <span class="afb-qmark-open">&ldquo;</span>
                <p class="afb-quote-text">{{ $feedback->feedback }}</p>
                <span class="afb-qmark-close">&rdquo;</span>
            </div>

        </div>

        {{-- Footer --}}
        <div class="afb-card-footer">
            <div class="afb-date-text">
                <i class="far fa-clock" style="font-size:.58rem;"></i>
                Submitted {{ $feedback->created_at->format('M d, Y · g:i A') }}
                @if($feedback->updated_at->ne($feedback->created_at))
                    &bull; <em>Edited {{ $feedback->updated_at->diffForHumans() }}</em>
                @endif
            </div>
            <div class="afb-actions">
                <a href="{{ route('admin.feedback.show', $feedback) }}"
                   class="afb-action-btn" title="View full feedback">
                    <i class="fas fa-eye"></i>
                </a>
                <button type="button" class="afb-action-btn danger" title="Delete"
                        @click="$dispatch('open-modal', 'del-{{ $feedback->id }}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Delete modal --}}
    <x-modal name="del-{{ $feedback->id }}" focusable>
        <div class="afb-modal-wrap">
            <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:4px;">
                <div class="afb-modal-icon"><i class="fas fa-trash"></i></div>
                <div>
                    <div class="afb-modal-title">Delete Feedback</div>
                    <div class="afb-modal-sub">This action cannot be undone.</div>
                </div>
            </div>
            <p class="afb-modal-body">
                Are you sure you want to permanently delete the feedback from
                <strong style="color:#fffbf0;">{{ $feedback->user->full_name ?? 'Unknown Voter' }}</strong>?
            </p>
            <div class="afb-modal-btns">
                <button class="afb-m-cancel"
                        @click="$dispatch('close-modal', 'del-{{ $feedback->id }}')">
                    Cancel
                </button>
                <form method="POST" action="{{ route('admin.feedback.destroy', $feedback) }}" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="afb-m-delete">
                        <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </x-modal>

    @empty
    <div class="afb-empty">
        <i class="fas fa-comments afb-empty-icon"></i>
        <div class="afb-empty-title">No feedback found</div>
        <div class="afb-empty-sub">
            @if(request()->hasAny(['search','rating']))
                Try adjusting your filters.
            @else
                Voters haven't submitted any feedback yet.
            @endif
        </div>
        @if(request()->hasAny(['search','rating']))
        <a href="{{ route('admin.feedback.index') }}"
           class="afb-btn afb-btn-ghost" style="margin-top:16px;display:inline-flex;">
            <i class="fas fa-xmark" style="font-size:.62rem;"></i> Clear filters
        </a>
        @endif
    </div>
    @endforelse

    @if($feedbacks->hasPages())
    <div style="margin-top:20px;">{{ $feedbacks->appends(request()->query())->links() }}</div>
    @endif

</div>
</x-app-layout>