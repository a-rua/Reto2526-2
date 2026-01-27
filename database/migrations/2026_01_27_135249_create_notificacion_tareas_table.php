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
    $table->foreignId('tarea_id')->constrained('tareas', 'id_tarea')->cascadeOnDelete();
    $table->foreignId('alumno_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('responsable_id')->constrained('users')->cascadeOnDelete();
    $table->text('comentario')->nullable();
    $table->timestamp('leido_at')->nullable(); // Para saber si el responsable lo vio
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
