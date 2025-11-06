<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { type BreadcrumbItem } from '@/types'
import { Download, Eye, FileText, Code, Layers } from 'lucide-vue-next'

interface Template {
  id: number
  nome: string
  nivel: string
  descricao: string
  instrucoes_uso?: string
}

interface Props {
  templates: Template[]
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Templates de Arquitetura',
    href: '/templates'
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
const downloadTemplate = (templateId: number) => {
  const url = `/templates/${templateId}/download`
  const link = document.createElement('a')
  link.href = url
  link.target = '_blank'
  link.click()
}

/* ✅ CORREÇÃO: Função para visualizar
const viewTemplate = (templateId: number) => {
  window.location.href = `/templates/${templateId}`
}*/
</script>

<template>
  <Head title="Templates de Arquitetura" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- Header -->
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Templates de Arquitetura
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Modelos padronizados para estruturação de projetos MVC
          </p>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Grid de Templates -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <Card
            v-for="template in templates"
            :key="template.id"
            class="hover:shadow-lg transition-shadow duration-200"
          >
            <CardHeader>
              <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                    <component :is="getNivelIcon(template.nivel)" class="w-5 h-5 text-primary" />
                  </div>
                  <div>
                    <CardTitle class="text-lg">{{ template.nome }}</CardTitle>
                  </div>
                </div>
                <span
                  :class="getNivelClass(template.nivel)"
                  class="px-3 py-1 rounded-full text-xs font-medium"
                >
                  {{ getNivelLabel(template.nivel) }}
                </span>
              </div>
              <CardDescription class="mt-2">{{ template.descricao }}</CardDescription>
            </CardHeader>
            <CardContent>
              <div class="space-y-4">
                <div
                  v-if="template.instrucoes_uso"
                  class="text-sm text-muted-foreground bg-muted/50 p-3 rounded-lg border"
                >
                  <div class="font-medium mb-1">Instruções de uso:</div>
                  <p>{{ template.instrucoes_uso }}</p>
                </div>

                <div class="flex gap-2">
                  <!-- ✅ CORREÇÃO: Botão Download -->
                  <Button
                    size="sm"
                    class="flex-1"
                    @click="downloadTemplate(template.id)"
                  >
                    <Download class="w-4 h-4 mr-2" />
                    Download
                  </Button>

                  <!-- ✅ CORREÇÃO: Botão Visualizar -->
                  <Button
                    size="sm"
                    variant="outline"
                    @click="$inertia.visit(`/templates/${template.id}`)"
                  >
                    <Eye class="w-4 h-4" />
                  </Button>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Card de Informações -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
          <Card class="border-green-200 dark:border-green-800">
            <CardHeader>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900 flex items-center justify-center">
                  <FileText class="w-5 h-5 text-green-600 dark:text-green-400" />
                </div>
                <CardTitle class="text-green-700 dark:text-green-400">Nível Base</CardTitle>
              </div>
            </CardHeader>
            <CardContent>
              <p class="text-sm text-muted-foreground">
                Ideal para iniciantes. Estrutura MVC básica com organização fundamental de diretórios, models, views e controllers.
              </p>
            </CardContent>
          </Card>

          <Card class="border-yellow-200 dark:border-yellow-800">
            <CardHeader>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                  <Code class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
                </div>
                <CardTitle class="text-yellow-700 dark:text-yellow-400">Nível Padrão</CardTitle>
              </div>
            </CardHeader>
            <CardContent>
              <p class="text-sm text-muted-foreground">
                Para projetos intermediários. Inclui helpers, configurações avançadas e melhor separação de camadas.
              </p>
            </CardContent>
          </Card>

          <Card class="border-red-200 dark:border-red-800">
            <CardHeader>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900 flex items-center justify-center">
                  <Layers class="w-5 h-5 text-red-600 dark:text-red-400" />
                </div>
                <CardTitle class="text-red-700 dark:text-red-400">Nível Avançado</CardTitle>
              </div>
            </CardHeader>
            <CardContent>
              <p class="text-sm text-muted-foreground">
                Estrutura robusta com middleware, services, testes automatizados e configuração para Docker.
              </p>
            </CardContent>
          </Card>
        </div>

        <!-- Card de Instruções Gerais -->
        <Card>
          <CardHeader>
            <CardTitle>Como utilizar os Templates</CardTitle>
            <CardDescription>
              Guia rápido para usar os templates de arquitetura em seus projetos
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-3">
                <div class="flex items-start gap-3">
                  <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold text-primary mt-0.5">
                    1
                  </div>
                  <div>
                    <div class="font-medium">Escolha o Template</div>
                    <div class="text-sm text-muted-foreground">Selecione o nível adequado ao seu projeto</div>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold text-primary mt-0.5">
                    2
                  </div>
                  <div>
                    <div class="font-medium">Baixe o Arquivo</div>
                    <div class="text-sm text-muted-foreground">Clique em Download para obter o template</div>
                  </div>
                </div>
              </div>
              <div class="space-y-3">
                <div class="flex items-start gap-3">
                  <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold text-primary mt-0.5">
                    3
                  </div>
                  <div>
                    <div class="font-medium">Extraia os Arquivos</div>
                    <div class="text-sm text-muted-foreground">Descompacte no diretório do seu projeto</div>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold text-primary mt-0.5">
                    4
                  </div>
                  <div>
                    <div class="font-medium">Personalize</div>
                    <div class="text-sm text-muted-foreground">Adapte conforme suas necessidades</div>
                  </div>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>
