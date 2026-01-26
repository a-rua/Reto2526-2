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
    public function materiales(): HasMany
    {
        // El segundo parámetro es la FK en la tabla materials
        // El tercer parámetro es la PK en esta tabla (proveedors)
        return $this->hasMany(Material::class, 'id_proveedores', 'id_proveedores');
    }
}
