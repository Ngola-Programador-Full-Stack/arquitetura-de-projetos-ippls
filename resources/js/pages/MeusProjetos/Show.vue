<template>
  <Head :title="`Gerenciar: ${instancia.projeto.titulo}`" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gerenciar: {{ instancia.projeto.titulo }}
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Acompanhe o progresso e gerencie seu projeto
          </p>
        </div>
        <Button variant="outline" @click="$inertia.visit(route('meus-projetos.index'))">
          <ArrowLeft class="w-4 h-4 mr-2" />
          Voltar aos meus projetos
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Status e Progresso -->
        <Card>
          <CardHeader>
            <div class="flex items-center justify-between">
              <CardTitle>Status do Projeto</CardTitle>
              <span
                class="px-3 py-1 text-sm font-medium rounded-full"
                :class="getStatusClass(instancia.status)"
              >
                {{ getStatusText(instancia.status) }}
              </span>
            </div>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="md:col-span-2">
                <div class="mb-6">
                  <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-muted-foreground">Progresso</span>
                    <span class="text-sm font-medium">
                      {{ instancia.percentual_conclusao || 0 }}%
                    </span>
                  </div>
                  <div class="w-full bg-muted rounded-full h-3">
                    <div
                      class="bg-primary h-3 rounded-full transition-all duration-300"
                      :style="{ width: `${instancia.percentual_conclusao || 0}%` }"
                    />
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                  <div>
                    <div class="flex items-center gap-2 mb-1">
                      <Calendar class="w-4 h-4 text-muted-foreground" />
                      <span class="font-medium text-muted-foreground">Iniciado em:</span>
                    </div>
                    <div class="text-foreground">
                      {{ formatarData(instancia.created_at) }}
                    </div>
                  </div>

                  <div v-if="instancia.data_conclusao">
                    <div class="flex items-center gap-2 mb-1">
                      <Calendar class="w-4 h-4 text-muted-foreground" />
                      <span class="font-medium text-muted-foreground">Concluído em:</span>
                    </div>
                    <div class="text-foreground">
                      {{ formatarData(instancia.data_conclusao) }}
                    </div>
                  </div>

                  <div>
                    <div class="flex items-center gap-2 mb-1">
                      <FileText class="w-4 h-4 text-muted-foreground" />
                      <span class="font-medium text-muted-foreground">Nível de arquitetura:</span>
                    </div>
                    <div class="text-foreground capitalize">
                      {{ instancia.nivel_arquitetura?.replace('_', ' ') }}
                    </div>
                  </div>

                  <div>
                    <span class="font-medium text-muted-foreground">Categoria:</span>
                    <div class="text-foreground mt-1">
                      {{ instancia.projeto.categoria }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="space-y-3">
                <Button
                  @click="mostrarModalProgresso = true"
                  class="w-full"
                >
                  <FileText class="w-4 h-4 mr-2" />
                  Atualizar Progresso
                </Button>

                <Button
                  @click="downloadTemplate"
                  variant="outline"
                  class="w-full"
                >
                  <Download class="w-4 h-4 mr-2" />
                  Download Template
                </Button>
              </div>
            </div>
          </CardContent>
        </Card>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Descrição do Projeto -->
          <Card>
            <CardHeader>
              <CardTitle>Descrição do Projeto</CardTitle>
            </CardHeader>
            <CardContent>
              <p class="text-muted-foreground leading-relaxed">{{ instancia.projeto.descricao }}</p>
            </CardContent>
          </Card>

          <!-- Repositório e Anexos -->
          <Card>
            <CardHeader>
              <CardTitle>Arquivos e Links</CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
              <div v-if="instancia.repositorio_url">
                <div class="flex items-center gap-2 mb-2">
                  <Globe class="w-4 h-4 text-muted-foreground" />
                  <label class="text-sm font-medium text-muted-foreground">
                    Repositório
                  </label>
                </div>
                <a
                  :href="instancia.repositorio_url"
                  target="_blank"
                  class="text-primary hover:text-primary/80 text-sm break-all"
                >
                  {{ instancia.repositorio_url }}
                </a>
              </div>

              <div>
                <div class="flex items-center gap-2 mb-3">
                  <Upload class="w-4 h-4 text-muted-foreground" />
                  <label class="text-sm font-medium text-muted-foreground">
                    Arquivos Anexos
                  </label>
                </div>

                <div v-if="instancia.arquivos_anexos && instancia.arquivos_anexos.length > 0" class="space-y-2">
                  <div
                    v-for="(arquivo, index) in instancia.arquivos_anexos"
                    :key="index"
                    class="flex items-center justify-between p-3 bg-muted/50 rounded-lg border"
                  >
                    <div class="flex items-center space-x-3">
                      <div class="w-8 h-8 bg-primary/10 rounded flex items-center justify-center">
                        <FileText class="w-4 h-4 text-primary" />
                      </div>
                      <div>
                        <div class="font-medium text-sm">{{ arquivo.nome }}</div>
                        <div class="text-xs text-muted-foreground">{{ formatarTamanho(arquivo.tamanho) }}</div>
                      </div>
                    </div>
                    <Button
                      size="sm"
                      variant="ghost"
                      @click="window.open(`/storage/${arquivo.path}`, '_blank')"
                    >
                      <Download class="w-4 h-4" />
                    </Button>
                  </div>
                </div>
                <div v-else class="text-muted-foreground text-sm text-center py-4 border-2 border-dashed border-muted-foreground/25 rounded-lg">
                  Nenhum arquivo anexado
                </div>

                <div class="mt-3">
                  <input
                    ref="fileInput"
                    type="file"
                    @change="uploadArquivo"
                    class="hidden"
                  />
                  <Button
                    variant="outline"
                    size="sm"
                    @click="$refs.fileInput.click()"
                  >
                    <Upload class="w-4 h-4 mr-2" />
                    Anexar arquivo
                  </Button>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Observações -->
        <Card v-if="instancia.observacoes">
          <CardHeader>
            <CardTitle>Observações</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="text-muted-foreground whitespace-pre-wrap">{{ instancia.observacoes }}</div>
          </CardContent>
        </Card>

        <!-- Avaliações -->
        <Card v-if="instancia.avaliacoes && instancia.avaliacoes.length > 0">
          <CardHeader>
            <CardTitle>Avaliações Recebidas</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="space-y-4">
              <div
                v-for="avaliacao in instancia.avaliacoes"
                :key="avaliacao.id"
                class="border-l-4 border-primary/50 pl-4 py-2"
              >
                <div class="flex items-center justify-between mb-2">
                  <div class="font-medium">
                    {{ avaliacao.avaliador.name }}
                  </div>
                  <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                      <Star
                        v-for="i in 5"
                        :key="i"
                        :class="i <= avaliacao.nota ? 'fill-current' : ''"
                        class="w-4 h-4"
                      />
                    </div>
                    <span class="text-sm text-muted-foreground">
                      {{ formatarData(avaliacao.created_at) }}
                    </span>
                  </div>
                </div>
                <p class="text-muted-foreground">{{ avaliacao.comentario }}</p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>

    <!-- Modal Atualizar Progresso -->
    <div
      v-if="mostrarModalProgresso"
      class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center"
      @click.self="mostrarModalProgresso = false"
    >
      <div class="relative p-6 border w-full max-w-md shadow-lg rounded-xl bg-background">
        <div class="space-y-6">
          <div>
            <h3 class="text-lg font-semibold">Atualizar Progresso</h3>
            <p class="text-sm text-muted-foreground">
              Atualize o status atual do seu projeto
            </p>
          </div>

          <form @submit.prevent="salvarProgresso" class="space-y-4">
            <div>
              <label class="block text-sm font-medium mb-2">
                Percentual de Conclusão
              </label>
              <input
                v-model.number="formProgresso.percentual_conclusao"
                type="range"
                min="0"
                max="100"
                class="w-full h-2 bg-muted rounded-lg appearance-none cursor-pointer"
              />
              <div class="text-center mt-2 text-sm text-muted-foreground">
                {{ formProgresso.percentual_conclusao }}%
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                URL do Repositório
              </label>
              <input
                v-model="formProgresso.repositorio_url"
                type="url"
                class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="https://github.com/usuario/projeto"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                Observações
              </label>
              <textarea
                v-model="formProgresso.observacoes"
                rows="4"
                class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                placeholder="Descreva o progresso atual, dificuldades encontradas, próximos passos..."
              ></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
              <Button
                type="button"
                variant="outline"
                @click="mostrarModalProgresso = false"
              >
                Cancelar
              </Button>
              <Button
                type="submit"
                :disabled="processandoProgresso"
              >
                {{ processandoProgresso ? 'Salvando...' : 'Salvar' }}
              </Button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { ArrowLeft, Download, Upload, Star, Calendar, Globe, FileText } from 'lucide-vue-next';

import { type BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Meus Projetos',
    href: '/meus-projetos'
  },
];

// Props
const props = defineProps({
  instancia: Object,
  template: Object
});

// State
const mostrarModalProgresso = ref(false);
const processandoProgresso = ref(false);

const formProgresso = reactive({
  percentual_conclusao: props.instancia.percentual_conclusao || 0,
  repositorio_url: props.instancia.repositorio_url || '',
  observacoes: props.instancia.observacoes || ''
});

// Methods
const getStatusClass = (status) => {
  const classes = {
    'iniciado': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    'em_desenvolvimento': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'concluido': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'abandonado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  };
  return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
};

const getStatusText = (status) => {
  const texts = {
    'iniciado': 'Iniciado',
    'em_desenvolvimento': 'Em Desenvolvimento',
    'concluido': 'Concluído',
    'abandonado': 'Abandonado'
  };
  return texts[status] || 'Desconhecido';
};

const formatarData = (data) => {
  return new Date(data).toLocaleDateString('pt-BR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const formatarTamanho = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

const salvarProgresso = () => {
  processandoProgresso.value = true;

  router.put(route('meus-projetos.atualizar-progresso', props.instancia.id), formProgresso, {
    onSuccess: () => {
      mostrarModalProgresso.value = false;
      processandoProgresso.value = false;
    },
    onError: () => {
      processandoProgresso.value = false;
    }
  });
};

const uploadArquivo = (event) => {
  const arquivo = event.target.files[0];
  if (!arquivo) return;

  const formData = new FormData();
  formData.append('arquivo', arquivo);

  router.post(route('meus-projetos.upload-anexo', props.instancia?.id), formData, {
    forceFormData: true,
    onSuccess: () => {
      event.target.value = '';
    }
  });
};

const downloadTemplate = () => {
  // Usar location.href para garantir que o download funcione
  const url = route('meus-projetos.download-template', props.instancia?.id);

  // Criar link invisível e clicar nele
  const link = document.createElement('a');
  link.href = url;
  link.style.display = 'none';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};
</script>
