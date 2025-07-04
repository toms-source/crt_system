import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    //to listen the front end on other device 
    server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
        hmr: {
        host: '192.168.1.3', // if you're listening on another network change this Ipv4
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
