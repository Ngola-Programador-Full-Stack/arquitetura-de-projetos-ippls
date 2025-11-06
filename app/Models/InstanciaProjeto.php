<?php

// app/Models/InstanciaProjeto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstanciaProjeto extends Model
{
    use HasFactory;

    protected $table = 'instancias_projeto';

    protected $fillable = [
        'projeto_id',
        'usuario_id',
        'turma_id',
        'nivel_arquitetura',
        'percentual_conclusao',
        'status',
        'data_inicio',
        'data_conclusao',
        'data_entrega',
        'data_submissao',
        'observacoes',
        'repositorio_url',
        'arquivos_anexos'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_conclusao' => 'datetime',
        'data_entrega' => 'datetime',
        'data_submissao' => 'datetime',
        'arquivos_anexos' => 'array'
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    
    public function estudante()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function avaliacaoAtual()
    {
        return $this->hasOne(Avaliacao::class)->latest();
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'iniciado' => 'bg-blue-100 text-blue-800',
            'em_desenvolvimento' => 'bg-yellow-100 text-yellow-800',
            'concluido' => 'bg-green-100 text-green-800',
            'abandonado' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'iniciado' => 'Iniciado',
            'em_desenvolvimento' => 'Em Desenvolvimento',
            'concluido' => 'Concluído',
            'abandonado' => 'Abandonado',
            default => 'Desconhecido'
        };
    }
}
