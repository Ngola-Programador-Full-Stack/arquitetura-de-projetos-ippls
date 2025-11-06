<script setup lang="ts">
import { PropType } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  notification: {
    type: Object as PropType<App.Notificacao>,
    required: true
  }
});

const emit = defineEmits(['markAsRead']);

const handleClick = () => {
  if (!notification.lida) {
    emit('markAsRead', notification.id);
  }
};
</script>

<template>
  <Link
    :href="notification.acao_url || '#'"
    @click="handleClick"
    class="block p-3 hover:bg-gray-50 transition"
    :class="{ 'bg-blue-50': !notification.lida }"
  >
    <div class="flex items-start">
      <span
        class="mt-1 w-2 h-2 rounded-full"
        :class="{
          'bg-blue-500': !notification.lida,
          'bg-transparent': notification.lida
        }"
      ></span>
      <div class="ml-3 flex-1">
        <p class="text-sm font-medium">
          {{ notification.titulo }}
        </p>
        <p class="text-sm text-gray-500">
          {{ notification.mensagem }}
        </p>
        <p class="text-xs text-gray-400 mt-1">
          {{ notification.created_at }}
        </p>
      </div>
    </div>
  </Link>
</template>
