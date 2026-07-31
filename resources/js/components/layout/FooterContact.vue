<script setup lang="ts">
import { Github, Instagram, Linkedin, Mail, MessageCircle } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    profile?: {
        email?: string | null;
        phone?: string | null;
        instagramUrl?: string | null;
        linkedinUrl?: string | null;
        githubUrl?: string | null;
    } | null;
    settings?: Record<string, string | null>;
}>();

const emailHref = computed(() => {
    const email = props.profile?.email?.trim() || 'hello@example.com';

    return email.startsWith('mailto:') ? email : `mailto:${email}`;
});

const whatsappHref = computed(() => {
    const phone = props.profile?.phone?.trim();

    if (!phone) {
        return null;
    }

    const digits = phone.replace(/\D/g, '');
    const internationalNumber = digits.startsWith('0') ? `62${digits.slice(1)}` : digits;

    return `https://wa.me/${internationalNumber}`;
});

const socialAccount = (value: string | null | undefined, prefix = '') => {
    const account = value?.trim();

    if (!account || account === '#') {
        return 'Belum diatur';
    }

    try {
        const url = new URL(account.startsWith('http') ? account : `https://${account}`);
        const path = url.pathname.replace(/^\/+|\/+$/g, '');
        const username = path.split('/').filter(Boolean).pop();

        return username ? `${prefix}${username}` : url.hostname.replace(/^www\./, '');
    } catch {
        return account;
    }
};

const contacts = computed(() =>
    [
        {
            label: 'Instagram',
            account: socialAccount(props.profile?.instagramUrl, '@'),
            href: props.profile?.instagramUrl || '#',
            icon: Instagram,
        },
        {
            label: 'LinkedIn',
            account: socialAccount(props.profile?.linkedinUrl),
            href: props.profile?.linkedinUrl || '#',
            icon: Linkedin,
        },
        {
            label: 'GitHub',
            account: socialAccount(props.profile?.githubUrl, '@'),
            href: props.profile?.githubUrl || '#',
            icon: Github,
        },
        {
            label: 'Gmail',
            account: props.profile?.email?.replace(/^mailto:/, '') || 'hello@example.com',
            href: emailHref.value || '#',
            icon: Mail,
        },
        {
            label: 'WhatsApp',
            account: props.profile?.phone || 'Nomor WhatsApp belum tersedia',
            href: whatsappHref.value,
            icon: MessageCircle,
        },
    ],
);

const footerHeading = computed(() => props.settings?.footer_heading || "Let's connect and build something thoughtful.");
</script>

<template>
    <footer id="contact" class="scroll-mt-24 border-t bg-[#D9D9D9]/30 px-5 py-16 md:px-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-8 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-portfolio-accent text-xs font-semibold uppercase tracking-[0.28em]">Contact</p>
                <h2 class="mt-3 font-serif text-3xl font-semibold text-white">{{ footerHeading }}</h2>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap">
                <a
                    v-for="contact in contacts"
                    :key="contact.label"
                    :href="contact.href"
                    :title="contact.account"
                    :aria-label="`${contact.label}: ${contact.account}`"
                    class="text-portfolio-muted group relative inline-flex items-center justify-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-3 text-sm transition hover:border-[#c9b27c]/70 hover:text-white"
                >
                    <component :is="contact.icon" class="h-4 w-4" />
                    {{ contact.label }}
                    <span
                        role="tooltip"
                        class="pointer-events-none absolute -top-10 left-1/2 z-10 -translate-x-1/2 whitespace-nowrap rounded-md bg-black px-2.5 py-1.5 text-xs text-white opacity-0 shadow-lg transition group-hover:opacity-100 group-focus-visible:opacity-100"
                    >
                        {{ contact.account }}
                    </span>
                </a>
            </div>
        </div>
    </footer>
</template>
