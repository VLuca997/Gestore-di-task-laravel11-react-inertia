<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

//Helpers
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Creazione della query per ottenere i progetti
        $query = Project::query();
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
        $projects = $query->orderBy($sortField, $sortDirection)->paginate(10)->onEachSide(1);

        return Inertia("Project/Index", [
            "projects" => ProjectResource::collection($projects),
            'queryParams' => request()->query() ?: null,/*passa i parametri della query string alla vista. La funzione request()->query() restituisce un array associativo contenente tutti i parametri della query string dell'URL corrente. Se non ci sono parametri, viene restituito null. */
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("Project/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        /** @var $image \Illuminate\Http\UploadedFile */
        $image = $data['image'] ?? null;
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        if($image){
            $data['image_path'] = $image->store('project/' . Str::random(), 'public');
        }

        Project::create($data);

        return to_route('project.index')->with('success','Project was Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $query = $project->tasks();
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
        return inertia( 'Project/Show', [
            'project' => new ProjectResource($project),
            'tasks' => TaskResource::collection($tasks),
            'queryParams' => request()->query() ?: null,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
        return inertia('Project/Edit', [
            'project' => new ProjectResource($project),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
			{

				$data = $request->validated();
				$image = $data['image'] ?? null;
				$data['updated_by'] = Auth::id();
				if($image){
					if($project->image_path){
						Storage::disk('public')->delete(dirname($project->image_path));
					}
					$data['image_path'] = $image->store('project/' . Str::random(), 'public');
				}
				$project->update($data);

				return to_route('project.index')->with('success',"Project \"$project->name\" was updated!");
			}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
        $project->delete();
        if($project->image_path){
            Storage::disk('public')->delete(dirname($project->image_path));
        }
        $nameProjectDeleted = $project->name;
        $idProjectDeleted = $project->id;

        return to_route('project.index')->with('success',"Project \"$idProjectDeleted\"\"$nameProjectDeleted\"was Deleted!");
    }
}
