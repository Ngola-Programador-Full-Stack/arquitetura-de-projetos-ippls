<template>
  <Head title="Novo Professor" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Novo Professor
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Cadastre um novo professor no sistema
          </p>
        </div>
        <Button 
          variant="outline" 
          @click="$inertia.visit(route('professores.index'))"
        >
          <ArrowLeft class="w-4 h-4 mr-2" />
          Voltar
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="submit" class="space-y-6">
          
          <!-- Informações Pessoais -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center gap-2">
                <User class="w-5 h-5" />
                Informações Pessoais
              </CardTitle>
              <CardDescription>
                Dados básicos do professor
              </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nome -->
                <div>
                  <label for="name" class="block text-sm font-medium mb-2">
                    Nome Completo *
                  </label>
                  <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    :class="{ 'border-destructive': form.errors.name }"
                    placeholder="Digite o nome completo"
                  />
                  <p v-if="form.errors.name" class="text-destructive text-xs mt-1">
                    {{ form.errors.name }}
                  </p>
                </div>

                <!-- Email -->
                <div>
                  <label for="email" class="block text-sm font-medium mb-2">
                    Email *
                  </label>
                  <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    :class="{ 'border-destructive': form.errors.email }"
                    placeholder="professor@email.com"
                  />
                  <p v-if="form.errors.email" class="text-destructive text-xs mt-1">
                    {{ form.errors.email }}
                  </p>
                </div>

                <!-- Telefone -->
                <div>
                  <label for="telefone_encarregado" class="block text-sm font-medium mb-2">
                    Telefone
                  </label>
                  <input
                    id="telefone_encarregado"
                    v-model="form.telefone_encarregado"
                    type="tel"
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    :class="{ 'border-destructive': form.errors.telefone_encarregado }"
                    placeholder="(XX) XXXXX-XXXX"
                  />
                  <p v-if="form.errors.telefone_encarregado" class="text-destructive text-xs mt-1">
                    {{ form.errors.telefone_encarregado }}
                  </p>
                </div>

                <!-- Status -->
                <div>
                  <label for="ativo" class="block text-sm font-medium mb-2">
                    Status *
                  </label>
                  <select
                    id="ativo"
                    v-model="form.ativo"
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    :class="{ 'border-destructive': form.errors.ativo }"
                  >
                    <option value="">Selecione o status</option>
                    <option :value="true">Ativo</option>
                    <option :value="false">Inativo</option>
                  </select>
                  <p v-if="form.errors.ativo" class="text-destructive text-xs mt-1">
                    {{ form.errors.ativo }}
                  </p>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Informações Acadêmicas -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center gap-2">
                <GraduationCap class="w-5 h-5" />
                Informações Acadêmicas
              </CardTitle>
              <CardDescription>
                Curso de vinculação e turmas
              </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
              <!-- Curso -->
              <div>
                <label for="curso_id" class="block text-sm font-medium mb-2">
                  Curso de Vinculação
                </label>
                <select
                  id="curso_id"
                  v-model="form.curso_id"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.curso_id }"
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
                <p v-if="form.errors.curso_id" class="text-destructive text-xs mt-1">
                  {{ form.errors.curso_id }}
                </p>
                <p class="text-xs text-muted-foreground mt-1">
                  Opcional: O curso ao qual o professor está vinculado
                </p>
              </div>

              <!-- Turmas -->
              <div>
                <label class="block text-sm font-medium mb-2">
                  Turmas Atribuídas
                </label>
                <div class="space-y-3">
                  <div class="max-h-48 overflow-y-auto border border-input rounded-md p-3 bg-background">
                    <div v-if="turmasDisponiveis.length > 0" class="space-y-2">
                      <div 
                        v-for="turma in turmasDisponiveis" 
                        :key="turma.id"
                        class="flex items-center space-x-3"
                      >
                        <input
                          :id="`turma-${turma.id}`"
                          v-model="form.turmas"
                          type="checkbox"
                          :value="turma.id"
                          class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <label 
                          :for="`turma-${turma.id}`"
                          class="text-sm cursor-pointer flex-1"
                        >
                          <span class="font-medium">{{ turma.nome }}</span>
                          <span class="text-muted-foreground">
                            - {{ turma.periodo }} ({{ turma.ano_letivo }})
                          </span>
                          <span v-if="turma.curso" class="text-xs bg-secondary px-1 py-0.5 rounded ml-2">
                            {{ turma.curso.codigo }}
                          </span>
                        </label>
                      </div>
                    </div>
                    <p v-else class="text-sm text-muted-foreground text-center py-4">
                      Nenhuma turma disponível
                    </p>
                  </div>
                  <p v-if="form.errors.turmas" class="text-destructive text-xs">
                    {{ form.errors.turmas }}
                  </p>
                  <p class="text-xs text-muted-foreground">
                    Selecione as turmas que o professor irá lecionar
                  </p>
                  <div v-if="form.turmas.length > 0" class="text-sm text-muted-foreground">
                    {{ form.turmas.length }} turma(s) selecionada(s)
                  </div>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Credenciais de Acesso -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center gap-2">
                <Lock class="w-5 h-5" />
                Credenciais de Acesso
              </CardTitle>
              <CardDescription>
                Configurações de login no sistema
              </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Senha -->
                <div>
                  <label for="password" class="block text-sm font-medium mb-2">
                    Senha *
                  </label>
                  <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    :class="{ 'border-destructive': form.errors.password }"
                    placeholder="Mínimo 8 caracteres"
                  />
                  <p v-if="form.errors.password" class="text-destructive text-xs mt-1">
                    {{ form.errors.password }}
                  </p>
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
                    class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                    :class="{ 'border-destructive': form.errors.password_confirmation }"
                    placeholder="Repita a senha"
                  />
                  <p v-if="form.errors.password_confirmation" class="text-destructive text-xs mt-1">
                    {{ form.errors.password_confirmation }}
                  </p>
                </div>
              </div>
              
              <!-- Opção de envio de credenciais -->
              <div class="flex items-center space-x-3">
                <input
                  id="enviar_credenciais"
                  v-model="form.enviar_credenciais"
                  type="checkbox"
                  class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                />
                <label for="enviar_credenciais" class="text-sm cursor-pointer">
                  Enviar credenciais por email para o professor
                </label>
              </div>
              <p class="text-xs text-muted-foreground">
                Se marcado, o professor receberá um email com suas credenciais de acesso
              </p>
            </CardContent>
          </Card>

          <!-- Ações -->
          <div class="flex items-center justify-between pt-6 border-t">
            <Button 
              type="button"
              variant="outline" 
              @click="$inertia.visit(route('professores.index'))"
            >
              <X class="w-4 h-4 mr-2" />
              Cancelar
            </Button>
            
            <Button 
              type="submit" 
              :disabled="form.processing"
              class="min-w-[120px]"
            >
              <template v-if="form.processing">
                <Loader2 class="w-4 h-4 mr-2 animate-spin" />
                Salvando...
              </template>
              <template v-else>
                <Save class="w-4 h-4 mr-2" />
                Cadastrar Professor
              </template>
            </Button>
          </div>

        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  ArrowLeft, User, GraduationCap, Lock, Save, X, 
  Loader2
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

interface Props {
  cursos: Curso[]
  turmas: Turma[]
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Professores',
    href: '/professores'
  },
  {
    title: 'Novo Professor'
  }
]

const form = useForm({
  name: '',
  email: '',
  telefone_encarregado: '',
  ativo: true,
  curso_id: '',
  turmas: [] as number[],
  password: '',
  password_confirmation: '',
  enviar_credenciais: true
})

// Computed para turmas disponíveis
const turmasDisponiveis = computed(() => {
  return props.turmas.sort((a, b) => {
    // Ordenar por curso, depois por nome
    if (a.curso && b.curso) {
      const cursoDiff = a.curso.nome.localeCompare(b.curso.nome)
      if (cursoDiff !== 0) return cursoDiff
    }
    return a.nome.localeCompare(b.nome)
  })
})

const submit = () => {
  form.post(route('professores.store'), {
    onSuccess: () => {
      // Redirecionará automaticamente para a lista ou para o professor criado
    }
  })
}
</script>