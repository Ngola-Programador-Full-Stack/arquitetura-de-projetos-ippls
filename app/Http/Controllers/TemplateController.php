<?php

// app/Http/Controllers/TemplateController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\TemplateArquitetura;
use App\Services\TemplateService;

class TemplateController extends Controller
{
    public function __construct(
        private TemplateService $templateService
    ) {}

    public function index()
    {
        $templates = TemplateArquitetura::ativos()
            ->orderBy('nivel')
            ->orderBy('nome')
            ->get()
            ->map(function ($template) {
                return [
                    'id' => $template->id,
                    'nome' => $template->nome,
                    'nivel' => $template->nivel,
                    'descricao' => $template->descricao,
                    'instrucoes_uso' => $template->instrucoes_uso,
                    'nivel_badge' => $template->nivel_badge,
                    'created_at' => $template->created_at,
                ];
            });

        return Inertia::render('Templates/Index', [
            'templates' => $templates
        ]);
    }

    public function show($id)
    {
        $template = TemplateArquitetura::findOrFail($id);

        // ✅ Garantir que estrutura_diretorios seja um array válido
        $estrutura = $template->estrutura_diretorios;

        // Debug: Log da estrutura
        \Log::info('Estrutura recebida:', ['estrutura' => $estrutura, 'tipo' => gettype($estrutura)]);

        $estruturaVisual = null;

        if (!empty($estrutura) && is_array($estrutura)) {
            try {
                $estruturaVisual = $this->templateService->formatarEstrutura($estrutura);
            } catch (\Exception $e) {
                \Log::error('Erro ao formatar estrutura:', [
                    'erro' => $e->getMessage(),
                    'estrutura' => $estrutura
                ]);
                $estruturaVisual = [];
            }
        }

        return Inertia::render('Templates/Show', [
            'template' => [
                'id' => $template->id,
                'nome' => $template->nome,
                'nivel' => $template->nivel,
                'descricao' => $template->descricao,
                'instrucoes_uso' => $template->instrucoes_uso,
                'nivel_badge' => $template->nivel_badge,
                'dependencias' => $template->dependencias,
                'arquivos_base' => $template->arquivos_base,
            ],
            'estruturaVisual' => $estruturaVisual ?? []
        ]);
    }

    public function download($id)
    {
        try {
            $template = TemplateArquitetura::findOrFail($id);
            return $this->templateService->gerarZipTemplate($template);
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar ZIP:', ['erro' => $e->getMessage()]);
            return back()->with('error', 'Erro ao gerar template: ' . $e->getMessage());
        }
    }

    public function preview($id)
    {
        $template = TemplateArquitetura::findOrFail($id);

        return response()->json([
            'estrutura' => $this->templateService->formatarEstrutura($template->estrutura_diretorios),
            'arquivos' => $template->arquivos_base
        ]);
    }

    public function templateBase()
    {
        return Inertia::render('Templates/Base/Index');
    }

    public function templatePadrao()
    {
        return Inertia::render('Templates/Padrao/Index');
    }

    public function templateAvancado()
    {
        return Inertia::render('Templates/Avancado/Index');
    }


    public function downloadTemplateBase()
    {
        $template = TemplateArquitetura::where('nivel', 'base')->first();

        if (!$template) {
            return back()->with('error', 'Template Base não encontrado.');
        }

        return $this->templateService->gerarZipTemplate($template);
    }

    public function downloadTemplatePadrao()
    {
        $template = TemplateArquitetura::where('nivel', 'padrao')->first();

        if (!$template) {
            return back()->with('error', 'Template Padrão não encontrado.');
        }

        return $this->templateService->gerarZipTemplate($template);
    }

    public function downloadTemplateAvancado()
    {
        $template = TemplateArquitetura::where('nivel', 'avancado')->first();

        if (!$template) {
            return back()->with('error', 'Template Avançado não encontrado.');
        }

        return $this->templateService->gerarZipTemplate($template);
    }
}
