<template>
  <Head title="Avaliações" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Avaliações de Projetos
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Avalie o progresso dos projetos dos seus estudantes
          </p>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-sm text-muted-foreground">
            {{ instancias.total || 0 }} projeto(s) encontrado(s)
          </span>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Total</p>
                  <p class="text-2xl font-bold">{{ instancias.total || 0 }}</p>
                </div>
                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                  <BarChart3 class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                </div>
              </div>
            </CardContent>
          </Card>

          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Pendentes</p>
                  <p class="text-2xl font-bold">{{ estatisticasPendentes }}</p>
                </div>
                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                  <Clock class="w-4 h-4 text-orange-600 dark:text-orange-400" />
                </div>
              </div>
            </CardContent>
          </Card>

          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Avaliados</p>
                  <p class="text-2xl font-bold">{{ estatisticasAvaliados }}</p>
                </div>
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                  <CheckCircle class="w-4 h-4 text-green-600 dark:text-green-400" />
                </div>
              </div>
            </CardContent>
          </Card>

          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Concluídos</p>
                  <p class="text-2xl font-bold">{{ estatisticasConcluidos }}</p>
                </div>
                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                  <Trophy class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Filtros -->
        <Card>
          <CardContent class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <div class="md:col-span-2">
                <input
                  v-model="filtroSearch"
                  type="text"
                  placeholder="Buscar por projeto ou estudante..."
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  @keyup.enter="aplicarFiltros"
                />
              </div>

              <div>
                <select
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
                <Button @click="aplicarFiltros" class="flex-1">
                  <Search class="w-4 h-4 mr-2" />
                  Filtrar
                </Button>
                <Button variant="outline" @click="limparFiltros">
                  <X class="w-4 h-4" />
                </Button>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Lista de Projetos para Avaliação -->
        <div v-if="instancias.data?.length > 0" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <Card
            v-for="instancia in instancias.data"
            :key="instancia.id"
            class="hover:shadow-lg transition-shadow duration-200"
          >
            <CardHeader>
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <CardTitle class="text-lg">{{ instancia.projeto.titulo }}</CardTitle>
                  <CardDescription class="mt-1">
                    Estudante: {{ instancia.usuario.name }}
                  </CardDescription>
                </div>
                <div class="ml-4">
                  <span
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="getStatusClass(instancia)"
                  >
                    {{ getStatusLabel(instancia) }}
                  </span>
                </div>
              </div>
            </CardHeader>

            <CardContent class="space-y-4">
              <!-- Progresso -->
              <div>
                <div class="flex justify-between text-sm mb-1">
                  <span class="font-medium">Progresso</span>
                  <span class="text-muted-foreground">{{ instancia.percentual_conclusao || 0 }}%</span>
                </div>
                <div class="w-full bg-muted rounded-full h-2">
                  <div
                    class="bg-primary h-2 rounded-full transition-all duration-300"
                    :style="`width: ${instancia.percentual_conclusao || 0}%`"
                  ></div>
                </div>
              </div>

              <!-- Informações do projeto -->
              <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="flex items-center gap-2">
                  <Calendar class="w-3 h-3 text-muted-foreground" />
                  <span class="text-muted-foreground">Iniciado</span>
                </div>
                <div class="text-right">
                  {{ formatarData(instancia.data_inicio) }}
                </div>

                <div class="flex items-center gap-2">
                  <Layers class="w-3 h-3 text-muted-foreground" />
                  <span class="text-muted-foreground">Arquitetura</span>
                </div>
                <div class="text-right">
                  <span
                    class="px-2 py-1 text-xs rounded-full"
                    :class="getNivelClass(instancia.nivel_arquitetura)"
                  >
                    {{ instancia.nivel_arquitetura.charAt(0).toUpperCase() + instancia.nivel_arquitetura.slice(1) }}
                  </span>
                </div>
              </div>

              <!-- Avaliação -->
              <div v-if="instancia.avaliacoes?.length > 0" class="pt-2 border-t">
                <div class="flex items-center gap-2 mb-2">
                  <Star class="w-4 h-4 text-yellow-500" />
                  <span class="text-sm font-medium">Última Avaliação</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-2xl font-bold">
                    {{ instancia.avaliacoes[0].nota }}<span class="text-lg text-muted-foreground">/20</span>
                  </span>
                  <span class="text-xs text-muted-foreground">
                    {{ formatarData(instancia.avaliacoes[0].created_at) }}
                  </span>
                </div>
              </div>

              <!-- Ações -->
              <div class="flex gap-2 pt-2 border-t">
                <Button
                  size="sm"
                  variant="outline"
                  @click="$inertia.visit(route('meus-projetos.show', instancia.id))"
                  class="flex-1"
                >
                  <Eye class="w-3 h-3 mr-1" />
                  Ver Projeto
                </Button>

                <Button
                  v-if="!instancia.avaliacoes?.length || instancia.status === 'concluido'"
                  size="sm"
                  @click="avaliarProjeto(instancia)"
                  :disabled="instancia.percentual_conclusao < 100 && instancia.status !== 'concluido'"
                >
                  <Star class="w-3 h-3 mr-1" />
                  {{ instancia.avaliacoes?.length > 0 ? 'Reavaliar' : 'Avaliar' }}
                </Button>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Estado vazio -->
        <Card v-else>
          <CardContent class="text-center py-16">
            <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center mb-4">
              <BarChart3 class="w-8 h-8 text-muted-foreground" />
            </div>
            <h3 class="text-lg font-semibold mb-2">Nenhum projeto encontrado</h3>
            <p class="text-muted-foreground mb-6">
              {{ filtroSearch || filtroStatus
                ? 'Tente ajustar os filtros de busca.'
                : 'Não há projetos dos seus estudantes para avaliar no momento.'
              }}
            </p>
            <Button v-if="filtroSearch || filtroStatus" @click="limparFiltros">
              <X class="w-4 h-4 mr-2" />
              Limpar Filtros
            </Button>
          </CardContent>
        </Card>

        <!-- Paginação -->
        <div v-if="instancias.data?.length > 0 && instancias.links?.length > 3" class="flex justify-center">
          <div class="flex items-center gap-2">
            <template v-for="(link, index) in instancias.links" :key="index">
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
import { Head, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import {
  BarChart3, Clock, CheckCircle, Trophy, Search, X, Eye, Star,
  Calendar, Layers
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

interface Projeto {
  id: number
  titulo: string
  descricao: string
  categoria: string
}

interface Usuario {
  id: number
  name: string
  email: string
}

interface Avaliacao {
  id: number
  nota: number
  comentarios: string
  created_at: string
}

interface Instancia {
  id: number
  status: string
  percentual_conclusao: number
  nivel_arquitetura: string
  data_inicio: string
  projeto: Projeto
  usuario: Usuario
  avaliacoes?: Avaliacao[]
}

interface PaginatedInstancias {
  data: Instancia[]
  current_page: number
  last_page: number
  per_page: number
  total: number
  links: Array<{
    url: string | null
    label: string
    active: boolean
  }>
}

interface Props {
  instancias: PaginatedInstancias
  statusOptions: Record<string, string>
  filtros: {
    status?: string
  }
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Avaliações',
    href: '/avaliacoes'
  }
]

const filtroSearch = ref('')
const filtroStatus = ref(props.filtros.status || '')

// Computeds para estatísticas
const estatisticasPendentes = computed(() => {
  return props.instancias.data?.filter(i => !i.avaliacoes?.length).length || 0
})

const estatisticasAvaliados = computed(() => {
  return props.instancias.data?.filter(i => i.avaliacoes?.length > 0).length || 0
})

const estatisticasConcluidos = computed(() => {
  return props.instancias.data?.filter(i => i.status === 'concluido').length || 0
})

// Methods
const aplicarFiltros = () => {
  const params: any = {}
  if (filtroSearch.value) params.search = filtroSearch.value
  if (filtroStatus.value) params.status = filtroStatus.value

  router.get(route('avaliacoes.index'), params, {
    preserveState: true,
    replace: true
  })
}

const limparFiltros = () => {
  filtroSearch.value = ''
  filtroStatus.value = ''

  router.get(route('avaliacoes.index'), {}, {
    preserveState: true,
    replace: true
  })
}

const getStatusClass = (instancia: Instancia) => {
  if (instancia.avaliacoes?.length > 0) {
    return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
  }

  switch (instancia.status) {
    case 'concluido':
      return 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
    case 'em_desenvolvimento':
      return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
    default:
      return 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200'
  }
}

const getStatusLabel = (instancia: Instancia) => {
  if (instancia.avaliacoes?.length > 0) {
    return 'Avaliado'
  }

  switch (instancia.status) {
    case 'concluido':
      return 'Concluído'
    case 'em_desenvolvimento':
      return 'Em Desenvolvimento'
    case 'iniciado':
      return 'Pendente'
    default:
      return instancia.status
  }
}

const getNivelClass = (nivel: string) => {
  const classes = {
    'base': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'padrao': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'avancado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  }
  return classes[nivel as keyof typeof classes] || 'bg-gray-100 text-gray-800'
}

const formatarData = (data: string) => {
  return new Date(data).toLocaleDateString('pt-BR', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const avaliarProjeto = (instancia: Instancia) => {
  // Redirecionar para página de avaliação
  router.visit(route('avaliacoes.show', instancia.id))
}
</script>
