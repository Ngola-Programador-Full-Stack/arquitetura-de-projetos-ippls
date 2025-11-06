<template>
  <Head title="Criar Estudante" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Criar Novo Estudante
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Adicione um novo estudante ao sistema
          </p>
        </div>
        <Button variant="outline" @click="$inertia.visit(route('estudante.index'))">
          <ArrowLeft class="w-4 h-4 mr-2" />
          Voltar
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <Card>
          <CardHeader>
            <CardTitle>Informações do Estudante</CardTitle>
            <CardDescription>
              Preencha os dados necessários para criar uma conta de estudante
            </CardDescription>
          </CardHeader>
          <CardContent>
            <form @submit.prevent="submit" class="space-y-6">
              
              <!-- Nome Completo -->
              <div>
                <label for="name" class="block text-sm font-medium mb-2">
                  Nome Completo *
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  required
                  maxlength="255"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.name }"
                  placeholder="Digite o nome completo do estudante"
                />
                <div v-if="form.errors.name" class="text-destructive text-sm mt-1">
                  {{ form.errors.name }}
                </div>
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium mb-2">
                  Endereço de Email *
                </label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  maxlength="255"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.email }"
                  placeholder="estudante@exemplo.com"
                />
                <div v-if="form.errors.email" class="text-destructive text-sm mt-1">
                  {{ form.errors.email }}
                </div>
              </div>

              <!-- Telefone do Encarregado -->
              <div>
                <label for="telefone_encarregado" class="block text-sm font-medium mb-2">
                  Telefone do Encarregado *
                </label>
                <input
                  id="telefone_encarregado"
                  v-model="form.telefone_encarregado"
                  type="text"
                  required
                  maxlength="15"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.telefone_encarregado }"
                  placeholder="+244 999 999 999"
                />
                <div v-if="form.errors.telefone_encarregado" class="text-destructive text-sm mt-1">
                  {{ form.errors.telefone_encarregado }}
                </div>
              </div>

              <!-- Número do Estudante -->
              <div>
                <label for="numero_estudante" class="block text-sm font-medium mb-2">
                  Número do Estudante (Opcional)
                </label>
                <input
                  id="numero_estudante"
                  v-model="form.numero_estudante"
                  type="text"
                  maxlength="20"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.numero_estudante }"
                  placeholder="Ex: 2024001"
                />
                <div v-if="form.errors.numero_estudante" class="text-destructive text-sm mt-1">
                  {{ form.errors.numero_estudante }}
                </div>
                <p class="text-xs text-muted-foreground mt-1">
                  Se não preenchido, será gerado automaticamente
                </p>
              </div>

              <!-- Curso -->
              <div>
                <label for="curso_id" class="block text-sm font-medium mb-2">
                  Curso *
                </label>
                <select
                  id="curso_id"
                  v-model="form.curso_id"
                  required
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.curso_id }"
                  @change="onCursoChange"
                >
                  <option value="">Selecione um curso</option>
                  <option 
                    v-for="curso in cursos" 
                    :key="curso.id" 
                    :value="curso.id"
                  >
                    {{ curso.nome }} ({{ curso.codigo }})
                  </option>
                </select>
                <div v-if="form.errors.curso_id" class="text-destructive text-sm mt-1">
                  {{ form.errors.curso_id }}
                </div>
              </div>

              <!-- Turma -->
              <div>
                <label for="turma_id" class="block text-sm font-medium mb-2">
                  Turma (Opcional)
                </label>
                <select
                  id="turma_id"
                  v-model="form.turma_id"
                  :disabled="!form.curso_id"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring disabled:opacity-50 disabled:cursor-not-allowed"
                  :class="{ 'border-destructive': form.errors.turma_id }"
                >
                  <option value="">Selecione uma turma (opcional)</option>
                  <option 
                    v-for="turma in turmasFiltradas" 
                    :key="turma.id" 
                    :value="turma.id"
                  >
                    {{ turma.nome }} - {{ turma.periodo }}
                  </option>
                </select>
                <div v-if="form.errors.turma_id" class="text-destructive text-sm mt-1">
                  {{ form.errors.turma_id }}
                </div>
                <p class="text-xs text-muted-foreground mt-1" v-if="!form.curso_id">
                  Selecione um curso primeiro para ver as turmas disponíveis
                </p>
              </div>

              <!-- Upload de Imagem -->
              <div>
                <label class="block text-sm font-medium mb-2">
                  Foto do Estudante (Opcional)
                </label>
                <div class="border-2 border-dashed border-muted-foreground/25 rounded-lg p-6">
                  <div v-if="previewImagem" class="text-center">
                    <img 
                      :src="previewImagem" 
                      alt="Preview" 
                      class="mx-auto h-32 w-32 object-cover rounded-lg border"
                    />
                    <Button
                      type="button"
                      variant="outline"
                      size="sm"
                      @click="removerImagem"
                      class="mt-3"
                    >
                      <X class="w-4 h-4 mr-2" />
                      Remover foto
                    </Button>
                  </div>
                  <div v-else class="text-center">
                    <div class="w-12 h-12 mx-auto bg-muted rounded-lg flex items-center justify-center mb-4">
                      <Image class="w-6 h-6 text-muted-foreground" />
                    </div>
                    <div class="space-y-2">
                      <Button
                        type="button"
                        variant="outline"
                        @click="$refs.inputImagem?.click()"
                      >
                        <Upload class="w-4 h-4 mr-2" />
                        Selecionar foto
                      </Button>
                      <input
                        ref="inputImagem"
                        type="file"
                        accept="image/*"
                        class="hidden"
                        @change="selecionarImagem"
                      />
                      <p class="text-xs text-muted-foreground">
                        PNG, JPG ou GIF até 2MB
                      </p>
                    </div>
                  </div>
                </div>
                <div v-if="form.errors.imagem" class="text-destructive text-sm mt-1">
                  {{ form.errors.imagem }}
                </div>
              </div>

              <!-- Senha -->
              <div>
                <label for="password" class="block text-sm font-medium mb-2">
                  Senha Inicial *
                </label>
                <input
                  id="password"
                  v-model="form.password"
                  type="password"
                  required
                  minlength="8"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.password }"
                  placeholder="Digite uma senha segura (mín. 8 caracteres)"
                />
                <div v-if="form.errors.password" class="text-destructive text-sm mt-1">
                  {{ form.errors.password }}
                </div>
              </div>

              <!-- Confirmar Senha -->
              <div>
                <label for="password_confirmation" class="block text-sm font-medium mb-2">
                  Confirmar Senha *
                </label>
                <input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  required
                  minlength="8"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.password_confirmation }"
                  placeholder="Digite a senha novamente"
                />
                <div v-if="form.errors.password_confirmation" class="text-destructive text-sm mt-1">
                  {{ form.errors.password_confirmation }}
                </div>
              </div>

              <!-- Botões -->
              <div class="flex justify-end gap-3 pt-6 border-t">
                <Button
                  type="button"
                  variant="outline"
                  @click="$inertia.visit(route('estudante.index'))"
                >
                  Cancelar
                </Button>
                <Button
                  type="submit"
                  :disabled="form.processing"
                >
                  <UserPlus class="w-4 h-4 mr-2" />
                  {{ form.processing ? 'Criando...' : 'Criar Estudante' }}
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
import { ref, computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { ArrowLeft, Image, Upload, X, UserPlus } from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

interface Curso {
  id: number
  nome: string
  codigo: string
  ativo: boolean
}

interface Turma {
  id: number
  nome: string
  periodo: string
  curso_id: number
  ano_letivo: number
  ativo: boolean
  curso?: Curso
}

interface Props {
  cursos: Curso[]
  turmas: Turma[]
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Estudantes',
    href: '/estudantes'
  },
  {
    title: 'Criar Estudante',
    href: '/estudante/create'
  }
]

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  telefone_encarregado: '',
  numero_estudante: '',
  curso_id: '',
  turma_id: '',
  tipo: 'estudante',
  imagem: null as File | null
})

const previewImagem = ref<string | null>(null)

// Computed para filtrar turmas baseado no curso selecionado
const turmasFiltradas = computed(() => {
  if (!form.curso_id) return []
  return props.turmas.filter(turma => turma.curso_id == form.curso_id)
})

const submit = () => {
  form.post(route('estudante.store'), {
    forceFormData: true,
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}

const selecionarImagem = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]

  if (file) {
    // Verificar tamanho (2MB)
    if (file.size > 2 * 1024 * 1024) {
      form.setError('imagem', 'A imagem deve ter no máximo 2MB')
      return
    }

    // Verificar tipo
    if (!file.type.startsWith('image/')) {
      form.setError('imagem', 'Por favor, selecione apenas arquivos de imagem')
      return
    }

    form.clearErrors('imagem')
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
  form.clearErrors('imagem')
}

const onCursoChange = () => {
  // Limpar turma selecionada quando curso mudar
  form.turma_id = ''
  form.clearErrors('turma_id')
}
</script>