<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Cpu, Database, FileCode, Sparkles } from 'lucide-vue-next';

const architectureLevels = [
    {
        level: 'Base',
        routeName: 'templates.base',
        icon: FileCode,
        description: 'Estrutura MVC fundamental e direta',
        features: ['Models básicos', 'Views simples', 'Controllers essenciais', 'Configuração mínima', 'Rotas básicas'],
        color: 'from-[#4A8FC4] to-[#6BA3D4]',
        price: 'Gratuito',
    },
    {
        level: 'Padrão',
        routeName: 'templates.padrao',
        icon: Database,
        description: 'MVC completo com helpers e middlewares',
        features: [
            'Models + Services',
            'Views + Components',
            'Controllers + Middleware',
            'Helpers & Utils',
            'Validações avançadas',
            'Sistema de cache',
        ],
        color: 'from-[#F4B41A] to-[#F7C950]',
        featured: true,
        price: 'Gratuito',
    },
    {
        level: 'Avançado',
        routeName: 'templates.avancado',
        icon: Cpu,
        description: 'Arquitetura enterprise completa',
        features: ['Core System', 'Advanced Services', 'Middleware Chain', 'API Integration', 'Testing Suite', 'CI/CD Pipeline'],
        color: 'from-[#C1272D] to-[#E04850]',
        price: 'Gratuito',
    },
];
</script>
<template>
    <section
        id="architecture"
        class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center px-4 py-24 sm:px-6 lg:px-8 dark:bg-[#010226]"
    >
        <div class="mx-auto max-w-7xl">
            <div class="mb-16 space-y-4 text-center">
                <h2 class="text-4xl font-bold text-[#24292f] sm:text-5xl dark:text-[#e6edf3]">Escolha Seu Nível</h2>
                <p class="mx-auto max-w-3xl text-xl text-[#656d76] dark:text-[#7d8590]">Três níveis de complexidade para cada etapa da sua jornada</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div
                    v-for="arch in architectureLevels"
                    :key="arch.level"
                    :class="[
                        'relative rounded-xl bg-white p-8 transition-all duration-200 dark:bg-[#010226]',
                        arch.featured
                            ? 'scale-[1.02] border-2 border-[#F4B41A] shadow-lg hover:scale-[1.03]'
                            : 'border border-[#d0d7de] hover:-translate-y-1 hover:border-[#2B4C7E] hover:shadow-md dark:border-[#30363d] dark:hover:border-[#6BA3D4]',
                    ]"
                >
                    <div v-if="arch.featured" class="absolute -top-3 left-1/2 -translate-x-1/2 transform">
                        <div
                            class="flex items-center space-x-1.5 rounded-full bg-gradient-to-r from-[#F4B41A] to-[#F7C950] px-4 py-1.5 text-xs font-bold text-white"
                        >
                            <Star class="h-3.5 w-3.5 fill-white" :stroke-width="2" />
                            <span>MAIS POPULAR</span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div :class="['flex h-14 w-14 items-center justify-center rounded-lg', `bg-gradient-to-br ${arch.color}`]">
                            <component :is="arch.icon" class="h-7 w-7 text-white" :stroke-width="2" />
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <h3 class="text-2xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                                    {{ arch.level }}
                                </h3>
                                <span class="text-sm font-semibold text-[#2B4C7E] dark:text-[#6BA3D4]">
                                    {{ arch.price }}
                                </span>
                            </div>
                            <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                {{ arch.description }}
                            </p>
                        </div>

                        <ul class="space-y-2.5">
                            <li v-for="feature in arch.features" :key="feature" class="flex items-start space-x-2.5">
                                <CheckCircle2 class="mt-0.5 h-4 w-4 flex-shrink-0 text-[#2B4C7E] dark:text-[#6BA3D4]" :stroke-width="2" />
                                <span class="text-sm text-[#24292f] dark:text-[#c9d1d9]">
                                    {{ feature }}
                                </span>
                            </li>
                        </ul>

                        <button
                            :class="[
                                'w-full rounded-lg py-3 font-semibold shadow-md transition-all hover:shadow-lg',
                                arch.featured
                                    ? 'bg-[#F4B41A] text-white hover:-translate-y-0.5 hover:bg-[#D69E0E]'
                                    : 'bg-[#2B4C7E] text-white hover:-translate-y-0.5 hover:bg-[#1e3557] dark:bg-[#1f6feb] dark:hover:bg-[#1a5cd7]',
                            ]"
                        >
                            <Link :href="route(arch.routeName)" class="flex items-center justify-center gap-2">
                                <Sparkles class="h-4 w-4" :stroke-width="2" />
                                Explorar {{ arch.level }}
                            </Link>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    background: #0d1117;
}

::-webkit-scrollbar-thumb {
    background: #2b4c7e;
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: #1e3557;
}
</style>
