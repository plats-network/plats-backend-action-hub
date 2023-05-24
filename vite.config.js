import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/sass/app.scss',
                'resources/sass/admin.scss',
                // JS
                // 'resources/js/app.js',
                'resources/js/admin/adminapp.js',
                'resources/js/admin.js',
                'resources/js/admin/cws/event.js',
            ],
            refresh: true,
        }),
    ],
});
