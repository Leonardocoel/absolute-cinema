<script setup>
import UserForm from "@/Components/User/UserForm.vue";

const props = defineProps({
    cinemasWithoutAdmin: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
    },
});
</script>

<template>
    <UserForm
        :errors="errors"
        :cinemasWithoutAdmin="cinemasWithoutAdmin.data"
    />
</template>
