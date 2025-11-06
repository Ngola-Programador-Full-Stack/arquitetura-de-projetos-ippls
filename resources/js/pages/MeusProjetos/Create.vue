<template>
  <Head title="Iniciar Projeto" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Iniciar Projeto
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Configure e inicie sua instância deste projeto
          </p>
        </div>
        <Button variant="outline" @click="$inertia.visit(route('meus-projetos.templates'))">
          <ArrowLeft class="w-4 h-4 mr-2" />
          Voltar
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Detalhes do Projeto -->
        <Card>
          <CardHeader>
            <CardTitle class="flex items-center gap-3">
              <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                <FolderOpen class="w-6 h-6 text-primary" />
              </div>
              {{ projeto.titulo }}
            </CardTitle>
            <CardDescription>
              Criado por {{ projeto.criado_por?.name || 'Sistema' }}
            </CardDescription>
          </CardHeader>
          <CardContent class="space-y-4">
            <div>
              <h3 class="font-medium mb-2">Descrição do Projeto</h3>
              <p class="text-muted-foreground">{{ projeto.descricao }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="flex items-center gap-2">
                <Tag class="w-4 h-4 text-muted-foreground" />
                <div>
                  <p class="text-sm font-medium">Categoria</p>
                  <p class="text-sm text-muted-foreground">{{ projeto.categoria }}</p>
                </div>
              </div>
              
              <div class="flex items-center gap-2">
                <Clock class="w-4 h-4 text-muted-foreground" />
                <div>
                  <p class="text-sm font-medium">Duração Estimada</p>
                  <p class="text-sm text-muted-foreground">{{ projeto.duracao_estimada }} dias</p>
                </div>
              </div>

              <div class="flex items-center gap-2">
                <BarChart3 class="w-4 h-4 text-muted-foreground" />
                <div>
                  <p class="text-sm font-medium">Nível</p>
                  <span 
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="getNivelClass(projeto.nivel_dificuldade)"
                  >
                    {{ getNivelLabel(projeto.nivel_dificuldade) }}
                  </span>
                </div>
              </div>
            </div>

            <div v-if="projeto.tecnologias?.length">
              <h3 class="font-medium mb-2">Tecnologias</h3>
              <div class="flex flex-wrap gap-2">
                <span 
                  v-for="tech in projeto.tecnologias" 
                  :key="tech"
                  class="inline-flex items-center px-2 py-1 text-xs font-medium bg-secondary text-secondary-foreground rounded-md"
                >
                  {{ tech }}
                </span>
              </div>
            </div>

            <div v-if="projeto.requisitos">
              <h3 class="font-medium mb-2">Requisitos</h3>
              <p class="text-sm text-muted-foreground">{{ projeto.requisitos }}</p>
            </div>
          </CardContent>
        </Card>

        <!-- Formulário de Inscrição -->
        <Card>
          <CardHeader>
            <CardTitle>Configuração da Instância</CardTitle>
            <CardDescription>
              Escolha o nível de arquitetura e configure sua instância do projeto
            </CardDescription>
          </CardHeader>
          <CardContent>
            <form @submit.prevent="submit" class="space-y-6">
              
              <!-- Nível de Arquitetura -->
              <div>
                <label class="block text-sm font-medium mb-4">
                  Nível de Arquitetura *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <div 
                    v-for="nivel in niveisArquitetura" 
                    :key="nivel.value"
                    class="relative"
                  >
                    <input
                      :id="`nivel-${nivel.value}`"
                      v-model="form.nivel_arquitetura"
                      :value="nivel.value"
                      type="radio"
                      class="sr-only"
                      required
                    />
                    <label
                      :for="`nivel-${nivel.value}`"
                      class="flex flex-col p-4 border rounded-lg cursor-pointer transition-colors"
                      :class="form.nivel_arquitetura === nivel.value 
                        ? 'border-primary bg-primary/5' 
                        : 'border-input hover:border-primary/50'"
                    >
                      <div class="flex items-center gap-2 mb-2">
                        <div 
                          class="w-3 h-3 rounded-full border-2"
                          :class="form.nivel_arquitetura === nivel.value 
                            ? 'border-primary bg-primary' 
                            : 'border-input'"
                        />
                        <span class="font-medium">{{ nivel.label }}</span>
                      </div>
                      <p class="text-sm text-muted-foreground">{{ nivel.descricao }}</p>
                      <div class="mt-2">
                        <span 
                          class="inline-flex items-center px-2 py-1 text-xs rounded-full"
                          :class="nivel.badgeClass"
                        >
                          {{ nivel.badge }}
                        </span>
                      </div>
                    </label>
                  </div>
                </div>
                <div v-if="form.errors.nivel_arquitetura" class="text-destructive text-sm mt-1">
                  {{ form.errors.nivel_arquitetura }}
                </div>
              </div>

              <!-- URL do Repositório -->
              <div>
                <label for="repositorio_url" class="block text-sm font-medium mb-2">
                  URL do Repositório (Opcional)
                </label>
                <input
                  id="repositorio_url"
                  v-model="form.repositorio_url"
                  type="url"
                  placeholder="https://github.com/usuario/projeto"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.repositorio_url }"
                />
                <div v-if="form.errors.repositorio_url" class="text-destructive text-sm mt-1">
                  {{ form.errors.repositorio_url }}
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                  Se você já tem um repositório configurado, adicione a URL aqui
                </p>
              </div>

              <!-- Observações -->
              <div>
                <label for="observacoes" class="block text-sm font-medium mb-2">
                  Observações (Opcional)
                </label>
                <textarea
                  id="observacoes"
                  v-model="form.observacoes"
                  rows="4"
                  placeholder="Adicione qualquer comentário ou observação sobre o projeto..."
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring resize-none"
                  :class="{ 'border-destructive': form.errors.observacoes }"
                />
                <div v-if="form.errors.observacoes" class="text-destructive text-sm mt-1">
                  {{ form.errors.observacoes }}
                </div>
              </div>

              <!-- Botões -->
              <div class="flex justify-end gap-3 pt-6 border-t">
                <Button
                  type="button"
                  variant="outline"
                  @click="$inertia.visit(route('meus-projetos.templates'))"
                >
                  Cancelar
                </Button>
                <Button
                  type="submit"
                  :disabled="form.processing"
                >
                  <UserCheck class="w-4 h-4 mr-2" />
                  {{ form.processing ? 'Iniciando...' : 'Iniciar Projeto' }}
                </Button>
              </div>
            </form>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  ArrowLeft, FolderOpen, Tag, Clock, BarChart3, UserCheck
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
  projeto: Projeto
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Meus Projetos',
    href: '/meus-projetos'
  },
  {
    title: 'Templates',
    href: '/meus-projetos/templates'
  },
  {
    title: 'Iniciar Projeto',
    href: `/meus-projetos/criar/${props.projeto.id}`
  }
]

const form = useForm({
  nivel_arquitetura: '',
  repositorio_url: '',
  observacoes: ''
})

const niveisArquitetura = [
  {
    value: 'base',
    label: 'Base',
    descricao: 'Estrutura MVC básica com organização fundamental de diretórios',
    badge: 'Iniciante',
    badgeClass: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
  },
  {
    value: 'padrao',
    label: 'Padrão',
    descricao: 'Estrutura MVC intermediária com helpers e configurações avançadas',
    badge: 'Intermediário',
    badgeClass: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
  },
  {
    value: 'avancado',
    label: 'Avançado',
    descricao: 'Estrutura MVC completa com middleware, services e testes',
    badge: 'Avançado',
    badgeClass: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  }
]

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

const submit = () => {
  form.post(route('meus-projetos.store', props.projeto.id), {
    onFinish: () => form.reset(),
  })
}
</script>