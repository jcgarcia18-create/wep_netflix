<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta la migración - Crea la tabla para códigos de recuperación
    public function up(): void
    {
        Schema::create('password_reset_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('code'); // Código de 6 dígitos encriptado
            $table->timestamp('expires_at'); // Expira en 15 minutos
            $table->timestamp('created_at')->useCurrent();
        });
    }

    // Deshace la migración - Elimina la tabla de códigos de recuperación
    public function down(): void
    {
        Schema::dropIfExists('password_reset_codes');
    }
};
