<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import BaseTable from "@/Components/BaseTable.vue";
import { ref } from "vue";
import CinemaForm from "@/Components/Cinema/CinemaForm.vue";

const { cinemas } = defineProps({
    cinemas: {
        type: Array,
        required: true,
    },
});

const filter = ref({
    show: true,
    name: "",
    CNPJ: "",
    state: "",
    city: "",
    address: "",
    email: "",
    phone: "",
    result: cinemas,
});

const CinemasFilter = () => {
    const { CNPJ, name, email } = filter.value;

    filter.value.result = cinemas.filter((cinema) => {
        let numericCNPJ = cinema.cnpj.replace(/\D/g, "");

        const CNPJmatch = numericCNPJ.includes(CNPJ);

        const nameMatch = cinema.name
            .toLowerCase()
            .includes(name.toLowerCase());

        const emailMatch = cinema.email
            .toLowerCase()
            .includes(email.toLocaleLowerCase());

        return CNPJmatch && nameMatch && emailMatch;
    });
};

const handleClick = (id) => router.visit(`/admin/cinemas/${id}`);
</script>

<template>
    <Head title="Cinemas" />

    <CinemaForm :cinemas="cinemas" />

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
                            @input="CinemasFilter"
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
                            id="filter_cpf"
                            name="filter_cpf"
                            @input="CinemasFilter"
                            v-model.trim="filter.CNPJ"
                            class="block py-2 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                            placeholder=" "
                        />
                        <label
                            for="cpf"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >CNPJ</label
                        >
                    </div>
                    <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                        <input
                            type="email"
                            name="filter_email"
                            @input="CinemasFilter"
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
                </div>
            </form>
        </section>

        <BaseTable
            :columns="['nome', 'CNPJ', 'email', 'telefone', 'endereço']"
            :click="handleClick"
            :data="filter.result"
            v-slot="{ item }"
        >
            <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
            >
                {{ item.name }}
            </th>

            <td scope="row" class="px-6 py-4">
                {{ item.cnpj }}
            </td>
            <td scope="row" class="px-6 py-4">
                {{ item.email }}
            </td>
            <td scope="row" class="px-6 py-4">
                {{ item.phone }}
            </td>
            <td scope="row" class="px-6 py-4">
                {{ `${item.address}, ${item.city} - ${item.state} ` }}
            </td>
        </BaseTable>
    </section>
</template>
