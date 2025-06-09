<script setup>
import {ref } from "vue";
let input = ref("");

const prop = defineProps({
    stations: Array
});
</script>

<template>
    <div>
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
            v-for="(station, name) in stations"
            :key="name"
            style="border: 1px solid #ccc; margin-bottom: 2rem; padding: 1rem; border-radius: 8px;"
        >
            <h2>Station: {{ name }}</h2>

            <div style="display: flex; gap: 2rem; overflow-x: auto;">
                <canvas :id="`temp-${name}`" width="400" height="200"></canvas>
                <canvas :id="`hum-${name}`" width="400" height="200"></canvas>
            </div>
<!--deze 2 regels hieronder laten de raw json data van elk grafiek zien als t actief staat-->
            <h3>Raw Data:</h3>
            <pre>{{ station }}</pre>

            <!-- accses somthing specific -->
            <h3> Temperature: </h3>
            <pre>{{ station.map(m => m.temperature) }}</pre>
        </div>
    </div>
</template>


