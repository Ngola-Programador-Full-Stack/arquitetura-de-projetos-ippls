<template>
  <Head :title="projeto.titulo" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ projeto.titulo }}
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            {{ projeto.categoria }} • {{ projeto.nivel_dificuldade.charAt(0).toUpperCase() + projeto.nivel_dificuldade.slice(1) }}
          </p>
        </div>
        <div class="flex gap-2">
          <!-- Botões específicos por tipo de usuário -->
          <Button
            v-if="$page.props.auth.user?.tipo === 'coordenador' && projeto.criador.id === $page.props.auth.user.id"
            variant="outline"
            @click="$inertia.visit(route('projetos.edit', projeto.id))"
          >
            <Edit class="w-4 h-4 mr-2" />
            Editar
          </Button>
          
          <Button variant="outline" @click="$inertia.visit(route('projetos.index'))">
            <ArrowLeft class="w-4 h-4 mr-2" />
            Voltar
          </Button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Imagem e Info Principal -->
        <Card class="overflow-hidden">
          <CardContent class="p-0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
              <!-- Imagem -->
              <div class="aspect-video bg-muted">
                <img
                  :src="projeto.imagem_url || '/images/projeto-default.png'"
                  :alt="projeto.titulo"
                  class="w-full h-full object-cover"
                  @error="$event.target.src = '/images/projeto-default.png'"
                />
              </div>

              <!-- Informações básicas -->
              <div class="p-6 space-y-6">
                <div>
                  <h1 class="text-2xl font-bold mb-3">
                    {{ projeto.titulo }}
                  </h1>
                  <div class="flex items-center gap-3">
                    <span
                      class="px-3 py-1 text-sm font-medium rounded-full"
                      :class="getNivelClass(projeto.nivel_dificuldade)"
                    >
                      {{ projeto.nivel_dificuldade.charAt(0).toUpperCase() + projeto.nivel_dificuldade.slice(1) }}
                    </span>
                    <span class="px-3 py-1 bg-secondary text-secondary-foreground text-sm rounded-full">
                      {{ projeto.categoria }}
                    </span>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                      <Clock class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                      <p class="text-sm text-muted-foreground">Duração</p>
                      <p class="font-semibold">{{ projeto.duracao_estimada }}h</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                      <User class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div>
                      <p class="text-sm text-muted-foreground">Criado por</p>
                      <p class="font-semibold">{{ projeto.criador.name }}</p>
                    </div>
                  </div>
                </div>

                <!-- Tecnologias -->
                <div>
                  <p class="text-sm font-medium text-muted-foreground mb-3">Tecnologias</p>
                  <div class="flex flex-wrap gap-2">
                    <span
                      v-for="tecnologia in projeto.tecnologias"
                      :key="tecnologia"
                      class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs rounded-full"
                    >
                      {{ tecnologia }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Descrição -->
        <Card>
          <CardHeader>
            <CardTitle class="flex items-center gap-2">
              <FileText class="w-5 h-5" />
              Descrição do Projeto
            </CardTitle>
            <CardDescription>
              Objetivo e escopo detalhado do projeto
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div class="prose max-w-none dark:prose-invert">
              <p class="text-muted-foreground leading-relaxed">
                {{ projeto.descricao }}
              </p>
            </div>
          </CardContent>
        </Card>

        <!-- Requisitos -->
        <Card v-if="projeto.requisitos">
          <CardHeader>
            <CardTitle class="flex items-center gap-2">
              <CheckSquare class="w-5 h-5" />
              Requisitos
            </CardTitle>
            <CardDescription>
              Pré-requisitos necessários para este projeto
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div class="prose max-w-none dark:prose-invert">
              <p class="text-muted-foreground leading-relaxed">
                {{ projeto.requisitos }}
              </p>
            </div>
          </CardContent>
        </Card>

        <!-- Status do meu projeto -->
        <Card v-if="$page.props.auth.user?.tipo === 'estudante'">
          <CardHeader>
            <CardTitle class="flex items-center gap-2">
              <BarChart3 class="w-5 h-5" />
              Meu Progresso
            </CardTitle>
            <CardDescription>
              Status da sua instância deste projeto
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div v-if="meuProjeto" class="space-y-6">
              <div class="flex items-center justify-between p-4 border rounded-lg">
                <div class="space-y-1">
                  <div class="flex items-center gap-2">
                    <span class="text-sm font-medium">Status:</span>
                    <span
                      class="px-2 py-1 text-xs rounded-full font-medium"
                      :class="getStatusClass(meuProjeto.status)"
                    >
                      {{ getStatusText(meuProjeto.status) }}
                    </span>
                  </div>
                  <p class="text-sm text-muted-foreground">
                    Iniciado em {{ formatarData(meuProjeto.created_at) }}
                  </p>
                </div>
                <Button @click="$inertia.visit(route('meus-projetos.show', meuProjeto.id))">
                  <Play class="w-4 h-4 mr-2" />
                  Continuar Projeto
                </Button>
              </div>

              <div v-if="meuProjeto.avaliacao_atual" class="p-4 bg-muted rounded-lg">
                <p class="text-sm font-medium mb-2">Última Avaliação</p>
                <p class="text-2xl font-bold">
                  {{ meuProjeto.avaliacao_atual.nota }}<span class="text-lg text-muted-foreground">/10</span>
                </p>
              </div>
            </div>

            <div v-else class="text-center py-12">
              <!-- Exibir mensagem de erro se houver -->
              <div v-if="$page.props.errors.projeto" class="mb-6 p-4 bg-destructive/10 border border-destructive/20 text-destructive rounded-lg">
                <div class="flex items-center gap-2">
                  <AlertCircle class="w-4 h-4" />
                  {{ $page.props.errors.projeto }}
                </div>
              </div>

              <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center mb-4">
                <Rocket class="w-8 h-8 text-muted-foreground" />
              </div>
              <h3 class="text-lg font-semibold mb-2">Projeto não iniciado</h3>
              <p class="text-muted-foreground mb-6">
                Você ainda não criou uma instância deste projeto
              </p>

              <Button @click="mostrarModalIniciar = true" size="lg">
                <Play class="w-4 h-4 mr-2" />
                Iniciar Projeto
              </Button>
            </div>
          </CardContent>
        </Card>

        <!-- Modal de iniciar projeto -->
        <div v-if="mostrarModalIniciar" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
          <Card class="w-full max-w-md">
            <CardHeader>
              <CardTitle>Escolha o nível de arquitetura</CardTitle>
              <CardDescription>
                Selecione a complexidade da estrutura do projeto
              </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="space-y-3">
                <label
                  v-for="nivel in ['base', 'padrao', 'avancado']"
                  :key="nivel"
                  class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-muted/50 transition-colors"
                  :class="nivelSelecionado === nivel ? 'border-primary bg-primary/5' : 'border-border'"
                >
                  <input
                    v-model="nivelSelecionado"
                    type="radio"
                    :value="nivel"
                    class="sr-only"
                  />
                  <div class="flex-1">
                    <div class="font-medium">
                      {{ nivel.charAt(0).toUpperCase() + nivel.slice(1) }}
                    </div>
                    <div class="text-sm text-muted-foreground mt-1">
                      {{ getDescricaoNivel(nivel) }}
                    </div>
                  </div>
                  <div v-if="nivelSelecionado === nivel" class="text-primary">
                    <CheckCircle class="w-5 h-5" />
                  </div>
                </label>
              </div>

              <div class="flex gap-3 pt-4">
                <Button
                  variant="outline"
                  @click="cancelarInicio"
                  class="flex-1"
                >
                  Cancelar
                </Button>
                <Button
                  @click="iniciarProjeto"
                  :disabled="!nivelSelecionado || processandoInicio"
                  class="flex-1"
                >
                  <Loader2 v-if="processandoInicio" class="w-4 h-4 mr-2 animate-spin" />
                  <Play v-else class="w-4 h-4 mr-2" />
                  {{ processandoInicio ? 'Iniciando...' : 'Iniciar Projeto' }}
                </Button>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Templates de Arquitetura -->
        <Card v-if="templates.length > 0">
          <CardHeader>
            <CardTitle class="flex items-center gap-2">
              <Layers class="w-5 h-5" />
              Templates de Arquitetura
            </CardTitle>
            <CardDescription>
              Estruturas disponíveis para diferentes níveis de complexidade
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <Card
                v-for="template in templates"
                :key="template.id"
                class="hover:shadow-md transition-shadow"
              >
                <CardContent class="p-4">
                  <h4 class="font-semibold mb-2">{{ template.nome }}</h4>
                  <p class="text-sm text-muted-foreground mb-3 line-clamp-2">
                    {{ template.descricao }}
                  </p>
                  <span
                    class="inline-flex items-center px-2 py-1 text-xs rounded-full font-medium"
                    :class="getNivelClass(template.nivel)"
                  >
                    {{ template.nivel.charAt(0).toUpperCase() + template.nivel.slice(1) }}
                  </span>
                </CardContent>
              </Card>
            </div>
          </CardContent>
        </Card>
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
import { type BreadcrumbItem } from '@/types'
import { 
  Clock, User, FileText, CheckSquare, BarChart3, Play, ArrowLeft, Edit,
  AlertCircle, Rocket, CheckCircle, Loader2, Layers
} from 'lucide-vue-next'

interface Criador {
  id: number
  name: string
}

interface InstanciaProjeto {
  id: number
  status: string
  created_at: string
  avaliacao_atual?: {
    nota: number
  }
}

interface Template {
  id: number
  nome: string
  descricao: string
  nivel: string
}

interface Projeto {
  id: number
  titulo: string
  descricao: string
  imagem_url?: string
  categoria: string
  nivel_dificuldade: 'base' | 'padrao' | 'avancado'
  tecnologias: string[]
  requisitos?: string
  duracao_estimada: number
  criador: Criador
}

interface Props {
  projeto: Projeto
  meuProjeto: InstanciaProjeto | null
  templates: Template[]
}

const props = defineProps<Props>()

// Breadcrumbs definidos após props
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Projetos',
    href: '/projetos'
  },
  {
    title: props.projeto.titulo,
    href: `/projetos/${props.projeto.id}`
  }
]

const mostrarModalIniciar = ref(false)
const nivelSelecionado = ref('')
const processandoInicio = ref(false)

// FUNÇÃO CORRIGIDA - agora usa a rota correta
const iniciarProjeto = async () => {
  if (!nivelSelecionado.value) return

  processandoInicio.value = true

  try {
    await router.post(route('projetos.iniciar', { projeto: props.projeto.id }), {
      nivel_arquitetura: nivelSelecionado.value
    });
  } catch (error) {
    console.error('Erro ao iniciar projeto:', error)
  } finally {
    processandoInicio.value = false
    mostrarModalIniciar.value = false
  }
}

const cancelarInicio = () => {
  mostrarModalIniciar.value = false
  nivelSelecionado.value = ''
}

const getNivelClass = (nivel: string) => {
  switch (nivel) {
    case 'base':
      return 'bg-green-100 text-green-800'
    case 'padrao':
      return 'bg-yellow-100 text-yellow-800'
    case 'avancado':
      return 'bg-red-100 text-red-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getStatusClass = (status: string) => {
  switch (status) {
    case 'iniciado':
      return 'bg-blue-100 text-blue-800'
    case 'em_desenvolvimento':
      return 'bg-yellow-100 text-yellow-800'
    case 'concluido':
      return 'bg-green-100 text-green-800'
    case 'pausado':
      return 'bg-gray-100 text-gray-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getStatusText = (status: string) => {
  const statusMap: Record<string, string> = {
    'iniciado': 'Iniciado',
    'em_desenvolvimento': 'Em Desenvolvimento',
    'concluido': 'Concluído',
    'pausado': 'Pausado'
  }
  return statusMap[status] || status
}

const getDescricaoNivel = (nivel: string) => {
  const descricoes: Record<string, string> = {
    'base': 'Estrutura simples e direta',
    'padrao': 'Arquitetura balanceada',
    'avancado': 'Estrutura complexa e robusta'
  }
  return descricoes[nivel] || ''
}

const formatarData = (data: string) => {
  return new Date(data).toLocaleDateString('pt-BR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
