<?php

// app/Http/Controllers/NotificacaoController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Notificacao;

class NotificacaoController extends Controller
{
    public function index(Request $request)
    {
        $query = Notificacao::where('usuario_id', auth()->id());
        
        // Filtros
        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->lida !== null) {
            $query->where('lida', $request->lida);
        }
        
        if ($request->data_inicio) {
            $query->where('created_at', '>=', $request->data_inicio);
        }
        
        if ($request->data_fim) {
            $query->where('created_at', '<=', $request->data_fim);
        }
        
        $notificacoes = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Estatísticas
        $estatisticas = [
            'total' => Notificacao::where('usuario_id', auth()->id())->count(),
            'nao_lidas' => Notificacao::where('usuario_id', auth()->id())->where('lida', false)->count(),
            'por_tipo' => Notificacao::where('usuario_id', auth()->id())
                ->selectRaw('tipo, count(*) as total')
                ->groupBy('tipo')
                ->pluck('total', 'tipo')
        ];
        
        $tipos = ['sucesso', 'info', 'aviso', 'erro'];
        $filtros = $request->only(['tipo', 'lida', 'data_inicio', 'data_fim']);

        return Inertia::render('Notificacoes/Index', [
            'notificacoes' => $notificacoes,
            'estatisticas' => $estatisticas,
            'tipos' => $tipos,
            'filtros' => $filtros
        ]);
    }

    public function marcarComoLida($id)
    {
        $notificacao = Notificacao::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $notificacao->marcarComoLida();

        return back();
    }

    public function marcarTodasComoLidas()
    {
        Notificacao::where('usuario_id', auth()->id())
            ->where('lida', false)
            ->update([
                'lida' => true,
                'data_leitura' => now()
            ]);

        // Para requisições AJAX, retornar JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Todas as notificações foram marcadas como lidas'
            ]);
        }

        return back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    public function destroy($id)
    {
        $notificacao = Notificacao::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $notificacao->delete();

        // Para requisições AJAX, retornar JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notificação removida com sucesso'
            ]);
        }

        return back()->with('success', 'Notificação removida com sucesso.');
    }
    
    /**
     * API para obter notificações não lidas (para atualizações em tempo real)
     */
    public function naoLidas()
    {
        $notificacoes = Notificacao::where('usuario_id', auth()->id())
            ->where('lida', false)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        return response()->json([
            'notificacoes' => $notificacoes,
            'total_nao_lidas' => Notificacao::where('usuario_id', auth()->id())
                ->where('lida', false)
                ->count()
        ]);
    }
    
    /**
     * API para marcar notificação como lida via AJAX
     */
    public function marcarLidaAjax($id)
    {
        $notificacao = Notificacao::where('id', $id)
            ->where('usuario_id', auth()->id())
            ->firstOrFail();

        $notificacao->update([
            'lida' => true,
            'data_leitura' => now()
        ]);

        // Para requisições AJAX, retornar JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notificação marcada como lida'
            ]);
        }

        // Para requisições Inertia, retornar redirect
        return back()->with('success', 'Notificação marcada como lida');
    }
    
    /**
     * API para obter estatísticas de notificações
     */
    public function estatisticas()
    {
        $usuarioId = auth()->id();
        
        $estatisticas = [
            'total' => Notificacao::where('usuario_id', $usuarioId)->count(),
            'nao_lidas' => Notificacao::where('usuario_id', $usuarioId)->where('lida', false)->count(),
            'por_tipo' => Notificacao::where('usuario_id', $usuarioId)
                ->selectRaw('tipo, count(*) as total')
                ->groupBy('tipo')
                ->pluck('total', 'tipo'),
            'recentes' => Notificacao::where('usuario_id', $usuarioId)
                ->where('created_at', '>=', now()->subDays(7))
                ->count()
        ];
        
        return response()->json($estatisticas);
    }
}
