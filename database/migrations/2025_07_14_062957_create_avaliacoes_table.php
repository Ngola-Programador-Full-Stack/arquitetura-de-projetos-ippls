<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2025_01_01_000006_create_avaliacoes_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instancia_projeto_id')->constrained('instancias_projeto');
            $table->foreignId('avaliador_id')->constrained('users');
            $table->decimal('nota', 4, 2)->nullable();
            $table->text('comentarios')->nullable();
            $table->json('criterios_avaliacao')->nullable(); // Estrutura, Funcionalidade, etc.
            $table->enum('status', ['pendente', 'em_avaliacao', 'avaliado'])->default('pendente');
            $table->timestamp('data_avaliacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
