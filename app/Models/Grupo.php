<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = ['nombre_grupo', 'descripcion'];


    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'grupo_id', 'id');
    }
}
