<script setup lang="ts">
import FooterContact from '@/components/layout/FooterContact.vue';
import Navbar from '@/components/layout/Navbar.vue';
import AboutSection from '@/components/sections/AboutSection.vue';
import CertificateCarousel from '@/components/sections/CertificateCarousel.vue';
import EducationSection from '@/components/sections/EducationSection.vue';
import ExperienceSection from '@/components/sections/ExperienceSection.vue';
import GallerySection from '@/components/sections/GallerySection.vue';
import HeroSection from '@/components/sections/HeroSection.vue';
import ProjectSection from '@/components/sections/ProjectSection.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';

let revealObserver: IntersectionObserver | null = null;

defineProps<{
    profile?: {
        name: string;
        headline?: string | null;
        heroGreeting?: string | null;
        heroSlogan?: string | null;
        profileImage?: string | null;
        email?: string | null;
        phone?: string | null;
        instagramUrl?: string | null;
        linkedinUrl?: string | null;
        githubUrl?: string | null;
    } | null;
    aboutItems?: Array<{
        key: string;
        label: string;
        title: string;
        content: string;
    }>;
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
    certificates?: Array<{
        image?: string | null;
        title: string;
        issuer?: string | null;
        year?: string | null;
        credentialUrl?: string | null;
    }>;
    projects?: Array<{
        type: 'IT' | 'NON_IT';
        title: string;
        description: string;
        detail?: string | null;
        category?: string | null;
        stack?: string[];
        thumbnail?: string | null;
        projectUrl?: string | null;
        repositoryUrl?: string | null;
    }>;
    galleryItems?: Array<{
        image: string;
        title: string;
        description?: string | null;
        altText?: string | null;
        category?: string | null;
    }>;
    siteSettings?: Record<string, string | null>;
}>();

onMounted(() => {
    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver?.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.18,
            rootMargin: '0px 0px -10% 0px',
        },
    );

    document.querySelectorAll('.scroll-reveal').forEach((element) => {
        revealObserver?.observe(element);
    });
});

onUnmounted(() => {
    revealObserver?.disconnect();
});
</script>

<template>
    <Head title="Muhammad Rizki Darmawan" />

    <div class="portfolio-shell bg-portfolio text-portfolio-text min-h-screen">
        <div class="relative z-10">
            <Navbar />
            <main>
                <HeroSection :profile="profile" />
                <AboutSection :items="aboutItems" />
                <EducationSection :educations="educations" />
                <ExperienceSection :experiences="experiences" />
                <CertificateCarousel :certificates="certificates" />
                <ProjectSection :projects="projects" />
                <GallerySection :items="galleryItems" />
            </main>
            <FooterContact :profile="profile" :settings="siteSettings" />
        </div>
    </div>
</template>
