<script setup lang="ts">
defineProps<{
    certificate: {
        image?: string | null;
        title: string;
        issuer?: string | null;
        year?: string | null;
    };
}>();
</script>

<template>
    <article class="h-fit overflow-hidden rounded-[8px] border border-white/10 bg-[rgba(70,70,78,0.9)] shadow-2xl shadow-black/30 backdrop-blur">
        <div class="aspect-[16/10] overflow-hidden bg-[#d9d9d9] p-2">
            <img :src="certificate.image || '/images/certificate/Certificate_1.webp'" :alt="certificate.title" class="h-full w-full object-contain" loading="lazy" />
        </div>
        <div class="space-y-1.5 p-4">
            <h3 class="line-clamp-2 font-serif text-xl font-semibold leading-tight text-white">
                {{ certificate.title }}
            </h3>
            <p class="text-sm text-portfolio-muted">{{ certificate.issuer }}</p>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-portfolio-accent">{{ certificate.year }}</p>
        </div>
    </article>
</template>
