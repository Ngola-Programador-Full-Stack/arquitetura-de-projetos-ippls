<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2025_01_01_000004_create_projetos_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('imagem')->nullable();
            $table->string('categoria', 50);
            $table->enum('nivel_dificuldade', ['base', 'padrao', 'avancado'])->default('base');
            $table->json('tecnologias')->nullable(); // Array de tecnologias
            $table->text('requisitos')->nullable();
            $table->integer('duracao_estimada')->nullable(); // em dias
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->foreignId('criado_por')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};
