<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EstudanteController;

// Middleware auth para proteger as rotas do sistema
Route::middleware('auth', 'verified')->group(function () {
    Route::prefix('estudantes')->name('estudante.')->group(function () {
        Route::get('/', [EstudanteController::class, 'index'])->name('index');
        Route::get('/create', [EstudanteController::class, 'create'])->name('create');
        Route::post('/store', [EstudanteController::class, 'store'])->name('store');
        Route::get('/{projeto}', [EstudanteController::class, 'show'])->name('show');
    });
});
