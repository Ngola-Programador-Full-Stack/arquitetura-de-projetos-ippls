<?php

// app/Http/Controllers/SupervisaoController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\InstanciaProjeto;
use App\Models\Projeto;
use App\Models\User;
use App\Models\Turma;
use App\Models\Avaliacao;
use App\Services\AvaliacaoService;
use Illuminate\Support\Facades\DB;

class SupervisaoController extends Controller
{
    public function __construct(
        private AvaliacaoService $avaliacaoService
    ) {}
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Apenas coordenadores podem acessar
        if ($user->tipo !== 'coordenador') {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Buscar todas as instâncias de projetos
        $instancias = InstanciaProjeto::with(['projeto', 'usuario', 'avaliacoes.avaliador'])
            ->when($request->status, function($query, $status) {
                switch($status) {
                    case 'pendente_avaliacao':
                        $query->whereDoesntHave('avaliacoes');
                        break;
                    case 'avaliado':
                        $query->whereHas('avaliacoes');
                        break;
                    default:
                        $query->where('status', $status);
                        break;
                }
            })
            ->when($request->projeto_id, function($query, $projetoId) {
                $query->where('projeto_id', $projetoId);
            })
            ->when($request->search, function($query, $search) {
                $query->whereHas('usuario', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('projeto', function($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%");
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(15);
        
        // Estatísticas gerais
        $estatisticas = [
            'total_instancias' => InstanciaProjeto::count(),
            'total_estudantes_ativos' => User::where('tipo', 'estudante')->where('ativo', true)->count(),
            'total_projetos' => Projeto::where('status', 'ativo')->count(),
            'total_turmas' => Turma::where('ativo', true)->count(),
            'instancias_por_status' => [
                'iniciado' => InstanciaProjeto::where('status', 'iniciado')->count(),
                'em_desenvolvimento' => InstanciaProjeto::where('status', 'em_desenvolvimento')->count(),
                'concluido' => InstanciaProjeto::where('status', 'concluido')->count(),
                'abandonado' => InstanciaProjeto::where('status', 'abandonado')->count(),
            ],
            'pendentes_avaliacao' => InstanciaProjeto::whereDoesntHave('avaliacoes')
                ->where('status', 'concluido')
                ->count(),
            'media_progresso' => InstanciaProjeto::avg('percentual_conclusao') ?? 0,
        ];
        
        // Projetos disponíveis para filtro
        $projetos = Projeto::where('status', 'ativo')
            ->select('id', 'titulo')
            ->orderBy('titulo')
            ->get();
        
        $statusOptions = [
            'iniciado' => 'Iniciado',
            'em_desenvolvimento' => 'Em Desenvolvimento', 
            'concluido' => 'Concluído',
            'abandonado' => 'Abandonado',
            'pendente_avaliacao' => 'Pendente de Avaliação',
            'avaliado' => 'Avaliado'
        ];
        
        return Inertia::render('Supervisao/Index', [
            'instancias' => $instancias,
            'estatisticas' => $estatisticas,
            'projetos' => $projetos,
            'statusOptions' => $statusOptions,
            'filtros' => $request->only(['status', 'projeto_id', 'search'])
        ]);
    }
    
    public function relatorio(Request $request)
    {
        $user = auth()->user();
        
        // Apenas coordenadores podem acessar
        if ($user->tipo !== 'coordenador') {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Dados para relatório detalhado
        $periodo = $request->get('periodo', '30'); // últimos 30 dias por padrão
        $dataInicio = now()->subDays($periodo);
        
        // Estatísticas gerais
        $estatisticasGerais = [
            'total_usuarios' => User::count(),
            'total_projetos' => Projeto::count(),
            'total_instancias' => InstanciaProjeto::count(),
            'total_avaliacoes' => Avaliacao::count(),
            'nota_media_geral' => Avaliacao::avg('nota') ?? 0,
            'taxa_conclusao' => $this->calcularTaxaConclusao(),
            'tempo_medio_projeto' => $this->calcularTempoMedioProjeto()
        ];
        
        // Projetos mais populares
        $projetosPopulares = InstanciaProjeto::select('projeto_id')
            ->with('projeto:id,titulo')
            ->where('created_at', '>=', $dataInicio)
            ->groupBy('projeto_id')
            ->selectRaw('count(*) as total')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
            
        // Estudantes mais ativos
        $estudantesAtivos = InstanciaProjeto::select('usuario_id')
            ->with('usuario:id,name')
            ->where('updated_at', '>=', $dataInicio)
            ->groupBy('usuario_id')
            ->selectRaw('avg(percentual_conclusao) as media_progresso, count(*) as total_projetos')
            ->orderBy('media_progresso', 'desc')
            ->limit(10)
            ->get();
            
        // Evolução mensal
        $evolucaoMensal = InstanciaProjeto::selectRaw('
                DATE_FORMAT(created_at, "%Y-%m") as mes,
                count(*) as total_iniciados,
                count(CASE WHEN status = "concluido" THEN 1 END) as total_concluidos,
                avg(percentual_conclusao) as media_progresso
            ')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
            
        // Desempenho por nível
        $desempenhoNivel = InstanciaProjeto::selectRaw('
                nivel_arquitetura,
                count(*) as total,
                avg(percentual_conclusao) as media_progresso,
                count(CASE WHEN status = "concluido" THEN 1 END) as concluidos,
                count(CASE WHEN status = "abandonado" THEN 1 END) as abandonados
            ')
            ->groupBy('nivel_arquitetura')
            ->get();
            
        // Estatísticas de avaliações
        $estatisticasAvaliacoes = $this->avaliacaoService->obterEstatisticas();
        
        // Distribuição de notas
        $distribuicaoNotas = Avaliacao::selectRaw('
                CASE 
                    WHEN nota <= 5 THEN "0-5"
                    WHEN nota <= 10 THEN "6-10"
                    WHEN nota <= 15 THEN "11-15"
                    ELSE "16-20"
                END as faixa,
                count(*) as total
            ')
            ->groupBy('faixa')
            ->orderBy('faixa')
            ->get();
            
        // Professores mais ativos
        $professoresAtivos = Avaliacao::select('avaliador_id')
            ->with('avaliador:id,name')
            ->where('data_avaliacao', '>=', $dataInicio)
            ->groupBy('avaliador_id')
            ->selectRaw('count(*) as total_avaliacoes, avg(nota) as nota_media')
            ->orderBy('total_avaliacoes', 'desc')
            ->limit(10)
            ->get();
        
        $dados = [
            'periodo' => $periodo,
            'estatisticas_gerais' => $estatisticasGerais,
            'projetos_mais_populares' => $projetosPopulares,
            'estudantes_mais_ativos' => $estudantesAtivos,
            'evolucao_mensal' => $evolucaoMensal,
            'desempenho_por_nivel' => $desempenhoNivel,
            'estatisticas_avaliacoes' => $estatisticasAvaliacoes,
            'distribuicao_notas' => $distribuicaoNotas,
            'professores_mais_ativos' => $professoresAtivos
        ];
        
        return Inertia::render('Supervisao/Relatorio', [
            'dados' => $dados
        ]);
    }
    
    /**
     * Calcula taxa de conclusão de projetos
     */
    private function calcularTaxaConclusao(): float
    {
        $total = InstanciaProjeto::count();
        if ($total === 0) return 0;
        
        $concluidos = InstanciaProjeto::where('status', 'concluido')->count();
        return round(($concluidos / $total) * 100, 2);
    }
    
    /**
     * Calcula tempo médio de desenvolvimento de projetos
     */
    private function calcularTempoMedioProjeto(): float
    {
        $projetosConcluidos = InstanciaProjeto::where('status', 'concluido')
            ->whereNotNull('data_conclusao')
            ->get();
            
        if ($projetosConcluidos->isEmpty()) return 0;
        
        $tempoTotal = $projetosConcluidos->sum(function ($projeto) {
            return $projeto->data_conclusao->diffInDays($projeto->data_inicio);
        });
        
        return round($tempoTotal / $projetosConcluidos->count(), 1);
    }
    
    /**
     * Exporta relatório em formato CSV
     */
    public function exportarCsv(Request $request)
    {
        $user = auth()->user();
        
        if ($user->tipo !== 'coordenador') {
            abort(403, 'Acesso não autorizado.');
        }
        
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);
        
        $instancias = InstanciaProjeto::with(['projeto', 'usuario', 'avaliacoes.avaliador'])
            ->where('created_at', '>=', $dataInicio)
            ->get();
            
        $filename = 'relatorio_projetos_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($instancias) {
            $file = fopen('php://output', 'w');
            
            // Cabeçalho
            fputcsv($file, [
                'ID',
                'Projeto',
                'Estudante',
                'Email',
                'Status',
                'Progresso (%)',
                'Nível Arquitetura',
                'Data Início',
                'Data Conclusão',
                'Nota',
                'Avaliador',
                'Data Avaliação',
                'Observações'
            ]);
            
            // Dados
            foreach ($instancias as $instancia) {
                $avaliacao = $instancia->avaliacoes->first();
                
                fputcsv($file, [
                    $instancia->id,
                    $instancia->projeto->titulo,
                    $instancia->usuario->name,
                    $instancia->usuario->email,
                    $instancia->status,
                    $instancia->percentual_conclusao,
                    $instancia->nivel_arquitetura,
                    $instancia->data_inicio->format('d/m/Y'),
                    $instancia->data_conclusao ? $instancia->data_conclusao->format('d/m/Y') : '',
                    $avaliacao ? $avaliacao->nota : '',
                    $avaliacao ? $avaliacao->avaliador->name : '',
                    $avaliacao ? $avaliacao->data_avaliacao->format('d/m/Y') : '',
                    $instancia->observacoes ?? ''
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Exporta relatório em formato Excel
     */
    public function exportarExcel(Request $request)
    {
        $user = auth()->user();
        
        if ($user->tipo !== 'coordenador') {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Para implementação futura com PhpSpreadsheet
        return response()->json([
            'message' => 'Exportação Excel será implementada em breve',
            'suggestion' => 'Use a exportação CSV por enquanto'
        ]);
    }
}