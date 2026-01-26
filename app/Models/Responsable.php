<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Responsable extends Model
{
    protected $fillable = ['id_usuario', 'admin'];

    protected $casts = ['admin' => 'boolean'];

    public function isAdmin(): bool
    {
        return $this->admin === true;
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'id_responsable', 'id_responsable');
    }
}
