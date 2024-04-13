<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Creazione della query per ottenere i progetti
        $query = Task::query();

        $sortDirection = request("sort_direction","desc");
        $sortField = request("sort_field","created_at");

        // Filtraggio dei progetti in base al nome
        if(request('name')) {
            $query = $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Filtraggio dei progetti in base allo stato
        if(request('status')) {
            $query = $query->where('status', request('status'));
        }
    // Paginazione dei risultati e impostazione del numero di pagine visualizzate sui lati
    $tasks = $query->orderBy($sortField, $sortDirection)->paginate(10)->onEachSide(1);

    return Inertia("Task/Index", [
        "tasks" => TaskResource::collection($tasks),
        'queryParams' => request()->query() ?: null,/*passa i parametri della query string alla vista. La funzione request()->query() restituisce un array associativo contenente tutti i parametri della query string dell'URL corrente. Se non ci sono parametri, viene restituito null. */
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
