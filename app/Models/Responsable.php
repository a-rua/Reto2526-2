<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
