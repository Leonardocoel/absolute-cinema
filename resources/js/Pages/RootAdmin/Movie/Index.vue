<script setup>
import { Head, router } from "@inertiajs/vue3";
import BaseTable from "@/Components/BaseTable.vue";
import { ref } from "vue";
import MovieForm from "@/Components/Movie/MovieForm.vue";

const { movies } = defineProps({
    movies: {
        type: Array,
        required: true,
    },
});

const filter = ref({
    show: true,
    title: "",
    synopsis: "",
    duration_minutes: "",
    release_date: "",
    genre: "",
    language: "",
    rating: "",
    image: null,
    availability: "",
    result: movies,
});

const MoviesFilter = () => {
    const { title, release_date, availability } = filter.value;

    filter.value.result = movies.filter((movie) => {
        const availabilityMatch =
            availability === "" || movie.availability === availability;

        const dateMatch = movie.release_date.includes(
            release_date.toLowerCase()
        );

        const nameMatch = movie.title
            .toLowerCase()
            .includes(title.toLowerCase());

        return availabilityMatch && nameMatch && dateMatch;
    });
};

const handleClick = (id) => router.visit(`/admin/filmes/${id}`);
</script>

<template>
    <Head title="Movies" />

    <MovieForm :movies="movies" />

    <section>
        <section class="mt-16">
            <form class="mx-8">
                <div
                    @click="filter.show = !filter.show"
                    class="flex justify-between cursor-pointer md:mb-4"
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
                            name="filter_title"
                            id="filter_title"
                            v-model.trim="filter.title"
                            @input="MoviesFilter"
                            class="block py-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                        />
                        <label
                            for="filter_title"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Nome</label
                        >
                    </div>
                    <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                        <input
                            type="date"
                            name="filter_release_date"
                            id="filter_release_date"
                            v-model.trim="filter.release_date"
                            @input="MoviesFilter"
                            class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                        />
                        <label
                            for="filter_release_date"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Data de lançamento</label
                        >
                    </div>
                    <div class="mt-4 sm:mt-0 relative z-0 w-full group flex">
                        <div class="mt-3 sm:mt-3 flex items-center me-4">
                            <input
                                id="filter_availability_yes"
                                type="radio"
                                value=""
                                @change="MoviesFilter"
                                v-model="filter.availability"
                                name="filter_availability-group"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 cursor-pointer"
                            />
                            <label
                                for="filter_availability_yes"
                                class="ms-2 text-sm font-medium text-gray-900 cursor-pointer"
                                >Todos</label
                            >
                        </div>
                        <div class="mt-3 sm:mt-3 flex items-center me-4">
                            <input
                                id="filter_availability_yes"
                                type="radio"
                                :value="true"
                                @change="MoviesFilter"
                                v-model="filter.availability"
                                name="filter_availability-group"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 cursor-pointer"
                            />
                            <label
                                for="filter_availability_yes"
                                class="ms-2 text-sm font-medium text-gray-900 cursor-pointer"
                                >Sim</label
                            >
                        </div>
                        <div class="mt-3 sm:mt-3 flex items-center me-4">
                            <input
                                id="filter_availability_no"
                                type="radio"
                                :value="false"
                                @change="MoviesFilter"
                                v-model="filter.availability"
                                name="filter_availability-group"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 cursor-pointer"
                            />
                            <label
                                for="filter_availability_no"
                                class="ms-2 text-sm font-medium text-gray-900 cursor-pointer"
                                >Não</label
                            >
                        </div>
                        <label
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Disponível para exibição</label
                        >
                    </div>
                </div>
            </form>
        </section>

        <BaseTable
            :columns="[
                '',
                'titulo',
                'disponibilidade',
                'data de lançamento',
                'duração em minutos',
                'gênero',
                'linguagem',
                'avaliação',
            ]"
            :data="filter.result"
            v-slot="{ item }"
            :click="handleClick"
        >
            <td scope="row" class="">
                <img
                    :src="'/storage/' + item.image_url"
                    alt=""
                    class="w-64 max-w-80"
                />
            </td>
            <td scope="row" class="px-6">
                {{ item.title }}
            </td>
            <td scope="row" class="px-6 text-center">
                <span
                    class="text-xs font-bold me-2 px-2.5 py-0.5 rounded border"
                    :class="
                        item.availability
                            ? 'bg-green-100 text-green-800 border-green-400'
                            : 'bg-red-100 text-red-800 border-red-400'
                    "
                    >{{ item.availability ? "DISPONÍVEL" : "OCULTO" }}</span
                >
            </td>
            <td scope="row" class="px-6">
                {{ item.release_date }}
            </td>
            <td scope="row" class="px-6">{{ item.duration_minutes }} min</td>
            <td scope="row" class="px-6">
                {{ item.genre }}
            </td>
            <td scope="row" class="px-6">
                {{ item.language }}
            </td>
            <td scope="row" class="px-6 py-4">
                {{ item.rating }}
            </td>
        </BaseTable>
    </section>
</template>
