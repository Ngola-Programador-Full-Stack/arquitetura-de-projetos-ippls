<script setup lang="ts">
import {
    Package, Box, FileCode,
    Workflow, Sparkles, Database
} from 'lucide-vue-next';

const technologies = [
    { name: 'Laravel 12', icon: Package, color: 'from-red-500 to-red-600', description: 'Framework PHP robusto' },
    { name: 'Vue 3', icon: Box, color: 'from-green-500 to-green-600', description: 'Framework JavaScript progressivo' },
    { name: 'TypeScript', icon: FileCode, color: 'from-blue-500 to-blue-600', description: 'JavaScript tipado' },
    { name: 'Inertia.js', icon: Workflow, color: 'from-purple-500 to-purple-600', description: 'Modern monolith' },
    { name: 'Tailwind CSS', icon: Sparkles, color: 'from-cyan-500 to-cyan-600', description: 'Utility-first CSS' },
    { name: 'MySQL', icon: Database, color: 'from-orange-500 to-orange-600', description: 'Banco de dados relacional' },
];


</script>
<template>
        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-24 px-4 sm:px-6 lg:px-8 dark:bg-[#010226]">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="text-4xl sm:text-5xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                        Tecnologia Moderna
                    </h2>
                    <p class="text-xl text-[#656d76] dark:text-[#7d8590]">
                        Construído com as melhores ferramentas do mercado
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="tech in technologies"
                        :key="tech.name"
                        class="group bg-white dark:bg-[#010226] rounded-lg p-6 border border-[#d0d7de] dark:border-[#30363d] hover:border-[#2B4C7E] dark:hover:border-[#6BA3D4] hover:shadow-lg transition-all"
                    >
                        <div class="flex items-start space-x-4">
                            <div :class="[
                                'w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform',
                                `bg-gradient-to-br ${tech.color}`
                            ]">
                                <component :is="tech.icon" class="w-6 h-6 text-white" :stroke-width="2" />
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3]">
                                    {{ tech.name }}
                                </h3>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    {{ tech.description }}
                                </p>
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
