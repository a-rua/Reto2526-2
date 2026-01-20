<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{


    protected $table = 'materials';


    protected $primaryKey = 'id_material';


    protected $fillable = [
        'nombre_material',
        'descripcion',
        'id_proveedor',
        'id_tarea',
    ];

    /**
     * Relación con Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedores');
    }

    /**
     * Relación con Tarea
     */
    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_tarea', 'id_tarea');
    }
}
