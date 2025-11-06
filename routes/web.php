<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\MeuProjetoController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Middleware auth para proteger as rotas do sistema
Route::middleware('auth')->group(function () {

    // Projetos (CRUD para coordenadores - Templates base)
    Route::get('/projetos', [ProjetoController::class, 'index'])->name('projetos.index');
    Route::get('/projetos/create', [ProjetoController::class, 'create'])->name('projetos.create');
    Route::post('/projetos', [ProjetoController::class, 'store'])->name('projetos.store');
    Route::get('/projetos/{projeto}', [ProjetoController::class, 'show'])->name('projetos.show');
    Route::delete('/projetos/{projeto}', [ProjetoController::class, 'destroy'])->name('projetos.destroy');

    // Meus Projetos (Estudantes gerenciam suas instâncias)
    Route::get('/meus-projetos', [App\Http\Controllers\MeuProjetoController::class, 'index'])->name('meus-projetos.index');
    Route::get('/meus-projetos/criar/{projeto}', [App\Http\Controllers\MeuProjetoController::class, 'create'])->name('meus-projetos.create');
    Route::post('/meus-projetos/criar/{projeto}', [App\Http\Controllers\MeuProjetoController::class, 'store'])->name('meus-projetos.store');
    Route::get('/meus-projetos/{instancia}', [App\Http\Controllers\MeuProjetoController::class, 'show'])->name('meus-projetos.show');

    // Gerenciamento de instâncias
    Route::put('/meus-projetos/{instancia}/progresso', [App\Http\Controllers\MeuProjetoController::class, 'atualizarProgresso'])->name('meus-projetos.atualizar-progresso');
    Route::post('/meus-projetos/{instancia}/anexo', [App\Http\Controllers\MeuProjetoController::class, 'uploadAnexo'])->name('meus-projetos.upload-anexo');
    Route::get('/meus-projetos/{instancia}/template', [MeuProjetoController::class, 'downloadTemplate'])->name('meus-projetos.download-template');

    // Turmas (CRUD para coordenadores)
    Route::resource('turmas', App\Http\Controllers\TurmaController::class);

    // Templates
    Route::get('/templates', [App\Http\Controllers\TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{template}', [App\Http\Controllers\TemplateController::class, 'show'])->name('templates.show');
    Route::get('/templates/{template}/download', [App\Http\Controllers\TemplateController::class, 'download'])->name('templates.download');

    // Notificações
    Route::get('/notificacoes', [App\Http\Controllers\NotificacaoController::class, 'index'])->name('notificacoes.index');
    Route::get('/notificacoes/nao-lidas', [App\Http\Controllers\NotificacaoController::class, 'naoLidas'])->name('notificacoes.nao-lidas');
    Route::get('/notificacoes/estatisticas', [App\Http\Controllers\NotificacaoController::class, 'estatisticas'])->name('notificacoes.estatisticas');
    Route::post('/notificacoes/{id}/marcar-lida', [App\Http\Controllers\NotificacaoController::class, 'marcarLidaAjax'])->name('notificacoes.marcar-lida-ajax');
    Route::post('/notificacoes/marcar-todas-lidas', [App\Http\Controllers\NotificacaoController::class, 'marcarTodasComoLidas'])->name('notificacoes.marcar-todas-lidas');
    Route::delete('/notificacoes/{id}', [App\Http\Controllers\NotificacaoController::class, 'destroy'])->name('notificacoes.destroy');

    // Avaliações (para professores)
    Route::get('/avaliacoes', [App\Http\Controllers\AvaliacaoController::class, 'index'])->name('avaliacoes.index');
    Route::get('/avaliacoes/{avaliacao}', [App\Http\Controllers\AvaliacaoController::class, 'show'])->name('avaliacoes.show');
    Route::post('/avaliacoes/{instancia}', [App\Http\Controllers\AvaliacaoController::class, 'store'])->name('avaliacoes.store');

    // Supervisão (para coordenadores)
    Route::get('/supervisao', [App\Http\Controllers\SupervisaoController::class, 'index'])->name('supervisao.index');
    Route::get('/supervisao/relatorio', [App\Http\Controllers\SupervisaoController::class, 'relatorio'])->name('supervisao.relatorio');
    Route::get('/supervisao/exportar-csv', [App\Http\Controllers\SupervisaoController::class, 'exportarCsv'])->name('supervisao.exportar-csv');
    Route::get('/supervisao/exportar-excel', [App\Http\Controllers\SupervisaoController::class, 'exportarExcel'])->name('supervisao.exportar-excel');

    // Professores (CRUD para coordenadores)
    Route::resource('professores', App\Http\Controllers\ProfessorController::class)
        ->middleware('coordenador');


    // Configurações de usuário
    Route::get('/settings/appearance', fn () => Inertia::render('Settings/Appearance'))->name('appearance');

    // Perfil e senha (opcionalmente via Settings\ProfileController e PasswordController)
    require __DIR__.'/settings.php';
});

require __DIR__.'/auth.php';
require __DIR__.'/estudante.php';
