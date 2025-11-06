<template>
  <Head title="Turmas" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestão de Turmas
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Gerencie as turmas da instituição
          </p>
        </div>
        <Button @click="$inertia.visit(route('turmas.create'))">
          <Plus class="w-4 h-4 mr-2" />
          Nova Turma
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Filtros de Busca -->
        <Card>
          <CardContent class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <div class="flex-1">
                <input
                  v-model="filtroSearch"
                  type="text"
                  placeholder="Buscar turmas..."
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  @keyup.enter="aplicarFiltros"
                />
              </div>
              
              <div>
                <select
                  v-model="filtroCurso"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                >
                  <option value="">Todos os cursos</option>
                  <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
                    {{ curso.nome }}
                  </option>
                </select>
              </div>
              
              <div>
                <select
                  v-model="filtroAno"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                >
                  <option value="">Todos os anos</option>
                  <option v-for="ano in anosLetivos" :key="ano" :value="ano">
                    {{ ano }}
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

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Total Turmas</p>
                  <p class="text-2xl font-bold">{{ turmas.total || 0 }}</p>
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
                  <p class="text-sm font-medium text-muted-foreground">Turmas Ativas</p>
                  <p class="text-2xl font-bold">{{ turmasAtivas }}</p>
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
                  <p class="text-sm font-medium text-muted-foreground">Estudantes</p>
                  <p class="text-2xl font-bold">{{ totalEstudantes }}</p>
                </div>
                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                  <GraduationCap class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Cursos</p>
                  <p class="text-2xl font-bold">{{ cursos?.length || 0 }}</p>
                </div>
                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                  <BookOpen class="w-4 h-4 text-orange-600 dark:text-orange-400" />
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Lista de Turmas -->
        <div v-if="turmas.data?.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <Card
            v-for="turma in turmas.data"
            :key="turma.id"
            class="hover:shadow-lg transition-shadow duration-200"
          >
            <CardHeader>
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <CardTitle class="text-lg">{{ turma.nome }}</CardTitle>
                  <CardDescription class="mt-1">
                    {{ turma.curso?.nome }}
                  </CardDescription>
                </div>
                <div class="ml-4">
                  <span 
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="turma.ativo 
                      ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                      : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'"
                  >
                    {{ turma.ativo ? 'Ativa' : 'Inativa' }}
                  </span>
                </div>
              </div>
            </CardHeader>
            
            <CardContent class="space-y-4">
              <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="flex items-center gap-2">
                  <Clock class="w-4 h-4 text-muted-foreground" />
                  <div>
                    <p class="font-medium">Período</p>
                    <p class="text-muted-foreground">{{ turma.periodo }}</p>
                  </div>
                </div>
                
                <div class="flex items-center gap-2">
                  <Calendar class="w-4 h-4 text-muted-foreground" />
                  <div>
                    <p class="font-medium">Ano Letivo</p>
                    <p class="text-muted-foreground">{{ turma.ano_letivo }}</p>
                  </div>
                </div>
              </div>

              <div class="pt-2 border-t">
                <div class="flex items-center gap-2 mb-2">
                  <Users class="w-4 h-4 text-muted-foreground" />
                  <span class="text-sm font-medium text-muted-foreground">Estudantes</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm">
                  <div>
                    <span class="font-medium">Total:</span>
                    <span class="text-muted-foreground ml-1">{{ turma.users?.length || 0 }}</span>
                  </div>
                  <div>
                    <span class="font-medium">Ativos:</span>
                    <span class="text-muted-foreground ml-1">{{ turma.users?.filter(u => u.ativo).length || 0 }}</span>
                  </div>
                </div>
              </div>
              
              <div class="flex gap-2 pt-2 border-t">
                <Button 
                  size="sm" 
                  variant="outline" 
                  @click="$inertia.visit(route('turmas.show', turma.id))"
                  class="flex-1"
                >
                  <Eye class="w-3 h-3 mr-1" />
                  Ver
                </Button>
                <Button 
                  size="sm" 
                  variant="outline" 
                  @click="$inertia.visit(route('turmas.edit', turma.id))"
                >
                  <Edit class="w-3 h-3" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline" 
                  @click="confirmarExclusao(turma)"
                  class="text-destructive hover:text-destructive"
                >
                  <Trash class="w-3 h-3" />
                </Button>
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
            <h3 class="text-lg font-semibold mb-2">Nenhuma turma encontrada</h3>
            <p class="text-muted-foreground mb-6">
              {{ filtroSearch || filtroCurso || filtroAno 
                ? 'Tente ajustar os filtros de busca.' 
                : 'Comece criando a primeira turma.'
              }}
            </p>
            <Button @click="$inertia.visit(route('turmas.create'))">
              <Plus class="w-4 h-4 mr-2" />
              {{ filtroSearch || filtroCurso || filtroAno ? 'Nova Turma' : 'Criar Primeira Turma' }}
            </Button>
          </CardContent>
        </Card>

        <!-- Paginação -->
        <div v-if="turmas.data?.length > 0 && turmas.links?.length > 3" class="flex justify-center">
          <div class="flex items-center gap-2">
            <template v-for="(link, index) in turmas.links" :key="index">
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

    <!-- Modal de Confirmação de Exclusão -->
    <ConfirmDialog
      v-model:open="showConfirmDialog"
      type="danger"
      title="Excluir Turma"
      :message="`Tem certeza que deseja excluir a turma '${turmaParaExcluir?.nome}'?`"
      :details="turmaParaExcluir?.users?.length > 0 
        ? `Esta turma possui ${turmaParaExcluir.users.length} estudante(s). A exclusão não será possível.` 
        : 'Esta ação não pode ser desfeita.'"
      confirm-text="Excluir"
      cancel-text="Cancelar"
      :loading="excluindoTurma"
      @confirm="executarExclusao"
      @cancel="cancelarExclusao"
    />
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import ConfirmDialog from '@/components/ConfirmDialog.vue'
import { 
  Plus, Users, Search, X, Eye, Edit, Trash, Clock, Calendar, 
  CheckCircle, GraduationCap, BookOpen
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

interface Curso {
  id: number
  nome: string
  codigo: string
  ativo: boolean
}

interface User {
  id: number
  name: string
  email: string
  ativo: boolean
  tipo: string
}

interface Turma {
  id: number
  nome: string
  periodo: string
  ano_letivo: number
  ativo: boolean
  curso?: Curso
  users?: User[]
}

interface PaginatedTurmas {
  data: Turma[]
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
  turmas: PaginatedTurmas
  cursos: Curso[]
  anosLetivos: number[]
  filtros: {
    search?: string
    curso_id?: number
    ano_letivo?: number
  }
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Turmas',
    href: '/turmas'
  }
]

const filtroSearch = ref(props.filtros.search || '')
const filtroCurso = ref(props.filtros.curso_id || '')
const filtroAno = ref(props.filtros.ano_letivo || '')

// Estado do modal de confirmação
const showConfirmDialog = ref(false)
const turmaParaExcluir = ref<Turma | null>(null)
const excluindoTurma = ref(false)

// Computeds
const turmasAtivas = computed(() => {
  return props.turmas.data?.filter(t => t.ativo).length || 0
})

const totalEstudantes = computed(() => {
  return props.turmas.data?.reduce((total, turma) => total + (turma.users?.length || 0), 0) || 0
})

// Methods
const aplicarFiltros = () => {
  const params: any = {}
  if (filtroSearch.value) params.search = filtroSearch.value
  if (filtroCurso.value) params.curso_id = filtroCurso.value
  if (filtroAno.value) params.ano_letivo = filtroAno.value
  
  router.get(route('turmas.index'), params, {
    preserveState: true,
    replace: true
  })
}

const limparFiltros = () => {
  filtroSearch.value = ''
  filtroCurso.value = ''
  filtroAno.value = ''
  
  router.get(route('turmas.index'), {}, {
    preserveState: true,
    replace: true
  })
}

const confirmarExclusao = (turma: Turma) => {
  turmaParaExcluir.value = turma
  showConfirmDialog.value = true
}

const executarExclusao = () => {
  if (!turmaParaExcluir.value) return
  
  excluindoTurma.value = true
  router.delete(route('turmas.destroy', turmaParaExcluir.value.id), {
    onFinish: () => {
      excluindoTurma.value = false
      showConfirmDialog.value = false
      turmaParaExcluir.value = null
    }
  })
}

const cancelarExclusao = () => {
  turmaParaExcluir.value = null
  showConfirmDialog.value = false
}
</script>