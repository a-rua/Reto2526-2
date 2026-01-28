<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $fillable = ['id_usuario', 'grupo_id'];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
    protected static function booted()
{
    static::deleting(function ($alumno) {
        // Al borrar el alumno, buscamos su usuario y lo borramos
        if ($alumno->usuario) {
            $alumno->usuario->delete();
        }
    });
}
}
