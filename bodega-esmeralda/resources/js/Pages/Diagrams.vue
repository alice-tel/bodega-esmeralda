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
<<<<<<< Updated upstream
    <Head title="{{ stationName }}" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                {{ stationName }}
            </h2>
        </template>

        <div class="py-12">
            <div
                class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8"
            >
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <Bar
                        id="temperatures"
                        :options="props.temperaturesOptions"
                        :data="props.temperaturesData"/>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <Bar
                        id="humidity"
                        title="humidity"
                        :options="props.humiditiesOptions"
                        :data="props.humiditiesData"/>
=======
    <Head title="Diagram"/>

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Diagram
            </h2>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1>Station Data</h1>

                <!-- Zoekbalk poging 2 -->
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search station id..."
                    style="margin-bottom: 1rem; padding: 0.5rem; width: 100%; max-width: 400px; border: 1px solid #ccc; border-radius: 4px;"
                />

                <!-- Station blokken om ze te splitten vann elkaar-->
                <div
                    v-for="(entries, name) in filteredStations"
                    :key="name"
                    style="border: 1px solid #ccc; margin-bottom: 2rem; padding: 1rem; border-radius: 8px;"
                >
                    <h2>Station: {{ name }}</h2>

                    <div style="display: flex; gap: 2rem; overflow-x: auto;">
                        <canvas :id="`temp-${name}`" width="400" height="200"></canvas>
                        <canvas :id="`hum-${name}`" width="400" height="200"></canvas>
                    </div>
                    <!--Deze 2 regels hieronder laten de raw json data van elk grafiek zien als t actief staat -->
                    <!-- <h3>Raw Data:</h3> -->
                    <!-- <pre>{{ JSON.stringify(entries, null, 2) }}</pre> -->
>>>>>>> Stashed changes
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
<<<<<<< Updated upstream


</template>

=======
</template>

<script setup>
import { onMounted, ref, computed, nextTick, watch } from 'vue'
import axios from 'axios'
import { Chart, registerables } from 'chart.js'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

>>>>>>> Stashed changes

