<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});


const classes = computed(() =>
    props.active
        ? 'text-gray-900 bg-indigo-50'
        : 'text-gray-900 text-white hover:bg-gray-700'

);

</script>

<template>
    <Link :href="href" class="flex items-center p-2 hover:bg-gray-100  group" :class="classes">
    <slot />
    </Link>
</template>
