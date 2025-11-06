<?php

// app/Services/TemplateService.php
namespace App\Services;

use App\Models\TemplateArquitetura;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class TemplateService
{
    public function formatarEstrutura(array $estrutura, int $nivel = 0): array
    {
        $formatada = [];

        foreach ($estrutura as $item) {
            // ✅ VALIDAÇÃO: Verificar se o item tem as chaves necessárias
            if (!is_array($item)) {
                continue; // Pular itens inválidos
            }

            // ✅ Garantir que 'nome' e 'tipo' existam
            if (!isset($item['nome']) || !isset($item['tipo'])) {
                \Log::warning('Item de estrutura sem nome ou tipo', ['item' => $item]);
                continue;
            }

            $itemFormatado = [
                'nome' => $item['nome'],
                'tipo' => $item['tipo'],
                'nivel' => $nivel,
                'icone' => $this->obterIcone($item)
            ];

            // ✅ Processar filhos apenas se for pasta e tiver filhos
            if ($item['tipo'] === 'pasta' && isset($item['filhos']) && is_array($item['filhos'])) {
                $itemFormatado['filhos'] = $this->formatarEstrutura($item['filhos'], $nivel + 1);
            }

            $formatada[] = $itemFormatado;
        }

        return $formatada;
    }

    private function obterIcone(array $item): string
    {
        if ($item['tipo'] === 'pasta') {
            return 'folder';
        }

        $extensao = pathinfo($item['nome'] ?? '', PATHINFO_EXTENSION);

        return match($extensao) {
            'php' => 'code',
            'js' => 'javascript',
            'html' => 'html',
            'css' => 'css',
            'json' => 'json',
            'md' => 'markdown',
            'txt' => 'text',
            'sql' => 'database',
            default => 'file'
        };
    }

    public function gerarZipTemplate(TemplateArquitetura $template): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $zipFileName = "template_{$template->nome}_{$template->nivel}.zip";
        $zipPath = storage_path("app/temp/{$zipFileName}");

        // Garantir que o diretório existe
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $estrutura = $template->estrutura_diretorios;
            if (is_string($estrutura)) {
                $estrutura = json_decode($estrutura, true) ?? [];
            }

            $arquivos = $template->arquivos_base;
            if (is_string($arquivos)) {
                $arquivos = json_decode($arquivos, true) ?? [];
            }

            $this->adicionarEstruturaDiretorios($zip, $estrutura);
            $this->adicionarArquivosBase($zip, $arquivos);
            $zip->close();
        }

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend();
    }

    private function adicionarEstruturaDiretorios(ZipArchive $zip, array $estrutura, string $basePath = '')
    {
        foreach ($estrutura as $item) {
            if (!isset($item['nome']) || !isset($item['tipo'])) {
                continue;
            }

            $caminho = $basePath . $item['nome'];

            if ($item['tipo'] === 'pasta') {
                $zip->addEmptyDir($caminho);
                if (isset($item['filhos']) && is_array($item['filhos'])) {
                    $this->adicionarEstruturaDiretorios($zip, $item['filhos'], $caminho . '/');
                }
            }
        }
    }

    private function adicionarArquivosBase(ZipArchive $zip, array $arquivos)
    {
        foreach ($arquivos as $arquivo) {
            if (!isset($arquivo['caminho'])) {
                continue;
            }

            $conteudo = $arquivo['template'] ?? '';
            $zip->addFromString($arquivo['caminho'], $conteudo);
        }
    }

    public function criarTemplateBase(): TemplateArquitetura
    {
        return TemplateArquitetura::create([
            'nome' => 'Template Base MVC',
            'nivel' => 'base',
            'descricao' => 'Estrutura básica para projetos MVC em PHP',
            'estrutura_diretorios' => $this->obterEstruturaBase(),
            'arquivos_base' => $this->obterArquivosBase(),
            'dependencias' => [],
            'instrucoes_uso' => 'Estrutura básica para iniciantes em desenvolvimento web com PHP.'
        ]);
    }

    private function obterEstruturaBase(): array
    {
        return [
            ['nome' => 'app', 'tipo' => 'pasta', 'filhos' => [
                ['nome' => 'controllers', 'tipo' => 'pasta'],
                ['nome' => 'models', 'tipo' => 'pasta'],
                ['nome' => 'views', 'tipo' => 'pasta']
            ]],
            ['nome' => 'public', 'tipo' => 'pasta', 'filhos' => [
                ['nome' => 'css', 'tipo' => 'pasta'],
                ['nome' => 'js', 'tipo' => 'pasta'],
                ['nome' => 'images', 'tipo' => 'pasta']
            ]],
            ['nome' => 'config', 'tipo' => 'pasta'],
            ['nome' => 'storage', 'tipo' => 'pasta']
        ];
    }

    private function obterArquivosBase(): array
    {
        return [
            [
                'caminho' => 'index.php',
                'template' => "<?php\n// {{PROJETO_TITULO}}\n// Criado por: {{ESTUDANTE_NOME}}\n// Data: {{DATA_CRIACAO}}\n\nrequire_once 'config/config.php';\n\n// Roteamento básico\n\$controller = \$_GET['controller'] ?? 'home';\n\$action = \$_GET['action'] ?? 'index';\n\necho 'Projeto iniciado com sucesso!';\n"
            ],
            [
                'caminho' => 'config/config.php',
                'template' => "<?php\n// Configurações do projeto\n\ndefine('BASE_URL', 'http://localhost/');\ndefine('DB_HOST', 'localhost');\ndefine('DB_NAME', 'database');\ndefine('DB_USER', 'root');\ndefine('DB_PASS', '');\n"
            ],
            [
                'caminho' => 'README.md',
                'template' => "# {{PROJETO_TITULO}}\n\n## Descrição\n{{PROJETO_DESCRICAO}}\n\n## Autor\n{{ESTUDANTE_NOME}} ({{ESTUDANTE_EMAIL}})\n\n## Arquitetura\n{{NIVEL_ARQUITETURA}}\n\n## Instalação\n1. Clone o repositório\n2. Configure o banco de dados\n3. Abra no navegador\n\n## Estrutura\n- `app/` - Código da aplicação\n- `public/` - Arquivos públicos\n- `config/` - Configurações\n"
            ]
        ];
    }
}
