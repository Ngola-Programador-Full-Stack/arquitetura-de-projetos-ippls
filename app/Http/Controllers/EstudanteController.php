<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Turma;
use App\Models\Curso;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class EstudanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $estudantes = User::where('tipo', 'estudante')
            ->with(['curso', 'turma', 'instanciasProjeto'])
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(12);

        return Inertia::render('Estudante/Index', [
            'estudantes' => $estudantes,
            'filtros' => $request->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursos = Curso::where('ativo', true)->orderBy('nome')->get();
        $turmas = Turma::where('ativo', true)->with('curso')->orderBy('nome')->get();
        
        return Inertia::render('Estudante/Create', [
            'cursos' => $cursos,
            'turmas' => $turmas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefone_encarregado' => 'required|string|max:15',
            'curso_id' => 'required|exists:cursos,id',
            'turma_id' => 'nullable|exists:turmas,id',
            'numero_estudante' => 'nullable|string|unique:users,numero_estudante',
            'imagem' => 'nullable|image|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefone_encarregado' => $request->telefone_encarregado,
            'tipo' => 'estudante',
            'ativo' => true,
            'curso_id' => $request->curso_id,
            'turma_id' => $request->turma_id,
            'numero_estudante' => $request->numero_estudante,
        ];

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('estudantes', 'public');
        }

        $user = User::create($data);

        event(new Registered($user));

        return redirect()->route('estudante.index')
            ->with('success', 'Estudante criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
