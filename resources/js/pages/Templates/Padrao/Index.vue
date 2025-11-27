<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, type Component } from 'vue';
import Navbar from '@/components/Navbar.vue';
import {
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
    Workflow,
    Users,
    GraduationCap,
    Building2
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
    Home,
    Workflow,
    Users,
    GraduationCap,
    Building2
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
        icon: Settings,
        title: 'Camada de Serviços Reutilizável',
        description: 'Serviços desacoplados que centralizam regras de negócio e podem ser reaproveitados em múltiplos módulos.'
    },
    {
        icon: Shield,
        title: 'Middlewares Personalizados',
        description: 'Fluxo de requisições protegido por middlewares de autenticação, autorização e auditoria prontos.'
    },
    {
        icon: Layers,
        title: 'Componentização de Views',
        description: 'Componentes reutilizáveis que garantem consistência visual e agilidade na criação de novas telas.'
    },
    {
        icon: Server,
        title: 'Integração REST Completa',
        description: 'Padrões para criação de APIs RESTful, incluindo validações, responses estruturadas e documentação básica.'
    }
];

const defaultDirectoryStructure: DirectoryItem[] = [
    { name: 'projeto_padrao/', icon: Folder, level: 0, type: 'folder' },
    { name: 'app/', icon: FolderOpen, level: 1, type: 'folder' },
    { name: 'Http/', icon: FolderOpen, level: 2, type: 'folder' },
    { name: 'Controllers/', icon: FolderOpen, level: 3, type: 'folder', description: 'Controladores organizados por domínio' },
    { name: 'Middleware/', icon: Shield, level: 3, type: 'folder', description: 'Middlewares de autenticação e auditoria' },
    { name: 'Requests/', icon: FileText, level: 3, type: 'folder', description: 'Validações de entrada com Form Requests' },
    { name: 'Services/', icon: Settings, level: 3, type: 'folder', description: 'Camada de serviços reutilizáveis' },
    { name: 'Repositories/', icon: Box, level: 3, type: 'folder', description: 'Acesso a dados desacoplado do ORM' },
    { name: 'Models/', icon: Database, level: 2, type: 'folder', description: 'Models com relacionamentos e casts' },
    { name: 'database/', icon: Database, level: 1, type: 'folder', description: 'Migrations, seeders e factories' },
    { name: 'routes/', icon: GitBranch, level: 1, type: 'folder' },
    { name: 'web.php', icon: FileCode, level: 2, type: 'file', description: 'Rotas web e middlewares associados' },
    { name: 'api.php', icon: FileCode, level: 2, type: 'file', description: 'Rotas API com versionamento' },
    { name: 'resources/', icon: FolderOpen, level: 1, type: 'folder' },
    { name: 'views/', icon: Eye, level: 2, type: 'folder', description: 'Templates Blade componentizados' },
    { name: 'components/', icon: Layers, level: 3, type: 'folder', description: 'Componentes dinâmicos reutilizáveis' },
    { name: 'tests/', icon: FileText, level: 1, type: 'folder', description: 'Testes automatizados (Feature e Unit)' }
];

const defaultInstallationSteps = [
    {
        step: '01',
        title: 'Clonar Projeto',
        description: 'Faça o download do template Padrão via Git ou manipulação de ZIP.',
        icon: CloudDownload,
        color: 'from-[#2B4C7E] to-[#6BA3D4]'
    },
    {
        step: '02',
        title: 'Instalar Dependências',
        description: 'Execute composer install e npm install para preparar backend e front-end.',
        icon: Package,
        color: 'from-[#C1272D] to-[#E04850]'
    },
    {
        step: '03',
        title: 'Configurar Ambiente',
        description: 'Crie o arquivo .env, configure credenciais e gere a chave da aplicação.',
        icon: Settings,
        color: 'from-[#F4B41A] to-[#F7C950]'
    },
    {
        step: '04',
        title: 'Rodar Migrações',
        description: 'Execute php artisan migrate --seed e finalize com npm run dev.',
        icon: Database,
        color: 'from-[#2B4C7E] to-[#567FA6]'
    }
];

const codeExamples = {
    routes: `<?php
// routes/web.php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard.index');

        Route::post('/login', [LoginController::class, 'authenticate'])
            ->middleware('guest')
            ->name('auth.login');
    });

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class);
    });`,

    controller: `<?php
// app/Http/Controllers/ProjectsController.php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ProjectsController extends Controller
{
    public function __construct(private ProjectService $service)
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(): Response
    {
        return inertia('Projects/Index', [
            'projects' => $this->service->paginated()
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Projeto criado com sucesso!');
    }
}`,

    service: `<?php
// app/Services/ProjectService.php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    public function __construct(private ProjectRepository $repository)
    {
    }

    public function paginated(): array
    {
        return $this->repository->paginate(12)
            ->through(fn (Project $project) => [
                'id' => $project->id,
                'name' => $project->name,
                'status' => $project->status,
                'owner' => $project->owner?->name,
            ])
            ->toArray();
    }

    public function create(array $payload): void
    {
        $project = $this->repository->create($payload);
        Log::channel('projects')->info('Novo projeto criado', ['id' => $project->id]);
    }
}`,

    middleware: `<?php
// app/Http/Middleware/EnsureRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || ! $request->user()->hasRole($role)) {
            abort(403, 'Acesso não autorizado');
        }

        return $next($request);
    }
}`,

    view: `@extends('layouts.app')

@section('content')
    <x-page-header :title="$project->name" back="{{ route('admin.projects.index') }}" />

    <div class="grid gap-6 lg:grid-cols-3">
        <x-card class="lg:col-span-2">
            <x-slot:title>Informações Gerais</x-slot:title>
            <dl class="divide-y divide-neutral-200">
                <div class="py-4 flex justify-between">
                    <dt class="text-neutral-500">Status</dt>
                    <dd class="font-semibold text-neutral-900">{{ ucfirst($project->status) }}</dd>
                </div>
                <div class="py-4 flex justify-between">
                    <dt class="text-neutral-500">Responsável</dt>
                    <dd class="font-semibold text-neutral-900">{{ $project->owner->name }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card>
            <x-slot:title>Próximas Ações</x-slot:title>
            <ul class="space-y-3 text-sm text-neutral-600">
                <li>• Revisar requisitos do cliente</li>
                <li>• Atualizar roadmap do sprint</li>
                <li>• Validar entregáveis com a equipe</li>
            </ul>
        </x-card>
    </div>
@endsection`
};

const requirements = [
    { name: 'PHP', version: '>= 8.1', icon: FileCode },
    { name: 'Composer', version: '>= 2.5', icon: Package },
    { name: 'Node.js', version: '>= 18', icon: Server },
    { name: 'MySQL', version: '>= 8.0', icon: Database }
];

const benefits = [
    'Separação completa entre Controller, Service e Repository',
    'Validações robustas com Form Requests e Policies',
    'Padrão para criação de APIs RESTful e SPA híbridas',
    'Testes automatizados com suporte a mocks e factories',
    'Layouts componentizados com Blade e Tailwind',
    'Pipeline de logs e monitoramento integrado'
];

const useCases = [
    {
        title: 'Sistemas Acadêmicos',
        description: 'Gestão de turmas, matrículas e avaliações com múltiplos papéis.',
        icon: GraduationCap
    },
    {
        title: 'Plataformas Corporativas',
        description: 'Soluções internas com dashboards, relatórios e workflows.',
        icon: Building2
    },
    {
        title: 'APIs RESTful',
        description: 'Serviços REST integrados com autenticação JWT e documentação.',
        icon: Server
    },
    {
        title: 'Portais Multiusuário',
        description: 'Experiências completas com controle de acesso granular.',
        icon: Users
    }
];

const CTA_LINKS = {
    download: 'templates.padrao.download',
    explore: 'templates.padrao'
};

const activeTab = ref<TabKey>('overview');
const copiedCode = ref<string | null>(null);
const features = ref<FeatureItem[]>(defaultFeatures);
const directoryStructure = ref<DirectoryItem[]>(defaultDirectoryStructure);
const installationSteps = ref(defaultInstallationSteps);

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

const resolveDirectory = (items: DirectoryPayload[]): DirectoryItem[] =>
    items.map((item) => {
        const level = typeof item.level === 'number' ? item.level : 0;
        const type = item.type === 'folder' ? 'folder' : 'file';
        const fallback = type === 'folder' ? Folder : FileCode;

        return {
            name: item.name,
            description: item.description,
            level,
            type,
            icon: resolveIcon(item.icon, fallback)
        };
    });

onMounted(() => {
    if (props.template?.estrutura_diretorios?.length) {
        directoryStructure.value = resolveDirectory(props.template.estrutura_diretorios);
    }

    if (props.template?.features?.length) {
        features.value = props.template.features.map((item) => ({
            title: item.title,
            description: item.description,
            icon: resolveIcon(item.icon, Layers)
        }));
    }
});
</script>

<template>
    <Head title="Template Padrão MVC - IPPLS" />

    <div class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center min-h-screen bg-white dark:bg-[#010226]">
        <Navbar />

        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden dark:bg-[#010226]">
            <div class="absolute inset-0 opacity-[0.015] dark:opacity-[0.08]">
                <div class="absolute inset-0" style="background-image: linear-gradient(rgba(43, 76, 126, 0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(43, 76, 126, 0.15) 1px, transparent 1px); background-size: 80px 80px;"></div>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="flex items-center space-x-2 text-sm mb-8">
                    <Link :href="route('home')" class="text-[#656d76] dark:text-[#7d8590] hover:text-[#2B4C7E] dark:hover:text-[#6BA3D4] transition-colors">
                        <Home class="w-4 h-4" :stroke-width="2" />
                    </Link>
                    <ChevronRight class="w-4 h-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                    <span class="text-[#656d76] dark:text-[#7d8590]">Templates</span>
                    <ChevronRight class="w-4 h-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                    <span class="text-[#24292f] dark:text-[#e6edf3] font-medium">Padrão MVC</span>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <div class="inline-flex items-center space-x-2 px-4 py-2 bg-[#2B4C7E]/10 dark:bg-[#2B4C7E]/20 border border-[#2B4C7E]/20 dark:border-[#2B4C7E]/30 rounded-full">
                            <Workflow class="w-4 h-4 text-[#2B4C7E]" :stroke-width="2.5" />
                            <span class="text-sm font-semibold text-[#2B4C7E]">TEMPLATE PADRÃO</span>
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight text-[#24292f] dark:text-[#e6edf3]">
                                Template Padrão
                                <span class="block mt-2 bg-gradient-to-r from-[#2B4C7E] via-[#C1272D] to-[#F4B41A] bg-clip-text text-transparent">
                                    MVC Profissional
                                </span>
                            </h1>

                            <p class="text-lg text-[#656d76] dark:text-[#7d8590] leading-relaxed">
                                Estrutura completa para projetos de médio porte, com camadas bem definidas, middlewares prontos e integrações modernas que aceleram o desenvolvimento com qualidade enterprise.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a
                                :href="route(CTA_LINKS.download)"
                                class="group inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-[#2B4C7E] to-[#6BA3D4] text-white font-semibold rounded-lg hover:shadow-lg transition-all"
                            >
                                <CloudDownload class="w-5 h-5" :stroke-width="2.5" />
                                <span>Baixar Template</span>
                                <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                            </a>

                            <Link
                                :href="route(CTA_LINKS.explore)"
                                class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-white dark:bg-[#0d1117] border border-[#d0d7de] dark:border-[#30363d] hover:border-[#2B4C7E] dark:hover:border-[#6BA3D4] text-[#24292f] dark:text-[#e6edf3] font-semibold rounded-lg transition-all"
                            >
                                <Github class="w-5 h-5" :stroke-width="2.5" />
                                <span>Estrutura Completa</span>
                            </Link>
                        </div>

                        <div class="flex flex-wrap gap-4 pt-4">
                            <div class="flex items-center space-x-2 px-4 py-2 bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <CheckCircle2 class="w-4 h-4 text-[#2B4C7E]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">Arquitetura em Camadas</span>
                            </div>
                            <div class="flex items-center space-x-2 px-4 py-2 bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <Shield class="w-4 h-4 text-[#C1272D]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">Segurança Avançada</span>
                            </div>
                            <div class="flex items-center space-x-2 px-4 py-2 bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <Terminal class="w-4 h-4 text-[#F4B41A]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#24292f] dark:text-[#e6edf3]">API + SPA Ready</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="relative bg-[#f6f8fa] dark:bg-[#161b22] rounded-xl p-6 border border-[#d0d7de] dark:border-[#30363d] shadow-lg">
                            <div class="space-y-1 font-mono text-sm">
                                <div
                                    v-for="(item, index) in directoryStructure.slice(0, 11)"
                                    :key="index"
                                    class="flex items-center space-x-2 py-1.5"
                                    :style="{ paddingLeft: (item.level * 20) + 'px' }"
                                >
                                    <component
                                        :is="item.icon"
                                        class="w-4 h-4 flex-shrink-0"
                                        :class="item.type === 'folder' ? 'text-[#2B4C7E]' : 'text-[#656d76] dark:text-[#7d8590]'"
                                        :stroke-width="2"
                                    />
                                    <span class="text-[#24292f] dark:text-[#e6edf3]">{{ item.name }}</span>
                                </div>
                                <div class="flex items-center space-x-2 py-1.5 pl-5 text-[#656d76] dark:text-[#7d8590]">
                                    <span>...</span>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -top-4 -right-4 bg-gradient-to-br from-[#2B4C7E] to-[#6BA3D4] rounded-lg p-3 shadow-lg transform rotate-3">
                            <Workflow class="w-6 h-6 text-white" :stroke-width="2.5" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-16 px-4 sm:px-6 lg:px-8 bg-[#f6f8fa] dark:bg-[#010226]">
            <!-- Links de outros templates -->
            <div class="flex items-center justify-center flex-col sm:flex-row gap-4">
                <Link :href="route('templates.base')" class="group inline-flex items-center justify-center space-x-2 px-6 py-3 bg-[#4A8FC4] hover:bg-ippls-blue-dark text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                    <Eye class="w-5 h-5" :stroke-width="2.5" />
                    <span>Ver Template Base</span>
                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                </Link>

                <Link :href="route('templates.avancado')" target="_blank" class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-white dark:bg-[#0d1117] border border-[#d0d7de] dark:border-[#30363d] hover:border-[#4A8FC4] dark:hover:border-[#6BA3D4] text-[#24292f] dark:text-[#e6edf3] font-semibold rounded-lg transition-all bg-none text-sm shadow-md shadow-ippls-blue-dark hover:shadow-lg hover:bg-ippls-blue-dark hover:text-white">
                    <Eye class="w-5 h-5" :stroke-width="2.5" />
                    <span>Ver Template Avançado</span>
                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                </Link>
            </div>
        </section>

        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-16 px-4 sm:px-6 lg:px-8 bg-[#f6f8fa] dark:bg-[#010226]">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-4">
                        Por que escolher o Template Padrão?
                    </h2>
                    <p class="text-lg text-[#656d76] dark:text-[#7d8590]">
                        Arquitetura robusta com camadas bem definidas, ideal para projetos acadêmicos e corporativos.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d] hover:border-[#2B4C7E] dark:hover:border-[#6BA3D4] hover:shadow-md transition-all"
                    >
                        <div class="w-12 h-12 bg-gradient-to-br from-[#2B4C7E] via-[#C1272D] to-[#F4B41A] rounded-lg flex items-center justify-center mb-4">
                            <component :is="feature.icon" class="w-6 h-6 text-white" :stroke-width="2" />
                        </div>
                        <h3 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">{{ feature.title }}</h3>
                        <p class="text-sm text-[#656d76] dark:text-[#7d8590]">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 px-4 sm:px-6 lg:px-8 dark:bg-[#010226]">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-wrap gap-2 mb-8 border-b border-[#d0d7de] dark:border-[#30363d]">
                    <button
                        @click="activeTab = 'overview'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'overview'
                                ? 'text-[#2B4C7E] border-b-2 border-[#2B4C7E]'
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
                                ? 'text-[#2B4C7E] border-b-2 border-[#2B4C7E]'
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
                                ? 'text-[#2B4C7E] border-b-2 border-[#2B4C7E]'
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
                                ? 'text-[#2B4C7E] border-b-2 border-[#2B4C7E]'
                                : 'text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3]'
                        ]"
                    >
                        Exemplos de Código
                    </button>
                </div>

                <div class="mt-8">
                    <div v-show="activeTab === 'overview'" class="space-y-8">
                        <div class="grid lg:grid-cols-2 gap-8">
                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-4 flex items-center space-x-2">
                                    <AlertCircle class="w-5 h-5 text-[#2B4C7E]" :stroke-width="2" />
                                    <span>Requisitos</span>
                                </h3>
                                <div class="space-y-3">
                                    <div
                                        v-for="req in requirements"
                                        :key="req.name"
                                        class="flex items-center justify-between p-3 bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg"
                                    >
                                        <div class="flex items-center space-x-3">
                                            <component :is="req.icon" class="w-5 h-5 text-[#2B4C7E]" :stroke-width="2" />
                                            <span class="font-medium text-[#24292f] dark:text-[#e6edf3]">{{ req.name }}</span>
                                        </div>
                                        <span class="text-sm text-[#656d76] dark:text-[#7d8590]">{{ req.version }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-4 flex items-center space-x-2">
                                    <Star class="w-5 h-5 text-[#F4B41A] fill-[#F4B41A]" :stroke-width="2" />
                                    <span>Benefícios</span>
                                </h3>
                                <ul class="space-y-3">
                                    <li
                                        v-for="benefit in benefits"
                                        :key="benefit"
                                        class="flex items-start space-x-3"
                                    >
                                        <CheckCircle2 class="w-5 h-5 text-[#2B4C7E] flex-shrink-0 mt-0.5" :stroke-width="2" />
                                        <span class="text-[#24292f] dark:text-[#c9d1d9]">{{ benefit }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-6">
                                Casos de Uso
                            </h3>
                            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div
                                    v-for="useCase in useCases"
                                    :key="useCase.title"
                                    class="bg-white dark:bg-[#0d1117] rounded-lg p-5 border border-[#d0d7de] dark:border-[#30363d] hover:border-[#2B4C7E] dark:hover:border-[#6BA3D4] transition-all"
                                >
                                    <component :is="useCase.icon" class="w-8 h-8 text-[#2B4C7E] mb-3" :stroke-width="2" />
                                    <h4 class="font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">{{ useCase.title }}</h4>
                                    <p class="text-sm text-[#656d76] dark:text-[#7d8590]">{{ useCase.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'structure'" class="space-y-6">
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                            <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-6">
                                Estrutura de Diretórios Completa
                            </h3>
                            <div class="space-y-1 font-mono text-sm">
                                <div
                                    v-for="(item, index) in directoryStructure"
                                    :key="index"
                                    class="group flex items-start space-x-3 py-2 hover:bg-[#f6f8fa] dark:hover:bg-[#161b22] rounded px-3 transition-colors"
                                    :style="{ paddingLeft: (item.level * 24 + 12) + 'px' }"
                                >
                                    <component
                                        :is="item.icon"
                                        class="w-4 h-4 flex-shrink-0 mt-0.5"
                                        :class="item.type === 'folder' ? 'text-[#2B4C7E]' : 'text-[#656d76] dark:text-[#7d8590]'"
                                        :stroke-width="2"
                                    />
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-[#24292f] dark:text-[#e6edf3] font-medium">{{ item.name }}</span>
                                        </div>
                                        <p v-if="item.description" class="text-xs text-[#656d76] dark:text-[#7d8590] mt-1">{{ item.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#C1272D] to-[#E04850] rounded-lg flex items-center justify-center mb-4">
                                    <Workflow class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">Services</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Encapsulam regras de negócio, garantindo coesão e reutilização em múltiplos controladores.
                                </p>
                            </div>

                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#2B4C7E] to-[#6BA3D4] rounded-lg flex items-center justify-center mb-4">
                                    <Shield class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">Middlewares</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Camada de proteção para rotas, com autenticação, rate limiting e auditoria prontos para uso.
                                </p>
                            </div>

                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#F4B41A] to-[#F7C950] rounded-lg flex items-center justify-center mb-4">
                                    <Layers class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">Componentes</h4>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Views componentizadas com slots e props, prontas para uso em múltiplos módulos.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'installation'" class="space-y-8">
                        <div class="bg-gradient-to-r from-[#2B4C7E]/10 to-[#6BA3D4]/10 border border-[#2B4C7E]/20 dark:border-[#6BA3D4]/30 rounded-lg p-6">
                            <div class="flex items-start space-x-4">
                                <AlertCircle class="w-6 h-6 text-[#2B4C7E] flex-shrink-0 mt-1" :stroke-width="2" />
                                <div>
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-2">Antes de começar</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">
                                        Certifique-se de ter Composer, Node.js e um banco MySQL configurados. Recomendamos PHP 8.1 ou superior.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div v-for="step in installationSteps" :key="step.step" class="relative">
                                <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d] hover:border-[#2B4C7E] dark:hover:border-[#6BA3D4] transition-all h-full">
                                    <div class="flex items-start space-x-4 mb-4">
                                        <div :class="['w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 bg-gradient-to-br', step.color]">
                                            <component :is="step.icon" class="w-6 h-6 text-white" :stroke-width="2" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-3xl font-bold text-[#2B4C7E]/30 dark:text-[#6BA3D4]/30 mb-2">{{ step.step }}</div>
                                            <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">{{ step.title }}</h4>
                                        </div>
                                    </div>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">{{ step.description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d]">
                            <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-6 flex items-center space-x-2">
                                <Terminal class="w-5 h-5 text-[#2B4C7E]" :stroke-width="2" />
                                <span>Guia Detalhado de Instalação</span>
                            </h3>

                            <div class="space-y-6">
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">1. Instalação Backend</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Dentro da pasta do projeto execute:</p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[#656d76] dark:text-[#7d8590]">Terminal</span>
                                            <button
                                                @click="copyToClipboard('composer install', 'composer1')"
                                                class="text-[#656d76] dark:text-[#7d8590] hover:text-[#2B4C7E] transition-colors"
                                            >
                                                <component :is="copiedCode === 'composer1' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                            </button>
                                        </div>
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">composer install</code>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">2. Configuração de Ambiente</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">
                                        Copie o arquivo de exemplo e gere a key da aplicação:
                                    </p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">cp .env.example .env</code>
                                    </div>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">php artisan key:generate</code>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">3. Banco de Dados</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">
                                        Ajuste suas credenciais no arquivo <code class="px-2 py-1 bg-[#f6f8fa] dark:bg-[#161b22] rounded text-[#24292f] dark:text-[#e6edf3] font-mono text-sm">.env</code> e execute:
                                    </p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">php artisan migrate --seed</code>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">4. Front-end</h4>
                                    <p class="text-[#656d76] dark:text-[#7d8590]">Instale dependências e compile os assets:</p>
                                    <div class="bg-[#f6f8fa] dark:bg-[#161b22] rounded-lg p-4 border border-[#d0d7de] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#24292f] dark:text-[#e6edf3]">npm install && npm run dev</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'code'" class="space-y-6">
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <GitBranch class="w-4 h-4 text-[#2B4C7E]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">routes/web.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.routes, 'route')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#2B4C7E] transition-colors"
                                >
                                    <component :is="copiedCode === 'route' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.routes }}</code></pre>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Code2 class="w-4 h-4 text-[#C1272D]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">ProjectsController.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.controller, 'controller')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#2B4C7E] transition-colors"
                                >
                                    <component :is="copiedCode === 'controller' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.controller }}</code></pre>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Settings class="w-4 h-4 text-[#2B4C7E]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">ProjectService.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.service, 'service')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#2B4C7E] transition-colors"
                                >
                                    <component :is="copiedCode === 'service' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.service }}</code></pre>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Shield class="w-4 h-4 text-[#6BA3D4]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">EnsureRole.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.middleware, 'middleware')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#2B4C7E] transition-colors"
                                >
                                    <component :is="copiedCode === 'middleware' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#24292f] dark:text-[#e6edf3]"><code>{{ codeExamples.middleware }}</code></pre>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#d0d7de] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f6f8fa] dark:bg-[#161b22] border-b border-[#d0d7de] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Eye class="w-4 h-4 text-[#F4B41A]" :stroke-width="2" />
                                    <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">views/projects/show.blade.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.view, 'view')"
                                    class="text-[#656d76] dark:text-[#7d8590] hover:text-[#2B4C7E] transition-colors"
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

        <section class="relative isolate overflow-hidden bg-gray-900">
            <BackgroundGradient />
            <section class="py-20 px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center space-y-8">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                        Pronto para acelerar o desenvolvimento?
                    </h2>
                    <p class="text-xl text-white/90">
                        Baixe o Template Padrão MVC e obtenha uma base pronta para integrações, APIs e front-ends modernos.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a
                            :href="route(CTA_LINKS.download)"
                            class="group inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white text-[#2B4C7E] font-bold rounded-lg hover:shadow-xl transition-all"
                        >
                            <CloudDownload class="w-5 h-5" :stroke-width="2.5" />
                            <span>Download Gratuito</span>
                            <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                        </a>
                        <Link
                            :href="route('home')"
                            class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-[#2B4C7E] transition-all"
                        >
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
</style>
