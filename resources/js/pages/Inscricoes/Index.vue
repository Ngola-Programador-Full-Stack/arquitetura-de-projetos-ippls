<template>
  <Head title="Projetos Disponíveis" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Projetos Disponíveis
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Explore e inscreva-se nos projetos disponíveis
          </p>
        </div>
        <Button @click="$inertia.visit(route('inscricoes.meus-projetos'))">
          <BookOpen class="w-4 h-4 mr-2" />
          Meus Projetos
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
                  <p class="text-sm font-medium text-muted-foreground">Total Projetos</p>
                  <p class="text-2xl font-bold">{{ projetos?.length || 0 }}</p>
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
                  <p class="text-sm font-medium text-muted-foreground">Já Inscritos</p>
                  <p class="text-2xl font-bold">{{ projetosInscritos?.length || 0 }}</p>
                </div>
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                  <UserCheck class="w-4 h-4 text-green-600 dark:text-green-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Disponíveis</p>
                  <p class="text-2xl font-bold">{{ projetosDisponiveis }}</p>
                </div>
                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                  <Plus class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Categorias</p>
                  <p class="text-2xl font-bold">{{ categorias?.length || 0 }}</p>
                </div>
                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                  <Tag class="w-4 h-4 text-orange-600 dark:text-orange-400" />
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Lista de Projetos -->
        <div v-if="projetos?.length > 0" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <Card
            v-for="projeto in projetos"
            :key="projeto.id"
            class="hover:shadow-lg transition-shadow duration-200"
          >
            <CardHeader>
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <CardTitle class="text-lg">{{ projeto.titulo }}</CardTitle>
                  <CardDescription class="mt-1">
                    Por {{ projeto.criado_por?.name || 'Sistema' }}
                  </CardDescription>
                </div>
                <div class="ml-4">
                  <span 
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="getNivelClass(projeto.nivel_dificuldade)"
                  >
                    {{ getNivelLabel(projeto.nivel_dificuldade) }}
                  </span>
                </div>
              </div>
            </CardHeader>
            
            <CardContent class="space-y-4">
              <p class="text-sm text-muted-foreground line-clamp-2">
                {{ projeto.descricao }}
              </p>
              
              <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center gap-2">
                  <Tag class="w-3 h-3 text-muted-foreground" />
                  <span class="text-xs text-muted-foreground">{{ projeto.categoria }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <Clock class="w-3 h-3 text-muted-foreground" />
                  <span class="text-xs text-muted-foreground">{{ projeto.duracao_estimada }} dias</span>
                </div>
              </div>

              <div v-if="projeto.tecnologias?.length" class="space-y-2">
                <p class="text-xs font-medium text-muted-foreground">Tecnologias:</p>
                <div class="flex flex-wrap gap-1">
                  <span 
                    v-for="tech in projeto.tecnologias.slice(0, 3)" 
                    :key="tech"
                    class="inline-flex items-center px-1.5 py-0.5 text-xs bg-secondary text-secondary-foreground rounded"
                  >
                    {{ tech }}
                  </span>
                  <span 
                    v-if="projeto.tecnologias.length > 3"
                    class="inline-flex items-center px-1.5 py-0.5 text-xs bg-muted text-muted-foreground rounded"
                  >
                    +{{ projeto.tecnologias.length - 3 }}
                  </span>
                </div>
              </div>
              
              <div class="flex justify-between items-center pt-2 border-t">
                <div class="flex items-center gap-2">
                  <div 
                    v-if="isProjectInscrito(projeto.id)"
                    class="flex items-center gap-1 text-green-600"
                  >
                    <CheckCircle class="w-4 h-4" />
                    <span class="text-xs font-medium">Inscrito</span>
                  </div>
                  <div 
                    v-else
                    class="flex items-center gap-1 text-muted-foreground"
                  >
                    <Circle class="w-4 h-4" />
                    <span class="text-xs">Disponível</span>
                  </div>
                </div>
                
                <div class="flex gap-2">
                  <Button 
                    size="sm" 
                    variant="outline"
                    @click="$inertia.visit(route('projetos.show', projeto.id))"
                  >
                    <Eye class="w-3 h-3 mr-1" />
                    Detalhes
                  </Button>
                  
                  <Button 
                    v-if="!isProjectInscrito(projeto.id)"
                    size="sm"
                    @click="$inertia.visit(route('inscricoes.create', projeto.id))"
                  >
                    <UserPlus class="w-3 h-3 mr-1" />
                    Inscrever
                  </Button>
                  
                  <Button 
                    v-else
                    size="sm"
                    variant="secondary"
                    @click="$inertia.visit(route('inscricoes.show', projeto.id))"
                  >
                    <Settings class="w-3 h-3 mr-1" />
                    Gerenciar
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
            <h3 class="text-lg font-semibold mb-2">Nenhum projeto disponível</h3>
            <p class="text-muted-foreground">
              Não há projetos disponíveis para inscrição no momento.
            </p>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { computed, withDefaults } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  FolderOpen, BookOpen, UserCheck, Plus, Tag, Clock, Eye, UserPlus, 
  Settings, CheckCircle, Circle
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

interface Projeto {
  id: number
  titulo: string
  descricao: string
  categoria: string
  nivel_dificuldade: string
  duracao_estimada: number
  tecnologias: string[]
  requisitos: string
  criado_por?: {
    name: string
  }
}

interface Props {
  projetos: Projeto[]
  projetosInscritos: number[]
}

const props = withDefaults(defineProps<Props>(), {
  projetos: () => [],
  projetosInscritos: () => []
})

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Projetos Disponíveis',
    href: '/inscricoes/projetos'
  }
]

// Computeds
const projetosDisponiveis = computed(() => {
  const totalProjetos = props.projetos?.length || 0
  const projetosInscritos = props.projetosInscritos?.length || 0
  return totalProjetos - projetosInscritos
})

const categorias = computed(() => {
  if (!props.projetos || !Array.isArray(props.projetos)) return []
  return [...new Set(props.projetos.map(p => p.categoria).filter(Boolean))]
})

// Methods
const isProjectInscrito = (projetoId: number) => {
  if (!props.projetosInscritos || !Array.isArray(props.projetosInscritos)) return false
  return props.projetosInscritos.includes(projetoId)
}

const getNivelClass = (nivel: string) => {
  const classes = {
    'base': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'padrao': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'avancado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  }
  return classes[nivel as keyof typeof classes] || 'bg-gray-100 text-gray-800'
}

const getNivelLabel = (nivel: string) => {
  const labels = {
    'base': 'Iniciante',
    'padrao': 'Intermediário',
    'avancado': 'Avançado'
  }
  return labels[nivel as keyof typeof labels] || 'Indefinido'
}
</script>