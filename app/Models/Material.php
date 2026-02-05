<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id_material';

    protected $fillable = [
        'nombre_material',
        'descripcion',
        'id_proveedores',
    ];

    /**
     * Relación con Proveedor (1:N)
     */
  public function proveedor()
{

    return $this->belongsTo(Proveedor::class, 'id_proveedores', 'id_proveedores');
}

    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'material_tarea', 'id_material', 'id_tarea')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}
