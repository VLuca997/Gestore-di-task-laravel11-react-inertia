<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory per la creazione di istanze del modello Task.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Definizione dello stato predefinito del modello Task
        return [
            'name'=> fake()->sentence(), // Nome casuale per il compito
            'description' => fake()->realText(), // Descrizione casuale per il compito
            'due_date' => fake()->dateTimeBetween('now', '+1 year'), // Data di scadenza casuale entro un anno dalla data attuale
            'status' => fake()->randomElement(['pending','in_progress','completed']), // Stato casuale del compito
            'priority'=> fake()->randomElement(['low','medium','high']), // Priorità casuale del compito
            'image_path' => fake()->imageUrl(), // Percorso casuale di un'immagine per il compito
            'assigned_user_id' => 1, // ID dell'utente assegnato (temporaneamente fisso a 1)
            'created_by' => 1, // ID dell'utente creatore (temporaneamente fisso a 1)
            'updated_by' => 1, // ID dell'utente che ha aggiornato (temporaneamente fisso a 1)
            'created_at' => time(), // Data e ora di creazione impostata alla data attuale
            'updated_at' => time(), // Data e ora di aggiornamento impostata alla data attuale
        ];
    }
}
