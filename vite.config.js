import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/Login.css',
                'resources/css/Menu.css',
                'resources/css/Formulario.css',
                'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
