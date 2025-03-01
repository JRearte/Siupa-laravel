import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/Login.css',
                'resources/css/principal.css',
                'resources/css/sidebar.css',
                'resources/css/tabla.css',
                'resources/css/historial.css',
                'resources/css/estadistica.css',
                'resources/css/formulario.css',
                'resources/css/presentacion.css',
                'resources/css/calendario.css',
                'resources/js/app.js',
                'resources/js/grafico.js',
                'resources/js/grafico-barra.js',
                'resources/js/toast.js',
                'resources/js/menu_desplegable.js',
                'resources/js/dropdowns.js'],
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
