<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
        ];
    }
}
/*
    Questo middleware gestisce le richieste Inertia per l'applicazione. Qui sono definite due funzioni principali:

    version(Request $request): string|null: Questo metodo determina la versione corrente delle risorse dell'applicazione.

    share(Request $request): array: Questo metodo definisce le proprietà che vengono condivise di default con tutte le pagine
    dell'applicazione. In questo caso, viene condiviso il valore dell'utente autenticato nell'array auth.
 */
