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
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Campo auto-incrementante per l'identificazione univoca del progetto
            $table->string('name'); // Nome del progetto
            $table->longText('description')->nullable(); // Descrizione del progetto (può essere nullo)
            $table->timestamp('due_date')->nullable(); // Data di scadenza del progetto (può essere nullo)
            $table->string('status'); // Stato del progetto
            $table->string('image_path')->nullable(); // Percorso dell'immagine associata al progetto (può essere nullo)
            $table->foreignId('created_by')->constrained('users'); // Chiave esterna che fa riferimento all'utente che ha creato il progetto
            $table->foreignId('updated_by')->constrained('users'); // Chiave esterna che fa riferimento all'utente che ha aggiornato il progetto
            $table->timestamps(); // Campi per memorizzare le informazioni sulla creazione e l'aggiornamento del progetto (created_at, updated_at)
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
