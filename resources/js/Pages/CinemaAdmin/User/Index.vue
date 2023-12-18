<script setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import BaseTable from "@/Components/BaseTable.vue";
import { ref } from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import UserForm from "@/Components/User/UserForm.vue";
import axios from "axios";

const { users } = defineProps({
    users: {
        type: Array,
        required: true,
    },
});

const filter = ref({
    show: true,
    name: "",
    email: "",
    cpf: "",
    role: "",
    result: users,
});

const form = useForm({
    email: "",
    cpf: "",
});

const rolesMap = ref({
    cinema_admin: "Administrador Cinema",
    end_user: "Usuário",
});

const UsersFilter = () => {
    const { name, email: filterEmail, cpf, role } = filter.value;

    filter.value.result = users.filter(({ user_account, email, roles }) => {
        const { role_name } = roles[0] || { role_name: "" };
        const roleMatch = role_name === role || role === "";

        let numericCPF = user_account.cpf.replace(/\D/g, "");
        const cpfMatch = numericCPF.includes(cpf);

        const nameMatch = user_account.name
            .toLowerCase()
            .includes(name.toLowerCase());

        const emailMatch = email
            .toLowerCase()
            .includes(filterEmail.toLocaleLowerCase());

        return roleMatch && cpfMatch && nameMatch && emailMatch;
    });
};

const formatCPF = () => {
    const cpfRegex = /(\d{3})(\d{3})(\d{3})(\d{2})/;
    const layout = "$1.$2.$3-$4";

    let numericCPF = form.cpf.replace(/\D/g, "");

    if (numericCPF.length === 11)
        form.cpf = numericCPF.replace(cpfRegex, layout);
};

const message = ref("");
const user = ref(null);

const submit = async () => {
    const { data } = await axios.post("/cinema/usuarios/find", form);

    if (data.message) return (message.value = data.message);

    console.log(data.user);

    if (data.user) return (user.value = data.user);
};

const handleClick = (id) => router.visit(`/cinema/usuarios/${id}`);
</script>

<template>
    <Head title="Usuários" />

    <!-- <UserForm :users="users" /> -->

    <section class="mt-16">
        <form @submit.prevent="submit" class="mx-8 md:flex gap-x-8">
            <div class="grow">
                <div class="mt-4 md: sm:mt-0 relative z-0 w-full group">
                    <input
                        type="email"
                        name="email"
                        id="email"
                        v-model.trim="form.email"
                        class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Email</label
                    >
                </div>

                <div class="mt-4 sm:mt-4 relative z-0 w-full group">
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
            <SecondaryButton
                class="mr-4 md:mt-8"
                :type="'submit'"
                :disabled="form.processing"
                >Encontrar usuário</SecondaryButton
            >
        </form>
        <div v-if="message" class="alert mx-8">
            {{ message }}
        </div>

        <div class="alert mx-8" v-if="user">
            <p>
                {{
                    users.some((u) => u.id === user.id)
                        ? "Já cadastrado"
                        : "Usuário na base"
                }}
            </p>
            <p>Nome: {{ user.user_account.name }}</p>
            <p>Email: {{ user.email }}</p>
        </div>
    </section>

    <section>
        <section class="mt-16">
            <form class="mx-8">
                <div
                    @click="filter.show = !filter.show"
                    class="flex justify-between cursor-pointer"
                >
                    <h3 class="mb-4">Filtros</h3>
                    <svg
                        v-if="filter.show"
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
                <div
                    v-show="filter.show"
                    class="grid md:grid-cols-4 md:gap-6 mx-2"
                >
                    <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                        <input
                            type="text"
                            name="filter_name"
                            id="filter_name"
                            v-model.trim="filter.name"
                            @input="UsersFilter"
                            class="block py-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                        />
                        <label
                            for="name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Nome</label
                        >
                    </div>
                    <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                        <input
                            type="email"
                            name="filter_email"
                            @input="UsersFilter"
                            id="filter_email"
                            v-model.trim="filter.email"
                            class="block py-2 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                        />
                        <label
                            for="email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Email</label
                        >
                    </div>

                    <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                        <input
                            id="filter_cpf"
                            name="filter_cpf"
                            @input="UsersFilter"
                            v-model.trim="filter.cpf"
                            class="block py-2 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                            placeholder=" "
                        />
                        <label
                            for="cpf"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >CPF</label
                        >
                    </div>
                    <div class="mt-8 sm:mt-0 relative z-0 w-full group">
                        <label
                            for="filter_role"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top1 -z-10 origin-[0]"
                            >Função</label
                        >
                        <select
                            v-model="filter.role"
                            id="filter_role"
                            @change="UsersFilter"
                        >
                            <option value="">Todos</option>
                            <option
                                v-for="(role, key) in rolesMap"
                                :key="key"
                                :value="key"
                            >
                                {{ role }}
                            </option>
                        </select>
                    </div>
                </div>
            </form>
        </section>

        <BaseTable
            :columns="['nome', 'email', 'cpf', 'função']"
            :data="filter.result"
            :click="handleClick"
            v-slot="{ item }"
        >
            <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
            >
                {{ item.user_account.name }}
            </th>
            <td scope="row" class="px-6 py-4">
                {{ item.email }}
            </td>
            <td scope="row" class="px-6 py-4">
                {{ item.user_account.cpf }}
            </td>
            <td scope="row" class="px-6 py-4">
                {{ rolesMap[item.roles[0]?.role_name] || "-" }}
            </td>
        </BaseTable>
    </section>
</template>
