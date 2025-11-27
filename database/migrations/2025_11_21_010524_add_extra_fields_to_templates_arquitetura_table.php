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
        Schema::table('templates_arquitetura', function (Blueprint $table) {
            $table->string('subtitulo')->nullable()->after('nome');
            $table->text('descricao_completa')->nullable()->after('descricao');
            $table->json('requisitos')->nullable()->after('dependencias');
            $table->json('beneficios')->nullable()->after('requisitos');
            $table->json('casos_uso')->nullable()->after('beneficios');
            $table->json('caracteristicas')->nullable()->after('casos_uso');
            $table->integer('tempo_setup')->nullable()->after('instrucoes_uso')->comment('Tempo estimado de setup em minutos');
            $table->boolean('para_iniciantes')->default(false)->after('tempo_setup');
            $table->boolean('gratuito')->default(true)->after('para_iniciantes');
            $table->boolean('documentado')->default(true)->after('gratuito');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates_arquitetura', function (Blueprint $table) {
            $table->dropColumn([
                'subtitulo',
                'descricao_completa',
                'requisitos',
                'beneficios',
                'casos_uso',
                'caracteristicas',
                'tempo_setup',
                'para_iniciantes',
                'gratuito',
                'documentado'
            ]);
        });
    }
};
