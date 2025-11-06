<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
    public function up()
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->string('nivel_dificuldade')->change();
        });
    }

    public function down()
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->dropColumn('nivel_dificuldade'); // Ajuste conforme necessário
        });
    }
};
