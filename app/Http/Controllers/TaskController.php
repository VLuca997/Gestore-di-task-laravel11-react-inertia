<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserCrudResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $projects = Project::query()->orderBy('name','asc')->get();
        $users = User::query()->orderBy('name','asc')->get();

        return inertia("Task/Create",[
            'projects' => ProjectResource::collection($projects),//prendiamo la collezione completa
            'users'=> UserCrudResource::collection($users),//prendiamo la collezione completa
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        if($image){
            $data['image_path'] = $image->store('task/' . Str::random(), 'public');
        }

        Task::create($data);

        return to_route('task.index')->with('success','Task was Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $query = $task->tasks();
        $sortField = request("sort_field",'created_at');
        $sortDirection = request("sort_direction","desc");

        // Filtraggio dei progetti in base al nome
        if(request('name')) {
            $query = $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Filtraggio dei progetti in base allo stato
        if(request('status')) {
            $query = $query->where('status', request('status'));
        }

        $tasks = $query->orderBy($sortField, $sortDirection)->paginate(10)->onEachSide(1);
        return inertia( 'Task/Show', [
            'task' => new TaskResource($task),
            'tasks' => TaskResource::collection($tasks),
            'queryParams' => request()->query() ?: null,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {

        $projects = Project::query()->orderBy('name','asc')->get();
        $users = User::query()->orderBy('name','asc')->get();

        return inertia("Task/Edit",[
            'projects' => ProjectResource::collection($projects),//prendiamo la collezione completa
            'users'=> UserCrudResource::collection($users),//prendiamo la collezione completa
            'task' => new TaskResource($task),
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        $data['updated_by'] = Auth::id();
        if($image){
            if($task->image_path){
                Storage::disk('public')->deleteDirectory(dirname($task->image_path));
            }
            $data['image_path'] = $image->store('task/' . Str::random(), 'public');
        }
        $task->update($data);

        return to_route('task.index')->with('success',"Task \"$task->name\" was updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        if($task->image_path){
            Storage::disk('public')->deleteDirectory(dirname($task->image_path));
        }
        $nameTaskDeleted = $task->name;
        $idTaskDeleted = $task->id;

        return to_route('task.index')->with('success',"Task \"$idTaskDeleted\"\"$nameTaskDeleted\"was Deleted!");
    }
}

