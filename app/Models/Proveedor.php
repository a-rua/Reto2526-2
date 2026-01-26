<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    // Nombre de la tabla (opcional si sigue la convención, pero mejor asegurar)
    protected $table = 'proveedors';

    // ¡IMPORTANTE! Tu migración usa 'id_proveedores' como PK
    protected $primaryKey = 'id_proveedores';

    // Permitimos la asignación masiva del nombre
    protected $fillable = [
        'nombre_proveedor',
    ];

    /**
     * Relación con Materiales (Un proveedor tiene muchos materiales)
     */

    public function materiales()
{
    return $this->hasMany(Material::class, 'id_proveedores');
}
}
