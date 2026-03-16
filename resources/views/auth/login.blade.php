<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — {{ config('app.name', 'Voting System') }}</title>
    <link rel="icon" href="{{ asset('images/tab_icon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css','resources/css/auth/login.css', 'resources/js/app.js'])

</head>
    <body class="antialiased" x-data>

        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="grid-lines"></div>

        {{-- ── Navigation ── --}}
        <nav class="top-nav">
            <a href="/" class="nav-logo">
                <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" />
                <span class="nav-app-name">
                    {{ config('app.name', 'BukSU') }} <span class="accent">System</span>
                </span>
            </a>
            <a href="/" class="btn-nav-ghost">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </nav>

        {{-- ── Main ── --}}
        <div class="page-wrap">
            <div class="login-container">

                {{-- ── Left side ── --}}
                <div class="login-side">
                    <div class="side-grid"></div>

                    <div class="side-top">
                        <div class="side-logo-wrap">
                            <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" class="side-logo-img">
                            <span class="side-app-name">{{ config('app.name', 'BukSU') }} <span>System</span></span>
                        </div>

                        <div class="side-gold-rule"></div>
                        <h2 class="side-headline">
                            Your Vote <span class="hl-accent">Shapes</span><br>the Future
                        </h2>
                        <p class="side-lead">
                            Secure, transparent, and fair — every voice counts in our digital democracy platform.
                        </p>

                        <div class="side-features">
                            <div class="side-feat">
                                <div class="side-feat-icon"><i class="fas fa-shield-alt"></i></div>
                                <div>
                                    <div class="side-feat-title">End-to-End Encrypted</div>
                                    <div class="side-feat-desc">Your ballot is secured with SHA-256 hashing and unique transaction numbers.</div>
                                </div>
                            </div>
                            <div class="side-feat">
                                <div class="side-feat-icon"><i class="fas fa-chart-bar"></i></div>
                                <div>
                                    <div class="side-feat-title">Live Results</div>
                                    <div class="side-feat-desc">Real-time vote tallying with transparent, verifiable outcomes.</div>
                                </div>
                            </div>
                            <div class="side-feat">
                                <div class="side-feat-icon"><i class="fas fa-user-secret"></i></div>
                                <div>
                                    <div class="side-feat-title">Anonymous Ballots</div>
                                    <div class="side-feat-desc">Your identity is protected — only your vote is recorded.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="side-bottom">
                    </div>
                </div>

                {{-- ── Right form side ── --}}
                <div class="login-form-side">

                    @if (session('status'))
                        <div class="session-status">
                            <i class="fas fa-circle-check" style="margin-right:6px;"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Role Toggle --}}
                    <div class="role-toggle" role="tablist">
                        <button class="role-btn active" id="tab-voter" role="tab" aria-selected="true" onclick="switchRole('voter')" type="button">
                            <i class="fas fa-vote-yea"></i> Voter Login
                        </button>
                        <button class="role-btn" id="tab-admin" role="tab" aria-selected="false" onclick="switchRole('admin')" type="button">
                            <i class="fas fa-shield-halved"></i> Admin Login
                        </button>
                    </div>

                    {{-- ── VOTER PANEL ── --}}
                    <div class="form-panel" id="panel-voter">
                        <div class="form-eyebrow">
                            <div class="eyebrow-dot"></div> Voter Portal
                        </div>
                        <h1 class="form-heading">Welcome <span class="h-accent">Back</span></h1>
                        <p class="form-subtext">Sign in with your Google account to cast your vote and view election results.</p>

                        {{-- Session errors (e.g. inactive account, admin tried Google login) --}}
                        @if (session('error'))
                            <div class="field-error" style="margin-bottom: 1rem;">
                                <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
                            </div>
                        @endif

                        <div class="google-login-wrapper">
                            <a href="{{ route('auth.google') }}" class="google-btn">
                                <svg class="google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span>Continue with Google</span>
                            </a>

                            <p class="google-hint">
                                <i class="fas fa-shield-halved"></i>
                                Only registered student accounts are allowed to vote.
                            </p>
                        </div>
                    </div>

                    {{-- ── ADMIN PANEL ── --}}
                    <div class="form-panel hidden" id="panel-admin">
                        <div class="form-eyebrow" style="background:rgba(249,180,15,0.06);border-color:rgba(249,180,15,0.2);">
                            <div class="eyebrow-dot"></div> Admin Portal
                        </div>
                        <h1 class="form-heading">Admin <span class="h-accent">Access</span></h1>
                        <p class="form-subtext">Restricted area — authorized administrators only.</p>

                        <div class="admin-badge visible">
                            <div class="admin-badge-icon"><i class="fas fa-shield-halved"></i></div>
                            <div><strong>Secure Admin Login</strong> — All access is logged and monitored.</div>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="login_as" value="admin">

                            <div class="field-group">
                                <label class="field-label" for="admin_email">Admin Email</label>
                                <div class="input-wrap">
                                    <i class="fas fa-id-badge input-icon"></i>
                                    <input id="admin_email" name="email" type="email" class="field-input"
                                        placeholder="admin@domain.com" value="{{ old('email') }}"
                                        required autocomplete="username" />
                                </div>
                                @error('email')
                                    <div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="field-label" for="admin_password">Admin Password</label>
                                <div class="input-wrap">
                                    <i class="fas fa-key input-icon"></i>
                                    <input id="admin_password" name="password" type="password" class="field-input"
                                        placeholder="••••••••" required autocomplete="current-password" />
                                </div>
                                @error('password')
                                    <div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-row-mid">
                                <label class="remember-label">
                                    <input type="checkbox" name="remember" class="remember-cb"> Remember me
                                </label>
                            </div>

                            <button type="submit" class="submit-btn admin-mode">
                                <i class="fas fa-shield-halved"></i> Sign In as Admin
                            </button>
                        </form>
                    </div>

                    <a href="/" class="back-link">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>

                </div>

            </div>
        </div>

        {{-- Footer --}}
        <footer>
            <div style="max-width:1220px;margin:0 auto;padding:16px 40px;text-align:center;">
                <p>
                    © {{ date('Y') }} <span class="footer-accent">{{ config('app.name', 'Voting System') }}.</span>
                    All rights reserved.
                </p>
            </div>
        </footer>

        <script>
            function switchRole(role) {
                const voterTab   = document.getElementById('tab-voter');
                const adminTab   = document.getElementById('tab-admin');
                const voterPanel = document.getElementById('panel-voter');
                const adminPanel = document.getElementById('panel-admin');

                if (role === 'voter') {
                    voterTab.classList.add('active');    adminTab.classList.remove('active');
                    voterPanel.classList.remove('hidden'); adminPanel.classList.add('hidden');
                    voterTab.setAttribute('aria-selected', 'true');
                    adminTab.setAttribute('aria-selected', 'false');
                } else {
                    adminTab.classList.add('active');    voterTab.classList.remove('active');
                    adminPanel.classList.remove('hidden'); voterPanel.classList.add('hidden');
                    adminTab.setAttribute('aria-selected', 'true');
                    voterTab.setAttribute('aria-selected', 'false');
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                if ("{{ old('login_as') }}" === 'admin') switchRole('admin');
            });
        </script>
        <script>
            // Apply saved theme immediately to prevent flash
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            document.addEventListener('alpine:init', () => {
                Alpine.store('darkMode', {
                    init() {
                        const theme = localStorage.getItem('theme');
                        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        this.on = theme === 'dark' || (!theme && prefersDark);
                        document.documentElement.classList.toggle('dark', this.on);
                    },
                    on: false,
                    toggle() {
                        this.on = !this.on;
                        localStorage.setItem('theme', this.on ? 'dark' : 'light');
                        document.documentElement.classList.toggle('dark', this.on);
                    }
                });
            });
        </script>

    </body>
</html>