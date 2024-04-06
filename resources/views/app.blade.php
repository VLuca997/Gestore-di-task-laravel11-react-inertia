<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <!-- Imposta la codifica dei caratteri e la viewport -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Imposta il titolo della pagina utilizzando il nome dell'applicazione Laravel -->
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Collega il font utilizzato nell'applicazione -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Carica gli script -->
    @routes <!-- Definisce le rotte dell'applicazione -->
    @viteReactRefresh <!-- Aggiorna automaticamente l'applicazione React -->
    @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"]) <!-- Carica gli script Vite per l'applicazione -->
    @inertiaHead <!-- Carica le informazioni dell'head Inertia.js -->
</head>
<body class="font-sans antialiased">
    <!-- Contenitore per l'applicazione Inertia.js -->
    @inertia
</body>
</html>
