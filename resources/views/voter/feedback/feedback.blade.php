<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
.fb-wrap { max-width: 700px; margin: 32px auto; padding: 0 16px 60px; }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes shimmer {
    0%   { background-position: -200% 0; }
    100% { background-position:  200% 0; }
}
@keyframes starPop {
    0%   { transform: scale(0) rotate(-20deg); opacity: 0; }
    60%  { transform: scale(1.3) rotate(5deg);  opacity: 1; }
    100% { transform: scale(1)   rotate(0deg);  opacity: 1; }
}

/* ── Page header ── */
.page-header {
    display: flex; align-items: center; gap: 14px; margin-bottom: 24px;
    animation: fadeUp 0.35s ease both;
}
.back-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 9px;
    border: 1px solid rgba(249,180,15,0.2); background: transparent;
    font-size: 0.7rem; font-weight: 600; color: rgba(249,180,15,0.6);
    text-decoration: none; transition: all 0.18s; font-family: 'DM Sans', sans-serif;
    flex-shrink: 0;
}
.back-btn:hover { border-color: rgba(249,180,15,0.4); color: #f9b40f; background: rgba(249,180,15,0.05); }
.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem; font-weight: 900; color: #fffbf0;
}
.page-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); margin-top: 2px; }

/* ── Main card ── */
.fb-card {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.2);
    border-radius: 20px;
    box-shadow: 0 8px 48px rgba(0,0,0,0.45), inset 0 1px 0 rgba(249,180,15,0.07);
    overflow: hidden;
    animation: fadeUp 0.4s ease both;
}
.fb-card::before {
    content: ''; display: block; height: 2px;
    background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
}

/* Already-submitted state — green accent */
.fb-card.submitted-card {
    border-color: rgba(52,211,153,0.25);
}
.fb-card.submitted-card::before {
    background: linear-gradient(90deg, transparent, #34d399, #6ee7b7, transparent);
}

/* ── Card header ── */
.fb-card-header {
    padding: 28px 32px 20px;
    border-bottom: 1px solid rgba(249,180,15,0.08);
    display: flex; align-items: flex-start; gap: 16px;
}
.fb-header-icon {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #f9b40f;
}
.fb-header-icon.green {
    background: rgba(52,211,153,0.1); border-color: rgba(52,211,153,0.25);
    color: #34d399;
}
.fb-header-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem; font-weight: 900; color: #fffbf0; margin-bottom: 4px;
}
.fb-header-sub { font-size: 0.72rem; color: rgba(255,251,240,0.4); line-height: 1.6; }

/* ── Star Rating ── */
.rating-section { padding: 24px 32px 0; }
.rating-label {
    font-size: 0.62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5); margin-bottom: 14px;
}
.stars-row {
    display: flex; gap: 10px; align-items: center; margin-bottom: 8px;
}
.star-btn {
    background: transparent; border: none; cursor: pointer;
    padding: 4px; border-radius: 6px; transition: transform 0.15s;
    display: flex; align-items: center; justify-content: center;
    line-height: 1;
}
.star-btn:hover { transform: scale(1.25); }
.star-btn .star-icon {
    font-size: 2rem; color: rgba(249,180,15,0.18);
    transition: color 0.18s, text-shadow 0.18s;
}
.star-btn.active .star-icon,
.star-btn.hovered .star-icon {
    color: #f9b40f;
    text-shadow: 0 0 12px rgba(249,180,15,0.6);
    animation: starPop 0.28s cubic-bezier(0.34,1.56,0.64,1) both;
}
.rating-text {
    font-size: 0.72rem; font-weight: 700; color: rgba(249,180,15,0.55);
    margin-top: 4px; min-height: 1.2em; transition: all 0.18s;
}

/* ── Textarea ── */
.textarea-section { padding: 20px 32px; }
.textarea-label {
    font-size: 0.62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; color: rgba(249,180,15,0.5); margin-bottom: 10px;
    display: flex; align-items: center; justify-content: space-between;
}
.char-counter {
    font-size: 0.62rem; font-weight: 600;
    color: rgba(255,251,240,0.25); letter-spacing: 0;
    text-transform: none;
    transition: color 0.2s;
}
.char-counter.near-limit { color: rgba(249,180,15,0.6); }
.char-counter.at-limit   { color: #f87171; }

.fb-textarea {
    width: 100%; min-height: 160px; resize: vertical;
    background: rgba(56,0,65,0.5);
    border: 1px solid rgba(249,180,15,0.15);
    border-radius: 12px;
    padding: 14px 16px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem; color: #fffbf0; line-height: 1.65;
    outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    -webkit-appearance: none;
}
.fb-textarea::placeholder { color: rgba(255,251,240,0.2); }
.fb-textarea:focus {
    border-color: rgba(249,180,15,0.4);
    box-shadow: 0 0 0 3px rgba(249,180,15,0.06);
}

/* ── Submit error ── */
.fb-error {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; margin: 0 32px 16px;
    background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2);
    font-size: 0.72rem; font-weight: 600; color: #f87171;
    animation: fadeUp 0.3s ease both;
}

/* ── Footer ── */
.fb-footer {
    padding: 16px 32px 28px;
    border-top: 1px solid rgba(249,180,15,0.07);
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    flex-wrap: wrap;
}
.btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 11px 26px; border-radius: 10px; font-size: 0.78rem; font-weight: 700;
    cursor: pointer; transition: all 0.18s; text-decoration: none;
    font-family: 'DM Sans', sans-serif; border: none;
}
.btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 4px 16px rgba(249,180,15,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
}
.btn-primary:hover   { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(249,180,15,0.45); }
.btn-primary:disabled { opacity: 0.4; cursor: not-allowed; transform: none; box-shadow: none; }
.btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.18);
    color: rgba(249,180,15,0.55);
}
.btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; border-color: rgba(249,180,15,0.35); }

/* ── Already submitted view ── */
.submitted-view { padding: 28px 32px 32px; }
.submitted-rating-display {
    display: flex; gap: 6px; align-items: center; margin-bottom: 20px;
}
.submitted-star {
    font-size: 1.5rem;
    transition: color 0.15s;
}
.submitted-star.filled { color: #f9b40f; text-shadow: 0 0 10px rgba(249,180,15,0.4); }
.submitted-star.empty  { color: rgba(249,180,15,0.15); }

.submitted-feedback-box {
    background: rgba(52,211,153,0.04);
    border: 1px solid rgba(52,211,153,0.12);
    border-radius: 12px; padding: 16px;
    margin-bottom: 20px;
}
.submitted-feedback-text {
    font-size: 0.84rem; color: rgba(255,251,240,0.7); line-height: 1.75;
    font-style: italic;
}
.submitted-meta {
    display: flex; align-items: center; gap: 10px; margin-top: 12px;
    flex-wrap: wrap;
}
.submitted-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 99px;
    font-size: 0.62rem; font-weight: 700;
}
.submitted-pill.green {
    background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.2); color: #34d399;
}
.submitted-pill.gold {
    background: rgba(249,180,15,0.08); border: 1px solid rgba(249,180,15,0.18); color: rgba(249,180,15,0.8);
}

.edit-notice {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: 10px;
    background: rgba(249,180,15,0.04); border: 1px solid rgba(249,180,15,0.1);
    font-size: 0.68rem; color: rgba(255,251,240,0.4); line-height: 1.65;
}

/* ── Rating descriptions ── */
[x-cloak] { display: none !important; }

@media (max-width: 600px) {
    .fb-card-header   { padding: 20px; }
    .rating-section   { padding: 18px 20px 0; }
    .textarea-section { padding: 16px 20px; }
    .fb-footer        { padding: 14px 20px 24px; }
    .submitted-view   { padding: 20px; }
    .fb-error         { margin: 0 20px 14px; }
    .page-title       { font-size: 1.1rem; }
}
</style>
@endpush

<div class="fb-wrap" x-data="feedbackForm()" x-init="init()">

    {{-- Page header --}}
    <div class="page-header">
        <a href="{{ route('voter.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left" style="font-size:0.6rem;"></i> Back
        </a>
        <div>
            <div class="page-title">Share Your Feedback</div>
            <div class="page-sub">Help us improve this election experience</div>
        </div>
    </div>

    {{-- Flash: success --}}
    @if(session('success'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:10px;
                background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);
                margin-bottom:16px;animation:fadeUp .35s ease both;">
        <i class="fas fa-circle-check" style="color:#34d399;flex-shrink:0;font-size:.85rem;"></i>
        <span style="font-size:.75rem;font-weight:600;color:#34d399;">{{ session('success') }}</span>
    </div>
    @endif

    @if($myFeedback && !request('edit'))
    {{-- ════════════════════════════════════════
         ALREADY SUBMITTED — Read-only view
    ════════════════════════════════════════ --}}
    <div class="fb-card submitted-card">

        <div class="fb-card-header">
            <div class="fb-header-icon green"><i class="fas fa-comments"></i></div>
            <div>
                <div class="fb-header-title">Your Feedback</div>
                <div class="fb-header-sub">
                    You've already shared your thoughts. Thank you!<br>
                    You can update your feedback at any time.
                </div>
            </div>
        </div>

        <div class="submitted-view">

            {{-- Star rating display --}}
            <div style="margin-bottom:8px;">
                <div class="rating-label">Your Rating</div>
                <div class="submitted-rating-display">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="submitted-star {{ $i <= $myFeedback->rating ? 'filled' : 'empty' }}">★</span>
                    @endfor
                    <span style="font-size:0.72rem;font-weight:700;color:rgba(249,180,15,0.65);margin-left:6px;">
                        @php
                            $labels = ['', 'Poor', 'Fair', 'Good', 'Great', 'Excellent'];
                        @endphp
                        {{ $labels[$myFeedback->rating] ?? '' }}
                    </span>
                </div>
            </div>

            {{-- Feedback text --}}
            <div style="margin-bottom:6px;">
                <div class="rating-label">Your Comment</div>
            </div>
            <div class="submitted-feedback-box">
                <div class="submitted-feedback-text">
                    "{{ $myFeedback->feedback }}"
                </div>
                <div class="submitted-meta">
                    <span class="submitted-pill green">
                        <i class="fas fa-check-circle"></i>
                        Submitted
                    </span>
                    <span class="submitted-pill gold">
                        <i class="fas fa-clock"></i>
                        {{ $myFeedback->updated_at->format('M d, Y · g:i A') }}
                    </span>
                </div>
            </div>

            {{-- Edit notice --}}
            <div class="edit-notice">
                <i class="fas fa-pen-to-square" style="color:rgba(249,180,15,0.5);flex-shrink:0;margin-top:1px;"></i>
                <span>
                    Want to update your feedback?
                    <a href="{{ route('voter.feedback') }}?edit=1"
                       style="color:rgba(249,180,15,0.75);font-weight:700;text-decoration:none;
                              border-bottom:1px dashed rgba(249,180,15,0.3);padding-bottom:1px;
                              transition:color .18s;"
                       onmouseover="this.style.color='#f9b40f'"
                       onmouseout="this.style.color='rgba(249,180,15,0.75)'">
                        Click here to edit
                    </a>
                    — you can revise your comment and rating any time.
                </span>
            </div>

        </div>
    </div>

    @else
    {{-- ════════════════════════════════════════
         SUBMIT / EDIT FORM
    ════════════════════════════════════════ --}}
    <div class="fb-card">

        <div class="fb-card-header">
            <div class="fb-header-icon"><i class="fas fa-star-half-stroke"></i></div>
            <div>
                <div class="fb-header-title">
                    {{ $myFeedback ? 'Update Your Feedback' : 'Leave Your Feedback' }}
                </div>
                <div class="fb-header-sub">
                    Rate your experience and share your thoughts about this election system.<br>
                    Your feedback is kept confidential and helps us do better.
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('voter.feedback.submit') }}">
            @csrf

            {{-- Validation errors --}}
            @if($errors->any())
            <div style="padding:0 32px;margin-top:16px;">
                @foreach($errors->all() as $error)
                <div class="fb-error">
                    <i class="fas fa-circle-exclamation" style="flex-shrink:0;"></i>
                    {{ $error }}
                </div>
                @endforeach
            </div>
            @endif

            {{-- ── Star Rating ── --}}
            <div class="rating-section">
                <div class="rating-label">Overall Rating <span style="color:rgba(249,180,15,0.3);">*</span></div>

                {{-- Hidden input driven by Alpine --}}
                <input type="hidden" name="rating" :value="rating">

                <div class="stars-row">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button"
                            class="star-btn"
                            :class="{
                                'active':  {{ $i }} <= rating,
                                'hovered': {{ $i }} <= hovered && {{ $i }} > rating
                            }"
                            @mouseenter="hovered = {{ $i }}"
                            @mouseleave="hovered = 0"
                            @click="setRating({{ $i }})">
                        <span class="star-icon">★</span>
                    </button>
                    @endfor

                    <span style="font-size:0.72rem;font-weight:700;color:rgba(249,180,15,0.55);margin-left:6px;"
                          x-text="ratingLabel"></span>
                </div>

                <div class="rating-text" x-text="ratingHint"></div>
            </div>

            {{-- ── Textarea ── --}}
            <div class="textarea-section">
                <div class="textarea-label">
                    <span>Your Comment <span style="color:rgba(249,180,15,0.3);">*</span></span>
                    <span class="char-counter"
                          :class="{ 'near-limit': charCount >= 800, 'at-limit': charCount >= 1000 }"
                          x-text="charCount + ' / 1000'">0 / 1000</span>
                </div>

                <textarea
                    class="fb-textarea"
                    name="feedback"
                    placeholder="Tell us about your experience — what went well, what could be improved, or any other thoughts you'd like to share..."
                    maxlength="1000"
                    x-model="feedbackText"
                    @input="charCount = $el.value.length"
                    x-ref="textarea"
                >{{ old('feedback', $myFeedback?->feedback) }}</textarea>

                <div style="font-size:0.65rem;color:rgba(255,251,240,0.22);margin-top:6px;display:flex;align-items:center;gap:5px;">
                    <i class="fas fa-lock" style="font-size:0.55rem;"></i>
                    Your feedback is confidential and will only be seen by administrators.
                </div>
            </div>

            {{-- ── Footer ── --}}
            <div class="fb-footer">
                <a href="{{ route('voter.dashboard') }}" class="btn btn-ghost">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>

                <button type="submit"
                        class="btn btn-primary"
                        :disabled="!canSubmit">
                    <i class="fas fa-paper-plane"></i>
                    {{ $myFeedback ? 'Update Feedback' : 'Submit Feedback' }}
                </button>
            </div>
        </form>

    </div>
    @endif

</div>

@push('scripts')
<script>
function feedbackForm() {
    const ratingLabels = ['', 'Poor', 'Fair', 'Good', 'Great', 'Excellent'];
    const ratingHints  = [
        '',
        'We\'re sorry to hear that. Please tell us what went wrong.',
        'Thank you — we\'d love to know how we can do better.',
        'Glad it was a decent experience! What could make it even better?',
        'Wonderful! We appreciate your positive feedback.',
        'Amazing! Thank you so much — this means a lot to us.',
    ];

    return {
        rating:       {{ old('rating', $myFeedback?->rating ?? 0) }},
        hovered:      0,
        feedbackText: '',
        charCount:    0,

        get ratingLabel() {
            const idx = this.hovered || this.rating;
            return ratingLabels[idx] || '';
        },
        get ratingHint() {
            const idx = this.hovered || this.rating;
            return ratingHints[idx] || 'Select a star rating above.';
        },
        get canSubmit() {
            return this.rating > 0 && this.feedbackText.trim().length >= 10;
        },

        setRating(val) {
            this.rating = val;
        },

        init() {
            this.feedbackText = this.$refs.textarea?.value || '';
            this.charCount    = this.feedbackText.length;
        },
    };
}
</script>
@endpush
</x-app-layout>