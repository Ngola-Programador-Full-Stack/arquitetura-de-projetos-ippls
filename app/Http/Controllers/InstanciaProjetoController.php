<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstanciaProjeto;
use App\Models\Projeto;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InstanciaProjetoController extends Controller
{
    /**
     * Exibir projetos disponíveis para inscrição
     */
    public function index()
    {
        $user = Auth::user();
        
        // Buscar projetos disponíveis
        $projetos = Projeto::where('status', 'ativo')
            ->with(['criadoPor'])
            ->get();
            
        // Buscar projetos onde o usuário já está inscrito
        $projetosInscritos = InstanciaProjeto::where('usuario_id', $user->id)
            ->pluck('projeto_id')
            ->toArray();
            
        return Inertia::render('Inscricoes/Index', [
            'projetos' => $projetos,
            'projetosInscritos' => $projetosInscritos
        ]);
    }
    
    /**
     * Mostrar formulário de inscrição em projeto
     */
    public function create(Projeto $projeto)
    {
        $user = Auth::user();
        
        // Verificar se já está inscrito
        $jaInscrito = InstanciaProjeto::where('usuario_id', $user->id)
            ->where('projeto_id', $projeto->id)
            ->exists();
            
        if ($jaInscrito) {
            return redirect()->route('inscricoes.index')
                ->with('error', 'Você já está inscrito neste projeto.');
        }
        
        return Inertia::render('Inscricoes/Inscricao', [
            'projeto' => $projeto->load('criadoPor')
        ]);
    }
    
    /**
     * Processar inscrição em projeto
     */
    public function store(Request $request, Projeto $projeto)
    {
        $user = Auth::user();
        
        // Verificar se já está inscrito
        $jaInscrito = InstanciaProjeto::where('usuario_id', $user->id)
            ->where('projeto_id', $projeto->id)
            ->exists();
            
        if ($jaInscrito) {
            return redirect()->route('inscricoes.index')
                ->with('error', 'Você já está inscrito neste projeto.');
        }
        
        $request->validate([
            'nivel_arquitetura' => 'required|in:base,padrao,avancado',
            'repositorio_url' => 'nullable|url',
            'observacoes' => 'nullable|string|max:1000'
        ]);
        
        InstanciaProjeto::create([
            'projeto_id' => $projeto->id,
            'usuario_id' => $user->id,
            'nivel_arquitetura' => $request->nivel_arquitetura,
            'repositorio_url' => $request->repositorio_url,
            'observacoes' => $request->observacoes,
            'status' => 'iniciado',
            'percentual_conclusao' => 0,
            'data_inicio' => now()
        ]);
        
        return redirect()->route('inscricoes.show', $projeto)
            ->with('success', 'Inscrição realizada com sucesso!');
    }
    
    /**
     * Exibir detalhes do projeto inscrito
     */
    public function show(Projeto $projeto)
    {
        $user = Auth::user();
        
        $instancia = InstanciaProjeto::where('usuario_id', $user->id)
            ->where('projeto_id', $projeto->id)
            ->with(['projeto.criadoPor', 'avaliacoes.avaliador'])
            ->first();
            
        if (!$instancia) {
            return redirect()->route('inscricoes.index')
                ->with('error', 'Você não está inscrito neste projeto.');
        }
        
        return Inertia::render('MeusProjetos/Show', [
            'instancia' => $instancia
        ]);
    }
    
    /**
     * Atualizar progresso do projeto
     */
    public function updateProgress(Request $request, Projeto $projeto)
    {
        $user = Auth::user();
        
        $instancia = InstanciaProjeto::where('usuario_id', $user->id)
            ->where('projeto_id', $projeto->id)
            ->first();
            
        if (!$instancia) {
            return redirect()->route('inscricoes.index')
                ->with('error', 'Você não está inscrito neste projeto.');
        }
        
        $request->validate([
            'percentual_conclusao' => 'required|integer|min:0|max:100',
            'repositorio_url' => 'nullable|url',
            'observacoes' => 'nullable|string|max:1000'
        ]);
        
        $status = match(true) {
            $request->percentual_conclusao == 0 => 'iniciado',
            $request->percentual_conclusao == 100 => 'concluido',
            default => 'em_desenvolvimento'
        };
        
        $instancia->update([
            'percentual_conclusao' => $request->percentual_conclusao,
            'repositorio_url' => $request->repositorio_url,
            'observacoes' => $request->observacoes,
            'status' => $status,
            'data_conclusao' => $request->percentual_conclusao == 100 ? now() : null
        ]);
        
        return redirect()->back()
            ->with('success', 'Progresso atualizado com sucesso!');
    }
    
    /**
     * Listar meus projetos inscritos
     */
    public function meusProjetos()
    {
        $user = Auth::user();
        
        $instancias = InstanciaProjeto::where('usuario_id', $user->id)
            ->with(['projeto.criadoPor'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return Inertia::render('MeusProjetos/MeusProjetosInscritos', [
            'instancias' => $instancias
        ]);
    }
}
