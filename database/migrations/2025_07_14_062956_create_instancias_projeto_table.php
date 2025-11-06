<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2025_01_01_000005_create_instancias_projeto_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instancias_projeto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->constrained('projetos');
            $table->foreignId('usuario_id')->constrained('users');
            $table->enum('nivel_arquitetura', ['base', 'padrao', 'avancado'])->default('base');
            $table->integer('percentual_conclusao')->default(0);
            $table->enum('status', ['iniciado', 'em_desenvolvimento', 'concluido', 'abandonado'])->default('iniciado');
            $table->timestamp('data_inicio')->useCurrent();
            $table->timestamp('data_conclusao')->nullable();
            $table->timestamp('data_entrega')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('repositorio_url')->nullable();
            $table->json('arquivos_anexos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instancias_projeto');
    }
};

