<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/admin/dashboard.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }

            document.addEventListener('alpine:init', () => {
                Alpine.store('sidebar', {
                    isOpen: window.innerWidth >= 1024,
                    toggle() { this.isOpen = !this.isOpen; }
                });

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

        <style>
            [x-cloak] { display: none !important; }
            *, *::before, *::after { box-sizing: border-box; }
            html, body { overflow-x: hidden; max-width: 100vw; }

            @media (max-width: 640px)  { html { font-size: 14px; } }
            @media (min-width: 641px) and (max-width: 768px) { html { font-size: 15px; } }
            @media (min-width: 769px) { html { font-size: 16px; } }
        </style>

        @stack('styles')
    </head>
    @php
        $isVoter = auth()->check() && auth()->user()->role === 'voter';
        $rawElectionStatus = $isVoter ? ($electionStatus ?? \App\Models\ElectionSetting::status()) : null;
        $normalizedElectionStatus = $rawElectionStatus === 'upcoming' ? 'not_started' : $rawElectionStatus;
        $blockedStatus = session('election_blocked');
    @endphp

    <body class="font-sans antialiased dark bg-[#0f0a1e]"
          data-election-status="{{ $normalizedElectionStatus }}"
          data-election-blocked="{{ $blockedStatus }}"
          :class="{ 'dark bg-[#0f0a1e]': $store.darkMode.on, 'bg-violet-50/40': !$store.darkMode.on }">
        <div class="min-h-screen flex flex-col w-full">

            @include('layouts.navigation')

            <div class="flex flex-1 relative">
                @include('layouts.sidebar')

                <div class="flex-1 transition-all duration-300 ease-in-out w-full"
                     :class="{
                         'lg:pl-72': $store.sidebar.isOpen,
                         'pl-0': !$store.sidebar.isOpen
                     }">

                    @isset($header)
                        <header class="bg-white/80 dark:bg-violet-950/80 backdrop-blur-md shadow-sm border-b border-violet-100 dark:border-violet-900/50">
                            <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <main class="py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8 w-full">
                        @hasSection('content')
                            @yield('content')
                        @else
                            {{ $slot ?? '' }}
                        @endif
                    </main>
                </div>
            </div>
        </div>

        @stack('modals')
        @stack('scripts')
        <style>
            .vote-guard-toast {
                position: fixed;
                top: 82px;
                right: 20px;
                z-index: 100000;
                width: min(420px, calc(100vw - 32px));
                border-radius: 14px;
                border: 1px solid rgba(249, 180, 15, 0.35);
                background: linear-gradient(145deg, rgba(34, 0, 52, 0.97), rgba(20, 0, 33, 0.97));
                box-shadow: 0 14px 42px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(249, 180, 15, 0.08) inset;
                display: none;
                transform: translateY(-10px);
                opacity: 0;
                transition: opacity 0.2s ease, transform 0.2s ease;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }

            .vote-guard-toast.show {
                display: block;
                opacity: 1;
                transform: translateY(0);
            }

            .vote-guard-toast-content {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 14px 16px;
                color: #fffbf0;
            }

            .vote-guard-toast-icon {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(249, 180, 15, 0.15);
                border: 1px solid rgba(249, 180, 15, 0.3);
                color: #f9b40f;
            }

            .vote-guard-toast-title {
                margin: 0 0 4px;
                font-size: 0.86rem;
                font-weight: 800;
                color: #fcd558;
            }

            .vote-guard-toast-message {
                margin: 0;
                font-size: 0.75rem;
                line-height: 1.55;
                color: rgba(255, 251, 240, 0.78);
            }
        </style>

        <div id="vote-guard-toast" class="vote-guard-toast" role="status" aria-live="polite">
            <div class="vote-guard-toast-content">
                <div class="vote-guard-toast-icon"><i class="fas fa-hourglass-half"></i></div>
                <div>
                    <p id="vote-guard-toast-title" class="vote-guard-toast-title"></p>
                    <p id="vote-guard-toast-message" class="vote-guard-toast-message"></p>
                </div>
            </div>
        </div>

        <script>
            (function () {
                const electionStatus = document.body.dataset.electionStatus;
                const blockedStatus = document.body.dataset.electionBlocked;
                const toast = document.getElementById('vote-guard-toast');
                const toastTitle = document.getElementById('vote-guard-toast-title');
                const toastMessage = document.getElementById('vote-guard-toast-message');
                const toastIcon = toast?.querySelector('.vote-guard-toast-icon i');
                let toastTimer = null;

                function normalize(status) {
                    return status === 'upcoming' ? 'not_started' : status;
                }

                function getCopy(status) {
                    if (status === 'ended') {
                        return {
                            icon: 'fa-flag-checkered',
                            title: 'Voting Closed',
                            message: 'The election has already ended. Thank you for your participation.'
                        };
                    }

                    return {
                        icon: 'fa-hourglass-half',
                        title: 'Voting Not Yet Started',
                        message: 'The election has not started yet. Voting will be available once it begins.'
                    };
                }

                function showGuardToast(status) {
                    if (!toast || !toastTitle || !toastMessage) return;
                    const copy = getCopy(normalize(status));
                    if (toastIcon) toastIcon.className = `fas ${copy.icon}`;
                    toastTitle.textContent = copy.title;
                    toastMessage.textContent = copy.message;
                    toast.classList.add('show');
                    clearTimeout(toastTimer);
                    toastTimer = setTimeout(() => toast.classList.remove('show'), 4000);
                }

                document.addEventListener('click', (event) => {
                    const voteLink = event.target.closest('[data-election-guard="vote"]');
                    if (!voteLink) return;

                    const status = normalize(electionStatus);
                    if (status === 'not_started' || status === 'ended') {
                        event.preventDefault();
                        showGuardToast(status);
                    }
                });

                if (blockedStatus) {
                    showGuardToast(blockedStatus);
                }
            })();
        </script>
    </body>
</html>