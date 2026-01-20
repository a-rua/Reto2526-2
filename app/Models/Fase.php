<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model

{
    protected $primaryKey = 'id_fase';
    protected $table = 'fases';

    protected $fillable = [ 'id_tarea','nombre','descripcion'];


  public function tarea() {
    return $this->belongsTo(Tarea::class, 'id_tarea', 'id_tarea');
}



}
