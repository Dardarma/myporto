<script setup lang="ts">
import SectionTitle from '@/components/ui/SectionTitle.vue';
import { computed } from 'vue';

const props = defineProps<{
    experiences?: Array<{
        companyName: string;
        position: string;
        startDate?: string | null;
        endDate?: string | null;
        isCurrent?: boolean;
        location?: string | null;
        description?: string | null;
        logo?: string | null;
    }>;
}>();

const fallbackExperiences = [
    {
        companyName: 'PT ALFAHUMA REKAYASA TECHNOLOGI',
        position: 'Intern Programer',
        startDate: '2024-06-01',
        endDate: '2024-12-31',
        isCurrent: false,
        location: 'Lamongan',
        description: 'Lorem ipsum',
        logo: '/images/company/logo.webp',
    },
];

const experiences = computed(() => (props.experiences?.length ? props.experiences : fallbackExperiences));

const formatPeriod = (experience: (typeof fallbackExperiences)[number]) => {
    const start = experience.startDate ? new Date(experience.startDate).toLocaleDateString('en-US', { month: 'long', year: 'numeric' }) : '';
    const end = experience.isCurrent ? 'Present' : experience.endDate ? new Date(experience.endDate).toLocaleDateString('en-US', { month: 'long', year: 'numeric' }) : '';

    return [start, end].filter(Boolean).join(' - ');
};
</script>

<template>
    <section id="experience" class="portfolio-section pattern-parallax scroll-mt-24 lg:min-h-[75vh] lg:py-28">
        <div class="scroll-reveal mx-auto w-full max-w-7xl">
            <SectionTitle title="Experience" align="center" />

            <article
                v-for="experience in experiences"
                :key="`${experience.companyName}-${experience.position}`"
                class="mx-auto flex max-w-6xl flex-col items-center gap-6 rounded-[8px] bg-[rgba(70,70,78,0.88)] p-6 text-center shadow-2xl shadow-black/25 backdrop-blur sm:flex-row sm:text-left md:gap-8 md:p-9"
            >
                <div class="flex h-28 w-28 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#d9d9d9] p-4 md:h-32 md:w-32">
                    <img :src="experience.logo || '/images/company/logo.webp'" :alt="experience.companyName" class="h-full w-full object-contain" />
                </div>
                <div>
                    <h3 class="font-serif text-2xl font-semibold leading-tight text-white md:text-3xl">
                        {{ experience.companyName }}
                    </h3>
                    <p class="mt-1 text-sm font-semibold text-portfolio-muted md:text-base">{{ experience.position }} {{ formatPeriod(experience) }}</p>
                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-portfolio-muted">{{ experience.description }}</p>
                </div>
            </article>
        </div>
    </section>
</template>
