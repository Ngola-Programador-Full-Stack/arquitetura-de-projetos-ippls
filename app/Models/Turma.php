<?php

// app/Models/Turma.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'periodo',
        'ano_letivo',
        'curso_id',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function estudantes()
    {
        return $this->hasMany(User::class)->where('tipo', 'estudante');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    // Relacionamento many-to-many com professores
    public function professores()
    {
        return $this->belongsToMany(User::class, 'professor_turma', 'turma_id', 'professor_id')
                    ->where('users.tipo', 'professor')
                    ->withTimestamps();
    }

    public function getNomeCompleto()
    {
        return "{$this->nome} - {$this->periodo} ({$this->ano_letivo})";
    }
}

