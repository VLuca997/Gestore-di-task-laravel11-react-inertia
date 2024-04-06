<?php

namespace App\Http\Resources;

use Carbon\Carbon; // Importa la classe Carbon per la gestione delle date
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Ritorna un array rappresentante le informazioni del progetto

        // Utilizza Carbon per formattare la data di creazione nel formato desiderato (Y-m-d H:i:s)
        // Esempio: "2022-04-08 14:30:00"
        $createdAt = (new Carbon($this->created_at))->format("Y-m-d H:i:s");

        // Utilizza Carbon per formattare la data di scadenza nel formato desiderato (Y-m-d H:i:s)
        // Esempio: "2022-04-15 18:00:00"
        $dueDate = (new Carbon($this->due_date))->format("Y-m-d H:i:s");

        // Ritorna un array contenente le informazioni del progetto
        return [
            "id" => $this->id, // ID del progetto
            "name" => $this->name, // Nome del progetto
            "description" => $this->description, // Descrizione del progetto
            "created_at" => $createdAt, // Data di creazione del progetto
            "due_date" => $dueDate, // Data di scadenza del progetto
            "status" => $this->status, // Stato del progetto
            "image_path" => $this->image_path, // Percorso dell'immagine associata al progetto
            "createdBy" => $this->createdBy, // Utente creatore del progetto
            "updatedBy" => $this->updatedBy, // Utente che ha aggiornato il progetto
        ];
    }
}
