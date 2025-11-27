<script setup lang="ts">
import {
    Facebook,
    Instagram,
    Twitter,
    Youtube,
    Github,
    Mail,
    Send
} from 'lucide-vue-next';
import BackgroundGradient from './ui/background-gradient/BackgroundGradient.vue';
</script>

<template>
    <section class="relative isolate overflow-hidden bg-gray-900">
        <!-- Background gradient -->
        <BackgroundGradient />
        <footer class="pt-16 pb-7 ">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between pb-14 border-b border-gray-500 gap-8">
                    <a href="#home" class="flex items-center group cursor-pointer">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#C1272D] via-[#2B4C7E] to-[#F4B41A] rounded-lg flex items-center justify-center">
                            <img src="\img\logo\ippls-logo.jpg" alt="IPPLS" class="w-full h-auto rounded-md" />
                        </div>
                        <div class="ml-3 flex flex-col">
                            <span class="text-xl font-bold text-white">IPPLS</span>
                            <span class="text-xs text-gray-400">Arquitetura de Projetos</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-4">
                        <a
                            href="https://facebook.com"
                            target="_blank"
                            class="p-3 rounded-full bg-white text-gray-700 group transition-all duration-500 hover:bg-[#F4B41A] hover:text-white focus:outline-none focus:bg-[#F4B41A] focus:text-white"
                        >
                            <Facebook class="w-5 h-5" :stroke-width="2" />
                        </a>
                        <a
                            href="https://instagram.com"
                            target="_blank"
                            class="p-3 rounded-full bg-white text-gray-900 group transition-all duration-500 hover:bg-[#F4B41A] hover:text-white focus:outline-none focus:bg-[#F4B41A] focus:text-white"
                        >
                            <Instagram class="w-5 h-5" :stroke-width="2" />
                        </a>
                        <a
                            href="https://twitter.com"
                            target="_blank"
                            class="p-3 rounded-full bg-white text-gray-700 group transition-all duration-500 hover:bg-[#F4B41A] hover:text-white focus:outline-none focus:bg-[#F4B41A] focus:text-white"
                        >
                            <Twitter class="w-5 h-5" :stroke-width="2" />
                        </a>
                        <a
                            href="https://youtube.com"
                            target="_blank"
                            class="p-3 rounded-full bg-white text-gray-700 group transition-all duration-500 hover:bg-[#F4B41A] hover:text-white focus:outline-none focus:bg-[#F4B41A] focus:text-white"
                        >
                            <Youtube class="w-5 h-5" :stroke-width="2" />
                        </a>
                        <a
                            href="https://github.com/Ngola-develop/arquitetura-de-projetos-ippls"
                            target="_blank"
                            class="p-3 rounded-full bg-white text-gray-700 group transition-all duration-500 hover:bg-[#2B4C7E] hover:text-white focus:outline-none focus:bg-[#2B4C7E] focus:text-white"
                        >
                            <Github class="w-5 h-5" :stroke-width="2" />
                        </a>
                    </div>
                </div>

                <div class="py-14 flex flex-col lg:flex-row justify-between gap-8 border-b border-gray-500">
                    <div class="w-full flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6 md:gap-12 lg:gap-24">
                        <div>
                            <h6 class="text-lg font-medium text-white mb-7 text-center sm:text-left">Plataforma</h6>
                            <ul class="flex flex-col items-center sm:items-start gap-6">
                                <li><a href="#home" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Início</a></li>
                                <li><a href="#features" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Funcionalidades</a></li>
                                <li><a href="#architecture" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Arquitetura</a></li>
                                <li><a href="#about" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Sobre</a></li>
                            </ul>
                        </div>

                        <div>
                            <h6 class="text-lg font-medium text-white mb-7 text-center sm:text-left">Templates</h6>
                            <ul class="flex flex-col items-center sm:items-start gap-6">
                                <li><a href="#architecture" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Base MVC</a></li>
                                <li><a href="#architecture" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Padrão MVC</a></li>
                                <li><a href="#architecture" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Avançado MVC</a></li>
                                <li><a href="https://github.com/Ngola-develop/arquitetura-de-projetos-ippls" target="_blank" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Documentação</a></li>
                            </ul>
                        </div>

                        <div>
                            <h6 class="text-lg font-medium text-white mb-7 text-center sm:text-left">Recursos</h6>
                            <ul class="flex flex-col items-center sm:items-start gap-6">
                                <li><a href="#contact" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Suporte</a></li>
                                <li><a href="https://github.com/Ngola-develop/arquitetura-de-projetos-ippls" target="_blank" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">GitHub</a></li>
                                <li><a href="#" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">Guia de Uso</a></li>
                                <li><a href="#" class="text-base font-normal text-gray-400 whitespace-nowrap transition-all duration-300 hover:text-[#F4B41A] focus:outline-none focus:text-[#F4B41A]">FAQ</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="w-full lg:max-w-md">
                        <h6 class="text-lg font-medium text-white mb-7 text-center lg:text-left">Receba Novidades</h6>
                        <div class="bg-gray-800 rounded-3xl p-5">
                            <form class="flex flex-col gap-5">
                                <div>
                                    <label class="flex items-center mb-2 text-gray-400 text-base font-medium">Email</label>
                                    <input
                                        type="email"
                                        class="block w-full px-5 py-3 text-lg font-normal shadow-xs text-white bg-transparent border border-gray-400 rounded-full placeholder-gray-400 focus:outline-none leading-relaxed focus:border-gray-300"
                                        placeholder="seu@email.com"
                                        required
                                    />
                                </div>
                                <div class="flex flex-col min-[540px]:flex-row items-center justify-between gap-3">
                                    <div class="flex items-start">
                                        <input
                                            id="newsletter-checkbox"
                                            type="checkbox"
                                            class="w-5 h-5 appearance-none cursor-pointer border border-gray-600 bg-transparent rounded-md mr-2 hover:border-gray-400 hover:bg-gray-900 checked:bg-no-repeat checked:bg-center checked:border-gray-400 checked:bg-gray-800"
                                            checked
                                        />
                                        <label for="newsletter-checkbox" class="text-sm font-normal cursor-pointer text-gray-400">
                                            Concordo com a
                                            <a href="#" class="text-[#F4B41A] hover:underline">Política de Privacidade</a>
                                        </label>
                                    </div>
                                    <button
                                        type="submit"
                                        class="text-white text-base font-semibold py-3 px-7 rounded-full cursor-pointer bg-gradient-to-br from-[#C1272D] via-[#2B4C7E] to-[#F4B41A] transition-all duration-500 hover:bg-white hover:text-gray-300 flex items-center gap-2"
                                    >
                                        <Send class="w-4 h-4" :stroke-width="2" />
                                        <span>Enviar</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-5 pt-7">
                    <span class="text-sm font-normal text-gray-400">
                        © 2025
                        <a href="https://ippls.ao" class="text-white hover:text-[#F4B41A] transition-colors">IPPLS</a>. Todos os direitos reservados.
                    </span>

                    <button
                        type="button"
                        class="relative text-gray-500 focus:text-gray-900 flex items-center gap-2 px-6 py-3 text-base font-normal shadow-xs text-gray-50 bg-transparent border border-gray-700 rounded-full hover:border-gray-500 focus:outline-none leading-relaxed transition-all duration-500"
                    >
                        <Mail class="w-5 h-5" :stroke-width="2" />
                        <span>Tem dúvidas? Fale conosco</span>
                    </button>
                </div>
            </div>
        </footer>
    </section>
</template>

