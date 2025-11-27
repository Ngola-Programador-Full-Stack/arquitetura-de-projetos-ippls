<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Templates devem ser criados primeiro (fazem truncate automaticamente)
            TemplateArquiteturaSeeder::class,
            // Depois criamos os dados de exemplo (usuários, projetos, etc.)
            DadosExemploSeeder::class,
        ]);
    }
}
