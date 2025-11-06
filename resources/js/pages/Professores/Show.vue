<template>
  <Head :title="professor.name" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ professor.name }}
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Professor - {{ professor.email }}
          </p>
        </div>
        <div class="flex gap-2">
          <Button 
            variant="outline" 
            @click="$inertia.visit(route('professores.edit', professor.id))"
          >
            <Edit class="w-4 h-4 mr-2" />
            Editar
          </Button>
          <Button 
            variant="outline" 
            @click="$inertia.visit(route('professores.index'))"
          >
            <ArrowLeft class="w-4 h-4 mr-2" />
            Voltar
          </Button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Status e Informações Básicas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Informações Pessoais -->
          <Card class="md:col-span-2">
            <CardHeader>
              <CardTitle class="flex items-center justify-between">
                <span class="flex items-center gap-2">
                  <User class="w-5 h-5" />
                  Informações Pessoais
                </span>
                <span 
                  class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full"
                  :class="professor.ativo 
                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                    : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'"
                >
                  {{ professor.ativo ? 'Ativo' : 'Inativo' }}
                </span>
              </CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium text-muted-foreground">Nome</label>
                  <p class="text-sm font-medium">{{ professor.name }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-muted-foreground">Email</label>
                  <p class="text-sm font-medium">{{ professor.email }}</p>
                </div>
                <div v-if="professor.telefone_encarregado">
                  <label class="text-sm font-medium text-muted-foreground">Telefone</label>
                  <p class="text-sm font-medium">{{ professor.telefone_encarregado }}</p>
                </div>
                <div v-if="professor.curso">
                  <label class="text-sm font-medium text-muted-foreground">Curso de Vinculação</label>
                  <p class="text-sm font-medium">{{ professor.curso.nome }} ({{ professor.curso.codigo }})</p>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Estatísticas Rápidas -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center gap-2">
                <BarChart class="w-5 h-5" />
                Estatísticas
              </CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="text-center">
                <div class="text-2xl font-bold">{{ professor.turmas?.length || 0 }}</div>
                <p class="text-sm text-muted-foreground">Turmas Atribuídas</p>
              </div>
              <div class="text-center">
                <div class="text-2xl font-bold">{{ totalEstudantes }}</div>
                <p class="text-sm text-muted-foreground">Total de Estudantes</p>
              </div>
              <div class="text-center">
                <div class="text-2xl font-bold">{{ avaliacoesRealizadas }}</div>
                <p class="text-sm text-muted-foreground">Avaliações Realizadas</p>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Turmas e Projetos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Turmas Atribuídas -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center gap-2">
                <GraduationCap class="w-5 h-5" />
                Turmas Atribuídas
              </CardTitle>
              <CardDescription>
                Turmas sob responsabilidade do professor
              </CardDescription>
            </CardHeader>
            <CardContent>
              <div v-if="professor.turmas?.length > 0" class="space-y-3">
                <div 
                  v-for="turma in professor.turmas" 
                  :key="turma.id"
                  class="p-3 border border-border rounded-lg hover:bg-muted/50 transition-colors"
                >
                  <div class="flex items-center justify-between">
                    <div>
                      <h4 class="font-medium">{{ turma.nome }}</h4>
                      <p class="text-sm text-muted-foreground">
                        {{ turma.periodo }} - {{ turma.ano_letivo }}
                      </p>
                      <div v-if="turma.curso" class="flex items-center gap-1 mt-1">
                        <span class="text-xs bg-secondary px-2 py-1 rounded">
                          {{ turma.curso.codigo }}
                        </span>
                        <span class="text-xs text-muted-foreground">
                          {{ turma.curso.nome }}
                        </span>
                      </div>
                    </div>
                    <div class="text-right">
                      <div class="text-sm font-medium">
                        {{ turma.estudantes_count || 0 }} estudantes
                      </div>
                      <div class="text-xs text-muted-foreground">
                        {{ turma.projetos_count || 0 }} projetos
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="text-center py-8">
                <GraduationCap class="w-12 h-12 mx-auto text-muted-foreground mb-4" />
                <p class="text-muted-foreground">Nenhuma turma atribuída</p>
              </div>
            </CardContent>
          </Card>

          <!-- Projetos para Avaliação -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center gap-2">
                <ClipboardCheck class="w-5 h-5" />
                Projetos para Avaliação
              </CardTitle>
              <CardDescription>
                Projetos aguardando avaliação
              </CardDescription>
            </CardHeader>
            <CardContent>
              <div v-if="projetosPendentes.length > 0" class="space-y-3">
                <div 
                  v-for="projeto in projetosPendentes.slice(0, 5)" 
                  :key="projeto.id"
                  class="p-3 border border-border rounded-lg hover:bg-muted/50 transition-colors"
                >
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <h4 class="font-medium text-sm">{{ projeto.titulo }}</h4>
                      <p class="text-xs text-muted-foreground">
                        {{ projeto.estudante?.name }} - {{ projeto.turma?.nome }}
                      </p>
                      <div class="flex items-center gap-1 mt-1">
                        <span 
                          class="text-xs px-2 py-1 rounded"
                          :class="getStatusBadgeClass(projeto.status)"
                        >
                          {{ projeto.status }}
                        </span>
                      </div>
                    </div>
                    <div class="text-xs text-muted-foreground">
                      {{ formatarDataRelativa(projeto.data_submissao) }}
                    </div>
                  </div>
                </div>
                
                <div v-if="projetosPendentes.length > 5" class="text-center pt-2 border-t">
                  <Button variant="outline" size="sm">
                    Ver todos os {{ projetosPendentes.length }} projetos
                  </Button>
                </div>
              </div>
              <div v-else class="text-center py-8">
                <ClipboardCheck class="w-12 h-12 mx-auto text-muted-foreground mb-4" />
                <p class="text-muted-foreground">Nenhum projeto para avaliar</p>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Histórico de Avaliações -->
        <Card>
          <CardHeader>
            <CardTitle class="flex items-center gap-2">
              <History class="w-5 h-5" />
              Histórico de Avaliações
            </CardTitle>
            <CardDescription>
              Últimas avaliações realizadas pelo professor
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div v-if="historicoAvaliacoes.length > 0" class="space-y-4">
              <div 
                v-for="avaliacao in historicoAvaliacoes.slice(0, 10)" 
                :key="avaliacao.id"
                class="flex items-center justify-between p-3 border border-border rounded-lg"
              >
                <div class="flex-1">
                  <h4 class="font-medium text-sm">{{ avaliacao.projeto.titulo }}</h4>
                  <p class="text-xs text-muted-foreground">
                    {{ avaliacao.projeto.estudante.name }} - {{ avaliacao.projeto.turma.nome }}
                  </p>
                  <p class="text-xs text-muted-foreground mt-1">
                    Avaliado em {{ formatarData(avaliacao.created_at) }}
                  </p>
                </div>
                <div class="text-right">
                  <div class="text-sm font-medium">
                    Nota: {{ avaliacao.nota_final }}/10
                  </div>
                  <span 
                    class="text-xs px-2 py-1 rounded"
                    :class="avaliacao.status === 'Aprovado' 
                      ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                      : avaliacao.status === 'Reprovado'
                      ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                      : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'"
                  >
                    {{ avaliacao.status }}
                  </span>
                </div>
              </div>
            </div>
            <div v-else class="text-center py-8">
              <History class="w-12 h-12 mx-auto text-muted-foreground mb-4" />
              <p class="text-muted-foreground">Nenhuma avaliação realizada</p>
            </div>
          </CardContent>
        </Card>

        <!-- Informações do Sistema -->
        <Card>
          <CardHeader>
            <CardTitle class="flex items-center gap-2">
              <Info class="w-5 h-5" />
              Informações do Sistema
            </CardTitle>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
              <div>
                <span class="text-muted-foreground">Cadastrado em:</span>
                <div class="font-medium">{{ formatarData(professor.created_at) }}</div>
              </div>
              <div>
                <span class="text-muted-foreground">Última atualização:</span>
                <div class="font-medium">{{ formatarData(professor.updated_at) }}</div>
              </div>
              <div>
                <span class="text-muted-foreground">Status do email:</span>
                <div class="font-medium">
                  <span v-if="professor.email_verified_at" class="text-green-600">
                    ✓ Verificado em {{ formatarData(professor.email_verified_at) }}
                  </span>
                  <span v-else class="text-amber-600">
                    ⚠ Não verificado
                  </span>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Ações -->
        <div class="flex justify-between items-center pt-6 border-t">
          <Button 
            variant="outline" 
            @click="$inertia.visit(route('professores.index'))"
          >
            <ArrowLeft class="w-4 h-4 mr-2" />
            Voltar à Lista
          </Button>
          
          <div class="flex gap-2">
            <Button 
              variant="destructive"
              @click="confirmarExclusao"
            >
              <Trash class="w-4 h-4 mr-2" />
              Excluir Professor
            </Button>
            <Button @click="$inertia.visit(route('professores.edit', professor.id))">
              <Edit class="w-4 h-4 mr-2" />
              Editar Professor
            </Button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <ConfirmDialog
      v-model:open="showConfirmDialog"
      type="danger"
      title="Excluir Professor"
      :message="`Tem certeza que deseja excluir o professor '${professor.name}'?`"
      :details="professor.turmas?.length > 0 
        ? `Este professor possui ${professor.turmas.length} turma(s) atribuída(s).` 
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
import { computed, ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import ConfirmDialog from '@/components/ConfirmDialog.vue'
import { 
  ArrowLeft, Edit, User, GraduationCap, ClipboardCheck, History, Info, Trash,
  BarChart
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
  estudantes_count?: number
  projetos_count?: number
}

interface Estudante {
  id: number
  name: string
}

interface Projeto {
  id: number
  titulo: string
  status: string
  data_submissao: string
  estudante?: Estudante
  turma?: Turma
}

interface Avaliacao {
  id: number
  nota_final: number
  status: string
  created_at: string
  projeto: {
    id: number
    titulo: string
    estudante: Estudante
    turma: Turma
  }
}

interface Professor {
  id: number
  name: string
  email: string
  telefone_encarregado?: string
  ativo: boolean
  curso?: Curso
  turmas?: Turma[]
  created_at: string
  updated_at: string
  email_verified_at?: string
}

interface Props {
  professor: Professor
  projetosPendentes: Projeto[]
  historicoAvaliacoes: Avaliacao[]
  estatisticas: {
    totalEstudantes: number
    avaliacoesRealizadas: number
  }
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Professores',
    href: '/professores'
  },
  {
    title: props.professor.name
  }
]

// Estado do modal de confirmação
const showConfirmDialog = ref(false)
const excluindoProfessor = ref(false)

// Computeds
const totalEstudantes = computed(() => props.estatisticas.totalEstudantes || 0)
const avaliacoesRealizadas = computed(() => props.estatisticas.avaliacoesRealizadas || 0)

// Helpers
const formatarData = (data: string) => {
  return new Date(data).toLocaleString('pt-BR', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatarDataRelativa = (data: string) => {
  const agora = new Date()
  const dataObj = new Date(data)
  const diffMs = agora.getTime() - dataObj.getTime()
  const diffDias = Math.floor(diffMs / (1000 * 60 * 60 * 24))
  
  if (diffDias === 0) return 'Hoje'
  if (diffDias === 1) return 'Ontem'
  if (diffDias < 7) return `${diffDias} dias atrás`
  if (diffDias < 30) return `${Math.floor(diffDias / 7)} semanas atrás`
  
  return formatarData(data).split(' ')[0] // Só a data
}

const getStatusBadgeClass = (status: string) => {
  const classes = {
    'Pendente': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'Em Avaliação': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    'Aprovado': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'Reprovado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
  }
  return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
}

// Methods
const confirmarExclusao = () => {
  showConfirmDialog.value = true
}

const executarExclusao = () => {
  excluindoProfessor.value = true
  router.delete(route('professores.destroy', props.professor.id), {
    onFinish: () => {
      excluindoProfessor.value = false
      showConfirmDialog.value = false
    }
  })
}

const cancelarExclusao = () => {
  showConfirmDialog.value = false
}
</script>