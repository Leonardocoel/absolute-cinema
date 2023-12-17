<script setup>
import { router, useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { computed } from "vue";
import FileUpload from "@/Components/FileUpload.vue";

const { movie } = defineProps({
    movie: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    title: movie.title,
    synopsis: movie.synopsis,
    duration_minutes: movie.duration_minutes,
    release_date: movie.release_date_raw,
    genre: movie.genre,
    language: movie.language,
    rating: movie.rating,
    image_url: "/storage/" + movie.image_url,
    availability: movie.availability,
    image: null,
});

const formsIsInvalid = computed(() => {
    const fields = form.data();

    for (const field of Object.values(fields)) {
        if (field === "") return true;
    }

    return false;
});

const submit = () =>
    router.post(`/admin/filmes/${movie.id}`, {
        _method: "put",
        ...form.data(),
    });

const handleDelete = () => router.delete(`/admin/filmes/${movie.id}`);

const previewImage = (file) => URL.createObjectURL(file);

const onFileChange = (e) => {
    const file = e.target.files[0];

    if (file) return (form.image = file);
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
                <div class="md:flex">
                    <div class="mr-4 text-center">
                        <label
                            for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-64s border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100"
                        >
                            <input
                                id="dropzone-file"
                                type="file"
                                @change="onFileChange"
                                class="hidden"
                            />
                            <img
                                :src="
                                    form.image
                                        ? previewImage(form.image)
                                        : form.image_url
                                "
                                class="w-64"
                                alt="Capa do filme"
                            />
                        </label>
                    </div>

                    <div
                        class="grid md:grid-cols-4 md:mt-4 md:gap-x-6 md:mx-2 grow"
                    >
                        <div
                            class="mt-4 sm:col-span-2 sm:mt-0 relative z-0 w-full group"
                        >
                            <input
                                type="text"
                                name="title"
                                id="title"
                                v-model.trim="form.title"
                                class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                            />
                            <label
                                for="title"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Titulo</label
                            >
                        </div>

                        <div class="mt-4 sm:mt-0 relative z-0 w-full group">
                            <input
                                type="date"
                                name="release_date"
                                id="release_date"
                                v-model.trim="form.release_date"
                                class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                            />
                            <label
                                for="release_date"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Data de lançamento</label
                            >
                        </div>

                        <div
                            class="mt-5 md:mt-0 relative z-0 w-full group flex"
                        >
                            <div class="mt-3 sm:mt-0 flex items-center me-4">
                                <input
                                    id="availability_yes"
                                    type="radio"
                                    :value="true"
                                    v-model="form.availability"
                                    name="availability-group"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 cursor-pointer"
                                />
                                <label
                                    for="availability_yes"
                                    class="ms-2 text-sm font-medium text-gray-900 cursor-pointer"
                                    >Sim</label
                                >
                            </div>
                            <div class="mt-3 sm:mt-0 flex items-center me-4">
                                <input
                                    id="availability_no"
                                    type="radio"
                                    :value="false"
                                    v-model="form.availability"
                                    name="availability-group"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 cursor-pointer"
                                />
                                <label
                                    for="availability_no"
                                    class="ms-2 text-sm font-medium text-gray-900 cursor-pointer"
                                    >Não</label
                                >
                            </div>
                            <label
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Disponível para exibição</label
                            >
                        </div>

                        <div class="mt-4 sm:mt-3 relative z-0 w-full group">
                            <input
                                type="number"
                                min="0"
                                name="duration_minutes"
                                id="duration_minutes"
                                v-model.trim="form.duration_minutes"
                                class="block p-2 text-sm w-full text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                            />
                            <label
                                for="duration_minutes"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Duração em minutos</label
                            >
                        </div>

                        <div class="mt-4 sm:mt-3 relative z-0 w-full group">
                            <input
                                type="text"
                                name="genre"
                                id="genre"
                                v-model.trim="form.genre"
                                class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=""
                            />
                            <label
                                for="address"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Gênero</label
                            >
                        </div>

                        <div class="mt-4 sm:mt-3 relative z-0 w-full group">
                            <input
                                type="text"
                                name="language"
                                id="language"
                                v-model.trim="form.language"
                                class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=""
                            />
                            <label
                                for="address"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Linguagem</label
                            >
                        </div>
                        <div class="mt-4 sm:mt-3 relative z-0 w-full group">
                            <input
                                type="number"
                                step="any"
                                min="1"
                                max="5"
                                name="rating"
                                id="rating"
                                v-model.trim="form.rating"
                                class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=""
                            />
                            <label
                                for="address"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Avaliação</label
                            >
                        </div>
                        <div
                            class="mt-8 sm:col-span-4 sm:mt-8 relative z-0 w-full group"
                        >
                            <textarea
                                id="synopsis"
                                name="synopsis"
                                v-model.trim="form.synopsis"
                                rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Escreva sobre o filme..."
                            ></textarea>
                            <label
                                for="synopsis"
                                class="absolute text-md text-gray-500 duration-300 transform -translate-y-7 scale-75 top-1 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                                >Sinopse</label
                            >
                        </div>
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
