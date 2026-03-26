<script setup lang="ts">
const columns = [
    { key: 'id', label: 'ID' },
    { key: 'title', label: 'Заголовок' },
    { key: 'author', label: 'Автор' },
    { key: 'status', label: 'Статус' },
    { key: 'created_at', label: 'Дата' },
];

const rows = [
    {
        id: 1,
        title: 'Перший пост',
        author: 'Іван',
        status: 'Опублікований',
        created_at: '2024-01-01',
    },
    {
        id: 2,
        title: 'Другий пост',
        author: 'Марія',
        status: 'Чернетка',
        created_at: '2024-01-05',
    },
    {
        id: 3,
        title: 'Третій пост',
        author: 'Олег',
        status: 'Опублікований',
        created_at: '2024-01-10',
    },
];
</script>

<template>
    <div class="p-6">
        <h1 class="mb-4 text-xl font-semibold text-zinc-100">Список постів</h1>

        <div
            class="w-full overflow-x-auto rounded-xl border border-zinc-700/60 shadow-lg"
        >
            <table class="w-full text-left text-sm">
                <thead
                    class="bg-zinc-800 text-xs tracking-widest text-zinc-400 uppercase"
                >
                    <tr>
                        <th
                            v-for="col in columns"
                            :key="col.key"
                            class="px-6 py-3 font-semibold"
                        >
                            {{ col.label }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="row in rows"
                        :key="row.id"
                        class="border-t border-zinc-700/50 bg-zinc-900 text-zinc-300 transition-colors duration-150 hover:bg-zinc-800/70"
                    >
                        <td
                            v-for="col in columns"
                            :key="col.key"
                            class="px-6 py-4"
                        >
                            <span
                                v-if="col.key === 'status'"
                                :class="[
                                    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                    row.status === 'Опублікований'
                                        ? 'bg-emerald-900/50 text-emerald-400 ring-1 ring-emerald-500/30'
                                        : 'bg-zinc-700/50 text-zinc-400 ring-1 ring-zinc-500/30',
                                ]"
                            >
                                {{ row[col.key] }}
                            </span>
                            <span
                                v-else-if="col.key === 'id'"
                                class="font-mono text-zinc-500"
                            >
                                #{{ row[col.key] }}
                            </span>
                            <span v-else>
                                {{ row[col.key] }}
                            </span>
                        </td>
                    </tr>

                    <tr v-if="rows.length === 0">
                        <td
                            :colspan="columns.length"
                            class="px-6 py-10 text-center text-zinc-500"
                        >
                            Немає постів
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
