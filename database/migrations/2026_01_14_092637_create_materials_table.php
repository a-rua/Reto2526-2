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
    Schema::create('materials', function (Blueprint $table) {
    $table->id('id_material');
    $table->string('nombre_material')->unique();
    $table->string('descripcion')->nullable();

    // Relación con proveedors
    $table->foreignId('id_proveedores')->nullable()
          ->constrained('proveedors', 'id_proveedores')
          ->nullOnDelete();
        $table->foreignId('id_tarea')
          ->nullable()
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
        Schema::dropIfExists('materials');
    }
};
