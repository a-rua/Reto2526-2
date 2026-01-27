<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacionTarea extends Model
{
    // Nombre de la tabla según tu migración
    protected $table = 'notificacion_tareas';

    protected $fillable = [
        'tarea_id',
        'alumno_id',
        'responsable_id',
        'comentario',
        'leido_at'
    ];

    // Relaciones para que el responsable pueda ver los datos
    public function tarea(): BelongsTo { return $this->belongsTo(Tarea::class, 'tarea_id'); }
    public function alumno(): BelongsTo { return $this->belongsTo(User::class, 'alumno_id'); }
}
