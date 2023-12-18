<script setup>
import { router, useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref, computed } from "vue";
import Estados from "@/Components/Estados.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import MultiSelect from "@/Components/MultiSelect.vue";

const { cinema } = defineProps({
    cinema: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: cinema.name,
    cnpj: cinema.cnpj,
    state: cinema.state,
    city: cinema.city,
    address: cinema.address,
    email: cinema.email,
    phone: cinema.phone,
});

const rolesMap = ref({
    cinema_admin: "Administrador Cinema",
    end_user: "Usuário",
});

const formsIsInvalid = computed(() => {
    const { show, ...fields } = form;

    for (const field of Object.values(fields)) {
        if (field === "") return true;
    }

    const regex = /^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/;
    if (!regex.test(form.cnpj))
        return { field: "CNPJ", message: "CNPJ invalido" };

    return false;
});

const submit = () => form.put(`/cinema/perfil`);

const formatCNPJ = () => {
    const CNPJRegex = /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/;
    const layout = "$1.$2.$3/$4-$5";

    let numericCNPJ = form.cnpj.replace(/\D/g, "");

    if (numericCNPJ.length === 14)
        form.cnpj = numericCNPJ.replace(CNPJRegex, layout);
};
</script>

<template>
    <section class="mt-8">
        <form @submit.prevent="submit" class="mx-8">
            <div class="flex justify-between my-4">
                <h3 class="">Perfil</h3>
            </div>
            <div class="p-4 pt-8 border rounded-lg">
                <div class="grid md:grid-cols-2 md:mt-4 md:gap-6 md:mx-2">
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
                            id="CNPJ"
                            name="CNPJ"
                            @input="formatCNPJ()"
                            maxlength="18"
                            minlength="14"
                            v-model.trim="form.cnpj"
                            class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            pattern="(\d{2}\.?\d{3}\.?\d{3}/?\d{4}-?\d{2})"
                            placeholder=" "
                        />
                        <label
                            for="CNPJ"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >CNPJ</label
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
                            type="text"
                            name="phone"
                            id="phone"
                            v-model.trim="form.phone"
                            class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                        />
                        <label
                            for="name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Telefone</label
                        >
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:mt-4 md:gap-6 md:mx-2">
                    <div class="mt-8 sm:mt-4 relative z-0 w-full group">
                        <Estados
                            :selectedEstado="form.state"
                            :selectedCidade="form.city"
                            @inputEstado="form.state = $event"
                            @inputCidade="form.city = $event"
                        />
                    </div>
                    <div class="mt-8 sm:mt-4 relative z-0 w-full group">
                        <input
                            type="text"
                            name="address"
                            id="address"
                            v-model.trim="form.address"
                            class="block p-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                        />
                        <label
                            for="address"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                            >Endereço</label
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
    </section>

    <section>
        <div class="m-8">
            <h3 class="">Associações</h3>
            <div
                v-for="user in cinema.users"
                class="p-4 mb-1 border rounded-lg flex gap-x-6"
            >
                <p>{{ user.user_account.name }}</p>

                <p>{{ rolesMap[user.roles[0].role_name] }}</p>
            </div>
        </div>
    </section>
</template>
