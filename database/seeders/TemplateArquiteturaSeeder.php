<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateArquitetura;
use Illuminate\Support\Facades\DB;

class TemplateArquiteturaSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔄 Verificando e atualizando templates...');
        $this->command->line('');

        // =====================================================
        // 1. TEMPLATE BASE - MVC SIMPLIFICADO
        // =====================================================
        TemplateArquitetura::updateOrCreate(
            [
                'nivel' => 'base' // Usar nivel como identificador único
            ],
            [
            'nome' => 'Template Base',
            'subtitulo' => 'MVC Simplificado',
            'nivel' => 'base',
            'descricao' => 'Estrutura MVC fundamental e direta para iniciantes. Aprenda os conceitos básicos de arquitetura de software com uma estrutura simples e bem organizada.',
            'descricao_completa' => 'O Template Base oferece uma introdução prática ao padrão MVC (Model-View-Controller), ideal para estudantes que estão começando no desenvolvimento web. Com uma estrutura enxuta e direta, permite foco no aprendizado dos conceitos fundamentais sem complexidade desnecessária.',

            // ✅ FORMATO COMPATÍVEL: formato antigo do seeder (chave = nome da pasta/arquivo)
            'estrutura_diretorios' => [
                'projeto_base/' => [
                    'index.php',
                    'config/' => ['database.php'],
                    'models/' => ['User.php'],
                    'views/' => [
                        'pages/' => ['home.php']
                    ],
                    'controllers/' => ['HomeController.php'],
                    'assets/' => [
                        'css/' => ['style.css'],
                        'js/' => ['main.js'],
                        'images/' => [
                            'logo/' => ['ippls-logo-removebg-preview.png']
                        ]
                    ],
                    'favicon.ico',
                    'README.md'
                ]
            ],

            // ✅ FORMATO COMPATÍVEL: array simples de strings (formato antigo)
            'arquivos_base' => [
                [
                    'caminho' => 'projeto_base/index.php',
                    'template' => $this->getIndexBase()
                ],
                [
                    'caminho' => 'projeto_base/config/database.php',
                    'template' => $this->getDatabaseConfig()
                ],
                [
                    'caminho' => 'projeto_base/models/User.php',
                    'template' => $this->getUserModel()
                ],
                [
                    'caminho' => 'projeto_base/controllers/HomeController.php',
                    'template' => $this->getHomeController()
                ],
                [
                    'caminho' => 'projeto_base/views/pages/home.php',
                    'template' => $this->getHomeView()
                ],
                [
                    'caminho' => 'projeto_base/assets/images/logo/ippls-logo-removebg-preview.png',
                    'template' => $this->getLogoPlaceholder()
                ],
                [
                    'caminho' => 'projeto_base/favicon.ico',
                    'template' => $this->getFaviconPlaceholder()
                ],
                [
                    'caminho' => 'projeto_base/assets/css/style.css',
                    'template' => $this->getStyleCss()
                ],
                [
                    'caminho' => 'projeto_base/assets/js/main.js',
                    'template' => $this->getMainJs()
                ],
                [
                    'caminho' => 'projeto_base/README.md',
                    'template' => $this->getReadmeBase()
                ]
            ],

            'requisitos' => [
                'PHP' => '>= 7.4',
                'MySQL' => '>= 5.7',
                'Apache/Nginx' => 'Qualquer',
                'Conhecimento' => 'Básico de PHP'
            ],

            'beneficios' => [
                'Estrutura simples e intuitiva para estudantes',
                'Separação clara de responsabilidades (MVC)',
                'Fácil manutenção e expansão do código',
                'Ideal para projetos acadêmicos pequenos',
                'Documentação completa incluída',
                'Exemplos práticos de uso'
            ],

            'casos_uso' => [
                ['nome' => 'Sistema de Cadastro', 'descricao' => 'CRUD básico para gerenciar usuários, produtos ou qualquer entidade.', 'icone' => 'database'],
                ['nome' => 'Páginas Dinâmicas', 'descricao' => 'Sites com conteúdo dinâmico proveniente da base de dados.', 'icone' => 'file-text'],
                ['nome' => 'Blogs Simples', 'descricao' => 'Sistema de publicação de artigos com categorias.', 'icone' => 'book'],
                ['nome' => 'Portfólios', 'descricao' => 'Páginas pessoais com projetos e informações.', 'icone' => 'briefcase']
            ],

            'caracteristicas' => ['Estrutura MVC Básica', 'Setup Rápido', 'Fácil de Aprender', 'Segurança Básica'],

            'instrucoes_uso' => $this->getInstrucoesBase(),

            'tempo_setup' => 5,
            'para_iniciantes' => true,
            'gratuito' => true,
            'documentado' => true,
            'ativo' => true
            ]
        );

        $this->command->info('  ✓ Template Base verificado/atualizado');

        // =====================================================
        // 2. TEMPLATE PADRÃO - MVC PROFISSIONAL
        // =====================================================
        TemplateArquitetura::updateOrCreate(
            [
                'nivel' => 'padrao' // Usar nivel como identificador único
            ],
            [
            'nome' => 'Template Padrão',
            'subtitulo' => 'MVC Profissional',
            'nivel' => 'padrao',
            'descricao' => 'Estrutura completa para projetos de médio porte, com camadas bem definidas, middlewares prontos e integrações modernas que aceleram o desenvolvimento com qualidade enterprise.',
            'descricao_completa' => 'O Template Padrão representa um salto qualitativo no desenvolvimento, oferecendo arquitetura robusta com camadas bem definidas. Inclui sistema de serviços, middlewares personalizados, componentes reutilizáveis e integração REST completa, ideal para projetos acadêmicos e corporativos de médio porte.',

            'estrutura_diretorios' => [
                'projeto_padrao/' => [
                    'app/' => [
                        'Http/' => [
                            'Controllers/',
                            'Middleware/',
                            'Requests/'
                        ],
                        'Services/',
                        'Repositories/',
                        'Models/'
                    ],
                    'database/' => [
                        'migrations/',
                        'seeders/',
                        'factories/'
                    ],
                    'routes/' => ['web.php', 'api.php'],
                    'resources/' => ['views/'],
                    'tests/' => ['Feature/', 'Unit/'],
                    'public/' => ['css/', 'js/', 'images/'],
                    'composer.json',
                    'artisan',
                    '.env.example',
                    'README.md'
                ]
            ],

            'arquivos_base' => [
                [
                    'caminho' => 'projeto_padrao/composer.json',
                    'template' => $this->getComposerJson()
                ],
                [
                    'caminho' => 'projeto_padrao/.env.example',
                    'template' => $this->getEnvExample()
                ],
                [
                    'caminho' => 'projeto_padrao/README.md',
                    'template' => $this->getReadmePadrao()
                ],
                [
                    'caminho' => 'projeto_padrao/routes/web.php',
                    'template' => $this->getWebRoutes()
                ],
                [
                    'caminho' => 'projeto_padrao/routes/api.php',
                    'template' => $this->getApiRoutes()
                ]
            ],

            'requisitos' => [
                'PHP' => '>= 8.1',
                'Composer' => '>= 2.5',
                'Node.js' => '>= 18',
                'MySQL' => '>= 8.0'
            ],

            'beneficios' => [
                'Separação completa entre Controller, Service e Repository',
                'Validações robustas com Form Requests e Policies',
                'Padrão para criação de APIs RESTful e SPA híbridas',
                'Testes automatizados com suporte a mocks e factories',
                'Layouts componentizados com Blade e Tailwind',
                'Pipeline de logs e monitoramento integrado'
            ],

            'casos_uso' => [
                ['nome' => 'Sistemas Acadêmicos', 'descricao' => 'Gestão de turmas, matrículas e avaliações com múltiplos papéis.', 'icone' => 'graduation-cap'],
                ['nome' => 'Plataformas Corporativas', 'descricao' => 'Soluções internas com dashboards, relatórios e workflows.', 'icone' => 'building'],
                ['nome' => 'APIs RESTful', 'descricao' => 'Serviços REST integrados com autenticação JWT e documentação.', 'icone' => 'code'],
                ['nome' => 'Portais Multiusuário', 'descricao' => 'Experiência completa com controle de acesso granular.', 'icone' => 'users']
            ],

            'caracteristicas' => ['Arquitetura em Camadas', 'Middlewares Personalizados', 'Componentização de Views', 'Integração REST Completa'],

            'instrucoes_uso' => $this->getInstrucoesPadrao(),

            'tempo_setup' => 15,
            'para_iniciantes' => false,
            'gratuito' => true,
            'documentado' => true,
            'ativo' => true
            ]
        );

        $this->command->info('  ✓ Template Padrão verificado/atualizado');

        // =====================================================
        // 3. TEMPLATE AVANÇADO - ARQUITETURA ENTERPRISE
        // =====================================================
        TemplateArquitetura::updateOrCreate(
            [
                'nivel' => 'avancado' // Usar nivel como identificador único
            ],
            [
            'nome' => 'Template Avançado',
            'subtitulo' => 'Arquitetura Enterprise',
            'nivel' => 'avancado',
            'descricao' => 'Plataforma completa para projetos mission critical. Inclui modularização, pipelines de deploy, observabilidade integrada e suporte a arquiteturas orientadas a eventos.',
            'descricao_completa' => 'O Template Avançado é a escolha definitiva para projetos enterprise que exigem escalabilidade, performance e governança. Implementa Domain-Driven Design (DDD), arquitetura em módulos independentes, pipelines CI/CD configurados, integração com filas, cache distribuído e monitoramento completo com métricas e alertas.',

            'estrutura_diretorios' => [
                'projeto_avancado/' => [
                    'apps/' => ['api/', 'spa/'],
                    'modules/' => [
                        'Users/' => ['Domain/', 'Application/', 'Infrastructure/'],
                        'Projects/' => ['Domain/', 'Application/', 'Infrastructure/'],
                        'Support/' => ['Domain/', 'Application/', 'Infrastructure/']
                    ],
                    'domains/',
                    'infrastructure/' => ['Cache/', 'Queue/', 'Storage/', 'Events/'],
                    'database/' => ['migrations/', 'seeders/', 'factories/'],
                    'tests/' => ['Feature/', 'Unit/', 'Integration/'],
                    'docker/' => ['Dockerfile', 'docker-compose.yml'],
                    'deploy/' => ['scripts/', 'pipelines/'],
                    'Makefile',
                    '.gitlab-ci.yml',
                    'README.md'
                ]
            ],

            'arquivos_base' => [
                [
                    'caminho' => 'projeto_avancado/Dockerfile',
                    'template' => $this->getDockerfile()
                ],
                [
                    'caminho' => 'projeto_avancado/docker-compose.yml',
                    'template' => $this->getDockerCompose()
                ],
                [
                    'caminho' => 'projeto_avancado/Makefile',
                    'template' => $this->getMakefile()
                ],
                [
                    'caminho' => 'projeto_avancado/.gitlab-ci.yml',
                    'template' => $this->getGitlabCi()
                ],
                [
                    'caminho' => 'projeto_avancado/README.md',
                    'template' => $this->getReadmeAvancado()
                ]
            ],

            'dependencias' => ['PHP 8.2+', 'Docker', 'Redis & Horizon', 'Node.js', 'Composer'],

            'requisitos' => [
                'PHP' => '>= 8.2',
                'Docker' => '>= 26',
                'Node.js' => '>= 18',
                'Redis & Horizon' => 'Obrigatórios'
            ],

            'beneficios' => [
                'Arquitetura modular com separação por domínios e camadas',
                'Integrado com filas, cache distribuído e pipelines CI/CD',
                'Observabilidade com logs estruturados, métricas e tracing',
                'Suporte a event sourcing e domain events com histórico completo',
                'Templates para testes de contrato, feature e domínio',
                'Scripts de deploy automatizados para ambientes multi-stage'
            ],

            'casos_uso' => [
                ['nome' => 'Plataformas SaaS', 'descricao' => 'Aplicações multi-tenant com escalabilidade horizontal e billing integrado.', 'icone' => 'cloud'],
                ['nome' => 'Sistemas Financeiros', 'descricao' => 'Processamento de transações com conciliação e auditoria completa.', 'icone' => 'dollar-sign'],
                ['nome' => 'Ecossistemas de APIs', 'descricao' => 'Centros de serviços REST com módulos independentes e versionamento.', 'icone' => 'layers'],
                ['nome' => 'Plataformas Educacionais', 'descricao' => 'Gestão de turmas, avaliações e automações com filas e notificações.', 'icone' => 'book-open']
            ],

            'caracteristicas' => ['Event Sourcing', 'Security by Design', 'CI/CD Automatizado', 'Arquitetura em Módulos'],

            'instrucoes_uso' => $this->getInstrucoesAvancado(),

            'tempo_setup' => 30,
            'para_iniciantes' => false,
            'gratuito' => true,
            'documentado' => true,
            'ativo' => true
            ]
        );

        $this->command->info('  ✓ Template Avançado verificado/atualizado');

        $this->command->newLine();
        $this->command->info('✅ Templates de arquitetura verificados/atualizados com sucesso!');
        $this->command->line('');
        $this->command->line('📦 <fg=cyan>Templates Disponíveis:</>');
        $this->command->line('   • Template Base - MVC Simplificado (Iniciantes)');
        $this->command->line('   • Template Padrão - MVC Profissional (Intermediário)');
        $this->command->line('   • Template Avançado - Arquitetura Enterprise (Avançado)');
        $this->command->line('');
    }

    // ==========================================
    // TEMPLATE BASE - CONTEÚDO DOS ARQUIVOS
    // ==========================================


private function getIndexBase(): string
{
    return <<<'PHP'
<?php
// index.php - Ponto de entrada e roteamento global

require_once 'config/database.php';

// Captura a ação da URL
$action = $_GET['action'] ?? 'index';

// Carregar controller
require_once 'controllers/HomeController.php';
$controller = new HomeController();

// Roteamento centralizado
switch ($action) {
    case 'create':
        $controller->create();
        break;

    case 'update':
        $controller->update();
        break;

    case 'delete':
        $controller->delete();
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
PHP;
}


    private function getDatabaseConfig(): string
    {
        return <<<'PHP'
<?php
// config/database.php - Configuração do banco de dados

define('DB_HOST', 'localhost');
define('DB_NAME', 'meu_projeto_base');
define('DB_USER', 'root');
define('DB_PASS', '');

// Função para conectar ao banco
function getConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}
PHP;
    }

    private function getUserModel(): string
    {
        return <<<'PHP'
<?php
// models/User.php - Model de usuário com CRUD completo

class User {
    private $db;

    public function __construct() {
        $this->db = getConnection();
    }

    // ✅ CREATE - Criar novo usuário
    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())"
        );
        return $stmt->execute([
            htmlspecialchars($data['name'] ?? ''),
            htmlspecialchars($data['email'] ?? '')
        ]);
    }

    // ✅ READ - Buscar todos os usuários
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ READ - Buscar usuário por ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ UPDATE - Atualizar usuário
    public function update($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE users SET name = ?, email = ? WHERE id = ?"
        );
        return $stmt->execute([
            htmlspecialchars($data['name'] ?? ''),
            htmlspecialchars($data['email'] ?? ''),
            $id
        ]);
    }

    // ✅ DELETE - Deletar usuário
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ✅ Validação de email único
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
PHP;
    }

private function getHomeController(): string
{
    return <<<'PHP'
<?php
// controllers/HomeController.php - Controller principal com CRUD completo

require_once 'models/User.php';

class HomeController {
    private $userModel;
    private $message = '';
    private $messageType = '';

    public function __construct() {
        // Iniciar sessão se não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    // ✅ Método principal - Lista todos os usuários
    public function index() {
        $users = $this->userModel->getAll();
        $controller = $this;
        require __DIR__ . '/../views/pages/home.php';
    }

    // ✅ CREATE - Criar novo usuário
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');

            // Validação
            if (empty($name) || empty($email)) {
                $this->setMessage('Por favor, preencha todos os campos.', 'error');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setMessage('Email inválido.', 'error');
            } elseif ($this->userModel->emailExists($email)) {
                $this->setMessage('Este email já está cadastrado.', 'error');
            } else {
                if ($this->userModel->create(['name' => $name, 'email' => $email])) {
                    $this->setMessage('Usuário criado com sucesso!', 'success');
                    header('Location: ?');
                    exit;
                } else {
                    $this->setMessage('Erro ao criar usuário.', 'error');
                }
            }
        }
        $this->index();
    }

    // ✅ UPDATE - Atualizar usuário
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');

            // Validação
            if (empty($name) || empty($email)) {
                $this->setMessage('Por favor, preencha todos os campos.', 'error');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setMessage('Email inválido.', 'error');
            } elseif ($this->userModel->emailExists($email, $id)) {
                $this->setMessage('Este email já está cadastrado.', 'error');
            } else {
                if ($this->userModel->update($id, ['name' => $name, 'email' => $email])) {
                    $this->setMessage('Usuário atualizado com sucesso!', 'success');
                    header('Location: ?');
                    exit;
                } else {
                    $this->setMessage('Erro ao atualizar usuário.', 'error');
                }
            }
        }
        $this->index();
    }

    // ✅ DELETE - Deletar usuário
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);

            if ($id > 0) {
                if ($this->userModel->delete($id)) {
                    $this->setMessage('Usuário deletado com sucesso!', 'success');
                    header('Location: ?');
                    exit;
                } else {
                    $this->setMessage('Erro ao deletar usuário.', 'error');
                }
            }
        }
        $this->index();
    }

    // ✅ Armazena mensagem na SESSION
    private function setMessage($message, $type) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }

    // ✅ Verifica se existe mensagem (NÃO limpa ainda)
    public function hasMessage() {
        return isset($_SESSION['flash_message']);
    }

    // ✅ Recupera mensagem SEM limpar
    public function getMessage() {
        return $_SESSION['flash_message'] ?? '';
    }

    // ✅ Recupera tipo SEM limpar
    public function getMessageType() {
        return $_SESSION['flash_type'] ?? '';
    }

    // ✅ NOVO - Limpa as mensagens após exibição
    public function clearMessage() {
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }

    public function getUserById($id) {
        return $this->userModel->getById($id);
    }
}
PHP;
}


    private function getHomeView(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Base MVC - IPPLS</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Hero Section - Brutal Design with IPPLS Logo -->
    <div class="hero-section">
        <div class="hero-container">
            <div class="hero-grid">
                <!-- Left Section: Text Content -->
                <div class="hero-content">
                    <!-- Welcome IPPLS -->
                    <div class="welcome-container">
                        <span class="welcome-icon">👋</span>
                        <span class="welcome-text">Bem-vindo ao futuro do desenvolvimento no ITLS</span>
                    </div>
                    <h1 class="hero-title">
                        Template <span class="hero-title-highlight">MVC BASE</span>
                    </h1>
                    <p class="hero-subtitle">
                        Arquitetura base para desenvolvimento rápido. Construa projetos sem concessões.
                    </p>
                    <div class="hero-buttons">
                        <a href="#home" class="btn-hero btn-hero-primary">Começar Agora</a>
                        <a href="README.md" class="btn-hero btn-hero-secondary">Documentação</a>
                    </div>
                </div>
                <!-- Right Section: Visual Block -->
                <div class="hero-visual">
                    <div class="decoration-block-top">
                        <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS Logo" class="logo">
                    </div>
                    <div class="feature-card">
                        <h2 class="feature-card-title">Ousado. Forte. Real.</h2>
                        <p class="feature-card-subtitle">IPPLS - Instituto Politécnico</p>
                    </div>
                    <div class="decoration-block-bottom">
                        <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS Logo" class="logo">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Alert Messages -->
        <?php if (isset($controller) && $controller->hasMessage()): ?>
            <div class="alert alert-<?= $controller->getMessageType() ?>">
                <span><?= $controller->getMessageType() === 'success' ? '✓' : '⚠' ?></span>
                <span><?= htmlspecialchars($controller->getMessage()) ?></span>
            </div>
            <?php $controller->clearMessage(); // Limpa APÓS exibir ?>
        <?php endif; ?>

        <h1 class="hero-title">
            CRUD - <span class="hero-title-highlight">CREATE</span> READ <span class="hero-title-highlight">UPDATE</span> DELETE
        </h1><br>

        <!-- Create/Edit User Card -->
        <div class="card" id="form">
            <div class="card-header">
                <h2><?= isset($_GET['edit']) ? '✏️ Editar Usuário' : '➕ Criar Usuário' ?></h2>
            </div>
            <div class="card-body">
                <?php
                $editUser = null;
                if (isset($_GET['edit']) && isset($controller)) {
                    $editUser = $controller->getUserById(intval($_GET['edit']));
                }
                ?>
                <form method="POST" action="?action=<?= $editUser ? 'update' : 'create' ?>">
                    <?php if ($editUser): ?>
                        <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="name">Nome Completo *</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-input"
                                value="<?= htmlspecialchars($editUser['name'] ?? '') ?>"
                                placeholder="Digite o nome"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email *</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                value="<?= htmlspecialchars($editUser['email'] ?? '') ?>"
                                placeholder="exemplo@ippls.edu.ao"
                                required
                            >
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <?= $editUser ? 'ATUALIZAR' : 'CRIAR' ?>
                        </button>
                        <?php if ($editUser): ?>
                            <a href="?" class="btn btn-secondary">CANCELAR</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users List Card -->
        <div class="card">
            <div class="card-header">
                <h2>📋 Usuários Cadastrados (<?= count($users ?? []) ?>)</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($users)): ?>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><strong>#<?= $user['id'] ?></strong></td>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($user['created_at'] ?? 'now')) ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?edit=<?= $user['id'] ?>" class="btn btn-sm btn-edit">
                                                    EDITAR
                                                </a>
                                                <form method="POST" action="?action=delete" class="inline-form"
                                                      onsubmit="return confirm('Confirma a exclusão?');">
                                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-delete">
                                                        DELETAR
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <h3>Nenhum Usuário</h3>
                        <p>Crie o primeiro usuário usando o formulário acima.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="skills-section">
        <h2 class="skills-title">Requisitos Técnicos</h2>
        <div class="skills-grid">
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" alt="HTML" class="skill-icon">
                <span class="skill-name">HTML5</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" alt="CSS" class="skill-icon">
                <span class="skill-name">CSS3</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript" class="skill-icon">
                <span class="skill-name">JavaScript</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP" class="skill-icon">
                <span class="skill-name">PHP</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL" class="skill-icon">
                <span class="skill-name">MySQL</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apache/apache-original.svg" alt="Apache" class="skill-icon">
                <span class="skill-name">Apache</span>
            </div>
            <div class="skill-card">
                <img src="https://www.apachefriends.org/images/xampp-logo-ac950edf.svg" alt="XAMPP" class="skill-icon">
                <span class="skill-name">XAMPP</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg" alt="Git" class="skill-icon">
                <span class="skill-name">Git</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS" class="footer-logo">
                <p class="footer-desc">Arquitetura base para desenvolver seus projetos.</p>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Links Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="#home">Começar</a></li>
                    <li><a href="README.md">Documentação</a></li>
                    <li><a href="?">Usuários</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Tecnologias</h3>
                <ul class="footer-links">
                    <li>PHP • MySQL</li>
                    <li>HTML5 • CSS3</li>
                    <li>JavaScript • Git</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>Desenvolvido com ❤️ para o <strong>IPPLS</strong></p>
            <p class="footer-version">Template Base MVC • v1.0.0 • 2025</p>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
HTML;
    }

    private function getStyleCss(): string
    {
        return <<<'CSS'
/* ============================================
    Template Base MVC - IPPLS BRUTAL DESIGN
    Estrutura Organizada e Modular
    ============================================ */

/* ============================================
   1. RESET & BASE
   ============================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    /* Cores IPPLS */
    --ippls-blue-dark: #07183b;
    --ippls-blue-medium: #4A8FC4;
    --ippls-red: #C1272D;
    --ippls-gold: #F4B41A;
    --ippls-gold-dark: #D69E0E;

    /* Escala de Cinzas */
    --gray-900: #0c2248;
    --gray-800: #1a2f52;
    --gray-700: #2d4464;
    --gray-400: #a0a0a0;
    --gray-50: #f9f9f9;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background: linear-gradient(135deg, #e8eef5 0%, #d4dce8 100%);
    min-height: 100vh;
    padding: 0;
    color: #07183b;
    line-height: 1.6;
}


/* ============================================
   2. SEÇÃO HERO
   ============================================ */

/* Container Principal */
.hero-section {
    padding: 1.5rem 1rem;
    margin: 0;
    border-radius: 0;
    background: var(--gray-900);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    position: relative;
}

@media (min-width: 768px) {
    .hero-section {
        padding: 2.5rem 1.25rem;
        margin: 0;
    }
}

.hero-container {
    width: 100%;
    max-width: 1400px;
    padding: 0 1rem;
}

/* Layout em Grade */
.hero-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    align-items: center;
}

@media (min-width: 768px) {
    .hero-grid {
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
}

/* Conteúdo Hero (Esquerda) */
.hero-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    z-index: 10;
}

@media (min-width: 768px) {
    .hero-content {
        text-align: left;
    }
}

/* Títulos */
.hero-title {
    font-size: 2rem;
    font-weight: 900;
    text-transform: uppercase;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

@media (min-width: 480px) {
    .hero-title {
        font-size: 2.5rem;
    }
}

@media (min-width: 640px) {
    .hero-title {
        font-size: 3rem;
    }
}

@media (min-width: 768px) {
    .hero-title {
        font-size: 3.5rem;
    }
}

@media (min-width: 1024px) {
    .hero-title {
        font-size: 4.5rem;
    }
}

.hero-title-highlight {
    color: var(--ippls-gold);
}

.hero-subtitle {
    margin-top: 1rem;
    font-size: 1rem;
    font-weight: 500;
    color: var(--gray-400);
    text-wrap: balance;
}

@media (min-width: 640px) {
    .hero-subtitle {
        font-size: 1.125rem;
    }
}

@media (min-width: 768px) {
    .hero-subtitle {
        font-size: 1.25rem;
    }
}

/* Badge de Boas-Vindas */
.welcome-container {
    margin-bottom: 1rem;
    display: inline-block;
}

@media (min-width: 640px) {
    .welcome-container {
        margin-bottom: 1.5rem;
    }
}

@media (min-width: 1024px) {
    .welcome-container {
        margin-bottom: 2rem;
    }
}

.welcome-icon {
    font-size: 1.5rem;
    animation: wave 2s ease-in-out infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-20deg); }
}

.welcome-text {
    font-size: 0.875rem;
    color: var(--ippls-gold);
    font-weight: 900;
    text-transform: uppercase;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

@media (min-width: 640px) {
    .welcome-text {
        font-size: 0.95rem;
    }
}

/* Botões da Seção Hero */
.hero-buttons {
    margin-top: 2rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.btn-hero {
    border-radius: 0.25rem;
    padding: 0.875rem 2rem;
    flex-grow: 1;
    text-align: center;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.1em;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    border: none;
    cursor: pointer;
}

.btn-hero-primary {
    background: var(--ippls-gold);
    color: #07183b;
}

.btn-hero-primary:hover {
    background: var(--ippls-gold-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(244, 180, 26, 0.3);
}

.btn-hero-secondary {
    border: 2px solid var(--ippls-gold);
    color: var(--ippls-gold);
    background: transparent;
}

.btn-hero-secondary:hover {
    background: var(--ippls-gold);
    color: #07183b;
}

/* Visual Hero (Direita) */
.hero-visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    min-height: 200px;
}

@media (min-width: 640px) {
    .hero-visual {
        padding: 2rem;
        min-height: 250px;
    }
}

@media (min-width: 768px) {
    .hero-visual {
        padding: 2.5rem;
        min-height: 300px;
    }
}

/* Blocos Decorativos */
.decoration-block-top {
    position: absolute;
    top: -1rem;
    left: -1rem;
    width: 4rem;
    height: 4rem;
    background: var(--ippls-gold);
    transform: rotate(12deg);
    border-radius: 0.5rem;
    border-bottom: 3px solid var(--ippls-gold-dark);
    border-right: 5px solid var(--ippls-gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (min-width: 640px) {
    .decoration-block-top {
        top: -1.5rem;
        left: -1.5rem;
        width: 6rem;
        height: 6rem;
    }
}

@media (min-width: 768px) {
    .decoration-block-top {
        top: -2.5rem;
        left: -2.5rem;
        width: 8rem;
        height: 8rem;
        border-bottom: 4px solid var(--ippls-gold-dark);
        border-right: 8px solid var(--ippls-gold-dark);
    }
}

@media (min-width: 1024px) {
    .decoration-block-top {
        width: 12rem;
        height: 12rem;
    }
}

@media (min-width: 1280px) {
    .decoration-block-top {
        top: -5rem;
        width: 16rem;
        height: 16rem;
    }
}

.decoration-block-bottom {
    position: absolute;
    bottom: -1rem;
    right: -1rem;
    width: 4rem;
    height: 4rem;
    background: var(--ippls-gold);
    transform: rotate(-12deg);
    border-radius: 0.5rem;
    border-right: 3px solid var(--ippls-gold-dark);
    border-bottom: 5px solid var(--ippls-gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (min-width: 640px) {
    .decoration-block-bottom {
        bottom: -1.5rem;
        right: -1.5rem;
        width: 6rem;
        height: 6rem;
    }
}

@media (min-width: 768px) {
    .decoration-block-bottom {
        bottom: -2.5rem;
        right: -2.5rem;
        width: 8rem;
        height: 8rem;
        border-right: 4px solid var(--ippls-gold-dark);
        border-bottom: 8px solid var(--ippls-gold-dark);
    }
}

@media (min-width: 1024px) {
    .decoration-block-bottom {
        width: 12rem;
        height: 12rem;
    }
}

@media (min-width: 1280px) {
    .decoration-block-bottom {
        bottom: -5rem;
        right: -4rem;
        width: 16rem;
        height: 16rem;
    }
}

/* Logos */
.logo {
    height: 50px;
    width: auto;
    display: block;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    filter: drop-shadow(0 10px 20px rgba(255, 255, 255, 0.4))
            drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3))
            drop-shadow(0 2px 4px rgba(255, 255, 255, 0.2));
}

@media (min-width: 480px) {
    .logo {
        height: 60px;
        filter: drop-shadow(0 12px 24px rgba(255, 255, 255, 0.45))
                drop-shadow(0 6px 12px rgba(255, 255, 255, 0.35))
                drop-shadow(0 3px 6px rgba(255, 255, 255, 0.25));
    }
}

@media (min-width: 640px) {
    .logo {
        height: 70px;
        filter: drop-shadow(0 15px 30px rgba(255, 255, 255, 0.5))
                drop-shadow(0 8px 16px rgba(255, 255, 255, 0.4))
                drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
    }
}

@media (min-width: 768px) {
    .logo {
        height: 80px;
        filter: drop-shadow(0 18px 36px rgba(255, 255, 255, 0.55))
                drop-shadow(0 10px 20px rgba(255, 255, 255, 0.45))
                drop-shadow(0 5px 10px rgba(255, 255, 255, 0.35));
    }
}

@media (min-width: 1024px) {
    .logo {
        height: 100px;
        filter: drop-shadow(0 20px 40px rgba(255, 255, 255, 0.6))
                drop-shadow(0 12px 24px rgba(255, 255, 255, 0.5))
                drop-shadow(0 6px 12px rgba(255, 255, 255, 0.4))
                drop-shadow(0 2px 4px rgba(255, 255, 255, 0.3));
    }
}

@media (min-width: 1280px) {
    .logo {
        height: 120px;
        filter: drop-shadow(0 25px 50px rgba(255, 255, 255, 0.65))
                drop-shadow(0 15px 30px rgba(255, 255, 255, 0.55))
                drop-shadow(0 8px 16px rgba(255, 255, 255, 0.45))
                drop-shadow(0 3px 6px rgba(255, 255, 255, 0.35));
    }
}

.logo:hover {
    transform: scale(1.08) translateY(-4px);
    filter: drop-shadow(0 30px 60px rgba(255, 255, 255, 0.8))
            drop-shadow(0 20px 40px rgba(255, 255, 255, 0.7))
            drop-shadow(0 10px 20px rgba(244, 180, 26, 0.6))
            drop-shadow(0 5px 10px rgba(244, 180, 26, 0.8));
}

/* Card de Destaque */
.feature-card {
    position: relative;
    z-index: 10;
    background: var(--gray-800);
    padding: 1rem;
    width: 100%;
    max-width: 100%;
    text-align: center;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    transform: rotate(-2deg);
    border-radius: 0.75rem;
    border-bottom: 3px solid #050f1f;
    border-right: 5px solid #050f1f;
}

@media (min-width: 640px) {
    .feature-card {
        padding: 1.5rem;
        border-bottom: 4px solid #050f1f;
        border-right: 8px solid #050f1f;
    }
}

.feature-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--gray-50);
    word-wrap: break-word;
    hyphens: auto;
}

@media (min-width: 480px) {
    .feature-card-title {
        font-size: 1.5rem;
    }
}

@media (min-width: 640px) {
    .feature-card-title {
        font-size: 1.875rem;
    }
}

.feature-card-subtitle {
    margin-top: 0.25rem;
    font-size: 0.75rem;
    font-weight: 300;
    color: var(--gray-400);
}

@media (min-width: 640px) {
    .feature-card-subtitle {
        font-size: 0.875rem;
    }
}

@media (min-width: 768px) {
    .feature-card-subtitle {
        font-size: 1rem;
    }
}


/* ============================================
   3. CONTAINER PRINCIPAL
   ============================================ */
.main-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 1.25rem;
}


/* ============================================
   4. ALERTAS E MENSAGENS FLASH
   ============================================ */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-weight: 600;
    animation: slideDown 0.3s ease;
    border-left: 4px solid;
    position: relative;
    z-index: 1000;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-color: #28a745;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border-color: #dc3545;
}


/* ============================================
   5. CARDS
   ============================================ */
.card {
    background: var(--gray-900);
    color: white;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    margin-bottom: 2rem;
    border-bottom: 4px solid #050f1f;
    border-right: 6px solid #050f1f;
}

.card-header {
    background: var(--gray-800);
    padding: 1.5rem 2rem;
    border-bottom: 3px solid var(--ippls-gold);
}

.card-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.card-body {
    padding: 2rem;
    background: var(--gray-900);
}


/* ============================================
   6. FORMULÁRIOS
   ============================================ */
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 700;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--gray-400);
}

.form-input {
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-700);
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--gray-800);
    color: white;
}

.form-input:focus {
    outline: none;
    border-color: var(--ippls-gold);
    background: var(--gray-700);
}

.form-input::placeholder {
    color: var(--gray-400);
}


/* ============================================
   7. BOTÕES
   ============================================ */
.button-group {
    display: flex;
    gap: 1rem;
    padding-top: 1rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.875rem 2rem;
    border: none;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--ippls-gold);
    color: #07183b;
    border-bottom: 3px solid var(--ippls-gold-dark);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(244, 180, 26, 0.4);
}

.btn-secondary {
    background: transparent;
    color: var(--gray-400);
    border: 2px solid var(--gray-700);
}

.btn-secondary:hover {
    background: var(--gray-800);
    border-color: var(--gray-400);
    color: white;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}

.btn-edit {
    background: var(--ippls-gold);
    color: #07183b;
    border: none;
}

.btn-edit:hover {
    background: var(--ippls-gold-dark);
    transform: translateY(-1px);
}

.btn-delete {
    background: var(--ippls-red);
    color: white;
    border: none;
}

.btn-delete:hover {
    background: #9d1f23;
    transform: translateY(-1px);
}


/* ============================================
   8. TABELAS
   ============================================ */
.table-wrapper {
    overflow-x: auto;
    border-radius: 0.5rem;
    border: 2px solid var(--gray-800);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--gray-800);
}

.data-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.1em;
    color: var(--ippls-gold);
}

.data-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-800);
}

.data-table tbody tr {
    transition: background-color 0.2s ease;
}

.data-table tbody tr:hover {
    background: var(--gray-800);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}


/* ============================================
   9. ESTADO VAZIO
   ============================================ */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--gray-400);
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: white;
    text-transform: uppercase;
    font-weight: 700;
}


/* ============================================
   10. SEÇÃO DE HABILIDADES
   ============================================ */
.skills-section {
    width: 100%;
    max-width: 1200px;
    margin: 3rem auto;
    text-align: center;
    padding: 2rem 1.5rem;
}

.skills-title {
    font-size: 2rem;
    font-weight: 700;
    color: #0c2248;
    margin-bottom: 2rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    line-height: 1.1;
}

@media (min-width: 768px) {
    .skills-title {
        font-size: 2.5rem;
    }
}

.skills-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (min-width: 640px) {
    .skills-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (min-width: 768px) {
    .skills-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }
}

.skill-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 1rem;
    background: #0c2248;
    border-radius: 0.75rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.skill-card:hover {
    transform: scale(1.05) translateY(-5px);
    background: #1a3a5f;
    border-color: var(--ippls-gold);
    box-shadow: 0 15px 35px rgba(244, 180, 26, 0.3);
}

.skill-icon {
    width: 3rem;
    height: 3rem;
    margin-bottom: 0.75rem;
    transition: transform 0.3s ease;
}

@media (min-width: 768px) {
    .skill-icon {
        width: 3.5rem;
        height: 3.5rem;
    }
}

.skill-card:hover .skill-icon {
    transform: rotateY(360deg);
}

.skill-name {
    color: #d1d5db;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

@media (min-width: 768px) {
    .skill-name {
        font-size: 0.95rem;
    }
}

.skill-card:hover .skill-name {
    color: var(--ippls-gold);
}


/* ============================================
   11. RODAPÉ
   ============================================ */
.footer {
    background: var(--gray-900);
    color: white;
    margin-top: 3rem;
    padding: 2.5rem 2rem;
    border-top: 3px solid var(--ippls-gold);
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .footer-content {
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
    }
}

.footer-section {
    flex: 1;
    min-width: 200px;
}

.footer-logo {
    height: 60px;
    margin-bottom: 1rem;
    filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
}

.footer-desc {
    color: var(--gray-400);
    font-size: 0.9rem;
    line-height: 1.6;
}

.footer-heading {
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--ippls-gold);
    margin-bottom: 1rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: var(--gray-400);
}

.footer-links a {
    color: var(--gray-400);
    text-decoration: none;
    transition: color 0.3s;
}

.footer-links a:hover {
    color: var(--ippls-gold);
}

.footer-bottom {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--gray-700);
    text-align: center;
}

.footer-bottom p {
    margin: 0.5rem 0;
    font-size: 0.95rem;
    color: var(--gray-400);
}

.footer-bottom strong {
    color: var(--ippls-gold);
    font-weight: 600;
}

.footer-version {
    font-size: 0.75rem;
    color: var(--gray-400);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.footer-heart {
    color: var(--ippls-red);
    animation: heartbeat 1.5s ease-in-out infinite;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}


/* ============================================
   12. CLASSES UTILITÁRIAS
   ============================================ */
.inline-form {
    display: inline;
}


/* ============================================
   13. RESPONSIVIDADE
   ============================================ */
@media (max-width: 768px) {
    .button-group {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-sm {
        width: 100%;
    }

    .card-body {
        padding: 1.5rem;
    }
}
CSS;
    }

    private function getMainJs(): string
    {
        return <<<'JS'
// assets/js/main.js - Scripts principais

document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Template Base MVC carregado com sucesso! DESIGN BRUTAL');
    console.log('🏫 IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos');

    // Adicionar animação suave nas linhas da tabela
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';

        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Auto-hide mensagens após 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s, transform 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Validação de formulário em tempo real
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = '#C1272D';
            } else {
                this.style.borderColor = '#4A8FC4';
            }
        });
    }
});
JS;
    }

    private function getLogoPlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'LOGO_PLACEHOLDER - O logo IPPLS será incluído automaticamente no template.';
    }

    private function getFaviconPlaceholder(): string
    {
        // Retorna uma nota de que o favicon deve ser copiado manualmente
        return 'FAVICON_PLACEHOLDER - O favicon será incluído automaticamente no template.';
    }



    private function getReadmeBase(): string
    {
        return <<<'MD'
# Template Base - MVC Simplificado

Estrutura MVC fundamental e direta para iniciantes no desenvolvimento web.

## 🏫 IPPLS
**Instituto Politécnico Privado Lucrêcio dos Santos**

Template desenvolvido para o curso de Gestão de Redes e Sistemas Informáticos.

## 📋 Requisitos

- PHP >= 7.4
- MySQL >= 5.7
- Apache/Nginx
- Conhecimento básico de PHP

## 🚀 Instalação

### 1. Configurar Servidor Local

Coloque os arquivos na pasta do seu servidor web:
- **XAMPP**: `C:\xampp\htdocs\meu-projeto`
- **WAMP**: `C:\wamp64\www\meu-projeto`
- **MAMP**: `/Applications/MAMP/htdocs/meu-projeto`

### 2. Criar Banco de Dados
```sql
CREATE DATABASE meu_projeto_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE meu_projeto_base;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email) VALUES
('Pai Grande Ngola', 'paigrandengola@ippls.edu.ao'),
('Professor Lengo Júnior', 'lengojunior@ippls.edu.ao'),
('Eng. Vanilson Manuel', 'vanilsonmanuel@ippls.edu.ao');
```

### 3. Configurar Conexão

Edite `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'meu_projeto_base');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Acessar Aplicação
```
http://localhost/meu-projeto
```

## 📁 Estrutura do Projeto
```
projeto_base/
├── index.php                    # Ponto de entrada e roteamento centralizado
├── favicon.ico                  # Ícone do site
├── config/
│   └── database.php            # Configuração do banco de dados
├── models/
│   └── User.php                # Model com CRUD completo
├── views/
│   └── pages/                  # 📁 Diretório para suas páginas
│       └── home.php            # Página inicial com CRUD funcional
├── controllers/
│   └── HomeController.php      # Controller com ações CRUD e mensagens flash
└── assets/
    ├── css/
    │   └── style.css           # Estilos com cores IPPLS
    ├── js/
    │   └── main.js             # Scripts JavaScript
    └── images/
        └── logo/
            └── ippls-logo-removebg-preview.png
```

## 🎯 Conceitos Aprendidos

- **Model**: Gerencia os dados e a lógica de negócio (CRUD completo)
- **View**: Responsável pela apresentação (HTML + PHP)
- **Controller**: Intermediário entre Model e View (processa requisições)
- **Roteamento**: O `index.php` gerencia todas as rotas da aplicação
- **Sessões**: Sistema de mensagens flash persistentes entre requisições

## 🔄 Fluxo de Requisição
```
Usuário acessa URL
    ↓
index.php (roteamento)
    ↓
HomeController (lógica + sessões)
    ↓
User Model (dados)
    ↓
home.php (apresentação + limpeza de mensagens)
```

## ✨ Funcionalidades Incluídas

Este template já vem com um **CRUD completo de usuários** funcionando:
- ✅ **Create** - Criar novos usuários
- ✅ **Read** - Listar todos os usuários
- ✅ **Update** - Editar usuários existentes
- ✅ **Delete** - Deletar usuários
- ✅ **Validação** de formulários com feedback
- ✅ **Mensagens flash** persistentes com sessões
- ✅ **Redirecionamento** PRG (Post-Redirect-Get)
- ✅ Interface responsiva
- ✅ Logo IPPLS incluído

## 💬 Sistema de Mensagens Flash

O template inclui um sistema robusto de mensagens que persiste entre redirecionamentos usando **sessões do PHP**.

### Como Funciona

```php
// 1. Controller armazena a mensagem na sessão
$this->setMessage('Usuário criado com sucesso!', 'success');
header('Location: ?');
exit;

// 2. View verifica se existe mensagem
<?php if (isset($controller) && $controller->hasMessage()): ?>
    <div class="alert alert-<?= $controller->getMessageType() ?>">
        <span><?= $controller->getMessageType() === 'success' ? '✓' : '⚠' ?></span>
        <span><?= htmlspecialchars($controller->getMessage()) ?></span>
    </div>
    <?php $controller->clearMessage(); // Limpa após exibir ?>
<?php endif; ?>
```

### Métodos Disponíveis

```php
// Armazenar mensagem (privado - apenas dentro do controller)
$this->setMessage('Texto da mensagem', 'success'); // ou 'error'

// Verificar se existe mensagem
$controller->hasMessage(); // true/false

// Recuperar mensagem (não limpa)
$controller->getMessage(); // string

// Recuperar tipo (não limpa)
$controller->getMessageType(); // 'success' ou 'error'

// Limpar mensagem da sessão
$controller->clearMessage(); // void
```

## 🎨 Cores do IPPLS

O template usa as cores oficiais do IPPLS definidas no CSS:

```css
/* Cores Principais */
--ippls-blue-dark: #07183b;      /* Azul Escuro Principal */
--ippls-blue-medium: #4A8FC4;    /* Azul Médio */
--ippls-red: #C1272D;            /* Vermelho IPPLS */
--ippls-gold: #F4B41A;           /* Dourado Principal */
--ippls-gold-dark: #D69E0E;      /* Dourado Escuro (sombras) */

/* Escala de Cinzas */
--gray-900: #0c2248;             /* Fundo escuro */
--gray-800: #1a2f52;             /* Cards e headers */
--gray-700: #2d4464;             /* Bordas */
--gray-400: #a0a0a0;             /* Texto secundário */
--gray-50: #f9f9f9;              /* Texto claro */
```

Use essas variáveis CSS para manter a identidade visual consistente!

## 📝 Como Criar Novas Funcionalidades

### 1. Criar um Novo Model

Crie um arquivo em `models/` (ex: `Product.php`):
```php
<?php
// models/Product.php

class Product {
    private $db;

    public function __construct() {
        $this->db = getConnection();
    }

    // CREATE
    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO products (name, price) VALUES (?, ?)"
        );
        return $stmt->execute([
            htmlspecialchars($data['name']),
            floatval($data['price'])
        ]);
    }

    // READ - Todos
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ - Por ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE products SET name = ?, price = ? WHERE id = ?"
        );
        return $stmt->execute([
            htmlspecialchars($data['name']),
            floatval($data['price']),
            $id
        ]);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
```

### 2. Criar um Novo Controller com Sistema de Mensagens

Crie um arquivo em `controllers/` (ex: `ProductController.php`):
```php
<?php
// controllers/ProductController.php

require_once 'models/Product.php';

class ProductController {
    private $productModel;

    public function __construct() {
        // ✅ Iniciar sessão
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->productModel = new Product();
    }

    public function index() {
        $products = $this->productModel->getAll();
        $controller = $this;
        require __DIR__ . '/../views/pages/products.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);

            if (empty($name) || $price <= 0) {
                $this->setMessage('Preencha todos os campos corretamente.', 'error');
            } else {
                if ($this->productModel->create(['name' => $name, 'price' => $price])) {
                    // ✅ Mensagem armazenada na sessão
                    $this->setMessage('Produto criado com sucesso!', 'success');
                    // ✅ Redireciona (PRG pattern)
                    header('Location: ?page=products');
                    exit;
                } else {
                    $this->setMessage('Erro ao criar produto.', 'error');
                }
            }
        }
        $this->index();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);

            if (empty($name) || $price <= 0) {
                $this->setMessage('Preencha todos os campos corretamente.', 'error');
            } else {
                if ($this->productModel->update($id, ['name' => $name, 'price' => $price])) {
                    $this->setMessage('Produto atualizado com sucesso!', 'success');
                    header('Location: ?page=products');
                    exit;
                } else {
                    $this->setMessage('Erro ao atualizar produto.', 'error');
                }
            }
        }
        $this->index();
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0 && $this->productModel->delete($id)) {
                $this->setMessage('Produto deletado com sucesso!', 'success');
                header('Location: ?page=products');
                exit;
            } else {
                $this->setMessage('Erro ao deletar produto.', 'error');
            }
        }
        $this->index();
    }

    // ✅ SISTEMA DE MENSAGENS FLASH COM SESSÕES

    private function setMessage($message, $type) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }

    public function hasMessage() {
        return isset($_SESSION['flash_message']);
    }

    public function getMessage() {
        return $_SESSION['flash_message'] ?? '';
    }

    public function getMessageType() {
        return $_SESSION['flash_type'] ?? '';
    }

    public function clearMessage() {
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }

    // Outros métodos auxiliares
    public function getProductById($id) {
        return $this->productModel->getById($id);
    }
}
```

### 3. Criar uma Nova View com Mensagens Flash

Crie um arquivo em `views/pages/` (ex: `products.php`):
```php
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - IPPLS</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- ✅ Header Específico de Produtos (Versão Simplificada) -->
    <header class="page-header">
        <div class="page-header-content">
            <img src="assets/images/logo/ippls-logo-removebg-preview.png"
                 alt="IPPLS"
                 class="page-header-logo">
            <div class="page-header-text">
                <h1>Gestão de Produtos</h1>
                <p>IPPLS - Template Base MVC</p>
            </div>
        </div>
    </header>

    <!-- ✅ Container Principal para Conteúdo -->
    <div class="main-container">
        <!-- Sistema de Mensagens Flash -->
        <?php if (isset($controller) && $controller->hasMessage()): ?>
            <div class="alert alert-<?= $controller->getMessageType() ?>">
                <span><?= $controller->getMessageType() === 'success' ? '✓' : '⚠' ?></span>
                <span><?= htmlspecialchars($controller->getMessage()) ?></span>
            </div>
            <?php $controller->clearMessage(); ?>
        <?php endif; ?>

        <!-- Formulário de Criação/Edição -->
        <div class="card" id="form">
            <div class="card-header">
                <h2><?= isset($_GET['edit']) ? '✏️ Editar Produto' : '➕ Criar Produto' ?></h2>
            </div>
            <div class="card-body">
                <?php
                $editProduct = null;
                if (isset($_GET['edit']) && isset($controller)) {
                    $editProduct = $controller->getProductById(intval($_GET['edit']));
                }
                ?>
                <form method="POST" action="?page=products&action=<?= $editProduct ? 'update' : 'create' ?>">
                    <?php if ($editProduct): ?>
                        <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="name">Nome *</label>
                            <input type="text" id="name" name="name"
                                   class="form-input"
                                   value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>"
                                   placeholder="Digite o nome do produto"
                                   required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="price">Preço *</label>
                            <input type="number" id="price" name="price"
                                   class="form-input"
                                   value="<?= $editProduct['price'] ?? '' ?>"
                                   placeholder="0.00"
                                   step="0.01" required>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <?= $editProduct ? 'ATUALIZAR' : 'CRIAR' ?>
                        </button>
                        <?php if ($editProduct): ?>
                            <a href="?page=products" class="btn btn-secondary">CANCELAR</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Produtos -->
        <div class="card">
            <div class="card-header">
                <h2>📋 Produtos Cadastrados (<?= count($products ?? []) ?>)</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($products)): ?>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Preço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><strong>#<?= $product['id'] ?></strong></td>
                                        <td><?= htmlspecialchars($product['name']) ?></td>
                                        <td><?= number_format($product['price'], 2, ',', '.') ?> Kz</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?page=products&edit=<?= $product['id'] ?>#form"
                                                   class="btn btn-sm btn-edit">EDITAR</a>
                                                <form method="POST"
                                                      action="?page=products&action=delete"
                                                      class="inline-form"
                                                      onsubmit="return confirm('Confirma a exclusão de <?= htmlspecialchars($product['name']) ?>?');">
                                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-delete">
                                                        DELETAR
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <h3>Nenhum Produto</h3>
                        <p>Crie o primeiro produto usando o formulário acima.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS" class="footer-logo">
                <p class="footer-desc">Arquitetura base para desenvolver seus projetos.</p>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Links Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="#form">Começar</a></li>
                    <li><a href="README.md">Documentação</a></li>
                    <li><a href="?">Usuários</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Tecnologias</h3>
                <ul class="footer-links">
                    <li>PHP • MySQL</li>
                    <li>HTML5 • CSS3</li>
                    <li>JavaScript • Git</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>Desenvolvido com ❤️ para o <strong>IPPLS</strong></p>
            <p class="footer-version">Template Base MVC • v1.0.0 • 2025</p>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
```

### 4. Adicionar css para o cabeçálio desta nova view
 Inserir antes dos estilos do footer (Rodapé):



```css
/* ============================================
   14. HEADER DE PÁGINAS INTERNAS
   ============================================ */

/* Header Simplificado para Páginas Internas */
.page-header {
    background: var(--gray-900);
    color: white;
    padding: 2rem 1rem;
    text-align: center;
    border-bottom: 3px solid var(--ippls-gold);
    margin-bottom: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

@media (min-width: 768px) {
    .page-header {
        padding: 3rem 1.5rem;
    }
}

.page-header-content {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

@media (min-width: 768px) {
    .page-header-content {
        flex-direction: row;
        justify-content: space-between;
        text-align: left;
    }
}

/* Logo do Header de Página */
.page-header-logo {
    height: 60px;
    width: auto;
    filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
    transition: transform 0.3s ease;
}

@media (min-width: 768px) {
    .page-header-logo {
        height: 80px;
    }
}

.page-header-logo:hover {
    transform: scale(1.05);
}

/* Texto do Header de Página */
.page-header-text h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

@media (min-width: 768px) {
    .page-header-text h1 {
        font-size: 2.25rem;
    }
}

.page-header-text p {
    margin: 0.5rem 0 0 0;
    font-size: 0.875rem;
    color: var(--gray-400);
}

@media (min-width: 768px) {
    .page-header-text p {
        font-size: 1rem;
    }
}
```



### 5. Adicionar Rota no index.php

Edite `index.php` e adicione suporte para múltiplas páginas:
```php
<?php
// index.php - Ponto de entrada e roteamento global

require_once 'config/database.php';

// Captura página e ação da URL
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Roteamento por página
switch ($page) {
    case 'home':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        break;

    case 'products':  // ✅ Nova rota
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        break;

    default:
        http_response_code(404);
        echo "<!DOCTYPE html><html><head><title>404</title></head>";
        echo "<body style='font-family: Arial; text-align: center; padding: 50px;'>";
        echo "<h1 style='color: #C1272D;'>404 - Página não encontrada</h1>";
        echo "<a href='?' style='color: #4A8FC4;'>Voltar para Home</a>";
        echo "</body></html>";
        exit;
}

// Executar ação no controller
switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}
```

Acesse:
- **Home**: `http://localhost/meu-projeto`
- **Produtos**: `http://localhost/meu-projeto?page=products`

## 📚 Próximos Passos

1. ✅ CRUD completo com mensagens flash funcionando
2. 🔄 Adicionar mais modelos (Product, Category, etc.)
3. 🔄 Implementar sistema de autenticação
4. 🔄 Adicionar validações mais robustas
5. 🔄 Implementar upload de arquivos
6. 🔄 Adicionar paginação nas listagens

## 💡 Dicas

### Segurança
- **Sempre use** `htmlspecialchars()` para prevenir XSS
- **Sempre use** prepared statements para prevenir SQL Injection
- **Inicie sessões** no construtor do controller
- **Valide e sanitize** todos os dados de entrada

### Organização
- **Organize** suas views em `views/pages/`
- **Mantenha** a estrutura MVC (Model → Controller → View)
- **Use** as variáveis CSS do IPPLS para manter consistência visual
- **Comente** seu código para facilitar manutenção

### Mensagens Flash
- **Armazene** mensagens na sessão antes de redirecionar
- **Verifique** com `hasMessage()` antes de exibir
- **Limpe** as mensagens com `clearMessage()` após exibição
- **Redirecione** após POST para evitar reenvio de formulário (PRG pattern)

### Padrão PRG (Post-Redirect-Get)
```php
// ✅ Correto: Redirecionar após POST
if ($this->model->create($data)) {
    $this->setMessage('Criado com sucesso!', 'success');
    header('Location: ?page=sua-pagina');
    exit;
}

// ❌ Errado: Não redirecionar após POST
if ($this->model->create($data)) {
    $this->message = 'Criado!'; // Mensagem perdida no refresh
}
$this->index();
```

## ⚠️ Importante

Este template usa **roteamento centralizado** no `index.php`:
- O `index.php` gerencia TODAS as rotas
- Os controllers NÃO têm roteamento interno
- Cada método do controller é uma ação específica
- Use `header('Location: ?page=nome')` após operações POST
- **Sempre inicie sessões** no construtor do controller
- **Sempre limpe mensagens** após exibição na view
- **Use `require`** ao invés de `return` para carregar views

## 🐛 Solução de Problemas

### Mensagens não aparecem
```php
// ✅ Certifique-se de:
// 1. Iniciar sessão no controller
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Verificar existência antes de exibir
if (isset($controller) && $controller->hasMessage()) {
    // exibir mensagem
}

// 3. Limpar após exibição
$controller->clearMessage();
```

### Páginas não aparecem
```php
// ✅ Use require ao invés de return
public function index() {
    $data = $this->model->getAll();
    $controller = $this;
    require __DIR__ . '/../views/pages/suapagina.php'; // ✅
    // return __DIR__ . '/../views/pages/suapagina.php'; // ❌
}
```

### Edição não funciona
```php
// ✅ Verifique se o formulário tem:
// 1. Campo hidden com ID
<input type="hidden" name="id" value="<?= $produto['id'] ?>">

// 2. Action correto
<form method="POST" action="?page=products&action=update">

// 3. Botão de cancelar para voltar
<a href="?page=products" class="btn btn-secondary">CANCELAR</a>
```

---

**Desenvolvido com ❤️ para estudantes do IPPLS**

**Template Base MVC - Aprenda criando!**
MD;
    }


    private function getInstrucoesBase(): string
    {
        return "# Guia de Instalação - Template Base\n\n## 1. Baixar o Template\n## 2. Extrair Arquivos\n## 3. Criar Banco de Dados\n## 4. Configurar Conexão\n## 5. Acessar no Navegador";
    }

    // ==========================================
    // TEMPLATE PADRÃO - CONTEÚDO DOS ARQUIVOS
    // ==========================================

    private function getComposerJson(): string
    {
        return <<<'JSON'
{
    "name": "ippls/template-padrao",
    "description": "Template Padrão MVC Profissional - IPPLS",
    "type": "project",
    "require": {
        "php": "^8.1",
        "laravel/framework": "^11.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    }
}
JSON;
    }

    private function getEnvExample(): string
    {
        return <<<'ENV'
APP_NAME="Projeto IPPLS"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meu_projeto
DB_USERNAME=root
DB_PASSWORD=
ENV;
    }

    private function getWebRoutes(): string
    {
        return <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
PHP;
    }

    private function getApiRoutes(): string
    {
        return <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // API routes here
});
PHP;
    }

    private function getReadmePadrao(): string
    {
        return "# Template Padrão - MVC Profissional\n\n## IPPLS\n\n## Requisitos\n- PHP >= 8.1\n- Composer\n- MySQL\n";
    }

    private function getInstrucoesPadrao(): string
    {
        return "# Guia de Instalação - Template Padrão\n\n## 1. Clonar Projeto\n## 2. Instalar Dependências\n## 3. Configurar Ambiente\n## 4. Rodar Migrações\n## 5. Compilar Assets\n## 6. Iniciar Servidor";
    }

    // ==========================================
    // TEMPLATE AVANÇADO - CONTEÚDO DOS ARQUIVOS
    // ==========================================

    private function getDockerfile(): string
    {
        return <<<'DOCKER'
FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git curl zip unzip

COPY . .

RUN composer install

CMD ["php-fpm"]
DOCKER;
    }

    private function getDockerCompose(): string
    {
        return <<<'YAML'
version: '3.8'

services:
  app:
    build: .
    volumes:
      - .:/var/www
    ports:
      - "8000:8000"

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: projeto_avancado
YAML;
    }

    private function getMakefile(): string
    {
        return <<<'MAKE'
up:
	docker-compose up -d

down:
	docker-compose down

test:
	php artisan test
MAKE;
    }

    private function getGitlabCi(): string
    {
        return <<<'YAML'
stages:
  - test
  - deploy

test:
  stage: test
  script:
    - composer install
    - php artisan test
YAML;
    }

    private function getReadmeAvancado(): string
    {
        return "# Template Avançado - Arquitetura Enterprise\n\n## IPPLS\n\n## Requisitos\n- PHP >= 8.2\n- Docker\n- Redis\n";
    }

    private function getInstrucoesAvancado(): string
    {
        return "# Guia de Instalação - Template Avançado\n\n## 1. Preparar Ambiente\n## 2. Subir Containers\n## 3. Rodar Setup\n## 4. Ativar Observabilidade\n## 5. Desenvolvimento";
    }
}
