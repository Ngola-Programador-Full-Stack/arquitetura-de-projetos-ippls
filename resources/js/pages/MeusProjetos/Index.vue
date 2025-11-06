<template>
  <Head title="Meus Projetos" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Meus Projetos
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Gerencie seus projetos em andamento e concluídos
          </p>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Filtros -->
        <Card>
          <CardHeader>
            <CardTitle>Filtros</CardTitle>
            <CardDescription>Filtre seus projetos por status</CardDescription>
          </CardHeader>
          <CardContent>
            <form @submit.prevent="filtrar" class="flex items-end gap-4">
              <div class="flex-1">
                <label for="status" class="block text-sm font-medium mb-2">
                  Status do projeto
                </label>
                <select
                  id="status"
                  v-model="filtroStatus"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                >
                  <option value="">Todos os status</option>
                  <option v-for="(label, value) in statusOptions" :key="value" :value="value">
                    {{ label }}
                  </option>
                </select>
              </div>
              <div class="flex gap-2">
                <Button
                  type="button"
                  variant="outline"
                  @click="limparFiltro"
                >
                  <X class="w-4 h-4 mr-2" />
                  Limpar
                </Button>
                <Button type="submit">
                  <Filter class="w-4 h-4 mr-2" />
                  Filtrar
                </Button>
              </div>
            </form>
          </CardContent>
        </Card>

        <!-- Lista de Projetos -->
        <div v-if="projetos.data.length > 0" class="space-y-4">
          <Card
            v-for="instancia in projetos.data"
            :key="instancia.id"
            class="hover:shadow-lg transition-shadow duration-200"
          >
            <CardContent class="p-6">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                      <Folder class="w-5 h-5 text-primary" />
                    </div>
                    <div class="flex-1">
                      <h3 class="text-lg font-semibold">
                        {{ instancia.projeto.titulo }}
                      </h3>
                      <div class="flex items-center gap-2 mt-1">
                        <span
                          class="px-2 py-1 text-xs font-medium rounded-full"
                          :class="getStatusClass(instancia.status)"
                        >
                          {{ statusOptions[instancia.status] || instancia.status }}
                        </span>
                        <span
                          class="px-2 py-1 text-xs font-medium rounded-full"
                          :class="getNivelClass(instancia.projeto.nivel_dificuldade)"
                        >
                          {{ instancia.projeto.nivel_dificuldade.charAt(0).toUpperCase() + instancia.projeto.nivel_dificuldade.slice(1) }}
                        </span>
                      </div>
                    </div>
                  </div>

                  <p class="text-muted-foreground text-sm mb-4 line-clamp-2">
                    {{ instancia.projeto.descricao }}
                  </p>

                  <!-- Progresso -->
                  <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                      <span class="text-sm font-medium text-muted-foreground">Progresso</span>
                      <span class="text-sm font-medium">
                        {{ instancia.percentual_conclusao || 0 }}%
                      </span>
                    </div>
                    <div class="w-full bg-muted rounded-full h-2">
                      <div
                        class="bg-primary h-2 rounded-full transition-all duration-300"
                        :style="{ width: `${instancia.percentual_conclusao || 0}%` }"
                      />
                    </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
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
                        <CheckCircle class="w-4 h-4 text-muted-foreground" />
                        <span class="font-medium text-muted-foreground">Concluído em:</span>
                      </div>
                      <div class="text-foreground">
                        {{ formatarData(instancia.data_conclusao) }}
                      </div>
                    </div>

                    <div v-else-if="instancia.projeto.duracao_estimada">
                      <div class="flex items-center gap-2 mb-1">
                        <Clock class="w-4 h-4 text-muted-foreground" />
                        <span class="font-medium text-muted-foreground">Duração estimada:</span>
                      </div>
                      <div class="text-foreground">
                        {{ instancia.projeto.duracao_estimada }}h
                      </div>
                    </div>
                  </div>

                  <!-- Avaliação atual -->
                  <div v-if="instancia.avaliacao_atual" class="mt-4 pt-4 border-t">
                    <div class="flex items-center gap-2">
                      <span class="text-sm font-medium text-muted-foreground">Última avaliação:</span>
                      <div class="flex items-center">
                        <div class="flex">
                          <Star
                            v-for="i in 5"
                            :key="i"
                            class="w-4 h-4"
                            :class="i <= Math.floor(instancia.avaliacao_atual.nota / 2)
                              ? 'text-yellow-400 fill-current'
                              : 'text-muted-foreground'"
                          />
                        </div>
                        <span class="ml-2 text-sm text-muted-foreground">
                          {{ instancia.avaliacao_atual.nota }}/10
                        </span>
                      </div>
                    </div>
                  </div>

                  <!-- Tecnologias -->
                  <div v-if="instancia.projeto.tecnologias?.length" class="mt-4">
                    <div class="flex flex-wrap gap-1">
                      <span
                        v-for="tecnologia in instancia.projeto.tecnologias.slice(0, 4)"
                        :key="tecnologia"
                        class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs rounded-full"
                      >
                        {{ tecnologia }}
                      </span>
                      <span
                        v-if="instancia.projeto.tecnologias.length > 4"
                        class="px-2 py-1 bg-muted text-muted-foreground text-xs rounded-full"
                      >
                        +{{ instancia.projeto.tecnologias.length - 4 }}
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Ações -->
                <div class="flex flex-col gap-2 ml-6">
                  <Button @click="$inertia.visit(route('meus-projetos.show', instancia.id))">
                    <Settings class="w-4 h-4 mr-2" />
                    Gerenciar
                  </Button>

                  <Button
                    variant="outline"
                    @click="$inertia.visit(route('projetos.show', instancia.projeto.id))"
                  >
                    <Eye class="w-4 h-4 mr-2" />
                    Ver Original
                  </Button>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Estado vazio -->
        <Card v-else>
          <CardContent class="text-center py-16">
            <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center mb-4">
              <FolderOpen class="w-8 h-8 text-muted-foreground" />
            </div>
            <h3 class="text-lg font-semibold mb-2">
              Você ainda não iniciou nenhum projeto
            </h3>
            <p class="text-muted-foreground mb-6">
              Navegue pelos projetos disponíveis e comece sua jornada de aprendizado!
            </p>
            <Button @click="$inertia.visit(route('projetos.index'))">
              <Search class="w-4 h-4 mr-2" />
              Explorar Projetos
            </Button>
          </CardContent>
        </Card>

        <!-- Paginação -->
        <div v-if="projetos.data.length > 0 && (projetos.prev_page_url || projetos.next_page_url)" class="flex justify-center">
          <div class="flex items-center gap-2">
            <Button
              v-if="projetos.prev_page_url"
              variant="outline"
              @click="$inertia.visit(projetos.prev_page_url)"
            >
              <ChevronLeft class="w-4 h-4 mr-2" />
              Anterior
            </Button>

            <span class="px-4 py-2 text-sm text-muted-foreground">
              Página {{ projetos.current_page }} de {{ projetos.last_page }}
            </span>

            <Button
              v-if="projetos.next_page_url"
              variant="outline"
              @click="$inertia.visit(projetos.next_page_url)"
            >
              Próxima
              <ChevronRight class="w-4 h-4 ml-2" />
            </Button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import {
  Folder, FolderOpen, Calendar, CheckCircle, Clock, Star, Settings, Eye, Search, Filter, X,
  ChevronLeft, ChevronRight
} from 'lucide-vue-next';
import { type BreadcrumbItem } from '@/types';

// Props
const props = defineProps({
  projetos: Object,
  statusOptions: Object,
  filtros: Object
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Meus Projetos',
    href: '/meus-projetos'
  },
];

// Estado dos filtros
const filtroStatus = ref(props.filtros?.status || '');

// Methods
const getStatusClass = (status: string) => {
  const classes: Record<string, string> = {
    'iniciado': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    'em_desenvolvimento': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'concluido': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'abandonado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  };
  return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
};

const getNivelClass = (nivel: string) => {
  const classes: Record<string, string> = {
    'base': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'padrao': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'avancado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
    'básico': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'intermediário': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'avançado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  };
  return classes[nivel.toLowerCase()] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
};

const formatarData = (data: string) => {
  return new Date(data).toLocaleDateString('pt-BR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const filtrar = () => {
  const params: any = {};
  if (filtroStatus.value) {
    params.status = filtroStatus.value;
  }

  router.get(route('meus-projetos.index'), params, {
    preserveState: true,
    replace: true
  });
};

const limparFiltro = () => {
  filtroStatus.value = '';
  router.get(route('meus-projetos.index'), {}, {
    preserveState: true,
    replace: true
  });
};
</script>
