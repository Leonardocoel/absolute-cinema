<script setup>
import { router, useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { computed } from "vue";

const { users } = defineProps({
    users: {
        type: Array,
        required: true,
    },
    cinemasWithoutAdmin: {
        type: Array,
        required: true,
    },
});

const roles = { none: 0, admin: 2, user: 3 };

const form = useForm({
    show: true,
    email: "",
    name: "",
    password: "",
    cpf: "",
    role_id: roles.none,
    cinema_id: 0,
});

const formsIsInvalid = computed(() => {
    const { show, ...fields } = form.data();

    if (fields.role_id === roles.user) form.cinema_id = 0;

    for (const field of Object.values(fields)) {
        if (field === "") return true;
    }

    if (fields.role_id === roles.none) return true;
    if (fields.role_id === roles.admin && fields.cinema_id === 0) return true;

    if (form.password.length < 8)
        return {
            field: "password",
            message: "Esta senha é muito curta",
        };

    const regex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
    if (!regex.test(form.cpf)) return { field: "cpf", message: "Cpf invalido" };

    for (const { email, user_account, roles } of users) {
        if (email === form.email)
            return { field: "email", message: "Email já existe" };

        if (user_account.cpf === form.cpf)
            return { field: "cpf", message: "Cpf já existe" };
    }

    return false;
});

const submit = () => {
    return form
        .transform((data) => {
            if (data.cinema_id === roles.none) delete data.cinema_id;

            return data;
        })
        .post("/admin/usuarios", {
            onSuccess: (data) => {
                router.visit("/admin/usuarios", {
                    only: ["users", "cinemasWithoutAdmin"],
                });
                return form.reset();
            },
        });
};

const formatCPF = () => {
    const cpfRegex = /(\d{3})(\d{3})(\d{3})(\d{2})/;
    const layout = "$1.$2.$3-$4";

    let numericCPF = form.cpf.replace(/\D/g, "");

    if (numericCPF.length === 11)
        form.cpf = numericCPF.replace(cpfRegex, layout);
};
</script>

<template>
    <section class="mt-8">
        <form @submit.prevent="submit" class="mx-8">
            <div
                @click="form.show = !form.show"
                class="flex justify-between cursor-pointer"
            >
                <h3 class="mb-4">Cadastro</h3>
                <svg
                    v-if="form.show"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.5 15.75l7.5-7.5 7.5 7.5"
                    />
                </svg>
                <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                    />
                </svg>
            </div>
            <div v-show="form.show" class="p-4 pt-8 border rounded-lg">
                <div class="grid md:grid-cols-2 md:gap-6 md:mx-2">
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
                            type="password"
                            name="password"
                            id="password"
                            v-model.trim="form.password"
                            class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                            required
                        />
                        <label
                            for="password"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Password</label
                        >
                    </div>

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
                    <div class="mt-8 sm:mt-4 relative z-0 w-full group">
                        <label
                            for="role_id"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top1 -z-10 origin-[0]"
                            >Função</label
                        >
                        <select
                            v-model="form.role_id"
                            id="role_id"
                            class="cursor-pointer"
                        >
                            <option :value="roles.none" disabled>
                                Escolha a Função
                            </option>
                            <option
                                :value="roles.admin"
                                :disabled="cinemasWithoutAdmin.length < 1"
                            >
                                Administrador Cinema
                                {{
                                    cinemasWithoutAdmin.length < 1
                                        ? " Sem cinemas disponíveis"
                                        : ""
                                }}
                            </option>
                            <option :value="roles.user">Usuário</option>
                        </select>
                    </div>
                    <div class="mt-8 sm:mt-4 relative z-0 w-full group">
                        <label
                            for="cinema_id"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top1 -z-10 origin-[0]"
                            >Cinema</label
                        >
                        <select
                            v-model="form.cinema_id"
                            id="cinema_id"
                            class="disabled:opacity-25 enabled:cursor-pointer"
                            :disabled="
                                cinemasWithoutAdmin.length < 1 ||
                                form.role_id !== roles.admin
                            "
                        >
                            <option :value="roles.none" disabled>
                                Escolha o Cinema
                            </option>
                            <option
                                v-for="cinema of cinemasWithoutAdmin"
                                :value="cinema.id"
                                :key="cinema.id"
                            >
                                {{ cinema.name }}
                            </option>
                        </select>
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
                        >Salvar</SecondaryButton
                    >
                </div>
            </div>
        </form>
    </section>
</template>
