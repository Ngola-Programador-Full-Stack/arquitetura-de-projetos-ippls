<template>
  <Head title="Gestão de Professores" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestão de Professores
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Gerencie os professores e suas turmas
          </p>
        </div>
        <Button @click="$inertia.visit(route('professores.create'))">
          <Plus class="w-4 h-4 mr-2" />
          Novo Professor
        </Button>
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
                  <p class="text-sm font-medium text-muted-foreground">Total Professores</p>
                  <p class="text-2xl font-bold">{{ professores.total || 0 }}</p>
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
                  <p class="text-sm font-medium text-muted-foreground">Professores Ativos</p>
                  <p class="text-2xl font-bold">{{ professoresAtivos }}</p>
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
                  <p class="text-sm font-medium text-muted-foreground">Com Turmas</p>
                  <p class="text-2xl font-bold">{{ professoresComTurmas }}</p>
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
                  <p class="text-sm font-medium text-muted-foreground">Turmas Atribuídas</p>
                  <p class="text-2xl font-bold">{{ totalTurmasAtribuidas }}</p>
                </div>
                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                  <BookOpen class="w-4 h-4 text-orange-600 dark:text-orange-400" />
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
                  placeholder="Buscar por nome ou email..."
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

        <!-- Lista de Professores -->
        <div v-if="professores.data?.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <Card
            v-for="professor in professores.data"
            :key="professor.id"
            class="hover:shadow-lg transition-shadow duration-200"
          >
            <CardHeader>
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <CardTitle class="text-lg">{{ professor.name }}</CardTitle>
                  <CardDescription class="mt-1">
                    {{ professor.email }}
                  </CardDescription>
                </div>
                <div class="ml-4">
                  <span 
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="professor.ativo 
                      ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                      : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'"
                  >
                    {{ professor.ativo ? 'Ativo' : 'Inativo' }}
                  </span>
                </div>
              </div>
            </CardHeader>
            
            <CardContent class="space-y-4">
              <!-- Informações do Professor -->
              <div class="space-y-2 text-sm">
                <div v-if="professor.telefone_encarregado" class="flex items-center gap-2">
                  <Phone class="w-3 h-3 text-muted-foreground" />
                  <span class="text-muted-foreground">{{ professor.telefone_encarregado }}</span>
                </div>
                <div v-if="professor.curso" class="flex items-center gap-2">
                  <BookOpen class="w-3 h-3 text-muted-foreground" />
                  <span class="text-muted-foreground">{{ professor.curso.nome }}</span>
                </div>
              </div>

              <!-- Turmas do Professor -->
              <div class="pt-2 border-t">
                <div class="flex items-center gap-2 mb-2">
                  <GraduationCap class="w-4 h-4 text-muted-foreground" />
                  <span class="text-sm font-medium text-muted-foreground">Turmas</span>
                </div>
                
                <div v-if="professor.turmas?.length > 0" class="space-y-1">
                  <div 
                    v-for="turma in professor.turmas.slice(0, 3)" 
                    :key="turma.id"
                    class="text-xs bg-secondary px-2 py-1 rounded"
                  >
                    {{ turma.nome }} - {{ turma.periodo }}
                  </div>
                  <div v-if="professor.turmas.length > 3" class="text-xs text-muted-foreground">
                    +{{ professor.turmas.length - 3 }} turma(s)
                  </div>
                </div>
                
                <div v-else class="text-xs text-muted-foreground">
                  Nenhuma turma atribuída
                </div>
              </div>
              
              <!-- Ações -->
              <div class="flex gap-2 pt-2 border-t">
                <Button 
                  size="sm" 
                  variant="outline"
                  @click="$inertia.visit(route('professores.show', professor.id))"
                  class="flex-1"
                >
                  <Eye class="w-3 h-3 mr-1" />
                  Ver
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  @click="$inertia.visit(route('professores.edit', professor.id))"
                >
                  <Edit class="w-3 h-3" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  @click="confirmarExclusao(professor)"
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
            <h3 class="text-lg font-semibold mb-2">Nenhum professor encontrado</h3>
            <p class="text-muted-foreground mb-6">
              {{ filtroSearch || filtroStatus 
                ? 'Tente ajustar os filtros de busca.' 
                : 'Comece cadastrando o primeiro professor.'
              }}
            </p>
            <Button @click="$inertia.visit(route('professores.create'))">
              <Plus class="w-4 h-4 mr-2" />
              {{ filtroSearch || filtroStatus ? 'Novo Professor' : 'Cadastrar Primeiro Professor' }}
            </Button>
          </CardContent>
        </Card>

        <!-- Paginação -->
        <div v-if="professores.data?.length > 0 && professores.links?.length > 3" class="flex justify-center">
          <div class="flex items-center gap-2">
            <template v-for="(link, index) in professores.links" :key="index">
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
      title="Excluir Professor"
      :message="`Tem certeza que deseja excluir o professor '${professorParaExcluir?.name}'?`"
      :details="professorParaExcluir?.turmas?.length > 0 
        ? `Este professor possui ${professorParaExcluir.turmas.length} turma(s) atribuída(s).` 
        : 'Esta ação não pode ser desfeita.'"
      confirm-text="Excluir"
      cancel-text="Cancelar"
      :loading="excluindoProfessor"
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
  Plus, Users, Search, X, Eye, Edit, Trash, Phone, BookOpen, 
  CheckCircle, GraduationCap
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

interface Curso {
  id: number
  nome: string
  codigo: string
}

interface Turma {
  id: number
  nome: string
  periodo: string
  ano_letivo: number
  curso?: Curso
}

interface Professor {
  id: number
  name: string
  email: string
  telefone_encarregado?: string
  ativo: boolean
  curso?: Curso
  turmas?: Turma[]
}

interface PaginatedProfessores {
  data: Professor[]
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
  professores: PaginatedProfessores
  turmas: Turma[]
  statusOptions: Record<string, string>
  filtros: {
    search?: string
    ativo?: string
    turma_id?: number
  }
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Professores',
    href: '/professores'
  }
]

const filtroSearch = ref(props.filtros.search || '')
const filtroStatus = ref(props.filtros.ativo || '')

// Estado do modal de confirmação
const showConfirmDialog = ref(false)
const professorParaExcluir = ref<Professor | null>(null)
const excluindoProfessor = ref(false)

// Computeds para estatísticas
const professoresAtivos = computed(() => {
  return props.professores.data?.filter(p => p.ativo).length || 0
})

const professoresComTurmas = computed(() => {
  return props.professores.data?.filter(p => p.turmas && p.turmas.length > 0).length || 0
})

const totalTurmasAtribuidas = computed(() => {
  return props.professores.data?.reduce((total, professor) => {
    return total + (professor.turmas?.length || 0)
  }, 0) || 0
})

// Methods
const aplicarFiltros = () => {
  const params: any = {}
  if (filtroSearch.value) params.search = filtroSearch.value
  if (filtroStatus.value) params.ativo = filtroStatus.value
  
  router.get(route('professores.index'), params, {
    preserveState: true,
    replace: true
  })
}

const limparFiltros = () => {
  filtroSearch.value = ''
  filtroStatus.value = ''
  
  router.get(route('professores.index'), {}, {
    preserveState: true,
    replace: true
  })
}

const confirmarExclusao = (professor: Professor) => {
  professorParaExcluir.value = professor
  showConfirmDialog.value = true
}

const executarExclusao = () => {
  if (!professorParaExcluir.value) return
  
  excluindoProfessor.value = true
  router.delete(route('professores.destroy', professorParaExcluir.value.id), {
    onFinish: () => {
      excluindoProfessor.value = false
      showConfirmDialog.value = false
      professorParaExcluir.value = null
    }
  })
}

const cancelarExclusao = () => {
  professorParaExcluir.value = null
  showConfirmDialog.value = false
}
</script>