<!----------------------------------------------------------------------------------------------------------------------------->
MILESTONE 1: INSTALLAZIONE PACCHETTI

        - composer create-project laravel/laravel .
        - composer require laravel/breeze --dev 
        - php artisan breeze:install

        - Generiamo dal comando del Model,Factory e Migration tramite:
            - php artisan make:model Project -fm
            - php artisan make:model Task -fm

        - creiamo i controller che ci fanno utilizzare sia le request che le resource
            - php artisan make:controller ProjectController --model=Project --requests --resource

        - Creiamo un Resource:
            - php artisan make:resource ProjectResource

        - E LE VARIE MIGRAZIONI, SEEDER, CONTROLLER AGGIUNTIVI + 
            -php artisan tinker
<!----------------------------------------------------------------------------------------------------------------------------->
Milestone 2: Frontend React

    Creazione dei Componenti React: Abbiamo creato componenti React per gestire l'interfaccia utente, come Pagination.jsx, SelectInput.jsx,
    TextInput.jsx utilizzando JSX e CSS per lo stile.

    Integrazione di Inertia.js: Abbiamo integrato Inertia.js nei nostri componenti React utilizzando il metodo Inertia.get(), Inertia.post() 
    per effettuare richieste HTTP al backend Laravel e aggiornare le viste senza ricaricare completamente la pagina.
<!----------------------------------------------------------------------------------------------------------------------------->

Milestone 3: Backend Laravel

    Creazione di Controller e Route: Abbiamo creato controller per gestire le richieste dell'API dall'applicazione React, come ProjectController, 
    e abbiamo definito le route corrispondenti nel file web.php.

    Creazione di Risorse API: Abbiamo creato risorse API come ProjectResource per trasformare i dati prima di restituirli all'applicazione frontend,
    garantendo che solo i campi desiderati vengano inclusi nella risposta JSON.
<!----------------------------------------------------------------------------------------------------------------------------->

Milestone 4: Integrazione dei Dati

    Generazione di Dati di Esempio: Abbiamo utilizzato le factory di Laravel per generare dati di esempio per i progetti e gli utenti. Le factory 
    ci hanno permesso di popolare il database con dati fittizi per scopi di sviluppo e testing.

    Recupero e Trasformazione dei Dati: Nel controller ProjectController, abbiamo recuperato i dati necessari dal database utilizzando Eloquent ORM 
    e li abbiamo trasformati utilizzando le risorse API come ProjectResource prima di restituirli all'applicazione frontend.
<!----------------------------------------------------------------------------------------------------------------------------->

Milestone 5: Gestione della Navigazione

    Navigazione tra le Pagine: Abbiamo gestito la navigazione tra le diverse pagine dell'applicazione utilizzando Inertia.js, aggiungendo i link 
    alle diverse viste e consentendo agli utenti di spostarsi tra le pagine senza dover ricaricare completamente l'applicazione.
<!----------------------------------------------------------------------------------------------------------------------------->
Milestone 6: Codice quasi tutto commentato per una legibilità maggiore.
