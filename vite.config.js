import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                './resources/css/game/*.sass',
                './resources/css/*.sass',
                './resources/js/game/*.ts'
            ],
            refresh: true,
        }),
    ],
});
