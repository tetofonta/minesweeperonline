import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import * as path from "path"

export default defineConfig({
    plugins: [
        laravel({
            input: [
                './resources/css/**/*.sass',
                './resources/css/**/*.wolf2',
                './resources/js/**/*.ts',
                './resources/assets/**/*.png',
                './resources/assets/font-awesome-pro-v6/css/*.css',
                './resources/assets/font-awesome-pro-v6/webfonts/*',
            ],
            refresh: true,
        }),
    ]
});
