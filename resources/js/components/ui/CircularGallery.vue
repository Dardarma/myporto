<script setup lang="ts">
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
    items: Array<{
        image: string;
        title: string;
        description?: string | null;
        altText?: string | null;
        category?: string | null;
    }>;
}>();

const emit = defineEmits<{
    select: [item: (typeof props.items)[number]];
}>();

const activeIndex = ref(0);
const dragStartX = ref(0);
const dragDeltaX = ref(0);
const isDragging = ref(false);
const didDrag = ref(false);
const itemCount = computed(() => Math.max(props.items.length, 1));

const rotatePrev = () => {
    activeIndex.value = (activeIndex.value - 1 + itemCount.value) % itemCount.value;
};

const rotateNext = () => {
    activeIndex.value = (activeIndex.value + 1) % itemCount.value;
};

const getItemStyle = (index: number) => {
    const step = 360 / itemCount.value;
    const dragAngle = dragDeltaX.value * 0.12;
    const angle = (index - activeIndex.value) * step + dragAngle;

    return {
        transform: `rotateY(${angle}deg) translateZ(clamp(220px, 36vw, 520px))`,
    };
};

const startDrag = (event: PointerEvent) => {
    isDragging.value = true;
    didDrag.value = false;
    dragStartX.value = event.clientX;
    dragDeltaX.value = 0;
};

const moveDrag = (event: PointerEvent) => {
    if (!isDragging.value) {
        return;
    }

    dragDeltaX.value = event.clientX - dragStartX.value;

    if (Math.abs(dragDeltaX.value) > 8) {
        didDrag.value = true;
    }
};

const endDrag = (event: PointerEvent) => {
    if (!isDragging.value) {
        return;
    }

    const threshold = 56;

    if (dragDeltaX.value > threshold) {
        rotatePrev();
    } else if (dragDeltaX.value < -threshold) {
        rotateNext();
    }

    isDragging.value = false;
    dragDeltaX.value = 0;
};

const selectItem = (item: (typeof props.items)[number], index: number) => {
    if (didDrag.value) {
        didDrag.value = false;
        return;
    }

    activeIndex.value = index;
    emit('select', item);
};
</script>

<template>
    <div class="circular-gallery">
        <div
            :class="['circular-gallery__stage', { 'is-dragging': isDragging }]"
            @pointerdown="startDrag"
            @pointermove="moveDrag"
            @pointerup="endDrag"
            @pointercancel="endDrag"
        >
            <div class="circular-gallery__ring">
                <button
                    v-for="(item, index) in items"
                    :key="item.image"
                    type="button"
                    :class="['circular-gallery__item', { 'is-active': index === activeIndex }]"
                    :style="getItemStyle(index)"
                    @click="selectItem(item, index)"
                >
                    <img :src="item.image" :alt="item.altText || item.title" loading="lazy" />
                    <span>{{ item.title }}</span>
                </button>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-center gap-3">
            <button type="button" class="circular-gallery__control" aria-label="Previous gallery item" @click="rotatePrev">
                <ChevronLeft class="h-5 w-5" />
            </button>
            <p class="min-w-[180px] text-center font-serif text-2xl font-semibold text-white">{{ items[activeIndex]?.title }}</p>
            <button type="button" class="circular-gallery__control" aria-label="Next gallery item" @click="rotateNext">
                <ChevronRight class="h-5 w-5" />
            </button>
        </div>
    </div>
</template>
