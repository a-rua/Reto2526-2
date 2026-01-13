<?php

namespace App\Models;

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

    //  Relaciones
    public function responsable()
    {
        return $this->hasOne(Responsable::class, 'id_usuario');
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class, 'id_usuario');
    }

    //  Helpers de rol
    public function isAdmin(): bool
    {
        return $this->responsable && $this->responsable->admin;
    }

    public function isResponsable(): bool
    {
        return $this->responsable && ! $this->responsable->admin;
    }

    public function isAlumno(): bool
    {
        return (bool) $this->alumno;
    }
    public function isProfesor(): bool
{
    return $this->isResponsable();
}

       public function getNameAttribute(): string
    {
        return $this->email;
    }
}
