<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import {
    Github, Mail, Send, BookOpen,
    Bell,
    } from 'lucide-vue-next';

</script>
<template>
    <section id="contact" class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-24 px-4 sm:px-6 lg:px-8 dark:bg-[#010226] border-y border-[#d0d7de] dark:bg-[#010226]">
        <div class="max-w-7xl mx-auto">

            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center space-x-2 px-4 py-2 bg-[#C1272D]/10 dark:bg-[#010226]/20 border border-[#C1272D]/20 dark:border-[#C1272D]/30 rounded-full">
                    <Mail class="w-4 h-4 text-[#C1272D] dark:text-[#E04850]" :stroke-width="2.5" />
                    <span class="text-sm font-semibold text-[#C1272D] dark:text-[#E04850]">SUPORTE DO PROJETO</span>
                </div>

                <h2 class="text-4xl sm:text-5xl font-bold text-[#24292f] dark:text-[#e6edf3]">
                    Precisa de Ajuda?
                </h2>

                <p class="text-xl text-[#656d76] dark:text-[#7d8590] max-w-3xl mx-auto">
                    Entre em contato para suporte técnico, dúvidas sobre a plataforma ou sugestões de melhoria
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">

                <!-- Contact Information -->
                <div class="space-y-6">

                    <!-- Documentation -->
                    <div class="group p-6 bg-white dark:bg-[#010226] rounded-xl border border-[#d0d7de] dark:border-[#30363d] hover:border-[#2B4C7E] dark:hover:border-[#6BA3D4] hover:shadow-md transition-all">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#2B4C7E] to-[#4A8FC4] rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <BookOpen class="w-6 h-6 text-white" :stroke-width="2.5" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-1">Documentação</h3>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Acesse a documentação completa do projeto no GitHub
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- GitHub -->
                    <div class="group p-6 bg-white dark:bg-[#010226] rounded-xl border border-[#d0d7de] dark:border-[#30363d] hover:border-[#C1272D] dark:hover:border-[#E04850] hover:shadow-md transition-all">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#C1272D] to-[#E04850] rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <Github class="w-6 h-6 text-white" :stroke-width="2.5" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-1">Repositório</h3>
                                <a href="https://github.com/Ngola-develop/arquitetura-de-projetos-ippls" target="_blank" class="text-sm text-[#0969da] dark:text-[#58a6ff] hover:underline font-medium">
                                    GitHub - Arquitetura de Projetos IPPLS
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="group p-6 bg-white dark:bg-[#010226] rounded-xl border border-[#d0d7de] dark:border-[#30363d] hover:border-[#F4B41A] hover:shadow-md transition-all">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#F4B41A] to-[#F7C950] rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <Bell class="w-6 h-6 text-white" :stroke-width="2.5" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-1">Suporte</h3>
                                <p class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    Abra uma issue no GitHub para reportar problemas ou sugerir melhorias
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Technologies -->
                    <div class="p-6 bg-white dark:bg-[#010226] rounded-xl border border-[#d0d7de] dark:border-[#30363d]">
                        <h3 class="text-lg font-bold text-[#24292f] dark:text-[#e6edf3] mb-4">Tecnologias</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1.5 text-xs font-semibold text-[#24292f] dark:text-[#e6edf3] bg-[#f6f8fa] dark:bg-[#010226] rounded-md border border-[#d0d7de] dark:border-[#30363d]">Laravel 12</span>
                            <span class="px-3 py-1.5 text-xs font-semibold text-[#24292f] dark:text-[#e6edf3] bg-[#f6f8fa] dark:bg-[#010226] rounded-md border border-[#d0d7de] dark:border-[#30363d]">Vue 3</span>
                            <span class="px-3 py-1.5 text-xs font-semibold text-[#24292f] dark:text-[#e6edf3] bg-[#f6f8fa] dark:bg-[#010226] rounded-md border border-[#d0d7de] dark:border-[#30363d]">TypeScript</span>
                            <span class="px-3 py-1.5 text-xs font-semibold text-[#24292f] dark:text-[#e6edf3] bg-[#f6f8fa] dark:bg-[#010226] rounded-md border border-[#d0d7de] dark:border-[#30363d]">Inertia.js</span>
                            <span class="px-3 py-1.5 text-xs font-semibold text-[#24292f] dark:text-[#e6edf3] bg-[#f6f8fa] dark:bg-[#010226] rounded-md border border-[#d0d7de] dark:border-[#30363d]">Tailwind CSS</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-none dark:bg-[#010226] rounded-xl border-0 p-8">
                    <h3 class="text-2xl font-bold text-[#24292f] dark:text-[#e6edf3] mb-6">Envie sua Mensagem</h3>

                    <form class="space-y-5">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-[#24292f] dark:text-[#e6edf3] mb-2">
                                Nome Completo
                            </label>
                            <input
                                type="text"
                                placeholder="Seu nome"
                                class="w-full px-4 py-3 bg-[#f6f8fa] dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C7E] dark:focus:ring-[#1f6feb] focus:border-transparent text-[#24292f] dark:text-[#e6edf3] transition-all placeholder:text-[#656d76] dark:placeholder:text-[#7d8590]"
                            />
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-[#24292f] dark:text-[#e6edf3] mb-2">
                                Email
                            </label>
                            <input
                                type="email"
                                placeholder="seu@email.com"
                                class="w-full px-4 py-3 bg-[#f6f8fa] dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C7E] dark:focus:ring-[#1f6feb] focus:border-transparent text-[#24292f] dark:text-[#e6edf3] transition-all placeholder:text-[#656d76] dark:placeholder:text-[#7d8590]"
                            />
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-semibold text-[#24292f] dark:text-[#e6edf3] mb-2">
                                Assunto
                            </label>
                            <input
                                type="text"
                                placeholder="Dúvida, sugestão ou problema"
                                class="w-full px-4 py-3 bg-[#f6f8fa] dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C7E] dark:focus:ring-[#1f6feb] focus:border-transparent text-[#24292f] dark:text-[#e6edf3] transition-all placeholder:text-[#656d76] dark:placeholder:text-[#7d8590]"
                            />
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-semibold text-[#24292f] dark:text-[#e6edf3] mb-2">
                                Mensagem
                            </label>
                            <textarea
                                rows="4"
                                placeholder="Descreva sua dúvida ou sugestão sobre a plataforma..."
                                class="w-full px-4 py-3 bg-[#f6f8fa] dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C7E] dark:focus:ring-[#1f6feb] focus:border-transparent text-[#24292f] dark:text-[#e6edf3] transition-all resize-none placeholder:text-[#656d76] dark:placeholder:text-[#7d8590]"
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="group w-full px-6 py-3 text-base font-semibold text-white bg-[#2B4C7E] hover:bg-[#1e3557] dark:bg-[#1f6feb] dark:hover:bg-[#1a5cd7] rounded-lg transition-all shadow-sm hover:shadow-md"
                        >
                            <span class="flex items-center justify-center space-x-2">
                                <span>Enviar Mensagem</span>
                                <Send class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2.5" />
                            </span>
                        </button>
                    </form>
                </div>
            </div>
                <div class="inline-flex ">
                <Link :href="route('home')"
                class="bg-none text-ippls-blue-dark dark:text-gray-300 text-sm border-2 border-ippls-blue-dark px-3 py-2 rounded-xl font-semibold shadow-md shadow-ippls-blue-dark hover:shadow-lg hover:bg-ippls-blue-dark hover:text-white"
                >
                    Guia do Utilizador
                </Link>
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
