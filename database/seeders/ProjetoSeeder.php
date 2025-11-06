<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Projeto;

class ProjetoSeeder extends Seeder
{
    public function run()
    {
        // Dados de exemplo
        $projetos = [
            [
                'titulo' => 'Projeto A',
                'descricao' => 'Descrição do Projeto A.',
                'imagem' => 'imagens/projeto_a.png',
                'categoria' => 'Categoria 1',
                'nivel_dificuldade' => 'Fácil',
                'tecnologias' => ['PHP', 'Laravel', 'MySQL'],
                'requisitos' => 'Requisitos do Projeto A.',
                'duracao_estimada' => '2 semanas',
                'status' => 'ativo',
                'criado_por' => 1, // ID do usuário que criou o projeto
            ],
            [
                'titulo' => 'Projeto B',
                'descricao' => 'Descrição do Projeto B.',
                'imagem' => 'imagens/projeto_b.png',
                'categoria' => 'Categoria 2',
                'nivel_dificuldade' => 'Médio',
                'tecnologias' => ['JavaScript', 'Vue.js', 'Node.js'],
                'requisitos' => 'Requisitos do Projeto B.',
                'duracao_estimada' => '1 mês',
                'status' => 'ativo',
                'criado_por' => 1,
            ],
            [
                'titulo' => 'Projeto C',
                'descricao' => 'Descrição do Projeto C.',
                'imagem' => 'imagens/projeto_c.png',
                'categoria' => 'Categoria 3',
                'nivel_dificuldade' => 'Difícil',
                'tecnologias' => ['Python', 'Django'],
                'requisitos' => 'Requisitos do Projeto C.',
                'duracao_estimada' => '2 meses',
                'status' => 'inativo',
                'criado_por' => 2, // Outro usuário
            ],
        ];

        foreach ($projetos as $projeto) {
            Projeto::create($projeto);
        }
    }
}
