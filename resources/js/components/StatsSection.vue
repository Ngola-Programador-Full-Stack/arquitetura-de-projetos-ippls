<script setup lang="ts">
import {
    Layers, Users, Zap, Target,
} from 'lucide-vue-next';

const stats = [
    { number: 100, suffix: '%', label: 'Padronização', icon: Target },
    { number: 3, suffix: '', label: 'Níveis MVC', icon: Layers },
    { number: 70, suffix: '%', label: 'Mais Rápido', icon: Zap },
    { number: 500, suffix: '+', label: 'Estudantes', icon: Users }
];
</script>
<template>
        <section class="stats-section py-16 px-4 sm:px-6 lg:px-8 bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center dark:bg-[#010226] border-y border-[#d0d7de] dark:bg-[#010226]">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        v-for="(stat) in stats"
                        :key="stat.label"
                        class="text-center space-y-2 group"
                    >
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-[#2B4C7E]/5 dark:bg-[#2B4C7E]/15 rounded-lg group-hover:scale-110 transition-transform">
                            <component :is="stat.icon" class="w-6 h-6 text-[#2B4C7E] dark:text-[#6BA3D4]" :stroke-width="2" />
                        </div>
                        <div class="space-y-1">
                            <div class="text-4xl lg:text-5xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                                <span class="stat-number" :data-target="stat.number">0</span><span>{{ stat.suffix }}</span>
                            </div>
                            <div class="text-sm font-medium text-[#656d76] dark:text-[#7d8590]">
                                {{ stat.label }}
                            </div>
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
    background: #2B4C7E;
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: #1e3557;
}
</style>
