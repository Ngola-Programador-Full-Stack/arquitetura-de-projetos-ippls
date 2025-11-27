<?php

// app/Services/NotificacaoService.php
namespace App\Services;

use App\Models\Notificacao;
use App\Models\User;

class NotificacaoService
{
    public function enviarNotificacao(
        User $usuario,
        string $titulo,
        string $mensagem,
        string $tipo = 'info',
        ?string $acaoUrl = null
    ): Notificacao {
        return Notificacao::create([
            'usuario_id' => $usuario->id,
            'titulo' => $titulo,
            'mensagem' => $mensagem,
            'tipo' => $tipo,
            'acao_url' => $acaoUrl
        ]);
    }

    public function enviarNotificacaoEmMassa(
        array $usuarios,
        string $titulo,
        string $mensagem,
        string $tipo = 'info',
        ?string $acaoUrl = null
    ): void {
        $dados = collect($usuarios)->map(function($usuario) use ($titulo, $mensagem, $tipo, $acaoUrl) {
            return [
                'usuario_id' => $usuario->id,
                'titulo' => $titulo,
                'mensagem' => $mensagem,
                'tipo' => $tipo,
                'acao_url' => $acaoUrl,
                'created_at' => now(),
                'updated_at' => now()
            ];
        })->toArray();

        Notificacao::insert($dados);
    }

    public function notificarNovoProjetoDisponivel(int $projetoId): void
    {
        $estudantes = User::where('tipo', 'estudante')
            ->where('ativo', true)
            ->get();

        $this->enviarNotificacaoEmMassa(
            $estudantes,
            'Novo Projeto Disponível',
            'Um novo projeto foi adicionado à plataforma. Confira agora!',
            'info',
            route('projetos.show', $projetoId)
        );
    }

    // Implementar em NotificacaoService.php
    public function notificarPrazoEntrega(int $dias = 7): void
    {
        $instancias = InstanciaProjeto::where('status', '!=', 'concluido')
            ->whereNotNull('data_entrega')
            ->where('data_entrega', '<=', now()->addDays($dias))
            ->with('usuario')
            ->get();
        
        foreach ($instancias as $instancia) {
            $diasRestantes = now()->diffInDays($instancia->data_entrega);
            $this->enviarNotificacao(
                $instancia->usuario,
                'Prazo de Entrega Próximo',
                "Seu projeto '{$instancia->projeto->titulo}' tem {$diasRestantes} dias para entrega.",
                'aviso',
                route('meus-projetos.show', $instancia->id)
            );
        }
    }
}
