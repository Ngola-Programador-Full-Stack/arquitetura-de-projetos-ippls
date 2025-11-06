<?php

// app/Http/Controllers/ProjetoController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Projeto;
use App\Models\InstanciaProjeto;
use App\Models\TemplateArquitetura;
use App\Services\ProjetoService;

class ProjetoController extends Controller
{
    public function __construct(
        private ProjetoService $projetoService
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Para estudantes: mostrar projetos para criar instâncias
        if ($user && $user->tipo === 'estudante') {
            $projetos = Projeto::where('status', 'ativo')
                ->with(['criadoPor'])
                ->get();
                
            // Buscar projetos onde o usuário já criou instâncias
            $projetosComInstancia = InstanciaProjeto::where('usuario_id', $user->id)
                ->pluck('projeto_id')
                ->toArray();
                
            return Inertia::render('Projetos/IndexEstudante', [
                'projetos' => $projetos,
                'projetosComInstancia' => $projetosComInstancia
            ]);
        }
        
        // Para coordenadores e professores: interface de gestão/visualização
        $projetos = Projeto::ativos()
            ->with('criador')
            ->when($request->search, function($query, $search) {
                $query->where('titulo', 'like', "%{$search}%")
                      ->orWhere('descricao', 'like', "%{$search}%");
            })
            ->when($request->categoria, function($query, $categoria) {
                $query->where('categoria', $categoria);
            })
            ->when($request->nivel, function($query, $nivel) {
                $query->where('nivel_dificuldade', $nivel);
            })
            ->paginate(12);

        $categorias = Projeto::distinct()->pluck('categoria');
        $niveis = ['base', 'padrao', 'avancado'];

        return Inertia::render('Projetos/Index', [
            'projetos' => $projetos,
            'categorias' => $categorias,
            'niveis' => $niveis,
            'filtros' => $request->only(['search', 'categoria', 'nivel'])
        ]);
    }

    public function show($id)
    {
        $projeto = Projeto::with('criador')->findOrFail($id);

        $meuProjeto = null;
        if (auth()->check()) {
            $meuProjeto = InstanciaProjeto::where('projeto_id', $id)
                ->where('usuario_id', auth()->id())
                ->with('avaliacaoAtual')
                ->first();
        }

        $templates = TemplateArquitetura::ativos()->get();

        return Inertia::render('Projetos/Show', [
            'projeto' => $projeto,
            'meuProjeto' => $meuProjeto,
            'templates' => $templates
        ]);
    }

    // MÉTODO CORRIGIDO - agora usa route model binding corretamente
    public function iniciar(Request $request, Projeto $projeto)
    {
        try {
            $request->validate([
                'nivel_arquitetura' => 'required|in:base,padrao,avancado',
            ]);

            // Verificar se já existe instância ativa
            $instanciaExistente = InstanciaProjeto::where('projeto_id', $projeto->id)
                ->where('usuario_id', auth()->id())
                ->whereIn('status', ['iniciado', 'em_desenvolvimento'])
                ->first();

            if ($instanciaExistente) {
                return back()->withErrors([
                    'projeto' => 'Você já possui uma instância ativa deste projeto.'
                ]);
            }

            $instancia = $this->projetoService->iniciarProjeto(
                $projeto,
                auth()->user(),
                $request->nivel_arquitetura
            );

            return redirect()->route('meus-projetos.show', $instancia->id)
                ->with('success', 'Projeto iniciado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao iniciar projeto: ' . $e->getMessage());

            return back()->withErrors([
                'projeto' => 'Erro ao iniciar projeto. Tente novamente.'
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'categoria' => 'required|max:50',
            'nivel_dificuldade' => 'required|in:base,padrao,avancado',
            'tecnologias' => 'array',
            'duracao_estimada' => 'integer|min:1',
            'imagem' => 'image|max:2048'
        ]);

        $data = $request->all();
        $data['criado_por'] = auth()->id();

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('projetos', 'public');
        }

        $projeto = Projeto::create($data);

        return redirect()->route('projetos.show', $projeto->id)
            ->with('success', 'Projeto criado com sucesso!');
    }

    public function create()
    {
        return Inertia::render('Projetos/Create');
    }

    public function destroy(Projeto $projeto)
    {
        // Verificar se o usuário tem permissão para deletar
        if ($projeto->criado_por !== auth()->id()) {
            abort(403);
        }

        $projeto->delete();

        return redirect()->route('projetos.index')
            ->with('success', 'Projeto deletado com sucesso!');
    }
}
