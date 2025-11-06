<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2025_01_01_000007_create_notificacoes_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('titulo');
            $table->text('mensagem');
            $table->enum('tipo', ['info', 'sucesso', 'aviso', 'erro'])->default('info');
            $table->boolean('lida')->default(false);
            $table->timestamp('data_leitura')->nullable();
            $table->string('acao_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
