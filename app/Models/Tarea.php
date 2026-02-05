<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';
    protected $primaryKey = 'id_tarea';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'estimado',
        'fecha_fin',
        'visible',
        'realizado',
        'grupo_id',
        'id_responsable',
        'id_fase',
    ];

    /**
     * Relación con Grupo
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    /**
     * Relación con Responsable
     */
    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'id_responsable', 'id');
    }


    public function fase()
    {
        return $this->belongsTo(Fase::class, 'id_fase', 'id_fase');
    }

    /**
     * Relación con Materiales
     */
  public function materiales()
{

    return $this->belongsToMany(Material::class, 'material_tarea', 'id_tarea', 'id_material')
                ->withPivot('cantidad');
}
}
