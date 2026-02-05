<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{

    protected $table = 'proveedors';


    protected $primaryKey = 'id_proveedores';


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
