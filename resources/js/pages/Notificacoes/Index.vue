<template>
  <Head title="Notificações" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <template #header>
      <div class="flex justify-between items-center">
        <div>
          <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Notificações
          </h2>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Acompanhe suas notificações e atualizações
          </p>
        </div>
        <div class="flex gap-2">
          <Button 
            v-if="temNaoLidas"
            variant="outline"
            @click="marcarTodasComoLidasHandler"
            :disabled="processando"
          >
            <CheckCheck class="w-4 h-4 mr-2" />
            Marcar todas como lidas
          </Button>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Filtros -->
        <Card>
          <CardContent class="p-4">
            <div class="flex items-center gap-4">
              <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Filtrar:</label>
                <select
                  v-model="filtroTipo"
                  @change="aplicarFiltros"
                  class="border border-input rounded-md px-3 py-1 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-ring"
                >
                  <option value="">Todas</option>
                  <option value="nao_lidas">Não lidas</option>
                  <option value="lidas">Lidas</option>
                </select>
              </div>
              
              <div class="flex items-center gap-2 text-sm text-muted-foreground">
                <Bell class="w-4 h-4" />
                <span>{{ notificacoesList.length }} notificação(ões)</span>
                <span v-if="naoLidas > 0" class="text-primary font-medium">
                  ({{ naoLidas }} não lidas)
                </span>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Lista de Notificações -->
        <div v-if="notificacoesFiltradas.length > 0" class="space-y-2">
          <Card
            v-for="notificacao in notificacoesFiltradas"
            :key="notificacao.id"
            class="transition-all duration-200"
            :class="!notificacao.lida ? 'bg-blue-50/50 dark:bg-blue-950/20 border-blue-200 dark:border-blue-800' : 'hover:shadow-md'"
          >
            <CardContent class="p-0">
              <div 
                class="flex items-start p-4 cursor-pointer"
                @click="marcarComoLida(notificacao)"
              >
                <!-- Indicador de status -->
                <div class="flex-shrink-0 mt-1">
                  <div 
                    class="w-3 h-3 rounded-full"
                    :class="!notificacao.lida ? 'bg-blue-500' : 'bg-muted'"
                  ></div>
                </div>

                <!-- Ícone do tipo -->
                <div class="flex-shrink-0 mx-3">
                  <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                       :class="getIconClass(notificacao.tipo)">
                    <component :is="getIcon(notificacao.tipo)" class="w-5 h-5" />
                  </div>
                </div>

                <!-- Conteúdo -->
                <div class="flex-1 min-w-0">
                  <h3 class="text-sm font-semibold mb-1"
                      :class="!notificacao.lida ? 'text-foreground' : 'text-muted-foreground'">
                    {{ notificacao.titulo }}
                  </h3>
                  
                  <p class="text-sm text-muted-foreground mb-2">
                    {{ notificacao.mensagem }}
                  </p>
                  
                  <div class="flex items-center justify-between">
                    <span class="text-xs text-muted-foreground">
                      {{ formatarData(notificacao.created_at) }}
                    </span>
                    
                    <div class="flex items-center gap-2">
                      <span v-if="!notificacao.lida" 
                            class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs rounded-full">
                        Nova
                      </span>
                      
                      <Button
                        v-if="notificacao.acao_url"
                        variant="ghost"
                        size="sm"
                        @click.stop="abrirLink(notificacao.acao_url)"
                      >
                        <ExternalLink class="w-3 h-3" />
                      </Button>
                    </div>
                  </div>
                </div>

                <!-- Botão de ação -->
                <div class="flex-shrink-0 ml-2">
                  <Button
                    variant="ghost"
                    size="sm"
                    @click.stop="removerNotificacaoHandler(notificacao.id)"
                  >
                    <X class="w-4 h-4" />
                  </Button>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Estado vazio -->
        <Card v-else>
          <CardContent class="text-center py-16">
            <div class="w-16 h-16 mx-auto bg-muted rounded-full flex items-center justify-center mb-4">
              <Bell class="w-8 h-8 text-muted-foreground" />
            </div>
            <h3 class="text-lg font-semibold mb-2">
              {{ filtroTipo === 'nao_lidas' ? 'Nenhuma notificação não lida' : 'Nenhuma notificação' }}
            </h3>
            <p class="text-muted-foreground">
              {{ filtroTipo === 'nao_lidas' 
                ? 'Parabéns! Você está em dia com suas notificações.' 
                : 'Você receberá notificações sobre atualizações importantes aqui.' 
              }}
            </p>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  Bell, CheckCheck, X, ExternalLink, Info, AlertTriangle, CheckCircle, 
  Star, FileText, Users
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'
import { useNotifications } from '@/composables/useNotifications'

interface Notificacao {
  id: number
  titulo: string
  mensagem: string
  tipo: string
  lida: boolean
  acao_url?: string
  created_at: string
}

interface PaginatedNotificacoes {
  data: Notificacao[]
  current_page: number
  last_page: number
  per_page: number
  total: number
  links: Array<{
    url: string | null
    label: string
    active: boolean
  }>
}

interface Props {
  notificacoes: PaginatedNotificacoes | Notificacao[]
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Notificações',
    href: '/notificacoes'
  }
]

const filtroTipo = ref('')
const { processando, marcarComoLida, marcarTodasComoLidas, removerNotificacao } = useNotifications()

// Computeds
const notificacoesList = computed(() => {
  // Se for um objeto paginado, pega o data. Se for array, usa direto
  return Array.isArray(props.notificacoes) ? props.notificacoes : props.notificacoes.data || []
})

const naoLidas = computed(() => 
  notificacoesList.value.filter(n => !n.lida).length
)

const temNaoLidas = computed(() => naoLidas.value > 0)

const notificacoesFiltradas = computed(() => {
  const lista = notificacoesList.value
  if (!filtroTipo.value) return lista
  
  if (filtroTipo.value === 'nao_lidas') {
    return lista.filter(n => !n.lida)
  }
  
  if (filtroTipo.value === 'lidas') {
    return lista.filter(n => n.lida)
  }
  
  return lista
})

// Methods
const getIcon = (tipo: string) => {
  const icons: Record<string, any> = {
    'info': Info,
    'warning': AlertTriangle,
    'success': CheckCircle,
    'avaliacao': Star,
    'projeto': FileText,
    'sistema': Users
  }
  return icons[tipo] || Bell
}

const getIconClass = (tipo: string) => {
  const classes: Record<string, string> = {
    'info': 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-400',
    'warning': 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-400',
    'success': 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400',
    'avaliacao': 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-400',
    'projeto': 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-400',
    'sistema': 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'
  }
  return classes[tipo] || 'bg-muted text-muted-foreground'
}

const formatarData = (data: string) => {
  const agora = new Date()
  const dataNotificacao = new Date(data)
  const diff = agora.getTime() - dataNotificacao.getTime()
  const minutos = Math.floor(diff / (1000 * 60))
  const horas = Math.floor(diff / (1000 * 60 * 60))
  const dias = Math.floor(diff / (1000 * 60 * 60 * 24))
  
  if (minutos < 60) {
    return minutos <= 1 ? 'Agora' : `${minutos} min atrás`
  } else if (horas < 24) {
    return `${horas}h atrás`
  } else if (dias < 7) {
    return `${dias}d atrás`
  } else {
    return dataNotificacao.toLocaleDateString('pt-BR')
  }
}

const marcarTodasComoLidasHandler = async () => {
  const sucesso = await marcarTodasComoLidas()
  if (sucesso) {
    // Recarregar a página para atualizar as notificações
    router.reload({ only: ['notificacoes'] })
  }
}

const removerNotificacaoHandler = async (id: number) => {
  const sucesso = await removerNotificacao(id)
  if (sucesso) {
    // Recarregar a página para atualizar as notificações
    router.reload({ only: ['notificacoes'] })
  }
}

const abrirLink = (url: string) => {
  if (url.startsWith('http')) {
    window.open(url, '_blank')
  } else {
    router.visit(url)
  }
}

const aplicarFiltros = () => {
  // A filtragem é feita via computed, então não precisa fazer nada aqui
}
</script>