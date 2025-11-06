<!-- resources/js/components/Pagination.vue -->
<template>
  <nav class="flex gap-2 flex-wrap">
    <Component
      v-for="(link, idx) in links"
      :key="idx"
      :is="link.url ? 'Link' : 'span'"
      :href="link.url"
      class="px-3 py-1 border rounded hover:bg-gray-200"
      :class="{ 'bg-gray-300': link.active, 'text-gray-500': !link.url }"
    >
      <span v-if="!link.url" v-html="link.label"></span>
      <template v-else>{{ link.label }}</template>
    </Component>
  </nav>
</template>

<script setup lang="ts">
//import { Link } from '@inertiajs/vue3'
import { defineProps } from 'vue'

defineProps<{
  links: Array<{
    url: string | null
    label: string
    active: boolean
  }>
}>()

// Register Link as a local component for dynamic usage
</script>
