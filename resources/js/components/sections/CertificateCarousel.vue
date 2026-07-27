<script setup lang="ts">
import CertificateCard from '@/components/ui/CertificateCard.vue';
import SectionTitle from '@/components/ui/SectionTitle.vue';
import { EffectCoverflow } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/effect-coverflow';
import { computed, ref } from 'vue';

type Certificate = {
    image?: string | null;
    title: string;
    issuer?: string | null;
    year?: string | null;
    credentialUrl?: string | null;
};

const props = defineProps<{ certificates?: Certificate[] }>();

const fallbackCertificates = [
    { image: '/images/certificate/Certificate_1.webp', title: 'Frontend Development Fundamentals', issuer: 'Learning Partner', year: '2024' },
    { image: '/images/certificate/Certificate_2.webp', title: 'Laravel Web Application', issuer: 'Tech Course', year: '2024' },
    { image: '/images/certificate/Certificate_3.webp', title: 'Database and API Practice', issuer: 'Campus Program', year: '2025' },
    { image: '/images/certificate/Certificate_4.webp', title: 'UI Design Exploration', issuer: 'Creative Class', year: '2025' },
    { image: '/images/certificate/Certificate_1.webp', title: 'Cultural Documentation', issuer: 'Personal Archive', year: '2026' },
];

const certificateItems = computed(() => (props.certificates?.length ? props.certificates : fallbackCertificates));
const selectedCertificate = ref<Certificate | null>(null);
</script>

<template>
    <section id="certificate" class="pattern-parallax scroll-mt-10 overflow-hidden px-5 py-5 md:px-8 lg:py-14">
        <div class="scroll-reveal mx-auto w-full max-w-6xl">
            <SectionTitle title="Certificate" subtitle="Selected certificates and learning milestones." align="center" />

            <Swiper
                :modules="[EffectCoverflow]"
                :centered-slides="true"
                :slides-per-view="'auto'"
                :loop="true"
                :effect="'coverflow'"
                :coverflow-effect="{ rotate: 0, stretch: 110, depth: 240, modifier: 1.6, slideShadows: false }"
                :grab-cursor="true"
                class="certificate-swiper"
            >
                <SwiperSlide v-for="certificate in certificateItems" :key="certificate.title" class="certificate-slide">
                    <button type="button" class="block w-full text-left" :aria-label="`Preview sertifikat ${certificate.title}`" @click="selectedCertificate = certificate">
                        <CertificateCard :certificate="certificate" />
                    </button>
                </SwiperSlide>
            </Swiper>
        </div>

        <Teleport to="body">
            <div v-if="selectedCertificate" class="fixed inset-0 z-[90] flex items-center justify-center bg-black/80 p-5 backdrop-blur-md" @click.self="selectedCertificate = null">
                <article class="max-h-[92vh] w-full max-w-5xl overflow-y-auto rounded-[8px] border border-white/10 bg-[#242429] p-5 shadow-2xl shadow-black/60 md:p-7">
                    <div class="flex items-start justify-between gap-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-portfolio-accent">Certificate Preview</p>
                            <h3 class="mt-2 font-serif text-3xl font-semibold text-white">{{ selectedCertificate.title }}</h3>
                            <p class="mt-1 text-sm text-portfolio-muted">{{ selectedCertificate.issuer }} · {{ selectedCertificate.year }}</p>
                        </div>
                        <button type="button" class="rounded-full border border-white/10 px-3 py-1 text-sm text-portfolio-muted hover:text-white" @click="selectedCertificate = null">Close</button>
                    </div>
                    <div class="mt-6 flex min-h-[320px] items-center justify-center rounded-[8px] bg-black p-3">
                        <img
                            :src="selectedCertificate.image || '/images/certificate/Certificate_1.webp'"
                            :alt="selectedCertificate.title"
                            class="max-h-[70vh] max-w-full object-contain"
                        />
                    </div>
                    <a
                        v-if="selectedCertificate.credentialUrl"
                        :href="selectedCertificate.credentialUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-5 inline-flex rounded-full border border-white/15 px-4 py-2 text-sm text-white hover:bg-white/10"
                    >
                        Lihat kredensial
                    </a>
                </article>
            </div>
        </Teleport>
    </section>
</template>
