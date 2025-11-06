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
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { ArrowLeft, Image, Upload, X, UserPlus } from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

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
  tipo: 'estudante',
  imagem: null as File | null
})

const previewImagem = ref<string | null>(null)

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
</script>