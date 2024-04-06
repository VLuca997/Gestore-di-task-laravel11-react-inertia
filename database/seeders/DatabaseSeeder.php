<?php

namespace Database\Seeders;

//MODELS
use App\Models\Project;
use App\Models\User;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'DevL',
            'email' => 'luca@luca.it',
            'password' => bcrypt('12345678'),
            'email_verified_at' => time(),
        ]);

        Project::factory()
                ->count(30)//crea 30 project
                ->hasTasks(30)//30 elementi per project
                ->create();//crea
    }
    /*
        In sintesi, questo seeder crea un utente di esempio con il nome 'DevL', l'email 'luca@luca.it' e la password '12345678',
        quindi crea 30 progetti, ciascuno dei quali ha associati 30 task di esempio. Questi dati possono essere utilizzati per testare e sviluppare
        l'applicazione con un insieme di dati di esempio già presente nel database.
    */
}
