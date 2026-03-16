<x-app-layout>
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; }
@keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
@keyframes shimmerBar { 0%,100% { background-position:0% 0%; } 50% { background-position:100% 0%; } }

.apr-wrap { max-width: 720px; margin: 0 auto; padding: 0 0 60px; }

.apr-page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:28px; flex-wrap:wrap; animation:fadeUp .3s ease both; }
.apr-page-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:#fffbf0; margin:0 0 3px; }
.apr-page-sub { font-size:0.72rem; color:rgba(255,251,240,0.4); }

/* ── glass card ── */
.apr-card {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    overflow:hidden; margin-bottom:16px; animation:fadeUp .4s ease both;
}
.apr-card::before {
    content:''; display:block; height:2px;
    background:linear-gradient(90deg,transparent,#f9b40f,#fcd558,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}
.apr-card-header {
    padding:18px 28px 14px; border-bottom:1px solid rgba(249,180,15,0.08);
    display:flex; align-items:center; gap:12px;
    background:linear-gradient(to right,rgba(56,0,65,0.3),transparent);
}
.apr-card-icon {
    width:36px; height:36px; border-radius:10px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:0.8rem;
}
.apr-card-title { font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:800; color:#fffbf0; }
.apr-card-sub   { font-size:0.68rem; color:rgba(255,251,240,0.4); margin-top:2px; }
.apr-card-body  { padding:24px 28px; display:flex; flex-direction:column; gap:18px; }

/* ── fields ── */
.apr-label {
    display:block; font-size:0.6rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.08em; color:rgba(249,180,15,0.5); margin-bottom:7px;
}
.apr-input {
    width:100%; background:rgba(56,0,65,0.6); border:1px solid rgba(249,180,15,0.15);
    border-radius:10px; padding:10px 14px;
    font-family:'DM Sans',sans-serif; font-size:0.82rem; color:#fffbf0;
    outline:none; transition:border-color .2s, box-shadow .2s;
}
.apr-input::placeholder { color:rgba(255,251,240,0.2); }
.apr-input:focus { border-color:rgba(249,180,15,0.4); box-shadow:0 0 0 3px rgba(249,180,15,0.06); }
.apr-error { display:flex; align-items:center; gap:5px; margin-top:5px; font-size:0.68rem; color:#f87171; }

/* ── verify email notice ── */
.apr-verify-notice {
    padding:10px 14px; border-radius:9px; margin-top:8px;
    background:rgba(251,146,60,0.07); border:1px solid rgba(251,146,60,0.18);
    font-size:0.72rem; color:rgba(251,146,60,0.8); line-height:1.6;
}
.apr-verify-btn {
    background:none; border:none; cursor:pointer; text-decoration:underline;
    color:rgba(249,180,15,0.7); font-size:0.72rem; font-family:'DM Sans',sans-serif; padding:0;
    transition:color .18s;
}
.apr-verify-btn:hover { color:#f9b40f; }
.apr-verify-sent {
    padding:8px 12px; border-radius:8px; margin-top:6px;
    background:rgba(52,211,153,0.08); border:1px solid rgba(52,211,153,0.2);
    font-size:0.68rem; color:#34d399;
}

/* ── toast ── */
.apr-toast {
    display:inline-flex; align-items:center; gap:6px;
    padding:6px 14px; border-radius:99px;
    background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.2);
    font-size:0.7rem; font-weight:600; color:#34d399;
}

/* ── actions bar ── */
.apr-actions {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(249,180,15,0.18); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35), inset 0 1px 0 rgba(249,180,15,0.06);
    padding:20px 28px; display:flex; align-items:center; gap:12px;
    animation:fadeUp .5s ease both;
}
.apr-btn {
    display:inline-flex; align-items:center; gap:7px; padding:10px 22px; border-radius:10px;
    font-family:'DM Sans',sans-serif; font-size:0.78rem; font-weight:700;
    cursor:pointer; transition:all .18s; text-decoration:none; border:none;
}
.apr-btn-primary { background:linear-gradient(135deg,#f9b40f,#fcd558); color:#380041; box-shadow:0 3px 12px rgba(249,180,15,0.3); }
.apr-btn-primary:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(249,180,15,0.45); color:#380041; }
.apr-btn-ghost { background:transparent; border:1px solid rgba(249,180,15,0.2); color:rgba(249,180,15,0.55); }
.apr-btn-ghost:hover { background:rgba(249,180,15,0.06); color:#f9b40f; }
.apr-btn-danger { background:linear-gradient(135deg,#ef4444,#f87171); color:#fff; box-shadow:0 3px 12px rgba(239,68,68,0.3); }
.apr-btn-danger:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(239,68,68,0.45); }

/* ── danger zone card ── */
.apr-danger-card {
    background:rgba(26,0,32,0.88); backdrop-filter:blur(24px);
    border:1px solid rgba(248,113,113,0.2); border-radius:18px;
    box-shadow:0 4px 32px rgba(0,0,0,0.35);
    overflow:hidden; margin-bottom:16px; animation:fadeUp .56s ease both;
}
.apr-danger-card::before {
    content:''; display:block; height:2px;
    background:linear-gradient(90deg,transparent,#ef4444,#f87171,transparent);
    background-size:200% 100%; animation:shimmerBar 3s ease-in-out infinite;
}
.apr-danger-header {
    padding:18px 28px 14px; border-bottom:1px solid rgba(248,113,113,0.1);
    display:flex; align-items:center; gap:12px;
    background:linear-gradient(to right,rgba(239,68,68,0.06),transparent);
}
.apr-danger-body { padding:24px 28px; }
.apr-danger-desc { font-size:0.75rem; color:rgba(255,251,240,0.45); line-height:1.7; margin-bottom:20px; }

/* ── delete modal ── */
.apr-modal-wrap { padding:28px; background:rgba(26,0,32,0.98); }
.apr-modal-icon { width:50px; height:50px; border-radius:14px; flex-shrink:0; background:rgba(248,113,113,0.1); border:1px solid rgba(248,113,113,0.2); display:flex; align-items:center; justify-content:center; font-size:1.1rem; color:#f87171; }
.apr-modal-title { font-family:'Playfair Display',serif; font-size:1.05rem; font-weight:900; color:#fffbf0; margin-bottom:3px; }
.apr-modal-sub   { font-size:0.7rem; color:rgba(255,251,240,0.4); }
.apr-modal-body  { font-size:0.75rem; color:rgba(255,251,240,0.5); line-height:1.7; margin:16px 0 20px; }
.apr-modal-btns  { display:flex; gap:10px; justify-content:flex-end; }
.apr-m-cancel { padding:9px 18px; border-radius:9px; cursor:pointer; background:transparent; border:1px solid rgba(249,180,15,0.18); color:rgba(249,180,15,0.55); font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700; transition:all .18s; }
.apr-m-cancel:hover { background:rgba(249,180,15,0.06); color:#f9b40f; }
.apr-m-delete { padding:9px 20px; border-radius:9px; cursor:pointer; background:linear-gradient(135deg,#ef4444,#f87171); border:none; color:#fff; font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:700; box-shadow:0 3px 10px rgba(239,68,68,0.3); transition:all .18s; }
.apr-m-delete:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(239,68,68,0.45); }
</style>
@endpush

<div class="apr-wrap">

    {{-- Page header --}}
    <div class="apr-page-header">
        <div>
            <h1 class="apr-page-title">My Profile</h1>
            <p class="apr-page-sub">Manage your account settings and credentials</p>
        </div>
    </div>

    {{-- ── Profile Information ── --}}
    <div class="apr-card" style="animation-delay:.06s;">
        <div class="apr-card-header">
            <div class="apr-card-icon" style="background:rgba(249,180,15,0.1);border:1px solid rgba(249,180,15,0.2);">
                <i class="fas fa-user" style="color:#f9b40f;"></i>
            </div>
            <div>
                <div class="apr-card-title">Profile Information</div>
                <div class="apr-card-sub">Update your name and email address</div>
            </div>
        </div>
        <div class="apr-card-body">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

            <form method="post" action="{{ route('admin.profile.update') }}" id="profile-form">
                @csrf @method('patch')

                <div style="display:flex;flex-direction:column;gap:18px;">
                    <div>
                        <label class="apr-label" for="name">Full Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" autofocus
                               value="{{ old('name', $user->name) }}"
                               class="apr-input">
                        @error('name', 'profileInformation')
                            <div class="apr-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="apr-label" for="email">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="username"
                               value="{{ old('email', $user->email) }}"
                               class="apr-input">
                        @error('email', 'profileInformation')
                            <div class="apr-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="apr-verify-notice">
                            <i class="fas fa-triangle-exclamation" style="font-size:.65rem;margin-right:4px;"></i>
                            Your email address is unverified.
                            <button form="send-verification" class="apr-verify-btn">Click here to re-send the verification email.</button>
                            @if (session('status') === 'verification-link-sent')
                            <div class="apr-verify-sent" style="margin-top:8px;">
                                <i class="fas fa-circle-check" style="font-size:.6rem;margin-right:4px;"></i>
                                A new verification link has been sent to your email address.
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <div style="display:flex;align-items:center;gap:14px;">
                        <button type="submit" class="apr-btn apr-btn-primary">
                            <i class="fas fa-floppy-disk" style="font-size:.7rem;"></i> Save Changes
                        </button>
                        @if (session('status') === 'profile-updated')
                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="apr-toast">
                            <i class="fas fa-circle-check" style="font-size:.6rem;"></i> Saved successfully
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Update Password ── --}}
    <div class="apr-card" style="animation-delay:.12s;">
        <div class="apr-card-header">
            <div class="apr-card-icon" style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2);">
                <i class="fas fa-lock" style="color:#60a5fa;"></i>
            </div>
            <div>
                <div class="apr-card-title">Update Password</div>
                <div class="apr-card-sub">Use a long, random password to stay secure</div>
            </div>
        </div>
        <div class="apr-card-body">
            <form method="post" action="{{ route('password.update') }}" id="password-form">
                @csrf @method('put')

                <div style="display:flex;flex-direction:column;gap:18px;">
                    <div>
                        <label class="apr-label" for="current_password">Current Password</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                               class="apr-input" placeholder="••••••••">
                        @error('current_password', 'updatePassword')
                            <div class="apr-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="apr-label" for="password">New Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password"
                               class="apr-input" placeholder="••••••••">
                        @error('password', 'updatePassword')
                            <div class="apr-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="apr-label" for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                               class="apr-input" placeholder="••••••••">
                        @error('password_confirmation', 'updatePassword')
                            <div class="apr-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;align-items:center;gap:14px;">
                        <button type="submit" class="apr-btn apr-btn-primary">
                            <i class="fas fa-key" style="font-size:.7rem;"></i> Update Password
                        </button>
                        @if (session('status') === 'password-updated')
                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="apr-toast">
                            <i class="fas fa-circle-check" style="font-size:.6rem;"></i> Password updated
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Danger Zone ── --}}
    <div class="apr-danger-card" style="animation-delay:.18s;">
        <div class="apr-danger-header">
            <div class="apr-card-icon" style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);">
                <i class="fas fa-triangle-exclamation" style="color:#f87171;"></i>
            </div>
            <div>
                <div class="apr-card-title" style="color:#f87171;">Delete Account</div>
                <div class="apr-card-sub">Permanently remove your account and all data</div>
            </div>
        </div>
        <div class="apr-danger-body">
            <p class="apr-danger-desc">
                Once your account is deleted, all of its resources and data will be permanently removed.
                Before deleting your account, please download any data or information you wish to retain.
            </p>
            <button type="button"
                    class="apr-btn apr-btn-danger"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                <i class="fas fa-trash" style="font-size:.7rem;"></i> Delete Account
            </button>
        </div>
    </div>

</div>

{{-- Delete modal --}}
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('admin.profile.destroy') }}">
        @csrf @method('delete')
        <div class="apr-modal-wrap">
            <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:4px;">
                <div class="apr-modal-icon"><i class="fas fa-user-slash"></i></div>
                <div>
                    <div class="apr-modal-title">Delete Your Account?</div>
                    <div class="apr-modal-sub">This action cannot be undone.</div>
                </div>
            </div>
            <p class="apr-modal-body">
                Once your account is deleted, all of its resources and data will be permanently removed.
                Please enter your password to confirm you would like to permanently delete your account.
            </p>

            <div style="margin-bottom:20px;">
                <label class="apr-label" for="delete_password">Password</label>
                <input id="delete_password" name="password" type="password"
                       class="apr-input" placeholder="Enter your password to confirm">
                @error('password', 'userDeletion')
                    <div class="apr-error"><i class="fas fa-circle-exclamation" style="font-size:.6rem;"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="apr-modal-btns">
                <button type="button" class="apr-m-cancel" x-on:click="$dispatch('close')">Cancel</button>
                <button type="submit" class="apr-m-delete">
                    <i class="fas fa-trash" style="font-size:.62rem;margin-right:4px;"></i> Delete Account
                </button>
            </div>
        </div>
    </form>
</x-modal>

</x-app-layout>