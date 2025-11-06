<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { 
    Folder, 
    Settings, 
    CheckCircle, 
    ClipboardList, 
    Bell, 
    Users, 
    Edit, 
    Star, 
    BarChart, 
    User 
} from 'lucide-vue-next';

interface User {
    id: number;
    name: string;
    email: string;
    tipo: 'coordenador' | 'professor' | 'estudante';
    curso?: {
        nome: string;
    };
    turma?: {
        nome: string;
    };
}

interface Props {
    user: User;
    userType: string;
    dashboardData?: any;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Painel de Controle',
        href: '/dashboard',
    },
];

// Título personalizado baseado no tipo de usuário
const dashboardTitle = computed(() => {
    const titles = {
        coordenador: 'Dashboard - Coordenador',
        professor: 'Dashboard - Professor', 
        estudante: 'Dashboard - Estudante'
    };
    return titles[props.userType as keyof typeof titles] || 'Dashboard';
});

// Descrição baseada no tipo de usuário
const dashboardDescription = computed(() => {
    const descriptions = {
        coordenador: 'Visão geral do sistema e gestão institucional',
        professor: 'Acompanhe projetos e avaliações dos estudantes',
        estudante: 'Explore projetos e acompanhe seu progresso acadêmico'
    };
    return descriptions[props.userType as keyof typeof descriptions] || 'Bem-vindo ao sistema';
});

// Métodos para labels e ícones das estatísticas
const getStatLabel = (key: string): string => {
    const labels: Record<string, string> = {
        'meus_projetos': 'Meus Projetos',
        'projetos_em_desenvolvimento': 'Em Desenvolvimento',
        'projetos_concluidos': 'Concluídos',
        'projetos_disponiveis': 'Disponíveis',
        'notificacoes_nao_lidas': 'Notificações',
        'estudantes_turmas': 'Estudantes',
        'instancias_para_avaliar': 'Para Avaliar',
        'avaliacoes_realizadas': 'Avaliações',
        'nota_media_avaliacoes': 'Nota Média',
        'total_usuarios': 'Usuários',
        'total_projetos': 'Projetos',
        'total_instancias': 'Instâncias',
        'total_avaliacoes': 'Avaliações',
        'nota_media_geral': 'Nota Média'
    };
    return labels[key] || key.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
};

const getStatIcon = (key: string) => {
    const icons: Record<string, any> = {
        'meus_projetos': Folder,
        'projetos_em_desenvolvimento': Settings,
        'projetos_concluidos': CheckCircle,
        'projetos_disponiveis': ClipboardList,
        'notificacoes_nao_lidas': Bell,
        'estudantes_turmas': Users,
        'instancias_para_avaliar': Edit,
        'avaliacoes_realizadas': Star,
        'nota_media_avaliacoes': BarChart,
        'total_usuarios': User,
        'total_projetos': Folder,
        'total_instancias': Settings,
        'total_avaliacoes': Star,
        'nota_media_geral': BarChart
    };
    return icons[key] || BarChart;
};

const getProjectsTitle = (): string => {
    const titles = {
        'estudante': 'Meus Projetos',
        'professor': 'Projetos para Avaliar',
        'coordenador': 'Projetos Recentes'
    };
    return titles[props.userType as keyof typeof titles] || 'Projetos';
};

const getNotificationsTitle = (): string => {
    const titles = {
        'estudante': 'Notificações Recentes',
        'professor': 'Avaliações Recentes',
        'coordenador': 'Atividade Recente'
    };
    return titles[props.userType as keyof typeof titles] || 'Notificações';
};

const getStatusClass = (status: string): string => {
    const classes: Record<string, string> = {
        'iniciado': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'em_desenvolvimento': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'concluido': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'abandonado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
    };
    return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
};

const getStatusLabel = (status: string): string => {
    const labels: Record<string, string> = {
        'iniciado': 'Iniciado',
        'em_desenvolvimento': 'Em Desenvolvimento',
        'concluido': 'Concluído',
        'abandonado': 'Abandonado'
    };
    return labels[status] || status;
};

const getNotificationTypeClass = (type: string): string => {
    const classes: Record<string, string> = {
        'sucesso': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'info': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'aviso': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'erro': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
    };
    return classes[type] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
};

const getNotificationTypeLabel = (type: string): string => {
    const labels: Record<string, string> = {
        'sucesso': 'Sucesso',
        'info': 'Informação',
        'aviso': 'Aviso',
        'erro': 'Erro'
    };
    return labels[type] || type;
};
</script>

<template>
    <Head :title="dashboardTitle" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Header personalizado -->
        <template #header>
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ dashboardTitle }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ dashboardDescription }}
                    </p>
                    <div v-if="user.curso || user.turma" class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                        <span v-if="user.curso">Curso: {{ user.curso.nome }}</span>
                        <span v-if="user.curso && user.turma"> | </span>
                        <span v-if="user.turma">Turma: {{ user.turma.nome }}</span>
                    </div>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-500">
                    Bem-vindo, <strong>{{ user.name }}</strong>
                </div>
            </div>
        </template>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- Dashboard com dados reais -->
            <div v-if="dashboardData" class="space-y-6">
                <!-- Estatísticas principais -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div v-for="(value, key) in dashboardData.estatisticas || dashboardData.estatisticas_gerais" 
                         :key="key"
                         class="bg-white dark:bg-gray-800 rounded-lg border p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ getStatLabel(key) }}
                                </p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ value }}
                                </p>
                            </div>
                            <div class="text-2xl">
                                <component :is="getStatIcon(key)" class="w-6 h-6" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo específico por tipo de usuário -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Projetos/Instâncias -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg border p-6">
                        <h3 class="text-lg font-semibold mb-4">
                            {{ getProjectsTitle() }}
                        </h3>
                        <div v-if="dashboardData.projetos_recentes?.length" class="space-y-3">
                            <div v-for="projeto in dashboardData.projetos_recentes" 
                                 :key="projeto.id"
                                 class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-medium">{{ projeto.titulo || projeto.projeto }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ projeto.estudante || 'Progresso: ' + projeto.progresso + '%' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                          :class="getStatusClass(projeto.status)">
                                        {{ getStatusLabel(projeto.status) }}
                                    </span>
                                    <p v-if="projeto.nota" class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Nota: {{ projeto.nota }}/20
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center text-gray-500 py-8">
                            Nenhum projeto encontrado
                        </div>
                    </div>

                    <!-- Notificações ou Avaliações -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg border p-6">
                        <h3 class="text-lg font-semibold mb-4">
                            {{ getNotificationsTitle() }}
                        </h3>
                        <div v-if="dashboardData.notificacoes_recentes?.length || dashboardData.avaliacoes_recentes?.length" 
                             class="space-y-3">
                            <div v-for="item in (dashboardData.notificacoes_recentes || dashboardData.avaliacoes_recentes)" 
                                 :key="item.id"
                                 class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-medium">{{ item.titulo || item.projeto }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ item.mensagem || item.estudante }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span v-if="item.tipo" 
                                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                          :class="getNotificationTypeClass(item.tipo)">
                                        {{ getNotificationTypeLabel(item.tipo) }}
                                    </span>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ item.data }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center text-gray-500 py-8">
                            Nenhuma notificação encontrada
                        </div>
                    </div>
                </div>

                <!-- Distribuições para coordenadores -->
                <div v-if="userType === 'coordenador' && dashboardData.distribuicao_projetos" 
                     class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg border p-6">
                        <h3 class="text-lg font-semibold mb-4">Distribuição de Projetos</h3>
                        <div class="space-y-3">
                            <div v-for="(value, key) in dashboardData.distribuicao_projetos" 
                                 :key="key"
                                 class="flex justify-between items-center">
                                <span class="capitalize">{{ key.replace('_', ' ') }}</span>
                                <span class="font-semibold">{{ value }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg border p-6">
                        <h3 class="text-lg font-semibold mb-4">Distribuição de Usuários</h3>
                        <div class="space-y-3">
                            <div v-for="(value, key) in dashboardData.distribuicao_usuarios" 
                                 :key="key"
                                 class="flex justify-between items-center">
                                <span class="capitalize">{{ key }}</span>
                                <span class="font-semibold">{{ value }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fallback para dados não disponíveis -->
            <div v-else class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-muted-foreground max-w-md">
                        <div class="text-2xl font-bold mb-4">{{ dashboardTitle }}</div>
                        <p class="text-lg mb-4">{{ dashboardDescription }}</p>
                        <p class="text-sm">
                            Carregando dados do dashboard...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
