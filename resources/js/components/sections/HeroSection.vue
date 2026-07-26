<script setup lang="ts">
import BeamsBackground from '@/components/ui/BeamsBackground.vue';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps<{
    profile?: {
        name: string;
        heroGreeting?: string | null;
        heroSlogan?: string | null;
        profileImage?: string | null;
    } | null;
}>();

const scrollY = ref(0);
const isMobile = ref(false);
let frameId = 0;

const updateViewport = () => {
    isMobile.value = window.innerWidth < 768;
};

const updateScroll = () => {
    if (frameId) {
        return;
    }

    frameId = window.requestAnimationFrame(() => {
        scrollY.value = window.scrollY;
        frameId = 0;
    });
};

const leftTextStyle = computed(() => ({
    transform: isMobile.value ? 'none' : `translateY(calc(-50% + ${scrollY.value * 0.06}px))`,
}));

const rightTextStyle = computed(() => ({
    transform: isMobile.value ? 'none' : `translateY(calc(-50% + ${scrollY.value * 0.08}px))`,
}));

const profileStyle = computed(() => ({
    transform: isMobile.value ? 'none' : `translateX(-50%) translateY(${scrollY.value * 0.12}px)`,
}));

const heroGreeting = computed(() => props.profile?.heroGreeting || 'HI I AM');
const greetingParts = computed(() => {
    const [first, ...rest] = heroGreeting.value.split(' ');

    return {
        first: first || 'HI',
        rest: rest.join(' ') || 'I AM',
    };
});
const heroSlogan = computed(() => props.profile?.heroSlogan || "It's ALL ABOUT E'MEEEH");
const sloganLines = computed(() => heroSlogan.value.split(' '));
const profileName = computed(() => props.profile?.name || 'Muhammad Rizki Darmawan');
const profileImage = computed(() => props.profile?.profileImage || '/images/component/Profile.png');

onMounted(() => {
    updateViewport();
    updateScroll();
    window.addEventListener('resize', updateViewport, { passive: true });
    window.addEventListener('scroll', updateScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('resize', updateViewport);
    window.removeEventListener('scroll', updateScroll);

    if (frameId) {
        window.cancelAnimationFrame(frameId);
    }
});
</script>

<template>
    <section id="home" class="relative h-screen min-h-screen w-full overflow-hidden bg-[#1c1c20]">
        <BeamsBackground />
        <div class="relative mx-auto flex h-full w-full max-w-[1440px] flex-col items-center justify-center px-5 pt-20 text-center md:block md:px-10 md:text-left lg:px-14">
            <div
                class="z-20 space-y-3 md:absolute md:left-[6%] md:top-[48%] md:max-w-[360px] lg:left-[8%] xl:left-[10%]"
                :style="leftTextStyle"
            >
                <div class="flex flex-col items-center gap-2 md:block">
                    <h1 class=" font-serif text-[clamp(5.5rem,19vw,8rem)] font-semibold leading-[0.78] text-white mb-8 md:text-[clamp(7rem,10vw,10rem)]">
                        {{ greetingParts.first }}
                    </h1>
                    <p class="font-serif text-4xl font-semibold leading-tight text-white md:ml-28 md:-mt-8 lg:text-5xl m">{{ greetingParts.rest }}</p>
                </div>
                <p class="mx-auto max-w-[300px] font-serif text-2xl leading-tight text-portfolio-muted md:mx-0">
                    {{ profileName }}
                </p>
            </div>

            <div
                class="relative z-10 mt-6 h-[52vh] min-h-[330px] w-[min(92vw,430px)] md:absolute md:bottom-0 md:left-1/2 md:mt-0 md:h-[80vh] md:min-h-[520px] md:max-h-[760px] md:w-[min(48vw,620px)]"
                :style="profileStyle"
            >
                <img
                    :src="profileImage"
                    :alt="profileName"
                    class="hero-profile-float h-full w-full object-contain object-bottom"
                />
            </div>

            <div
                class="z-20 mt-6 md:absolute md:right-[6%] md:top-[39%] md:mt-0 md:max-w-[330px] md:text-right lg:right-[8%] xl:right-[10%]"
                :style="rightTextStyle"
            >
                <p class="font-serif text-4xl font-semibold leading-[1.02] text-white sm:text-5xl md:text-6xl lg:text-7xl">
                    <template v-for="line in sloganLines" :key="line">
                        {{ line }}<br />
                    </template>
                </p>
            </div>
        </div>
    </section>
</template>
