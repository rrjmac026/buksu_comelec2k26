<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Voting System') }}</title>
        <link rel="icon" href="{{ asset('images/tab_icon.png') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;0,900;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/css/public-pages.css', 'resources/js/app.js', 'resources/js/public-pages.js'])
    </head>
    <body class="public-body antialiased">
        @php
            $page = $activePage ?? '';
            $navItems = [
                ['route' => 'home', 'label' => 'Home', 'key' => 'home'],
                ['route' => 'public.about', 'label' => 'About', 'key' => 'about'],
                ['route' => 'public.elections', 'label' => 'Elections', 'key' => 'elections'],
                ['route' => 'public.how-it-works', 'label' => 'How It Works', 'key' => 'how'],
                ['route' => 'public.contact', 'label' => 'Contact', 'key' => 'contact'],
            ];
        @endphp

        @if (Route::has('login'))
            <nav class="public-nav">
                <a href="{{ route('home') }}" class="public-brand">
                    <img src="{{ asset('assets/app_logo.png') }}" class="public-logo" alt="{{ config('app.name') }}">
                    <div class="public-brand-copy">
                        <span class="public-brand-name">BukSU COMELEC</span>
                        <span class="public-brand-tagline">Online Voting System</span>
                    </div>
                </a>

                <div class="public-nav-links">
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}" class="public-nav-link {{ $page === $item['key'] ? 'is-active' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                <div class="public-nav-actions">
                    <div class="public-live-badge" id="global-live-badge">
                        <span class="public-live-dot"></span>
                        <span>LIVE SYSTEM</span>
                    </div>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="public-cta-btn">
                                <i class="fas fa-shield-halved"></i> <span>Admin Dashboard</span>
                            </a>
                        @elseif(Auth::user()->role === 'voter')
                            <a href="{{ route('voter.dashboard') }}" class="public-cta-btn">
                                <i class="fas fa-vote-yea"></i> <span>Voter Dashboard</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="public-cta-btn">
                            <i class="fas fa-right-to-bracket"></i> <span>Login</span>
                        </a>
                    @endauth
                </div>
            </nav>
        @endif

        <main class="public-main">
            @yield('content')
        </main>

        <footer class="public-footer">
            <div class="public-footer-inner">
                <div class="public-footer-left">
                    <i class="fas fa-shield-halved"></i>
                    &copy; {{ date('Y') }} <strong>{{ config('app.name', 'BukSU COMELEC') }}.</strong> All rights reserved.
                </div>
                <div class="public-footer-right">
                    Built for secure and transparent student elections.
                    <i class="fas fa-heart"></i>
                </div>
            </div>
        </footer>

        <div class="toast-stack" id="toast-stack"></div>
    </body>
</html>
