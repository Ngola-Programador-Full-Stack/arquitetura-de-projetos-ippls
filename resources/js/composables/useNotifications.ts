import { ref } from 'vue'

interface Notificacao {
  id: number
  titulo: string
  mensagem: string
  tipo: string
  lida: boolean
  acao_url?: string
  created_at: string
  data_leitura?: string
}

export function useNotifications() {
  const processando = ref(false)

  const marcarComoLida = async (notificacao: Notificacao): Promise<boolean> => {
    if (notificacao.lida) return true

    try {
      processando.value = true
      
      const response = await fetch(`/notificacoes/${notificacao.id}/marcar-lida`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({})
      })
      
      if (response.ok) {
        // Atualizar o estado local da notificação
        notificacao.lida = true
        notificacao.data_leitura = new Date().toISOString()
        return true
      }
      
      return false
    } catch (error) {
      console.error('Erro ao marcar notificação como lida:', error)
      return false
    } finally {
      processando.value = false
    }
  }

  const marcarTodasComoLidas = async (): Promise<boolean> => {
    try {
      processando.value = true
      
      const response = await fetch('/notificacoes/marcar-todas-lidas', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({})
      })
      
      return response.ok
    } catch (error) {
      console.error('Erro ao marcar todas as notificações como lidas:', error)
      return false
    } finally {
      processando.value = false
    }
  }

  const removerNotificacao = async (id: number): Promise<boolean> => {
    try {
      const response = await fetch(`/notificacoes/${id}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      
      return response.ok
    } catch (error) {
      console.error('Erro ao remover notificação:', error)
      return false
    }
  }

  return {
    processando,
    marcarComoLida,
    marcarTodasComoLidas,
    removerNotificacao
  }
}

