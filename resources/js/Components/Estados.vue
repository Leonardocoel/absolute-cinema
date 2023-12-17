<template>
    <div class="grid md:grid-cols-2">
        <div class="relative w-full z-0 group">
            <label
                for="role_id"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top1 -z-10 origin-[0]"
                >Estado</label
            >
            <select
                v-model="estado"
                @input="$emit('inputEstado', $event.target.value)"
            >
                <option value="" disabled selected>Selecione um estado</option>
                <option
                    v-for="estado in estados"
                    :key="estado.value"
                    :value="estado.value"
                >
                    {{ estado.text }}
                </option>
            </select>
        </div>
        <div class="relative mt-7 sm:mt-0 w-full z-0 group">
            <label
                for="cidade"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top1 -z-10 origin-[0]"
                >Cidade</label
            >
            <select
                v-model="cidade"
                id="cidade"
                @input="$emit('inputCidade', $event.target.value)"
            >
                <option v-if="estado.length" value="" disabled selected>
                    Selecione uma cidade
                </option>
                <option v-else value="" disabled selected>...</option>
                <option
                    v-for="(cidade, index) in cidades"
                    :key="index"
                    :value="cidade"
                >
                    {{ cidade }}
                </option>
            </select>
        </div>
    </div>
</template>
<script>
import brasil from "../brasil.json";

export default {
    name: "Estados",
    props: {
        selectedEstado: {
            type: String,
            required: true,
            description: "'Estado' value",
        },
        selectedCidade: {
            type: String,
            required: true,
            description: "'Cidade' value",
        },
        estadoLabel: {
            type: String,
            default: "Estado",
            description: "Label of 'Estado' select",
        },
        cidadeLabel: {
            type: String,
            default: "Cidade",
            description: "Label of 'Cidade' select",
        },
        estadoInputSize: {
            type: String,
            default: "lg-6",
            description: "Column size of 'Estado' select div",
        },
        cidadeInputSize: {
            type: String,
            default: "lg-6",
            description: "Column size of 'Cidade' select div",
        },
        labelClasses: {
            type: String,
            default: "fs-4",
            description: "Label classes",
        },
        selectClasses: {
            type: String,
            default: "form-select-lg",
            description: "Select classes",
        },
    },
    data() {
        return {
            cidade: "",
            estado: "",
            cidades: [],
            brasil,
            estados: [
                { value: "AC", text: "Acre" },
                { value: "AL", text: "Alagoas" },
                { value: "AP", text: "Amapá" },
                { value: "AM", text: "Amazonas" },
                { value: "BA", text: "Bahia" },
                { value: "CE", text: "Ceará" },
                { value: "DF", text: "Distrito Federal" },
                { value: "ES", text: "Espírito Santo" },
                { value: "GO", text: "Goiás" },
                { value: "MA", text: "Maranhão" },
                { value: "MT", text: "Mato Grosso" },
                { value: "MS", text: "Mato Grosso do Sul" },
                { value: "MG", text: "Minas Gerais" },
                { value: "PA", text: "Pará" },
                { value: "PB", text: "Paraíba" },
                { value: "PR", text: "Paraná" },
                { value: "PE", text: "Pernambuco" },
                { value: "PI", text: "Piauí" },
                { value: "RJ", text: "Rio de Janeiro" },
                { value: "RN", text: "Rio Grande do Norte" },
                { value: "RS", text: "Rio Grande do Sul" },
                { value: "RO", text: "Rondônia" },
                { value: "RR", text: "Roraima" },
                { value: "SC", text: "Santa Catarina" },
                { value: "SP", text: "São Paulo" },
                { value: "SE", text: "Sergipe" },
                { value: "TO", text: "Tocantins" },
            ],
        };
    },
    updated: function () {
        this.estado = this.selectedEstado;
        this.cidade = this.selectedCidade;
    },
    watch: {
        selectedEstado: function () {
            this.cidades = this.brasil[this.selectedEstado].cidades;
            if (this.cidade) {
                this.cidade = "";
                // eslint-disable-next-line vue/custom-event-name-casing
                this.$emit("inputCidade", this.cidade);
            }
        },
    },
};
</script>
