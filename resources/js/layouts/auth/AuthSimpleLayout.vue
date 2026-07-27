<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="relative flex min-h-svh flex-col items-center justify-center overflow-hidden bg-[#1c1c20] p-6 text-white md:p-10">
        <div class="absolute inset-0 opacity-20 [background-image:url('/images/component/Pattern.webp')] [background-size:620px_auto] [background-position:center]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_10%,rgba(201,178,124,0.22),transparent_34%),linear-gradient(180deg,rgba(28,28,32,0.7),#1c1c20)]"></div>

        <div class="relative z-10 w-full max-w-md rounded-[8px] border border-white/10 bg-white/10 p-6 shadow-2xl shadow-black/30 backdrop-blur-md md:p-8">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="route('home')" class="flex flex-col items-center gap-2 font-medium">
                        <div class="mb-1 flex h-12 w-12 items-center justify-center rounded-full border border-[#c9b27c]/50 bg-black/20">
                            <AppLogoIcon class="size-8 fill-current text-white" />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="font-serif text-3xl font-semibold">{{ title }}</h1>
                        <p class="text-center text-sm text-[#d1d1d1]">{{ description }}</p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
