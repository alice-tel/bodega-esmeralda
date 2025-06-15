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
            Station: {{ stationName }}
        </template>

        <div class="py-3">
            <div
                class="space-y-4 px-2 sm:px-2 md:px-2 lg:px-2"
            >
                <div class="bg-white p-2 sm:p-4 md:p-6 lg:p-8 shadow rounded-lg">
                    <h2 class="text-xl sm:text-xl font-semibold mb-4">Temperatures</h2>
                    <div class="h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px]">
                        <Bar
                            id="temperatures"
                            :options="props.temperaturesOptions"
                            :data="props.temperaturesData"/>
                    </div>
                </div>

                <div class="bg-white p-2 sm:p-4 md:p-6 lg:p-8 shadow rounded-lg">
                    <h2 class="text-xl sm:text-xl font-semibold mb-4">Humidity</h2>
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
