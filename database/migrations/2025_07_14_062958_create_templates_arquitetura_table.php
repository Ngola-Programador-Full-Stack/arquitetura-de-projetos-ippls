<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2025_01_01_000008_create_templates_arquitetura_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates_arquitetura', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('nivel', ['base', 'padrao', 'avancado']);
            $table->text('descricao');
            $table->json('estrutura_diretorios'); // JSON com a estrutura de pastas
            $table->json('arquivos_base'); // Arquivos que serão criados automaticamente
            $table->json('dependencias')->nullable(); // Dependências necessárias
            $table->text('instrucoes_uso')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates_arquitetura');
    }
};
