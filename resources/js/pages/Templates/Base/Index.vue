<script setup lang="ts">
import AppFooter from '@/components/AppFooter.vue';
import BackToTop from '@/components/BackToTop.vue';
import Navbar from '@/components/Navbar.vue';
import BackgroundGradient from '@/components/ui/background-gradient/BackgroundGradient.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    AlertCircle,
    ArrowRight,
    Book,
    Box,
    Check,
    CheckCircle2,
    ChevronRight,
    CloudDownload,
    Code2,
    Copy,
    Database,
    Download,
    ExternalLink,
    Eye,
    FileCode,
    FileText,
    Folder,
    FolderOpen,
    GitBranch,
    Github,
    Home,
    Layers,
    Package,
    Play,
    Server,
    Settings,
    Shield,
    Star,
    Target,
    Terminal,
    Zap,
} from 'lucide-vue-next';
import { onMounted, ref, type Component } from 'vue';

const iconRegistry = {
    FileCode,
    Download,
    Folder,
    FolderOpen,
    Code2,
    Database,
    Eye,
    Settings,
    CheckCircle2,
    ArrowRight,
    Terminal,
    Play,
    Book,
    Layers,
    Box,
    GitBranch,
    Package,
    ChevronRight,
    Copy,
    Check,
    Zap,
    Shield,
    Star,
    Target,
    AlertCircle,
    FileText,
    Server,
    CloudDownload,
    Github,
    ExternalLink,
    Home,
} as const;

type IconName = keyof typeof iconRegistry;
type IconSource = IconName | Component;

interface DirectoryPayload {
    name: string;
    icon?: IconSource;
    level?: number;
    type?: 'folder' | 'file';
    description?: string;
}

interface DirectoryItem extends Omit<DirectoryPayload, 'icon' | 'level' | 'type'> {
    icon: Component;
    level: number;
    type: 'folder' | 'file';
}

interface FeaturePayload {
    icon?: IconSource;
    title: string;
    description: string;
}

interface FeatureItem extends Omit<FeaturePayload, 'icon'> {
    icon: Component;
}

type TabKey = 'overview' | 'structure' | 'installation' | 'code';

const resolveIcon = (icon: IconSource | undefined, fallback: Component): Component => {
    if (!icon) {
        return fallback;
    }

    if (typeof icon === 'string') {
        return iconRegistry[icon as IconName] ?? fallback;
    }

    return icon;
};

const defaultFeatures: FeatureItem[] = [
    {
        icon: Layers,
        title: 'Estrutura MVC Básica',
        description: 'Separação clara entre Models, Views e Controllers para projetos simples e diretos.',
    },
    {
        icon: Zap,
        title: 'Setup Rápido',
        description: 'Configure seu projeto em menos de 5 minutos com estrutura pré-definida.',
    },
    {
        icon: Book,
        title: 'Fácil de Aprender',
        description: 'Ideal para iniciantes aprenderem os conceitos fundamentais do MVC.',
    },
    {
        icon: Shield,
        title: 'Segurança Básica',
        description: 'Proteção essencial com configurações de segurança pré-estabelecidas.',
    },
];

const defaultDirectoryStructure: DirectoryItem[] = [
    { name: 'projeto_base/', icon: Folder, level: 0, type: 'folder' },
    { name: 'index.php', icon: FileCode, level: 1, type: 'file', description: 'Ponto de entrada da aplicação' },
    { name: 'favicon.ico', icon: Star, level: 1, type: 'file', description: 'Ícone do site' },
    { name: 'config/', icon: FolderOpen, level: 1, type: 'folder' },
    { name: 'database.php', icon: Database, level: 2, type: 'file', description: 'Configuração do banco de dados' },
    { name: 'models/', icon: FolderOpen, level: 1, type: 'folder' },
    { name: 'User.php', icon: FileCode, level: 2, type: 'file', description: 'Model de exemplo' },
    { name: 'views/', icon: FolderOpen, level: 1, type: 'folder' },
    { name: 'pages/', icon: FolderOpen, level: 2, type: 'folder' },
    { name: 'home.php', icon: Eye, level: 3, type: 'file', description: 'View inicial' },
    { name: 'controllers/', icon: FolderOpen, level: 1, type: 'folder' },
    { name: 'HomeController.php', icon: Code2, level: 2, type: 'file', description: 'Controller de exemplo' },
    { name: 'assets/', icon: FolderOpen, level: 1, type: 'folder' },
    { name: 'css/', icon: FolderOpen, level: 2, type: 'folder' },
    { name: 'style.css', icon: FileCode, level: 3, type: 'file', description: 'Folha de estilos' },
    { name: 'js/', icon: FolderOpen, level: 2, type: 'folder' },
    { name: 'main.js', icon: FileCode, level: 3, type: 'file', description: 'Script javascript' },
    { name: 'images/', icon: FolderOpen, level: 2, type: 'folder' },
    { name: 'logo/', icon: FolderOpen, level: 3, type: 'folder' },
    { name: 'ippls-logo-removebg-preview.png', icon: FileCode, level: 4, type: 'file', description: 'Logo do IPPLS' },
    { name: 'README.md', icon: FileText, level: 1, type: 'file', description: 'Documentação do projeto' },
];

const activeTab = ref<TabKey>('overview');
const copiedCode = ref<string | null>(null);
const features = ref<FeatureItem[]>(defaultFeatures);
const directoryStructure = ref<DirectoryItem[]>(defaultDirectoryStructure);

const props = defineProps<{
    template?: {
        estrutura_diretorios?: DirectoryPayload[];
        features?: FeaturePayload[];
    };
}>();

const copyToClipboard = (text: string, id: string) => {
    navigator.clipboard.writeText(text);
    copiedCode.value = id;
    setTimeout(() => {
        copiedCode.value = null;
    }, 2000);
};

onMounted(() => {
    if (props.template?.estrutura_diretorios?.length) {
        directoryStructure.value = props.template.estrutura_diretorios.map((item) => {
            const level = typeof item.level === 'number' ? item.level : 0;
            const type = item.type === 'folder' ? 'folder' : 'file';
            const fallbackIcon = type === 'folder' ? Folder : FileCode;

            return {
                name: item.name,
                description: item.description,
                level,
                type,
                icon: resolveIcon(item.icon, fallbackIcon),
            };
        });
    }

    if (props.template?.features?.length) {
        features.value = props.template.features.map((item) => ({
            title: item.title,
            description: item.description,
            icon: resolveIcon(item.icon, Layers),
        }));
    }
});

const installationSteps = [
    {
        step: '01',
        title: 'Baixar o Template',
        description: 'Podes Baixar o Template Base MVC através da plataforma ou GitHub',
        icon: CloudDownload,
        color: 'from-[#4A8FC4] to-[#6BA3D4]',
    },
    {
        step: '02',
        title: 'Extrair Arquivos',
        description: 'Descompacte o arquivo ZIP na pasta do seu servidor web (htdocs, www, public_html)',
        icon: Package,
        color: 'from-[#F4B41A] to-[#F7C950]',
    },
    {
        step: '03',
        title: 'Configurar Banco de Dados',
        description:
            'Edite o arquivo config/database.php com suas credenciais do MySQL. Crie uma tabela Users com o código sql e dados iniciais no README.md',
        icon: Database,
        color: 'from-[#C1272D] to-[#E04850]',
    },
    {
        step: '04',
        title: 'Iniciar Desenvolvimento',
        description: 'Abra o navegador e acesse localhost/seu-projeto para começar',
        icon: Zap,
        color: 'from-[#2B4C7E] to-[#567FA6]',
    },
];

const codeExamples = {
    index: `<?php
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
}`,

    config: `<?php
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
}`,

    model: `<?php
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
}`,

    controller: `<?php
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
}`,

    view: `<!DOCTYPE html>
<!-- views/home.php - View principal -->
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

    <script src="assets/js/main.js"><\/script>
</body>
</html>`,
};

const requirements = [
    { name: 'PHP', version: '>= 7.4', icon: FileCode },
    { name: 'MySQL', version: '>= 5.7', icon: Database },
    { name: 'Apache/Nginx', version: 'Qualquer', icon: Server },
    { name: 'Conhecimento', version: 'Básico de PHP', icon: Book },
];

const benefits = [
    'Estrutura simples e intuitiva para iniciantes',
    'Separação clara de responsabilidades (MVC)',
    'Fácil manutenção e expansão do código',
    'Ideal para projetos acadêmicos pequenos',
    'Documentação completa incluída',
    'Exemplos práticos de uso',
];

const useCases = [
    {
        title: 'Sistemas de Cadastro',
        description: 'CRUD básico para gerenciar usuários, produtos ou qualquer entidade',
        icon: Database,
    },
    {
        title: 'Páginas Dinâmicas',
        description: 'Sites com conteúdo dinâmico proveniente de banco de dados',
        icon: Eye,
    },
    {
        title: 'Blogs Simples',
        description: 'Sistemas de publicação de artigos com categorias',
        icon: FileText,
    },
    {
        title: 'Portfólios',
        description: 'Páginas pessoais com projetos e informações',
        icon: Star,
    },
];

const errorMessage = ref<string | null>(null);
</script>

<template>
    <Head title="Template Base MVC - IPPLS" />
    <div class="min-h-screen bg-white bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center dark:bg-[#010226]">
        <Navbar />

        <!-- Flash Messages -->
        <div v-if="errorMessage" class="fixed top-20 right-4 z-50 w-full max-w-sm">
            <div class="rounded-lg border border-red-200 bg-red-50 p-4 shadow-lg dark:border-red-800 dark:bg-red-900/20">
                <div class="flex items-start space-x-3">
                    <AlertCircle class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-500 dark:text-red-400" :stroke-width="2" />
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">
                            {{ errorMessage }}
                        </p>
                    </div>
                    <button @click="errorMessage = null" class="text-red-400 transition-colors hover:text-red-600">
                        <X class="h-4 w-4" :stroke-width="2" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <section
            class="relative overflow-hidden bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center px-4 pt-32 pb-20 sm:px-6 lg:px-8 dark:bg-[#010226]"
        >
            <!-- Background Elements -->
            <div class="absolute inset-0 opacity-[0.015] dark:opacity-[0.08]">
                <div
                    class="absolute inset-0"
                    style="
                        background-image:
                            linear-gradient(rgba(74, 143, 196, 0.15) 1px, transparent 1px),
                            linear-gradient(90deg, rgba(74, 143, 196, 0.15) 1px, transparent 1px);
                        background-size: 80px 80px;
                    "
                ></div>
            </div>

            <div class="relative z-10 mx-auto max-w-7xl">
                <!-- Breadcrumb -->
                <div class="mb-8 flex items-center space-x-2 text-sm">
                    <Link
                        :href="route('home')"
                        class="text-[#656d76] transition-colors hover:text-[#2B4C7E] dark:text-[#7d8590] dark:hover:text-[#6BA3D4]"
                    >
                        <Home class="h-4 w-4" :stroke-width="2" />
                    </Link>
                    <ChevronRight class="h-4 w-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                    <span class="text-[#656d76] dark:text-[#7d8590]">Templates</span>
                    <ChevronRight class="h-4 w-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                    <span class="font-medium text-[#24292f] dark:text-[#e6edf3]">Base MVC</span>
                </div>

                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <!-- Left Content -->
                    <div class="space-y-8">
                        <div
                            class="inline-flex items-center space-x-2 rounded-full border border-[#4A8FC4]/20 bg-[#4A8FC4]/10 px-4 py-2 dark:border-[#4A8FC4]/30 dark:bg-[#4A8FC4]/20"
                        >
                            <Layers class="h-4 w-4 text-[#4A8FC4]" :stroke-width="2.5" />
                            <span class="text-sm font-semibold text-[#4A8FC4]">TEMPLATE BASE</span>
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-4xl leading-tight font-black text-[#24292f] sm:text-5xl lg:text-6xl dark:text-[#e6edf3]">
                                Template Base
                                <span class="mt-2 block bg-gradient-to-r from-[#4A8FC4] to-[#6BA3D4] bg-clip-text text-transparent">
                                    MVC Simplificado
                                </span>
                            </h1>

                            <p class="text-lg leading-relaxed text-[#656d76] dark:text-[#7d8590]">
                                Estrutura MVC fundamental e direta para iniciantes. Aprenda os conceitos básicos de arquitetura de software com uma
                                estrutura simples e bem organizada.
                            </p>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <a
                                :href="route('templates.base.download')"
                                class="group inline-flex items-center justify-center space-x-2 rounded-lg bg-gradient-to-r from-[#4A8FC4] to-[#6BA3D4] px-6 py-3 font-semibold text-white transition-all hover:shadow-lg"
                            >
                                <CloudDownload class="h-5 w-5" :stroke-width="2.5" />
                                <span>Baixar Template</span>
                                <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" :stroke-width="2.5" />
                            </a>

                            <a
                                href="https://github.com/Ngola-develop/arquitetura-de-projetos-ippls"
                                target="_blank"
                                class="inline-flex items-center justify-center space-x-2 rounded-lg border border-[#d0d7de] bg-white px-6 py-3 font-semibold text-[#24292f] transition-all hover:border-[#4A8FC4] dark:border-[#30363d] dark:bg-[#0d1117] dark:text-[#e6edf3] dark:hover:border-[#6BA3D4]"
                            >
                                <Github class="h-5 w-5" :stroke-width="2.5" />
                                <span>Ver no GitHub</span>
                            </a>
                        </div>

                        <!-- Quick Stats -->
                        <div class="flex flex-wrap gap-4 pt-4">
                            <div
                                class="flex items-center space-x-2 rounded-lg border border-[#d0d7de] bg-[#f6f8fa] px-4 py-2 dark:border-[#30363d] dark:bg-[#161b22]"
                            >
                                <CheckCircle2 class="h-4 w-4 text-[#4A8FC4]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">Setup em 5 min</span>
                            </div>
                            <div
                                class="flex items-center space-x-2 rounded-lg border border-[#d0d7de] bg-[#f6f8fa] px-4 py-2 dark:border-[#30363d] dark:bg-[#161b22]"
                            >
                                <Star class="h-4 w-4 fill-[#F4B41A] text-[#F4B41A]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">Para Iniciantes</span>
                            </div>
                            <div
                                class="flex items-center space-x-2 rounded-lg border border-[#d0d7de] bg-[#f6f8fa] px-4 py-2 dark:border-[#30363d] dark:bg-[#161b22]"
                            >
                                <Shield class="h-4 w-4 text-[#2B4C7E]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">100% Gratuito</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Visual -->
                    <div class="relative">
                        <div class="relative rounded-xl border border-[#d0d7de] bg-[#f6f8fa] p-6 shadow-lg dark:border-[#30363d] dark:bg-[#161b22]">
                            <!-- Directory Preview -->
                            <div class="space-y-1 font-mono text-sm">
                                <div
                                    v-for="(item, index) in directoryStructure.slice(0, 10)"
                                    :key="index"
                                    class="flex items-center space-x-2 py-1.5"
                                    :style="{ paddingLeft: item.level * 20 + 'px' }"
                                >
                                    <component
                                        :is="item.icon"
                                        class="h-4 w-4 flex-shrink-0"
                                        :class="item.type === 'folder' ? 'text-[#4A8FC4]' : 'text-[#656d76] dark:text-[#7d8590]'"
                                        :stroke-width="2"
                                    />
                                    <span class="text-[#24292f] dark:text-[#e6edf3]">{{ item.name }}</span>
                                </div>
                                <div class="flex items-center space-x-2 py-1.5 pl-5 text-[#656d76] dark:text-[#7d8590]">
                                    <span>...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Badge -->
                        <div
                            class="absolute -top-4 -right-4 rotate-3 transform rounded-lg bg-gradient-to-br from-[#4A8FC4] to-[#6BA3D4] p-3 shadow-lg"
                        >
                            <Layers class="h-6 w-6 text-white" :stroke-width="2.5" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            class="bg-[#f6f8fa] bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center px-4 py-16 sm:px-6 lg:px-8 dark:bg-[#010226]"
        >
            <!-- Links de outros templates -->
            <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                <Link
                    :href="route('templates.padrao')"
                    class="group inline-flex items-center justify-center space-x-2 rounded-lg bg-[#4A8FC4] px-6 py-3 font-semibold text-white transition-all hover:bg-ippls-blue-dark hover:shadow-lg"
                >
                    <Eye class="h-5 w-5" :stroke-width="2.5" />
                    <span>Ver Template Padrão</span>
                    <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" :stroke-width="2.5" />
                </Link>

                <Link
                    :href="route('templates.avancado')"
                    target="_blank"
                    class="inline-flex items-center justify-center space-x-2 rounded-lg border border-[#d0d7de] bg-white bg-none px-6 py-3 text-sm font-semibold text-[#24292f] shadow-md shadow-ippls-blue-dark transition-all hover:border-[#4A8FC4] hover:bg-ippls-blue-dark hover:text-white hover:shadow-lg dark:border-[#30363d] dark:bg-[#0d1117] dark:text-[#e6edf3] dark:hover:border-[#6BA3D4]"
                >
                    <Eye class="h-5 w-5" :stroke-width="2.5" />
                    <span>Ver Template Avançado</span>
                    <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" :stroke-width="2.5" />
                </Link>
            </div>
        </section>

        <!-- Features Section -->
        <section
            class="bg-[#f6f8fa] bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center px-4 py-16 sm:px-6 lg:px-8 dark:bg-[#010226]"
        >
            <div class="mx-auto max-w-7xl">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-[#24292f] sm:text-4xl dark:text-[#e6edf3]">Por que escolher o Template Base?</h2>
                    <p class="text-lg text-[#656d76] dark:text-[#7d8590]">Ideal para quem está começando no desenvolvimento MVC</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="rounded-lg border border-[#d0d7de] bg-white p-6 transition-all hover:border-[#4A8FC4] hover:shadow-md dark:border-[#30363d] dark:bg-[#0d1117] dark:hover:border-[#6BA3D4]"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-[#4A8FC4] to-[#6BA3D4]">
                            <component :is="feature.icon" class="h-6 w-6 text-white" :stroke-width="2" />
                        </div>
                        <h3 class="mb-2 text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">
                            {{ feature.title }}
                        </h3>
                        <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                            {{ feature.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content Tabs -->
        <section class="px-4 py-16 sm:px-6 lg:px-8 bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center dark:bg-[#010226]">
            <div class="mx-auto max-w-7xl">
                <!-- Tab Navigation -->
                <div class="mb-8 flex flex-wrap gap-2 border-b border-[#d0d7de] dark:border-[#30363d]">
                    <button
                        @click="activeTab = 'overview'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'overview'
                                ? 'border-b-2 border-[#4A8FC4] text-[#4A8FC4]'
                                : 'text-[#656d76] hover:text-[#24292f] dark:text-[#7d8590] dark:hover:text-[#e6edf3]',
                        ]"
                    >
                        Visão Geral
                    </button>
                    <button
                        @click="activeTab = 'structure'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'structure'
                                ? 'border-b-2 border-[#4A8FC4] text-[#4A8FC4]'
                                : 'text-[#656d76] hover:text-[#24292f] dark:text-[#7d8590] dark:hover:text-[#e6edf3]',
                        ]"
                    >
                        Estrutura
                    </button>
                    <button
                        @click="activeTab = 'installation'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'installation'
                                ? 'border-b-2 border-[#4A8FC4] text-[#4A8FC4]'
                                : 'text-[#656d76] hover:text-[#24292f] dark:text-[#7d8590] dark:hover:text-[#e6edf3]',
                        ]"
                    >
                        Instalação
                    </button>
                    <button
                        @click="activeTab = 'code'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'code'
                                ? 'border-b-2 border-[#4A8FC4] text-[#4A8FC4]'
                                : 'text-[#656d76] hover:text-[#24292f] dark:text-[#7d8590] dark:hover:text-[#e6edf3]',
                        ]"
                    >
                        Exemplos de Código
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="mt-8">
                    <!-- Overview Tab -->
                    <div v-show="activeTab === 'overview'" class="space-y-8">
                        <div class="grid gap-8 lg:grid-cols-2">
                            <!-- Requirements -->
                            <div class="rounded-lg border border-[#d0d7de] bg-white p-6 dark:border-[#30363d] dark:bg-[#0d1117]">
                                <h3 class="mb-4 flex items-center space-x-2 text-xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                                    <AlertCircle class="h-5 w-5 text-[#4A8FC4]" :stroke-width="2" />
                                    <span>Requisitos</span>
                                </h3>
                                <div class="space-y-3">
                                    <div
                                        v-for="req in requirements"
                                        :key="req.name"
                                        class="flex items-center justify-between rounded-lg bg-[#f6f8fa] p-3 dark:bg-[#161b22]"
                                    >
                                        <div class="flex items-center space-x-3">
                                            <component :is="req.icon" class="h-5 w-5 text-[#4A8FC4]" :stroke-width="2" />
                                            <span class="font-medium text-[#24292f] dark:text-[#e6edf3]">{{ req.name }}</span>
                                        </div>
                                        <span class="text-sm text-[#656d76] dark:text-[#7d8590]">{{ req.version }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Benefits -->
                            <div class="rounded-lg border border-[#d0d7de] bg-white p-6 dark:border-[#30363d] dark:bg-[#0d1117]">
                                <h3 class="mb-4 flex items-center space-x-2 text-xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                                    <Star class="h-5 w-5 fill-[#F4B41A] text-[#F4B41A]" :stroke-width="2" />
                                    <span>Benefícios</span>
                                </h3>
                                <ul class="space-y-3">
                                    <li v-for="benefit in benefits" :key="benefit" class="flex items-start space-x-3">
                                        <CheckCircle2 class="mt-0.5 h-5 w-5 flex-shrink-0 text-[#4A8FC4]" :stroke-width="2" />
                                        <span class="text-[#24292f] dark:text-[#c9d1d9]">{{ benefit }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Use Cases -->
                        <div>
                            <h3 class="mb-6 text-2xl font-bold text-[#24292f] dark:text-[#e6edf3]">Casos de Uso</h3>
                            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                                <div
                                    v-for="useCase in useCases"
                                    :key="useCase.title"
                                    class="rounded-lg border border-[#d0d7de] bg-white p-5 transition-all hover:border-[#4A8FC4] dark:border-[#30363d] dark:bg-[#0d1117] dark:hover:border-[#6BA3D4]"
                                >
                                    <component :is="useCase.icon" class="mb-3 h-8 w-8 text-[#4A8FC4]" :stroke-width="2" />
                                    <h4 class="mb-2 font-bold text-[#24292f] dark:text-[#e6edf3]">{{ useCase.title }}</h4>
                                    <p class="text-sm text-[#656d76] dark:text-[#7d8590]">{{ useCase.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Structure Tab -->
                    <div v-show="activeTab === 'structure'" class="space-y-6">
                        <div class="rounded-lg border border-[#d0d7de] bg-white p-6 dark:border-[#30363d] dark:bg-[#0d1117]">
                            <h3 class="mb-6 text-xl font-bold text-[#24292f] dark:text-[#e6edf3]">Estrutura de Diretórios Completa</h3>
                            <div class="space-y-1 font-mono text-sm">
                                <div
                                    v-for="(item, index) in directoryStructure"
                                    :key="index"
                                    class="group flex items-start space-x-3 rounded px-3 py-2 transition-colors hover:bg-[#f6f8fa] dark:hover:bg-[#161b22]"
                                    :style="{ paddingLeft: item.level * 24 + 12 + 'px' }"
                                >
                                    <component
                                        :is="item.icon"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        :class="item.type === 'folder' ? 'text-[#4A8FC4]' : 'text-[#656d76] dark:text-[#7d8590]'"
                                        :stroke-width="2"
                                    />
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-[#24292f] dark:text-[#e6edf3]">{{ item.name }}</span>
                                        </div>
                                        <p v-if="item.description" class="mt-1 text-xs text-[#656d76] dark:text-[#7d8590]">{{ item.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Architecture Explanation -->
                        <div class="grid gap-6 md:grid-cols-3">
                            <div class="rounded-lg border border-[#d0d7de] bg-white p-6 dark:border-[#30363d] dark:bg-[#0d1117]">
                                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-[#C1272D] to-[#E04850]">
                                    <Database class="h-6 w-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="mb-2 text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">Models</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Gerenciam os dados e a lógica de negócio. Contêm as classes que interagem com o banco de dados.
                                </p>
                            </div>

                            <div class="rounded-lg border border-[#d0d7de] bg-white p-6 dark:border-[#30363d] dark:bg-[#0d1117]">
                                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-[#4A8FC4] to-[#6BA3D4]">
                                    <Eye class="h-6 w-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="mb-2 text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">Views</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Responsáveis pela apresentação. Arquivos HTML/PHP que exibem os dados para o usuário.
                                </p>
                            </div>

                            <div class="rounded-lg border border-[#d0d7de] bg-white p-6 dark:border-[#30363d] dark:bg-[#0d1117]">
                                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-[#F4B41A] to-[#F7C950]">
                                    <Code2 class="h-6 w-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="mb-2 text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">Controllers</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Intermediários entre Models e Views. Processam requisições e retornam respostas.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Installation Tab -->
                    <div v-show="activeTab === 'installation'" class="space-y-8">
                        <div
                            class="rounded-lg border border-[#4A8FC4]/20 bg-gradient-to-r from-[#4A8FC4]/10 to-[#6BA3D4]/10 p-6 dark:border-[#6BA3D4]/30"
                        >
                            <div class="flex items-start space-x-4">
                                <AlertCircle class="mt-1 h-6 w-6 flex-shrink-0 text-[#4A8FC4]" :stroke-width="2" />
                                <div>
                                    <h4 class="mb-2 text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">Antes de começar</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">
                                        Certifique-se de ter um servidor web local instalado (XAMPP, WAMP, MAMP ou similar) e um navegador moderno.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div v-for="step in installationSteps" :key="step.step" class="relative">
                                <div
                                    class="h-full rounded-lg border border-[#d0d7de] bg-white p-6 transition-all hover:border-[#4A8FC4] dark:border-[#30363d] dark:bg-[#0d1117] dark:hover:border-[#6BA3D4]"
                                >
                                    <div class="mb-4 flex items-start space-x-4">
                                        <div
                                            :class="[
                                                'flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br',
                                                step.color,
                                            ]"
                                        >
                                            <component :is="step.icon" class="h-6 w-6 text-white" :stroke-width="2" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="mb-2 text-3xl font-bold text-[#4A8FC4]/30 dark:text-[#6BA3D4]/30">{{ step.step }}</div>
                                            <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">{{ step.title }}</h4>
                                        </div>
                                    </div>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">{{ step.description }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Installation Guide -->
                        <div class="rounded-lg border border-[#d0d7de] bg-white p-6 dark:border-[#30363d] dark:bg-[#0d1117]">
                            <h3 class="mb-6 flex items-center space-x-2 text-xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                                <Terminal class="h-5 w-5 text-[#4A8FC4]" :stroke-width="2" />
                                <span>Guia Detalhado de Instalação</span>
                            </h3>

                            <div class="space-y-6">
                                <!-- Step 1 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">1. Baixar o Template</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">
                                        Baixe o template através da plataforma IPPLS ou diretamente do GitHub:
                                    </p>
                                    <div
                                        class="rounded-lg border border-[#d0d7de] bg-[#f6f8fa] p-4 font-mono text-sm dark:border-[#30363d] dark:bg-[#161b22]"
                                    >
                                        <div class="mb-2 flex items-center justify-between">
                                            <span class="text-[#656d76] dark:text-[#7d8590]">Terminal</span>
                                            <button
                                                @click="
                                                    copyToClipboard(
                                                        'git clone https://github.com/Ngola-develop/arquitetura-de-projetos-ippls/template-base-mvc.git',
                                                        'git1',
                                                    )
                                                "
                                                class="text-[#656d76] transition-colors hover:text-[#4A8FC4] dark:text-[#7d8590]"
                                            >
                                                <component :is="copiedCode === 'git1' ? Check : Copy" class="h-4 w-4" :stroke-width="2" />
                                            </button>
                                        </div>
                                        <code class="text-[#24292f] dark:text-[#e6edf3]"
                                            >https://github.com/Ngola-develop/arquitetura-de-projetos-ippls/template-base-mvc.git</code
                                        >
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">2. Mover para Pasta do Servidor</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Mova ou extraia os arquivos para a pasta do seu servidor web:</p>
                                    <ul class="ml-4 list-inside list-disc space-y-1 text-[#656d76] dark:text-[#7d8590]">
                                        <li><strong>XAMPP:</strong> C:\xampp\htdocs\seu-projeto</li>
                                        <li><strong>WAMP:</strong> C:\wamp64\www\seu-projeto</li>
                                        <li><strong>MAMP:</strong> /Applications/MAMP/htdocs/seu-projeto</li>
                                    </ul>
                                </div>

                                <!-- Step 3 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">3. Criar Banco de Dados</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Acesse o phpMyAdmin e crie um novo banco de dados:</p>
                                    <div
                                        class="rounded-lg border border-[#d0d7de] bg-[#f6f8fa] p-4 font-mono text-sm dark:border-[#30363d] dark:bg-[#161b22]"
                                    >
                                        <div class="mb-2 flex items-center justify-between">
                                            <span class="text-[#656d76] dark:text-[#7d8590]">SQL</span>
                                            <button
                                                @click="
                                                    copyToClipboard(
                                                        'CREATE DATABASE meu_projeto_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;',
                                                        'sql1',
                                                    )
                                                "
                                                class="text-[#656d76] transition-colors hover:text-[#4A8FC4] dark:text-[#7d8590]"
                                            >
                                                <component :is="copiedCode === 'sql1' ? Check : Copy" class="h-4 w-4" :stroke-width="2" />
                                            </button>
                                        </div>
                                        <code class="text-[#24292f] dark:text-[#e6edf3]"
                                            >CREATE DATABASE meu_projeto_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</code
                                        >
                                    </div>
                                </div>
                                <!-- Step 4 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">4. Criar Tabela Users</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Acesse o banco de dados e crie uma tabela com dados inicial:</p>
                                    <div
                                        class="rounded-lg border border-[#d0d7de] bg-[#f6f8fa] p-4 font-mono text-sm dark:border-[#30363d] dark:bg-[#161b22]"
                                    >
                                        <div class="mb-2 flex items-center justify-between">
                                            <span class="text-[#656d76] dark:text-[#7d8590]">SQL</span>
                                            <button
                                                @click="
                                                    copyToClipboard(
                                                        `CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL UNIQUE, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP); INSERT INTO users (name, email) VALUES('Pai Grande Ngola', 'paigrandengola@ippls.edu.ao'), ('Professor Lengo Júnior', 'lengojunior@ippls.edu.ao'), ('Eng. Vanilson Manuel', 'vanilsonmanuel@ippls.edu.ao');`,
                                                        'sql2',
                                                    )
                                                "
                                                class="text-[#656d76] transition-colors hover:text-[#4A8FC4] dark:text-[#7d8590]"
                                            >
                                                <component :is="copiedCode === 'sql2' ? Check : Copy" class="h-4 w-4" :stroke-width="2" />
                                            </button>
                                        </div>
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">
                                            CREATE TABLE users (<br />
                                            id INT AUTO_INCREMENT PRIMARY KEY,<br />
                                            name VARCHAR(100) NOT NULL,<br />
                                            email VARCHAR(100) NOT NULL UNIQUE,<br />
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ); <br /><br />

                                            INSERT INTO users (name, email) VALUES<br />
                                            ('Pai Grande Ngola', 'paigrandengola@ippls.edu.ao'),<br />
                                            ('Professor Lengo Júnior', 'lengojunior@ippls.edu.ao'),<br />
                                            ('Eng. Vanilson Manuel', 'vanilsonmanuel@ippls.edu.ao');<br />
                                        </code>
                                    </div>
                                </div>

                                <!-- Step 5 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">5. Configurar Conexão</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">
                                        Edite o arquivo
                                        <code
                                            class="rounded bg-[#f6f8fa] px-2 py-1 font-mono text-sm text-[#24292f] dark:bg-[#161b22] dark:text-[#e6edf3]"
                                            >config/database.php</code
                                        >
                                        com suas credenciais:
                                    </p>
                                    <div class="rounded-lg border border-[#d0d7de] bg-[#f6f8fa] p-4 dark:border-[#30363d] dark:bg-[#161b22]">
                                        <pre class="overflow-x-auto text-sm text-[#24292f] dark:text-[#e6edf3]"><code>define('DB_HOST', 'localhost');
define('DB_NAME', 'meu_projeto_base');
define('DB_USER', 'root');
define('DB_PASS', '');</code></pre>
                                    </div>
                                </div>

                                <!-- Step 6 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">6. Acessar no Navegador</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Abra seu navegador e acesse:</p>
                                    <div
                                        class="rounded-lg border border-[#d0d7de] bg-[#f6f8fa] p-4 font-mono text-sm dark:border-[#30363d] dark:bg-[#161b22]"
                                    >
                                        <code class="text-[#4A8FC4]">http://localhost/seu-projeto</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Code Examples Tab -->
                    <div v-show="activeTab === 'code'" class="space-y-6">
                        <!-- Index.php -->
                        <div class="overflow-hidden rounded-lg border border-[#d0d7de] bg-white dark:border-[#30363d] dark:bg-[#0d1117]">
                            <div
                                class="flex items-center justify-between border-b border-[#d0d7de] bg-[#f6f8fa] px-6 py-3 dark:border-[#30363d] dark:bg-[#161b22]"
                            >
                                <div class="flex items-center space-x-2">
                                    <FileCode class="h-4 w-4 text-[#4A8FC4]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">index.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.index, 'index')"
                                    class="text-[#656d76] transition-colors hover:text-[#4A8FC4] dark:text-[#7d8590]"
                                >
                                    <component :is="copiedCode === 'index' ? Check : Copy" class="h-4 w-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="overflow-x-auto p-6">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.index }}</code></pre>
                            </div>
                        </div>

                        <!-- Config -->
                        <div class="overflow-hidden rounded-lg border border-[#d0d7de] bg-white dark:border-[#30363d] dark:bg-[#0d1117]">
                            <div
                                class="flex items-center justify-between border-b border-[#d0d7de] bg-[#f6f8fa] px-6 py-3 dark:border-[#30363d] dark:bg-[#161b22]"
                            >
                                <div class="flex items-center space-x-2">
                                    <Database class="h-4 w-4 text-[#C1272D]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">config/database.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.config, 'config')"
                                    class="text-[#656d76] transition-colors hover:text-[#4A8FC4] dark:text-[#7d8590]"
                                >
                                    <component :is="copiedCode === 'config' ? Check : Copy" class="h-4 w-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="overflow-x-auto p-6">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.config }}</code></pre>
                            </div>
                        </div>

                        <!-- Model -->
                        <div class="overflow-hidden rounded-lg border border-[#d0d7de] bg-white dark:border-[#30363d] dark:bg-[#0d1117]">
                            <div
                                class="flex items-center justify-between border-b border-[#d0d7de] bg-[#f6f8fa] px-6 py-3 dark:border-[#30363d] dark:bg-[#161b22]"
                            >
                                <div class="flex items-center space-x-2">
                                    <Database class="h-4 w-4 text-[#F4B41A]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">models/User.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.model, 'model')"
                                    class="text-[#656d76] transition-colors hover:text-[#4A8FC4] dark:text-[#7d8590]"
                                >
                                    <component :is="copiedCode === 'model' ? Check : Copy" class="h-4 w-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="overflow-x-auto p-6">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.model }}</code></pre>
                            </div>
                        </div>

                        <!-- Controller -->
                        <div class="overflow-hidden rounded-lg border border-[#d0d7de] bg-white dark:border-[#30363d] dark:bg-[#0d1117]">
                            <div
                                class="flex items-center justify-between border-b border-[#d0d7de] bg-[#f6f8fa] px-6 py-3 dark:border-[#30363d] dark:bg-[#161b22]"
                            >
                                <div class="flex items-center space-x-2">
                                    <Code2 class="h-4 w-4 text-[#2B4C7E]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">controllers/HomeController.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.controller, 'controller')"
                                    class="text-[#656d76] transition-colors hover:text-[#4A8FC4] dark:text-[#7d8590]"
                                >
                                    <component :is="copiedCode === 'controller' ? Check : Copy" class="h-4 w-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="overflow-x-auto p-6">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.controller }}</code></pre>
                            </div>
                        </div>

                        <!-- View -->
                        <div class="overflow-hidden rounded-lg border border-[#d0d7de] bg-white dark:border-[#30363d] dark:bg-[#0d1117]">
                            <div
                                class="flex items-center justify-between border-b border-[#d0d7de] bg-[#f6f8fa] px-6 py-3 dark:border-[#30363d] dark:bg-[#161b22]"
                            >
                                <div class="flex items-center space-x-2">
                                    <Eye class="h-4 w-4 text-[#4A8FC4]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">views/home.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.view, 'view')"
                                    class="text-[#656d76] transition-colors hover:text-[#4A8FC4] dark:text-[#7d8590]"
                                >
                                    <component :is="copiedCode === 'view' ? Check : Copy" class="h-4 w-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="overflow-x-auto p-6">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.view }}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="relative isolate overflow-hidden bg-gray-900">
            <!-- Background gradient -->
            <BackgroundGradient />
            <section class="px-4 py-20 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-4xl space-y-8 text-center">
                    <h2 class="text-3xl font-bold text-white sm:text-4xl lg:text-5xl">Pronto para começar?</h2>
                    <p class="text-xl text-white/90">Baixe o Template Base MVC e comece seu primeiro projeto estruturado hoje mesmo!</p>
                    <div class="flex flex-col justify-center gap-4 sm:flex-row">
                        <a
                            :href="route('templates.base.download')"
                            class="group inline-flex items-center justify-center space-x-2 rounded-lg bg-white px-8 py-4 font-bold text-[#4A8FC4] transition-all hover:shadow-xl"
                        >
                            <CloudDownload class="h-5 w-5" :stroke-width="2.5" />
                            <span>Baixar Gratuito</span>
                            <ArrowRight class="h-4 w-4 transition-transform group-hover:translate-x-1" :stroke-width="2.5" />
                        </a>
                        <Link
                            :href="route('home')"
                            class="inline-flex items-center justify-center space-x-2 rounded-lg border-2 border-white bg-transparent px-8 py-4 font-bold text-white transition-all hover:bg-white hover:text-[#4A8FC4]"
                        >
                            <Book class="h-5 w-5" :stroke-width="2.5" />
                            <span>Ver Documentação</span>
                        </Link>
                    </div>
                </div>
            </section>
        </section>

        <AppFooter />
        <BackToTop />
    </div>
</template>

<style scoped>
html {
    scroll-behavior: smooth;
}

pre code {
    font-family: 'Fira Code', 'Courier New', monospace;
    line-height: 1.6;
}

.dark section {
    background-image: none !important;
}
</style>
