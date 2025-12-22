<?php

// app/Services/TemplateService.php
namespace App\Services;

use App\Models\TemplateArquitetura;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function gerarZipTemplate(TemplateArquitetura $template): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $nomeSanitizado = Str::slug($template->nome, '_');
        $nivelSanitizado = Str::slug($template->nivel, '_');

        // Normalizar nome do arquivo para evitar duplicações como:
        // template_template_base_base.zip
        // Estratégia:
        // - Se o nome já começa com "template_", não acrescentamos outro prefixo
        // - Se o nome já termina com o nível (ex: "_base"), não acrescentamos o nível novamente
        if (str_starts_with($nomeSanitizado, 'template_')) {
            $baseName = $nomeSanitizado;
        } else {
            $baseName = "template_{$nomeSanitizado}";
        }

        if ($nivelSanitizado !== '' && !str_ends_with($baseName, "_{$nivelSanitizado}")) {
            $zipFileName = "{$baseName}_{$nivelSanitizado}.zip";
        } else {
            $zipFileName = "{$baseName}.zip";
        }
        $zipPath = storage_path("app/temp/{$zipFileName}");

        // Garantir que o diretório existe
        $tempDir = dirname($zipPath);
        if (!file_exists($tempDir)) {
            if (!mkdir($tempDir, 0755, true)) {
                throw new \RuntimeException("Não foi possível criar o diretório: {$tempDir}");
            }
        }

        // Remover arquivo existente se houver
        if (file_exists($zipPath)) {
            @unlink($zipPath);
        }

        $zip = new ZipArchive();
        $result = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        if ($result !== true) {
            $errorMessages = [
                ZipArchive::ER_OK => 'Nenhum erro',
                ZipArchive::ER_MULTIDISK => 'Multi-disk zip archives not supported',
                ZipArchive::ER_RENAME => 'Renaming temporary file failed',
                ZipArchive::ER_CLOSE => 'Closing zip archive failed',
                ZipArchive::ER_SEEK => 'Seek error',
                ZipArchive::ER_READ => 'Read error',
                ZipArchive::ER_WRITE => 'Write error',
                ZipArchive::ER_CRC => 'CRC error',
                ZipArchive::ER_ZIPCLOSED => 'Containing zip archive was closed',
                ZipArchive::ER_NOENT => 'No such file',
                ZipArchive::ER_EXISTS => 'File already exists',
                ZipArchive::ER_OPEN => 'Can\'t open file',
                ZipArchive::ER_TMPOPEN => 'Failure to create temporary file',
                ZipArchive::ER_ZLIB => 'Zlib error',
                ZipArchive::ER_MEMORY => 'Memory allocation failure',
                ZipArchive::ER_CHANGED => 'Entry has been changed',
                ZipArchive::ER_COMPNOTSUPP => 'Compression method not supported',
                ZipArchive::ER_EOF => 'Premature EOF',
                ZipArchive::ER_INVAL => 'Invalid argument',
                ZipArchive::ER_NOZIP => 'Not a zip archive',
                ZipArchive::ER_INTERNAL => 'Internal error',
                ZipArchive::ER_INCONS => 'Zip archive inconsistent',
                ZipArchive::ER_REMOVE => 'Can\'t remove file',
                ZipArchive::ER_DELETED => 'Entry has been deleted',
            ];

            $errorMsg = $errorMessages[$result] ?? "Erro desconhecido (código: {$result})";
            \Log::error('Erro ao abrir ZIP', [
                'caminho' => $zipPath,
                'erro' => $errorMsg,
                'codigo' => $result
            ]);

            throw new \RuntimeException("Não foi possível criar o arquivo compactado: {$errorMsg}");
        }

        // Estrutura e arquivos vindos do modelo (já convertidos em array pelos casts/accessors)
        $estrutura = $template->estrutura_diretorios ?? [];
        $arquivos = $template->arquivos_base ?? [];

        // Normalizar formatos antigos (seeders) e novos em uma estrutura única
        $estruturaNormalizada = $this->normalizarEstruturaDiretorios($estrutura);
        $raiz = $this->detectarPrefixoRaiz($estruturaNormalizada);
        $arquivosNormalizados = $this->normalizarArquivosBase($arquivos, $raiz, $template);

        // Adicionar estrutura e arquivos
        $this->adicionarEstruturaDiretorios($zip, $estruturaNormalizada);
        $this->adicionarArquivosBase($zip, $arquivosNormalizados);

        // ✅ Adicionar logo e favicon se existirem no template
        $this->adicionarAssetsBinarios($zip, $arquivosNormalizados);

        // Log para debug
        \Log::info('Adicionando ao ZIP', [
            'estrutura_count' => count($estrutura ?? []),
            'arquivos_count' => count($arquivos ?? []),
            'arquivos_zip_antes' => $zip->numFiles
        ]);

        // Adicionar um README mínimo se não houver arquivos
        if ($zip->numFiles === 0) {
            $readmeContent = "# {$template->nome}\n\n{$template->descricao}\n\n## Nível: " . ucfirst($template->nivel) . "\n\nEste template foi gerado automaticamente pela plataforma IPPLS.";
            if ($zip->addFromString('README.md', $readmeContent) === false) {
                \Log::error('Falha ao adicionar README ao ZIP');
            }
            \Log::info('README adicionado ao ZIP vazio', ['arquivos_zip' => $zip->numFiles]);
        }

        // Salvar número de arquivos antes de fechar
        $numFiles = $zip->numFiles;

        // Verificar se há pelo menos um arquivo antes de fechar
        if ($numFiles === 0) {
            $zip->close();
            throw new \RuntimeException('Nenhum arquivo foi adicionado ao ZIP. Verifique a estrutura e arquivos do template.');
        }

        // Fechar o ZIP
        if (!$zip->close()) {
            \Log::error('Erro ao fechar ZIP', ['caminho' => $zipPath, 'arquivos' => $numFiles]);
            throw new \RuntimeException('Não foi possível finalizar o arquivo compactado.');
        }

        \Log::info('ZIP fechado com sucesso', ['arquivos' => $numFiles]);

        // Verificar se o arquivo foi criado
        if (!file_exists($zipPath)) {
            \Log::error('Arquivo ZIP não encontrado após criação', [
                'caminho' => $zipPath,
                'diretorio_existe' => file_exists($tempDir),
                'diretorio_gravavel' => is_writable($tempDir)
            ]);
            throw new \RuntimeException("Não foi possível localizar o arquivo gerado em: {$zipPath}");
        }

        // Verificar se o arquivo tem conteúdo
        if (filesize($zipPath) === 0) {
            @unlink($zipPath);
            throw new \RuntimeException('O arquivo ZIP gerado está vazio.');
        }

        \Log::info('ZIP criado com sucesso', [
            'arquivo' => $zipFileName,
            'tamanho' => filesize($zipPath)
        ]);

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend();
    }

    private function adicionarEstruturaDiretorios(ZipArchive $zip, array $estrutura, string $basePath = '')
    {
        foreach ($estrutura as $item) {
            if (!isset($item['nome']) || !isset($item['tipo'])) {
                \Log::warning('Item de estrutura inválido ignorado', ['item' => $item]);
                continue;
            }

            // Normalizar o caminho
            $nome = trim($item['nome'], '/');
            $caminho = $basePath ? rtrim($basePath, '/') . '/' . $nome : $nome;

            if ($item['tipo'] === 'pasta' || $item['tipo'] === 'folder') {
                // Garantir que o caminho termine com /
                $caminhoDir = rtrim($caminho, '/') . '/';

                if ($zip->addEmptyDir($caminhoDir) === false) {
                    \Log::warning('Falha ao adicionar diretório ao ZIP', ['caminho' => $caminhoDir]);
                }

                if (isset($item['filhos']) && is_array($item['filhos']) && !empty($item['filhos'])) {
                    $this->adicionarEstruturaDiretorios($zip, $item['filhos'], $caminhoDir);
                }
            }
        }
    }

    private function adicionarArquivosBase(ZipArchive $zip, array $arquivos)
    {
        foreach ($arquivos as $arquivo) {
            if (!isset($arquivo['caminho'])) {
                \Log::warning('Arquivo sem caminho ignorado', ['arquivo' => $arquivo]);
                continue;
            }

            $caminho = ltrim($arquivo['caminho'], '/');

            // ✅ Verificar se é arquivo binário (logo ou favicon, fontawesome: all.min.css, fa-brands-400.woff2, fa-regular-400.woff2, fa-solid-900.woff2)
            if (str_contains($caminho, 'ippls-logo-removebg-preview.png') ||
                str_contains($caminho, 'favicon.ico' ||
                str_contains($caminho, 'all.min.css') ||
                str_contains($caminho, 'fa-brands-400.woff2') ||
                str_contains($caminho, 'fa-regular-400.woff2') ||
                str_contains($caminho, 'fa-solid-900.woff2'))) {
                // Pular aqui - será adicionado por adicionarAssetsBinarios
                continue;
            }

            $conteudo = $arquivo['template'] ?? $arquivo['conteudo'] ?? '';

            if ($zip->addFromString($caminho, $conteudo) === false) {
                \Log::warning('Falha ao adicionar arquivo ao ZIP', [
                    'caminho' => $caminho,
                    'tamanho_conteudo' => strlen($conteudo)
                ]);
            }
        }
    }

    /**
     * Adiciona assets binários (logo e favicon) ao ZIP
     */
    private function adicionarAssetsBinarios(ZipArchive $zip, array $arquivos)
    {
        foreach ($arquivos as $arquivo) {
            if (!isset($arquivo['caminho'])) {
                continue;
            }

            $caminho = ltrim($arquivo['caminho'], '/');

            // ✅ Adicionar logo IPPLS
            if (str_contains($caminho, 'ippls-logo-removebg-preview.png')) {
                $logoPath = public_path('img/logo/ippls-logo-removebg-preview.png');
                if (file_exists($logoPath)) {
                    if ($zip->addFile($logoPath, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // ✅ Adicionar favicon
            if (str_contains($caminho, 'favicon.ico')) {
                $faviconPath = public_path('favicon.ico');
                if (file_exists($faviconPath)) {
                    if ($zip->addFile($faviconPath, $caminho) === false) {
                        \Log::warning('Falha ao adicionar favicon ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            /*
                ✅ Adicionar fontawesome css file
            */
            // all.min.css
            if (str_contains($caminho, 'all.min.css')) {
                $faallmincssPath = public_path('fontawesome-free-7.1.0-web/css/all.min.css');
                if (file_exists($faallmincssPath)) {
                    if ($zip->addFile($faallmincssPath, $caminho) === false) {
                        \Log::warning('Falha ao adicionar fontawesome - fa-brands-400.woff2 ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // ✅ Adicionar fontawesome web fonts
            // fa-brands-400.woff2
            if (str_contains($caminho, 'fa-brands-400.woff2')) {
                $fabrands400Path = public_path('fontawesome-free-7.1.0-web/webfonts/fa-brands-400.woff2');
                if (file_exists($fabrands400Path)) {
                    if ($zip->addFile($fabrands400Path, $caminho) === false) {
                        \Log::warning('Falha ao adicionar fontawesome - fa-brands-400.woff2 ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }
            // fa-regular-400.woff2
            if (str_contains($caminho, 'fa-regular-400.woff2')) {
                $faregular400Path = public_path('fontawesome-free-7.1.0-web/webfonts/fa-regular-400.woff2');
                if (file_exists($faregular400Path)) {
                    if ($zip->addFile($faregular400Path, $caminho) === false) {
                        \Log::warning('Falha ao adicionar fontawesome - fa-regular-400.woff2 ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }
            // fa-solid-900.woff2
            if (str_contains($caminho, 'fa-solid-900.woff2')) {
                $fasolid900Path = public_path('fontawesome-free-7.1.0-web/webfonts/fa-solid-900.woff2');
                if (file_exists($fasolid900Path)) {
                    if ($zip->addFile($fasolid900Path, $caminho) === false) {
                        \Log::warning('Falha ao adicionar fontawesome - fa-solid-900.woff2 ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            /*
                ✅ Adicionar svg dos locos na skills
            */
            // Skills do Apache
            if (str_contains($caminho, 'apache.svg')) {
                $apacheSVG = public_path('img/skills/apache.svg');
                if (file_exists($apacheSVG)) {
                    if ($zip->addFile($apacheSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Apache ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Skills do Composer
            if (str_contains($caminho, 'composer.svg')) {
                $composerSVG = public_path('img/skills/composer.svg');
                if (file_exists($composerSVG)) {
                    if ($zip->addFile($composerSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Composer ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Skills do Css3
            if (str_contains($caminho, 'css3.svg')) {
                $css3SVG = public_path('img/skills/css3.svg');
                if (file_exists($css3SVG)) {
                    if ($zip->addFile($css3SVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Css3 ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Skills do Git
            if (str_contains($caminho, 'git.svg')) {
                $gitSVG = public_path('img/skills/git.svg');
                if (file_exists($gitSVG)) {
                    if ($zip->addFile($gitSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Git ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Skills do Html5
            if (str_contains($caminho, 'html5.svg')) {
                $html5SVG = public_path('img/skills/html5.svg');
                if (file_exists($html5SVG)) {
                    if ($zip->addFile($html5SVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Html5 ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Skills do Javascript
            if (str_contains($caminho, 'javascript.svg')) {
                $javascriptSVG = public_path('img/skills/javascript.svg');
                if (file_exists($javascriptSVG)) {
                    if ($zip->addFile($javascriptSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do JavascriptSVG ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Skills do Mysql
            if (str_contains($caminho, 'mysql.svg')) {
                $mysqlSVG = public_path('img/skills/mysql.svg');
                if (file_exists($mysqlSVG)) {
                    if ($zip->addFile($mysqlSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do MySql ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Skills do Php
            if (str_contains($caminho, 'php.svg')) {
                $phpSVG = public_path('img/skills/php.svg');
                if (file_exists($phpSVG)) {
                    if ($zip->addFile($phpSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Php ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Skills do Xampp
            if (str_contains($caminho, 'xampp.svg')) {
                $xamppSVG = public_path('img/skills/xampp.svg');
                if (file_exists($xamppSVG)) {
                    if ($zip->addFile($xamppSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Xampp ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Logo do MySql
            if (str_contains($caminho, 'mysql.svg')) {
                $mySqlSVG = public_path('img/logo/mysql.svg');
                if (file_exists($mySqlSVG)) {
                    if ($zip->addFile($mySqlSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do MySql ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Logo do Php
            if (str_contains($caminho, 'php.svg')) {
                $phpMITSVG = public_path('img/logo/php.svg');
                if (file_exists($phpMITSVG)) {
                    if ($zip->addFile($phpMITSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Php ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Logo do Composer
            if (str_contains($caminho, 'composer.svg')) {
                $ComposerMITSVG = public_path('img/logo/composer.svg');
                if (file_exists($ComposerMITSVG)) {
                    if ($zip->addFile($ComposerMITSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo do Composer ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }

            // Logo da Licensa do MIT
            if (str_contains($caminho, 'license.svg')) {
                $licenseMITSVG = public_path('img/logo/license.svg');
                if (file_exists($licenseMITSVG)) {
                    if ($zip->addFile($licenseMITSVG, $caminho) === false) {
                        \Log::warning('Falha ao adicionar logo da License do MIT ao ZIP', ['caminho' => $caminho]);
                    }
                }
            }


        }
    }

    /**
     * Normaliza a estrutura de diretórios vinda do banco (formato antigo ou novo)
     * para o formato esperado por adicionarEstruturaDiretorios:
     * [
     *   ['nome' => 'app', 'tipo' => 'pasta', 'filhos' => [...]],
     *   ['nome' => 'index.php', 'tipo' => 'arquivo']
     * ]
     */
    private function normalizarEstruturaDiretorios(array $estruturaBruta, int $nivel = 0): array
    {
        $resultado = [];

        foreach ($estruturaBruta as $chave => $valor) {
            // Formato "novo": já vem como itens com nome/tipo
            if (is_array($valor) && isset($valor['nome']) && isset($valor['tipo'])) {
                $item = $valor;

                // Garantir que o nível exista
                if (!isset($item['nivel'])) {
                    $item['nivel'] = $nivel;
                }

                // Normalizar filhos, se existirem
                if (isset($item['filhos']) && is_array($item['filhos'])) {
                    $item['filhos'] = $this->normalizarEstruturaDiretorios($item['filhos'], $nivel + 1);
                }

                $resultado[] = $item;
                continue;
            }

            // Formato "antigo" do seeder: chave pode ser o nome da pasta
            if (is_string($chave)) {
                $nome = trim($chave, '/');
                $item = [
                    'nome' => $nome,
                    'tipo' => 'pasta',
                    'nivel' => $nivel,
                ];

                if (is_array($valor)) {
                    $item['filhos'] = $this->normalizarEstruturaDiretorios($valor, $nivel + 1);
                }

                $resultado[] = $item;
                continue;
            }

            // Quando a chave é numérica e o valor é uma string:
            // ex: ['index.php', 'models/', 'views/']
            if (is_int($chave) && is_string($valor)) {
                $nome = trim($valor, '/');

                // Se termina com "/" e não tem ponto, consideramos pasta
                $isDiretorio = str_ends_with($valor, '/') && !str_contains($valor, '.');
                $tipo = $isDiretorio ? 'pasta' : 'arquivo';

                $item = [
                    'nome' => $nome,
                    'tipo' => $tipo,
                    'nivel' => $nivel,
                ];

                $resultado[] = $item;
            }
        }

        return $resultado;
    }

    /**
     * Normaliza a lista de arquivos base vinda do banco.
     * Aceita tanto:
     *  - formato novo: [['caminho' => 'index.php', 'template' => '...'], ...]
     *  - formato antigo: ['index.php', 'config/database.php', ...]
     */
    private function normalizarArquivosBase(array $arquivosBrutos, string $prefixo = '', TemplateArquitetura $templateMeta = null): array
    {
        $resultado = [];
        $prefixoNormalizado = $prefixo !== '' ? rtrim($prefixo, '/') . '/' : '';

        foreach ($arquivosBrutos as $arquivo) {
            $caminho = null;
            $conteudo = '';
            $conteudoTemplate = null;

            if (is_array($arquivo) && isset($arquivo['caminho'])) {
                $caminho = $arquivo['caminho'];
                $conteudo = $arquivo['conteudo'] ?? '';
                $conteudoTemplate = $arquivo['template'] ?? null;
            } elseif (is_string($arquivo)) {
                $caminho = $arquivo;
            }

            if ($caminho === null) {
                continue;
            }

            $caminhoNormalizado = ltrim($caminho, '/');

            if ($prefixoNormalizado !== '' && !str_starts_with($caminhoNormalizado, rtrim($prefixoNormalizado, '/'))) {
                $caminhoNormalizado = $prefixoNormalizado . $caminhoNormalizado;
            }

            $item = ['caminho' => $caminhoNormalizado];

            if ($conteudoTemplate !== null) {
                $item['template'] = $conteudoTemplate;
            } else {
                $conteudoPadrao = $this->gerarConteudoPadraoArquivo($caminhoNormalizado, $templateMeta);
                $item['conteudo'] = $conteudoPadrao !== '' ? $conteudoPadrao : $conteudo;
            }

            $resultado[] = $item;
        }

        return $resultado;
    }

    private function gerarConteudoPadraoArquivo(string $caminho, ?TemplateArquitetura $templateMeta): string
    {
        if (!$templateMeta) {
            return '';
        }

        $arquivo = strtolower(basename($caminho));

        if ($arquivo === 'readme.md') {
            $nome = $templateMeta->nome ?? 'Template IPPLS';
            $descricao = $templateMeta->descricao ?? 'Estrutura modelo da plataforma IPPLS.';
            $nivel = ucfirst($templateMeta->nivel ?? 'base');

            return "# {$nome}\n\n{$descricao}\n\n## Nível de Arquitetura\n{$nivel}\n\n## Como começar\n1. Extraia os arquivos do template.\n2. Configure o ambiente conforme as instruções do template.\n3. Use esta estrutura como base para o desenvolvimento do seu projeto.\n";
        }

        return '';
    }

    private function detectarPrefixoRaiz(array $estrutura): string
    {
        $raizes = array_filter($estrutura, function ($item) {
            return ($item['tipo'] ?? '') === 'pasta' && (($item['nivel'] ?? 0) === 0);
        });

        if (count($raizes) === 1) {
            $item = reset($raizes);
            return rtrim($item['nome'], '/') . '/';
        }

        return '';
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
