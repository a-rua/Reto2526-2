<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacionTarea extends Model
{
    // Nombre de la tabla según tu migración
    protected $table = 'notificacion_tareas';

    protected $fillable = [
        'id_tarea',
        'alumno_id',
        'responsable_id',
        'comentario',
        'leido_at'
    ];

    // Relaciones para que el responsable pueda ver los datos
    public function tarea(): BelongsTo { return $this->belongsTo(Tarea::class, 'id_tarea'); }
public function alumno(): BelongsTo
{
    // Cambiamos User::class por Usuario::class
    return $this->belongsTo(Usuario::class, 'alumno_id', 'id_usuario');
}
}
