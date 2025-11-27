<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
//import { onMounted, ref } from 'vue';
import Navbar from '@/components/Navbar.vue';
// import {
//     Users, Shield,
//     ArrowRight, CheckCircle2, Star,
// } from 'lucide-vue-next';
// import AppLogoIcon from '@/components/AppLogoIcon.vue';
// import BackgroundGradient from '@/components/ui/background-gradient/BackgroundGradient.vue';
// import Badge from '@/components/ui/badge/Badge.vue';
import AppFooter from '@/components/AppFooter.vue';
import BackToTop from '@/components/BackToTop.vue';
import HeroSection from '@/components/HeroSection.vue';
import Banner from '@/components/Banner.vue';
import StatsSection from '@/components/StatsSection.vue';
import FeaturesSection from '@/components/FeaturesSection.vue';
import ArchitectureLevels from '@/components/ArchitectureLevels.vue';
import WorkflowSection from '@/components/WorkflowSection.vue';
import TechnologiesSection from '@/components/TechnologiesSection.vue';
import TestimonialsSection from '@/components/TestimonialsSection.vue';
import AboutSection from '@/components/AboutSection.vue';
import ContactSection from '@/components/ContactSection.vue';
import CTASection from '@/components/CTASection.vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();


</script>

<template>
    <Head title="Arquitetura de Projetos IPPLS - Plataforma Premium de Gestão de Projetos">
        <meta name="description" content="Plataforma profissional para padronização e gestão de projetos acadêmicos do IPPLS com templates MVC em três níveis de complexidade." />
    </Head>

    <div class="bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-cover bg-center min-h-screen dark:bg-[#010226]">

        <!-- Navbar -->
        <Navbar />

        <!-- Hero Section -->
        <HeroSection />

        <!-- Banner Section -->
         <!-- <div class="hidden banner"> -->
            <Banner />
         <!-- </div> -->

        <!-- Stats Section -->
        <StatsSection />

        <!-- Features Section -->
         <FeaturesSection />

        <!-- Architecture Levels -->
         <ArchitectureLevels />

        <!-- Workflow Section -->
        <WorkflowSection />

        <!-- Technologies Section -->
        <TechnologiesSection />

        <!-- Testimonials Section -->
        <TestimonialsSection />

        <!-- About Section -->
        <AboutSection />

        <!-- Contact Section -->
        <ContactSection />

        <!-- CTA Section -->
        <CTASection />

        <!-- FOOTER MODERNIZADO ESTILO PAGEDONE -->
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

.dark section {

}
</style>
