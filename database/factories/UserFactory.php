<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Factory per la creazione di istanze del modello User.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * La password corrente utilizzata dalla factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Definizione dello stato predefinito del modello User
        return [
            'name' => fake()->name(), // Nome casuale dell'utente
            'email' => fake()->unique()->safeEmail(), // Email casuale unica e sicura dell'utente
            'email_verified_at' => now(), // Data e ora di verifica dell'email impostata alla data e ora attuali
            'password' => static::$password ??= Hash::make('password'), // Password casuale (se non definita, viene utilizzata la password 'password' crittografata)
            'remember_token' => Str::random(10), // Token casuale per la funzione di "remember me"
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        // Metodo per indicare che l'indirizzo email dell'utente deve essere non verificato
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null, // Imposta l'attributo 'email_verified_at' a null
        ]);
    }
}
