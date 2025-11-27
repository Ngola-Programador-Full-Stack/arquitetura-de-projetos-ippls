<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import {
    Rocket, Shield,
    ArrowRight, CheckCircle2, Sparkles,
    FileCode, Cpu, Database,
    ChevronRight,  Play,Package, Workflow, GitBranch,
    Box, Blocks, Settings,
} from 'lucide-vue-next';


const scrolled = ref(false);
const activeTestimonial = ref(0);
const mousePosition = ref({ x: 0, y: 0 });

const handleScroll = () => {
    scrolled.value = window.scrollY > 50;
};

const handleMouseMove = (e: MouseEvent) => {
    mousePosition.value = {
        x: (e.clientX / window.innerWidth - 0.5) * 15,
        y: (e.clientY / window.innerHeight - 0.5) * 15
    };
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('mousemove', handleMouseMove);

    const observerOptions = { threshold: 0.3, rootMargin: '0px' };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.stat-number');
                counters.forEach((counter: any) => {
                    const target = parseInt(counter.getAttribute('data-target') || '0');
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;

                    const updateCounter = () => {
                        if (current < target) {
                            current += increment;
                            counter.textContent = Math.floor(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target;
                        }
                    };
                    updateCounter();
                });
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) observer.observe(statsSection);

    setInterval(() => {
        activeTestimonial.value = (activeTestimonial.value + 1) % 3;
    }, 5000);

    return () => {
        window.removeEventListener('scroll', handleScroll);
        window.removeEventListener('mousemove', handleMouseMove);
        observer.disconnect();
    };
});
</script>
<template>
    <section id="home" class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center relative pt-32 pb-24 px-4 sm:px-6 lg:px-8 overflow-hidden dark:bg-[#010226]">

        <!-- Subtle Grid Background -->
        <div class="absolute inset-0 opacity-[0.015] dark:opacity-[0.08]">
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(43, 76, 126, 0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(43, 76, 126, 0.15) 1px, transparent 1px); background-size: 80px 80px;"></div>
        </div>

        <!-- Gradient Orbs -->
        <div
            class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-[#2B4C7E]/5 dark:bg-[#2B4C7E]/10 rounded-full blur-3xl"
            :style="{ transform: `translate(${mousePosition.x}px, ${mousePosition.y}px)` }"
        ></div>
        <div
            class="absolute bottom-0 left-1/4 w-[400px] h-[400px] bg-[#F4B41A]/5 dark:bg-[#F4B41A]/10 rounded-full blur-3xl"
            :style="{ transform: `translate(${-mousePosition.x}px, ${-mousePosition.y}px)` }"
        ></div>

        <div class="max-w-7xl mx-auto relative z-10">

            <div class="text-center space-y-8 max-w-5xl mx-auto">

                <!-- Badge -->
                <div class="inline-flex items-center space-x-3 px-5 py-2.5 bg-[#2B4C7E]/5 dark:bg-[#2B4C7E]/15 border border-[#2B4C7E]/10 dark:border-[#2B4C7E]/20 rounded-full hover:border-[#2B4C7E]/20 dark:hover:border-[#2B4C7E]/30 transition-all group cursor-pointer">
                    <Sparkles class="w-4 h-4 text-[#F4B41A]" :stroke-width="2" />
                    <span class="text-sm font-semibold text-[#2B4C7E] dark:text-[#6BA3D4]">
                        Plataforma Premium de Gestão de Projetos
                    </span>
                    <ChevronRight class="w-4 h-4 text-[#2B4C7E] dark:text-[#6BA3D4] group-hover:translate-x-1 transition-transform" :stroke-width="2" />
                </div>

                <!-- Main Heading -->
                <div class="space-y-6">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black leading-[1.1] tracking-tight">
                        <span class="block text-[#24292f] dark:text-white mb-4">
                            A Plataforma Que
                        </span>
                        <span class="block relative">
                            <span class="bg-gradient-to-r from-[#2B4C7E] via-[#C1272D] to-[#F4B41A] bg-clip-text text-transparent">
                                Revoluciona a Gestão
                            </span>
                        </span>
                        <span class="block text-[#24292f] dark:text-white mt-4">
                            de Projetos no IPPLS
                        </span>
                    </h1>

                    <p class="text-lg sm:text-xl text-[#656d76] dark:text-[#7d8590] leading-relaxed max-w-3xl mx-auto">
                        Templates MVC profissionais em três níveis. Reduza <span class="font-semibold text-[#2B4C7E] dark:text-[#6BA3D4]">70% do tempo</span> e foque no que importa.
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-6" v-if="$page.props.auth?.user">
                    <Link

                        :href="route('home')"
                        class="group inline-flex items-center space-x-2 px-6 py-3 text-base font-semibold text-white bg-gradient-to-br from-[#C1272D] via-[#2B4C7E] to-[#F4B41A] rounded-lg transition-all shadow-sm hover:shadow-md"
                    >
                        <Rocket class="w-5 h-5" :stroke-width="2.5" />
                        <span>Guia do Utilizador</span>
                        <ArrowRight class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" :stroke-width="2.5" />
                    </Link>

                    <Link
                        :href="route('home')"
                        class="group inline-flex items-center space-x-2 px-6 py-3 text-base font-semibold text-[#24292f] dark:text-[#e6edf3] bg-white dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] hover:border-[#2B4C7E] dark:hover:border-[#6BA3D4] rounded-lg transition-all shadow-sm"
                    >
                        <Play class="w-5 h-5" :stroke-width="2.5" />
                        <span>Ver Documentação</span>
                    </Link>
                </div>
                <template v-else>
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-6">

                        <Link
                            :href="route('register')"
                            class="group inline-flex items-center space-x-2 px-6 py-3 text-base font-semibold text-white bg-gradient-to-br from-[#C1272D] via-[#2B4C7E] to-[#F4B41A] rounded-lg transition-all shadow-sm hover:shadow-md"
                        >
                            <Rocket class="w-5 h-5" :stroke-width="2.5" />
                            <span>Começar gratuitamente</span>
                            <ArrowRight class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" :stroke-width="2.5" />
                        </Link>

                        <Link
                            :href="route('login')"
                            class="group inline-flex items-center space-x-2 px-6 py-3 text-base font-semibold text-[#24292f] dark:text-[#e6edf3] bg-white dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] hover:border-[#2B4C7E] dark:hover:border-[#6BA3D4] rounded-lg transition-all shadow-sm"
                        >
                            <Play class="w-5 h-5" :stroke-width="2.5" />
                            <span>Ver demonstração</span>
                        </Link>
                    </div>
                    </template>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap justify-center items-center gap-6 pt-8 text-sm text-[#656d76] dark:text-[#7d8590]">
                    <div class="flex items-center space-x-2">
                        <CheckCircle2 class="w-4 h-4 text-[#2B4C7E] dark:text-[#6BA3D4] flex-shrink-0" :stroke-width="2.5" />
                        <span>Sem cartão</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Shield class="w-4 h-4 text-[#2B4C7E] dark:text-[#6BA3D4] flex-shrink-0" :stroke-width="2.5" />
                        <span>100% Seguro</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <Star class="w-4 h-4 text-[#F4B41A] fill-[#F4B41A] flex-shrink-0" :stroke-width="2.5" />
                        <span>500+ estudantes</span>
                    </div>
                </div>
            </div>

            <!-- Code Preview - REFATORADO -->
            <div class="mt-20 max-w-6xl mx-auto">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#2B4C7E] via-[#C1272D] to-[#F4B41A] rounded-2xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>

                    <div class="relative bg-[#f6f8fa] dark:bg-[#161b22] rounded-xl border border-[#d0d7de] dark:border-[#30363d] overflow-hidden shadow-lg">

                        <!-- Window Header -->
                        <div class="flex items-center justify-between px-4 sm:px-6 py-3.5 bg-white dark:bg-[#0d1117] border-b border-[#d0d7de] dark:border-[#30363d]">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                                <div class="w-3 h-3 rounded-full bg-[#ffbd2e]"></div>
                                <div class="w-3 h-3 rounded-full bg-[#27c93f]"></div>
                            </div>
                            <div class="hidden sm:flex items-center space-x-2 px-3 py-1 bg-[#f6f8fa] dark:bg-[#161b22] border border-[#d0d7de] dark:border-[#30363d] rounded-md">
                                <div class="w-2 h-2 bg-[#27c93f] rounded-full"></div>
                                <span class="text-xs font-medium text-[#656d76] dark:text-[#7d8590]">projeto-mvc</span>
                            </div>
                            <div class="flex items-center space-x-2 text-[#656d76] dark:text-[#7d8590]">
                                <FileCode class="w-4 h-4" :stroke-width="2.5" />
                                <span class="text-xs sm:text-sm font-medium hidden sm:inline">MVC Structure</span>
                            </div>
                        </div>

                        <!-- Code Content - Grid Responsivo -->
                        <div class="p-4 sm:p-6 font-mono text-xs sm:text-sm bg-[#f6f8fa] dark:bg-[#161b22] overflow-x-auto">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 min-w-max md:min-w-0">

                                <!-- Template Base -->
                                <div class="space-y-2.5">
                                    <div class="flex items-center space-x-2 pb-2 border-b border-[#d0d7de] dark:border-[#30363d]">
                                        <div class="w-2 h-2 rounded-full bg-[#4A8FC4]"></div>
                                        <span class="text-[#24292f] dark:text-[#e6edf3] font-bold text-sm">Base MVC</span>
                                    </div>

                                    <div class="flex items-center space-x-2 pl-2">
                                        <Package class="w-3.5 h-3.5 text-[#0969da] dark:text-[#58a6ff]" :stroke-width="2" />
                                        <span class="text-[#24292f] dark:text-[#e6edf3]">app/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <GitBranch class="w-3 h-3 text-[#8250df] dark:text-[#a371f7]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Controllers/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Database class="w-3 h-3 text-[#cf222e] dark:text-[#ff7b72]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Models/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Box class="w-3 h-3 text-[#116329] dark:text-[#7ee787]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Views/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Settings class="w-3 h-3 text-[#953800] dark:text-[#ffa657]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Config/</span>
                                    </div>
                                </div>

                                <!-- Template Padrão -->
                                <div class="space-y-2.5">
                                    <div class="flex items-center space-x-2 pb-2 border-b border-[#d0d7de] dark:border-[#30363d]">
                                        <div class="w-2 h-2 rounded-full bg-[#F4B41A]"></div>
                                        <span class="text-[#24292f] dark:text-[#e6edf3] font-bold text-sm">Padrão MVC</span>
                                        <Star class="w-3 h-3 text-[#F4B41A] fill-[#F4B41A]" :stroke-width="2" />
                                    </div>

                                    <div class="flex items-center space-x-2 pl-2">
                                        <Package class="w-3.5 h-3.5 text-[#0969da] dark:text-[#58a6ff]" :stroke-width="2" />
                                        <span class="text-[#24292f] dark:text-[#e6edf3]">app/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <GitBranch class="w-3 h-3 text-[#8250df] dark:text-[#a371f7]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Controllers/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Database class="w-3 h-3 text-[#cf222e] dark:text-[#ff7b72]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Models/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Box class="w-3 h-3 text-[#116329] dark:text-[#7ee787]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Views/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Workflow class="w-3 h-3 text-[#8250df] dark:text-[#a371f7]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Middleware/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Blocks class="w-3 h-3 text-[#bf8700] dark:text-[#d29922]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Helpers/</span>
                                    </div>
                                </div>

                                <!-- Template Avançado -->
                                <div class="space-y-2.5">
                                    <div class="flex items-center space-x-2 pb-2 border-b border-[#d0d7de] dark:border-[#30363d]">
                                        <div class="w-2 h-2 rounded-full bg-[#C1272D]"></div>
                                        <span class="text-[#24292f] dark:text-[#e6edf3] font-bold text-sm">Avançado MVC</span>
                                    </div>

                                    <div class="flex items-center space-x-2 pl-2">
                                        <Package class="w-3.5 h-3.5 text-[#0969da] dark:text-[#58a6ff]" :stroke-width="2" />
                                        <span class="text-[#24292f] dark:text-[#e6edf3]">app/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Cpu class="w-3 h-3 text-[#0969da] dark:text-[#58a6ff]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Core/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <GitBranch class="w-3 h-3 text-[#8250df] dark:text-[#a371f7]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Controllers/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Database class="w-3 h-3 text-[#cf222e] dark:text-[#ff7b72]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Models/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Workflow class="w-3 h-3 text-[#8250df] dark:text-[#a371f7]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Services/</span>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-6">
                                        <Shield class="w-3 h-3 text-[#116329] dark:text-[#7ee787]" :stroke-width="2" />
                                        <span class="text-[#656d76] dark:text-[#7d8590]">Middleware/</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -top-3 -right-3 bg-gradient-to-br from-[#F4B41A] to-[#F7C950] rounded-lg p-3 shadow-lg transform rotate-3 group-hover:rotate-0 group-hover:scale-105 transition-all duration-300">
                        <Sparkles class="w-5 h-5 sm:w-6 sm:h-6 text-white" :stroke-width="2.5" />
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
