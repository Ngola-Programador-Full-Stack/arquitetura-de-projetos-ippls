<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Curso;
use Inertia\Inertia;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $turmas = Turma::with(['curso', 'users'])
            ->when($request->search, function($query, $search) {
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('periodo', 'like', "%{$search}%");
            })
            ->when($request->curso_id, function($query, $cursoId) {
                $query->where('curso_id', $cursoId);
            })
            ->when($request->ano_letivo, function($query, $ano) {
                $query->where('ano_letivo', $ano);
            })
            ->orderBy('nome')
            ->paginate(12);

        $cursos = Curso::where('ativo', true)->orderBy('nome')->get();
        $anosLetivos = Turma::distinct()->orderBy('ano_letivo', 'desc')->pluck('ano_letivo');

        return Inertia::render('Turmas/Index', [
            'turmas' => $turmas,
            'cursos' => $cursos,
            'anosLetivos' => $anosLetivos,
            'filtros' => $request->only(['search', 'curso_id', 'ano_letivo'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursos = Curso::where('ativo', true)->orderBy('nome')->get();
        
        return Inertia::render('Turmas/Create', [
            'cursos' => $cursos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:turmas,nome',
            'periodo' => 'required|in:Manhã,Tarde,Noite',
            'curso_id' => 'required|exists:cursos,id',
            'ano_letivo' => 'required|integer|min:2020|max:2030',
            'ativo' => 'boolean'
        ]);

        Turma::create([
            'nome' => $request->nome,
            'periodo' => $request->periodo,
            'curso_id' => $request->curso_id,
            'ano_letivo' => $request->ano_letivo,
            'ativo' => $request->ativo ?? true
        ]);

        return redirect()->route('turmas.index')
            ->with('success', 'Turma criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Turma $turma)
    {
        $turma->load(['curso', 'users']);
        
        // Estatísticas da turma
        $stats = [
            'total_estudantes' => $turma->users->count(),
            'estudantes_ativos' => $turma->users->where('ativo', true)->count(),
            'projetos_em_andamento' => $turma->users->sum(function($user) {
                return $user->instanciasProjeto()->whereIn('status', ['iniciado', 'em_desenvolvimento'])->count();
            }),
            'projetos_concluidos' => $turma->users->sum(function($user) {
                return $user->instanciasProjeto()->where('status', 'concluido')->count();
            })
        ];

        return Inertia::render('Turmas/Show', [
            'turma' => $turma,
            'stats' => $stats
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma)
    {
        $cursos = Curso::where('ativo', true)->orderBy('nome')->get();
        
        return Inertia::render('Turmas/Edit', [
            'turma' => $turma,
            'cursos' => $cursos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turma $turma)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:turmas,nome,' . $turma->id,
            'periodo' => 'required|in:Manhã,Tarde,Noite',
            'curso_id' => 'required|exists:cursos,id',
            'ano_letivo' => 'required|integer|min:2020|max:2030',
            'ativo' => 'boolean'
        ]);

        $turma->update([
            'nome' => $request->nome,
            'periodo' => $request->periodo,
            'curso_id' => $request->curso_id,
            'ano_letivo' => $request->ano_letivo,
            'ativo' => $request->ativo ?? true
        ]);

        return redirect()->route('turmas.index')
            ->with('success', 'Turma atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {
        // Verificar se a turma tem estudantes
        if ($turma->users()->count() > 0) {
            return redirect()->route('turmas.index')
                ->with('error', 'Não é possível excluir uma turma que possui estudantes.');
        }

        $turma->delete();

        return redirect()->route('turmas.index')
            ->with('success', 'Turma excluída com sucesso!');
    }
}
