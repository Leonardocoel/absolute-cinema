<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
});
</script>

<template>
    <button
        :type="type"
        class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase shadow-sm hover:bg-gray-50 disabled:opacity-25"
    >
        <slot />
    </button>
</template>
