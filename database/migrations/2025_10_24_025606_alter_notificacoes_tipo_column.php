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
        Schema::table('notificacoes', function (Blueprint $table) {
            // Alterar a coluna tipo de ENUM para STRING
            $table->string('tipo', 20)->default('info')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notificacoes', function (Blueprint $table) {
            // Reverter para ENUM se necessário
            $table->enum('tipo', ['info', 'sucesso', 'aviso', 'erro'])->default('info')->change();
        });
    }
};
