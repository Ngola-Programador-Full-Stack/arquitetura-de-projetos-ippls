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
        Schema::create('professor_turma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('turma_id')
                  ->constrained('turmas')
                  ->onDelete('cascade');
            $table->timestamps();
            
            // Evitar duplicatas
            $table->unique(['professor_id', 'turma_id']);
            
            // Índices para performance
            $table->index(['professor_id']);
            $table->index(['turma_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_turma');
    }
};