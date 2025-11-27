<script setup lang="ts">
import { ChevronRight, Code2, Rocket, Settings, Target } from 'lucide-vue-next';

const workflow = [
    { step: '01', title: 'Escolha o Template', description: 'Escolha entre Base, Padrão ou Avançado', icon: Target },
    { step: '02', title: 'Configure o Projeto', description: 'Personalize configurações em minutos', icon: Settings },
    { step: '03', title: 'Desenvolva com Qualidade', description: 'Código padronizado e organizado', icon: Code2 },
    { step: '04', title: 'Deploy Simplificado', description: 'Pronto para produção instantaneamente', icon: Rocket },
];
</script>
<template>
    <section class="bg-cover bg-center px-4 py-24 sm:px-6 lg:px-8 bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] dark:bg-[#010226]">
        <div class="mx-auto max-w-7xl">
            <div class="mb-16 space-y-4 text-center">
                <h2 class="text-4xl font-bold text-[#24292f] sm:text-5xl dark:text-[#e6edf3]">Trabalho Simplificado</h2>
                <p class="mx-auto max-w-3xl text-xl text-[#656d76] dark:text-[#7d8590]">Do template ao deploy em 4 passos simples</p>
            </div>

            <div class="grid gap-6 md:grid-cols-4">
                <div v-for="(step, index) in workflow" :key="step.step" class="relative">
                    <div
                        class="group rounded-lg border border-[#d0d7de] bg-white p-6 transition-all hover:border-[#2B4C7E] dark:border-[#30363d] dark:bg-[#010226] dark:hover:border-[#6BA3D4]"
                    >
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#2B4C7E]/10 transition-transform group-hover:scale-110 dark:bg-[#2B4C7E]/20"
                                >
                                    <component :is="step.icon" class="h-6 w-6 text-[#2B4C7E] dark:text-[#6BA3D4]" :stroke-width="2" />
                                </div>
                                <span class="text-4xl font-bold text-[#2B4C7E]/20 dark:text-[#2B4C7E]/30">{{ step.step }}</span>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">
                                    {{ step.title }}
                                </h3>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    {{ step.description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Connector Arrow -->
                    <div v-if="index < workflow.length - 1" class="absolute top-1/2 -right-3 z-10 hidden -translate-y-1/2 transform md:block">
                        <ChevronRight class="h-6 w-6 text-[#d0d7de] dark:text-[#30363d]" :stroke-width="2" />
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
