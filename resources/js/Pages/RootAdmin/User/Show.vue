<script setup>
import { router, useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref, computed } from "vue";

const { user } = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const roles = { none: 0, admin: 2, user: 3 };

const rolesMap = ref({
    admin: "Administrador do Cinema",
    end_user: "Usuário",
});

const form = useForm({
    email: user.data.email,
    name: user.data.name,
    cpf: user.data.cpf,
});

const formsIsInvalid = computed(() => {
    const { show, ...fields } = form.data();

    for (const field of Object.values(fields)) {
        if (field === "") return true;
    }

    const regex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
    if (!regex.test(form.cpf)) return { field: "cpf", message: "Cpf invalido" };

    return false;
});

const submit = () => {
    return form.put(`/admin/usuarios/${user.data.id}`);
};

const handleDelete = () => router.delete(`/admin/usuarios/${user.data.id}`);

// const formatCPF = () => {
//     const cpfRegex = /(\d{3})(\d{3})(\d{3})(\d{2})/;
//     const layout = "$1.$2.$3-$4";

//     let numericCPF = form.cpf.replace(/\D/g, "");

//     if (numericCPF.length === 11)
//         form.cpf = numericCPF.replace(cpfRegex, layout);
// };

const getCinemaName = (role) => {
    if (role.role_name === "root_admin") return;

    if (!user.cinemas.length) return "[removido]";

    return user.cinemas.find(({ id }) => role.pivot.cinema_id === id).name;
};
</script>

<template>
    <section class="mt-8">
        <form @submit.prevent="submit" class="mx-8">
            <div class="flex justify-between my-4">
                <h3 class="">Perfil</h3>
                <SecondaryButton
                    class="mr-4"
                    @click="handleDelete()"
                    :type="'button'"
                    :disabled="formsIsInvalid || form.processing"
                    >Excluir</SecondaryButton
                >
            </div>
            <div class="p-4 pt-8 border rounded-lg">
                <div class="grid md:grid-cols-3 md:gap-6 md:mx-2">
                    <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                        <input
                            type="text"
                            name="name"
                            id="name"
                            v-model.trim="form.name"
                            class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                        />
                        <label
                            for="name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Nome</label
                        >
                    </div>
                    <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            v-model.trim="form.email"
                            class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                            required
                        />
                        <label
                            for="email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Email</label
                        >
                    </div>

                    <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                        <input
                            id="cpf"
                            name="cpf"
                            @input="formatCPF()"
                            maxlength="14"
                            minlength="11"
                            v-model.trim="form.cpf"
                            class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                            placeholder=" "
                        />
                        <label
                            for="cpf"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >CPF</label
                        >
                    </div>
                </div>
                <div class="mt-4 justify-between flex">
                    <p class="text-red-500 px-4 py-2" role="alert">
                        {{ formsIsInvalid.message }}
                    </p>
                    <SecondaryButton
                        class="mr-4"
                        :type="'submit'"
                        :disabled="formsIsInvalid || form.processing"
                        >Editar</SecondaryButton
                    >
                </div>
            </div>
        </form>

        <div class="m-8">
            <h3 class="">Associações</h3>
            <div
                v-for="cinema in user.data.cinemas"
                class="p-4 mb-1 border rounded-lg flex gap-x-6"
            >
                <p>
                    {{ cinema.name }}
                </p>
                <p>{{ rolesMap[user.data.role] }}</p>

                <p class="ml-auto">X</p>
            </div>
        </div>
    </section>
</template>
