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
      Schema::create('tareas', function (Blueprint $table) {
    $table->id('id_tarea');
    $table->string('nombre')->unique();

    $table->dateTime('fecha_inicio')->nullable();
    $table->time('estimado')->nullable();
    $table->dateTime('fecha_fin')->nullable();

    $table->boolean('visible')->default(true);
    $table->boolean('realizado')->default(false);

    $table->foreignId('grupo_id')
        ->constrained('grupos')
        ->cascadeOnDelete();

    $table->foreignId('id_responsable')
        ->constrained('responsables')
        ->cascadeOnDelete();

    // Relación opcional con fase
    $table->foreignId('id_fase')->nullable()
        ->constrained('fases', 'id_fase')
        ->nullOnDelete(); // Si la fase se elimina, la tarea queda sin fase

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
