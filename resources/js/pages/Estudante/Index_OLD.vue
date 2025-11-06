<template>
  <Head title="Estudantes" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Estudantes Disponíveis
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Gerencie estudantes e seus projetos
          </p>
        </div>
        <Button 
          v-if="$page.props.auth.user.tipo === 'coordenador'"
          @click="$inertia.visit(route('estudante.create'))"
        >
          <Plus class="w-4 h-4 mr-2" />
          Novo Estudante
        </Button>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Placeholder para lista de estudantes -->
        <Card>
          <CardContent class="text-center py-16">
            <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center mb-4">
              <Users class="w-8 h-8 text-muted-foreground" />
            </div>
            <h3 class="text-lg font-semibold mb-2">
              Lista de Estudantes
            </h3>
            <p class="text-muted-foreground mb-6">
              Esta funcionalidade estará disponível em breve. Você poderá gerenciar estudantes e acompanhar seus projetos aqui.
            </p>
          </CardContent>
        </Card>
        
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Plus, Users } from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Estudantes',
    href: '/estudantes'
  }
]
</script>
