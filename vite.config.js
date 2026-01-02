import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/profiles.css',
                'resources/css/privacy.css',
                'resources/css/profiles-admin.css',
                'resources/css/account.css',
                'resources/css/dashboard.css',
                'resources/css/catalog.css',
                'resources/css/register.css',
                'resources/css/welcome.css',
                'resources/css/settings.css',
                'resources/css/admin.css',
                'resources/css/ayuda.css',
                'resources/css/peliculas-admin-modal.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
     server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
    },
});


