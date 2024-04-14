<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['image_path','name','status','description','due_date','created_by','updated_by'];

    // Definizione della relazione "hasMany" con il modello Task
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    // Definizione della relazione "belongsTo" con il modello User per l'utente creatore del progetto
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    // Definizione della relazione "belongsTo" con il modello User per l'utente che ha aggiornato il progetto
    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
