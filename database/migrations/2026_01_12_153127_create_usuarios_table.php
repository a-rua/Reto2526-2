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
    Schema::create('usuarios', function (Blueprint $table) {
       $table->bigIncrements('id_usuario');

        // Datos básicos
        $table->string('nombre')->unique();
        $table->string('email')->unique();
        $table->string('password');

        // Estado
        $table->boolean('activo')->default(true);

        // Recordar sesión
        $table->rememberToken();

        // Fechas
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
