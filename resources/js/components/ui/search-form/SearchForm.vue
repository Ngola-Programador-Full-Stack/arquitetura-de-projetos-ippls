<script lang="ts" setup>
import { onMounted, ref } from 'vue'
const typewriter = ref<HTMLElement | null>(null)

const words = [
"Descobre os produtos ao melhor preço!",
"Explora novidades de novos produtos!",
"Confiança e qualidade em cada compra!",
"Aproveita todas ofertas imperdíveis!"
];

let i = 0;
let j = 0;
let isDeleting = false;

const type = () => {
const currentWord = words[i];

if (typewriter.value) {
    if (isDeleting) {
    j--;
    typewriter.value.textContent = currentWord.substring(0, j);
    if (j === 0) {
        isDeleting = false;
        i = (i + 1) % words.length;
        setTimeout(type, 1000); // pausa maior ao mudar palavra
        return;
    }
    } else {
    j++;
    typewriter.value.textContent = currentWord.substring(0, j);
    if (j === currentWord.length) {
        isDeleting = true;
        setTimeout(type, 1500); // pausa ao final da palavra
        return;
    }
    }
}

setTimeout(type, isDeleting ? 60 : 100); // velocidade ajustada
};

onMounted(() => {
type();
});

</script>
<template>

    <div class="shadow-lg rounded-lg pt-24 sm:pt-20 max-md:mt-2 lg:mt-35 bg-[url('https://pagedone.io/asset/uploads/1691055810.png')] bg-center bg-cover z-20 px-4 w-full max-w-3xl text-center">
        <div class="relative p-14 bottom-5 max-md:p-10 flex items-center justify-center">
            <h1
            ref="typewriter"
            class="absolute text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-[#ffdd00] leading-tight min-h-[3.5rem] sm:min-h-[4rem] md:min-h-[5rem] transition-all duration-200 ease-linear text-balance text-center break-words"
            ></h1>
        </div>


        <!-- Premium Description -->
        <div class="mb-8 text-center">
            <p class="text-xl md:text-2xl mb-4 text-white/90 font-light leading-relaxed">
                Pesquise, compare e compre com confiança na 
                <span class="font-semibold bg-gradient-to-r from-[#ffdd00] via-[#DAA520] to-[#ffdd00] bg-clip-text text-transparent">plataforma Anulika</span>
            </p>
            <!-- Premium Stats -->
            <div class="flex items-center justify-center gap-6 text-white/70 text-sm">
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span>+10k produtos</span>
                </div>
                <div class="w-px h-4 bg-white/30"></div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-[#ffdd00] rounded-full animate-pulse"></div>
                    <span>Entrega rápida</span>
                </div>
                <div class="w-px h-4 bg-white/30"></div>
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                    <span>Garantia total</span>
                </div>
            </div>
        </div>

        <!-- Ultra Premium Search Form -->
        <form action="/search" class="pb-4">
            <div class="relative max-w-2xl mx-auto">
                <!-- Background Glow -->
                <div class="absolute -inset-1 bg-gradient-to-r from-[#0061d6]/20 via-[#ffdd00]/20 to-[#0061d6]/20 rounded-3xl blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                
                <!-- Main Container -->
                <div class="relative flex flex-col md:flex-row items-center bg-white/95 backdrop-blur-xl rounded-3xl p-3 gap-3 shadow-2xl shadow-black/20 border border-white/20 hover:bg-white/98 transition-all duration-500 focus-within:shadow-3xl focus-within:bg-white">
                    
                    <!-- Search Icon (Left) -->
                    <div class="hidden md:flex items-center pl-2">
                        <svg class="w-5 h-5 text-gray-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <!-- Input Field -->
                    <input
                        id="search-bar"
                        name="q"
                        type="text"
                        placeholder="Descobrir produtos incríveis..."
                        class="flex-1 px-4 py-4 text-gray-800 placeholder:text-gray-400 bg-transparent outline-none text-lg font-medium transition-all duration-300 focus:placeholder:text-gray-300"
                        required
                    />
                    
                    <!-- Premium Search Button -->
                    <button
                        type="submit"
                        class="group relative overflow-hidden inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-[#0061d6] to-[#0056b3] text-white font-semibold rounded-2xl shadow-lg shadow-[#0061d6]/30 transition-all duration-500 hover:shadow-xl hover:shadow-[#0061d6]/40 hover:-translate-y-0.5 hover:scale-[1.02] active:scale-[0.98] w-full md:w-auto"
                    >
                        <!-- Button Shimmer Effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -skew-x-12 w-8 transition-transform duration-1000 group-hover:translate-x-40"></div>
                        
                        <!-- Button Content -->
                        <div class="relative flex items-center gap-2">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-[#ffdd00] font-bold tracking-wide">PESQUISAR</span>
                        </div>
                    </button>
                </div>
                
                <!-- Floating Suggestions (Optional Enhancement) -->
                <div class="absolute top-full left-0 right-0 mt-2 opacity-0 hover:opacity-100 transition-opacity duration-300">
                    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-4">
                        <div class="text-sm text-gray-600 mb-2 font-medium">Sugestões populares:</div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-gray-100 hover:bg-[#0061d6]/10 hover:text-[#0061d6] rounded-full text-sm cursor-pointer transition-all duration-300">iPhone</span>
                            <span class="px-3 py-1 bg-gray-100 hover:bg-[#0061d6]/10 hover:text-[#0061d6] rounded-full text-sm cursor-pointer transition-all duration-300">Roupa</span>
                            <span class="px-3 py-1 bg-gray-100 hover:bg-[#0061d6]/10 hover:text-[#0061d6] rounded-full text-sm cursor-pointer transition-all duration-300">Casa</span>
                            <span class="px-3 py-1 bg-gray-100 hover:bg-[#0061d6]/10 hover:text-[#0061d6] rounded-full text-sm cursor-pointer transition-all duration-300">Tecnologia</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<style scoped>

</style>
