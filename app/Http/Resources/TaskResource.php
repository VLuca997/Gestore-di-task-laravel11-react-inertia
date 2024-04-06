<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // Ritorna un array rappresentante le informazioni della risorsa Task
        // Utilizza il metodo parent::toArray() per ottenere l'array predefinito delle informazioni della risorsa

        return parent::toArray($request);
    }
}
