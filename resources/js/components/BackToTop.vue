<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { ArrowUp } from 'lucide-vue-next';
import { gsap } from 'gsap';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';

// Registrar plugin GSAP
gsap.registerPlugin(ScrollToPlugin);

const isVisible = ref(false);
const buttonRef = ref<HTMLElement | null>(null);
const progressRef = ref<HTMLElement | null>(null);
const scrollProgress = ref(0);
const isHovered = ref(false);

var tl: gsap.core.Timeline;

const handleScroll = () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;
    
    scrollProgress.value = scrollPercent;
    isVisible.value = scrollTop > 400;
};

const scrollToTop = () => {
    // Animação suave com GSAP
    gsap.to(window, {
        duration: 1.5,
        scrollTo: { y: 0, autoKill: true },
        ease: 'power3.inOut'
    });

    // Animação de feedback do botão
    if (buttonRef.value) {
        gsap.to(buttonRef.value, {
            scale: 0.9,
            duration: 0.1,
            yoyo: true,
            repeat: 1,
            ease: 'power2.inOut'
        });
    }
};

const handleMouseEnter = () => {
    isHovered.value = true;
    if (buttonRef.value) {
        gsap.to(buttonRef.value, {
            scale: 1.1,
            duration: 0.3,
            ease: 'back.out(1.7)'
        });
    }
};

const handleMouseLeave = () => {
    isHovered.value = false;
    if (buttonRef.value) {
        gsap.to(buttonRef.value, {
            scale: 1,
            duration: 0.3,
            ease: 'power2.out'
        });
    }
};

watch(isVisible, (newVal) => {
    if (buttonRef.value) {
        if (newVal) {
            // Animação de entrada
            gsap.fromTo(
                buttonRef.value,
                {
                    opacity: 0,
                    scale: 0.5,
                    y: 20
                },
                {
                    opacity: 1,
                    scale: 1,
                    y: 0,
                    duration: 0.5,
                    ease: 'back.out(1.7)'
                }
            );
        } else {
            // Animação de saída
            gsap.to(buttonRef.value, {
                opacity: 0,
                scale: 0.5,
                y: 20,
                duration: 0.3,
                ease: 'power2.in'
            });
        }
    }
});

watch(scrollProgress, (newVal) => {
    if (progressRef.value) {
        gsap.to(progressRef.value, {
            strokeDashoffset: 283 - (283 * newVal) / 100,
            duration: 0.3,
            ease: 'power2.out'
        });
    }
});

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // Initial check
    
    // Inicializar o círculo de progresso
    if (progressRef.value) {
        gsap.set(progressRef.value, {
            strokeDasharray: 283,
            strokeDashoffset: 283
        });
    }
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    if (tl) tl.kill();
});
</script>

<template>
    <button
        v-show="isVisible"
        ref="buttonRef"
        type="button"
        aria-label="Voltar ao topo"
        class="fixed bottom-6 right-6 z-50 group"
        style="opacity: 0"
        @click="scrollToTop"
        @mouseenter="handleMouseEnter"
        @mouseleave="handleMouseLeave"
    >
        <!-- Container com shadow e border -->
        <div class="relative w-14 h-14 rounded-full bg-white dark:bg-[#0a0f1c] border-2 border-[#1e3a5f] dark:border-[#2d4a75] shadow-lg hover:shadow-xl transition-shadow duration-300">
            
            <!-- Círculo de progresso externo -->
            <svg 
                class="absolute inset-0 w-full h-full transform -rotate-90"
                viewBox="0 0 100 100"
            >
                <!-- Background circle -->
                <circle
                    cx="50"
                    cy="50"
                    r="45"
                    fill="none"
                    stroke="#e8edf5"
                    class="dark:stroke-[#0f1729]"
                    stroke-width="4"
                />
                
                <!-- Progress circle com gradiente IPPLS otimizado -->
                <defs>
                    <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#1e3a5f;stop-opacity:1" />
                        <stop offset="50%" style="stop-color:#b91c1c;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#d97706;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <circle
                    ref="progressRef"
                    cx="50"
                    cy="50"
                    r="45"
                    fill="none"
                    stroke="url(#progressGradient)"
                    stroke-width="4"
                    stroke-linecap="round"
                />
            </svg>

            <!-- Botão interno com gradiente refinado -->
            <div class="absolute inset-2 rounded-full bg-gradient-to-br from-[#C1272D] via-[#2B4C7E] to-[#F4B41A] flex items-center justify-center group-hover:from-[#152a4a] group-hover:via-[#991b1b] group-hover:to-[#b45309] transition-all duration-300">
                <div class="w-full h-full rounded-full bg-white dark:bg-[#0a0f1c] m-[2px] flex items-center justify-center">
                    <ArrowUp 
                        class="w-5 h-5 text-[#1e3a5f] dark:text-[#3b82f6] group-hover:text-[#b91c1c] dark:group-hover:text-[#ef4444] transition-colors duration-300" 
                        :stroke-width="2.5"
                    />
                </div>
            </div>

            <!-- Glow effect on hover refinado -->
            <div 
                class="absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-300 pointer-events-none"
                style="background: linear-gradient(135deg, #1e3a5f 0%, #b91c1c 50%, #d97706 100%);"
            ></div>
        </div>

        <!-- Tooltip com cores do IPPLS -->
        <div 
            class="absolute bottom-full right-0 mb-2 px-3 py-1.5 bg-[#1e3a5f] dark:bg-[#0f1729] text-white text-xs font-medium rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none shadow-lg border border-[#b91c1c]"
        >
            Voltar ao topo
            <div class="absolute top-full right-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-[#1e3a5f] dark:border-t-[#0f1729]"></div>
        </div>

        <!-- Ripple effect com cores IPPLS -->
        <div 
            class="absolute inset-0 rounded-full pointer-events-none"
            :class="{ 'animate-ping': isHovered }"
            style="animation-duration: 1s; opacity: 0.2; background: linear-gradient(135deg, #1e3a5f 0%, #b91c1c 50%, #d97706 100%);"
        ></div>
    </button>
</template>

<style scoped>
    /* Animação de ping personalizada */
    @keyframes ping {
        0% {
            transform: scale(1);
            opacity: 0.3;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.1;
        }
        100% {
            transform: scale(1.4);
            opacity: 0;
        }
    }

    .animate-ping {
        animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    /* Garantir que o botão tenha cursor pointer */
    button {
        cursor: pointer;
    }

    /* Melhorar a transição do tooltip */
    button:hover div[class*="tooltip"] {
        transition-delay: 0.3s;
    }
</style>