<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Home, FolderOpenDot, Users2Icon, FileText, Bell, Star,  GraduationCap, BarChart3  } from 'lucide-vue-next';
import { computed, ref, onMounted } from 'vue';
import AppLogo from './AppLogo.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const notificacoesNaoLidas = ref(0);

// Função para buscar notificações não lidas
const buscarNotificacoesNaoLidas = async () => {
    if (!user.value) return;

    try {
        const response = await fetch('/notificacoes/nao-lidas', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });

        if (response.ok) {
            const data = await response.json();
            notificacoesNaoLidas.value = data.total_nao_lidas || 0;
        }
    } catch (error) {
        console.error('Erro ao buscar notificações:', error);
    }
};

// Buscar notificações quando o componente for montado
onMounted(() => {
    buscarNotificacoesNaoLidas();

    // Atualizar a cada 30 segundos
    setInterval(buscarNotificacoesNaoLidas, 30000);
});

// Itens de navegação baseados no tipo de usuário
const mainNavItems = computed((): NavItem[] => {
    const baseItems: NavItem[] = [
        {
            title: 'Painel de controle',
            href: '/dashboard',
            icon: LayoutGrid,
        },
        {
            title: 'Página inicial',
            href: '/',
            icon: Home,
        },
    ];

    if (!user.value) return baseItems;

    // Items comuns a todos os usuários autenticados
    const commonItems: NavItem[] = [
        {
            title: 'Notificações',
            href: '/notificacoes',
            icon: Bell,
            badge: notificacoesNaoLidas.value,
            badgeVariant: notificacoesNaoLidas.value > 0 ? 'destructive' : 'secondary'
        }
    ];

    // Items específicos por tipo de usuário
    let specificItems: NavItem[] = [];

    if (user.value.tipo === 'coordenador') {
        specificItems = [
            {
                title: 'Estudantes',
                href: '/estudantes',
                icon: Users2Icon,
            },
            {
                title: 'Professores',
                href: '/professores',
                icon: GraduationCap,
            },
            {
                title: 'Projetos',
                href: '/projetos',
                icon: Folder,
            },
            {
                title: 'Turmas',
                href: '/turmas',
                icon: Users2Icon,
            },
            {
                title: 'Templates de Arquitetura',
                href: '/templates',
                icon: FileText,
            },
            {
                title: 'Supervisão',
                href: '/supervisao',
                icon: BarChart3,
            }
        ];
    } else if (user.value.tipo === 'professor') {
        specificItems = [
            {
                title: 'Projetos Disponíveis',
                href: '/projetos',
                icon: Folder,
            },
            {
                title: 'Avaliações',
                href: '/avaliacoes',
                icon: Star,
            },
            {
                title: 'Templates de Arquitetura',
                href: '/templates',
                icon: FileText,
            }
        ];
    } else if (user.value.tipo === 'estudante') {
        specificItems = [
            {
                title: 'Meus Projetos',
                href: '/meus-projetos',
                icon: FolderOpenDot,
            },
            {
                title: 'Projetos Disponíveis',
                href: '/projetos',
                icon: Folder,
            },
            {
                title: 'Templates de Arquitetura',
                href: '/templates',
                icon: FileText,
            }
        ];
    }

    return [...baseItems, ...specificItems, ...commonItems];
});

const footerNavItems: NavItem[] = [
    {
        title: 'Repositório Github',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Visite a Documentação',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
