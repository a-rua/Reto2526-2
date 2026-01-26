<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // -----------------------------
    // Relaciones
    // -----------------------------

    /**
     * Relación con Responsable (Admin o Profesor)
     */
    public function responsable(): HasOne
    {
        return $this->hasOne(Responsable::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con Alumno
     */
    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class, 'id_usuario', 'id_usuario');
    }

    // -----------------------------
    // Helpers de rol
    // -----------------------------

    /**
     * Determina si el usuario es Admin
     */
    public function isAdmin(): bool
    {
        return $this->responsable && $this->responsable->admin;
    }

    /**
     * Determina si el usuario es Responsable (Profesor)
     */
    public function isResponsable(): bool
    {
        return $this->responsable && ! $this->responsable->admin;
    }

    /**
     * Determina si el usuario es Profesor
     */
    public function isProfesor(): bool
    {
        return $this->isResponsable();
    }

    /**
     * Determina si el usuario es Alumno
     */
    public function isAlumno(): bool
    {
        return (bool) $this->alumno;
    }

    // -----------------------------
    // Accesor de nombre
    // -----------------------------

    /**
     * Devuelve el email como nombre por defecto
     */
    public function getNameAttribute(): string
    {
        return $this->email;
    }
}
