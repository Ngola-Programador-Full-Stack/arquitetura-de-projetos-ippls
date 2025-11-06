<?php

// app/Http/Controllers/AvaliacaoController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Avaliacao;
use App\Models\InstanciaProjeto;
use App\Services\AvaliacaoService;

class AvaliacaoController extends Controller
{
    public function __construct(
        private AvaliacaoService $avaliacaoService
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();

        // Para professores: mostrar instâncias de projetos dos estudantes para avaliar
        if ($user->tipo === 'professor') {
            // Buscar turmas do professor
            $turmasIds = $user->turmas()->pluck('turmas.id');

            // Buscar estudantes das turmas do professor
            $estudantesIds = \App\Models\Turma::whereIn('id', $turmasIds)
                ->with('users')
                ->get()
                ->pluck('users')
                ->flatten()
                ->pluck('id')
                ->unique();

            // Instâncias de projetos dos estudantes
            $instancias = InstanciaProjeto::whereIn('usuario_id', $estudantesIds)
                ->with(['projeto', 'usuario', 'avaliacoes' => function($query) use ($user) {
                    $query->where('avaliador_id', $user->id);
                }])
                ->when($request->status, function($query, $status) {
                    switch($status) {
                        case 'pendente':
                            $query->whereDoesntHave('avaliacoes');
                            break;
                        case 'avaliado':
                            $query->whereHas('avaliacoes');
                            break;
                        case 'em_desenvolvimento':
                            $query->where('status', 'em_desenvolvimento');
                            break;
                        case 'concluido':
                            $query->where('status', 'concluido');
                            break;
                    }
                })
                ->orderBy('updated_at', 'desc')
                ->paginate(12);

            $statusOptions = [
                'pendente' => 'Pendente de Avaliação',
                'avaliado' => 'Já Avaliado',
                'em_desenvolvimento' => 'Em Desenvolvimento',
                'concluido' => 'Concluído'
            ];

            return Inertia::render('Avaliacoes/Index', [
                'instancias' => $instancias,
                'statusOptions' => $statusOptions,
                'filtros' => $request->only(['status'])
            ]);
        }

        // Fallback para outros tipos de usuário
        return redirect()->route('dashboard');
    }

    public function show($id)
    {
        $avaliacao = Avaliacao::where('id', $id)
            ->where('avaliador_id', auth()->id())
            ->with(['instanciaProjeto.projeto', 'instanciaProjeto.usuario'])
            ->firstOrFail();

        return Inertia::render('Avaliacoes/Show', [
            'avaliacao' => $avaliacao,
            'criterios' => $this->avaliacaoService->obterCriterios()
        ]);
    }

    
    public function store(Request $request, $instanciaId)
    {
        $request->validate([
            'nota' => 'required|numeric|min:0|max:20',
            'comentarios' => 'required|string',
            'criterios_avaliacao' => 'required|array'
        ]);

        $instancia = InstanciaProjeto::findOrFail($instanciaId);

        $avaliacao = Avaliacao::create([
            'instancia_projeto_id' => $instancia->id,
            'avaliador_id' => auth()->id(),
            'nota' => $request->nota,
            'comentarios' => $request->comentarios,
            'criterios_avaliacao' => $request->criterios_avaliacao,
            'status' => 'avaliado',
            'data_avaliacao' => now()
        ]);

        // Notificar estudante
        $this->avaliacaoService->notificarEstudante($avaliacao);

        return redirect()->route('avaliacoes.index')
            ->with('success', 'Avaliação realizada com sucesso!');
    }
}
