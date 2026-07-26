<script setup lang="ts">
import { Menu, X } from 'lucide-vue-next';
import { ref } from 'vue';

const isOpen = ref(false);

const links = [
    { label: 'About', href: '#about' },
    { label: 'Edu', href: '#education' },
    { label: 'Experience', href: '#experience' },
    { label: 'Project', href: '#project' },
];

const closeMenu = () => {
    isOpen.value = false;
};
</script>

<template>
    <header class="fixed left-0 top-0 z-50 w-full bg-[#1b1b20]/85 backdrop-blur-xl">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 md:px-8">
            <a href="#home" class="font-serif text-xl font-semibold text-white md:hidden" @click="closeMenu">MRD</a>

            <div class="hidden items-center gap-7 md:flex">
                <a
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    class="text-base font-semibold text-portfolio-muted transition hover:text-white"
                >
                    {{ link.label }}
                </a>
            </div>

            <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/10 text-white md:hidden"
                aria-label="Toggle menu"
                @click="isOpen = !isOpen"
            >
                <X v-if="isOpen" class="h-5 w-5" />
                <Menu v-else class="h-5 w-5" />
            </button>
        </nav>

        <div v-if="isOpen" class="border-t border-white/10 bg-[#101013]/95 px-5 py-4 md:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-2">
                <a
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    class="rounded-[8px] px-4 py-3 text-sm font-medium text-portfolio-muted transition hover:bg-white/10 hover:text-white"
                    @click="closeMenu"
                >
                    {{ link.label }}
                </a>
            </div>
        </div>
    </header>
</template>
