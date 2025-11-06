<template>
  <div class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-xl shadow">
    <div class="flex-shrink-0">
      <component :is="icon" class="w-8 h-8 text-indigo-500" />
    </div>
    <div class="ml-4">
      <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ title }}</p>
      <p class="text-2xl font-bold text-gray-700 dark:text-white">{{ value }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
// Import only the icons you need, or use a dynamic import if needed
import { Home, User, Settings } from 'lucide-vue-next';

const props = defineProps<{
  title: string;
  value: number;
  icon: string;
}>();

// Map icon names to components
const iconMap: Record<string, any> = {
  home: Home,
  user: User,
  settings: Settings,
};

const icon = computed(() => iconMap[props.icon] || Home);
import { computed } from 'vue';
</script>
