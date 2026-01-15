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
            $table->id('id_tarea'); // PK personalizada
            $table->string('nombre')->unique();

            // Fechas y tiempos
            $table->dateTime('fecha_inicio')->nullable();
            $table->time('estimado')->nullable();
            $table->dateTime('fecha_fin')->nullable();

            // Estados (Booleanos)
            $table->boolean('visible')->default(true);
            $table->boolean('realizado')->default(false);

            // Relación con Grupos
            $table->foreignId('grupo_id')
                ->constrained('grupos')
                ->cascadeOnDelete();

            // Relación con Responsables
            $table->foreignId('id_responsable')
                ->constrained('responsables')
                ->cascadeOnDelete();

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
