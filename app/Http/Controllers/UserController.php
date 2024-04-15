<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCrudResource;
//HELPERS
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Creazione della query per ottenere i progetti
        $query = User::query();
        $sortDirection = request("sort_direction","desc");
        $sortField = request("sort_field","created_at");

        // Filtraggio dei progetti in base al nome
        if(request('name')) {
            $query = $query->where('name', 'like', '%' . request('name') . '%');
        }
        // Filtraggio dei progetti in base alla email
        if(request('email')) {
            $query = $query->where('email', 'like', '%' . request('email') . '%');
        }


        // Paginazione dei risultati e impostazione del numero di pagine visualizzate sui lati
        $users = $query->orderBy($sortField, $sortDirection)->paginate(10)->onEachSide(1);

        return Inertia("User/Index", [
            "users" => UserCrudResource::collection($users),
            'queryParams' => request()->query() ?: null,/*passa i parametri della query string alla vista. La funzione request()->query() restituisce un array associativo contenente tutti i parametri della query string dell'URL corrente. Se non ci sono parametri, viene restituito null. */
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("User/Create");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return to_route('user.index')->with('success',"User was Created!");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
