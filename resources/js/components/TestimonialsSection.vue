<script setup lang="ts">
import { Code2, GraduationCap, Star, Users } from 'lucide-vue-next';

const testimonials = [
    {
        name: 'Maria Silva',
        role: 'Estudante de Engenharia - 3º Ano',
        avatar: GraduationCap,
        quote: 'A plataforma revolucionou minha forma de desenvolver projetos. Economizei semanas de trabalho e aprendi as melhores práticas de arquitetura de software.',
        rating: 5,
    },
    {
        name: 'João Santos',
        role: 'Professor e Coordenador de TI',
        avatar: Users,
        quote: 'Finalmente uma solução que padroniza e facilita o acompanhamento dos projetos. O sistema de avaliação e relatórios é excepcional e economiza horas de trabalho.',
        rating: 5,
    },
    {
        name: 'Ana Costa',
        role: 'Estudante de Sistemas - 2º Ano',
        avatar: Code2,
        quote: 'Os templates são extremamente profissionais e me ajudaram a entender profundamente MVC. Agora meus projetos têm qualidade de produção desde o início.',
        rating: 5,
    },
];
</script>
<template>
    <section class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center px-4 py-24 sm:px-6 lg:px-8 dark:bg-[#010226]">
        <div class="mx-auto max-w-7xl">
            <div class="mb-16 space-y-4 text-center">
                <h2 class="text-4xl font-bold text-[#24292f] sm:text-5xl dark:text-[#e6edf3]">O Que Dizem Nossos Usuários</h2>
                <p class="text-xl text-[#656d76] dark:text-[#7d8590]">Feedback real de estudantes e professores do IPPLS</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div
                    v-for="(testimonial, index) in testimonials"
                    :key="testimonial.name"
                    class="rounded-lg border border-[#d0d7de] bg-white p-6 transition-all hover:border-[#2B4C7E] hover:shadow-lg dark:border-[#30363d] dark:bg-[#010226] dark:hover:border-[#6BA3D4]"
                    :class="{ 'animate-fade-in opacity-0': true }"
                    :style="{ animationDelay: `${index * 0.1}s` }"
                >
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-[#2B4C7E] to-[#4A8FC4]">
                                <component :is="testimonial.avatar" class="h-6 w-6 text-white" :stroke-width="2" />
                            </div>
                            <div>
                                <div class="font-bold text-[#24292f] dark:text-[#e6edf3]">
                                    {{ testimonial.name }}
                                </div>
                                <div class="text-sm text-[#656d76] dark:text-[#7d8590]">
                                    {{ testimonial.role }}
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-1">
                            <Star v-for="i in testimonial.rating" :key="i" class="h-4 w-4 fill-[#F4B41A] text-[#F4B41A]" :stroke-width="2" />
                        </div>

                        <p class="text-sm leading-relaxed text-[#24292f] dark:text-[#c9d1d9]">"{{ testimonial.quote }}"</p>
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
