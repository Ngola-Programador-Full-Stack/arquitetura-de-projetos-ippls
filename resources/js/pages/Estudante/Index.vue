<template>
  <Head title="Estudantes" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Estudantes
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Gerencie os estudantes e acompanhe seus projetos
          </p>
        </div>
        <Button 
          v-if="$page.props.auth.user.tipo === 'coordenador'"
          @click="$inertia.visit(route('estudante.create'))"
        >
          <Plus class="w-4 h-4 mr-2" />
          Novo Estudante
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Filtros de Busca -->
        <Card>
          <CardContent class="p-4">
            <div class="flex items-center gap-4">
              <div class="flex-1">
                <input
                  v-model="filtroSearch"
                  type="text"
                  placeholder="Buscar por nome ou email..."
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  @keyup.enter="aplicarFiltros"
                />
              </div>
              <Button @click="aplicarFiltros">
                <Search class="w-4 h-4 mr-2" />
                Buscar
              </Button>
              <Button 
                variant="outline" 
                @click="limparFiltros"
                v-if="filtroSearch"
              >
                <X class="w-4 h-4 mr-2" />
                Limpar
              </Button>
            </div>
          </CardContent>
        </Card>

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Total de Estudantes</p>
                  <p class="text-2xl font-bold">{{ estudantes.total || estudantes.data?.length || 0 }}</p>
                </div>
                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                  <Users class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Com Projetos</p>
                  <p class="text-2xl font-bold">{{ estudantesComProjetos }}</p>
                </div>
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                  <BookOpen class="w-4 h-4 text-green-600 dark:text-green-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Ativos</p>
                  <p class="text-2xl font-bold">{{ estudantesAtivos }}</p>
                </div>
                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                  <CheckCircle class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Novos Este Mês</p>
                  <p class="text-2xl font-bold">{{ estudantesNovosMes }}</p>
                </div>
                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                  <UserPlus class="w-4 h-4 text-orange-600 dark:text-orange-400" />
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Lista de Estudantes -->
        <div v-if="estudantesList.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
          <Card
            v-for="estudante in estudantesList"
            :key="estudante.id"
            class="hover:shadow-lg transition-shadow duration-200"
          >
            <CardContent class="p-4">
              <div class="flex items-start space-x-4">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                  <div v-if="estudante.imagem" class="w-12 h-12 rounded-full overflow-hidden border-2 border-muted">
                    <img 
                      :src="`/storage/${estudante.imagem}`" 
                      :alt="estudante.name"
                      class="w-full h-full object-cover"
                    />
                  </div>
                  <div v-else class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                    <User class="w-6 h-6 text-primary" />
                  </div>
                </div>

                <!-- Informações -->
                <div class="flex-1 min-w-0">
                  <h3 class="font-semibold text-sm truncate">{{ estudante.name }}</h3>
                  <p class="text-xs text-muted-foreground truncate">{{ estudante.email }}</p>
                  
                  <div class="mt-2 space-y-1">
                    <div v-if="estudante.curso" class="flex items-center gap-1">
                      <GraduationCap class="w-3 h-3 text-muted-foreground" />
                      <span class="text-xs text-muted-foreground truncate">{{ estudante.curso.nome }}</span>
                    </div>
                    
                    <div v-if="estudante.turma" class="flex items-center gap-1">
                      <Users class="w-3 h-3 text-muted-foreground" />
                      <span class="text-xs text-muted-foreground truncate">{{ estudante.turma.nome }}</span>
                    </div>
                    
                    <div class="flex items-center gap-1">
                      <FolderOpen class="w-3 h-3 text-muted-foreground" />
                      <span class="text-xs text-muted-foreground">
                        {{ estudante.instancias_projeto?.length || 0 }} projeto(s)
                      </span>
                    </div>
                  </div>

                  <!-- Status e Ações -->
                  <div class="flex items-center justify-between mt-3">
                    <span 
                      class="px-2 py-1 text-xs font-medium rounded-full"
                      :class="estudante.ativo 
                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                        : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'"
                    >
                      {{ estudante.ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                    
                    <Button variant="ghost" size="sm">
                      <Eye class="w-3 h-3" />
                    </Button>
                  </div>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Estado vazio -->
        <Card v-else>
          <CardContent class="text-center py-16">
            <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center mb-4">
              <Users class="w-8 h-8 text-muted-foreground" />
            </div>
            <h3 class="text-lg font-semibold mb-2">
              {{ filtroSearch ? 'Nenhum estudante encontrado' : 'Nenhum estudante cadastrado' }}
            </h3>
            <p class="text-muted-foreground mb-6">
              {{ filtroSearch 
                ? 'Tente ajustar os filtros de busca.' 
                : 'Comece adicionando o primeiro estudante ao sistema.'
              }}
            </p>
            <Button 
              v-if="$page.props.auth.user.tipo === 'coordenador' && !filtroSearch"
              @click="$inertia.visit(route('estudante.create'))"
            >
              <Plus class="w-4 h-4 mr-2" />
              Adicionar Primeiro Estudante
            </Button>
          </CardContent>
        </Card>

        <!-- Paginação -->
        <div v-if="estudantesList.length > 0 && estudantes.links?.length > 3" class="flex justify-center">
          <div class="flex items-center gap-2">
            <template v-for="(link, index) in estudantes.links" :key="index">
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
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  Plus, Users, Search, X, Eye, User, BookOpen, CheckCircle, UserPlus,
  GraduationCap, FolderOpen
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

interface Estudante {
  id: number
  name: string
  email: string
  telefone_encarregado?: string
  imagem?: string
  ativo: boolean
  created_at: string
  curso?: {
    id: number
    nome: string
  }
  turma?: {
    id: number
    nome: string
  }
  instancias_projeto?: Array<{
    id: number
    status: string
  }>
}

interface PaginatedEstudantes {
  data: Estudante[]
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
  estudantes: PaginatedEstudantes
  filtros: {
    search?: string
  }
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Estudantes',
    href: '/estudantes'
  }
]

const filtroSearch = ref(props.filtros.search || '')

// Computeds
const estudantesList = computed(() => {
  return props.estudantes.data || []
})

const estudantesComProjetos = computed(() => {
  return estudantesList.value.filter(e => e.instancias_projeto && e.instancias_projeto.length > 0).length
})

const estudantesAtivos = computed(() => {
  return estudantesList.value.filter(e => e.ativo).length
})

const estudantesNovosMes = computed(() => {
  const umMesAtras = new Date()
  umMesAtras.setMonth(umMesAtras.getMonth() - 1)
  
  return estudantesList.value.filter(e => {
    const criadoEm = new Date(e.created_at)
    return criadoEm >= umMesAtras
  }).length
})

// Methods
const aplicarFiltros = () => {
  const params: any = {}
  if (filtroSearch.value) {
    params.search = filtroSearch.value
  }
  
  router.get(route('estudante.index'), params, {
    preserveState: true,
    replace: true
  })
}

const limparFiltros = () => {
  filtroSearch.value = ''
  router.get(route('estudante.index'), {}, {
    preserveState: true,
    replace: true
  })
}
</script>