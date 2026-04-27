import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/public-pages.css',
                'resources/css/welcome.css',
                'resources/css/admin/dashboard.css',
                'resources/css/voter/ballot/step.css',
                'resources/css/voter/dashboard.css',
                'resources/css/auth/login.css',
                'resources/js/app.js',
                'resources/js/public-pages.js',
                'resources/js/welcome.js',
            ],
            refresh: true,
        }),
    ],

    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
        hmr: {
            host: '127.0.0.1',
            protocol: 'ws',
            clientPort: 5173,
        },
    },
});