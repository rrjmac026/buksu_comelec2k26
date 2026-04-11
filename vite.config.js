import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/welcome.css',
                'resources/css/admin/dashboard.css',
                'resources/css/voter/ballot/step.css',
                'resources/css/voter/dashboard.css',
                'resources/css/auth/login.css',
                'resources/js/app.js',
                'resources/js/welcome.js',
            ],
            refresh: true,
        }),
    ],

    // server: {
    //     host: '0.0.0.0',
    //     port: 5173,
    //     strictPort: true,
    //     cors: true,
    //     hmr: {
    //         host: 'nonadjunctive-severely-rosemary.ngrok-free.dev',
    //         protocol: 'wss',
    //         clientPort: 443,
    //     },
    // },
});