<script setup lang="ts">
</script>

<template>
    <section id="banner" class="hidden bg-[url('/img/banner/banner-ippls.gif')] bg-cover bg-center py-[28%] px-[35%] relative dark:shadow-luminous dark:block">
        <div class="max-w-full mx-auto">
        </div>
    </section>
</template>

<style scoped>
.dark section {
    background-image: url('/img/banner/banner-ippls-dar-mode.gif') !important;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    backdrop-filter: initial;
}

/* Sombra luminosa para dark mode */
.dark .shadow-luminous {
    box-shadow: 
        0 0 60px 20px rgba(10, 48, 110, 0.15),
        0 0 100px 40px rgba(49, 20, 117, 0.1),
        0 0 150px 60px rgba(126, 20, 73, 0.05),
        inset 0 0 80px 20px rgba(59, 130, 246, 0.1);
}

/* Alternativa com efeito de brilho mais suave */
.dark section::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: inherit;
    box-shadow: 
        0 0 80px 30px rgba(10, 62, 145, 0.2),
        0 0 120px 50px rgba(63, 26, 150, 0.15),
        inset 0 0 60px 15px rgba(20, 69, 148, 0.1);
    pointer-events: none;
    z-index: 1;
}
</style>