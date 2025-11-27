<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, type Component } from 'vue';
import Navbar from '@/components/Navbar.vue';
import {
    FileCode, Download, Folder, FolderOpen, Code2, Database, Eye,
    Settings, CheckCircle2, ArrowRight, Terminal, Play, Book,
    Layers, Box, GitBranch, Package, ChevronRight, Copy, Check,
    Zap, Shield, Star, Target, AlertCircle, FileText, Server,
    CloudDownload, Github, ExternalLink, Home
} from 'lucide-vue-next';
import BackgroundGradient from '@/components/ui/background-gradient/BackgroundGradient.vue';
import AppFooter from '@/components/AppFooter.vue';
import BackToTop from '@/components/BackToTop.vue';

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
    Home
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
        description: 'Separação clara entre Models, Views e Controllers para projetos simples e diretos.'
    },
    {
        icon: Zap,
        title: 'Setup Rápido',
        description: 'Configure seu projeto em menos de 5 minutos com estrutura pré-definida.'
    },
    {
        icon: Book,
        title: 'Fácil de Aprender',
        description: 'Ideal para iniciantes aprenderem os conceitos fundamentais do MVC.'
    },
    {
        icon: Shield,
        title: 'Segurança Básica',
        description: 'Proteção essencial com configurações de segurança pré-estabelecidas.'
    }
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
    { name: 'README.md', icon: FileText, level: 1, type: 'file', description: 'Documentação do projeto' }
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
                icon: resolveIcon(item.icon, fallbackIcon)
            };
        });
    }

    if (props.template?.features?.length) {
        features.value = props.template.features.map((item) => ({
            title: item.title,
            description: item.description,
            icon: resolveIcon(item.icon, Layers)
        }));
    }
});

const installationSteps = [
    {
        step: '01',
        title: 'Baixar o Template',
        description: 'Podes Baixar o Template Base MVC através da plataforma ou GitHub',
        icon: CloudDownload,
        color: 'from-[#4A8FC4] to-[#6BA3D4]'
    },
    {
        step: '02',
        title: 'Extrair Arquivos',
        description: 'Descompacte o arquivo ZIP na pasta do seu servidor web (htdocs, www, public_html)',
        icon: Package,
        color: 'from-[#F4B41A] to-[#F7C950]'
    },
    {
        step: '03',
        title: 'Configurar Banco de Dados',
        description: 'Edite o arquivo config/database.php com suas credenciais do MySQL. Crie uma tabela Users com o código sql e dados iniciais no README.md',
        icon: Database,
        color: 'from-[#C1272D] to-[#E04850]'
    },
    {
        step: '04',
        title: 'Iniciar Desenvolvimento',
        description: 'Abra o navegador e acesse localhost/seu-projeto para começar',
        icon: Zap,
        color: 'from-[#2B4C7E] to-[#567FA6]'
    }
];

const codeExamples = {
    index: `<?php
// index.php - Ponto de entrada da aplicação

// Carrega configurações
require_once 'config/database.php';

// Define rotas básicas
$request = $_SERVER['REQUEST_URI'];
$basePath = '/projeto_base';

switch ($request) {
    case $basePath:
    case $basePath . '/':
        require 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada";
        break;
}`,

    config: `<?php
// config/database.php - Configuração do banco de dados

define('DB_HOST', 'localhost');
define('DB_NAME', 'seu_banco');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
define('DB_CHARSET', 'utf8mb4');

// Função para conectar ao banco
function getConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}`,

    model: `<?php
// models/User.php - Model de usuário

class User {
    private $db;

    public function __construct() {
        $this->db = getConnection();
    }

    // Buscar todos os usuários
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar usuário por ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Criar novo usuário
    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email) VALUES (?, ?)"
        );
        return $stmt->execute([$data['name'], $data['email']]);
    }
}`,

    controller: `<?php
// controllers/HomeController.php - Controller principal

require_once 'models/User.php';

class HomeController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Método principal
    public function index() {
        // Busca dados do model
        $users = $this->userModel->getAll();

        // Passa dados para a view
        $pageTitle = "Página Inicial";
        require 'views/home.php';
    }
}`,

    view: `<!DOCTYPE html>
<!-- views/home.php - View principal -->
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Meu Projeto'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Template Base MVC</h1>

        <div class="users-list">
            <h2>Lista de Usuários</h2>
            <?php if (!empty($users)): ?>
                <ul>
                    <?php foreach ($users as $user): ?>
                        <li><?php echo htmlspecialchars($user['name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum usuário encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/js/script.js"><\/script>
</body>
</html>`
};

const requirements = [
    { name: 'PHP', version: '>= 7.4', icon: FileCode },
    { name: 'MySQL', version: '>= 5.7', icon: Database },
    { name: 'Apache/Nginx', version: 'Qualquer', icon: Server },
    { name: 'Conhecimento', version: 'Básico de PHP', icon: Book }
];

const benefits = [
    'Estrutura simples e intuitiva para iniciantes',
    'Separação clara de responsabilidades (MVC)',
    'Fácil manutenção e expansão do código',
    'Ideal para projetos acadêmicos pequenos',
    'Documentação completa incluída',
    'Exemplos práticos de uso'
];

const useCases = [
    {
        title: 'Sistemas de Cadastro',
        description: 'CRUD básico para gerenciar usuários, produtos ou qualquer entidade',
        icon: Database
    },
    {
        title: 'Páginas Dinâmicas',
        description: 'Sites com conteúdo dinâmico proveniente de banco de dados',
        icon: Eye
    },
    {
        title: 'Blogs Simples',
        description: 'Sistemas de publicação de artigos com categorias',
        icon: FileText
    },
    {
        title: 'Portfólios',
        description: 'Páginas pessoais com projetos e informações',
        icon: Star
    }
];

const errorMessage = ref<string | null>(null);


</script>

<template>
    <Head title="Template Base MVC - IPPLS" />
    <div class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center min-h-screen bg-white dark:bg-[#010226]">
        <Navbar />


        <!-- Flash Messages -->
        <div v-if="errorMessage" class="fixed top-20 right-4 z-50 max-w-sm w-full">
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 shadow-lg">
                <div class="flex items-start space-x-3">
                    <AlertCircle class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" :stroke-width="2" />
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">
                            {{ errorMessage }}
                        </p>
                    </div>
                    <button @click="errorMessage = null" class="text-red-400 hover:text-red-600 transition-colors">
                        <X class="w-4 h-4" :stroke-width="2" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden dark:bg-[#010226]">
            <!-- Background Elements -->
            <div class="absolute inset-0 opacity-[0.015] dark:opacity-[0.08]">
                <div class="absolute inset-0" style="background-image: linear-gradient(rgba(74, 143, 196, 0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(74, 143, 196, 0.15) 1px, transparent 1px); background-size: 80px 80px;"></div>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <!-- Breadcrumb -->
                <div class="flex items-center space-x-2 text-sm mb-8">
                    <Link :href="route('home')" class="text-[#656d76] dark:text-[#7d8590] hover:text-[#2B4C7E] dark:hover:text-[#6BA3D4] transition-colors">
                        <Home class="w-4 h-4" :stroke-width="2" />
                    </Link>
                    <ChevronRight class="w-4 h-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                    <span class="text-[#656d76] dark:text-[#7d8590]">Templates</span>
                    <ChevronRight class="w-4 h-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                    <span class="text-[#24292f] dark:text-[#e6edf3] font-medium">Base MVC</span>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8">
                        <div class="inline-flex items-center space-x-2 px-4 py-2 bg-[#4A8FC4]/10 dark:bg-[#4A8FC4]/20 border border-[#4A8FC4]/20 dark:border-[#4A8FC4]/30 rounded-full">
                            <Layers class="w-4 h-4 text-[#4A8FC4]" :stroke-width="2.5" />
                            <span class="text-sm font-semibold text-[#4A8FC4]">TEMPLATE BASE</span>
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight text-[#24292f] dark:text-[#e6edf3]">
                                Template Base
                                <span class="block mt-2 bg-gradient-to-r from-[#4A8FC4] to-[#6BA3D4] bg-clip-text text-transparent">
                                    MVC Simplificado
                                </span>
                            </h1>

                            <p class="text-lg text-[#656d76] dark:text-[#7d8590] leading-relaxed">
                                Estrutura MVC fundamental e direta para iniciantes. Aprenda os conceitos básicos de arquitetura de software com uma estrutura simples e bem organizada.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a :href="route('templates.base.download')" class="group inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-[#4A8FC4] to-[#6BA3D4] text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                                <CloudDownload class="w-5 h-5" :stroke-width="2.5" />
                                <span>Baixar Template</span>
                                <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                            </a>

                            <a href="https://github.com/Ngola-develop/arquitetura-de-projetos-ippls" target="_blank" class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-white dark:bg-[#0d1117] border border-[#d0d7de] dark:border-[#30363d] hover:border-[#4A8FC4] dark:hover:border-[#6BA3D4] text-[#24292f] dark:text-[#e6edf3] font-semibold rounded-lg transition-all">
                                <Github class="w-5 h-5" :stroke-width="2.5" />
                                <span>Ver no GitHub</span>
                            </a>
                        </div>


                        <!-- Quick Stats -->
                        <div class="flex flex-wrap gap-4 pt-4">
                            <div class="flex items-center space-x-2 px-4 py-2 bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <CheckCircle2 class="w-4 h-4 text-[#4A8FC4]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">Setup em 5 min</span>
                            </div>
                            <div class="flex items-center space-x-2 px-4 py-2 bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <Star class="w-4 h-4 text-[#F4B41A] fill-[#F4B41A]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">Para Iniciantes</span>
                            </div>
                            <div class="flex items-center space-x-2 px-4 py-2 bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <Shield class="w-4 h-4 text-[#2B4C7E]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">100% Gratuito</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Visual -->
                    <div class="relative">
                        <div class="relative bg-[#f6f8fa] dark:bg-[#161b22] rounded-xl p-6 border border-[#d0d7de] dark:border-[#30363d] shadow-lg">
                            <!-- Directory Preview -->
                            <div class="space-y-1 font-mono text-sm">
                                <div v-for="(item, index) in directoryStructure.slice(0, 10)" :key="index" class="flex items-center space-x-2 py-1.5" :style="{ paddingLeft: (item.level * 20) + 'px' }">
                                    <component :is="item.icon" class="w-4 h-4 flex-shrink-0" :class="item.type === 'folder' ? 'text-[#4A8FC4]' : 'text-[#656d76] dark:text-[#7d8590]'" :stroke-width="2" />
                                    <span class="text-[#24292f] dark:text-[#e6edf3]">{{ item.name }}</span>
                                </div>
                                <div class="flex items-center space-x-2 py-1.5 pl-5 text-[#656d76] dark:text-[#7d8590]">
                                    <span>...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute -top-4 -right-4 bg-gradient-to-br from-[#4A8FC4] to-[#6BA3D4] rounded-lg p-3 shadow-lg transform rotate-3">
                            <Layers class="w-6 h-6 text-white" :stroke-width="2.5" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-16 px-4 sm:px-6 lg:px-8 bg-[#f6f8fa] dark:bg-[#010226]">
            <!-- Links de outros templates -->
            <div class="flex items-center justify-center flex-col sm:flex-row gap-4">
                <Link :href="route('templates.padrao')" class="group inline-flex items-center justify-center space-x-2 px-6 py-3 bg-[#4A8FC4] hover:bg-ippls-blue-dark text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                    <Eye class="w-5 h-5" :stroke-width="2.5" />
                    <span>Ver Template Padrão</span>
                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                </Link>

                <Link :href="route('templates.avancado')" target="_blank" class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-white dark:bg-[#0d1117] border border-[#d0d7de] dark:border-[#30363d] hover:border-[#4A8FC4] dark:hover:border-[#6BA3D4] text-[#24292f] dark:text-[#e6edf3] font-semibold rounded-lg transition-all bg-none text-sm shadow-md shadow-ippls-blue-dark hover:shadow-lg hover:bg-ippls-blue-dark hover:text-white">
                    <Eye class="w-5 h-5" :stroke-width="2.5" />
                    <span>Ver Template Avançado</span>
                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                </Link>
            </div>
        </section>


        <!-- Features Section -->
        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-16 px-4 sm:px-6 lg:px-8 bg-[#f6f8fa] dark:bg-[#010226]">

            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-4">
                        Por que escolher o Template Base?
                    </h2>
                    <p class="text-lg text-[#656d76] dark:text-[#7d8590]">
                        Ideal para quem está começando no desenvolvimento MVC
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="feature in features" :key="feature.title" class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d] hover:border-[#4A8FC4] dark:hover:border-[#6BA3D4] hover:shadow-md transition-all">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#4A8FC4] to-[#6BA3D4] rounded-lg flex items-center justify-center mb-4">
                            <component :is="feature.icon" class="w-6 h-6 text-white" :stroke-width="2" />
                        </div>
                        <h3 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">
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
        <section class="py-16 px-4 sm:px-6 lg:px-8 dark:bg-[#010226]">
            <div class="max-w-7xl mx-auto">
                <!-- Tab Navigation -->
                <div class="flex flex-wrap gap-2 mb-8 border-b border-[#d0d7de] dark:border-[#30363d]">
                    <button
                        @click="activeTab = 'overview'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'overview'
                                ? 'text-[#4A8FC4] border-b-2 border-[#4A8FC4]'
                                : 'text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3]'
                        ]"
                    >
                        Visão Geral
                    </button>
                    <button
                        @click="activeTab = 'structure'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'structure'
                                ? 'text-[#4A8FC4] border-b-2 border-[#4A8FC4]'
                                : 'text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3]'
                        ]"
                    >
                        Estrutura
                    </button>
                    <button
                        @click="activeTab = 'installation'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'installation'
                                ? 'text-[#4A8FC4] border-b-2 border-[#4A8FC4]'
                                : 'text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3]'
                        ]"
                    >
                        Instalação
                    </button>
                    <button
                        @click="activeTab = 'code'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'code'
                                ? 'text-[#4A8FC4] border-b-2 border-[#4A8FC4]'
                                : 'text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3]'
                        ]"
                    >
                        Exemplos de Código
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="mt-8">
                    <!-- Overview Tab -->
                    <div v-show="activeTab === 'overview'" class="space-y-8">
                        <div class="grid lg:grid-cols-2 gap-8">
                            <!-- Requirements -->
                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-4 flex items-center space-x-2">
                                    <AlertCircle class="w-5 h-5 text-[#4A8FC4]" :stroke-width="2" />
                                    <span>Requisitos</span>
                                </h3>
                                <div class="space-y-3">
                                    <div v-for="req in requirements" :key="req.name" class="flex items-center justify-between p-3 bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <component :is="req.icon" class="w-5 h-5 text-[#4A8FC4]" :stroke-width="2" />
                                            <span class="font-medium text-[#24292f] dark:text-[#e6edf3]">{{ req.name }}</span>
                                        </div>
                                        <span class="text-sm text-[#656d76] dark:text-[#7d8590]">{{ req.version }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Benefits -->
                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-4 flex items-center space-x-2">
                                    <Star class="w-5 h-5 text-[#F4B41A] fill-[#F4B41A]" :stroke-width="2" />
                                    <span>Benefícios</span>
                                </h3>
                                <ul class="space-y-3">
                                    <li v-for="benefit in benefits" :key="benefit" class="flex items-start space-x-3">
                                        <CheckCircle2 class="w-5 h-5 text-[#4A8FC4] flex-shrink-0 mt-0.5" :stroke-width="2" />
                                        <span class="text-[#24292f] dark:text-[#c9d1d9]">{{ benefit }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Use Cases -->
                        <div>
                            <h3 class="text-2xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-6">
                                Casos de Uso
                            </h3>
                            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div v-for="useCase in useCases" :key="useCase.title" class="bg-white dark:bg-[#0d1117] rounded-lg p-5 border border-[#d0d7de] dark:border-[#30363d] hover:border-[#4A8FC4] dark:hover:border-[#6BA3D4] transition-all">
                                    <component :is="useCase.icon" class="w-8 h-8 text-[#4A8FC4] mb-3" :stroke-width="2" />
                                    <h4 class="font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">{{ useCase.title }}</h4>
                                    <p class="text-sm text-[#656d76] dark:text-[#7d8590]">{{ useCase.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Structure Tab -->
                    <div v-show="activeTab === 'structure'" class="space-y-6">
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                            <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-6">
                                Estrutura de Diretórios Completa
                            </h3>
                            <div class="space-y-1 font-mono text-sm">
                                <div v-for="(item, index) in directoryStructure" :key="index" class="group flex items-start space-x-3 py-2 hover:bg-[#f6f8fa] dark:hover:bg-[#161b22] rounded px-3 transition-colors" :style="{ paddingLeft: (item.level * 24 + 12) + 'px' }">
                                    <component :is="item.icon" class="w-4 h-4 flex-shrink-0 mt-0.5" :class="item.type === 'folder' ? 'text-[#4A8FC4]' : 'text-[#656d76] dark:text-[#7d8590]'" :stroke-width="2" />
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-[#24292f] dark:text-[#e6edf3] font-medium">{{ item.name }}</span>
                                        </div>
                                        <p v-if="item.description" class="text-xs text-[#656d76] dark:text-[#7d8590] mt-1">{{ item.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Architecture Explanation -->
                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#C1272D] to-[#E04850] rounded-lg flex items-center justify-center mb-4">
                                    <Database class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">Models</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Gerenciam os dados e a lógica de negócio. Contêm as classes que interagem com o banco de dados.
                                </p>
                            </div>

                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#4A8FC4] to-[#6BA3D4] rounded-lg flex items-center justify-center mb-4">
                                    <Eye class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">Views</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Responsáveis pela apresentação. Arquivos HTML/PHP que exibem os dados para o usuário.
                                </p>
                            </div>

                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#F4B41A] to-[#F7C950] rounded-lg flex items-center justify-center mb-4">
                                    <Code2 class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">Controllers</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Intermediários entre Models e Views. Processam requisições e retornam respostas.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Installation Tab -->
                    <div v-show="activeTab === 'installation'" class="space-y-8">
                        <div class="bg-gradient-to-r from-[#4A8FC4]/10 to-[#6BA3D4]/10 border border-[#4A8FC4]/20 dark:border-[#6BA3D4]/30 rounded-lg p-6">
                            <div class="flex items-start space-x-4">
                                <AlertCircle class="w-6 h-6 text-[#4A8FC4] flex-shrink-0 mt-1" :stroke-width="2" />
                                <div>
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">Antes de começar</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">
                                        Certifique-se de ter um servidor web local instalado (XAMPP, WAMP, MAMP ou similar) e um navegador moderno.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div v-for="step in installationSteps" :key="step.step" class="relative">
                                <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d] hover:border-[#4A8FC4] dark:hover:border-[#6BA3D4] transition-all h-full">
                                    <div class="flex items-start space-x-4 mb-4">
                                        <div :class="['w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 bg-gradient-to-br', step.color]">
                                            <component :is="step.icon" class="w-6 h-6 text-white" :stroke-width="2" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-3xl font-bold text-[#4A8FC4]/30 dark:text-[#6BA3D4]/30 mb-2">{{ step.step }}</div>
                                            <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">{{ step.title }}</h4>
                                        </div>
                                    </div>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">{{ step.description }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Installation Guide -->
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                            <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-6 flex items-center space-x-2">
                                <Terminal class="w-5 h-5 text-[#4A8FC4]" :stroke-width="2" />
                                <span>Guia Detalhado de Instalação</span>
                            </h3>

                            <div class="space-y-6">
                                <!-- Step 1 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">1. Baixar o Template</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Baixe o template através da plataforma IPPLS ou diretamente do GitHub:</p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[#656d76] dark:text-[#7d8590]">Terminal</span>
                                            <button
                                                @click="copyToClipboard('git clone https://github.com/Ngola-develop/arquitetura-de-projetos-ippls/template-base-mvc.git', 'git1')"
                                                class="text-[#656d76] dark:text-[#7d8590] hover:text-[#4A8FC4] transition-colors"
                                            >
                                                <component :is="copiedCode === 'git1' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                            </button>
                                        </div>
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">https://github.com/Ngola-develop/arquitetura-de-projetos-ippls/template-base-mvc.git</code>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">2. Mover para Pasta do Servidor</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Mova ou extraia os arquivos para a pasta do seu servidor web:</p>
                                    <ul class="list-disc list-inside space-y-1 text-[#656d76] dark:text-[#7d8590] ml-4">
                                        <li><strong>XAMPP:</strong> C:\xampp\htdocs\seu-projeto</li>
                                        <li><strong>WAMP:</strong> C:\wamp64\www\seu-projeto</li>
                                        <li><strong>MAMP:</strong> /Applications/MAMP/htdocs/seu-projeto</li>
                                    </ul>
                                </div>

                                <!-- Step 3 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">3. Criar Banco de Dados</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Acesse o phpMyAdmin e crie um novo banco de dados:</p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[#656d76] dark:text-[#7d8590]">SQL</span>
                                            <button
                                                @click="copyToClipboard('CREATE DATABASE meu_projeto_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;', 'sql1')"
                                                class="text-[#656d76] dark:text-[#7d8590] hover:text-[#4A8FC4] transition-colors"
                                            >
                                                <component :is="copiedCode === 'sql1' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                            </button>
                                        </div>
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">CREATE DATABASE meu_projeto_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</code>
                                    </div>
                                </div>
                                <!-- Step 4 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">4. Criar Tabela Users</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Acesse o banco de dados e crie uma tabela com dados inicial:</p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[#656d76] dark:text-[#7d8590]">SQL</span>
                                            <button
                                                @click="copyToClipboard('CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL UNIQUE, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP); INSERT INTO users (name, email) VALUES(\'Pai Grande Ngola', 'paigrandengola@ippls.edu.ao\'), (\'Professor Lengo Júnior', 'lengojunior@ippls.edu.ao\'), (\'Eng. Vanilson Manuel', 'vanilsonmanuel@ippls.edu.ao\');', 'sql2')"
                                                class="text-[#656d76] dark:text-[#7d8590] hover:text-[#4A8FC4] transition-colors"
                                            >
                                                <component :is="copiedCode === 'sql2' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                            </button>
                                        </div>
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">
                                            CREATE TABLE users (<br/>
                                                id INT AUTO_INCREMENT PRIMARY KEY,<br/>
                                                name VARCHAR(100) NOT NULL,<br/>
                                                email VARCHAR(100) NOT NULL UNIQUE,<br/>
                                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                                            ); <br/><br/>

                                            INSERT INTO users (name, email) VALUES<br/>
                                            ('Pai Grande Ngola', 'paigrandengola@ippls.edu.ao'),<br/>
                                            ('Professor Lengo Júnior', 'lengojunior@ippls.edu.ao'),<br/>
                                            ('Eng. Vanilson Manuel', 'vanilsonmanuel@ippls.edu.ao');<br/>
                                        </code>
                                    </div>
                                </div>

                                <!-- Step 5 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">5. Configurar Conexão</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Edite o arquivo <code class="px-2 py-1 bg-[#f6f8fa] dark:bg-[#161b22] rounded text-[#24292f] dark:text-[#e6edf3] font-mono text-sm">config/database.php</code> com suas credenciais:</p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d]">
                                        <pre class="text-sm text-[#24292f] dark:text-[#e6edf3] overflow-x-auto"><code>define('DB_HOST', 'localhost');
define('DB_NAME', 'meu_projeto_base');
define('DB_USER', 'root');
define('DB_PASS', '');</code></pre>
                                    </div>
                                </div>

                                <!-- Step 6 -->
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">6. Acessar no Navegador</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Abra seu navegador e acesse:</p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#4A8FC4]">http://localhost/seu-projeto</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Code Examples Tab -->
                    <div v-show="activeTab === 'code'" class="space-y-6">
                        <!-- Index.php -->
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <FileCode class="w-4 h-4 text-[#4A8FC4]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">index.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.index, 'index')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#4A8FC4] transition-colors"
                                >
                                    <component :is="copiedCode === 'index' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.index }}</code></pre>
                            </div>
                        </div>

                        <!-- Config -->
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Database class="w-4 h-4 text-[#C1272D]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">config/database.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.config, 'config')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#4A8FC4] transition-colors"
                                >
                                    <component :is="copiedCode === 'config' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.config }}</code></pre>
                            </div>
                        </div>

                        <!-- Model -->
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Database class="w-4 h-4 text-[#F4B41A]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">models/User.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.model, 'model')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#4A8FC4] transition-colors"
                                >
                                    <component :is="copiedCode === 'model' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.model }}</code></pre>
                            </div>
                        </div>

                        <!-- Controller -->
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Code2 class="w-4 h-4 text-[#2B4C7E]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">controllers/HomeController.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.controller, 'controller')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#4A8FC4] transition-colors"
                                >
                                    <component :is="copiedCode === 'controller' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.controller }}</code></pre>
                            </div>
                        </div>

                        <!-- View -->
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Eye class="w-4 h-4 text-[#4A8FC4]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">views/home.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.view, 'view')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#4A8FC4] transition-colors"
                                >
                                    <component :is="copiedCode === 'view' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
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
            <section class="py-20 px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center space-y-8">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                        Pronto para começar?
                    </h2>
                    <p class="text-xl text-white/90">
                        Baixe o Template Base MVC e comece seu primeiro projeto estruturado hoje mesmo!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a :href="route('templates.base.download')" class="group inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white text-[#4A8FC4] font-bold rounded-lg hover:shadow-xl transition-all">
                            <CloudDownload class="w-5 h-5" :stroke-width="2.5" />
                            <span>Baixar Gratuito</span>
                            <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                        </a>
                        <Link :href="route('home')" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-[#4A8FC4] transition-all">
                            <Book class="w-5 h-5" :stroke-width="2.5" />
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
