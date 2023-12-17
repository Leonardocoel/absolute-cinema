<script setup>
import { ref, computed, defineProps } from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
    cinema_id: {
        type: Number,
        required: true,
    },
});

const refs = ref({
    isDropdownOpen: false,
    selectedItems: [],
});

const selectedNames = computed(() => {
    const { selectedItems } = refs.value;

    if (selectedItems.length === 0) return [];

    const names = props.data.reduce((acc, cur) => {
        if (selectedItems.includes(cur.id)) acc.push(cur.user_account.name);

        return acc;
    }, []);

    return names;
});

const handleNewUsers = () => {
    return router.post(`/admin/cinemas/${props.cinema_id}/novos-usuarios`, {
        newIds: refs.value.selectedItems,
        onSuccess: () => {
            router.visit(`/admin/cinemas/${props.cinema_id}`, {
                only: ["endUsers"],
            });
        },
    });
};
</script>

<template>
    <div class="grid md:grid-cols-10 gap-x-1">
        <div
            class="relative md:col-span-9"
            @click="refs.isDropdownOpen = !refs.isDropdownOpen"
        >
            <div
                class="flex flex-wrap gap-y-2 p-2 border border-gray-300 rounded-md"
            >
                <span v-if="refs.selectedItems.length === 0"
                    >Selecione os usuários</span
                >
                <span
                    v-else
                    v-for="name of selectedNames"
                    :key="name"
                    id="badge-dismiss-default"
                    class="inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-blue-900 bg-blue-100 rounded"
                >
                    {{ name }}
                </span>
            </div>

            <div
                v-if="refs.isDropdownOpen"
                class="absolute mt-1 w-full p-2 bg-white border border-gray-300 rounded-md shadow-md"
            >
                <div
                    v-for="option in data"
                    :key="option.id"
                    class="flex items-center"
                >
                    <input
                        type="checkbox"
                        :id="option.id"
                        :value="option.id"
                        v-model="refs.selectedItems"
                        class="mr-2"
                    />
                    <label :for="option.id">{{
                        option.user_account.name
                    }}</label>
                </div>
            </div>
        </div>
        <SecondaryButton
            @click="handleNewUsers()"
            :type="'button'"
            :disabled="refs.selectedItems.length === 0"
            class="h-10 md:grid-cols-2 mt-auto"
            >Adicionar</SecondaryButton
        >
    </div>
</template>
