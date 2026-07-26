<script setup lang="ts">
import ProjectCard from '@/components/ui/ProjectCard.vue';
import SectionTitle from '@/components/ui/SectionTitle.vue';
import TabButton from '@/components/ui/TabButton.vue';
import { computed, ref } from 'vue';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

type ProjectType = 'IT' | 'NON_IT';
type Project = {
    type: ProjectType;
    title: string;
    description: string;
    detail?: string | null;
    category?: string | null;
    stack?: string[];
    thumbnail?: string | null;
    images?: string[];
    projectUrl?: string | null;
    repositoryUrl?: string | null;
};

const props = defineProps<{
    projects?: Project[];
}>();

const activeType = ref<ProjectType>('IT');
const selectedProject = ref<Project | null>(null);
const selectedImageIndex = ref(0);

const fallbackProjects = [
    {
        type: 'IT',
        title: 'Beswan E-Learning',
        description: 'Learning platform concept with course materials, student access, and practical dashboard workflows.',
        detail:
            'A static preview for an e-learning idea focused on course discovery, learner progress, admin-friendly content management, and practical dashboard flows that can later be connected to Laravel APIs.',
        category: 'IT',
        stack: ['Laravel', 'Vue', 'MySQL'],
        thumbnail: '/images/project/project_1_1.png',
    },
    {
        type: 'IT',
        title: 'Mentoring Web',
        description: 'Mentoring web concept with Laravel API, Vue interface, token authentication, and guided sessions.',
        detail:
            'A mentoring platform concept for arranging sessions, protecting user areas with token authentication, and separating frontend interaction from Laravel API responsibilities.',
        category: 'IT',
        stack: ['Laravel API', 'Vue', 'JWT'],
        thumbnail: '/images/project/project_1_2.png',
    },
    {
        type: 'IT',
        title: 'CMS Project',
        description: 'Content management dashboard for structured publishing and admin-side data management.',
        detail:
            'A CMS-style dashboard concept with structured content editing, admin navigation, reusable layout sections, and a path toward CRUD-backed Laravel modules.',
        category: 'IT',
        stack: ['Laravel', 'AdminLTE'],
        thumbnail: '/images/project/project_2_1.png',
    },
    {
        type: 'NON_IT',
        title: 'Artikel Budaya',
        description: 'Short-form cultural writing that documents heritage, local memory, and everyday interpretation.',
        detail:
            'A writing collection concept for cultural notes, local history, observation, and reflective interpretation outside software development work.',
        category: 'Non-IT',
        thumbnail: '/images/component/Pattern.jpg',
    },
    {
        type: 'NON_IT',
        title: 'Tulisan Reflektif',
        description: 'Personal essays about learning, discipline, identity, and small observations from daily life.',
        detail:
            'A personal archive for reflection pieces, opinions, and essays that help preserve thought process, growth, and everyday lessons.',
        category: 'Non-IT',
        thumbnail: '/images/project/project_2_2.png',
    },
    {
        type: 'NON_IT',
        title: 'Dokumentasi Organisasi',
        description: 'Visual notes and written documentation from organization activities and collaborative events.',
        detail:
            'A documentation concept for organization activities, event memories, visual records, and collaborative experience outside formal project work.',
        category: 'Non-IT',
        thumbnail: '/images/component/Profile.png',
    },
] satisfies Project[];

const projectItems = computed(() => (props.projects?.length ? props.projects : fallbackProjects));
const filteredProjects = computed(() => projectItems.value.filter((project) => project.type === activeType.value));
const selectedImages = computed(() => {
    if (!selectedProject.value) return [];
    const values = selectedProject.value.images?.length
        ? selectedProject.value.images
        : [selectedProject.value.thumbnail || '/images/project/project_1_1.png'];
    return [...new Set(values.filter(Boolean))];
});

const openProject = (project: Project) => {
    selectedProject.value = project;
    selectedImageIndex.value = 0;
};

const changeSelectedImage = (direction: number) => {
    selectedImageIndex.value = (selectedImageIndex.value + direction + selectedImages.value.length) % selectedImages.value.length;
};
</script>

<template>
    <section id="project" class="portfolio-section pattern-parallax scroll-mt-24 lg:min-h-screen lg:py-32">
        <div class="scroll-reveal mx-auto w-full max-w-7xl">
            <div class="flex flex-col items-center gap-4 text-center mb-2">
                <SectionTitle title="Project" subtitle="A mix of software projects and non-IT creative documentation." align="center" />
                <div class="flex gap-3 overflow-x-auto pb-2 md:pb-0">
                    <TabButton variant="compact" :active="activeType === 'IT'" @click="activeType = 'IT'">IT</TabButton>
                    <TabButton variant="compact" :active="activeType === 'NON_IT'" @click="activeType = 'NON_IT'">Non-IT</TabButton>
                </div>
            </div>

            <Swiper
                :key="activeType"
                :space-between="24"
                :grab-cursor="true"
                :breakpoints="{ 0: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }"
                class="project-swiper"
            >
                <SwiperSlide v-for="project in filteredProjects" :key="project.title" class="h-auto">
                    <div role="button" tabindex="0" class="h-full w-full cursor-pointer text-left" @click="openProject(project)" @keydown.enter="openProject(project)">
                        <ProjectCard :project="project" />
                    </div>
                </SwiperSlide>
            </Swiper>
        </div>

        <Teleport to="body">
            <div v-if="selectedProject" class="fixed inset-0 z-[80] flex items-center justify-center bg-black/75 p-5 backdrop-blur-md" @click.self="selectedProject = null">
                <article class="max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-[8px] border border-white/10 bg-[#242429] shadow-2xl shadow-black/50">
                    <div class="grid md:grid-cols-[1.1fr_0.9fr]">
                        <div class="relative flex min-h-[360px] items-center bg-black p-4">
                            <img :src="selectedImages[selectedImageIndex]" :alt="`${selectedProject.title} ${selectedImageIndex + 1}`" class="h-full max-h-[560px] w-full object-contain" />
                            <template v-if="selectedImages.length > 1">
                                <button type="button" aria-label="Gambar sebelumnya" class="absolute left-5 top-1/2 -translate-y-1/2 rounded-full bg-white/15 p-2 text-white hover:bg-white/25" @click="changeSelectedImage(-1)">
                                    <ChevronLeft class="h-5 w-5" />
                                </button>
                                <button type="button" aria-label="Gambar berikutnya" class="absolute right-5 top-1/2 -translate-y-1/2 rounded-full bg-white/15 p-2 text-white hover:bg-white/25" @click="changeSelectedImage(1)">
                                    <ChevronRight class="h-5 w-5" />
                                </button>
                                <p class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-black/70 px-3 py-1 text-xs text-white">
                                    {{ selectedImageIndex + 1 }} / {{ selectedImages.length }}
                                </p>
                            </template>
                        </div>
                        <div class="space-y-5 p-7 md:p-9">
                            <div class="flex items-start justify-between gap-5">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-portfolio-accent">{{ selectedProject.category }}</p>
                                    <h3 class="mt-3 font-serif text-4xl font-semibold leading-tight text-white">{{ selectedProject.title }}</h3>
                                </div>
                                <button type="button" class="rounded-full border border-white/10 px-3 py-1 text-sm text-portfolio-muted hover:text-white" @click="selectedProject = null">
                                    Close
                                </button>
                            </div>
                            <p class="text-base leading-7 text-portfolio-muted">{{ selectedProject.detail || selectedProject.description }}</p>
                            <div v-if="selectedProject.stack?.length" class="flex flex-wrap gap-2">
                                <span v-for="item in selectedProject.stack" :key="item" class="rounded-full bg-white/10 px-3 py-1 text-xs text-portfolio-muted">
                                    {{ item }}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-3" v-if="selectedProject.projectUrl || selectedProject.repositoryUrl">
                                <a v-if="selectedProject.projectUrl" :href="selectedProject.projectUrl" class="rounded-full border border-white/10 px-4 py-2 text-sm text-portfolio-muted hover:text-white">
                                    View Project
                                </a>
                                <a v-if="selectedProject.repositoryUrl" :href="selectedProject.repositoryUrl" class="rounded-full border border-white/10 px-4 py-2 text-sm text-portfolio-muted hover:text-white">
                                    Repository
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </Teleport>
    </section>
</template>
