// Importa il file di bootstrap per caricare i pacchetti e le configurazioni necessarie per l'applicazione Laravel
import './bootstrap';

// Importa il file CSS dell'applicazione
import '../css/app.css';

// Importa la funzione createRoot da react-dom/client per creare la radice dell'applicazione React
import { createRoot } from 'react-dom/client';

// Importa la funzione createInertiaApp da @inertiajs/react per avviare un'applicazione Inertia.js
import { createInertiaApp } from '@inertiajs/react';

// Importa la funzione resolvePageComponent da laravel-vite-plugin/inertia-helpers per risolvere il componente della pagina Inertia.js
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// Definisce il nome dell'applicazione utilizzando il valore di VITE_APP_NAME se presente nell'ambiente Vite, altrimenti utilizza 'Laravel' come valore predefinito
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Avvia l'applicazione Inertia.js con le seguenti opzioni
createInertiaApp({
    // Aggiunge il nome dell'applicazione al titolo di ogni pagina
    title: (title) => `${title} - ${appName}`,

    // Risolve il componente della pagina Inertia.js utilizzando il percorso del file JSX corrispondente all'interno della cartella Pages
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),

    // Configura l'applicazione React, definendo come renderizzare l'applicazione nella radice specificata
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },

    // Configura il colore della barra di avanzamento dell'Inertia.js durante il caricamento delle pagine
    progress: {
        color: '#4B5563',
    },
});
