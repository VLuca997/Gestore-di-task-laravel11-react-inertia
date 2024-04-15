<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCrudResource;
use App\Http\Resources\UserResource;
//HELPERS
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::query();
        $sortDirection = request("sort_direction","desc");
        $sortField = request("sort_field","created_at");

        if(request('name')) {
            $query = $query->where('name', 'like', '%' . request('name') . '%');
        }
        if(request('email')) {
            $query = $query->where('email', 'like', '%' . request('email') . '%');
        }


        $users = $query->orderBy($sortField, $sortDirection)->paginate(10)->onEachSide(1);

        return Inertia("User/Index", [
            "users" => UserCrudResource::collection($users),
            'queryParams' => request()->query() ?: null,
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

        $data['email_verified_at'] = time();
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
        return inertia('User/Edit', [
            'user' => new UserCrudResource($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

				$data = $request->validated();
                $password = $data['password'] ?? null;
                if($password){
                    $data['password'] = bcrypt($password);
                }else{
                    unset($data['password']);
                }

				$user->update($data);

				return to_route('user.index')->with('success',"User \"$user->name\" was updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        // if($user->image_path){
        //     Storage::disk('public')->deleteDirectory(dirname($user->image_path));
        // }
        $nameUserDeleted = $user->name;
        $idUserDeleted = $user->id;

        return to_route('user.index')->with('success',"User \"$idUserDeleted\"\"$nameUserDeleted\"was Deleted!");
    }
}
