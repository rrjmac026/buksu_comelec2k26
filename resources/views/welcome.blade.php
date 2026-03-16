<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background:#1e0025;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Voting System') }}</title>
        <link rel="icon" href="{{ asset('images/tab_icon.png') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/css/welcome.css', 'resources/js/app.js', 'resources/js/welcome.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="antialiased" style="background:#1e0025;min-height:100vh;display:flex;flex-direction:column;" x-data>

        {{-- Nav --}}
        @if (Route::has('login'))
        <nav style="position:fixed;top:0;left:0;right:0;z-index:50;height:60px;display:flex;align-items:center;padding:0 32px;background:rgba(26,0,32,0.9);backdrop-filter:blur(20px);border-bottom:1px solid rgba(249,180,15,0.2);">
            <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;flex:1;">
                <img src="{{ asset('assets/app_logo.png') }}" 
                    style="height:38px;width:38px;object-fit:cover;border-radius:8px;border:1.5px solid rgba(249,180,15,0.4);">
                <span style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#fffbf0;">
                    {{ config('app.name', 'BukSU') }} <span style="color:#f9b40f;">System</span>
                </span>
            </a>
            <div>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:8px;font-size:0.82rem;font-weight:600;text-decoration:none;color:#380041;background:linear-gradient(135deg,#f9b40f,#fcd558);font-family:'DM Sans',sans-serif;"><i class="fas fa-shield-halved"></i> Admin Dashboard</a>
                    @elseif(Auth::user()->role === 'voter')
                        <a href="{{ route('voter.dashboard') }}" style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:8px;font-size:0.82rem;font-weight:600;text-decoration:none;color:#380041;background:linear-gradient(135deg,#f9b40f,#fcd558);font-family:'DM Sans',sans-serif;"><i class="fas fa-vote-yea"></i> Voter Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:8px;font-size:0.82rem;font-weight:600;text-decoration:none;color:#380041;background:linear-gradient(135deg,#f9b40f,#fcd558);font-family:'DM Sans',sans-serif;"><i class="fas fa-right-to-bracket"></i> Login</a>
                @endauth
            </div>
        </nav>
        @endif

        <div style="padding-top:60px;flex:1;display:flex;flex-direction:column;">

            <div class="outer">
                <div class="grid-bg"></div>

                <div class="two-col">

                    <!-- ── LEFT: Vote Matters ── -->
                    <div class="panel left-panel">
                        <div class="eyebrow"><div class="eyebrow-dot"></div> Trusted Online Voting Platform</div>
                        <div class="gold-rule"></div>
                        <h1 class="hero-h1">Your Vote <span class="h1-accent">Matters</span></h1>
                        <p class="hero-lead">Welcome to our Online Voting System — ensuring fair, transparent, and secure elections for every student voice.</p>
                        <div class="logo-showcase">
                            <div class="logo-img-wrap">
                                <div class="logo-glow"></div>
                                <img src="{{ asset('assets/app_logo.png') }}" alt="Logo" class="logo-img">
                            </div>
                            <div class="logo-chips">
                                <span class="logo-chip"><i class="fas fa-shield-alt" style="font-size:0.58rem"></i> Secure</span>
                                <span class="logo-chip"><i class="fas fa-eye" style="font-size:0.58rem"></i> Transparent</span>
                                <span class="logo-chip"><i class="fas fa-bolt" style="font-size:0.58rem"></i> Real-time</span>
                                <span class="logo-chip"><i class="fas fa-user-secret" style="font-size:0.58rem"></i> Anonymous</span>
                            </div>
                        </div>

                        <div class="stats-bar">
                            <div class="s-item"><div class="s-num">99.9%</div><div class="s-lbl">Uptime</div></div>
                            <div class="s-item"><div class="s-num">256-bit</div><div class="s-lbl">Encrypted</div></div>
                            <div class="s-item"><div class="s-num" id="stat-votes-cast">0</div><div class="s-lbl">Votes Cast</div></div>
                            <div class="s-item"><div class="s-num">Anon</div><div class="s-lbl">Ballots</div></div>
                        </div>
                    </div>

                    <!-- ── RIGHT: Team slider ── -->
                    <div class="panel right-panel">
                        <div class="right-header">
                            <div class="right-eyebrow"><i class="fas fa-laptop-code" style="font-size:0.55rem"></i>&nbsp; System Developers</div>
                            <div class="right-title">Meet the <span class="h1-accent">IT Team</span></div>
                            <div class="right-sub">The people who built this platform</div>
                        </div>

                        <div class="progress-wrap"><div class="progress-bar" id="pbar" style="width:0%"></div></div>

                        <div class="slide-viewport">
                            <div class="slide-strip" id="strip">

                                <!-- Dev 1 -->
                                <div class="member-slide">
                                    <div class="avatar-wrap">
                                        <div class="avatar av1"><img src="{{ asset('assets/team/dev1.jpg') }}" alt="Dev 1" onerror="this.parentElement.innerHTML='JD'"></div>
                                        <div class="spin-ring"></div>
                                        <div class="member-num">1</div>
                                    </div>
                                    <div class="member-name">Rey Rameses Jude "Jam" Macalutas III</div>
                                    <div class="member-role">System Developer / Lead Developer</div>
                                    <div class="contrib-bar">
                                        <div class="contrib-label">Key Contributions</div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Built the full-stack system end-to-end</div></div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Designed the overall look & feel of the app</div></div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Kept the codebase clean & running solid</div></div>
                                    </div>
                                </div>

                                <!-- Dev 2 -->
                                <div class="member-slide">
                                    <div class="avatar-wrap">
                                        <div class="avatar av2"><img src="{{ asset('assets/team/dev2.jpg') }}" alt="Dev 2" onerror="this.parentElement.innerHTML='MS'"></div>
                                        <div class="spin-ring"></div>
                                        <div class="member-num">2</div>
                                    </div>
                                    <div class="member-name">Khyle Ivan Kim Amacna</div>
                                    <div class="member-role">Head System Developer</div>
                                    <div class="contrib-bar">
                                        <div class="contrib-label">Key Contributions</div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Led the team & kept everything moving</div></div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Crafted intuitive UI/UX experiences</div></div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Made sure every screen looks just right</div></div>
                                    </div>
                                </div>

                                <!-- Dev 3 -->
                                <div class="member-slide">
                                    <div class="avatar-wrap">
                                        <div class="avatar av3"><img src="{{ asset('assets/team/dev3.jpg') }}" alt="Dev 3" onerror="this.parentElement.innerHTML='AR'"></div>
                                        <div class="spin-ring"></div>
                                        <div class="member-num">3</div>
                                    </div>
                                    <div class="member-name">Bernardo DeLa Cerna Jr.</div>
                                    <div class="member-role">System Developer / QA</div>
                                    <div class="contrib-bar">
                                        <div class="contrib-label">Key Contributions</div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Tested & caught bugs before they cause trouble</div></div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Handled & cleaned up all the messy data</div></div>
                                        <div class="contrib-item"><div class="contrib-dot"></div><div class="contrib-text">Made sure the numbers always add up right</div></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="right-footer">
                            <span class="slide-counter" id="counter">1 / 3</span>
                            <div class="dots" id="dots"></div>
                            <div class="nav-btns">
                                <button class="nav-btn" id="prevBtn" onclick="go(-1)" disabled><i class="fas fa-chevron-up"></i></button>
                                <button class="nav-btn" id="nextBtn" onclick="go(1)"><i class="fas fa-chevron-down"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <footer style="background:rgba(26,0,32,0.95);border-top:1px solid rgba(249,180,15,0.15);text-align:center;padding:16px 40px;">
            <p style="color:rgba(255,251,240,0.45);font-size:0.8rem;margin:0;">
                &copy; {{ date('Y') }} <span style="color:#f9b40f;font-weight:700;">{{ config('app.name', 'Voting System') }}.</span> All rights reserved.
            </p>
        </footer>

    </body>
</html>