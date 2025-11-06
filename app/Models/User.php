<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
        'telefone_encarregado',
        'numero_estudante',
        'curso_id',
        'turma_id',
        'ativo',
        'imagem'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ativo' => 'boolean'
    ];

    public function curso() { return $this->belongsTo(Curso::class); }
    public function turma() { return $this->belongsTo(Turma::class); }
    public function instanciasProjeto() { return $this->hasMany(InstanciaProjeto::class, 'usuario_id'); }
    public function avaliacoes() { return $this->hasMany(Avaliacao::class, 'avaliador_id'); }
    public function notificacoes() { return $this->hasMany(Notificacao::class); }
    
    // Relacionamento many-to-many para professores com suas turmas
    public function turmas() { 
        return $this->belongsToMany(Turma::class, 'professor_turma', 'professor_id', 'turma_id')
                    ->withTimestamps();
    }

    public function isEstudante() { return $this->tipo === 'estudante'; }
    public function isProfessor() { return $this->tipo === 'professor'; }
    public function isCoordenador() { return $this->tipo === 'coordenador'; }

    public function getProjetosAtivoCount() {
        return $this->instanciasProjeto()
            ->whereIn('status', ['iniciado', 'em_desenvolvimento'])
            ->count();
    }
}
