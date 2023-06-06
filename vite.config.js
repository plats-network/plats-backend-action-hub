import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/sass/app.scss',
                'resources/sass/admin.scss',
                'resources/sass/event.scss',
                'resources/sass/event-job.scss',
                'resources/sass/event-auth.scss',
                // JS
                // 'resources/js/app.js',
                // 'resources/js/admin/adminapp.js',
                'resources/js/admin.js',
                'resources/js/event.js',
            ],
            refresh: true,
        }),
    ],
});
