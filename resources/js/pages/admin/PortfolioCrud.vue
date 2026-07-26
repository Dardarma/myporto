<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

type Field = {
    name: string;
    label: string;
    type: 'text' | 'email' | 'textarea' | 'number' | 'date' | 'boolean' | 'select' | 'image' | 'image_multiple';
    required?: boolean;
    options?: string[];
};

type RecordItem = Record<string, any> & { id: number };

const props = defineProps<{
    resource: string;
    resources: Array<{ key: string; label: string }>;
    config: {
        label: string;
        fields: Field[];
    };
    records: RecordItem[];
}>();

const editingRecord = ref<RecordItem | null>(null);
const isSingleton = computed(() => Boolean((props.config as { singleton?: boolean }).singleton));

const emptyValues = () =>
    props.config.fields.reduce<Record<string, any>>((values, field) => {
        values[field.name] = field.type === 'boolean' ? false : '';
        return values;
    }, {});

const form = useForm<Record<string, any>>(emptyValues());

const breadcrumbs = computed(() => [
    { title: 'Admin', href: '/admin/portfolio/profiles' },
    { title: props.config.label, href: `/admin/portfolio/${props.resource}` },
]);

const visibleColumns = computed(() => props.config.fields.slice(0, 4));

const resetForm = () => {
    editingRecord.value = null;
    form.defaults(emptyValues());
    form.reset();
    form.clearErrors();
};

const editRecord = (record: RecordItem) => {
    editingRecord.value = record;

    props.config.fields.forEach((field) => {
        form[field.name] = field.type === 'image' || field.type === 'image_multiple' ? null : (record[field.name] ?? (field.type === 'boolean' ? false : ''));
    });
};

watch(
    () => [props.resource, props.records],
    () => {
        resetForm();

        if (isSingleton.value && props.records[0]) {
            editRecord(props.records[0]);
        }
    },
    { immediate: true },
);

const submit = () => {
    if (editingRecord.value) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(`/admin/portfolio/${props.resource}/${editingRecord.value.id}`, {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                if (!isSingleton.value) {
                    resetForm();
                }
            },
        });
        return;
    }

    form.post(`/admin/portfolio/${props.resource}`, {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            if (!isSingleton.value) {
                resetForm();
            }
        },
    });
};

const selectImage = (event: Event, fieldName: string) => {
    const input = event.target as HTMLInputElement;
    form[fieldName] = input.files?.[0] ?? null;
};

const selectImages = (event: Event, fieldName: string) => {
    const input = event.target as HTMLInputElement;
    form[fieldName] = Array.from(input.files ?? []);
};

const destroyRecord = (record: RecordItem) => {
    if (!confirm(`Delete ${props.config.label} item #${record.id}?`)) {
        return;
    }

    router.delete(`/admin/portfolio/${props.resource}/${record.id}`, {
        preserveScroll: true,
    });
};

const displayValue = (value: unknown) => {
    if (typeof value === 'boolean') {
        return value ? 'Yes' : 'No';
    }

    if (value === null || value === undefined || value === '') {
        return '-';
    }

    return String(value);
};
</script>

<template>
    <Head :title="`${config.label} Admin`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-4 md:p-6">
            <section class="rounded-[8px] border border-sidebar-border/70 bg-background p-5 shadow-sm dark:border-sidebar-border">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-muted-foreground">Portfolio Admin</p>
                        <h1 class="mt-2 text-2xl font-semibold">{{ config.label }}</h1>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <Link
                            v-for="item in resources"
                            :key="item.key"
                            :href="`/admin/portfolio/${item.key}`"
                            :class="[
                                'rounded-full border px-3 py-1.5 text-sm transition',
                                item.key === resource ? 'border-primary bg-primary text-primary-foreground' : 'border-border hover:bg-muted',
                            ]"
                        >
                            {{ item.label }}
                        </Link>
                    </div>
                </div>
            </section>

            <div :class="isSingleton ? 'grid gap-6 xl:grid-cols-[minmax(0,760px)]' : 'grid gap-6 xl:grid-cols-[minmax(0,1fr)_420px]'">
                <section v-if="!isSingleton" class="overflow-hidden rounded-[8px] border border-sidebar-border/70 bg-background shadow-sm dark:border-sidebar-border">
                    <div class="border-b p-5">
                        <h2 class="text-lg font-semibold">Data</h2>
                        <p class="text-sm text-muted-foreground">{{ records.length }} item tersimpan</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[720px] text-left text-sm">
                            <thead class="bg-muted/60 text-xs uppercase text-muted-foreground">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th v-for="field in visibleColumns" :key="field.name" class="px-4 py-3">{{ field.label }}</th>
                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="record in records" :key="record.id" class="border-t">
                                    <td class="px-4 py-3 font-medium">{{ record.id }}</td>
                                    <td v-for="field in visibleColumns" :key="field.name" class="max-w-[260px] truncate px-4 py-3">
                                        {{ displayValue(record[field.name]) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" class="rounded-md border px-3 py-1.5 text-sm hover:bg-muted" @click="editRecord(record)">Edit</button>
                                            <button type="button" class="rounded-md border border-red-500/40 px-3 py-1.5 text-sm text-red-600 hover:bg-red-500/10" @click="destroyRecord(record)">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="!records.length">
                                    <td :colspan="visibleColumns.length + 2" class="px-4 py-12 text-center text-muted-foreground">Belum ada data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="rounded-[8px] border border-sidebar-border/70 bg-background p-5 shadow-sm dark:border-sidebar-border">
                    <div class="mb-5 flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold">{{ isSingleton ? 'Edit Profile' : editingRecord ? 'Edit Data' : 'Create Data' }}</h2>
                            <p class="text-sm text-muted-foreground">
                                {{ isSingleton ? 'Ubah data utama yang tampil di landing page.' : editingRecord ? `Editing #${editingRecord.id}` : `Tambah ${config.label}` }}
                            </p>
                        </div>
                        <button v-if="editingRecord && !isSingleton" type="button" class="rounded-md border px-3 py-1.5 text-sm hover:bg-muted" @click="resetForm">Cancel</button>
                    </div>

                    <form class="space-y-4" @submit.prevent="submit">
                        <div v-for="field in config.fields" :key="field.name" class="space-y-2">
                            <label :for="field.name" class="text-sm font-medium">
                                {{ field.label }}
                                <span v-if="field.required" class="text-red-500">*</span>
                            </label>

                            <textarea
                                v-if="field.type === 'textarea'"
                                :id="field.name"
                                v-model="form[field.name]"
                                :required="field.required"
                                rows="4"
                                class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                            />

                            <select
                                v-else-if="field.type === 'select'"
                                :id="field.name"
                                v-model="form[field.name]"
                                :required="field.required"
                                class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                            >
                                <option value="">Choose {{ field.label }}</option>
                                <option v-for="option in field.options" :key="option" :value="option">{{ option }}</option>
                            </select>

                            <select
                                v-else-if="field.type === 'boolean'"
                                :id="field.name"
                                v-model="form[field.name]"
                                class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                            >
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>

                            <div v-else-if="field.type === 'image'" class="space-y-2">
                                <img
                                    v-if="editingRecord?.[field.name]"
                                    :src="editingRecord[field.name]"
                                    :alt="field.label"
                                    class="h-28 w-full rounded-md border object-contain"
                                />
                                <input
                                    :id="field.name"
                                    type="file"
                                    accept="image/jpeg,image/png,image/webp"
                                    :required="field.required && !editingRecord?.[field.name]"
                                    class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm file:mr-3 file:rounded file:border-0 file:px-3 file:py-1"
                                    @change="selectImage($event, field.name)"
                                />
                                <p class="text-xs text-muted-foreground">JPG, PNG, atau WebP (maks. 10 MB). Otomatis dikompres ke WebP.</p>
                            </div>

                            <div v-else-if="field.type === 'image_multiple'" class="space-y-2">
                                <div v-if="editingRecord?.[field.name]?.length" class="grid grid-cols-3 gap-2 rounded-md bg-black p-2">
                                    <img
                                        v-for="image in editingRecord[field.name]"
                                        :key="image"
                                        :src="image"
                                        :alt="field.label"
                                        class="h-24 w-full rounded object-contain"
                                    />
                                </div>
                                <input
                                    :id="field.name"
                                    type="file"
                                    multiple
                                    accept="image/jpeg,image/png,image/webp"
                                    class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm file:mr-3 file:rounded file:border-0 file:px-3 file:py-1"
                                    @change="selectImages($event, field.name)"
                                />
                                <p class="text-xs text-muted-foreground">Pilih beberapa gambar sekaligus (maks. 12 file, masing-masing 10 MB). Saat edit, gambar baru akan ditambahkan.</p>
                            </div>

                            <input
                                v-else
                                :id="field.name"
                                v-model="form[field.name]"
                                :type="field.type"
                                :required="field.required"
                                class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring"
                            />

                            <p v-if="form.errors[field.name]" class="text-sm text-red-600">{{ form.errors[field.name] }}</p>
                        </div>

                        <button type="submit" :disabled="form.processing" class="w-full rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground transition hover:opacity-90 disabled:opacity-60">
                            {{ form.processing ? 'Saving...' : editingRecord || isSingleton ? 'Update' : 'Create' }}
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </AppLayout>
</template>
