<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import Badge from './ui/badge/Badge.vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
    size?: 'xs' | 'sm' | 'md' | 'lg' | 'xl';
    showText?: boolean;
    variant?: 'default' | 'compact' | 'icon-only';
}

const props = withDefaults(defineProps<Props>(), {
    size: 'md',
    showText: true,
    variant: 'default'
});

// Tamanhos responsivos para cada variante
const sizeClasses = {
    xs: {
        image: 'w-8 h-8',
        text: 'text-xs',
        subtitle: 'text-[0.6rem]',
        badge: 'text-[0.55rem] px-1 py-0.5'
    },
    sm: {
        image: 'w-10 h-10',
        text: 'text-sm',
        subtitle: 'text-[0.65rem]',
        badge: 'text-[0.65rem] px-1 py-0.5'
    },
    md: {
        image: 'w-12 h-12',
        text: 'text-base',
        subtitle: 'text-[0.7rem]',
        badge: 'text-[0.75rem] px-1.5 py-0.5'
    },
    lg: {
        image: 'w-16 h-16',
        text: 'text-lg',
        subtitle: 'text-sm',
        badge: 'text-[0.85rem] px-2 py-1'
    },
    xl: {
        image: 'w-20 h-20',
        text: 'text-xl',
        subtitle: 'text-base',
        badge: 'text-base px-2 py-1'
    }
};

const currentSize = sizeClasses[props.size];
</script>

<template>
    <a 
        href="/" 
        :class="[
            'inline-flex items-center group cursor-pointer transition-all duration-200 hover:opacity-90',
            className
        ]"
        v-bind="$attrs"
    >
        <!-- Logo Image -->
        <div class="relative flex-shrink-0">
            <img 
                src="/img/logo/ippls-logo-removebg-preview.png" 
                alt="IPPLS Logo" 
                :class="[
                    'rounded-md object-cover transition-transform duration-200 group-hover:scale-105',
                    currentSize.image
                ]"
            />
        </div>

        <!-- Text Content (Condicional) -->
        <div 
            v-if="showText && variant !== 'icon-only'" 
            :class="[
                'flex flex-col ml-2 sm:ml-3',
                variant === 'compact' ? 'gap-0' : 'gap-0.5'
            ]"
        >
            <!-- Título Principal -->
            <span 
                :class="[
                    'font-bold text-[#1e3557] dark:text-[#e6edf3] leading-tight whitespace-nowrap',
                    currentSize.text,
                    variant === 'compact' ? 'hidden sm:inline-block' : ''
                ]"
            >
                INSTITUTO TÉCNICO
            </span>
            
               
            <!-- Subtítulo -->
            <span 
                :class="[
                    'font-bold text-[#2B4C7E] dark:text-[#6BA3D4] leading-tight whitespace-nowrap',
                    currentSize.subtitle,
                    variant === 'compact' ? 'hidden sm:inline-block' : ''
                ]"
            >
                LUCRÊCIO DOS SANTOS
            </span>
        </div>

        <!-- Versão Compacta para Mobile -->
        <div 
            v-if="showText && variant === 'compact'" 
            :class="'flex sm:hidden items-center ml-2'"
        >
        </div>
    </a>
</template>