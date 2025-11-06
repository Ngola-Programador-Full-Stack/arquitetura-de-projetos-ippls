<template>
  <Head title="Supervisão de Projetos" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Supervisão de Projetos
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Monitore o progresso de todos os projetos dos estudantes
          </p>
        </div>
        <div class="flex items-center gap-3">
          <Button variant="outline" @click="$inertia.visit(route('supervisao.relatorio'))">
            <BarChart3 class="w-4 h-4 mr-2" />
            Relatórios
          </Button>
          <span class="text-sm text-muted-foreground">
            {{ instancias.total || 0 }} instância(s) encontrada(s)
          </span>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Estatísticas Principais -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Instâncias</p>
                  <p class="text-2xl font-bold">{{ estatisticas.total_instancias }}</p>
                </div>
                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                  <FolderOpen class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Estudantes</p>
                  <p class="text-2xl font-bold">{{ estatisticas.total_estudantes_ativos }}</p>
                </div>
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                  <Users class="w-4 h-4 text-green-600 dark:text-green-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Projetos</p>
                  <p class="text-2xl font-bold">{{ estatisticas.total_projetos }}</p>
                </div>
                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                  <Layers class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Turmas</p>
                  <p class="text-2xl font-bold">{{ estatisticas.total_turmas }}</p>
                </div>
                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                  <GraduationCap class="w-4 h-4 text-orange-600 dark:text-orange-400" />
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Estatísticas de Status -->
        <Card>
          <CardHeader>
            <CardTitle>Distribuição por Status</CardTitle>
            <CardDescription>
              Progresso geral dos projetos
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
              <div class="text-center">
                <p class="text-2xl font-bold text-blue-600">{{ estatisticas.instancias_por_status.iniciado }}</p>
                <p class="text-sm text-muted-foreground">Iniciados</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ estatisticas.instancias_por_status.em_desenvolvimento }}</p>
                <p class="text-sm text-muted-foreground">Em Desenvolvimento</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-green-600">{{ estatisticas.instancias_por_status.concluido }}</p>
                <p class="text-sm text-muted-foreground">Concluídos</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-orange-600">{{ estatisticas.pendentes_avaliacao }}</p>
                <p class="text-sm text-muted-foreground">Pendente Avaliação</p>
              </div>
              <div class="text-center">
                <p class="text-2xl font-bold text-primary">{{ Math.round(estatisticas.media_progresso) }}%</p>
                <p class="text-sm text-muted-foreground">Progresso Médio</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Filtros Avançados -->
        <Card>
          <CardContent class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
              <div>
                <input
                  v-model="filtroSearch"
                  type="text"
                  placeholder="Buscar estudante ou projeto..."
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
              
              <div>
                <select
                  v-model="filtroProjeto"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                >
                  <option value="">Todos os projetos</option>
                  <option v-for="projeto in projetos" :key="projeto.id" :value="projeto.id">
                    {{ projeto.titulo }}
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
              
              <div>
                <Button variant="outline" @click="exportarDados" class="w-full">
                  <Download class="w-4 h-4 mr-2" />
                  Exportar
                </Button>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Lista de Instâncias -->
        <div v-if="instancias.data?.length > 0" class="space-y-4">
          <Card
            v-for="instancia in instancias.data"
            :key="instancia.id"
            class="hover:shadow-md transition-shadow duration-200"
          >
            <CardContent class="p-6">
              <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Informações do Projeto e Estudante -->
                <div class="lg:col-span-2">
                  <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                      <h3 class="text-lg font-semibold mb-1">{{ instancia.projeto.titulo }}</h3>
                      <p class="text-sm text-muted-foreground flex items-center gap-1">
                        <User class="w-3 h-3" />
                        {{ instancia.usuario.name }} ({{ instancia.usuario.email }})
                      </p>
                    </div>
                    <span 
                      class="px-3 py-1 text-xs font-medium rounded-full"
                      :class="getStatusClass(instancia.status)"
                    >
                      {{ getStatusLabel(instancia.status) }}
                    </span>
                  </div>
                  
                  <!-- Progresso -->
                  <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                      <span class="font-medium">Progresso</span>
                      <span class="text-muted-foreground">{{ instancia.percentual_conclusao }}%</span>
                    </div>
                    <div class="w-full bg-muted rounded-full h-2">
                      <div 
                        class="bg-primary h-2 rounded-full transition-all duration-300" 
                        :style="`width: ${instancia.percentual_conclusao}%`"
                      ></div>
                    </div>
                  </div>
                </div>

                <!-- Detalhes Técnicos -->
                <div>
                  <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                      <span class="text-muted-foreground">Nível:</span>
                      <span 
                        class="px-2 py-1 text-xs rounded-full"
                        :class="getNivelClass(instancia.nivel_arquitetura)"
                      >
                        {{ instancia.nivel_arquitetura.charAt(0).toUpperCase() + instancia.nivel_arquitetura.slice(1) }}
                      </span>
                    </div>
                    <div class="flex justify-between">
                      <span class="text-muted-foreground">Iniciado:</span>
                      <span>{{ formatarData(instancia.data_inicio) }}</span>
                    </div>
                    <div class="flex justify-between">
                      <span class="text-muted-foreground">Atualizado:</span>
                      <span>{{ formatarData(instancia.updated_at) }}</span>
                    </div>
                    <div class="flex justify-between">
                      <span class="text-muted-foreground">Avaliações:</span>
                      <span class="flex items-center gap-1">
                        {{ instancia.avaliacoes?.length || 0 }}
                        <Star class="w-3 h-3 text-yellow-500" />
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Ações -->
                <div class="flex flex-col gap-2">
                  <Button 
                    size="sm" 
                    variant="outline"
                    @click="$inertia.visit(route('meus-projetos.show', instancia.id))"
                    class="w-full"
                  >
                    <Eye class="w-3 h-3 mr-1" />
                    Ver Projeto
                  </Button>
                  
                  <Button 
                    v-if="instancia.avaliacoes?.length > 0"
                    size="sm" 
                    variant="secondary"
                    @click="verAvaliacoes(instancia)"
                    class="w-full"
                  >
                    <FileText class="w-3 h-3 mr-1" />
                    Ver Avaliações
                  </Button>
                  
                  <Button 
                    v-if="instancia.usuario.email"
                    size="sm" 
                    variant="outline"
                    @click="contatarEstudante(instancia.usuario)"
                    class="w-full"
                  >
                    <Mail class="w-3 h-3 mr-1" />
                    Contatar
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
              <BarChart3 class="w-8 h-8 text-muted-foreground" />
            </div>
            <h3 class="text-lg font-semibold mb-2">Nenhuma instância encontrada</h3>
            <p class="text-muted-foreground mb-6">
              {{ filtroSearch || filtroStatus || filtroProjeto
                ? 'Tente ajustar os filtros de busca.' 
                : 'Não há instâncias de projetos no momento.'
              }}
            </p>
            <Button v-if="filtroSearch || filtroStatus || filtroProjeto" @click="limparFiltros">
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
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  BarChart3, FolderOpen, Users, Layers, GraduationCap, Search, X, 
  Eye, Star, User, Download, FileText, Mail
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

interface Projeto {
  id: number
  titulo: string
}

interface Usuario {
  id: number
  name: string
  email: string
}

interface Avaliacao {
  id: number
  nota: number
  avaliador: {
    name: string
  }
}

interface Instancia {
  id: number
  status: string
  percentual_conclusao: number
  nivel_arquitetura: string
  data_inicio: string
  updated_at: string
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

interface Estatisticas {
  total_instancias: number
  total_estudantes_ativos: number
  total_projetos: number
  total_turmas: number
  instancias_por_status: {
    iniciado: number
    em_desenvolvimento: number
    concluido: number
    abandonado: number
  }
  pendentes_avaliacao: number
  media_progresso: number
}

interface Props {
  instancias: PaginatedInstancias
  estatisticas: Estatisticas
  projetos: Projeto[]
  statusOptions: Record<string, string>
  filtros: {
    search?: string
    status?: string
    projeto_id?: number
  }
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Supervisão de Projetos',
    href: '/supervisao'
  }
]

const filtroSearch = ref(props.filtros.search || '')
const filtroStatus = ref(props.filtros.status || '')
const filtroProjeto = ref(props.filtros.projeto_id || '')

// Methods
const aplicarFiltros = () => {
  const params: any = {}
  if (filtroSearch.value) params.search = filtroSearch.value
  if (filtroStatus.value) params.status = filtroStatus.value
  if (filtroProjeto.value) params.projeto_id = filtroProjeto.value
  
  router.get(route('supervisao.index'), params, {
    preserveState: true,
    replace: true
  })
}

const limparFiltros = () => {
  filtroSearch.value = ''
  filtroStatus.value = ''
  filtroProjeto.value = ''
  
  router.get(route('supervisao.index'), {}, {
    preserveState: true,
    replace: true
  })
}

const getStatusClass = (status: string) => {
  const classes = {
    'iniciado': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    'em_desenvolvimento': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'concluido': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'abandonado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  }
  return classes[status as keyof typeof classes] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
}

const getStatusLabel = (status: string) => {
  const labels = {
    'iniciado': 'Iniciado',
    'em_desenvolvimento': 'Em Desenvolvimento',
    'concluido': 'Concluído',
    'abandonado': 'Abandonado'
  }
  return labels[status as keyof typeof labels] || status
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

const verAvaliacoes = (instancia: Instancia) => {
  // Implementar modal ou página de detalhes das avaliações
  console.log('Ver avaliações de:', instancia)
}

const contatarEstudante = (usuario: Usuario) => {
  window.open(`mailto:${usuario.email}?subject=Sobre seu projeto`)
}

const exportarDados = () => {
  // Implementar exportação dos dados filtrados
  console.log('Exportar dados com filtros:', { 
    search: filtroSearch.value,
    status: filtroStatus.value,
    projeto: filtroProjeto.value
  })
}
</script>