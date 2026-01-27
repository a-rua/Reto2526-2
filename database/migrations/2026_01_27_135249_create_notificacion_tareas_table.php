<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('notificacion_tareas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('id_tarea')->constrained('tareas', 'id_tarea')->cascadeOnDelete();

    // Apuntamos explícitamente a la tabla 'usuarios' y su columna 'id_usuario'
    $table->foreignId('alumno_id')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
    $table->foreignId('responsable_id')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();

    $table->text('comentario')->nullable();
    $table->timestamp('leido_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacion_tareas');
    }
};
