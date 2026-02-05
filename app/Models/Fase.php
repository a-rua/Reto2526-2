<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fase extends Model
{
    protected $primaryKey = 'id_fase';
    protected $table = 'fases';


    protected $fillable = ['nombre', 'descripcion'];

    public function tareas(): HasMany
    {

        return $this->hasMany(Tarea::class, 'id_fase', 'id_fase');
    }
}
