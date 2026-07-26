<script setup lang="ts">
import { Github, Instagram, Linkedin, Mail } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    profile?: {
        email?: string | null;
        instagramUrl?: string | null;
        linkedinUrl?: string | null;
        githubUrl?: string | null;
    } | null;
    settings?: Record<string, string | null>;
}>();

const contacts = computed(() => [
    { label: 'Instagram', href: props.profile?.instagramUrl || '#', icon: Instagram },
    { label: 'LinkedIn', href: props.profile?.linkedinUrl || '#', icon: Linkedin },
    { label: 'GitHub', href: props.profile?.githubUrl || '#', icon: Github },
    { label: 'Email', href: `mailto:${props.profile?.email || 'hello@example.com'}`, icon: Mail },
]);

const footerHeading = computed(() => props.settings?.footer_heading || "Let's connect and build something thoughtful.");
</script>

<template>
    <footer id="contact" class="scroll-mt-24 border-t bg-[#D9D9D9]/30 px-5 py-16 md:px-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-8 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-portfolio-accent">Contact</p>
                <h2 class="mt-3 font-serif text-3xl font-semibold text-white">{{ footerHeading }}</h2>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap">
                <a
                    v-for="contact in contacts"
                    :key="contact.label"
                    :href="contact.href"
                    class="inline-flex items-center justify-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-portfolio-muted transition hover:border-[#c9b27c]/70 hover:text-white"
                >
                    <component :is="contact.icon" class="h-4 w-4" />
                    {{ contact.label }}
                </a>
            </div>
        </div>
    </footer>
</template>
