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
        'id_proveedores', // Asegúrate que coincida con tu migración (pusiste proveedores en plural)
    ];

    /**
     * Relación con Proveedor (1:N)
     */
  public function proveedor()
{
    // El tercer parámetro debe ser 'id_proveedores' porque así lo llamaste en la migración
    return $this->belongsTo(Proveedor::class, 'id_proveedores', 'id_proveedores');
}
    /**
     * Relación con Tareas (N:M)
     * Usamos belongsToMany porque un material puede estar en muchas tareas.
     */
    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'material_tarea', 'id_material', 'id_tarea')
                    ->withPivot('cantidad') // Esto permite acceder al "Kopurua"
                    ->withTimestamps();
    }
}
