<?php

// app/Models/Avaliacao.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    protected $fillable = [
        'instancia_projeto_id',
        'avaliador_id',
        'nota',
        'nota_final',
        'comentarios',
        'criterios_avaliacao',
        'status',
        'data_avaliacao'
    ];

    protected $casts = [
        'criterios_avaliacao' => 'array',
        'data_avaliacao' => 'datetime'
    ];

    public function instanciaProjeto()
    {
        return $this->belongsTo(InstanciaProjeto::class);
    }

    public function avaliador()
    {
        return $this->belongsTo(User::class, 'avaliador_id');
    }

    public function getNotaFormatada()
    {
        return number_format($this->nota, 1) . '/20';
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pendente' => 'bg-yellow-100 text-yellow-800',
            'em_avaliacao' => 'bg-blue-100 text-blue-800',
            'avaliado' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
