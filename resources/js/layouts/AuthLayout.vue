<script setup lang="ts">
import AuthSimpleLayout from '@/layouts/auth/AuthSimpleLayout.vue';
import type { BreadcrumbItem } from '@/types';

const { title = '', description = '' } = defineProps<{
    title?: string;
    description?: string;
    breadcrumbs?: BreadcrumbItem[];
}>();

</script>

<template>
    <AuthSimpleLayout :title="title" :description="description">
        <slot />
    </AuthSimpleLayout>
</template>
