<?php

// app/Services/AvaliacaoService.php
namespace App\Services;

use App\Models\Avaliacao;
use App\Models\Notificacao;

class AvaliacaoService
{
    public function obterCriterios(): array
    {
        return [
            'estrutura' => [
                'nome' => 'Estrutura do Projeto',
                'peso' => 25,
                'descricao' => 'Organização de pastas e arquivos conforme padrão MVC'
            ],
            'funcionalidade' => [
                'nome' => 'Funcionalidade',
                'peso' => 30,
                'descricao' => 'Implementação correta das funcionalidades propostas'
            ],
            'codigo' => [
                'nome' => 'Qualidade do Código',
                'peso' => 20,
                'descricao' => 'Legibilidade, comentários e boas práticas'
            ],
            'design' => [
                'nome' => 'Interface/Design',
                'peso' => 15,
                'descricao' => 'Aparência e usabilidade da interface'
            ],
            'documentacao' => [
                'nome' => 'Documentação',
                'peso' => 10,
                'descricao' => 'README e documentação do projeto'
            ]
        ];
    }

    public function calcularNotaFinal(array $criterios): float
    {
        $notaFinal = 0;
        $pesoTotal = 0;

        foreach ($criterios as $criterio => $nota) {
            $criterioDados = $this->obterCriterios()[$criterio] ?? null;
            if ($criterioDados) {
                $notaFinal += $nota * ($criterioDados['peso'] / 100);
                $pesoTotal += $criterioDados['peso'];
            }
        }

        return $pesoTotal > 0 ? $notaFinal : 0;
    }

    public function notificarEstudante(Avaliacao $avaliacao): void
    {
        $instancia = $avaliacao->instanciaProjeto;
        $projeto = $instancia->projeto;
        
        $mensagem = $this->gerarMensagemAvaliacao($avaliacao);
        
        Notificacao::create([
            'usuario_id' => $instancia->usuario_id,
            'titulo' => 'Projeto Avaliado',
            'mensagem' => $mensagem,
            'tipo' => $this->determinarTipoNotificacao($avaliacao->nota),
            'acao_url' => route('meus-projetos.show', $instancia->id)
        ]);
    }

    /**
     * Gera mensagem personalizada baseada na nota
     */
    private function gerarMensagemAvaliacao(Avaliacao $avaliacao): string
    {
        $projeto = $avaliacao->instanciaProjeto->projeto;
        $nota = $avaliacao->nota;
        
        if ($nota >= 16) {
            return "🎉 Excelente trabalho! Seu projeto '{$projeto->titulo}' foi avaliado com {$nota}/20. Parabéns!";
        } elseif ($nota >= 12) {
            return "✅ Bom trabalho! Seu projeto '{$projeto->titulo}' foi avaliado com {$nota}/20. Continue assim!";
        } elseif ($nota >= 10) {
            return "⚠️ Seu projeto '{$projeto->titulo}' foi avaliado com {$nota}/20. Há espaço para melhorias.";
        } else {
            return "❌ Seu projeto '{$projeto->titulo}' foi avaliado com {$nota}/20. Consulte os comentários para melhorias.";
        }
    }

    /**
     * Determina o tipo de notificação baseado na nota
     */
    private function determinarTipoNotificacao(float $nota): string
    {
        if ($nota >= 16) return 'sucesso';
        if ($nota >= 12) return 'info';
        if ($nota >= 10) return 'aviso';
        return 'erro';
    }

    public function gerarRelatorioAvaliacao(Avaliacao $avaliacao): array
    {
        $criterios = $this->obterCriterios();
        $avaliacaoCriterios = $avaliacao->criterios_avaliacao ?? [];

        $relatorio = [
            'projeto' => $avaliacao->instanciaProjeto->projeto->titulo,
            'estudante' => $avaliacao->instanciaProjeto->usuario->nome,
            'nota_final' => $avaliacao->nota,
            'data_avaliacao' => $avaliacao->data_avaliacao,
            'criterios' => []
        ];

        foreach ($criterios as $codigo => $criterio) {
            $nota = $avaliacaoCriterios[$codigo] ?? 0;
            $relatorio['criterios'][] = [
                'nome' => $criterio['nome'],
                'peso' => $criterio['peso'],
                'nota' => $nota,
                'contribuicao' => ($nota * $criterio['peso'] / 100)
            ];
        }

        return $relatorio;
    }

    /**
     * Obtém estatísticas de avaliações
     */
    public function obterEstatisticas(int $avaliadorId = null): array
    {
        $query = Avaliacao::query();
        
        if ($avaliadorId) {
            $query->where('avaliador_id', $avaliadorId);
        }

        $avaliacoes = $query->get();

        return [
            'total_avaliacoes' => $avaliacoes->count(),
            'nota_media' => $avaliacoes->avg('nota'),
            'nota_maxima' => $avaliacoes->max('nota'),
            'nota_minima' => $avaliacoes->min('nota'),
            'distribuicao_notas' => $this->calcularDistribuicaoNotas($avaliacoes),
            'avaliacoes_por_mes' => $this->calcularAvaliacoesPorMes($avaliacoes)
        ];
    }

    /**
     * Calcula distribuição de notas
     */
    private function calcularDistribuicaoNotas($avaliacoes): array
    {
        $distribuicao = [
            '0-5' => 0,
            '6-10' => 0,
            '11-15' => 0,
            '16-20' => 0
        ];

        foreach ($avaliacoes as $avaliacao) {
            $nota = $avaliacao->nota;
            if ($nota <= 5) {
                $distribuicao['0-5']++;
            } elseif ($nota <= 10) {
                $distribuicao['6-10']++;
            } elseif ($nota <= 15) {
                $distribuicao['11-15']++;
            } else {
                $distribuicao['16-20']++;
            }
        }

        return $distribuicao;
    }

    /**
     * Calcula avaliações por mês
     */
    private function calcularAvaliacoesPorMes($avaliacoes): array
    {
        return $avaliacoes->groupBy(function ($avaliacao) {
            return $avaliacao->data_avaliacao->format('Y-m');
        })->map(function ($grupo) {
            return $grupo->count();
        })->toArray();
    }

    /**
     * Gera relatório completo de avaliações
     */
    public function gerarRelatorioCompleto(int $avaliadorId = null, string $periodo = '30'): array
    {
        $query = Avaliacao::with(['instanciaProjeto.projeto', 'instanciaProjeto.usuario', 'avaliador']);
        
        if ($avaliadorId) {
            $query->where('avaliador_id', $avaliadorId);
        }

        if ($periodo !== 'all') {
            $query->where('data_avaliacao', '>=', now()->subDays((int)$periodo));
        }

        $avaliacoes = $query->get();

        return [
            'periodo' => $periodo,
            'total_avaliacoes' => $avaliacoes->count(),
            'estatisticas' => $this->obterEstatisticas($avaliadorId),
            'avaliacoes_detalhadas' => $avaliacoes->map(function ($avaliacao) {
                return [
                    'id' => $avaliacao->id,
                    'projeto' => $avaliacao->instanciaProjeto->projeto->titulo,
                    'estudante' => $avaliacao->instanciaProjeto->usuario->name,
                    'nota' => $avaliacao->nota,
                    'data' => $avaliacao->data_avaliacao->format('d/m/Y'),
                    'avaliador' => $avaliacao->avaliador->name
                ];
            })
        ];
    }
}
