<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    movies: {
        type: Array,
        require: true,
    },
    moviesWeek: {
        type: Array,
        require: true,
    },
});

const formatToCurrency = (value) => {
    const currency = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
    }).format(value);

    return currency;
};

const moviesWeekTotal = computed(() => {
    const total = props.moviesWeek.reduce((acc, cur) => {
        return acc + Number(cur.total);
    }, 0);

    return formatToCurrency(total);
});

const order = (array) => array.toSorted((a, b) => b.views - a.views);
</script>

<template>
    <Head title="Dashboard" />

    <div class="m-8 mt-4 h-full grid sm:grid-cols-12 gap-4 text-center">
        <section
            class="sm:row-span-3 sm:col-span-8 w-full h-full border-2 bg-gray-50 rounded-xl"
        >
            <div class="p-4">
                <p>Valor arrecadado na semana(gráfico)</p>
                <p class="my-2">TOTAL: {{ moviesWeekTotal }}</p>
                <div class="flex justify-between">
                    <span>segunda</span>
                    <span>terça</span>
                    <span>quarta</span>
                    <span>quinta</span>
                    <span>sexta</span>
                    <span>sábado</span>
                    <span>domingo</span>
                </div>
            </div>
        </section>

        <section
            class="sm:row-span-6 sm:col-span-4 w-full h-full max-h-screen border-2 bg-gray-50 rounded-xl overflow-auto"
        >
            <div class="p-4">
                <p>Valores arrecadados por filme</p>
                <div
                    v-for="movie of movies"
                    :key="movie.id"
                    class="p-3 text-left border rounded-xl m-1 bg-white"
                >
                    <p><b>titulo: </b>{{ movie.title }}</p>
                    <p><b>data de lançamento: </b>{{ movie.release_date }}</p>
                    <p><b>visualizações: </b>{{ movie.views }}</p>
                    <p>
                        <b>total arrecadado: </b
                        >{{ formatToCurrency(movie.total) }}
                    </p>
                </div>
            </div>
        </section>

        <section
            class="sm:row-span-3 sm:col-span-4 w-full h-full border-2 bg-gray-50 rounded-xl"
        >
            <div class="p-4">
                <p>Top 3 desta semana</p>
                <div
                    v-for="movie of order(moviesWeek).slice(0, 3)"
                    :key="movie.id"
                    class="p-3 text-left border rounded-xl m-1 bg-white"
                >
                    <p><b>titulo: </b>{{ movie.title }}</p>
                    <p><b>data de lançamento: </b>{{ movie.release_date }}</p>
                    <p><b>visualizações: </b>{{ movie.views }}</p>
                    <p>
                        <b>total arrecadado: </b
                        >{{ formatToCurrency(movie.total) }}
                    </p>
                </div>
            </div>
        </section>

        <section
            class="sm:row-span-3 sm:col-span-4 w-full h-full border-2 bg-gray-100 rounded-xl"
        >
            <div class="p-4">
                <p>Top 3 todos os tempos</p>
                <div
                    v-for="movie of order(movies).slice(0, 3)"
                    :key="movie.id"
                    class="p-3 text-left border rounded-xl m-1 bg-white"
                >
                    <p><b>titulo: </b>{{ movie.title }}</p>
                    <p><b>data de lançamento: </b>{{ movie.release_date }}</p>
                    <p><b>visualizações: </b>{{ movie.views }}</p>
                    <p>
                        <b>total arrecadado: </b
                        >{{ formatToCurrency(movie.total) }}
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>
