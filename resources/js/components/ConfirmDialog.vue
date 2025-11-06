<template>
  <Dialog :open="open" @update:open="$emit('update:open', $event)">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle class="flex items-center gap-2">
          <component :is="icon" class="w-5 h-5" :class="iconClass" />
          {{ title }}
        </DialogTitle>
        <DialogDescription>
          {{ message }}
        </DialogDescription>
      </DialogHeader>
      
      <div v-if="details" class="py-4">
        <div class="bg-muted/50 rounded-lg p-3">
          <p class="text-sm text-muted-foreground">{{ details }}</p>
        </div>
      </div>
      
      <DialogFooter>
        <Button
          variant="outline"
          @click="handleCancel"
          :disabled="loading"
        >
          {{ cancelText }}
        </Button>
        <Button
          :variant="variant"
          @click="handleConfirm"
          :disabled="loading"
        >
          <Loader2 v-if="loading" class="w-4 h-4 mr-2 animate-spin" />
          <component v-else :is="confirmIcon" class="w-4 h-4 mr-2" />
          {{ confirmText }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>

<script setup lang="ts">
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'
import { AlertTriangle, Trash, CheckCircle, XCircle, Loader2 } from 'lucide-vue-next'
import { computed } from 'vue'

interface Props {
  open: boolean
  title?: string
  message?: string
  details?: string
  type?: 'warning' | 'danger' | 'info' | 'success'
  confirmText?: string
  cancelText?: string
  loading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Confirmar ação',
  message: 'Tem certeza que deseja continuar?',
  type: 'warning',
  confirmText: 'Confirmar',
  cancelText: 'Cancelar',
  loading: false
})

const emit = defineEmits<{
  'update:open': [value: boolean]
  'confirm': []
  'cancel': []
}>()

const icon = computed(() => {
  const icons = {
    warning: AlertTriangle,
    danger: Trash,
    info: CheckCircle,
    success: CheckCircle
  }
  return icons[props.type]
})

const iconClass = computed(() => {
  const classes = {
    warning: 'text-yellow-600',
    danger: 'text-red-600',
    info: 'text-blue-600',
    success: 'text-green-600'
  }
  return classes[props.type]
})

const variant = computed(() => {
  const variants = {
    warning: 'default' as const,
    danger: 'destructive' as const,
    info: 'default' as const,
    success: 'default' as const
  }
  return variants[props.type]
})

const confirmIcon = computed(() => {
  const icons = {
    warning: AlertTriangle,
    danger: Trash,
    info: CheckCircle,
    success: CheckCircle
  }
  return icons[props.type]
})

const handleConfirm = () => {
  emit('confirm')
}

const handleCancel = () => {
  emit('cancel')
  emit('update:open', false)
}
</script>