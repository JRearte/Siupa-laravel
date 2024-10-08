import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/alerta.css',
                'resources/css/app.css', 
                'resources/css/Login.css',
                'resources/css/principal.css',
                'resources/css/formulario.css',
                'resources/css/sidebar.css',
                'resources/css/tabla.css',
                'resources/css/presentacion.css'],
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
