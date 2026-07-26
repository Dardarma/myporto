<script setup lang="ts">
defineProps<{
    title: string;
    eyebrow?: string;
    subtitle?: string;
    align?: 'left' | 'center';
}>();
</script>

<template>
    <div :class="['mb-10', align === 'center' ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl']">
        <p v-if="eyebrow" class="mb-3 text-xs font-semibold uppercase tracking-[0.28em] text-portfolio-accent">
            {{ eyebrow }}
        </p>
        <h2 class="font-serif text-4xl font-semibold leading-tight text-white md:text-5xl">
            {{ title }}
        </h2>
        <p v-if="subtitle" class="mt-4 text-base leading-7 text-portfolio-muted md:text-lg">
            {{ subtitle }}
        </p>
    </div>
</template>
