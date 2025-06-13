<script setup>
// import {ref } from "vue";
// let input = ref("");
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const props = defineProps({
    temperaturesData: Map,
    temperaturesOptions: Map,
    humiditiesData: Map,
    humiditiesOptions: Map,
    stationName: String,
    name: 'BarChart',
    components: { Bar },

});

</script>

<template>
    <Head title="Station: {{ stationName }}" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-font-800"
            >
                Station: {{ stationName }}
            </h2>
        </template>

        <div class="py-4">
            <div
                class="mx-auto max-w-7xl space-y-6 px-2 sm:px-4 lg:px-8"
            >
                <div class="bg-white p-2 sm:p-4 md:p-6 lg:p-8 shadow rounded-lg">
                    <div class="h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px]">
                        <Bar
                            id="temperatures"
                            :options="props.temperaturesOptions"
                            :data="props.temperaturesData"/>
                    </div>
                </div>

                <div class="bg-white p-2 sm:p-4 md:p-6 lg:p-8 shadow rounded-lg">
                    <div class="h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px]">
                        <Bar
                            id="humidity"
                            title="humidity"
                            :options="props.humiditiesOptions"
                            :data="props.humiditiesData"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
