<?php

// app/Http/Controllers/MeuProjetoController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\InstanciaProjeto;
use App\Models\Projeto;
use App\Models\User;
use App\Services\ProjetoService;
use App\Services\NotificacaoService;
use Illuminate\Support\Facades\Auth;

class MeuProjetoController extends Controller
{
    public function __construct(
        private ProjetoService $projetoService,
        private NotificacaoService $notificacaoService
    ) {}

    public function index(Request $request)
    {
        // Lista das minhas instâncias de projeto
        $projetos = InstanciaProjeto::where('usuario_id', auth()->id())
            ->with(['projeto', 'avaliacaoAtual'])
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statusOptions = [
            'iniciado' => 'Iniciado',
            'em_desenvolvimento' => 'Em Desenvolvimento',
            'concluido' => 'Concluído',
            'abandonado' => 'Abandonado'
        ];

        return Inertia::render('MeusProjetos/Index', [
            'projetos' => $projetos,
            'statusOptions' => $statusOptions,
            'filtros' => $request->only(['status'])
        ]);
    }


    public function show($id)
    {
        $instancia = InstanciaProjeto::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->with(['projeto', 'avaliacoes.avaliador'])
            ->firstOrFail();

        $template = $this->projetoService->obterTemplate($instancia->nivel_arquitetura);

        return Inertia::render('MeusProjetos/Show', [
            'instancia' => $instancia,
            'template' => $template
        ]);
    }

    public function atualizarProgresso(Request $request, $id)
    {
        $request->validate([
            'percentual_conclusao' => 'required|integer|min:0|max:100',
            'observacoes' => 'nullable|string',
            'repositorio_url' => 'nullable|url',
            'marco_atingido' => 'nullable|string|max:255'
        ]);

        $instancia = InstanciaProjeto::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $progressoAnterior = $instancia->percentual_conclusao;
        $novoProgresso = $request->percentual_conclusao;

        $instancia->update([
            'percentual_conclusao' => $novoProgresso,
            'observacoes' => $request->observacoes,
            'repositorio_url' => $request->repositorio_url
        ]);

        // Atualizar status baseado no progresso
        if ($novoProgresso == 100) {
            $instancia->update([
                'status' => 'concluido',
                'data_conclusao' => now()
            ]);

            // Notificar coordenadores sobre conclusão
            $this->notificarConclusaoProjeto($instancia);

        } elseif ($novoProgresso > 0) {
            $instancia->update(['status' => 'em_desenvolvimento']);
        }

        // Verificar marcos atingidos
        $this->verificarMarcos($instancia, $progressoAnterior, $novoProgresso);

        // Notificar professores se houver marco importante
        if ($request->marco_atingido) {
            $this->notificarMarcoAtingido($instancia, $request->marco_atingido);
        }

        // ✅ NOTIFICAÇÕES AUTOMÁTICAS PARA PROGRESSO
        $this->enviarNotificacoesProgresso($instancia, $progressoAnterior, $novoProgresso);

        return back()->with('success', 'Progresso atualizado com sucesso!');
    }

    /**
     * Verifica marcos atingidos e envia notificações
     */
    private function verificarMarcos(InstanciaProjeto $instancia, int $progressoAnterior, int $novoProgresso): void
    {
        $marcos = [25, 50, 75, 100];

        foreach ($marcos as $marco) {
            if ($progressoAnterior < $marco && $novoProgresso >= $marco) {
                $this->notificarMarcoAtingido($instancia, "{$marco}% de conclusão");
                break; // Notificar apenas o primeiro marco atingido
            }
        }
    }

    /**
     * Notifica coordenadores sobre conclusão de projeto
     */
    private function notificarConclusaoProjeto(InstanciaProjeto $instancia): void
    {
        $coordenadores = \App\Models\User::where('tipo', 'coordenador')->get();

        foreach ($coordenadores as $coordenador) {
            \App\Models\Notificacao::create([
                'usuario_id' => $coordenador->id,
                'titulo' => 'Projeto Concluído',
                'mensagem' => "O estudante {$instancia->usuario->name} concluiu o projeto '{$instancia->projeto->titulo}'",
                'tipo' => 'sucesso',
                'acao_url' => route('supervisao.index')
            ]);
        }
    }

    /**
     * Notifica professores sobre marco atingido
     */
    private function notificarMarcoAtingido(InstanciaProjeto $instancia, string $marco): void
    {
        // Buscar professores das turmas do estudante
        $turmasIds = $instancia->usuario->turma_id ? [$instancia->usuario->turma_id] : [];
        $professores = \App\Models\User::where('tipo', 'professor')
            ->whereHas('turmas', function($query) use ($turmasIds) {
                $query->whereIn('turma_id', $turmasIds);
            })
            ->get();

        foreach ($professores as $professor) {
            \App\Models\Notificacao::create([
                'usuario_id' => $professor->id,
                'titulo' => 'Marco Atingido',
                'mensagem' => "O estudante {$instancia->usuario->name} atingiu {$marco} no projeto '{$instancia->projeto->titulo}'",
                'tipo' => 'info',
                'acao_url' => route('avaliacoes.index')
            ]);
        }
    }

    public function uploadAnexo(Request $request, $id)
    {
        $request->validate([
            'arquivo' => 'required|file|max:10240', // 10MB
        ]);

        $instancia = InstanciaProjeto::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $arquivo = $request->file('arquivo');
        $path = $arquivo->store('projetos/anexos', 'public');

        $anexos = $instancia->arquivos_anexos ?? [];
        $anexos[] = [
            'nome' => $arquivo->getClientOriginalName(),
            'path' => $path,
            'tamanho' => $arquivo->getSize(),
            'tipo' => $arquivo->getMimeType(),
            'data_upload' => now()
        ];

        $instancia->update(['arquivos_anexos' => $anexos]);

        return back()->with('success', 'Arquivo anexado com sucesso!');
    }

   /* public function downloadTemplate($id)
    {
        $instancia = InstanciaProjeto::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        return $this->projetoService->gerarZipTemplate($instancia);
    }*/

        // Adicione este método ao seu MeuProjetoController.php

public function downloadTemplate($id)
{
    $instancia = InstanciaProjeto::where('id', $id)
        ->where('usuario_id', auth()->id())
        ->with('projeto')
        ->firstOrFail();

    try {
        return $this->projetoService->gerarZipTemplate($instancia);
    } catch (\Exception $e) {
        return back()->with('error', 'Erro ao gerar template: ' . $e->getMessage());
    }
}

/**
 * Mostrar formulário para criar nova instância de projeto
 */
public function create(Projeto $projeto)
{
    $user = Auth::user();

    // Verificar se já está inscrito
    $jaInscrito = InstanciaProjeto::where('usuario_id', $user->id)
        ->where('projeto_id', $projeto->id)
        ->exists();

    if ($jaInscrito) {
        return redirect()->route('meus-projetos.index')
            ->with('error', 'Você já possui uma instância deste projeto.');
    }

    return Inertia::render('MeusProjetos/Create', [
        'projeto' => $projeto->load('criadoPor')
    ]);
}

/**
 * Criar nova instância de projeto
 */
public function store(Request $request, Projeto $projeto)
{
    $user = Auth::user();

    // Verificar se já está inscrito
    $jaInscrito = InstanciaProjeto::where('usuario_id', $user->id)
        ->where('projeto_id', $projeto->id)
        ->exists();

    if ($jaInscrito) {
        return redirect()->route('meus-projetos.index')
            ->with('error', 'Você já possui uma instância deste projeto.');
    }

    $request->validate([
        'nivel_arquitetura' => 'required|in:base,padrao,avancado',
        'repositorio_url' => 'nullable|url',
        'observacoes' => 'nullable|string|max:1000'
    ]);

    $instancia = InstanciaProjeto::create([
        'projeto_id' => $projeto->id,
        'usuario_id' => $user->id,
        'nivel_arquitetura' => $request->nivel_arquitetura,
        'repositorio_url' => $request->repositorio_url,
        'observacoes' => $request->observacoes,
        'status' => 'iniciado',
        'percentual_conclusao' => 0,
        'data_inicio' => now()
    ]);

    // ✅ NOTIFICAÇÕES AUTOMÁTICAS
    $this->enviarNotificacoesProjetoIniciado($instancia);

    return redirect()->route('meus-projetos.show', $instancia)
        ->with('success', 'Projeto iniciado com sucesso!');
}

/**
 * Enviar notificações quando um projeto é iniciado
 */
private function enviarNotificacoesProjetoIniciado(InstanciaProjeto $instancia): void
{
    $estudante = $instancia->usuario;
    $projeto = $instancia->projeto;

    // 1. Notificação para o estudante
    $this->notificacaoService->enviarNotificacao(
        $estudante,
        'Projeto Iniciado com Sucesso! 🎉',
        "Você iniciou o projeto '{$projeto->titulo}' com arquitetura {$instancia->nivel_arquitetura}. Boa sorte!",
        'success',
        route('meus-projetos.show', $instancia->id)
    );

    // 2. Notificação para coordenadores
    $coordenadores = User::where('tipo', 'coordenador')->get();
    foreach ($coordenadores as $coordenador) {
        $this->notificacaoService->enviarNotificacao(
            $coordenador,
            'Novo Projeto Iniciado',
            "O estudante {$estudante->name} iniciou o projeto '{$projeto->titulo}'",
            'info',
            route('supervisao.index')
        );
    }

    // 3. Notificação para professores da turma do estudante (se houver)
    if ($estudante->turma_id) {
        $professores = User::where('tipo', 'professor')
            ->whereHas('turmas', function($query) use ($estudante) {
                $query->where('turma_id', $estudante->turma_id);
            })
            ->get();

        foreach ($professores as $professor) {
            $this->notificacaoService->enviarNotificacao(
                $professor,
                'Estudante Iniciou Projeto',
                "{$estudante->name} iniciou o projeto '{$projeto->titulo}' na sua turma",
                'info',
                route('avaliacoes.index')
            );
        }
    }
}

/**
 * Enviar notificações para marcos de progresso
 */
private function enviarNotificacoesProgresso(InstanciaProjeto $instancia, int $progressoAnterior, int $novoProgresso): void
{
    $estudante = $instancia->usuario;
    $projeto = $instancia->projeto;

    // Marcos importantes (25%, 50%, 75%, 100%)
    $marcos = [25, 50, 75, 100];

    foreach ($marcos as $marco) {
        if ($progressoAnterior < $marco && $novoProgresso >= $marco) {
            // Notificação para o estudante
            $this->notificacaoService->enviarNotificacao(
                $estudante,
                "Marco {$marco}% Atingido! 🎯",
                "Parabéns! Você atingiu {$marco}% do projeto '{$projeto->titulo}'",
                'success',
                route('meus-projetos.show', $instancia->id)
            );

            // Notificação para coordenadores
            $coordenadores = User::where('tipo', 'coordenador')->get();
            foreach ($coordenadores as $coordenador) {
                $this->notificacaoService->enviarNotificacao(
                    $coordenador,
                    'Marco de Progresso Atingido',
                    "{$estudante->name} atingiu {$marco}% do projeto '{$projeto->titulo}'",
                    'info',
                    route('supervisao.index')
                );
            }

            // Notificação para professores da turma
            if ($estudante->turma_id) {
                $professores = User::where('tipo', 'professor')
                    ->whereHas('turmas', function($query) use ($estudante) {
                        $query->where('turma_id', $estudante->turma_id);
                    })
                    ->get();

                foreach ($professores as $professor) {
                    $this->notificacaoService->enviarNotificacao(
                        $professor,
                        'Estudante Atingiu Marco',
                        "{$estudante->name} atingiu {$marco}% do projeto '{$projeto->titulo}'",
                        'info',
                        route('avaliacoes.index')
                    );
                }
            }
        }
    }
}
}
