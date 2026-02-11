<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('Bitacora', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->id('BitacoraID'); // Tu llave primaria
        $table->string('Accion', 100);
        $table->text('Detalle')->nullable();
        $table->string('IpAddress', 45)->nullable();
        $table->unsignedBigInteger('UsuarioID')->nullable();
        $table->timestamp('FechaHora')->useCurrent();

        // Relación con tu tabla de usuarios
      $table->foreign('UsuarioID')->references('UsuarioID')->on('usuario')->onDelete('set null');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('Bitacora');
    }
};