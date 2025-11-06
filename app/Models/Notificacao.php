<?php

// app/Models/Notificacao.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;

    protected $table = 'notificacoes';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'mensagem',
        'tipo',
        'lida',
        'data_leitura',
        'acao_url'
    ];

    protected $casts = [
        'lida' => 'boolean',
        'data_leitura' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function marcarComoLida()
    {
        $this->update([
            'lida' => true,
            'data_leitura' => now()
        ]);
    }

    public function getTipoBadgeClass()
    {
        return match($this->tipo) {
            'info' => 'bg-blue-100 text-blue-800',
            'sucesso' => 'bg-green-100 text-green-800',
            'aviso' => 'bg-yellow-100 text-yellow-800',
            'erro' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function scopeNaoLidas($query)
    {
        return $query->where('lida', false);
    }
}
