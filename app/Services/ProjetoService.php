<?php

namespace App\Services;

use App\Models\Projeto;
use App\Models\InstanciaProjeto;
use App\Models\TemplateArquitetura;
use App\Models\User;
use App\Models\Notificacao;
use ZipArchive;
use Exception;
use Illuminate\Support\Facades\Storage;

class ProjetoService
{
    /**
     * Inicia um novo projeto para um usuário
     *
     * @param Projeto|int $projeto Instância ou ID do projeto
     * @param User $usuario Usuário que está iniciando o projeto
     * @param string $nivelArquitetura Nível de arquitetura (basico, intermediario, avancado)
     * @return InstanciaProjeto
     * @throws Exception
     */
    public function iniciarProjeto($projeto, User $usuario, string $nivelArquitetura): InstanciaProjeto
    {
        if (is_numeric($projeto)) {
            $projeto = Projeto::findOrFail($projeto);
        }

        if (!($projeto instanceof Projeto)) {
            throw new Exception("Projeto inválido - tipo esperado: Projeto ou ID numérico");
        }

        $instancia = InstanciaProjeto::create([
            'projeto_id' => $projeto->id,
            'usuario_id' => $usuario->id,
            'nivel_arquitetura' => $nivelArquitetura,
            'status' => 'iniciado',
            'data_inicio' => now()
        ]);

        $this->enviarNotificacoesInicio($projeto, $usuario, $instancia);

        return $instancia;
    }

    /**
     * Envia notificações quando um projeto é iniciado
     */
    private function enviarNotificacoesInicio(Projeto $projeto, User $usuario, InstanciaProjeto $instancia): void
    {
        // Notificação para o estudante
        Notificacao::create([
            'usuario_id' => $usuario->id,
            'titulo' => 'Projeto Iniciado',
            'mensagem' => "Seu projeto '{$projeto->titulo}' foi iniciado com sucesso!",
            'tipo' => 'sucesso',
            'acao_url' => route('meus-projetos.show', $instancia->id)
        ]);

        // Notificação para coordenadores
        $coordenadores = User::where('tipo', 'coordenador')->get();
        foreach ($coordenadores as $coordenador) {
            Notificacao::create([
                'usuario_id' => $coordenador->id,
                'titulo' => 'Novo Projeto Iniciado',
                'mensagem' => "O estudante {$usuario->nome} iniciou o projeto '{$projeto->titulo}'",
                'tipo' => 'info'
            ]);
        }
    }

    /**
     * Obtém o template baseado no nível de arquitetura
     *
     * @param string $nivel Nível de arquitetura
     * @return array|TemplateArquitetura|null
     */
    public function obterTemplate(string $nivel)
    {
        $templateDb = $this->buscarTemplateAtivoPorNivel($nivel);

        if ($templateDb) {
            return $this->formatarTemplateDoBanco($templateDb);
        }

        return $this->getTemplatePorNivel($nivel);
    }

    private function buscarTemplateAtivoPorNivel(string $nivel): ?TemplateArquitetura
    {
        return TemplateArquitetura::where('nivel', $nivel)
            ->where('ativo', true)
            ->first();
    }

    private function formatarTemplateDoBanco(TemplateArquitetura $template): array
    {
        $estruturaNormalizada = $this->normalizarEstruturaDiretoriosBanco($template->estrutura_diretorios ?? []);
        $arquivosNormalizados = $this->normalizarArquivosBaseBanco($template->arquivos_base ?? []);

        return [
            'nome' => $template->nome,
            'descricao' => $template->descricao,
            'estrutura_diretorios' => $estruturaNormalizada,
            'arquivos_base' => $arquivosNormalizados
        ];
    }

    /*private function getTemplatePorNivel(string $nivel): array
    {
        return match ($nivel) {
            'intermediario' => $this->getTemplateIntermediario(),
            'avancado' => $this->getTemplateAvancado(),
            default => $this->getTemplateBasico(),
        };
    }*/

    /**
     * Obtém template embutido baseado no nível
     */
    private function getTemplatePorNivel(string $nivel): array
    {
        return match ($nivel) {
            'padrao' => $this->getTemplatePadrao(),
            'avancado' => $this->getTemplateAvancado(),
            default => $this->getTemplateBase(),
        };
    }

    /*public function gerarZipTemplate(InstanciaProjeto $instancia)
    {
        $templateDb = $this->buscarTemplateAtivoPorNivel($instancia->nivel_arquitetura);

        if ($templateDb) {
            return $this->gerarZipFromDatabaseTemplate($templateDb, $instancia);
        }

        $template = $this->getTemplatePorNivel($instancia->nivel_arquitetura);

        return $this->gerarZipFromEmbeddedTemplate($instancia, $template);
    }*/



    /**
     * ✅ CORRIGIDO: Gera ZIP para projetos instanciados (SEMPRE usa templates embutidos)
     */
    public function gerarZipTemplate(InstanciaProjeto $instancia)
    {
        // ✅ SEMPRE usar templates embutidos para projetos instanciados
        // Estes templates têm variáveis personalizadas do estudante
        $template = $this->getTemplatePorNivel($instancia->nivel_arquitetura);

        return $this->gerarZipFromEmbeddedTemplate($instancia, $template);
    }




    /**
     * Gera ZIP a partir de template do banco de dados
     */
    private function gerarZipFromDatabaseTemplate(TemplateArquitetura $template, InstanciaProjeto $instancia)
    {
        $zipFileName = "PROJETO__{$instancia->projeto->titulo}_{$instancia->nivel_arquitetura}__IPPLS.zip";
        $zipPath = storage_path("app/temp/{$zipFileName}");

        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $estruturaNormalizada = $this->normalizarEstruturaDiretoriosBanco($template->estrutura_diretorios ?? []);
        $prefixoRaiz = $this->detectarPrefixoRaizEstrutura($estruturaNormalizada);
        $arquivosNormalizados = $this->normalizarArquivosBaseBanco($template->arquivos_base ?? [], $prefixoRaiz);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            if (!empty($estruturaNormalizada)) {
                $this->adicionarEstruturaDiretorios($zip, $estruturaNormalizada);
            }

            if (!empty($arquivosNormalizados)) {
                $this->adicionarArquivosBase($zip, $arquivosNormalizados, $instancia);
            }

            $zip->close();
        }

        if ($zip->numFiles === 0) {
            $zip->open($zipPath);
            $zip->addFromString('README.md', "Template gerado automaticamente para {$instancia->projeto->titulo}");
            $zip->close();
        }

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend();
    }

    /**
     * Gera ZIP a partir de template embutido
     */
    /*private function gerarZipFromEmbeddedTemplate(InstanciaProjeto $instancia, array $template)
    {
        $zipFileName = "template_{$instancia->projeto->titulo}_{$instancia->id}.zip";
        $tempFile = tempnam(sys_get_temp_dir(), 'template_');

        $zip = new ZipArchive();
        if ($zip->open($tempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new Exception('Não foi possível criar o arquivo ZIP');
        }

        // Adiciona estrutura de diretórios
        if (isset($template['estrutura_diretorios'])) {
            $this->adicionarEstruturaDiretorios($zip, $template['estrutura_diretorios']);
        }

        // Adiciona arquivos base
        if (isset($template['arquivos_base'])) {
            foreach ($template['arquivos_base'] as $arquivo) {
                $zip->addFromString($arquivo['caminho'], $this->gerarConteudoArquivo($arquivo, $instancia));
            }
        }

        // Adiciona README
        $readme = $this->gerarReadme($instancia, $template);
        $zip->addFromString('README.md', $readme);

        $zip->close();

        return response()->download($tempFile, $zipFileName)->deleteFileAfterSend(true);
    }*/



    /**
     * Gera ZIP a partir de template embutido (com dados personalizados)
     */
    private function gerarZipFromEmbeddedTemplate(InstanciaProjeto $instancia, array $template)
    {
        $nomeProjeto = \Illuminate\Support\Str::slug($instancia->projeto->titulo, '_');
        $nivel = $instancia->nivel_arquitetura;
        $estudante = \Illuminate\Support\Str::slug($instancia->usuario->name, '_');

        $zipFileName = "IPPLS_{$nomeProjeto}_{$nivel}_{$estudante}.zip";
        $zipPath = storage_path("app/temp/{$zipFileName}");

        // Garantir que o diretório existe
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new Exception('Não foi possível criar o arquivo ZIP');
        }

        // Adiciona estrutura de diretórios
        if (isset($template['estrutura_diretorios'])) {
            $this->adicionarEstruturaDiretorios($zip, $template['estrutura_diretorios']);
        }

        // Adiciona arquivos base com dados personalizados
        if (isset($template['arquivos_base'])) {
            foreach ($template['arquivos_base'] as $arquivo) {
                $caminho = $arquivo['caminho'] ?? '';

                // ✅ Verificar se é logo ou favicon (arquivos binários)
                if (str_contains($caminho, 'ippls-logo-removebg-preview.png')) {
                    $logoPath = public_path('img/logo/ippls-logo-removebg-preview.png');
                    if (file_exists($logoPath)) {
                        $zip->addFile($logoPath, $caminho);
                    }
                } elseif (str_contains($caminho, 'favicon.ico')) {
                    $faviconPath = public_path('favicon.ico');
                    if (file_exists($faviconPath)) {
                        $zip->addFile($faviconPath, $caminho);
                    }
                } else {
                    // Arquivo de texto (PHP, HTML, CSS, JS, etc.)
                    $conteudo = $this->gerarConteudoArquivo($arquivo, $instancia);
                    $zip->addFromString($caminho, $conteudo);
                }
            }
        }

        // Adiciona README personalizado
        $readme = $this->gerarReadmePersonalizado($instancia, $template);
        $zip->addFromString('README.md', $readme);

        $zip->close();

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }





    /**
     * Adiciona estrutura de diretórios ao ZIP
     */
    private function adicionarEstruturaDiretorios(ZipArchive $zip, array $estrutura, string $basePath = ''): void
    {
        foreach ($estrutura as $item) {
            $caminho = $basePath . $item['nome'];

            if ($item['tipo'] === 'pasta') {
                $zip->addEmptyDir($caminho);
                if (isset($item['filhos'])) {
                    $this->adicionarEstruturaDiretorios($zip, $item['filhos'], $caminho . '/');
                }
            }
        }
    }

    /**
     * Adiciona arquivos base ao ZIP
     */
    private function adicionarArquivosBase(ZipArchive $zip, array $arquivos, InstanciaProjeto $instancia): void
    {
        foreach ($arquivos as $arquivo) {
            $conteudo = $this->gerarConteudoArquivo($arquivo, $instancia);
            $zip->addFromString($arquivo['caminho'], $conteudo);
        }
    }

    /**
     * Gera conteúdo de arquivo com substituição de variáveis
     */
    /*private function gerarConteudoArquivo(array $arquivo, InstanciaProjeto $instancia): string
    {
        $template = $arquivo['template'] ?? '';

        $variaveis = [
            '{{PROJETO_TITULO}}' => $instancia->projeto->titulo,
            '{{PROJETO_DESCRICAO}}' => $instancia->projeto->descricao,
            '{{ESTUDANTE_NOME}}' => $instancia->usuario->nome,
            '{{ESTUDANTE_EMAIL}}' => $instancia->usuario->email,
            '{{DATA_CRIACAO}}' => now()->format('d/m/Y H:i'),
            '{{NIVEL_ARQUITETURA}}' => strtoupper($instancia->nivel_arquitetura)
        ];

        return str_replace(array_keys($variaveis), array_values($variaveis), $template);
    }*/



    /**
     * Gera conteúdo de arquivo com substituição de variáveis do estudante
     */
    private function gerarConteudoArquivo(array $arquivo, InstanciaProjeto $instancia): string
    {
        $template = $arquivo['template'] ?? '';

        $variaveis = [
            '{{PROJETO_TITULO}}' => $instancia->projeto->titulo,
            '{{PROJETO_DESCRICAO}}' => $instancia->projeto->descricao,
            '{{ESTUDANTE_NOME}}' => $instancia->usuario->name,
            '{{ESTUDANTE_EMAIL}}' => $instancia->usuario->email,
            '{{DATA_CRIACAO}}' => now()->format('d/m/Y H:i'),
            '{{NIVEL_ARQUITETURA}}' => strtoupper($instancia->nivel_arquitetura),
            '{{NUMERO_ESTUDANTE}}' => $instancia->usuario->numero_estudante ?? 'N/A',
            '{{CURSO}}' => $instancia->usuario->curso->nome ?? 'N/A',
            '{{TURMA}}' => $instancia->usuario->turma->nome ?? 'N/A',
        ];

        return str_replace(array_keys($variaveis), array_values($variaveis), $template);
    }






    /**
     * Gera conteúdo do README
     */
    /*private function gerarReadme(InstanciaProjeto $instancia, array $template): string
    {
        return "# {$instancia->projeto->titulo}

## Descrição
{$instancia->projeto->descricao}

## Template: {$template['nome']}
{$template['descricao']}

## Nível de Arquitetura
" . ucfirst($instancia->nivel_arquitetura) . "

## Progresso Atual
{$instancia->percentual_conclusao}% concluído

## Instalação
1. Extraia este arquivo ZIP
2. Navegue até o diretório do projeto
3. Siga as instruções específicas do template

## Repositório
" . ($instancia->repositorio_url ?: 'Ainda não definido') . "

## Observações
" . ($instancia->observacoes ?: 'Nenhuma observação adicional') . "

---
Gerado automaticamente em " . now()->format('d/m/Y H:i:s');
    }*/


    /**
     * Gera conteúdo do README personalizado
     */
    private function gerarReadmePersonalizado(InstanciaProjeto $instancia, array $template): string
    {
        $tecnologias = is_array($instancia->projeto->tecnologias)
            ? implode(', ', $instancia->projeto->tecnologias)
            : $instancia->projeto->tecnologias ?? 'N/A';

        return "# {$instancia->projeto->titulo}

## 📚 Instituição
**Instituto Politécnico Privado Lucrêcio dos Santos (IPPLS)**

## 👨‍🎓 Informações do Estudante
- **Nome:** {$instancia->usuario->name}
- **Email:** {$instancia->usuario->email}
- **Nº Estudante:** " . ($instancia->usuario->numero_estudante ?? 'N/A') . "
- **Curso:** " . ($instancia->usuario->curso->nome ?? 'N/A') . "
- **Turma:** " . ($instancia->usuario->turma->nome ?? 'N/A') . "

## 📝 Descrição do Projeto
{$instancia->projeto->descricao}

## 🏗️ Template: {$template['nome']}
{$template['descricao']}

## 🎯 Nível de Arquitetura
**" . ucfirst($instancia->nivel_arquitetura) . "** - {$instancia->nivel_arquitetura}

## 💻 Tecnologias
{$tecnologias}

## 📊 Progresso Atual
{$instancia->percentual_conclusao}% concluído

## 🔗 Repositório
" . ($instancia->repositorio_url ?: 'Ainda não definido') . "

## 📅 Datas
- **Início:** " . $instancia->data_inicio->format('d/m/Y') . "
- **Gerado em:** " . now()->format('d/m/Y H:i:s') . "

## 📖 Instruções de Instalação
1. Extraia este arquivo ZIP
2. Navegue até o diretório do projeto
3. Configure o ambiente conforme as instruções específicas do template
4. Inicie o desenvolvimento!

## 📌 Observações
" . ($instancia->observacoes ?: 'Nenhuma observação adicional') . "

---
**Gerado automaticamente pela Plataforma IPPLS**
Data: " . now()->format('d/m/Y H:i:s') . "
";
    }





    /**
     * Normaliza a estrutura de diretórios vinda do banco
     */
    private function normalizarEstruturaDiretoriosBanco(array $estruturaBruta, int $nivel = 0): array
    {
        $resultado = [];

        foreach ($estruturaBruta as $chave => $valor) {
            if (is_array($valor) && isset($valor['nome']) && isset($valor['tipo'])) {
                $item = $valor;
                if (!isset($item['nivel'])) {
                    $item['nivel'] = $nivel;
                }
                if (isset($item['filhos']) && is_array($item['filhos'])) {
                    $item['filhos'] = $this->normalizarEstruturaDiretoriosBanco($item['filhos'], $nivel + 1);
                }
                $resultado[] = $item;
                continue;
            }

            if (is_string($chave)) {
                $nome = trim($chave, '/');
                $item = [
                    'nome' => $nome,
                    'tipo' => 'pasta',
                    'nivel' => $nivel,
                ];

                if (is_array($valor)) {
                    $item['filhos'] = $this->normalizarEstruturaDiretoriosBanco($valor, $nivel + 1);
                }

                $resultado[] = $item;
                continue;
            }

            if (is_int($chave) && is_string($valor)) {
                $nome = trim($valor, '/');
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
     * Normaliza os arquivos base vindos do banco
     */
    private function normalizarArquivosBaseBanco(array $arquivosBrutos, string $prefixo = ''): array
    {
        $resultado = [];
        $prefixoNormalizado = $prefixo !== '' ? rtrim($prefixo, '/') . '/' : '';

        foreach ($arquivosBrutos as $arquivo) {
            $caminho = null;
            $conteudo = '';

            if (is_array($arquivo) && isset($arquivo['caminho'])) {
                $caminho = $arquivo['caminho'];
                $conteudo = $arquivo['template'] ?? $arquivo['conteudo'] ?? '';
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

            $resultado[] = [
                'caminho' => $caminhoNormalizado,
                'template' => $conteudo,
            ];
        }

        return $resultado;
    }

    private function detectarPrefixoRaizEstrutura(array $estrutura): string
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

    /*
      Template Básico - Estrutura simples mas bem organizada

    private function getTemplateBasico(): array
    {
        return [
            'nome' => 'Template Básico Profissional',
            'descricao' => 'Estrutura inicial bem organizada para projetos simples, seguindo boas práticas',
            'estrutura_diretorios' => [
                [
                    'nome' => 'public',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'assets', 'tipo' => 'pasta', 'filhos' => [
                            ['nome' => 'css', 'tipo' => 'pasta'],
                            ['nome' => 'js', 'tipo' => 'pasta'],
                            ['nome' => 'images', 'tipo' => 'pasta']
                        ]],
                        ['nome' => 'index.html', 'tipo' => 'arquivo']
                    ]
                ],
                [
                    'nome' => 'docs',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'requirements.md', 'tipo' => 'arquivo']
                    ]
                ],
                ['nome' => 'README.md', 'tipo' => 'arquivo'],
                ['nome' => '.gitignore', 'tipo' => 'arquivo']
            ],
            'arquivos_base' => [
                [
                    'caminho' => 'public/index.html',
                    'template' => $this->getHtmlBasico()
                ],
                [
                    'caminho' => 'public/assets/css/style.css',
                    'template' => $this->getCssBasico()
                ],
                [
                    'caminho' => 'public/assets/js/app.js',
                    'template' => $this->getJsBasico()
                ],
                [
                    'caminho' => 'README.md',
                    'template' => $this->getReadmeBasico()
                ],
                [
                    'caminho' => '.gitignore',
                    'template' => $this->getGitignoreBasico()
                ]
            ]
        ];
    }

    /
     * Template Intermediário - Estrutura modular com pré-processadores

    private function getTemplateIntermediario(): array
    {
        return [
            'nome' => 'Template Intermediário Modular',
            'descricao' => 'Estrutura modular com separação de responsabilidades e build automatizado',
            'estrutura_diretorios' => [
                [
                    'nome' => 'src',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'components', 'tipo' => 'pasta'],
                        ['nome' => 'modules', 'tipo' => 'pasta'],
                        ['nome' => 'styles', 'tipo' => 'pasta'],
                        ['nome' => 'utils', 'tipo' => 'pasta'],
                        ['nome' => 'index.js', 'tipo' => 'arquivo']
                    ]
                ],
                [
                    'nome' => 'public',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'index.html', 'tipo' => 'arquivo'],
                        ['nome' => 'favicon.ico', 'tipo' => 'arquivo']
                    ]
                ],
                [
                    'nome' => 'config',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'build.js', 'tipo' => 'arquivo']
                    ]
                ],
                [
                    'nome' => 'docs',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'architecture.md', 'tipo' => 'arquivo'],
                        ['nome' => 'styleguide.md', 'tipo' => 'arquivo']
                    ]
                ],
                ['nome' => 'package.json', 'tipo' => 'arquivo'],
                ['nome' => 'README.md', 'tipo' => 'arquivo'],
                ['nome' => '.gitignore', 'tipo' => 'arquivo'],
                ['nome' => '.editorconfig', 'tipo' => 'arquivo']
            ],
            'arquivos_base' => [
                [
                    'caminho' => 'public/index.html',
                    'template' => $this->getHtmlIntermediario()
                ],
                [
                    'caminho' => 'src/styles/main.scss',
                    'template' => $this->getScssIntermediario()
                ],
                [
                    'caminho' => 'src/index.js',
                    'template' => $this->getJsIntermediario()
                ],
                [
                    'caminho' => 'package.json',
                    'template' => $this->getPackageJsonIntermediario()
                ],
                [
                    'caminho' => 'README.md',
                    'template' => $this->getReadmeIntermediario()
                ]
            ]
        ];
    }

    /
     * Template Avançado - Arquitetura MVC completa

    private function getTemplateAvancado(): array
    {
        return [
            'nome' => 'Template Avançado MVC',
            'descricao' => 'Arquitetura MVC completa com separação clara de camadas e ferramentas modernas',
            'estrutura_diretorios' => [
                [
                    'nome' => 'app',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'controllers', 'tipo' => 'pasta'],
                        ['nome' => 'models', 'tipo' => 'pasta'],
                        ['nome' => 'views', 'tipo' => 'pasta'],
                        ['nome' => 'services', 'tipo' => 'pasta'],
                        ['nome' => 'config', 'tipo' => 'pasta']
                    ]
                ],
                [
                    'nome' => 'public',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'assets', 'tipo' => 'pasta', 'filhos' => [
                            ['nome' => 'dist', 'tipo' => 'pasta'],
                            ['nome' => 'src', 'tipo' => 'pasta']
                        ]],
                        ['nome' => 'index.php', 'tipo' => 'arquivo']
                    ]
                ],
                [
                    'nome' => 'tests',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'unit', 'tipo' => 'pasta'],
                        ['nome' => 'integration', 'tipo' => 'pasta'],
                        ['nome' => 'e2e', 'tipo' => 'pasta']
                    ]
                ],
                [
                    'nome' => 'config',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'routes.php', 'tipo' => 'arquivo'],
                        ['nome' => 'database.php', 'tipo' => 'arquivo']
                    ]
                ],
                [
                    'nome' => 'docs',
                    'tipo' => 'pasta',
                    'filhos' => [
                        ['nome' => 'api.md', 'tipo' => 'arquivo'],
                        ['nome' => 'db_schema.md', 'tipo' => 'arquivo']
                    ]
                ],
                ['nome' => 'composer.json', 'tipo' => 'arquivo'],
                ['nome' => 'README.md', 'tipo' => 'arquivo'],
                ['nome' => '.env.example', 'tipo' => 'arquivo'],
                ['nome' => '.htaccess', 'tipo' => 'arquivo']
            ],
            'arquivos_base' => [
                [
                    'caminho' => 'public/index.php',
                    'template' => $this->getPhpAvancado()
                ],
                [
                    'caminho' => 'app/config/core.php',
                    'template' => $this->getCoreConfig()
                ],
                [
                    'caminho' => 'app/controllers/HomeController.php',
                    'template' => $this->getControllerExample()
                ],
                [
                    'caminho' => 'app/models/User.php',
                    'template' => $this->getModelExample()
                ],
                [
                    'caminho' => 'composer.json',
                    'template' => $this->getComposerJson()
                ],
                [
                    'caminho' => 'README.md',
                    'template' => $this->getReadmeAvancado()
                ]
            ]
        ];
    }*/




    // ==========================================
    // TEMPLATES EMBUTIDOS (Com dados personalizados)
    // ==========================================

    /**
     * Template Base - Estrutura simples mas bem organizada
     */
    private function getTemplateBase(): array
    {
        return [
            'nome' => 'Template Base Profissional',
            'descricao' => 'Estrutura inicial bem organizada para projetos simples, seguindo boas práticas',
            'estrutura_diretorios' => [
                ['nome' => 'public', 'tipo' => 'pasta', 'filhos' => [
                    ['nome' => 'assets', 'tipo' => 'pasta', 'filhos' => [
                        ['nome' => 'css', 'tipo' => 'pasta'],
                        ['nome' => 'js', 'tipo' => 'pasta'],
                        ['nome' => 'images', 'tipo' => 'pasta']
                    ]],
                ]],
                ['nome' => 'docs', 'tipo' => 'pasta'],
                ['nome' => 'config', 'tipo' => 'pasta'],
            ],
            'arquivos_base' => [
                [
                    'caminho' => 'public/index.html',
                    'template' => '<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{PROJETO_TITULO}}</title>
    <meta name="description" content="{{PROJETO_DESCRICAO}}">
    <meta name="author" content="{{ESTUDANTE_NOME}}">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>{{PROJETO_TITULO}}</h1>
            <p class="subtitle">{{PROJETO_DESCRICAO}}</p>
            <p class="author">Desenvolvido por: {{ESTUDANTE_NOME}} - {{NUMERO_ESTUDANTE}}</p>
        </div>
    </header>

    <main class="main-content">
        <section class="container">
            <h2>Bem-vindo ao projeto</h2>
            <p>Template gerado em: {{DATA_CRIACAO}}</p>
            <p>Arquitetura: {{NIVEL_ARQUITETURA}}</p>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; ' . date('Y') . ' {{PROJETO_TITULO}} - IPPLS</p>
            <p>{{CURSO}} - {{TURMA}}</p>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>'
                ],
                [
                    'caminho' => 'public/assets/css/style.css',
                    'template' => '/**
 * {{PROJETO_TITULO}}
 * Desenvolvido por: {{ESTUDANTE_NOME}}
 * Email: {{ESTUDANTE_EMAIL}}
 * Data: {{DATA_CRIACAO}}
 */

:root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
    --text-color: #333;
    --light-color: #f9f9f9;
    --dark-color: #222;
    --spacing-unit: 1rem;
    --max-width: 1200px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Segoe UI", Roboto, sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: var(--light-color);
}

.container {
    width: 100%;
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-unit);
}

.header {
    background-color: var(--dark-color);
    color: white;
    padding: calc(var(--spacing-unit) * 2) 0;
    margin-bottom: var(--spacing-unit);
}

.subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-top: 0.5rem;
}

.author {
    font-size: 0.9rem;
    opacity: 0.7;
    margin-top: 0.5rem;
}

.main-content {
    min-height: 60vh;
    padding: 2rem 0;
}

.footer {
    background-color: var(--dark-color);
    color: white;
    padding: var(--spacing-unit) 0;
    margin-top: var(--spacing-unit);
    text-align: center;
}

.footer p {
    margin: 0.25rem 0;
}'
                ],
                [
                    'caminho' => 'public/assets/js/app.js',
                    'template' => '/**
 * {{PROJETO_TITULO}}
 *
 * Desenvolvido por: {{ESTUDANTE_NOME}}
 * Email: {{ESTUDANTE_EMAIL}}
 * Nº Estudante: {{NUMERO_ESTUDANTE}}
 * Curso: {{CURSO}}
 * Turma: {{TURMA}}
 *
 * Data de criação: {{DATA_CRIACAO}}
 * Arquitetura: {{NIVEL_ARQUITETURA}}
 */

document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ Projeto iniciado: {{PROJETO_TITULO}}");
    console.log("👨‍💻 Desenvolvedor: {{ESTUDANTE_NOME}}");
    console.log("🏗️ Arquitetura: {{NIVEL_ARQUITETURA}}");

    // Inicializar aplicação
    const App = {
        init() {
            this.setupEvents();
            this.displayInfo();
        },

        setupEvents() {
            console.log("🔧 Eventos configurados");
        },

        displayInfo() {
            console.log("📚 IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos");
        }
    };

    App.init();
});'
                ],
                [
                    'caminho' => 'config/config.php',
                    'template' => '<?php
/**
 * {{PROJETO_TITULO}}
 *
 * Desenvolvido por: {{ESTUDANTE_NOME}}
 * Email: {{ESTUDANTE_EMAIL}}
 * Data: {{DATA_CRIACAO}}
 */

define("APP_NAME", "{{PROJETO_TITULO}}");
define("APP_AUTHOR", "{{ESTUDANTE_NOME}}");
define("APP_EMAIL", "{{ESTUDANTE_EMAIL}}");
define("APP_VERSION", "1.0.0");

// Configurações do banco de dados
define("DB_HOST", "localhost");
define("DB_NAME", "database_name");
define("DB_USER", "root");
define("DB_PASS", "");

// URLs
define("BASE_URL", "http://localhost/");

// Timezone
date_default_timezone_set("Africa/Luanda");
'
                ],
                [
                    'caminho' => '.gitignore',
                    'template' => '# Diretórios de IDE
.idea/
.vscode/

# Arquivos de sistema
.DS_Store
Thumbs.db

# Logs e temporários
*.log
*.tmp
*.temp

# Dependências
node_modules/
vendor/

# Configurações sensíveis
config/database.local.php
.env'
                ]
            ]
        ];
    }

    /**
     * Template Padrão - Estrutura modular
     */
    private function getTemplatePadrao(): array
    {
        return [
            'nome' => 'Template Padrão Modular',
            'descricao' => 'Estrutura modular com separação de responsabilidades',
            'estrutura_diretorios' => [
                ['nome' => 'src', 'tipo' => 'pasta', 'filhos' => [
                    ['nome' => 'components', 'tipo' => 'pasta'],
                    ['nome' => 'modules', 'tipo' => 'pasta'],
                    ['nome' => 'styles', 'tipo' => 'pasta'],
                    ['nome' => 'utils', 'tipo' => 'pasta'],
                ]],
                ['nome' => 'public', 'tipo' => 'pasta'],
                ['nome' => 'config', 'tipo' => 'pasta'],
                ['nome' => 'docs', 'tipo' => 'pasta'],
            ],
            'arquivos_base' => [
                [
                    'caminho' => 'package.json',
                    'template' => '{
  "name": "{{PROJETO_TITULO}}",
  "version": "1.0.0",
  "description": "{{PROJETO_DESCRICAO}}",
  "author": "{{ESTUDANTE_NOME}} <{{ESTUDANTE_EMAIL}}>",
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  }
}'
                ]
            ]
        ];
    }

    /**
     * Template Avançado - Arquitetura MVC completa
     */
    private function getTemplateAvancado(): array
    {
        return [
            'nome' => 'Template Avançado MVC',
            'descricao' => 'Arquitetura MVC completa enterprise',
            'estrutura_diretorios' => [
                ['nome' => 'app', 'tipo' => 'pasta', 'filhos' => [
                    ['nome' => 'controllers', 'tipo' => 'pasta'],
                    ['nome' => 'models', 'tipo' => 'pasta'],
                    ['nome' => 'views', 'tipo' => 'pasta'],
                    ['nome' => 'services', 'tipo' => 'pasta'],
                ]],
                ['nome' => 'public', 'tipo' => 'pasta'],
                ['nome' => 'tests', 'tipo' => 'pasta'],
                ['nome' => 'config', 'tipo' => 'pasta'],
            ],
            'arquivos_base' => [
                [
                    'caminho' => 'composer.json',
                    'template' => '{
  "name": "{{ESTUDANTE_NOME}}/{{PROJETO_TITULO}}",
  "description": "{{PROJETO_DESCRICAO}}",
  "type": "project",
  "authors": [
    {
      "name": "{{ESTUDANTE_NOME}}",
      "email": "{{ESTUDANTE_EMAIL}}"
    }
  ],
  "require": {
    "php": "^8.0"
  }
}'
                ]
            ]
        ];
    }











    // Métodos para conteúdo dos arquivos básicos
    private function getHtmlBasico(): string
    {
        return '<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{PROJETO_TITULO}}</title>
    <meta name="description" content="{{PROJETO_DESCRICAO}}">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>{{PROJETO_TITULO}}</h1>
            <p>{{PROJETO_DESCRICAO}}</p>
        </div>
    </header>

    <main class="main-content">
        <section class="container">
            <h2>Bem-vindo ao seu projeto</h2>
            <p>Este é um template profissional básico para iniciar seu projeto.</p>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; ' . date('Y') . ' {{PROJETO_TITULO}}. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>';
    }

    private function getCssBasico(): string
    {
        return ':root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
    --text-color: #333;
    --light-color: #f9f9f9;
    --dark-color: #222;
    --spacing-unit: 1rem;
    --max-width: 1200px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Segoe UI", Roboto, sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: var(--light-color);
}

.container {
    width: 100%;
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-unit);
}

.header {
    background-color: var(--dark-color);
    color: white;
    padding: calc(var(--spacing-unit) * 2) 0;
    margin-bottom: var(--spacing-unit);
}

.footer {
    background-color: var(--dark-color);
    color: white;
    padding: var(--spacing-unit) 0;
    margin-top: var(--spacing-unit);
}';
    }

    private function getJsBasico(): string
    {
        return '/**
 * Ponto de entrada principal do projeto
 */
document.addEventListener("DOMContentLoaded", () => {
    console.log("Aplicação iniciada - Template Básico");

    // Exemplo de módulo
    const App = {
        init() {
            this.setupEvents();
        },

        setupEvents() {
            // Adicione listeners de eventos aqui
            console.log("Eventos configurados");
        }
    };

    App.init();
});';
    }



    private function getReadmeBasico(): string
    {
        return '# {{PROJETO_TITULO}}

        ## Descrição
        {{PROJETO_DESCRICAO}}

        ## Estrutura do Projeto
        project/
        ├── public/ # Arquivos públicos
        │ ├── assets/ # Recursos estáticos
        │ │ ├── css/ # Folhas de estilo
        │ │ ├── js/ # Scripts JavaScript
        │ │ └── images/ # Imagens
        │ └── index.html # Página principal
        ├── docs/ # Documentação
        └── README.md # Este arquivo

        text

        ## Como Executar
        1. Clone o repositório
        2. Abra o arquivo `public/index.html` em seu navegador

        ## Boas Práticas
        - Sempre organize seu código em módulos
        - Use nomes descritivos para arquivos e variáveis
        - Comente seu código adequadamente

        ## Licença
        MIT';
    }

    private function getGitignoreBasico(): string
    {
        return '# Diretórios de IDE
        .idea/
        .vscode/

        # Arquivos de sistema
        .DS_Store
        Thumbs.db

        # Logs e arquivos temporários
        *.log
        *.tmp
        *.temp

        # Dependências
        node_modules/
        vendor/';
    }

    // Métodos para conteúdo dos arquivos intermediários
    private function getHtmlIntermediario(): string
    {
        return '<!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{{PROJETO_TITULO}}</title>
            <meta name="description" content="{{PROJETO_DESCRICAO}}">
            <link rel="stylesheet" href="/dist/css/main.min.css">
        </head>
        <body>
            <div id="app">
                <header-component></header-component>

                <main class="main-content">
                    <div class="container">
                        <router-view></router-view>
                    </div>
                </main>

                <footer-component></footer-component>
            </div>

            <script src="/dist/js/app.min.js"></script>
        </body>
        </html>';
    }

    private function getScssIntermediario(): string
    {
        return '// Configurações
        @import "config/variables";
        @import "config/mixins";

        // Base
        @import "base/reset";
        @import "base/typography";

        // Componentes
        @import "components/buttons";
        @import "components/forms";

        // Layout
        @import "layout/header";
        @import "layout/footer";
        @import "layout/grid";

        // Páginas
        @import "pages/home";

        // Utilitários
        @import "utilities/helpers";';
    }

    private function getJsIntermediario(): string
    {
        return 'import { createApp } from "vue";
        import App from "./App.vue";
        import router from "./router";
        import store from "./store";

        // Cria a aplicação Vue
        const app = createApp(App);

        // Usa plugins
        app.use(router);
        app.use(store);

        // Monta a aplicação
        app.mount("#app");';
    }

private function getPackageJsonIntermediario(): string
{
    return json_encode([
        'name' => 'meu-projeto-intermediario',
        'version' => '1.0.0',
        'description' => '{{PROJETO_DESCRICAO}}',
        'scripts' => [
            'dev' => 'vite',
            'build' => 'vite build',
            'preview' => 'vite preview',
            'lint' => 'eslint src --ext .js,.vue',
            'format' => 'prettier --write src'
        ],
        'dependencies' => [
            'vue' => '^3.2.37',
            'vue-router' => '^4.1.5',
            'pinia' => '^2.0.14'
        ],
        'devDependencies' => [
            '@vitejs/plugin-vue' => '^3.0.0',
            'eslint' => '^8.22.0',
            'eslint-plugin-vue' => '^9.3.0',
            'prettier' => '^2.7.1',
            'sass' => '^1.54.0',
            'vite' => '^3.0.0'
        ]
    ], JSON_PRETTY_PRINT);
}
    private function getReadmeIntermediario(): string
    {
        return '# {{PROJETO_TITULO}} (Intermediário)

        ## Descrição
        {{PROJETO_DESCRICAO}}

        ## Tecnologias
        - Vue 3 (Composition API)
        - Vue Router
        - Pinia (Gerenciamento de estado)
        - Sass (Pré-processador CSS)
        - Vite (Build tool)

        ## Estrutura do Projeto
        src/
        ├── assets/ # Recursos estáticos
        ├── components/ # Componentes Vue
        ├── composables/ # Composables/ hooks
        ├── router/ # Configuração de rotas
        ├── stores/ # Gerenciamento de estado (Pinia)
        ├── styles/ # Estilos globais
        ├── utils/ # Utilitários
        ├── views/ # Páginas/views
        ├── App.vue # Componente raiz
        └── main.js # Ponto de entrada

        text

        ## Como Executar
        1. Instale as dependências: `npm install`
        2. Inicie o servidor de desenvolvimento: `npm run dev`
        3. Acesse: `http://localhost:3000`

        ## Scripts
        - `npm run build`: Cria build de produção
        - `npm run lint`: Verifica erros de código
        - `npm run format`: Formata o código automaticamente';
    }

    // Métodos para conteúdo dos arquivos avançados
    private function getPhpAvancado(): string
    {
        return '<?php
        require __DIR__ . "/../app/config/core.php";

        $app = new Core\Application();
        $app->run();';
    }

    private function getCoreConfig(): string
    {
        return '<?php
        namespace App\Config;

        class Core
        {
            const ENV_DEVELOPMENT = "development";
            const ENV_PRODUCTION = "production";

            protected $environment;

            public function __construct()
            {
                $this->setEnvironment();
                $this->setupErrorHandling();
                $this->loadConfigurations();
            }

            protected function setEnvironment()
            {
                $this->environment = getenv("APP_ENV") ?: self::ENV_DEVELOPMENT;
            }

            protected function setupErrorHandling()
            {
                if ($this->environment === self::ENV_DEVELOPMENT) {
                    error_reporting(E_ALL);
                    ini_set("display_errors", 1);
                } else {
                    error_reporting(0);
                    ini_set("display_errors", 0);
                }
            }

            protected function loadConfigurations()
            {
                require __DIR__ . "/database.php";
                require __DIR__ . "/routes.php";
            }
        }';
    }

    private function getControllerExample(): string
    {
        return '<?php
        namespace App\Controllers;

        use App\Models\User;
        use Core\Controller;
        use Core\View;

        class HomeController extends Controller
        {
            public function index()
            {
                $users = User::all();
                View::render("home/index", ["users" => $users]);
            }

            public function show($id)
            {
                $user = User::find($id);
                View::render("home/show", ["user" => $user]);
            }
        }';
    }

    private function getModelExample(): string
    {
        return '<?php
        namespace App\Models;

        use Core\Model;

        class User extends Model
        {
            protected $table = "users";
            protected $fillable = ["name", "email", "password"];

            public function posts()
            {
                return $this->hasMany(Post::class);
            }
        }';
    }
    private function getComposerJson(): string
    {
        return json_encode([
            'name' => 'meu-projeto/mvc',
            'description' => '{{PROJETO_TITULO}} - {{PROJETO_DESCRICAO}}',
            'type' => 'project',
            'require' => [
                'php' => '^8.0',
                'ext-pdo' => '*'
            ],
            'autoload' => [
                'psr-4' => [
                    'App\\' => 'app/'
                ]
            ],
            'require-dev' => [
                'phpunit/phpunit' => '^9.5'
            ],
            'config' => [
                'optimize-autoloader' => true
            ],
            'minimum-stability' => 'dev',
            'prefer-stable' => true
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
    private function getReadmeAvancado(): string
    {
        return '# {{PROJETO_TITULO}} (Avançado)

        ## Descrição
        {{PROJETO_DESCRICAO}}

        ## Arquitetura
        Padrão MVC (Model-View-Controller) com:
        - Rotas definidas
        - Injeção de dependências
        - ORM próprio
        - Sistema de templates
        - Camada de serviço

        ## Requisitos
        - PHP 8.0+
        - Composer
        - Banco de dados MySQL/PostgreSQL

        ## Instalação
        1. Clone o repositório
        2. Instale as dependências: `composer install`
        3. Configure o .env
        4. Execute as migrações: `php migrations.php`

        ## Estrutura
        app/
        ├── Config/ # Configurações
        ├── Controllers/ # Controladores
        ├── Models/ # Modelos
        ├── Services/ # Lógica de negócio
        └── Views/ # Templates

        public/ # Arquivos públicos
        tests/ # Testes
        vendor/ # Dependências

        text

        ## Testes
        Execute os testes com: `vendor/bin/phpunit`';
    }
}
