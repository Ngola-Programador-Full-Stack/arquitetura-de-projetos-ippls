<!--template>
  <component
    :is="href ? Link : 'button'"
    v-if="showButton"
    :href="href ? route(href, routeParams) : undefined"
    class="bg-[#1F609D] hover:bg-[#0061d6] text-[#ffdd00] px-4 py-2 rounded-full flex items-center space-x-2 transition-colors shadow-2xl"
    :class="customClass"
  >
    <slot name="icon">
      <svg v-if="icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon" />
      </svg>
    </slot>
    <span v-if="text">{{ text }}</span>
    <slot />
  </component>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const props = defineProps({
    href: {
        type: String,
        default: null,
    },
    routeParams: {
        type: [Object, Number, String],
        default: () => ({}),
    },
    text: {
        type: String,
        default: '',
    },
    icon: {
        type: String,
        default: '',
    },
    showCondition: {
        type: [Boolean, String, Object],
        default: true,
    },
    customClass: {
        type: String,
        default: '',
    },
    });

    const showButton = computed(() => {
    if (typeof props.showCondition === 'boolean') return props.showCondition;
    return true;
    });
</script-->


<template>
  <component
    :is="href ? Link : 'button'"
    v-if="showButton"
    :href="href ? route(href, routeParams) : undefined"
    class="bg-[#1F609D] hover:bg-[#0061d6] text-[#ffdd00] px-4 py-2 rounded-full flex items-center space-x-2 transition-colors shadow-2xl"
    :class="customClass"
  >
    <slot name="icon">
      <svg v-if="icon" :class="['stroke-current', iconSizeClass]" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon" />
      </svg>
    </slot>
    <span v-if="text">{{ text }}</span>
    <slot />
  </component>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  href: {
    type: String,
    default: null,
  },
  routeParams: {
    type: [Object, Number, String],
    default: () => ({}),
  },
  text: {
    type: String,
    default: '',
  },
  icon: {
    type: String,
    default: '',
  },
  showCondition: {
    type: [Boolean, String, Object],
    default: true,
  },
  customClass: {
    type: String,
    default: '',
  },
  iconSize: {
    type: String,
    default: '4', // Tamanho padrão (h-5 w-5)
    validator: (value: string) => ['3', '4', '5', '6', '7', '8'].includes(value)
  }
});

const showButton = computed(() => {
  if (typeof props.showCondition === 'boolean') return props.showCondition;
  return true;
});

const iconSizeClass = computed(() => `w-${props.iconSize} h-${props.iconSize}`);
</script>
