import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, // enables HMR in dev
        }),
        tailwindcss(),
    ],
    build: {
        // manifest: true,         // generates manifest.json (important for Laravel)
        outDir: 'public/build', // output directory for production
        // emptyOutDir: true,
    },
    base: process.env.VITE_ASSET_URL || '/',  // <--- important!
});
