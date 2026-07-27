<script setup lang="ts">
import CircularGallery from '@/components/ui/CircularGallery.vue';
import SectionTitle from '@/components/ui/SectionTitle.vue';
import { computed, ref } from 'vue';

const props = defineProps<{
    items?: Array<{
        image: string;
        title: string;
        description?: string | null;
        altText?: string | null;
        category?: string | null;
    }>;
}>();

const fallbackGallery = [
    { image: '/images/component/Profile.webp', title: 'Profile Portrait', description: 'Portrait image used as the main visual identity for the portfolio hero.' },
    { image: '/images/component/Pattern.webp', title: 'Ethnic Pattern', description: 'Background motif that gives the page its ethnic and personal visual character.' },
    { image: '/images/project/project_1_1.webp', title: 'Project Preview 1', description: 'Interface preview from an IT project archive.' },
    { image: '/images/project/project_1_2.webp', title: 'Project Preview 2', description: 'Second project image used as portfolio documentation.' },
    { image: '/images/project/project_2_1.webp', title: 'Project Preview 3', description: 'Dashboard-style visual documentation for project presentation.' },
    { image: '/images/project/project_2_2.webp', title: 'Project Preview 4', description: 'Additional project image for visual context and archive.' },
];

const gallery = computed(() => (props.items?.length ? props.items : fallbackGallery));
const selectedGallery = ref<(typeof fallbackGallery)[number] | null>(null);
</script>

<template>
    <section id="gallery" class="gallery-solid-section portfolio-section scroll-mt-24 lg:min-h-[85vh] lg:py-32">
        <div class="scroll-reveal mx-auto w-full max-w-7xl">
            <SectionTitle title="Gallery" subtitle="A simple archive of visual moments, activities, and experiments." align="center" />

            <CircularGallery :items="gallery" @select="selectedGallery = $event" />
        </div>

        <Teleport to="body">
            <div v-if="selectedGallery" class="fixed inset-0 z-[90] flex items-center justify-center bg-black/80 p-5 backdrop-blur-md" role="dialog" aria-modal="true" :aria-label="`Preview gallery ${selectedGallery.title}`" @click.self="selectedGallery = null">
                <article class="max-h-[92vh] w-full max-w-5xl overflow-y-auto rounded-[8px] border border-white/10 bg-[#242429] p-5 shadow-2xl shadow-black/60 md:p-7">
                    <div class="flex items-start justify-between gap-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-portfolio-accent">Gallery Detail</p>
                            <h3 class="mt-2 font-serif text-3xl font-semibold text-white">{{ selectedGallery.title }}</h3>
                        </div>
                        <button type="button" class="rounded-full border border-white/10 px-3 py-1 text-sm text-portfolio-muted hover:text-white" @click="selectedGallery = null">
                            Close
                        </button>
                    </div>
                    <div class="mt-6 flex min-h-[280px] items-center justify-center rounded-[8px] bg-black p-3">
                        <img :src="selectedGallery.image" :alt="selectedGallery.altText || selectedGallery.title" class="max-h-[68vh] max-w-full object-contain" />
                    </div>
                    <p class="mt-5 text-base leading-7 text-portfolio-muted">{{ selectedGallery.description }}</p>
                </article>
            </div>
        </Teleport>
    </section>
</template>
