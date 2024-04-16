<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TaskResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // Ritorna un array rappresentante le informazioni della risorsa Task
        // Utilizza il metodo parent::toArray() per ottenere l'array predefinito delle informazioni della risorsa

        return [
            "id" => $this->id, // ID del progetto
            "name" => $this->name, // Nome del progetto
            "description" => $this->description, // Descrizione del progetto
            "created_at" => (new Carbon($this->created_at))->format('Y-m-d'), // Data di creazione del progetto
            "due_date" => (new Carbon($this->due_date))->format('Y-m-d'),
            "status" => $this->status, // Stato del progetto
            "priority" => $this->priority,
            "image_path" => $this->image_path ? Storage::url($this->image_path) : '',
            "assignedUser" => $this->assignedUser,
            "project_id" => $this->project_id,
            "assigned_user_id" => $this->assigned_user_id,
            "project" => new ProjectResource($this->project),
            "createdBy" => new UserCrudResource($this->createdBy) , // Utente creatore del progetto
            "updatedBy" => new UserCrudResource($this->updatedBy) , // Utente che ha aggiornato il progetto
        ];
    }
}
