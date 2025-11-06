<?php

// app/Models/Projeto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'imagem',
        'categoria',
        'nivel_dificuldade',
        'tecnologias',
        'requisitos',
        'duracao_estimada',
        'status',
        'criado_por'
    ];

    protected $casts = [
        'tecnologias' => 'array'
    ];

    public function criador()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    public function instancias()
    {
        return $this->hasMany(InstanciaProjeto::class);
    }

    public function instanciasAtivas()
    {
        return $this->hasMany(InstanciaProjeto::class)
            ->whereIn('status', ['iniciado', 'em_desenvolvimento']);
    }

    public function getImagemUrl()
    {
        return $this->imagem ? asset('storage/' . $this->imagem) : asset('images/');
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }
}
