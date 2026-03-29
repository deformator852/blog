<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/AppLayout.vue';
import { formatDate, formatLabel } from '@/lib/utils';
import type { Category } from '@/types/models/category';
import type { PaginatedPosts } from '@/types/pagination';


const props = defineProps<{
    posts: PaginatedPosts;
    categories: Category[];
    activeCategory: string | null;
}>();

const isFiltering = ref(false);

const paginationLinks = computed(() =>
    props.posts.links.filter((link) => link.label !== ''),
);

function selectCategory(slug: string | null) {
    isFiltering.value = true;

    router.get(
        route('client.posts.index'),
        slug ? { category: slug } : {},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isFiltering.value = false;
            },
        },
    );
}
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-zinc-950 px-4 py-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl">

                <div class="mb-10 border-b border-zinc-800 pb-8">
                    <p class="mb-2 font-mono text-xs tracking-[0.25em] text-indigo-400 uppercase">
                        Journal
                    </p>
                    <div class="flex items-end justify-between gap-4">
                        <h1 class="text-4xl font-light tracking-tight text-zinc-100">
                        </h1>
                        <span class="font-mono text-sm text-zinc-500">
                            {{ posts.total }} articles
                        </span>
                    </div>
                </div>

                <div v-if="categories.length > 0" class="mb-10">
                    <div class="flex flex-wrap gap-2">
                        <button @click="selectCategory(null)" :class="[
                            'rounded-full border px-4 py-1.5 font-mono text-xs transition-all duration-200',
                            !activeCategory
                                ? 'border-indigo-500 bg-indigo-500/15 text-indigo-300'
                                : 'border-zinc-700 bg-transparent text-zinc-500 hover:border-zinc-500 hover:text-zinc-300',
                        ]">
                            All
                            <span class="ml-1.5 opacity-60">{{ posts.total }}</span>
                        </button>

                        <button v-for="cat in categories" :key="cat.id" @click="selectCategory(cat.slug)" :class="[
                            'rounded-full border px-4 py-1.5 font-mono text-xs transition-all duration-200',
                            activeCategory === cat.slug
                                ? 'border-indigo-500 bg-indigo-500/15 text-indigo-300'
                                : 'border-zinc-700 bg-transparent text-zinc-500 hover:border-zinc-500 hover:text-zinc-300',
                        ]">
                            {{ cat.name }}
                            <span class="ml-1.5 opacity-60">{{ cat.posts_count }}</span>
                        </button>
                    </div>
                </div>

                <Transition name="fade" mode="out-in">
                    <div :key="activeCategory ?? 'all'">

                        <div v-if="posts.data.length === 0" class="py-24 text-center">
                            <p class="text-zinc-500">No posts in this category yet.</p>
                        </div>

                        <div v-else class="divide-y divide-zinc-800/70">
                            <Link v-for="post in posts.data" :key="post.id"
                                :href="route('client.posts.show', { id: post.id })"
                                class="group flex flex-col gap-2 py-7 transition-all duration-200 sm:flex-row sm:items-start sm:gap-8">
                                <div class="shrink-0 font-mono text-xs text-zinc-600 sm:w-32 sm:pt-1">
                                    {{ formatDate(post.created_at) }}
                                </div>

                                <div class="flex-1">
                                    <h3
                                        class="mb-1.5 text-base font-medium text-zinc-200 transition-colors group-hover:text-indigo-300">
                                        {{ post.title }}
                                    </h3>
                                    <p v-if="post.excerpt" class="text-sm leading-relaxed text-zinc-500 line-clamp-2">
                                        {{ post.excerpt }}
                                    </p>
                                    <div class="mt-3 flex flex-wrap items-center gap-2">
                                        <span v-if="post.category"
                                            class="rounded-full border border-zinc-800 px-2 py-0.5 font-mono text-xs text-zinc-600">
                                            {{ post.category.name }}
                                        </span>
                                        <span v-if="post.reading_time" class="font-mono text-xs text-zinc-600">
                                            {{ post.reading_time }} min read
                                        </span>
                                    </div>
                                </div>

                                <div
                                    class="hidden shrink-0 text-zinc-700 transition-all duration-200 group-hover:translate-x-1 group-hover:text-indigo-400 sm:block">
                                    <svg class="h-5 w-5" viewBox="0 0 16 16" fill="none">
                                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </Link>
                        </div>

                    </div>
                </Transition>

                <div v-if="posts.last_page > 1"
                    class="mt-12 flex items-center justify-between border-t border-zinc-800 pt-8">
                    <span class="font-mono text-xs text-zinc-600">
                        Page {{ posts.current_page }} / {{ posts.last_page }}
                    </span>
                    <div class="flex gap-1">
                        <template v-for="link in paginationLinks" :key="link.label">
                            <Link v-if="link.url !== null" :href="link.url" :class="[
                                'rounded-lg px-3 py-1.5 font-mono text-sm transition-colors',
                                link.active
                                    ? 'bg-indigo-600 text-white'
                                    : 'text-zinc-500 hover:bg-zinc-800 hover:text-zinc-300',
                            ]" preserve-scroll>
                                {{ formatLabel(link.label) }}
                            </Link>
                            <span v-else
                                class="cursor-not-allowed rounded-lg px-3 py-1.5 font-mono text-sm text-zinc-700">
                                {{ formatLabel(link.label) }}
                            </span>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>