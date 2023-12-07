import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from "path";

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: [
                // CSS
                'resources/sass/app.scss',
                'resources/sass/admin.scss',
                'resources/sass/event.scss',
                'resources/sass/event-job.scss',
                'resources/sass/event-auth.scss',
                'resources/sass/game.scss',
                // JS
                // 'resources/js/app.js',
                // 'resources/js/admin/adminapp.js',
                'resources/js/admin.js',
                'resources/js/event.js',
                'resources/js/game.js',
                //'resources/css/mail.css',

                'resources/js/connect-wallet.jsx',
                'resources/js/deposit.jsx',
                'resources/js/deposit-wallet.jsx',
                'resources/js/ModalWallet.jsx',
                'resources/js/connect-wallet-admin.jsx',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '@': path.resolve(__dirname, 'resources/assets'),
            '@nm': path.resolve(__dirname, 'node_modules'),
        }
    },
});
