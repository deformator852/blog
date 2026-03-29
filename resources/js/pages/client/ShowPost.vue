<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/AppLayout.vue';
import { formatDate } from '@/lib/utils';
import type { FullPost } from '@/types/models/post';


defineProps<{
    post: FullPost;
}>();
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-zinc-950">

            <div class="relative h-96 w-full overflow-hidden bg-zinc-800">
                <img v-if="post.image_path" :src="`/storage/${post.image_path}`" :alt="post.title"
                    class="h-full w-full object-cover opacity-80" />
                <div class="absolute inset-0 bg-linear-to-t from-zinc-950 via-zinc-950/40 to-transparent" />

                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <div class="mx-auto max-w-3xl">
                        <span
                            class="mb-3 inline-block rounded-full bg-indigo-900/70 px-3 py-1 text-xs font-medium text-indigo-400 ring-1 ring-indigo-500/30 backdrop-blur-sm">
                            {{ post.category.name }}
                        </span>
                        <h1 class="text-4xl font-bold leading-tight text-zinc-100">
                            {{ post.title }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-3xl px-6 py-10">

                <div class="mb-8 flex items-center gap-4 border-b border-zinc-700/60 pb-8">
                    <Link :href="route('client.posts.index')"
                        class="inline-flex items-center gap-2 text-sm text-zinc-400 transition-colors hover:text-zinc-100">
                        ← All posts
                    </Link>
                    <span class="text-zinc-700">|</span>
                    <span class="text-sm text-zinc-500">
                        {{ formatDate(post.created_at) }}
                    </span>
                </div>

                <div class="text-lg leading-relaxed whitespace-pre-wrap text-zinc-300">
                    {{ post.content }}
                </div>

            </div>
        </div>
    </AppLayout>
</template>