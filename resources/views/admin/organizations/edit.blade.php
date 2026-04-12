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

    .ac-wrap { max-width: 760px; margin: 0 auto; padding: 0 0 60px; }

    .ac-page-header {
        display: flex; align-items: center; gap: 14px; margin-bottom: 28px;
        animation: fadeUp .3s ease both;
    }
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

    /* ── Section card ── */
    .ac-card {
        background: rgba(26,0,32,0.88);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(249,180,15,0.18);
        border-radius: 18px;
        box-shadow: 0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
        overflow: hidden;
        margin-bottom: 16px;
        animation: fadeUp .4s ease both;
    }
    .ac-card::before {
        content: ''; display: block; height: 2px;
        background: linear-gradient(90deg, transparent, #f9b40f, #fcd558, transparent);
        background-size: 200% 100%;
        animation: shimmerBar 3s ease-in-out infinite;
    }
    .ac-card-header {
        padding: 18px 28px 14px;
        border-bottom: 1px solid rgba(249,180,15,0.08);
        display: flex; align-items: center; gap: 12px;
        background: linear-gradient(to right, rgba(56,0,65,0.3), transparent);
    }
    .ac-card-icon {
        width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
    }
    .ac-card-title { font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:800; color:#fffbf0; }
    .ac-card-body  { padding: 24px 28px; }
    .ac-card-grid  { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .ac-card-grid .span2 { grid-column: span 2; }
    @media (max-width:560px) { .ac-card-grid { grid-template-columns:1fr; } .ac-card-grid .span2 { grid-column:span 1; } }

    /* ── Fields ── */
    .ac-label {
        display:block; font-size:0.6rem; font-weight:700; text-transform:uppercase;
        letter-spacing:.08em; color:rgba(249,180,15,0.5); margin-bottom:7px;
    }
    .ac-label span { color:#f87171; }
    .ac-input, .ac-select, .ac-textarea {
        width:100%; background:rgba(56,0,65,0.6); border:1px solid rgba(249,180,15,0.15);
        border-radius:10px; padding:10px 14px;
        font-family:'DM Sans',sans-serif; font-size:0.82rem; color:#fffbf0;
        outline:none; transition:border-color .2s, box-shadow .2s;
    }
    .ac-input::placeholder, .ac-textarea::placeholder { color:rgba(255,251,240,0.2); }
    .ac-input:focus, .ac-select:focus, .ac-textarea:focus {
        border-color:rgba(249,180,15,0.4); box-shadow:0 0 0 3px rgba(249,180,15,0.06);
    }
    .ac-input.err, .ac-select.err, .ac-textarea.err { border-color:rgba(248,113,113,0.5); }
    .ac-select {
        -webkit-appearance:none; appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(249,180,15,0.5)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 12px center;
        padding-right:32px;
    }
    .ac-select option { background:#1a0020; }
    .ac-textarea { resize:vertical; min-height:100px; }
    .ac-error { display:flex;align-items:center;gap:5px; margin-top:5px; font-size:0.68rem; color:#f87171; }
    .ac-hint  { display:flex;align-items:center;gap:5px; margin-top:6px; font-size:0.65rem; color:rgba(249,180,15,0.35); }

    /* ── Actions bar ── */
    .ac-actions {
        background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
        border:1px solid rgba(249,180,15,0.18); border-radius:18px;
        box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
        padding:20px 28px; display:flex; align-items:center; gap:12px;
        animation:fadeUp .52s ease both;
    }
    .ac-btn {
        display:inline-flex; align-items:center; gap:7px;
        padding:10px 22px; border-radius:10px;
        font-family:'DM Sans',sans-serif; font-size:0.78rem; font-weight:700;
        cursor:pointer; transition:all .18s; text-decoration:none; border:none;
    }
    .ac-btn-primary {
        background:linear-gradient(135deg,#f9b40f,#fcd558); color:#380041;
        box-shadow:0 3px 12px rgba(249,180,15,0.3);
    }
    .ac-btn-primary:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(249,180,15,0.45); color:#380041; }
    .ac-btn-ghost {
        background:transparent; border:1px solid rgba(249,180,15,0.2); color:rgba(249,180,15,0.55);
    }
    .ac-btn-ghost:hover { background:rgba(249,180,15,0.06); color:#f9b40f; }
</style>
@endpush

<div class="ac-wrap">

    <div class="ac-page-header">
        <a href="{{ route('admin.organizations.index') }}" class="ac-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="ac-page-title">Edit Organization</div>
            <div class="ac-page-sub">Updating: <strong>{{ $organization->name }}</strong></div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.organizations.update', $organization) }}">
        @csrf @method('PUT')

        {{-- Organization Information --}}
        <div class="ac-card" style="animation-delay:.06s;">
            <div class="ac-card-header">
                <div class="ac-card-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                    <i class="fas fa-sitemap" style="color:#f9b40f;"></i>
                </div>
                <div class="ac-card-title">Organization Information</div>
            </div>
            <div class="ac-card-body">
                <div class="ac-card-grid">
                    <div class="span2">
                        <label class="ac-label">Organization Name <span>*</span></label>
                        <input type="text" name="name" value="{{ old('name', $organization->name) }}"
                               class="ac-input {{ $errors->has('name') ? 'err' : '' }}"
                               placeholder="e.g., Business Club">
                        @error('name')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="ac-label">College <span>*</span></label>
                        <select name="college_id" class="ac-select {{ $errors->has('college_id') ? 'err' : '' }}">
                            <option value="">-- Select College --</option>
                            @foreach(\App\Models\College::orderBy('name')->get() as $college)
                                <option value="{{ $college->id }}" {{ old('college_id', $organization->college_id) == $college->id ? 'selected' : '' }}>
                                    {{ $college->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('college_id')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="span2">
                        <label class="ac-label">Description</label>
                        <textarea name="description" rows="4" class="ac-textarea"
                                  placeholder="Enter organization description and details…">{{ old('description', $organization->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="ac-actions">
            <a href="{{ route('admin.organizations.index') }}" class="ac-btn ac-btn-ghost">Cancel</a>
            <button type="submit" class="ac-btn ac-btn-primary">
                <i class="fas fa-floppy-disk" style="font-size:.7rem;"></i> Save Changes
            </button>
        </div>
    </form>

</div>
</x-app-layout>
