<template>
  <Head title="Criar Projeto" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Criar Novo Projeto
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Adicione um novo projeto template ao sistema
          </p>
        </div>
        <Button variant="outline" @click="$inertia.visit(route('projetos.index'))">
          <ArrowLeft class="w-4 h-4 mr-2" />
          Voltar
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <Card>
          <CardHeader>
            <CardTitle>Informações do Projeto</CardTitle>
            <CardDescription>
              Preencha os dados necessários para criar um novo projeto template
            </CardDescription>
          </CardHeader>
          <CardContent>
            <form @submit.prevent="submit" class="space-y-8">
              <!-- Título -->
              <div>
                <label for="titulo" class="block text-sm font-medium mb-2">
                  Título do Projeto *
                </label>
                <input
                  id="titulo"
                  v-model="form.titulo"
                  type="text"
                  required
                  maxlength="255"
                  placeholder="Ex: Sistema de Gestão de Biblioteca"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.titulo }"
                />
                <div v-if="form.errors.titulo" class="text-destructive text-sm mt-1">
                  {{ form.errors.titulo }}
                </div>
              </div>

              <!-- Descrição -->
              <div>
                <label for="descricao" class="block text-sm font-medium mb-2">
                  Descrição do Projeto *
                </label>
                <textarea
                  id="descricao"
                  v-model="form.descricao"
                  required
                  rows="4"
                  placeholder="Descreva o objetivo, escopo e funcionalidades principais do projeto..."
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring resize-none"
                  :class="{ 'border-destructive': form.errors.descricao }"
                />
                <div v-if="form.errors.descricao" class="text-destructive text-sm mt-1">
                  {{ form.errors.descricao }}
                </div>
              </div>

              <!-- Categoria e Nível -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="categoria" class="block text-sm font-medium mb-2">
                    Categoria *
                  </label>
                  <input
                    id="categoria"
                    v-model="form.categoria"
                    type="text"
                    required
                    maxlength="50"
                    placeholder="Ex: Web, Mobile, Desktop, IA, Blockchain..."
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    :class="{ 'border-destructive': form.errors.categoria }"
                  />
                  <div v-if="form.errors.categoria" class="text-destructive text-sm mt-1">
                    {{ form.errors.categoria }}
                  </div>
                </div>

                <div>
                  <label for="nivel_dificuldade" class="block text-sm font-medium mb-2">
                    Nível de Dificuldade *
                  </label>
                  <select
                    id="nivel_dificuldade"
                    v-model="form.nivel_dificuldade"
                    required
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    :class="{ 'border-destructive': form.errors.nivel_dificuldade }"
                  >
                    <option value="">Selecione o nível</option>
                    <option value="base">Iniciante</option>
                    <option value="padrao">Intermediário</option>
                    <option value="avancado">Avançado</option>
                  </select>
                  <div v-if="form.errors.nivel_dificuldade" class="text-destructive text-sm mt-1">
                    {{ form.errors.nivel_dificuldade }}
                  </div>
                </div>
              </div>

              <!-- Duração Estimada -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="duracao_estimada" class="block text-sm font-medium mb-2">
                    Duração Estimada (horas)
                  </label>
                  <div class="relative">
                    <input
                      id="duracao_estimada"
                      v-model.number="form.duracao_estimada"
                      type="number"
                      min="1"
                      step="1"
                      placeholder="Ex: 40"
                      class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                      :class="{ 'border-destructive': form.errors.duracao_estimada }"
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <Clock class="h-4 w-4 text-muted-foreground" />
                    </div>
                  </div>
                  <div v-if="form.errors.duracao_estimada" class="text-destructive text-sm mt-1">
                    {{ form.errors.duracao_estimada }}
                  </div>
                  <p class="text-xs text-muted-foreground mt-1">
                    Tempo estimado para conclusão do projeto
                  </p>
                </div>
                
                <!-- Placeholder para futuro campo -->
                <div></div>
              </div>

              <!-- Tecnologias -->
              <div>
                <label for="tecnologias_input" class="block text-sm font-medium mb-2">
                  Tecnologias
                </label>
                <div class="space-y-3">
                  <div class="relative">
                    <input
                      id="tecnologias_input"
                      v-model="novaTecnologia"
                      type="text"
                      @keydown.enter.prevent="adicionarTecnologia"
                      placeholder="Digite uma tecnologia e pressione Enter"
                      class="w-full border border-input rounded-md px-3 py-2 pr-10 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                      <Button 
                        type="button"
                        size="sm"
                        variant="ghost"
                        @click="adicionarTecnologia"
                        :disabled="!novaTecnologia.trim()"
                        class="h-6 w-6 p-0"
                      >
                        <Plus class="h-3 w-3" />
                      </Button>
                    </div>
                  </div>
                  
                  <div v-if="form.tecnologias.length > 0" class="flex flex-wrap gap-2">
                    <span
                      v-for="(tecnologia, index) in form.tecnologias"
                      :key="index"
                      class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-sm rounded-full"
                    >
                      {{ tecnologia }}
                      <Button
                        type="button"
                        variant="ghost"
                        size="sm"
                        @click="removerTecnologia(index)"
                        class="h-4 w-4 p-0 hover:bg-blue-200 dark:hover:bg-blue-800 rounded-full"
                      >
                        <X class="h-3 w-3" />
                      </Button>
                    </span>
                  </div>
                  
                  <p class="text-xs text-muted-foreground">
                    Adicione as principais tecnologias que serão usadas neste projeto
                  </p>
                </div>
              </div>

              <!-- Requisitos -->
              <div>
                <label for="requisitos" class="block text-sm font-medium mb-2">
                  Pré-requisitos
                </label>
                <textarea
                  id="requisitos"
                  v-model="form.requisitos"
                  rows="3"
                  placeholder="Descreva os conhecimentos prévios, ferramentas ou tecnologias necessárias..."
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring resize-none"
                />
                <p class="text-xs text-muted-foreground mt-1">
                  Liste os conhecimentos ou ferramentas que os estudantes devem ter para realizar este projeto
                </p>
              </div>

              <!-- Upload de Imagem -->
              <div>
                <label class="block text-sm font-medium mb-2">
                  Imagem do Projeto
                </label>
                <Card class="border-2 border-dashed border-muted-foreground/25 hover:border-muted-foreground/50 transition-colors">
                  <CardContent class="p-6">
                    <div v-if="previewImagem" class="text-center space-y-4">
                      <div class="relative inline-block">
                        <img 
                          :src="previewImagem" 
                          alt="Preview" 
                          class="mx-auto h-32 w-48 object-cover rounded-lg border"
                        />
                        <Button
                          type="button"
                          variant="destructive"
                          size="sm"
                          @click="removerImagem"
                          class="absolute -top-2 -right-2 rounded-full h-8 w-8 p-0"
                        >
                          <X class="h-4 w-4" />
                        </Button>
                      </div>
                      <div class="space-y-2">
                        <p class="text-sm font-medium">Imagem carregada</p>
                        <Button variant="outline" size="sm" @click="() => inputImagem?.click()">
                          <Upload class="w-4 h-4 mr-2" />
                          Trocar imagem
                        </Button>
                      </div>
                    </div>
                    
                    <div v-else class="text-center space-y-4">
                      <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center">
                        <Image class="w-8 h-8 text-muted-foreground" />
                      </div>
                      <div class="space-y-2">
                        <p class="text-sm font-medium">Adicionar imagem do projeto</p>
                        <p class="text-xs text-muted-foreground">PNG, JPG, GIF até 2MB</p>
                      </div>
                      <Button 
                        type="button"
                        variant="outline"
                        @click="() => inputImagem?.click()"
                      >
                        <Upload class="w-4 h-4 mr-2" />
                        Selecionar arquivo
                      </Button>
                    </div>
                    
                    <input
                      ref="inputImagem"
                      type="file"
                      accept="image/*"
                      class="sr-only"
                      @change="selecionarImagem"
                    />
                  </CardContent>
                </Card>
                <div v-if="form.errors.imagem" class="text-destructive text-sm mt-2">
                  {{ form.errors.imagem }}
                </div>
                <p class="text-xs text-muted-foreground mt-2">
                  Uma imagem representativa ajuda os estudantes a identificar o projeto
                </p>
              </div>

              <!-- Botões -->
              <div class="flex justify-end gap-3 pt-8 border-t">
                <Button
                  type="button"
                  variant="outline"
                  @click="$inertia.visit(route('projetos.index'))"
                >
                  <X class="w-4 h-4 mr-2" />
                  Cancelar
                </Button>
                <Button
                  type="submit"
                  :disabled="form.processing"
                >
                  <Loader2 v-if="form.processing" class="w-4 h-4 mr-2 animate-spin" />
                  <Plus v-else class="w-4 h-4 mr-2" />
                  {{ form.processing ? 'Criando...' : 'Criar Projeto' }}
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
import { type BreadcrumbItem } from '@/types'
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  ArrowLeft, Plus, Clock, X, Upload, Image, Loader2
} from 'lucide-vue-next'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Projetos',
    href: '/projetos'
  },
  {
    title: 'Criar Projeto',
    href: '/projetos/create'
  }
]

const form = useForm({
  titulo: '',
  descricao: '',
  categoria: '',
  nivel_dificuldade: '',
  tecnologias: [] as string[],
  requisitos: '',
  duracao_estimada: null as number | null,
  imagem: null as File | null
})

const novaTecnologia = ref('')
const previewImagem = ref<string | null>(null)
const inputImagem = ref<HTMLInputElement>()

const submit = () => {
  form.post(route('projetos.store'), {
    forceFormData: true
  })
}

const adicionarTecnologia = () => {
  const tecnologia = novaTecnologia.value.trim()
  if (tecnologia && !form.tecnologias.includes(tecnologia)) {
    form.tecnologias.push(tecnologia)
    novaTecnologia.value = ''
  }
}

const removerTecnologia = (index: number) => {
  form.tecnologias.splice(index, 1)
}

const selecionarImagem = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]

  if (file) {
    form.imagem = file

    const reader = new FileReader()
    reader.onload = (e) => {
      previewImagem.value = e.target?.result as string
    }
    reader.readAsDataURL(file)
  }
}

const removerImagem = () => {
  form.imagem = null
  previewImagem.value = null
  if (inputImagem.value) {
    inputImagem.value.value = ''
  }
}
</script>
