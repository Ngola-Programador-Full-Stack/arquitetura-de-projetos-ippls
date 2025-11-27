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
    Cpu,
    Cloud,
    LineChart,
    Rocket
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
    Cpu,
    Cloud,
    LineChart,
    Rocket
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
        icon: Cpu,
        title: 'Arquitetura em Módulos',
        description: 'Domínios independentes com módulos isolados, facilitando manutenção e escalabilidade horizontal.'
    },
    {
        icon: Cloud,
        title: 'Infraestrutura Observável',
        description: 'Integração com filas, cache distribuído e monitoramento centralizado para operações críticas.'
    },
    {
        icon: LineChart,
        title: 'Pipelines Automatizados',
        description: 'Fluxos CI/CD pré-configurados com testes, lint e deploy automatizado para múltiplos ambientes.'
    },
    {
        icon: Shield,
        title: 'Segurança Corporativa',
        description: 'Autenticação multifator, auditoria completa e políticas de acesso avançadas com granularidade por domínio.'
    }
];

const defaultDirectoryStructure: DirectoryItem[] = [
    { name: 'projeto_avancado/', icon: Folder, level: 0, type: 'folder' },
    { name: 'apps/', icon: FolderOpen, level: 1, type: 'folder', description: 'Entrypoints para APIs, SPA e workers' },
    { name: 'api/', icon: FolderOpen, level: 2, type: 'folder', description: 'App responsável pela camada REST' },
    { name: 'spa/', icon: FolderOpen, level: 2, type: 'folder', description: 'Client Vue 3 integrado via Inertia' },
    { name: 'modules/', icon: Layers, level: 1, type: 'folder', description: 'Domínios independentes com lógica isolada' },
    { name: 'Users/', icon: Users, level: 2, type: 'folder', description: 'Domínio de usuários e RBAC' },
    { name: 'Projects/', icon: FolderOpen, level: 2, type: 'folder', description: 'Domínio de gestão de projetos e workflows' },
    { name: 'Support/', icon: Shield, level: 2, type: 'folder', description: 'Domínio de auditoria e logs' },
    { name: 'domains/', icon: Workflow, level: 1, type: 'folder', description: 'Camada de domínio com agregados e serviços' },
    { name: 'infrastructure/', icon: Package, level: 1, type: 'folder', description: 'Conexões com cache, filas, storage, eventos' },
    { name: 'database/', icon: Database, level: 1, type: 'folder', description: 'Migrations versionadas e seeds por módulo' },
    { name: 'tests/', icon: FileText, level: 1, type: 'folder', description: 'Suites de testes Feature, Unit e Contract' },
    { name: 'docker/', icon: Package, level: 1, type: 'folder', description: 'Configurações Docker e docker-compose.yml' },
    { name: 'deploy/', icon: CloudDownload, level: 1, type: 'folder', description: 'Scripts CI/CD e pipelines' }
];

const defaultInstallationSteps = [
    {
        step: '01',
        title: 'Preparar Ambiente',
        description: 'Instale Docker, Docker Compose e garanta suporte a Make ou Sail para orquestrar serviços.',
        icon: Cloud,
        color: 'from-[#0f172a] to-[#1e3a8a]'
    },
    {
        step: '02',
        title: 'Subir Containers',
        description: 'Execute make up ou ./vendor/bin/sail up -d para iniciar web, queue, cache e banco.',
        icon: Server,
        color: 'from-[#4A8FC4] to-[#6BA3D4]'
    },
    {
        step: '03',
        title: 'Rodar Setup',
        description: 'Rode scripts de inicialização: composer install, npm install, php artisan migrate --seed.',
        icon: Package,
        color: 'from-[#C1272D] to-[#E04850]'
    },
    {
        step: '04',
        title: 'Ativar Observabilidade',
        description: 'Configure Horizon, Octane, Telescope e integrações de métricas com Prometheus/Grafana.',
        icon: LineChart,
        color: 'from-[#F4B41A] to-[#F7C950]'
    }
];

const codeExamples = {
    moduleProvider: `<?php
// modules/Projects/Providers/ProjectsServiceProvider.php

namespace Modules\Projects\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ProjectsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'projects');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'projects');

        Route::middleware(['web', 'auth'])
            ->prefix('projects')
            ->group(__DIR__.'/../Routes/web.php');
    }
}`,

    aggregate: `<?php
// domains/Projects/Aggregates/ProjectAggregate.php

namespace Domains\Projects\Aggregates;

use Domains\Projects\Events\ProjectCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class ProjectAggregate extends AggregateRoot
{
    public function create(array $payload): self
    {
        $this->recordThat(new ProjectCreated(
            projectId: $payload['id'],
            name: $payload['name'],
            ownerId: $payload['owner_id']
        ));

        return $this;
    }
}
`,

    pipeline: `# deploy/pipeline.yml
name: Deploy Avançado

on:
  push:
    branches: [ main ]

jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - run: composer install --prefer-dist
      - run: npm ci && npm run build
      - run: php artisan test --parallel

  deploy:
    needs: tests
    runs-on: ubuntu-latest
    steps:
      - uses: appleboy/scp-action@v0.1.7
        with:
          host: \${{ secrets.SERVER_HOST }}
          username: \${{ secrets.SERVER_USER }}
          key: \${{ secrets.SERVER_SSH_KEY }}
          source: 'release/'
          target: '/var/www/ippls-avancado'
`,

    horizon: `<?php
// apps/api/app/Providers/HorizonServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class HorizonServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Horizon::routeSlackNotificationsTo(config('services.slack.webhook'));

        Horizon::auth(function ($request) {
            return Gate::allows('viewHorizon', [$request->user()]);
        });
    }
}`
};

const requirements = [
    { name: 'PHP', version: '>= 8.2', icon: FileCode },
    { name: 'Docker', version: '>= 24', icon: Cloud },
    { name: 'Node.js', version: '>= 18', icon: Server },
    { name: 'Redis & Horizon', version: 'Obrigatório', icon: Database }
];

const benefits = [
    'Arquitetura modular com separação por domínios e camadas',
    'Integração com filas, cache distribuído e pipelines CI/CD',
    'Observabilidade com logs estruturados, métricas e tracing',
    'Suporte a event sourcing e domain events com histórico completo',
    'Templates para testes de contrato, feature e domínio',
    'Scripts de deploy automatizado para ambientes multi-stage'
];

const useCases = [
    {
        title: 'Plataformas SaaS',
        description: 'Aplicações multi-tenant com escalabilidade horizontal e billing integrado.',
        icon: Rocket
    },
    {
        title: 'Sistemas Financeiros',
        description: 'Processamento de transações, auditoria e conciliação em tempo real.',
        icon: LineChart
    },
    {
        title: 'Ecossistemas de APIs',
        description: 'Gateway central com módulos independentes e versionamento flexível.',
        icon: Server
    },
    {
        title: 'Plataformas Educacionais',
        description: 'Gestão de jornadas, avaliações e automações com fila e notificações.',
        icon: GraduationCap
    }
];

const CTA_LINKS = {
    download: 'templates.avancado.download',
    explore: 'templates.avancado'
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
    <Head title="Template Avançado MVC - IPPLS" />

    <div class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center min-h-screen bg-white dark:bg-[#010226]">
        <Navbar />

        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden dark:bg-[#010226]">
            <div class="absolute inset-0 opacity-[0.02] dark:opacity-[0.1]">
                <div class="absolute inset-0" style="background-image: linear-gradient(rgba(15, 23, 42, 0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(15, 23, 42, 0.2) 1px, transparent 1px); background-size: 80px 80px;"></div>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="flex items-center space-x-2 text-sm mb-8">
                    <Link :href="route('home')" class="text-[#94A3B8] dark:text-[#7d8590] hover:text-[#38bdf8] dark:hover:text-[#38bdf8] transition-colors">
                        <Home class="w-4 h-4" :stroke-width="2" />
                    </Link>
                    <ChevronRight class="w-4 h-4 text-[#94A3B8] dark:text-[#7d8590]" :stroke-width="2" />
                    <span class="text-[#94A3B8] dark:text-[#7d8590]">Templates</span>
                    <ChevronRight class="w-4 h-4 text-[#94A3B8] dark:text-[#7d8590]" :stroke-width="2" />
                    <span class="text-[#0f172a] dark:text-[#f8fafc] font-medium">Avançado Enterprise</span>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <div class="inline-flex items-center space-x-2 px-4 py-2 bg-[#0f172a]/15 dark:bg-[#0f172a]/25 border border-[#0f172a]/20 dark:border-[#38bdf8]/30 rounded-full">
                            <Rocket class="w-4 h-4 text-[#38bdf8]" :stroke-width="2.5" />
                            <span class="text-sm font-semibold text-[#38bdf8]">TEMPLATE AVANÇADO</span>
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight text-[#0f172a] dark:text-[#f8fafc]">
                                Template Avançado
                                <span class="block mt-2 bg-gradient-to-r from-[#0f172a] via-[#38bdf8] to-[#F59E0B] bg-clip-text text-transparent">
                                    Arquitetura Enterprise
                                </span>
                            </h1>

                            <p class="text-lg text-[#475569] dark:text-[#94A3B8] leading-relaxed">
                                Plataforma completa para projetos mission critical. Inclui modularização, pipelines de deploy, observabilidade integrada e suporte a arquiteturas orientadas a eventos.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a
                                :href="route(CTA_LINKS.download)"
                                class="group inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-[#0f172a] to-[#38bdf8] text-white font-semibold rounded-lg hover:shadow-xl transition-all"
                            >
                                <CloudDownload class="w-5 h-5" :stroke-width="2.5" />
                                <span>Download Enterprise</span>
                                <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                            </a>

                            <Link
                                :href="route(CTA_LINKS.explore)"
                                class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-white dark:bg-[#0d1117] border border-[#cbd5f5] dark:border-[#30363d] hover:border-[#38bdf8] dark:hover:border-[#38bdf8] text-[#0f172a] dark:text-[#f8fafc] font-semibold rounded-lg transition-all"
                            >
                                <Github class="w-5 h-5" :stroke-width="2.5" />
                                <span>Explorar GitHub</span>
                            </Link>
                        </div>

                        <div class="flex flex-wrap gap-4 pt-4">
                            <div class="flex items-center space-x-2 px-4 py-2 bg-white/60 dark:bg-[#161b22] rounded-lg border border-[#cbd5f5] dark:border-[#30363d]">
                                <CheckCircle2 class="w-4 h-4 text-[#38bdf8]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#0f172a] dark:text-[#f8fafc]">Event Sourcing</span>
                            </div>
                            <div class="flex items-center space-x-2 px-4 py-2 bg-white/60 dark:bg-[#161b22] rounded-lg border border-[#cbd5f5] dark:border-[#30363d]">
                                <Shield class="w-4 h-4 text-[#F59E0B]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#0f172a] dark:text-[#f8fafc]">Security by Design</span>
                            </div>
                            <div class="flex items-center space-x-2 px-4 py-2 bg-white/60 dark:bg-[#161b22] rounded-lg border border-[#cbd5f5] dark:border-[#30363d]">
                                <Terminal class="w-4 h-4 text-[#38bdf8]" :stroke-width="2" />
                                <span class="text-sm font-medium text-[#0f172a] dark:text-[#f8fafc]">CI/CD Automatizado</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="relative bg-[#f8fafc] dark:bg-[#0d1117] rounded-xl p-6 border border-[#cbd5f5] dark:border-[#30363d] shadow-lg">
                            <div class="space-y-1 font-mono text-sm">
                                <div
                                    v-for="(item, index) in directoryStructure.slice(0, 12)"
                                    :key="index"
                                    class="flex items-center space-x-2 py-1.5"
                                    :style="{ paddingLeft: (item.level * 20) + 'px' }"
                                >
                                    <component
                                        :is="item.icon"
                                        class="w-4 h-4 flex-shrink-0"
                                        :class="item.type === 'folder' ? 'text-[#0f172a] dark:text-[#38bdf8]' : 'text-[#475569] dark:text-[#94A3B8]'"
                                        :stroke-width="2"
                                    />
                                    <span class="text-[#0f172a] dark:text-[#f8fafc]">{{ item.name }}</span>
                                </div>
                                <div class="flex items-center space-x-2 py-1.5 pl-5 text-[#475569] dark:text-[#94A3B8]">
                                    <span>...</span>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -top-4 -right-4 bg-gradient-to-br from-[#0f172a] to-[#38bdf8] rounded-lg p-3 shadow-lg transform rotate-3">
                            <Cpu class="w-6 h-6 text-white" :stroke-width="2.5" />
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

                <Link :href="route('templates.padrao')" target="_blank" class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-white dark:bg-[#0d1117] border border-[#d0d7de] dark:border-[#30363d] hover:border-[#4A8FC4] dark:hover:border-[#6BA3D4] text-[#24292f] dark:text-[#e6edf3] font-semibold rounded-lg transition-all bg-none text-sm shadow-md shadow-ippls-blue-dark hover:shadow-lg hover:bg-ippls-blue-dark hover:text-white">
                    <Eye class="w-5 h-5" :stroke-width="2.5" />
                    <span>Ver Template Padrão</span>
                    <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                </Link>
            </div>
        </section>

        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-16 px-4 sm:px-6 lg:px-8 bg-[#f1f5f9] dark:bg-[#010226]">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#0f172a] dark:text-[#f8fafc] mb-4">
                        Por que o Template Avançado?
                    </h2>
                    <p class="text-lg text-[#475569] dark:text-[#94A3B8]">
                        Voltado para projetos de alta complexidade, com foco em escalabilidade, performance e governança.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d] hover:border-[#38bdf8] hover:shadow-md transition-all"
                    >
                        <div class="w-12 h-12 bg-gradient-to-br from-[#0f172a] via-[#38bdf8] to-[#F59E0B] rounded-lg flex items-center justify-center mb-4">
                            <component :is="feature.icon" class="w-6 h-6 text-white" :stroke-width="2" />
                        </div>
                        <h3 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc] mb-2">{{ feature.title }}</h3>
                        <p class="text-sm text-[#475569] dark:text-[#94A3B8]">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 px-4 sm:px-6 lg:px-8 dark:bg-[#010226]">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-wrap gap-2 mb-8 border-b border-[#cbd5f5] dark:border-[#30363d]">
                    <button
                        @click="activeTab = 'overview'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'overview'
                                ? 'text-[#0f172a] dark:text-[#38bdf8] border-b-2 border-[#0f172a] dark:border-[#38bdf8]'
                                : 'text-[#475569] dark:text-[#94A3B8] hover:text-[#0f172a] dark:hover:text-[#f8fafc]'
                        ]"
                    >
                        Visão Geral
                    </button>
                    <button
                        @click="activeTab = 'structure'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'structure'
                                ? 'text-[#0f172a] dark:text-[#38bdf8] border-b-2 border-[#0f172a] dark:border-[#38bdf8]'
                                : 'text-[#475569] dark:text-[#94A3B8] hover:text-[#0f172a] dark:hover:text-[#f8fafc]'
                        ]"
                    >
                        Estrutura
                    </button>
                    <button
                        @click="activeTab = 'installation'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'installation'
                                ? 'text-[#0f172a] dark:text-[#38bdf8] border-b-2 border-[#0f172a] dark:border-[#38bdf8]'
                                : 'text-[#475569] dark:text-[#94A3B8] hover:text-[#0f172a] dark:hover:text-[#f8fafc]'
                        ]"
                    >
                        Instalação
                    </button>
                    <button
                        @click="activeTab = 'code'"
                        :class="[
                            'px-6 py-3 font-semibold transition-all',
                            activeTab === 'code'
                                ? 'text-[#0f172a] dark:text-[#38bdf8] border-b-2 border-[#0f172a] dark:border-[#38bdf8]'
                                : 'text-[#475569] dark:text-[#94A3B8] hover:text-[#0f172a] dark:hover:text-[#f8fafc]'
                        ]"
                    >
                        Exemplos de Código
                    </button>
                </div>

                <div class="mt-8">
                    <div v-show="activeTab === 'overview'" class="space-y-8">
                        <div class="grid lg:grid-cols-2 gap-8">
                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d]">
                                <h3 class="text-xl font-bold text-[#0f172a] dark:text-[#f8fafc] mb-4 flex items-center space-x-2">
                                    <AlertCircle class="w-5 h-5 text-[#38bdf8]" :stroke-width="2" />
                                    <span>Requisitos</span>
                                </h3>
                                <div class="space-y-3">
                                    <div
                                        v-for="req in requirements"
                                        :key="req.name"
                                        class="flex items-center justify-between p-3 bg-[#f8fafc] dark:bg-[#161b22] rounded-lg"
                                    >
                                        <div class="flex items-center space-x-3">
                                            <component :is="req.icon" class="w-5 h-5 text-[#38bdf8]" :stroke-width="2" />
                                            <span class="font-medium text-[#0f172a] dark:text-[#f8fafc]">{{ req.name }}</span>
                                        </div>
                                        <span class="text-sm text-[#475569] dark:text-[#94A3B8]">{{ req.version }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d]">
                                <h3 class="text-xl font-bold text-[#0f172a] dark:text-[#f8fafc] mb-4 flex items-center space-x-2">
                                    <Star class="w-5 h-5 text-[#F59E0B] fill-[#F59E0B]" :stroke-width="2" />
                                    <span>Benefícios</span>
                                </h3>
                                <ul class="space-y-3">
                                    <li
                                        v-for="benefit in benefits"
                                        :key="benefit"
                                        class="flex items-start space-x-3"
                                    >
                                        <CheckCircle2 class="w-5 h-5 text-[#38bdf8] flex-shrink-0 mt-0.5" :stroke-width="2" />
                                        <span class="text-[#0f172a] dark:text-[#cbd5f5]">{{ benefit }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-[#0f172a] dark:text-[#f8fafc] mb-6">
                                Casos de Uso
                            </h3>
                            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div
                                    v-for="useCase in useCases"
                                    :key="useCase.title"
                                    class="bg-white dark:bg-[#0d1117] rounded-lg p-5 border border-[#cbd5f5] dark:border-[#30363d] hover:border-[#38bdf8] transition-all"
                                >
                                    <component :is="useCase.icon" class="w-8 h-8 text-[#38bdf8] mb-3" :stroke-width="2" />
                                    <h4 class="font-bold text-[#0f172a] dark:text-[#f8fafc] mb-2">{{ useCase.title }}</h4>
                                    <p class="text-sm text-[#475569] dark:text-[#94A3B8]">{{ useCase.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'structure'" class="space-y-6">
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d]">
                            <h3 class="text-xl font-bold text-[#0f172a] dark:text-[#f8fafc] mb-6">
                                Estrutura Modular Completa
                            </h3>
                            <div class="space-y-1 font-mono text-sm">
                                <div
                                    v-for="(item, index) in directoryStructure"
                                    :key="index"
                                    class="group flex items-start space-x-3 py-2 hover:bg-[#f8fafc] dark:hover:bg-[#161b22] rounded px-3 transition-colors"
                                    :style="{ paddingLeft: (item.level * 24 + 12) + 'px' }"
                                >
                                    <component
                                        :is="item.icon"
                                        class="w-4 h-4 flex-shrink-0 mt-0.5"
                                        :class="item.type === 'folder' ? 'text-[#0f172a] dark:text-[#38bdf8]' : 'text-[#475569] dark:text-[#94A3B8]'"
                                        :stroke-width="2"
                                    />
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-[#0f172a] dark:text-[#f8fafc] font-medium">{{ item.name }}</span>
                                        </div>
                                        <p v-if="item.description" class="text-xs text-[#475569] dark:text-[#94A3B8] mt-1">{{ item.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-3 gap-6">
                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#0f172a] to-[#1d4ed8] rounded-lg flex items-center justify-center mb-4">
                                    <Layers class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc] mb-2">Domínios Independentes</h4>
                                <p class="text-sm text-[#475569] dark:text-[#94A3B8]">
                                    Separação por domínios com contratos explícitos, reduzindo acoplamento e facilitando testes.
                                </p>
                            </div>

                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#1d4ed8] to-[#38bdf8] rounded-lg flex items-center justify-center mb-4">
                                    <Server class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc] mb-2">Infraestrutura Orquestrada</h4>
                                <p class="text-sm text-[#475569] dark:text-[#94A3B8]">
                                    Integrações com Redis, Horizon, Octane e pipelines de deploy automatizados.
                                </p>
                            </div>

                            <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d]">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#F59E0B] to-[#F97316] rounded-lg flex items-center justify-center mb-4">
                                    <LineChart class="w-6 h-6 text-white" :stroke-width="2" />
                                </div>
                                <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc] mb-2">Observabilidade</h4>
                                <p class="text-sm text-[#475569] dark:text-[#94A3B8]">
                                    Monitoramento com métricas, alertas e dashboards prontos para Prometheus/Grafana.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'installation'" class="space-y-8">
                        <div class="bg-gradient-to-r from-[#0f172a]/10 to-[#38bdf8]/10 border border-[#0f172a]/20 dark:border-[#38bdf8]/30 rounded-lg p-6">
                            <div class="flex items-start space-x-4">
                                <AlertCircle class="w-6 h-6 text-[#38bdf8] flex-shrink-0 mt-1" :stroke-width="2" />
                                <div>
                                    <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc] mb-2">Pré-requisitos</h4>
                                    <p class="text-[#475569] dark:text-[#94A3B8]">
                                        Prepare um ambiente com Docker, Node.js, Composer e suporte a filas Redis. Recomenda-se 8GB de RAM para containers.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div v-for="step in installationSteps" :key="step.step" class="relative">
                                <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d] hover:border-[#38bdf8] transition-all h-full">
                                    <div class="flex items-start space-x-4 mb-4">
                                        <div :class="['w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 bg-gradient-to-br', step.color]">
                                            <component :is="step.icon" class="w-6 h-6 text-white" :stroke-width="2" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-3xl font-bold text-[#0f172a]/30 dark:text-[#38bdf8]/30 mb-2">{{ step.step }}</div>
                                            <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc]">{{ step.title }}</h4>
                                        </div>
                                    </div>
                                    <p class="text-[#475569] dark:text-[#94A3B8]">{{ step.description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg p-6 border border-[#cbd5f5] dark:border-[#30363d]">
                            <h3 class="text-xl font-bold text-[#0f172a] dark:text-[#f8fafc] mb-6 flex items-center space-x-2">
                                <Terminal class="w-5 h-5 text-[#38bdf8]" :stroke-width="2" />
                                <span>Playbook de Setup</span>
                            </h3>

                            <div class="space-y-6">
                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc]">1. Inicializar Containers</h4>
                                    <div class="bg-[#f8fafc] dark:bg-[#161b22] rounded-lg p-4 border border-[#cbd5f5] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#0f172a] dark:text-[#f8fafc]">make up # ou ./vendor/bin/sail up -d</code>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc]">2. Instalar Dependências</h4>
                                    <div class="bg-[#f8fafc] dark:bg-[#161b22] rounded-lg p-4 border border-[#cbd5f5] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#0f172a] dark:text-[#f8fafc]">composer install && npm install</code>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc]">3. Migrar e Popular</h4>
                                    <div class="bg-[#f8fafc] dark:bg-[#161b22] rounded-lg p-4 border border-[#cbd5f5] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#0f172a] dark:text-[#f8fafc]">php artisan migrate --seed</code>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <h4 class="text-lg font-bold text-[#0f172a] dark:text-[#f8fafc]">4. Ativar Serviços</h4>
                                    <div class="bg-[#f8fafc] dark:bg-[#161b22] rounded-lg p-4 border border-[#cbd5f5] dark:border-[#30363d] font-mono text-sm">
                                        <code class="text-[#0f172a] dark:text-[#f8fafc]">php artisan horizon &amp;&amp; php artisan octane:start</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'code'" class="space-y-6">
                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#cbd5f5] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f8fafc] dark:bg-[#161b22] border-b border-[#cbd5f5] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Layers class="w-4 h-4 text-[#38bdf8]" :stroke-width="2" />
                                    <span class="font-semibold text-[#0f172a] dark:text-[#f8fafc]">ProjectsServiceProvider.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.moduleProvider, 'module')"
                                    class="text-[#475569] dark:text-[#94A3B8] hover:text-[#38bdf8] transition-colors"
                                >
                                    <component :is="copiedCode === 'module' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#0f172a] dark:text-[#f8fafc]"><code>{{ codeExamples.moduleProvider }}</code></pre>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#cbd5f5] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f8fafc] dark:bg-[#161b22] border-b border-[#cbd5f5] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Workflow class="w-4 h-4 text-[#38bdf8]" :stroke-width="2" />
                                    <span class="font-semibold text-[#0f172a] dark:text-[#f8fafc]">ProjectAggregate.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.aggregate, 'aggregate')"
                                    class="text-[#475569] dark:text-[#94A3B8] hover:text-[#38bdf8] transition-colors"
                                >
                                    <component :is="copiedCode === 'aggregate' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#0f172a] dark:text-[#f8fafc]"><code>{{ codeExamples.aggregate }}</code></pre>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#cbd5f5] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f8fafc] dark:bg-[#161b22] border-b border-[#cbd5f5] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Terminal class="w-4 h-4 text-[#38bdf8]" :stroke-width="2" />
                                    <span class="font-semibold text-[#0f172a] dark:text-[#f8fafc]">pipeline.yml</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.pipeline, 'pipeline')"
                                    class="text-[#475569] dark:text-[#94A3B8] hover:text-[#38bdf8] transition-colors"
                                >
                                    <component :is="copiedCode === 'pipeline' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#0f172a] dark:text-[#f8fafc]"><code>{{ codeExamples.pipeline }}</code></pre>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#0d1117] rounded-lg border border-[#cbd5f5] dark:border-[#30363d] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-3 bg-[#f8fafc] dark:bg-[#161b22] border-b border-[#cbd5f5] dark:border-[#30363d]">
                                <div class="flex items-center space-x-2">
                                    <Shield class="w-4 h-4 text-[#38bdf8]" :stroke-width="2" />
                                    <span class="font-semibold text-[#0f172a] dark:text-[#f8fafc]">HorizonServiceProvider.php</span>
                                </div>
                                <button
                                    @click="copyToClipboard(codeExamples.horizon, 'horizon')"
                                    class="text-[#475569] dark:text-[#94A3B8] hover:text-[#38bdf8] transition-colors"
                                >
                                    <component :is="copiedCode === 'horizon' ? Check : Copy" class="w-4 h-4" :stroke-width="2" />
                                </button>
                            </div>
                            <div class="p-6 overflow-x-auto">
                                <pre class="text-sm text-[#0f172a] dark:text-[#f8fafc]"><code>{{ codeExamples.horizon }}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative isolate overflow-hidden bg-[#0f172a] text-white">
            <BackgroundGradient />
            <section class="py-20 px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center space-y-8">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold">
                        Eleve sua arquitetura para o próximo nível
                    </h2>
                    <p class="text-xl text-white/80">
                        Utilize o Template Avançado MVC para acelerar entregas, garantir governança e rodar com segurança em produção.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a
                            :href="route(CTA_LINKS.download)"
                            class="group inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white text-[#0f172a] font-bold rounded-lg hover:shadow-xl transition-all"
                        >
                            <CloudDownload class="w-5 h-5" :stroke-width="2.5" />
                            <span>Download Completo</span>
                            <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                        </a>
                        <Link
                            :href="route('home')"
                            class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-[#0f172a] transition-all"
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
