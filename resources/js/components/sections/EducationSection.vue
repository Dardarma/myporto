<script setup lang="ts">
import SectionTitle from '@/components/ui/SectionTitle.vue';
import { computed } from 'vue';

const props = defineProps<{
    educations?: Array<{
        degree: string;
        institution: string;
        subtitle?: string | null;
        startYear?: number | null;
        endYear?: number | null;
        isCurrent?: boolean;
        description?: string | null;
        image?: string | null;
    }>;
}>();

const fallbackEducations = [
    {
        degree: 'D3 Informatics Engineering',
        institution: 'PENS PSDKU Lamongan',
        subtitle: 'D3 Informatic Engineering',
        startYear: 2023,
        endYear: null,
        isCurrent: true,
        description: 'Learning software fundamentals, web development, databases, and practical information system development.',
        image: '/images/education/Gambar%20WhatsApp%202025-11-25%20pukul%2011.26.52_79f73091.webp',
    },
];

const educations = computed(() => (props.educations?.length ? props.educations : fallbackEducations));
const subtitle = computed(() => educations.value[0]?.subtitle || 'D3 Informatic Engineering');

const yearRange = (education: (typeof fallbackEducations)[number]) => {
    if (!education.startYear) {
        return education.isCurrent ? 'Present' : '';
    }

    return `${education.startYear} - ${education.isCurrent ? 'Present' : education.endYear || ''}`;
};
</script>

<template>

    <section id="education" class="portfolio-section pattern-parallax scroll-mt-10 lg:min-h-[85vh] lg:py-32">
        <div class="scroll-reveal mx-auto w-full max-w-7xl">
            <SectionTitle title="EDUCATE" :subtitle="subtitle" align="center" />

            <article
                v-for="education in educations"
                :key="`${education.degree}-${education.institution}`"
                class="mx-auto grid max-w-4xl overflow-hidden rounded-[8px] border border-white/10 bg-[rgba(70,70,78,0.9)] shadow-2xl shadow-black/25 backdrop-blur md:grid-cols-[0.9fr_1.1fr] my-4"
            >
                <div class="min-h-[260px] bg-[#d9d9d9] p-3 md:min-h-[360px]">
                    <img
                        :src="education.image || '/images/education/Gambar%20WhatsApp%202025-11-25%20pukul%2011.26.52_79f73091.webp'"
                        :alt="education.institution"
                        class="h-full w-full rounded-[6px] object-cover"
                    />
                </div>
                <div class="flex flex-col justify-center p-8 text-center md:p-12 md:text-left">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-portfolio-accent">{{ yearRange(education) }}</p>
                    <h3 class="mt-4 font-serif text-3xl font-semibold text-white md:text-4xl">{{ education.degree }}</h3>
                    <p class="mt-3 text-base text-portfolio-muted md:text-lg">{{ education.institution }}</p>
                    <p class="mt-6 text-sm leading-7 text-portfolio-muted md:text-base">
                        {{ education.description }}
                    </p>
                </div>
            </article>
        </div>
    </section>
</template>
