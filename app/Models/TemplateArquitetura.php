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
        'subtitulo',
        'nivel',
        'descricao',
        'descricao_completa',
        'estrutura_diretorios',
        'arquivos_base',
        'dependencias',
        'requisitos',
        'beneficios',
        'casos_uso',
        'caracteristicas',
        'instrucoes_uso',
        'tempo_setup',
        'para_iniciantes',
        'gratuito',
        'documentado',
        'ativo'
    ];

    // ✅ IMPORTANTE: Converter JSON automaticamente
    protected $casts = [
        'estrutura_diretorios' => 'array',
        'arquivos_base' => 'array',
        'dependencias' => 'array',
        'requisitos' => 'array',
        'beneficios' => 'array',
        'casos_uso' => 'array',
        'caracteristicas' => 'array',
        'ativo' => 'boolean',
        'para_iniciantes' => 'boolean',
        'gratuito' => 'boolean',
        'documentado' => 'boolean',
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
        return $this->decodeAttributeToArray($value);
    }

    // ✅ Accessor para garantir que arquivos_base seja sempre array
    public function getArquivosBaseAttribute($value)
    {
        return $this->decodeAttributeToArray($value);
    }

    // ✅ Accessor para garantir que dependencias seja sempre array
    public function getDependenciasAttribute($value)
    {
        return $this->decodeAttributeToArray($value);
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

    private function decodeAttributeToArray($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (!is_string($value) || $value === '') {
            return [];
        }

        $candidates = [
            $value,
            trim($value),
            trim($value, "\"'"),
            trim(trim($value), "\"'"),
            stripslashes($value),
            stripslashes(trim($value)),
            stripslashes(trim($value, "\"'")),
        ];

        foreach ($candidates as $candidate) {
            if (!is_string($candidate) || $candidate === '') {
                continue;
            }

            $decoded = json_decode($candidate, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }
}
