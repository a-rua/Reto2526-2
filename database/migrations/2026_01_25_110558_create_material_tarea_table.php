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
      Schema::create('material_tarea', function (Blueprint $table) {
    $table->id();

    $table->foreignId('id_tarea')->constrained('tareas', 'id_tarea')->cascadeOnDelete();
    $table->foreignId('id_material')->constrained('materials', 'id_material')->cascadeOnDelete();

    // Aquí es donde vive el "Kopurua / Cantidad"
    $table->integer('cantidad')->default(1);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_tarea');
    }
};
