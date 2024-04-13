<?php

namespace App\Http\Resources;

use Carbon\Carbon; // Importa la classe Carbon per la gestione delle date
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public static $wrap = false;
    /*
    Quando $wrap è impostato su true:
        i dati restituiti dalla risorsa sono avvolti all'interno di un array con una chiave
        corrispondente al nome della risorsa stessa. Questo può essere utile per standardizzare la struttura delle risposte API e
        per fornire un contesto aggiuntivo per i dati.

    Quando $wrap è impostato su false:
        i dati restituiti dalla risorsa non sono avvolti all'interno di un array
        aggiuntivo e sono restituiti direttamente come oggetto. Questo è utile quando si desidera ottenere i dati della
        risorsa senza l'avvolgimento aggiuntivo,rendendo così la risposta JSON più pulita e più vicina alla struttura dei dati sottostanti nel database.
    */



    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Ritorna un array rappresentante le informazioni del progetto

        // Utilizza Carbon per formattare la data di creazione nel formato desiderato (Y-m-d H:i:s)
        // Ritorna un array contenente le informazioni del progetto
        return [
            "id" => $this->id, // ID del progetto
            "name" => $this->name, // Nome del progetto
            "description" => $this->description, // Descrizione del progetto
            "created_at" => (new Carbon($this->created_at))->format("Y-m-d"), // Data di creazione del progetto
            "due_date" => (new Carbon($this->due_date))->format("Y-m-d"), // Data di scadenza del progetto
            "status" => $this->status, // Stato del progetto
            "image_path" => $this->image_path, // Percorso dell'immagine associata al progetto
            // "assignedUser" => $this->assignedUser,
            // "project" => new ProjectResource($this->project),
            "createdBy" => $this->createdBy, // Utente creatore del progetto
            "updatedBy" => $this->updatedBy, // Utente che ha aggiornato il progetto
        ];
    }
}
