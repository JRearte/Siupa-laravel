import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/Login.css',
                'resources/css/Menu.css',
                'resources/css/sidebar.css',
                'resources/css/Principal.css',
                'resources/css/Formulario.css'],
            refresh: true,
        }),
    ],
    /*server: {
        host: '0.0.0.0', //Escuchar en todas las interfaces de red
        port: 5173, //Puerto de Vite
        hmr: {
            host: '192.168.100.7', //Colocar IP local para que funcione el css y js
            port: 5173,
        },
    },*/
});
