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

.apos-wrap { max-width: 640px; margin: 0 auto; padding: 0 0 60px; }

/* ── Page header ── */
.apos-page-header {
    display: flex; align-items: center; gap: 14px; margin-bottom: 28px;
    animation: fadeUp 0.3s ease both;
}
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

/* ── Card header ── */
.apos-card-header {
    padding: 20px 28px 16px;
    border-bottom: 1px solid rgba(249,180,15,0.08);
    display: flex; align-items: center; gap: 12px;
}
.apos-card-header-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    background: rgba(249,180,15,0.1); border: 1px solid rgba(249,180,15,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; color: #f9b40f;
}
.apos-card-header-title {
    font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 800; color: #fffbf0;
}
.apos-card-body { padding: 24px 28px; }

/* ── Form fields ── */
.apos-field-label {
    display: block; font-size: 0.62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.08em; color: rgba(249,180,15,0.5); margin-bottom: 8px;
}
.apos-field-label span { color: #f87171; }
.apos-input {
    width: 100%; background: rgba(56,0,65,0.6); border: 1px solid rgba(249,180,15,0.15);
    border-radius: 10px; padding: 10px 14px;
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem; color: #fffbf0;
    outline: none; transition: border-color .2s, box-shadow .2s;
}
.apos-input::placeholder { color: rgba(255,251,240,0.2); }
.apos-input:focus { border-color: rgba(249,180,15,0.4); box-shadow: 0 0 0 3px rgba(249,180,15,0.06); }
.apos-input.error { border-color: rgba(248,113,113,0.5); }

.apos-error {
    display: flex; align-items: center; gap: 5px; margin-top: 6px;
    font-size: 0.68rem; color: #f87171;
}
.apos-hint {
    display: flex; align-items: center; gap: 5px; margin-top: 8px;
    font-size: 0.65rem; color: rgba(249,180,15,0.4);
}

/* ── Action bar ── */
.apos-actions {
    background: rgba(26,0,32,0.88);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(249,180,15,0.18);
    border-radius: 18px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    padding: 20px 28px;
    display: flex; align-items: center; gap: 12px;
    animation: fadeUp .5s ease both;
}
.apos-actions::before {
    display: none;
}

.apos-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 22px; border-radius: 10px;
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem; font-weight: 700;
    cursor: pointer; transition: all .18s; text-decoration: none; border: none;
}
.apos-btn-primary {
    background: linear-gradient(135deg, #f9b40f, #fcd558); color: #380041;
    box-shadow: 0 3px 12px rgba(249,180,15,0.3);
}
.apos-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(249,180,15,0.45); color: #380041; }
.apos-btn-ghost {
    background: transparent; border: 1px solid rgba(249,180,15,0.2); color: rgba(249,180,15,0.55);
}
.apos-btn-ghost:hover { background: rgba(249,180,15,0.06); color: #f9b40f; }
</style>
@endpush

<div class="apos-wrap">

    {{-- Page Header --}}
    <div class="apos-page-header">
        <a href="{{ route('admin.positions.index') }}" class="apos-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="apos-page-title">Add New Position</div>
            <div class="apos-page-sub">Create a new election position</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.positions.store') }}">
        @csrf

        {{-- Position Information --}}
        <div class="apos-card">
            <div class="apos-card-header">
                <div class="apos-card-header-icon"><i class="fas fa-sitemap"></i></div>
                <div class="apos-card-header-title">Position Information</div>
            </div>
            <div class="apos-card-body">
                <div>
                    <label class="apos-field-label">
                        Position Name <span>*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g., President, Vice President, Secretary"
                           class="apos-input {{ $errors->has('name') ? 'error' : '' }}">
                    @error('name')
                        <div class="apos-error">
                            <i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}
                        </div>
                    @enderror
                    <div class="apos-hint">
                        <i class="fas fa-info-circle" style="font-size:.6rem;"></i>
                        Position name must be unique
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="apos-actions">
            <a href="{{ route('admin.positions.index') }}" class="apos-btn apos-btn-ghost">
                Cancel
            </a>
            <button type="submit" class="apos-btn apos-btn-primary">
                <i class="fas fa-floppy-disk" style="font-size:.7rem;"></i> Create Position
            </button>
        </div>
    </form>

</div>
</x-app-layout>