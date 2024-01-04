<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import BaseTable from "@/Components/BaseTable.vue";
import { ref } from "vue";

const { users } = defineProps({
    users: {
        type: Object,
        required: true,
    },
});

const filter = ref({
    show: true,
    name: "",
    email: "",
    cpf: "",
    role: "",
    result: users.data,
});

const rolesMap = ref({
    root_admin: "Administrador Raiz",
    admin: "Administrador Cinema",
    end_user: "Usuário",
});

const UsersFilter = () => {
    const { name, email, cpf, role } = filter.value;

    filter.value.result = users.data.filter((user) => {
        const roleMatch = user.role === role || "" === role;

        let numericCPF = user.cpf.replace(/\D/g, "");
        const cpfMatch = numericCPF.includes(cpf);

        const nameMatch = user.name.toLowerCase().includes(name.toLowerCase());

        const emailMatch = user.email
            .toLowerCase()
            .includes(email.toLocaleLowerCase());

        return roleMatch && cpfMatch && nameMatch && emailMatch;
    });
};

const handleClick = (id) => router.visit(`/admin/usuarios/${id}`);
</script>

<template>
    <Head title="Usuários" />

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
                {{ item.name }}
            </th>
            <td scope="row" class="px-6 py-4">
                {{ item.email }}
            </td>
            <td scope="row" class="px-6 py-4">
                {{ item.cpf }}
            </td>
            <td scope="row" class="px-6 py-4">
                {{ rolesMap[item.role] }}
            </td>
        </BaseTable>
        <div class="text-center my-4">
            <Link :href="users.links.prev" class="p-2 mr-2 border">{{
                "<<"
            }}</Link>
            <Link :href="users.links.next" class="p-2 border">{{ ">>" }}</Link>
        </div>
        <div v-if="$page.props.flash.message" class="alert text-end mr-8">
            {{ $page.props.flash.message }}
        </div>
    </section>
</template>
