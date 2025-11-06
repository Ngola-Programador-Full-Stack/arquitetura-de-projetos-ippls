<!-- resources/js/Components/ProjectCard.vue -->
<script setup lang="ts">
import { PropType } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  projeto: {
    type: Object as PropType<App.InstanciaProjeto | App.Projeto>,
    required: true
  },
  showStatus: Boolean,
  showAction: Boolean,
  actionText: String,
  actionUrl: String
});
</script>

<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-4">
      <h3 class="font-bold text-lg mb-2">{{ projeto.projeto?.titulo || projeto.titulo }}</h3>
      <p class="text-gray-600 mb-3 line-clamp-2">
        {{ projeto.projeto?.descricao || projeto.descricao }}
      </p>

      <div v-if="showStatus" class="flex items-center mb-2">
        <span
          class="px-2 py-1 text-xs rounded-full"
          :class="{
            'bg-green-100 text-green-800': projeto.status === 'concluido',
            'bg-blue-100 text-blue-800': projeto.status === 'em_desenvolvimento',
            'bg-yellow-100 text-yellow-800': projeto.status === 'iniciado'
          }"
        >
          {{ projeto.status }}
        </span>
      </div>

      <div v-if="showAction && actionUrl" class="mt-4">
        <Link
          :href="actionUrl"
          class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
        >
          {{ actionText }}
        </Link>
      </div>
    </div>
  </div>
</template>
