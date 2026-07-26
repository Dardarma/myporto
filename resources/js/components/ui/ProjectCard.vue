<script setup lang="ts">
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
    project: {
        title: string;
        description: string;
        category?: string | null;
        stack?: string[];
        thumbnail?: string | null;
        images?: string[];
    };
}>();

const activeImage = ref(0);
const images = computed(() => {
    const values = props.project.images?.length
        ? props.project.images
        : [props.project.thumbnail || '/images/project/project_1_1.png'];

    return [...new Set(values.filter(Boolean))];
});

const changeImage = (direction: number) => {
    activeImage.value = (activeImage.value + direction + images.value.length) % images.value.length;
};
</script>

<template>
    <article class="group h-full overflow-hidden rounded-[8px] border border-white/10 bg-[rgba(70,70,78,0.9)] shadow-xl shadow-black/25 backdrop-blur">
        <div class="relative aspect-[16/11] overflow-hidden bg-black">
            <img
                :src="images[activeImage]"
                :alt="project.title"
                class="h-full w-full object-contain transition duration-500"
                loading="lazy"
            />
            <template v-if="images.length > 1">
                <button type="button" aria-label="Gambar sebelumnya" class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-black/70 p-2 text-white hover:bg-black" @click.stop="changeImage(-1)">
                    <ChevronLeft class="h-4 w-4" />
                </button>
                <button type="button" aria-label="Gambar berikutnya" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-black/70 p-2 text-white hover:bg-black" @click.stop="changeImage(1)">
                    <ChevronRight class="h-4 w-4" />
                </button>
                <div class="absolute bottom-3 left-1/2 flex -translate-x-1/2 gap-1.5">
                    <span v-for="(_, index) in images" :key="index" :class="['h-1.5 w-1.5 rounded-full', index === activeImage ? 'bg-white' : 'bg-white/40']" />
                </div>
            </template>
        </div>
        <div class="min-h-[260px] space-y-4 bg-black/20 p-7">
            <div class="flex items-center justify-between gap-3">
                <span class="rounded-full border border-[#c9b27c]/40 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-portfolio-accent">
                    {{ project.category || 'Project' }}
                </span>
            </div>
            <h3 class="font-serif text-3xl font-semibold text-white">{{ project.title }}</h3>
            <p class="text-base leading-7 text-portfolio-muted">{{ project.description }}</p>
            <div v-if="project.stack?.length" class="flex flex-wrap gap-2">
                <span v-for="item in project.stack" :key="item" class="rounded-full bg-white/10 px-3 py-1 text-xs text-portfolio-muted">
                    {{ item }}
                </span>
            </div>
        </div>
    </article>
</template>
