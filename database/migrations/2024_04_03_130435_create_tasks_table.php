<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Campo auto-incrementante per l'identificazione univoca del task
            $table->string('name'); // Nome del task
            $table->longText('description')->nullable(); // Descrizione del task (può essere nullo)
            $table->string('image_path')->nullable(); // Percorso dell'immagine associata al task (può essere nullo)
            $table->string('status'); // Stato del task
            $table->string('priority'); // Priorità del task
            $table->string('due_date')->nullable(); // Data di scadenza del task (può essere nullo)
            $table->foreignId('assigned_user_id')->constrained('users'); // Chiave esterna che fa riferimento all'utente assegnato al task
            $table->foreignId('created_by')->constrained('users'); // Chiave esterna che fa riferimento all'utente che ha creato il task
            $table->foreignId('updated_by')->constrained('users'); // Chiave esterna che fa riferimento all'utente che ha aggiornato il task
            $table->foreignId('project_id')->constrained('projects'); // Chiave esterna che fa riferimento al progetto a cui appartiene il task
            $table->timestamps(); // Campi per memorizzare le informazioni sulla creazione e l'aggiornamento del task (created_at, updated_at)
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
