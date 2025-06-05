import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'resources/routes/**',
                'routes/**',
                'resources/views/**',
                'resources/css/rumah-sakit/detail.css',
                'resources/js/rumah-sakit/detail.js'
            ],
        }),
        tailwindcss(),
    ],
});
