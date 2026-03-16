<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes shimmerBar { 0%,100% { background-position:0% 0%; } 50% { background-position:100% 0%; } }

.apl-wrap { max-width: 640px; margin: 0 auto; padding: 0 0 60px; }

.apl-page-header { display:flex; align-items:center; gap:14px; margin-bottom:28px; animation:fadeUp .3s ease both; }
.apl-back-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:34px; height:34px; border-radius:10px; flex-shrink:0;
    border:1px solid rgba(249,180,15,0.2); background:transparent;
    font-size:0.72rem; color:rgba(249,180,15,0.6); text-decoration:none; transition:all .18s;
}
.apl-back-btn:hover { border-color:rgba(249,180,15,0.4); color:#f9b40f; background:rgba(249,180,15,0.06); }
.apl-page-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:#fffbf0; margin:0; }
.apl-page-sub   { font-size:0.72rem; color:rgba(255,251,240,0.4); margin-top:3px; }

.apl-card {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow:hidden; margin-bottom:16px; animation:fadeUp .4s ease both;
}
.apl-card::before {
    content:''; display:block; height:2px;
    background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}
.apl-card-header {
    padding:18px 28px 14px; border-bottom:1px solid rgba(249,180,15,0.08);
    display:flex; align-items:center; gap:12px;
    background:linear-gradient(to right,rgba(56,0,65,0.3),transparent);
}
.apl-card-icon {
    width:36px; height:36px; border-radius:10px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:0.8rem;
    background:rgba(249,180,15,0.1); border:1px solid rgba(249,180,15,0.2);
}
.apl-card-title { font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:800; color:#fffbf0; }
.apl-card-body  { padding:24px 28px; display:flex; flex-direction:column; gap:18px; }

.apl-label {
    display:block; font-size:0.6rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.08em; color:rgba(249,180,15,0.5); margin-bottom:7px;
}
.apl-label span { color:#f87171; }
.apl-input, .apl-textarea {
    width:100%; background:rgba(56,0,65,0.6); border:1px solid rgba(249,180,15,0.15);
    border-radius:10px; padding:10px 14px;
    font-family:'DM Sans',sans-serif; font-size:0.82rem; color:#fffbf0;
    outline:none; transition:border-color .2s, box-shadow .2s;
}
.apl-input::placeholder, .apl-textarea::placeholder { color:rgba(255,251,240,0.2); }
.apl-input:focus, .apl-textarea:focus { border-color:rgba(249,180,15,0.4); box-shadow:0 0 0 3px rgba(249,180,15,0.06); }
.apl-input.err, .apl-textarea.err { border-color:rgba(248,113,113,0.5); }
.apl-textarea { resize:vertical; min-height:100px; }
.apl-error { display:flex; align-items:center; gap:5px; margin-top:5px; font-size:0.68rem; color:#f87171; }
.apl-hint  { display:flex; align-items:center; gap:5px; margin-top:6px; font-size:0.65rem; color:rgba(249,180,15,0.35); }

.apl-actions {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    padding:20px 28px; display:flex; align-items:center; gap:12px;
    animation:fadeUp .5s ease both;
}
.apl-btn {
    display:inline-flex; align-items:center; gap:7px; padding:10px 22px; border-radius:10px;
    font-family:'DM Sans',sans-serif; font-size:0.78rem; font-weight:700;
    cursor:pointer; transition:all .18s; text-decoration:none; border:none;
}
.apl-btn-primary { background:linear-gradient(135deg,#f9b40f,#fcd558); color:#380041; box-shadow:0 3px 12px rgba(249,180,15,0.3); }
.apl-btn-primary:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(249,180,15,0.45); color:#380041; }
.apl-btn-ghost { background:transparent; border:1px solid rgba(249,180,15,0.2); color:rgba(249,180,15,0.55); }
.apl-btn-ghost:hover { background:rgba(249,180,15,0.06); color:#f9b40f; }
</style>
@endpush

<div class="apl-wrap">
    <div class="apl-page-header">
        <a href="{{ route('admin.partylists.index') }}" class="apl-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="apl-page-title">Add New Partylist</div>
            <div class="apl-page-sub">Create a new partylist</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.partylists.store') }}">
        @csrf
        <div class="apl-card">
            <div class="apl-card-header">
                <div class="apl-card-icon"><i class="fas fa-flag" style="color:#f9b40f;"></i></div>
                <div class="apl-card-title">Partylist Information</div>
            </div>
            <div class="apl-card-body">
                <div>
                    <label class="apl-label">Partylist Name <span>*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g., Unity Party, Progressive Alliance"
                           class="apl-input {{ $errors->has('name') ? 'err' : '' }}">
                    @error('name')<div class="apl-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                    <div class="apl-hint"><i class="fas fa-info-circle" style="font-size:.6rem;"></i> Partylist name must be unique</div>
                </div>
                <div>
                    <label class="apl-label">Description</label>
                    <textarea name="description" rows="4" class="apl-textarea"
                              placeholder="Enter partylist description (optional)…">{{ old('description') }}</textarea>
                    @error('description')<div class="apl-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="apl-actions">
            <a href="{{ route('admin.partylists.index') }}" class="apl-btn apl-btn-ghost">Cancel</a>
            <button type="submit" class="apl-btn apl-btn-primary">
                <i class="fas fa-floppy-disk" style="font-size:.7rem;"></i> Create Partylist
            </button>
        </div>
    </form>
</div>
</x-app-layout>