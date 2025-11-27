<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import {
        Users, Shield,
        ArrowRight, CheckCircle2, Star,
    } from 'lucide-vue-next';
</script>
<template>
        <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center py-32 px-4 sm:px-6 lg:px-8 dark:bg-[#010226] border-y border-[#d0d7de] dark:bg-[#010226]">
            <div class="max-w-5xl mx-auto text-center space-y-8">

                <div class="space-y-6">
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-[#24292f] dark:text-[#e6edf3]">
                        Pronto Para Transformar
                        <span class="block mt-2 bg-gradient-to-r from-[#2B4C7E] via-[#C1272D] to-[#F4B41A] bg-clip-text text-transparent">
                            Seus Projetos Acadêmicos?
                        </span>
                    </h2>

                    <p class="text-xl text-[#656d76] dark:text-[#7d8590] max-w-3xl mx-auto">
                        Junte-se a 500+ estudantes do IPPLS criando projetos profissionais.
                    </p>
                </div>

                <div class="max-w-2xl mx-auto pt-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                        <input
                            type="email"
                            placeholder="Digite seu email institucional"
                            class="flex-1 w-full sm:w-auto px-6 py-3.5 text-base text-[#24292f] dark:text-[#e6edf3] bg-white dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B4C7E] dark:focus:ring-[#1f6feb] focus:border-transparent transition-all placeholder:text-[#656d76] dark:placeholder:text-[#7d8590]"
                        />
                        <Link
                            :href="route('register')"
                            class="group inline-flex items-center space-x-2 px-8 py-3.5 text-base font-semibold text-white bg-[#2B4C7E] hover:bg-[#1e3557] dark:bg-[#1f6feb] dark:hover:bg-[#1a5cd7] rounded-lg transition-all shadow-md hover:shadow-lg whitespace-nowrap"
                        >
                            <span>Começar agora</span>
                            <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" :stroke-width="2" />
                        </Link>
                    </div>
                    <div class="flex items-center justify-center space-x-2 mt-4">
                        <CheckCircle2 class="w-4 h-4 text-[#2B4C7E] dark:text-[#6BA3D4]" :stroke-width="2" />
                        <span class="text-sm text-[#656d76] dark:text-[#7d8590]">
                            Sem cartão • Suporte 24/7 • Cancelamento gratuito
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center items-center gap-6 pt-8">
                    <div class="flex items-center space-x-2 px-5 py-2.5 bg-white dark:bg-[#010226] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                        <Shield class="w-5 h-5 text-[#2B4C7E] dark:text-[#6BA3D4]" :stroke-width="2" />
                        <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">100% Seguro</span>
                    </div>
                    <div class="flex items-center space-x-2 px-5 py-2.5 bg-white dark:bg-[#010226] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                        <Star class="w-5 h-5 text-[#F4B41A] fill-[#F4B41A]" :stroke-width="2" />
                        <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">5 Estrelas</span>
                    </div>
                    <div class="flex items-center space-x-2 px-5 py-2.5 bg-white dark:bg-[#010226] rounded-lg border border-[#d0d7de] dark:border-[#30363d]">
                        <Users class="w-5 h-5 text-[#C1272D] dark:text-[#E04850]" :stroke-width="2" />
                        <span class="font-semibold text-[#24292f] dark:text-[#e6edf3]">500+ Estudantes</span>
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
    background: #010226;
}

::-webkit-scrollbar-thumb {
    background: #2B4C7E;
    border-radius: 6px;
}

::-webkit-scrollbar-thumb:hover {
    background: #1e3557;
}
</style>
