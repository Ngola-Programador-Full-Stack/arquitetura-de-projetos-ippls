<template>
  <Head :title="`Turma ${turma.nome}`" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ turma.nome }}
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            {{ turma.curso?.nome }} - {{ turma.periodo }} - {{ turma.ano_letivo }}
          </p>
        </div>
        <div class="flex gap-2">
          <Button variant="outline" @click="$inertia.visit(route('turmas.edit', turma.id))">
            <Edit class="w-4 h-4 mr-2" />
            Editar
          </Button>
          <Button variant="outline" @click="$inertia.visit(route('turmas.index'))">
            <ArrowLeft class="w-4 h-4 mr-2" />
            Voltar
          </Button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Informações da Turma -->
        <Card>
          <CardHeader>
            <div class="flex items-center justify-between">
              <div>
                <CardTitle class="flex items-center gap-2">
                  <GraduationCap class="w-5 h-5" />
                  Informações da Turma
                </CardTitle>
                <CardDescription>
                  Detalhes e configurações da turma
                </CardDescription>
              </div>
              <span 
                class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full"
                :class="turma.ativo 
                  ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                  : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'"
              >
                {{ turma.ativo ? 'Ativa' : 'Inativa' }}
              </span>
            </div>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                  <BookOpen class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                  <p class="text-sm text-muted-foreground">Curso</p>
                  <p class="font-semibold">{{ turma.curso?.nome }}</p>
                  <p class="text-xs text-muted-foreground">{{ turma.curso?.codigo }}</p>
                </div>
              </div>
              
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                  <Clock class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                </div>
                <div>
                  <p class="text-sm text-muted-foreground">Período</p>
                  <p class="font-semibold">{{ turma.periodo }}</p>
                </div>
              </div>
              
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                  <Calendar class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                </div>
                <div>
                  <p class="text-sm text-muted-foreground">Ano Letivo</p>
                  <p class="font-semibold">{{ turma.ano_letivo }}</p>
                </div>
              </div>
              
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                  <Users class="w-5 h-5 text-green-600 dark:text-green-400" />
                </div>
                <div>
                  <p class="text-sm text-muted-foreground">Estudantes</p>
                  <p class="font-semibold">{{ turma.users?.length || 0 }}</p>
                  <p class="text-xs text-muted-foreground">
                    {{ turma.users?.filter(u => u.ativo).length || 0 }} ativos
                  </p>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Lista de Estudantes -->
        <Card>
          <CardHeader>
            <div class="flex items-center justify-between">
              <div>
                <CardTitle class="flex items-center gap-2">
                  <Users class="w-5 h-5" />
                  Estudantes da Turma
                </CardTitle>
                <CardDescription>
                  {{ turma.users?.length || 0 }} estudante(s) vinculado(s) a esta turma
                </CardDescription>
              </div>
              <Button size="sm">
                <UserPlus class="w-4 h-4 mr-2" />
                Adicionar Estudante
              </Button>
            </div>
          </CardHeader>
          <CardContent>
            <div v-if="turma.users && turma.users.length > 0" class="space-y-4">
              <div 
                v-for="user in turma.users" 
                :key="user.id"
                class="flex items-center justify-between p-4 border rounded-lg hover:bg-muted/50 transition-colors"
              >
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                    <User class="w-5 h-5 text-primary" />
                  </div>
                  <div>
                    <p class="font-medium">{{ user.name }}</p>
                    <p class="text-sm text-muted-foreground">{{ user.email }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <span 
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="user.ativo 
                      ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                      : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'"
                  >
                    {{ user.ativo ? 'Ativo' : 'Inativo' }}
                  </span>
                  <Button size="sm" variant="outline">
                    <Eye class="w-3 h-3" />
                  </Button>
                  <Button size="sm" variant="outline" class="text-destructive hover:text-destructive">
                    <X class="w-3 h-3" />
                  </Button>
                </div>
              </div>
            </div>
            
            <!-- Estado vazio -->
            <div v-else class="text-center py-12">
              <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center mb-4">
                <Users class="w-8 h-8 text-muted-foreground" />
              </div>
              <h3 class="text-lg font-semibold mb-2">Nenhum estudante vinculado</h3>
              <p class="text-muted-foreground mb-4">
                Esta turma ainda não possui estudantes cadastrados.
              </p>
              <Button>
                <UserPlus class="w-4 h-4 mr-2" />
                Adicionar Primeiro Estudante
              </Button>
            </div>
          </CardContent>
        </Card>

        <!-- Estatísticas da Turma -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <Card>
            <CardContent class="p-6">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Total de Estudantes</p>
                  <p class="text-3xl font-bold">{{ turma.users?.length || 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                  <Users class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-6">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Estudantes Ativos</p>
                  <p class="text-3xl font-bold">{{ turma.users?.filter(u => u.ativo).length || 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                  <CheckCircle class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
              </div>
            </CardContent>
          </Card>
          
          <Card>
            <CardContent class="p-6">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-muted-foreground">Estudantes Inativos</p>
                  <p class="text-3xl font-bold">{{ (turma.users?.length || 0) - (turma.users?.filter(u => u.ativo).length || 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-900 rounded-lg flex items-center justify-center">
                  <UserX class="w-6 h-6 text-gray-600 dark:text-gray-400" />
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  ArrowLeft, Edit, GraduationCap, BookOpen, Clock, Calendar, Users, 
  UserPlus, User, Eye, X, CheckCircle, UserX
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

interface Curso {
  id: number
  nome: string
  codigo: string
  ativo: boolean
}

interface User {
  id: number
  name: string
  email: string
  ativo: boolean
  tipo: string
}

interface Turma {
  id: number
  nome: string
  periodo: string
  ano_letivo: number
  ativo: boolean
  curso?: Curso
  users?: User[]
}

interface Props {
  turma: Turma
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
  }
]
</script>