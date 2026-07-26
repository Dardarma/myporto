<script setup lang="ts">
defineProps<{
    active?: boolean;
    variant?: 'large' | 'compact';
}>();
</script>

<template>
    <button
        type="button"
        :class="[
            'shrink-0 border font-semibold transition duration-200',
            variant === 'compact' ? 'rounded-[4px] px-8 py-1.5 text-sm' : 'rounded-[8px] px-8 py-5 font-serif text-2xl lg:min-h-[120px]',
            active
                ? 'border-white/10 bg-[#d9d9d9] text-[#1c1c20] shadow-lg shadow-black/30'
                : 'border-white/10 bg-portfolio-card text-white hover:border-[#c9b27c]/70',
        ]"
    >
        <slot />
    </button>
</template>
