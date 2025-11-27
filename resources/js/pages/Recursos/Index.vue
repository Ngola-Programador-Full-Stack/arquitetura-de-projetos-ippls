<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppFooter from '@/components/AppFooter.vue';
import ContactSection from '@/components/ContactSection.vue';
import Navbar from '@/components/Navbar.vue';
import { BarChart3, FileCode, Shield, TrendingUp, Users, Zap } from 'lucide-vue-next';
import BackToTop from '@/components/BackToTop.vue';

const features = [
    {
        icon: FileCode,
        title: 'Templates MVC Profissionais',
        description: 'Arquitetura padronizada em três níveis de complexidade, pronta para produção.',
        gradient: 'from-[#2B4C7E] to-[#567FA6]',
        benefits: ['Estrutura organizada', 'Código padronizado', 'Best practices'],
    },
    {
        icon: TrendingUp,
        title: 'Gestão Inteligente',
        description: 'Dashboard completo com métricas em tempo real e notificações automáticas.',
        gradient: 'from-[#C1272D] to-[#E04850]',
        benefits: ['Analytics avançado', 'Relatórios detalhados', 'Acompanhamento live'],
    },
    {
        icon: Users,
        title: 'Multi-Usuário Enterprise',
        description: 'Sistema robusto com roles granulares para estudantes, professores e coordenadores.',
        gradient: 'from-[#F4B41A] to-[#F7C950]',
        benefits: ['Controle de acesso', 'Gestão de turmas', 'Sistema de avaliações'],
    },
    {
        icon: Zap,
        title: 'Produtividade Máxima',
        description: 'Reduza 70% do tempo de setup com configuração automática e templates prontos.',
        gradient: 'from-[#4A8FC4] to-[#6BA3D4]',
        benefits: ['Setup instantâneo', 'Auto-configuração', 'Deploy simplificado'],
    },
    {
        icon: Shield,
        title: 'Segurança Enterprise',
        description: 'Proteção de nível empresarial com criptografia, backups e auditoria completa.',
        gradient: 'from-[#2B4C7E] to-[#C1272D]',
        benefits: ['Criptografia ponta-a-ponta', 'Backup automático', 'Logs de auditoria'],
    },
    {
        icon: BarChart3,
        title: 'Analytics Avançado',
        description: 'Relatórios detalhados com exportação em múltiplos formatos e dashboards interativos.',
        gradient: 'from-[#F4B41A] to-[#C1272D]',
        benefits: ['Dashboards customizáveis', 'Exportação CSV/Excel/PDF', 'Gráficos interativos'],
    },
];
</script>
<template>
    <Head title="Recursos" />
    <div class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center min-h-screen dark:bg-[#010226]">
        <!-- Barra de Navegação -->
        <Navbar />

        <!-- Conteúdo Principal -->
        <section id="features" class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center px-4 py-24 sm:px-6 lg:px-8 dark:bg-[#010226]">
            <div class="mx-auto max-w-7xl">
                <div class="mb-16 space-y-4 text-center">
                    <h2 class="text-4xl font-bold text-[#24292f] sm:text-5xl dark:text-[#e6edf3]">Recursos da Plataforma</h2>
                    <p class="mx-auto max-w-3xl text-xl text-[#656d76] dark:text-[#7d8590]">
                        Funcionalidades enterprise para projetos acadêmicos profissionais
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="feature in features"
                        :key="feature.title"
                        class="group relative rounded-xl border border-[#d0d7de] bg-white p-6 transition-all duration-200 hover:-translate-y-1 hover:border-[#2B4C7E] hover:shadow-md dark:border-[#30363d] dark:bg-[#010226] dark:hover:border-[#6BA3D4]"
                    >
                        <div class="space-y-4">
                            <div :class="['flex h-12 w-12 items-center justify-center rounded-lg', `bg-gradient-to-br ${feature.gradient}`]">
                                <component :is="feature.icon" class="h-6 w-6 text-white" :stroke-width="2" />
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                                    {{ feature.title }}
                                </h3>
                                <p class="text-sm leading-relaxed text-[#656d76] dark:text-[#7d8590]">
                                    {{ feature.description }}
                                </p>
                            </div>

                            <ul class="space-y-2 pt-2">
                                <li
                                    v-for="benefit in feature.benefits"
                                    :key="benefit"
                                    class="flex items-center space-x-2 text-sm text-[#24292f] dark:text-[#c9d1d9]"
                                >
                                    <CheckCircle2 class="h-4 w-4 flex-shrink-0 text-[#2B4C7E] dark:text-[#6BA3D4]" :stroke-width="2" />
                                    <span>{{ benefit }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
            <!-- Tecnologia Moderna -->
         <ContactSection />

        <!-- Rodapé -->
        <AppFooter />
        
        <!-- BackToTop -->
        <BackToTop />
     </div>
</template>
<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
}

html {
    scroll-behavior: smooth;
}

::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: #f6f8fa;
}

.dark ::-webkit-scrollbar-track {
    background: #010226;
}

::-webkit-scrollbar-thumb {
    background: #2b4c7e;
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: #1e3557;
}
</style>
