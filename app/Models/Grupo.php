<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = ['nombre_grupo', 'descripcion'];

    // Relación 1:N con alumnos
    // App/Models/Grupo.php
    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'grupo_id', 'id'); // asegúrate de que las columnas coinciden
    }
}
