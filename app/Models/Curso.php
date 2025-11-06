<?php

// app/Models/Curso.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'codigo',
        'descricao',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function estudantes()
    {
        return $this->hasMany(User::class)->where('tipo', 'estudante');
    }
}
