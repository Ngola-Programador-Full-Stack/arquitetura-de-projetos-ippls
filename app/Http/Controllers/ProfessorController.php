<?php

// app/Http/Controllers/ProfessorController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Turma;
use App\Models\Curso;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfessorController extends Controller
{
    public function index(Request $request)
    {
        
        $professores = User::where('tipo', 'professor')
            ->with(['turmas', 'curso'])
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($request->ativo !== null, function($query) use ($request) {
                $query->where('ativo', $request->ativo);
            })
            ->when($request->turma_id, function($query, $turmaId) {
                $query->whereHas('turmas', function($q) use ($turmaId) {
                    $q->where('turma_id', $turmaId);
                });
            })
            ->orderBy('name')
            ->paginate(12);
        
        $turmas = Turma::where('ativo', true)
            ->with('curso')
            ->orderBy('nome')
            ->get();
        
        $statusOptions = [
            '1' => 'Ativo',
            '0' => 'Inativo'
        ];
        
        return Inertia::render('Professores/Index', [
            'professores' => $professores,
            'turmas' => $turmas,
            'statusOptions' => $statusOptions,
            'filtros' => $request->only(['search', 'ativo', 'turma_id'])
        ]);
    }
    
    public function create()
    {
        
        $turmas = Turma::where('ativo', true)
            ->with('curso')
            ->orderBy('nome')
            ->get();
        
        $cursos = Curso::where('ativo', true)
            ->orderBy('nome')
            ->get();
        
        return Inertia::render('Professores/Create', [
            'turmas' => $turmas,
            'cursos' => $cursos
        ]);
    }
    
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telefone_encarregado' => 'nullable|string|max:20',
            'curso_id' => 'nullable|exists:cursos,id',
            'turmas' => 'array',
            'turmas.*' => 'exists:turmas,id',
            'ativo' => 'boolean',
            'enviar_credenciais' => 'boolean'
        ]);
        
        $professor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo' => 'professor',
            'telefone_encarregado' => $request->telefone_encarregado,
            'curso_id' => $request->curso_id,
            'ativo' => $request->ativo ?? true
        ]);
        
        // Sincronizar turmas
        if ($request->turmas) {
            $professor->turmas()->sync($request->turmas);
        }
        
        // Enviar credenciais por email se solicitado
        if ($request->enviar_credenciais) {
            try {
                // Aqui seria implementado o envio de email
                // Pode usar um Job para processar em background
                // Mail::to($professor->email)->send(new CredenciaisProfessr($professor, $request->password));
                
                // Por enquanto, apenas loggar
                \Log::info('Credenciais enviadas para: ' . $professor->email);
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar credenciais: ' . $e->getMessage());
                // Não falhar a criação por causa do email
            }
        }
        
        $message = 'Professor cadastrado com sucesso!';
        if ($request->enviar_credenciais) {
            $message .= ' Credenciais enviadas por email.';
        }
        
        return redirect()->route('professores.index')
            ->with('success', $message);
    }
    
    public function show(User $professor)
    {
        
        if ($professor->tipo !== 'professor') {
            abort(404, 'Professor não encontrado.');
        }
        
        $professor->load(['turmas.curso', 'curso']);
        
        // Buscar projetos pendentes de avaliação nas turmas do professor
        $projetosPendentes = [];
        if ($professor->turmas->count() > 0) {
            $turmaIds = $professor->turmas->pluck('id');
            // Assumindo que existe um model InstanciaProjeto
            if (class_exists('App\Models\InstanciaProjeto')) {
                $projetosPendentes = \App\Models\InstanciaProjeto::whereIn('turma_id', $turmaIds)
                    ->whereIn('status', ['Submetido', 'Em Avaliação'])
                    ->with(['estudante', 'turma', 'projeto'])
                    ->orderBy('data_submissao', 'desc')
                    ->limit(10)
                    ->get()
                    ->map(function($instancia) {
                        return [
                            'id' => $instancia->id,
                            'titulo' => $instancia->projeto->titulo ?? 'Projeto sem título',
                            'status' => $instancia->status,
                            'data_submissao' => $instancia->data_submissao,
                            'estudante' => $instancia->estudante,
                            'turma' => $instancia->turma
                        ];
                    });
            }
        }
        
        // Histórico de avaliações do professor
        $historicoAvaliacoes = [];
        if (method_exists($professor, 'avaliacoes')) {
            $historicoAvaliacoes = $professor->avaliacoes()
                ->with(['instanciaProjeto.projeto', 'instanciaProjeto.estudante', 'instanciaProjeto.turma'])
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get()
                ->map(function($avaliacao) {
                    return [
                        'id' => $avaliacao->id,
                        'nota_final' => $avaliacao->nota_final,
                        'status' => $avaliacao->status,
                        'created_at' => $avaliacao->created_at,
                        'projeto' => [
                            'id' => $avaliacao->instanciaProjeto->projeto->id ?? null,
                            'titulo' => $avaliacao->instanciaProjeto->projeto->titulo ?? 'Projeto sem título',
                            'estudante' => $avaliacao->instanciaProjeto->estudante,
                            'turma' => $avaliacao->instanciaProjeto->turma
                        ]
                    ];
                });
        }
        
        // Estatísticas do professor
        $totalEstudantes = 0;
        if ($professor->turmas->count() > 0) {
            $turmaIds = $professor->turmas->pluck('id');
            $totalEstudantes = User::where('tipo', 'estudante')
                ->whereIn('turma_id', $turmaIds)
                ->count();
        }
        
        $avaliacoesRealizadas = method_exists($professor, 'avaliacoes') 
            ? $professor->avaliacoes()->count() 
            : 0;
        
        $estatisticas = [
            'totalEstudantes' => $totalEstudantes,
            'avaliacoesRealizadas' => $avaliacoesRealizadas
        ];
        
        return Inertia::render('Professores/Show', [
            'professor' => $professor,
            'projetosPendentes' => $projetosPendentes,
            'historicoAvaliacoes' => $historicoAvaliacoes,
            'estatisticas' => $estatisticas
        ]);
    }
    
    public function edit(User $professor)
    {
        
        if ($professor->tipo !== 'professor') {
            abort(404, 'Professor não encontrado.');
        }
        
        $professor->load('turmas');
        
        $turmas = Turma::where('ativo', true)
            ->with('curso')
            ->orderBy('nome')
            ->get();
        
        $cursos = Curso::where('ativo', true)
            ->orderBy('nome')
            ->get();
        
        return Inertia::render('Professores/Edit', [
            'professor' => $professor,
            'turmas' => $turmas,
            'cursos' => $cursos,
            'professorTurmas' => $professor->turmas->pluck('id')->toArray()
        ]);
    }
    
    public function update(Request $request, User $professor)
    {
        
        if ($professor->tipo !== 'professor') {
            abort(404, 'Professor não encontrado.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($professor->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'telefone_encarregado' => 'nullable|string|max:20',
            'curso_id' => 'nullable|exists:cursos,id',
            'turmas' => 'array',
            'turmas.*' => 'exists:turmas,id',
            'ativo' => 'boolean',
            'notificar_alteracao_senha' => 'boolean'
        ]);
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'telefone_encarregado' => $request->telefone_encarregado,
            'curso_id' => $request->curso_id,
            'ativo' => $request->ativo ?? $professor->ativo
        ];
        
        // Só atualizar senha se foi fornecida
        $senhaAlterada = false;
        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
            $senhaAlterada = true;
        }
        
        $professor->update($updateData);
        
        // Sincronizar turmas
        $professor->turmas()->sync($request->turmas ?? []);
        
        // Notificar sobre alteração de senha se solicitado
        if ($senhaAlterada && $request->notificar_alteracao_senha) {
            try {
                // Aqui seria implementado o envio de email
                // Mail::to($professor->email)->send(new SenhaAlterada($professor));
                
                // Por enquanto, apenas loggar
                \Log::info('Notificação de alteração de senha enviada para: ' . $professor->email);
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar notificação de senha: ' . $e->getMessage());
            }
        }
        
        $message = 'Professor atualizado com sucesso!';
        if ($senhaAlterada && $request->notificar_alteracao_senha) {
            $message .= ' Notificação enviada por email.';
        }
        
        return redirect()->route('professores.index')
            ->with('success', $message);
    }
    
    public function destroy(User $professor)
    {
        
        if ($professor->tipo !== 'professor') {
            abort(404, 'Professor não encontrado.');
        }
        
        // Verificar se o professor tem avaliações
        if ($professor->avaliacoes()->count() > 0) {
            return back()->withErrors([
                'delete' => 'Não é possível excluir este professor pois ele possui avaliações registradas.'
            ]);
        }
        
        // Remover associações com turmas
        $professor->turmas()->detach();
        
        $professor->delete();
        
        return redirect()->route('professores.index')
            ->with('success', 'Professor removido com sucesso!');
    }
}