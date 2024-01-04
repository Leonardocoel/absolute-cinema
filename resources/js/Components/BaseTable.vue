<script setup>
const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    data: {
        type: Array,
        required: true,
    },
    click: {
        type: Function,
    },
});
</script>

<template>
    <div class="mx-8 my-4 rounded-lg border bg-white overflow-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-600 uppercase">
                <tr>
                    <th
                        v-for="column of columns"
                        :key="column.id"
                        scope="col"
                        class="px-6 py-3 rounded-full"
                    >
                        {{ column }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(item, row_index) in data"
                    :key="item.id"
                    @click="click(item.id)"
                    class="bg-gray-100 border-b hover:bg-gray-200 cursor-pointer"
                >
                    <slot :item="item" :index="row_index"> </slot>
                </tr>
            </tbody>
        </table>
    </div>
</template>
