<template>
    <nav
        :class="[
            'fixed top-0 left-0 right-0 z-50 transition-all duration-300',
            scrolled
                ? 'bg-white/95 dark:bg-[#010226]/95 backdrop-blur-xl shadow-sm border-b border-[#d0d7de]/50 dark:border-[#30363d]/50'
                : 'bg-white/70 dark:bg-[#010226]/70 backdrop-blur-md'
        ]"
    >
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <AppLogoIcon />

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-xl mx-4 lg:mx-8">
                    <div class="relative w-full group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <Search class="w-4 h-4 text-[#656d76] dark:text-[#7d8590] group-focus-within:text-[#0969da] dark:group-focus-within:text-[#58a6ff] transition-colors" :stroke-width="2.5" />
                        </div>
                        <input
                            type="search"
                            id="navbar-search"
                            v-model="searchQuery"
                            @focus="searchFocused = true"
                            @blur="searchFocused = false"
                            @keydown.enter="handleSearch"
                            class="block w-full pl-10 pr-4 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] bg-[#f6f8fa] dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0969da] dark:focus:ring-[#1f6feb] focus:border-[#0969da] dark:focus:border-[#1f6feb] transition-all placeholder:text-[#656d76] dark:placeholder:text-[#7d8590]"
                            placeholder="Pesquisar projetos, templates, documentação..."
                            autocomplete="off"
                        />
                        <!-- Clear button or keyboard shortcut hint -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button
                                v-if="searchQuery"
                                @click="clearSearch"
                                class="p-1 rounded-md hover:bg-[#eaeef2] dark:hover:bg-[#21262d] transition-colors"
                                aria-label="Limpar pesquisa"
                            >
                                <X class="w-4 h-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2.5" />
                            </button>
                            <kbd v-else-if="!searchFocused" class="hidden lg:inline-flex items-center px-2 py-1 text-xs font-semibold text-[#656d76] dark:text-[#7d8590] bg-white dark:bg-[#010226] border border-[#d0d7de] dark:border-[#30363d] rounded pointer-events-none">
                                <span class="text-[10px]">⌘</span>K
                            </kbd>
                        </div>
                    </div>
                </div>

                <!-- Mobile Search Button -->
                <button
                    @click="mobileSearchOpen = !mobileSearchOpen"
                    class="md:hidden p-2 rounded-lg hover:bg-[#f6f8fa] dark:hover:bg-[#161b22] transition-colors"
                    aria-label="Abrir pesquisa"
                >
                    <Search class="w-5 h-5 text-[#24292f] dark:text-[#e6edf3]" :stroke-width="2.5" />
                </button>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <Link
                        :href="route('home')"
                        class="relative px-3 py-2 text-sm font-medium text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3] transition-colors rounded-md group"
                    >
                        <span class="relative">Início</span>
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-[#2B4C7E] dark:bg-[#1f6feb] group-hover:w-4/5 transition-all duration-200"></span>
                    </Link>

                    <Link
                        :href="route('feature')"
                        class="relative px-3 py-2 text-sm font-medium text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3] transition-colors rounded-md group"
                    >
                        <span class="relative">Recursos</span>
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-[#2B4C7E] dark:bg-[#1f6feb] group-hover:w-4/5 transition-all duration-200"></span>
                    </Link>

                    <Link
                        :href="route('architecture')"
                        class="relative px-3 py-2 text-sm font-medium text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3] transition-colors rounded-md group"
                    >
                        <span class="relative">Arquitetura</span>
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-[#2B4C7E] dark:bg-[#1f6feb] group-hover:w-4/5 transition-all duration-200"></span>
                    </Link>

                    <Link
                        :href="route('about')"
                        class="relative px-3 py-2 text-sm font-medium text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3] transition-colors rounded-md group"
                    >
                        <span class="relative">Sobre</span>
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-[#2B4C7E] dark:bg-[#1f6feb] group-hover:w-4/5 transition-all duration-200"></span>
                    </Link>

                    <!-- Account Dropdown -->
                    <div class="relative" ref="accountDropdownRef">
                        <button
                            @click="accountDropdownOpen = !accountDropdownOpen"
                            class="relative px-3 py-2 text-sm font-medium text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3] transition-colors rounded-md group flex items-center space-x-1"
                        >
                            <span class="relative">Conta</span>
                            <ChevronDown 
                                :class="[
                                    'w-4 h-4 transition-transform duration-200',
                                    accountDropdownOpen ? 'rotate-180' : ''
                                ]" 
                                :stroke-width="2.5" 
                            />
                            <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-[#2B4C7E] dark:bg-[#1f6feb] group-hover:w-4/5 transition-all duration-200"></span>
                        </button>

                        <!-- Dropdown Menu -->
                        <transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 transform scale-95"
                            enter-to-class="opacity-100 transform scale-100"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 transform scale-100"
                            leave-to-class="opacity-0 transform scale-95"
                        >
                            <div
                                v-if="accountDropdownOpen"
                                class="absolute right-0 mt-2 w-56 origin-top-right rounded-lg bg-white dark:bg-[#161b22] shadow-lg ring-1 ring-black/5 dark:ring-white/10 border border-[#d0d7de] dark:border-[#30363d] divide-y divide-[#d0d7de] dark:divide-[#30363d]"
                            >
                                <div class="py-1">
                                    <Link
                                        v-if="$page.props.auth?.user"
                                        :href="route('dashboard')"
                                        class="flex items-center px-4 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#21262d] transition-colors"
                                    >
                                        <LayoutDashboard class="w-4 h-4 mr-3 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                        Dashboard
                                    </Link>
                                    <Link
                                        v-if="$page.props.auth?.user"
                                        href="/profile"
                                        class="flex items-center px-4 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#21262d] transition-colors"
                                    >
                                        <User class="w-4 h-4 mr-3 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                        Meu Perfil
                                    </Link>
                                    <Link
                                        v-if="$page.props.auth?.user"
                                        href="/settings"
                                        class="flex items-center px-4 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#21262d] transition-colors"
                                    >
                                        <Settings class="w-4 h-4 mr-3 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                        Configurações
                                    </Link>
                                </div>

                                <!-- Theme Switcher -->
                                <div class="py-1">
                                    <div class="px-1 py-2">
                                        <p class="text-xs font-semibold text-[#656d76] dark:text-[#7d8590] mb-2 ml-2">Tema</p>
                                        <div class="flex items-center space-x-1 bg-[#f6f8fa] dark:bg-[#010226] rounded-lg p-1">
                                            <button
                                                @click="setTheme('light')"
                                                :class="[
                                                    'flex-1 flex items-center justify-center space-x-1.5 px-2 py-1.5 text-xs font-medium rounded-md transition-all',
                                                    theme === 'light'
                                                        ? 'bg-white dark:bg-[#21262d] text-[#24292f] dark:text-[#e6edf3] shadow-sm'
                                                        : 'text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3]'
                                                ]"
                                            >
                                                <Sun class="w-3.5 h-3.5" :stroke-width="2.5" />
                                                <span>Luz</span>
                                            </button>
                                            <button
                                                @click="setTheme('dark')"
                                                :class="[
                                                    'flex-1 flex items-center justify-center space-x-1.5 px-2 py-1.5 text-xs font-medium rounded-md transition-all',
                                                    theme === 'dark'
                                                        ? 'bg-white dark:bg-[#21262d] text-[#24292f] dark:text-[#e6edf3] shadow-sm'
                                                        : 'text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3]'
                                                ]"
                                            >
                                                <Moon class="w-3.5 h-3.5" :stroke-width="2.5" />
                                                <span>Escuro</span>
                                            </button>
                                            <button
                                                @click="setTheme('system')"
                                                :class="[
                                                    'flex-1 flex items-center justify-center space-x-1.5 px-2 py-1.5 text-xs font-medium rounded-md transition-all',
                                                    theme === 'system'
                                                        ? 'bg-white dark:bg-[#21262d] text-[#24292f] dark:text-[#e6edf3] shadow-sm'
                                                        : 'text-[#656d76] dark:text-[#7d8590] hover:text-[#24292f] dark:hover:text-[#e6edf3]'
                                                ]"
                                            >
                                                <Monitor class="w-3.5 h-3.5" :stroke-width="2.5" />
                                                <span>Sistema</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="py-1" v-if="$page.props.auth?.user">
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="flex items-center w-full px-4 py-2 text-sm text-[#cf222e] dark:text-[#f85149] hover:bg-[#fff1f0] dark:hover:bg-[#1a1f28] transition-colors"
                                    >
                                        <LogOut class="w-4 h-4 mr-3" :stroke-width="2" />
                                        Sair
                                    </Link>
                                </div>

                                <div class="py-1" v-else>
                                    <Link
                                        :href="route('login')"
                                        class="flex items-center px-4 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#21262d] transition-colors"
                                    >
                                        <LogIn class="w-4 h-4 mr-3 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                        Entrar
                                    </Link>
                                    <Link
                                        :href="route('register')"
                                        class="flex items-center px-4 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#21262d] transition-colors"
                                    >
                                        <UserPlus class="w-4 h-4 mr-3 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                        Criar Conta
                                    </Link>
                                </div>
                            </div>
                        </transition>
                    </div>

                    <!-- Divider -->
                    <div class="w-px h-6 bg-[#d0d7de] dark:bg-[#30363d] mx-2"></div>

                    <!-- Auth Buttons -->
                    <Link
                        v-if="$page.props.auth?.user"
                        :href="route('dashboard')"
                        class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-[#24292f] dark:text-[#e6edf3] bg-[#f6f8fa] dark:bg-[#010226] hover:bg-[#eaeef2] dark:hover:bg-[#21262d] border border-[#d0d7de] dark:border-[#30363d] rounded-full transition-all"
                    >
                        <span>Dashboard</span>
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-4 py-2 text-sm font-medium text-[#24292f] dark:text-[#e6edf3] hover:text-[#0969da] dark:hover:text-[#58a6ff] transition-colors"
                        >
                            Entrar
                        </Link>
                        <Link
                            :href="route('register')"
                            class="group relative px-4 py-2 text-sm font-semibold text-white bg-gradient-to-br from-[#C1272D] via-[#2B4C7E] to-[#F4B41A] hover:opacity-90 rounded-full transition-all shadow-sm hover:shadow-md"
                        >
                            <span class="relative flex items-center space-x-1.5">
                                <span>Começar</span>
                                <ArrowRight class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" :stroke-width="2.5" />
                            </span>
                        </Link>
                    </template>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 rounded-full hover:bg-[#f6f8fa] dark:hover:bg-[#161b22] transition-colors"
                    aria-label="Toggle menu"
                >
                    <Menu v-if="!mobileMenuOpen" class="w-6 h-6 text-[#24292f] dark:text-[#e6edf3]" :stroke-width="2" />
                    <X v-else class="w-6 h-6 text-[#24292f] dark:text-[#e6edf3]" :stroke-width="2" />
                </button>
            </div>

            <!-- Mobile Search -->
            <transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 transform -translate-y-2"
                enter-to-class="opacity-100 transform translate-y-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 transform translate-y-0"
                leave-to-class="opacity-0 transform -translate-y-2"
            >
                <div
                    v-if="mobileSearchOpen"
                    class="md:hidden py-4 border-t border-[#d0d7de] dark:border-[#30363d]"
                >
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <Search class="w-4 h-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2.5" />
                        </div>
                        <input
                            type="search"
                            v-model="searchQuery"
                            @keydown.enter="handleSearch"
                            class="block w-full pl-10 pr-10 py-2.5 text-sm text-[#24292f] dark:text-[#e6edf3] bg-[#f6f8fa] dark:bg-[#161b22] border border-[#d0d7de] dark:border-[#30363d] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0969da] dark:focus:ring-[#1f6feb] focus:border-[#0969da] dark:focus:border-[#1f6feb] transition-all placeholder:text-[#656d76] dark:placeholder:text-[#7d8590]"
                            placeholder="Pesquisar..."
                            autocomplete="off"
                        />
                        <button
                            v-if="searchQuery"
                            @click="clearSearch"
                            class="absolute inset-y-0 right-0 flex items-center pr-4"
                            aria-label="Limpar pesquisa"
                        >
                            <X class="w-4 h-4 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2.5" />
                        </button>
                    </div>
                </div>
            </transition>

            <!-- Mobile Menu -->
            <transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 transform -translate-y-2"
                enter-to-class="opacity-100 transform translate-y-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 transform translate-y-0"
                leave-to-class="opacity-0 transform -translate-y-2"
            >
                <div
                    v-if="mobileMenuOpen"
                    class="lg:hidden py-4 space-y-1 border-t border-[#d0d7de] dark:border-[#30363d]"
                >
                    <Link
                        :href="route('home')"
                        @click="mobileMenuOpen = false"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#161b22] rounded-md transition-colors"
                    >
                        Início
                    </Link>

                    <Link
                        :href="route('feature')"
                        @click="mobileMenuOpen = false"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#161b22] rounded-md transition-colors"
                    >
                        Recursos
                    </Link>

                    <Link
                        :href="route('architecture')"
                        @click="mobileMenuOpen = false"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#161b22] rounded-md transition-colors"
                    >
                        Arquitetura
                    </Link>

                    <Link
                        :href="route('about')"
                        @click="mobileMenuOpen = false"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-[#24292f] dark:text-[#e6edf3] hover:bg-[#f6f8fa] dark:hover:bg-[#161b22] rounded-md transition-colors"
                    >
                        Sobre
                    </Link>

                    <!-- Mobile Account Section -->
                    <div class="px-4 py-3 bg-[#f6f8fa] dark:bg-[#161b22] rounded-md mt-2">
                        <p class="text-xs font-semibold text-[#656d76] dark:text-[#7d8590] mb-3">Conta</p>
                        
                        <div class="space-y-1" v-if="$page.props.auth?.user">
                            <Link
                                :href="route('dashboard')"
                                @click="mobileMenuOpen = false"
                                class="flex items-center px-3 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-white dark:hover:bg-[#21262d] rounded-md transition-colors"
                            >
                                <LayoutDashboard class="w-4 h-4 mr-2.5 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                Dashboard
                            </Link>
                            <Link
                                href="/profile"
                                @click="mobileMenuOpen = false"
                                class="flex items-center px-3 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-white dark:hover:bg-[#21262d] rounded-md transition-colors"
                            >
                                <User class="w-4 h-4 mr-2.5 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                Meu Perfil
                            </Link>
                        </div>

                        <div class="space-y-1" v-else>
                            <Link
                                :href="route('login')"
                                @click="mobileMenuOpen = false"
                                class="flex items-center px-3 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-white dark:hover:bg-[#21262d] rounded-md transition-colors"
                            >
                                <LogIn class="w-4 h-4 mr-2.5 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                Entrar
                            </Link>
                            <Link
                                :href="route('register')"
                                @click="mobileMenuOpen = false"
                                class="flex items-center px-3 py-2 text-sm text-[#24292f] dark:text-[#e6edf3] hover:bg-white dark:hover:bg-[#21262d] rounded-md transition-colors"
                            >
                                <UserPlus class="w-4 h-4 mr-2.5 text-[#656d76] dark:text-[#7d8590]" :stroke-width="2" />
                                Criar Conta
                            </Link>
                        </div>
                    </div>

                    <!-- Mobile Theme Switcher -->
                    <div class="px-4 py-3 bg-[#f6f8fa] dark:bg-[#161b22] rounded-md mt-2">
                        <p class="text-xs font-semibold text-[#656d76] dark:text-[#7d8590] mb-3">Tema</p>
                        <div class="flex items-center space-x-2">
                            <button
                                @click="setTheme('light')"
                                :class="[
                                    'flex-1 flex flex-col items-center justify-center px-3 py-2.5 text-xs font-medium rounded-md transition-all',
                                    theme === 'light'
                                        ? 'bg-white dark:bg-[#21262d] text-[#24292f] dark:text-[#e6edf3] shadow-sm ring-2 ring-[#0969da] dark:ring-[#1f6feb]'
                                        : 'text-[#656d76] dark:text-[#7d8590] hover:bg-white dark:hover:bg-[#21262d]'
                                ]"
                            >
                                <Sun class="w-5 h-5 mb-1" :stroke-width="2.5" />
                                <span>Luz</span>
                            </button>
                            <button
                                @click="setTheme('dark')"
                                :class="[
                                    'flex-1 flex flex-col items-center justify-center px-3 py-2.5 text-xs font-medium rounded-md transition-all',
                                    theme === 'dark'
                                        ? 'bg-white dark:bg-[#21262d] text-[#24292f] dark:text-[#e6edf3] shadow-sm ring-2 ring-[#0969da] dark:ring-[#1f6feb]'
                                        : 'text-[#656d76] dark:text-[#7d8590] hover:bg-white dark:hover:bg-[#21262d]'
                                ]"
                            >
                                <Moon class="w-5 h-5 mb-1" :stroke-width="2.5" />
                                <span>Escuro</span>
                            </button>
                            <button
                                @click="setTheme('system')"
                                :class="[
                                    'flex-1 flex flex-col items-center justify-center px-3 py-2.5 text-xs font-medium rounded-md transition-all',
                                    theme === 'system'
                                        ? 'bg-white dark:bg-[#21262d] text-[#24292f] dark:text-[#e6edf3] shadow-sm ring-2 ring-[#0969da] dark:ring-[#1f6feb]'
                                        : 'text-[#656d76] dark:text-[#7d8590] hover:bg-white dark:hover:bg-[#21262d]'
                                ]"
                            >
                                <Monitor class="w-5 h-5 mb-1" :stroke-width="2.5" />
                                <span>Sistema</span>
                            </button>
                        </div>
                    </div>

                    <div class="h-px bg-[#d0d7de] dark:bg-[#30363d] my-3"></div>

                    <Link
                        v-if="$page.props.auth?.user"
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="flex items-center w-full px-4 py-2.5 text-sm font-medium text-[#cf222e] dark:text-[#f85149] hover:bg-[#fff1f0] dark:hover:bg-[#1a1f28] rounded-md transition-colors"
                    >
                        <LogOut class="w-4 h-4 mr-2.5" :stroke-width="2" />
                        Sair
                    </Link>
                    <Link
                        v-else
                        :href="route('register')"
                        class="block px-4 py-2.5 text-sm font-semibold text-center text-white bg-gradient-to-br from-[#C1272D] via-[#2B4C7E] to-[#F4B41A] hover:opacity-90 rounded-full transition-all shadow-sm mt-2"
                    >
                        Começar Agora
                    </Link>
                </div>
            </transition>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';
import { 
    Menu, 
    X, 
    ArrowRight, 
    Search, 
    ChevronDown, 
    Sun, 
    Moon, 
    Monitor,
    User,
    Settings,
    LogOut,
    LogIn,
    UserPlus,
    LayoutDashboard
} from 'lucide-vue-next';
import AppLogoIcon from './AppLogoIcon.vue';

const mobileMenuOpen = ref(false);
const mobileSearchOpen = ref(false);
const accountDropdownOpen = ref(false);
const scrolled = ref(false);
const searchQuery = ref('');
const searchFocused = ref(false);
const theme = ref<'light' | 'dark' | 'system'>('system');
const accountDropdownRef = ref<HTMLElement | null>(null);

const handleScroll = () => {
    scrolled.value = window.scrollY > 10;
};

const handleSearch = () => {
    if (searchQuery.value.trim()) {
        console.log('Pesquisando:', searchQuery.value);
        // Implementar lógica de pesquisa
        // Exemplo: router.get('/search', { q: searchQuery.value });
    }
};

const clearSearch = () => {
    searchQuery.value = '';
    searchFocused.value = false;
};

const setTheme = (newTheme: 'light' | 'dark' | 'system') => {
    theme.value = newTheme;
    localStorage.setItem('theme', newTheme);
    applyTheme(newTheme);
};

const applyTheme = (themeToApply: 'light' | 'dark' | 'system') => {
    const root = document.documentElement;
    
    if (themeToApply === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDark) {
            root.classList.add('dark');
        } else {
            root.classList.remove('dark');
        }
    } else if (themeToApply === 'dark') {
        root.classList.add('dark');
    } else {
        root.classList.remove('dark');
    }
};

const handleClickOutside = (event: MouseEvent) => {
    if (accountDropdownRef.value && !accountDropdownRef.value.contains(event.target as Node)) {
        accountDropdownOpen.value = false;
    }
};

onMounted(() => {
    // Carrega tema salvo
    const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | 'system' | null;
    if (savedTheme) {
        theme.value = savedTheme;
        applyTheme(savedTheme);
    } else {
        applyTheme('system');
    }

    // Event listeners
    window.addEventListener('scroll', handleScroll);
    document.addEventListener('click', handleClickOutside);

    // Keyboard shortcut: Cmd/Ctrl + K
    const handleKeyDown = (e: KeyboardEvent) => {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.getElementById('navbar-search') as HTMLInputElement;
            if (searchInput) {
                searchInput.focus();
            } else {
                mobileSearchOpen.value = true;
            }
        }
        // ESC para fechar dropdown
        if (e.key === 'Escape') {
            accountDropdownOpen.value = false;
        }
    };

    window.addEventListener('keydown', handleKeyDown);

    // Monitor system theme changes
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    const handleThemeChange = () => {
        if (theme.value === 'system') {
            applyTheme('system');
        }
    };
    mediaQuery.addEventListener('change', handleThemeChange);

    return () => {
        window.removeEventListener('scroll', handleScroll);
        window.removeEventListener('keydown', handleKeyDown);
        document.removeEventListener('click', handleClickOutside);
        mediaQuery.removeEventListener('change', handleThemeChange);
    };
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('click', handleClickOutside);
});
</script>