<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <div
    data-slot="sidebar-footer"
    data-sidebar="footer"
    :class="cn('bg-wihte dark:bg-gray-900 flex flex-col gap-2 p-2', props.class, 'cursor-pointer bg-white')"
  >
    <slot />
  </div>
</template>
