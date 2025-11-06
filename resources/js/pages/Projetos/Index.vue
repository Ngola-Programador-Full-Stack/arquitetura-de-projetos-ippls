<template>
  <Head title="Projetos" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Projetos Disponíveis
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Explore e participe dos projetos disponíveis
          </p>
        </div>
        <div class="flex gap-2">
          <!-- Botões específicos por tipo de usuário -->
          
          <!-- COORDENADORES -->
          <template v-if="$page.props.auth.user.tipo === 'coordenador'">
            <Button @click="$inertia.visit(route('projetos.create'))">
              <Plus class="w-4 h-4 mr-2" />
              Novo Projeto
            </Button>
            <Button 
              variant="outline" 
              @click="$inertia.visit(route('supervisao.index'))"
            >
              <BarChart3 class="w-4 h-4 mr-2" />
              Supervisão de Projetos
            </Button>
          </template>

          <!-- PROFESSORES -->
          <template v-if="$page.props.auth.user.tipo === 'professor'">
            <Button 
              variant="outline"
              @click="$inertia.visit(route('avaliacoes.index'))"
            >
              <Star class="w-4 h-4 mr-2" />
              Avaliações
            </Button>
          </template>

          <!-- ESTUDANTES -->
          <template v-if="$page.props.auth.user.tipo === 'estudante'">
            <Button
              variant="outline"
              @click="$inertia.visit(route('meus-projetos.index'))"
            >
              <FolderOpen class="w-4 h-4 mr-2" />
              Meus Projetos
            </Button>
          </template>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Filtros -->
        <Card>
          <CardHeader>
            <CardTitle>Filtros de Busca</CardTitle>
            <CardDescription>Encontre projetos usando os filtros abaixo</CardDescription>
          </CardHeader>
          <CardContent>
            <form @submit.prevent="pesquisar" class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Busca -->
                <div class="md:col-span-2">
                  <label for="search" class="block text-sm font-medium mb-2">
                    Buscar
                  </label>
                  <input
                    id="search"
                    v-model="form.search"
                    type="text"
                    placeholder="Buscar por título ou descrição..."
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  />
                </div>

                <!-- Categoria -->
                <div>
                  <label for="categoria" class="block text-sm font-medium mb-2">
                    Categoria
                  </label>
                  <select
                    id="categoria"
                    v-model="form.categoria"
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  >
                    <option value="">Todas as categorias</option>
                    <option v-for="categoria in categorias" :key="categoria" :value="categoria">
                      {{ categoria }}
                    </option>
                  </select>
                </div>

                <!-- Nível -->
                <div>
                  <label for="nivel" class="block text-sm font-medium mb-2">
                    Nível
                  </label>
                  <select
                    id="nivel"
                    v-model="form.nivel"
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  >
                    <option value="">Todos os níveis</option>
                    <option v-for="nivel in niveis" :key="nivel" :value="nivel">
                      {{ nivel.charAt(0).toUpperCase() + nivel.slice(1) }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="flex justify-end gap-2">
                <Button
                  type="button"
                  variant="outline"
                  @click="limparFiltros"
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
        <div v-if="projetos.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <Card
            v-for="projeto in projetos.data"
            :key="projeto.id"
            class="overflow-hidden hover:shadow-lg transition-shadow duration-200"
          >
            <div class="aspect-video bg-muted">
              <img
                :src="projeto.imagem_url || '/images/projeto-default.png'"
                :alt="projeto.titulo"
                class="w-full h-full object-cover"
                @error="$event.target.src = '/images/projeto-default.png'"
              />
            </div>

            <CardContent class="p-6">
              <div class="flex justify-between items-start mb-3">
                <h3 class="text-lg font-semibold line-clamp-2">
                  {{ projeto.titulo }}
                </h3>
                <span
                  class="px-2 py-1 text-xs font-medium rounded-full ml-2 flex-shrink-0"
                  :class="getNivelClass(projeto.nivel_dificuldade)"
                >
                  {{ projeto.nivel_dificuldade.charAt(0).toUpperCase() + projeto.nivel_dificuldade.slice(1) }}
                </span>
              </div>

              <p class="text-muted-foreground text-sm mb-4 line-clamp-3">
                {{ projeto.descricao }}
              </p>

              <!-- Tecnologias -->
              <div v-if="projeto.tecnologias?.length" class="flex flex-wrap gap-1 mb-4">
                <span
                  v-for="tecnologia in projeto.tecnologias.slice(0, 3)"
                  :key="tecnologia"
                  class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs rounded-full"
                >
                  {{ tecnologia }}
                </span>
                <span
                  v-if="projeto.tecnologias.length > 3"
                  class="px-2 py-1 bg-muted text-muted-foreground text-xs rounded-full"
                >
                  +{{ projeto.tecnologias.length - 3 }}
                </span>
              </div>

              <div class="flex justify-between items-center">
                <div class="flex items-center text-sm text-muted-foreground">
                  <Clock class="w-4 h-4 mr-1" />
                  {{ projeto.duracao_estimada }}h
                </div>
                <Button @click="$inertia.visit(route('projetos.show', projeto.id))">
                  <Eye class="w-4 h-4 mr-2" />
                  Ver Detalhes
                </Button>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Estado vazio -->
        <Card v-else>
          <CardContent class="text-center py-16">
            <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center mb-4">
              <Search class="w-8 h-8 text-muted-foreground" />
            </div>
            <h3 class="text-lg font-semibold mb-2">
              Nenhum projeto encontrado
            </h3>
            <p class="text-muted-foreground mb-6">
              Tente ajustar os filtros ou criar um novo projeto
            </p>
            <Button
              v-if="$page.props.auth.user.tipo === 'coordenador'"
              @click="$inertia.visit(route('projetos.create'))"
            >
              <Plus class="w-4 h-4 mr-2" />
              Criar Primeiro Projeto
            </Button>
          </CardContent>
        </Card>

        <!-- Paginação -->
        <div v-if="projetos.data.length > 0 && projetos.links.length > 3" class="flex justify-center">
          <div class="flex items-center gap-2">
            <template v-for="(link, index) in projetos.links" :key="index">
              <Button
                v-if="link.url"
                :variant="link.active ? 'default' : 'outline'"
                @click="$inertia.visit(link.url)"
                v-html="link.label"
                size="sm"
                class="min-w-[2.5rem]"
              />
              <span
                v-else
                class="px-3 py-2 text-sm text-muted-foreground"
                v-html="link.label"
              />
            </template>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Clock, Search, Filter, X, Eye, Plus, FolderOpen, BarChart3, Star } from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Projetos',
    href: '/projetos'
  },
];

interface Projeto {
  id: number
  titulo: string
  descricao: string
  imagem_url?: string
  categoria: string
  nivel_dificuldade: 'base' | 'padrao' | 'avancado'
  tecnologias: string[]
  duracao_estimada: number
  criador: {
    id: number
    name: string
  }
}

interface PaginatedData {
  data: Projeto[]
  links: Array<{
    url: string | null
    label: string
    active: boolean
  }>
  current_page: number
  last_page: number
  per_page: number
  total: number
}

interface Props {
  projetos: PaginatedData
  categorias: string[]
  niveis: string[]
  filtros: {
    search?: string
    categoria?: string
    nivel?: string
  }
  user: {
    id: number
    name: string
    email: string
    tipo: 'estudante' | 'professor' | 'coordenador'
  }
}

const props = defineProps<Props>()

const form = ref({
  search: props.filtros.search || '',
  categoria: props.filtros.categoria || '',
  nivel: props.filtros.nivel || ''
})

const pesquisar = () => {
  router.get(route('projetos.index'), {
    search: form.value.search,
    categoria: form.value.categoria,
    nivel: form.value.nivel
  }, {
    preserveState: true,
    replace: true
  })
}

const limparFiltros = () => {
  form.value.search = ''
  form.value.categoria = ''
  form.value.nivel = ''
  router.get(route('projetos.index'))
}

const getNivelClass = (nivel: string) => {
  const classes = {
    'base': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'padrao': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'avancado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  }
  return classes[nivel] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200'
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
