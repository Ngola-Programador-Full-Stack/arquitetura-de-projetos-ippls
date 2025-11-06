<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PropType } from 'vue';

const props = defineProps({
  avaliacao: {
    type: Object as PropType<App.Avaliacao>,
    required: true
  },
  criterios: {
    type: Object as PropType<Record<string, {
      nome: string;
      peso: number;
      descricao: string;
    }>>,
    required: true
  }
});

const form = useForm({
  nota: 0,
  comentarios: '',
  criterios_avaliacao: {} as Record<string, number>
});

const submit = () => {
  form.put(route('avaliacoes.update', {
    avaliacao: props.avaliacao.id
  }), {
    preserveScroll: true,
    onSuccess: () => form.reset()
  });
};
</script>

<template>
  <Head :title="`Avaliação - ${avaliacao.instanciaProjeto.projeto.titulo}`" />

  <div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">
        Avaliação: {{ avaliacao.instanciaProjeto.projeto.titulo }}
      </h1>
      <span class="px-3 py-1 rounded-full text-sm" :class="avaliacao.getStatusBadgeClass">
        {{ avaliacao.status.replace('_', ' ') }}
      </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-2">Informações do Projeto</h3>
        <p><strong>Estudante:</strong> {{ avaliacao.instanciaProjeto.usuario.name }}</p>
        <p><strong>Nível:</strong> {{ avaliacao.instanciaProjeto.nivel_arquitetura }}</p>
      </div>

      <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-2">Critérios de Avaliação</h3>
        <div v-for="(criterio, key) in criterios" :key="key" class="mb-2">
          <label class="block">{{ criterio.nome }} ({{ criterio.peso }}%)</label>
          <input
            v-model="form.criterios_avaliacao[key]"
            type="range"
            min="0"
            max="20"
            step="0.5"
            class="w-full"
          >
          <span>{{ form.criterios_avaliacao[key] || 0 }}/20</span>
        </div>
      </div>

      <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-2">Nota Final</h3>
        <div class="text-4xl font-bold text-center my-4">
          {{ form.nota || 0 }}/20
        </div>
        <textarea
          v-model="form.comentarios"
          placeholder="Comentários adicionais..."
          class="w-full p-2 border rounded"
          rows="4"
        ></textarea>
      </div>
    </div>

    <div class="flex justify-end gap-4">
      <Link
        :href="route('avaliacoes.index')"
        class="px-4 py-2 border rounded-md"
      >
        Voltar
      </Link>
      <button
        @click="submit"
        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
        :disabled="form.processing"
      >
        Salvar Avaliação
      </button>
    </div>
  </div>
</template>
