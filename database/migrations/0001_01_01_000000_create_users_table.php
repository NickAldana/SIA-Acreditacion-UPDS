<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABLA USUARIO
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('UsuarioID');
            $table->string('NombreUsuario', 50)->nullable();
            $table->string('Correo', 255)->unique();
            $table->longText('Contraseña');
            $table->string('RecordatorioToken', 100)->nullable();
            $table->boolean('Activo')->default(true);
            $table->dateTime('Creacionfecha')->useCurrent();
            $table->dateTime('Finalfecha')->nullable();
            $table->integer('Idpersonal')->nullable();
        });

        // Tablas requeridas por Laravel
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};