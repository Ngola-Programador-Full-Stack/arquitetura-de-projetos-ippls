<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import BackgroundGradient from '@/components/ui/background-gradient/BackgroundGradient.vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const name = page.props.name;
const quote = page.props.quote;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <!--section class="relative isolate overflow-hidden bg-gray-900"-->


        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="relative hidden h-full flex-col isolate overflow-hidden bg-gray-900 p-10 text-white lg:flex dark:border-r">
                <!-- Background gradient -->
                <BackgroundGradient />
                <!--div class="absolute inset-0 bg-zinc-900" /-->
                <Link :href="route('home')" class="relative z-20 flex items-center text-lg font-medium bg-white w-[30%] h-[7%] rounded-sm">
                    <AppLogoIcon class="size-8 fill-current text-white" />
                </Link>


                <div class="text-left mt-40">
                    <!-- Main Heading -->
                    <div class="space-y-3">
                    
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-black leading-[1.1] tracking-tight">
                            <span class="block text-gray-300 dark:text-white mb-4">
                                A Plataforma Que
                            </span>
                            <span class="block relative">
                                <span class="bg-gradient-to-r from-ippls-blue-dark via-ippls-red to-ippls-gold bg-clip-text text-transparent animate-gradient">
                                    Revoluciona a Gestão
                                </span>
                            </span>
                            <span class="block text-gray-300 dark:text-white mt-4">
                                de Projetos no IPPLS
                            </span>
                        </h1>
                        
                        <p class="text-xl sm:text-2xl text-white/50 dark:text-[#7d8590] leading-relaxed max-w-4xl mx-auto font-normal">
                            Faça login com sua conta para gerir seus projetos. Reduza <span class="font-semibold text-ippls-gold dark:text-[#6BA3D4]">70% do tempo</span> e foque no que importa.
                        </p>
                    </div>
                </div>

                <div v-if="quote" class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <p class="text-lg">&ldquo;{{ quote.message }}&rdquo;</p>
                        <footer class="text-sm text-neutral-300">{{ quote.author }}</footer>
                    </blockquote>
                </div>
            </div>
            <div class="lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <div class="flex flex-col space-y-2 text-center">
                        <h1 class="text-xl font-medium tracking-tight" v-if="title">{{ title }}</h1>
                        <p class="text-sm text-muted-foreground" v-if="description">{{ description }}</p>
                    </div>
                    <slot />
                </div>
            </div>
        </div>
    <!--/section-->
</template>
