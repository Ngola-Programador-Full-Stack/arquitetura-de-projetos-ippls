<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Projeto;
use App\Models\InstanciaProjeto;
use App\Models\Notificacao;
use App\Models\User;
use App\Models\Avaliacao;
use App\Services\AvaliacaoService;

class DashboardController extends Controller
{
    public function __construct(
        private AvaliacaoService $avaliacaoService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();
        
        // Dados específicos por tipo de usuário
        $dashboardData = $this->obterDadosDashboard($user);
        
        return Inertia::render('Dashboard', [
            'user' => $user->load(['curso', 'turma']),
            'userType' => $user->tipo,
            'dashboardData' => $dashboardData
        ]);
    }

    /**
     * Obtém dados específicos do dashboard baseado no tipo de usuário
     */
    private function obterDadosDashboard(User $user): array
    {
        switch ($user->tipo) {
            case 'estudante':
                return $this->obterDadosEstudante($user);
            case 'professor':
                return $this->obterDadosProfessor($user);
            case 'coordenador':
                return $this->obterDadosCoordenador($user);
            default:
                return [];
        }
    }

    /**
     * Dados do dashboard para estudantes
     */
    private function obterDadosEstudante(User $user): array
    {
        $meusProjetos = InstanciaProjeto::where('usuario_id', $user->id)
            ->with(['projeto', 'avaliacaoAtual'])
            ->get();

        $projetosDisponiveis = Projeto::where('status', 'ativo')
            ->whereNotIn('id', $meusProjetos->pluck('projeto_id'))
            ->count();

        $notificacoesNaoLidas = Notificacao::where('usuario_id', $user->id)
            ->where('lida', false)
            ->count();

        return [
            'estatisticas' => [
                'meus_projetos' => $meusProjetos->count(),
                'projetos_em_desenvolvimento' => $meusProjetos->where('status', 'em_desenvolvimento')->count(),
                'projetos_concluidos' => $meusProjetos->where('status', 'concluido')->count(),
                'projetos_disponiveis' => $projetosDisponiveis,
                'notificacoes_nao_lidas' => $notificacoesNaoLidas
            ],
            'projetos_recentes' => $meusProjetos->take(5)->map(function ($instancia) {
                return [
                    'id' => $instancia->id,
                    'titulo' => $instancia->projeto->titulo,
                    'progresso' => $instancia->percentual_conclusao,
                    'status' => $instancia->status,
                    'nota' => $instancia->avaliacaoAtual?->nota,
                    'data_inicio' => $instancia->data_inicio->format('d/m/Y')
                ];
            }),
            'notificacoes_recentes' => Notificacao::where('usuario_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($notificacao) {
                    return [
                        'id' => $notificacao->id,
                        'titulo' => $notificacao->titulo,
                        'mensagem' => $notificacao->mensagem,
                        'tipo' => $notificacao->tipo,
                        'lida' => $notificacao->lida,
                        'data' => $notificacao->created_at->format('d/m/Y H:i')
                    ];
                })
        ];
    }

    /**
     * Dados do dashboard para professores
     */
    private function obterDadosProfessor(User $user): array
    {
        // Buscar turmas do professor
        //$turmasIds = $user->turmas()->pluck('id');
        $turmasIds = $user->turmas()->pluck('turmas.id');
        
        // Buscar estudantes das turmas
        $estudantesIds = \App\Models\Turma::whereIn('id', $turmasIds)
            ->with('users')
            ->get()
            ->pluck('users')
            ->flatten()
            ->pluck('id')
            ->unique();

        $instanciasParaAvaliar = InstanciaProjeto::whereIn('usuario_id', $estudantesIds)
            ->whereDoesntHave('avaliacoes')
            ->where('status', 'em_desenvolvimento')
            ->count();

        $avaliacoesRealizadas = Avaliacao::where('avaliador_id', $user->id)->count();

        $estatisticasAvaliacoes = $this->avaliacaoService->obterEstatisticas($user->id);

        return [
            'estatisticas' => [
                'estudantes_turmas' => $estudantesIds->count(),
                'instancias_para_avaliar' => $instanciasParaAvaliar,
                'avaliacoes_realizadas' => $avaliacoesRealizadas,
                'nota_media_avaliacoes' => $estatisticasAvaliacoes['nota_media'] ?? 0
            ],
            'projetos_para_avaliar' => InstanciaProjeto::whereIn('usuario_id', $estudantesIds)
                ->whereDoesntHave('avaliacoes')
                ->with(['projeto', 'usuario'])
                ->take(5)
                ->get()
                ->map(function ($instancia) {
                    return [
                        'id' => $instancia->id,
                        'projeto' => $instancia->projeto->titulo,
                        'estudante' => $instancia->usuario->name,
                        'progresso' => $instancia->percentual_conclusao,
                        'data_inicio' => $instancia->data_inicio->format('d/m/Y')
                    ];
                }),
            'avaliacoes_recentes' => Avaliacao::where('avaliador_id', $user->id)
                ->with(['instanciaProjeto.projeto', 'instanciaProjeto.usuario'])
                ->orderBy('data_avaliacao', 'desc')
                ->take(5)
                ->get()
                ->map(function ($avaliacao) {
                    return [
                        'id' => $avaliacao->id,
                        'projeto' => $avaliacao->instanciaProjeto->projeto->titulo,
                        'estudante' => $avaliacao->instanciaProjeto->usuario->name,
                        'nota' => $avaliacao->nota,
                        'data' => $avaliacao->data_avaliacao->format('d/m/Y')
                    ];
                })
        ];
    }

    /**
     * Dados do dashboard para coordenadores
     */
    private function obterDadosCoordenador(User $user): array
    {
        $totalUsuarios = User::count();
        $totalProjetos = Projeto::count();
        $totalInstancias = InstanciaProjeto::count();
        $totalAvaliacoes = Avaliacao::count();

        $projetosPorStatus = InstanciaProjeto::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $usuariosPorTipo = User::selectRaw('tipo, count(*) as total')
            ->groupBy('tipo')
            ->pluck('total', 'tipo');

        $estatisticasAvaliacoes = $this->avaliacaoService->obterEstatisticas();

        return [
            'estatisticas_gerais' => [
                'total_usuarios' => $totalUsuarios,
                'total_projetos' => $totalProjetos,
                'total_instancias' => $totalInstancias,
                'total_avaliacoes' => $totalAvaliacoes,
                'nota_media_geral' => $estatisticasAvaliacoes['nota_media'] ?? 0
            ],
            'distribuicao_projetos' => [
                'iniciados' => $projetosPorStatus['iniciado'] ?? 0,
                'em_desenvolvimento' => $projetosPorStatus['em_desenvolvimento'] ?? 0,
                'concluidos' => $projetosPorStatus['concluido'] ?? 0,
                'abandonados' => $projetosPorStatus['abandonado'] ?? 0
            ],
            'distribuicao_usuarios' => [
                'estudantes' => $usuariosPorTipo['estudante'] ?? 0,
                'professores' => $usuariosPorTipo['professor'] ?? 0,
                'coordenadores' => $usuariosPorTipo['coordenador'] ?? 0
            ],
            'projetos_recentes' => InstanciaProjeto::with(['projeto', 'usuario'])
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get()
                ->map(function ($instancia) {
                    return [
                        'id' => $instancia->id,
                        'projeto' => $instancia->projeto->titulo,
                        'estudante' => $instancia->usuario->name,
                        'progresso' => $instancia->percentual_conclusao,
                        'status' => $instancia->status,
                        'data_atualizacao' => $instancia->updated_at->format('d/m/Y H:i')
                    ];
                }),
            'estatisticas_avaliacoes' => $estatisticasAvaliacoes
        ];
    }
}
