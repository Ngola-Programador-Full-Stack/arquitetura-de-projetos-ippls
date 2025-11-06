<?php

// app/Models/TemplateArquitetura.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplateArquitetura extends Model
{
    use HasFactory;

    protected $table = 'templates_arquitetura';

    protected $fillable = [
        'nome',
        'nivel',
        'descricao',
        'estrutura_diretorios',
        'arquivos_base',
        'dependencias',
        'instrucoes_uso',
        'ativo'
    ];

    // ✅ IMPORTANTE: Converter JSON automaticamente
    protected $casts = [
        'estrutura_diretorios' => 'array',
        'arquivos_base' => 'array',
        'dependencias' => 'array',
        'ativo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // ✅ Scope para templates ativos
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    // ✅ Scope por nível
    public function scopePorNivel($query, $nivel)
    {
        return $query->where('nivel', $nivel);
    }

    // ✅ Accessor para garantir que estrutura_diretorios seja sempre array
    public function getEstruturaDiretoriosAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    // ✅ Accessor para garantir que arquivos_base seja sempre array
    public function getArquivosBaseAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    // ✅ Accessor para garantir que dependencias seja sempre array
    public function getDependenciasAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    // ✅ Método helper para obter badge do nível
    public function getNivelBadgeAttribute()
    {
        return match($this->nivel) {
            'base' => ['label' => 'Base', 'color' => 'green'],
            'padrao' => ['label' => 'Padrão', 'color' => 'blue'],
            'avancado' => ['label' => 'Avançado', 'color' => 'purple'],
            default => ['label' => 'Desconhecido', 'color' => 'gray']
        };
    }
}
