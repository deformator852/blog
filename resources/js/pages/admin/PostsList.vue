<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref, watch } from 'vue';

interface Post {
    id: number;
    title: string;
    is_published: boolean;
    created_at: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedPosts {
    data: Post[];
    current_page: number;
    last_page: number;
    total: number;
    links: PaginationLink[];
}

const props = defineProps<{
    posts: PaginatedPosts;
}>();

const formatLabel = (label: string): string => {
    if (label === '&laquo; Previous') {
        return '←';
    }

    if (label === 'Next &raquo;') {
        return '→';
    }


    return label;
};

const confirmDelete = (postId: number) => {
    if (confirm('Are you sure you want to delete this post?')) {
        router.delete(`/admin/posts/${postId}`);
    }
};

const formatDate = (dateStr: string): string => {
    return new Intl.DateTimeFormat('en-US', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(dateStr));
};

const paginationLinks = computed(() =>
    props.posts.links.filter((link) => link.label !== ''),
);


const flashMessage = ref<{ success?: string; error?: string }>({});


watch(
    () => usePage().props.flash,
    (val: any) => {
        if (val?.success || val?.error) {
            flashMessage.value = { ...val };
            setTimeout(() => (flashMessage.value = {}), 4000);
        }
    },
    { immediate: true, deep: true }
);

</script>

<template>
    <div class="p-6">
        <div class="mb-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-zinc-100">
                Posts
                <span class="ml-2 text-sm text-zinc-400">({{ posts.total }})</span>
            </h1>
            <Link href="/admin/posts/create"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                Create post
            </Link>
        </div>
        <transition name="fade">
            <div v-if="flashMessage.success || flashMessage.error">
                <div v-if="flashMessage.success"
                    class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-900/40 px-4 py-3 text-sm text-emerald-400">
                    ✓ {{ flashMessage.success }}
                </div>
                <div v-if="flashMessage.error"
                    class="mb-4 rounded-lg border border-red-500/30 bg-red-900/40 px-4 py-3 text-sm text-red-400">
                    ✕ {{ flashMessage.error }}
                </div>
            </div>
        </transition>
        <div class="w-full overflow-x-auto rounded-xl border border-zinc-700/60 shadow-lg">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-800 text-xs tracking-widest text-zinc-400 uppercase">
                    <tr>
                        <th class="px-6 py-3 font-semibold">ID</th>
                        <th class="px-6 py-3 font-semibold">Title</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Created</th>
                        <th class="px-6 py-3 font-semibold"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts.data" :key="post.id"
                        class="cursor-pointer border-t border-zinc-700/50 bg-zinc-900 text-zinc-300 hover:bg-zinc-800/70">
                        <td class="px-6 py-4 font-mono text-zinc-500">
                            #{{ post.id }}
                        </td>
                        <td class="px-6 py-4 font-medium text-zinc-100">
                            {{ post.title }}
                        </td>
                        <td class="px-6 py-4">
                            <span :class="[
                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                post.is_published
                                    ? 'bg-emerald-900/50 text-emerald-400 ring-1 ring-emerald-500/30'
                                    : 'bg-zinc-700/50 text-zinc-400 ring-1 ring-zinc-500/30',
                            ]">
                                {{ post.is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-zinc-400">
                            {{ formatDate(post.created_at) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <Link href="#" @click.stop.prevent="confirmDelete(post.id)"
                                class="text-xs text-red-500 hover:text-red-400 hover:underline transition-colors mr-2">
                                Delete
                            </Link>
                            <Link :href="`/admin/posts/${post.id}/edit`"
                                class="text-xs text-indigo-400 hover:text-indigo-300 hover:underline" @click.stop>
                                Edit
                            </Link>
                        </td>
                    </tr>

                    <tr v-if="posts.data.length === 0">
                        <td colspan="5" class="px-6 py-10 text-center text-zinc-500">
                            No posts found
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm text-zinc-400">
            <span>Page {{ posts.current_page }} of {{ posts.last_page }}</span>
            <div class="flex gap-1">
                <template v-for="link in paginationLinks" :key="link.label">
                    <Link v-if="link.url !== null" :href="link.url" :class="[
                        'rounded px-3 py-1 transition-colors',
                        link.active
                            ? 'bg-indigo-600 text-white'
                            : 'text-zinc-400 hover:bg-zinc-700',
                    ]" preserve-scroll>
                        {{ formatLabel(link.label) }}
                    </Link>
                    <span v-else class="cursor-not-allowed rounded px-3 py-1 text-zinc-600">
                        {{ formatLabel(link.label) }}
                    </span>
                </template>
            </div>
        </div>
    </div>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>