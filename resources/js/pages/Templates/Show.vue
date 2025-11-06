<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { type BreadcrumbItem } from '@/types'
import { Download, ArrowLeft, FileText, Code, Layers, File } from 'lucide-vue-next'
import { computed } from 'vue'

interface EstruturaDiretorio {
  nome: string
  tipo: 'pasta' | 'arquivo'
  nivel?: number
  icone?: string
  filhos?: EstruturaDiretorio[]
}

interface Template {
  id: number
  nome: string
  nivel: string
  descricao: string
  instrucoes_uso?: string
  dependencias?: string[]
  arquivos_base?: any[]
  nivel_badge?: {
    label: string
    color: string
  }
}

interface Props {
  template: Template
  estruturaVisual?: EstruturaDiretorio[]
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Templates de Arquitetura',
    href: '/templates'
  },
  {
    title: props.template.nome,
    href: `/templates/${props.template.id}`
  }
]

const getNivelClass = (nivel: string) => {
  const classes = {
    'base': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
    'padrao': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
    'avancado': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
  }
  return classes[nivel as keyof typeof classes] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200'
}

const getNivelLabel = (nivel: string) => {
  const labels: Record<string, string> = {
    'base': 'Base',
    'padrao': 'Padrão',
    'avancado': 'Avançado'
  }
  return labels[nivel] || 'Desconhecido'
}

const getNivelIcon = (nivel: string) => {
  const icons = {
    'base': FileText,
    'padrao': Code,
    'avancado': Layers
  }
  return icons[nivel as keyof typeof icons] || FileText
}

// ✅ CORREÇÃO: Função para download
const downloadTemplate = () => {
  const url = `/templates/${props.template.id}/download`
  const link = document.createElement('a')
  link.href = url
  link.target = '_blank'
  link.download = `template_${props.template.nome}_${props.template.nivel}.zip`
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}

// ✅ Função recursiva para renderizar estrutura
const renderEstrutura = (itens: EstruturaDiretorio[], nivel: number = 0): string => {
  if (!itens || !Array.isArray(itens)) return ''

  let resultado = ''

  itens.forEach((item, index) => {
    const isLast = index === itens.length - 1
    const prefix = '  '.repeat(nivel)
    const connector = isLast ? '└──' : '├──'
    const icon = item.tipo === 'pasta' ? '📁' : '📄'

    resultado += `${prefix}${connector} ${icon} ${item.nome}\n`

    if (item.filhos && item.filhos.length > 0) {
      resultado += renderEstrutura(item.filhos, nivel + 1)
    }
  })

  return resultado
}

// ✅ Estrutura formatada para exibição
const estruturaFormatada = computed(() => {
  if (!props.estruturaVisual || props.estruturaVisual.length === 0) {
    return `📁 projeto/
├── 📁 app/
│   ├── 📁 Controllers/
│   ├── 📁 Models/
│   └── 📁 Views/
├── 📁 public/
│   ├── 📁 css/
│   ├── 📁 js/
│   └── 📁 images/
├── 📁 config/
└── 📄 README.md`
  }

  return `📁 projeto/\n${renderEstrutura(props.estruturaVisual)}`
})
</script>

<template>
  <Head :title="`${template.nome} - Template de Arquitetura`" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- Header -->
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
              <component :is="getNivelIcon(template.nivel)" class="w-6 h-6 text-primary" />
            </div>
            <div>
              <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ template.nome }}
              </h2>
              <span
                :class="getNivelClass(template.nivel)"
                class="inline-flex px-3 py-1 rounded-full text-xs font-medium mt-1"
              >
                {{ getNivelLabel(template.nivel) }}
              </span>
            </div>
          </div>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            {{ template.descricao }}
          </p>
        </div>
        <div class="flex items-center gap-3">
          <Button variant="outline" @click="$inertia.visit('/templates')">
            <ArrowLeft class="w-4 h-4 mr-2" />
            Voltar
          </Button>
          <Button @click="downloadTemplate">
            <Download class="w-4 h-4 mr-2" />
            Download
          </Button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Informações principais -->
          <div class="lg:col-span-2 space-y-6">

            <!-- Descrição detalhada -->
            <Card>
              <CardHeader>
                <CardTitle>Descrição</CardTitle>
              </CardHeader>
              <CardContent>
                <p class="text-muted-foreground leading-relaxed">
                  {{ template.descricao }}
                </p>
              </CardContent>
            </Card>

            <!-- Instruções de uso -->
            <Card v-if="template.instrucoes_uso">
              <CardHeader>
                <CardTitle>Instruções de Uso</CardTitle>
              </CardHeader>
              <CardContent>
                <div class="prose prose-sm max-w-none text-muted-foreground">
                  <p class="whitespace-pre-wrap">{{ template.instrucoes_uso }}</p>
                </div>
              </CardContent>
            </Card>

            <!-- Estrutura de diretórios -->
            <Card>
              <CardHeader>
                <CardTitle>Estrutura de Diretórios</CardTitle>
                <CardDescription>
                  Organização dos arquivos e pastas incluídos no template
                </CardDescription>
              </CardHeader>
              <CardContent>
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg font-mono text-sm overflow-x-auto">
                  <pre class="text-muted-foreground whitespace-pre">{{ estruturaFormatada }}</pre>
                </div>
              </CardContent>
            </Card>

            <!-- Arquivos incluídos -->
            <Card v-if="template.arquivos_base && template.arquivos_base.length > 0">
              <CardHeader>
                <CardTitle>Arquivos Incluídos</CardTitle>
                <CardDescription>
                  Lista de arquivos pré-configurados no template
                </CardDescription>
              </CardHeader>
              <CardContent>
                <div class="space-y-2">
                  <div
                    v-for="(arquivo, index) in template.arquivos_base"
                    :key="index"
                    class="flex items-center gap-2 text-sm p-2 rounded hover:bg-muted/50"
                  >
                    <File class="w-4 h-4 text-muted-foreground" />
                    <span class="font-mono">{{ arquivo.caminho }}</span>
                  </div>
                </div>
              </CardContent>
            </Card>
          </div>

          <!-- Sidebar -->
          <div class="space-y-6">
            <!-- Informações do template -->
            <Card>
              <CardHeader>
                <CardTitle>Informações do Template</CardTitle>
              </CardHeader>
              <CardContent class="space-y-4">
                <div>
                  <div class="text-sm font-medium text-muted-foreground">Nível de Complexidade</div>
                  <div class="mt-1">
                    <span
                      :class="getNivelClass(template.nivel)"
                      class="inline-flex px-3 py-1 rounded-full text-xs font-medium"
                    >
                      {{ getNivelLabel(template.nivel) }}
                    </span>
                  </div>
                </div>

                <!-- Dependências -->
                <div v-if="template.dependencias && template.dependencias.length > 0">
                  <div class="text-sm font-medium text-muted-foreground mb-2">Dependências</div>
                  <div class="space-y-1">
                    <div
                      v-for="(dep, index) in template.dependencias"
                      :key="index"
                      class="text-xs bg-muted/50 px-2 py-1 rounded"
                    >
                      {{ dep }}
                    </div>
                  </div>
                </div>

                <div class="pt-4">
                  <Button
                    class="w-full"
                    @click="downloadTemplate"
                  >
                    <Download class="w-4 h-4 mr-2" />
                    Baixar Template
                  </Button>
                </div>
              </CardContent>
            </Card>

            <!-- Níveis de template -->
            <Card>
              <CardHeader>
                <CardTitle>Sobre os Níveis</CardTitle>
              </CardHeader>
              <CardContent class="space-y-4">
                <div class="space-y-3">
                  <div>
                    <div class="flex items-center gap-2 mb-1">
                      <FileText class="w-4 h-4 text-green-600" />
                      <span class="text-sm font-medium text-green-700 dark:text-green-400">Base</span>
                    </div>
                    <p class="text-xs text-muted-foreground">
                      Estrutura MVC básica para iniciantes
                    </p>
                  </div>

                  <div>
                    <div class="flex items-center gap-2 mb-1">
                      <Code class="w-4 h-4 text-yellow-600" />
                      <span class="text-sm font-medium text-yellow-700 dark:text-yellow-400">Padrão</span>
                    </div>
                    <p class="text-xs text-muted-foreground">
                      Configurações avançadas e helpers
                    </p>
                  </div>

                  <div>
                    <div class="flex items-center gap-2 mb-1">
                      <Layers class="w-4 h-4 text-red-600" />
                      <span class="text-sm font-medium text-red-700 dark:text-red-400">Avançado</span>
                    </div>
                    <p class="text-xs text-muted-foreground">
                      Middleware, services e Docker
                    </p>
                  </div>
                </div>
              </CardContent>
            </Card>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
