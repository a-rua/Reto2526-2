<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fase extends Model
{
    protected $primaryKey = 'id_fase';
    protected $table = 'fases';

    // ELIMINA 'id_tarea' de aquí. Una fase no tiene una tarea, tiene MUCHAS.
    protected $fillable = ['nombre', 'descripcion'];

    public function tareas(): HasMany
    {
        // Esto está perfecto: busca 'id_fase' en la tabla 'tareas'
        return $this->hasMany(Tarea::class, 'id_fase', 'id_fase');
    }
}
