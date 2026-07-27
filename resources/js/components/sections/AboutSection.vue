<script setup lang="ts">
import TabButton from '@/components/ui/TabButton.vue';
import { computed, ref } from 'vue';

const props = defineProps<{
    items?: Array<{
        key: string;
        label: string;
        title: string;
        content: string;
    }>;
}>();

const fallbackTabs = [
    {
        key: 'projects',
        label: 'IT Projects',
        title: 'ABOUT ME',
        content:
            'I enjoy building Laravel and Vue projects, from information systems and CRUD workflows to dashboards and API integrations. My work usually starts from a practical problem, then becomes a clean interface that is easier to use and maintain.',
    },
    {
        key: 'writing',
        label: 'Writing',
        title: 'ABOUT ME',
        content:
            'Beyond IT, I like writing about history, culture, reflection, opinion, and personal notes. Writing helps me arrange ideas carefully and keep a more human rhythm inside technical work.',
    },
    {
        key: 'gallery',
        label: 'Gallery',
        title: 'ABOUT ME',
        content:
            'The gallery collects documentation from activities, organizations, trips, and personal moments. It is a visual archive of learning, people, and places that shape the story behind the portfolio.',
    },
];

const tabs = computed(() => (props.items?.length ? props.items : fallbackTabs));
const activeKey = ref(tabs.value[0].key);
const activeTab = computed(() => tabs.value.find((tab) => tab.key === activeKey.value) ?? tabs.value[0]);
</script>

<template>
    <section id="about" class="pattern-fade-from-dark portfolio-section pattern-parallax scroll-mt-24 lg:min-h-screen lg:py-32">
        <div class="scroll-reveal mx-auto w-full max-w-7xl">
            <div class="grid gap-6 lg:grid-cols-[360px_1fr]">
                <div class="flex gap-4 overflow-x-auto lg:flex-col lg:gap-7 lg:overflow-visible">
                    <TabButton v-for="tab in tabs" :key="tab.key" :active="activeKey === tab.key" @click="activeKey = tab.key">
                        {{ tab.label }}
                    </TabButton>
                </div>

                <article class="min-h-[420px] rounded-[8px] border border-white/10 bg-[rgba(70,70,78,0.86)] p-7 shadow-2xl shadow-black/25 backdrop-blur md:min-h-[540px] md:p-10">
                    <h2 class="font-serif text-4xl font-semibold text-white md:text-5xl">{{ activeTab.title }}</h2>
                    <p class="mt-6 max-w-3xl text-base leading-8 text-portfolio-muted md:text-lg">
                        {{ activeTab.content }}
                    </p>
                </article>
            </div>
        </div>
    </section>
</template>
