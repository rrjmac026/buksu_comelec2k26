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

/* ── File input ── */
.ac-file-input {
    width:100%; background:rgba(56,0,65,0.6); border:1px solid rgba(249,180,15,0.15);
    border-radius:10px; padding:8px 12px;
    font-family:'DM Sans',sans-serif; font-size:0.78rem; color:#fffbf0;
    transition:border-color .2s;
}
.ac-file-input:focus { outline:none; border-color:rgba(249,180,15,0.4); }
.ac-file-input::file-selector-button {
    padding:4px 12px; border-radius:7px; border:none; cursor:pointer;
    background:rgba(249,180,15,0.15); color:rgba(249,180,15,0.8);
    font-family:'DM Sans',sans-serif; font-size:0.72rem; font-weight:700;
    margin-right:10px; transition:background .18s;
}
.ac-file-input::file-selector-button:hover { background:rgba(249,180,15,0.25); }

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
        <a href="{{ route('admin.candidates.index') }}" class="ac-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="ac-page-title">Add New Candidate</div>
            <div class="ac-page-sub">Create a new candidate entry</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.candidates.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Personal Information --}}
        <div class="ac-card" style="animation-delay:.06s;">
            <div class="ac-card-header">
                <div class="ac-card-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                    <i class="fas fa-user" style="color:#f9b40f;"></i>
                </div>
                <div class="ac-card-title">Personal Information</div>
            </div>
            <div class="ac-card-body">
                <div class="ac-card-grid">
                    <div>
                        <label class="ac-label">First Name <span>*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                               class="ac-input {{ $errors->has('first_name') ? 'err' : '' }}"
                               placeholder="Juan">
                        @error('first_name')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="ac-label">Last Name <span>*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                               class="ac-input {{ $errors->has('last_name') ? 'err' : '' }}"
                               placeholder="dela Cruz">
                        @error('last_name')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="span2">
                        <label class="ac-label">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                               class="ac-input" placeholder="Santos">
                    </div>
                </div>
            </div>
        </div>

        {{-- Academic Information --}}
        <div class="ac-card" style="animation-delay:.1s;">
            <div class="ac-card-header">
                <div class="ac-card-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                    <i class="fas fa-graduation-cap" style="color:#60a5fa;"></i>
                </div>
                <div class="ac-card-title">Academic Information</div>
            </div>
            <div class="ac-card-body">
                <div class="ac-card-grid">
                    <div>
                        <label class="ac-label">College <span>*</span></label>
                        <select name="college_id" class="ac-select {{ $errors->has('college_id') ? 'err' : '' }}">
                            <option value="">Select college</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>
                                    {{ $college->name }} ({{ $college->acronym }})
                                </option>
                            @endforeach
                        </select>
                        @error('college_id')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="ac-label">Course <span>*</span></label>
                        <input type="text" name="course" value="{{ old('course') }}"
                               class="ac-input {{ $errors->has('course') ? 'err' : '' }}"
                               placeholder="e.g., BSCS">
                        @error('course')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Election Position --}}
        <div class="ac-card" style="animation-delay:.14s;">
            <div class="ac-card-header">
                <div class="ac-card-icon" style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.2);">
                    <i class="fas fa-vote-yea" style="color:#34d399;"></i>
                </div>
                <div class="ac-card-title">Election Position</div>
            </div>
            <div class="ac-card-body">
                <div class="ac-card-grid">
                    <div>
                        <label class="ac-label">Party List <span>*</span></label>
                        <select name="partylist_id" class="ac-select {{ $errors->has('partylist_id') ? 'err' : '' }}">
                            <option value="">Select party list</option>
                            @foreach($partylists as $partylist)
                                <option value="{{ $partylist->id }}" {{ old('partylist_id') == $partylist->id ? 'selected' : '' }}>
                                    {{ $partylist->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('partylist_id')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="ac-label">Organization <span>*</span></label>
                        <select name="organization_id" class="ac-select {{ $errors->has('organization_id') ? 'err' : '' }}">
                            <option value="">Select organization</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                    {{ $organization->name }} ({{ $organization->college?->acronym ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('organization_id')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="span2">
                        <label class="ac-label">Position <span>*</span></label>
                        <select name="position_id" class="ac-select {{ $errors->has('position_id') ? 'err' : '' }}">
                            <option value="">Select position</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Campaign Information --}}
        <div class="ac-card" style="animation-delay:.18s;">
            <div class="ac-card-header">
                <div class="ac-card-icon" style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);">
                    <i class="fas fa-microphone" style="color:#f87171;"></i>
                </div>
                <div class="ac-card-title">Campaign Information</div>
            </div>
            <div class="ac-card-body" style="display:flex;flex-direction:column;gap:18px;">
                <div>
                    <label class="ac-label">Platform</label>
                    <textarea name="platform" rows="4" class="ac-textarea"
                              placeholder="Enter candidate's campaign platform and promises…">{{ old('platform') }}</textarea>
                </div>
                <div>
                    <label class="ac-label">Candidate Photo</label>
                    <input type="file" name="photo" accept="image/*"
                           class="ac-file-input {{ $errors->has('photo') ? 'err' : '' }}">
                    <div class="ac-hint">
                        <i class="fas fa-info-circle" style="font-size:.6rem;"></i>
                        JPG, PNG, or WEBP (max 2MB)
                    </div>
                    @error('photo')<div class="ac-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="ac-actions">
            <a href="{{ route('admin.candidates.index') }}" class="ac-btn ac-btn-ghost">Cancel</a>
            <button type="submit" class="ac-btn ac-btn-primary">
                <i class="fas fa-floppy-disk" style="font-size:.7rem;"></i> Create Candidate
            </button>
        </div>
    </form>

</div>
</x-app-layout>