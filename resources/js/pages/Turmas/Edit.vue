<template>
  <Head title="Editar Turma" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Turma
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Atualize as informações da turma {{ turma.nome }}
          </p>
        </div>
        <Button variant="outline" @click="$inertia.visit(route('turmas.index'))">
          <ArrowLeft class="w-4 h-4 mr-2" />
          Voltar
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <Card>
          <CardHeader>
            <CardTitle>Informações da Turma</CardTitle>
            <CardDescription>
              Atualize os dados necessários da turma
            </CardDescription>
          </CardHeader>
          <CardContent>
            <form @submit.prevent="submit" class="space-y-6">
              
              <!-- Nome da Turma -->
              <div>
                <label for="nome" class="block text-sm font-medium mb-2">
                  Nome da Turma *
                </label>
                <input
                  id="nome"
                  v-model="form.nome"
                  type="text"
                  required
                  maxlength="100"
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.nome }"
                  placeholder="Ex: GRSI-3A, GRSI-3B, etc."
                />
                <div v-if="form.errors.nome" class="text-destructive text-sm mt-1">
                  {{ form.errors.nome }}
                </div>
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
                >
                  <option value="">Selecione um curso</option>
                  <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
                    {{ curso.nome }} ({{ curso.codigo }})
                  </option>
                </select>
                <div v-if="form.errors.curso_id" class="text-destructive text-sm mt-1">
                  {{ form.errors.curso_id }}
                </div>
              </div>

              <!-- Período -->
              <div>
                <label for="periodo" class="block text-sm font-medium mb-2">
                  Período *
                </label>
                <select
                  id="periodo"
                  v-model="form.periodo"
                  required
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.periodo }"
                >
                  <option value="">Selecione um período</option>
                  <option value="Manhã">Manhã</option>
                  <option value="Tarde">Tarde</option>
                  <option value="Noite">Noite</option>
                </select>
                <div v-if="form.errors.periodo" class="text-destructive text-sm mt-1">
                  {{ form.errors.periodo }}
                </div>
              </div>

              <!-- Ano Letivo -->
              <div>
                <label for="ano_letivo" class="block text-sm font-medium mb-2">
                  Ano Letivo *
                </label>
                <select
                  id="ano_letivo"
                  v-model="form.ano_letivo"
                  required
                  class="w-full border border-input rounded-md px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                  :class="{ 'border-destructive': form.errors.ano_letivo }"
                >
                  <option value="">Selecione o ano letivo</option>
                  <option v-for="ano in anosDisponiveis" :key="ano" :value="ano">
                    {{ ano }}
                  </option>
                </select>
                <div v-if="form.errors.ano_letivo" class="text-destructive text-sm mt-1">
                  {{ form.errors.ano_letivo }}
                </div>
              </div>

              <!-- Status Ativo -->
              <div class="flex items-center space-x-2">
                <input
                  id="ativo"
                  v-model="form.ativo"
                  type="checkbox"
                  class="rounded border-gray-300 text-primary focus:ring-primary focus:ring-offset-0"
                />
                <label for="ativo" class="text-sm font-medium cursor-pointer">
                  Turma ativa
                </label>
              </div>

              <!-- Botões -->
              <div class="flex justify-end gap-3 pt-6 border-t">
                <Button
                  type="button"
                  variant="outline"
                  @click="$inertia.visit(route('turmas.index'))"
                >
                  Cancelar
                </Button>
                <Button
                  type="submit"
                  :disabled="form.processing"
                >
                  <Save class="w-4 h-4 mr-2" />
                  {{ form.processing ? 'Salvando...' : 'Salvar Alterações' }}
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
import { computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { ArrowLeft, Save } from 'lucide-vue-next'
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
  ano_letivo: number
  ativo: boolean
  curso_id: number
}

interface Props {
  turma: Turma
  cursos: Curso[]
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Turmas',
    href: '/turmas'
  },
  {
    title: props.turma.nome,
    href: `/turmas/${props.turma.id}`
  },
  {
    title: 'Editar',
    href: `/turmas/${props.turma.id}/edit`
  }
]

const form = useForm({
  nome: props.turma.nome,
  curso_id: props.turma.curso_id,
  periodo: props.turma.periodo,
  ano_letivo: props.turma.ano_letivo,
  ativo: props.turma.ativo
})

// Anos disponíveis (ano atual + próximos 2 anos + anteriores 2 anos)
const anosDisponiveis = computed(() => {
  const anoAtual = new Date().getFullYear()
  const anos = []
  
  for (let i = anoAtual - 1; i <= anoAtual + 3; i++) {
    anos.push(i)
  }
  
  return anos
})

const submit = () => {
  form.put(route('turmas.update', props.turma.id))
}
</script>