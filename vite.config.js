import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/dashboard.css',
                'resources/js/app.js',
                'resources/css/accountchoice.css',
                'resources/css/compteInfo.css',
                'resources/css/gestionComptes.css',
                'resources/css/gestionDemandes.css',
                'resources/css/gestionTransactions.css',
                'resources/css/pdfHisto.css'
            ],
            refresh: true,
        }),
    ],
});
