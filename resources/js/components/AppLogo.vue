<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import type { HTMLAttributes } from 'vue';

interface Props {
    className?: HTMLAttributes['class'];
    size?: 'xs' | 'sm' | 'md' | 'lg' | 'xl';
    showText?: boolean;
    variant?: 'default' | 'compact' | 'icon-only';
}

withDefaults(defineProps<Props>(), {
    size: 'md',
    showText: true,
    variant: 'default'
});
</script>

<template>
    <AppLogoIcon 
        :size="size"
        :showText="showText"
        :variant="variant"
        :className="className"
        v-bind="$attrs"
    />
</template>