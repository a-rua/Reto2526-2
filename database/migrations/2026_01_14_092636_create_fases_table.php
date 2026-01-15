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
        Schema::create('fases', function (Blueprint $table) {
            $table->id('id_fase'); // PK según tu diagrama
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();

            // Relación con la tabla Tareas
            // Usamos id_tarea porque así definiste la PK en la migración de tareas
            $table->foreignId('id_tarea')
                ->constrained('tareas', 'id_tarea')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fases');
    }
};
