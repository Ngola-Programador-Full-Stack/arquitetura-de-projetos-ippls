<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
              <Link :href="route('dashboard')">
                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
              </Link>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                Dashboard
              </NavLink>
              <NavLink :href="route('projetos.index')" :active="route().current('projetos.*')">
                Projetos
              </NavLink>
              <NavLink :href="route('meus-projetos.index')" :active="route().current('meus-projetos.*')">
                Meus Projetos
              </NavLink>
              <NavLink
                v-if="$page.props.auth.user.tipo === 'coordenador'"
                :href="route('admin.dashboard')"
                :active="route().current('admin.*')"
              >
                Administração
              </NavLink>
            </div>
          </div>

          <div class="hidden sm:flex sm:items-center sm:ml-6">
            <!-- Notificações -->
            <div class="relative">
              <button
                @click="toggleNotifications"
                class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <BellIcon class="h-6 w-6" />
                <span
                  v-if="notificacoesNaoLidas > 0"
                  class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"
                >
                  {{ notificacoesNaoLidas }}
                </span>
              </button>

              <!-- Dropdown de Notificações -->
              <div
                v-if="showNotifications"
                class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50"
              >
                <div class="px-4 py-2 text-sm font-medium text-gray-900 border-b border-gray-200">
                  Notificações
                </div>
                <div class="max-h-96 overflow-y-auto">
                  <div
                    v-for="notificacao in notificacoes"
                    :key="notificacao.id"
                    :class="[
                      'px-4 py-3 text-sm cursor-pointer hover:bg-gray-50',
                      !notificacao.lida ? 'bg-blue-50' : ''
                    ]"
                    @click="marcarComoLida(notificacao)"
                  >
                    <div class="font-medium text-gray-900">
                      {{ notificacao.titulo }}
                    </div>
                    <div class="text-gray-600">
                      {{ notificacao.mensagem }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                      {{ formatarData(notificacao.created_at) }}
                    </div>
                  </div>
                </div>
                <div v-if="notificacoes.length === 0" class="px-4 py-3 text-sm text-gray-500">
                  Nenhuma notificação
                </div>
              </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="ml-3 relative">
              <Dropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button
                      type="button"
                      class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    >
                      {{ $page.props.auth.user.nome }}
                      <svg
                        class="ml-2 -mr-0.5 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </span>
                </template>

                <template #content>
                  <DropdownLink :href="route('profile.edit')">
                    Perfil
                  </DropdownLink>
                  <DropdownLink :href="route('logout')" method="post" as="button">
                    Logout
                  </DropdownLink>
                </template>
              </Dropdown>
            </div>
          </div>

          <!-- Hamburger -->
          <div class="-mr-2 flex items-center sm:hidden">
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
            >
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path
                  :class="{
                    hidden: showingNavigationDropdown,
                    'inline-flex': !showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{
                    hidden: !showingNavigationDropdown,
                    'inline-flex': showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Responsive Navigation Menu -->
      <div
        :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
        class="sm:hidden"
      >
        <div class="pt-2 pb-3 space-y-1">
          <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
            Dashboard
          </ResponsiveNavLink>
          <ResponsiveNavLink :href="route('projetos.index')" :active="route().current('projetos.*')">
            Projetos
          </ResponsiveNavLink>
          <ResponsiveNavLink :href="route('meus-projetos.index')" :active="route().current('meus-projetos.*')">
            Meus Projetos
          </ResponsiveNavLink>
          <ResponsiveNavLink
            v-if="$page.props.auth.user.tipo === 'coordenador'"
            :href="route('admin.dashboard')"
            :active="route().current('admin.*')"
          >
            Administração
          </ResponsiveNavLink>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
          <div class="px-4">
            <div class="font-medium text-base text-gray-800">
              {{ $page.props.auth.user.nome }}
            </div>
            <div class="font-medium text-sm text-gray-500">
              {{ $page.props.auth.user.email }}
            </div>
          </div>

          <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('profile.edit')">
              Perfil
            </ResponsiveNavLink>
            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
              Logout
            </ResponsiveNavLink>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Heading -->
    <header v-if="$slots.header" class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header" />
      </div>
    </header>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div
        v-if="$page.props.flash.success"
        class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
      >
        {{ $page.props.flash.success }}
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <svg
            class="fill-current h-6 w-6 text-green-500"
            role="button"
            @click="$page.props.flash.success = null"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          >
            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
          </svg>
        </span>
      </div>

      <div
        v-if="$page.props.flash.error"
        class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
      >
        {{ $page.props.flash.error }}
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <svg
            class="fill-current h-6 w-6 text-red-500"
            role="button"
            @click="$page.props.flash.error = null"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          >
            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
          </svg>
        </span>
      </div>
    </div>

    <!-- Page Content -->
    <main>
      <slot />
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { BellIcon } from 'lucide-vue-next'

const showingNavigationDropdown = ref(false)
const showNotifications = ref(false)
const notificacoes = ref([])
const notificacoesNaoLidas = ref(0)

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value
  if (showNotifications.value) {
    carregarNotificacoes()
  }
}

const carregarNotificacoes = async () => {
  try {
    const response = await fetch(route('notificacoes.index'))
    const data = await response.json()
    notificacoes.value = data.notificacoes
    notificacoesNaoLidas.value = data.naoLidas
  } catch (error) {
    console.error('Erro ao carregar notificações:', error)
  }
}

const marcarComoLida = async (notificacao) => {
  if (!notificacao.lida) {
    try {
      await fetch(route('notificacoes.marcar-lida', notificacao.id), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })

      notificacao.lida = true
      notificacoesNaoLidas.value = Math.max(0, notificacoesNaoLidas.value - 1)

      if (notificacao.acao_url) {
        router.visit(notificacao.acao_url)
      }
    } catch (error) {
      console.error('Erro ao marcar notificação como lida:', error)
    }
  }
}

const formatarData = (data) => {
  return new Date(data).toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

onMounted(() => {
  carregarNotificacoes()

  // Atualizar notificações a cada 30 segundos
  setInterval(carregarNotificacoes, 30000)
})
</script>
