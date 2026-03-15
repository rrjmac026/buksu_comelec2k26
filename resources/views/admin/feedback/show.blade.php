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

.afs-wrap { max-width: 680px; margin: 0 auto; padding: 0 0 60px; }

/* ── Page header ── */
.afs-page-header {
    display: flex; align-items: center; gap: 14px; margin-bottom: 24px;
    animation: fadeUp 0.35s ease both;
}
.afs-back-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 9px;
    border: 1px solid rgba(249,180,15,0.2); background: transparent;
    font-size: 0.7rem; font-weight: 600; color: rgba(249,180,15,0.6);
    text-decoration: none; transition: all 0.18s; font-family: 'DM Sans', sans-serif;
    flex-shrink: 0;
}
.afs-back-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.05); }
.afs-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem; font-weight: 900; color: #fffbf0;
}
.afs-page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); margin-top: 2px; }

/* ── Main card ── */
.afs-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.2);
    border-radius: 20px;
    box-shadow: 0 8px 48px rgba(0,0,0,0.45), inset 0 1px 0 rgba(249,180,15,0.07);
    overflow: hidden;
    animation: fadeUp 0.4s ease both;
}
.afs-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
    background-size: 200% 100%;
    animation: shimmerBar 3s ease-in-out infinite;
}

/* ── Card header ── */
.afs-card-header {
    padding: 28px 32px 22px;
    border-bottom: 1px solid rgba(249,180,15,0.08);
    display: flex; align-items: flex-start; gap: 16px; flex-wrap: wrap;
}
.afs-header-icon {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #f9b40f;
}
.afs-header-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem; font-weight: 900; color: #fffbf0; margin-bottom: 4px;
}
.afs-header-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); line-height: 1.6; }

/* ── User profile row ── */
.afs-user-section { padding: 24px 32px 0; }
.afs-section-label {
    font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5); margin-bottom: 12px;
}
.afs-user-row {
    display: flex; align-items: center; gap: 16px;
    padding: 16px; border-radius: 14px;
    background: rgba(56,0,65,0.4); border: 1px solid rgba(249,180,15,0.1);
    flex-wrap: wrap;
}
.afs-avatar {
    width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg, #380041, #520060);
    border: 2px solid rgba(249,180,15,0.3);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 900; color: #f9b40f;
}
.afs-voter-name  { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 800; color: #fffbf0; }
.afs-voter-email { font-size: 0.68rem; color: rgba(249,180,15,0.55); margin-top: 3px; }
.afs-voter-meta  { font-size: 0.65rem; color: rgba(255,251,240,0.3); margin-top: 2px; }

/* ── Rating section ── */
.afs-rating-section { padding: 22px 32px 0; }
.afs-stars-row { display: flex; gap: 6px; align-items: center; margin-bottom: 8px; }
.afs-s-fill  { font-size: 1.6rem; color: #f9b40f; text-shadow: 0 0 12px rgba(249,180,15,0.5); }
.afs-s-empty { font-size: 1.6rem; color: rgba(249,180,15,0.12); }
.afs-rating-badge {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 6px 16px; border-radius: 99px; font-size: 0.8rem; font-weight: 800; margin-left: 8px;
}
.rb-high { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.25); color: #34d399; }
.rb-mid  { background: rgba(251,146,60,0.1); border: 1px solid rgba(251,146,60,0.25); color: #fb923c; }
.rb-low  { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.25); color: #f87171; }

/* ── Feedback body ── */
.afs-feedback-section { padding: 20px 32px; }
.afs-quote-box {
    background: rgba(56,0,65,0.4);
    border: 1px solid rgba(249,180,15,0.1);
    border-radius: 14px; padding: 20px 24px;
    position: relative; overflow: hidden;
}
.afs-qmark-open {
    position: absolute; top: -8px; left: 12px;
    font-family: 'Playfair Display', serif;
    font-size: 5.5rem; font-weight: 900; line-height: 1;
    color: rgba(249,180,15,0.05); pointer-events: none; user-select: none;
}
.afs-qmark-close {
    position: absolute; bottom: -22px; right: 12px;
    font-family: 'Playfair Display', serif;
    font-size: 5.5rem; font-weight: 900; line-height: 1;
    color: rgba(249,180,15,0.05); pointer-events: none; user-select: none;
}
.afs-quote-text {
    font-size: 0.88rem; color: rgba(255,251,240,0.7); line-height: 1.8;
    font-style: italic; position: relative; z-index: 1;
    padding: 4px 4px 4px 8px; white-space: pre-line;
}

/* ── Meta pills ── */
.afs-meta-row { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px; }
.afs-meta-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 14px; border-radius: 99px; font-size: 0.65rem; font-weight: 700;
}
.afs-meta-pill.gold   { background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.18); color: rgba(249,180,15,0.75); }
.afs-meta-pill.muted  { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,251,240,0.35); }

/* ── Footer actions ── */
.afs-footer {
    padding: 16px 32px 28px;
    border-top: 1px solid rgba(249,180,15,0.07);
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    flex-wrap: wrap;
}
.afs-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 22px; border-radius: 10px; font-size: 0.78rem; font-weight: 700;
    cursor: pointer; transition: all .18s; text-decoration: none;
    font-family: 'DM Sans', sans-serif; border: none;
}
.afs-btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.55);
}
.afs-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; border-color: rgba(249,180,15,0.35); }
.afs-btn-danger {
    background: linear-gradient(135deg, #ef4444, #f87171); color: #fff;
    box-shadow: 0 3px 12px rgba(239,68,68,0.3);
}
.afs-btn-danger:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(239,68,68,0.45); }

/* ── Delete modal ── */
.afs-modal-wrap { padding: 28px; background: rgba(26,0,32,0.98); }
.afs-modal-icon {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #f87171;
}
.afs-modal-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 900; color: #fffbf0; margin-bottom: 3px; }
.afs-modal-sub   { font-size: 0.7rem; color: rgba(255,251,240,0.4); }
.afs-modal-body  { font-size: 0.75rem; color: rgba(255,251,240,0.5); line-height: 1.7; margin: 16px 0 22px; }
.afs-modal-btns  { display: flex; gap: 10px; justify-content: flex-end; }
.afs-m-cancel {
    padding: 9px 18px; border-radius: 9px; cursor: pointer;
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.55); font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700; transition: all .18s;
}
.afs-m-cancel:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
.afs-m-delete {
    padding: 9px 20px; border-radius: 9px; cursor: pointer;
    background: linear-gradient(135deg, #ef4444, #f87171); border: none;
    color: #fff; font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(239,68,68,0.3); transition: all .18s;
}
.afs-m-delete:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(239,68,68,0.45); }

@media (max-width: 600px) {
    .afs-card-header      { padding: 20px; }
    .afs-user-section     { padding: 18px 20px 0; }
    .afs-rating-section   { padding: 18px 20px 0; }
    .afs-feedback-section { padding: 16px 20px; }
    .afs-footer           { padding: 14px 20px 24px; }
    .afs-modal-wrap       { padding: 22px; }
}
</style>
@endpush

@php
    $ratingLabels = [1=>'Poor', 2=>'Fair', 3=>'Good', 4=>'Great', 5=>'Excellent'];
    $rbClass = match(true) {
        $feedback->rating >= 4 => 'rb-high',
        $feedback->rating == 3 => 'rb-mid',
        default                => 'rb-low',
    };
@endphp

<div class="afs-wrap">

    {{-- Page header --}}
    <div class="afs-page-header">
        <a href="{{ route('admin.feedback.index') }}" class="afs-back-btn">
            <i class="fas fa-arrow-left" style="font-size:0.6rem;"></i> Back
        </a>
        <div>
            <div class="afs-page-title">Feedback Detail</div>
            <div class="afs-page-sub">Full submission from {{ $feedback->user->full_name ?? 'Unknown Voter' }}</div>
        </div>
    </div>

    <div class="afs-card">

        {{-- Card header --}}
        <div class="afs-card-header">
            <div class="afs-header-icon"><i class="fas fa-comment-dots"></i></div>
            <div style="flex:1;min-width:0;">
                <div class="afs-header-title">Voter Feedback</div>
                <div class="afs-header-sub">
                    Submitted {{ $feedback->created_at->format('F d, Y \a\t g:i A') }}<br>
                    @if($feedback->updated_at->ne($feedback->created_at))
                        Last edited {{ $feedback->updated_at->format('F d, Y \a\t g:i A') }}
                    @else
                        No edits made after submission.
                    @endif
                </div>
            </div>

            {{-- Rating badge in header --}}
            <span class="afs-rating-badge {{ $rbClass }}">
                <i class="fas fa-star" style="font-size:.62rem;"></i>
                {{ $feedback->rating }} / 5
                &mdash; {{ $ratingLabels[$feedback->rating] ?? '' }}
            </span>
        </div>

        {{-- Voter profile --}}
        <div class="afs-user-section">
            <div class="afs-section-label">Submitted By</div>
            <div class="afs-user-row">
                <div class="afs-avatar">
                    {{ strtoupper(substr($feedback->user->full_name ?? 'U', 0, 1)) }}
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="afs-voter-name">{{ $feedback->user->full_name ?? 'Unknown Voter' }}</div>
                    <div class="afs-voter-email">{{ $feedback->user->email ?? '—' }}</div>
                    @if(($feedback->user->student_number ?? null))
                    <div class="afs-voter-meta">
                        Student No. {{ $feedback->user->student_number }}
                    </div>
                    @endif
                    @if(($feedback->user->course ?? null) || ($feedback->user->college ?? null))
                    <div class="afs-voter-meta">
                        {{ $feedback->user->course ?? '' }}
                        @if($feedback->user->college)
                            {{ $feedback->user->course ? '—' : '' }}
                            {{ $feedback->user->college->acronym ?? $feedback->user->college->name }}
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Rating ── --}}
        <div class="afs-rating-section">
            <div class="afs-section-label" style="margin-bottom:12px;">Rating</div>
            <div class="afs-stars-row">
                @for($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $feedback->rating ? 'afs-s-fill' : 'afs-s-empty' }}">★</span>
                @endfor
                <span style="font-size:0.75rem;font-weight:700;color:rgba(255,251,240,0.4);margin-left:8px;">
                    {{ $feedback->rating }} out of 5
                </span>
            </div>
        </div>

        {{-- Feedback text ── --}}
        <div class="afs-feedback-section">
            <div class="afs-section-label" style="margin-bottom:12px;">Comment</div>
            <div class="afs-quote-box">
                <span class="afs-qmark-open">&ldquo;</span>
                <p class="afs-quote-text">{{ $feedback->feedback }}</p>
                <span class="afs-qmark-close">&rdquo;</span>
            </div>

            {{-- Meta row --}}
            <div class="afs-meta-row">
                <span class="afs-meta-pill gold">
                    <i class="far fa-clock" style="font-size:.58rem;"></i>
                    {{ $feedback->created_at->format('M d, Y · g:i A') }}
                </span>
                @if($feedback->updated_at->ne($feedback->created_at))
                <span class="afs-meta-pill muted">
                    <i class="fas fa-pen" style="font-size:.55rem;"></i>
                    Edited {{ $feedback->updated_at->diffForHumans() }}
                </span>
                @endif
            </div>
        </div>

        {{-- Footer actions ── --}}
        <div class="afs-footer">
            <a href="{{ route('admin.feedback.index') }}" class="afs-btn afs-btn-ghost">
                <i class="fas fa-arrow-left"></i> Back to All Feedback
            </a>
            <button type="button" class="afs-btn afs-btn-danger"
                    @click="$dispatch('open-modal', 'del-show-{{ $feedback->id }}')">
                <i class="fas fa-trash" style="font-size:.7rem;"></i> Delete Feedback
            </button>
        </div>

    </div>
</div>

{{-- Delete modal --}}
<x-modal name="del-show-{{ $feedback->id }}" focusable>
    <div class="afs-modal-wrap">
        <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:4px;">
            <div class="afs-modal-icon"><i class="fas fa-trash"></i></div>
            <div>
                <div class="afs-modal-title">Delete Feedback</div>
                <div class="afs-modal-sub">This action cannot be undone.</div>
            </div>
        </div>
        <p class="afs-modal-body">
            Are you sure you want to permanently delete the feedback from
            <strong style="color:#fffbf0;">{{ $feedback->user->full_name ?? 'Unknown Voter' }}</strong>?
        </p>
        <div class="afs-modal-btns">
            <button class="afs-m-cancel"
                    @click="$dispatch('close-modal', 'del-show-{{ $feedback->id }}')">
                Cancel
            </button>
            <form method="POST" action="{{ route('admin.feedback.destroy', $feedback) }}" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="afs-m-delete">
                    <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete
                </button>
            </form>
        </div>
    </div>
</x-modal>
</x-app-layout>