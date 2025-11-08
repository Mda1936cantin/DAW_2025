<?php

// database/migrations/..._create_users_table_final.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name'); // Campo Requerido
            $table->string('username')->unique(); // Campo Requerido y Único
            $table->string('email')->unique();
            $table->string('phone')->nullable(); // Campo Requerido
            $table->enum('profile', ['Administrador', 'Gestion', 'Consultas'])->default('Consultas'); // Campo Requerido
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // Requisito: Baja Lógica
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
