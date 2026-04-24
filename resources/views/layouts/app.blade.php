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
    <body class="font-sans antialiased dark bg-[#0f0a1e]"
          :class="{ 'dark bg-[#0f0a1e]': $store.darkMode.on, 'bg-violet-50/40': !$store.darkMode.on }">
        <div class="min-h-screen flex flex-col w-full">

            @include('layouts.navigation')

            <div class="flex flex-1 relative">
                @include('layouts.sidebar')

                <div class="flex-1 pt-16 transition-all duration-300 ease-in-out w-full"
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
    </body>
</html>