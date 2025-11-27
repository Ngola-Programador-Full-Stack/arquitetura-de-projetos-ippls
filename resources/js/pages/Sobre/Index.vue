<script setup lang="ts">
    import { Head, Link } from '@inertiajs/vue3';
    import {
    Layers, FileCode, Database, Code2
} from 'lucide-vue-next';
    import Navbar from '@/components/Navbar.vue';
    import AppFooter from '@/components/AppFooter.vue';
import ContactSection from '@/components/ContactSection.vue';
import BackToTop from '@/components/BackToTop.vue';
</script>
<template>
    <Head title="Sobre" />
    <div class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center min-h-screen dark:bg-[#010226]">
        <!-- Barra de Navegação -->
        <Navbar />

        <!-- Conteúdo Principal -->
        <section id="about" class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-24 px-4 sm:px-6 lg:px-8 dark:bg-[#010226]">
            <div class="max-w-7xl mx-auto">

                <div class="text-center mb-16 space-y-4">
                    <div class="inline-flex items-center space-x-2 px-4 py-2 bg-[#2B4C7E]/10 dark:bg-[#010226]/20 border border-[#2B4C7E]/20 dark:border-[#2B4C7E]/30 rounded-full">
                        <Code2 class="w-4 h-4 text-[#2B4C7E] dark:text-[#6BA3D4]" :stroke-width="2.5" />
                        <span class="text-sm font-semibold text-[#2B4C7E] dark:text-[#6BA3D4]">SOBRE</span>
                    </div>

                    <h2 class="text-4xl sm:text-5xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                        Arquitetura de Projetos IPPLS
                    </h2>

                    <p class="text-xl text-[#656d76] dark:text-[#7d8590] max-w-3xl mx-auto">
                        Plataforma de Padronização e Gestão de Projetos Acadêmicos
                    </p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">

                    <!-- Left Content -->
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                                O Problema que Resolvemos
                            </h3>
                            <p class="text-[#656d76] dark:text-[#7d8590] leading-relaxed">
                                Os estudantes enfrentam dificuldades significativas no desenvolvimento de projetos de programação web devido à falta de padronização, conhecimento limitado sobre arquiteturas de software, estruturas inadequadas e baixa qualidade nos projetos desenvolvidos.
                            </p>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                                Nossa Solução
                            </h3>
                            <p class="text-[#656d76] dark:text-[#7d8590] leading-relaxed">
                                Uma plataforma web robusta que implementa templates padronizados baseados na arquitetura MVC (Model-View-Controller), oferecendo três níveis de complexidade (Base, Padrão e Avançado) para diferentes necessidades pedagógicas, garantindo projetos estruturados e profissionais.
                            </p>
                        </div>

                        <!-- Project Stats -->
                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <div class="p-4 bg-[#f6f8fa] dark:bg-[#010226] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="text-3xl font-bold text-[#2B4C7E] dark:text-[#6BA3D4] mb-1">3</div>
                                <div class="text-sm font-medium text-[#656d76] dark:text-[#7d8590]">Níveis MVC</div>
                            </div>
                            <div class="p-4 bg-[#f6f8fa] dark:bg-[#010226] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="text-3xl font-bold text-[#C1272D] dark:text-[#E04850] mb-1">100%</div>
                                <div class="text-sm font-medium text-[#656d76] dark:text-[#7d8590]">Padronização</div>
                            </div>
                            <div class="p-4 bg-[#f6f8fa] dark:bg-[#010226] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="text-3xl font-bold text-[#F4B41A] mb-1">70%</div>
                                <div class="text-sm font-medium text-[#656d76] dark:text-[#7d8590]">Mais Rápido</div>
                            </div>
                            <div class="p-4 bg-[#f6f8fa] dark:bg-[#010226] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                                <div class="text-3xl font-bold text-[#4A8FC4] dark:text-[#6BA3D4] mb-1">24/7</div>
                                <div class="text-sm font-medium text-[#656d76] dark:text-[#7d8590]">Suporte</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Visual -->
                    <div class="relative">
                        <div class="relative bg-[#f6f8fa] dark:bg-[#010226] rounded-xl p-8 border border-[#d0d7de] dark:border-[#30363d]">
                            <div class="aspect-square bg-gradient-to-br from-[#2B4C7E] via-[#2B4C7E] to-[#F4B41A] dark:from-[#906500b3] dark:via-[#010226] dark:to-[#906500b3] rounded-lg flex items-center justify-center">
                                <div class="text-center space-y-4 p-8">
                                    <Layers class="w-20 h-20 text-white mx-auto" :stroke-width="1.5" />
                                    <div class="space-y-2">
                                        <div class="text-3xl font-bold text-white">MVC</div>
                                        <div class="text-sm font-semibold text-white/90">Arquitetura de Projetos</div>
                                        <div class="text-xs font-semibold text-white/70 tracking-widest">BASE • PADRÃO • AVANÇADO</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Decorative Elements -->
                            <div class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-[#F4B41A] to-[#F7C950] rounded-xl shadow-lg flex items-center justify-center transform rotate-12">
                                <FileCode class="w-8 h-8 text-white" :stroke-width="2" />
                            </div>

                            <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-gradient-to-br from-[#2B4C7E] to-[#4A8FC4] rounded-xl shadow-lg flex items-center justify-center transform -rotate-12">
                                <Database class="w-8 h-8 text-white" :stroke-width="2" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inline-flex ">
                    <Link :href="route('home')"
                    class="bg-none text-ippls-blue-dark dark:text-gray-300 text-sm border-2 border-ippls-blue-dark px-3 py-2 rounded-xl font-semibold shadow-md shadow-ippls-blue-dark hover:shadow-lg hover:bg-ippls-blue-dark hover:text-white"
                    >
                        Página inicial
                    </Link>
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
