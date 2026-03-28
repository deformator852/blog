<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthLayout from '@/layouts/AuthLayout.vue';

const props = defineProps<{
    post: {
        id: number;
        title: string;
        content: string;
        category_id: number;
        image_path: string | null;
        is_published: boolean;
    };
    categories: { id: number; name: string }[];
}>();

const imagePreview = ref<string | null>(
    props.post.image_path ? `/storage/${props.post.image_path}` : null
);

const form = useForm({
    title: props.post.title,
    content: props.post.content,
    category_id: props.post.category_id,
    image_path: null as File | null,
    is_published: props.post.is_published,
});

function handleImage(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0];

    if (!file) {
        return
    }

    form.image_path = file;
    imagePreview.value = URL.createObjectURL(file);
}

function removeImage() {
    form.image_path = null;
    imagePreview.value = null;
}

function submit() {
    form.put(`/admin/posts/${props.post.id}`, {
        forceFormData: true,
    });
}
</script>

<template>
    <AuthLayout>
        <div class="min-h-screen bg-zinc-950 p-6 text-zinc-100">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <Link href="/admin/posts"
                        class="mb-2 flex items-center gap-1 text-xs text-zinc-500 transition hover:text-zinc-300">
                        ← Back
                    </Link>
                    <h1 class="text-2xl font-bold tracking-tight text-zinc-100">
                        Edit post
                    </h1>
                </div>
            </div>

            <form @submit.prevent="submit" class="mx-auto max-w-3xl space-y-6" novalidate>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-widest text-zinc-400 uppercase">
                        Title
                    </label>
                    <input v-model="form.title" type="text" placeholder="Enter title..."
                        class="w-full rounded-lg border border-zinc-700 bg-zinc-900 px-4 py-3 text-zinc-100 placeholder-zinc-600 transition outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50" />
                    <p v-if="form.errors.title" class="text-xs text-red-400">
                        {{ form.errors.title }}
                    </p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-widest text-zinc-400 uppercase">
                        Category
                    </label>
                    <select v-model="form.category_id"
                        class="w-full rounded-lg border border-zinc-700 bg-zinc-900 px-4 py-3 text-zinc-100 transition outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50">
                        <option value="" disabled>Choose category...</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                            {{ cat.name }}
                        </option>
                    </select>
                    <p v-if="form.errors.category_id" class="text-xs text-red-400">
                        {{ form.errors.category_id }}
                    </p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-widest text-zinc-400 uppercase">
                        Content
                    </label>
                    <textarea v-model="form.content" rows="8" placeholder="Text..."
                        class="w-full resize-none rounded-lg border border-zinc-700 bg-zinc-900 px-4 py-3 text-zinc-100 placeholder-zinc-600 transition outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/50" />
                    <p v-if="form.errors.content" class="text-xs text-red-400">
                        {{ form.errors.content }}
                    </p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-widest text-zinc-400 uppercase">
                        Image
                    </label>

                    <div v-if="imagePreview" class="relative mb-2 overflow-hidden rounded-lg border border-zinc-700">
                        <img :src="imagePreview" class="h-48 w-full object-cover" />
                        <button type="button" @click="removeImage"
                            class="absolute top-2 right-2 rounded-full bg-zinc-900/80 px-2 py-0.5 text-xs text-zinc-400 transition hover:text-red-400">
                            ✕ Remove
                        </button>
                    </div>

                    <label
                        class="flex w-full cursor-pointer flex-col items-center justify-center gap-2 rounded-lg border border-dashed border-zinc-700 bg-zinc-900 px-4 py-8 transition hover:border-indigo-500/50 hover:bg-zinc-800/50">
                        <span class="text-2xl">🖼️</span>
                        <span class="text-sm text-zinc-400">Click or drag image here</span>
                        <span class="text-xs text-zinc-600">PNG, JPG, WEBP up to 2MB</span>
                        <input type="file" accept="image/*" class="hidden" @change="handleImage" />
                    </label>

                    <p v-if="form.errors.image_path" class="text-xs text-red-400">
                        {{ form.errors.image_path }}
                    </p>
                </div>

                <div class="flex items-center gap-3 rounded-lg border border-zinc-700/50 bg-zinc-900 px-4 py-3">
                    <button type="button" @click="form.is_published = !form.is_published" :class="[
                        'relative h-5 w-9 rounded-full transition-colors duration-200',
                        form.is_published ? 'bg-indigo-600' : 'bg-zinc-700',
                    ]">
                        <span :class="[
                            'absolute top-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200',
                            form.is_published ? 'translate-x-4' : 'translate-x-0.5',
                        ]" />
                    </button>
                    <span class="text-sm text-zinc-300">Publish immediately</span>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-zinc-800 pt-6">
                    <Link href="/admin/posts"
                        class="rounded-lg border border-zinc-700 px-5 py-2.5 text-sm text-zinc-400 transition hover:border-zinc-500 hover:text-zinc-200">
                        Cancel
                    </Link>
                    <button type="submit" :disabled="form.processing"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-500 disabled:opacity-50">
                        {{ form.processing ? 'Saving...' : 'Update post' }}
                    </button>
                </div>
            </form>
        </div>
    </AuthLayout>
</template>